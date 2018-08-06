// System
import Vue                  from 'vue';
import VueRouter            from 'vue-router';

// Components
import AccountGroupList     from './components/accountgrouplist.vue';
import Categories           from './components/categories.vue';
import Clients              from './components/clients.vue';
import ClientProjects       from './components/clientprojects.vue';
import Projects             from './components/projects.vue';
import Users                from './components/users.vue';
import Settings             from './components/settings.vue';

Vue.use(VueRouter);

const routes = [
    { path: window.location.pathname + '/categories', component: Categories, name: 'categories' },
    { path: window.location.pathname + '/projects', component: Projects, name: 'projects' },
    { path: window.location.pathname + '/project/:id', component: AccountGroupList, name: 'accountGroupsByProject' },
    { path: window.location.pathname + '/clients', component: Clients, name: 'clients' },
    { path: window.location.pathname + '/client/:id', component: ClientProjects, name: 'projectsByClient' },
    { path: window.location.pathname + '/users', component: Users, name: 'users' },
    { path: window.location.pathname + '/settings', component: Settings, name: 'settings' },
    { path: window.location.pathname +'/', component: AccountGroupList, name: 'accountGroupList' },
];

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes 
});

module.exports = router;