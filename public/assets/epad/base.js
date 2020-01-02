var Rats = {};
		
Rats.UI = {};

Rats.UI.LoadAnimation = {
    "start" : function() {
        $('#spinner-preview').css('display','inline');
        $('#spinner-preview').height('100%');
        $('#spinner-preview').width('100%');
        var top = $(window).height() / 2;
        var left = $(window).width() / 2;
        
        var opts = {
                lines:13,
                length:28,
                width:14,
                radius:42,
                scale:0.2,
                corners:1,
                color:'#FFFFFF',
                opacity:0.25,
                rotate:0,
                direction:1,
                speed:1,
                trail:60,
                fps:20,
                zIndex:2e9,
                className:'spinner',
                top:top + 'px',
                left:left + 'px',
                shadow:false,
                hwaccel:false,
                position:'fixed'};
        
        var target = document.getElementById('spinner-preview');
        return new Spinner(opts).spin(target);
    },
    "stop" : function(spinner) {
        spinner.stop();
        $('#spinner-preview').fadeOut(200);
    }
};

function ping()
{
    $.ajax({
        type:'GET',
        url: baseApiUrl + '/ping-server',
        beforeSend: function() {
            
        },
        statusCode: {
            200: function(responseObject) {
                if(responseObject.status == true) {
                    
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
}

function UnauthorizedMessages()
{
    bootbox.alert({
        message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Otorisasi Gagal </h4><hr>\
            <p align='center'><img align='center' src='"+baseUrl+"/assets/images/icons/warning-icon.png' style='height:128px;width:128px;'><p>\
            <h5 align='justify'>Gagal Otorisasi, anda telah mencapai batas waktu maksimum pada sessi login, silahkan logout dan login kembali pada aplikasi BRI Payment Point untuk mendapatkan otorisasi. ?</h5>\
        </div>",
        callback: function() {
            window.location = baseUrl + '/logout'
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
}

function UnAvailableCloudData(message)
{
    $('#error_load_table').show()
    $('span#error_load_table_text').html(message)
    Rats.UI.LoadAnimation.stop(spinner);
    bootbox.dialog({
        message: "<h4 class='smaller'><i class='ace-icon fa fa-warning red'></i> Data Ditemukan </h4><hr>\
            <h5>Data tidak ditemukan, silahkan tambah data terlebih dahulu</h5>\
        </div>",
        buttons: {
          confirm: {
             label: "Ok",
             className: "btn-primary btn-sm",
          },
        },
    }).find('.modal-content').css({
        'margin-top': function (){
            var w = $( window ).height();
            var b = $(".modal-dialog").height();
            // should not be (w-h)/2
            var h = ((w-b)/2) - 150;
            return h+"px";
        }
    });
}

function setSuccessAjaxRequest(response) {
    if(response.error_text){

        if(response.error_text==null){
            response.error_text="Koneksi Terputus";
        }

        document.getElementById("error_text").textContent = response.error_text;
        document.getElementById("error_div").style.display 	= '';
    }else{

        document.getElementById("error_text").textContent = null;
        document.getElementById("error_div").style.display 	= 'none';
        
    }
};

function setErrorAjaxRequest(response) {
    if(response.responseText==null){
        response.responseText="Koneksi Terputus";
    }

    document.getElementById("error_text").textContent = response.responseText;
    document.getElementById("error_div").style.display 	= '';
};

$('#menu .active').each(function(){
    $(this).parents('.nav.nav-list > li').addClass('open');
    $(this).parents('.active.open > .submenu > li').addClass('open');
    $(this).parent().removeClass('nav-hide').addClass('nav-show').css('display', 'block');
    $(this).addClass('active');
});