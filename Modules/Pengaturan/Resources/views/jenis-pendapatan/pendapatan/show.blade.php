

@extends('layouts.admin')

@section('title', 'Informasi Jenis Pendapatan')

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon active"></i> <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li>
                <a href="javascript:void(0)"> Rekening </a>
            </li>

            <li>
                <a href="{{ url('pengaturan/jenis-pendapatan') }}"> Jenis Pendapatan </a>
            </li>
            <li class="active">Informasi Pendapatan</li>
        </ul>
        <!-- /.breadcrumb -->

        <div class="nav-search" id="nav-search">
            <form class="form-search">
                <span class="input-icon">
                    <input type="text" placeholder="Pencarian ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
            </form>
        </div>
    </div>
    <!-- BREADCRUMB -->


    <div class="page-content">
        <div class="page-header">
            <h1>
                Jenis Pendapatan
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Sunting Jenis Pendapatan</span>
                </small>
            </h1>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="row">
                    <div id="error_div" style="display: none;">
                        <div class="alert alert-block alert-danger">
                            <i class="ace-icon fa fa-times red"> </i>&nbsp;<span id="error_text"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="row" id="form-content" style="display:none">
                <div class="col-xs-12 col-sm-12 col-lg-12 widget-container-col ui-sortable" id="widget-container-col-12">
                    <div class="widget-box widget-color-dark light-border">
                        <div class="widget-header">
                            <h6 class="widget-title">Pendapatan <span id="txt_judul_pendapatan"></span></h6>

                            <div class="widget-toolbar">
                                <a href="{{ url()->previous() }}" class="btn btn-xs btn-light">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <a href="javascript:void(0)" id="btn-hapus" class="btn btn-xs btn-danger bigger">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-horizontal" role="form">
                                    <div id="validation_error" style="display: none;">
                                        <div class="alert alert-block alert-danger">
                                            <span id="validation_error_text"></span>
                                        </div>
                                    </div>

                                    <fieldset>
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Korporasi</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                <h4><small>: <span id="txt_company_id"></span></small></h4>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kategori Pajak</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                <h4><small>: <span id="txt_kategori_pajak"></span></small></h4>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Ketetapan Pajak</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                <h4><small>: <span id="txt_reff_pajak"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jenis</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <h4><small>: <span id="txt_jenis_pajak"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Sub Rekening</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <h4><small>: <span id="txt_sub_rekening"></span></small></h4>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Rekening</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <h4><small>: <span id="txt_rekening"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Pendapatan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-6 col-xl-4">
                                                <h4><small>: <span id="txt_pendapatan"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3 col-xl-3">
                                                <h4><small>Metode Hitung</small></h4>
                                            </div>
                                            <div class="col-xs-5 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                                                <h4><small>: <span id="txt_metode_hitung"></span></small></h4>
                                            </div>

                                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                                                <h4><small>: <span id="txt_persentase"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jenis Pelaporan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <h4><small>: <span id="txt_jenis_pelaporan"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Metode Penetapan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <h4><small>: <span id="txt_jenis_penetapan"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row" id="form-jatuh_tempo">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jatuh Tempo</small></h4>
                                            </div>
                                            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-2 col-xl-2">
                                                <h4><small>: <span id="txt_jatuh_tempo"></span></small></h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Rekening Denda</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-7 col-xl-8">
                                                <h4><small>: <span id="txt_akun_denda"></span></small></h4>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Status</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-xl-4">
                                                <h4><small>: <span id="txt_status"></span></small></h4>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a href="{{ url('pengaturan/jenis-pendapatan') }}" class="btn">
                                                <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                                                Kembali
                                            </a>
                                            &nbsp;&nbsp;

                                            <a href="{{ url('pengaturan/jenis-pendapatan/edit/'.$company_id.'?kategori_pajak_id='.$kategori_pajak_id.'&ketetapan_id='.$ketetapan_id.'&grup_id='.$grup_id.'&kategori_id='.$kategori_id.'&subkategori_id='.$subkategori_id.'&subrekening_id='.$subrekening_id.'&rekening_id='.$rekening_id.'&pendapatan_id='.$pendapatan_id) }}" class="btn btn-info">
                                                <i class="ace-icon fa fa-pencil" class="bigger-120"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <!-- Jquery js-->
   <script src="{{ url('/assets/js/jquery-2.1.4.min.js') }}"></script>

   <script type="text/javascript">
       if('ontouchstart' in document.documentElement) document.write("<script src='http://epad.test/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
   </script>

    <script src="{{ url('/assets/js/jquery.mobile.custom.min.js') }}"></script>

    <script src="{{ url('/assets/js//chosen.jquery.min.js') }}"></script>

    <script src="{{ url('/assets/js/chosen.ajaxaddition.jquery.js') }}"></script>

    <script src="{{ url('/assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery-ui.custom.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.ui.touch-punch.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace-elements.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace.min.js') }}"></script>

    <script src="{{ url('/assets/js/spin.js') }}"></script>

    <script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ url('/assets/js/spinbox.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace-extra.min.js') }}"></script>

    <script src="{{ url('assets/js/cleave.min.js') }}"></script>

    <script src="{{ url('/assets/js/bootbox.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.gritter.min.js') }}"></script>

    <script src="{{ url('/assets/epad/base.js') }}"></script>

    <script src="{{ url('/assets/epad/pengaturan/jenis-pendapatan/pendapatan.js') }}"></script>
@endpush

@push('scripts')
<script>
    var cleaveInstance;
    var pages      = 'get';
    var company_id = '{!! $company_id !!}';
    var kategori_pajak_id = {{ $kategori_pajak_id }};
    var ketetapan_id     = {{ $ketetapan_id }};
    var grup_id        = {{ $grup_id }};
    var kategori_id    = {{ $kategori_id }};
    var subkategori_id = {{ $subkategori_id }};
    var subrekening_id = {{ $subrekening_id }};
    var rekening_id    = {{ $rekening_id }};
    var id             = {{ $pendapatan_id }};
</script>
@endpush