@extends('layouts.login')

@section('title', 'e-PAD')

@section('content')
<body class="login-layout light-login">
    <div style="display: none; height: 100%; width: 100%;" id="spinner-preview"></div>
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2" style="padding: 8vh 4vh;">
                    <div class="login-container">
                        <div class="center">
                            {{-- <h1>
                                <i class="ace-icon fa fa-bar-chart-o  orange"></i>
                                <strong><span class="blue">e-</span></strong>
                                <span class="orange" style="margin-left: -8px;">PAD</span>
                            </h1> --}}
                            <img src="{{ url('assets/images/logo/logo-karo.gif') }}" height="120" width="150" alt="Home">
                            <h4 class="blue" id="id-company-text">(e-PAD) <br>Elektronik SIM Pendapatan Asli Daerah</h4>
                        </div>

                        <div class="space-6"></div>
                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">									
                                <div class="widget-body">									
                                    <div class="widget-main">
                                        <h5 class="header blue lighter smaller">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-110 orange"></i>
                                            Informasi Login
                                        </h5>
                                        <form id="form-login">
                                            <fieldset>
                                                <div class="form-group" id="form-email">
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" placeholder="email / username" name="email" id="email" value="andriyanto@indonusamedia.co.id" required autocomplete="off">
                                                            <i class="ace-icon fa fa-user" style="margin-right: 5px;"></i>
                                                        </span>
                                                    </label>
                                                </div>
                                                
                                                <div class="form-group" id="form-password">
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="Kata Sandi" name="password" id="password" value="password" required="" autocomplete="off">
                                                            <i class="ace-icon fa fa-lock" style="margin-right: 5px;"></i>
                                                        </span>
                                                    </label>
                                                </div>	
                                                
                                                <div class="form-group" id="form-captcha">
                                                    <div style="display: flex">
                                                        <div style="flex: 3;">
                                                            <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Captcha" value="" maxlength="6/" autocomplete="off">
                                                        </div>
                                                        
                                                        <div style="flex: 1;">
                                                            <a href="javascript:void(0);" class="refreshCaptcha">
                                                                <img src="{{ url('assets/images/icons/refresh.png') }}" style="padding:5px 0 0 5px" alt="load">
                                                            </a>
                                                        </div>
                                                            
                                                        <div style="flex: 1;">
                                                            <p id="captImg">
                                                                {!! captcha_img('flat') !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div id="error_div" style="display: none;">
                                                    <div class="alert alert-block alert-danger">                                							
                                                        <i class="ace-icon red"> </i> <span id="error_text"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="space-8"></div>
                                                <div class="clearfix">
                                                    <label class="inline">
                                                        <input type="checkbox" class="ace" id="remember" name="remember">
                                                        <span class="lbl"> <small>Remember Me</small></span>
                                                    </label>
                                                    
                                                    <button type="submit" class="width-35 pull-right btn btn-sm btn-primary" id="btn-login">
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="smaller-110">Login</span>
                                                    </button>
                                                </div>													
                                            </fieldset>
                                        </form>

                                        <div class="space-8"></div>
                                        <h6 class="header blue lighter smaller">
                                            <a id="id-btn-dialog2" href="#">													
                                                Lupa Password ?
                                            </a>
                                        </h6>
                                    </div>	
                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->
                        </div><!-- /.position-relative -->
                        <br>
                        <div class="center">
                            <font color="#fff" size="1.5px">
                                Badan Pengelolaan Keuangan Pendapatan Daearah Kabupaten Karo <br>
                                Copyright © 2019 Indonusamedia Powered Bank Rakyat Indonesia, Tbk
                            </font>
                        </div>

                        <div id="pageSpinner" style="display: none;">
                            <div id="page-spinner-login" style="display: none;">Proses Login...</div>
                        </div>
                    </div>
                </div><!-- /.col -->
                
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div>
    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{ url('/assets/js/jquery-2.1.4.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.backstretch.min.js') }}"></script>

    <script src="{{ url('/assets/js/spin.js') }}"></script>

    <script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>

    <script src="{{ url('/assets/epad/auth/login.js') }}"></script>

    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $("body").backstretch([
                "assets/images/backgrounds/bg_login_4.jpg",
                "assets/images/backgrounds/bg_login_5.jpg",
                "assets/images/backgrounds/bg_login_3.jpg",
                "assets/images/backgrounds/bg_login_2.jpg",
                "assets/images/backgrounds/bg_login_1.jpg",
			],{duration:8000,fade:750});
    </script>
</body>
@endsection

@push('stylesheet')
<link href="{{ url('assets/css/sweetalert.css') }}" rel="stylesheet">
@endpush