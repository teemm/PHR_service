Ext.define('cms.view.video.VideoGrid', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grdContent',
    frame: false,
    height: 595,
    width: 990,
    store: 'video.VideoGridStore',
    tbar: [{
        xtype: 'button',
        text: 'დამატება',
        handler: function (obj, e) {
            var wnd = Ext.create('cms.view.video.VideoWindow', {
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

            var video_id = selected.data.id;
            var wnd = Ext.create('cms.view.video.VideoWindow', {
                video_id: video_id,
                grid: obj.up('gridpanel')
            });

            var requestManager = new cms.requestManager(function () {
                wnd.show();
            });

            requestManager.Start();
            cms.ajaxRequest('/admin/video/get_video', 4,
            {
                video_id: video_id
            },
            function (data) {
                cms.setValue('txtToken', data.token);

                requestManager.Finish();
            }, function (data) {
                cms.showMessage(data, 4);
            });

            requestManager.WaitAll();
        }
    }, {
        xtype: 'button',
        text: 'წაშლა',
        handler: function (obj, e) {
            var selected = obj.up('gridpanel').selModel.selected.items[0];
            if (!selected) return;
            var video_id = selected.data.id;
            console.log(video_id);

            cms.showMessage('ნამდვილად გსურთ კონტენტის წაშლა?', 7, null, function () {
                cms.ajaxRequest('/admin/video/delete', 3,
                {
                    id: video_id
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
        text: 'ID'
    }, {
        xtype: 'gridcolumn',
        dataIndex: 'token',
        text: 'Token',
        width: 200
    }],
    dockedItems: [{
        xtype: 'pagingtoolbar',
        store: 'video.VideoGridStore',
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
