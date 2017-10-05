<!-- Scripts -->
<script src="{{ asset('assets/admin/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/fastclick/fastclick.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
@yield('admin.additional_script')
<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
</script>