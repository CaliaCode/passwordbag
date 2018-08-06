// Main scripts
require('./bootstrap');

// Configurations
require('./config');

// Tables Actions Module
require('./tables/table-actions-module');

// System
import Vue          from 'vue';
import VueResource  from 'vue-resource';

// Routes
import router       from './routes';

Vue.use(VueResource);

new Vue({
    router,
    root: '/admin',
    components : {},
    data : {
        toggle: false
    },
    beforeCreate(){ },
    created(){
        let self = this;
       
        $('body').on('click.menu', '.app_sidebar-menu-item', function () {
            if($(window).width() <= 992) {
                self.toggle = false;
            }
        });
    },
    methods: {
        profileEdit(id){ // Edit Profile
            let self = this;

            this.$http.get(window.baseUrl + '/profile/' + id + '/edit').then((response) => {

                // Insert the retrieved html inside the modal
                $('#app_modal').modal('hide').html(response.body).modal('show');

                // Set action for profile update
                $('.app_actions-profile').on('click', function(e){

                    e.preventDefault();
                    
                    self.profileUpdate(id);
                    
                });
            },
            (response) => {
                noty({text: 'It is not possible edit your profile.',
                    layout: 'topCenter',
                    type: 'error'
                });
            });
        },
        profileUpdate(id){ // Save Profile
            
            // Form profile
            let profileForm = $('#app_form-profile-update');

            // Test if the form is valid
            if(profileForm.valid()){
                
                $('#app_form-profile-update' + ' .modal-dialog').addClass('app_form-working');

                let formData = new FormData(profileForm[0]);               
                
                this.$http.post(window.baseUrl + '/profile/' + id, formData).then((response) => {
                    
                    $('#app_modal').modal('hide').html('');

                    noty({text: response.body,
                        layout: 'topCenter',
                        type: 'success'
                    });

                    console.log(response);
                },
                (response) => {

                    $('#app_form-profile-update' + ' .modal-dialog').removeClass('app_form-working');                    
                    
                    $('#app_modal').modal('hide').html('');

                    noty({text: 'There was an error submitting the form.',
                        layout: 'topCenter',
                        type: 'error'
                    });
                    
                });
            }else{
                noty({text: 'Fill the form correctly.',
                    layout: 'topCenter',
                    type: 'error'
                });
            }
        },

        passwordEdit(id){
            let self = this;

            // Get the password form
            this.$http.get(window.baseUrl + '/password/' + id + '/edit').then((response) => {
                    
                    // Insert the retrieved html inside the modal
                    $('#app_modal').modal('hide').html(response.body).modal('show');

                    // Set action for password update
                    $('.app_actions-password').on('click', function(e){

                        e.preventDefault();
                        
                        self.passwordUpdate(id);
                    
                    });
                },
                (response) => {
                    noty({text: 'It is not possible edit your password.',
                        layout: 'topCenter',
                        type: 'error'
                    });
                });
        },
        passwordUpdate(id){
            // Get the form
            let passwordForm = $('#app_form-password-update');
            
            // Test if form is valid
            if(passwordForm.valid()){
                
                $('#app_form-profile-update' + ' .modal-dialog').addClass('app_form-working');

                this.$http.post(window.baseUrl + '/password/' + id, new FormData(passwordForm[0])).then((response) => {
                        $('#app_modal').modal('hide').html('');

                        noty({text: response.body,
                            layout: 'topCenter',
                            type: 'success'
                        });
                    },
                    (response) => {

                        $('#app_form-profile-update' + ' .modal-dialog').removeClass('app_form-working');                        
                        
                        $('#app_modal').modal('hide').html('');

                        noty({text: 'There was an error submitting the form.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                        
                        console.log(response);
                    });
            }else{
                noty({text: 'Fill the form correctly.',
                    layout: 'topCenter',
                    type: 'error'
                });
            }
        },
        toggleSideMenu(){
            let self = this;
            
            if(this.toggle == false){
                this.toggle = true;
                
                if($(window).width() <= 992) {
                    $('body').on('mouseup.menu', function (e) {

                        e.preventDefault();

                        let buttonToggleMenu = $('.app_toggle-sidebar a');
                        let sideMenu = $('.app_sidebar');

                        if (!sideMenu.is(e.target) && 
                            sideMenu.has(e.target).length === 0 && 
                            !buttonToggleMenu.is(e.target) &&
                            buttonToggleMenu.has(e.target).length === 0) {
                            self.toggle = false;
                            $('body').off('mouseup.menu');
                        }
                    });
                }
            }else{
                this.toggle = false;

                if($(window).width() <= 992) {
                    $('body').off('mouseup.menu');
                }
            }
        },
        toggleFullScreen(){

                // if already full screen; exit
                // else go fullscreen
                if (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.mozFullScreenElement ||
                    document.msFullscreenElement
                ) {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                } else {
                    let element = $('html').get(0);
                    if (element.requestFullscreen) {
                        element.requestFullscreen();
                    } else if (element.mozRequestFullScreen) {
                        element.mozRequestFullScreen();
                    } else if (element.webkitRequestFullscreen) {
                        element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    } else if (element.msRequestFullscreen) {
                        element.msRequestFullscreen();
                    }
                }

        }
    }
}).$mount('#app');






