@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Dashboard</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="height: 85vh;">
            <x-alert type="error" id="alert_tracking" />
            <form id="tracking_form" @if($no_order != '') style="display: none;" @endif>
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <x-form-group id="no_order" caption="No.Order">
                            <x-input name="no_order" :value="$no_order ?? ''" />
                        </x-form-group>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-block btn-primary" id="tracking_button_search">Search</button>
                    </div>
                </div>
            </form>
            <div id="tracking_data"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let $tracking_form = $('#tracking_form'),
            $tracking_button_search = $('#tracking_button_search'),
            $tracking_data = $('#tracking_data');

        $tracking_form.submit((e) => {
            e.preventDefault();
            $tracking_button_search.html('<i class="fa fa-spinner fa-spin"></i>');
            let data = new FormData($tracking_form.get(0));
            $.ajax({
                url: "{{ route('track_order') }}",
                type: 'post',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: (result) => {
                    $tracking_data.html(result);
                    $tracking_button_search.html('Search');
                },
            }).fail((xhr) => {
                let error = JSON.parse(xhr.responseText);
                if (error.errors) {
                    display_error('alert_tracking', error.errors);
                } else {
                    console.log(xhr.responseText);
                }
            });
        });

        @if($no_order != '')
            $tracking_form.submit();
        @endif
    </script>
@endpush
