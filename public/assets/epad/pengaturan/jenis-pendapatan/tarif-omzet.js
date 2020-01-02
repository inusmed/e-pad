var tarif_omzet = function () {
    return {
        init: function() {
            tarif_omzet.eventList();
            Rats.UI.LoadAnimation.stop(spinner);
        },

        create: function() {
            $('#grupTarif-1').prop('checked', true);
            $('#periodeTarif-1').prop('checked', true);

            $('#btn-submit-create').click(function() {
                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penambahan Data </h4><hr>\
                        <h5>Apakah anda yakin ingin menambah data tersebut?</h5>\
                    </div>",
                    buttons: {
                        confirm: {
                            label: "Setuju",
                            className: "btn-primary btn-sm",
                        },
                        cancel: {
                            label: "Tidak Setuju",
                            className: "btn-sm",
                        }
                    },
                    callback: function(isConfirm) {
                        if(isConfirm) {
                            $.ajax({
                                type: 'POST',
                                url: baseApiUrl+ '/pengaturan/tarif-omzet/store',
                                data: {
                                    'company_id'        : $('#company_id').val(),
                                    'kategori_pajak'    : $('#kategori_pajak').val(),
                                    'reff_pajak'        : $('#reff_pajak').val(),
                                    'grup_id'           : $('#akun_grup').val(),
                                    'kategori_id'       : $('#akun_kategori').val(),
                                    'subkategori_id'    : $('#akun_subkategori').val(),
                                    'subrekening_id'    : $('#akun_subrekening').val(),
                                    'rekening_id'       : $('#akun_rekening').val(),
                                    'id'                : $('#akun_id').val(),
                                    'kode_akun'         : $('#kode_akun').val(),
                                    'nama'              : $('#nama').val(),
                                    'persentase'        : $('#persentase').val(),
                                    'satuan'            : $('#satuan').val(),
                                    'nominal'           : $('#nominal').val(),
                                    'keterangan'        : $('#keterangan').val(),
                                    'grupTarif'         : $("input[type='radio'][name='grupTarif']:checked").val(),
                                    'periodeTarif'      : $("input[type='radio'][name='periodeTarif']:checked").val(),
                                    'status'            : $("input[name='status']:checked").val(),
                                },
                                headers: {
                                    "Accept"  : "application/json",
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                beforeSend : function() {
                                    $('#validation_error').hide()
                                    $('span#validation_error_text').html('')
                                    spinner = Rats.UI.LoadAnimation.start();
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        $.gritter.add({
                                            title: 'Penambahan Data Berhasil',
                                            text: 'Tambah Data tarif omzet Berhasil. Silahkan menunggu beberapa saat',
                                            time: 2000,
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        var uri = '?kategori_pajak_id='+resp.kategori_pajak_id+'&ketetapan_pajak='+resp.reff_pajak_id+'&grup_id='+resp.grup_id;
                                        uri = uri + '&kategori_id='+resp.kategori_id+'&subkategori_id='+resp.subkategori_id+'&subrekening_id='+resp.subrekening_id+'&rekening_id='+resp.rekening_id+'&pendapatan_id='+resp.pendapatan_id

                                        localStorage.setItem('label_jenis_pendapatan', resp.nama)

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/tarif-omzet/filter/' + uri
                                        }, 1500);
                                    },
                                    401: function(responseObject) {
                                        UnauthorizedMessages();
                                    },
                                    422: function(responseObject) {
                                        var responses = JSON.parse(responseObject.responseText);

                                        if(responses.validate == 'validator') {
                                            var errorString = '<ul>';
                                            var response = responses.messages
                                            $.each( response, function( key, value) {
                                                $('#form-' + key).addClass('has-error')
                                                $('#'+key).addClass('inputError')
                                                errorString += '<li>' + value + '</li>';
                                            });
                                            errorString += '</ul>';
                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(errorString)
                                        }

                                        if(responses.validate == 'exist') {
                                            var errorString = responses.messages;
                                            $('#form-id').addClass('has-error')
                                            $('#id').addClass('inputError')
                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(errorString)

                                            if(responses.validate == 'exist') {
                                                $.gritter.add({
                                                    title: 'Terjadi Kesalahan',
                                                    text: responses.messages,
                                                    time : 2000,
                                                    class_name: 'gritter-error gritter-center'
                                                });
                                            }
                                        }else {
                                            $.gritter.add({
                                                title: 'Terjadi Kesalahan',
                                                text: 'Terjadi kesalahan, Periksa kembali data yang anda masukkan',
                                                time : 2000,
                                                class_name: 'gritter-warning gritter-center'
                                            });
                                        }

                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    500: function() {
                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                            time : 2000,
                                            class_name: 'gritter-error gritter-center'
                                        });
                                    }
                                },
                                error: function() {
                                    $('html, body').animate({
                                        scrollTop: $("#form-content").offset().top
                                    }, 2000);
                                    Rats.UI.LoadAnimation.stop(spinner);
                                }
                            });
                        }
                    }
                });
            });

            tarif_omzet.eventList();
            Rats.UI.LoadAnimation.stop(spinner);
        },

        edit: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/tarif-omzet/' + company_id + '/' + uuid,
                dataType: 'json',
                headers: {
                    'Accept' : 'application/json',
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                statusCode: {
                    200: function(responseObject) {
                        if(responseObject.status == true) {
                            var data = responseObject.data;
                            $('#nama').val(data.nama)
                            $('#persentase').val(data.persentase)
                            $('#satuan').val(data.satuan)
                            $('#nominal').val(data.nilai)
                            $('#keterangan').val(data.keterangan)

                            $('#grupTarif-'+data.tarif_group_id).prop('checked', true);
                            $('#periodeTarif-'+data.reff_periode_tarif_id).prop('checked', true);

                            var kode_akun = data.grup_id + '.' + data.kategori_id+ '.' + data.subkategori_id + '.'+ data.subrekening_id + '.'+ data.rekening_id + '.' + data.id
    
                            $('#company_id').val(data.company_id)
                            $('#kategori_pajak').val(data.kategori_pajak_id),
                            $('#reff_pajak').val(data.reff_pajak_id),
                            $('#akun_grup').val(data.grup_id)
                            $('#akun_kategori').val(data.kategori_id)
                            $('#akun_subkategori').val(data.subkategori_id)
                            $('#akun_subrekening').val(data.subrekening_id)
                            $('#akun_rekening').val(data.rekening_id)
                            $('#akun_id').val(data.id)
                            $('#kode_akun').val(kode_akun)

                            var namaRekeningDenda = data.grup_id + '.' + data.kategori_id+ '.' + data.subkategori_id + '.'+ data.subrekening_id + '.'+ data.rekening_id + '. ' + data.nama_pendapatan;
                            $('#jenis_pendapatan').val(namaRekeningDenda)

                            if(data.status == 'Aktif' )
                            {
                                $("#aktif").attr('checked', 'checked');
                            }
                            else
                            {
                                $("#nonaktif").attr('checked', 'checked');
                            }

                            $('#form-content').show()
                            Rats.UI.LoadAnimation.stop(spinner);
                        }
                    },
                    500: function() {
                        $.gritter.add({
                            title: 'Terjadi Kesalahan',
                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                            time : 2000,
                            class_name: 'gritter-error gritter-center'
                        });

                        setTimeout(function(){
                            window.location = baseUrl + '/pengaturan/tarif-omzet'
                        }, 1500);
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages();
                    }
                },
                error: function() {
                    Rats.UI.LoadAnimation.stop(spinner);
                }
            });

            $('#btn-submit-edit').click(function() {
                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Perubahan Data </h4><hr>\
                        <h5>Apakah anda yakin ingin mengedit data tersebut?</h5>\
                    </div>",
                    buttons: {
                        confirm: {
                            label: "Setuju",
                            className: "btn-primary btn-sm",
                        },
                        cancel: {
                            label: "Tidak Setuju",
                            className: "btn-sm",
                        }
                    },
                    callback: function(isConfirm) {
                        if(isConfirm) {
                            $.ajax({
                                type: 'PATCH',
                                url: baseApiUrl+ '/pengaturan/tarif-omzet/' + company_id + '/' + uuid,
                                data: {
                                    'company_id'        : $('#company_id').val(),
                                    'nama'              : $('#nama').val(),
                                    'persentase'        : $('#persentase').val(),
                                    'satuan'            : $('#satuan').val(),
                                    'nominal'           : $('#nominal').val(),
                                    'keterangan'        : $('#keterangan').val(),
                                    'grupTarif'         : $("input[type='radio'][name='grupTarif']:checked").val(),
                                    'periodeTarif'      : $("input[type='radio'][name='periodeTarif']:checked").val(),
                                    'status'            : $("input[name='status']:checked").val(),
                                },
                                headers: {
                                    "Accept"  : "application/json",
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                beforeSend : function() {
                                    $('#validation_error').hide()
                                    $('span#validation_error_text').html('')
                                    spinner = Rats.UI.LoadAnimation.start();
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        var resp = responseObject.data
                                        $.gritter.add({
                                            title: 'Penambahan Data Berhasil',
                                            text: 'Pembaharuan Jenis Pendapatan Berhasil. Silahkan menunggu beberapa saat',
                                            time: 2000,
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        var uri = '?kategori_pajak_id='+resp.kategori_pajak_id+'&ketetapan_pajak='+resp.reff_pajak_id+'&grup_id='+resp.grup_id;
                                        uri = uri + '&kategori_id='+resp.kategori_id+'&subkategori_id='+resp.subkategori_id+'&subrekening_id='+resp.subrekening_id+'&rekening_id='+resp.rekening_id+'&pendapatan_id='+resp.pendapatan_id

                                        localStorage.setItem('label_jenis_pendapatan', resp.nama)

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/tarif-omzet/filter/' +resp.company_id + uri
                                        }, 1000);
                                    },
                                    401: function(responseObject) {
                                        UnauthorizedMessages();
                                    },
                                    422: function(responseObject) {
                                        var responses = JSON.parse(responseObject.responseText);

                                        if(responses.validate == 'validator') {
                                            var errorString = '<ul>';
                                            var response = responses.messages
                                            $.each( response, function( key, value) {
                                                $('#form-' + key).addClass('has-error')
                                                $('#'+key).addClass('inputError')
                                                errorString += '<li>' + value + '</li>';
                                            });
                                            errorString += '</ul>';
                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(errorString)
                                        }

                                        if(responses.validate == 'exist') {
                                            var errorString = responses.messages;
                                            $('#form-id').addClass('has-error')
                                            $('#id').addClass('inputError')
                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(errorString)
                                        }

                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan, Periksa kembali data yang anda masukkan',
                                            time : 2000,
                                            class_name: 'gritter-warning gritter-center'
                                        });

                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    500: function() {
                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                            time : 2000,
                                            class_name: 'gritter-error gritter-center'
                                        });
                                    }
                                },
                                error: function() {
                                    $('html, body').animate({
                                        scrollTop: $("#form-content").offset().top
                                    }, 2000);
                                    Rats.UI.LoadAnimation.stop(spinner);
                                }
                            });
                        }
                    }
                }).find('.modal-content').css({
                    'margin-top': function (){
                        var w = $( window ).height();
                        var b = $(".modal-dialog").height();
                        // should not be (w-h)/2
                        var h = ((w-b)/2) - 200;
                        return h+"px";
                    }
                });
            });
        },

        filter: function() {
            jenis_pendapatan(company_id, kategori_pajak, reff_pajak, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, id, localStorage.getItem('label_jenis_pendapatan'))
            tarif_omzet.eventList();
        },

        search: function(company_id, kategori_pajak, reff_pajak, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, id) {
            $('#modalViewJenisPendapatan').modal('hide')
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabelTarifOmzet').DataTable( {
                "bInfo": true,
                "bFilter": true,
                "bAutoWidth": true,
                "bSort": false,
                "pageLength": 20,
                "bServerSide": true,
                "responsive": true,
                "processing": true,
                "aaSorting" : [[1,'asc']],
                'processing': true,
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4]} ],
                "lengthMenu": [ 20, 25, 50, 75, 100 ],
                "ajax" : {
                    type	: 'POST',
                    url     :  baseApiUrl + '/pengaturan/tarif-omzet',
                    beforeSend: function() {
                        spinner = Rats.UI.LoadAnimation.start()
                    },
                    data: {
                        'company_id'        : company_id,
                        'kategori_pajak'    : kategori_pajak,
                        'reff_pajak'        : reff_pajak,
                        'grup_id'           : grup_id,
                        'kategori_id'       : kategori_id,
                        'subkategori_id'    : subkategori_id,
                        'subrekening_id'    : subrekening_id,
                        'rekening_id'       : rekening_id,
                        'pendapatan_id'     : id
                    },
                    dataType: 'json',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                    },
                    beforeSend: function() {
                        $('#tabelTarifOmzet').hide();
                    },
                    statusCode: {
                        401: function(responseObject) {
                            UnauthorizedMessages()
                        },
                        522: function(responseObject) {
                            $('#tabelTarifOmzet').dataTable().fnDestroy();
                            $('#tabelTarifOmzet').hide();
                            UnAvailableCloudData(JSON.parse(responseObject.responseText).message)
                            Rats.UI.LoadAnimation.stop(spinner);
                        }
                    },
                    dataSrc	: function ( response ) {
                        Rats.UI.LoadAnimation.stop(spinner);
                        if(response.data) {
                            $('#tabelTarifOmzet').show();
                            return response.data
                        }
                    }
                },
                "columns": [
                    {
                        data: "id", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama", className: "left", "width": "23%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "grup_tarif", className: "left", "width": "10%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "tarif", className: "text-right", "width": "10%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "persentase", className: "center", "width": "7%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "keterangan", className: "left", "width": "20%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "status", className: "center", "width": "8%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            return "<button style='cursor:pointer;padding-top:0px;padding-bottom:0px;border-width:1px;'\
                                    data-rel='tooltip' title='Pilih "+full['nama']+"''\
                                    onclick=edit_tarif('"+full['company_id']+"','"+full['uuid']+"')\
                                    class='btn btn-info no-radius'><i class='fa fa-pencil-square-o'></i>\
                                    </button>";
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            return "<button style='cursor:pointer;padding-top:0px;padding-bottom:0px;border-width:1px;'\
                                    data-rel='tooltip' title='Pilih "+full['nama']+"''\
                                    onclick=hapus_tarif('"+full['company_id']+"','"+full['uuid']+"')\
                                    class='btn btn-danger no-radius'><i class='fa fa-trash-o'></i>\
                                    </button>";
                        }
                    },
                ]
            });
        },

        eventList: function() {
            $('#btn-jenis-pendapatan').click(function() {
                $.fn.dataTable.ext.errMode = 'throw';
                $('#tabelJenisPendapatan').DataTable( {
                    "bInfo": true,
                    "bFilter": true,
                    "bAutoWidth": true,
                    "bSort": false,
                    "pageLength": 8,
                    "bServerSide": true,
                    "responsive": true,
                    "processing": true,
                    "aaSorting" : [[1,'asc']],
                    'processing': true,
                    columnDefs: [ { orderable: false, targets: [0,1,2,3,4]} ],
                    "lengthMenu": [ 8, 15, 25, 50, 75, 100 ],
                    "ajax" : {
                        type	: 'POST',
                        url     :  baseApiUrl + '/pengaturan/grup-pendapatan/list-pendapatan',
                        data    : {
                            'metode_hitung'      : 2
                        },
                        dataType: 'json',
                        headers: {
                            'Accept' : 'application/json',
                            'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                        },
                        beforeSend: function() {
                            $('#error_load_table').hide()
                            $('#tabelTarifOmzet').dataTable().fnDestroy();
                            spinner = Rats.UI.LoadAnimation.start()
                        },
                        statusCode: {
                            401: function(responseObject) {
                                UnauthorizedMessages()
                            },
                            522: function(responseObject) {
                                $('#tabelJenisPendapatan').dataTable().fnDestroy();
                                $('#tabelJenisPendapatan').hide();
                                UnAvailableCloudData(JSON.parse(responseObject.responseText).message)
                            }
                        },
                        dataSrc	: function ( response ) {
                            Rats.UI.LoadAnimation.stop(spinner);
                            if(response.data) {
                                $('#modalViewJenisPendapatan').modal('show')
                                $('#tabelTarifOmzet').show();
                                Rats.UI.LoadAnimation.stop(spinner);
                                return response.data
                            }
                        },
                        error: function() {
                            Rats.UI.LoadAnimation.stop(spinner);
                        }
                    },
                    "columns": [
                        {
                            data: "grup_id", className: "center", "width": "5%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: "kategori_id", className: "center", "width": "5%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: "subkategori_id", className: "center", "width": "5%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: "subrekening_id", className: "center", "width": "5%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: "id", className: "center", "width": "5%",
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
                            data: "nama", className: "left", "width": "40%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: 'status', className: "center", "width": "5%", 
                            render: function (data, type, full)  {
                                return "<button style='cursor:pointer;padding-top:0px;padding-bottom:0px;border-width:1px;'\
                                        data-rel='tooltip' title='Pilih "+full['nama']+"''\
                                        onclick=jenis_pendapatan('"+full['company_id']+"',"+full['kategori_pajak']+","+full['reff_pajak']+","+full['grup_id']+","+full['kategori_id']+","+full['subkategori_id']+","+full['subrekening_id']+","+full['rekening_id']+","+full['id']+","+ "'"+encodeURIComponent(full['nama'])+"'" +")\
                                        class='btn btn-info no-radius'><i class='fa fa-check-square-o'></i>\
                                        </button>";
                            }
                        },
                    ]
                });
            });

            $('#modalViewJenisPendapatan').on('hidden.bs.modal', function () {
                $('#tabelJenisPendapatan').dataTable().fnDestroy();
            });
        },
    };
}();

