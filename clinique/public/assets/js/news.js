$(document).ready(function() {

    $('#contenu').summernote({
        height: 350,
        placeholder: 'Saisir le contenu de la news...'
    });

    $(document).on('click','.trash', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La news va être supprimée définitivement",
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
                        data: 'idPays='+id,
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

    $(document).on('click','.change', function(e){
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

	$(document).on('submit', '#newForm', function (e) {
		e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
		var nom = $('#nom').val(),
			detail = $('#contenu').val(),
            act = $('.newBtn').text();
		if (nom != '' && detail != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                contentType: false,
                processData: false,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').text('Chargement ...').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
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
                    $('.newBtn').text(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });

        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
		}
	});

    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#contenu').val('');
        $('.note-editable').html('');
        $('#nom').val('');
        $('#idElement').val('');
        $('#action').val('add');
        $('#pictureContent').show();
        $('.titleForm').text("PUBLIER UNE NOUVELLE NEWS");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
	$(document).on('click','.edit', function (e) {
		e.preventDefault();
		var nom = $(this).data('nom'),
            detail = $(this).parent().find('div.bibio').html(),
			id = $(this).data('id');
        $('#nom').val(nom);
        $('#contenu').val(detail);
        $('.note-editable').html(detail);
        $('#idElement').val(id);
        $('#action').val('edit');
        $('#pictureContent').hide();
        $('.md-input-wrapper').addClass('md-input-focus');
        $('.titleForm').text("MODIFIER UNE NEWS");
        $('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
	});

});