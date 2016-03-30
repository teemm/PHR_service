Ext.define('cms.view.fileManager.FileManagerWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.wndFile',
    height: 200,
    width: 420,
    resizable: false,
    modal: true,
    frame: true,
    scope: this,
    overflowY: 'auto',
    title: 'ფაილი',
    id: 'file_panel',
    items: [{
        xtype: 'form',
        frame: true,
        style: 'border: 0px;',
        items: [{
            xtype: 'hidden',
            id: 'path',
            name: 'path',
            value: ''
        }, {
            xtype: 'filefield',
            name: 'files[]',
            allowBlank: false,
            blankText: 'სავალდებულოა!',
            width: 350,
            buttonText: '',
            buttonConfig: { iconCls: 'attach' },
            validator: function (v) {
                if (!/\.(jpg|JPG|gif|GIF|png|PNG|pdf|PDF)$/i.test(v)) {
                    return 'ფაილის ფორმატი არავალიდურია';
                }
                if (/-/.test(v)) {
                    return "ფაილის სახელი არ შეიძლება შეიცავდეს შემდეგ სიმბოლოებს: [-!$%^&*()_+|~=`{}\[\]:\";'<>?,\/]";
                }
                return true;
            }
        }]
    }],
    buttons: [{
        text: 'ფაილის დამატება',
        iconCls: 'plus',
        handler: function () {
            var window = this.up('window');
            var form = window.down('form');
            form.add(Ext.create('cms.view.shared.FileContainer'));
        }
    }, {
        text: 'ატვირთვა',
        handler: function () {
            var window = this.up('window');
            if (!window.down('form').getForm().isValid()) return;

            var form = window.down('form').getForm();

            Ext.getCmp('path').setValue(window.path);

            form.submit({
                url: $.getPath('/admin/fileManager/upload_files'),
                waitMsg: 'იტვირთება, გთხოვთ დაელოდოთ...',
                success: function (fp, o) {
                    cms.showMessage('ოპერაცია წარმატებით დასრულდა', 2);
                    window.close();
                    window.grid.getStore().load();
                },
                failure: function (form, action) {
                    switch (action.failureType) {
                        case Ext.form.action.Action.CLIENT_INVALID:
                            cms.showMessage('Form fields may not be submitted with invalid values', 3);
                            break;
                        case Ext.form.action.Action.CONNECT_FAILURE:
                            cms.showMessage('Ajax communication failed', 3);
                            break;
                        case Ext.form.action.Action.SERVER_INVALID:
                            cms.showMessage(action.result.msg, 3);
                    }
                }
            });
        }
    }],

    initComponent: function () {
        this.callParent(arguments);
    }
});
