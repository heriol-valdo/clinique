var requiredField = "Remplissez tous les champs obligatoires";
var loadingText = "Chargement...";
var wellDoneText = "Bien joué !";
var oopsText = "Oups !";
function showAlert($form,$type,$message) {
    removeAlert();
    var $classe = '';
    if($type===1){
        $classe = ' alert-success';
        $message += '<br>Redirection en cours, veuillez patienter SVP';
        $form.find('*').prop('disabled',true);
    }else{
        $classe = ' alert-danger';
    }
    $form.prepend('<div class="alerterForm alert text-center alert-dismissible'+$classe+'">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' +
        '<span>'+$message+'</span></div>');
}
function removeAlert() {
    $('.alerterForm').remove();
}
function loadRegion(val,is,idSous) {
    $.ajax({
        type: 'post',
        url: 'http://clinique.log/localisation/loader',
        data: 'val='+val,
        datatype: 'json',
        beforeSend: function () {},
        success: function (json) {
            if (json.statuts == 0) {
                var valText = is?'Chercher par la région':'.....';
                var con = '<option value="">'+valText+'</option>';
                $('#'+idSous).html('').html(con+json.contenu);
            }
        },
        complete: function () {},
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}
function DateRanges(debut,fin) {
    var $dp_start = $('#'+debut),
        $dp_end = $('#'+fin);
    $($dp_start).datepicker({
        format: 'dd-mm-yyyy',
        todayBtn:  1,
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $dp_end.datepicker('setStartDate', minDate);
        setTimeout(function () {
            $dp_end.focus();
        }, 300);
    });

    $($dp_end).datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $dp_start.datepicker('setEndDate', maxDate);
    });
}
DateRanges('debut','end');
function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function thousand(number) {
    return number_format(number,0,',',' ');
}
function thousands(number) {
    return number_format(number,0,'.',',');
}
function thousandss(number) {
    return number_format(number,2,'.',',');
}
function handle(){
    return imReady;
}
var imReady = false;
function setReady(){
    imReady = true;
}
function run_waitMe(effect,text){
    $('body').waitMe(
        {
            effect: effect,
            text: text,
            bg: 'rgba(255,255,255,0.9)',
            color: '#000',
            maxSize: '',
            waitTime: -1,
            source: '',
            textPos: 'vertical',
            fontSize: '',
            onClose: function() {}
        })
    ;
}
function dismiss_waitMe(){
    $('body').waitMe('hide');
}
var current_effect = 'bounce';
$(document).ready(function () {
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
    setReady();
    if($('.alertJss').text() != ''){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-center",
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            timeOut: 3000
        };
        toastr.success($('.alertJss').text(),'Succès !');
    }
    if($('.alertJs').text() != ''){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-center",
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            timeOut: 3000
        };
        toastr.error($('.alertJs').text(),'Oups !');
    }
});