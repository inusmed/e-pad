
var skpd_bidang = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            skpd_bidang.request();

            $('#btn-edit').click(function() {
                var dataid    = $('#data-id').val();
                var companyid = $('#data-company').val();
                var categorid = $('#data-kategori').val();
                var subcategorid = $('#data-subkategori').val();
                var groupid   = $('#data-grup').val();
                
                window.location = baseUrl + '/pengaturan/mata-anggaran/subrekening/' + companyid + '/' + groupid + '/' + categorid + '/' + subcategorid + '/' + dataid + '/edit'
            });

            $('#btn-delete').click(function() {
                $('#modalView').modal('hide');
                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penghapusan Data </h4><hr>\
                        <h5>Apakah anda yakin ingin menghapus data tersebut?</h5>\
                        Penghapusan akun rekening ini akan menghapus turunan rekening dari rekening utama yang anda hapus\
                    </div>",
                    buttons: {
                        confirm: {
                            label: "Setuju",
                            className: "btn-danger btn-sm",
                        },
                        cancel: {
                            label: "Tidak Setuju",
                            className: "btn-primary btn-sm",
                        }
                    },
                    callback: function(isConfirm) {
                        if(isConfirm)
                        {
                            var dataid    = $('#data-id').val();
                            var companyid = $('#data-company').val();
                            var categorid = $('#data-kategori').val();
                            var subcategorid = $('#data-subkategori').val();
                            var groupid   = $('#data-grup').val();
                            
                            $.ajax({
                                type: 'DELETE',
                                url: baseApiUrl + '/pengaturan/mata-anggaran/subrekening',
                                dataType: 'json',
                                data : {
                                    'company_id' : companyid,
                                    'grup_id'    : groupid,
                                    'kategori_id': categorid,
                                    'subkategori_id': subcategorid,
                                    'kodeAkun'   : dataid
                                },
                                headers: {
                                    'Accept' : 'application/json',
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                beforeSend: function(){
                                    Rats.UI.LoadAnimation.start();
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        console.log(responseObject);
                                        if(responseObject.status == true) {
                                            $.gritter.add({
                                                title: 'Penghapusan data berhasil',
                                                text: responseObject.message,
                                                class_name: 'gritter-success gritter-center'
                                            });

                                            $('#tableSubRekening').dataTable().fnDestroy();
                                            skpd_bidang.request();
                                        }
                                    },
                                    401: function() {
                                        UnauthorizedMessages();
                                    },
                                    500: function() {
                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                            class_name: 'gritter-error gritter-center'
                                        });
                                    }
                                },
                                error: function() {
                                    Rats.UI.LoadAnimation.stop(spinner);
                                }
                            });
                        }else {
                            $('#modalView').modal('show');
                        }
                    }
                });
            });
        },

        get: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/mata-anggaran/subrekening/' + company_id + '/' + grup_id + '/' + kategori_id + '/' + subkategori_id + '/' + id +'/get',
                dataType: 'json',
                headers: {
                    'Accept' : 'application/json',
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                statusCode: {
                    200: function(responseObject) {
                        if(responseObject.status == true) {
                            $('#form-content').show()
                            skpd_bidang.groupList(grup_id, kategori_id, subkategori_id);

                            $('#kategori-pajak-'+responseObject.data.kategori_pajak).prop('checked', true);

                            if(responseObject.data.status_id == 1) {
                                $('#status-active').prop("checked", true);
                            }else {
                                $('#status-inactive').prop("checked", true);
                            }
                            
                            $('#id').val(grup_id + '' + kategori_id + '' + subkategori_id + '' + responseObject.data.id)
                            $('#nama').val(responseObject.data.subrekening_nama)

                            skpd_bidang.eventChangeList()

                            var block = skpd_bidang.blocks(grup_id, kategori_id, subkategori_id)
                            cleaveInstance = new Cleave('#id', {
                                delimiters: ['.'],
                                prefix: grup_id + '' + kategori_id + '' + subkategori_id,
                                numericOnly: true,
                                blocks: block
                            });
                        }
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages();
                    }
                },
            });
        },

        request: function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabelBidangSatuanKerja').DataTable( {
                "bInfo": true,
                "bFilter": true,
                "bAutoWidth": true,
                "bSort": true,
                "pageLength": 12,
                "bServerSide": true,
                "responsive": true,
                "aaSorting" : [[1,'asc']],
                'processing': true,
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4]} ],
                "lengthMenu": [ 12, 18, 25, 50, 75, 100 ],
                "ajax" : {
                    type	: 'POST',
                    url		:  baseApiUrl + '/konfigurasi/skpd/bidang/' + company_id,
                    dataType: 'json',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                    },
                    statusCode: {
                        401: function(responseObject) {
                            UnauthorizedMessages()
                        },
                        522: function(responseObject) {
                            $('#tabelBidangSatuanKerja').dataTable().fnDestroy();
                            $('#tabelBidangSatuanKerja').hide();
                            UnAvailableCloudData(JSON.parse(responseObject.responseText).message)
                        }
                    },
                    dataSrc	: function ( response ) {
                        Rats.UI.LoadAnimation.stop(spinner);
                        if(response.data) {
                            return response.data
                        }
                    }
                },
                "columns": [
                    {
                        data: "id", className: "center", "width": "3%",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "company_id", className: "center", "width": "7%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "urusan_nama", className: "left", "width": "8%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "kode", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "nama", className: "left", "width": "20%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "status_nama", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat Bidang "+full['nama']+"'' onclick=bidangRequest('"+full['company_id']+"',"+full['urusan_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat Bidang "+full['nama']+"'' onclick=bidangRequest('"+full['company_id']+"',"+full['urusan_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            
                            if(full['status'] == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='javascript:void(0)' style='cursor:pointer' data-rel='tooltip' title='Akun "+full['nama']+"' class='disabled btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='"+baseUrl+"/konfigurasi/skpd/satuan-kerja/"+full['company_id']+"/"+full['urusan_id']+"/"+full['id']+"' style='cursor:pointer' data-rel='tooltip' title='Bidang "+full['nama']+"' class='btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                        }
                    },
                ]
            });
        },
    };
}();

