<div style="margin-top: 4em">
    <h3>{{ trans('order::orders.assign_driver') }}</h3>
    @if ($order->driver && $order->mission)
        <!-- Display the assigned driver and mission code -->
        <div class="assigned-info">
            <p>{{ trans('order::orders.assigned_driver') }}: {{ $order->driver->name }}</p>
            <p>{{ trans('order::orders.mission_code') }}: {{ $order->mission->code }}</p>
            {{-- <form action="{{ route('admin.orders.unassign_driver', $order) }}" method="POST">
                @csrf
                @method('DELETE') <!-- Assuming you're using a DELETE request for unassignment -->
                <button type="submit" class="btn btn-warning">{{ trans('order::orders.unassign') }}</button>
            </form> --}}
        </div>
    @else
        <!-- If the order is not assigned, show the form to assign a driver -->
        <form action="{{ route('admin.orders.assign_driver', $order) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="driver">{{ trans('order::orders.select_driver') }}</label>
                <select name="driver_id" id="driver" class="form-control">
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ trans('order::orders.assign') }}</button>
        </form>
    @endif
</div>
