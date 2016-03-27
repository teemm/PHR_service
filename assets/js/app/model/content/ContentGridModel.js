Ext.define('cms.model.content.ContentGridModel', {
    extend: 'Ext.data.Model',
    fields: ['id', 'content_id', 'menu_title', 'content_status_name', 'content_type_name', 'order', 'static_page_name', 'url',
        'title_ka', 'short_desc_ka']
});