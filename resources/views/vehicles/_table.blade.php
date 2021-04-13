<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Profile</th>
        <th>Code</th>
        <th>Name</th>
        <th>Tracking Url</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($vehicles->currentPage()-1) * $vehicles->perPage()) + 1)
        @foreach($vehicles as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->profile->name ?? '' }}</td>
                <td class="text-nowrap">{{ $value->code }}</td>
                <td class="text-nowrap">{{ $value->name }}</td>
                <td class="text-nowrap">{{ $value->tracking_url }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="vehicle_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $vehicles->links('vendor.pagination.custom', ['function' => 'search_vehicle']) }}
