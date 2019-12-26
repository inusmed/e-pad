
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="twitter:description" content="Pajak Asli Daerah Integrasi Bank BRI">

        <!-- Meta -->
        <meta name="description" content="Pajak Asli Daerah Integrasi Bank BRI">
        <meta name="author" content="Indonusamedia">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title') - Pendapatan Asli Daerah</title>

        <!-- bootstrap & fontawesome -->
        <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/css/jquery.gritter.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/css/chosen/chosen.css') }}" rel="stylesheet">

        <!-- text fonts -->
        <link href="{{ url('assets/css/fonts.googleapis.com.css') }}" rel="stylesheet">

        <!-- ace styles -->
        <link href="{{ url('assets/css/ace.min.css') }}" rel="stylesheet">

        <!--[if lte IE 9]>
            <link rel="stylesheet" href="assets/css/ace-part2.min.css" />
        <![endif]-->
        <link href="{{ url('assets/css/ace-part2.min.css') }}" rel="stylesheet" class="ace-main-stylesheet">
        <link href="{{ url('assets/css/ace-skins.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/css/ace-rtl.min.css') }}" rel="stylesheet">
        
        <link href="{{ url('assets/css/ace-ie.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/css/spin.css') }}" rel="stylesheet">
        <link href="{{ url('assets/css/epad.min.css') }}" rel="stylesheet">
    
        @stack('css')

        @stack('stylesheet')

        @stack('js')

        @stack('scripts')

        <script>
            var baseUrl = '{!! url('/') !!}';
            var baseApiUrl = '{!! url('/') !!}/api/v1';
        </script>
        <style>
            @keyframes nodeInserted{from{outline-color:#fff}to{outline-color:#000}}@-moz-keyframes nodeInserted{from{outline-color:#fff}to{outline-color:#000}}@-webkit-keyframes nodeInserted{from{outline-color:#fff}to{outline-color:#000}}@-ms-keyframes nodeInserted{from{outline-color:#fff}to{outline-color:#000}}@-o-keyframes nodeInserted{from{outline-color:#fff}to{outline-color:#000}}.ace-save-state{animation-duration:10ms;-o-animation-duration:10ms;-ms-animation-duration:10ms;-moz-animation-duration:10ms;-webkit-animation-duration:10ms;animation-delay:0s;-o-animation-delay:0s;-ms-animation-delay:0s;-moz-animation-delay:0s;-webkit-animation-delay:0s;animation-name:nodeInserted;-o-animation-name:nodeInserted;-ms-animation-name:nodeInserted;-moz-animation-name:nodeInserted;-webkit-animation-name:nodeInserted}
        </style>
    </head>

    <body class="no-skin">
        <div style="display: none; height: 100%; width: 100%;" id="spinner-preview"></div>
        @include('partials.admin.navbar')
        
        <div class="main-container ace-save-state">
            <script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
            @include('partials.admin.sidebar')

            <div class="main-content">
                <div class="main-content-inner">
                    @yield('content')
                </div>
            </div>
            @include('partials.admin.footer')
        </div>
    </body>
</html>