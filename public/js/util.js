/**
 * Created by tiddd on 9/27/2016.
 */
let DEBUG = false;
let HTTP_ROOT = '';

function ajax(url, params, callback) {
    if(params == null)
        params = [];

    $.ajax({
        type: "POST",
        url: HTTP_ROOT + url,
        data: JSON.stringify({
            'params': params
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(result){
            if(callback != null)
                callback(result);
        },
        failure: function(result) {
            handleAjaxError(result.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            handleAjaxError(jqXHR.responseText + url + JSON.stringify(params) + textStatus + errorThrown);
        }
    });
}

function handleAjaxError(errorMessage) {
    console.log(errorMessage.replace(/<br>/g,'\n').replace(/<.{1,2}>/g,''));
    if(DEBUG) {
        $("#errorlog").html(errorMessage);
    } else {
        location.href = HTTP_ROOT+'error';
    }
}

Vue.component('error', {
    props: ['field'],
    template: '<span class="error" v-if="field.errors && field.dirty">{{field.errors[0].message}}</span>'
});

Vue.component('result', {
    props: ['field'],
    template: '<div v-if="field != null" class="result-message" :class="{success: field.success, \'error-message\': !field.success}">{{field.data}}</div>'
});

Vue.filter('yn', function(value) {
    if(value == 1)
        return 'Yes';
    else if(value == 0)
        return 'No';
    else
        return value;
});

Vue.filter('percent', function(value) {
    var num = parseFloat(value);
    if(isNaN(num))
        return '—';
    return (num*100).toFixed(1) + '%';
});

Vue.filter('money', function(value) {
    var num = parseFloat(value);
    if(isNaN(num))
        return value;
    return '$ ' + num.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

Vue.filter('money-zero', function(value) {
    var num = parseFloat(value);
    if(isNaN(num))
        return value;
    if(num == 0)
        return '—';
    return '$ ' + num.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

Vue.filter('decimal', function(value) {
    var num = parseFloat(value);
    if(isNaN(num))
        return '—';
    return num.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});
Vue.filter('int', function(value) {
    var num = parseInt(value);
    if(isNaN(num))
        return '—';
    return num.toString();
});

Vue.filter('date', function(value) {
    if(value == null)
        return null;
    return moment(value).format("M/D/Y")
});

Vue.filter('assessmentType', function(value) {
    value = parseInt(value);
    switch (value) {
        case 1: return "GPRA Intake";
        case 2: return "GPRA Discharge";
        case 3: return "GPRA Followup";
        default: return value;
    }
});

Vue.filter('gpraType', function(value) {
    value = parseInt(value);
    switch (value) {
        case 1: return "Intake";
        case 2: return "Discharge";
        case 3: return "3-Month Followup";
        case 4: return "6-Month Followup";
        default: return value;
    }
});

Vue.filter('assessmentStatus', function(status) {
    switch(status) {
        case 0: return "In Progress";
        case 1: return "Complete";
        case 2: return "Locked";
    }
    return status;
});

function isIE() {
    if (window.navigator.userAgent.indexOf("MSIE ") > 0 || !!window.navigator.userAgent.match(/Trident.*rv\:11\./))
        return true;
    else
        return false;
}
function saveCSV(csv, filename) {
    if(!isIE()) {
        csv = "data:text/csv;charset=utf-8," + csv;
        var encodedUri = encodeURI(csv);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename);
        document.body.appendChild(link); // Required for FF
        link.click();
    }
    else {
        var IEwindow = window.open();
        IEwindow.document.write('sep=,\r\n' + csv);
        IEwindow.document.close();
        IEwindow.document.execCommand('SaveAs', true, filename);
        IEwindow.close();
    }
}

function showOverlayMessage(msg, success) {
    $('#overlay-message').html(msg);
    let box = $('#overlay-box');
    box.css('display','table');

    if(success) {
        $('#overlay-success').show();
        $('#overlay-error').hide();
        box.css('opacity','1').delay(1500).fadeTo(600,0).hide(0);
    }
    else {
        $('#overlay-success').hide();
        $('#overlay-error').show();
        box.css('opacity','1').delay(3000).fadeTo(600,0).hide(0); //show errors longer
    }
}