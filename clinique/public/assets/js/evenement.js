/**
 * Created by su on 18/08/2015.
 */
$(document).ready(function(){

    $('#date').datetimepicker({autoclose: true});
    $('#fin').datetimepicker({autoclose: true});
    $("#date").on("dp.change", function (e) {
        $('#fin').data("DateTimePicker").minDate(e.date);
    });
    $("#fin").on("dp.change", function (e) {
        $('#date').data("DateTimePicker").maxDate(e.date);
    });

    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $(document).on('click','#ajouterPays', function (e) {
        e.preventDefault();
        $('#introPays').html('AJOUTER UNE PROMOTION');
        $('#confirmPays').html('ENREGISTRER');
        $('#nom').val('');
        $('#date').val('');
        $('#val').val('');
        $('#cat').val('');
        $('#fin').val('');
        $('#detail').val('');
        $('#action').val('add');
        $('#addPays').modal({backdrop: 'static'});
    });

    /**
     * Fonction qui ouvre la Modal d'edition
     */
    $(document).on('click','.edit',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var nom = $(this).data('nom'),
            debut = $(this).data('debut'),
            fin = $(this).data('fin'),
            montant = $(this).data('montant'),
            pourcentage = $(this).data('pourcentage'),
            detail = $(this).data('detail');
        $('#idPays').val(id);
        $('#nom').val(nom);
        if(pourcentage>0){
            $('#val').val(pourcentage);
            $('#cat').val(1);
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Pourcentage <b>*</b>');
        }else{
            $('#val').val(montant);
            $('#cat').val(2);
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Montant de la reduction <b>*</b>');
        }
        $('#date').val(debut);
        $('#fin').val(fin);
        $('#detail').val(detail);
        $('#action').val('edit');
        $('#introPays').html('MODIFIER UNE PROMOTION');
        $('#confirmPays').html('ENREGISTRER');
        $('#addPays').modal({backdrop: 'static'});
    });

    //FIIN DE L'AJOUT

    $(document).on('submit','#newForm',function (e) {
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
                $('.newBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
            },
            success: function (json) {
                if (json.statuts === 0){
                    showAlert($form,1,json.mes);
                    toastr.success(json.mes,'Succès!');
                    window.location.reload();
                }else{
                    showAlert($form,2,json.mes);
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('.newBtn').html('VALIDER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $(document).on('click','.trash', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "La promotion va être supprimée définitivement",
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
                $('.photoBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled',true);
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
                $('.photoBtn').html('ENREGISTRER').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });
    $(document).on('click', '.detailPhoto', function (e) {
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

    $(document).on('change','#cat', function (e) {
        e.preventDefault();
        var val = $(this).val();
        if(val == 1){
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Pourcentage <b>*</b>');
        }else if (val==2){
            $('.valDiv').removeClass('hide');
            $('.valLabel').html('Montant de la reduction <b>*</b>');
        }else{
            $('.valDiv').addClass('hide');
        }
    });


});