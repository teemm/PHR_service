//Main view

Ext.define('cms.view.Main', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.mainPanel',
    width: 1000,
    activeTab: 0,
    items: [{
        xtype: 'container',
        id: 'cntMain',
        //width: 700,
        height: 600
    }],
    initComponent: function () {
        this.callParent(arguments);
    }
});
