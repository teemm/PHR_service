//Main controller

Ext.define('cms.controller.Main', {
    extend: 'Ext.app.Controller',
    stores: ['menu.MenuGridStore', 'menu.MenuCmbStore', 'menu.MenuTypeCmbStore', 'content.ContentGridStore',
        'content.ContentStatusCmbStore', 'content.ContentTypeCmbStore', 'fileManager.FileManagerGridStore', 'news.NewsGridStore',
        'accounts.AccountsGridStore', 'video.VideoGridStore'],
    models: ['menu.MenuGridModel', 'content.ContentGridModel', 'fileManager.FileManagerGridModel', 'news.NewsGridModel', 
        'accounts.AccountsGridModel', 'video.VideoGridModel'],
    views: ['Main', 'Menu', 'menu.MenuGrid', 'menu.MenuWindow', 'content.ContentGrid', 'content.ContentWindow',
        'news.NewsGrid', 'news.NewsWindow', 'accounts.AccountsGrid', 'accounts.AccountsWindow', 'shared.FileContainer',
        'fileManager.FileManagerWindow', 'video.VideoGrid'],
    init: function () {
        this.control();
    }
});
