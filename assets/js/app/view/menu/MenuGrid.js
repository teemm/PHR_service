Ext.define('cms.view.menu.MenuGrid', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grdMenu',
    frame: false,
    height: 595,
    width: 990,
    store: 'menu.MenuGridStore',
    forceFit: true,
    tbar: [{
        xtype: 'button',
        text: 'დამატება',
        handler: function (obj, e) {
            var wnd = Ext.create('cms.view.menu.MenuWindow', {
                menu_id: null,
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

            var menu_id = selected.data.id;
            var wnd = Ext.create('cms.view.menu.MenuWindow', {
                menu_id: menu_id,
                grid: obj.up('gridpanel')
            });

            var requestManager = new cms.requestManager(function () {
                wnd.show();
            });

            requestManager.Start();
            cms.ajaxRequest('/admin/menu/get_menu', 4,
            {
                menu_id: menu_id
            },
            function (data) {
                cms.setValue('cmbParentMenu', data.parent_id);
                cms.setValue('cmbMenuType', data.menu_type_id);
                cms.setValue('txtMenuTitle_ka', data.desc_ka);
                cms.setValue('txtMenuTitle_en', data.desc_en);

                requestManager.Finish();
            }, function (data) {
                cms.showMessage(data, 4);
            });

            requestManager.Start();
            cms.getCmp('cmbParentMenu').getStore().load({
                callback: function () {
                    requestManager.Finish();
                }
            });

            requestManager.Start();
            cms.getCmp('cmbMenuType').getStore().load({
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

            cms.showMessage('ნამდვილად გსურთ კონტენტის წაშლა? თანხმობის შემთხვევაში წაიშლება ამ მენიუზე მიბმული კონტენტებიც. თუ კონტენტების დატოვება გსურთ მიაბით ის სხვა მენიუს ამ მენიუს წაშლამდე', 7, null, function () {
                cms.ajaxRequest('/admin/menu/delete', 3,
                {
                    id: content_id
                },
                function (data) {
                    cms.showMessage('ოპერაცია წარმატებით დასრულდა.', 2);
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
        width: 50
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'parent_id',
        text: 'parent id',
        width: 50
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'menu_type',
        text: 'მენიუს ტიპი'
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'title_ka',
        text: 'სათაური (ქართ)'
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'title_en',
        text: 'სათაური (ინგ)'
    }],
    initComponent: function () {
        this.callParent(arguments);
        this.getStore().load();
    }
});
