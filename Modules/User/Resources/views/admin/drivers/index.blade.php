@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::users.users'))

    <li class="active">{{ trans('user::users.drivers') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    {{-- @slot('buttons', ['create']) --}}
    @slot('resource', 'drivers')
    @slot('name', trans('user::users.driver'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all')

            <th>{{ trans('admin::admin.table.id') }}</th>
            <th>{{ trans('user::users.table.name') }}</th>
            <th>{{ trans('user::users.table.phone') }}</th>
            <th>{{ trans('user::users.table.email') }}</th>
            <th data-sort>{{ trans('admin::admin.table.created') }}</th>
        </tr>
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#drivers-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'id', width: '5%' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'created', name: 'created_at' },
            ]
        });
    </script>
@endpush
