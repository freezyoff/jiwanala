(function( w, $ ) {

  fontSpy = function  ( fontName, conf ) {
    var $html = $('html'),
        $body = $('body'),
        fontFamilyName = fontName;

        // Throw error if fontName is not a string or not is left as an empty string
        if (typeof fontFamilyName !== 'string' || fontFamilyName === '') {
          throw 'A valid fontName is required. fontName must be a string and must not be an empty string.';
        }

    var defaults = {
        font: fontFamilyName,
        fontClass: fontFamilyName.toLowerCase().replace( /\s/g, '' ),
        success: function() {},
        failure: function() {},
        testFont: 'Courier New',
        testString: 'QW@HhsXJ',
        glyphs: '',
        delay: 50,
        timeOut: 1000,
        callback: $.noop
    };

    var config = $.extend( defaults, conf );

    var $tester = $('<span>' + config.testString+config.glyphs + '</span>')
        .css('position', 'absolute')
        .css('top', '-9999px')
        .css('left', '-9999px')
        .css('visibility', 'hidden')
        .css('fontFamily', config.testFont)
        .css('fontSize', '250px');

    $body.append($tester);

    var fallbackFontWidth = $tester.outerWidth();

    $tester.css('fontFamily', config.font + ',' + config.testFont);

    var failure = function () {
      $html.addClass("no-"+config.fontClass);
      if( config && config.failure ) {
        config.failure();
      }
      config.callback(new Error('FontSpy timeout'));
      $tester.remove();
    };

    var success = function () {
      config.callback();
      $html.addClass(config.fontClass);
      if( config && config.success ) {
        config.success();
      }
      $tester.remove();
    };

    var retry = function () {
      setTimeout(checkFont, config.delay);
      config.timeOut = config.timeOut - config.delay;
    };

    var checkFont = function () {
      var loadedFontWidth = $tester.outerWidth();

      if (fallbackFontWidth !== loadedFontWidth){
        success();
      } else if(config.timeOut < 0) {
        failure();
      } else {
        retry();
      }
    }

    checkFont();
    }
})( this, jQuery );
  
(function( $ ) {
	$.fn.isOnScreen = function(){
		var el = $(this);
		var win = $(window);
		var bounds = el.offset();

		var viewport = {
		top : win.scrollTop()
		};

		viewport.bottom = viewport.top + win.height();
		bounds.bottom = bounds.top + el.outerHeight();

		return (!(viewport.bottom < bounds.top || viewport.bottom < bounds.bottom || viewport.top > bounds.bottom || viewport.top > bounds.top));
	};  
}( jQuery ));

