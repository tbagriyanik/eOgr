/**
 * 1.0 Original article and Script is from: http://think2loud.com/build-an-unsupported-browser-warning-with-jquery/
 * 1.1 Then the script was extended here: http://blog.team-noir.net/2009/06/fight-old-browsers-warning-with-jquery/
 * 1.2 And finally Fleshgrinder had a look at it and also minified it: http://www.nervenhammer.com/
 * 1.3 Google Chrome & new Safari detect added by www.team-noir.net
 * 1.4 Browser Version Update by www.team-noir.net
 */

function badBrowser() {
	var userAgent = navigator.userAgent.toLowerCase();
	
	// Check for Microsoft Internet Explorer 8.0
	if ($.browser.msie && parseInt($.browser.version, 10) < 8) {
		return true;
	}
	// Check for Opera 9.5
	if ($.browser.opera && ($.browser.version *10) <= 95) {
		return true;
	}
	// Check for Mozilla Firefox 3.0
	if (/firefox[\/\s](\d+\.\d+)/.test(userAgent)) {
		var ffversion = Number(RegExp.$1);
		if (ffversion < 3) {
			return true;
		}
	}
	// Check for Safari < Version 4.0
	if (/safari[\/\s](\d+\.\d+)/.test(userAgent) && !/chrome[\/\s](\d+\.\d+)/.test(userAgent)) {
		var safari = userAgent.indexOf('version');
		if (safari > -1) {
			var snip1 = safari+8;
			var version = userAgent.substring(snip1, (snip1+1));
			if (version < 4) {
				return true;
			}
		}
	}
	// Check for Chrome < Version 3.0
	var chrome = userAgent.indexOf('chrome');
	if (chrome > -1) {
		var snip1 = chrome+7;
		var version = userAgent.substring(snip1, (snip1+2));

		if (version < 3) {
			return true;
			}
	}
	
    return false;
}

function getBadBrowser(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1) {
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}

function setBadBrowser(c_name,value,expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays === null) ? "" : ";expires=" + exdate.toGMTString());
}