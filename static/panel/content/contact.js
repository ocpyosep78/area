Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var main_store = Ext.create('Ext.data.Store', {
		autoLoad: true, pageSize: 25, remoteSort: true,
        sorters: [{ property: 'message_time', direction: 'DESC' }],
		fields: [ 'id', 'name', 'email', 'website', 'message', 'message_time' ],
		proxy: {
			type: 'ajax',
			url : URLS.base + 'panel/content/contact/grid', actionMethods: { read: 'POST' },
			reader: { type: 'json', root: 'rows', totalProperty: 'count' }
		}
	});
	
	var main_grid = new Ext.grid.GridPanel({
		viewConfig: { forceFit: true }, store: main_store, height: 335, renderTo: 'grid-member',
		features: [{ ftype: 'filters', encode: true, local: false }],
		columns: [ {
					header: 'Time', dataIndex: 'message_time', sortable: true, filter: true, width: 150
			}, {	header: 'Name', dataIndex: 'name', sortable: true, filter: true, width: 200
			}, {	header: 'Email', dataIndex: 'email', sortable: true, filter: true, width: 200
			}, {	header: 'Website', dataIndex: 'website', sortable: true, filter: true, width: 150, flex: 1
		} ],
		tbar: [ {
				text: 'View', iconCls: 'editIcon', tooltip: 'Ubah', handler: function() { main_grid.update({ }); }
			}, '-', {
				text: 'Hapus', iconCls: 'delIcon', tooltip: 'Hapus', handler: function() {
					if (main_grid.getSelectionModel().getSelection().length == 0) {
						Ext.Msg.alert('Informasi', 'Silahkan memilih data.');
						return false;
					}
					
					Ext.MessageBox.confirm('Konfirmasi', 'Apa anda yakin akan menghapus data ini ?', main_grid.delete);
				}
			}, '->', {
                id: 'SearchPM', xtype: 'textfield', tooltip: 'Cari', emptyText: 'Cari', listeners: {
                    'specialKey': function(field, el) {
                        if (el.getKey() == Ext.EventObject.ENTER) {
                            var value = Ext.getCmp('SearchPM').getValue();
                            if ( value ) {
								main_grid.load_grid({ namelike: value });
                            }
                        }
                    }
                }
            }, '-', {
				text: 'Reset', tooltip: 'Reset pencarian', iconCls: 'refreshIcon', handler: function() {
					main_grid.load_grid({ });
				}
		} ],
		bbar: new Ext.PagingToolbar( {
			store: main_store, displayInfo: true,
			displayMsg: 'Displaying topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'
		} ),
		listeners: {
			'itemdblclick': function(model, records) {
				main_grid.update({ });
            }
        },
		load_grid: function(Param) {
			main_store.proxy.extraParams = Param;
			main_store.load();
		},
		update: function(Param) {
			var row = main_grid.getSelectionModel().getSelection();
			if (row.length == 0) {
				Ext.Msg.alert('Informasi', 'Silahkan memilih data.');
				return false;
			}
			
			Ext.Ajax.request({
				url: URLS.base + 'panel/content/contact/action',
				params: { action: 'get_by_id', id: row[0].data.id },
				success: function(Result) {
					eval('var Record = ' + Result.responseText)
					Record.id = Record.id;
					main_win(Record);
				}
			});
		},
		delete: function(Value) {
			if (Value == 'no') {
				return;
			}
			
			Ext.Ajax.request({
				url: URLS.base + 'panel/content/contact/action',
				params: { action: 'delete', id: main_grid.getSelectionModel().getSelection()[0].data.id },
				success: function(TempResult) {
					eval('var Result = ' + TempResult.responseText)
					
					Ext.Msg.alert('Informasi', Result.message);
					if (Result.status == '1') {
						main_store.load();
					}
				}
			});
		}
	});
	
	function main_win(param) {
		var win = new Ext.Window({
			layout: 'fit', width: 710, height: 270,
			closeAction: 'hide', plain: true, modal: true, title: 'Entry Contact',
			buttons: [ { text: 'Close', handler: function() { win.hide(); } }],
			listeners: {
				show: function(w) {
					Ext.Ajax.request({
						url: URLS.base + 'panel/content/contact/view',
						success: function(Result) {
							w.body.dom.innerHTML = Result.responseText;
							
							win.id = param.id;
							win.name = new Ext.form.TextField({ renderTo: 'nameED', width: 225, readOnly: true });
							win.email = new Ext.form.TextField({ renderTo: 'emailED', width: 225, readOnly: true });
							win.website = new Ext.form.TextField({ renderTo: 'websiteED', width: 225, readOnly: true });
							win.message_time = new Ext.form.TextField({ renderTo: 'message_timeED', width: 225, readOnly: true });
							win.message = new Ext.form.TextArea({ renderTo: 'messageED', width: 575, height: 80, readOnly: true });
							
							// Populate Record
							if (param.id > 0) {
								win.name.setValue(param.name);
								win.email.setValue(param.email);
								win.website.setValue(param.website);
								win.message_time.setValue(param.message_time);
								win.message.setValue(param.message)
							}
						}
					});
				},
				hide: function(w) {
					w.destroy();
					w = win = null;
				}
			}
		});
		win.show();
	}
	
	Renderer.InitWindowSize({ Panel: -1, Grid: main_grid, Toolbar: 70 });
});