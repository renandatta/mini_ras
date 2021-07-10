<div class="row">
    <div class="col-md-3">
        <h5 class="mb-3"># Shipment Order</h5>
        <h5 class="mb-1"><small>No.Shipment Order</small><br>{{ $shipment_order->no_order }}</h5>
        <h5 class="mb-1"><small>Customer</small><br>{{ $shipment_order->customer->name }}</h5>
        <h5 class="mb-1"><small>Date</small><br>{{ format_date($shipment_order->date) }}</h5>
        <h5 class="mb-1"><small>Description</small><br>{{ $shipment_order->description }}</h5>
    </div>
    <div class="col-md-9">
        <form id="form_delivery_order">
            @csrf
            <x-input type="hidden" name="shipment_order_id" :value="$shipment_order->id ?? ''" />
            <x-input type="hidden" name="id" :value="$delivery_order->id ?? ''" />
            @if($mode == '')
                <div class="row">
                    <div class="col-md-5">
                        <h5 class="mb-2"># {{ !empty($delivery_order) ? 'Edit' : 'Add New' }} Delivery Order</h5>
                        <x-form-group caption="No.DO *">
                            <x-input name="no_order" :value="$no_order ?? ''" />
                        </x-form-group>
                        <x-form-group caption="Date DO *">
                            <x-input name="date" class="datepicker" :value="format_date($delivery_order->date ?? date('d-m-Y'))" />
                        </x-form-group>
                        <x-form-group caption="Transporter *">
                            @php($status = $delivery_order->status ?? 'Waiting Confirmation')
                            @if($status == 'Waiting Confirmation' || $status == 'Rejected')
                                <x-select name="transporter_id" class="select2" :options="$list_transporter" :value="$shipment_order->transporter_id ?? ''" />
                            @else
                                <x-input name="transporter" :value="$delivery_order->transporter->name" readonly />
                            @endif
                        </x-form-group>
                        <div class="row">
                            <div class="col-md-6">
                                <x-form-group caption="Pickup Date">
                                    <x-input name="date_pickup" class="datepicker" :value="format_date($delivery_order->date_pickup ?? date('d-m-Y'))" />
                                </x-form-group>
                            </div>
                            <div class="col-md-6">
                                <x-form-group caption="Pickup Time">
                                    <x-input name="time_pickup" class="timepicker" :value="$delivery_order->time_pickup ?? ''" />
                                </x-form-group>
                            </div>
                        </div>
                        <x-form-group caption="Note to Transporter">
                            <x-input name="description" :value="$delivery_order->description ?? ''" />
                        </x-form-group>
                    </div>
                    <div class="col-md-7">
                        <h5 class="mb-2"># Delivery Order Items</h5>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Item Name</th>
                                <th class="text-right">Qty</th>
                                <th>Unit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="vertical-middle p-0">
                                        <x-input name="name[]" class="border-0" :value="$item->name" readonly />
                                    </td>
                                    <td class="vertical-middle p-0">
                                        <x-input name="qty[]" class="border-0 text-right autonumeric" :value="$item->qty" />
                                    </td>
                                    <td class="vertical-middle p-0">
                                        <x-input name="unit[]" class="border-0" :value="$item->unit" readonly />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h5 class="my-2"># Delivery Order Locations</h5>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Origin</th>
                                <th>Destination</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="vertical-middle p-0">
                                    <x-select
                                        name="pickup_location_id"
                                        class="select2"
                                        :options="$locations"
                                        :value="$delivery_order->pickup_location_id ?? ''"
                                    />
                                </td>
                                <td class="vertical-middle p-0">
                                    <x-select
                                        name="deliver_location_id"
                                        class="select2"
                                        :options="$customer_locations"
                                        :value="$delivery_order->deliver_location_id ?? ''"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-0">
                                    <button class="btn btn-primary btn-xs btn-block">Add New Destination</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @include('shipper.delivery_orders._date_note')

            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-light ml-2" type="button" onclick="init_delivery_order()">Cancel</button>
            @if(!empty($delivery_order))
                <button class="btn btn-danger float-right" type="button" onclick="delete_delivery_order({{ $delivery_order->id }})">Delete</button>
            @endif
        </form>
    </div>
</div>
<hr>
<script>
    select_item = (id) => {
        $.post("{{ route('shipper.shipment_orders.items.info') }}", {
            _token, id
        }, (result) => {
            $('#name').val(result.name);
            $('#qty').val(result.qty);
            $('#unit').val(result.unit);
        });
    }

    $form_delivery_order = $('#form_delivery_order');
    $form_delivery_order.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_delivery_order.get(0));
        $.ajax({
            url: "{{ route('shipper.delivery_orders.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_delivery_order();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_delivery_order = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('shipper.delivery_orders.delete') }}", {
                    _token, id
                }, () => {
                    init_delivery_order();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_delivery_order', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
