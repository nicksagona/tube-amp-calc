/**
 * tubecalc.js
 */

var tubecalc = {
    decimal : 4,
    round   : function(value) {
        return Number(Math.round(value + 'e' + tubecalc.decimal) + 'e-' + tubecalc.decimal).toString()
    },

    volts : function() {
        var i = parseFloat($('#i_variable_1_1').val());
        var r = parseFloat($('#r_variable_1_1').val());

        if (!isNaN(i) && !isNaN(r)){
            var v = i * r;
            if (!isNaN(v)) {
                $('#v_variable_1_1').val(tubecalc.round(v) + ' V');
            }
        }
    },

    ohms : function() {
        var v = parseFloat($('#v_variable_1_2').val());
        var i = parseFloat($('#i_variable_1_2').val());

        if (!isNaN(v) && !isNaN(i) && (i != 0)){
            var r = v / i;
            if (!isNaN(r)) {
                $('#r_variable_1_2').val(tubecalc.round(r) + ' Ω');
            }
        }
    },

    amps : function() {
        var v = parseFloat($('#v_variable_1_3').val());
        var r = parseFloat($('#r_variable_1_3').val());

        if (!isNaN(v) && !isNaN(r) && (r != 0)){
            var i = v / r;
            if (!isNaN(i)) {
                $('#i_variable_1_3').val(tubecalc.round(i) + ' A');
            }
        }
    },

    watts : function() {
        var i = parseFloat($('#i_variable_2_1').val());
        var v = parseFloat($('#v_variable_2_1').val());

        if (!isNaN(i) && !isNaN(v)){
            var p = i * v;
            if (!isNaN(p)) {
                $('#p_variable_2_1').val(tubecalc.round(p) + ' W');
            }
        }
    },

    ohms2 : function() {
        var p = parseFloat($('#p_variable_2_2').val());
        var i = parseFloat($('#i_variable_2_2').val());

        if (!isNaN(p) && !isNaN(i) && (i != 0)){
            var v = p / i;
            if (!isNaN(v)) {
                $('#v_variable_2_2').val(tubecalc.round(v) + ' V');
            }
        }
    },

    amps2 : function() {
        var p = parseFloat($('#p_variable_2_3').val());
        var v = parseFloat($('#v_variable_2_3').val());

        if (!isNaN(p) && !isNaN(v) && (v != 0)){
            var i = p / v;
            if (!isNaN(i)) {
                $('#i_variable_2_3').val(tubecalc.round(i) + ' A');
            }
        }
    },

    watts2 : function() {
        var v = parseFloat($('#v_variable_3_1').val());
        var r = parseFloat($('#r_variable_3_1').val());

        if (!isNaN(v) && !isNaN(r) && (r != 0)){
            var p = (v * v) / r;
            if (!isNaN(p)) {
                $('#p_variable_3_1').val(tubecalc.round(p) + ' W');
            }
        }
    },

    watts3 : function() {
        var r = parseFloat($('#r_variable_3_2').val());
        var i = parseFloat($('#i_variable_3_2').val());

        if (!isNaN(r) && !isNaN(i)){
            var p = r * (i * i);
            if (!isNaN(p)) {
                $('#p_variable_3_2').val(tubecalc.round(p) + ' W');
            }
        }
    },

    ohms3 : function() {
        var v = parseFloat($('#v_variable_3_3').val());
        var p = parseFloat($('#p_variable_3_3').val());

        if (!isNaN(v) && !isNaN(p) && (p != 0)){
            var r = (v * v) / p;
            if (!isNaN(r)) {
                $('#r_variable_3_3').val(tubecalc.round(r) + ' Ω');
            }
        }
    },

    ohms4 : function() {
        var p = parseFloat($('#p_variable_3_4').val());
        var i = parseFloat($('#i_variable_3_4').val());

        if (!isNaN(p) && !isNaN(i) && (i != 0)){
            var r = p / (i * i);
            if (!isNaN(r)) {
                $('#r_variable_3_4').val(tubecalc.round(r) + ' Ω');
            }
        }
    },

    volts2 : function() {
        var p = parseFloat($('#p_variable_3_5').val());
        var r = parseFloat($('#r_variable_3_5').val());

        if (!isNaN(p) && !isNaN(r)){
            var v = Math.sqrt(p * r);
            if (!isNaN(v)) {
                $('#v_variable_3_5').val(tubecalc.round(v) + ' V');
            }
        }
    },

    amps3 : function() {
        var p = parseFloat($('#p_variable_3_6').val());
        var r = parseFloat($('#r_variable_3_6').val());

        if (!isNaN(p) && !isNaN(r) && (r != 0)){
            var i = Math.sqrt(p / r);
            if (!isNaN(i)) {
                $('#i_variable_3_6').val(tubecalc.round(i) + ' A');
            }
        }
    },

    reset : function(fields, num) {
        for (var x = 0; x < fields.length; x++) {
            var fieldName = '#' + fields[x] + '_variable_' + num.toString();
            if ($(fieldName)[0] != undefined) {
                $(fieldName).val('');
            }
        }

        return false;
    },

    resetAll : function() {
        $('input[type=text]').val('');

        return false;
    }
};

module.exports = tubecalc;


$(document).ready(function(){
    $('#i_variable_1_1').keyup(tubecalc.volts);
    $('#r_variable_1_1').keyup(tubecalc.volts);

    $('#v_variable_1_2').keyup(tubecalc.ohms);
    $('#i_variable_1_2').keyup(tubecalc.ohms);

    $('#v_variable_1_3').keyup(tubecalc.amps);
    $('#r_variable_1_3').keyup(tubecalc.amps);

    $('#i_variable_2_1').keyup(tubecalc.watts);
    $('#v_variable_2_1').keyup(tubecalc.watts);

    $('#p_variable_2_2').keyup(tubecalc.ohms2);
    $('#i_variable_2_2').keyup(tubecalc.ohms2);

    $('#p_variable_2_3').keyup(tubecalc.amps2);
    $('#v_variable_2_3').keyup(tubecalc.amps2);

    $('#v_variable_3_1').keyup(tubecalc.watts2);
    $('#r_variable_3_1').keyup(tubecalc.watts2);

    $('#r_variable_3_2').keyup(tubecalc.watts3);
    $('#i_variable_3_2').keyup(tubecalc.watts3);

    $('#v_variable_3_3').keyup(tubecalc.ohms3);
    $('#p_variable_3_3').keyup(tubecalc.ohms3);

    $('#p_variable_3_4').keyup(tubecalc.ohms4);
    $('#i_variable_3_4').keyup(tubecalc.ohms4);

    $('#p_variable_3_5').keyup(tubecalc.volts2);
    $('#r_variable_3_5').keyup(tubecalc.volts2);

    $('#p_variable_3_6').keyup(tubecalc.amps3);
    $('#r_variable_3_6').keyup(tubecalc.amps3);
});