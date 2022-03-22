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
            <h4 id="page_title">Delivery Order</h4>
        </div>
        <div class="col-md-6 text-right">
            @if(!empty($shipment_order))
                <button class="btn btn-primary" type="button" onclick="info_delivery_order()" id="button_new">Add New</button>
            @endif
        </div>
    </div>
    @if(!empty($shipment_order))
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3"># Purchase Order Information</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-nowrap">
                            <p class="mb-0">
                                <span class="font-weight-light">No.Purchase Order</span><br>
                                <b>{{ $shipment_order->no_order }}</b>
                            </p>
                        </td>
                        <td>
                            <p class="mb-0">
                                <span class="font-weight-light">Customer</span><br>
                                <b>{{ $shipment_order->customer->name }}</b>
                            </p>
                        </td>
                        <td class="text-nowrap">
                            <p class="mb-0">
                                <span class="font-weight-light">Date</span><br>
                                <b>{{ format_date($shipment_order->date) }}</b>
                            </p>
                        </td>
                        <td class="text-nowrap">
                            <p class="mb-0">
                                <span class="font-weight-light">Status</span><br>
                                <b>{{ $shipment_order->status }}</b>
                            </p>
                        </td>
                        <td>
                            <p class="mb-0">
                                <span class="font-weight-light">Description</span><br>
                                <b>{{ $shipment_order->description }}</b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <p class="mb-0">
                                <span><b>Items</b></span><br>
                                @foreach($shipment_order->items as $item)
                                    {{ $item->name . ' (' . $item->qty . ' ' . $item->unit.')' }},
                                @endforeach
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div id="info_delivery_order"></div>
            <form id="search_delivery_order">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <x-input name="no_order" prefix="search_" caption="Search No.DO" />
                    </div>
                    <div class="col-md-3">
                        <x-input name="no_po" prefix="search_" caption="Search No.PO" />
                    </div>
                    <div class="col-md-3">
                        <x-select
                            name="customer_id"
                            class="select2"
                            prefix="search_"
                            :options="$list_customer"
                            caption="All Customer" />
                    </div>
                    <div class="col-md-3">
                        <x-select
                            name="transporter_id"
                            class="select2"
                            prefix="search_"
                            :options="$list_transporter"
                            caption="All Transporter" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <x-input name="date_pickup_start" class="datepicker" prefix="search_" caption="Date Pickup Start" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="date_pickup_end" class="datepicker" prefix="search_" caption="Date Pickup End" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="date_arrive_start" class="datepicker" prefix="search_" caption="Date Arrive Start" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="date_arrive_end" class="datepicker" prefix="search_" caption="Date Arrive End" />
                    </div>
                    <div class="col-md-2">
                        <x-select
                            name="status"
                            class="select2"
                            prefix="search_"
                            :options="$list_status"
                            caption="All Status" />
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <div id="table_delivery_order"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let shipment_order_id = '{{ $shipment_order->id ?? '' }}';
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $page_title = $('#page_title');
        let $info_delivery_order = $('#info_delivery_order'),
            $table_delivery_order = $('#table_delivery_order'),
            $search_delivery_order = $('#search_delivery_order'),
            $button_new = $('#button_new');

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
            $search_delivery_order.hide();
            $table_delivery_order.hide();
            $button_new.hide();
            $page_title.html((id === '' ? 'New' : 'Edit') + ' Delivery Order');
            if (mode !== '') $page_title.html('Mode');
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
            $search_delivery_order.show();
            $table_delivery_order.show();
            $button_new.show();
            $page_title.html('Delivery Order');
        }

        init_form_element();
        init_delivery_order();
    </script>
@endpush

@push('modals')
    <div class="modal fade" id="modal_delivery_order_items" tabindex="-2" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delivery Order Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="data_delivery_order_items"></div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        let $modal_delivery_order_items = $('#modal_delivery_order_items'),
            $data_delivery_order_items = $('#data_delivery_order_items');

        let delivery_order_item = (delivery_order_id) => {
            $.post("{{ route('shipper.delivery_orders.items.search') }}", {
                _token, delivery_order_id
            }, (result) => {
                $data_delivery_order_items.html(result);
                $modal_delivery_order_items.modal('show');
            }).fail((xhr) => {
                $data_delivery_order_items.html(xhr.responseText);
                $modal_delivery_order_items.modal('show');
            });
        }
    </script>
@endpush

@push('modals')
    <div class="modal fade" id="modal_delivery_order_timelines" tabindex="-2" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delivery Order Timelines</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="data_delivery_order_timelines"></div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        let $modal_delivery_order_timelines = $('#modal_delivery_order_timelines'),
            $data_delivery_order_timelines = $('#data_delivery_order_timelines');

        let delivery_order_timeline = (delivery_order_id) => {
            $.post("{{ route('shipper.delivery_orders.timelines.search') }}", {
                _token, delivery_order_id
            }, (result) => {
                $data_delivery_order_timelines.html(result);
                $modal_delivery_order_timelines.modal('show');
            }).fail((xhr) => {
                $data_delivery_order_timelines.html(xhr.responseText);
                $modal_delivery_order_timelines.modal('show');
            });
        }
    </script>
@endpush
