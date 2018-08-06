<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Company Name</span>
                    </h5>
                    <span>{{ $client->company }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Email</span>
                    </h5>
                    <span>{{ $client->email }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Phone</span>
                    </h5>
                    <span>{{ $client->phone }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Mobile</span>
                    </h5>
                    <span>{{ $client->mobile or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Website</span>
                    </h5>
                    <span>{{ $client->website or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Vat Number</span>
                    </h5>
                    <span>{{ $client->vat_number or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Country</span>
                    </h5>
                    <span>{{ $client->country or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Province</span>
                    </h5>
                    <span>{{ $client->province or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Address</span>
                    </h5>
                    <span>{{ $client->address or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Zip Code</span>
                    </h5>
                    <span>{{ $client->zip_code or '' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>
                        <span class="label label-warning">Created By</span>
                    </h5>
                    <span>{{ $client->user->name }}</span>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <div class="pull-right">
                <button type="button" class="btn btn-info app_actions-client" data-id="{{ $client->id }}" data-action-type="update" data-from="modal-view">Edit</button>
                <button type="button" class="btn btn-danger app_actions-client" data-id="{{ $client->id }}" data-action-type="delete" data-from="modal-view">Delete</button>
            </div>
        </div>

    </div>
</div>

