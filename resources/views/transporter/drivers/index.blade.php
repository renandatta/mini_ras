@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Driver</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_driver()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_driver"></div>
            <div id="table_driver"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_driver = $('#info_driver'),
            $table_driver = $('#table_driver');

        let search_drivers = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('transporter.drivers.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_driver.html(result);
            }).fail((xhr) => {
                $table_driver.html(xhr.responseText);
            });
        }

        let info_driver = (id = '') => {
            $.post("{{ route('transporter.drivers.info') }}", {
                _token, id
            }, (result) => {
                $info_driver.html(result);
            }).fail((xhr) => {
                $info_driver.html(xhr.responseText);
            });
        }

        let init_driver = () => {
            search_drivers(selected_page);
            $info_driver.html('');
        }

        init_form_element();
        init_driver();
    </script>
@endpush
