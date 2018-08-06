<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        <div class="modal-header">
            <span class="app_form-avatar-preview" style="background-image: url('{{ asset('public/' . $user->userInfo->avatar) }}')"></span>
        </div>
        {!! Form::open(['route' => ['users.update', $user->id], 'method' => 'put', 'id' => 'app_form-user-update','files' => true]) !!}
        <div class="modal-body">

            <div class="form-group">
                <label for="name" class="sr-only"><span>Username*</span></label>
                {!! Form::text('name', $user->name,['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Username']) !!}
            </div>

            <div class="form-group">
                <label for="first-name" class="sr-only"><span>First Name*</span></label>
                {!! Form::text('first_name', $user->userInfo->first_name,['class' => 'form-control', 'id' => 'first-name', 'placeholder' => 'First Name']) !!}
            </div>

            <div class="form-group">
                <label for="last-name" class="sr-only"><span>Last Name*</span></label>
                {!! Form::text('last_name', $user->userInfo->last_name,['class' => 'form-control', 'id' => 'last-name', 'placeholder' => 'Last Name']) !!}
            </div>

            <div class="form-group">
                <label for="email" class="sr-only"><span>Email*</span></label>
                {!! Form::email('email', $user->email,['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) !!}
            </div>

            <div class="form-group">
                <label for="status" class="sr-only"><span>Status*</span></label>
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], $user->status,['class' => 'form-control', 'id' => 'status']) !!}
            </div>

            <div class="form-group">
                <label for="role" class="sr-only"><span>Role*</span></label>
                {!! Form::select('role', ['employer' => 'Employer', 'manager' => 'Manager', 'admin' => 'Admin'], $user->roles[0]->name,['class' => 'form-control', 'id' => 'role']) !!}
            </div>

            <div class="form-group">
                <label for="projects" class="sr-only"><span>Assign Projects*</span></label>
                {!! Form::select('projects[]', $projects, $assignedProjects, ['multiple' => true, 'class' => 'form-control hidden', 'id' => 'projects']) !!}
            </div>

            <div class="form-group">
                {!! Form::file('avatar', ['class' => 'form-control',  'id' => 'avatar']) !!}
                <label for="avatar">
                    <i class="fa fa-user-plus"></i>
                    <span>Add Avatar</span>
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            {!! Form::button('Update', ['class' => ' btn btn-primary pull-right app_actions-user', 'data-id' => $user->id,'data-action-type' => 'update', 'data-from' => 'modal']) !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\User\UpdateUserRequest', '#app_form-user-update') !!}

<script>
    // Apply Select2 to projects field
    var projects = $("#projects");

    projects.select2({
        placeholder: "Assign Projects"
    });

    if($('#role').val() != 'employer'){

        projects.next().hide();

    }

    $('body').on('change', '#role', function(e){
        if($('#role').val() == 'employer'){

            projects.next().show();

        }else{
            projects.next().hide();
        }
    });
</script>