
var skpd_satker = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            skpd_satker.request();
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
                            skpd_satker.groupList(grup_id, kategori_id, subkategori_id);

                            $('#kategori-pajak-'+responseObject.data.kategori_pajak).prop('checked', true);

                            if(responseObject.data.status_id == 1) {
                                $('#status-active').prop("checked", true);
                            }else {
                                $('#status-inactive').prop("checked", true);
                            }
                            
                            $('#id').val(grup_id + '' + kategori_id + '' + subkategori_id + '' + responseObject.data.id)
                            $('#nama').val(responseObject.data.subrekening_nama)

                            skpd_satker.eventChangeList()

                            var block = skpd_satker.blocks(grup_id, kategori_id, subkategori_id)
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
                    url		:  baseApiUrl + '/konfigurasi/skpd/satuan-kerja/' + company_id + '/' + urusan_id + '/' + bidang_id + '/bidang',
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
                        data: "bidang_nama", className: "left", "width": "15%",
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
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat Satker "+full['nama']+"'' onclick=satkerRequest('"+full['company_id']+"',"+full['urusan_id']+","+full['bidang_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat Satker "+full['nama']+"'' onclick=satkerRequest('"+full['company_id']+"',"+full['urusan_id']+","+full['bidang_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                        }
                    },
                ]
            });
        },
    };
}();

function satkerRequest(company_id, urusan_id, bidang_id, id)
{    
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/konfigurasi/skpd/satuan-kerja/' + company_id + '/' + urusan_id + '/' + bidang_id + '/' + id + '/get',
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
                    $('#txtBidang').text(responseObject.data.bidang_nama);
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
                            skpd_satker.init()
                        break;
                    
                        case 'create':
                            skpd_satker.create()
                        break;
                
                        case 'edit':
                            skpd_satker.edit()
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