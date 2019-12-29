@extends('layouts.admin')

@section('title', 'Master Rekening')

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
                <a href="{{ url('pengaturan/mata-anggaran/grup') }}"> Master Rekening </a>
            </li>
            <li class="active"> Kategori </li>
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
                Master Rekening
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Tambah Kategori Rekening</span>
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

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 widget-container-col ui-sortable" id="widget-container-col-12">
                    <div class="widget-box widget-color-dark light-border">
                        <div class="widget-header">
                            <h6 class="widget-title">Tambah Kategori Rekening</h6>

                            <div class="widget-toolbar">
                                <a href="{{ url()->previous() }}" class="btn btn-xs btn-light">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    Kembali
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

                                    <div class="space-10"></div>

                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Korporasi </label>
                                            <div class="col-sm-9">
                                                <input type="text" id="company_id" placeholder="Kode Korporasi" class="col-xs-12 col-sm-12 col-lg-3" value="{{ $company_id }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Rekening Utama </label>
                                            <div class="col-sm-9">
                                                <select id="txtRekUtama" class="chosen-select form-control" style="width:350px;" data-placeholder="Pilih Rekening Utama"></select>
                                            </div>
                                        </div>

                                        <div id="form-id" class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nomor Akun </label>
                                            <div class="col-sm-9">
                                                <input type="text" id="id" placeholder="Account Number" class="col-xs-12 col-sm-12 col-lg-6" readonly autocomplete="off">
                                            </div>
                                        </div>

                                        <div id="form-nama" class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Rekening </label>
                                            <div class="col-sm-9">
                                                <input type="text" id="nama" placeholder="Nama Rekening" class="col-xs-12 col-sm-12 col-lg-9" autocomplete="off">
                                            </div>
                                        </div>

                                        <div id="form-status" class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status </label>
                                            <div class="col-sm-9">
                                                <div class="radio">
                                                    <label>
                                                        <input name="status" id="aktif" type="radio" class="ace" value="1" checked>
                                                        <span class="lbl"> Aktif</span>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input name="status" id="nonaktif" type="radio" class="ace" value="0">
                                                        <span class="lbl"> Non Aktif</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a href="{{ url()->previous() }}" class="btn">
                                                <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                                                Batal
                                            </a>
                                            &nbsp;&nbsp;
                                            <button  id="btn-submit-create" class="btn btn-info" type="button">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Simpan
                                            </button>
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

@push('stylesheet')

@endpush

@push('scripts')
    <!-- Jquery js-->
   <script src="{{ url('/assets/js/jquery-2.1.4.min.js') }}"></script>

   <script type="text/javascript">
       if('ontouchstart' in document.documentElement) document.write("<script src='https://andriyanto.me/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
   </script>

    <script src="{{ url('/assets/js/jquery.mobile.custom.min.js') }}"></script>

    <script src="{{ url('/assets/js//chosen.jquery.min.js') }}"></script>

    <script src="{{ url('/assets/js/chosen.ajaxaddition.jquery.js') }}"></script>

    <script src="{{ url('/assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery-ui.custom.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.ui.touch-punch.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace-elements.min.js') }}"></script>

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

    <script src="{{ url('/assets/epad/pengaturan/mataanggaran/kategori-akun.js') }}"></script>
@endpush

@push('scripts')
<script>
    var pages      = 'create';
    var company_id = '{!! $company_id !!}';
    var grup_id   = {!! $grup_id !!};
</script>
@endpush