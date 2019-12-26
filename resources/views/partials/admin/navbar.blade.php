<!-- HEADER -->
<div id="navbar" class="navbar navbar-default ace-save-state">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>
    
                <span class="icon-bar"></span>
    
                <span class="icon-bar"></span>
    
                <span class="icon-bar"></span>
            </button>
            
            <div class="navbar-header pull-left">
                <a href="{{ url('/') }}" class="navbar-brand">
                    {{-- <img src="https://brisim.bri.co.id/assets/images/logo/logo_brisim_H_white.png" height="25" width="100" alt="Home"> --}}
                </a>
            </div>
            
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav" style="">
                    <li class="orange dropdown-modal" id="notif_dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="c_notif_badge">
                            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                        </a>
                        <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i> 
                                0 Notif belum dibaca
                            </li>
                        </ul>
                    </li>
    
                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle" aria-expanded="false"> 
                            <span class="user-info"> <small>Selamat Datang,</small> {{ auth()->user()->name }} </span>
                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>
                        
                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="javascript:void(0)"> <i class="ace-icon fa fa-user"></i> Profil </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ url('/logout') }}"> <i class="ace-icon fa fa-power-off"></i> Keluar</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- HEADER -->