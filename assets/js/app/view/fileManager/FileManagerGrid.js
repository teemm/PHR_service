Ext.define('cms.view.fileManager.FileManagerGrid', {
    extend: 'Ext.tree.TreePanel',
    height: 595,
    width: 990,
    store: 'fileManager.FileManagerGridStore',
    rootVisible: false,
    useArrows: true,
    draggable: false,
    columns: [
        { xtype: 'treecolumn', header: 'Name', dataIndex: 'name', flex: 1 }
    ],
    dockedItems: [{
        xtype: 'toolbar',
        items: [{
            text: 'Add Directory',
            handler: function(obj, e){
                var selected = obj.up('treepanel').selModel.selected.items[0];
                if (!selected) return;
                var isDir = selected.data.isdir;
                if (!isDir) return;
                var path = selected.data.path;

                var wnd = Ext.create('cms.view.fileManager.FileManagerDirWindow', {
                    path: path,
                    grid: obj.up('treepanel')
                });
                wnd.show();
            }
        }, {
            text: 'Add File',
            handler: function(obj, e){
                var selected = obj.up('treepanel').selModel.selected.items[0];
                if (!selected) return;
                var isDir = selected.data.isdir;
                if (!isDir) return;
                var path = selected.data.path;

                obj.up('treepanel').selModel.deselectAll();

                var wnd = Ext.create('cms.view.fileManager.FileManagerWindow', {
                    path: path,
                    name: name,
                    grid: obj.up('treepanel')
                });
                wnd.show();
            }
        }, {
            text: 'Remove Directory',
            handler: function(obj, e){
                var selected = obj.up('treepanel').selModel.selected.items[0];
                if (!selected) return;
                var isDir = selected.data.isdir;
                if (!isDir) return;
                var path = selected.data.path;
                var name = selected.data.name;

                var isroot = selected.data.isroot;
                if (isroot) {
                    cms.showMessage('თქვენ ვერ წაშლით "'+name+'" ფოლდერს', 4, null, function() {});
                    return;
                }

                cms.showMessage('ნამდვილად გსურთ წაშალოთ "'+name+'" ფოლდერი?', 7, null, function () {
                    cms.ajaxRequest('/admin/fileManager/delete_folder', 3,
                    {
                        path: path,
                        isroot: isroot
                    },
                    function (data) {
                        cms.showMessage('ფოლდერი "'+name+'" წარმატებით წაიშალა', 2);
                        obj.up('treepanel').selModel.deselectAll();
                        obj.up('treepanel').store.load();
                    }, function (data) {
                        cms.showMessage(data, 4);
                    });
                });
            }
        }, {
            text: 'Remove File',
            handler: function(obj, e){
                var selected = obj.up('treepanel').selModel.selected.items[0];
                if (!selected) return;
                var isDir = selected.data.isdir;
                if (isDir) return;
                var path = selected.data.path;
                var name = selected.data.name;

                cms.showMessage('ნამდვილად გსურთ წაშალოთ "'+name+'" ფაილი?', 7, null, function () {
                    cms.ajaxRequest('/admin/fileManager/delete_file', 3,
                    {
                        path: path
                    },
                    function (data) {
                        cms.showMessage('ფაილი "'+name+'" წარმატებით წაიშალა', 2);
                        obj.up('treepanel').selModel.deselectAll();
                        obj.up('treepanel').store.load();
                    }, function (data) {
                        cms.showMessage(data, 4);
                    });
                });
            }
        }, {
            text: 'View File',
            handler: function(obj, e){
                var selected = obj.up('treepanel').selModel.selected.items[0];
                if (!selected) return;
                var isDir = selected.data.isdir;
                if (isDir) return;
                var path = selected.data.path;

                obj.up('treepanel').selModel.deselectAll();

                $.ajax({
                    type: "POST",
                    url: '/admin/fileManager/view_file',
                    data: {path: path},
                    success: function(data){
                        window.open(data.url, '_blank');
                    },
                    async: false
                });
            }
        }]

    }]
});
