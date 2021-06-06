<div class="row">
    <div class="col-md-4">
        <h4 class="mb-3"># Profile Information</h4>
        <h5 class="mb-2"><small>Name</small><br>{{ $profile->name }}</h5>
        <h5 class="mb-2"><small>Phone</small><br>{{ $profile->phone }}</h5>
        <h5 class="mb-2"><small>Address</small><br>{{ $profile->address }}</h5>
        <button class="btn btn-light" type="button" onclick="init_profile()">Close</button>
    </div>
    <div class="col-md-8">
        <h4 class="mb-3"># User Profile</h4>
        <div id="info_user"></div>
        <div id="table_user"></div>
    </div>
</div>
<hr>

<script>
    profile_id = '{{ $profile->id }}';
    $info_user = $('#info_user');
    $table_user = $('#table_user');

    search_users = () => {
        $.post("{{ route('admin.profiles.users.search') }}", {
            _token, profile_id
        }, (result) => {
            $table_user.html(result);
        }).fail((xhr) => {
            $table_user.html(xhr.responseText);
        });
    }

    info_user = (id = '') => {
        $.post("{{ route('admin.profiles.users.info') }}", {
            _token, id, profile_id
        }, (result) => {
            $info_user.html(result);
        }).fail((xhr) => {
            $info_user.html(xhr.responseText);
        });
    }

    init_user = () => {
        search_users(selected_page);
        $info_user.html('');
    }

    init_form_element();
    init_user();
</script>
