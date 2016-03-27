Ext.define('cms.view.shared.FileContainer', {
    extend: 'Ext.container.Container',
    alias: 'widget.fileContainer',
    layout: 'hbox',
    style: {
        'padding-bottom': '5px'
    },
    items: [{
        xtype: 'filefield',
        name: 'files[]',
        allowBlank: false,
        blankText: 'სავალდებულოა!',
        width: 350,
        buttonText: '',
        buttonConfig: { iconCls: 'attach' },
        validator: function (v) {
            if (!/\.(jpg|JPG|gif|GIF|png|PNG|pdf|PDF)$/i.test(v)) {
                return 'ფაილის ფორმატი არავალიდურია';
            }
            if (/-/.test(v)) {
                return "ფაილის სახელი არ შეიძლება შეიცავდეს შემდეგ სიმბოლოებს: -";
            }
            return true;
        }
    }, {
        xtype: 'button',
        iconCls: 'minus',
        style: {
            'margin-left': '5px'
        },
        handler: function () {
            this.up('form').remove(this.up('container'));
        }
    }]
});