(function( $ ) {
    $.fn.select = function(options) {
		defOpt={
			style:{
				cursor: 'pointer',
				overflow: 'hidden'
			},
			hideCevron:false
		};
		options = $.extend(defOpt, options );
		$(this).each(function(){
			
			var origin = $(this);
			origin.attr('type','hidden');	//hide original input element
			
			if (origin.attr('id')==''){	
				origin.attr('id', Math.rand(4)); //generate id
			}
			
			//need to wrap like <div class="input-group"><input /></div>
			if (!origin.parent().hasClass('input-group')){
				var wrapper = $('<div class="input-group"></div>');
				origin = origin.replaceWith( wrapper );
				origin.appendTo(wrapper);
			}
			
			var toggleContainer = [];
			if ($(this).attr('select-dropdown') != '') 			toggleContainer.push($(this).attr('select-dropdown'));
			if ($(this).attr('select-modal-container') != '')	toggleContainer.push($(this).attr('select-modal-container'));
			if ($(this).attr('select-modal') != '')				toggleContainer.push($(this).attr('select-modal'));
			toggleContainer = $(toggleContainer.join(','));
			
			var label = $('<label class="w3-input" for="'+ origin.attr('id') +'"></label>')
				.css(options.style)
				.insertBefore(this)
				.html( origin.val()==''? 
					$('<span></span>').css('color','rgb(120,120,120)').html(origin.attr('placeholder')).prop('outerHTML') : 
					$(toggleContainer).find('[select-value="'+origin.val()+'"]').html() 
				);
				
			var chevron = $(
					'<label class="icon">'+
						'<i class="fas fa-chevron-down fa-fw w3-hide-small w3-hide-medium"></i>'+
						'<i class="fas fa-square fa-fw w3-hide-large"></i>'+
					'</label>'
				).css('cursor','pointer');
				
			if(!options.hideCevron) {
				chevron.insertBefore(origin);
			}
			
			//event 
			var chevronToggle = function(){
				var dropdown = toggleContainer.filter(origin.attr('select-dropdown'));
				var add = dropdown.is(':visible')? 'fa-chevron-up' : 'fa-chevron-down';
				var del = dropdown.is(':visible')? 'fa-chevron-down' : 'fa-chevron-up';
				chevron.find('.w3-hide-small.w3-hide-medium').removeClass(del).addClass(add);
			};
			
			var triggerShowContainer = function(event){
				event.stopPropagation();
				$(window).trigger('click');	
				origin.trigger('click');
			};
			
			var showContainer = function(event){
				event.stopPropagation();
				var requiredWidth = toggleContainer.filter($(this).attr('select-dropdown')).width('').width();
				var width = $(this).parent().hasClass('input-group')? $(this).parent().width() : $(this).width();
				var height = $(this).parent().hasClass('input-group')? $(this).parent().height() : $(this).height();
				var position = $(label).position();
				toggleContainer.filter($(this).attr('select-dropdown'))
					.css({top:(position.top+height+2)+'px'})
					.width(Math.max(width, requiredWidth));	//dropdown only set the width
				toggleContainer.show();	//show all
				chevronToggle();
			};
			
			var hideContainer = function(event){
				toggleContainer.hide();	//hide all
				chevronToggle();
			};
			
			var pickItemInContainer = function(){
				var oldValue = origin.val(),
					newValue = null;
				
				if ($(this).is('li')){
					var val = $(this).find('a[select-role="item"]');
					label.html( $(val).html() );
					origin.val( $(val).attr('select-value') );	
					newValue = $(val).attr('select-value');
				}
				else{
					label.html( $(this).html() );
					origin.val( $(this).attr('select-value') );	
					newValue = $(this).attr('select-value');
				}
				
				hideContainer();
				origin.trigger('select.pick', [oldValue,newValue]).trigger('change', [oldValue,newValue]);
			};
			
			$.each([label, chevron], function(index, item){ item.click(triggerShowContainer); });
			origin.click(showContainer);
			toggleContainer.find('[select-role="item"]').each(function(index, item){
				var pwidth = $(item).parent().width();
				var cwidth = $(item).width();
				
				//item width = parent.width, no issue on click
				if (cwidth == pwidth){
					$(item).click(pickItemInContainer);
				}
				
				//item width only display, absolutely an issue when not clicking item,
				//we git parent the event click
				else{
					$(item).parent().click(pickItemInContainer);
				}
			});
			$(window).on('click resize', hideContainer);
			
		});
		
		return this;
    };
}( jQuery ));

