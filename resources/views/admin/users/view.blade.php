<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        <div class="modal-header">
            <span class="app_form-avatar-preview" style="background-image: url('{{ asset('public/' . $user->userInfo->avatar) }}')"></span>
        </div>
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Username</span>
                    </h5>
                    <span>{{ $user->name }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Email</span>
                    </h5>
                    <span>{{ $user->email }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">First Name</span>
                    </h5>
                    <span>{{ $user->userInfo->first_name or '--'}}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Last Name</span>
                    </h5>
                    <span>{{ $user->userInfo->last_name or '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Status</span>
                    </h5>
                    <span>{{ $user->status ? 'Active' : 'Inactive'  }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Role</span>
                    </h5>
                    <span>{{ $user->roles[0]->name  }}</span>
                </li>
                @if($user->roles[0]->name == 'employer')
                    <li class="list-group-item">
                        <h5>
                            <span class="label label-warning">Assigned Projects:</span>
                        </h5>
                        <span>
                            @foreach($user->assignedProjects as $project)
                                - {{ $project->name }}<br>
                            @endforeach
                        </span>
                    </li>
                @endif
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <div class="pull-right">
                <button type="button" class="btn btn-info app_actions-user" data-id="{{ $user->id }}" data-action-type="update" data-from="modal-view">Edit</button>
                <button type="button" class="btn btn-danger app_actions-user" data-id="{{ $user->id }}" data-action-type="delete" data-from="modal-view">Delete</button>
            </div>
        </div>

    </div>
</div>

