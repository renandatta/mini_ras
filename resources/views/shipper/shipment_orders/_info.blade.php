<x-alert type="error" id="alert_shipment_order" />
<form id="form_shipment_order">
    @csrf
    <x-input type="hidden" name="id" :value="$shipment_order->id ?? ''" />
    <div class="row">
        <div class="col-md-2">
            <x-form-group caption="No.PO">
                <x-input name="no_order" :value="$no_order ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-8">
        </div>
        <div class="col-md-2 text-right">
            <x-form-group caption="Date">
                <x-input name="date" class="datepicker text-right" :value="format_date($shipment_order->date ?? date('d-m-Y'))" />
            </x-form-group>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <x-form-group caption="Customer">
                <x-select name="customer_id" class="select2" :options="$list_customer" :value="$shipment_order->customer_id ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-9">
            <x-form-group caption="Description">
                <x-input name="description" :value="$shipment_order->description ?? ''" />
            </x-form-group>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_shipment_order()">Cancel</button>
    @if(!empty($shipment_order))
        <button class="btn btn-danger float-right" type="button" onclick="delete_shipment_order({{ $shipment_order->id }})">Delete</button>
    @endif
</form>
<hr>
<div id="table_items"></div>

<script>
    $form_shipment_order = $('#form_shipment_order');
    $form_shipment_order.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_shipment_order.get(0));
        $.ajax({
            url: "{{ route('shipper.shipment_orders.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                info_shipment_order(result.id);
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_shipment_order = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('shipper.shipment_orders.delete') }}", {
                    _token, id
                }, () => {
                    init_shipment_order();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_shipment_order', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    @if(!empty($shipment_order))
        search_items = () => {
            $table_items = $('#table_items');
            $.post("{{ route('shipper.shipment_orders.items.search') }}", {
                _token, shipment_order_id : '{{ $shipment_order->id }}'
            }, (result) => {
                $table_items.html(result);
            }).fail((xhr) => {
                $table_items.html(xhr.responseText);
            });
        }
        delete_item = (id) => {
            $.post("{{ route('shipper.shipment_orders.items.delete') }}", {
                _token, id
            }, () => {
                search_items();
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        search_items();
    @endif

    init_form_element();
</script>
