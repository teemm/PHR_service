Ext.define('cms.store.news.NewsGridStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.news.NewsGridModel',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 75,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/news/get_contents'),
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
