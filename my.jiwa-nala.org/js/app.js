/* jQuery-FontSpy.js v3.0.0
 * https://github.com/patrickmarabeas/jQuery-FontSpy.js
 *
 * Copyright 2013, Patrick Marabeas http://pulse-dev.com
 * Released under the MIT license
 * http://opensource.org/licenses/mit-license.php
 *
 * Date: 02/11/2015
 */

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
    $.fn.select = function() {
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
				.css('cursor','pointer')
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
				).css('cursor','pointer')
				.insertBefore(origin);
			
			//event 
			var chevronToggle = function(){
				var dropdown = toggleContainer.filter(origin.attr('select-dropdown'));
				var add = dropdown.is(':visible')? 'fa-chevron-up' : 'fa-chevron-down';
				var del = dropdown.is(':visible')? 'fa-chevron-down' : 'fa-chevron-up';
				chevron.find('.w3-hide-small.w3-hide-medium').removeClass(del).addClass(add);
			};
			
			var triggerShowContainer = function(event){
				event.stopPropagation();
				origin.trigger('click');
			}
			
			var showContainer = function(event){
				event.stopPropagation();
				var width = $(this).parent().hasClass('input-group')? $(this).parent().width() : $(this).width();
				toggleContainer.filter($(this).attr('select-dropdown')).width(width);	//dropdown only set the width
				toggleContainer.show();	//show all
				chevronToggle();
			};
			
			var hideContainer = function(event){
				toggleContainer.hide();	//hide all
				chevronToggle();
			};
			
			var pickItemInContainer = function(){
				if ($(this).is('li')){
					var val = $(this).find('a[select-role="item"]');
					label.html( $(val).html() );
					origin.val( $(val).attr('select-value') );	
				}
				else{
					label.html( $(this).html() );
					origin.val( $(this).attr('select-value') );	
				}
				
				hideContainer();
				origin.trigger('select.pick');
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
			$(window).click(hideContainer);
			
		});
		
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