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
                        $('.contenus').html('').html(json.contenu);

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

    $(document).on('click','.deleteImage', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id'),
            image = $(this).data('image'),
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
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: 'id='+id+'&image='+image,
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
                    swal.close();
                }
            });
    });

    $(document).on('click','.image', function(e){
        e.preventDefault();
        var id = $(this).data('id'),
            service = $(this).data('service'),
            nom = $(this).data('nom');
        $('.titleImage').html('JOINDRE DES FICHIERS : <b>'+nom+'</b> ('+service+')');
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

});