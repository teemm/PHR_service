Ext.define('cms.view.content.ContentGrid', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grdContent',
    frame: false,
    height: 595,
    width: 990,
    store: 'content.ContentGridStore',
    tbar: [{
        xtype: 'button',
        text: 'დამატება',
        handler: function (obj, e) {
            var wnd = Ext.create('cms.view.content.ContentWindow', {
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
            var wnd = Ext.create('cms.view.content.ContentWindow', {
                content_id: content_id,
                grid: obj.up('gridpanel')
            });

            var requestManager = new cms.requestManager(function () {

                wnd.show();
            });

            requestManager.Start();
            cms.ajaxRequest('/admin/content/get_content', 4,
            {
                content_id: content_id
            },
            function (data) {
                cms.getCmp('cmbContentType').fireEvent('select', { value: data.content_type_id });

                cms.setValue('cmbMenu', data.menu_id);
                cms.setValue('cmbContentStatus', data.content_status_id);
                cms.setValue('cmbContentType', data.content_type_id);
                cms.setValue('txtStaticPageName', data.static_page_name);
                cms.setValue('txtURL', data.url);
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
            cms.getCmp('cmbMenu').getStore().load({
                callback: function () {
                    requestManager.Finish();
                }
            });

            requestManager.Start();
            cms.getCmp('cmbContentStatus').getStore().load({
                callback: function () {
                    requestManager.Finish();
                }
            });

            requestManager.Start();
            cms.getCmp('cmbContentType').getStore().load({
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
        dataIndex: 'content_id',
        text: 'ContentID',
        width: 50
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'menu_title',
        text: 'მენიუს დასახელება',
        width: 100
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'content_status_name',
        text: 'სტატუსი',
        width: 60
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'content_type_name',
        text: 'ტიპი',
        width: 60
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'static_page_name',
        text: 'სტატიკური გვერდის სახელი',
        width: 170
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'url',
        text: 'URL',
        width: 150
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'title_ka',
        text: 'სათაური',
        width: 160
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'short_desc_ka',
        text: 'მოკლე აღწერა',
        width: 160
    }],
    dockedItems: [{
        xtype: 'pagingtoolbar',
        store: 'content.ContentGridStore',
        dock: 'bottom',
        displayInfo: true,
        displayMsg: 'ნაჩვენებია {0} - {1} სულ {2}',
        emptyMsg: 'არ არის ჩანაწერები',
        beforePageText: 'გვერდი',
        afterPageText: 'სულ {0}'
    }],
    initComponent: function () {
        this.callParent(arguments);
        this.getStore().load();
    }
});