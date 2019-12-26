var groups = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            groups.request();
        },

        request: function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#tableGroupAccounts').DataTable( {
                "bInfo": true,
                "bFilter": true,
                "bAutoWidth": true,
                "bSort": true,
                "bServerSide": true,
                "responsive": true,
                "aaSorting" : [[1,'asc']],
                'processing': true,
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4]} ],
                "ajax" : {
                    type	: 'POST',
                    url		: baseApiUrl + '/pengaturan/mata-anggaran/grup/' + company_id,
                    dataType: 'json',
                    headers: {
                        'Authorization': 'Bearer ' +localStorage.getItem('api_token'),
                    },
                    statusCode: {
                        401: function(responseObject) {
                            UnauthorizedMessages()
                        },
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
                        data: "company_id", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "id", className: "center", "width": "3%",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama_grup", className: "left", "width": "15%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "keterangan", className: "center", "width": "5%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {
                            var id     = full['id']
                            var status = full['status'];
                            var company_id = full['company_id'];
    
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['nama_grup']+"'' onclick=groupRequest('"+company_id+"',"+id+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                    <a href='"+baseUrl+"/pengaturan/mata-anggaran/kategori/"+data+"' style='cursor:pointer' data-rel='tooltip' title='Category "+full['nama_grup']+"' class='disabled btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Lihat "+full['nama_grup']+"'' onclick=groupRequest('"+company_id+"',"+id+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                    <a href='"+baseUrl+"/pengaturan/mata-anggaran/kategori/"+company_id+"/"+full['id']+"' style='cursor:pointer' data-rel='tooltip' title='Category "+full['nama_grup']+"' class='btn btn-xs btn-success no-radius'><i class='ace-icon fa fa-arrow-right icon-on-right'></i></a>\
                                </div>";
                            }
                        }
                    },
                ],
            });
        }
    };
}();

function groupRequest(company_id, id) {
    $.ajax({
        type: 'GET',
        url: baseApiUrl + '/pengaturan/mata-anggaran/grup/' + company_id + '/' + id,
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
                    $('#txtCompanyID').text(responseObject.data.company_id);
                    $('#txtAccno').text(responseObject.data.id);
                    $('#txtName').text(responseObject.data.name);
                    $('#txtStatus').text(responseObject.data.status);
                    $('#txtUpdatedAt').text(responseObject.data.updated_at);
                    $('#txtCreatedAt').text(responseObject.data.created_at);
                    
                    $('#modalViewGroups').modal('show');
                    Rats.UI.LoadAnimation.stop(spinner);
                }
            },
            401: function(responseObject) {
                UnauthorizedMessages()
            },
            419: function() {

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
                            groups.init();
                        break;
                    
                        case 'create':
                            groups.create()
                        break;
                
                        case 'edit':
                            groups.edit()
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