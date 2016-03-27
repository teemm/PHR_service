//ჯერ-ჯერობით არ არის Order და Image

var _tinyMCEConfig = {
    // General options
    theme: 'advanced',

    skin: 'extjs',
    inlinepopups_skin: 'extjs',

    // Original value is 23, hard coded.
    // with 23 the editor calculates the height wrong.
    // With these settings, you can do the fine tuning of the height
    // by the initialization.
    theme_advanced_row_height: 27,
    delta_height: 1,

    schema: 'html5',

    plugins: 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist',

    // Theme options
    theme_advanced_buttons1: 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
    theme_advanced_buttons2: 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
    theme_advanced_buttons3: 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
    theme_advanced_buttons4: 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft',
    theme_advanced_toolbar_location: 'top',
    theme_advanced_toolbar_align: 'left',
    theme_advanced_statusbar_location: 'bottom'

    // Example content CSS (should be your site CSS)
    //content_css: 'contents.css'
};

Ext.define('cms.view.news.NewsWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.wndContent',
    height: 500,
    width: 900,
    resizable: true,
    modal: true,
    frame: true,
    scope: this,
    //autoScroll: true,
    overflowY: 'auto',
    title: 'ვაკანსიები',
    items: [{
        xtype: 'form',
        frame: true,
        style: 'border: 0px;',
        items: [{
            xtype: 'hidden',
            id: 'cont_id',
            name: 'content_id',
            value: ''
        }, {
            xtype: 'combobox',
            id: 'cmbContentStatus',
            fieldLabel: 'კონტენტის სტატუსი',
            valueField: 'value',
            displayField: 'text',
            labelAlign: 'right',
            labelWidth: 170,
            width: 350,
            store: 'content.ContentStatusCmbStore',
            queryMode: 'remote',
            allowBlank: false,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'container',
            layout: 'hbox',
            height: 28,
            items: [{
                xtype: 'label',
                text: 'სურათი:  ',
                style: 'text-align: right; padding-right: 6px; padding-top: 3px',
                width: 176,
                align: 'right',
            }, {
                xtype: 'filefield',
                id: 'userfile',
                name: 'userfile',
                allowBlank: true,
                width: 350,
                buttonText: '',
                buttonConfig: { iconCls: 'attach' },
                validator: function (v) {
                    if (!v) return true;

                    if (!/\.(jpg|JPG|gif|GIF|png|PNG)$/i.test(v)) {
                        return 'ფაილის ფორმატი არავალიდურია';
                    }
                    if (/-/.test(v)) {
                        return "ფაილის სახელი არ შეიძლება შეიცავდეს შემდეგ სიმბოლოებს: [-!$%^&*()_+|~=`{}\[\]:\";'<>?,\/]";
                    }
                    return true;
                }
            }]
        }, {
            xtype: 'textfield',
            id: 'txtContentTitle_ka',
            fieldLabel: 'სათაური (ქართ)',
            labelAlign: 'right',
            width: 350,
            labelWidth: 170,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'textfield',
            id: 'txtContentTitle_en',
            fieldLabel: 'სათაური (ინგ)',
            labelAlign: 'right',
            width: 350,
            labelWidth: 170,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'tinymce_textarea',
            id: 'txtShortDesc_ka',
            region: 'center',
            fieldLabel: 'მოკლე აღწერა (ქართ)',
            labelWidth: 170,
            labelAlign: 'right',
            height: 200,
            width: 600,
            noWysiwyg: false,
            tinyMCEConfig: _tinyMCEConfig,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'tinymce_textarea',
            id: 'txtShortDesc_en',
            region: 'center',
            fieldLabel: 'მოკლე აღწერა (ინგ)',
            labelWidth: 170,
            labelAlign: 'right',
            height: 200,
            width: 600,
            noWysiwyg: false,
            tinyMCEConfig: _tinyMCEConfig,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'tinymce_textarea',
            id: 'txtDesc_ka',
            region: 'center',
            fieldLabel: 'აღწერა (ქართ)',
            labelWidth: 170,
            labelAlign: 'right',
            height: 400,
            width: 600,
            noWysiwyg: false,
            tinyMCEConfig: _tinyMCEConfig,
            blankText: 'სავალდებულოა'
        }, {
            xtype: 'tinymce_textarea',
            id: 'txtDesc_en',
            region: 'center',
            fieldLabel: 'აღწერა (ინგ)',
            labelWidth: 170,
            labelAlign: 'right',
            height: 400,
            width: 600,
            noWysiwyg: false,
            tinyMCEConfig: _tinyMCEConfig,
            blankText: 'სავალდებულოა'
        }]
    }],
    buttons: [{
        text: 'ფაილის არჩევა',
        handler: function () {
            var wnd = Ext.create('cms.view.file.FileSelectorWindow');
            wnd.show();
        }
    }, {
        text: 'შენახვა',
        handler: function () {
            var window = this.up('window');
            if (!window.down('form').getForm().isValid()) return;

            Ext.getCmp('cont_id').setValue(window.content_id);

            var form = window.down('form').getForm();
            form.submit({
                url: $.getPath('/admin/news/save_content'),
                waitMsg: 'იტვირთება, გთხოვთ დაელოდოთ...',
                success: function (fp, o) {
                    cms.showMessage('ოპერაცია წარმატებით დასრულდა', 2);
                    window.close();
                    window.grid.getStore().load();
                },
                failure: function (form, action) {
                    switch (action.failureType) {
                        case Ext.form.action.Action.CLIENT_INVALID:
                            cms.showMessage('Form fields may not be submitted with invalid values', 3);
                            break;
                        case Ext.form.action.Action.CONNECT_FAILURE:
                            cms.showMessage('Ajax communication failed', 3);
                            break;
                        case Ext.form.action.Action.SERVER_INVALID:
                            cms.showMessage(action.result.msg, 3);
                    }
                }
            });
        }
    }],

    initComponent: function () {
        this.callParent(arguments);
    }
});
