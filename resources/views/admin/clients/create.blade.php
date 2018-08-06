<div class="modal-dialog" role="document">
    <div class="app_form-loading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>
    <div class="modal-content">
        {!! Form::open(['route' => 'clients.store', 'method' => 'POST', 'id' => 'app_form-client-create']) !!}
        <div class="modal-body">
            <div class="form-group">
                <label for="name" class="sr-only"><span>Company Name*</span></label>
                {!! Form::text('company', '',['class' => 'form-control', 'id' => 'company', 'placeholder' => 'Company Name']) !!}
            </div>

            <div class="form-group">
                <label for="email" class="sr-only"><span>Email*</span></label>
                {!! Form::email('email', '',['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) !!}
            </div>

            <div class="form-group">
                <label for="phone" class="sr-only"><span>Phone*</span></label>
                {!! Form::text('phone', '',['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone']) !!}
            </div>

            <div class="form-group">
                <label for="mobile" class="sr-only"><span>Mobile*</span></label>
                {!! Form::text('mobile', '',['class' => 'form-control', 'id' => 'mobile', 'placeholder' => 'Mobile']) !!}
            </div>

            <div class="form-group">
                <label for="website" class="sr-only"><span>Website*</span></label>
                {!! Form::text('website', '',['class' => 'form-control', 'id' => 'website', 'placeholder' => 'Website']) !!}
            </div>

            <div class="form-group">
                <label for="vat_number" class="sr-only"><span>Vat Number*</span></label>
                {!! Form::text('vat_number', '',['class' => 'form-control', 'id' => 'vat_number', 'placeholder' => 'Vat Number']) !!}
            </div>

            <div class="form-group">
                <label for="country" class="sr-only"><span>Country*</span></label>
                {!! Form::text('country', '',['class' => 'form-control', 'id' => 'country', 'placeholder' => 'Country']) !!}
            </div>

            <div class="form-group">
                <label for="province" class="sr-only"><span>Province*</span></label>
                {!! Form::text('province', '',['class' => 'form-control', 'id' => 'province', 'placeholder' => 'Province']) !!}
            </div>

            <div class="form-group">
                <label for="address" class="sr-only"><span>Address*</span></label>
                {!! Form::text('address', '',['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address']) !!}
            </div>

            <div class="form-group">
                <label for="zip_code" class="sr-only"><span>Zip Code*</span></label>
                {!! Form::text('zip_code', '',['class' => 'form-control', 'id' => 'zip_code', 'placeholder' => 'Zip Code']) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            {!! Form::button('Create', ['class' => ' btn btn-primary pull-right app_actions-client', 'data-action-type' => 'create', 'data-from' => 'modal']) !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\Admin\Client\CreateClientRequest', '#app_form-client-create') !!}
