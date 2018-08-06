<template>
    <div class="app_account">
        <!-- ACCOUNT "VIEW MODE"
        =================================================-->
        <template v-if="mode === 'view'">
            <!--=== Account Name Input ===-->
            <div class="app_account-name">
                <h5>
                    {{ account.name }}
                </h5>
            </div>

            <!--=== Account Value ===-->
            <div class="app_account-value">
                <a v-if="account.value_type == 'email'" :href="'mailto:' + account.value">
                    {{ account.value }}
                </a>
                <a v-if="account.value_type == 'link'" :href="account.value">
                    {{ account.value }}
                </a>
                <template v-else>
                    <div v-if="account.value_type === 'password' && !visible" v-html="passwordPlaceholder"></div>
                    <div v-if="(account.value_type === 'password' && visible) ||
                                account.value_type === 'text' ||
                                account.value_type === 'textarea'">
                        {{ account.value }}
                    </div>
                </template>
                <span>
                    <a v-if="account.value_type === 'password'" @click="visible = !visible">
                        <i class="fa fa-eye-slash" v-if="visible"></i>
                        <i class="fa fa-eye" v-else></i>
                    </a>
                    <a class="app_copy-to-clipboard" :value-to-copy="account.value">
                        <i class="fa fa-copy"></i>
                    </a>
                </span>
            </div>
        </template>

        <!-- ACCOUNT "EDIT MODE"
        =================================================-->
        <template v-if="mode === 'edit'">

            <!--=== Account Name and Value Group ===-->
            <div class="form-group" :class="{ 'has-error': nameErrors || valueErrors }">
                <!--=== Account Name Input ===-->
                 <span class="help-block error-help-block top-help-block" v-if="nameErrors">
                    {{ nameErrors }}
                </span>
                <label class="sr-only" :for="account.id + account.name"></label>
                <input type="text" class="form-control app_account-name-input" placeholder="Name" v-model="account.name">

                <!--=== Account Value Input ===-->
                <label class="sr-only" :for="account.id + account.value"></label>
                <input type="text" class="form-control app_account-value-input" placeholder="Text" v-model="account.value" v-if="account.value_type === 'text'">
                <input type="email" class="form-control app_account-value-input" placeholder="Email" v-model="account.value" v-if="account.value_type === 'email'">
                <input type="password" class="form-control app_account-value-input" placeholder="Password" v-model="account.value" v-if="account.value_type === 'password' && !visible">
                <input type="text" class="form-control app_account-value-input" placeholder="Password" v-model="account.value" v-if="account.value_type === 'password' && visible">
                <textarea class="form-control app_account-value-input" rows="5" placeholder="Text..." v-model="account.value" v-if="account.value_type === 'textarea'"></textarea>
                <input type="text" class="form-control app_account-value-input" placeholder="Link" v-model="account.value" v-if="account.value_type === 'link'">

                <!--=== Account Value "Input Type" [text, textarea, email, password, link] ===-->
                <div class="app_actions-value-type">
                    <input type="hidden" v-model="account.value_type">
                    <a @click="setAccountType('text')" :class="{active: (account.value_type === 'text')}">Text</a>
                    <a @click="setAccountType('textarea')" :class="{active: (account.value_type === 'textarea')}">Textarea</a>
                    <a @click="setAccountType('email')" :class="{active: (account.value_type === 'email')}">Email</a>
                    <a @click="setAccountType('password')" :class="{active: (account.value_type === 'password')}">Password</a>
                    <a @click="setAccountType('link')" :class="{active: (account.value_type === 'link')}">Link</a>
                </div>

                <span class="help-block error-help-block" v-if="valueErrors">
                    {{ valueErrors }}
                </span>
            </div>
            <!--=== Account Actions ===-->
            <div class="app_actions-account">
                <a data-action="generate" v-if="account.value_type === 'password'" @click="generatePassword"><i class="fa fa-key"></i></a>
                <a data-action="view" v-if="account.value_type === 'password'" @click="visible = !visible"><i class="fa fa-eye"></i></a>
                <a data-action="delete" @click="deleteAccount"><i class="fa fa-trash"></i></a>
                <a data-action="add" @click="addAccount"><i class="fa fa-plus"></i></a>
                <a data-action="move" class="app_account-drag"><i class="fa fa-arrows"></i></a>
            </div>
        </template>
    </div>
</template>

<script type="text/babel">

    module.exports = {

        name: 'account',

        props: ['account', 'mode', 'errors', 'i'],

        components: {

        },

        data : function () {
            return {
                localAccount: {},
                visible: false,
                nameErrors: '',
                valueErrors: ''
            }

        },

        created()
        {

        },

        mounted()
        {

        },

        computed: {  // Computed Properties
            passwordPlaceholder(){
                const passwordLength = this.account.value.length;
                return Array(passwordLength + 1).join("&#x25cf");

            },
        },
        watch: { // Watchers
            errors(){

                let nameErrors = '';

                if(this.errors['accounts.' + this.i + '.name'] !== undefined){

                    this.errors['accounts.' + this.i + '.name'].forEach(function(item, index){

                        nameErrors += item + '\n';

                    });

                }else{
                    nameErrors = '';
                }

                this.nameErrors = nameErrors;

                let valueErrors = '';

                if(this.errors['accounts.' + this.i + '.value'] !== undefined){

                    this.errors['accounts.' + this.i + '.value'].forEach(function(item, index){

                        valueErrors += item + '\n';

                    });


                }else{
                    valueErrors = '';
                }

                this.valueErrors = valueErrors;

            }
        },
        methods : { // Methods
            addAccount(){   // Add "NEW ACCOUNT"
                this.$emit('addAccount');
            },
            deleteAccount(){
                this.$emit('deleteAccount');
            },
            generatePassword(){  // Generate Random Password
                this.account.value = Math.random().toString(36).slice(-8);
            },
            setAccountType(type){
                switch(type){
                    case 'text':
                        this.account.name = 'Username';
                        this.account.value_type = 'text';
                        break;
                    case 'textarea':
                        this.account.name = 'Notes';
                        this.account.value_type = 'textarea';
                        break;
                    case 'email':
                        this.account.name = 'Email';
                        this.account.value_type = 'email';
                        break;
                    case 'password':
                        this.account.name = 'Password';
                        this.account.value_type = 'password';
                        break;
                    case 'link':
                        this.account.name = 'Link';
                        this.account.value_type = 'link';
                        break;
                }
            }
        }
    }
</script>
