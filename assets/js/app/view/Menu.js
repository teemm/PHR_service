//Main menu

Ext.define('cms.view.Menu', {
    extend: 'Ext.toolbar.Toolbar',
    alias: 'widget.mainMenu',
    frame: true,
    width: 1000,
    items: [{
        xtype: 'splitbutton',
        height: 30,
        width: 147,
        text: 'მენიუ',
        handler: function () {
            cms.getCmp('cntMain').removeAll();
            cms.getCmp('cntMain').add(Ext.create('cms.view.menu.MenuGrid'));
        }
    }, {
        xtype: 'tbseparator'
    }, {
        xtype: 'splitbutton',
        height: 30,
        width: 147,
        text: 'კონტენტი',
        handler: function () {
            cms.getCmp('cntMain').removeAll();
            cms.getCmp('cntMain').add(Ext.create('cms.view.content.ContentGrid'));
        }
    }, {
        xtype: 'tbseparator'
    }, {
        xtype: 'splitbutton',
        height: 30,
        width: 147,
        text: 'სიახლეები',
        handler: function () {
            cms.getCmp('cntMain').removeAll();
            cms.getCmp('cntMain').add(Ext.create('cms.view.news.NewsGrid'));
        }
    }, {
        xtype: 'tbseparator'
    }, {
        xtype: 'splitbutton',
        height: 30,
        width: 147,
        text: 'ფაილები',
        handler: function () {
            cms.getCmp('cntMain').removeAll();
            cms.getCmp('cntMain').add(Ext.create('cms.view.fileManager.FileManagerGrid'));    
        }
    }, {
        xtype: 'splitbutton',
        height: 30,
        width: 147,
        text: 'ვიდეოები',
        handler: function () {
            cms.getCmp('cntMain').removeAll();
            cms.getCmp('cntMain').add(Ext.create('cms.view.video.VideoGrid'));    
        }
    }, {
        xtype: 'button',
        height: 30,
        width: 147,
        cls: 'logout',
        text: 'გასვლა',
        handler: function () {
            window.open('/admin/auth/logout', '_self');    
        }
    }],

    initComponent: function () {
        this.callParent(arguments);
    }

});