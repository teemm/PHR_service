Ext.define('cms.store.content.ContentStatusCmbStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.SelectModel',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/common/get_content_status_sl'),
        reader: {
            type: 'json',
            root: 'data'
        },
        actionMethods: {
            read: 'POST'
        }
    }
});
