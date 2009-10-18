//////////////////////////////////////////
// PHPLiveX Library						//
// (C) Copyright 2006 Arda Beyazoglu	//
// Version: 2.5.1						//
// Home Page: www.phplivex.com			//
// Contact: ardabeyazoglu@gmail.com		//
// License: LGPL						//
// Release Date: 27.09.2008				//
//////////////////////////////////////////

function PHPLiveX(){
	this.Options = {
		"type": "asynchronous", 
		"mode": "rw", 
		"target": null, 
		"preloader": null, 
		"method": "post",
		"onCreate": function(){},
		"onUninitialized": function(){}, 
		"onLoading": function(){}, 
		"onRequest": function(){}, 
		"onInteraction": function(){}, 
		"onFinish": function(){},  
		"onUpdate": function(){}, 
		"onFailure": function(){}, 
		"interval": 0, 
		"clear_content": false,
		"preloader_style": "visibility", 
		"target_attr": "innerContent",
		"url": "",
		"eval_scripts": true, 
		"content_type": "text",
		"headers": {},
		"params": {}
	};
	
	this.Validations = {
		"type": {"values": ["asynchronous", "synchronous"]},
		"mode": {"values": ["rw", "aw", "asw"]},
		"target": {"formats": ["object", "string"]}, "preloader": {"formats": ["object", "string"]},
		"method": {"values": ["get", "post"]},
		"onCreate": {"formats": ["function"]}, "onUninitialized": {"formats": ["function"]}, "onLoading": {"formats": ["function"]}, "onRequest": {"formats": ["function"]}, "onInteraction": {"formats": ["function"]}, "onFinish": {"formats": ["function"]}, "onUpdate": {"formats": ["function"]}, "onFailure": {"formats": ["function"]},
		"interval": {"formats": ["number"]},
		"clear_content": {"formats": ["boolean"]}, "eval_content": {"formats": ["boolean"]}, 
		"preloader_style": {"values": ["visibility", "display"]}, 
		"target_attr": {"formats": ["string"]},
		"url": {"formats": ["string"]},
		"content_type": {"values": ["text", "json"]},
		"headers": {"formats": ["object"]}, "params": {"formats": ["object"]}
	};
	
	if(navigator.appName == "Opera") this.Browser = "opera";
	else if(navigator.appName == "Microsoft Internet Explorer") this.Browser = "ie";
	else this.Browser = "gecko";
}

PHPLiveX.prototype.GetXmlHttp = function(){
	objXmlHttp = false;
	if(window.XMLHttpRequest) {
		objXmlHttp = new XMLHttpRequest();
		if (objXmlHttp.overrideMimeType) {
			objXmlHttp.overrideMimeType('text/xml');
		}
	}else if(window.ActiveXObject) {
		try {
			objXmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e) {
			try{ objXmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); }
			catch(e) {}
		}
	}

	if (!objXmlHttp) {
		alert("Cannot create an XMLHTTP instance");
		return false;
	}

	return objXmlHttp;
}

PHPLiveX.prototype.ParseArray = function(arr){
	if(arr.length == undefined) return this.ParseObject(arr);
	var values = new Array();

	for(key in arr){
		if(typeof arr[key] == "string") val = "\"" + arr[key] + "\"";
		else if(typeof arr[key] == "object"){
			if(arr[key].length != undefined) val = this.ParseArray(arr[key]);
			else val = this.ParseObject(arr[key]);
		}
		else val = arr[key];
		values.push(val);
	}

	return "[" + values.join(", ") + "]";
}

PHPLiveX.prototype.ParseObject = function(obj){
	if(obj.length != undefined) return this.ParseArray(obj);
	var values = new Array();

	for(key in obj){
		if(obj[key] != null){
			if(typeof obj[key] == "string"){
				val = "\"" + key + "\": " + "\"" + obj[key] + "\"";
			}else if(typeof obj[key] == "object"){
				if(obj[key].length != undefined) val = "\"" + key + "\": " + this.ParseArray(obj[key]);
				else val = "\"" + key + "\": " + this.ParseObject(obj[key]);
			}
			else val = "\"" + key + "\": " + obj[key];
			values.push(val);
		}
	}

	return "{" + values.join(", ") + "}";
}

PHPLiveX.prototype.utf8_encode = function(string){
	if(typeof(string) != "string") return escape(string);
	string = string.replace(/\r\n/g,"\n");
	var utftext = "";
	for (var n = 0; n < string.length; n++){
		var c = string.charCodeAt(n);
		if (c < 128) {
			utftext += String.fromCharCode(c);
		}else if((c > 127) && (c < 2048)){
			utftext += String.fromCharCode((c >> 6) | 192);
			utftext += String.fromCharCode((c & 63) | 128);
		}else{
			utftext += String.fromCharCode((c >> 12) | 224);
			utftext += String.fromCharCode(((c >> 6) & 63) | 128);
			utftext += String.fromCharCode((c & 63) | 128);
		}
	}
	return escape(utftext);
}

