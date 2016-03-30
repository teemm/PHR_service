//Ext.application({
//    name: 'cms',
//    extend: 'cms.Application',
//    autoCreateViewport: true
//});

Ext.application({
    name: 'cms',
    appFolder: $.getPath('/assets/js/app'),
    controllers: ['Main'],
    launch: function () {
        myapp = this;
        Ext.create('Ext.container.Container', {
            renderTo: 'divMainPanel',
            items: [{
                xtype: 'mainMenu'
            }, {
                xtype: 'mainPanel'
            }]
        });
    }
});
