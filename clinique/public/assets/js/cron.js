if($('[data-toggle="summernote"]').length){
    $('[data-toggle="summernote"]').summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    })
}

/**
 * Created by Ndjeunou on 03/08/2017.
 */
$(document).ready(function(){

    /*****
     *
     *
     */
    var sendAll = null;

    var $modal = $("#detailModal");
    $(document).on('change','#selectAll', function (e) {
        e.preventDefault();
        if(this.is(':checked'))
            $(".selected").attr('checked',true);
        else
            $(".selected").attr('checked',false);
        setText();
        if (selected().length >= 1) {
            $("#toolbox").fadeIn(300);
        }else{
            $("#toolbox").fadeOut();
        }
    });
    $(document).on('change','.selected', function(e){
        setText();
        if (selected().length >= 1) {
            $("#toolbox").fadeIn(300);
        }else{
            $("#toolbox").fadeOut();
        }
    });
    var setText = function(){
        var selecte = selected();
        if(selecte.length != 0){
            $('#envoieMail').text('Email '+selecte.length);
            $('#envoieSms').text('SMS '+selecte.length);
            $('#couponAll').text('Coupon de réduction '+selecte.length);
        }else{
            $('#envoieMail').text("Email à tous");
            $('#envoieSms').text("SMS à tous");
            $('#couponAll').text("Coupon de réduction à tous");
        }
        if ($('.selected').length === selecte.length){
            $('#selectAll').prop('checked',true);
        }else{
            $('#selectAll').prop('checked',false);
        }
    };
    var selected = function(){
        var $selected = [];
        $('input.selected:checkbox:checked').each(function () {
            $selected.push($(this).val());
        });
        return $selected;
    };

//debut travail Arlette


    var content1 = $("#smsFormTemplate").html();
    var content2 = $("#mailFormTemplate").html();
    var content3 = $("#couponFormTemplate").html();

    $(document).on('click','#couponAll', function(e){
        e.preventDefault();
        sendAll = true;
        var url = $(this).data('url');
        $('.titreDetails').text('Donner un coupon de réduction à ('+selected().length+')');
        $('.contenuDetails').html('').append(content3);
        $('#detailModal').modal();
        $('#dFin1').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: '+1d'
        });
        $modal.find('.url').val(url);
    });
    $(document).on('click','#envoieSms', function(e){
        e.preventDefault();
        sendAll = true;
        var url = $(this).data('url');
        $('.titreDetails').text('Envoyer un SMS aux clients ('+selected().length+')');
        $('.contenuDetails').html('').append(content1);
        $('#detailModal').modal();
        $modal.find('.url').val(url);
    });
    $(document).on('click','#envoieMail', function(e){
        e.preventDefault();
        sendAll = true;
        var url = $(this).data('url');
        $('.titreDetails').text('Envoyer un email aux clients ('+selected().length+')');
        $('.contenuDetails').html('').append(content2);
        $('#detailModal').modal();
        $('#messageAbonneMailAll').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        $modal.find('.url').val(url);
    });


        /*
        *
        *  SOUMISSION DES FORMULAIRE
        *
        *
        *  */
    
    $(document).on('submit','#form-sendMail', function(e){
        e.preventDefault();
        var datas = selected();

        var $form = $(this),
            subject = $('#subjectMailAll').val(),
            message = $('#messageAbonneMailAll').val();
            url = $modal.find('.url').val();
        if(subject!='' && message!=''){
            $.ajax({
                type: 'post',
                url: url,
                data: 'subject='+subject+'&message='+message+'&datas='+datas,
                datatype: 'json',
                beforeSend: function () {
                    $('.contenuDetails').addClass('none');
                    $('.loaderCard').removeClass('none');
                },
                success: function (json) {
                    if(json.statuts === 0){
                        toastr.success(json.mes,'Succès');
                        $('.alertJsText').text(json.mes);
                        $('.alerter').removeClass('hide');
                        $('#detailModal').modal('hide');
                        $('#subjectMailAll').val('');
                        $('#messageAbonneMailAll').val('');
                    }else{
                        showAlert($form,2,json.mes);
                        toastr.error(json.mes,'error',5);
                    }
                },

                complete: function () {
                    $('.contenuDetails').removeClass('none');
                    $('.loaderCard').addClass('none');
                },

                error: function(jqXHR, textStatus, errorThrown){
                    alert('erreur : '+errorThrown);
                }
            });
        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });

    $(document).on("keyup","#messageAbonneSMSPerso",function(event){
        checkTextAreaMaxLength(this,event);
    });
    $(document).on("keyup","#messageAbonneSMSAll",function(event){
        checkTextAreaMaxLength(this,event);
    });
    function checkTextAreaMaxLength(textBox, e) {
        var maxLength = parseInt($(textBox).data("length"));
        if (!checkSpecialKeys(e)) {
            if (textBox.value.length > maxLength - 1) textBox.value = textBox.value.substring(0, maxLength);
        }
        var res = maxLength - textBox.value.length;
        var text = res>1?res+" caractères restants":res+ " caractère restant";
        /*if (res < 0){
         $('#message').css('border-color','#a94442');
         }else{
         $('#message').css('border-color','#3c763d');
         }*/
        $(".char-count").html(text);
        return true;
    }
    function checkSpecialKeys(e) {
        if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40)
            return false;
        else
            return true;
    }

    $(document).on('submit','#form-sendSms', function(e){
        e.preventDefault();
        var datas = selected();
        var message = $('#messageAbonneSMSAll').val(),
            $form = $(this),
            url = $modal.find('.url').val();
        if(message!=' '){
            $.ajax({
                type: 'post',
                url: url,
                data: 'message='+message+'&datas='+datas,
                datatype: 'json',
                beforeSend: function () {
                    $('.contenuDetails').addClass('none');
                    $('.loaderCard').removeClass('none');
                },
                success: function (json) {
                    if(json.statuts === 0){
                        toastr.success(json.mes,'Succès');
                        $('.alertJsText').text(json.mes);
                        $('.alerter').removeClass('hide');
                        $('#detailModal').modal('hide');
                        $('#messageAbonne').val('');
                    }else{
                        showAlert($form,2,json.mes);
                        toastr.info(json.mes,'error',5);
                    }
                },

                complete: function () {
                    $('.contenuDetails').removeClass('none');
                    $('.loaderCard').addClass('none');
                },

                error: function(jqXHR, textStatus, errorThrown){
                    alert('erreur : '+errorThrown);
                }
            });

        }else{
            toastr.error('Veuillez remplir correctement tous les champs requis','Oups!');
            showAlert($form,2,'Veuillez remplir correctement tous les champs requis');
        }
    });

    $(document).on('submit','#form-coupon', function(e){
        e.preventDefault();
        var datas = selected();
            url = $modal.find('.url').val();
        var cat = $('#cat1').val(),
            val = $('#val1').val(),
            titre = $('#titre1').val(),
            fin = $('#dFin1').val(),
            minimal = $('#minimal1').val(),
            $form = $(this),
            point = $('#points1').val();
        $.ajax({
            type: 'post',
            url: url,
            data: 'cat='+cat+'&val='+val+'&titre='+titre+'&fin='+fin+'&minimal='+minimal+'&point='+point+'&datas='+datas,
            datatype: 'json',
            beforeSend: function () {
                $('.contenuDetails').addClass('none');
                $('.loaderCard').removeClass('none');
            },
            success: function (json) {
                if(json.statuts === 0){
                    toastr.success(json.mes,'Succès');
                    $('.alertJsText').text(json.mes);
                    $('.alerter').removeClass('hide');
                    $('#detailModal').modal('hide');
                }else{
                    showAlert($form,2,json.mes);
                    toastr.info(json.mes,'error',5);
                }
            },

            complete: function () {
                $('.contenuDetails').removeClass('none');
                $('.loaderCard').addClass('none');
            },

            error: function(jqXHR, textStatus, errorThrown){
                alert('erreur : '+errorThrown);
            }
        });
    });

});