function jenis_pendapatan(company_id, kategori_pajak, reff_pajak, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, id, nama)
{
    var kode_akun = grup_id + '.' + kategori_id+ '.' + subkategori_id + '.'+ subrekening_id + '.'+ rekening_id + '.' + id
    
    $('#company_id').val(company_id)
    $('#kategori_pajak').val(kategori_pajak),
    $('#reff_pajak').val(reff_pajak),
    $('#akun_grup').val(grup_id)
    $('#akun_kategori').val(kategori_id)
    $('#akun_subkategori').val(subkategori_id)
    $('#akun_subrekening').val(subrekening_id)
    $('#akun_rekening').val(rekening_id)
    $('#akun_id').val(id)
    $('#kode_akun').val(kode_akun)

    localStorage.setItem('label_jenis_pendapatan', decodeURIComponent(nama))

    var namaRekeningDenda = grup_id + '.' + kategori_id+ '.' + subkategori_id + '.'+ subrekening_id + '.'+ rekening_id + '. ' + decodeURIComponent(nama);
    $('#jenis_pendapatan').val(namaRekeningDenda)

    tarif_omzet.search(company_id, kategori_pajak, reff_pajak, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, id)
}

function edit_tarif(company_id, uuid)
{
    window.location = baseUrl + '/pengaturan/tarif-omzet/edit/' + company_id + '/' + uuid
}

