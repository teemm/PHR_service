Ext.define('cms.store.video.VideoGridStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.video.VideoGridModel',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 75,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/video/get_videos'),
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'totalCount',
            start: 0,
            limit: 75
        },
        actionMethods: {
            read: 'POST'
        }
    }
});
