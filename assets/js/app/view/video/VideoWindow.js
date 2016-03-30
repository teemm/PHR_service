Ext.define('cms.view.video.VideoWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.wndVideo',
    height: 100,
    width: 400,
    resizable: true,
    modal: true,
    frame: true,
    scope: this,
    //autoScroll: true,
    overflowY: 'auto',
    title: 'ვიდეო',
    items: [{
        xtype: 'form',
        frame: true,
        style: 'border: 0px;',
        items: [{
            xtype: 'hidden',
            id: 'video_id',
            name: 'video_id',
            value: ''
        }, {
            xtype: 'textfield',
            id: 'txtToken',
            fieldLabel: 'Token',
            labelAlign: 'right',
            width: 350,
            labelWidth: 70,
            blankText: 'სავალდებულოა'
        }]
    }],
    buttons: [{
        text: 'შენახვა',
        handler: function () {
            var window = this.up('window');
            if (!window.down('form').getForm().isValid()) return;

            Ext.getCmp('video_id').setValue(window.video_id);

            var form = window.down('form').getForm();
            form.submit({
                url: $.getPath('/admin/video/save_video'),
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
