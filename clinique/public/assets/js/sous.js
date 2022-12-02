
$(document).ready(function(){
    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $(document).on('click','#ajouterVille',function(e){
        e.preventDefault();
        $('#introVille').text('AJOUTER UNE SOUS CATEGORIE');
        $('#confirmVille').text('ENREGISTRER');
        $('#categorie').val('');
        $('#sous').val('');
        $('#nameVille').val('');
        $('#description').val('');
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
        var sous = $(this).data('sous');
        var description = $(this).data('description');
        $('#idVille').val(id);
        $('#nameVille').val(name);
        $('#categorie').val(categorie);
        $('#sous').val(sous);
        $('#description').val(description);
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
            categorie = $('#sous').val(),
            description = $('#description').val(),
            action = $('#action').val(),
            act = $('.newBtn').text(),
            url = $(this).attr('action');
        if (name!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'name='+name+'&idPays='+categorie+'&description='+description+'&id='+id+'&action='+action,
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

    $(document).on('click','.solde', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#idSous').val(id);
        $('#soldeModal').modal({backdrop: 'static'});

    });
    $(document).on('submit', '#form-Solde', function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idSous').val(),
            promotion = $('#promotion').val(),
            url = $(this).attr('action'),
            act = $('.soldeBtn').text();
        if (id!=''&&url!=''&&promotion!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'promotion='+promotion+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.soldeBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0){
                        //$('#soldeModal').modal('hide');
                        showAlert($form,1,json.mes);
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                    } else {
                        toastr.error(json.mes,'Oups!');
                        showAlert($form,2,json.mes);
                    }
                },
                complete: function () {
                    $('.soldeBtn').text(act).prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown){}
            });
        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }

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
                $('.photoBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
            },
            success: function (json) {
                if (json.statuts === 0){
                    showAlert($form,1,json.mes);
                    window.location.reload();
                    //$('.photoModal').modal('hide');
                }else{
                    toastr.error(json.mes,'Oups!');
                    showAlert($form,2,json.mes);
                }
            },
            complete: function () {
                $('.photoBtn').text('ENREGISTRER').prop('disabled',false);
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

    $(document).on('change', '#catId', function (e) {
        e.preventDefault();
        var val = $(this).val();
        loader(val,true,'sousId');
    });
    $(document).on('change', '#categorie', function (e) {
        e.preventDefault();
        var val = $(this).val();
        loader(val,false,'sous');
    });

    function loader(val,is,idSous) {
        $.ajax({
            type: 'post',
            url: 'https://admin.app.afrikfid.boutique/loader1',
            data: 'val='+val,
            datatype: 'json',
            beforeSend: function () {},
            success: function (json) {
                if (json.statuts === 0) {
                    var valText = is?'Chercher par la sous catégorie':'.....';
                    var con = '<option value="">'+valText+'</option>';
                    $('#'+idSous).html('').html(con+json.con);
                }
            },
            complete: function () {},
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }

});