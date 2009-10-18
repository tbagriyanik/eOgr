function Hijax() {

 var container,url,canvas,data,loading,callback,request;

 this.setContainer = function(value) {
  container = value;
 };
 this.setUrl = function(value) {
  url = value;
 };
 this.setCanvas = function(value) {
  canvas = value;
 };
 this.setLoading = function(value) {
  loading = value;
 };
 this.setCallback = function(value) {
  callback = value;
 };

 this.captureData = function() {
  if (container.nodeName.toLowerCase() == "form") {
   container.onsubmit = function() {
    var query = "";
    for (var i=0; i<this.elements.length; i++) {
     query+= this.elements[i].name;
     query+= "=";
     query+= escape(this.elements[i].value);
     query+= "&";
    }
    data = query;
    return !start();
   };
  } else {
   var links = container.getElementsByTagName("a");
   for (var i=0; i<links.length; i++) {
    links[i].onclick = function() {
     var query = this.getAttribute("href").split("?")[1];
     url+= "?"+query;
     return !start();
    };
   }
   links = null;
  }
 };

 var start = function() {
  request = getHTTPObject();
  if (!request || !url) {
   return false;
  } else {
   initiateRequest();
   return true;
  }
 };

 var getHTTPObject = function() {
  var xmlhttp = false;
  if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
  } else if(window.ActiveXObject) {
   try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
   } catch (e) {
    try {
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
     xmlhttp = false;
    }
   }
  }
  return xmlhttp;
 };

 var initiateRequest = function() {
  if (loading) {
   loading();
  }
  request.onreadystatechange = completeRequest;
  if (data) {
   request.open("POST", url, true);
   request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   request.send(data);
  } else {
   request.open("GET", url, true);
   request.send(null);
  }
 };

 var completeRequest = function() {
  if (request.readyState == 4) {
   if (request.status == 200 || request.status == 304) {
    if (canvas) {
     canvas.innerHTML = request.responseText;
    }
    if (callback) {
     callback();
    }
   }
  }
 };

}

function rateIt() {

 var prepareRating = function(element) {
  var xhr = new Hijax();
  xhr.setContainer(element);
  xhr.setUrl("rating.php");
  xhr.setCanvas(element);
  xhr.setLoading(function() {
   displayLoading(element);
  });
  xhr.setCallback(function() {
   fadeUp(element,255,255,204);
   prepareRating(element);
  });
  xhr.captureData();
 };

 var displayLoading = function(element) {
  var image = document.createElement("img");
  image.setAttribute("alt","loading...");
  image.setAttribute("src","img/loadingRect2.gif");
  image.className = "loading";
  element.appendChild(image);
 };

 var fadeUp = function(element,red,green,blue) {
  if (element.fade) {
   clearTimeout(element.fade);
  }
  element.style.backgroundColor = "rgb("+red+","+green+","+blue+")";
  if (red == 255 && green == 255 && blue == 255) {
   return;
  }
  var newred = red + Math.ceil((255 - red)/10);
  var newgreen = green + Math.ceil((255 - green)/10);
  var newblue = blue + Math.ceil((255 - blue)/10);
  var repeat = function() {
   fadeUp(element,newred,newgreen,newblue)
  };
  element.fade = setTimeout(repeat,100);
 };

 var all_divs = document.getElementsByTagName("div");
 for (var i=0; i<all_divs.length; i++) {
  if (all_divs[i].className.match("rating")) {
   prepareRating(all_divs[i]);
  }
 }
 all_divs = null;

}

window.onload = rateIt;