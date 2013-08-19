Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	Ext.get('loading_mask').remove();
	
	var form = { };
	form.link_from = new Ext.form.TextArea({
		renderTo: 'link_fromED', width: Ext.get("link_fromED").getWidth() - 5, height: 175,
		allowBlank: false, blankText: 'Masukkan Link Source'
	});
	form.link_to = new Ext.form.TextArea({
		renderTo: 'link_toED', width: Ext.get("link_toED").getWidth() - 5, height: 175
	});
	form.link_short = Combo.Class.LinkShort({ renderTo: 'link_shortED', width: 100, value: 1 });
	form.convert = new Ext.Button({ renderTo: 'convertED', text: 'Convert', width: 100, handler: function(btn) {
		// Validation
		var is_valid = true;
		if (! form.link_from.validate()) {
			is_valid = false;
		}
		if (! is_valid) {
			return;
		}
		
		form.link_to.setValue('');
		var param = { action: 'convert', id: form.link_short.getValue(), link_from: form.link_from.getValue() };
		Func.ajax({ param: param, url: URLS.base + 'panel/content/shink_link/action', callback: function(result) {
			if (result.status) {
				form.link_to.setValue(result.message);
			}
		} });
	} });
});