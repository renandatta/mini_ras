<x-alert type="error" id="alert_item" />
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th width="10%">Qty</th>
            <th width="15%">Unit</th>
            <th width="5%"></th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @foreach($items as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $item->name }}</td>
                <td class="text-nowrap text-right">{{ format_number($item->qty) }}</td>
                <td class="text-nowrap">{{ $item->unit }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        type="button"
                        class="btn btn-xs btn-icon-append btn-danger"
                        onclick="delete_item({{ $item->id }})"
                    >Delete</button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td>#</td>
            <td class="p-0 vertical-middle">
                <x-input name="name" caption="Name" class="border-0" />
            </td>
            <td class="p-0 vertical-middle">
                <x-input name="qty" caption="Qty" class="border-0 autonumeric text-right" />
            </td>
            <td class="p-0 vertical-middle">
                <x-input name="unit" caption="Unit" class="border-0" />
            </td>
            <td class="p-0 vertical-middle text-center">
                <button type="button" class="btn btn-success btn-xs" onclick="save_items()">Save</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    save_items = () => {
        $.post("{{ route('shipper.shipment_orders.items.save') }}", {
            _token,
            shipment_order_id: '{{ $shipment_order_id }}',
            name: $('#name').val(),
            qty: $('#qty').val(),
            unit: $('#unit').val(),
        }, (result) => {
            search_items();
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_item', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    }
</script>
