$(document).ready(function() {

    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            state_name = $('#state_name').val(),
            tps = $('#tps').val(),
            tvq = $('#tvq').val(),
            act = $('.newBtn').html();
        tps = parseFloat(tps);
        tvq = parseFloat(tvq);
        if (state_name !== '' && tps >=0 && tps <=100 && tvq >=0 && tvq <=100 && url !== '' && action !== '') {
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                contentType: false,
                processData: false,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts == 0) {
                        //$('.newModal').modal('hide');
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
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis', 'Oups!');
            showAlert($form, 2, 'Veuillez remplir correctement tous les champs requis');
        }
    });
    $(document).on('click', '.new', function (e) {
        e.preventDefault();
        $('#state_name').val('');
        $('#tps').val('');
        $('#tvq').val('');
        $('#idElement').val('');
        $('#action').val('add');
        $('.titleForm').text("AJOUTER UNE VOUVELLE TAXE");
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.edit', function (e) {
        e.preventDefault();
        var state_name = $(this).data('state_name'),
            tps = $(this).data('tps'),
            tvq = $(this).data('tvq'),
            state_name = $(this).data('state_name'),
            id = $(this).data('id');
        $('#state_name').val(state_name);
        $('#tps').val(tps);
        $('#tvq').val(tvq);
        $('#idElement').val(id);
        $('#action').val('edit');
        // $('#pictureContent').hide();
        // $('.md-input-wrapper').addClass('md-input-focus');
        $('.titleForm').text("MODIFIER UNE TAXE");
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });

    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La taxe va être supprimé",
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
                if (json.statuts == 0) {
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