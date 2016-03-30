Ext.ns('cms');
cms.getRowNumbererColumn = function (colWidth) {
    /// <summary>
    /// grid-ის store-ს უნდა ქონდეს შემდეგი property :
    /// paramNames: {
    ///     start: 'Start',
    ///     limit: 'Limit',
    /// } (extjs 3.4)
    /// proxy: {
    ///     reader: {
    ///         start: 0,
    ///         limit: 10
    ///     }
    /// } (extjs 4.0.7)
    /// </summary>
    return {
        header: '', width: colWidth, renderer: function (v, p, record, rowIndex) {
            if (this.rowspan) { p.cellAttr = 'rowspan="' + this.rowspan + '"'; }
            var st = record.store;
            if (st.lastOptions != null && st.lastOptions && st.lastOptions.start != undefined && st.lastOptions.limit != undefined) {
                var page = Math.floor(st.lastOptions.start / st.lastOptions.limit);
                var limit = st.lastOptions.limit;
                return limit * page + rowIndex + 1;
            } else { return rowIndex + 1; }
        }
    };
};
cms.getCmp = function (id) {
    return Ext.getCmp(id);
};
cms.getValue = function (id) {
    if (!Ext.getCmp(id)) return null;
    return Ext.getCmp(id).getValue();
};
cms.getRawValue = function (id) {
    if (!Ext.getCmp(id)) return null;
    return Ext.getCmp(id).getRawValue();
};
cms.setValue = function (id, value) {
    if (!Ext.getCmp(id)) return;
    Ext.getCmp(id).setValue(value);
};
cms.setRawValue = function (id, value) {
    if (!Ext.getCmp(id)) return;
    Ext.getCmp(id).setRawValue(value);
};
cms.enum = function () {
    this.menuType = {
        main: 1,
        footer: 2
    };
    this.contentType = {
        static: 1,
        dynamic: 2,
        url: 3
    };
};
cms.ajaxRequest = function (url, type, paramObject, successAction, failureAction, controller, specialMsgCfg) {
    // ხელოვნური ფუნქცია სერვერთან მიმართვის.
    // url - მეთოდის მისამართი.
    // type - გამოძახების ტიპი: 
    // 1-ჩვეულებრივი გამოძახება (მესიჯით),
    // 2-გამოძახება მონაცემების შესანახად,
    // 3-გამოძახება მონაცემების წასაშლელად,
    // 4-ჩვეულებრივი გამოძახება (მესიჯების გარეშე).
    // paramObject - პარამეტრების ობიექტი.
    // successAction - ფუნქცია, რომელიც შესრულდება წარმატების შემთხვევაში.
    // failureAction - ფუნქცია, რომელიც შესრულდება წარუმატებლობის შემთხვევაში.
    // specialMsg - სპეციალური შეტყობინება გამოსაჩენად: Wait-დალოდების ტექსტი, Succ-წარმატების ტექსტი, Fail-წარუმატებლობის ტექსტი

    var waitMsg = type == 1 ? 'გთხოვთ დაელოდოთ...' : type == 2 ? 'მიმდინარეობს მონაცემების შენახვა...' :
        type == 3 ? 'მიმდინარეობს მონაცემების წაშლა...' : '';
    var successMsg = type == 2 ? 'მონაცემები დამახსოვრებულია' : type == 3 ? 'მონაცემები წაშლილია' : '';
    if ((type == 1 || type == 2 || type == 3) && specialMsgCfg != null) {
        waitMsg = specialMsgCfg.Wait;
        successMsg = specialMsgCfg.Succ;
    }
    var wait = type == 4 ? null : cms.showMessage(waitMsg, 6);

    Ext.Ajax.request({
        url: $.getPath(url),
        method: 'POST',
        defaultHeaders: { 'Content-Type': 'application/json' },
        params: paramObject,
        //jsonData: paramObject,
        //jsonData: Ext.encode(paramObject)
        //JSON.stringify(paramObject),
        //dataType: 'json',
        //contentType: 'application/json; charset=utf-8'
        success: function (result, request) {
            response = Ext.decode(result.responseText);
            //if (!isEmpty(wait)) wait.hide();
            if (response.success) {
                if (!cms.isEmpty(wait)) wait.hide();
                if (!cms.isEmpty(successMsg)) cms.showMessage(successMsg, null);
                if (!cms.isEmpty(successAction)) successAction(response.data, controller);
            }
            else {
                if (type != 4) {
                    if (!cms.isEmpty(specialMsgCfg) && !cms.isEmpty(specialMsgCfg.Fail)) cms.showMessage(specialMsgCfg.Fail, 3);
                    else cms.showMessage(response.msg, 3);
                }
                if (!cms.isEmpty(failureAction)) failureAction(response.msg);
            }
        },
        failure: function (result, request) {
            if (wait != null) wait.hide();
            cms.showMessage(result.statusText, 4);
        }
    });
};
cms.requestManager = function (finishFunction, eventName, eventObjId, arr) {
    /// <summary>
    /// ობიექტი გამოიყენება ასინქრონული მოთხოვნების სამართავად
    /// <para>გადმოსაცემი პარამეტრები:</para>
    /// <para>  finishFunction - მოთხოვნების დასრულების შემდეგ შესასრულებელი მეთოდი. (თუ არაფერი გადაეცემა არაფერი სრულდება, ანუ შეცდომა არ მოხდება)</para>
    /// <para>  arr - მასივი რომელსაც გამოიყენებს რექვესთების სამართავად. იწერება რექვესთის იდენთიფიკატორი (ახლა არ გამოიენება) </para>
    /// <para>  eventName - ევენთის სახელი, რომელსაც გამოისვრის მოთხოვნების დასრულების შემდეგ (გამორთულია)</para>
    /// <para>  eventObjId - ობიექტის იდენთიფიკატორი, რომლისთვისაც გამოისვრის eventName ევენთს (გამორთულია)</para>
    /// <para>ობიექტის მეთოდები:</para>
    /// <para>  Start - მოთხოვნის დაწყების მარეგისტრირებელი. გამოიძახება ყველა მოთხოვნის დაწყების წინ</para>
    /// <para>  Finish - მოთხოვნის დასრულების მაიდენთიფიცირებელი. გამოიძახება მოთხოვნების ქოლლბექში</para>
    /// <para>  WaitAll - ლოდინის დაწყების მეთოდი. გამოიძახება მოთხოვნების დაწყების ბოლოს. ელოდება ყველა მოთხოვნის დაწყებას</para>
    /// <para>  WaitOne - ლოდინის დაწყების მეთოდი. გამოიძახება მოთხოვნების დაწყების ბოლოს. ელოდება რომელიმე მეთოდის დასრულებას</para>
    /// </summary>

    window.setCount = 0;
    window.resetCount = 0;
    window.waitBox = null;
    window.intervalId = null;
    this.arr = arr;
    window.finishFunction = finishFunction;
    this.eventName = eventName;
    this.eventObjId = eventObjId;

    this.Start = function (p) {
        window.setCount += 1;
        //        if (!(p in this.arr))
        //            this.arr.push(p);
    };

    this.Finish = function (p) {
        window.resetCount += 1;
        //        if (p in this.arr)
        //            this.arr.splice(p);
    };

    window.Reset = function () {
        window.setCount = 0;
        window.resetCount = 0;
    };

    this.CheckAll = function () {
        if (window.resetCount >= window.setCount) {
            clearInterval(window.intervalId);
            if (window.waitBox) {
                window.waitBox.hide();
            }
            this.Reset();
            if (this.finishFunction) {
                this.finishFunction();
            }
        }
    };

    this.CheckOne = function () {
        if (window.resetCount > 0 && window.setCount > 0) {
            clearInterval(window.intervalId);
            this.Reset();
            window.waitBox.hide();
            this.finishFunction();
        }
    };

    this.CreateWaitBox = function () {
        window.waitBox = cms.showMessage('დაელოდეთ...', 6); //Ext.Msg.wait("დაელოდეთ...", "სტატუსი:");
    };
    this.WaitAll = function () {
        this.CreateWaitBox();
        window.intervalId = setInterval(this.CheckAll, 3000);
    };

    this.WaitOne = function () {
        this.CreateWaitBox();
        window.intervalId = setInterval(this.Check, 3000);
    };
};
cms.showMessage = function (msg, type, obj, acceptHandler, title, textEnabled, refuseHandler) {
    /// <summary>
    /// ხელოვნური ფუნქცია მესიჯის შესაქმნელად და საჩვენებლად.
    /// msg - ტექსტი, რომელიც უნდა გამოჩნდეს.
    /// type - მესიჯის ტიპი: 1-საინფორმაციო, 2-წარმატება, 3-წარუმატებლობა, 4-შეცდომა, 5-გაფრთხილება, 6-დალოდება/მოცდა, 7-კითხვა.
    /// acceptHandler - ფუნქცია, რომელიც შესრულდება "დიახ" დაჭერის შემთხვევაში.
    /// textEnabled - გამოჩნდეს თუ არა ტექსტის შესაყვანი ველი მესიჯში.
    /// </summary>

    if (cms.isEmpty(type)) type = 1;
    if (cms.isEmpty(type)) acceptHandler = function () { };
    if (cms.isEmpty(type)) textEnabled = false;

    var icon = null;
    switch (type) {
        case 1:
            icon = 'info';
            break;
        case 2:
            icon = 'success';
            break;
        case 3:
            icon = 'fail';
            break;
        case 4:
            icon = 'error';
            break;
        case 5:
            icon = 'warning';
            break;
        case 6:
            icon = 'wait';
            break;
        case 7:
            icon = 'question';
            break;
    }
    var buttons = (type == 7 ? Ext.MessageBox.YESNO : (type == 6 ? null : Ext.Msg.OK));

    return Ext.MessageBox.show({
        title: title,
        msg: msg,
        icon: icon,
        buttons: buttons,
        wait: type == 6 ? true : false,
        waitConfig: { animate: true },
        multiline: textEnabled,
        fn: function (btn, text) {
            if ((btn == 'yes' || btn == 'ok') && !cms.isEmpty(acceptHandler)) acceptHandler(btn, text, obj);
            else if (!cms.isEmpty(refuseHandler)) refuseHandler();
        }
    });
};
cms.isEmpty = function (obj) {
    return Ext.isEmpty(obj);
};
