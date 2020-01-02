

@extends('layouts.admin')

@section('title', 'Master Tarif Omzet')

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
            
            <li class="active"> Tarif Omzet </li>
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
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Tarif Omzet</span>
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
                <div class="col-sm-12 fixWidth">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group" style="margin-top: 5px;">
                                <div class="col-sm-2">
                                    <label class=" control-label no-padding-right grey" for="label_personal_number" style="width: auto"> Jenis Pendapatan  </label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" id="jenis_pendapatan" readonly="readonly" class="form-control search-query" placeholder="Jenis Pendapatan">
                                        <span class="input-group-btn">
                                            <button type="button" id="btn-jenis-pendapatan" class="btn btn-inverse btn-white">
                                                <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                Pencarian
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-10"></div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 widget-container-col ui-sortable" id="widget-container-col-12">
                    <div class="widget-box widget-color-dark light-border">

                        <div class="widget-header">
                            <h6 class="widget-title">Daftar Tarif Omzet</h6>

                            <div class="widget-toolbar">
                                <a href="{{ url('pengaturan/tarif-omzet/create') }}" class="btn btn-xs btn-danger bigger">
                                    <i class="ace-icon fa fa-plus"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>

                        <div class="widget-body" id="tarif-content">
                            <!-- Table -->
                            <div class="table-responsive">
                                <div id="error_load_table" style="display: none;">
                                    <div class="alert alert-block alert-danger">
                                        <i class="ace-icon fa fa-times red"> </i>&nbsp;<span id="error_load_table_text"></span>
                                    </div>
                                </div>
                                
                                <table id="tabelTarifOmzet" style="font-size: 12px; width: 100%;display:none;" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tarif</th>
                                            <th>Grup</th>
                                            <th>Tarif</th>
                                            <th>Persen</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewJenisPendapatan" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Akun Jenis Pendapatan</h4>
                </div>
                <div class="modal-body" style="padding:10px 10px;">
                    <table id="tabelJenisPendapatan" style="font-size: 12px; width: 100%;" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Jenis Pendapatan</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <input type="hidden" id="company_id" value="">
                    <input type="hidden" id="kategori_pajak" value="">
                    <input type="hidden" id="reff_pajak" value="">
                    <input type="hidden" id="akun_grup" value="">
                    <input type="hidden" id="akun_kategori" value="">
                    <input type="hidden" id="akun_subkategori" value="">
                    <input type="hidden" id="akun_subrekening" value="">
                    <input type="hidden" id="akun_rekening" value="">
                    <input type="hidden" id="akun_id" value="">
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

    <script src="{{ url('/assets/js//chosen.jquery.min.js') }}"></script>

    <script src="{{ url('/assets/js/chosen.ajaxaddition.jquery.js') }}"></script>

    <script src="{{ url('/assets/js/spin.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ url('/assets/js/bootbox.js') }}"></script>

    <script src="{{ url('/assets/js/jquery.gritter.min.js') }}"></script>

    <script src="{{ url('/assets/epad/base.js') }}"></script>

    <script src="{{ url('/assets/epad/pengaturan/jenis-pendapatan/tarif-omzet.js') }}"></script>
@endpush

@push('scripts')
<script>
    var pages      = 'show';
</script>
@endpush