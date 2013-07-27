Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var main_store = Ext.create('Ext.data.Store', {
		autoLoad: true, pageSize: 25, remoteSort: true,
        sorters: [{ property: 'comment_time', direction: 'DESC' }],
		fields: [ 'id', 'user_id', 'user_email', 'link', 'comment', 'comment_time', 'is_publish' ],
		proxy: {
			type: 'ajax',
			url : URLS.base + 'panel/content/comment/grid', actionMethods: { read: 'POST' },
			reader: { type: 'json', root: 'rows', totalProperty: 'count' }
		}
	});
	
	var main_grid = new Ext.grid.GridPanel({
		viewConfig: { forceFit: true }, store: main_store, height: 335, renderTo: 'grid-member',
		features: [{ ftype: 'filters', encode: true, local: false }],
		columns: [ {
					header: 'Time', dataIndex: 'comment_time', sortable: true, filter: true, width: 125, align: 'center'
			}, {	header: 'Email', dataIndex: 'user_email', sortable: true, filter: true, width: 150
			}, {	header: 'Comment', dataIndex: 'comment', sortable: true, filter: true, width: 150, flex: 1
			}, {	header: 'Publish', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
						getClass: function(v, meta, rec) {
							if (rec.get('is_publish') == 0) {
								this.items[0].tooltip = 'Unpublish';
								return 'delIcon';
							} else {
								this.items[0].tooltip = 'Publish';
								return 'acceptIcon';
							}
						},
						handler: function(grid, rowIndex, colIndex) {
							var rec = grid.store.getAt(rowIndex);
							var param = { action: 'update', id: rec.data.id, is_publish: (rec.data.is_publish == 0) ? 1 : 0 }
							Func.ajax({ param: param, url: URLS.base + 'panel/content/comment/action', callback: function(result) {
								if (result.status) {
									grid.store.load();
								}
							} });
						}
					} ]
			}, {	header: 'Action', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
							iconCls: 'linkIcon', tooltip: 'Link', handler: function(grid, rowIndex, colIndex) {
								var row = grid.store.getAt(rowIndex).data;
								window.open(row.link);
							}
					} ]
		} ],
		tbar: [ {
				text: 'Tambah', iconCls: 'addIcon', tooltip: 'Tambah', handler: function() { main_win({ id: 0 }); }
			}, '-', {
				text: 'Ubah', iconCls: 'editIcon', tooltip: 'Ubah', handler: function() { main_grid.update({ }); }
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
				url: URLS.base + 'panel/content/comment/action',
				params: { action: 'get_by_id', id: row[0].data.id },
				success: function(Result) {
					eval('var record = ' + Result.responseText)
					record.id = record.id;
					main_win(record);
				}
			});
		},
		delete: function(Value) {
			if (Value == 'no') {
				return;
			}
			
			Ext.Ajax.request({
				url: URLS.base + 'panel/content/comment/action',
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
			layout: 'fit', width: 710, height: 225,
			closeAction: 'hide', plain: true, modal: true,
			buttons: [ {
						text: 'Save', handler: function() { win.save(); }
				}, {	text: 'Close', handler: function() {
						win.hide();
				}
			}],
			listeners: {
				show: function(w) {
					var Title = (param.id == 0) ? 'Entry Category - [New]' : 'Entry Category - [Edit]';
					w.setTitle(Title);
					
					Ext.Ajax.request({
						url: URLS.base + 'panel/content/comment/view',
						success: function(Result) {
							w.body.dom.innerHTML = Result.responseText;
							
							win.id = param.id;
							win.comment = new Ext.form.TextArea({ renderTo: 'commentED', width: 575, height: 150, allowBlank: false, blankText: 'Masukkan Comment' });
							
							// Populate Record
							if (param.id > 0) {
								win.comment.setValue(param.comment);
							}
						}
					});
				},
				hide: function(w) {
					w.destroy();
					w = win = null;
				}
			},
			save: function() {
				var ajax = new Object();
				ajax.action = 'update';
				ajax.id = win.id;
				ajax.comment = win.comment.getValue();
				
				// Validation
				var is_valid = true;
				if (! win.comment.validate()) {
					is_valid = false;
				}
				if (! is_valid) {
					return;
				}
				
				Func.ajax({ param: ajax, url: URLS.base + 'panel/content/comment/action', callback: function(result) {
					Ext.Msg.alert('Informasi', result.message);
					if (result.status) {
						main_store.load();
						win.hide();
					}
				} });
			}
		});
		win.show();
	}
	
	Renderer.InitWindowSize({ Panel: -1, Grid: main_grid, Toolbar: 70 });
});