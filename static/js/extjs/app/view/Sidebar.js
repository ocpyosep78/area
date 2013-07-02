Ext.define('Stiki.view.Sidebar' ,{
    extend: 'Ext.panel.Panel',
    alias : 'widget.sidebar',
    collapsible: true,
    collapseDirection: 'left',
    layout: 'fit',
	
    initComponent: function() {
        Ext.define('Menu', {
            extend: 'Ext.data.Model',
            fields: ['Title', 'Link']
        });
        
        
        Ext.applyIf( this, {
            items: [this.createView()]
        });
        
        this.addEvents(
            'menuselect'
        );
        
        this.callParent(arguments);
    },

    createView: function(){
        this.view = Ext.create('widget.dataview', {
            store: Ext.create('Ext.data.Store', {
                model: 'Menu',
                data: this.menu
            }),
            selModel: {
                mode: 'SINGLE',
                listeners: {
                    scope: this,
                    selectionchange: this.onSelectionChange
                }
            },
            listeners: {
                scope: this,
                contextmenu: this.onContextMenu,
                viewready: this.onViewReady
            },
            trackOver: true,
            cls: 'feed-list',
            itemSelector: '.feed-list-item',
            overItemCls: 'feed-list-item-hover',
            tpl: '<tpl for="."><div class="feed-list-item">{Title}</div></tpl>'
        });
        return this.view;
    },
    
    onViewReady: function(){
        //this.view.getSelectionModel().select(this.view.store.first());
    },
    
    onContextMenu: function(view, index, el, event){
        var menu = this.menu;

        event.stopEvent();
        menu.activeFeed = view.store.getAt(index);
        menu.showAt(event.getXY());
    },
    
    getSelectedItem: function(){
        return this.view.getSelectionModel().getSelection()[0] || false;
    },

    onSelectionChange: function() {
        var selected = this.getSelectedItem();
        this.menuSelected(selected);
    },
    
    menuSelected: function(rec){
        if (rec) {
            this.fireEvent('menuselect', this, rec.get('Title'), rec.get('Link'));
        }
    }

});
