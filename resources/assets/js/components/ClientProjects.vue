<template>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group" v-if="client">
                <li class="list-group-item">
                    <h5>Company Name</h5>
                    <span>{{ client.company }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Email</h5>
                    <span>{{ client.email }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Phone</h5>
                    <span>{{ client.phone }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Mobile</h5>
                    <span>{{ (client.mobile)? client.mobile : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Website</h5>
                    <span>{{ (client.website)? client.website : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Vat Number</h5>
                    <span>{{ (client.vat_number)? client.vat_number : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Country</h5>
                    <span>{{ (client.country)? client.country : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Province</h5>
                    <span>{{ (client.province)? client.province  : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Address</h5>
                    <span>{{ (client.address)? client.address : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Zip Code</h5>
                    <span>{{ (client.zip_code)? client.zip_code : '--' }}</span>
                </li>
                <li class="list-group-item">
                    <h5>Created By</h5>
                    <span>{{ client.user.name }}</span>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="app_content-actions">
                <a href="#" class="app_actions-project btn btn-default" role="button"  data-action-type="create" data-from="table">
                    <i class="fa fa-user-plus"></i>Create Project
                </a>
            </div>
            <div class="app_content-datatable panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title">Projects</h3>
                        </div>
                        <div class="app_content-heading-search col-md-6">
                            <div>
                                <i class="fa fa-search"></i>
                                <input type="text" id="app_content-table-search">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
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
    </div>
</template>

<script type="text/babel">
    // Routes
    import router       from './../routes';

    module.exports = {
        name: 'client-projects',
        props: [],
        components: {

        },
        data : function () {
            return {
                client: null
            }

        },

        beforeCreate()
        {
            let self = this;

            this.$http.get('client/' + this.$route.params.id).then((response) => {

                self.$set(self.$data, 'client', response.body);
                console.log(response.body);
            },
            (response) => {
                noty({
                    text: 'It was not possible retrieve the Client.',
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

            let route = window.baseUrl + '/projects/all/' + this.$route.params.id;

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
                    ajax: route,
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
        computed: {  // Computed Properties

        },
        watch: { // Watchers

        },
        methods : { // Methods

        }
    }
</script>
