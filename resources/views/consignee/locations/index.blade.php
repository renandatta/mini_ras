@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Location</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_location()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_location"></div>
            <div id="table_location"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_location = $('#info_location'),
            $table_location = $('#table_location');

        let search_locations = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('consignee.locations.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_location.html(result);
            }).fail((xhr) => {
                $table_location.html(xhr.responseText);
            });
        }

        let info_location = (id = '') => {
            $.post("{{ route('consignee.locations.info') }}", {
                _token, id
            }, (result) => {
                $info_location.html(result);
            }).fail((xhr) => {
                $info_location.html(xhr.responseText);
            });
        }

        let init_location = () => {
            search_locations(selected_page);
            $info_location.html('');
        }

        init_form_element();
        init_location();
    </script>
@endpush
