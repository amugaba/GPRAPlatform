/**
 * Created by tiddd on 9/27/2016.
 */
var DEBUG = false;
var HTTP_ROOT = '';

function ajax(func, params, callback) {
    if(params == null)
        params = [];

    $.ajax({
        type: "POST",
        url: HTTP_ROOT + func,
        data: JSON.stringify({
            'params': params
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(result){
            if(!result.success) {
                handleAjaxError(result.msg);
            }
            else {
                if(callback != null)
                    callback(result);
            }
        },
        failure: function(result) {
            handleAjaxError(result.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            handleAjaxError(jqXHR.responseText + func + JSON.stringify(params) + textStatus + errorThrown);
        }
    });
}

function handleAjaxError(errorMessage) {
    console.log(errorMessage.replace(/<br>/g,'\n').replace(/<.{1,2}>/g,''));
    if(DEBUG) {
        $("#errorlog").html(errorMessage);
    } else {
        //location.href = HTTP_ROOT+'error.php'; //not implemented yet
    }
}

function sendMail(func, params, callback) {
    if(params == null)
        params = [];

    $.ajax({
        type: "POST",
        url: HTTP_ROOT + "php/ajax-mail.php",
        data: JSON.stringify({
            'function': func,
            'params': params
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(result){
            if(!result.success) {
                alert(result.msg);
            }
            else {
                callback(result);
            }
        },
        failure: function(result) {
            alert(result.msg);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            alert(errorThrown);
        }
    });
}

var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
function getMonth(monthNum) {
    return months[monthNum-1];
}

Vue.component('error', {
    props: ['field'],
    template: '<span class="error" v-if="field.errors && field.dirty">{{field.errors[0].message}}</span>'
});

Vue.component('result', {
    props: ['field'],
    template: '<div v-if="field != null" :class="{success: field.success, error: !field.success}">{{field.msg}}<br></div>'
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
    return moment(value).format("MMM D, Y")
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