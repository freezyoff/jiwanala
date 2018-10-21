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
						}
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
	initDatatables: function(){
		this.options.datatable.data.source.read.url = $('#table1').attr('sourceUrl');
		$('#table1').mDatatable(this.options.datatable);
	},
	init: function(){
		this.initDatatables();
	},
};

jQuery(document).ready(function () {
	bauk_mnjkaryawan_landing.init();
});