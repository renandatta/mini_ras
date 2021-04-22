@extends('layouts.admin')

@section('title')
    Vehicle -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Vehicle</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="vehicle_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="vehicle_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="vehicle_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $vehicle_info = $('#vehicle_info'),
            $vehicle_table = $('#vehicle_table');

        let selected_page = 1;
        search_vehicle = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if(page.toString() === '-1') selected_page--;
            else selected_page = page

            $.post("{{ route('vehicles.search') }}?page=" + selected_page , {_token, paginate}, (result) => {
                $vehicle_table.html(result);
            }).fail((xhr) => {
                $vehicle_table.html(xhr.responseText);
            });
        }

        init_vehicle = () => {
            $vehicle_info.html('');
            search_vehicle();
        }

        vehicle_info = (id = '') => {
            $.post("{{ route('vehicles.info') }}", {_token, id}, (result) => {
                $vehicle_info.html(result);
            }).fail((xhr) => {
                $vehicle_info.html(xhr.responseText);
            });
        }

        init_vehicle();
    </script>
@endpush