//use for <input> inside <div class="input-group">
//	options.modal.icon = string
//	options.modal.title = string
//	options.ajax.type = function
//	options.ajax.url = function
//	options.ajax.data = function
//	options.ajax.beforeSend = function
//	options.ajax.complete = function
//	options.ajax.success = function
//	options.ajax.error = function
//	options.onListItemClicked = function	
//	options.onFocus
(function( $ ) {
    $.fn.ajaxSearch = function(options) {
		
		var defOpt = {
			ajax:{},
			modal:{},
		};
		options = $.extend(defOpt, options );
		
		var createUID = function() {
			var text = "";
			var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
			for (var i = 0; i < 5; i++)
			text += possible.charAt(Math.floor(Math.random() * possible.length));
			return text;
		}
		
		var createLoader = function(root, uid){
			return $('<label id="'+uid+'-loader"><i class="button-icon-loader"></i></label>')
				.hide()
				.insertAfter(root);
		}
		
		var createDropdown = function(root, uid){
			var dropdown = $(
					'<div id="'+uid+'-dropdown" '+
						'class="w3-card w3-dropdown-content w3-bar-block w3-border" '+
						'style="width:100%; max-height:400px; overflow:hidden scroll;">'+
					'</div>'
				).appendTo(
					$('<div class="w3-hide-small w3-hide-medium" style="position:relative"></div>').insertAfter(root.parent())
				),
				list = $('<ul id="'+uid+'-dropdown-list" '+
							'class="w3-ul w3-hoverable" '+
							'style="display:table; list-style:none; width:100%">'+
						'</ul>');
				
			list.appendTo(dropdown);	
			return {container: dropdown, list:list};
		}
		
		var createDropdownListItem = function(json, onListItemClicked){	
			var name = json.name_front_titles==null? '': json.name_front_titles;
				name += json.name_full==null? '' : ' ' + json.name_full;
				name += json.name_back_titles==null? '' : ' ' + json.name_back_titles,
				nip = json.nip,
				li = $('<li style="display:table-row; cursor:pointer"></li>');
				
			li.append($('<div class="nip" style="display:table-cell; padding:8px 16px; width:100px;">'+ nip +'</div>'));
			li.append($('<div class="name" style="display:table-cell; padding:8px 16px; white-space: nowrap;">'+ name +'</div>'));
				
			return li.click(function(){
				onListItemClicked(json);
			});
		}
		
		var computeDropdownListWidth = function(){
			var offset = 10;
			var min = dropdown.list.attr('min-width');
				min = min? min : dropdown.list.attr('min-width', dropdown.list.width()).width();
			return Math.max(dropdown.container.width(), dropdown.list.width() + offset);
		}
		
		var createModal = function(root, uid){
			var icon = !options.modal.icon? '' : options.modal.icon,
				title = !options.modal.title? '' : options.modal.title,
				modal =  $(
					'<div id="'+uid+'-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">'+
						'<div class="w3-modal-content w3-animate-top w3-card-4">'+
							'<header class="w3-container w3-theme">'+
								'<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"'+
									'onclick="$(\'#uid-modal\').hide()">×</h4>'+
								'<h4 class="padding-top-8 padding-bottom-8">'+
									'<i class="'+icon+'"></i>'+
									'<span style="padding-left:12px;">'+options.modal.title+'</span>'+
								'</h4>'+
							'</header>'+
							'<div id="'+uid+'-modal-container"></div>'+
						'</div>'+
					'</div>'
				),
				ul = $('<ul class="w3-ul w3-hoverable"></ul>');
			
			modal.insertAfter(root.parent()).find('header').next().append(ul);
			return {container:modal, list:ul};
		}
		
		var createModalListItem = function(json, onListItemClicked){
			var name = json.name_front_titles==null? '': json.name_front_titles;
				name += json.name_full==null? '' : ' ' + json.name_full;
				name += json.name_back_titles==null? '' : ' ' + json.name_back_titles;
			return $('<li style="cursor:pointer;">'+
						'<a class="w3-text-theme w3-mobile">'+
							'<span style="width:100px;display:inline-block">'+ json.nip +'</span>'+
							'<span>'+ name +'</span>'+
						'</a>'+
					'</li>')
					.click(function(){
						onListItemClicked(json);
					});
		}
		
		var uid = createUID(),
			root = $(this).attr('autocomplete','off'),
			loader = createLoader(root, uid),
			dropdown = createDropdown(root, uid),
			modal = createModal(root,uid);
		
		var setDropdownVisibility = function(flag){
			if (flag && !isEmptyList()){
				dropdown.container.css('visiblity','hidden')
					.show()
					.width(computeDropdownListWidth())
					.css('visiblity','visible');
				modal.container.show();
			}
			else {
				dropdown.container.hide();
				modal.container.hide();
			}
		}
		
		var setLoaderVisibility = function(flag){
			if (flag) loader.show();
			else loader.hide();
		}
		
		var isEmptyList = function(){
			return dropdown.list.children().length<=0;
		}
		
		var emptyList = function(){ dropdown.list.empty(); modal.list.empty(); }
		
		var dispatchAjax = function(ajaxOptions){
			$.ajax({
				type: ajaxOptions.type(),
				url: ajaxOptions.url(),
				data: ajaxOptions.data(),
				beforeSend: beforeSendAjax,
				complete: completeAjax,
				success: successAjax,
				error: errorAjax,
			});
		}
		var beforeSendAjax = function(aa, bb){
			if (options.ajax.beforeSend) options.ajax.beforeSend(aa, bb);
			emptyList();
			setLoaderVisibility(true);
			setDropdownVisibility(false);
		}
		var completeAjax = function(aa, bb){
			if (options.ajax.complete) options.ajax.complete(aa, bb);
		}
		var successAjax = function(aa, bb){
			//no records, hide dropdown
			if (aa.length>0) {
				if (options.ajax.success) options.ajax.success(aa, bb);
				$.each(aa, function(index, item){ 
					dropdown.list.append( createDropdownListItem(item, options.onListItemClicked) );
					modal.list.append( createModalListItem(item, options.onListItemClicked) );
				});
				setDropdownVisibility(true);
			}
			else{				
				setDropdownVisibility(false);
			}
			setLoaderVisibility(false);
		}
		var errorAjax = function(aa, bb){ 
			emptyList(); 
			if (options.ajax.error) options.ajax.error(aa, bb);				
			setLoaderVisibility(false);
		}
		
		root.on('keyup', $.debounce(1000, 
			function(e){
				e.stopPropagation();
				if (e.keyCode == 27 || e.keyCode == 38) { //escape & up arrow
					setDropdownVisibility(false);
				}
				else if (e.keyCode == 40){	//down arrow
					setDropdownVisibility(true);
				}
				else {
					if (options.ajax) dispatchAjax(options.ajax);
				}
			})
		).on('focus', function(event){
			event.stopPropagation();
			if (options.onFocus) options.onFocus(event, this);				
		});
		
		$(window).resize(function(){
			setDropdownVisibility(true);
		}).click(function(){
			setDropdownVisibility(false);
		});
		
		
        return this;
    };
}( jQuery ));

