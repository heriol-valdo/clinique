
$(document).ready(function(){
    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $('#date_nais').datepicker();

    $(document).on('click','.add',function(e){
        e.preventDefault();
        $('#intro').text('AJOUTER UN PATIENT');
        $('#confirm').text('ENREGISTRER');
        $('#nom').val('');
        $('#prenom').val('');
        $('#sexe').val('');
        $('#numero').val('');
        $('#date_nais').val('');
        $('#group').val('');
        $('#poids').val('');
        $('#taille').val('');
        $('#action').val('add');
        $('#new').modal();
    });

    /**
     * Fonction qui ouvre la Modal d'edition
     */
    $(document).on('click','.edit',function(e){
        e.preventDefault();
        var id = $(this).data('id'),
            nom = $(this).data('nom'),
            prenom = $(this).data('prenom'),
            sexe = $(this).data('sexe'),
            numero = $(this).data('numero'),
            date_nais = $(this).data('date_nais'),
            group = $(this).data('group'),
            poids = $(this).data('poids'),
            taille = $(this).data('taille');
        $('#idElement').val(id);
        $('#nom').val(nom);
        $('#prenom').val(prenom);
        $('#sexe').val(sexe);
        $('#numero').val(numero);
        $('#date_nais').val(date_nais);
        $('#group').val(group);
        $('#poids').val(poids);
        $('#taille').val(taille);
        $('#action').val('edit');
        $('#intro').text('MODIFIER UN PATIENT');
        $('#confirm').text('ENREGISTRER');
        $('#new').modal();
    });

    $(document).on('submit', '#newFrom', function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idElement').val(),
            nom = $('#nom').val(),
            prenom = $('#prenom').val(),
            sexe = $('#sexe').val(),
            numero = $('#numero').val(),
            date_nais = $('#date_nais').val(),
            group = $('#group').val(),
            poids = $('#poids').val(),
            taille = $('#taille').val(),
            action = $('#action').val(),
            act = $('.newBtn').html(),
            url = $(this).attr('action');
            taille = parseFloat(taille);
            poids = parseFloat(poids);

        if (nom!=='' && prenom!=='' && sexe!=='' && numero!=='' &&date_nais!=='' &&group!=='' && taille >= 0 && poids >= 0   ){
            $.ajax({
                type: 'post',
                url: url,
                data: 'nom='+nom+'&prenom='+prenom+'&sexe='+sexe+'&numero='+numero+'&date_nais='+date_nais+'&group='+group+'&poids='+poids+'&taille='+taille+'&id='+id+'&action='+action,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0){
                        //$('#addPays').modal('hide');
                        showAlert($form,1,json.mes);
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                    } else {
                        toastr.error(json.mes,'Oups!');
                        showAlert($form,2,json.mes);
                    }
                },
                complete: function () {
                    $('.newBtn').html(act).prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown){}
            });
        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }

    });

    $(document).on('click','.trash', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Le patient va être supprimée.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url : url,
                        data: 'id='+id,
                        datatype: 'json',
                        beforeSend: function () {
                            run_waitMe(current_effect,loadingText);
                        },
                        complete: function () {
                            dismiss_waitMe();
                        },
                        success: function (json) {
                            if (json.statuts === 0) {
                                toastr.success(json.mes,'Succès!');
                                window.location.reload();
                            } else {
                                toastr.error(json.mes,'Oups!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown){}
                    });
                }
            });
    });

});