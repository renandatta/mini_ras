@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Delivery Order</h4>
        </div>
        <div class="col-md-6 text-right">
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
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $table_delivery_order = $('#table_delivery_order'),
            $info_delivery_order = $('#info_delivery_order');

        let search_delivery_orders = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('transporter.delivery_orders.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_delivery_order.html(result);
            }).fail((xhr) => {
                $table_delivery_order.html(xhr.responseText);
            });
        }

        let status_delivery_order = (id, status) => {
            $.post("{{ route('transporter.delivery_orders.save') }}", {
                _token, id, status
            }, () => {
                search_delivery_orders(selected_page);
            }).fail((xhr) => {
                $table_delivery_order.html(xhr.responseText);
            });
        }

        let info_delivery_order = (id, mode) => {
            $.post("{{ route('transporter.delivery_orders.info') }}", {
                _token, id, mode
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

        init_form_element();
        init_delivery_order();
    </script>
@endpush
