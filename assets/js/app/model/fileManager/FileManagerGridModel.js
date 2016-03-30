Ext.define('cms.model.fileManager.FileManagerGridModel', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'id', type: 'int' },
        { name: 'name', type: 'string' },
        { name: 'path', type: 'string' },
        { name: 'isdir', type: 'boolean' },
        { name: 'isroot', type: 'boolean' }
    ],
    proxy: {
        type: 'ajax'
    }
});
