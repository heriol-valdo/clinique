/**
 * Created by su on 18/08/2015.
 */
$(document).ready(function(){

    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $(document).on('click','#ajouterPays', function (e) {
        e.preventDefault();
        $('#introPays').text('AJOUTER UN PAYS');
        $('#confirmPays').text('ENREGISTRER');
        $('#namePays').val('');
        $('#code').val('');
        $('#nbre').val('');
        $('#action').val('add');
        $('#addPays').modal({backdrop: 'static'});
    });

    /**
     * Fonction qui ouvre la Modal d'edition
     */
    $(document).on('click','.edit',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var code = $(this).data('code');
        var nbre = $(this).data('nbre');
        $('#idPays').val(id);
        $('#namePays').val(name);
        $('#action').val('edit');
        $('#code').val(code);
        $('#nbre').val(nbre);
        $('#introPays').text('MODIFIER UN PAYS');
        $('#confirmPays').text('ENREGISTRER');
        $('#addPays').modal({backdrop: 'static'});
    });

    //FIIN DE L'AJOUT


    $(document).on('submit', '#form-Pays',function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idPays').val(),
            name = $('#namePays').val(),
            code = $('#code').val(),
            nbre = $('#nbre').val(),
            action = $('#action').val(),
            act = $('.newBtn').text(),
            url = $(this).attr('action');
        if (name!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'name='+name+'&nbre='+nbre+'&code='+code+'&id='+id+'&action='+action,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
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
                    $('.newBtn').text(act).prop('disabled', false);
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
                text: "Le secteur d'activité va être supprimé.",
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