<template>
    <div>
        <form id="app_settings-form" action="/admin/settings" method="post" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    App Settings
                </div>
                <div class="panel-body">

                    <!--=== Loading Icon ===-->
                    <div class="row center-block app_settings_working">
                        <transition  enter-active-class="animated flipInY"
                                     leave-active-class="animated flipOutY">
                            <div class="app_working" v-if="working">
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </transition>
                    </div>

                    <input type="hidden" name="_method" value="put">

                    <!--=== Logo ===-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-left" :class="{ 'has-error': errors.app_logo }">
                                <h3>Logo</h3>
                                <div class="app_logo">
                                    <input id="app_logo" type="file" name="app_logo" class="form-control"  @change="logoChange($event, 'logo')">
                                    <label for="app_logo">
                                        <i class="fa fa-upload"></i>
                                    </label>
                                    <span :style="{ backgroundImage: 'url(' + form.app_logo + ')' }" v-if="form.app_logo"></span>
                                </div>

                                <span class="help-block error-help-block" v-if="errors.app_logo">
                                    <template v-for="error in errors.app_logo">
                                        {{ error }}<br>
                                    </template>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--=== Logo Mini ===-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-left" :class="{ 'has-error': errors.app_logo_mini }">
                                <h3>Logo Mini</h3>
                                <div class="app_logo">
                                    <input id="app_logo_mini" type="file" name="app_logo_mini" class="form-control" @change="logoChange($event, 'logo_mini')">
                                    <label for="app_logo_mini">
                                        <i class="fa fa-upload"></i>
                                    </label>
                                    <span :style="{ backgroundImage: 'url(' + form.app_logo_mini + ')' }" v-if="form.app_logo_mini"></span>
                                </div>

                                <span class="help-block error-help-block" v-if="errors.app_logo_mini">
                                    <template v-for="error in errors.app_logo_mini">
                                        {{ error }}<br>
                                    </template>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--=== App Title ===-->
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Title</h3>
                            <div class="form-group" :class="{ 'has-error': errors.title }">
                                <label for="title" class="sr-only">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="App Title" v-model="form.title">

                                <span class="help-block error-help-block" v-if="errors.title">
                                    <template v-for="error in errors.title">
                                        {{ error }}<br>
                                    </template>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--=== Footer Text ===-->
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Footer Text</h3>
                            <div class="form-group" :class="{ 'has-error': errors.footer_text }">
                                <label for="footer_text" class="sr-only">Footer Text</label>
                                <input type="text" name="footer_text" id="footer_text" class="form-control"  placeholder="Footer Text" v-model="form.footer_text">

                                <span class="help-block error-help-block" v-if="errors.footer_text">
                                    <template v-for="error in errors.footer_text">
                                        {{ error }}<br>
                                    </template>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--=== Theme Colors ===-->
                    <div class="row">
                        <div class="form-group" :class="{ 'has-error': errors.theme_color }">

                            <!--=== Yellow-Blu ===-->
                            <div class="col-md-3 app_theme-color">
                                <h3>Yellow-Blu</h3>

                                <input type="radio" name="theme_color" value="yellow-blu" id="yellow-blu" v-model="form.theme_color">
                                <label for="yellow-blu">
                                    <img :src="baseUrl + '/../../public/img/settings/theme-colors/yellow-blu-background.png'">
                                </label>
                            </div>

                            <!--=== Silver-Brown ===-->
                            <div class="col-md-3 app_theme-color">
                                <h3>Silver-Brown</h3>

                                <input type="radio" name="theme_color" value="silver-brown" id="silver-brown" v-model="form.theme_color">
                                <label for="silver-brown">
                                    <img :src="baseUrl + '/../../public/img/settings/theme-colors/silver-brown-background.png'">
                                </label>
                            </div>



                            <!--=== Cream-Green ===-->
                            <div class="col-md-3 app_theme-color">
                                <h3>Cream-Green</h3>

                                <input type="radio" name="theme_color" value="cream-green" id="cream-green" v-model="form.theme_color">
                                <label for="cream-green">
                                    <img :src="baseUrl + '/../../public/img/settings/theme-colors/cream-green-background.png'">
                                </label>
                            </div>

                            <!--=== Sun-Red ===-->
                            <div class="col-md-3 app_theme-color">
                                <h3>Sun-Red</h3>

                                <input type="radio" name="theme_color" value="sun-red" id="sun-red" v-model="form.theme_color">
                                <label for="sun-red">
                                    <img :src="baseUrl + '/../../public/img/settings/theme-colors/sun-red-background.png'">
                                </label>
                            </div>

                            <span class="help-block error-help-block" v-if="errors.theme_color">
                                <template v-for="error in errors.theme_color">
                                    {{ error }}<br>
                                </template>
                            </span>
                        </div>
                    </div>

                    <div class="row app_settings_submit">
                        <button type="submit" class="btn btn-primary" @click.prevent="updateSettings($event)">
                            <i class="fa fa-save" v-if="!working"></i>
                            <i class="fa fa-spinner fa-spin fa-fw" v-if="working"></i>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">

    module.exports = {
        name: 'settings',
        props: [],
        components: {

        },
        data : function () {
            return {
                working: false,
                form: {},
                errors: {},
                baseUrl: window.location.pathname
            }
        },

        beforeCreate(){
            this.working = true;

            this.$http.get('settings/all').then((response) => {

                let tempForm = response.body;

                tempForm.app_logo_mini = window.relativeBaseUrl + '/../../' + tempForm.app_logo_mini;
                tempForm.app_logo = window.relativeBaseUrl + '/../../' + tempForm.app_logo;

                this.$set(this.$data, 'form', tempForm);

                this.working = false;
            },
            (response) => {
                this.working = false;

                noty({
                    text: 'It is not possible to retrieve Settings.',
                    layout: 'topCenter',
                    type: 'error'
                });
            });
        },

        created()
        {

        },
        mounted()
        {

        },
        computed: {  // Computed Properties

        },
        watch: { // Watchers
            errors(){

            }
        },
        methods : { // Methods
            updateSettings(e){
                 let self = this;

                this.working = true;

                let form = $(e.target).closest('form');

                let formData = new FormData(form.get(0));

                this.$http.post('settings', formData).then((response) => {
                    this.working = false;

                    this.errors = {};

                    let tempForm = response.body;

                    tempForm.app_logo_mini = window.relativeBaseUrl + '/../../' + tempForm.app_logo_mini;
                    tempForm.app_logo = window.relativeBaseUrl + '/../../' + tempForm.app_logo;

                    this.$set(this.$data, 'form', tempForm);


//                    this.$nextTick(function(){
                        // UPDDATE....
                        // Logo
                        $('.app_logo-lg img').attr('src', self.form.app_logo)

                        // Logo Mini
                        $('.app_logo-sm img').attr('src', self.form.app_logo_mini)

                        // Title
                        $('title').text(self.form.title);

                        // Footer Text
                        $('.app_footer').text(self.form.footer_text);

                        // Theme Color
                        $('.app_theme_color').attr('href', baseUrl + '/../public/css/app_' + self.form.theme_color + '.css')
//                    });

                    noty({
                        text: 'Settings Updated.',
                        layout: 'topCenter',
                        type: 'success'
                    });
                },
                (response) => {
                    this.working = false;

                    if(response.status === 422){
                        this.errors = response.body;
                    }else{
                        noty({
                            text: 'It is not possible save Settings.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                    }
                });
            },

            logoChange(e, logoType){

                var reader = new FileReader();

                // read the image file as a data URL.
                reader.readAsDataURL(e.currentTarget.files[0]);

                let self = this;
                reader.onload = function (event) {

                    if(logoType == 'logo_mini'){
                        self.form.app_logo_mini = event.target.result;
                    }else{
                        self.form.app_logo = event.target.result;
                    }
                };
            }
        }
    }
</script>
