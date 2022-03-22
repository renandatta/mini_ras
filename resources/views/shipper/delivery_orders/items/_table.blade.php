<h5 class="mb-3"><small>No.Delivery Order</small><br>{{ $delivery_order->no_order }}</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th width="10%" class="text-right">Qty</th>
            <th width="15%">Unit</th>
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
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
