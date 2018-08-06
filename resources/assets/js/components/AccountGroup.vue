<template>
    <div class="app_account-group">

        <!-- AccountGroup "VIEW MODE"
        =================================================-->
        <template v-if="mode === 'view'">
            <!--=== AccountGroup HEADER ===-->
            <div class="app_account-group-header">
                <h3 class="pull-left">
                    {{ accountGroup.title }}
                </h3>
                <div class="pull-right">
                    <ul class="app_account-group-view-actions">

                        <!-- action edit -->
                        <li>
                           <a role="button" class="btn btn-default"
                              @click="mode = 'edit'">
                               <i class="fa fa-pencil"></i>
                           </a>
                        </li>

                        <!-- action send via mail -->
                        <li>
                            <a role="button" class="btn btn-info btn-mail"
                               @click.capture="toggleSendForm($event)">
                                <i class="fa fa-envelope"></i>
                            </a>
                            <div class="app_send-via-mail" v-if="send">
                                <form autocomplete="on">
                                    <div class="form-group" :class="{ 'has-error': emailErrors }">
                                        <label class="sr-only">Send to:</label>
                                        <input type="email" placeholder="example@domain.com" v-model="email">
                                        <span class="help-block error-help-block" v-if="emailErrors">
                                            {{ emailErrors }}
                                        </span>
                                        <a class="btn btn-primary"
                                           @click.prevent="sendAccountGroup()">
                                            <i class="fa fa-paper-plane" aria-hidden="true" v-if="!sending"></i>
                                            <i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"  v-if="sending"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- action delete -->
                        <li>
                            <a role="button" class="btn btn-primary"
                               @click="deleteAccountGroup()">
                                <i class="fa fa-trash"></i>
                            </a>
                        </li>

                        <!-- action login in a click with the chrome extension if present -->
                        <li v-if="extension">
                            <a role="button" class="btn btn-primary passwordbag" :data-credentials="credentials()">
                                <i class="fa fa-user"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--=== AccountGroup BODY ===-->
            <!--=== AccountGroup -> Category ===-->
            <div v-if="accountGroup.category" class="app_account-group-category">
                <span>{{ accountGroup.category.name }}</span>
            </div>

            <!--=== AccountGroup -> Account ===-->
            <ul class="app_account-group-body">
                <li v-for="(account, index) in accountGroup.accounts" :account="account" :mode="mode">
                    <account :account="account" :mode="mode"></account>
                </li>
            </ul>
        </template>

        <!-- AccountGroup "EDIT MODE"
        =================================================-->
        <transition enter-active-class="animated zoomIn" leave-active-class="animated fadeOut app_animation-position" mode="out-in">
            <template v-if="mode === 'edit'">

                <form class="app_account-group-form">
                    <div class="app_working-box" v-if="working">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <!--=== AccountGroup Title ===-->
                    <div class="form-group" :class="{ 'has-error': titleErrors }">
                        <label class="sr-only"></label>
                        <input type="text" class="form-control" placeholder="Title" v-model="editAccountGroup.title">
                        <span class="help-block error-help-block" v-if="titleErrors">
                            {{ titleErrors }}
                        </span>
                    </div>

                    <!--=== AccountGroup Category ===-->
                    <div class="form-group">
                        ---->> is{{ category }}

                        <label class="sr-only"></label>
                        <select v-model.number="category" class="app_select-category" :data-index="index">
                            <option v-for="(category, index) in categories" :value="index">{{ category.name }}</option>
                        </select>
                    </div>

                    <!--=== AccountGroup -> Account ===-->
                    <div :id="editAccountGroup.id" class="app_account-list">
                        <account v-for="(account, index) in editAccountGroup.accounts"
                                 :account="account"
                                 :key="account.id"
                                 :mode="mode"
                                 :errors="errors"
                                 :i="index"
                                 @addAccount="newAccount(index)"
                                 @deleteAccount="deleteAccount(index)"></account>
                    </div>

                    <!--=== AccountGroup Actions ===-->
                    <div class="app_account-group-edit-actions">
                        <a class="btn btn-primary pull-left" @click="saveAccountGroup">SAVE</a>
                        <a class="btn btn-default pull-right" @click="closeEditMode">CLOSE</a>
                    </div>
                </form>
            </template>
        </transition>
    </div>
