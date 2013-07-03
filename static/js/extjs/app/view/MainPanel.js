
Ext.define( 'Stiki.view.MainPanel', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.mainpanel',
    region: 'center',
    activeTab: 0,
    defaults: { padding: '10px' },
    initComponent: function() {
		var init_table = function() {
			/*
			var table_pin = Ext.create('Ext.ux.grid.TransformGrid', "table-pin", { stripeRows: true, height: 50 });
			table_pin.render();
			
			var table_fakultas = Ext.create('Ext.ux.grid.TransformGrid', "table-fakultas", { stripeRows: true, height: 350 });
			table_fakultas.render();
			
			var table_bank = Ext.create('Ext.ux.grid.TransformGrid', "table-bank", { stripeRows: true, height: 175 });
			table_bank.render();
			
			var table_spmk = Ext.create('Ext.ux.grid.TransformGrid', "table-spmk", { stripeRows: true, height: 225 });
			table_spmk.render();
			/*	*/
		}
		
        Ext.apply( this, {
            items: [{
                title: 'Home',
				loader: { url: URLS.base + 'panel/home/dashboard', contentType: 'html', autoLoad: true, callback: init_table }
            }]
        });
        this.callParent(arguments);
    }
});

Ext.define('Stiki.view.ContentTab', {
    extend: 'Ext.container.Container',
    alias: 'widget.contenttab',
    layout: 'fit',
    url: '',
    base: URLS.stiki,

    initComponent: function() {
        this.tpl = new Ext.XTemplate('<iframe style="width: 100%; height: 100%; border: 0; margin:0; padding:0;" src="{base}{url}"></iframe>');
        this.callParent(arguments);
    },

    load: function() {
        this.update(this.tpl.apply(this));
    },

    clear: function() {
        this.update('');
    }
});
