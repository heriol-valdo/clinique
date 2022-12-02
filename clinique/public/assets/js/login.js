/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $(document).on('submit','#loginForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            login = $('#login').val(),
            password = $('#password').val();
        if(login != '' && password != ''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'login='+login+'&password='+password,
                datatype: 'json',
                beforeSend: function () {
                    $('#login').prop('disabled',true);
                    $('#password').prop('disabled',true);
                    $('.sendBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
                },
                success: function (json) {
                    if(json.statuts === 0){
                        showAlert($form,1,"Authentification réussie");
                        toastr.success("Authentification réussie",'Succès');
                        window.location.assign(json.direct);
                    }else{
                        showAlert($form,2,json.mes);
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('#login').prop('disabled',false);
                    $('#password').prop('disabled',false);
                    $('.sendBtn').html('Connexion').prop('disabled',false);
                },
                error: function(jqXHR,textStatus, errorThrown){
                }
            });
        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });
});