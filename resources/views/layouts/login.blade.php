
<!DOCTYPE html>
<html lang="en">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="twitter:description" content="Pajak Asli Daerah Integrasi Bank BRI">

    <!-- Meta -->
    <meta name="description" content="Pajak Asli Daerah Integrasi Bank BRI">
    <meta name="author" content="Indonusamedia">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') - Pendapatan Asli Daerah Secara Elektronik</title>

    <!-- bootstrap & fontawesome -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- text fonts -->
    <link href="{{ url('assets/css/fonts.googleapis.com.css') }}" rel="stylesheet">
    
    <!-- ace styles -->
    <link href="{{ url('assets/css/ace.min.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/spiner-load.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/ace-rtl.min.css') }}" rel="stylesheet">

   
    @stack('css')

    @stack('stylesheet')

    @stack('js')

    @stack('scripts')

    <script>
        var baseUrl = '{!! url('/') !!}';
    </script>

    @yield('content')
</html>
