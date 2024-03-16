<div style="margin-top: 4em">
    <h3>{{ trans('order::orders.assign_driver') }}</h3>
    <form action="{{ route('admin.orders.assign_driver', $order) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="driver">{{ trans('order::orders.select_driver') }}</label>
            <select name="driver_id" id="driver" class="form-control">
                @foreach ($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ trans('order::orders.assign') }}</button>
    </form>
</div>
