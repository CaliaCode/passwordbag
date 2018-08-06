<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Name</span>
                    </h5>
                    <span>{{ $project->name }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Description</span>
                    </h5>
                    <span>{{ $project->description }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Client</span>
                    </h5>
                    <span>{{ $project->client->company or '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Created By</span>
                    </h5>
                    <span>{{ $project->user->name }}</span>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            @unless(Auth::user()->hasRole('employer'))
                <div class="pull-right">
                    <button type="button" class="btn btn-info app_actions-project" data-id="{{ $project->id }}" data-action-type="update" data-from="modal-view">Edit</button>
                    <button type="button" class="btn btn-danger app_actions-project" data-id="{{ $project->id }}" data-action-type="delete" data-from="modal-view">Delete</button>
                </div>
            @endunless
        </div>

    </div>
</div>

