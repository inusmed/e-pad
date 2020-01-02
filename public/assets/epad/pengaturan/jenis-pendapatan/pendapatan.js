var pendapatan = function () {
    return {
        init: function() {
            pendapatan.request();
        },

        get: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/jenis-pendapatan/' + company_id + '/pajak/' + kategori_pajak_id + '/ketetapan/' + ketetapan_id + '/grup/' + grup_id + '/kategori/' + kategori_id + '/subkategori/' + subkategori_id + '/subrekening/' + subrekening_id + '/rekening/' + rekening_id  + '/pendapatan/' + id,
                dataType: 'json',
                headers: {
                    'Accept' : 'application/json',
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                statusCode: {
                    200: function(responseObject) {
                        if(responseObject.status == true) {
                            var data = responseObject.data;
                            $('span#txt_judul_pendapatan').html(data.pendapatan)
                            $('span#txt_company_id').html(data.company_id)
                            $('span#txt_kategori_pajak').html(data.kategori_pajak)
                            $('span#txt_reff_pajak').html(data.reff_pajak)
                            $('span#txt_jenis_pajak').html(data.jenis_pajak)
                            $('span#txt_sub_rekening').html(data.sub_rekening)
                            $('span#txt_rekening').html(data.rekening)
                            $('span#txt_pendapatan').html(data.pendapatan)
                            $('span#txt_metode_hitung').html(data.metode_hitung)
                            $('span#txt_persentase').html(data.persentase+' %')
                            $('span#txt_jenis_pelaporan').html(data.jenis_pelaporan)
                            $('span#txt_jenis_penetapan').html(data.jenis_penetapan)
                            $('span#txt_jatuh_tempo').html(data.jatuh_tempo+' Hari')
                            $('span#txt_akun_denda').html(data.akun_denda)
                            $('span#txt_status').html(data.status)

                            $('#form-content').show()
                            Rats.UI.LoadAnimation.stop(spinner);
                        }
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages();
                    }
                },
            });

            $('#btn-hapus').click(function() {
                $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
                    $('#captImg img').attr('src', data);
                });

                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penghapusan Data </h4><hr>\
                        <h5>Apakah anda yakin ingin menghapus data tersebut?</h5>\
                        Penghapusan jenis pendapatan akan menghapus data tarif omzet yang berinduk pada jenis pendapatan ini \
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
                        var captcha   = $("input[name=captcha]").val();

                        if(captcha != "" && captcha.length == 6)
                        {
                            if(isConfirm) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: baseApiUrl + '/pengaturan/jenis-pendapatan',
                                    dataType: 'json',
                                    data : {
                                        'company_id'    : company_id,
                                        'kategori_pajak': kategori_pajak_id,
                                        'ketetapan_id'    : ketetapan_id,
                                        'grup_id'       : grup_id,
                                        'kategori_id'   : kategori_id,
                                        'subkategori_id': subkategori_id,
                                        'subrekening_id': subrekening_id,
                                        'rekening_id'   : rekening_id,
                                        'id'            : id,
                                        captcha     : captcha
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
                                                    text: 'Penghapusan data jenis pendapatan berhasil. Silahkan menunggu beberapa saat',
                                                    time: 2000,
                                                    class_name: 'gritter-success gritter-center'
                                                });
                                                
                                                setTimeout(function(){
                                                    window.location = baseUrl + '/pengaturan/jenis-pendapatan';
                                                }, 1000);
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
                                        }
                                    },
                                    error: function() {
                                        Rats.UI.LoadAnimation.stop(spinner);
                                    }
                                });
                            }
                        }
                        else {
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
                                    time: 1000
                                });

                                return false;
                            }
                        }
                    }
                });

                $('.refreshCaptcha').on('click', function(e){
                    e.preventDefault();
                    
                    $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
                        $('#captImg img').attr('src', data);
                    });
                });
            });
        },

        create: function() {
            $('#kategoriPajak-1').prop('checked', true);
            $('#reffPajak-1').prop('checked', true);
            $('#jenisPajak-1').prop('checked', true);
            $('#jenisPelaporan-1').prop('checked', true);
            $('#jenisPenetapan-1').prop('checked', true);

            var kategoriPajak = $("input[type='radio'][name='kategoriPajak']:checked").val();
            pendapatan.subRekeningList(grup_id, kategori_id, subkategori_id, kategoriPajak, false); 

            var optMetodeHitung = $("<option />", {
                value: '1',
                text : "Jenis reklame tidak menggunakan metode hitung"
            });

            $('#metode_hitung').append(optMetodeHitung);
            $("#metode_hitung").val(1).chosen().attr('disabled', 'true').trigger("chosen:updated");

            pendapatan.eventList();

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
                                url: baseApiUrl + '/pengaturan/jenis-pendapatan/store',
                                data: {
                                    'company_id'          : $('#company_id').val(),
                                    'kategoriPajak'       : $("input[type='radio'][name='kategoriPajak']:checked").val(),
                                    'reffPajak'           : $("input[type='radio'][name='reffPajak']:checked").val(),
                                    'jenisPajak'          : $("input[type='radio'][name='jenisPajak']:checked").val(),
                                    'akun_grup'           : $("#akun_grup").val(),
                                    'akun_kategori'       : $("#akun_kategori").val(),
                                    'akun_subkategori'    : $("#akun_subkategori").val(),
                                    'akun_subrekening'    : $("#akun_subrekening").val(),
                                    'akun_rekening'       : $("#akun_rekening").val(),
                                    'nama'                : $("#nama").val(),
                                    'kode'                : $("#kode").val(),
                                    'metode_hitung'       : $("#metode_hitung option:selected").val(),
                                    'jatuh_tempo'         : $("#jatuh_tempo").val(),
                                    'persentase'          : $("#persentase").val(),
                                    'jenisPelaporan'      : $("input[type='radio'][name='jenisPelaporan']:checked").val(),
                                    'jenisPenetapan'      : $("input[type='radio'][name='jenisPenetapan']:checked").val(),
                                    'akun_denda_grup'     : $("#akun_denda_grup").val(),
                                    'akun_denda_kategori' : $("#akun_denda_kategori").val(),
                                    'akun_denda_subkategori' : $("#akun_denda_subkategori").val(),
                                    'akun_denda_subrekening' : $("#akun_denda_subrekening").val(),
                                    'akun_denda_rekening'    : $("#akun_denda_rekening").val(),
                                    'status'                 : $("input[name='status']:checked").val(),
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
                                            text: 'Tambah Data Jenis Pendapatan Berhasil. Silahkan menunggu beberapa saat',
                                            time: 1000,
                                            class_name: 'gritter-success gritter-center'
                                        });
                                        
                                        var data = responseObject.data;

                                        var uri = data.company_id + '?kategori_pajak_id=' + data.kategori_pajak_id + '&ketetapan_id=' + data.reff_pajak_id + '&grup_id=' + data.grup_id +'&kategori_id=' + data.kategori_id;
                                        uri = uri + '&subkategori_id=' + data.subkategori_id + '&subrekening_id=' + data.subrekening_id + '&rekening_id=' + data.rekening_id + '&pendapatan_id=' + data.id

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/jenis-pendapatan/show/' + uri
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

                                            if(responses.validate == 'exist') {
                                                $.gritter.add({
                                                    title: 'Terjadi Kesalahan',
                                                    text: responses.messages,
                                                    time : 1000,
                                                    class_name: 'gritter-error gritter-center'
                                                });
                                            }
                                        }else {
                                            $.gritter.add({
                                                title: 'Terjadi Kesalahan',
                                                text: responses.messages,
                                                time : 1000,
                                                class_name: 'gritter-warning gritter-center'
                                            });

                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(responses.messages)
                                        }

                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    500: function() {
                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                            time : 1000,
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
        },

        edit: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/jenis-pendapatan/' + company_id + '/pajak/' + kategori_pajak_id + '/ketetapan/' + ketetapan_id + '/grup/' + grup_id + '/kategori/' + kategori_id + '/subkategori/' + subkategori_id + '/subrekening/' + subrekening_id + '/rekening/' + rekening_id  + '/pendapatan/' + id,
                dataType: 'json',
                headers: {
                    'Accept' : 'application/json',
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                statusCode: {
                    200: function(responseObject) {
                        if(responseObject.status == true)
                        {
                            var data = responseObject.data;
                            $('span#txt_judul_pendapatan').html(data.pendapatan)
                            $('#kategoriPajak-'+data.kategori_pajak_id).prop('checked', true);
                            $('#reffPajak-'+data.reff_pajak_id).prop('checked', true);
                            $('#jenisPajak-'+data.jenis_pajak_id).prop('checked', true);
                            $('#jenisPelaporan-'+data.jenis_pelaporan_id).prop('checked', true);
                            $('#jenisPenetapan-'+data.jenis_penetapan_id).prop('checked', true);
                            $('#nama').val(data.pendapatan);
                            $('#kode').val(data.kode);
                            $('#jatuh_tempo').val(data.jatuh_tempo);
                            $('#rekening_denda').val(data.akun_denda);

                            $('#akun_grup').val(grup_id)
                            $('#akun_kategori').val(kategori_id)
                            $('#akun_subkategori').val(subkategori_id)
                            $('#akun_subrekening').val(subrekening_id)
                            $('#akun_rekening').val(rekening_id)

                            pendapatan.subRekeningList(grup_id, kategori_id, subkategori_id, kategori_pajak_id, true); 

                            if(data.metode_hitung_id == 1)
                            {
                                var optMetodeHitung = $("<option />", {
                                    value: '1',
                                    text : "Jenis reklame tidak menggunakan metode hitung"
                                });


                                $('#metode_hitung').append(optMetodeHitung);
                                $("#metode_hitung").val(1).chosen().attr('disabled', false).trigger("chosen:updated");
                            }else {
                                pendapatan.metodeHitung();
                                $("#metode_hitung").val(data.metode_hitung_id).chosen().trigger("chosen:updated");
                            }

                            if(data.metode_hitung_id == 2 || data.metode_hitung_id == 5)
                            {
                                $('#persentaseWrap').show();
                                $('#persentase').val(data.persentase);
                            }else {
                                $('#persentase').val(0);
                            }

                            if(data.status == 'Aktif' )
                            {
                                $("#aktif").attr('checked', 'checked');
                            }
                            else
                            {
                                $("#nonaktif").attr('checked', 'checked');
                            }

                            var namaPendapatanDenda = data.akun_denda.split(' -- ');
                            var kode_akun_denda = namaPendapatanDenda[0].split('.');

                            $('#akun_denda_grup').val(kode_akun_denda[0])
                            $('#akun_denda_kategori').val(kode_akun_denda[1])
                            $('#akun_denda_subkategori').val(kode_akun_denda[2])
                            $('#akun_denda_subrekening').val(kode_akun_denda[3])
                            $('#akun_denda_rekening').val(kode_akun_denda[4])
                            
                            pendapatan.eventList();
                            $('#form-content').show()
                            Rats.UI.LoadAnimation.stop(spinner);
                        }
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages();
                    }
                },
            });

            $('#btn-submit-edit').click(function() {
                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penambahan Data </h4><hr>\
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
                                url: baseApiUrl+ '/pengaturan/jenis-pendapatan/' + company_id + '/pajak/' + kategori_pajak_id + '/ketetapan/' + ketetapan_id + '/grup/' + grup_id + '/kategori/' + kategori_id + '/subkategori/' + subkategori_id + '/subrekening/' + subrekening_id + '/rekening/' + rekening_id  + '/pendapatan/' + id,
                                data: {
                                    'jenisPajak'          : $("input[type='radio'][name='jenisPajak']:checked").val(),
                                    'akun_rekening'       : $("#akun_rekening").val(),
                                    'nama'                : $("#nama").val(),
                                    'kode'                : $("#kode").val(),
                                    'metode_hitung'       : $("#metode_hitung option:selected").val(),
                                    'jatuh_tempo'         : $("#jatuh_tempo").val(),
                                    'persentase'          : $("#persentase").val(),
                                    'jenisPelaporan'      : $("input[type='radio'][name='jenisPelaporan']:checked").val(),
                                    'jenisPenetapan'      : $("input[type='radio'][name='jenisPenetapan']:checked").val(),
                                    'akun_denda_grup'     : $("#akun_denda_grup").val(),
                                    'akun_denda_kategori' : $("#akun_denda_kategori").val(),
                                    'akun_denda_subkategori' : $("#akun_denda_subkategori").val(),
                                    'akun_denda_subrekening' : $("#akun_denda_subrekening").val(),
                                    'akun_denda_rekening'    : $("#akun_denda_rekening").val(),
                                    'status'                 : $("input[name='status']:checked").val(),
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
                                            time: 1000,
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        setTimeout(function(){
                                            lihatJenisPendapatan(resp.company_id, resp.kategori_pajak_id, resp.ketetapan_id, resp.grup_id, resp.kategori_id, resp.subkategori_id, resp.subrekening_id, resp.rekening_id, resp.id)
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
                                            $('#form-kode').addClass('has-error')
                                            $('#kode').addClass('inputError')
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
                });
            });
        },

        request: function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabelJenisPendapatan').DataTable( {
                "bInfo": true,
                "bFilter": true,
                "bAutoWidth": true,
                "bSort": true,
                "pageLength": 15,
                "bServerSide": true,
                "responsive": true,
                "processing": true,
                "aaSorting" : [[1,'asc']],
                'processing': true,
                columnDefs: [ { orderable: true, targets: [1]} ],
                "lengthMenu": [ 10, 15, 25, 50, 75, 100 ],
                "ajax" : {
                    type	: 'POST',
                    url     :  baseApiUrl + '/pengaturan/jenis-pendapatan',
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
                            $('#tabelJenisPendapatan').dataTable().fnDestroy();
                            $('#tabelJenisPendapatan').hide();
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
                        data: "utama", className: "left", "width": "30%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "pendapatan", className: "left", "width": "35%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "reffpajak", className: "center", "width": "8%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "status_name", className: "center", "width": "7%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            return "<button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['nama']+"'' onclick=lihatJenisPendapatan('"+full['company_id']+"',"+full['kategori_pajak']+","+full['ketetapan_id']+","+full['grup_id']+","+full['kategori_id']+","+full['subkategori_id']+","+full['subrekening_id']+","+full['rekening_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>";
                        }
                    }
                ]
            });
        },

        subRekeningList: function(grup_id, kategori_id, subkategori_id, kategoriPajak, status) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/subrekening/'+company_id + '/pajak/' + kategoriPajak + '/grup/' + grup_id + '/kategori/' + kategori_id + '/subkategori/' + subkategori_id + '/list-subrekening',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend : function() {
                    $('#subrekening_id').empty();
                    $('#rekening_id').empty();
                    Rats.UI.LoadAnimation.start();
                },
                success: function(data) {
                    if(data.length > 1) {
                        $.each(data, function (index) {
                            var opt = $("<option />", {
                                value: data[index].id,
                                text : data[index].name,
                            });
                            $('#subrekening_id').append(opt);
                        });
                        
                        if(pages == 'edit') {
                            if(status) {
                                $("#subrekening_id").val(subrekening_id).chosen().attr('disabled', true).trigger("chosen:updated");
                                pendapatan.rekeningList(grup_id, kategori_id, subkategori_id, subrekening_id, kategori_pajak_id, true)
                            }else {
                                $("#subrekening_id").val(0).chosen().trigger("chosen:updated");
                            }
                        }else {
                            if(status) {
                                $("#subrekening_id").val(subrekening_id).chosen().trigger("chosen:updated");
                                pendapatan.rekeningList(grup_id, kategori_id, subkategori_id, subrekening_id, kategori_pajak_id, true)
                            }else {
                                $("#subrekening_id").val(0).chosen().trigger("chosen:updated");
                            }
                        }
        
                        $('#rekening_id').append(opt);
                        $("#rekening_id").val(0).chosen().trigger("chosen:updated");
                    }
                    else {
                        $('#id, #name').val('');
                        $('#id, #name').prop('readonly', true);

                        var opt = $("<option />", {
                            value: '0',
                            text : "Data Sub Akun tidak ditemukan"
                        });
                        
                        $('#subrekening_id').append(opt);
                        $("#subrekening_id").val(0).chosen().trigger("chosen:updated");
                    }

                    setTimeout(function(){
                        Rats.UI.LoadAnimation.stop(spinner);
                    }, 1000);
                },
                error: function() {
                    $.gritter.add({
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal request data ke server, silahkan coba kembali beberapa saat',
                        class_name: 'gritter-warning gritter-center'
                    });

                    Rats.UI.LoadAnimation.stop(spinner);
                }
            });
        },

        rekeningList: function(grup_id, kategori_id, subkategori_id, subrekening_id, kategoriPajak, status) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/rekening/'+company_id + '/pajak/' + kategoriPajak + '/grup/' + grup_id + '/kategori/' + kategori_id + '/subkategori/' + subkategori_id + '/subrekening/' + subrekening_id +'/list-rekening',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend : function() {
                    $('#rekening_id').empty();
                    Rats.UI.LoadAnimation.start();
                },
                success: function(data) {
                    if(data.length > 1) {
                        $.each(data, function (index) {
                            var opt = $("<option />", {
                                value: data[index].id,
                                text : data[index].name,
                            });
                            $('#rekening_id').append(opt);
                        });
                        
                        if(status) {
                            $("#rekening_id").val(rekening_id).chosen().trigger("chosen:updated");
                        }else {
                            $("#rekening_id").val(0).chosen().trigger("chosen:updated");
                        }
                    }

                    setTimeout(function(){
                        Rats.UI.LoadAnimation.stop(spinner);
                    }, 500);
                },
                error: function() {
                    $.gritter.add({
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal request data ke server, silahkan coba kembali beberapa saat',
                        class_name: 'gritter-warning gritter-center'
                    });

                    Rats.UI.LoadAnimation.stop(spinner);
                }
            });
        },

        eventList: function() {
            $('#subrekening_id').on('change', function() {
                subrekening_id = $("#subrekening_id option:selected").val();
                if(subrekening_id == 0)
                {
                    var opt = $("<option />", {
                        value: '0',
                        text : "Pilih Rekening Utama Terlebih Dahulu"
                    });
    
                    $('#rekening_id').append(opt);
                    $("#rekening_id").val(0).chosen().trigger("chosen:updated");
                }else {
                    var kategoriPajak = $("input[type='radio'][name='kategoriPajak']:checked").val();
                    pendapatan.rekeningList(grup_id, kategori_id, subkategori_id, subrekening_id, kategoriPajak, false)
                }

                $('#akun_grup').val('')
                $('#akun_kategori').val('')
                $('#akun_subkategori').val('')
                $('#akun_subrekening').val('')
                $('#akun_rekening').val('')
                $('#kode').val('');
            });

            $('#rekening_id').on('change', function() {
                var namaPendapatan = $("#rekening_id option:selected").text().split(' -- ');
                var kode_akun = namaPendapatan[0].split('.');

                $('#akun_grup').val(kode_akun[0])
                $('#akun_kategori').val(kode_akun[1])
                $('#akun_subkategori').val(kode_akun[2])
                $('#akun_subrekening').val(kode_akun[3])
                $('#akun_rekening').val(kode_akun[4])
                $('#nama').val(namaPendapatan[1])
                $('#kode').val('');
            });

            $('input[type=radio].jenisPajak').change(function() {
                $('#metode_hitung').empty();
                if($(this).val() == 1) {
                    var opt = $("<option />", {
                        value: '1',
                        text : "Jenis reklame tidak menggunakan metode hitung"
                    });
                    
                    $('#persentaseWrap').hide();
                    $('#metode_hitung').append(opt);
                    $("#metode_hitung").chosen().attr('disabled', 'true').trigger("chosen:updated");
                }else {
                    pendapatan.metodeHitung();
                }
            });

            $('input[type=radio].kategoriPajak').change(function() {
                $('#nama').val('');
                $('#kode').val('');
                kategoriPajak = $("input[type='radio'][name='kategoriPajak']:checked").val();
                pendapatan.subRekeningList(grup_id, kategori_id, subkategori_id, kategoriPajak, false); 
            });

            $('#btn-pencarian-akun-denda').click(function() {
                $('#modalViewAkunDenda').modal('show')
                $('#tabelRekeningDenda').DataTable( {
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
                        url     :  baseApiUrl + '/pengaturan/mata-anggaran/rekening/rekening-pendapatan-denda',
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
                                $('#tabelRekeningDenda').dataTable().fnDestroy();
                                $('#tabelRekeningDenda').hide();
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
                            data: "nama", className: "left", "width": "40%",
                            render: function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            data: 'status', className: "center", "width": "5%", 
                            render: function (data, type, full)  {
                                var nn  = full['nama']
                                return "<button style='cursor:pointer;padding-top:0px;padding-bottom:0px;border-width:1px;' data-rel='tooltip' title='Pilih "+full['nama']+"'' onclick=pilih_rekening_denda('"+full['company_id']+"',"+full['grup_id']+","+full['kategori_id']+","+full['subkategori_id']+","+full['subrekening_id']+","+full['id']+","+ "'"+encodeURIComponent(nn)+"'" +")  class='btn btn-info no-radius'><i class='fa fa-check-square-o'></i></button>";
                            }
                        },
                    ]
                });
            });

            $('#modalViewAkunDenda').on('hidden.bs.modal', function () {
                $('#tabelRekeningDenda').dataTable().fnDestroy();
            });
        },

        metodeHitung: function() {
            var opt = $("<option />", {
                value: '1',
                text : "Pilih Metode Hitung"
            });
            $('#metode_hitung').append(opt);
            opt = $("<option />", {
                value: '2',
                text : "Volume x Tarif x Persentase"
            });
            $('#metode_hitung').append(opt);
            opt = $("<option />", {
                value: '3',
                text : "Omzet x Persentase"
            });
            $('#metode_hitung').append(opt);
            opt = $("<option />", {
                value: '4',
                text : "Tarif Pajak"
            });
            $('#metode_hitung').append(opt);
            opt = $("<option />", {
                value: '5',
                text : "(NPOP - NPOPTKP) x Persentase"
            });
            $('#metode_hitung').append(opt);
            
            $("#metode_hitung").val(0).chosen().attr('disabled', false).trigger("chosen:updated");

            /* event when subaccount change */
            $("#metode_hitung").chosen().change(function() {
                $('#persentase').val(0)
                if($(this).val() == 2 || $(this).val() == 5)
                {
                    $('#persentaseWrap').show();  
                }else
                {
                    $('#persentaseWrap').hide();
                }
            });
        },
    };
}();

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

