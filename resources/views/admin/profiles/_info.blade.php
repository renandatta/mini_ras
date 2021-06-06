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
            @if(!empty($profile))
                <button class="btn btn-danger float-right" type="button" onclick="delete_profile({{ $profile->id }})">Delete</button>
            @endif
        </form>
    </div>
</div>
<hr>

<script>
    $form_profile = $('#form_profile');
    $form_profile.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_profile.get(0));
        $.ajax({
            url: "{{ route('admin.profiles.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_profile();
            },
        }).fail((xhr) => {
            handle_error(xhr);
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
                $.post("{{ route('admin.profiles.delete') }}", {
                    _token, id
                }, () => {
                    init_profile();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_profile', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
