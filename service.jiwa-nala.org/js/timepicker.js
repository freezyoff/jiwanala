(function( $ ) {
 
    $.fn.timepicker = function(options) {
		var defaults={
			parseFormat:'hh:mm:ss A',
			outputFormat: 'HH:mm:ss'
		}
		
		var iroot = this;
        var troot =  $('<div id="'+ this.attr('name').replace(/[\[\]]/g,'') +'-timepicker" class="timepicker">');
		
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
		
		var stopPropagation = function(event){ event.stopPropagation(); }
		thoursInp.on('keyup', $.debounce( 250, function(event){
			change('h',$(this).val(), event);
		})).on('focus click ', stopPropagation);
		tminutesInp.on('keyup', $.debounce( 250, function(event){
			change('m',$(this).val(), event);
		})).on('focus click ', stopPropagation);
		tsecondsInp.on('keyup', $.debounce( 250, function(event){
			change('s',$(this).val(), event);
		})).on('focus click ', stopPropagation);
		
		options = $.extend(defaults, options);
		
		var initTime = function(parseFormat){
			var time = moment(iroot.val(), parseFormat);
			if (!time.isValid()) return moment('00:00:00 AM',parseFormat);
			return time;
		};
		
		var time = initTime(options.parseFormat);
		
		var click = function(act, number, event){
			event.stopPropagation();
			if (number>0) time.add(number, act);
			else if (number<0) time.subtract(number*-1, act);				
			display();
		}
		
		var change = function(act, number, event){
			event.stopPropagation();
			if (act=='h') time.hours(number);
			else if (act=='m') time.minute(number);
			else if (act=='s') time.second(number);
			display();
		}
		
		var display = function(){
			thoursInp.val(time.format('HH'));
			tminutesInp.val(time.format('mm'));
			tsecondsInp.val(time.format('ss'));
			iroot.val(time.format(options.outputFormat));
			$(iroot).trigger('change');
		}
		
		//if options[container] exist
		if (options){			
			if (options.container) $(options.container).append(troot);
			if (options.class) $(troot).addClass(options.class);
			if (options.styles) $(troot).attr('style',options.styles);
		}
		else{
			troot.insertAfter(this);
		}
		
		//trigger display
		display();
        return this;
    };
 
}( jQuery ));