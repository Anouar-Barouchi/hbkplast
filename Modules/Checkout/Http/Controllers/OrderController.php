<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\Validator;
use Modules\Payment\Facades\Gateway;
use Modules\Product\Entities\Product;
use stdClass;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('checkout::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('checkout::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isActivated()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorizes'
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'customer_email'    => ['required', 'email'],
            'customer_phone'    => ['required', 'string'],
            'first_name'        => ['required', 'string'],
            'last_name'         => ['required', 'string'],
            'data'              => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = json_decode($request->data, 1);
        if (empty($data)) {
            return response()->json(['errors' => 'Invalid Products']);
        }
        $prs  = array_keys($data);
        if (Product::whereIn('id', $prs)->count() < count($data)) {
            return response()->json(['errors' => 'Invalid Products']);
        }
        $subTotal = $total = 0;
        try {
            DB::beginTransaction();
            $order = Order::create([
                'customer_id' => null,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_first_name' => $request->first_name,
                'customer_last_name' => $request->last_name,
                'billing_first_name' => $request->first_name,
                'billing_last_name' => $request->last_name,
                'billing_address_1' => $user->state->name . ', ' . $user->city->name,
                'billing_address_2' => null,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => '',
                'shipping_zip' => '',
                'billing_country' => 'DZ',
                'discount' => 0,
                'shipping_first_name' => $request->first_name,
                'shipping_last_name' => $request->last_name,
                'shipping_address_1' => $user->state->name . ', ' . $user->city->name,
                'shipping_address_2' => null,
                'shipping_city' => $user->city->name,
                'shipping_state' => $user->state->name,
                'shipping_country' => 'DZ',
                'sub_total' => $subTotal,
                'shipping_method' => 'local_pickup',
                'shipping_cost' => $request->shipping_cost ?? 0,
                'total' => $total,
                'payment_method' => 'check_payment',
                'currency' => 'DZD',
                'currency_rate' => 1,
                'locale' => 'ar',
                'status' => Order::PENDING_PAYMENT,
                'note' => $request->order_note ?? '',
            ]);
            foreach ($data as $key => $value) {
                $product = Product::findOrFail($key);
                $cartItem = new stdClass;
                $cartItem->qty = $value;
                $cartItem->product_id = $product->id;
                $cartItem->price = $product->selling_price->amount();
                $order->storeProductsApi($cartItem);
                $product->decrement('qty', $value);
                $subTotal += ($cartItem->price * $value);
                
            }
    
            $order->sub_total = $subTotal;
            $order->total     = $subTotal;
            $order->save();
    
            $gateway = Gateway::get('check_payment');
            $gateway->purchase($order, $request);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg'    => 'Order Created',
                'data'   => $order->load('products'),
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG')) {
                DB::rollBack();
                return $th;
            }
            return response()->json([
                'status' => false,
                'msg'    => 'Something Wrong!'
            ]);
        }
    }



    public function storeCustomer(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user->isActivated()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorizes'
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'address'           => ['required', 'string'],
            'city'              => ['required', 'string'],
            'state'             => ['required', 'string'],
            'data'              => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = json_decode($request->data, 1);
        if (empty($data)) {
            return response()->json(['errors' => 'Invalid Products']);
        }
        $prs  = array_keys($data);
        if (Product::whereIn('id', $prs)->count() < count($data)) {
            return response()->json(['errors' => 'Invalid Products']);
        }
        $subTotal = $total = 0;
        try {
            DB::beginTransaction();
            $order = Order::create([
                'customer_id' => $user->id,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'customer_first_name' => $user->first_name,
                'customer_last_name' => $user->last_name,
                'billing_first_name' => $user->first_name,
                'billing_last_name' => $user->last_name,
                'billing_address_1' => $user->state->name . ', ' . $user->city->name,
                'billing_address_2' => null,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => '',
                'shipping_zip' => '',
                'billing_country' => 'DZ',
                'discount' => 0,
                'shipping_first_name' => $user->first_name,
                'shipping_last_name' => $user->last_name,
                'shipping_address_1' => $request->address,
                'shipping_address_2' => null,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_country' => 'DZ',
                'sub_total' => $subTotal,
                'shipping_method' => 'local_pickup',
                'shipping_cost' => $request->shipping_cost ?? 0,
                'total' => $total,
                'payment_method' => 'check_payment',
                'currency' => 'DZD',
                'currency_rate' => 1,
                'locale' => 'ar',
                'status' => Order::PENDING,
                'note' => $request->order_note ?? '',
            ]);
            foreach ($data as $key => $value) {
                $product = Product::findOrfail($key);
                if (($value % (int)$product->unit) != 0) {
                    throw new \Exception("Quantity Missmatch", 1);
                }
                $cartItem = new stdClass;
                $cartItem->qty = $value;
                $cartItem->product_id = $product->id;
                $cartItem->price = $product->selling_price->amount();
                $order->storeProductsApi($cartItem);
                $product->decrement('qty', $value);
                $subTotal += ($cartItem->price * $value);
                
            }
    
            $order->sub_total = $subTotal;
            $order->total     = $subTotal;
            $order->save();
    
            $gateway = Gateway::get('check_payment');
            $gateway->purchase($order, $request);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg'    => 'Order Created',
                'data'   => $order->load('products'),
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG')) {
                DB::rollBack();
                return $th;
            }
            return response()->json([
                'status' => false,
                'msg'    => 'Something Wrong!'
            ]);
        }
    }

    public function getOrders(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orders = Order::with('products')->where('customer_id', $user->id)->orderByDesc('id')->paginate($request->per_page ?? 20);
        return response()->json([
            'status' => true,
            'data'   => $orders,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('checkout::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('checkout::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
