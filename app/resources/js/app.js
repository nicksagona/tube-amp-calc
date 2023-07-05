/**
 * app.js
 */

var app = {
    addEmail: function(emailId) {
        var emailUser   = ['t','c','a','t','n','o','c'];
        var emailDomain = window.location.host.replace('www.', '').replace('calc.', '');
        var email       = emailUser.reverse().join('') + '@' + emailDomain;
        var emailHref   = 'mailto:' + email + '?subject=SonicTone+Calculator';
        var emailTags   = $(emailId);
        for (var i = 0; i < emailTags.length; i++) {
            emailTags[i].innerHTML = email;
            $(emailTags[i]).attr('href', emailHref);
        }
    }
};

$(document).ready(function(){
    $('#nav > li > a').click(function() {
        if ($(this).attr('href') == '#') {
            $('#nav > li > a').prop('class', 'nav-link');
            $(this).prop('class', 'nav-link active');

            $('div.calc-div').prop('class', 'calc-div calc-inactive');
            $('div.calc-div').css('display', 'none');
            $('#' + $(this).data('div')).fadeIn();
            return false;
        }
    });

    $('#nav > li:first-child > a').prop('class', 'nav-link active');
    $('div.calc-div').prop('class', 'calc-div calc-inactive');
    $('div.calc-div').css('display', 'none');
    $('#ohms-law').fadeIn();

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
                            $('#answer-ohm-box').hide();
                            if (json.voltage != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>V = ' + json.voltage + ' Volts</h4>';
                                $('#answer-ohm-box').fadeIn();
                            } else if (json.current != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>I = ' + json.current + ' Amps</h4>';
                                $('#answer-ohm-box').fadeIn();
                            } else if (json.resistance != undefined) {
                                $('#answer-ohm-box')[0].innerHTML = '<h4>R = ' + json.resistance + ' Ohms</h4>';
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
        var voltageIn   = $('#voltage_in').val();
        var resistance1 = $('#resistance1').val();
        var resistance2 = $('#resistance2').val();

        if ((voltageIn == '') || (resistance1 == '') || (resistance2 == '')) {
            alert('You must fill out all of the variable values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"        : "voltage-div",
                        "voltage"     : voltageIn,
                        "resistance1" : resistance1,
                        "resistance2" : resistance2
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-voltage-div-box').hide();
                            if ((json.voltage_out != undefined) && (json.db_reduction != undefined)) {
                                $('#answer-voltage-div-box')[0].innerHTML = '<h4>V<sub>(out)</sub> = ' + json.voltage_out + ' Volts<br /><span class="small">(dB: ' + json.db_reduction + ')</span></h4>';
                                $('#answer-voltage-div-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#power-form').submit(function(){
        var current = $('#current_power').val();
        var voltage = $('#voltage_power').val();
        var max     = $('#max').val();

        if ((current == '') || (voltage == '')) {
            alert('You must fill out the current and voltage variable values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"    : "power",
                        "current" : current,
                        "voltage" : voltage,
                        "max"     : max
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-power-box').hide();
                            if (json.power != undefined) {
                                var html = json.power + ' Watts';
                                if (json.dissipation != undefined) {
                                    html = html + '<br /><span class="small">(' + json.dissipation + '% dissipation)</span>';
                                }
                                $('#answer-power-box')[0].innerHTML = '<h4>' + html + '</h4>';
                                $('#answer-power-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#freq-form').submit(function(){
        var resistance  = $('#resistance_filter').val();
        var capacitance = $('#capacitance_filter').val();

        if ((resistance == '') || (capacitance == '')) {
            alert('You must fill out the current and voltage variable values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"        : "freq",
                        "resistance"  : resistance,
                        "capacitance" : capacitance,
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-freq-box').hide();
                            if (json.frequency != undefined) {
                                $('#answer-freq-box')[0].innerHTML = '<h4>' + json.frequency + ' Hz</h4>';
                                $('#answer-freq-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#res-form').submit(function(){
        var resistanceValues = $('#resistance_values').val();
        var resistanceConfig = $('input[name=res_config]:checked', '#res-form').val();

        if (resistanceValues == '') {
            alert('You must fill out the resistance values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"              : "resistance",
                        "resistance_values" : resistanceValues,
                        "resistance_config" : resistanceConfig
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-resistance-box').hide();
                            if (json.resistance != undefined) {
                                $('#answer-resistance-box')[0].innerHTML = '<h4>' + json.resistance + ' Ohms</h4>';
                                $('#answer-resistance-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#cap-form').submit(function(){
        var capacitanceValues = $('#capacitance_values').val();
        var capacitanceConfig = $('input[name=cap_config]:checked', '#cap-form').val();

        if (capacitanceValues == '') {
            alert('You must fill out the capacitance values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"              : "capacitance",
                        "capacitance_values" : capacitanceValues,
                        "capacitance_config" : capacitanceConfig
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-capacitance-box').hide();
                            if (json.capacitance != undefined) {
                                $('#answer-capacitance-box')[0].innerHTML = '<h4>' + json.capacitance.F + '<br /><span class="small">[' + json.capacitance.uF + 'uF, ' + json.capacitance.nF + 'nF, ' + json.capacitance.pF + 'pF]</span></h4>';
                                $('#answer-capacitance-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#bias-form').submit(function() {

        var ampOperation = $('#amp_operation').val();
        var ampBiasType  = $('#amp_bias_type').val();
        var ampConfig    = $('#amp_config').val();
        var tubeType     = $('#tube_type').val();
        var ot1          = $('#ot_primary_resistance_1').val();
        var ot2          = $('#ot_primary_resistance_2').val();
        var bPlus        = $('#b_plus').val();
        var pv1          = $('#plate_voltage_1').val();
        var pv2          = $('#plate_voltage_2').val();

        if ((ot1 == '') || (bPlus == '') || (pv1 == '')) {
            alert('You must fill out the B+ voltage and at least one of the OT and plate voltage values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"          : "bias",
                        "amp_operation" : ampOperation,
                        "amp_bias_type" : ampBiasType,
                        "amp_config"    : ampConfig,
                        "tube_type"     : tubeType,
                        "bPlus"         : bPlus,
                        "ot1"           : ot1,
                        "ot2"           : ot2,
                        "pv1"           : pv1,
                        "pv2"           : pv2,
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json    = xhr.responseJSON;
                            var tubeNum = (json.num_of_tubes == 4) ?' (2 Tubes)' : ' (1 Tube)';
                            $('#answer-bias-box').hide();

                            var html = '<h5>' + json.tube_type + '</h5>' +
                                '<strong>Max Plate Dissipation:</strong> ' + json.max_plate_dissipation + '<br />' +
                                '<strong>Max Plate Voltage:</strong> ' + json.max_plate_voltage + '<br />' +
                                '<strong>Max Cathode Current:</strong> ' + json.max_cathode_current + '<br />' +
                                '<strong>Number of Tubes:</strong> ' + json.num_of_tubes + '<br /><br />' +
                                '<p><em>Nominal bias target of <strong>' + json.nominal_bias + '%</strong> for a ' + json.amp_config + ' ' + json.amp_operation + ', ' + json.amp_bias_type + ' amp.</em></p>' +
                                '<div class="bias-tube-1"><h6 style="font-weight: bold;">Tube Set #1' + tubeNum + '</h6>' +
                                '<strong>Bias:</strong> ' + json.tube1_bias_point + ' (<strong class="' + json.tube1_bias_result.toLowerCase() + '">' +
                                    json.tube1_bias_result + '</strong>)<br />' +
                                '<strong>P<span class="hide">late </span>C<span class="hide">urrent</span>:</strong> ' + json.tube1_plate_current + '<br />' +
                                '<strong>P<span class="hide">late </span>D<span class="hide">issipation</span>:</strong> ' + json.tube1_plate_dissipation + '<span class="hide"> (of ' + json.max_plate_dissipation + ' max)</span><br /></div>';

                            if ((json.tube2_bias_point != undefined) && (json.tube2_bias_point != '')) {
                                html = html + '<div class="bias-tube-2"><h6 style="font-weight: bold;">Tube Set #2' + tubeNum + '</h6>' +
                                    '<strong>Bias:</strong> ' + json.tube2_bias_point + ' (<strong class="' + json.tube2_bias_result.toLowerCase() + '">' +
                                    json.tube2_bias_result + '</strong>)<br />' +
                                    '<strong>P<span class="hide">late </span>C<span class="hide">urrent</span>:</strong> ' + json.tube2_plate_current + '<br />' +
                                    '<strong>P<span class="hide">late </span>D<span class="hide">issipation</span>:</strong> ' + json.tube2_plate_dissipation + '<span class="hide"> (of ' + json.max_plate_dissipation + ' max)</span><br /></div>';
                            }

                            $('#answer-bias-box')[0].innerHTML = html;
                            $('#answer-bias-box').fadeIn();
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#b-plus-form').submit(function(){
        var vac       = $('#vac').val();
        var rectifier = $('#rectifier').val();

        if (vac == '') {
            alert('You must fill out the VAC value.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"      : "b-plus",
                        "vac"       : vac,
                        "rectifier" : rectifier
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-b-plus-box').hide();
                            if (json.upper_voltage != undefined) {
                                if (json.lower_voltage != undefined) {
                                    $('#answer-b-plus-box')[0].innerHTML = '<h4>' + json.lower_voltage + ' - ' + json.upper_voltage + ' Volts</h4>';
                                } else {
                                    $('#answer-b-plus-box')[0].innerHTML = '<h4>' + json.upper_voltage + ' Volts</h4>';
                                }

                                $('#answer-b-plus-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    $('#ot-form').submit(function(){
        var voltagePrimary   = $('#ot_voltage_primary').val();
        var voltageSecondary = $('#ot_voltage_secondary').val();
        var primaryImpedance = $('#ot_primary_impedance').val();
        var speakerImpedance = $('#ot_speaker_impedance').val();

        if (!(((primaryImpedance != '') && (speakerImpedance != '')) || ((voltageSecondary != '') && (voltagePrimary != '') && (primaryImpedance != '')) || ((voltageSecondary != '') && (voltagePrimary != '') && (speakerImpedance != '')))) {
            alert('You must either fill out both of the voltage values and either a primary or secondary impedance value; Or, you must enter both the primary and secondary values.');
        } else {
            $.ajax(
                '/process',
                {
                    "method"  : "POST",
                    "headers" : {
                        "Accept" : "application/json"
                    },
                    "data" : {
                        "type"             : "ot",
                        "voltagePrimary"   : voltagePrimary,
                        "voltageSecondary" : voltageSecondary,
                        "primaryImpedance" : primaryImpedance,
                        "speakerImpedance" : speakerImpedance
                    },
                    "complete" : function (xhr) {
                        if (xhr.responseJSON != undefined) {
                            var json = xhr.responseJSON;
                            $('#answer-ot-box').hide();
                            if ((json.speaker_impedance != undefined)) {
                                $('#answer-ot-box')[0].innerHTML = '<h4>Primary: ' + json.primary_impedance  + '; Speaker: ' + json.speaker_impedance + '<br /><span class="small">(Impedance Ratio: ' + json.impedance_ratio + ':1; Winding Ratio: ' + json.winding_ratio + ':1)</span></h4>';
                                $('#answer-ot-box').fadeIn();
                            }
                        }
                    }
                }
            );
        }

        return false;
    });

    if ($('a.contact-email')[0] != undefined) {
        app.addEmail('a.contact-email');
    }
});