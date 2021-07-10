@extends('layouts.admin')

@push('styles')
    <style>
        td .select2-container--default .select2-selection--single, .select2-container--default .select2-dropdown, .select2-container--default .select2-selection--multiple {
            border-color: #fff;
        }
        td .select2-container {
            width: 100%!important;
        }
        .select2-results {
            border: 1px solid #e9ecef!important;
        }
    </style>
@endpush

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Delivery Order</h4>
        </div>
        <div class="col-md-6 text-right">
            @if(!empty($shipment_order))
                <button class="btn btn-primary" type="button" onclick="info_delivery_order()">Add New</button>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_delivery_order"></div>
            <div id="table_delivery_order"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let shipment_order_id = '{{ $shipment_order->id ?? '' }}';
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_delivery_order = $('#info_delivery_order'),
            $table_delivery_order = $('#table_delivery_order');

        let search_delivery_orders = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('shipper.delivery_orders.search') }}?page=" + selected_page, {
                _token, paginate, shipment_order_id
            }, (result) => {
                $table_delivery_order.html(result);
            }).fail((xhr) => {
                $table_delivery_order.html(xhr.responseText);
            });
        }

        let info_delivery_order = (id = '', mode = '') => {
            $.post("{{ route('shipper.delivery_orders.info') }}", {
                _token, id, shipment_order_id, mode
            }, (result) => {
                $info_delivery_order.html(result);
            }).fail((xhr) => {
                $info_delivery_order.html(xhr.responseText);
            });
        }

        let init_delivery_order = () => {
            search_delivery_orders(selected_page);
            $info_delivery_order.html('');
        }

        let toggle_items = (no_order) => {
            $('.items-' + no_order).toggle();
        }

        init_form_element();
        init_delivery_order();
    </script>
@endpush
