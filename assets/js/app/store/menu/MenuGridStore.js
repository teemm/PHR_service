Ext.define('cms.store.menu.MenuGridStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.menu.MenuGridModel',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/menu/get_menus'),
        reader: {
            type: 'json',
            root: 'data'
        },
        actionMethods: {
            read: 'POST'
        }
    }
});
