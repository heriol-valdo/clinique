/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
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
    $(document).on('click','.desactiver', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La carte de fidélité va être désactivée",
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
    $(document).on('click','.activer', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La carte de fidélité va être activée",
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

    $(document).on('click','.edit', function (e) {
        e.preventDefault();
        var minimum = $(this).data('minimum'),
            maximal = $(this).data('maximal'),
            mois = $(this).data('mois'),
            carte = $(this).data('carte'),
            moyens = $(this).data('moyens'),
            id = $(this).data('id'),
            numero = $(this).data('numero');
        $('#minimum').val(minimum);
        $('#maximal').val(maximal);
        $('#moyens').val(moyens);
        $('#mois').val(mois);
        $('#carte').val(carte);
        $('#idHistory').val(id);
        $('.titleCForm').text("MODIFIER LA CARTE "+numero);
        $('.carteModal').modal({backdrop: 'static'});
    });

    $(document).on('click','.prolonger', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            numero = $(this).data('numero');
        $("#idHistoryPro").val(id);
        $('.titleProForm').text("PROLONGER LA CARTE "+numero);
        $('.carteProModal').modal({backdrop: 'static'});
    });

    $(document).on('click','.associer', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            numero = $(this).data('numero'),
            reduction = $(this).data('reduction');
        $("#idAssocier").val(id);
        $('.titleAssoForm').text("ASSOCIER LA CARTE "+numero+" ("+reduction+"% de réduction)");
        $('.associerModal').modal({backdrop: 'static'});
    });

    $(document).on('submit', '#associerForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        var act = $('.associerBtn').text(),
            numero = $('#num').val();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.associerBtn').text('Chargement ...').prop('disabled', true);
            },
            success: function (leJson) {
                if (leJson.statuts == 0) {
                    swal({
                            title: leJson.titre,
                            text: leJson.contenu,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#00008B",
                            confirmButtonText: "VALIDER",
                            cancelButtonText: "Annuler",
                            closeOnConfirm: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $.ajax({
                                    type: 'post',
                                    url: url,
                                    data: 'id='+leJson.idCarte+'&num='+numero+'&idClient='+leJson.idClient+'&type=2',
                                    datatype: 'json',
                                    beforeSend: function () {
                                        $('.associerBtn').text('Chargement ...').prop('disabled', true);
                                    },
                                    success: function (json) {
                                        if (json.statuts === 0) {
                                            toastr.success(json.mes,'Succès');
                                            showAlert($form,1,json.mes);
                                            window.location.reload();
                                        } else {
                                            showAlert($form,2,json.mes);
                                            toastr.error(json.mes,'Oups!');
                                        }
                                    },
                                    complete: function () {
                                        $('.associerBtn').text('').text(act).prop('disabled', false);
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {}
                                });
                            }
                        });
                } else {
                    showAlert($form,2,leJson.mes);
                    toastr.error(leJson.mes,'Oups!');
                }
            },
            complete: function () {
                $('.associerBtn').text('').text(act).prop('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    $(document).on('submit', '#carteProForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        var act = $('.sendProBtn').text();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.sendProBtn').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès');
                    showAlert($form,1,json.mes);
                    window.location.reload();
                } else {
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Succès!');
                }
            },
            complete: function () {
                $('.sendProBtn').text('').text(act).prop('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    $(document).on('submit', '#carteForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        var act = $('.sendCBtn').text();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('.sendCBtn').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès');
                    showAlert($form,1,json.mes);
                    window.location.reload();
                } else {
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Succès!');
                }
            },
            complete: function () {
                $('.sendCBtn').text('').text(act).prop('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

});