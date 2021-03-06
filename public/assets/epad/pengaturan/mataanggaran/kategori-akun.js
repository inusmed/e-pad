var kategori = function () {
    return {
        init: function() {
            kategori.request()
            /* enabeld button edit */
            $('#btn-edit').click(function() {
                var dataid    = $('#data-uuid').val();
                var companyid = $('#data-company').val();
                var groupid   = $('#data-grup').val();
                window.location = baseUrl + '/pengaturan/mata-anggaran/kategori-akun/edit/' + companyid + '?grup_id='+groupid+'&uuid='+dataid
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
                    callback: function(isConfirm){
                        var captcha   = $("input[name=captcha]").val();
                        var dataid    = $('#data-uuid').val();
                        var companyid = $('#data-company').val();
                        var groupid   = $('#data-grup').val();

                        if(captcha != "" && captcha.length == 6)
                        {
                            if(isConfirm)
                            {
                                $.ajax({
                                    type: 'DELETE',
                                    url: baseApiUrl + '/pengaturan/mata-anggaran/kategori',
                                    dataType: 'json',
                                    data : {
                                        'company_id': companyid,
                                        'grup_id'   : groupid,
                                        'kodeAkun'  : dataid,
                                        captcha     : captcha,
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
                                                    class_name: 'gritter-success gritter-center',
                                                    time: 1000
                                                });

                                                $('#tabelAkunKategori').dataTable().fnDestroy();
                                                kategori.request();
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
                                    time: 1000
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

        /* create pages */
        create: function() {
            kategori.eventChangeList();
            
            /* event change of list option */
            $("#txtRekUtama").chosen().change(function(){
                var mainacc = $(this).val();
                if(mainacc == 0)
                {
                    $("#id").val('');
                    $("#id").attr("readonly", true);
                }
                else
                {
                    new Cleave('#id', {
                        delimiters: ['.'],
                        prefix: mainacc,
                        numericOnly: true,
                        blocks: [1,2]
                    });
                    $("#id").attr("readonly", false); 
                }
            });

            /* event click submit data */
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
                                url: baseApiUrl+ '/pengaturan/mata-anggaran/kategori',
                                data: {
                                    'company_id'    : company_id,
                                    'grup_id'       : grup_id,
                                    'id'            : id,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
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
                                data: {
                                    'company_id'    : company_id,
                                    'grup_id'       : grup_id,
                                    'id'            : id,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        $.gritter.add({
                                            title: 'Penambahan Data Berhasil',
                                            text: 'Tambah Data Kategori Rekening Berhasil. Silahkan menunggu beberapa saat',
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/mata-anggaran/kategori-akun/'+ responseObject.data.company_id +'?grup_id=' + responseObject.data.grup_id
                                         }, 1000);
                                    },
                                    401: function(responseObject) {
                                        var response = JSON.parse(responseObject.responseText).message.messages[0];
                                        var message = response.message
                                        $('#error_div').show()
                                        $('span#error_text').html(message)
                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    422: function(responseObject) {
                                        var responses = JSON.parse(responseObject.responseText);

                                        if(responses.validate == 'validator')
                                        {
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

        /* edit pages */
        edit: function() {
            /* get data from server */
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/mata-anggaran/kategori/' + company_id + '/grup/' + grup_id + '/uuid/' + id,
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend:function() {
                    spinner = Rats.UI.LoadAnimation.start();
                },
                statusCode: {
                    200: function(responseObject) {
    
                        if(responseObject.status == true) {    
                            $('#txtCorpCode').val(responseObject.data.company_id)
                            $('#nama').val(responseObject.data.kategori_nama)
                            $('#txtCreatedAt').val(responseObject.data.created_at)
                            $('#txtUpdatedAt').val(responseObject.data.updated_at)
                            $('#kodeAkun').val(responseObject.data.grup_id);
                            
                            if(responseObject.data.status == 'Aktif' )
                            {
                                $("#aktif").attr('checked', 'checked');
                            }
                            else
                            {
                                $("#nonaktif").attr('checked', 'checked');
                            }
                            
                            $('#txtRekUtama').val(responseObject.data.grup_id).chosen().trigger("chosen:updated");
                            cleave = new Cleave('#kodeAkun', {
                                delimiters: ['.'],
                                prefix: $('#kodeAkun').val(),
                                numericOnly: true,
                                blocks: [1,2]
                            });
    
                            $('#kodeAkun').val(responseObject.data.grup_id+'.'+responseObject.data.id)

                            kategori.eventChangeList()
                        }
                    },
                    500: function() {
                        $.gritter.add({
                            title: 'Terjadi Kesalahan',
                            text: 'Data tidak ditemukan, silahkan hubungi administrator untuk support',
                            class_name: 'gritter-error gritter-center'
                        });

                        setTimeout(function(){
                            window.location = baseUrl + '/pengaturan/mata-anggaran/kategori-akun/' + company_id + '?grup_id=' + grup_id
                         }, 1500);
                    },
                    401: function(responseObject) {
                        UnauthorizedMessages()
                    },
                },
                error: function() {
                    Rats.UI.LoadAnimation.stop(spinner);
                }
            });

            /* event change of list option */
            $("#txtRekUtama").chosen().change(function(){
                var mainacc = $(this).val();
                if(mainacc == 0)
                {
                    cleave.destroy();
                    $("#kodeAkun").val('');
                    $("#kodeAkun").attr("readonly", true);
                }
                else
                {
                    cleave = new Cleave('#kodeAkun', {
                        delimiters: ['.'],
                        prefix: mainacc,
                        numericOnly: true,
                        blocks: [1,2]
                    });
                    $("#kodeAkun").attr("readonly", false); 
                }
            });

            $('#btn-edit').click(function()
            {
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
                            var kodeAkun = $('#kodeAkun').val();
                            var kodeAkun = kodeAkun.substr(kodeAkun.lastIndexOf('.') + 1);

                            $.ajax({
                                type: 'PATCH',
                                url: baseApiUrl + '/pengaturan/mata-anggaran/kategori/' + company_id + '/' + grup_id + '/' + id,
                                data : {
                                    'kodeAkun'      : kodeAkun,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                },
                                dataType: 'json',
                                headers: {
                                    "Accept"  : "application/json",
                                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                                },
                                beforeSend:function() {
                                    $('#validation_error').hide()
                                    $('span#validation_error_text').html('')
                                    spinner = Rats.UI.LoadAnimation.start();
                                },
                                statusCode: {
                                    200: function(responseObject) {
                                        if(responseObject.status == true) {
                                            $.gritter.add({
                                                title: 'Pembaharuan Berhasil',
                                                text: 'Data telah berhasil dilakukan pembaharuan. Silahkan menunggu beberapa saat',
                                                class_name: 'gritter-success gritter-center'
                                            });
    
                                            setTimeout(function(){
                                                window.location = baseUrl + '/pengaturan/mata-anggaran/kategori-akun/'+ responseObject.data.company_id +'?grup_id=' + responseObject.data.grup_id
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

                                        Rats.UI.LoadAnimation.stop(spinner);
                                    },
                                    401: function(responseObject) {
                                        UnauthorizedMessages()
                                    },
                                },
                                error: function() {
                                    $.gritter.add({
                                        title: 'Terjadi Kesalahan',
                                        text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                        class_name: 'gritter-error gritter-center'
                                    });
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
            $('#tabelAkunKategori').DataTable( {
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
                "ajax" : {
                    type	: 'POST',
                    url		: baseApiUrl + '/pengaturan/mata-anggaran/kategori/' + company_id + '/grup/' + grup_id,
                    dataType: 'json',
                    headers: {
                        'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                    },
                    statusCode: {
                        401: function() {
                            UnauthorizedMessages();
                        },
                        500: function() {
                            $.gritter.add({
                                title: 'Terjadi Kesalahan',
                                text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                                class_name: 'gritter-error gritter-center'
                            });

                            setTimeout(function(){
                                window.location = baseUrl + '/pengaturan/mata-anggaran/grup-akun'
                             }, 2000);
                        },
                        522: function(responseObject) {
                            $('#tabelAkunKategori').dataTable().fnDestroy();
                            $('#tabelAkunKategori').hide();
                            UnAvailableCloudData(JSON.parse(responseObject.responseText).message)
                        }
                    },
                    error: function() {
                        Rats.UI.LoadAnimation.stop(spinner);
                    },
                    dataSrc	: function ( response ) {
                        Rats.UI.LoadAnimation.stop(spinner);
                        if(response.data) {
                            $('#table-content').show();
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
                        data: "grup_nama", className: "center", "width": "15%",
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
                        data: "kategori_nama", className: "left", "width": "25%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "keterangan", className: "center", "width": "7%",
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
                            
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['category_name']+"'' onclick=categoryRequest('"+company_id+"',"+grup_id+",'"+id+"') class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['category_name']+"'' onclick=categoryRequest('"+company_id+"',"+grup_id+",'"+id+"') class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
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
                            
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='javascript:void(0)' style='cursor:pointer' data-rel='tooltip' title='SubCategory "+full['category_name']+"' class='disabled btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='"+baseUrl+"/pengaturan/mata-anggaran/subkategori-akun/"+company_id+"?grup_id="+grup_id+'&kategori_id='+full['id']+"' style='cursor:pointer' data-rel='tooltip' title='SubCategory "+full['category_name']+"' class='btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                        }
                    },
                ]
            });
        },

        eventChangeList: function() {
            $.ajax({
                type: 'GET',
                url: baseApiUrl + '/pengaturan/mata-anggaran/grup/'+ company_id + '/grup/' + grup_id + '/list-grup',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend : function() {
                    $('#txtRekUtama').empty()
                    spinner = Rats.UI.LoadAnimation.start();
                },
                success: function(data) {
                    $.each(data, function (index) {
                        var opt = $("<option />", {
                            value: data[index].id,
                            text : data[index].name,
                        });
                        $('#txtRekUtama').append(opt);
                    });

                    $("#txtRekUtama").chosen().trigger("chosen:updated");

                    if(pages == 'edit')
                        $("#txtRekUtama").chosen().val(grup_id).attr('disabled', true).trigger("chosen:updated");

                    Rats.UI.LoadAnimation.stop(spinner);
                },
            });
        }
    };
}();

/* view detail */
function categoryRequest(company_id, grup_id, ids) {
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/pengaturan/mata-anggaran/kategori/' + company_id + '/grup/' + grup_id + '/uuid/' + ids,
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
        },
        beforeSend:function() {
            spinner = Rats.UI.LoadAnimation.start();
        },
        statusCode: {
            200: function(responseObject) {
                if(responseObject.status == true) {
                    $('#txtTitleAcc').text(responseObject.data.kategori_nama);
                    $('#txtCompanyID').text(responseObject.data.company_id);
                    $('#txtGrupAkun').text(responseObject.data.grup_nama);
                    $('#txtkodeAkun').text(responseObject.data.kodeAkun);
                    $('#txtName').text(responseObject.data.kategori_nama);
                    $('#txtStatus').text(responseObject.data.status);
                    $('#txtUpdatedAt').text(responseObject.data.updated_at);
                    $('#txtCreatedAt').text(responseObject.data.created_at);
                    
                    $('#modalView').modal('show');
                    $('#data-uuid').val(ids);
                    $('#data-grup').val(grup_id);
                    $('#data-company').val(company_id);
                    Rats.UI.LoadAnimation.stop(spinner);
                }
            },
            401: function(responseObject) {
                UnauthorizedMessages()
            },
            500: function() {
                $.gritter.add({
                    title: 'Terjadi Kesalahan',
                    text: 'Terjadi kesalahan sistem, data gagal di perbaharui. silahkan hubungi admin untuk mendapatkan support',
                    class_name: 'gritter-error gritter-center'
                });
                $('#modalView').modal('hide');
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
                            kategori.init()
                        break;
                    
                        case 'create':
                            kategori.create()
                        break;

                        case 'edit':
                            kategori.edit()
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