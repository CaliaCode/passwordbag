<template>

    <!-- Category
    ==============================================-->
    <li class="category">
        <div class="form-group" :class="{ 'has-error': categoryErrors }">

            <!-- category name -->
            <input type="text" :name="'categories[' + index + '][name]'" :value="category.name" placeholder="Category" class="form-control" v-model="category.name">

            <!-- category errors -->
            <span class="help-block error-help-block" v-if="categoryErrors">
                    {{ categoryErrors }}
                </span>

            <!-- category id -->
            <template v-if="category.id">
                <input type="hidden" :name="'categories[' + index + '][id]'" :value="category.id">
            </template>

            <!-- category position -->
            <input type="hidden" :name="'categories[' + index + '][position]'" :value="category.position">
        </div>
        <!--=== Actions ===-->
        <div>
            <!-- new category -->
            <a class="btn btn-primary" @click="newCategory">
                <i class="fa fa-plus"></i>
            </a>
            <!-- delete category -->
            <a class="btn btn-danger" @click="deleteCategory">
                <i class="fa fa-trash"></i>
            </a>

            <!-- move category -->
            <a class="btn btn-default app_category-drag">
                <i class="fa fa-arrows"></i>
            </a>
        </div>
    </li>
</template>

<script type="text/babel">

    module.exports = {
        name: 'category',
        props: ['category', 'errors', 'index'],
        components: {},
        data : function () {
            return {
                categoryErrors: ''
            }
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
                if(this.errors === null) return;

                let categoryErrors = '';

                if(this.errors['categories.' + this.index + '.name'] !== undefined){

                    this.errors['categories.' + this.index + '.name'].forEach(function(item, index){

                        categoryErrors += item + '\n';

                    });


                }else{
                    categoryErrors = '';
                }

                this.categoryErrors = categoryErrors;
            }
        },
        methods : { // Methods
            newCategory(){
                this.$emit('new-category');
            },
            deleteCategory(){
                this.$emit('delete-category');
            }
        }
    }
</script>
