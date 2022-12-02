/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $(document).on('click', '.detail', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        $('.messageModal').modal();
        if (id != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.loader').removeClass('hide');
                    $('.contenus').html('').addClass('hide');
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        $('.contenus').html(json.contenu);
                    } else {
                        $('.messageModal').modal('hide');
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.contenus').removeClass('hide');
                    $('.loader').addClass('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error("Renseigner tous les champs requis",'Oups!');
        }
    });
    $(document).on('click','.activate', function (e) {
        e.preventDefault();
        var val,
            url = $(this).data('url'),
            id = $(this).data('id'),
            etat = $(this).data('etat');
        if(etat==1){
            mess = "Le client va être désactivé";
            val = 0;
        }else{
            mess = "Le client va être activé";
            val = 1;
        }
        swal({
                title: "Etes vous sûr?",
                text: mess,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id, val)
                }
            });
    });
    function desactivate(url,id,etat) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id+'&etat='+etat,
            datatype: 'json',
            beforeSend: function () {
                run_waitMe(current_effect,loadingText);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                } else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                dismiss_waitMe();
            },
            error: function (jqXHR, textStatus, errorThrown) {}
        });
    }
    $(document).on('click','.reset', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Réinitialisation?",
                text: "Le mot de passse du client sera réinitialisé et il recevra un mail contenant le nouveau mot de passe",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, réinitialiser!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: 'id='+id,
                        datatype: 'json',
                        beforeSend: function () {
                            run_waitMe(current_effect,loadingText);
                        },
                        success: function (json) {
                            if (json.statuts === 0) {
                                window.location.reload();
                                toastr.success(json.mes,'Succès!');
                            } else {
                                toastr.error(json.mes,'Oups!');
                            }
                        },
                        complete: function () {
                            dismiss_waitMe();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {}
                    });
                }
            });
    });
    $(document).on('click','.coupon', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            nom = $(this).data('nom');
        $("#idCoupon").val(id);
        $('.titleCoForm').text("DONNER UN COUPON A "+nom.toUpperCase());
        $('.couponModal').modal({backdrop: 'static'});
    });
    $(document).on('change','#cat', function (e) {
        e.preventDefault();
        var val = $(this).val();
        if(val == 1){
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Pourcentage <b>*</b>');
        }else if (val==2){
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Montant de la reduction <b>*</b>');
        }else{
            $('.valDiv').addClass('hide');
        }
    });
    $(document).on('submit', '#couponForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        var act = $('.sendCoBtn').text();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.sendCoBtn').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès');
                    $('.alertJsText').text(json.mes);
                    $('.alerter').removeClass('hide');
                    $('.couponModal').modal('hide');
                } else {
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Succès!');
                }
            },
            complete: function () {
                $('.sendCoBtn').text('').text(act).prop('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

});