Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var main_store = Ext.create('Ext.data.Store', {
		autoLoad: true, pageSize: 25, remoteSort: true,
        sorters: [{ property: 'request_time', direction: 'DESC' }],
		fields: [ 'id', 'user_id', 'user_fullname', 'name', 'desc', 'imdb', 'request_time', 'status', 'request_link' ],
		proxy: {
			type: 'ajax',
			url : URLS.base + 'panel/content/request/grid', actionMethods: { read: 'POST' },
			reader: { type: 'json', root: 'rows', totalProperty: 'count' }
		}
	});
	
	var main_grid = new Ext.grid.GridPanel({
		viewConfig: { forceFit: true }, store: main_store, height: 335, renderTo: 'grid-member',
		features: [{ ftype: 'filters', encode: true, local: false }],
		columns: [ {
					header: 'Time', dataIndex: 'request_time', sortable: true, filter: true, width: 125, align: 'center'
			}, {	header: 'User', dataIndex: 'user_fullname', sortable: true, filter: true, width: 125
			}, {	header: 'Title', dataIndex: 'name', sortable: true, filter: true, width: 150
			}, {	header: 'Content', dataIndex: 'desc', sortable: true, filter: true, width: 100, flex: 1
			}, {	header: 'Status', dataIndex: 'status', sortable: true, filter: true, width: 100, align: 'center'
			}, {	header: 'IMDB', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
							iconCls: 'linkIcon', tooltip: 'Link', handler: function(grid, rowIndex, colIndex) {
								var row = grid.store.getAt(rowIndex).data;
								window.open(row.imdb);
							}
					} ]
			}, {	header: 'Action', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
							iconCls: 'linkIcon', tooltip: 'Link', handler: function(grid, rowIndex, colIndex) {
								var row = grid.store.getAt(rowIndex).data;
								window.open(row.request_link);
							}
					} ]
		} ],
		tbar: [ {
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
				url: URLS.base + 'panel/content/request/action',
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
				url: URLS.base + 'panel/content/request/action',
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
			layout: 'fit', width: 710, height: 325,
			closeAction: 'hide', plain: true, modal: true,
			buttons: [ {
						text: 'Save', handler: function() { win.save(); }
				}, {	text: 'Close', handler: function() {
						win.hide();
				}
			}],
			listeners: {
				show: function(w) {
					var Title = (param.id == 0) ? 'Entry Post - [New]' : 'Entry Post - [Edit]';
					w.setTitle(Title);
					
					Ext.Ajax.request({
						url: URLS.base + 'panel/content/request/view',
						success: function(Result) {
							w.body.dom.innerHTML = Result.responseText;
							
							win.id = param.id;
							win.name = new Ext.form.TextField({ renderTo: 'nameED', width: 575 });
							win.imdb = new Ext.form.TextField({ renderTo: 'imdbED', width: 575 });
							win.desc = new Ext.form.TextArea({ renderTo: 'descED', width: 575, height: 80 });
							win.reply = new Ext.form.TextArea({ renderTo: 'replyED', width: 575, height: 80 });
							win.status = Combo.Class.CommentStatus({ renderTo: 'request_statusED', width: 225 });
							
							// Populate Record
							if (param.id > 0) {
								win.name.setValue(param.name);
								win.imdb.setValue(param.imdb);
								win.desc.setValue(param.desc);
								win.reply.setValue(param.reply);
								win.status.setValue(param.status);
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
				ajax.name = win.name.getValue();
				ajax.imdb = win.imdb.getValue();
				ajax.desc = win.desc.getValue();
				ajax.reply = win.reply.getValue();
				ajax.status = win.status.getValue();
				
				Func.ajax({ param: ajax, url: URLS.base + 'panel/content/request/action', callback: function(result) {
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