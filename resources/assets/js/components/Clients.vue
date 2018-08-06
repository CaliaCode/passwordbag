<template>
    <div>
        <!--=== Create Client Button ===-->
        <div class="app_content-actions">
            <a href="#" class="app_actions-client btn btn-default" role="button"  data-action-type="create" data-from="table">
                <i class="fa fa-user-plus"></i>Create Client
            </a>
        </div>
        <div class="app_content-datatable panel panel-default">
            <div class="panel-heading">
                <div class="row">

                    <!--=== Title ===-->
                    <div class="col-md-6">
                        <h3 class="panel-title">Clients</h3>
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

                <!--=== Clients Table ===-->
                <table id="app_clients-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created by</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    module.exports = {
        name: 'clients',
        data : function() {
            return {

            }
        },
        created() {

        },
        mounted() {
            let self = this;

            this.$nextTick(function(){
                // Set DataTable
                window.dataTable = $('#app_clients-table').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    dom: '<rt><"row"<"col-md-6"i><"col-md-6"p>>',
                    order: [[ 1, "desc" ]],
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    ajax: window.baseUrl + '/clients/all',
                        columns: [
                        {data: 'actions',   name: 'actions', orderable: false, searchable: false},
                        {data: 'company',   name: 'clients.company'},
                        {data: 'email',     name: 'clients.email'},
                        {data: 'phone',     name: 'clients.phone'},
                        {data: 'name',      name: 'users.name'}
                    ]
                });

                // Set DataTable search
                $("#app_content-table-search").on("keyup search input paste cut", function () {
                    dataTable.search(this.value).draw();
                });
            });

            // Go to the projects of the selected client
            $('body').on('click', '.app_actions-client', function (e) {
                e.preventDefault();

                var action = {};
                action.id = $(this).data('id');
                action.actionType = $(this).data('action-type');
                action.from = $(this).data('from');

                if(action.actionType === 'view-related'){
                    self.$router.push({ name: 'projectsByClient', params: { id: action.id }});
                }
            });
        },
        destroyed() {

        },
        methods : {

        }
    }
</script>