function bidangRequest(company_id, urusan_id, id)
{    
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/konfigurasi/skpd/bidang/' + company_id + '/' + urusan_id + '/' + id + '/get',
        dataType: 'json',
        headers: {
            'Accept' : 'application/json',
            'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
        },
        beforeSend:function() {
            spinner = Rats.UI.LoadAnimation.start();
        },
        statusCode: {
            200: function(responseObject) {
                if(responseObject.status == true) {
                    $('#txtJudulAkun').text(responseObject.data.nama);
                    $('#txtCompanyID').text(responseObject.data.company_id);
                    $('#txtUrusan').text(responseObject.data.urusan_nama);
                    $('#kodeBidang').text(responseObject.data.kode);
                    $('#txtKodeAkun').text(responseObject.data.kodeAkun);
                    $('#txtNama').text(responseObject.data.nama);
                    $('#txtStatus').text(responseObject.data.status_nama);
                    $('#txtUpdatedAt').text(responseObject.data.updated_at);
                    $('#txtCreatedAt').text(responseObject.data.created_at);
                    
                    $('#modalView').modal('show');
                    Rats.UI.LoadAnimation.stop(spinner);
                }
            },
            401: function(responseObject) {
                UnauthorizedMessages()
            },
            419: function() {
                swal({
                    title: "Token Kadarluarsa",
                    text: "Token Keamanan login telah kadarluarsa, kami akan refresh halaman ini dan memberikan token baru.<br/><br/>",
                    icon: "warning",
                    showCancelButton: false,
                    confirmButtonText: 'Refresh',
                    type: 'error',
                    html:true
                }, function(isConfirm) {
                    window.location = baseUrl + '/login'
                });
            }
        },
        error: function() {
            Rats.UI.LoadAnimation.stop(spinner);
        }
    });
}


document.addEventListener('DOMContentLoaded', function() {
    $.ajax({
        type:'GET',
        url: baseApiUrl + '/ping-server',
        beforeSend: function() {
            spinner = Rats.UI.LoadAnimation.start()
        },
        headers: {
            'Accept' : 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('api_token'),
        },
        statusCode: {
            200: function(responseObject) {
                if(responseObject.ping == true) {
                    switch (pages) {
                        case 'show':
                            skpd_bidang.init()
                        break;
                    
                        case 'create':
                            skpd_bidang.create()
                        break;
                
                        case 'edit':
                            skpd_bidang.edit()
                        break;
                    }
                }
            },
            401: function() {
                UnauthorizedMessages()
            }
        },
        error: function() {
            Rats.UI.LoadAnimation.stop(spinner);
        }
    });
})