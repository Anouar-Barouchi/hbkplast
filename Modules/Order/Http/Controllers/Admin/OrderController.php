<?php

namespace Modules\Order\Http\Controllers\Admin;

use FleetCart\Driver;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Mission;
use Modules\Order\Entities\Order;
use Modules\Admin\Traits\HasCrudActions;
use Illuminate\Http\Request;


class OrderController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['products', 'coupon', 'taxes'];

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'order::orders.order';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'order::admin.orders';

    public function show($id)
    {
        $order = Order::findOrFail($id); // Use the existing query method to include with relations
        $drivers = Driver::all(); // Retrieve all drivers

        return view("{$this->viewPath}.show", compact('order', 'drivers'));
    }

    public function assignDriver(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($order->mission) {
            return redirect()->route('admin.orders.show', $order)->withErrors(['error' => trans('order::messages.driver_already_assigned')]);
        }

        DB::transaction(function () use ($order, $validated) {
            $mission = new Mission([
                'order_id' => $order->id,
                'driver_id' => $validated['driver_id'],
            ]);
            $mission->save();

            // Update the order's driver_id if necessary
            $order->driver_id = $validated['driver_id'];
            $order->save();
        });

        return redirect()->route('admin.orders.show', $order)->withSuccess(trans('order::messages.driver_assigned'));
    }
}
