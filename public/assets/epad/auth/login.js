$(function(){
    'use strict'

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
                    position:'absolute'};
            
            var target = document.getElementById('spinner-preview');
            return new Spinner(opts).spin(target);
        },
        "stop" : function(spinner) {
            spinner.stop();
            $('#spinner-preview').fadeOut(200);
        }
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#pageSpinner, #page-spinner-login").css('display','none');

    $('.refreshCaptcha').on('click', function(e){
        e.preventDefault();
        
        $.get(baseUrl + '/auth/refreshCaptcha', function(data){
            $('#captImg img').attr('src', data);
        });
    });

    $('#btn-login').click(function(e) {
        e.preventDefault();
        
        var email = $("input[name=email]").val();
        var password = $("input[name=password]").val();
        var captcha = $("input[name=captcha]").val();

        var button = $('#btn-login');
        var isDisabled = true;

        var spinner = Rats.UI.LoadAnimation.start();

        $.ajax({
            type:'POST',
            url: baseUrl + '/login',
            data:{password:password, email:email, captcha:captcha},
            beforeSend: function() {
                button.attr('disabled', isDisabled);
                $("#form-login :input").attr("disabled", true);

                $('#btn-login').text('')
                $('#btn-login').append('Loading');
            },
            statusCode: {
                200: function(responseObject) {

                    localStorage.setItem('api_token', responseObject.data.user.token)
                    window.location = responseObject.path
                },
                401: function(responseObject) {
                    $.get(baseUrl + '/auth/refreshCaptcha', function(data){
                        $('#captImg img').attr('src', data);
                    });

                    var response = JSON.parse(responseObject.responseText).message.messages[0];
                    var message = response.message
                    $('#error_div').show()
                    $('span#error_text').html(message)
                },
                422: function(responseObject) {
                    $.get(baseUrl + '/auth/refreshCaptcha', function(data){
                        $('#captImg img').attr('src', data);
                    });

                    var errorString = '<ul>';
                    var response = JSON.parse(responseObject.responseText).message
                    $.each( response, function( key, value) {
                        $('#form-' + key).addClass('has-error')
                        $('#'+key).addClass('inputError')
                        errorString += '<li>' + value + '</li>';
                    });
                    errorString += '</ul>';
                    $('#error_div').show()
                    $('span#error_text').html(errorString)
                    
                },
                419: function() {
                    $.get(baseUrl + '/auth/refreshCaptcha', function(data){
                        $('#captImg img').attr('src', data);
                    });

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
        }).always(function() {
            button.attr('disabled', !isDisabled);
            $('#captcha').text('')
            $('#btn-login').text('')
            $('#btn-login').append('<i class="ace-icon fa fa-key"></i> <span class="smaller-110">Login</span>');
            $("#form-login :input").attr("disabled", false);
         });
    });
});