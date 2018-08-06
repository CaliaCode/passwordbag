<div class="app_breadcrumb">
    <span v-if="$route.name === 'accountGroupList'">ACCOUNTS</span>
    <span v-if="$route.name === 'categories'">CATEGORIES</span>
    <span v-if="$route.name === 'accountGroupsByProject'">ACCOUNT GROUPS BY PROJECT</span>
    <span v-if="$route.name === 'projects'">PROJECTS</span>
    <span v-if="$route.name === 'projectsByClient'">PROJECTS BY CLIENT</span>
    <span v-if="$route.name === 'clients'">CLIENTS</span>
    <span v-if="$route.name === 'users'">USERS</span>
    <span v-if="$route.name === 'settings'">SETTINGS</span>
</div>