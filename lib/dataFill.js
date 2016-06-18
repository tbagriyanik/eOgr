/*
lessons.php AJAX engine is here

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
// Get the HTTP Object
/*
getHTTPObject:
Ajax nesnesinin hazýrlanmasý
*/
function getHTTPObject(){
  var xmlhttp = null;
  if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
   	    if (xmlhttp.overrideMimeType) {
            xmlhttp.overrideMimeType('text/xml; charset=utf-8');
         }
  } else if(window.ActiveXObject) {
   try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
   } catch (e) {
    try {
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
	 alert("Your browser does not support AJAX.");
     xmlhttp = null;
    }
   }
  }
  return xmlhttp;		 
} 
/*
setOutputOda:
sohbet odasýnýn iþlemi
*/ 
function setOutputOda(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		
    }
}
/*
odaSec:
sohbet odasýnýn deðiþtirilmesi
*/
function odaSec(){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "setOda.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
  		httpObject.send('oda='+encodeURIComponent(document.getElementById('oda').value));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
/*
setYardim:
yardým için diziden gerekli sekmenin bilgilerinin çaðrýlmasý
*/
function setYardim(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		document.getElementById('icerisi').innerHTML = (httpObject.responseText);
    }
}
/*
yardimGoster:
yardým için diziden gerekli sekmenin bilgilerinin çaðrýlmasý
*/ 
function yardimGoster(gelen){
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.onreadystatechange = setYardim;
        httpObject.open("GET", "getYardim.php?"+'konu='+encodeURIComponent(gelen), true);
  		httpObject.send(null);	
    }
}
/*
arkadasOnayla:
arkadaþ eklemesi
*/
function arkadasOnayla(ID){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "askForFriendship2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
  		httpObject.send('kabul=1&kisi=' + encodeURIComponent(ID));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
/*
arkadasOnaylama:
arkadaþ eklenmemesi
*/
function arkadasOnaylama(ID){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "askForFriendship2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
  		httpObject.send('kabul=0&kisi=' + encodeURIComponent(ID));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
var httpObject = null;