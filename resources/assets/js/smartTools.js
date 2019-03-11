smartTools = {
    jqver: jQuery.fn.jquery,
    check: function(package){
        var style;
        var alert = false;
        switch(package){
            case 'PNotify':
                if( typeof (PNotify) === 'undefined') alert = true;
                break;
            case 'DataTable':
                if( typeof ($.fn.DataTable) === 'undefined') alert = true;
                break;
            case 'SmartWizard':
                if( typeof($.fn.smartWizard) === 'undefined' ) alert = true;
                break;
        }

        if( alert === true ){
            style = smartTools.logStyle('alert', 'bold');
            console.log('%c '+package+' package not found!!', style);
            return false;
        }
    },
    valueCheck: function(val, type, def){
        var value = def;

        switch(type){
            case 'isStr':
                if( typeof(val) === 'string'  ){
                    if( val.trim().length > 0 ) value = val;
                }
                break;
            case 'isNum':
                if( $.isNumeric(val) === true ) value = val;
                break;
            case 'isBoolean':
                if( typeof(val) == typeof(true) ) value = val;
                break;
            case 'isObj':
                if( typeof(val) === 'object' ) value = val;
                break;
            case 'isFunc':
                if( $.isFunction(val) === true ) value = val;
                break;
            case 'isArray':
                if( Array.isArray(val) === true ) value = val;
                break;
        }

        return value;
    },
    logStyle: function(type, weight){
        var style = new Array();
        style.push('background:'+smartTools.color(type));
        style.push('color:white');
        style.push('border-radius:3px');
        style.push('font-weight:'+weight);

        return style.join(';');
    },
    color: function(type){
        switch(type){
            case 'maintenance':
                color = '#e68a00';
                break;
            case 'warnning':
                color = '#cc9900';
                break;
            case 'alert':
                color = 'red';
                break;
            case 'success':
                color = '#4CAF50';
                break;
            case 'info':
                color = '#0099ff';
                break;
            default:
                color = '#0099ff';
                break;
        }

        return color;
    },
    Plugin: {}
};

smartTools.Plugin = {
    newNotify: function(title, content, type, closeCtrl){
        if( smartTools.check ('PNotify') === false ) return false;

        title = smartTools.valueCheck(title, 'isStr', 'Notification Box Title');
        content = smartTools.valueCheck(content, 'isStr', 'Notification Box Content');
        type = smartTools.valueCheck(type, 'isStr', 'info');  //success、info、notice、error
        var notice = new PNotify({
            title: title,
            text: content,
            type: type,
            styling: smartTools.valueCheck(arguments[4], 'isStr', 'bootstrap3'),
            icon: smartTools.valueCheck(arguments[5], 'isStr', 'fa fa-info-circle')
        });

        if( closeCtrl === 'click' ){
            notice.get().click(function() {
                notice.remove();
            });
        } else {
            var duration = smartTools.valueCheck(closeCtrl, 'isNum', 2500);
            setTimeout( function(){notice.remove();}, duration);
        }

        return notice;
    },
    newDatatable: function(selector, record, order){
        if( smartTools.check ('DataTable') === false ) return false;

        var paging;
        var defaultOrder = [0, 'asc'];

        record = smartTools.valueCheck(record, 'isNum', 10);
        paging = ( record == 0 ) ? false:true;
        if( smartTools.valueCheck(order, 'isObj', false) === false ){
            order = smartTools.valueCheck(order, 'isBoolean', false);
        } else {
            defaultOrder = order;
            order = true;
        }

        $(selector).DataTable({
            ordering: order,
            pageLength:  record,
            searching: ( typeof(arguments[3]) == 'undefined' ) ? false:arguments[3],
            paging: paging,
            info: ( typeof(arguments[4]) == 'undefined' ) ? false:arguments[4],
            responsive: false
        });
    },
    newResponsiveDatatable: function(selector, record, order, ctrlTarget){
        if( smartTools.check ('DataTable') === false ) return false;

        var paging;
        var defaultOrder = [[0, 'asc']];

        record = smartTools.valueCheck(record, 'isNum', 10);
        paging = ( record == 0 ) ? false:true;
        if( smartTools.valueCheck(order, 'isObj', false) === false ){
            order = smartTools.valueCheck(order, 'isBoolean', false);
        } else {
            defaultOrder = order;
            order = true;
        }

        $(selector).DataTable({
            ordering: order,
            pageLength:  record,
            searching: ( typeof(arguments[4]) == 'undefined' ) ? false:arguments[4],
            paging: paging,
            info: ( typeof(arguments[5]) == 'undefined' ) ? false:arguments[5],
            responsive: {
                details: {
                    type: 'column',
                    target: ctrlTarget
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets: ctrlTarget
                }
            ],
            order: defaultOrder
        });
    },
    newSmartWizard: function(selector, finishLabel, onFinish){
        if( smartTools.check ('SmartWizard') === false ) return false;

        var option;

        finishLabel = smartTools.valueCheck(finishLabel, 'isStr', 'Submit');
        onFinish = smartTools.valueCheck(onFinish, 'isFunc', false);
        option = {
            hideButtonsOnDisabled: true,
            labelFinish: finishLabel,
            fixHeight: true
        }
        if( onFinish !== false ){
            option.onFinish = onFinish;
        }
        $(selector).smartWizard(option);

        if( smartTools.valueCheck( arguments[3], 'isArray', false) !== false ){
            $('.buttonNext').addClass(arguments[3][0]);
	        $('.buttonPrevious').addClass(arguments[3][1]);
	        $('.buttonFinish').addClass(arguments[3][2]);
        }
    }
};