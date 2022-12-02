$(document).ready(function() {
    $('#privacy_policy').summernote({
                height: 300,
                placeholder: 'Saisir le contenu de la privacy policy ...'
            });
    $('#about_us').summernote({
        height: 300,
        placeholder: 'Saisir le contenu de about us ...'
    });
    $('#terms_and_conditions').summernote({
        height: 300,
        placeholder: 'Saisir le contenu des conditions ...'
    });
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();

        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            act = $('.newBtn').html();
        swal({
                title: "Modification",
                text: "Voulez-vous sauvegarder toutes les modifications ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
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
                }
            });


    });
    $(document).on('click','.editabout', function (e) {
        e.preventDefault();
        var about_us =$(this).parent().find('div.bibio').html(),
            id = $(this).data('id');
        $('.note-editable').html(about_us);
        $('#idElement').val(id);
        $('#action').val('editabout');
        $('.titleForm').text("MODIFIER LE CONTENU");
        $('.newBtn').text("MODIFIER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('submit', '#newForma', function (e) {
        e.preventDefault();

        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            act = $('.newBtna').html();
        swal({
                title: "Modification",
                text: "Voulez-vous sauvegarder toutes les modifications ?",
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
                        url: url,
                        data: data,
                        contentType: false,
                        processData: false,
                        datatype: 'json',
                        beforeSend: function () {
                            $('.newBtna').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
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
                            $('.newBtna').html(act).prop('disabled', false);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {}
                    });
                }
            });
    });
    $(document).on('click','.editpolicy', function (e) {
        e.preventDefault();
        var privacy_policy =$(this).parent().find('div.bibioa').html(),
            id = $(this).data('id');
        $('.note-editable').html(privacy_policy);
        $('#idElementa').val(id);
        $('#actiona').val('editpolicy');
        $('.titleForm').text("MODIFIER LE CONTENU");
        $('.newBtna').text("MODIFIER");
        $('.newModala').modal({backdrop: 'static'});
    });
    $(document).on('submit', '#newFormb', function (e) {
        e.preventDefault();

        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            act = $('.newBtnb').html();
        swal({
                title: "Modification",
                text: "Voulez-vous sauvegarder toutes les modifications ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        contentType: false,
                        processData: false,
                        datatype: 'json',
                        beforeSend: function () {
                            $('.newBtnb').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                        },
                        success: function (json) {
                            if (json.statuts == 0) {
                                showAlert($form,1,json.mes);
                                toastr.success(json.mes,'Succès!');
                                window.location.reload();
                            } else {
                                toastr.error(json.mes,'Oups!');
                                showAlert($form,2,json.mes);
                            }
                        },
                        complete: function () {
                            $('.newBtnb').html(act).prop('disabled', false);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {}
                    });
                }
            });
    });
    $(document).on('click','.editterm', function (e) {
        e.preventDefault();
        var privacy_policy =$(this).parent().find('div.bibiob').html(),
            id = $(this).data('id');
        $('.note-editable').html(privacy_policy);
        $('#idElementb').val(id);
        $('#actionb').val('editterm');
        $('.titleForm').text("MODIFIER LE CONTENU");
        $('.newBtnb').text("MODIFIER");
        $('.newModalb').modal({backdrop: 'static'});
    });
});

