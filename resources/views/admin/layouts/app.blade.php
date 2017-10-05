<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @section('admin.headHTML')
        @include('admin.layouts.partials.headHTML')
    @show
    {{--<link rel='icon' href='https://bounche.com/assets/img/favicon.png' />--}}
</head>
<body class="skin-green sidebar-mini">
    {{--<div id="app">--}}
        <div class="wrapper">
        @include('admin.layouts.partials.mainheader')

        @include('admin.layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

            @include('admin.layouts.partials.contentheader')

            <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    @yield('admin.main-content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            @include('admin.layouts.partials.controlsidebar')

            @include('admin.layouts.partials.footer')
        </div>
    @section('admin.script')
        @include('admin.layouts.partials.script')
    @show
</body>
</html>
