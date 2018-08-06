<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        <div class="modal-header">
            <span class="app_form-avatar-preview" style="background-image: url('{{ asset('public/' . $user->userInfo->avatar) }}')"></span>
        </div>
        {!! Form::open(['route' => ['profile.update', $user->id], 'method' => 'put', 'id' => 'app_form-profile-update','files' => true]) !!}
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
                {!! Form::file('avatar', ['class' => 'form-control',  'id' => 'avatar']) !!}
                <label for="avatar">
                    <i class="fa fa-user-plus"></i>
                    <span>Add Avatar</span>
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            <button class="btn btn-primary pull-right app_actions-profile">Update</button>

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\User\UpdateProfileRequest', '#app_form-profile-update') !!}
