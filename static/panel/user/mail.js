Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var form = {};
	form.to = new Ext.form.TextField({ renderTo: 'toED', width: 575, allowBlank: false, blankText: 'Masukkan Email Tujuan' });
	form.subject = new Ext.form.TextField({ renderTo: 'subjectED', width: 575, allowBlank: false, blankText: 'Masukkan Subject' });
	form.message = new Ext.form.HtmlEditor({ renderTo: 'messageED', width: 575, height: 300, enableFont: false });
	form.reset = function() {
		form.to.reset();
		form.subject.reset();
		form.message.reset();
	}
	Ext.get('loading_mask').remove()
	
	// button
	new Ext.Button({ renderTo: 'sendED', text: 'Send', width: 100, handler: function(btn) {
		// Validation
		var is_valid = true;
		if (! form.to.validate()) {
			is_valid = false;
		}
		if (! form.subject.validate()) {
			is_valid = false;
		}
		if (! is_valid) {
			return;
		}
		
		var param = { action: 'sent_mail', to: form.to.getValue(), subject: form.subject.getValue(), message: form.message.getValue() }
		Func.ajax({ param: param, url: URLS.base + 'panel/user/mail/action', callback: function(result) {
			Ext.Msg.alert('Informasi', result.message);
			if (result.status) {
				form.reset();
			}
		} });
	} });
	new Ext.Button({ renderTo: 'resetED', text: 'Reset', width: 100, handler: function(btn) { form.reset(); } });
});