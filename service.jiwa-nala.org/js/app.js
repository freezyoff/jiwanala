/*!
 * Datepicker v1.0.1
 * https://fengyuanchen.github.io/datepicker
 *
 * Copyright 2014-present Chen Fengyuan
 * Released under the MIT license
 *
 * Date: 2018-11-14T13:59:48.051Z
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],t):t(e.jQuery)}(this,function(D){"use strict";function s(e,t){for(var i=0;i<t.length;i++){var a=t[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}D=D&&D.hasOwnProperty("default")?D.default:D;var n={autoShow:!1,autoHide:!1,autoPick:!1,inline:!1,container:null,trigger:null,language:"",format:"mm/dd/yyyy",date:null,startDate:null,endDate:null,startView:0,weekStart:0,yearFirst:!1,yearSuffix:"",days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],itemTag:"li",mutedClass:"muted",pickedClass:"picked",disabledClass:"disabled",highlightedClass:"highlighted",template:'<div class="datepicker-container"><div class="datepicker-panel" data-view="years picker"><ul><li data-view="years prev">&lsaquo;</li><li data-view="years current"></li><li data-view="years next">&rsaquo;</li></ul><ul data-view="years"></ul></div><div class="datepicker-panel" data-view="months picker"><ul><li data-view="year prev">&lsaquo;</li><li data-view="year current"></li><li data-view="year next">&rsaquo;</li></ul><ul data-view="months"></ul></div><div class="datepicker-panel" data-view="days picker"><ul><li data-view="month prev">&lsaquo;</li><li data-view="month current"></li><li data-view="month next">&rsaquo;</li></ul><ul data-view="week"></ul><ul data-view="days"></ul></div></div>',offset:10,zIndex:1e3,filter:null,show:null,hide:null,pick:null},e="undefined"!=typeof window?window:{},d="datepicker",r="click.".concat(d),h="focus.".concat(d),o="hide.".concat(d),l="keyup.".concat(d),c="pick.".concat(d),t="resize.".concat(d),i="scroll.".concat(d),u="show.".concat(d),p="".concat(d,"-hide"),f={},g=0,y=1,v=2,a=Object.prototype.toString;function m(e){return"string"==typeof e}var w=Number.isNaN||e.isNaN;function k(e){return"number"==typeof e&&!w(e)}function b(e){return void 0===e}function C(e){return"date"===(t=e,a.call(t).slice(8,-1).toLowerCase());var t}function $(a,s){for(var e=arguments.length,n=new Array(2<e?e-2:0),t=2;t<e;t++)n[t-2]=arguments[t];return function(){for(var e=arguments.length,t=new Array(e),i=0;i<e;i++)t[i]=arguments[i];return a.apply(s,n.concat(t))}}function x(e){return'[data-view="'.concat(e,'"]')}function G(e,t){return[31,(i=e,i%4==0&&i%100!=0||i%400==0?29:28),31,30,31,30,31,31,30,31,30,31][t];var i}function F(e,t,i){return Math.min(i,G(e,t))}var M=/(y|m|d)+/g;var V=/\d+/g,Y={show:function(){this.built||this.build(),this.shown||this.trigger(u).isDefaultPrevented()||(this.shown=!0,this.$picker.removeClass(p).on(r,D.proxy(this.click,this)),this.showView(this.options.startView),this.inline||(this.$scrollParent.on(i,D.proxy(this.place,this)),D(window).on(t,this.onResize=$(this.place,this)),D(document).on(r,this.onGlobalClick=$(this.globalClick,this)),D(document).on(l,this.onGlobalKeyup=$(this.globalKeyup,this)),this.place()))},hide:function(){this.shown&&(this.trigger(o).isDefaultPrevented()||(this.shown=!1,this.$picker.addClass(p).off(r,this.click),this.inline||(this.$scrollParent.off(i,this.place),D(window).off(t,this.onResize),D(document).off(r,this.onGlobalClick),D(document).off(l,this.onGlobalKeyup))))},toggle:function(){this.shown?this.hide():this.show()},update:function(){var e=this.getValue();e!==this.oldValue&&(this.setDate(e,!0),this.oldValue=e)},pick:function(e){var t=this.$element,i=this.date;this.trigger(c,{view:e||"",date:i}).isDefaultPrevented()||(i=this.formatDate(this.date),this.setValue(i),this.isInput&&(t.trigger("input"),t.trigger("change")))},reset:function(){this.setDate(this.initialDate,!0),this.setValue(this.initialValue),this.shown&&this.showView(this.options.startView)},getMonthName:function(e,t){var i=this.options,a=i.monthsShort,s=i.months;return D.isNumeric(e)?e=Number(e):b(t)&&(t=e),!0===t&&(s=a),s[k(e)?e:this.date.getMonth()]},getDayName:function(e,t,i){var a=this.options,s=a.days;return D.isNumeric(e)?e=Number(e):(b(i)&&(i=t),b(t)&&(t=e)),i?s=a.daysMin:t&&(s=a.daysShort),s[k(e)?e:this.date.getDay()]},getDate:function(e){var t=this.date;return e?this.formatDate(t):new Date(t)},setDate:function(e,t){var i=this.options.filter;if(C(e)||m(e)){if(e=this.parseDate(e),D.isFunction(i)&&!1===i.call(this.$element,e,"day"))return;this.date=e,this.viewDate=new Date(e),t||this.pick(),this.built&&this.render()}},setStartDate:function(e){C(e)||m(e)?this.startDate=this.parseDate(e):this.startDate=null,this.built&&this.render()},setEndDate:function(e){C(e)||m(e)?this.endDate=this.parseDate(e):this.endDate=null,this.built&&this.render()},parseDate:function(e){var a=this.format,t=[];if(C(e))return new Date(e.getFullYear(),e.getMonth(),e.getDate());m(e)&&(t=e.match(V)||[]),e=new Date;var i=a.parts.length,s=e.getFullYear(),n=e.getDate(),r=e.getMonth();return t.length===i&&D.each(t,function(e,t){var i=parseInt(t,10);switch(a.parts[e]){case"dd":case"d":n=i;break;case"mm":case"m":r=i-1;break;case"yy":s=2e3+i;break;case"yyyy":s=i}}),new Date(s,r,n)},formatDate:function(e){var t=this.format,i="";if(C(e)){var a=e.getFullYear(),s={d:e.getDate(),m:e.getMonth()+1,yy:a.toString().substring(2),yyyy:a};s.dd=(s.d<10?"0":"")+s.d,s.mm=(s.m<10?"0":"")+s.m,i=t.source,D.each(t.parts,function(e,t){i=i.replace(t,s[t])})}return i},destroy:function(){this.unbind(),this.unbuild(),this.$element.removeData(d)}},I={click:function(e){var t=D(e.target),i=this.options,a=this.viewDate,s=this.format;if(e.stopPropagation(),e.preventDefault(),!t.hasClass("disabled")){var n=t.data("view"),r=a.getFullYear(),h=a.getMonth(),o=a.getDate();switch(n){case"years prev":case"years next":r="years prev"===n?r-10:r+10,this.viewDate=new Date(r,h,F(r,h,o)),this.renderYears();break;case"year prev":case"year next":r="year prev"===n?r-1:r+1,this.viewDate=new Date(r,h,F(r,h,o)),this.renderMonths();break;case"year current":s.hasYear&&this.showView(v);break;case"year picked":s.hasMonth?this.showView(y):(t.addClass(i.pickedClass).siblings().removeClass(i.pickedClass),this.hideView()),this.pick("year");break;case"year":r=parseInt(t.text(),10),this.date=new Date(r,h,F(r,h,o)),s.hasMonth?(this.viewDate=new Date(this.date),this.showView(y)):(t.addClass(i.pickedClass).siblings().removeClass(i.pickedClass),this.renderYears(),this.hideView()),this.pick("year");break;case"month prev":case"month next":(h="month prev"===n?h-1:h+1)<0?(r-=1,h+=12):11<h&&(r+=1,h-=12),this.viewDate=new Date(r,h,F(r,h,o)),this.renderDays();break;case"month current":s.hasMonth&&this.showView(y);break;case"month picked":s.hasDay?this.showView(g):(t.addClass(i.pickedClass).siblings().removeClass(i.pickedClass),this.hideView()),this.pick("month");break;case"month":h=D.inArray(t.text(),i.monthsShort),this.date=new Date(r,h,F(r,h,o)),s.hasDay?(this.viewDate=new Date(r,h,F(r,h,o)),this.showView(g)):(t.addClass(i.pickedClass).siblings().removeClass(i.pickedClass),this.renderMonths(),this.hideView()),this.pick("month");break;case"day prev":case"day next":case"day":"day prev"===n?h-=1:"day next"===n&&(h+=1),o=parseInt(t.text(),10),this.date=new Date(r,h,o),this.viewDate=new Date(r,h,o),this.renderDays(),"day"===n&&this.hideView(),this.pick("day");break;case"day picked":this.hideView(),this.pick("day")}}},globalClick:function(e){for(var t=e.target,i=this.element,a=this.$trigger[0],s=!0;t!==document;){if(t===a||t===i){s=!1;break}t=t.parentNode}s&&this.hide()},keyup:function(){this.update()},globalKeyup:function(e){var t=e.target,i=e.key,a=e.keyCode;this.isInput&&t!==this.element&&this.shown&&("Tab"===i||9===a)&&this.hide()}},T={render:function(){this.renderYears(),this.renderMonths(),this.renderDays()},renderWeek:function(){var i=this,a=[],e=this.options,t=e.weekStart,s=e.daysMin;t=parseInt(t,10)%7,s=s.slice(t).concat(s.slice(0,t)),D.each(s,function(e,t){a.push(i.createItem({text:t}))}),this.$week.html(a.join(""))},renderYears:function(){var e,t=this.options,i=this.startDate,a=this.endDate,s=t.disabledClass,n=t.filter,r=t.yearSuffix,h=this.viewDate.getFullYear(),o=(new Date).getFullYear(),l=this.date.getFullYear(),d=[],c=!1,u=!1;for(e=-5;e<=6;e+=1){var p=new Date(h+e,1,1),f=!1;i&&(f=p.getFullYear()<i.getFullYear(),-5===e&&(c=f)),!f&&a&&(f=p.getFullYear()>a.getFullYear(),6===e&&(u=f)),!f&&n&&(f=!1===n.call(this.$element,p,"year"));var g=h+e===l,y=g?"year picked":"year";d.push(this.createItem({picked:g,disabled:f,text:h+e,view:f?"year disabled":y,highlighted:p.getFullYear()===o}))}this.$yearsPrev.toggleClass(s,c),this.$yearsNext.toggleClass(s,u),this.$yearsCurrent.toggleClass(s,!0).html("".concat(h+-5+r," - ").concat(h+6).concat(r)),this.$years.html(d.join(""))},renderMonths:function(){var e,t=this.options,i=this.startDate,a=this.endDate,s=this.viewDate,n=t.disabledClass||"",r=t.monthsShort,h=D.isFunction(t.filter)&&t.filter,o=s.getFullYear(),l=new Date,d=l.getFullYear(),c=l.getMonth(),u=this.date.getFullYear(),p=this.date.getMonth(),f=[],g=!1,y=!1;for(e=0;e<=11;e+=1){var v=new Date(o,e,1),m=!1;i&&(m=(g=v.getFullYear()===i.getFullYear())&&v.getMonth()<i.getMonth()),!m&&a&&(m=(y=v.getFullYear()===a.getFullYear())&&v.getMonth()>a.getMonth()),!m&&h&&(m=!1===h.call(this.$element,v,"month"));var w=o===u&&e===p,k=w?"month picked":"month";f.push(this.createItem({disabled:m,picked:w,highlighted:o===d&&v.getMonth()===c,index:e,text:r[e],view:m?"month disabled":k}))}this.$yearPrev.toggleClass(n,g),this.$yearNext.toggleClass(n,y),this.$yearCurrent.toggleClass(n,g&&y).html(o+t.yearSuffix||""),this.$months.html(f.join(""))},renderDays:function(){var e,t,i,a=this.$element,s=this.options,n=this.startDate,r=this.endDate,h=this.viewDate,o=this.date,l=s.disabledClass,d=s.filter,c=s.months,u=s.weekStart,p=s.yearSuffix,f=h.getFullYear(),g=h.getMonth(),y=new Date,v=y.getFullYear(),m=y.getMonth(),w=y.getDate(),k=o.getFullYear(),D=o.getMonth(),b=o.getDate(),C=[],$=f,x=g,F=!1;0===g?($-=1,x=11):x-=1,e=G($,x);var M=new Date(f,g,1);for((i=M.getDay()-parseInt(u,10)%7)<=0&&(i+=7),n&&(F=M.getTime()<=n.getTime()),t=e-(i-1);t<=e;t+=1){var V=new Date($,x,t),Y=!1;n&&(Y=V.getTime()<n.getTime()),!Y&&d&&(Y=!1===d.call(a,V,"day")),C.push(this.createItem({disabled:Y,highlighted:$===v&&x===m&&V.getDate()===w,muted:!0,picked:$===k&&x===D&&t===b,text:t,view:"day prev"}))}var I=[],T=f,S=g,P=!1;11===g?(T+=1,S=0):S+=1,e=G(f,g),i=42-(C.length+e);var N=new Date(f,g,e);for(r&&(P=N.getTime()>=r.getTime()),t=1;t<=i;t+=1){var j=new Date(T,S,t),q=T===k&&S===D&&t===b,A=!1;r&&(A=j.getTime()>r.getTime()),!A&&d&&(A=!1===d.call(a,j,"day")),I.push(this.createItem({disabled:A,picked:q,highlighted:T===v&&S===m&&j.getDate()===w,muted:!0,text:t,view:"day next"}))}var O=[];for(t=1;t<=e;t+=1){var W=new Date(f,g,t),z=!1;n&&(z=W.getTime()<n.getTime()),!z&&r&&(z=W.getTime()>r.getTime()),!z&&d&&(z=!1===d.call(a,W,"day"));var J=f===k&&g===D&&t===b,E=J?"day picked":"day";O.push(this.createItem({disabled:z,picked:J,highlighted:f===v&&g===m&&W.getDate()===w,text:t,view:z?"day disabled":E}))}this.$monthPrev.toggleClass(l,F),this.$monthNext.toggleClass(l,P),this.$monthCurrent.toggleClass(l,F&&P).html(s.yearFirst?"".concat(f+p," ").concat(c[g]):"".concat(c[g]," ").concat(f).concat(p)),this.$days.html(C.join("")+O.join("")+I.join(""))}},S="".concat(d,"-top-left"),P="".concat(d,"-top-right"),N="".concat(d,"-bottom-left"),j="".concat(d,"-bottom-right"),q=[S,P,N,j].join(" "),A=function(){function i(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{};!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,i),this.$element=D(e),this.element=e,this.options=D.extend({},n,f[t.language],D.isPlainObject(t)&&t),this.$scrollParent=function(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1],i=D(e),a=i.css("position"),s="absolute"===a,n=t?/auto|scroll|hidden/:/auto|scroll/,r=i.parents().filter(function(e,t){var i=D(t);return(!s||"static"!==i.css("position"))&&n.test(i.css("overflow")+i.css("overflow-y")+i.css("overflow-x"))}).eq(0);return"fixed"!==a&&r.length?r:D(e.ownerDocument||document)}(e,!0),this.built=!1,this.shown=!1,this.isInput=!1,this.inline=!1,this.initialValue="",this.initialDate=null,this.startDate=null,this.endDate=null,this.init()}var e,t,a;return e=i,a=[{key:"setDefaults",value:function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};D.extend(n,f[e.language],D.isPlainObject(e)&&e)}}],(t=[{key:"init",value:function(){var e=this.$element,t=this.options,i=t.startDate,a=t.endDate,s=t.date;this.$trigger=D(t.trigger),this.isInput=e.is("input")||e.is("textarea"),this.inline=t.inline&&(t.container||!this.isInput),this.format=function(i){var e=String(i).toLowerCase(),t=e.match(M);if(!t||0===t.length)throw new Error("Invalid date format.");return i={source:e,parts:t},D.each(t,function(e,t){switch(t){case"dd":case"d":i.hasDay=!0;break;case"mm":case"m":i.hasMonth=!0;break;case"yyyy":case"yy":i.hasYear=!0}}),i}(t.format);var n=this.getValue();this.initialValue=n,this.oldValue=n,s=this.parseDate(s||n),i&&(i=this.parseDate(i),s.getTime()<i.getTime()&&(s=new Date(i)),this.startDate=i),a&&(a=this.parseDate(a),i&&a.getTime()<i.getTime()&&(a=new Date(i)),s.getTime()>a.getTime()&&(s=new Date(a)),this.endDate=a),this.date=s,this.viewDate=new Date(s),this.initialDate=new Date(this.date),this.bind(),(t.autoShow||this.inline)&&this.show(),t.autoPick&&this.pick()}},{key:"build",value:function(){if(!this.built){this.built=!0;var e=this.$element,t=this.options,i=D(t.template);this.$picker=i,this.$week=i.find(x("week")),this.$yearsPicker=i.find(x("years picker")),this.$yearsPrev=i.find(x("years prev")),this.$yearsNext=i.find(x("years next")),this.$yearsCurrent=i.find(x("years current")),this.$years=i.find(x("years")),this.$monthsPicker=i.find(x("months picker")),this.$yearPrev=i.find(x("year prev")),this.$yearNext=i.find(x("year next")),this.$yearCurrent=i.find(x("year current")),this.$months=i.find(x("months")),this.$daysPicker=i.find(x("days picker")),this.$monthPrev=i.find(x("month prev")),this.$monthNext=i.find(x("month next")),this.$monthCurrent=i.find(x("month current")),this.$days=i.find(x("days")),this.inline?D(t.container||e).append(i.addClass("".concat(d,"-inline"))):(D(document.body).append(i.addClass("".concat(d,"-dropdown"))),i.addClass(p).css({zIndex:parseInt(t.zIndex,10)})),this.renderWeek()}}},{key:"unbuild",value:function(){this.built&&(this.built=!1,this.$picker.remove())}},{key:"bind",value:function(){var e=this.options,t=this.$element;D.isFunction(e.show)&&t.on(u,e.show),D.isFunction(e.hide)&&t.on(o,e.hide),D.isFunction(e.pick)&&t.on(c,e.pick),this.isInput&&t.on(l,D.proxy(this.keyup,this)),this.inline||(e.trigger?this.$trigger.on(r,D.proxy(this.toggle,this)):this.isInput?t.on(h,D.proxy(this.show,this)):t.on(r,D.proxy(this.show,this)))}},{key:"unbind",value:function(){var e=this.$element,t=this.options;D.isFunction(t.show)&&e.off(u,t.show),D.isFunction(t.hide)&&e.off(o,t.hide),D.isFunction(t.pick)&&e.off(c,t.pick),this.isInput&&e.off(l,this.keyup),this.inline||(t.trigger?this.$trigger.off(r,this.toggle):this.isInput?e.off(h,this.show):e.off(r,this.show))}},{key:"showView",value:function(e){var t=this.$yearsPicker,i=this.$monthsPicker,a=this.$daysPicker,s=this.format;if(s.hasYear||s.hasMonth||s.hasDay)switch(Number(e)){case v:i.addClass(p),a.addClass(p),s.hasYear?(this.renderYears(),t.removeClass(p),this.place()):this.showView(g);break;case y:t.addClass(p),a.addClass(p),s.hasMonth?(this.renderMonths(),i.removeClass(p),this.place()):this.showView(v);break;default:t.addClass(p),i.addClass(p),s.hasDay?(this.renderDays(),a.removeClass(p),this.place()):this.showView(y)}}},{key:"hideView",value:function(){!this.inline&&this.options.autoHide&&this.hide()}},{key:"place",value:function(){if(!this.inline){var e=this.$element,t=this.options,i=this.$picker,a=D(document).outerWidth(),s=D(document).outerHeight(),n=e.outerWidth(),r=e.outerHeight(),h=i.width(),o=i.height(),l=e.offset(),d=l.left,c=l.top,u=parseFloat(t.offset),p=S;w(u)&&(u=10),o<c&&s<c+r+o?(c-=o+u,p=N):c+=r+u,a<d+h&&(d+=n-h,p=p.replace("left","right")),i.removeClass(q).addClass(p).css({top:c,left:d})}}},{key:"trigger",value:function(e,t){var i=D.Event(e,t);return this.$element.trigger(i),i}},{key:"createItem",value:function(e){var t=this.options,i=t.itemTag,a={text:"",view:"",muted:!1,picked:!1,disabled:!1,highlighted:!1},s=[];return D.extend(a,e),a.muted&&s.push(t.mutedClass),a.highlighted&&s.push(t.highlightedClass),a.picked&&s.push(t.pickedClass),a.disabled&&s.push(t.disabledClass),"<".concat(i,' class="').concat(s.join(" "),'" data-view="').concat(a.view,'">').concat(a.text,"</").concat(i,">")}},{key:"getValue",value:function(){var e=this.$element;return this.isInput?e.val():e.text()}},{key:"setValue",value:function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:"",t=this.$element;this.isInput?t.val(e):this.inline&&!this.options.container||t.text(e)}}])&&s(e.prototype,t),a&&s(e,a),i}();if(D.extend&&D.extend(A.prototype,T,I,Y),D.fn){var O=D.fn.datepicker;D.fn.datepicker=function(h){for(var e=arguments.length,o=new Array(1<e?e-1:0),t=1;t<e;t++)o[t-1]=arguments[t];var l;return this.each(function(e,t){var i=D(t),a="destroy"===h,s=i.data(d);if(!s){if(a)return;var n=D.extend({},i.data(),D.isPlainObject(h)&&h);s=new A(t,n),i.data(d,s)}if(m(h)){var r=s[h];D.isFunction(r)&&(l=r.apply(s,o),a&&i.removeData(d))}}),b(l)?this:l},D.fn.datepicker.Constructor=A,D.fn.datepicker.languages=f,D.fn.datepicker.setDefaults=A.setDefaults,D.fn.datepicker.noConflict=function(){return D.fn.datepicker=O,this}}});

(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
  (factory(global.jQuery));
}(this, (function ($) {
  'use strict';

  $.fn.datepicker.languages['id-ID'] = {
    format: 'dd-mm-YYYY',
    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    daysMin: ['Mn', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
    weekStart: 1,
    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    // Used everywhere, but probably not grammar correct
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  };
})));
/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);
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