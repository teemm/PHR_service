Ext.define('cms.store.content.ContentGridStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.content.ContentGridModel',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 75,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/content/get_contents'),
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
