/**
/*
 * 	Magic Scroll 0.1.5  - jQuery plugin
 *	written by Gabriele Campi	
 *	http://magicscroll.madeinthecave.com
 *	magicscroll@madeinthecave.com	
 *
 *	Copyright (c) 2009 Gabriele Campi (http://www.madeinthecave.com)
 *	Dual licensed under the MIT and GPL licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
(function(a){var b={auto:true,area:10,scroll:200,speed:600,play_key:44,pause_key:46};a.fn.magicScroll=function(e){var d=a.extend({},b,e);var h=a("html,body");var f=d.auto;if(d.auto){h.bind("mousemove",function(i){c(i)})}var g=false;a(document).keyup(function(i){if(i.which==17){g=false}});a(document).keydown(function(i){if(i.which==17){g=true}});if(d.play_key==d.pause_key){h.keypress(function(i){if(i.which==d.play_key&&g==true){if(f){h.unbind("mousemove");f=false}else{h.bind("mousemove",function(j){c(j);f=true})}}})}if(d.play_key!=d.pause_key){h.keypress(function(i){if(i.which==d.play_key&&g==true){h.bind("mousemove",function(j){c(j);f=true})}});h.keypress(function(i){if(i.which==d.pause_key&&g==true){h.unbind("mousemove");f=false}})}function c(l){var i=a(window).scrollTop();var k;var m;var j;k=parseInt(l.pageY);win_heigh=parseInt(a(window).height());win_heigh_limit_down=parseInt(win_heigh-d.area+i);win_heigh_limit_top=parseInt(d.area+i);doc_heigh=parseInt(a(document).height());if(k>win_heigh_limit_down){a("html,body").stop().animate({scrollTop:i+d.scroll},d.speed);a("html,body").unbind("mousemove");setTimeout(function(){a("html,body").bind("mousemove",function(n){c(n);f=true})},d.speed)}if(k<win_heigh_limit_top){a("html,body").stop().animate({scrollTop:i-d.scroll},d.speed);a("html,body").unbind("mousemove");setTimeout(function(){a("html,body").bind("mousemove",function(n){c(n);f=true})},d.speed)}}}})(jQuery);