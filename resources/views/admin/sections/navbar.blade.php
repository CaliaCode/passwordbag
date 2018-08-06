<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">

        {{--=== TOOGLE SideBar ===--}}
        <ul class="nav navbar-nav navbar-left app_toggle-sidebar">
            <li>
                <a @click.prevent="toggleSideMenu()">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>

        {{-- LOGO
        =======================================================--}}
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/admin') }}">
                <span class="app_logo-sm"><img src="{{ asset(config('settings.app_logo_mini')) }}" alt="PasswordBag"></span>
                <span class="app_logo-lg"><img src="{{ asset(config('settings.app_logo')) }}" alt="PasswordBag"></span>
            </a>
        </div>

        {{-- NAVIGATION RIGHT
        =======================================================--}}
        <ul class="nav navbar-nav navbar-right">

            {{-- mode FULLSCREEN --}}
            <li>
                <a @click.prevent="toggleFullScreen()">
                    <i class="fa fa-expand"></i>
                </a>
            </li>
            {{-- USER --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle app_navbar-user" data-toggle="dropdown" role="button" aria-expanded="false">
                    <img src="{{ asset( 'public/' . Auth::user()->userInfo->avatar) }}" alt="User Picture">
                </a>
                <ul class="dropdown-menu app_user-options" role="menu">

                    {{-- edit PROFILE --}}
                    <li class="app_user-settings">
                        <a @click.prevent="profileEdit({{ Auth::user()->id }})">
                            <i class="fa fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>

                    {{-- change PASSWORD --}}
                    <li class="app_user-password">
                        <a @click.prevent="passwordEdit({{ Auth::user()->id }})">
                            <i class="fa fa-key"></i>
                            <span>Password</span>
                        </a>
                    </li>

                    {{-- LOGOUT --}}
                    <li class="app_user-logout">
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>