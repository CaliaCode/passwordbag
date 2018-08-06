<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        {!! Form::open(['route' => 'projects.store', 'method' => 'POST', 'id' => 'app_form-project-create']) !!}
        <div class="modal-body">

            <div class="form-group">
                <label for="name" class="sr-only"><span>Name*</span></label>
                {!! Form::text('name', '',['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
            </div>

            <div class="form-group">
                <label for="email" class="sr-only"><span>Description*</span></label>
                {!! Form::textarea('description', '',['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Description']) !!}
            </div>

            <div class="form-group">
                <label for="client" class="sr-only"><span>Client*</span></label>
                {!! Form::select('client', $clients, null,['class' => 'form-control', 'id' => 'client', 'placeholder' => 'Select Client']) !!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            {!! Form::button('Create', ['class' => ' btn btn-primary pull-right app_actions-project', 'data-action-type' => 'create', 'data-from' => 'modal']) !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\Project\CreateProjectRequest', '#app_form-project-create') !!}

<script>
    // Set select
    $("#client").select2();
</script>