PHPLiveX.prototype.utf8_decode = function(utftext){
	if(typeof(utftext) != "string") return escape(utftext);
	utftext = unescape(utftext);
	var string = "";
	var i = 0;
	var c = c1 = c2 = 0;
	while ( i < utftext.length ){
		c = utftext.charCodeAt(i);
		if (c < 128){
			string += String.fromCharCode(c);
			i++;
		}else if((c > 191) && (c < 224)){
			c2 = utftext.charCodeAt(i+1);
			string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
			i += 2;
		}else{
			c2 = utftext.charCodeAt(i+1);
			c3 = utftext.charCodeAt(i+2);
			string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
			i += 3;
		}
	}
	return string;
}

PHPLiveX.prototype.RandomString = function(){
	var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var code = "";
	for (i=0; i<6; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		code += chars.substring(rnum, rnum + 1);
	}
	return code;
}

PHPLiveX.prototype.ValidateParams = function(user_options){
	var errors = [];
	var err_exist = false;
	for(param in user_options){
		if(this.Options[param] == undefined && typeof(this.Options[param]) != "object"){
			errors.push("* Undefined parameter: " + param);
			continue;
		}
		
		value = user_options[param];
		if(this.Validations[param].formats != undefined){
			for(key in this.Validations[param].formats){
				if(this.Validations[param].formats[key] != typeof(value)) err_exist = true;
				else{ 
					err_exist = false;
					break;
				}
			}
			if(err_exist) errors.push("* Invalid data type for '" + param + "' parameter: " + typeof(value));
		}else if(this.Validations[param].values != undefined){
			for(key in this.Validations[param].values){
				if(typeof(value) == "string") value = value.toLowerCase();
				if(this.Validations[param].values[key] != value) err_exist = true;
				else{
					err_exist = false;
					break;
				}
			}
			if(err_exist) errors.push("* Undefined value for '" + param + "' parameter: " + value);
		}
		
		this.Options[param] = value;
	}
	if(errors.length > 0){
		var warning = errors.join("\r\n");
		alert(warning);
	}
}

PHPLiveX.prototype.CreatePreloading = function(){
	if(this.Options.preloader != null){
		if(this.Options.preloader_style == "display") this.Options.preloader.style.display = "";
		this.Options.preloader.style.visibility = "visible";
	}
	if(this.Options.clear_content) eval("this.Options.target." + this.Options.target_attr + " = '';");
}

PHPLiveX.prototype.CompletePreloading = function(){
	if(this.Options.preloader != null){
		if(this.Options.preloader_style == "display") this.Options.preloader.style.display = "none";
		this.Options.preloader.style.visibility = "hidden";
	}
}

PHPLiveX.prototype.ExternalRequest = function(options){
	newargs = new Array();
	if(options.params){
		for(pairKey in options.params){
			value = options.params[pairKey];
			if(typeof(value) == "object"){
				if(value.length != undefined) value = this.ParseArray(value);
				else value = this.ParseObject(value);
			}
			newargs.push(pairKey + "~=~" + value);
		}
	}
	newargs.push(options);
	return this.Callback(0, newargs);
}

PHPLiveX.prototype.SubmitForm = function(form, options){
	if(typeof(form) == "string"){
          form = document.getElementById(form) || document.forms[form];
	}
	if(options == null) options = {};
	
	if(!options.url && form.action != "") options.url = form.action;
	else if(!options.url && form.action == ""){
		alert("Please define an action for form");
		return false;
	}
	if(!options.method && form.method != "") options.method = form.method;
	var args = new Array();
	var fields = form.elements;
			
	for(i=0; i<fields.length; i++){
		if(fields[i].type == "button" || fields[i].type == "submit" || fields[i].type == "reset") continue;
		if((fields[i].type == "radio" || fields[i].type == "checkbox") && !fields[i].checked) continue;
		args.push(fields[i].name + "~=~" + fields[i].value);
	}
	
	if(options.params){
		for(pairKey in options.params){
			value = options.params[pairKey];
			if(typeof(value) == "object"){
				if(value.length != undefined) value = this.ParseArray(value);
				else value = this.ParseObject(value);
			}
			args.push(pairKey + "~=~" + value);
		}
	}
	args.push(options);
	this.Callback(0, args);
	return false;
}

