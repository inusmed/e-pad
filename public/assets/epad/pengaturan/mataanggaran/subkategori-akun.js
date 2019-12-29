
var subkategori = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            /* start ping server to initiate communication */
            subkategori.request();

            $('#btn-edit').click(function() {
                var dataid    = $('#data-uuid').val();
                var companyid = $('#data-company').val();
                var kategorid = $('#data-kategori').val();
                var grupid    = $('#data-grup').val();

                window.location = baseUrl + '/pengaturan/mata-anggaran/subkategori-akun/edit/' + companyid + '?grup_id='+grupid+'&kategori_id='+kategorid+'&uuid='+dataid
            });

            $('#btn-delete').click(function() {
                $('#modalView').modal('hide');

                $.get(baseApiUrl + '/pengaturan/mata-anggaran/refreshCaptcha', function(data){
                    $('#captImg img').attr('src', data);
                });

                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Penghapusan Data </h4><hr>\
                        <h5>Apakah anda yakin ingin menghapus data tersebut?</h5>\
                        Penghapusan akun rekening ini akan menghapus turunan rekening dari rekening utama yang anda hapus\
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
                            className: "btn-danger btn-sm",
                        },
                        cancel: {
                            label: "Tidak Setuju",
                            className: "btn-primary btn-sm",
                        }
                    },
                    callback: function(isConfirm) {
                        var captcha   = $("input[name=captcha]").val();
                        var dataid    = $('#data-uuid').val();
                        var companyid = $('#data-company').val();
                        var grupid    = $('#data-grup').val();
                        var kategoriid= $('#data-kategori').val();

                        if(captcha != "" && captcha.length == 6)
                        {
                            if(isConfirm)
                            {
                                $.ajax({
                                    type: 'DELETE',
                                    url: baseApiUrl + '/pengaturan/mata-anggaran/subkategori',
                                    dataType: 'json',
                                    data : {
                                        'company_id' : companyid,
                                        'grup_id'    : grupid,
                                        'kategori_id': kategoriid,
                                        'kodeAkun'   : dataid,
                                        captcha      : captcha,
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
                                            if(responseObject.status == true) {
                                                $.gritter.add({
                                                    title: 'Penghapusan data berhasil',
                                                    text: responseObject.message,
                                                    class_name: 'gritter-success gritter-center'
                                                });

                                                $('#tabelSubKategoriAkun').dataTable().fnDestroy();
                                                subkategori.request();
                                            }
                                        },
                                        422: function() {
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
                                        },
                                        401: function() {
                                            UnauthorizedMessages();
                                        },
                                        500: function() {
                                            $.gritter.add({
                                                title: 'Terjadi Kesalahan',
                                                text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                                class_name: 'gritter-error gritter-center',
                                                time: 1500
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
                        }else
                        {
                            if(isConfirm)
                            {
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
                            }else {
                                $('#modalView').modal('show');
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
            $('#form-content').show();
            subkategori.groupList(grup_id, kategori_id);

            subkategori.eventChangeList()

            var block = subkategori.blocks(grup_id, kategori_id);
            cleaveInstance = new Cleave('#id', {
                delimiters: ['.'],
                prefix: grup_id + '' + kategori_id,
                numericOnly: true,
                blocks: block
            });

            /* event button submit */
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
                            var kodeAkun = $('#id').val();
                            var id = kodeAkun.substr(kodeAkun.lastIndexOf('.') + 1);

                            $.ajax({
                                type: 'POST',
                                url: baseApiUrl+ '/pengaturan/mata-anggaran/subkategori',
                                data: {
                                    'company_id'    : company_id,
                                    'grup_id'       : grup_id,
                                    'kategori_id'   : $("#kategori_id").val(),
                                    'id'            : id,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                },
                                headers: {
                                    "Accept"  : "application/json",
                                },
                                beforeSend : function() {
                                    $('#validation_error').hide()
                                    $('span#validation_error_text').html('')
                                    spinner = Rats.UI.LoadAnimation.start();
                                },
                                headers: {
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        $.gritter.add({
                                            title: 'Penambahan Data Berhasil',
                                            text: 'Tambah Data Sub Kategori Rekening Berhasil. Silahkan menunggu beberapa saat',
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/mata-anggaran/subkategori-akun/'+ responseObject.data.company_id +'?grup_id=' + responseObject.data.grup_id +'&kategori_id=' + responseObject.data.kategori_id
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

                                        if(responses.validate == 'exist')
                                        {
                                            var errorString = responses.messages;
                                            $('#form-id').addClass('has-error')
                                            $('#id').addClass('inputError')
                                            $('#validation_error').show()
                                            $('span#validation_error_text').html(errorString)

                                            $.gritter.add({
                                                title: 'Terjadi Kesalahan',
                                                text: 'Nomor akun telah tersedia, silahkan masukkan nomor lainnya.',
                                                class_name: 'gritter-warning gritter-center'
                                            });
                                        }

                                        Rats.UI.LoadAnimation.stop(spinner);
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

        edit: function() {
            subkategori.get();

            /* event post edit */
            $('#btn-edit').click(function() {
                bootbox.confirm({
                    message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Konfirmasi Pembaharuan </h4><hr>\
                        <h5>Apakah anda yakin ingin melakukan pembaharuan data tersebut?</h5>\
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
                            var kodeAkun = $('#id').val();
                            var kodeAkun = kodeAkun.substr(kodeAkun.lastIndexOf('.') + 1);
                            $.ajax({
                                type: 'PATCH',
                                url: baseApiUrl + '/pengaturan/mata-anggaran/subkategori/' + company_id + '/grup/' + grup_id + '/kategori/'+ kategori_id +'/uuid/' + uuid,
                                data: {
                                    'kodeAkun'      : kodeAkun,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                },
                                dataType: 'json',
                                headers: {
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                beforeSend:function() {
                                    $('#validation_error').hide()
                                    $('span#validation_error_text').html('')
                                    spinner = Rats.UI.LoadAnimation.start();
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        if(responseObject.success == true) {
                                            $.gritter.add({
                                                title: 'Pembaharuan Berhasil',
                                                text: 'Data telah berhasil dilakukan pembaharuan. Silahkan menunggu beberapa saat',
                                                class_name: 'gritter-success gritter-center'
                                            });
    
                                            setTimeout(function(){
                                                window.location = baseUrl + '/pengaturan/mata-anggaran/subkategori-akun/' + responseObject.data.company_id +'?grup_id=' + responseObject.data.grup_id + '&kategori_id=' + responseObject.data.kategori_id 
                                            }, 1000);
                                        }
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
                                            text: 'Nomor akun telah tersedia, silahkan gunakan nomor lain',
                                            class_name: 'gritter-warning gritter-center'
                                        });

                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    500: function() {
                                        $.gritter.add({
                                            title: 'Terjadi Kesalahan',
                                            text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                            class_name: 'gritter-error gritter-center'
                                        });
                                    },
                                    401: function() {
                                        UnauthorizedMessages()
                                    },
                                },
                                error: function() {
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

        /* request data */
        request: function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabelSubKategoriAkun').DataTable( {
                "bInfo": true,
                "bFilter": true,
                "bAutoWidth": true,
                "bSort": true,
                "pageLength": 15,
                "bServerSide": true,
                "responsive": true,
                "aaSorting" : [[1,'asc']],
                'processing': true,
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4]} ],
                "lengthMenu": [ 10, 15, 25, 50, 75, 100 ],
                "ajax" : {
                    type	: 'POST',
                    url		: baseApiUrl + '/pengaturan/mata-anggaran/subkategori/' + company_id + '/grup/' + grup_id + '/kategori/' + kategori_id,
                    dataType: 'json',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                    },
                    statusCode: {
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
                        },
                        500: function() {
                            $.gritter.add({
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal memuat data, silahkan hubungi administrator untuk support.',
                                class_name: 'gritter-error gritter-center'
                            });

                            setTimeout(function(){
                                window.location = baseUrl + '/pengaturan/mata-anggaran/kategori-akun/'+ company_id +'?grup_id=' + grup_id
                            }, 1000);
                        },
                        522: function(responseObject) {
                            $('#tabelSubKategoriAkun').dataTable().fnDestroy();
                            $('#tabelSubKategoriAkun').hide();
                            UnAvailableCloudData(JSON.parse(responseObject.responseText).message)
                        }
                    },
                    error: function() {
                        Rats.UI.LoadAnimation.stop(spinner);
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
                        data: "id", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "company_id", className: "center", "width": "10%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "category_name", className: "justify", "width": "20%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "kodeAkun", className: "center", "width": "8%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "subcategory_name", className: "left", "width": "30%",
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
                            var id     = full['uuid']
                            var status = full['status'];
                            var grup_id = full['grup_id'];
                            var company_id = full['company_id'];
                            var kategori_id = full['kategori_id'];
                            
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['category_name']+"'' onclick=subKategoriRequest('"+company_id+"',"+grup_id+","+kategori_id+",'"+id+"') class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['category_name']+"'' onclick=subKategoriRequest('"+company_id+"',"+grup_id+","+kategori_id+",'"+id+"') class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            var status = full['status'];
                            var grup_id = full['grup_id'];
                            var company_id = full['company_id'];
                            var kategori_id = full['kategori_id'];
                            
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='javascript:void(0)' style='cursor:pointer' data-rel='tooltip' title='SubCategory "+full['category_name']+"' class='disabled btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='"+baseUrl+"/pengaturan/mata-anggaran/subrekening-akun/"+company_id+"?grup_id="+grup_id+"&kategori_id="+kategori_id+'&subkategori_id='+full['id']+"' style='cursor:pointer' data-rel='tooltip' title='SubCategory "+full['category_name']+"' class='btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                        }
                    },
                ]
            });
        },

        get: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/mata-anggaran/subkategori/' + company_id + '/grup/' + grup_id + '/kategori/' + kategori_id + '/uuid/' + uuid,
                dataType: 'json',
                headers: {
                    'Accept' : 'application/json',
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                statusCode: {
                    200: function(responseObject) {
                        if(responseObject.status == true) {
                            $('#form-content').show()
                            subkategori.groupList(grup_id, kategori_id);

                            if(responseObject.data.status_id == 1) {
                                $('#status-active').prop("checked", true);
                            }else {
                                $('#status-inactive').prop("checked", true);
                            }
                            
                            $('#id').val(grup_id+''+kategori_id+responseObject.data.id)
                            $('#nama').val(responseObject.data.subkategori_nama)

                            if(responseObject.data.status_id == 1) {
                                $('#aktif').prop("checked", true);
                            }else {
                                $('#nonaktif').prop("checked", true);
                            }

                            subkategori.eventChangeList()

                            cleaveInstance = new Cleave('#id', {
                                delimiters: ['.'],
                                prefix: grup_id + '' + kategori_id,
                                numericOnly: true,
                                blocks: [1,1,2]
                            });
                        }
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages();
                    }
                },
            });
        },

        groupList: function(grup_id, kategori_id) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/grup/'+company_id + '/grup/' + grup_id + '/list-grup',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend : function() {
                    $('#txtRekUtama').empty()
                },
                success: function(data) {
                    $.each(data, function (index) {
                        var opt = $("<option />", {
                            value: data[index].id,
                            text : data[index].name,
                        });
                        $('#txtRekUtama').append(opt);
                    });

                    if(pages == 'edit')
                        $("#txtRekUtama").val(grup_id).chosen().attr('disabled', true).trigger("chosen:updated");

                    $("#txtRekUtama").val(grup_id).chosen().trigger("chosen:updated");


                    subkategori.categoryList(grup_id, kategori_id)
                },
            });
        },

        categoryList: function(grup_id, kategori_id) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/kategori/'+company_id + '/grup/' + grup_id + '/list-kategori',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                success: function(data) {
                    $.each(data, function (index) {
                        var opt = $("<option />", {
                            value: data[index].id,
                            text : data[index].name,
                        });
                        $('#kategori_id').append(opt);
                    });

                    if(pages == 'edit')
                        $("#kategori_id").val(kategori_id).chosen().attr('disabled', true).trigger("chosen:updated");

                    $("#kategori_id").val(kategori_id).chosen().trigger("chosen:updated");
                    
                    setTimeout(function(){
                        Rats.UI.LoadAnimation.stop(spinner);
                    }, 800);
                },
            });
        },

        eventChangeList: function() {
            $("#txtRekUtama").chosen().change(function(){
                groupId = $(this).val();
                if(groupId == 0)
                {
                    $('#id').val('');
                    $('#kategori_id').empty()
                    $('#id').prop('readonly', true);
                    var opt = $("<option />", {
                        value: '0',
                        text : "Pilih Rekening Utama Terlebih Dahulu"
                    });

                    $('#kategori_id').append(opt);
                    $("#kategori_id").chosen().trigger("chosen:updated");
                }
                else
                {
                    $('#kategori_id').empty()
                    $('#id').prop('readonly', false);
                    subkategori.categoryList(groupId)
                }
            });

            $("#kategori_id").chosen().change(function() {
                if($(this).val() == 0)
                {
                    $('#id').prop('readonly', true);
                }
                else
                {
                    $('#id').val('');
                    $('#id').prop('readonly', false);
                    
                    cleaveInstance.destroy();
                    var block = subkategori.blocks($('#txtRekUtama').val(), $(this).val());
                    cleaveInstance = new Cleave('#id', {
                        delimiters: ['.'],
                        prefix: $('#txtRekUtama').val() + $(this).val() ,
                        numericOnly: true,
                        blocks: block
                    });
                }
            });
        },

        blocks: function(grup_id, kategori_id) {
            var strgroup = grup_id.toString().length
            var strCategory = kategori_id.toString().length
            return Array(
                parseInt(strgroup),
                parseInt(strCategory),
                2
            )
        }
    };
}();

