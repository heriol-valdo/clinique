/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    //DateRanges('debut','end');
    DateRanges('login_debut','login_end');
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            nom = $('#nom').val(),
            prenom = $('#prenom').val(),
            profil = $('#profil').val(),
            numero = $('#numero').val(),
            email = $('#email').val(),
            sexe = $('#sexe').val(),
            id = $('#idElement').val(),
            action = $('#action').val(),
            act = $('.newBtn').html();
        if (nom != '' && profil != '' && prenom != '' && sexe != '' && numero != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'nom='+nom+'&prenom='+prenom+'&sexe='+sexe+'&email='+email+'&numero='+numero+'&profil='+profil+'&action='+action+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        showAlert($form,1,json.mes);
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                        //$('.newModal').modal('hide');
                    } else {
                        showAlert($form,2,json.mes);
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.newBtn').html(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });
    $(document).on('click','.edit', function (e) {
        e.preventDefault();
        var profil = $(this).data('profil'),
            sexe = $(this).data('sexe'),
            email = $(this).data('email'),
            numero = $(this).data('numero'),
            prenom = $(this).data('prenom'),
            nom = $(this).data('nom'),
            id = $(this).data('id');
        $('#profil').val(profil);
        $('#sexe').val(sexe);
        $('#email').val(email);
        $('#numero').val(numero);
        $('#prenom').val(prenom);
        $('#nom').val(nom);
        $('#idElement').val(id);
        $('#action').val('edit');
        $('.titleForm').html("MODIFIER L'ADMINISTRATEUR");
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#profil').val('');
        $('#sexe').val('');
        $('#email').val('');
        $('#numero').val('');
        $('#prenom').val('');
        $('#nom').val('');
        $('#idElement').val('');
        $('#action').val('add');
        $('.titleForm').html("NOUVEL ADMINISTRATEUR");
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
            title: "Etes vous sûr?",
            text: "L'administrateur va être supprimé",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00008B",
            confirmButtonText: "Oui, valider!",
            cancelButtonText: "Annuler",
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                desactivate(url, id,2)
            }
        });
    });
    $(document).on('click','.activate', function (e) {
        e.preventDefault();
        var val,
            url = $(this).data('url'),
            id = $(this).data('id'),
            etat = $(this).data('etat');
        if(etat==1){
            mess = "L'administrateur va être désactivé";
            val = 0;
        }else{
            mess = "L'administrateur va être activé";
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
            beforeSend: function () {},
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès!');
                    //window.location.reload();
                } else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {},
            error: function (jqXHR, textStatus, errorThrown) {}
        });
    }
    $(document).on('click','.editPhoto', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#idPhoto').val(id);
        $('.photoModal').modal({backdrop: 'static'});

    });
    $(document).on('submit','#photoForm',function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.photoBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
            },
            success: function (json) {
                if (json.statuts === 0){
                    showAlert($form,1,json.mes);
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                    //$('.photoModal').modal('hide');
                }else{
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.photoBtn').html('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });
    $(document).on('click','.reset', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Réinitialisation?",
                text: "le mot de passse de l'administrateur sera réinitialisé et il recevra un SMS contenant le nouveau mot de passe",
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
                        beforeSend: function () {},
                        success: function (json) {
                            if (json.statuts === 0) {
                                toastr.success(json.mes,'Succès!');
                            } else {
                                toastr.error(json.mes,'Oups!');
                            }
                        },
                        complete: function () {},
                        error: function (jqXHR, textStatus, errorThrown) {}
                    });
                }
            });
    });

});