<aside class="app_sidebar">
    <a class="app_toggle-sidebar-menu" @click.prevent="toggle = !toggle">
        <i class="fa fa-times"></i>
    </a>
    <ul class="app_sidebar-menu">
        <li class="app_sidebar-menu-title">
            <span>Main Navigation</span>
        </li>
        <li class="app_sidebar-menu-item">
            <router-link :to="{ name: 'accountGroupList'}" v-on:click="toggle = false">
                <i class="fa fa-key"></i>
                <span>Accounts</span>
            </router-link>
        </li>
        @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))
            <li class="app_sidebar-menu-item">
                <router-link :to="{ name: 'categories'}">
                    <i class="fa fa-tags"></i>
                    <span>Categories</span>
                </router-link>
            </li>
        @endif
        <li class="app_sidebar-menu-item">
            <router-link :to="{ name: 'projects'}">
                <i class="fa fa-tasks"></i>
                <span>Projects</span>
            </router-link>
        </li>
        @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))
            <li class="app_sidebar-menu-item">
                <router-link :to="{ name: 'clients'}">
                    <i class="fa fa-address-book-o"></i>
                    <span>Clients</span>
                </router-link>
                </a>
            </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
            <li class="app_sidebar-menu-item">
                <router-link :to="{ name: 'users'}">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                </router-link>
            </li>
            <li class="app_sidebar-menu-item">
                <router-link :to="{ name: 'settings'}">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </router-link>
            </li>
        @endif
        <li class="app_sidebar-menu-item">
            <a target="_blank" href="https://chrome.google.com/webstore/detail/passwordbag/bmmoclbhanofkpigeaahcbjbldmlnglf?utm_source=chrome-ntp-icon">
                <i class="fa fa-chrome"></i>
                <span>Extension</span>
            </a>
        </li>
        <li class="app_sidebar-menu-item">
            <a target="_blank" href="http://www.caliacode.com/passwordbag/documentation">
                <i class="fa fa-book"></i>
                <span>Documentation</span>
            </a>
        </li>
    </ul>
</aside>