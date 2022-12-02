/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            nom = $('#nom').val(),
            privilege = $('#privileges').val(),
            id = $('#idElement').val(),
            action = $('#action').val(),
            act = $('.newBtn').html();
        if (privilege != '' &&nom != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'privilege='+privilege+'&nom='+nom+'&action='+action+'&id='+id,
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
                        toastr.error(json.mes,'Oups!');
                        showAlert($form,2,json.mes);
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
        var nom = $(this).data('nom'),
            privilege = $(this).data('privilege'),
            id = $(this).data('id');
        var splits = privilege.split(',');
        for(var i=0;i<splits.length;i++){
            $("#privileges option[value='"+splits[i]+"']").prop('selected', true);
        }
        $('#privileges').multiSelect({ selectableOptgroup: true });
        $('#nom').val(nom);
        $('#idElement').val(id);
        $('#action').val('edit');
        $('.titleForm').text("MODIFIER LE PROFIL ADMINISTRATEUR");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#nom').val('');
        $('#privileges').val('');
        $('#privileges').multiSelect({ selectableOptgroup: true });
        $('#idElement').val('');
        $('#action').val('add');
        $('.titleForm').text("NOUVEAU PROFIL ADMINISTRATEUR");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
            title: "Etes vous sûr?",
            text: "Le profil administrateur va être supprimé",
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

});