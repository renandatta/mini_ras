<h5 class="mb-3"><small>No.Delivery Order</small><br>{{ $delivery_order->no_order }}</h5>

@foreach($locations as $location)
    <h5 class="mb-2">Origin : <span class="font-weight-light">{{ $location->pickup_location->name }} ({{ $location->pickup_detail }})</span></h5>
    <ul class="timeline">
        <li class="event {{ $location->status_caption == 'Waiting for Pickup' ? 'active' : '' }}">
            <h5 class="mb-0">Waiting for Pickup</h5>
            @if($location->pickup_date != '')
                <p>{{ format_date($location->pickup_date) }}, {{ $location->pickup_time }}</p>
            @endif
        </li>
        <li class="event {{ $location->status_caption == 'In Transit' ? 'active' : '' }}">
            <h5 class="mb-0">Loading Items Completed</h5>
            @if($location->loading_date != '')
                <p>{{ format_date($location->loading_date) }}, {{ $location->loading_time }}</p>
            @endif
        </li>
        <li class="event {{ $location->status_caption == 'Arrive at Destination' ? 'active' : '' }}">
            <h5 class="mb-0">Arrive at Destination</h5>
            @if($location->arrive_date != '')
                <p>{{ format_date($location->arrive_date) }}, {{ $location->arrive_time }}</p>
            @endif
        </li>
        <li class="event {{ $location->status_caption == 'Unloading Completed' ? 'active' : '' }}">
            <h5 class="mb-0">Unloading Items</h5>
            @if($location->unloading_date != '')
                <p>{{ format_date($location->unloading_date) }}, {{ $location->unloading_time }}</p>
            @endif
        </li>
        <li class="event {{ $location->status_caption == 'Closed' ? 'active' : '' }}">
            <h5 class="mb-0">Closed</h5>
            @if($location->file != '')
                <a href="{{ route('assets/' . $location->file) }}" class="btn btn-sm">Preview File</a>
            @endif
        </li>
    </ul>
    <h5 class="mt-2">Destination : <span class="font-weight-light">{{ $location->deliver_location->name }} ({{ $location->deliver_detail }})</span></h5>
    <hr>
@endforeach
