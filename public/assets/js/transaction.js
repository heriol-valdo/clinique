/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){

    $(document).on('click','.valid', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
            title: "Etes vous sûr?",
            text: "La demande de retrait va être validée",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00008B",
            confirmButtonText: "Oui, confirmer!",
            cancelButtonText: "Annuler",
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                desactivate(url, id, 1)
            }
        });
    });

    $(document).on('click','.cancel', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
            title: "Etes vous sûr?",
            text: "La demande de retrait va être annulée",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00008B",
            confirmButtonText: "Oui, confirmer!",
            cancelButtonText: "Annuler",
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                desactivate(url, id, 2)
            }
        });
    });
    function desactivate(url,id,etat) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'id='+id+'&etat='+etat,
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