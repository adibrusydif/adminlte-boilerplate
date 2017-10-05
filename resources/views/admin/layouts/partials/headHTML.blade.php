<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }}</title>

<!-- Styles -->
<link href="{{ asset('assets/admin/css/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/css/AdminLTE.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/css/skins/_all-skins.min.css') }}" rel="stylesheet">
@yield('admin.additional_style')