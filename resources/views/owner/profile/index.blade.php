@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Profile</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <x-alert type="error" id="alert_profile" />
                    <form id="form_profile">
                        @csrf
                        <x-input type="hidden" name="id" :value="$profile->id ?? ''" />
                        <x-form-group caption="Name">
                            <x-input name="name" :value="$profile->name ?? ''" />
                        </x-form-group>
                        <x-form-group caption="Phone">
                            <x-input name="phone" :value="$profile->phone ?? ''" />
                        </x-form-group>
                        <x-form-group caption="Adresss">
                            <x-textarea name="address" :value="$profile->address ?? ''" />
                        </x-form-group>
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button class="btn btn-light ml-2" type="button" onclick="init_profile()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}';

        let $form_profile = $('#form_profile');
        $form_profile.submit((e) => {
            e.preventDefault();
            let data = new FormData($form_profile.get(0));
            $.ajax({
                url: "{{ route('owner.profile.save') }}",
                type: 'post',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result) {
                    swal.fire('Profile successfully saved');
                },
            }).fail((xhr) => {
                handle_error(xhr);
            });
        });

        let handle_error = (xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_profile', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        }

        init_form_element();
    </script>
@endpush
