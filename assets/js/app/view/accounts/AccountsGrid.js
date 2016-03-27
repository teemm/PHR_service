Ext.define('cms.view.accounts.AccountsGrid', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grdContent',
    frame: false,
    height: 595,
    width: 990,
    store: 'accounts.AccountsGridStore',
    //forceFit: true,
    tbar: [{
        xtype: 'button',
        text: 'დამატება',
        handler: function (obj, e) {
            var wnd = Ext.create('cms.view.accounts.AccountsWindow', {
                content_id: null,
                grid: obj.up('gridpanel')
            });
            wnd.show();
        }
    }, {
        xtype: 'button',
        text: 'რედაქტირება',
        handler: function (obj, e) {
            var selected = obj.up('gridpanel').selModel.selected.items[0];
            if (!selected) return;

            var content_id = selected.data.id;
            var wnd = Ext.create('cms.view.accounts.AccountsWindow', {
                content_id: content_id,
                grid: obj.up('gridpanel')
            });

            var requestManager = new cms.requestManager(function () {
                wnd.show();
            });

            requestManager.Start();
            cms.ajaxRequest('/admin/accounts/get_content', 4,
            {
                content_id: content_id
            },
            function (data) {
                cms.setValue('cmbContentStatus', data.content_status_id);
                cms.setValue('txtContentTitle_ka', data.title_ka);
                cms.setValue('txtContentTitle_en', data.title_en);
                cms.setValue('txtShortDesc_ka', data.short_desc_ka);
                cms.setValue('txtShortDesc_en', data.short_desc_en);
                cms.setValue('txtDesc_ka', data.desc_ka);
                cms.setValue('txtDesc_en', data.desc_en);

                requestManager.Finish();
            }, function (data) {
                cms.showMessage(data, 4);
            });

            requestManager.Start();
            cms.getCmp('cmbContentStatus').getStore().load({
                callback: function () {
                    requestManager.Finish();
                }
            });

            requestManager.WaitAll();

        }
    }, {
        xtype: 'button',
        text: 'წაშლა',
        handler: function (obj, e) {
            var selected = obj.up('gridpanel').selModel.selected.items[0];
            if (!selected) return;
            var content_id = selected.data.id;

            cms.showMessage('ნამდვილად გსურთ კონტენტის წაშლა?', 7, null, function () {
                cms.ajaxRequest('/admin/content/delete', 3,
                {
                    id: content_id
                },
                function (data) {
                    cms.showMessage('ოპერაცია წარმატებით დასრულდა', 2);
                    obj.up('gridpanel').selModel.deselectAll();
                    obj.up('gridpanel').getStore().load();
                }, function (data) {
                    cms.showMessage(data, 4);
                });
            });
        }
    }],
    columns: [cms.getRowNumbererColumn(30), {
        xtype: 'gridcolumn',
        dataIndex: 'id',
        text: 'id',
        width: 50,
        hidden: true
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'content_status_name',
        text: 'სტატუსი',
        width: 70
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'title_ka',
        text: 'სახელი (ქართ)',
        width: 200
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'title_en',
        text: 'სახელი (ინგ)',
        width: 200
    }],
    initComponent: function () {
        this.callParent(arguments);
        this.getStore().load();
    }
});
