$(document).ready(function() {

    $('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        // endDate: '+1d'
    });
    $('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        // startDate: '+3d'
    });
    $('#description').summernote({
        height: 200,
        placeholder: 'Saisir le contenu du coupon de réduction ...'
    });
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            coupon_code = $('#coupon_code').val(),
            description = $('#description').val(),
            discount = $('#discount').val(),
            start_date = $('#start_date').val(),
            end_date = $('#end_date').val(),
            act = $('.newBtn').html();
            discount = parseFloat(discount);

            if ( coupon_code !=='' && description !=='' && discount !==''&& start_date !=='' && end_date !=='' && url !==''&& action !=='') {
                if(start_date < end_date  ){
                    if (discount >= 0 && discount <= 100 ){
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
                    }else{
                        toastr.error('La rémise doit etre un réel positif de l\'interval [0;100]' , 'Oups!');
                        showAlert($form, 2, 'La rémise doit etre un réel positif de l\'interval [0;100]');
                    }
                }else{
                    toastr.error('La date de debut doit etre inferieur à date de fin', 'Oups!');
                    showAlert($form, 2, 'La date de debut doit etre inferieur à date de fin');
                }
        } else {
                toastr.error('Veuillez remplir correctement tous les champs requis', 'Oups!');
                showAlert($form, 2, 'Veuillez remplir correctement tous les champs requis');
        }

    });
    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#coupon_code').val('');
        $('#description').val('');
        $('.note-editable').html('');
        $('#discount').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#idElement').val('');
        $('#action').val('add');
        $('#pictureContent').show();
        $('.titleForm').text("AJOUTER UN NOUVEAU COUPONS");
        $('.newBtn').text("AJOUTER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.edit', function (e) {
        e.preventDefault();
        var coupon_code = $(this).data('coupon_code'),
            description =$(this).parent().find('div.bibio').html(),
            discount = $(this).data('discount'),
            start_date= $(this).data('start_date'),
            end_date= $(this).data('end_date'),
            id = $(this).data('id');
        $('#coupon_code').val(coupon_code);
        $('.note-editable').html(description);
        $('#discount').val(discount);
        $('#start_date').val(start_date);
        $('#end_date').val(end_date);
        $('#idElement').val(id);
        $('#action').val('edit');
        // $('#pictureContent').hide();
        // $('.md-input-wrapper').addClass('md-input-focus');
        $('.titleForm').text("MODIFIER UN COUPONS");
        $('.newBtn').text("MODIFIER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.delete', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Le Coupons de réduction va être supprimé",
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
    $(document).on('click', '.detail', function (e) {
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
                    if (json.statuts == 0) {
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

