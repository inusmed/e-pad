
var pegawai = function () {
    /**
     * init loaded....
     */
    return {
        init: function() {
            pegawai.request();
        },

        request: function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabelDaftarPegawai').DataTable( {
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
                    url		:  baseApiUrl + '/konfigurasi/pegawai/' + company_id,
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
                            $('#tabelDaftarPegawai').dataTable().fnDestroy();
                            $('#tabelDaftarPegawai').hide();
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
                        data: "nip", className: "center", "width": "15%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "nama", className: "left", "width": "30%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "jabatan", className: "left", "width": "25%",
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: "userid", className: "left", "width": "10%",
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
                            console.log(full)
                            if(status == '0')  {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Nama "+full['nama']+"'' onclick=pegawai('"+full['company_id']+"',"+full['uuid']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                            else {
                                return "<div class='sidebar-shortcuts-large'id='sidebar-shortcuts-large'>\
                                    <button style='cursor:pointer' data-rel='tooltip' title='Nama "+full['nama']+"'' onclick=pegawai('"+full['company_id']+"',"+full['uuid']+") class='btn btn-xs btn-info no-radius'><i class='ace-icon fa fa-eye'></i></button>\
                                </div>";
                            }
                        }
                    },
                    {
                        data: 'status', className: "center", "width": "5%", 
                        render: function (data, type, full)  {

                        }
                    },
                ]
            });
        },
    };
}();

function pegawai($company_id, $uuid)
{

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
                            pegawai.init()
                        break;
                    
                        case 'create':
                            pegawai.create()
                        break;
                
                        case 'edit':
                            pegawai.edit()
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