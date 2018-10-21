var bauk_default_mnjkaryawan_rubah = {
	options:[
		{
			id: "inpNip",
			name: "NIP",
			threshold: 15,
			rules: {
				required: !0,
				minlength: 8,
				number: !0,
				remote: {
					url: '',
					type: "POST",
					dataType:'JSON',
					data: {
						recordID: function(){
							return $('#inpRecordID').val();
						},
						NIP: function() {
							return $( "#inpNip" ).val();
						},
						_token: function(){
							return $('meta[name=csrf-token]').attr("content");
						}
					},
				},
				beforeSend: function(){
					$('#inpNipLoader').addClass('m-loader m-loader--primary m-loader--right');
				},
				complete: function(){
					$('#inpNipLoader').removeClass('m-loader m-loader--primary m-loader--right');
				}
			},
			messages: {
				required: "Mohon diisi.",
				minlength: "NIP minimal {0} karakter.",
				number: "Mohon Isi dengan karakter angka.",
				remote: "NIP sudah terdaftar untuk Karyawan lain.",
			}
		}, {
			id: "inpKtp",
			name: "KTP",
			threshold: 15,
			rules: {
				required: !0,
				minlength: 8,
				number: !0
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Nomor KTP minimal {0} karakter",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpNamaGd",
			name: "nama_gelar_depan",
			threshold: 25
		}, {
			id: "inpNamaNn",
			name: "nama_lengkap",
			threshold: 50,
			rules: {
				required: !0,
				minlength: 5
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Nama Lengkap minimal {0} karakter",
			}
		}, {
			id: "inpNamaGb",
			name: "nama_gelar_belakang",
			threshold: 25
		}, {
			id: "inpAlamat",
			name: "alamat",
			threshold: 100,
			rules: {
				required: !0,
				minlength: 10
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Alamat minimal {0} karakter",
			}
		}, {
			id: "inpRt",
			name: "rt",
			threshold: 2,
			rules: {
				required: !0,
				number: !0
			},
			messages: {
				required: "Mohon diisi",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpRw",
			name: "rw",
			threshold: 2,
			rules: {
				required: !0,
				number: !0
			},
			messages: {
				required: "Mohon diisi",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpKodePos",
			name: "kode_pos",
			threshold: 15,
			rules: {
				required: !0,
				minlength: 4,
				number: !0
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Kode Pos minimal {0} karakter",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpKelurahan",
			name: "kelurahan",
			threshold: 25,
			rules: {
				required: !0,
				minlength: 5
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Kelurahan minimal {0} karakter",
			}
		}, {
			id: "inpKecamatan",
			name: "kecamatan",
			threshold: 25,
			rules: {
				required: !0,
				minlength: 5
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Kecamatan minimal {0} karakter",
			}
		}, {
			id: "inpKota",
			name: "kota",
			threshold: 25,
			rules: {
				required: !0,
				minlength: 5
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Kota minimal {0} karakter",
			}
		}, {
			id: "inpProvinsi",
			name: "provinsi",
			threshold: 25,
			rules: {
				required: !0,
				minlength: 5
			},
			messages: {
				required: "Mohon diisi",
				minlength: "Provinsi minimal {0} karakter",
			}
		}, {
			id: "inpTlp1",
			name: "tlp1",
			threshold: 15,
			rules:{
				required:{
					depends: function(){
						return !$.isNumeric($('#inpTlp2').val());
					}
				},
				minlength: 10,
				number: !0
			},
			messages: {
				required: "Mohon diisi salah satu",
				minlength: "Nomor Telepon Rumah minimal {0} karakter",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpTlp2",
			name: "tlp2",
			threshold: 15,
			rules: {
				required:{
					depends: function(){
						return !$.isNumeric($('#inpTlp1').val());
					}
				},
				minlength: 10,
				number: !0
			},
			messages: {
				required: "Mohon diisi salah satu",
				minlength: "Nomor Telepon Rumah minimal {0} karakter",
				number: "Mohon Isi dengan karakter angka"
			}
		}, {
			id: "inpStatusNk",
			name: "status_pernikahan",
			rules: {
				required: {
					depends: function(element){
						return !$(element).val();
					}
				}
			},
			messages: {
				required: 'Mohon pilih salah satu'
			}
		}, {
			id: "inpTglDf",
			name: "tanggal_masuk",
			threshold: 19,
			rules: {
				required: !0
			},
			messages: {
				required: 'Mohon diisi'
			}
		}
	],
	
	init: function(){
		this.initFormValidation();
		this.initDatePicker();
	},
	
	initDatePicker: function(){
		var t;
		t = mUtil.isRTL() ? {
			leftArrow: '<i class="la la-angle-right"></i>',
			rightArrow: '<i class="la la-angle-left"></i>'
		} : {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		};
		
		$("#inpTglDf").datepicker({
			rtl: mUtil.isRTL(),
			orientation: "right",
			todayBtn: "linked",
			clearBtn: !0,
			todayHighlight: !0,
			templates: t,
			format: 'dd-mm-yyyy',
		});
	},
	
	initFormValidation: function(){
		var rules = {};
		var messages = {};
		
		$.each(this.options, function( index, value ) {
			$('#'+value.id).maxlength({
				threshold: value.threshold,
				warningClass: "m-badge m-badge--warning m-badge--rounded m-badge--wide",
				limitReachedClass: "m-badge m-badge--success m-badge--rounded m-badge--wide"
			});
			
			if (value.messages !== "undefined"){
				rules[value.name] = value.rules;
				messages[value.name] = value.messages;				
			}
		});
		
		$("#form1").validate({
			rules: rules,
			messages: messages,
			invalidHandler: function (e, r) {
				$('.m-form__group.row').trigger('classChangeListener::classChangeListener_formGroup');
				$('#btnSubmit').disabled=false;
				$('#btnSubmit').children('span').addClass('m--hide');
				mUtil.scrollTo("#form1", -200);
			},
			submitHandler: function (e) {
				$('#btnSubmit').disabled=true;
				$('#btnSubmit').children('span').removeClass('m--hide');
				e.submit();	
			}
		});
		
		this.initFormValidation_formGroupRowHighlight_NamaDanGelar.init();
		this.initFormValidation_formGroupRowHighlight_Alamat.init();
	},
	
	initFormValidation_formGroupRowHighlight_NamaDanGelar:{
		init: function(){
			//add event class-change listener on .m-form__group.row
			$('.m-form__group.row.NamaDanGelar').on('classChangeListener::classChangeListener_formGroup', this.classChangeListener_formGroup)
				.find('.m-form__group-sub input').on('keyup', this.keyup_formGroupInput);
		},
		classChangeListener_formGroup: function(){
			var child = $(this).children('.m-form__group-sub.has-danger');
			if (child.length > 0){
				$('#lbNamaDanGelar').addClass('m--font-danger');
			}
			else{
				$('#lbNamaDanGelar').removeClass('m--font-danger');
			}
		},
		keyup_formGroupInput: function(){
			var parent = $(this).parents('.m-form__group.row');
			parent.trigger('classChangeListener::classChangeListener_formGroup');
		}
	},
	
	initFormValidation_formGroupRowHighlight_Alamat:{
		init: function(){
			//add event class-change listener on .m-form__group.row
			$('.m-form__group.row.Alamat').on('classChangeListener::classChangeListener_formGroup', this.classChangeListener_formGroup)
				.find('.m-form__group-sub input').on('keyup', this.keyup_formGroupInput);
		},
		classChangeListener_formGroup: function(){
			var child = $('.m-form__group.row.Alamat').find('.m-form__group-sub.has-danger');
			if (child.length > 0){
				$('#lbAlamat').addClass('m--font-danger');
			}
			else{
				$('#lbAlamat').removeClass('m--font-danger');
			}
		},
		keyup_formGroupInput: function(){
			var parent = $(this).parents('.m-form__group.row');
			parent.trigger('classChangeListener::classChangeListener_formGroup');
		}
	}
};

jQuery(document).ready(function () {
	bauk_default_mnjkaryawan_rubah.init();
});