/**
 * ping for jQuery
 *
 * @auth Jessica
 * @link http://www.skiyo.cn/demo/jquery.ping/
 *
 */
(function($) {
	$.fn.ping = function(options) {
		var opts = $.extend({}, $.fn.ping.defaults, options);
		return this.each(function() {
			var ping, requestTime, responseTime ;
			var target = $(this);
			function ping() {
				$.ajax({url: 'empty' + Math.random() + '.html',  
					type: 'GET',
					dataType: 'html',
					timeout: 30000,
					beforeSend : function() {
						requestTime = new Date().getTime();
					},
					complete : function() {
						responseTime = new Date().getTime();
						ping = Math.abs(requestTime - responseTime);
						if(ping<250){
						 document.getElementById('pingTest').src = "img/spacer.gif";
						 document.getElementById('pingTest').title = "Ping : "+ping + "ms";
						}
						else {
						 document.getElementById('pingTest').src = "img/warning.png";
						 document.getElementById('pingTest').title = "Ping : "+ping + "ms";
						}
//						target.text(ping);						  
					}
				});
			}
			ping(); 
			opts.interval != 0 && setInterval(ping,opts.interval * 1000);
		});
	};
	$.fn.ping.defaults = {
		interval: 3,
		unit: 'ms'
	};
})(jQuery);