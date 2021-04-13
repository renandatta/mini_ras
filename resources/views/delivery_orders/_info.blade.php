<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_delivery_order" />
        <form id="delivery_order_form">
            @csrf
            @if(!empty($delivery_order))
                <x-input type="hidden" name="id" :value="$delivery_order->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="vehicle_id" caption="Vehicle">
                        <x-select
                            name="vehicle_id"
                            class="select2"
                            :options="$vehicles"
                            :value="$delivery_order->vehicle_id ?? ''"
                        />
                    </x-form-group>
                    <x-form-group id="no_order" caption="No.Order">
                        <x-input name="no_order" :value="$delivery_order->no_order ?? ''" />
                    </x-form-group>
                    <x-form-group id="date" caption="Date">
                        <x-input name="date" class="datepicker" :value="$delivery_order->date ?? date('d-m-Y')" />
                    </x-form-group>
                    <x-form-group id="arrived_date" caption="Arrived Date">
                        <x-input name="arrived_date" class="arrived_datepicker" :value="$delivery_order->arrived_date ?? ''" />
                    </x-form-group>
                    <x-form-group id="description" caption="Description">
                        <x-textarea name="description" :value="$delivery_order->description ?? ''" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_delivery_order()">Cancelp</button>
                    @if(!empty($delivery_order))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_delivery_order({{ $delivery_order->id }})">Hapus</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $delivery_order_form = $('#delivery_order_form');
    $delivery_order_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($delivery_order_form.get(0));
        $.ajax({
            url: "{{ route('delivery_orders.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_delivery_order();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_delivery_order', error.errors);
            } else {
                console.log(xhr.responseText);
            }
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
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('delivery_orders.delete') }}", data, () => {
                    init_delivery_order();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_delivery_order', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
