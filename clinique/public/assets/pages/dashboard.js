$(document).ready(function() {

    /*
     * Start Range
      */

    var start = moment().subtract(1, 'month');
    var end = moment();
    moment.locale('fr');

    function cb1(start, end) {
        $('.reportrange1 span').html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));
        $('#dCA1').val(start.format('DD-MM-YYYY'));
        $('#dCA2').val(end.format('DD-MM-YYYY'));
        loader('.dCA',start.format('DD-MM-YYYY'),end.format('DD-MM-YYYY'),1);
    }

    function cb2(start, end) {
        $('.reportrange2 span').html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));
        $('#dCB1').val(start.format('DD-MM-YYYY'));
        $('#dCB2').val(end.format('DD-MM-YYYY'));
        loader('.dCB',start.format('DD-MM-YYYY'),end.format('DD-MM-YYYY'),2);
    }

    function loader(element,debut,fin,way){
        $.ajax({
            type: 'post',
            url: 'http://clinique.log/home/loader',
            data: 'debut='+debut+'&fin='+fin+'&way='+way,
            datatype: 'json',
            beforeSend: function () {
                if(way===1)
                    $('#flotchart1').html('<p class="text-center" style="padding-top: 140px;"><img class="img-xs" src="http://clinique.log/public/assets/images/load.gif" alt=""></p>');
                else
                    $('#flotchart2').html('<p class="text-center" style="padding-top: 140px;"><img class="img-xs" src="http://clinique.log/public/assets/images/load.gif" alt=""></p>');
            },
            success: function (json) {
                if (json.statuts === 0) {
                    $(element).html('<small class="text-xs">$</small> <span class="counter text-primary">'+thousands(json.value)+'</span>');
                    $(element +' .counter').counterUp({
                        delay: 10,
                        time: 1000
                    });
                    if(way===1){
                        var data = [];
                        for (var j = 0; j<json.commandes.length; j++){
                            data.push([j, json.commandes[j].paid_amount]);
                        }
                        var dataset =  [
                            {
                                data: data
                            }
                        ];
                        var ticks = [[0, "1"], [1, "2"], [2, "3"], [3, "4"], [4, "5"], [5, "6"], [6, "7"], [7, "8"],
                            [8, "9"], [9, "10"], [10, "11"], [11, "12"], [12, "13"], [13, "14"], [14, "15"], [15, "16"],
                            [16, "17"], [17, "18"], [18, "19"], [19, "20"], [20, "21"], [21, "22"], [22, "23"], [23, "24"], [24, "25"]];
                        var plot1 = $.plot("#flotchart1", dataset, {
                            series: {
                                color: "#00008B",
                                bars: {
                                    show: true,
                                    lineWidth: 2,
                                    barWidth: 1,
                                    fill: true,
                                    fillColor: null,
                                    align: "left",
                                    horizontal: false,
                                    zero: true
                                },
                                shadowSize: 3,
                                points: {show: true, radius: 3, lineWidth: 2, fill: true, fillColor: "#ffffff", symbol: "circle"},
                            },
                            yaxis: {
                                tickSize: 10000
                            },
                            xaxis: {
                                ticks: ticks
                            },
                            legend: {
                                show: true
                            },
                            grid: {
                                color: "rgba(120,130,140,1)",
                                hoverable: true,
                                borderWidth: 0,
                                backgroundColor: 'transparent'
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "$ %y",
                                defaultTheme: false
                            }
                        });
                    }else{
                        var data2 = [];
                        for (var k = 0; k<json.projets.length; k++){
                            data2.push([k, json.projets[k].project_price]);
                        }
                        var dataset2 =  [
                            {
                                data: data2
                            }
                        ];
                        var ticks2 = [[0, "1"], [1, "2"], [2, "3"], [3, "4"], [4, "5"], [5, "6"], [6, "7"], [7, "8"],
                            [8, "9"], [9, "10"], [10, "11"], [11, "12"], [12, "13"], [13, "14"], [14, "15"], [15, "16"],
                            [16, "17"], [17, "18"], [18, "19"], [19, "20"], [20, "21"], [21, "22"], [22, "23"], [23, "24"], [24, "25"]];
                        var plot2 = $.plot("#flotchart2", dataset2, {
                            series: {
                                color: "#00008B",
                                bars: {
                                    show: true,
                                    lineWidth: 2,
                                    barWidth: 1,
                                    fill: true,
                                    fillColor: null,
                                    align: "left",
                                    horizontal: false,
                                    zero: true
                                },
                                shadowSize: 3,
                                points: {show: true, radius: 3, lineWidth: 2, fill: true, fillColor: "#ffffff", symbol: "circle"},
                            },
                            yaxis: {
                                tickSize: 10000
                            },
                            xaxis: {
                                ticks: ticks2
                            },
                            legend: {
                                show: true
                            },
                            grid: {
                                color: "rgba(120,130,140,1)",
                                hoverable: true,
                                borderWidth: 0,
                                backgroundColor: 'transparent'
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "$ %y",
                                defaultTheme: false
                            }
                        });
                    }
                }else{
                    toastr.error(json.mes,"Oups!");
                }
            },
            complete: function () {},
            error: function (jqXHR, textStatus, errorThrown) {
                if(way===1)
                    $('#flotchart1').html('');
                else
                    $('#flotchart2').html('');
                toastr.error(errorThrown,"Oups!");
            }
        });
    }

    $('.reportrange1').daterangepicker({
        "locale": {
            "format": "DD-MM-YYYY",
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "A",
            "customRangeLabel": "Personnaliser",
            "daysOfWeek": [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu",
                "Ven",
                "Sam"
            ],
            "monthNames": [
                "Janvier",
                "Février",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Décembre"
            ],
            "firstDay": 1
        },
        startDate: start,
        endDate: end,
        ranges: {
            'Aujourd\'hui': [moment(), moment()],
            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
            "Mois passé": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            "Mois surpassé": [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')],
            "3 derniers mois": [moment().subtract(2, 'month').startOf('month'), moment().endOf('month')],
            "6 derniers mois": [moment().subtract(5, 'month').startOf('month'), moment().endOf('month')],
            "9 derniers mois": [moment().subtract(8, 'month').startOf('month'), moment().endOf('month')],
            "12 derniers mois": [moment().subtract(11, 'month').startOf('month'), moment().endOf('month')]
        }
    }, cb1);

    $('.reportrange2').daterangepicker({
        "locale": {
            "format": "DD-MM-YYYY",
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "A",
            "customRangeLabel": "Personnaliser",
            "daysOfWeek": [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu",
                "Ven",
                "Sam"
            ],
            "monthNames": [
                "Janvier",
                "Février",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Décembre"
            ],
            "firstDay": 1
        },
        startDate: start,
        endDate: end,
        ranges: {
            'Aujourd\'hui': [moment(), moment()],
            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
            "Mois passé": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            "Mois surpassé": [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')],
            "3 derniers mois": [moment().subtract(2, 'month').startOf('month'), moment().endOf('month')],
            "6 derniers mois": [moment().subtract(5, 'month').startOf('month'), moment().endOf('month')],
            "9 derniers mois": [moment().subtract(8, 'month').startOf('month'), moment().endOf('month')],
            "12 derniers mois": [moment().subtract(11, 'month').startOf('month'), moment().endOf('month')]
        }
    }, cb2);

    //cb1(start, end);
    //cb2(start, end);

    /*
    * End
     */

    // CounterUp Plugin
    /*$('.counter').counterUp({
        delay: 10,
        time: 1000
    });*/


    $.ajax({
        type: 'post',
        url: 'http://clinique.log/home/charts',
        datatype: 'json',
        beforeSend: function () {
            $('.counter').html('<img class="img-sl" src="http://clinique.log/public/assets/images/load.gif" alt="">');
            $('#flotchart1').html('<p class="text-center" style="padding-top: 140px;"><img class="img-xs" src="http://clinique.log/public/assets/images/load.gif" alt=""></p>');
            $('#flotchart2').html('<p class="text-center" style="padding-top: 140px;"><img class="img-xs" src="http://clinique.log/public/assets/images/load.gif" alt=""></p>');
        },
        success: function (json) {
            if (json.statuts === 0) {

                $('.clients1').html(thousands(json.clients1.Total));
                $('.clients2').html(thousands(json.clients2.Total));
                $('.clients3').html(thousands(json.clients3.Total));

                $('.affilies1').html(thousands(json.affilies1.Total));
                $('.affilies2').html(thousands(json.affilies2.Total));
                $('.affilies3').html(thousands(json.affilies3.Total));

                $('.rdv1').html(thousands(json.rdv1.Total));
                $('.rdv2').html(thousands(json.rdv2.Total));
                $('.rdv3').html(thousands(json.rdv3.Total));

                $('.projets1').html(thousands(json.projets1.Total));
                $('.projets2').html(thousands(json.projets2.Total));
                $('.projets3').html(thousands(json.projets3.Total));

                $('.conseils1').html(thousands(json.conseils1.Total));
                $('.conseils2').html(thousands(json.conseils2.Total));
                $('.conseils3').html(thousands(json.conseils3.Total));

                $('.pro1').html(thousands(json.pro1.Total));
                $('.pro2').html(thousands(json.pro2.Total));
                $('.pro3').html(thousands(json.pro3.Total));

                $('.com1').html(thousands(json.com1.Total));
                $('.com2').html(thousands(json.com2.Total));
                $('.com3').html(thousands(json.com3.Total));

                $('.prod1').html(thousands(json.prod1.somme));
                $('.prod2').html(thousands(json.prod2.Total));
                $('.prod3').html(thousands(json.prod3.Total));

                $('.ret1').html(thousands(json.ret1.somme));
                $('.ret2').html(thousands(json.ret2.Total));
                $('.ret3').html(thousands(json.ret3.Total));

                $('.art1').html(thousands(json.art1.somme));
                $('.art2').html(thousands(json.art2.Total));
                $('.art3').html(thousands(json.art3.Total));

                $('.ventes1').html(thousands(json.com1.somme));
                $('.ventes2').html(thousands(json.com2.somme));

                $('.proj1').html(thousands(json.proj1.somme));
                $('.proj2').html(thousands(json.proj2.somme));

                $('.counter').counterUp({
                    delay: 10,
                    time: 1000
                });

                var data = [];
                for (var j = 0; j<json.commandes.length; j++){
                    data.push([j, json.commandes[j].paid_amount]);
                }
                var dataset =  [
                    {
                        data: data
                    }
                ];
                var ticks = [[0, "1"], [1, "2"], [2, "3"], [3, "4"], [4, "5"], [5, "6"], [6, "7"], [7, "8"],
                    [8, "9"], [9, "10"], [10, "11"], [11, "12"], [12, "13"], [13, "14"], [14, "15"], [15, "16"],
                    [16, "17"], [17, "18"], [18, "19"], [19, "20"], [20, "21"], [21, "22"], [22, "23"], [23, "24"], [24, "25"]];
                var plot1 = $.plot("#flotchart1", dataset, {
                    series: {
                        color: "#00008B",
                        bars: {
                            show: true,
                            lineWidth: 2,
                            barWidth: 1,
                            fill: true,
                            fillColor: null,
                            align: "left",
                            horizontal: false,
                            zero: true
                        },
                        shadowSize: 3,
                        points: {show: true, radius: 3, lineWidth: 2, fill: true, fillColor: "#ffffff", symbol: "circle"},
                    },
                    yaxis: {
                        tickSize: 10000
                    },
                    xaxis: {
                        ticks: ticks
                    },
                    legend: {
                        show: true
                    },
                    grid: {
                        color: "rgba(120,130,140,1)",
                        hoverable: true,
                        borderWidth: 0,
                        backgroundColor: 'transparent'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "$ %y",
                        defaultTheme: false
                    }
                });

                var data2 = [];
                for (var k = 0; k<json.projets.length; k++){
                    data2.push([k, json.projets[k].project_price]);
                }
                var dataset2 =  [
                    {
                        data: data2
                    }
                ];
                var ticks2 = [[0, "1"], [1, "2"], [2, "3"], [3, "4"], [4, "5"], [5, "6"], [6, "7"], [7, "8"],
                    [8, "9"], [9, "10"], [10, "11"], [11, "12"], [12, "13"], [13, "14"], [14, "15"], [15, "16"],
                    [16, "17"], [17, "18"], [18, "19"], [19, "20"], [20, "21"], [21, "22"], [22, "23"], [23, "24"], [24, "25"]];
                var plot2 = $.plot("#flotchart2", dataset2, {
                    series: {
                        color: "#00008B",
                        bars: {
                            show: true,
                            lineWidth: 2,
                            barWidth: 1,
                            fill: true,
                            fillColor: null,
                            align: "left",
                            horizontal: false,
                            zero: true
                        },
                        shadowSize: 3,
                        points: {show: true, radius: 3, lineWidth: 2, fill: true, fillColor: "#ffffff", symbol: "circle"},
                    },
                    yaxis: {
                        tickSize: 10000
                    },
                    xaxis: {
                        ticks: ticks2
                    },
                    legend: {
                        show: true
                    },
                    grid: {
                        color: "rgba(120,130,140,1)",
                        hoverable: true,
                        borderWidth: 0,
                        backgroundColor: 'transparent'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "$ %y",
                        defaultTheme: false
                    }
                });
            }else{
                toastr.error(json.mes,"Oups!");
            }
        },
        complete: function () {},
        error: function (jqXHR, textStatus, errorThrown) {
            $('#flotchart1').html('');
            $('#flotchart2').html('');
            $('#counter').html('');
            toastr.error(errorThrown,"Oups!");
        }
    });

});