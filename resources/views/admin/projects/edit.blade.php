<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        {!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'put', 'id' => 'app_form-project-update']) !!}
        <div class="modal-body">

            <div class="form-group">
                <label for="name" class="sr-only"><span>Name*</span></label>
                {!! Form::text('name', null,['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
            </div>

            <div class="form-group">
                <label for="email" class="sr-only"><span>Description*</span></label>
                {!! Form::textarea('description', null,['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Description']) !!}
            </div>

            <div class="form-group">
                <label for="client" class="sr-only"><span>Client*</span></label>
                {!! Form::select('client', $clients, (isset($project->client->id) ? $project->client->id : null), ['class' => 'form-control', 'id' => 'client', 'placeholder' => 'No Client']) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            {!! Form::button('Update', ['class' => ' btn btn-primary pull-right app_actions-project', 'data-id' => $project->id, 'data-action-type' => 'update', 'data-from' => 'modal']) !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\Project\UpdateProjectRequest', '#app_form-project-update') !!}

<script>
    // Set select
    $("#client").select2();
</script>