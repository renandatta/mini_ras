@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Feature</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_feature()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7">
                    @include('admin.features.table')
                </div>
                <div class="col-md-5">
                    <div id="info_feature"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}';
        let $info_feature = $('#info_feature');

        let info_feature = (id = '', parent_code = '#') => {
            $.post("{{ route('admin.features.info') }}", {
                _token, id, parent_code
            }, (result) => {
                $info_feature.html(result);
            }).fail((xhr) => {
                $info_feature.html(xhr.responseText);
            });
        }

        let init_feature = () => {
            search_features();
            $info_feature.html('');
        }

        init_form_element();
        init_feature();
    </script>
@endpush
