<?php

namespace FleetCart\Http\Controllers;

use FleetCart\Driver;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Mission;
use Modules\Order\Entities\Order;


class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \FleetCart\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \FleetCart\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \FleetCart\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \FleetCart\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }


    public function getUser(Request $request)
    {
        return auth()->user();
    }


    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string',
            'device_token' => 'required|string',
        ]);
        $user = Driver::where('phone', $request->phone)->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            $token = $user->createToken('api-token')->plainTextToken;
            $user->device_token = $request->device_token;
            $user->save();
            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:drivers',
            'phone' => 'required|string|unique:drivers',
            'password' => 'required',
            'device_token' => 'required|string',
        ]);

        $user = Driver::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'] ?? null,
            'password' => \Hash::make($request['password']),
        ]);

        $user->device_token = $request->device_token;
        $user->save();

        // Optionally, you can generate a token for the newly registered user
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function setDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);
        $user = auth()->user();
        $user->device_token = $request->device_token;
        $user->save();

        return response()->json(['user' => $user], 200);
    }

    public function getMissions(Request $request)
    {
        $user = auth()->user();
        $missions = $user->missions()->orderBy('id', 'desc')->paginate(30);

        return response()->json([
            'success' => true,
            'data' => $missions,
        ]);
    }

    public function acceptMission(Request $request)
    {
        $validated = $request->validate([
            'mission_id' => 'required|exists:missions,id',
        ]);

        $mission = Mission::findOrFail($validated['mission_id']);

        // Check if the authenticated driver is assigned to this mission
        if ($mission->driver_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized - This mission is not assigned to you.'], 403);
        }

        // Verify the mission's status is 'pending' before allowing acceptance
        if ($mission->status !== 'pending') {
            return response()->json(['message' => 'This mission cannot be accepted. It is either already accepted or completed.'], 422);
        }

        // Update the mission's status to 'accepted'
        $mission->status = 'accepted';
        $mission->save();

        return response()->json(['message' => 'Mission accepted successfully']);
    }


    public function changeOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Check if the order has a mission and a driver assigned
        if (!$order->mission || !$order->mission->driver_id) {
            return response()->json(['message' => 'This order has no mission or driver assigned.'], 403);
        }

        // Ensure the driver making the request is the driver assigned to the order's mission
        $driverId = auth('driver')->id(); // Assuming driver authentication
        if ($order->mission->driver_id != $driverId) {
            return response()->json(['message' => 'Unauthorized - This order is not assigned to you.'], 403);
        }

        $newStatus = $request->input('status');
        $currentStatus = $order->status;

        // Define valid status transitions
        $statusTransitions = [
            'pending' => ['accepted'],
            'accepted' => ['charged'],
            'charged' => ['on_road'],
            'on_road' => ['discharged'],
            'discharged' => ['finished'],
        ];

        // Check if the new status is a valid transition from the current status
        if (!isset($statusTransitions[$currentStatus]) || !in_array($newStatus, $statusTransitions[$currentStatus])) {
            return response()->json(['message' => 'Invalid status transition.'], 422);
        }

        // Update the order's status
        $order->status = $newStatus;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully.']);
    }








}