(function( $ ) {
 
    $.fn.timepicker = function(options) {
		var iroot = $(this);
        var troot =  $('<div id="'+ iroot.attr('name').replace(/[\[\]]/g,'') +'-timepicker" class="timepicker">');
		
		//hours
		var thours = $('<div class="hours">').appendTo(troot);
		var thoursBtnNext = $('<button class="next">').append('<i class="fas fa-chevron-up">').appendTo(thours);
		var thoursBtnPrev = $('<button class="prev">').append('<i class="fas fa-chevron-down">').appendTo(thours);
		var thoursInp = $('<input type="text" class="w3-input hours" maxlength="2" />').insertBefore(thoursBtnPrev);
		
		//minutes
		var tminutes = $('<div class="minutes">').appendTo(troot);
		var tminutesBtnNext = $('<button class="next">').append('<i class="fas fa-chevron-up">').appendTo(tminutes);
		var tminutesBtnPrev = $('<button class="prev">').append('<i class="fas fa-chevron-down">').appendTo(tminutes);
		var tminutesInp = $('<input type="text" class="w3-input hours" maxlength="2" />').insertBefore(tminutesBtnPrev);
		
		//seconds
		var tseconds = $('<div class="seconds">').appendTo(troot);
		var tsecondsBtnNext = $('<button class="next">').append('<i class="fas fa-chevron-up">').appendTo(tseconds);
		var tsecondsBtnPrev = $('<button class="prev">').append('<i class="fas fa-chevron-down">').appendTo(tseconds);
		var tsecondsInp = $('<input type="text" class="w3-input hours" maxlength="2" />').insertBefore(tsecondsBtnPrev);
				
		troot.find('button').attr('type','button');
		
		//install event
		thoursBtnNext.click(function(event){ click("h", 1, event) });
		thoursBtnPrev.click(function(event){ click("h", -1, event) });
		tminutesBtnNext.click(function(event){ click("m", 1, event) });
		tminutesBtnPrev.click(function(event){ click("m", -1, event) });
		tsecondsBtnNext.click(function(event){ click("s", 1, event) });
		tsecondsBtnPrev.click(function(event){ click("s", -1, event) });
		
		var stopPropagation = function(event){ event.stopPropagation(); };
		var throttle = function(code, event){
			event.stopPropagation();
			if (event.keyCode == 38) click(code, 1, event);
			if (event.keyCode == 40) click(code, -1, event);
		};
		thoursInp.on('focus click ', stopPropagation)
			.on('keydown', function(event){ throttle("h",event); })
			.on('keyup', $.debounce( 500, function(event){
				event.stopPropagation();
				change('h',$(this).val(), event);
			}));
		tminutesInp.on('focus click ', stopPropagation)
			.on('keydown', function(event){ throttle("m",event); })
			.on('keyup', $.debounce( 500, function(event){
				change('m',$(this).val(), event);
			}));
		tsecondsInp.on('focus click ', stopPropagation)
			.on('keydown', function(event){ throttle("s",event); })
			.on('keyup', $.debounce( 500, function(event){
				change('s',$(this).val(), event);
			}));
		
		var defaults={
			parseFormat:'hh:mm:ss A',
			outputFormat: 'HH:mm:ss'
		};
		options = $.extend(defaults, options);
		
		var setLink = function(value) { $(iroot.attr('timepicker-link')).val(value); };
		var setSource = function(value){ $(iroot.attr('timepicker-source')).val(value); };
		var getSource = function(){ return $(iroot.attr('timepicker-source')).val(); };
		var getSourceTime = function(){ return moment(getSource(), options.parseFormat); };
		
		var getTime = function(){
			return iroot.attr('timepicker-source')? 
				getSourceTime() : 
				moment(iroot.val(), options.parseFormat);
		};
		
		var click = function(act, number, event){
			event.stopPropagation();
			var time = getTime();
			time = time.isValid()? time : moment('00:00:00', 'HH:mm:ss');
			if (number>0) time.add(number, act);
			else if (number<0) time.subtract(number*-1, act);
			display(time);
		};
		
		var change = function(act, number, event){
			event.stopPropagation();
			var time = getTime();
			time = time.isValid()? time : moment('00:00:00', 'HH:mm:ss');
			if (act=='h') time.hours(number);
			else if (act=='m') time.minute(number);
			else if (act=='s') time.second(number);
			display(time);
		};
		
		var display = function(time){
			thoursInp.val( time.isValid()? time.format('HH') : '00');
			tminutesInp.val( time.isValid()? time.format('mm') : '00' );
			tsecondsInp.val( time.isValid()? time.format('ss') : '00' );
			
			//set time value to source data
			var time = time.isValid()? time.format(options.outputFormat) : '';
			if (iroot.attr('timepicker-source')) setSource(time);
			if (iroot.attr('timepicker-link')) setLink(time);
			iroot.val(time);
			
			//trigger to display
			$(iroot).trigger('change');
		};
		
		//if options[container] exist
		if (iroot.attr('timepicker-container')){
			var isParentInputGroup = iroot.parent().hasClass('input-group');
			var height = isParentInputGroup? iroot.parent().height() : iroot.height();
			var container = iroot.attr('timepicker-container');
			
			//dropdown style
			$(container).append(troot);
			if (!iroot.attr('timepicker-modal')){
				$(container).css({padding: '8px', top: (height+2)+'px', right:'0'});
			}
			
			if (options.class) $(troot).addClass(options.class);
			if (options.styles) $(troot).attr('style',options.styles);
			
			//add focus event
			iroot.on('focus click', function(event){
				event.stopPropagation();
				$(window).trigger('click');
				
				if (iroot.attr('timepicker-modal')){
					$(iroot.attr('timepicker-modal')).show();
				}
				else{
					$(container).addClass('w3-show');
				}
				console.log(iroot.attr('timepicker-modal'));
			});
			$(window).on('click focus resize', function(){
				if (iroot.attr('timepicker-modal')){
					$(iroot.attr('timepicker-modal')).hide();
				}
				else{
					$(container).removeClass('w3-show');
				}
			});
		}
		else{
			troot.insertAfter(iroot);
		}
		
		display(getTime());
        return this;
    };
 
}( jQuery ));

var App = { UI: {} };
App.UI.inputGroup = function(el){
	$(el).focusin(function(){ $(el).parent().addClass('focus'); })
		.focusout(function(){$(el).parent().removeClass('focus');})
		.blur(function(){$(el).parent().removeClass('focus');});
};

App.init = function(){
	//input error remove error class
	$('input.w3-input.error').on('keyup', function(event){ 
		var inp = String.fromCharCode(event.keyCode);
		if (/[a-zA-Z0-9-_ ]/.test(inp)){
			$(this).removeClass('error'); 			
		}
	});
	$('.input-group.error>.w3-input').on('keyup', function(){ $(this).parent().removeClass('error'); });
	
	$.each( $('.input-group>.w3-input') , function( index, item ){ App.UI.inputGroup(item); });
};
  
$(document).ready(function() { App.init() });