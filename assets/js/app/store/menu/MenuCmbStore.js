Ext.define('cms.store.menu.MenuCmbStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.SelectModel',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/common/get_menu_sl'),
        reader: {
            type: 'json',
            root: 'data'
        },
        actionMethods: {
            read: 'POST'
        }
    }
});
