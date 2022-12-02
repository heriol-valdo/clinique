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

});