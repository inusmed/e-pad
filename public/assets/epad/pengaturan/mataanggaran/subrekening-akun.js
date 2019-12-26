
var subrekening = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            subrekening.request();

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
                                            subrekening.request();
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

        create: function() {
            $('#form-content').show();
            subrekening.groupList(grup_id, kategori_id, subkategori_id);

            $('#kategori-pajak-1').prop('checked', true);
            subrekening.eventChangeList()

            var block = subrekening.blocks(grup_id, kategori_id, subkategori_id, selected = true)
            cleaveInstance = new Cleave('#id', {
                delimiters: ['.'],
                prefix: grup_id + '' +kategori_id+ '' +subkategori_id,
                numericOnly: true,
                blocks: block
            });

            /* event button submit */
            $('#btn-submit-create').click(function()
            {
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
                                url: baseApiUrl+ '/pengaturan/mata-anggaran/subrekening',
                                data: {
                                    'company_id'    : company_id,
                                    'grup_id'       : grup_id,
                                    'kategori_id'   : $("#kategori_id").val(),
                                    'subkategori_id': $("#subkategori_id").val(),
                                    'id'            : id,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                    'kategori_pajak': $("input[type='radio'][name='kategori']:checked").val()
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
                                            text: 'Tambah Data Sub Akun Rekening Berhasil. Silahkan menunggu beberapa saat',
                                            class_name: 'gritter-success gritter-center'
                                        });

                                        setTimeout(function(){
                                            window.location = baseUrl + '/pengaturan/mata-anggaran/subrekening/'+ responseObject.data.company_id +'/' + responseObject.data.grup_id +'/' + responseObject.data.kategori_id + '/' + responseObject.data.subkategori_id
                                        }, 2000);
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
                                            text: 'Nomor akun telah tersedia, silahkan gunakan nomor lain',
                                            class_name: 'gritter-warning gritter-center'
                                        });
                                        Rats.UI.LoadAnimation.stop(spinner);
                                    }
                                },
                                error: function() {
                                
                                }
                            });
                        }
                    }
                });
            });
        },

        edit: function() {
            subrekening.get();

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
                                url: baseApiUrl + '/pengaturan/mata-anggaran/subrekening',
                                data: {
                                    'company_id'    : company_id,
                                    'grup_id'       : grup_id,
                                    'akun_kategori'  : kategori_id,
                                    'akun_subkategori': subkategori_id,
                                    'id'            : id,
                                    'kategori_id'   : $("#kategori_id").val(),
                                    'subkategori_id': $("#subkategori_id").val(),
                                    'kodeAkun'      : kodeAkun,
                                    'nama'          : $('#nama').val(),
                                    'status'        : $("input[name='status']:checked").val(),
                                    'kategori_pajak': $("input[type='radio'][name='kategori']:checked").val()
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
                                                window.location = baseUrl + '/pengaturan/mata-anggaran/subrekening/'+ responseObject.data.company_id +'/' + responseObject.data.grup_id + '/' + responseObject.data.kategori_id + '/' + responseObject.data.subkategori_id
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
                            subrekening.groupList(grup_id, kategori_id, subkategori_id);

                            $('#kategori-pajak-'+responseObject.data.kategori_pajak).prop('checked', true);

                            if(responseObject.data.status_id == 1) {
                                $('#status-active').prop("checked", true);
                            }else {
                                $('#status-inactive').prop("checked", true);
                            }
                            
                            $('#id').val(grup_id + '' + kategori_id + '' + subkategori_id + '' + responseObject.data.id)
                            $('#nama').val(responseObject.data.subrekening_nama)

                            subrekening.eventChangeList()

                            var block = subrekening.blocks(grup_id, kategori_id, subkategori_id)
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
            $('#tableSubRekening').DataTable( {
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
                    url		:  baseApiUrl + '/pengaturan/mata-anggaran/subrekening/' + company_id + '/' + grup_id + '/' + kategori_id +'/'+ subkategori_id +'/subkategori',
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
                            $('#tableSubRekening').dataTable().fnDestroy();
                            $('#tableSubRekening').hide();
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
                        data: "subkategori_nama", className: "justify", "width": "20%",
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
                        data: "subrekening_nama", className: "left", "width": "30%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "status_nama", className: "center", "width": "7%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['subrekening_nama']+"'' onclick=subrekeningRequest('"+full['company_id']+"',"+full['grup_id']+","+full['kategori_id']+","+full['subkategori_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['subrekening_nama']+"'' onclick=subrekeningRequest('"+full['company_id']+"',"+full['grup_id']+","+full['kategori_id']+","+full['subkategori_id']+","+full['id']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            
                            if(full['status'] == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='javascript:void(0)' style='cursor:pointer' data-rel='tooltip' title='Akun "+full['subrekening_nama']+"' class='disabled btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <a href='"+baseUrl+"/pengaturan/mata-anggaran/rekening/"+full['company_id']+"/"+full['grup_id']+"/"+full['kategori_id']+'/'+full['subkategori_id']+'/'+full['id']+"' style='cursor:pointer' data-rel='tooltip' title='Akun "+full['subrekening_nama']+"' class='btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                        }
                    },
                ]
            });
        },

        groupList: function(grup_id, kategori_id, subkategori_id, selected = true) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/grup/'+company_id + '/' + grup_id + '/lists',
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

                    if(selected)
                        $("#txtRekUtama").val(grup_id).chosen().trigger("chosen:updated");
                    else
                        $("#txtRekUtama").val(0).chosen().trigger("chosen:updated");

                    subrekening.categoryList(grup_id, kategori_id, subkategori_id, selected)
                },
            });
        },

        categoryList: function(grup_id, kategori_id, subkategori_id, selected) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/kategori/'+company_id + '/' + grup_id + '/lists',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                success: function(data) {
                    if(data.length > 1) {
                        $.each(data, function (index) {
                            var opt = $("<option />", {
                                value: data[index].id,
                                text : data[index].name,
                            });
                            $('#kategori_id').append(opt);
                        });
                        
                        if(selected)
                            $("#kategori_id").val(kategori_id).chosen().trigger("chosen:updated");
                        else
                            $("#kategori_id").val(0).chosen().trigger("chosen:updated");

                        subrekening.subcategoryList(grup_id, kategori_id, subkategori_id, selected)
                    }
                    else {
                        $('#id').val();
                        $('#id').prop('readonly', true);

                        setTimeout(function(){
                            Rats.UI.LoadAnimation.stop(spinner);
                        }, 500);
                    }
                },
            });
        },

        subcategoryList: function(grup_id, kategori_id, subkategori_id, selected) {
            $.ajax({
                type: 'GET',
                url: baseApiUrl+ '/pengaturan/mata-anggaran/subkategori/'+company_id + '/' + grup_id + '/' + kategori_id + '/lists',
                headers: {
                    "Accept"  : "application/json",
                    'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                },
                beforeSend : function() {
                    Rats.UI.LoadAnimation.start();
                },
                success: function(data) {
                    if(data.length > 1) {
                        $.each(data, function (index) {
                            var opt = $("<option />", {
                                value: data[index].id,
                                text : data[index].name,
                            });
                            $('#subkategori_id').append(opt);
                        });

                        if(selected)
                            $("#subkategori_id").val(subkategori_id).chosen().trigger("chosen:updated");
                        else
                            $("#subkategori_id").val(0).chosen().trigger("chosen:updated");
                    }
                    else {
                        $('#id, #name').val('');
                        $('#id, #name').prop('readonly', true);

                        var opt = $("<option />", {
                            value: '0',
                            text : "Data Sub Kategori tidak ditemukan"
                        });
        
                        $('#subkategori_id').append(opt);
                        $("#subkategori_id").chosen().trigger("chosen:updated");
                    }

                    setTimeout(function(){
                        Rats.UI.LoadAnimation.stop(spinner);
                    }, 500);
                },
            });
        },

        eventChangeList: function() {
            $("#txtRekUtama").chosen().change(function(){
                if($(this).val() == 0)
                {
                    $('#id, #name').val('');
                    $('#id, #name').prop('readonly', true);
                    $('#kategori_id').empty()
                    $('#subkategori_id').empty()
                    var opt = $("<option />", {
                        value: '0',
                        text : "Pilih Rekening Utama Terlebih Dahulu"
                    });
    
                    $('#kategori_id').append(opt);
                    $("#kategori_id").chosen().trigger("chosen:updated");
    
                    var opt = $("<option />", {
                        value: '0',
                        text : "Pilih Kategori Rekening Terlebih Dahulu"
                    });
    
                    $('#subkategori_id').append(opt);
                    $("#subkategori_id").val(0).chosen().trigger("chosen:updated");
                }
                else
                {
                    $('#kategori_id').empty()
                    $('#subkategori_id').empty()
                    $('#id, #name').prop('readonly', false);
                    subrekening.categoryList($(this).val(), kategori_id, subkategori_id, false)
                }
            });
    
            $("#kategori_id").chosen().change(function() {
                if($(this).val() == 0)
                {
                    $('#id, #name').val('');
                    $('#id, #name').prop('readonly', true);
                    $('#subkategori_id').empty()
    
                    var opt = $("<option />", {
                        value: '0',
                        text : "Pilih Kategori Rekening Terlebih Dahulu"
                    });
    
                    $('#subkategori_id').append(opt);
                    $("#subkategori_id").val(0).chosen().trigger("chosen:updated");
                }
                else
                {
                    $('#subkategori_id').empty()
                    subrekening.subcategoryList(grup_id, $(this).val(), subkategori_id, false)
                }
            });
    
            $("#subkategori_id").chosen().change(function() {
                if($(this).val() == 0)
                {
                    $('#id').val('');
                    $('#id, #name').prop('readonly', true);
                }
                else
                {
                    $('#id').val('');
                    $('#id, #name').prop('readonly', false);

                    cleaveInstance.destroy();
                    var block = subrekening.blocks($('#txtRekUtama').val(), $('#kategori_id').val(), $(this).val())
                    
                    cleaveInstance = new Cleave('#id', {
                        delimiters: ['.'],
                        prefix: $('#txtRekUtama').val() + $('#kategori_id').val() + $(this).val(),
                        numericOnly: true,
                        blocks: block
                    });
                }
            });
        },

        blocks: function(grup_id, kategori_id, subkategori_id) {
            var strgroup = grup_id.toString().length
            var strCategory = kategori_id.toString().length
            var strSubcategory = subkategori_id.toString().length
            return Array(
                parseInt(strgroup),
                parseInt(strCategory),
                parseInt(strSubcategory),
                2
            )
        }
    };
}();

