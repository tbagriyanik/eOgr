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
Ajax nesnesinin haz�rlanmas�
*/
function getHTTPObject(){
  var xmlhttp = null;
  if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
   	    if (xmlhttp.overrideMimeType) {
            xmlhttp.overrideMimeType('text/xml; charset=iso-8859-9');
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
sohbet odas�n�n i�lemi
*/ 
function setOutputOda(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		
    }
}
/*
odaSec:
sohbet odas�n�n de�i�tirilmesi
*/
function odaSec(){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "setOda.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('oda='+encodeURIComponent(document.getElementById('oda').value));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
/*
setYardim:
yard�m i�in diziden gerekli sekmenin bilgilerinin �a�r�lmas�
*/
function setYardim(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		document.getElementById('icerisi').innerHTML = (httpObject.responseText);
    }
}
/*
yardimGoster:
yard�m i�in diziden gerekli sekmenin bilgilerinin �a�r�lmas�
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
arkada� eklemesi
*/
function arkadasOnayla(ID){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "askForFriendship2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('kabul=1&kisi=' + encodeURIComponent(ID));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
/*
arkadasOnaylama:
arkada� eklenmemesi
*/
function arkadasOnaylama(ID){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "askForFriendship2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('kabul=0&kisi=' + encodeURIComponent(ID));
        httpObject.onreadystatechange = setOutputOda;		
    }
}
var httpObject = null;