@extends('layouts.admin')

@section('title', 'Data Pegawai')

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
            <li class="active"> Data Pegawai </li>
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
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Data Pegawai</span>
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
                            <h6 class="widget-title">Daftar Pegawai</h6>
                        </div>

                        <div class="widget-body">
                            <!-- Table -->
                            <div class="table-responsive">
                                <div id="error_load_table" style="display: none;">
                                    <div class="alert alert-block alert-danger">
                                        <i class="ace-icon fa fa-times red"> </i>&nbsp;<span id="error_load_table_text"></span>
                                    </div>
                                </div>

                                <table id="tabelDaftarPegawai" style="font-size: 12px; width: 100%;" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NIP</th>
                                            <th>NAMA PEGAWAI</th>
                                            <th>JABATAN</th>
                                            <th>USERID</th>
                                            <th>STATUS</th>
                                            <th>LIHAT</th>
                                            <th>AKSI</th>
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

    <script src="{{ url('/assets/epad/konfigurasi/pegawai.js') }}"></script>
@endpush

@push('scripts')
<script>
    var pages      = 'show';
    var company_id = "{!! session('company_id') !!}"
</script>
@endpush