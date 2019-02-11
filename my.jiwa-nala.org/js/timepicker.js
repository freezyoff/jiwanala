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
			.on('keyup', $.debounce( 250, function(event){
				event.stopPropagation();
				change('h',$(this).val(), event);
			}));
		tminutesInp.on('focus click ', stopPropagation)
			.on('keydown', function(event){ throttle("m",event); })
			.on('keyup', $.debounce( 250, function(event){
				change('m',$(this).val(), event);
			}));
		tsecondsInp.on('focus click ', stopPropagation)
			.on('keydown', function(event){ throttle("s",event); })
			.on('keyup', $.debounce( 250, function(event){
				change('s',$(this).val(), event);
			}));
		
		var defaults={
			parseFormat:'hh:mm:ss A',
			outputFormat: 'HH:mm:ss'
		}
		options = $.extend(defaults, options);
		
		var setLink = function(value) { $(iroot.attr('timepicker-link')).val(value); }
		var setSource = function(value){ $(iroot.attr('timepicker-source')).val(value); }
		var getSource = function(){ return $(iroot.attr('timepicker-source')).val(); }
		var getSourceTime = function(){ return moment(getSource(), options.parseFormat); }
		
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
		}
		
		var change = function(act, number, event){
			event.stopPropagation();
			var time = getTime();
			time = time.isValid()? time : moment('00:00:00', 'HH:mm:ss');
			if (act=='h') time.hours(number);
			else if (act=='m') time.minute(number);
			else if (act=='s') time.second(number);
			display(time);
		}
		
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
		}
		
		//if options[container] exist
		if (iroot.attr('timepicker-container')){
			var container = iroot.attr('timepicker-container');
			$(container).append(troot).css('padding', '8px');
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
					$(container).addClass('w3-show').css('right','0');
				}
			});
			$(window).on('click focus', function(){
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