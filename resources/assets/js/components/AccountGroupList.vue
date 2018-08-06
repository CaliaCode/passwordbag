<template>
    <div class="app_account-group-wrapper">

        <!--=== "New Account Group" Button ===-->
        <a class="app_new-account-group btn btn-default" @click="newAccountGroup()">
            <i class="fa fa-plus"></i>
        </a>

        <!-- Filter Toolbar
        =================================================-->
        <div class="row">
            <!--=== Filter Search Box ===-->
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Search..."
                           v-model="searchTerm"
                           @keyup="searchCategoryOrKeyword()">
                </div>
            </div>

            <!--=== Filter by Category ===-->
            <div class="col-md-4 app_filter">
                <select v-model.number="category" class="app_select-category">
                    <option v-for="(category, index) in categories" :value="index">{{ category.name }}</option>
                </select>
            </div>

            <!--=== Set the Current Project ===-->
            <div class="col-md-4 app_filter">
                <select v-model.number="project" class="app_select-project">
                    <option v-for="project in projects" :value="project.id">{{ project.name }}</option>
                </select>

            </div>
        </div>

        <!-- AccountGroups
        =================================================-->
        <div class="app_wrapper">
            <transition  enter-active-class="animated flipInY"
                         leave-active-class="animated flipOutY">
                <div class="app_working" v-if="working">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </transition>
            <div class="app_account-group-list">
                <account-group v-for="(accountGroup, index) in visibleAccountGroups"
                               :categories="categories"
                               :project="project"
                               :account-group="accountGroup"
                               :key="accountGroup.id"
                               :index="index"
                               @saved="saved(arguments[0], index)"
                               @saved-novel="savedNovel(arguments[0], index)"
                               @deleted="removeAccountGroup(index)"></account-group>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    // Libraries
    import Clipboard from 'clipboard';

    // Components
    import AccountGroup from './AccountGroup.vue';

    module.exports = {
        name: 'account-group-list',
        components: {
            AccountGroup
        },
        data: function () {
            return {
                project: null,
                projects: [],
                category: null,
                categories: [],
                accountGroups: [],
                visibleAccountGroups: [],
                searchTerm: null,
                working: true,
                clipboard: null
            }
        },
        beforeCreate() {
            let route;

            route = 'account-groups/all' + ((this.$route.params.id) ? '/' + this.$route.params.id : '');

            // Retrieve "Account Groups List" From the Server
            this.$http.get(route).then((response) => {
                let data = response.body;

                data.categories.unshift({name: 'No Category'});

                this.$set(this.$data, 'project', data.project);
                this.$set(this.$data, 'projects', data.projects);
                this.$set(this.$data, 'category', 0);
                this.$set(this.$data, 'categories', data.categories);
                this.$set(this.$data, 'accountGroups', data.accountGroups);
                this.$set(this.$data, 'visibleAccountGroups', data.accountGroups);

                this.working = false;
            }, (response) => {
                this.working = false;

                noty({
                    text: 'It was not possible retrieve your accounts.',
                    layout: 'topCenter',
                    type: 'error'
                });
            });
        },

        mounted() {
            let self = this;

            // Set Select2 for Projects
            let project = $('.app_select-project').select2();
            project.on("select2:select", function (e) {
                self.project = e.currentTarget.value;
            });

            // Set Select2 for categories
            let category = $('.app_select-category').select2();
            category.on("select2:select", function (e) {
                self.category = e.currentTarget.value;
                self.searchCategoryOrKeyword();
            });

            // Set Copy to Clipboard
            this.clipboard = new Clipboard('.app_copy-to-clipboard', {
                text: function (trigger) {
                    return trigger.getAttribute('value-to-copy');
                }
            });

            // On Successfully COPY listener
            this.clipboard.on('success', function (e) {
                noty({
                    text: 'Copied successfully.',
                    layout: 'topCenter',
                    type: 'success'
                });
            });
        },

        beforeDestroy(){
            this.clipboard.destroy();
        },

        watch: {
            project: function (val) { // Load "Account Groups List" related to the selected Project
                var self = this;

                this.working = true;

                this.$http.get('account-groups/all/' + val).then((response) => {
                    var data = response.body;

                    self.accountGroups = data.accountGroups;

                    // Set local variable "editAccountGroup"
                    self.visibleAccountGroups = JSON.parse(JSON.stringify(data.accountGroups));

                    this.working = false;
                }, (response) => {
                    this.working = false;

                    noty({
                        text: 'It was not possible retrieve your accounts for the given Project.',
                        layout: 'topCenter',
                        type: 'error'
                    });
                });
            }
        },

        methods: {
            generatePassword(){
                let password = Math.random().toString(36).slice(-8);

                return password;
            },
            newAccountGroup(){  // Insert new AccountGroup
                let accountGroup = {
                    novel: true,
                    id: Math.random(),
                    title: '',
                    category: null,
                    accounts: [
                        {
                            name: '',
                            value: '',
                            'value_type': 'text',
                            position: 0
                        }
                    ]
                };

                this.visibleAccountGroups.splice(0, 0, accountGroup);
            },
            saved(accountGroup, index){
                this.accountGroups.splice(index, 1, accountGroup);
                this.$set(this.visibleAccountGroups, index, accountGroup);
            },
            savedNovel(newAccountGroup, index){
                this.accountGroups.splice(0, 0, newAccountGroup);
                this.visibleAccountGroups.splice(index, 1, newAccountGroup);
            },
            removeAccountGroup(index){ // Remove Account Group by given Index
                if (this.visibleAccountGroups[index].novel !== undefined) {
                    this.visibleAccountGroups.splice(index, 1);
                } else {
                    this.accountGroups.splice(index, 1);
                    this.searchCategoryOrKeyword();
                }
            },
            searchCategoryOrKeyword(){ // Filter by Keyword or Category
                var self = this;

                this.visibleAccountGroups = this.accountGroups.filter(function (accountGroup) {
                    var hasCategory = true,
                        hasTitleOrName = true;

                    if (accountGroup.novel !== undefined) {
                        return false;
                    }

                    // Check if Category
                    if (self.category !== null) {
                        if (self.category == 0) {
                            hasCategory = true;
                        }
                        else if (accountGroup.category === null) {
                            hasCategory = false;
                        } else {
                            hasCategory = accountGroup.category.name === self.categories[self.category].name;
                        }
                    }

                    if (self.searchTerm !== null && self.searchTerm !== '') {
                        // Check if Title
                        var regExp = new RegExp('^' + self.searchTerm.trim(), 'i');
                        var hasTitle = regExp.test(accountGroup.title);

                        // Check if Account
                        for (var account in accountGroup.accounts) {
                            if (regExp.test(accountGroup.accounts[account].name.trim()) ||
                                regExp.test(accountGroup.accounts[account].value.trim())) {
                                var hasAccount = true;
                                break;
                            }
                        }

                        hasTitleOrName = hasTitle || hasAccount;
                    }

                    return hasCategory && hasTitleOrName;
                });
            }
        }
    }
</script>
