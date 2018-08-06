<template>
    <div>
        <!--=== Create Project Button ===-->
        <div class="app_content-actions" v-if="canCreate">
            <a href="#" class="app_actions-project btn btn-default" role="button"  data-action-type="create" data-from="table">
                <i class="fa fa-user-plus"></i>Create Project
            </a>
        </div>
        <div class="app_content-datatable panel panel-default">
            <div class="panel-heading">
                <div class="row">

                    <!--=== Title ===-->
                    <div class="col-md-6">
                        <h3 class="panel-title">Projects</h3>
                    </div>

                    <!--=== Search Box ===-->
                    <div class="app_content-heading-search col-md-6">
                        <div>
                            <i class="fa fa-search"></i>
                            <input type="text" id="app_content-table-search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <!--=== Projects Table ===-->
                <table id="app_projects-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created By</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    // Routes
    import router       from './../routes';

    module.exports = {
        name: 'projects',
        data : function() {
            return {
                canCreate: true
            }

        },
        created(){
            let self = this;

            this.$http.get('projects/can-create').then((response) => {
                if(response.body == 'no'){
                    self.canCreate = false;
                }
            },
            (response) => {
                console.log(response);
            });
        },
        mounted(){
            let self = this;

            this.$nextTick(function(){
                // Set DataTable
                window.dataTable = $('#app_projects-table').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    dom: '<rt><"row"<"col-md-6"i><"col-md-6"p>>',
                    order: [[ 1, "desc" ]],
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    ajax: window.baseUrl + '/projects/all',
                    columns: [
                        {data: 'actions',         name: 'actions', orderable: false, searchable: false},
                        {data: 'name',            name: 'projects.name'},
                        {data: 'description',     name: 'projects.description'},
                        {data: 'user_name',       name: 'users.name'}
                    ]
                });

                // Set DataTable search
                $("#app_content-table-search").on("keyup search input paste cut", function () {
                    dataTable.search(this.value).draw();
                });
            });

            // Go to the accounts of the selected project
            $('body').on('click', '.app_actions-project', function (e) {
                e.preventDefault();

                var action = {};
                action.id = $(this).data('id');
                action.actionType = $(this).data('action-type');
                action.from = $(this).data('from');

                if(action.actionType === 'view-related'){
                    self.$router.push({ name: 'accountGroupsByProject', params: { id: action.id }});
                }
            });
        },
        destroyed() {

        },
        methods : {

        }
    }
</script>
