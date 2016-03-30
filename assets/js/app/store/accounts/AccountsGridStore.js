Ext.define('cms.store.accounts.AccountsGridStore', {
    extend: 'Ext.data.Store',
    model: 'cms.model.accounts.AccountsGridModel',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 75,
    proxy: {
        type: 'ajax',
        url: $.getPath('/admin/accounts/get_contents'),
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
