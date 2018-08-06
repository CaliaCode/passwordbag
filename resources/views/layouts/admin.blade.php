<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Chrome Extension -->
        <meta name="chrome-extension" content="no">

        <title>{{ config('settings.title', 'PasswordBag') }}</title>

        <!-- Styles -->
        <link class="app_theme_color" href="{{ asset('public/css/app_' . config('settings.theme_color') . '.css') }}" rel="stylesheet">

        <!-- DataTables Style -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.1.2/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">

        @stack('styles')

        <!-- CSRF and Base URL -->
        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
            ]); ?>;

            window.baseUrl = "<?php echo url()->current(); ?>";
        </script>
    </head>
    <body>
        <div id="app" :class="{app_toggle: toggle}">
            {{-- Put Modals here --}}
            <div class="modal fade" id="app_modal" role="dialog" ></div>

            {{-- Include Navbar --}}
            @include('admin.sections.navbar')

            {{-- Include Sidebar Main Navigation --}}
            @include('admin.sections.sidebar')

            <div class="app_main">

                {{-- Include BreadCrumb --}}
                @include('admin.sections.breadcrumb')

                <div class="container-fluid">

                    {{-- Put Main Content here --}}
                    <router-view></router-view>

                </div>

            </div>

            {{-- Include Footer --}}
            @include('admin.sections.footer')
        </div>

        <!-- Scripts -->
        <script src="{{  asset('public/js/app.js') }}"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.1.2/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
        <script src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.min.js')  }}"></script>

    </body>
</html>