</template>

<script type="text/babel">
    // System
    import Sortable     from 'sortablejs';

    // Components
    import Account from './Account.vue';

    module.exports = {
        name: 'account-group',
        props: ['categories', 'project', 'accountGroup', 'index'],
        components: {
            Account
        },
        data : function () {
            return {
                mode: 'view',
                editAccountGroup: null,
                category: null,
                errors: {},
                titleErrors: '',
                emailErrors: '',
                working: false,
                sending: false,
                extension: false,
                email: '',
                send: false,
                sortable: null
            }

        },
        created()
        {
            // Set local variable "editAccountGroup"
            this.editAccountGroup = jQuery.extend(true, {}, this.accountGroup);

            // Set "Edit Mode" for newly created Account Groups
            if (this.editAccountGroup.novel !== undefined) {
                this.mode = 'edit';
            }

            // Set the Account Group Category
            if(this.accountGroup.category !== null){

                for(let index in this.categories){
                    if(this.categories[index].id === this.accountGroup.category.id){
                        this.category = index;
                    }
                }
            }else{
                this.category = 0;
            }
        },
        mounted(){
            let self = this;

            this.extension = ($('meta[name=chrome-extension]').attr('content') == 'yes')? true : false;
        },

        updated(){
            this.extension = ($('meta[name=chrome-extension]').attr('content') == 'yes')? true : false;

            let self = this;

            if(this.mode === 'edit' && self.sortable == null) {

                this.$nextTick(function() {

                    let accountList = document.getElementById(self.editAccountGroup.id);

                    self.sortable = Sortable.create(accountList, {
                        draggable: '.app_account',
                        handle: ".app_account-drag",
                        animation: 200,
                        ghostClass: "account-ghost",
                        chosenClass: "account-chosen",
                        dragClass: "account-drag",
                        onEnd: function (evt) {
                            let account = self.editAccountGroup.accounts[evt.oldIndex];

                            self.editAccountGroup.accounts.splice(evt.oldIndex, 1);
                            self.editAccountGroup.accounts.splice(evt.newIndex, 0, account);


                            self.editAccountGroup.accounts.forEach(function(account, i){
                                account.position = i;
                            });
                        },
                    });
                });
            }
        },

        computed: {},
        watch: {
          mode(){
              let self = this;

              if(this.mode === 'view'){
                  this.sortable = null;
              }

              if(this.mode === 'edit'){
                  this.$nextTick(function(){
                      // Set Select2 for Category Field
                      var category = $('[data-index=' + self.index + ']').select2();
                      category.on("select2:select", function (e) {
                          self.category =  e.currentTarget.value;
                      });


                  });
              }
          },
          errors(){ // Error helper
              let titleErrors = '';

              if(this.errors.title !== undefined){
                  this.errors.title.forEach(function(item, index){
                      titleErrors += item + '\n';
                  });
              }

              this.titleErrors = titleErrors;

              let emailErrors = '';

              if(this.errors.email !== undefined){
                  this.errors.email.forEach(function(item, index){
                      emailErrors += item + '\n';
                  });
              }

              this.emailErrors = emailErrors;
          }
        },

        methods : {
            newAccount(index){  // Add new Account at the given Index

                let account = {id: Math.random(), name: '', value: '', value_type: 'text', novel: true};

                this.editAccountGroup.accounts.splice(index + 1, 0, account);

                this.editAccountGroup.accounts.forEach(function(account, i){
                    account.position = i;
                });
            },
            saveAccountGroup(){ // Save the Account Group
                this.working = true;

                // "a" stands for "Account Group"
                let a = this.editAccountGroup;

                let formData = new FormData();

                if(this.accountGroup.novel === undefined && a.id !== undefined){
                    formData.append('id', a.id);
                }

                formData.append('title', a.title);
                formData.append('project', this.project);

                if(this.category != 0){
                    this.accountGroup.category = this.categories[this.category];
                    formData.append('category', this.categories[this.category].id);
                }

                for(let account in a.accounts){
                    if(a.accounts[account].novel === undefined && a.accounts[account].id !== undefined){
                        formData.append('accounts[' + account + '][id]', a.accounts[account].id);
                    }

                    formData.append("accounts[" + account + "][name]", a.accounts[account].name);
                    formData.append("accounts[" + account + "][value]", a.accounts[account].value);
                    formData.append("accounts[" + account + "][value_type]", a.accounts[account].value_type);
                    formData.append("accounts[" + account + "][position]", a.accounts[account].position);
                }

                let self = this;

                this.$http.post('account-groups', formData).then((response) => {

                    if (this.accountGroup.novel !== undefined) {
                        self.$emit('saved-novel', response.body);
                    }else{
                        self.$emit('saved', response.body);
                    }

                    this.working = false;
                    self.mode = 'view';

                    noty({
                        text: 'Account Group successfully saved.',
                        layout: 'topCenter',
                        type: 'success'
                    });

                },
                (response) => {
                    this.working = false;

                    if(response.status === 422){
                        self.errors = response.body;
                    }else{
                        noty({
                            text: 'It is not possible save your Changes.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                    }
                });
            },
            toggleSendForm(e){ // On and Off the send Account Group box

                let self = this;

                if(this.send == false){
                    this.send = true;
                    self.sendEvent = true;

                    $('body').on('mouseup.send', function(e){

                        e.preventDefault();

                        let buttonMail = $('.btn-mail');
                        let sendForm = $('.app_send-via-mail');

                        if(!sendForm.is(e.target) && sendForm.has(e.target).length === 0 && !buttonMail.is(e.target) && buttonMail.has(e.target).length === 0){
                            self.send = false;

                            $('body').off('mouseup.send');
                        }
                    });
                }else{
                    this.send = false;

                    $('body').off('mouseup.send');
                }
            },
            sendAccountGroup(){ // Send "Account Group" via Mail
                this.sending = true;
                let formData = new FormData();

                formData.append('account_group_id', this.accountGroup.id);
                formData.append('email', this.email);

                let self = this;

                this.$http.post('account-groups/send', formData).then((response) => {
                    self.sending = false;
                    self.send = false;
                    noty({
                        text: response.body,
                        layout: 'topCenter',
                        type: 'success'
                    });
                },
                (response) => {
                    self.sending = false;

                    if(response.status == 422){
                        self.errors = response.body;

                        noty({
                            text: 'Please set a valid Email address.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                    }else{
                        self.errors = response.body;

                        noty({
                            text: 'Error during sending Account Group.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                    }
                });
            },
            deleteAccount(index){ // Delete Account
                if(this.editAccountGroup.accounts.length === 1){
                    noty({
                        text: 'At least one Account is necessary per Group',
                        layout: 'topCenter',
                        type: 'error'
                    });
                }else {
                    this.editAccountGroup.accounts.splice(index, 1);
                }
            },

            deleteAccountGroup() {  // Delete "Account Group"
                let self = this;

                noty({
                    text: 'Do you really want to delete this Accounts Group?',
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

                            self.$http.delete('account-groups/' + self.accountGroup.id).then((response) => {

                                self.$emit('deleted');

                                noty({
                                    text: response.body,
                                    layout: 'topCenter',
                                    type: 'success'
                                });

                            },
                            (response) => {
                                noty({
                                    text: 'It was not possible delete this Accounts Group.',
                                    layout: 'topCenter',
                                    type: 'error'
                                });
                            });
                        }
                        }
                    ]
                });

            },
            closeEditMode(){ // Close "Account Group" Edit Mode
                if (this.accountGroup.novel !== undefined) {
                    this.$emit('deleted');
                }else{
                    // Set local variable "editAccountGroup"
                    this.editAccountGroup = jQuery.extend(true, {}, this.accountGroup);

                    this.mode = 'view';
                }
            },
            credentials(){ // Set the credentials fo the Chrome Extension
                let credentials = {};

                for(let account in this.accountGroup.accounts){

                    switch(this.accountGroup.accounts[account].value_type){
                        case 'link':
                            credentials.url = this.accountGroup.accounts[account].value;
                            break;
                        case 'text':
                            credentials.userOrEmail = this.accountGroup.accounts[account].value;
                            break;
                        case 'email':
                            credentials.userOrEmail = this.accountGroup.accounts[account].value;
                            break;
                        case 'password':
                            credentials.password = this.accountGroup.accounts[account].value;
                            break;
                    }
                }

                return JSON.stringify(credentials);
            }
        }
    }
</script>
