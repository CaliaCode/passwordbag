<template>
    <div>
        <!--=== "New Category" Button ===-->
        <a class="app_new-category btn btn-default" @click="newCategory(-1)">
            <i class="fa fa-plus"></i>
        </a>

        <form id="app_categories-form" action="categories" method="post">
            <div class="panel panel-default">

                <!--=== Title ===-->
                <div class="panel-heading">
                    Categories
                </div>
                <div class="panel-body">
                    <div class="row center-block app_categories_working">
                        <transition  enter-active-class="animated flipInY"
                                     leave-active-class="animated flipOutY">
                            <div class="app_working" v-if="working">
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </transition>
                    </div>

                    <div class="row">
                        <ul id="app_categories">
                            <category v-for="(category, index) in categories"
                                      :category="category"
                                      :errors="errors"
                                      :index="index"
                                      :key="category.id"
                                      @new-category="newCategory(index)"
                                      @delete-category="deleteCategory(index)"></category>
                        </ul>
                    </div>

                    <div class="row app_categories_submit">
                        <button type="submit" class="btn btn-primary" @click.prevent="updateCategories">
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

    // System
    import Vue          from 'vue';
    import Sortable     from 'sortablejs';


    // Components
    import Category from './Category.vue';

    module.exports = {
        name: 'categories',
        props: [],
        components: {
            Category
        },
        data : function () {
            return {
                working: true,
                categories: [],
                errors: null
            }
        },
        beforeCreate() {

            let self = this;

            this.$http.get('categories/all').then((response) => {

                self.$set(self.$data, 'categories', response.body);

                self.working = false;
            }, (response) => {
                self.working = false;

                noty({
                    text: 'It was not possible retrieve Categories.',
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
            let self = this;

            this.$nextTick(function() {

                let categoryList = document.getElementById('app_categories');

                Sortable.create(categoryList, {
                    draggable: '.category',
                    animation: 200,
                    handle: ".app_category-drag",
                    ghostClass: "category-ghost",
                    chosenClass: "category-chosen",
                    dragClass: "category-drag",
                    onEnd: function (evt) {
                        let category = self.categories[evt.oldIndex];

                        self.categories.splice(evt.oldIndex, 1);
                        self.categories.splice(evt.newIndex, 0, category);
                    },
                });
            });
        },
        computed: {  // Computed Properties

        },
        watch: { // Watchers
            categories(){
                let self = this;

                this.categories.forEach(function(category, i){
                    category.position = i;
                });
            }
        },
        methods : { // Methods
            newCategory(index){
                this.categories.splice(index + 1, 0, {id: Math.random(), name: '', novel: true});
            },
            deleteCategory(index){
                this.categories.splice(index, 1);
            },
            updateCategories(){
                let self = this;

                this.working = true;

                let formData = new FormData();

                for(let category in this.categories){

                    if(this.categories[category].novel === undefined){
                        formData.append('categories[' + category + '][id]', this.categories[category].id);
                    }

                    formData.append('categories[' + category + '][name]', this.categories[category].name);
                    formData.append('categories[' + category + '][position]', this.categories[category].position);
                }

                let form = $('#app_categories-form');

                this.$http.post('categories', formData).then((response) => {
                    self.working = false;

                    self.errors = null;

                    self.$set(self.$data, 'categories', response.body);

                    noty({
                        text: 'Categories saved.',
                        layout: 'topCenter',
                        type: 'success'
                    });
                }, (response) => {
                    self.working = false;

                    if(response.status == 422){
                        self.errors = response.body;
                    }else{
                        self.errors = null;

                        noty({
                            text: 'Error during saving Categories.',
                            layout: 'topCenter',
                            type: 'error'
                        });
                    }
                });
            }
        }
    }
</script>
