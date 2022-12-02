/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){

    /*$(document).on('click','.activate', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La commande va être marquée payée et livrée",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });
    $(document).on('click','.livrer', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Valider la livraison de la commande",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });*/
    $(document).on('click','.payer', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La commande va être marquée payée",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });
    $(document).on('click','.rembourser', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La commande va être marquée comme remboursée",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });
    $(document).on('click','.recevoir', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Valider la reception de la commande",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });
    $(document).on('click', '.valider', function (e) {
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
    $(document).on('click','.disponible', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id'),
            ref = $(this).data('ref'),
            title = "Voulez-vous valider la disponibilité des produits de la commande "+ref+" chez le point de livraison choisi par le client?";
        swal({
                title: "Etes vous sûr?",
                text: title,
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
    $(document).on('click','.retablir', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Retablir le stock reservé de cette commande",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    desactivate(url, id);
                }
            });
    });
    /*$(document).on('click','.livraison', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#idLivraison').val(id);
        $('.livraisonModal').modal({backdrop: 'static'});

    });

    $(document).on('submit', '#livraisonForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action'),
            etape = $('#etape').val(),
            id = $('#idLivraison').val(),
            act = $('.livraisonBtn').text();
        if (etape != '' && id != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'etape='+etape+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.livraisonBtn').text('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        window.location.reload();
                        $('.livraisonModal').modal('hide');
                    } else {
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.livraisonBtn').text(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error("Renseigner tous les champs requis",'Oups!');
        }
    });*/
    $(document).on('change','#selectAll', function (e) {
        $(".selected").prop('checked', $(this).prop("checked"));
        setText();
    });
    $(document).on('change','.selected', function(e){
        setText();
    });
    var setText = function(){
        var selecte = selected();
    };
    var selected = function(){
        var $selected = [];
        $('input.selected:checkbox:checked').each(function () {
            $selected.push($(this).val());

        });
        return $selected;
    };
    $(document).on('click', '.validBtn', function (e) {
        e.preventDefault();
        var btn = $(this),
            url = btn.data('url'),
            id = btn.data('id'),
            datas = selected();
        if (id != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'id='+id+'&datas='+datas,
                datatype: 'json',
                beforeSend: function () {
                    $('.loader').removeClass('hide');
                    $('.contenus').html('').addClass('hide');
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        $('.messageModal').modal('hide');
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                    } else {
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
    $(document).on('click','.livrer1', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#idPhoto').val(id);
        $('#idType').val(1);
        $('.titleLivraison').text('VALIDER LE PAIEMENT ET LA LIVRAISON');
        $('.photoModal').modal({backdrop: 'static'});

    });
    $(document).on('click','.livrer2', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#idPhoto').val(id);
        $('#idType').val(2);
        $('.titleLivraison').text('VALIDER LA LIVRAISON');
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
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                    //$('.photoModal').modal('hide');
                }else{
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.photoBtn').text('VALIDER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });
    function changesatut(url,id,etat) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id+'&etat='+etat,
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
    $(document).on('click','.etat', function (e) {
        e.preventDefault();
        var val,
            url = $(this).data('url'),
            id = $(this).data('id'),
            etat = $(this).data('etat');
        if(etat =='Order Placed'){
            mess = "L'etat va être changer en Order is in Production";
            val = 1;
        }else if(etat =='Order is in Production'){
            mess = "L'etat va être changer en Order in Delivery";
            val = 2;
        }else if(etat =='Order in Delivery'){
            mess = "L'etat va être changer en Order is Delivered";
            val = 3;
        }
        swal({
                title: "Etes vous sûr?",
                text: mess,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    changesatut(url, id, val)
                }
            });
    });
    $('#date_delivery').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        // endDate: '+1d'
    });
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var $form = $(this),
            url = $(this).attr('action'),
            formdata = (window.FormData) ? new FormData($form[0]) : null,
            data = (formdata !== null) ? formdata : $form.serialize(),
            delivery_date = $('#date_delivery').val(),
            act = $('.newBtn1').html();
        if (  delivery_date !=='' && url !==''&& action !=='') {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        contentType: false,
                        processData: false,
                        datatype: 'json',
                        beforeSend: function () {
                            $('.newBtn1').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
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
                            $('.newBtn1').html(act).prop('disabled', false);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {}
                    });

        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis', 'Oups!');
            showAlert($form, 2, 'Veuillez remplir correctement tous les champs requis');
        }

    });
    $(document).on('click','.date_livraison', function (e) {
        e.preventDefault();
        var date= $(this).data('date'),
            id = $(this).data('id');
            is= $(this).data('is');
        $('#date_delivery').val(date);
        $('#idElement').val(id);
        $('#action').val('edit');
        if (is===1){
            $('.titleForm').text("AJOUTER lA DATE DE LIVRAISON");
            $('.newBtn1').text("AJOUTER ");
        }else {
            $('.titleForm').text("MODIFIER lA DATE DE LIVRAISON");
            $('.newBtn1').text("MODIFIER");
        }

        $('.newModal').modal({backdrop: 'static'});
    });


});