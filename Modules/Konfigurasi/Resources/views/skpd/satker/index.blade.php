@extends('layouts.admin')

@section('title', 'Satuan Kerja')

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon active"></i> <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li>
                <a href="javascript:void(0)"> Konfigurasi </a>
            </li>
            <li class="active"> Satuan Kerja </li>
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
                Konfigurasi
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Satuan Kerja</span>
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
                            <h6 class="widget-title">Tabel Satuan Kerja</h6>

                            <div class="widget-toolbar">
                                <a href="{{ url('konfigurasi/skpd/bidang') }}" class="btn btn-xs btn-light">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <!-- Table -->
                            <div class="table-responsive">
                                <div id="error_load_table" style="display: none;">
                                    <div class="alert alert-block alert-danger">
                                        <i class="ace-icon fa fa-times red"> </i>&nbsp;<span id="error_load_table_text"></span>
                                    </div>
                                </div>

                                <table id="tabelBidangSatuanKerja" style="font-size: 12px; width: 100%;" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Perusahaan</th>
                                            <th>Urusan</th>
                                            <th>BIDANG</th>
                                            <th>KODE</th>
                                            <th>NAMA SATKER</th>
                                            <th>STATUS</th>
                                            <th>LIHAT</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalView" role="dialog">
        <div class="modal-dialog">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Satuan Kerja</h4>
                </div>
                <div class="modal-body" style="padding:15px 50px;">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <i class="ace-icon fa fa-check bigger-110 green"></i>
                            <h5 class="widget-title">SATKER <span id="txtJudulAkun"></span></h5>
                        </div>

                        <div class="widget-body" style="overflow:auto">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Kode Korporasi</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtCompanyID"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Urusan</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtUrusan"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Bidang</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtBidang"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Kode</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="kodeBidang"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Nama</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtNama"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Status</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtStatus"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Pembaharuan</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtUpdatedAt"></span></small></h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 col-sm-4 col-lg-4">
                                        <h4><small>Pembentukkan</small></h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtCreatedAt"></span></small></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    {{-- <button id="btn-edit" data-id="" class="btn btn-xs btn-primary pull-left">
                        <i class="ace-icon fa fa-pencil"></i>
                        <span class="bigger-110">Pembaharuan</span>
                    </button>
                    <button id="btn-delete" data-id="" class="btn btn-xs btn-danger pull-left">
                        <i class="ace-icon glyphicon glyphicon-trash"></i>
                        <span class="bigger-110">Hapus</span>
                    </button> --}}

                    <button class="btn btn-xs btn-default pull-right"  data-dismiss="modal">
                        <span class="bigger-110">Kembali</span>
                        <i class="ace-icon fa fa-times icon-on-right"></i>
                    </button>
                </div>
            </div>
                <!-- Modal content-->
        </div>
    </div>
@endsection


@push('scripts')
    <!-- Jquery js-->
    <script src="{{ url('/assets/js/jquery-2.1.4.min.js') }}"></script>

    <script src="{{ url('/assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/ace.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.ui.touch-punch.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery-ui.custom.min.js') }}"></script>

    <script src="{{ url('/assets/js/spin.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/bootbox.js') }}"></script>

    <script src="{{ url('/assets/epad/base.js') }}"></script>

    <script src="{{ url('/assets/epad/konfigurasi/skpd/skpd-satker.js') }}"></script>
@endpush

@push('scripts')
<script>
    var pages      = 'show';
    var company_id = '{!! $company_id !!}';
    var urusan_id  = {{ $urusan_id }};
    var bidang_id  = {{ $bidang_id }};
</script>
@endpush