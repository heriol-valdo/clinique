/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){
    $('#details').summernote({
        height: 200,
        placeholder: 'Saisir la description du produit...'
    });
    $('#mots').tagsinput({
        maxChars : 25,
        trimValue : true
    });
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

                        var grid = document.querySelector('.grid');
                        var msnry = new Masonry( grid, {
                            itemSelector: '.grid-item',
                            columnWidth: '.grid-sizer',
                            percentPosition: true
                        });
                        imagesLoaded( grid ).on( 'progress', function() {
                            msnry.layout();
                        });

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
    $(document).on('submit', '#newForm', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        var nom = $('#nom').val(),
            prix = $('#prix').val(),
            sous = $('#sous').val(),
            sku = $('#sku').val(),
            type = $('#type').val(),
            act = $('.newBtn').html();
        if (nom !== '' && prix !== '' && sku !== '' && sous !== '' && type !== '') {
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
        var type = $(this).data('type'),
            detail = $(this).parent().find('div.bibio').html(),
            prix = $(this).data('prix'),
            slug = $(this).data('slug'),
            offre = $(this).data('offre'),
            supplier = $(this).data('supplier'),
            mots = $(this).data('mots'),
            reduction = $(this).data('reduction'),
            sous = $(this).data('sous'),
            cat = $(this).data('cat'),
            sku = $(this).data('sku'),
            nmfc = $(this).data('nmfc'),
            freight = $(this).data('freight'),
            lenght = $(this).data('lenght'),
            width = $(this).data('width'),
            height = $(this).data('height'),
            weight = $(this).data('weight'),
            weightoz = $(this).data('weightoz'),
            nom = $(this).data('nom'),
            trending = $(this).data('trending'),
            hot = $(this).data('hot'),
            deal = $(this).data('deal'),
            id = $(this).data('id');
        $('#type').val(type);
        $('#details').val(detail);
        $('.note-editable').html(detail);
        $('#slug').val(slug);
        $('#prix').val(prix);
        $('#offre').val(offre);
        $('#supplier').val(supplier);
        $('#mots').tagsinput('add', mots);
        $('#reduction').val(reduction);
        $('#sous').val(sous);
        $('#cat').val(cat);
        $('#sku').val(sku);
        $('#nmfc').val(nmfc);
        $('#freight').val(freight);
        $('#lenght').val(lenght);
        $('#width').val(width);
        $('#height').val(height);
        $('#weight').val(weight);
        $('#weightoz').val(weightoz);
        $('#trending').val(trending);
        $('#hot').val(hot);
        $('#deal').val(deal);
        $('#nom').val(nom);
        $('#pictureContent').hide();
        $('#idElement').val(id);
        $('#action').val('edit');
        $('.titleForm').html('MODIFIER LE patient <b>'+nom+'</b>');
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });
    $(document).on('click','.new', function (e) {
        e.preventDefault();
        $('#type').val('');
        $('#details').val('');
        $('.note-editable').html('');
        $('#marque').val('');
        $('#slug').val('');
        $('#prix').val('');
        $('#offre').val('');
        $('#supplier').val('');
        $('#mots').val('').tagsinput('refresh');
        $('#reduction').val('');
        $('#cat').val('');
        $('#sous').val('');
        $('#sku').val('');
        $('#nmfc').val('');
        $('#freight').val('');
        $('#lenght').val('');
        $('#width').val('');
        $('#height').val('');
        $('#weight').val('');
        $('#weightoz').val('');
        $('#trending').val('');
        $('#deal').val('');
        $('#hot').val('');
        $('#nom').val('');
        $('#pictureContent').show();
        $('#idElement').val('');
        $('#action').val('add');
        $('.titleForm').html("Nouveau patient");
        $('.newBtn').html("ENREGISTRER");
        $('.newModal').modal({backdrop: 'static'});
    });

    $("#nom").on("change paste keyup", function(e) {
        e.preventDefault();
        $("#slug").val($(this).val().split(/[ ,]+/).filter(function(v){return v!==''}).join('_').toLowerCase());
    });
    $("#sku").on("change paste keyup", function(e) {
        e.preventDefault();
        $("#sku").val($(this).val().split(/[ ,]+/).filter(function(v){return v!==''}).join(''));
    });
    $(document).on('change paste keyup','#prix',function(e) {
        e.preventDefault();
        checkPrice();
    });
    $(document).on('change paste keyup','#offre',function(e) {
        e.preventDefault();
        checkPrice();
    });
    function checkPrice(){
        var oprice=parseFloat($('#offre').val());
        var price=parseFloat($('#prix').val());
        if(oprice>0&&price>0){
            if(oprice>price)
            {
                toastr.error("Le prix de l'offre ne peut pas être supérieur au prix",'Oups!');
                return false;
            }
            else
            {
                var percentage=(((price-oprice)*100)/price);
                $('#reduction').val(number_format (percentage, 2, ".",","));
            }
        }
    }

    $(document).on('click','.activate', function (e) {
        e.preventDefault();
        var val,
            url = $(this).data('url'),
            id = $(this).data('id'),
            nom = $(this).data('nom'),
            etat = $(this).data('etat');
        if(etat==1){
            mess = "Le produit <b>"+nom+"</b> va être désactivé";
            val = 0;
        }else{
            mess = "Le produit <b>"+nom+"</b> va être activé";
            val = 1;
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
                    desactivate(url, id, val);
                    swal.close();
                }
            });
    });
    function desactivate(url,id,etat) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id+'&etat='+etat,
            datatype: 'json',
            beforeSend: function () {
                run_waitMe(current_effect,loadingText);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                } else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                dismiss_waitMe();
            },
            error: function (jqXHR, textStatus, errorThrown) {}
        });
    }

    $(document).on('click','.deleteImage', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id'),
            parent = $(this).parent().parent();
        swal({
                title: "Etes vous sûr?",
                text: "L'image du produit va être supprimée",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00008B",
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    remove(url, id,parent);
                    swal.close();
                }
            });
    });
    function remove(url,id,parent) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id,
            datatype: 'json',
            beforeSend: function () {
                run_waitMe(current_effect,loadingText);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    toastr.success(json.mes,'Succès!');
                    parent.remove();

                    var grid = document.querySelector('.grid');
                    var msnry = new Masonry( grid, {
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-sizer',
                        percentPosition: true
                    });
                    imagesLoaded( grid ).on( 'progress', function() {
                        msnry.layout();
                    });

                } else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                dismiss_waitMe();
            },
            error: function (jqXHR, textStatus, errorThrown) {}
        });
    }

    var lePrix = 0;
    $(document).on('change','#d_prix',function(e) {
        e.preventDefault();
        checkLePrix();
    });
    function checkLePrix(){
        var oprice=parseFloat($('#d_prix').val());
        var price=parseFloat(lePrix);
        if(oprice>0&&price>0){
            if(oprice>price)
            {
                toastr.error("Le prix du deal ne peut pas être supérieur au prix",'Oups!');
            }
        }
    }
    $('#d_date').datetimepicker({autoclose: true});
    $('#d_fin').datetimepicker({autoclose: true});
    $("#d_date").on("dp.change", function (e) {
        $('#d_fin').data("DateTimePicker").minDate(e.date);
    });
    $("#d_fin").on("dp.change", function (e) {
        $('#d_date').data("DateTimePicker").maxDate(e.date);
    });
    $(document).on('click','.deal', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom');
        lePrix = $(this).data('prix');
        $('.titleDeal').html('DEAL DU JOUR: <b>'+nom+'</b>, Prix : <b>'+thousands(lePrix)+'</b>');
        $('#idDeal').val(id);
        $('.dealModal').modal({backdrop: 'static'});

    });
    $(document).on('submit','#dealForm',function (e) {
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
                $('.dealBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
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
                $('.dealBtn').html('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $(document).on('click','.editPhoto', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom');
        $('.titleImg').html('AJOUTER DES IMAGES A : <b>'+nom+'</b>');
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
                $('.photoBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
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
                $('.photoBtn').html('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $(document).on('click','.editImage', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom');
        $('.titlePho').html('CHANGER L\'IMAGE PRINCIPALE DE <b>'+nom+'</b>');
        $('#idImage').val(id);
        $('.imageModal').modal({backdrop: 'static'});

    });
    $(document).on('submit','#imageForm',function (e) {
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
                $('.imageBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
            },
            success: function (json) {
                if (json.statuts === 0){
                    showAlert($form,1,json.mes);
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                    //$('.imageModal').modal('hide');
                }else{
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.imageBtn').html('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $(document).on('click','.editStock', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom');
        $('.titleAddStock').html('AUGMENTER LE STOCK DE <b>'+nom+'</b>');
        $('#idStock').val(id);
        $('.stockModal').modal({backdrop: 'static'});

    });
    $(document).on('submit', '#stockForm', function (e) {
        e.preventDefault();
        var $form = $(this);
        var url = $(this).attr('action'),
            nbre = $('#nbre').val(),
            id = $('#idStock').val(),
            act = $('.stockBtn').html();
        if (nbre != '' && id != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'nbre='+nbre+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.stockBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        showAlert($form,1,json.mes);
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                        //$('.stockModal').modal('hide');
                    } else {
                        showAlert($form,2,json.mes);
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.stockBtn').html(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });

    $(document).on('click','.delStock', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom');
        $('.titleDelStock').html('DIMINUER LE STOCK DE <b>'+nom+'</b>');
        $('#idStockdel').val(id);
        $('.stockdelModal').modal({backdrop: 'static'});

    });
    $(document).on('submit', '#stockdelForm', function (e) {
        e.preventDefault();
        var $form = $(this);
        var url = $(this).attr('action'),
            nbre = $('#nbredel').val(),
            raison = $('#raisondel').val(),
            id = $('#idStockdel').val(),
            act = $('.stockBtn').html();
        if (nbre != '' && id != '' && raison != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'nbre='+nbre+'&raison='+raison+'&id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.stockdelBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        showAlert($form,1,json.mes);
                        toastr.success(json.mes,'Succès!');
                        window.location.reload();
                        //$('.stockdelModal').modal('hide');
                    } else {
                        showAlert($form,2,json.mes);
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.stockdelBtn').html(act).prop('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });
        } else {
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });

    $(document).on('change', '#catId', function (e) {
        e.preventDefault();
        var val = $(this).val();
        loader(val,true,'sousId');
    });
    $(document).on('change', '#cat', function (e) {
        e.preventDefault();
        var val = $(this).val();
        loader(val,false,'sous');
    });
    function loader(val,is,idSous) {
        $.ajax({
            type: 'post',
            url: 'http://clinique.log/loader',
            data: 'val='+val,
            datatype: 'json',
            beforeSend: function () {
                run_waitMe(current_effect,loadingText);
            },
            success: function (json) {
                if (json.statuts === 0) {
                    var valText = is?'Chercher par la sous catégorie':'.....';
                    var con = '<option value="">'+valText+'</option>';
                    $('#'+idSous).html('').html(con+json.con);
                }
            },
            complete: function () {
                dismiss_waitMe();
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }

});