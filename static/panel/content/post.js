Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var raw_data = $('.page-data').text();
	eval('var page_data = ' + raw_data);
	
	var main_store = Ext.create('Ext.data.Store', {
		autoLoad: true, pageSize: 25, remoteSort: true,
        sorters: [{ property: 'create_date', direction: 'DESC' }],
		fields: [
			'id', 'user_id', 'category_id', 'category_name', 'post_type_id', 'post_type_name', 'alias', 'name', 'desc', 'create_date',
			'publish_date', 'view_count', 'post_link', 'is_hot', 'is_popular', 'user_fullname'
		],
		proxy: {
			type: 'ajax',
			url : URLS.base + 'panel/content/post/grid', actionMethods: { read: 'POST' },
			reader: { type: 'json', root: 'rows', totalProperty: 'count' }
		}
	});
	
	var main_grid = new Ext.grid.GridPanel({
		viewConfig: { forceFit: true }, store: main_store, height: 335, renderTo: 'grid-member',
		features: [{ ftype: 'filters', encode: true, local: false }],
		columns: [ {
					header: 'Judul', dataIndex: 'name', sortable: true, filter: true, width: 200, flex: 1
			}, {	header: 'User', dataIndex: 'user_fullname', sortable: true, filter: true, width: 100
			}, {	header: 'Kategori', dataIndex: 'category_name', sortable: true, filter: true, width: 75
			}, {	header: 'Tipe Post', dataIndex: 'post_type_name', sortable: true, filter: true, width: 75
			}, {	header: 'Publish', dataIndex: 'publish_date', sortable: true, filter: true, width: 150, align: 'center'
			}, {	header: 'Dilihat', dataIndex: 'view_count', sortable: true, filter: true, width: 60, align: 'right'
			}, {	header: 'Hot', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
						getClass: function(v, meta, rec) {
							if (rec.get('is_hot') == 0) {
								this.items[0].tooltip = 'Normal Post';
								return 'delIcon';
							} else {
								this.items[0].tooltip = 'Hot Post';
								return 'acceptIcon';
							}
						},
						handler: function(grid, rowIndex, colIndex) {
							var rec = grid.store.getAt(rowIndex);
							var param = { action: 'update', id: rec.data.id, is_hot: (rec.data.is_hot == 0) ? 1 : 0 }
							Func.ajax({ param: param, url: URLS.base + 'panel/content/post/action', callback: function(result) {
								if (result.status) {
									grid.store.load();
								}
							} });
						}
					} ]
			}, {	header: 'Popular', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
						getClass: function(v, meta, rec) {
							if (rec.get('is_popular') == 0) {
								this.items[0].tooltip = 'Normal Post';
								return 'delIcon';
							} else {
								this.items[0].tooltip = 'Popular Post';
								return 'acceptIcon';
							}
						},
						handler: function(grid, rowIndex, colIndex) {
							var rec = grid.store.getAt(rowIndex);
							var param = { action: 'update', id: rec.data.id, is_popular: (rec.data.is_popular == 0) ? 1 : 0 }
							Func.ajax({ param: param, url: URLS.base + 'panel/content/post/action', callback: function(result) {
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
								window.open(row.post_link);
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
				url: URLS.base + 'panel/content/post/action',
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
				url: URLS.base + 'panel/content/post/action',
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
			layout: 'fit', width: 1070, height: 535,
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
						url: URLS.base + 'panel/content/post/view',
						success: function(Result) {
							w.body.dom.innerHTML = Result.responseText;
							
							win.id = param.id;
							win.name = new Ext.form.TextField({
								renderTo: 'nameED', width: 575, allowBlank: false, blankText: 'Masukkan Judul',
								enableKeyEvents: true, listeners: {
									keyup: function(me, b, c) {
										if (param.id == 0) {
											var alias = Func.GetName(me.getValue());
											win.alias.setValue(alias);
										}
									}
								}
							});
							win.alias = new Ext.form.TextField({ renderTo: 'aliasED', width: 575 });
							win.desc = new Ext.form.HtmlEditor({ renderTo: 'descED', width: 575, height: 265, enableFont: false });
							win.download = new Ext.form.TextArea({ renderTo: 'downloadED', width: 575, height: 130, allowBlank: false, blankText: 'Masukkan Link Source' });
							win.category = Combo.Class.Category({ renderTo: 'categoryED', width: 225, allowBlank: false, blankText: 'Masukkan Kategori' });
							win.post_type = Combo.Class.PostType({ renderTo: 'post_typeED', width: 225, allowBlank: false, blankText: 'Masukkan Jenis Post', value: page_data.POST_TYPE_MULTI_LINK });
							win.publish_date = new Ext.form.DateField({ renderTo: 'publish_dateED', width: 120, format: DATE_FORMAT, allowBlank: false, blankText: 'Masukkan Tanggal Publish', value: new Date() });
							win.publish_time = Combo.Class.Time({ renderTo: 'publish_timeED', width: 100, allowBlank: false, blankText: 'Masukkan Jam Publish', value: new Date() });
							win.create_date = new Ext.form.DateField({ renderTo: 'create_dateED', width: 120, format: DATE_FORMAT, allowBlank: false, blankText: 'Masukkan Tanggal Create', value: new Date() });
							win.create_time = Combo.Class.Time({ renderTo: 'create_timeED', width: 100, allowBlank: false, blankText: 'Masukkan Jam Create', value: new Date() });
							win.tag = new Ext.form.TextArea({ renderTo: 'tagED', width: 225, height: 50 });
							win.link_canonical = new Ext.form.TextField({ renderTo: 'link_canonicalED', width: 225 });
							win.thumbnail = new Ext.form.TextField({ renderTo: 'thumbnailED', width: 225, readOnly: true });
							win.thumbnail_button = new Ext.Button({ renderTo: 'btn_thumbnailED', text: 'Browse', width: 75, handler: function(btn) {
								window.iframe_thumbnail.browse();
							} });
							post_thumbnail = function(p) { win.thumbnail.setValue(p.file_name); }
							
							// Populate Record
							if (param.id > 0) {
								win.name.setValue(param.name);
								win.desc.setValue(param.desc);
								win.alias.setValue(param.alias);
								win.thumbnail.setValue(param.thumbnail);
								win.category.setValue(param.category_id);
								win.post_type.setValue(param.post_type_id);
								win.download.setValue(param.download);
								win.link_canonical.setValue(param.link_canonical);
								
								win.publish_date.setValue(Renderer.GetDateFromString.Date(param.publish_date));
								win.publish_time.setValue(Renderer.GetDateFromString.Time(param.publish_date));
								win.create_date.setValue(Renderer.GetDateFromString.Date(param.create_date));
								win.create_time.setValue(Renderer.GetDateFromString.Time(param.create_date));
								
								// tag
								if (param.array_tag != null) {
									var string_tag = '';
									for (var i = 0; i < param.array_tag.length; i++) {
										string_tag += (string_tag == '') ? param.array_tag[i].tag_name : ',' + param.array_tag[i].tag_name;
									}
									win.tag.setValue(string_tag);
								}
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
				ajax.desc = win.desc.getValue();
				ajax.alias = win.alias.getValue();
				ajax.thumbnail = win.thumbnail.getValue();
				ajax.download = win.download.getValue();
				ajax.category_id = win.category.getValue();
				ajax.post_type_id = win.post_type.getValue();
				ajax.tag = win.tag.getValue();
				ajax.link_canonical = win.link_canonical.getValue();
				
				// Validation
				var is_valid = true;
				if (! win.name.validate()) {
					is_valid = false;
				}
				if (! win.category.validate()) {
					is_valid = false;
				}
				if (! win.download.validate()) {
					is_valid = false;
				}
				if (! win.post_type.validate()) {
					is_valid = false;
				}
				if (! win.publish_date.validate()) {
					is_valid = false;
				}
				if (! win.publish_time.validate()) {
					is_valid = false;
				}
				if (! win.create_date.validate()) {
					is_valid = false;
				}
				if (! win.create_time.validate()) {
					is_valid = false;
				}
				if (! is_valid) {
					return;
				}
				
				// publish datetime
				var publish_date = Renderer.ShowFormat.Date(win.publish_date.getValue());
				var publish_time = Renderer.ShowFormat.Time(win.publish_time.getValue());
				ajax.publish_date = publish_date + ' ' + publish_time;
				
				// create datetime
				var create_date = Renderer.ShowFormat.Date(win.create_date.getValue());
				var create_time = Renderer.ShowFormat.Time(win.create_time.getValue());
				ajax.create_date = create_date + ' ' + create_time;
				
				Func.ajax({ param: ajax, url: URLS.base + 'panel/content/post/action', callback: function(result) {
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
	Ext.EventManager.onWindowResize(function() {
		Renderer.InitWindowSize({ Panel: -1, Grid: main_grid, Toolbar: 70 });
    }, main_grid);
});