/* view detail */
function subKategoriRequest(company_id, grup_id, kategori_id, ids) {
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/pengaturan/mata-anggaran/subkategori/' + company_id + '/grup/' + grup_id + '/kategori/' + kategori_id + '/uuid/' + ids,
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
                    $('#txtJudulAkun').text(responseObject.data.kategori_nama);
                    $('#txtCompanyID').text(responseObject.data.company_id);
                    $('#txtGrupAkun').text(responseObject.data.grup_nama);
                    $('#txtKategoriAkun').text(responseObject.data.kategori_nama);
                    $('#txtKodeAkun').text(responseObject.data.kodeAkun);
                    $('#txtNamaAkun').text(responseObject.data.subkategori_nama);
                    $('#txtStatus').text(responseObject.data.status);
                    $('#txtUpdatedAt').text(responseObject.data.updated_at);
                    $('#txtCreatedAt').text(responseObject.data.created_at);
                    
                    $('#modalView').modal('show');
                    $('#data-uuid').val(ids);
                    $('#data-grup').val(grup_id);
                    $('#data-kategori').val(kategori_id);
                    $('#data-company').val(company_id);
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
            },
            500: function() {
                $.gritter.add({
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat data, silahkan hubungi administrator untuk support.',
                    class_name: 'gritter-error gritter-center'
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
                            subkategori.init()
                        break;
                    
                        case 'create':
                            subkategori.create()
                        break;
                
                        case 'edit':
                            subkategori.edit()
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