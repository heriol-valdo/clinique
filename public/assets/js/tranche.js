$(document).ready(function(){
    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La ligne de commission va être supprimée.",
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
    });

	$(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize(),
            act = $('.newBtn').text();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.newBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    showAlert($form,1,json.mes);
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                    //$('.newModal').modal('hide');
                } else {
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.newBtn').text(act).prop('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
	});
	$(document).on('click','.new', function (e) {
		e.preventDefault();
		$('#debuts').val('');
		$('#fins').val('');
		$('#cout').val('');
		$('#action').val('add');
		$('.titleForm').text("NOUVELLE LIGNE DE COMMISSION");
		$('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
	});
	$(document).on('click','.edit', function (e) {
		e.preventDefault();
		var debut = $(this).data('debut'),
			fin = $(this).data('fin'),
            cout = $(this).data('cout'),
			id = $(this).data('id');
		$('#debuts').val(debut);
		$('#fins').val(fin);
		$('#cout').val(cout);
		$('#idElement').val(id);
		$('#action').val('edit');
		$('.md-input-wrapper').addClass('md-input-focus');
		$('.titleForm').text("MODIFIER UNE LIGNE DE COMMISSION");
		$('.newBtn').text("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
	});
});