Ext.define('cms.view.fileManager.FileManagerDirWindow', {
    extend: 'Ext.window.Window',
    height: 100,
    width: 420,
    resizable: false,
    modal: true,
    frame: true,
    scope: this,
    overflowY: 'auto',
    title: 'ფოლდერის დამატება',
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
            xtype: 'textfield',
            id: 'name',
            name: 'name',
            fieldLabel: 'ფოლდერის სახელი',
            labelAlign: 'right',
            width: 350,
            labelWidth: 170,
            blankText: 'სავალდებულოა'
        }]
    }],
    buttons: [{
        text: 'დამატება',
        handler: function () {
            var window = this.up('window');
            if (!window.down('form').getForm().isValid()) return;

            var form = window.down('form').getForm();

            Ext.getCmp('path').setValue(window.path);

            form.submit({
                url: $.getPath('/admin/fileManager/add_dir'),
                waitMsg: 'იტვირთება, გთხოვთ დაელოდოთ...',
                success: function (fp, o) {
                    cms.showMessage('ოპერაცია წარმატებით დასრულდა', 2);
                    window.close();
                    window.grid.store.reload();
                },
                failure: function (form, action) {
                    cms.showMessage(action.result.msg, 3);
                }
            });
        }
    }],

    initComponent: function () {
        this.callParent(arguments);
    }
});
