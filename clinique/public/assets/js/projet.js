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
    $(document).on('click', '.details', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        $('.detailModal').modal();
        if (id != '' && url != '') {
            $.ajax({
                type: 'post',
                url: url,
                data: 'id='+id,
                datatype: 'json',
                beforeSend: function () {
                    $('.loader2').removeClass('hide');
                    $('.contenus2').html('').addClass('hide');
                },
                success: function (json) {
                    if (json.statuts === 0) {
                        $('.contenus2').html('').html(json.contenu);
                    } else {
                        $('.detailModal').modal('hide');
                        toastr.error(json.mes,'Oups!');
                    }
                },
                complete: function () {
                    $('.contenus2').removeClass('hide');
                    $('.loader2').addClass('hide');
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

});