function hapus_tarif(company_id, uuid)
{
    $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
        $('#captImg img').attr('src', data);
    });

    bootbox.confirm({
        message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penghapusan Data </h4><hr>\
            <h5>Apakah anda yakin ingin menghapus data tersebut?</h5>\
                Data tarif omzet yang dihapus tidak akan muncul pada menu Pendataan Wajib Pajak\
            <br><br>\
            <div class='form-login'>\
                <div class='form-group' id='form-captcha'>\
                    <div style='display: flex'>\
                        <div style='flex: 3;'>\
                            <input type='text' class='form-control' name='captcha' id='captcha' placeholder='Captcha' value='' maxlength='6' autocomplete='off'>\
                            <span class='text-danger'>masukkan captha untuk konfirmasi</span>\
                        </div>\
                        <div style='flex: 1;'>\
                            <a href='javascript:void(0);' class='refreshCaptcha'>\
                                <img src='"+baseUrl+'/assets/images/icons/refresh.png'+"' style='padding:5px 0 0 5px' alt='load'>\
                            </a>\
                        </div>\
                        <div style='flex: 1;'>\
                            <p id='captImg'><img></p>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>",
        buttons: {
            confirm: {
                label: "Setuju",
                className: "btn-primary btn-sm",
            },
            cancel: {
                label: "Tidak Setuju",
                className: "btn-sm",
            }
        },
        callback: function(isConfirm) {
            if(isConfirm) {
                var captcha   = $("input[name=captcha]").val();

                if(captcha != "" && captcha.length == 6)
                {
                    if(isConfirm)
                    {
                        $.ajax({
                            type: 'DELETE',
                            url: baseApiUrl + '/pengaturan/tarif-omzet',
                            dataType: 'json',
                            data : {
                                'company_id'    : company_id,
                                'uuid'          : uuid,
                                captcha         : captcha
                            },
                            beforeSend: function() {
                                spinner = Rats.UI.LoadAnimation.start()
                            },
                            headers: {
                                'Accept' : 'application/json',
                                'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                            },
                            statusCode: {
                                200: function(responseObject) {
                                    if(responseObject.status == true) {
                                        $.gritter.add({
                                            title: 'Penghapusan Berhasil',
                                            text: 'Penghapusan data tarif omzet berhasil. Silahkan menunggu beberapa saat',
                                            time: 2000,
                                            class_name: 'gritter-success gritter-center'
                                        });
        
                                        $('#tabelTarifOmzet').dataTable().fnDestroy();
                                        $('#tabelTarifOmzet').hide();
                                        
                                        var data = responseObject.data
                                        tarif_omzet.search(data.company_id, data.kategori_pajak, data.reff_pajak, data.grup_id, data.kategori_id, data.subkategori_id, data.subrekening_id, data.rekening_id, data.pendapatan_id)
                                        Rats.UI.LoadAnimation.stop(spinner);
                                    }
                                },
                                422: function() {
                                    $('#form-captcha').addClass('has-error')
                                    $('#captcha').addClass('inputError');
                                    $('#captcha').val('');
    
                                    $.gritter.add({
                                        title: 'Terjadi Kesalahan',
                                        text: 'Captcha yang anda masukkan salah, perhatikan captha yang anda masukkan',
                                        class_name: 'gritter-warning gritter-center',
                                        time: 1000
                                    });
                                },
                                401: function(responseObject) {
                                    UnauthorizedMessages();
                                },
                                500: function() {
                                    $.gritter.add({
                                        title: 'Terjadi Kesalahan',
                                        text: 'Terjadi kesalahan sistem, data gagal di dihapus. silahkan hubungi admin untuk mendapatkan support',
                                        class_name: 'gritter-error gritter-center'
                                    });
                                }
                            },
                            error: function() {
                                Rats.UI.LoadAnimation.stop(spinner);
                            }
                        });
                    }
                }else
                {
                    if(isConfirm)
                    {
                        $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
                            $('#captImg img').attr('src', data);
                        });

                        $('#form-captcha').addClass('has-error')
                        $('#captcha').addClass('inputError');
                        $('#captcha').val('');

                        $.gritter.add({
                            title: 'Terjadi Kesalahan',
                            text: 'Captcha yang anda masukkan salah, perhatikan captha yang anda masukkan',
                            class_name: 'gritter-warning gritter-center',
                            time: 1500
                        });

                        return false;
                    }
                }
            }
        }
    }).find('.modal-content').css({
        'margin-top': function (){
            var w = $( window ).height();
            var b = $(".modal-dialog").height();
            // should not be (w-h)/2
            var h = ((w-b)/2) - 200;
            return h+"px";
        }
    });

    $('.refreshCaptcha').on('click', function(e){
        e.preventDefault();
        
        $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
            $('#captImg img').attr('src', data);
        });
    });
}

function percentageCheck(e,value)
{
    if (!e.target.validity.valid) {
        e.target.value = value.substring(0,value.length - 1);
      return false;
    }
      var idx = value.indexOf('.');
    if (idx >= 0) {
      if (value.length - idx > 3 ) {
        e.target.value = value.substring(0,value.length - 1);
        return false;
      }
    }
    return true;
}

function formatRupiah(nominal)
{
    var number_string = nominal.replace(/[^,\d]/g, '').toString(),
        split	= number_string.split(','),
        sisa 	= split[0].length % 3,
        rupiah 	= split[0].substr(0, sisa),
        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    $('#nominal').val(rupiah)
}

function limitCharacter(event)
{
    key = event.which || event.keyCode;
    if ( key != 188 // Comma
            && key != 8 // Backspace
            && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
            && (key < 48 || key > 57) // Non digit
            // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
        ) 
    {
        event.preventDefault();
        return false;
    }
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
                            tarif_omzet.init()
                        break;
                        case 'create':
                            tarif_omzet.create()
                        break;
                        case 'edit':
                            tarif_omzet.edit()
                        break;
                        case 'filter':
                            tarif_omzet.filter()
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