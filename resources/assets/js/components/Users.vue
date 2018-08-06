<template>
    <div>
        <div class="app_content-actions">

            <!--=== Create User Button ===-->
            <a href="#" class="app_actions-user btn btn-default" role="button" data-action-type="create"
               data-from="table">
                <i class="fa fa-user-plus"></i>Create User
            </a>
        </div>
        <div class="app_content-datatable panel panel-default">
            <div class="panel-heading">
                <div class="row">

                    <!--=== Title ===-->
                    <div class="col-md-6">
                        <h3 class="panel-title">Users</h3>
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

                <!--=== Users Table ===-->
                <table id="app_users-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Full Name</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
        module.exports = {
        name: 'users',
        data : function() {
            return {

            }
        },
        created() {

        },
        mounted() {

            // Retrieve Users
            window.dataTable = $('#app_users-table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: '<rt><"row"<"col-md-6"i><"col-md-6"p>>',
                order: [[ 1, "desc" ]],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                ajax: window.baseUrl + '/users/all',
                columns: [
                    {data: 'actions', name: 'actions', "orderable": false, searchable: false},
                    {data: 'name', name: 'users.name'},
                    {data: 'email', name: 'users.email'},
                    {data: 'status', name: 'users.status'},
                    {data: 'full_name', name: 'user_infos.first_name'}
                ]
            });

            $("#app_content-table-search").on("keyup search input paste cut", function () {
                dataTable.search(this.value).draw();
            });

        },
        destroyed() {

        },
        methods : {

        }
     }
</script>
