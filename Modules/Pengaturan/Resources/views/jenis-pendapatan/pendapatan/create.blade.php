

@extends('layouts.admin')

@section('title', 'Tambah Jenis Pendapatan')

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
            <li class="active"> Jenis Pendapatan </li>
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
                    <i class="ace-icon fa fa-angle-double-right"></i><span id="txt_judul"> Tambah Grup Pendapatan</span>
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

            <div class="row" id="form-content" style="display:block">
                <div class="col-xs-12 col-sm-12 col-lg-12 widget-container-col ui-sortable" id="widget-container-col-12">
                    <div class="widget-box widget-color-dark light-border">
                        <div class="widget-header">
                            <h6 class="widget-title">Tambah Jenis Pendapatan</h6>

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
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Korporasi</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                <input id="company_id" type="text" class="form-control" autocomplete="off" value="{{ $company_id }}" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kategori Pajak</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                @foreach($optKategoriTax as $key => $tax)
                                                    <div class="radio">
                                                        <label>
                                                            {{ Form::radio('kategoriPajak', $key , false, array('id'=>'kategoriPajak-'.$key, 'class' =>'kategoriPajak')) }}
                                                            <span class="lbl">{{ $tax }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <br>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Reff. Pajak</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-lg-4">
                                                @foreach($optReffPajak as $key => $tax)
                                                    <div class="radio">
                                                        <label>
                                                            {{ Form::radio('reffPajak', $key , false, array('id'=>'reffPajak-'.$key, 'class' =>'reffPajak')) }}
                                                            <span class="lbl">{{ $tax }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jenis</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                @foreach($optJenisPajak as $key => $tax)
                                                    <label style="margin-right:20px;margin-top:10px;">
                                                        {{ Form::radio('jenisPajak', $key , false, array('id'=>'jenisPajak-'.$key, 'class' =>'jenisPajak')) }}
                                                        <span class="lbl">{{ $tax }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Sub Rekening</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <select id="subrekening_id" class="chosen-select form-control" data-placeholder="Pilih Sub Rekening Dahulu"></select>
                                            </div>

                                            <input type="hidden" id="akun_grup" value="">
                                            <input type="hidden" id="akun_kategori" value="">
                                            <input type="hidden" id="akun_subkategori" value="">
                                            <input type="hidden" id="akun_subrekening" value="">
                                            <input type="hidden" id="akun_rekening" value="">
                                        </div>
                                        <hr>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode Rekening</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                <select id="rekening_id" class="chosen-select form-control" data-placeholder="Pilih Rekening Dahulu"></select>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row" id="form-nama">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Pendapatan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-6 col-xl-4">
                                                <input id="nama" type="text" class="form-control" autocomplete="off" value="">
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row" id="form-kode">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Kode</small></h4>
                                            </div>
                                            <div class="col-xs-8 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                                                <input id="kode" type="text" class="form-control" autocomplete="off" value="" maxlength="2">
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3 col-xl-3">
                                                <h4><small>Metode Hitung</small></h4>
                                            </div>
                                            <div class="col-xs-5 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                                                <select id="metode_hitung" class="chosen-select form-control" data-placeholder="Metode Perhitungan"></select>
                                            </div>

                                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-1 col-xl-1" id="persentaseWrap" style="display:none" >
                                                <input id="persentase" type="number" class="form-control" autocomplete="off" onInput="return percentageCheck(event,value)" min="0" max="100" step="0.01" placeholder="(%)">
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jenis Pelaporan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                @foreach($optPelaporanPajak as $key => $tax)
                                                    <label style="margin-right:20px;margin-top:10px;">
                                                        {{ Form::radio('jenisPelaporan', $key , false, array('id'=>'jenisPelaporan-'.$key, 'class' =>'jenisPelaporan')) }}
                                                        <span class="lbl">{{ $tax }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Metode Penetapan</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6 col-xl-7">
                                                @foreach($optPenetapanPajak as $key => $tax)
                                                    <label style="margin-right:20px;margin-top:10px;">
                                                        {{ Form::radio('jenisPenetapan', $key , false, array('id'=>'jenisPenetapan-'.$key, 'class' =>'jenisPenetapan')) }}
                                                        <span class="lbl">{{ $tax }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row" id="form-jatuh_tempo">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Jatuh Tempo</small></h4>
                                            </div>
                                            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-2 col-xl-2">
                                                <div class="input-group">
                                                    <input id="jatuh_tempo" type="text" class="form-control" autocomplete="off" maxlength="2">
                                                    <span class="input-group-addon">
                                                        Hari
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Rekening Denda</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-8 col-lg-7 col-xl-8">
                                                <div class="input-group">
                                                    <input type="text" id="rekening_denda" readonly="readonly" class="form-control search-query" placeholder="Rekening Denda">
                                                    <span class="input-group-btn">
                                                        <button type="button" id="btn-pencarian-akun-denda" class="btn btn-inverse btn-white">
                                                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                            Pencarian
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-lg-3">
                                                <h4><small>Status</small></h4>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 col-xl-4">
                                                <div class="radio">
                                                    <label>
                                                        <input name="status" id="status" type="radio" class="ace" value="1" checked>
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

    <div class="modal fade" id="modalViewAkunDenda" role="dialog">
        <div class="modal-dialog modal-lg">            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Akun Pendapatan Denda</h4>
                </div>
                <div class="modal-body" style="padding:10px 10px;">
                    <table id="tabelRekeningDenda" style="font-size: 12px; width: 100%;" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>REKENING PENDAPATAN DENDA</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <input type="hidden" id="akun_denda_grup" value="">
                    <input type="hidden" id="akun_denda_kategori" value="">
                    <input type="hidden" id="akun_denda_subkategori" value="">
                    <input type="hidden" id="akun_denda_subrekening" value="">
                    <input type="hidden" id="akun_denda_rekening" value="">
                </div>
            </div>
                <!-- Modal content-->
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
    var pages      = 'create';
    var company_id = '{!! $company_id !!}';
    var grup_id   = 4
    var kategori_id    = 1
    var subkategori_id = 1
</script>
@endpush