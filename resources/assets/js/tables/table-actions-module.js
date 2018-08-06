// Module for manage dataTable actions
window.TableActions = function () {

    var settings;

    // Module Configuration
    var config = function(options) {
        settings = {
            actionSelector: options.actionSelector,
            modalSelector: options.modalSelector,
            rootUrl: options.rootUrl,
            currentForm: null
        };

        addEvents();
    }

    // Add actions event listeners
    var addEvents = function() {
        $('body').on('click', settings.actionSelector, function (e) {

            e.preventDefault();

            var action = {};
            action.id = $(this).data('id');
            action.actionType = $(this).data('action-type');
            action.from = $(this).data('from');

            switch (action.actionType) {
                case 'create':
                    createItem(action);
                    break;
                case 'view':
                    viewItem(action);
                    break;
                case 'update':
                    updateItem(action);
                    break;
                case 'delete':
                    deleteItem(action);
                    break;
            }

        });

        $(settings.modalSelector).on('hide.bs.modal hidden.bs.modal', function (e) {
            $(settings.modalSelector + ' .modal-dialog').removeClass('app_form-working');
        })
    }

    // Create Item Action
    var createItem = function(action) {
        if(action.from == 'table') {
            getForm(settings.rootUrl + '/create', action.actionType)
        }else if(action.from == 'modal'){

            if($(settings.currentForm).valid()) {
                $(settings.modalSelector + ' .modal-dialog').addClass('app_form-working');

                saveForm(settings.currentForm, action.actionType);
            }else{
                noty({
                    text: 'Please fill the form correctly.',
                    layout: 'topCenter',
                    type: 'error'
                });
            }
        }

    }

    // View Item Action
    var viewItem = function(action) {
        if(action.from == 'table') {
            getForm(settings.rootUrl + '/' + action.id, action.actionType)
        }

    }

    // Update Item Action
    var updateItem = function(action) {
        if(action.from == 'table') {
            getForm(settings.rootUrl + '/' + action.id + '/edit', action.actionType)
        }else if(action.from == 'modal'){
            if($(settings.currentForm).valid()) {

                $(settings.modalSelector + ' .modal-dialog').addClass('app_form-working');

                saveForm(settings.currentForm, action.actionType, action.id);
            }else{
                noty({
                    text: 'Please fill the form correctly.',
                    layout: 'topCenter',
                    type: 'error'
                });
            }
        }else if(action.from == 'modal-view'){
            $(settings.modalSelector + ' .modal-dialog').addClass('app_form-working');

            getForm(settings.rootUrl + '/' + action.id + '/edit', action.actionType, true)
        }
    }

    // Delete Item Action
    var deleteItem = function(action) {

        if(action.from == 'modal-view'){

            $(settings.modalSelector).modal('hide').html('');
            
        }
        
        noty({
            text: 'Do you really want to delete this Record?',
            layout: 'center',
            type: 'dialog',
            buttons: [
                {
                    addClass: 'btn btn-danger', text: 'No', onClick: function ($noty) {
                    $noty.close();
                }
                },
                {
                    addClass: 'btn btn-primary', text: 'Yes', onClick: function ($noty) {
                    $noty.close();
                    if (action.from == 'table') {
                        $.ajax({
                            url: settings.rootUrl + '/' + action.id,
                            method: 'DELETE',
                            dataType: 'text',
                        }).done(function (res) {
                            noty({text: 'Record deleted successfully.', layout: 'topCenter', type: 'success'});
                            window.dataTable.ajax.reload(null, false);
                        }).fail(function () {
                            noty({
                                text: 'It was not Possible to delete the record.',
                                layout: 'topCenter',
                                type: 'error'
                            });
                        });
                    }
                }
                }
            ]
        });
    }

    // Get the desired form
    var getForm = function(formUrl, actionType, modal){

        var modal = modal || false;

        $.get({
            url: formUrl,
            dataType: 'html'
        }).done(function(res){

            if(!modal) {
                // Insert the retrieved html inside the modal
                $(settings.modalSelector).modal('hide').html(res).modal('show');
            }else{
                // Insert the retrieved html inside the modal
                $(settings.modalSelector).html(res);

                $(settings.modalSelector + ' .modal-dialog').removeClass('app_form-working');
            }

            if(actionType == 'create' || actionType == 'update') {
                // Get reference to the retrieved form
                settings.currentForm = $(settings.modalSelector + ' form')[0];
            }

        }).fail(function(){
            noty({text: 'There was an error retrieving the content.',
                  layout: 'topCenter',
                  type: 'error'
            });
        });
    }

    // Save Form
    var saveForm = function(form, actionType, id){

        var url = (actionType == 'create')? settings.rootUrl: settings.rootUrl + '/' + id;

        $.ajax({
            url: url,
            data: new FormData(form),
            method: 'POST',
            dataType: 'text',
            contentType: false,
            cache: false,
            processData:false
        }).done(function(res){
            console.log(res);

            $(settings.modalSelector).modal('hide').html('');

            noty({text: res,
                  layout: 'topCenter',
                  type: 'success'
            });

            window.dataTable.ajax.reload(null, false);

        }).fail(function(xhr){

            if(xhr.status == 422){

                // Display errors ServerSide validation
                var form        = $(settings.currentForm);
                var formGroup   = form.find('.form-group');

                // Remove if displayed errors
                formGroup.each(function(){
                    
                    if($(this).hasClass('has-error')){
                        $(this).removeClass('has-error');
                    }

                    if($(this).find('span.error-help-block')){
                        $(this).remove('span.error-help-block')
                    }
                    
                });
                
                let errors = JSON.parse(xhr.responseText);

                // Elaborate all the errors
                for(var key in errors){
                  
                    var errorString = '';

                    // Elaborate the messages
                    for(var error in errors[key]){
                        errorString += errors[key][error] + '<br>';
                    }

                    var elementWithError = $('*[id^="' + key + '"]');

                    elementWithError.closest('div.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block error-help-block">' + errorString + '</span>');
                                       
                }

                $(settings.modalSelector + ' .modal-dialog').removeClass('app_form-working');

            }else{
                $(settings.modalSelector).modal('hide');

                noty({text: 'There was an error submitting the form.',
                      layout: 'topCenter',
                      type: 'error'
                });
            }
        });
    }

    return {
        config: config
    };

};


$(document).ready(function(){

    // Users Configuration
    var userActions = new TableActions();

    userActions.config({
        actionSelector: '.app_actions-user',
        modalSelector: '#app_modal',
        rootUrl: window.baseUrl + '/users'
    });

    // File field change
    $('body').on('change', '#avatar',function(e){

        var input = $(this)[0];

        if(input.files){

            $('label[for="avatar"] > span').text(input.files[0].name);

            previewUploadedImage('.app_form-avatar-preview', input.files[0]);
        }

    });


    // Clients Configuration
    var clientActions = new TableActions();

    clientActions.config({
        actionSelector: '.app_actions-client',
        modalSelector: '#app_modal',
        rootUrl: window.baseUrl + '/clients'
    });

    // Projects Configuration
    var projectActions = new TableActions();

    projectActions.config({
        actionSelector: '.app_actions-project',
        modalSelector: '#app_modal',
        rootUrl: window.baseUrl + '/projects'
    });

});

// Preview Upload Image
function previewUploadedImage(selector, file){

    var reader = new FileReader();

    // read the image file as a data URL.
    reader.readAsDataURL(file);

    reader.onload = function (event) {

        $(selector).css('background-image', 'url("' + event.target.result + '")');
    };

}


