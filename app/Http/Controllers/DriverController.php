<?php

namespace FleetCart\Http\Controllers;

use FleetCart\Driver;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


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
        ]);
        $user = Driver::where('phone', $request->phone)->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            $token = $user->createToken('api-token')->plainTextToken;
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
        ]);

        $user = Driver::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'] ?? null,
            'password' => \Hash::make($request['password']),
        ]);

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
}