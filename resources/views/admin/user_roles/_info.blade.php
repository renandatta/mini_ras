<div class="row">
    <div class="col-md-6">
        <x-alert type="error" id="alert_user_role" />
        <form id="form_user_role">
            @csrf
            <x-input type="hidden" name="id" :value="$user_role->id ?? ''" />
            <x-form-group caption="Name">
                <x-input name="name" :value="$user_role->name ?? ''" />
            </x-form-group>
            <x-form-group caption="Description">
                <x-textarea name="description" :value="$user_role->description ?? ''" />
            </x-form-group>
            <x-form-group caption="Credential">
                <x-select
                    name="feature_id"
                    class="select2"
                    caption="Empty"
                    :options="$list_features"
                    :value="$user_role->feature_id ?? ''"
                />
            </x-form-group>
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-light ml-2" type="button" onclick="init_user_role()">Cancel</button>
            @if(!empty($user_role))
                <button class="btn btn-danger float-right" type="button" onclick="delete_user_role({{ $user_role->id }})">Delete</button>
            @endif
        </form>
    </div>
</div>
<hr>

<script>
    $form_user_role = $('#form_user_role');
    $form_user_role.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_user_role.get(0));
        $.ajax({
            url: "{{ route('admin.user_roles.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_user_role();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_user_role = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('admin.user_roles.delete') }}", {
                    _token, id
                }, () => {
                    init_user_role();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_user_role', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
