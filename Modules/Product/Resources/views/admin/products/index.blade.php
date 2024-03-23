@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('product::products.products'))

    <li class="active">{{ trans('product::products.products') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'products')
    @slot('name', trans('product::products.product'))

    @slot('thead')
        @include('product::admin.products.partials.thead', ['name' => 'products-index'])
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#products-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'id', width: '5%' },
                { data: 'thumbnail', orderable: false, searchable: false, width: '10%' },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'price', searchable: false },
                { data: 'status', name: 'is_active', searchable: false },
                { data: 'created', name: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    defaultContent: '',
                    render: function (data, type, row) {
                        const rowDataJsonString = JSON.stringify(row).replace(/'/g, "&#39;");
                        return `<button onclick="printRowData('${rowDataJsonString}')">Print Row Data</button>`;
                    },
                },
            ],
        });

        function printBarcode(barcode) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`<html><head><title>Print Barcode</title></head><body><p>${barcode}</p></body></html>`);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
@endpush
