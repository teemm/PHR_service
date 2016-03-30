(function ($) {
    $.waitBox = function (action) {
        try {
            var div = null;
            if ($('.waitbox')[0]) {
                div = $('.waitbox')[0];
            } else {
                var div = document.createElement('div');
                div.setAttribute('style', 'display: none;');
                $(div).addClass('waitbox');

                var divProgress = document.createElement('div');
                $(divProgress).addClass('waitbox-progressbar');
                $(divProgress).appendTo($(div));

                $(div).appendTo('body');

                $(div).dialog({
                    autoOpen: false,
                    //width: 320,
                    //height: 80,
                    title: null,
                    modal: true,
                    resizable: false,
                    open: function () {
                        $(".waitbox-progressbar").progressbar({
                            value: false
                        });
                        $('.waitbox').parent().find('.ui-dialog-titlebar').remove();
                        $('.waitbox').css('min-height', '');
                        $('.waitbox').css('padding', '0px');
                        $('.waitbox').parent().css('padding', '0px');
                    }

                });
            }

            $(div).dialog(action);
            //            if (action === 'open') $(div).dialog('open');
            //            if (action === 'close') $(div).dialog('close');
        }
        catch (ex) {
            alert(ex);
        }
    };

    /// <summary>
    /// methodType - "post", "get";
    /// url - "/controller/method";
    /// confirmText - string, null (request-ის გაკეთებამდე მესიჯის გამოტანა);
    /// sendObj - გასაგზავნი ობიექტი {options};
    /// successFunction(data) - ფუნქცია რომელიც გამოიძახება წარმატების შემთხვევაში;
    /// errorFunction(errorMsg) - ფუნქცია რომელიც გამოიძახება წარუმატებლობის შემთხვევაში;
    /// waitBoxOn - true, (false, null) სანამ სრულდება request, მანამდე load...
    /// chainFunction - სრულდება request-ების ჯაჭვში
    /// </summary>
    $.ajaxRequest = function (methodType, url, confirmText, sendObj,
        successFunction, errorFunction, waitBoxOn, chainFunction) {
        var confirmed = true;
        if (confirmText !== null) {
            confirmed = confirm(confirmText);
        }
        if (confirmed) {
            $.ajax({
                type: methodType,
                url: $.getPath(url),
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded',
                async: false,
                data: sendObj,
                beforeSend: function () {
                    if (waitBoxOn === true) {
                        $.waitBox('open');
                    }
                },
                complete: function (jqXHR, textStatus) {
                    if (textStatus === 'success') {
                        var data = JSON.parse(jqXHR.responseText);
                        if (data) {
                            if (data.success) {
                                if (successFunction) successFunction(data.data, data.totalRecords);
                            } else {
                                if (errorFunction) errorFunction(data.msg);
                            }
                        }
                    } else {
                        var data = JSON.parse(jqXHR.responseText);
                        if (errorFunction) errorFunction(data.msg);
                    }
                    if (waitBoxOn === true) {
                        $.waitBox('close');
                    }
                }
            }).then(function (jqXHR, textStatus, obj) {
                if (jqXHR.success === true && $.isFunction(chainFunction)) {
                    chainFunction(jqXHR.data);
                }
            });
        }
    };

    $.getPath = function (actionLink) {
        return 'http://' + window.location.host + actionLink;
    };

    $.parseInt = function (val) {
        var result = parseInt(val);
        if (isNaN(result)) return null;
        return result;
    };

    $.parseFloat = function (val) {
        var result = parseFloat(val);
        if (isNaN(result)) return null;
        return result;
    };

    $.getLocalTzOffset = function () {
        return new Date().getTimezoneOffset();
    };

    var _isEmptyObject = $.isEmptyObject;
    $.isEmptyObject = function (obj) {
        if (obj === null || obj === undefined || obj === '') return true;
        if (typeof obj === 'object') return _isEmptyObject(obj);
        return false;
    };

    $.isEmptyElement = function (el) {
        return $.isEmptyObject($.trim(el.html()));
    };

    $.getQueryStringParamByName = function (name) {
        name = name.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
        var match = location.search.match(new RegExp("[?&]" + name + "=([^&]+)(&|$)"));
        return match && decodeURIComponent(match[1].replace(/\+/g, " "));
    };

    $.getQueryStringParam = function () {
        var arr = window.location.href.split('/');
        return $.parseInt(arr[arr.length - 1]);
    };

    var _registeredLangs = ['ka', 'en'];
    $.getCultureFromUrl = function () {
        var arr = window.location.pathname.split('/');
        for (var i = 0; i < _registeredLangs.length; i++) {
            if (arr[1] == _registeredLangs[i]) return _registeredLangs[i];
        }
        return 'ka'; //default culture
    };

    $.tooltipAlert = function (msg) {
        if (!msg) msg = '';
        var tooltipContainer = $('.alertcontainer')[0];
        if (!tooltipContainer) {
            tooltipContainer = $('<div class="alertcontainer" ></div>').css({
                position: 'absolute',
                width: '100%',
                top: '0px'
            });
            //        .position({
            //            my: "left top",
            //            at: "left top",
            //            of: "body"
            //        });

            //  Make always visible
            //--------------------------------------------------------
            var cntYloc = parseInt($(tooltipContainer).css("top").substring(0, $(tooltipContainer).css("top").indexOf("px")));
            var offset = cntYloc + $(document).scrollTop() + "px";
            $(tooltipContainer).animate({ top: offset }, { duration: 0, queue: false });
            $(window).scroll(function () {
                var offset = cntYloc + $(document).scrollTop() + "px";
                $(tooltipContainer).animate({ top: offset }, { duration: 0, queue: false });
            });
            //--------------------------------------------------------
        }
        var tooltip = $("<div>" + msg + "</div>").css({
            'background-color': '#ffffcc',
            'text-align': 'center',
            'vertical-align': 'text-bottom',
            position: 'relative',
            width: '100%',
            height: '40px',
            'box-shadow': '2px 2px 6px #000000',
            'z-index': 1000
        }).delay(10000).fadeOut('slow');
        $(tooltipContainer).append(tooltip);

        $('body').append(tooltipContainer);
    };

})(jQuery);
