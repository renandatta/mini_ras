<x-alert type="error" id="alert_delivery_order" />
<form id="form_delivery_order">
    @csrf
    <x-input type="hidden" name="shipment_order_id" :value="$shipment_order->id ?? ''" />
    <x-input type="hidden" name="id" :value="$delivery_order->id ?? ''" />

    <div class="row">
        <div class="col-md-3">
            <x-form-group caption="No.DO *">
                <x-input name="no_order" :value="$no_order ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-3 ml-auto text-right">
            <x-form-group caption="Date DO *">
                <x-input name="date" class="datepicker text-right" :value="format_date($delivery_order->date ?? date('d-m-Y'))" />
            </x-form-group>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <x-form-group caption="Transporter *">
                @php($status = $delivery_order->status ?? 'Waiting Confirmation')
                @if($status == 'Waiting Confirmation' || $status == 'Rejected')
                    <x-select name="transporter_id" class="select2" :options="$list_transporter" :value="$shipment_order->transporter_id ?? ''" />
                @else
                    <x-input name="transporter" :value="$delivery_order->transporter->name" readonly />
                @endif
            </x-form-group>
        </div>
        <div class="col-md-2">
            <x-form-group caption="Pickup Date">
                <x-input name="pickup_date" class="datepicker" :value="format_date($delivery_order->location->pickup_date ?? date('d-m-Y'))" />
            </x-form-group>
        </div>
        <div class="col-md-2">
            <x-form-group caption="Pickup Time">
                <x-input name="pickup_time" class="timepicker" :value="$delivery_order->location->pickup_time ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-5">
            <x-form-group caption="Note to Transporter">
                <x-input name="description" :value="$delivery_order->description ?? ''" />
            </x-form-group>
        </div>
    </div>
    <h5 class="mb-2 mt-3"># Items</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Item Name</th>
            <th width="15%" class="text-right">Qty</th>
            <th width="15%">Unit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td class="vertical-middle p-0">
                    <x-input name="name[]" class="border-0 bg-white" :value="$item->name" readonly />
                </td>
                <td class="vertical-middle p-0">
                    <x-input name="qty[]" class="border-0 text-right autonumeric font-weight-bold" :value="$item->qty" />
                </td>
                <td class="vertical-middle p-0">
                    <x-input name="unit[]" class="border-0 bg-white" :value="$item->unit" readonly />
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h5 class="mb-2 mt-3"># Locations</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Origin *</th>
            <th>Destination *</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="vertical-middle p-0">
                <x-select
                    name="pickup_location_id[]"
                    class="select2"
                    caption="Empty"
                    caption="Select Origin"
                    :options="$locations"
                    :value="$delivery_order->location->pickup_location_id ?? ''"
                />
                <x-input name="pickup_detail[]" class="border-0" caption="Detail" :value="$delivery_order->location->pickup_detail ?? ''" />
            </td>
            <td class="vertical-middle p-0">
                <x-select
                    name="deliver_location_id[]"
                    class="select2"
                    caption="Select Destination"
                    :options="$locations"
                    :value="$delivery_order->location->deliver_location_id ?? ''"
                />
                <x-input name="deliver_detail[]" class="border-0" caption="Detail" :value="$delivery_order->location->deliver_detail ?? ''" />
            </td>
        </tr>
        </tbody>
    </table>
    <br><br>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_delivery_order()">Cancel</button>
    @if(!empty($delivery_order))
        <button class="btn btn-danger float-right" type="button" onclick="delete_delivery_order({{ $delivery_order->id }})">Delete</button>
    @endif
</form>

<script>
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
            success: function() {
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
