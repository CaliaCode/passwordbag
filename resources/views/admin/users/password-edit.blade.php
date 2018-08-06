<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        {!! Form::open(['route' => ['password.update', $user->id], 'method' => 'put', 'id' => 'app_form-password-update','files' => true]) !!}
        <div class="modal-body">

            <div class="form-group">
                <label for="name" class="sr-only"><span>Old Password*</span></label>
                {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old-password', 'placeholder' => 'Old Password']) !!}
            </div>

            <div class="form-group">
                <label for="name" class="sr-only"><span>New Password*</span></label>
                {!! Form::password('new_password', ['class' => 'form-control', 'id' => 'new-password', 'placeholder' => 'New Password']) !!}
            </div>

            <div class="form-group">
                <label for="name" class="sr-only"><span>Confirm New Password*</span></label>
                {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'id' => 'new-password-confirmation', 'placeholder' => 'Confirm New Password']) !!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            <button class="btn btn-primary pull-right app_actions-password">Update</button>

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\User\UpdatePasswordRequest', '#app_form-password-update') !!}
