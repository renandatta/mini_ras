<div class="row">
    <div class="col-md-4">
        <h4 class="mb-3"># Delivery Order Information</h4>
        <h5 class="mb-1"><small>No.Delivery Order</small><br>{{ $delivery_order->no_order }}</h5>
        <h5 class="mb-1"><small>Item</small><br>{{ $delivery_order->name }}</h5>
        <h5 class="mb-1"><small>Qty</small><br>{{ $delivery_order->qty . ' ' . $delivery_order->unit }}</h5>
        <h5 class="mb-1"><small>Description</small><br>{{ $delivery_order->description }}</h5>
        <h5 class="mb-1"><small>Pickup</small><br>{{ format_date($delivery_order->date_pickup) . ', ' . $delivery_order->time_pickup }}</h5>
    </div>
    <div class="col-md-8">
        <form id="form_delivery_order">
            @csrf
            <x-input type="hidden" name="id" :value="$delivery_order->id ?? ''" />

            @include('shipper.delivery_orders._date_note')

            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-light ml-2" type="button" onclick="init_delivery_order()">Cancel</button>
        </form>
    </div>
</div>
<hr>
<script>
    $form_delivery_order = $('#form_delivery_order');
    $form_delivery_order.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_delivery_order.get(0));
        $.ajax({
            url: "{{ route('transporter.delivery_orders.save') }}",
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
