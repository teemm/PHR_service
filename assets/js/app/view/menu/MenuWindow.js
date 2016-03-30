Ext.define('cms.view.menu.MenuWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.wndMenu',
    height: 230,
    width: 400,
    resizable: false,
    modal: true,
    frame: true,
    scope: this,
    title: 'მენიუ',
    items: [{
        xtype: 'form',
        frame: true,
        style: 'border: 0px;',
        items: [{
            xtype: 'combobox',
            id: 'cmbParentMenu',
            fieldLabel: 'მშობელი მენიუ',
            valueField: 'value',
            displayField: 'text',
            labelAlign: 'right',
            labelWidth: 120,
            width: 305,
            store: 'menu.MenuCmbStore',
            queryMode: 'remote'
        }, {
            xtype: 'combobox',
            id: 'cmbMenuType',
            fieldLabel: 'მენიუს ტიპი',
            valueField: 'value',
            displayField: 'text',
            labelAlign: 'right',
            labelWidth: 120,
            width: 305,
            store: 'menu.MenuTypeCmbStore',
            queryMode: 'remote',
            listeners: {
                select: function (combo, records, eOpts) {
                    var value = combo.getValue();
                    if ($.parseInt(value) == new cms.enum().menuType.footer) {
                        cms.setValue('cmbParentMenu', null);
                        cms.getCmp('cmbParentMenu').hide();
                    } else {
                        cms.getCmp('cmbParentMenu').show();
                    }
                }
            },
            allowBlank: false,
            blankText: 'სავალდებულოა!'
        }, {
            xtype: 'textfield',
            id: 'txtMenuTitle_ka',
            fieldLabel: 'სათაური (ქართ)',
            labelAlign: 'right',
            width: 305,
            labelWidth: 120,
            allowBlank: false,
            blankText: 'სავალდებულოა!'
        }, {
            xtype: 'textfield',
            id: 'txtMenuTitle_en',
            fieldLabel: 'სათაური (ინგ)',
            labelAlign: 'right',
            width: 305,
            labelWidth: 120,
            allowBlank: false,
            blankText: 'სავალდებულოა!'
        }]
    }],
    buttons: [{
        text: 'შენახვა',
        handler: function () {
            var window = this.up('window');
            if (!window.down('form').getForm().isValid()) return;

            cms.ajaxRequest('/admin/menu/save_menu', 1,
            {
                menu_id: window.menu_id,
                parent_menu_id: cms.getValue('cmbParentMenu'),
                menu_type_id: cms.getValue('cmbMenuType'),
                title_ka: cms.getValue('txtMenuTitle_ka'),
                title_en: cms.getValue('txtMenuTitle_en'),
            },
            function (data) {
                cms.showMessage('ოპერაცია წარმატებით დასრულდა!', 2);
                window.close();
                window.grid.getStore().load();
            }, function (data) {
                cms.showMessage(data);
            });
        }
    }],

    initComponent: function () {

        this.callParent(arguments);
    }
});
