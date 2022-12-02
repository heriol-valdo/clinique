$(document).ready(function() {

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
    function desactivates(url,id,status) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id+'&status='+status,
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

    $(document).on('click','.activate', function (e) {
        e.preventDefault();
        var val,
            url = $(this).data('url'),
            id = $(this).data('id'),
            status = $(this).data('status');
        if(status==1){
            mess = "Le councils va être désactivé";
            val = 0;
        }else{
            mess = "Le councils va va être activé";
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
                    desactivates(url, id, val)
                }
            });
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
                    if (json.statuts == 0) {
                        $('.contenus2').html(json.contenu);
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

});

