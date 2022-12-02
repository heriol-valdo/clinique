/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $(document).on('submit', '#changePasswordForm', function (e) {
        e.preventDefault();
        var oldpassword = $('#oldPassword').val(),
            newpassword = $('#newPassword').val(),
            url = $(this).attr('action'),
            confirmpassword = $('#confirmPassword').val();
        if (oldpassword!='' && newpassword!='' && confirmpassword!=''){
            if (newpassword == confirmpassword){
                $.ajax({
                    type: 'post',
                    url: url,
                    data: 'oldpassword='+oldpassword+'&newpassword='+newpassword+'&confirmpassword='+confirmpassword,
                    datatype: 'json',
                    beforeSend: function () {
                        $('.sendBtn').text('Chargement en cours...').prop('disabled',true);
                    },
                    success: function (json) {
                        if (json.statuts === 0){
                            toastr.success(json.mes,'Succès');
                            $('#oldPassword').val('');
                            $('#newPassword').val('');
                            $('#confirmPassword').val('');
                        }else{
                            toastr.error(json.mes,'Oups');
                        }
                    },
                    complete: function () {
                        $('.sendBtn').text('Modifier').prop('disabled',false);
                    },
                    error: function(jqXHR, textStatus, errorThrown){}
                });
            }else{
                toastr.error("Le nouveau mot de passe doit etre identique a la confirmation svp !!!",'Oups');
            }
        }else{
            toastr.error('Veuillez remplir tous les champs','Oups');
        }
    });

});