<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_profile" />
        <form id="profile_form">
            @csrf
            @if(!empty($profile))
                <x-input type="hidden" name="id" :value="$profile->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="name" caption="Name">
                        <x-input name="name" :value="$profile->name ?? ''" />
                    </x-form-group>
                    <x-form-group id="phone" caption="Phone">
                        <x-input name="phone" :value="$profile->phone ?? ''" />
                    </x-form-group>
                    <x-form-group id="address" caption="Address">
                        <x-input name="address" :value="$profile->address ?? ''" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_profile()">Cancel</button>
                    @if(!empty($profile))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_profile({{ $profile->id }})">Hapus</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $profile_form = $('#profile_form');
    $profile_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($profile_form.get(0));
        $.ajax({
            url: "{{ route('profiles.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_profile();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_profile', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_profile = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('profiles.delete') }}", data, () => {
                    init_profile();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_profile', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
