Ext.define('cms.view.file.FileSelectorWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.wndFileSelector',
    height: 400,
    width: 600,
    resizable: false,
    modal: true,
    frame: true,
    scope: this,
    overflowY: 'auto',
    title: 'ფაილის არჩევა',
    items: [{
        xtype: 'container',
        layout: 'hbox',
        height: 28,
        items: [{
            xtype: 'button',
            text: 'View',
            style: {
                'margin-top': '3px',
                'margin-left': '8px'
            },
            handler: function(obj, e){
                var link = cms.getValue('txtCopiedFilePath');

                if (link) {
                    window.open(link, '_blank');
                }                
            }
        }, {
            xtype: 'textfield',
            id: 'txtCopiedFilePath',
            fieldLabel: 'მისამართი',
            labelAlign: 'right',
            width: 530,
            labelWidth: 90,
            readOnly: true,
            selectOnFocus: true,
            style: {
                'margin-top': '4px'
            }
        }]
    }, {
        xtype: 'treepanel',
        width: 600,
        height: 330,
        store: 'fileManager.FileManagerGridStore',
        rootVisible: false,
        useArrows: true,
        draggable: false,
        columns: [
            { xtype: 'treecolumn', header: 'Name', dataIndex: 'name', flex: 1 }
        ],
        listeners: {
            select: function (obj, record, index, eOpts) {
                var result = '';

                var isdir = record.data.isdir;
                if (isdir) {
                    cms.setValue('txtCopiedFilePath', result);
                    return;
                }

                var path = record.data.path;

                $.ajax({
                    type: "POST",
                    url: '/admin/fileManager/view_file',
                    data: {path: path},
                    success: function(data){
                        result = data.url;
                        cms.setValue('txtCopiedFilePath', result);
                    },
                    async: false
                });
            }
        }
    }],

    initComponent: function () {
        this.callParent(arguments);
    }
});
