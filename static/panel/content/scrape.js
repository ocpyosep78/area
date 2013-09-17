Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('Ext.ux', URLS.ext + '/examples/ux');
Ext.require([ 'Ext.grid.*', 'Ext.data.*', 'Ext.ux.grid.FiltersFeature', 'Ext.toolbar.Paging' ]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
	var raw_data = $('.page-data').text();
	eval('var page_data = ' + raw_data);
	
	var main_store = Ext.create('Ext.data.Store', {
		autoLoad: true, pageSize: 25, remoteSort: true,
        sorters: [{ property: 'scrape_time', direction: 'DESC' }],
		fields: [ 'id', 'category_name', 'post_type_name', 'scrape_master_name', 'name', 'scrape_time', 'post_id', 'post_link' ],
		proxy: {
			type: 'ajax',
			url : URLS.base + 'panel/content/scrape/grid', actionMethods: { read: 'POST' },
			reader: { type: 'json', root: 'rows', totalProperty: 'count' }
		}
	});
	
	var main_grid = new Ext.grid.GridPanel({
		viewConfig: { forceFit: true }, store: main_store, height: 335, renderTo: 'grid-member',
		features: [{ ftype: 'filters', encode: true, local: false }],
		columns: [ {
					header: 'Title', dataIndex: 'name', sortable: true, filter: true, width: 200, flex: 1
			}, {	header: 'Category', dataIndex: 'category_name', sortable: true, filter: true, width: 200
			}, {	header: 'Post Type', dataIndex: 'post_type_name', sortable: true, filter: true, width: 100
			}, {	header: 'Source', dataIndex: 'scrape_master_name', sortable: true, filter: true, width: 100
			}, {	header: 'Time', dataIndex: 'scrape_time', sortable: true, filter: true, width: 125
			}, {	header: 'Post ID', dataIndex: 'post_id', sortable: true, filter: { type: 'numeric' }, width: 100, align: 'center', hidden: true
			}, {	header: 'Status', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [ {
						getClass: function(v, meta, rec) {
							if (rec.get('post_id') == 0) {
								this.items[0].tooltip = 'Pending';
								return 'questionIcon';
							} else if (rec.get('post_id') == -1) {
								this.items[0].tooltip = 'Unpublish';
								return 'delIcon';
							} else {
								this.items[0].tooltip = 'Publish';
								return 'linkIcon';
							}
						},
						handler: function(grid, rowIndex, colIndex) {
							var rec = grid.store.getAt(rowIndex);
							if (rec.data.post_id == 0) {
								return false;
							} else if (rec.data.post_id > 0) {
								window.open(rec.data.post_link);
								return false;
							}
						}
					} ]
			}, {	header: 'Action', xtype: 'actioncolumn', width: 75, align: 'center',
					items: [
						{	getClass: function(v, meta, rec) {
								if (rec.get('post_id') == 0) {
									this.items[0].tooltip = 'Publish';
									return 'addIcon';
								} else {
									this.items[0].tooltip = '';
									return 'spaceIcon';
								}
							},
							handler: function(grid, rowIndex, colIndex) {
								var rec = grid.store.getAt(rowIndex);
								if (rec.data.post_id != 0) {
									return false;
								}
								
								var param = { action: 'publish', id: rec.data.id }
								Func.ajax({ param: param, url: URLS.base + 'panel/content/scrape/action', callback: function(result) {
									if (result.status) {
										grid.store.load();
									}
								} });
							}
						},
						{	getClass: function(v, meta, rec) {
								if (rec.get('post_id') == 0) {
									this.items[0].tooltip = 'Unpublish';
									return 'delIcon';
								} else {
									this.items[0].tooltip = '';
									return 'spaceIcon';
								}
							},
							handler: function(grid, rowIndex, colIndex) {
								var rec = grid.store.getAt(rowIndex);
								if (rec.data.post_id != 0) {
									return false;
								}
								
								var param = { action: 'unpublish', id: rec.data.id }
								Func.ajax({ param: param, url: URLS.base + 'panel/content/scrape/action', callback: function(result) {
									if (result.status) {
										grid.store.load();
									}
								} });
							}
						}
				]
		} ],
		tbar: [
			{	xtype: 'label', text: 'Source :', margin: '0 5 0 5' },
			Combo.Param.ScrapeMaster({ id: 'scrape-master', width: 200, listeners: {
				select: function() {
					Ext.getCmp('do_scrape').setDisabled(false);
				}
			} }),
			{	text: 'Start', iconCls: 'addIcon', tooltip: 'Start', id: 'do_scrape', handler: function() {
				if (Ext.getCmp('scrape-master').getValue() == null) {
					return;
				}
				
				Ext.getCmp('do_scrape').setDisabled(true);
				var ajax_param = { action: 'do_scrape', id: Ext.getCmp('scrape-master').getValue() };
				Func.ajax({ param: ajax_param, url: URLS.base + 'panel/content/scrape/action', callback: function(result) {
					Ext.getCmp('do_scrape').setDisabled(false);
					
					if (result.status) {
						Ext.Msg.alert('Informasi', result.message);
						main_store.load();
					}
				} });
			} }, '-',
			{	text: 'Ubah', iconCls: 'editIcon', tooltip: 'Ubah', handler: function() { main_grid.update({ }); } }, '-',
			{	text: 'Set Status', iconCls: 'editIcon', tooltip: 'Set Status', handler: function() { main_grid.set_status({ }); } }, '-',
			{	text: 'Hapus', iconCls: 'delIcon', tooltip: 'Hapus', handler: function() {
					if (main_grid.getSelectionModel().getSelection().length == 0) {
						Ext.Msg.alert('Informasi', 'Silahkan memilih data.');
						return false;
					}
					
					Ext.MessageBox.confirm('Konfirmasi', 'Apa anda yakin akan menghapus data ini ?', main_grid.delete);
				}
			}, '->',
			{	id: 'SearchPM', xtype: 'textfield', tooltip: 'Cari', emptyText: 'Cari', listeners: {
                    'specialKey': function(field, el) {
                        if (el.getKey() == Ext.EventObject.ENTER) {
                            var value = Ext.getCmp('SearchPM').getValue();
                            if ( value ) {
								main_grid.load_grid({ namelike: value });
                            }
                        }
                    }
                }
			}, '-',
			{	text: 'Reset', tooltip: 'Reset pencarian', iconCls: 'refreshIcon', handler: function() {
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
				url: URLS.base + 'panel/content/scrape/action',
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
				url: URLS.base + 'panel/content/scrape/action',
				params: { action: 'delete', id: main_grid.getSelectionModel().getSelection()[0].data.id },
				success: function(TempResult) {
					eval('var Result = ' + TempResult.responseText)
					
					Ext.Msg.alert('Informasi', Result.message);
					if (Result.status == '1') {
						main_store.load();
					}
				}
			});
		},
		set_status: function(Param) {
			var row = main_grid.getSelectionModel().getSelection();
			if (row.length == 0) {
				Ext.Msg.alert('Informasi', 'Silahkan memilih data.');
				return false;
			}
			
			var record = row[0].data;
			Ext.MessageBox.prompt('Set Status', 'Please enter new status id :', function (btn, post_id) {
				if (btn != 'ok') {
					return;
				}
				
				Ext.Ajax.request({
					url: URLS.base + 'panel/content/scrape/action',
					params: { action: 'update', id: record.id, post_id: post_id },
					success: function(temp) {
						main_store.load();
					}
				});
			});
		}
	});
	
	function main_win(param) {
		var win = new Ext.Window({
			layout: 'fit', width: 1070, height: 535,
			closeAction: 'hide', plain: true, modal: true, title: 'Entry Post - [Edit]',
			buttons: [ {
						text: 'Save', handler: function() { win.save(); }
				}, {	text: 'Close', handler: function() {
						win.hide();
				}
			}],
			listeners: {
				show: function(w) {
					Ext.Ajax.request({
						url: URLS.base + 'panel/content/scrape/view',
						success: function(Result) {
							w.body.dom.innerHTML = Result.responseText;
							
							win.id = param.id;
							win.name = new Ext.form.TextField({ renderTo: 'nameED', width: 575, allowBlank: false, blankText: 'Masukkan Judul' });
							win.desc = new Ext.form.HtmlEditor({ renderTo: 'descED', width: 575, height: 250, enableFont: false });
							win.download = new Ext.form.TextArea({ renderTo: 'downloadED', width: 575, height: 120, allowBlank: false, blankText: 'Masukkan Link Source' });
							win.category = Combo.Class.Category({ renderTo: 'categoryED', width: 225, allowBlank: false, blankText: 'Masukkan Kategori' });
							win.post_type = Combo.Class.PostType({ renderTo: 'post_typeED', width: 225, allowBlank: false, blankText: 'Masukkan Jenis Post', value: page_data.POST_TYPE_MULTI_LINK });
							win.publish_date = new Ext.form.DateField({ renderTo: 'publish_dateED', width: 120, format: DATE_FORMAT, allowBlank: false, blankText: 'Masukkan Tanggal Publish', value: new Date() });
							win.publish_time = Combo.Class.Time({ renderTo: 'publish_timeED', width: 100, allowBlank: false, blankText: 'Masukkan Jam Publish', value: new Date() });
							win.tag = new Ext.form.TextField({ renderTo: 'tagED', width: 225 });
							win.thumbnail = new Ext.form.TextField({ renderTo: 'thumbnailED', width: 225, readOnly: true });
							win.link_source = new Ext.form.TextField({ renderTo: 'link_sourceED', width: 575, readOnly: true });
							win.image_source = new Ext.form.TextField({ renderTo: 'image_sourceED', width: 575, readOnly: true });
							win.thumbnail_button = new Ext.Button({ renderTo: 'btn_thumbnailED', text: 'Browse', width: 75, handler: function(btn) {
								window.iframe_thumbnail.browse();
							} });
							scrape_thumbnail = function(p) { win.thumbnail.setValue(p.file_name); }
							
							if (param.id > 0) {
								win.name.setValue(param.name);
								win.desc.setValue(param.desc);
								win.tag.setValue(param.tag);
								win.thumbnail.setValue(param.thumbnail);
								win.category.setValue(param.category_id);
								win.post_type.setValue(param.post_type_id);
								win.download.setValue(param.download);
								win.link_source.setValue(param.link_source);
								win.image_source.setValue(param.image_source);
								
								if (param.publish_date != null) {
									win.publish_date.setValue(Renderer.GetDateFromString.Date(param.publish_date));
									win.publish_time.setValue(Renderer.GetDateFromString.Time(param.publish_date));
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
				ajax.tag = win.tag.getValue();
				ajax.download = win.download.getValue();
				ajax.thumbnail = win.thumbnail.getValue();
				ajax.category_id = win.category.getValue();
				ajax.post_type_id = win.post_type.getValue();
				
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
				if (! is_valid) {
					return;
				}
				
				var publish_date = Renderer.ShowFormat.Date(win.publish_date.getValue());
				var publish_time = Renderer.ShowFormat.Time(win.publish_time.getValue());
				ajax.publish_date = publish_date + ' ' + publish_time;
				
				Func.ajax({ param: ajax, url: URLS.base + 'panel/content/scrape/action', callback: function(result) {
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