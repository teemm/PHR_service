Ext.define('cms.store.fileManager.FileManagerGridStore', {
    extend: 'Ext.data.TreeStore',
    model: 'cms.model.fileManager.FileManagerGridModel',
    proxy: {
        type: 'ajax',
        url: '/admin/fileManager/get_files'
    },
    root: {
        text: 'assets',
        id: 0,
        expanded: true
    },
    folderSort: true,
    sorters: [{
        property: 'text',
        direction: 'ASC'
    }]
});
