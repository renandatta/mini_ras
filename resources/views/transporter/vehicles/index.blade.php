@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Vehicle</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_vehicle()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_vehicle"></div>
            <div id="table_vehicle"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_vehicle = $('#info_vehicle'),
            $table_vehicle = $('#table_vehicle');

        let search_vehicles = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('transporter.vehicles.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_vehicle.html(result);
            }).fail((xhr) => {
                $table_vehicle.html(xhr.responseText);
            });
        }

        let info_vehicle = (id = '') => {
            $.post("{{ route('transporter.vehicles.info') }}", {
                _token, id
            }, (result) => {
                $info_vehicle.html(result);
            }).fail((xhr) => {
                $info_vehicle.html(xhr.responseText);
            });
        }

        let init_vehicle = () => {
            search_vehicles(selected_page);
            $info_vehicle.html('');
        }

        init_form_element();
        init_vehicle();
    </script>
@endpush
