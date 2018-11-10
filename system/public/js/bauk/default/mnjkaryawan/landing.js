var bauk_mnjkaryawan_landing = {
	options: {
		datatable: {
			data: {
                type: "remote",
                source: {
                    read: {
                        url: "",
						method: "POST",
						params: {
							_token: $('meta[name=csrf-token]').attr("content")
						},
                    },
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0
            },
            layout: {
                theme: "default",
                class: "",
                scroll: !0,
                height: 450,
                footer: !1,
				customScrollbar: !0
            },
            sortable: !0,
            pagination: !0,
			scrollY: "10vh",
            scrollX: !0,
            scrollCollapse: !0,
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: [10, 20, 30, 50, 100]
                    }
                }
            },
			columns: [{
                field: "id",
                title: "#",
                width: 40,
                selector: !1,
				textAlign: "left",
            },{
                field: "Actions",
                title: "",
				width: 0,
                sortable: !1,
				textAlign: "left",
                overflow: "visible",
                template: function (t, e, i) {
					var rubahAction = $("meta[name=dropdown-rubah-url]").attr("content"),
						hapusAction = $("meta[name=dropdown-hapus-url]").attr("content"),
						_token = $("meta[name=csrf-token]").attr("content");
						
					//avoid redudancy on append
					if ( $('#modal-'+t.id).length == 0) {
						
						$('#modal-container').append(''+
							'<div class="modal fade" id="modal-'+t.id+'" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">'+
							'	<div class="modal-dialog modal-dialog-centered" role="document">'+
							'		<div class="modal-content">'+
							'			<div class="modal-header bg-danger">'+
							'				<h5 class="modal-title m--font-light" id="exampleModalLongTitle">Hapus Data Karyawan</h5>'+
							'			</div>'+
							'			<div class="modal-body">'+
							'				<p>Anda yakin akan menghapus data Karyawan:</p>'+
							'				<table width="100%">'+
							'					<tr>'+
							'						<td>Record ID</td>'+
							'						<td>: '+ t.id +'</td>'+
							'					</tr>'+
							'					<tr>'+
							'						<td>NIP</td>'+
							'						<td>: '+ t.NIP +'</td>'+
							'					</tr>'+
							'					<tr>'+
							'						<td>Nama</td>'+
							'						<td>: '+ t.nama_gelar_depan +' '+ t.nama_lengkap +' '+ t.nama_gelar_belakang +'</td>'+
							'					</tr>'+
							'					<tr>'+
							'						<td>Status</td>'+
							'						<td>: <span class="m-badge ' + (t.aktif? "m-badge--warning" : "m-badge--metal") +' m-badge--wide">'+ 
														(t.aktif? "Karyawan Aktif" : "Karyawan Non Aktif") + 
							'							</span></td>'+
							'					</tr>'+
							'				</table>'+
							'			</div>'+
							'			<div class="modal-footer">'+
							'				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>'+
							'				<form id="dropdownForm-'+ t.id +'-delete" name="dropdownForm-'+ t.id +'" method="POST" action="'+hapusAction+'">'+
							'					<input type="hidden" name="recordID" value="'+ t.id +'">'+
							'					<input type="hidden" name="_token" value="'+ _token +'">'+
							'					<input type="hidden" name="_method" value="DELETE">'+
							'					<button type="submit" class="btn btn-danger">Hapus</button>'+
							'				</form>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'</div>'
						);
					}
					
                    return ''+
						'<div class="dropdown ' + (i.getPageSize() - e <= 4 ? "dropup" : "") + '" style="left:-2rem">'+
						'	<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">'+
						'		<i class="la la-caret-square-o-down"></i>'+
						'	</a>'+
						'	<div class="dropdown-menu dropdown-menu-left">'+
						'		<form id="dropdownForm-'+ t.id +'-update" name="dropdownForm-'+ t.id +'" method="POST" action="'+rubahAction+'">'+
						'			<input type="hidden" name="recordID" value="'+ t.id +'">'+
						'			<input type="hidden" name="_token" value="'+ _token +'">'+
						'			<input type="hidden" name="_method" value="PUT">'+
						'		</form>'+
						'		<a class="dropdown-item" href="#" onclick="$(this).prev(\'form\').submit()">'+
						'			<i class="la la-edit"></i> Rubah'+
						'		</a>'+
						'		<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-'+t.id+'">'+
						'			<i class="la la-trash"></i> Hapus'+
						'		</a>'+
						//'		<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>'+
						//'		<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>'+
						'	</div>'+
						'</div>'+
						'';
                }
            },{
				field: "aktif",
                title: "Status",
				filterable: !0,
				width: 120,
				textAlign: "center",
				template: function (t) {
                    var e = {
                        1: {
                            title: "Karyawan Aktif",
                            class: " m-badge--warning"
                        },
                        0: {
                            title: "Karyawan Non Aktif",
                            class: " m-badge--metal"
                        }
                    };
                    return '<span class="m-badge ' + e[t.aktif].class + ' m-badge--wide">' + e[t.aktif].title + "</span>"
                }
			},{
                field: "NIP",
                title: "NIP",
                filterable: !0,
				textAlign: "left",
            },{
                field: "nama_lengkap",
                title: "Nama & Gelar",
                filterable: !0,
				textAlign: "left",
				template: "{{nama_gelar_depan}} {{nama_lengkap}} {{nama_gelar_belakang}}"
            },{
				field: "tlp",
                title: "Telepon",
				filterable: !0,
				textAlign: "left",
				template: "{{tlp1}} / {{tlp2}}"
			},{
				field: "tanggal_masuk",
                title: "Tanggal Aktif",
				width: 150,
				filterable: !0,
				textAlign: "center"
			}]
		}
	},
	_setDatatableOptions: function(keys, value){
		var split = keys.split('.');
		var dump = this.options.datatable;
		for (var i = 0, n = split.length-1; i < n; i++) {
			if (split[i] in dump) {
				dump = dump[split[i]];
			} else {
				return;
			}
			
			if ( !(i+1<n) ){
				dump[split[i+1]] = value;
			}
		}
	},
	_getDatatableOptions: function(keys){
		var dump = this.options.datatable;
		if (keys === undefined || keys === null) return dump;
		
		var split = keys.split('.');
		for (var i = 0, n = split.length; i < n; i++) {
			if (split[i] in dump) {
				dump = dump[split[i]];
			} else {
				return undefined;
			}
		}
		return dump;
	},
	_setQuery: function(key, value){
		var optionKeys = 'data.source.read.params.query';
		var query = this._getDatatableOptions(optionKeys);
		
		if (!query){
			query = key+'='+value;
		}
		else if (query && query.indexOf(key) != -1){
			query = query.split('&');
			for(var i=0, n=query.length; i<n; i++){
				if (query[i].indexOf(key) != -1){
					query[i] = key+'='+value;
				}
			}
			query = query.join('&');
		}		
		else {
			query += (query? '&':'')+key+'='+value;
		}	
		this._setDatatableOptions(optionKeys, query);
		
	},
	initDatatables: function(){
		this._setDatatableOptions('data.source.read.url', $('#table1').attr('sourceUrl'));
		$('#table1').mDatatable(this._getDatatableOptions());
	},
	initSearchDatatables: function(){
		$('#inpStatusNk').on('change', function(){
			bauk_mnjkaryawan_landing._setQuery('status_pernikahan', $(this).val());
			$('#table1').mDatatable('destroy');
			$('#table1').mDatatable(bauk_mnjkaryawan_landing._getDatatableOptions());
		});
		
		$('#inpKeywords').on('keyup paste', $.debounce( 250, function(){
			bauk_mnjkaryawan_landing._setQuery('kata_kunci', $(this).val());
			$('#table1').mDatatable('destroy');
			$('#table1').mDatatable(bauk_mnjkaryawan_landing._getDatatableOptions());
		}));
	},
	initExport: function(){
		$('a.export').on('click', function(){
			$( $(this).parent('form') ).ajaxSubmit();
		});
	},
	init: function(){
		this.initExport();
		this.initSearchDatatables();
		this.initDatatables();
	},
};

jQuery(document).ready(function () {
	bauk_mnjkaryawan_landing.init();
});