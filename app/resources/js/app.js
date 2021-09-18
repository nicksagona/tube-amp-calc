/**
 * app.js
 */

var app = {};

$(document).ready(function(){
    $(window).on('hashchange', function(e){
        var hash = window.location.hash;
        if ((hash != '') && (hash != '#top')) {
            $('#nav > li > a').prop('class', 'nav-link');
            switch (hash) {
                case '#ohms-law':
                    $('#nav > li:nth-child(1) > a').prop('class', 'nav-link active');
                    break;
                case '#voltage-div':
                    $('#nav > li:nth-child(2) > a').prop('class', 'nav-link active');
                    break;
                case '#power':
                    $('#nav > li:nth-child(3) > a').prop('class', 'nav-link active');
                    break;
                case '#rc-filter':
                    $('#nav > li:nth-child(4) > a').prop('class', 'nav-link active');
                    break;
                case '#resistance-calc':
                    $('#nav > li:nth-child(5) > a').prop('class', 'nav-link active');
                    break;
                case '#capacitance-calc':
                    $('#nav > li:nth-child(6) > a').prop('class', 'nav-link active');
                    break;
                case '#capacitance-chart':
                    $('#nav > li:nth-child(7) > a').prop('class', 'nav-link active');
                    break;
            }
        }
    });

    $('#ohms-form').submit(function(){
        var current    = $('#current').val();
        var resistance = $('#resistance').val();
        var voltage    = $('#voltage').val();

        if (((current == '') && (resistance == '')) ||
            ((resistance == '') && (voltage == '')) ||
            ((current == '') && (voltage == ''))) {
            alert('You must fill out two of the variable values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"       : "ohms",
                        "current"    : current,
                        "resistance" : resistance,
                        "voltage"    : voltage
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            console.log(json);
                            $('#answer-ohm-box').hide();
                            if (json.voltage != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>' + json.voltage + ' Volts</h4>';
                                $('#answer-ohm-box').fadeIn();
                            } else if (json.current != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>' + json.current + ' Amps</h4>';
                                $('#answer-ohm-box').fadeIn();
                            } else if (json.resistance != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>' + json.resistance + ' Ohms</h4>';
                                $('#answer-ohm-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#voltage-form').submit(function(){
        console.log('voltage');
        return false;
    });

    $('#power-form').submit(function(){
        console.log('power');
        return false;
    });

    $('#freq-form').submit(function(){
        console.log('freq');
        return false;
    });

    $('#res-form').submit(function(){
        console.log('res');
        return false;
    });

    $('#cap-form').submit(function(){
        console.log('cap');
        return false;
    });
});