
$(document).ready(function(){
    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $(document).on('click','#ajouterVille',function(e){
        e.preventDefault();
        $('#introVille').text('AJOUTER UNE SOUS CATEGORIE');
        $('#confirmVille').text('ENREGISTRER');
        $('#categorie').val('');
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
        var categorie = $(this).data('categorie');
        $('#idVille').val(id);
        $('#nameVille').val(name);
        $('#categorie').val(categorie);
        $('#action').val('edit');
        $('#introVille').text('MODIFIER UNE SOUS CATEGORIE');
        $('#confirmVille').text('ENREGISTRER');
        $('#addVille').modal();
    });

    $(document).on('submit', '#form-Ville', function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idVille').val(),
            name = $('#nameVille').val(),
            categorie = $('#categorie').val(),
            action = $('#action').val(),
            act = $('.newBtn').html(),
            url = $(this).attr('action');
        if (name!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'name='+name+'&idPays='+categorie+'&id='+id+'&action='+action,
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
                text: "La sous catégorie va être supprimée.",
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
    $(document).on('click', '.detailPhoto', function (e) {
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

});