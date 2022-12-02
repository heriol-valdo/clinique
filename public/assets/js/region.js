
$(document).ready(function(){
    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $(document).on('click','#ajouterVille',function(e){
        e.preventDefault();
        $('#introVille').html('AJOUTER UNE REGION');
        $('#confirmVille').html('ENREGISTRER');
        $('#idPays').val('');
        $('#nameVille').val('');
        $('#action').val('add');
        $('#addVille').modal();
    });

    /**
     * Fonction qui ouvre la Modal d'edition
     */
    $(document).on('click','.edit',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var idPays = $(this).data('pays');
        $('#idVille').val(id);
        $('#nameVille').val(name);
        $('#idPays').val(idPays);
        $('#action').val('edit');
        $('#introVille').html('MODIFIER UNE REGION');
        $('#confirmVille').html('ENREGISTRER');
        $('#addVille').modal();
    });

    $(document).on('submit', '#form-Ville', function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idVille').val(),
            name = $('#nameVille').val(),
            idPays = $('#idPays').val(),
            action = $('#action').val(),
            act = $('.newBtn').html(),
            url = $(this).attr('action');
        if (name!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'name='+name+'&idPays='+idPays+'&id='+id+'&action='+action,
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
                text: "La région va être supprimée.",
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