function subrekeningRequest(company_id, grup_id, kategori_id, subkategori_id, ids)
{    
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/pengaturan/mata-anggaran/subrekening/' + company_id + '/' + grup_id + '/' + kategori_id + '/' + subkategori_id + '/' + ids + '/get',
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
                    $('#txtJudulAkun').text(responseObject.data.subkategori_nama);
                    $('#txtCompanyID').text(responseObject.data.company_id);
                    $('#txtGrupAkun').text(responseObject.data.grop_nama);
                    $('#txtKategoriAkun').text(responseObject.data.kategori_nama);
                    $('#txtSubKategoriAkun').text(responseObject.data.subkategori_nama);
                    $('#txtKodeAkun').text(responseObject.data.kodeAkun);
                    $('#txtNamaAkun').text(responseObject.data.subrekening_nama);
                    $('#txtStatus').text(responseObject.data.status);
                    $('#txtUpdatedAt').text(responseObject.data.updated_at);
                    $('#txtCreatedAt').text(responseObject.data.created_at);
                    
                    $('#modalView').modal('show');
                    $('#data-id').val(ids);
                    $('#data-grup').val(grup_id);
                    $('#data-kategori').val(kategori_id);
                    $('#data-subkategori').val(subkategori_id);
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
                            subrekening.init()
                        break;
                    
                        case 'create':
                            subrekening.create()
                        break;
                
                        case 'edit':
                            subrekening.edit()
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