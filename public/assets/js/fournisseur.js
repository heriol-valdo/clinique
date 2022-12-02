/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action'),
            nom = $('#nom').val(),
            pays = $('#pays').val(),
            adresse = $('#adresse').val(),
            numero = $('#numero').val(),
            id = $('#idElement').val(),
            action = $('#action').val(),
            act = $('.newBtn').text();
        if (nom != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'nom='+nom+'&pays='+pays+'&adresse='+adresse+'&numero='+numero+'&action='+action+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        window.location.reload();
                        $('.newModal').modal('hide');
                    } else {
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.newBtn').text(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error("Renseigner tous les champs requis",'Oups!');
        }
    });
    $(document).on('click','.edit', function (e) {
        e.preventDefault();
        var nom = $(this).data('nom'),
            pays = $(this).data('pays'),
            adresse = $(this).data('adresse'),
            numero = $(this).data('numero'),
            id = $(this).data('id');
        $('#nom').val(nom);
        $('#pays').val(pays);
        $('#adresse').val(adresse);
        $('#numero').val(numero);
        $('#idElement').val(id);
        $('#action').val('edit');
        $('.titleForm').text("MODIFIER LE FOURNISSEUR");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#nom').val('');
        $('#pays').val('');
        $('#numero').val('');
        $('#adresse').val('');
        $('#idElement').val('');
        $('#action').val('add');
        $('.titleForm').text("NOUVEAU FOURNISSEUR");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
            title: "Etes vous sûr?",
            text: "Le fournisseur va être supprimé",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00008B",
            confirmButtonText: "Oui, valider!",
            cancelButtonText: "Annuler",
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                desactivate(url, id)
            }
        });
    });
    function desactivate(url,id) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id,
            datatype: 'json',
            beforeSend: function () {},
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
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
                $('.photoBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
            },
            success: function (json) {
                if (json.statuts === 0){
                    window.location.reload();
                    $('.photoModal').modal('hide');
                }else{
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.photoBtn').text('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

});