function lihatJenisPendapatan(company_id, kategori_pajak, ketetapan_id, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, id)
{
    var url =  baseUrl + '/pengaturan/jenis-pendapatan/show/' + company_id + '?kategori_pajak_id=' +  kategori_pajak + '&ketetapan_id=' + ketetapan_id + '&grup_id=' + grup_id + '&kategori_id=' + kategori_id + '&subkategori_id=';
    var url = url + subkategori_id + '&subrekening_id=' + subrekening_id + '&rekening_id=' + rekening_id + '&pendapatan_id=' + id;
    window.location = url; 
}

function pilih_rekening_denda(company_id, grup_id, kategori_id, subkategori_id, subrekening_id, rekening_id, nama)
{
    $('#akun_denda_grup').val(grup_id)
    $('#akun_denda_kategori').val(kategori_id)
    $('#akun_denda_subkategori').val(subkategori_id)
    $('#akun_denda_subrekening').val(subrekening_id)
    $('#akun_denda_rekening').val(rekening_id)

    var namaRekeningDenda = grup_id + '.' + kategori_id+ '.' + subkategori_id + '.'+ subrekening_id + '.'+ rekening_id + '. ' + decodeURIComponent(nama);
    $('#rekening_denda').val(namaRekeningDenda)

    $('#modalViewAkunDenda').modal('hide')
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
                            pendapatan.init()
                        break;
                    
                        case 'create':
                            pendapatan.create()
                        break;

                        case 'get':
                            pendapatan.get()
                        break;
                
                        case 'edit':
                            pendapatan.edit()
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