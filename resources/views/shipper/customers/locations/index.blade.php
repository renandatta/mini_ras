@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Customer Location "{{ $customer->name }}"</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_customer_location()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_customer_location"></div>
            <div id="table_customer_location"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_customer_location = $('#info_customer_location'),
            $table_customer_location = $('#table_customer_location');

        let search_customer_locations = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('shipper.customers.locations.search', $customer_id) }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_customer_location.html(result);
            }).fail((xhr) => {
                $table_customer_location.html(xhr.responseText);
            });
        }

        let info_customer_location = (id = '') => {
            $.post("{{ route('shipper.customers.locations.info', $customer_id) }}", {
                _token, id
            }, (result) => {
                $info_customer_location.html(result);
            }).fail((xhr) => {
                $info_customer_location.html(xhr.responseText);
            });
        }

        let init_customer_location = () => {
            search_customer_locations(selected_page);
            $info_customer_location.html('');
        }

        init_form_element();
        init_customer_location();
    </script>
@endpush