PHPLiveX.prototype.UtilizeResponse = function(funcName, funcArgs, funcUrl){
	if(typeof(funcName) == "object") funcName = funcName.obj + "::" + funcName.method;
	var data = (funcName) ? "plxf=" + escape(funcName) : "";
	var args = new Array();

	if(funcArgs.length > 0){
		if(funcName){
			for (i=0;i<funcArgs.length;i++) data += "&plxa[]=" + this.utf8_encode(funcArgs[i]);
		}else{
			for (i=0;i<funcArgs.length;i++){
				key = this.utf8_encode(funcArgs[i].split("~=~")[0]);
				val = this.utf8_encode(funcArgs[i].split("~=~")[1]);
				data += "&" + key + "=" + val;
			}
			data = data.substring(1);
		}
	}
	var _root = this;

	var XmlHttp = this.GetXmlHttp();
	var asynchronous = (this.Options.type == "asynchronous") ? true : false;

	if(this.Options.method.toUpperCase() == "GET"){
		data += "&RequestId=" + new Date().getTime();
		if(funcUrl.indexOf("?") != -1){
			data = (funcUrl.indexOf("&")) ? "&" + data : data;
			XmlHttp.open("GET", funcUrl + "&" + data, asynchronous);
		}else{
			XmlHttp.open("GET", funcUrl + "?" + data, asynchronous);
		}
	}else XmlHttp.open("POST", funcUrl, asynchronous);

	if(this.Options.method.toUpperCase() == "POST"){
		XmlHttp.setRequestHeader("Method", "POST " + funcUrl + " HTTP/1.1");
		XmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		XmlHttp.setRequestHeader("Accept", "text/javascript, text/html, application/xml, text/xml, */*");
	}
	for(key in this.Options.headers) XmlHttp.setRequestHeader(key, this.Options.headers[key]);

	if(asynchronous){
		this.CreatePreloading();
		_root.Options.onCreate(XmlHttp);

		XmlHttp.onreadystatechange = function(){
			if(XmlHttp.readyState == 0){
				_root.Options.onUninitialized(XmlHttp);
			}else if(XmlHttp.readyState == 1){
				_root.Options.onLoading(XmlHttp);
			}else if(XmlHttp.readyState == 2){
				_root.Options.onRequest(XmlHttp);
			}else if(XmlHttp.readyState == 3){
				_root.Options.onInteraction(XmlHttp);
			}else if(XmlHttp.readyState == 4){
				_root.CompletePreloading();

				var response = XmlHttp.responseText;
						
				var jscode = "";
						
				if(response.indexOf("<phplivex>") != -1){
					var parts = response.split("<phplivex>");
					response = parts[parts.length-1].split("</phplivex>")[0];
				}

				var jsparts = response.match(/<script[^>]*>(.|\n|\t|\r)*?<\/script>/gi);
				if(jsparts){
					lng = jsparts.length;
					for(i=0;i<lng;i++){
						jscode += jsparts[i].replace(/<script[^>]*>|<\/script>/gi, "");
						response = response.replace(jsparts[i], "");
					}
				}
				
				var test_integer = /^[\+\-]?\d*$/;
				if(response != "" && test_integer.test(response)) response = parseInt(response);
				
				if(_root.Options.content_type.toUpperCase() == "JSON" && response != "") eval("response = " + response + ";");
				_root.Options.onFinish(response, XmlHttp);

				if(_root.Options.preloader != null){
					if(_root.Options.preloader_style == "visibility"){
						_root.Options.preloader.style.visibility = "hidden";
						_root.Options.preloader.style.display = "";
					}
					if(_root.Options.preloader_tyle == "display"){
						_root.Options.preloader.style.display = "none";
						_root.Options.preloader.style.visibility = "visible";
					}
				}
				
				if(_root.Options.target != null){
					var attr = _root.Options.target_attr;
					var item = _root.Options.target;
					
					if(item.type == "select-one" && attr == "options"){
						if(_root.Options.mode == "rw"){
							lng = item.options.length;
							for(k=0; k<lng; k++) item.remove(0);
						}
						
						for(var i=0; i<response.length; i++){
							option = response[i];
							var opt = document.createElement("option");
							for(key in option){
								val = option[key];
								eval("opt." + key + " = val;");
							}
							
							if(_root.Options.mode == "aw" || _root.Options.mode == "rw"){
								if(_root.Browser == "ie") item.add(opt); else item.add(opt, null);
							}else if(_root.Options.mode == "asw"){
								if(_root.Browser == "ie") item.add(opt, 0); else item.add(opt, item.options[0]);
							}
							
						}
					}else{
						switch(_root.Options.mode){
							case "aw": eval("item." + attr + " += response;"); break;
							case "rw": eval("item." + attr + " = response;"); break;
							case "asw": eval("item." + attr + " = response + item." + attr + ";"); break;
						}
					}
				}

				if(jscode != "" && _root.Options.eval_scripts){
					var script = document.createElement("script");
					script.type = "text/javascript";
					script.lang = "javascript";
					script.text = jscode;
					document.getElementsByTagName("head")[0].appendChild(script);
				}
	
				_root.Options.onUpdate(response, XmlHttp);
			}
		}

		if(this.Options.method.toUpperCase() == "GET") XmlHttp.send(null);
		else XmlHttp.send(data);
	}else{
		if(this.Options.method.toUpperCase() == "GET") XmlHttp.send(null);
		else XmlHttp.send(data);

		var response = XmlHttp.responseText;
		if(response.indexOf("<phplivex>") != -1){
			var parts = response.split("<phplivex>");
			response = parts[parts.length-1].split("</phplivex>")[0];
		}

		var jscode = "";
		var parts = response.match(/<script[^>]*>(.|\n|\t|\r)*?<\/script>/gi);
		if(parts){
			for(i=0;i<parts.length;i++){
				jscode += parts[i].replace(/<script[^>]*>|<\/script>/gi, "");
				response = response.replace(parts[i], "");
			}
		}
		if(jscode != "" && _root.Options.eval_scripts){
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.lang = "javascript";
			script.text = jscode;
			document.getElementsByTagName("head")[0].appendChild(script);
		}
		
		var test_integer = /^[\+\-]?\d*$/;
		if(response != "" && test_integer.test(response)) response = parseInt(response);
		
		if(_root.Options.content_type.toUpperCase() == "JSON" && response != "") eval("response = " + response + ";");
		return response;
	}
}

