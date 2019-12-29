
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
            <li class="active"> Master Rekening </li>
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
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Akun Rekening</span>
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
                        <div class="widget-body">
                            <div class="table-responsive">
                                <div id="error_load_table" style="display: none;">
                                    <div class="alert alert-block alert-danger">
                                        <i class="ace-icon fa fa-times red"> </i>&nbsp;<span id="error_load_table_text"></span>
                                    </div>
                                </div>

                                <table id="tableGroupAccounts" style="font-size: 12px; width: 100%;" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Kode Perusahaan</th>
                                            <th>Kode</th>
                                            <th>Nama Rekening</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
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

    <div class="modal fade" id="modalViewGroups" role="dialog">
        <div class="modal-dialog">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Akun Mata Anggaran</h4>
                </div>
                <div class="modal-body" style="padding:15px 50px;">
                	<div class="widget-box">
						<div class="widget-header widget-header-flat">
                            <i class="ace-icon fa fa-check bigger-110 green"></i>
							<h5 class="widget-title">Grup Rekening</h5>
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
    									<h4><small>No. Rekening</small></h4>
    								</div>
    								<div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtAccno"></span></small></h4>
									</div>
								</div>

                                <div class="row">
									<div class="col-xs-5 col-sm-4 col-lg-4">
    									<h4><small>Nama</small></h4>
    								</div>
    								<div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtName"></span></small></h4>
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
    									<h4><small>Pembentukkan</small></h4>
    								</div>
    								<div class="col-xs-7 col-sm-8 col-lg-8">
                                        <h4><small>: <span id="txtUpdatedAt"></span></small></h4>
									</div>
								</div>

                                <div class="row">
									<div class="col-xs-5 col-sm-4 col-lg-4">
    									<h4><small>Pembaharuan</small></h4>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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

    <script src="{{ url('/assets/epad/pengaturan/mataanggaran/grup-akun.js') }}"></script>
@endpush

@push('scripts')
<script>
    var company_id = "{!! session('company_id') !!}";
    var pages      = 'show';
</script>
@endpush