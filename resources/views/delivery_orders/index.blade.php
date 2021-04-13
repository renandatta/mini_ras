@extends('layouts.admin')

@section('title')
    Delivery Order -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Delivery Order</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="delivery_order_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="delivery_order_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="delivery_order_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $delivery_order_info = $('#delivery_order_info'),
            $delivery_order_table = $('#delivery_order_table');

        search_delivery_order = () => {
            $.post("{{ route('delivery_orders.search') }}", {_token, paginate}, (result) => {
                $delivery_order_table.html(result);
            }).fail((xhr) => {
                $delivery_order_table.html(xhr.responseText);
            });
        }

        init_delivery_order = () => {
            $delivery_order_info.html('');
            search_delivery_order();
        }

        delivery_order_info = (id = '') => {
            $.post("{{ route('delivery_orders.info') }}", {_token, id}, (result) => {
                $delivery_order_info.html(result);
            }).fail((xhr) => {
                $delivery_order_info.html(xhr.responseText);
            });
        }

        init_delivery_order();
    </script>
@endpush
