@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 id="page_title">Purchase Order</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_shipment_order()" id="button_new">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_shipment_order"></div>
            <form id="search_shipment_order" class="mb-2">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <x-input name="no_order" prefix="search_" caption="Search No.PO" />
                    </div>
                    <div class="col-md-3">
                        <x-input name="item_name" prefix="search_" caption="Item Name" />
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
                            name="status"
                            class="select2"
                            prefix="search_"
                            :options="$list_status"
                            caption="All Status" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <x-input name="qty_start" prefix="search_" caption="Qty Start" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="qty_end" prefix="search_" caption="Qty End" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="date_start" class="datepicker" prefix="search_" caption="Date Start" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="date_end" class="datepicker" prefix="search_" caption="Date End" />
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <div id="table_shipment_order"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $page_title = $('#page_title');
        let $info_shipment_order = $('#info_shipment_order'),
            $table_shipment_order = $('#table_shipment_order'),
            $search_shipment_order = $('#search_shipment_order'),
            $button_new = $('#button_new');

        let search_shipment_orders = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($search_shipment_order);
            data.paginate = paginate;
            $.post("{{ route('shipper.shipment_orders.search') }}?page=" + selected_page, data, (result) => {
                $table_shipment_order.html(result);
            }).fail((xhr) => {
                $table_shipment_order.html(xhr.responseText);
            });
        }

        let info_shipment_order = (id = '') => {
            $table_shipment_order.hide();
            $search_shipment_order.hide();
            $page_title.html((id === '' ? 'New' : 'Edit') + ' Purchase Order');
            $button_new.hide();
            $.post("{{ route('shipper.shipment_orders.info') }}", {
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
            $table_shipment_order.show();
            $search_shipment_order.show();
            $page_title.html('Purchase Order');
            $button_new.show();
        }

        $search_shipment_order.submit((e) => {
            e.preventDefault();
            search_shipment_orders();
        });

        init_form_element();
        init_shipment_order();
    </script>
@endpush
