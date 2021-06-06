<x-alert type="error" id="alert_user" />
<form id="form_user">
    @csrf
    <x-input type="hidden" name="id" :value="$user->id ?? ''" />
    <x-input type="hidden" name="profile_id" :value="$profile_id ?? ''" />
    <div class="row">
        <div class="col-md-6">
            <x-form-group caption="User Role">
                <x-select name="user_role_id" class="select2" :options="$user_roles" :value="$user->user_role_id ?? ''" />
            </x-form-group>
            <x-form-group caption="Name">
                <x-input name="name" :value="$user->name ?? ''" />
            </x-form-group>
            <x-form-group caption="Email">
                <x-input name="email" :value="$user->email ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-6">
            @if(!empty($user))
                <i>*) Ignore field below if no changes</i>
            @endif
            <x-form-group caption="Password">
                <x-input name="password" type="password" />
            </x-form-group>
            <x-form-group caption="Repeat Password">
                <x-input name="password_confirmation" type="password" />
            </x-form-group>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_user()">Cancel</button>
    @if(!empty($user))
        <button class="btn btn-danger float-right" type="button" onclick="delete_user({{ $user->id }})">Delete</button>
    @endif
</form>
<hr>

<script>
    $form_user = $('#form_user');
    $form_user.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_user.get(0));
        $.ajax({
            url: "{{ route('admin.users.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_user();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_user = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('admin.users.delete') }}", {
                    _token, id
                }, () => {
                    init_user();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_user', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
