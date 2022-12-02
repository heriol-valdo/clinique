
$(document).ready(function(){
    /**
     * Fonction qui ouvre la modal pour l'ajouter
     */
    $('#date_in').datepicker();
    $(document).on('click','#add',function(e){
        e.preventDefault();
        $('#intro').text('AJOUTER UNE HOSPITALISATION');
        $('#confirm').text('ENREGISTRER');
        $('#idsalle').val('');
        $('#idpatient').val('');
        $('#date_in').val('');
        $('#action').val('add');
        $('#newModal').modal();
    });

    /**
     * Fonction qui ouvre la Modal d'edition
     */
    $(document).on('click','.edit',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var idsalle = $(this).data('idsalle');
        var idpatient = $(this).data('idpatient');
        var date_in = $(this).data('date_in');
        $('#idElement').val(id);
        $('#idsalle').val(idsalle);
        $('#idpatient').val(idpatient);
        $('#date_in').val(date_in);
        $('#action').val('edit');
        $('#intro').text('MODIFIER UNE HOSPITALISATION');
        $('#confirm').text('ENREGISTRER');
        $('#newModal').modal();
    });

    $(document).on('submit', '#newFrom', function (e) {
        e.preventDefault();
        var $form = $(this),
            id = $('#idElement').val(),
            idsalle = $('#idsalle').val(),
            idpatient = $('#idpatient').val(),
            date_in = $('#date_in').val(),
            action = $('#action').val(),
            act = $('.newBtn').html(),
            url = $(this).attr('action');
            idpatient = parseFloat(idpatient);
        if (idsalle!=='' && idpatient >= 0 ){
            $.ajax({
                type: 'post',
                url: url,
                data: 'idsalle='+idsalle+'&idpatient='+idpatient+'&date_in='+date_in+'&id='+id+'&action='+action,
                datatype: 'json',
                beforeSend: function () {
                    $('.newBtn').html('<i class="fa fa-refresh fa-spin fa-2x"></i>').prop('disabled', true);
                },
                success: function (json) {
                    if (json.statuts === 0){
                        //$('#addPays').modal('hide');
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
                error: function(jqXHR, textStatus, errorThrown){}
            });
        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }

    });

    $(document).on('click','.trash', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "L'hospitalisation va être supprimée.",
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
                        data: 'id='+id,
                        datatype: 'json',
                        beforeSend: function () {
                            run_waitMe(current_effect,loadingText);
                        },
                        complete: function () {
                            dismiss_waitMe();
                        },
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
    /*
       ***** Debut chargement client par ajax select2
        */
    var select2Option = {
        dropdownParent: $("#newModal"),
        language: "fr",
        ajax: {
            url: "http://digitalstock.log/patient.json",
            dataType: 'json',
            delay: 250,
            width: '100%',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                data.clients.text = data.clients.nom;
                return {
                    results: data.clients,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Choisir un patient',
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    };
    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.nom + "</div>" +
            "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'><i class='fa fa-phone'></i> <b>" +repo.numero+ "</b></div>" +
            "</div></div>";
        return markup;
    }
    function formatRepoSelection (repo) {
        return repo.nom || 'Saisir le nom ou lu numéro du patient';
    }
    /*
    ***** Fin chargement client par ajax select2
     */
});