PHPLiveX.prototype.Callback = function(funcName, funcArgs, isRepeat){
	var args = [];
	for(i=0;i<funcArgs.length-1;i++){
		args.push(funcArgs[i]);
		
		if(typeof(args[i]) == "object") args[i] = "<plxobj>" + this.ParseObject(args[i]) + "</plxobj>";
		else if(typeof(args[i]) == "boolean"){
			if(args[i] == false) args[i] = 0;
			else args[i] = 1;
		}
	
		if(String(args[i]).indexOf("+")) args[i] = String(args[i]).replace("+", encodeURIComponent("+"), "g");
	}
	var params = funcArgs[funcArgs.length-1];
	this.ValidateParams(params);
	
	if(this.Options.target != null){
		targetId = String(this.Options.target);
		if(document.getElementById(targetId)) this.Options.target = document.getElementById(targetId);
		if(this.Options.target_attr == "innerContent"){
			if(this.Options.target.type == "select-one") this.Options.target_attr = "options";
			else if(this.Options.target == "[object HTMLInputElement]" || this.Options.target.type != undefined) this.Options.target_attr = "value";
			else this.Options.target_attr = "innerHTML";
		}
	}
	if(this.Options.preloader != null){
		preloaderId = String(this.Options.preloader);
		if(document.getElementById(preloaderId)) this.Options.preloader = document.getElementById(preloaderId);
	}
			
	if(this.Options.url == "") this.Options.url = window.location.href;

	try{
		if(this.Options.type == "synchronous"){
			return this.UtilizeResponse(funcName, args, this.Options.url);
		}else if(this.Options.type == "asynchronous"){
			this.UtilizeResponse(funcName, args, this.Options.url);
		}
	}catch(ex){
		this.Options.onFailure(ex);
		return;
	}

	if(this.Options.interval != 0){
		var initialArgs = [];
		lng = funcArgs.length;
		for(i=0; i<lng; i++){
			if(typeof(funcArgs[i]) == "object") initialArgs.push(this.ParseObject(funcArgs[i]));
			else initialArgs.push("'" + funcArgs[i] + "'");
		}
		if(funcName){
			if(typeof(funcName) == "string") PLX_Timeouts.push(setTimeout("eval(" + funcName + "(" + initialArgs.join(", ") + "));", this.Options.interval));
			else if(typeof(funcName) == "object") PLX_Timeouts.push(setTimeout("eval(" + funcName.obj + "." + funcName.method + "(" + initialArgs.join(", ") + "));", this.Options.interval));
		}else{
			if(!isRepeat){
				code = this.RandomString();
				eval("PLX_Repeats." + code + " = funcArgs;");
			}
			PLX_Timeouts.push(setTimeout("new PHPLiveX().Callback(0, PLX_Repeats['" + code + "'], true);", this.Options.interval));
		}
	}
	return;
}

var PLX_Timeouts = [];
var PLX_Repeats = {};