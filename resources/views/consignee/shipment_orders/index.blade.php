@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Shipment Order</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_shipment_order()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_shipment_order"></div>
            <div id="table_shipment_order"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_shipment_order = $('#info_shipment_order'),
            $table_shipment_order = $('#table_shipment_order');

        let search_shipment_orders = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('consignee.shipment_orders.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_shipment_order.html(result);
            }).fail((xhr) => {
                $table_shipment_order.html(xhr.responseText);
            });
        }

        let info_shipment_order = (id = '') => {
            $.post("{{ route('consignee.shipment_orders.info') }}", {
                _token, id
            }, (result) => {
                $info_shipment_order.html(result);
            }).fail((xhr) => {
                $info_shipment_order.html(xhr.responseText);
            });
        }

        let init_shipment_order = () => {
            search_shipment_orders(selected_page);
            $info_shipment_order.html('');
        }

        init_form_element();
        init_shipment_order();
    </script>
@endpush
