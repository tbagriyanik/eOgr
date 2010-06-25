// Get the HTTP Object
function getHTTPObject(){
   if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
   else if (window.XMLHttpRequest)  {
	   http_request = new XMLHttpRequest();
	    if (http_request.overrideMimeType) {
            http_request.overrideMimeType('text/xml; charset=iso-8859-9');
         }
		return  http_request;
   }
   else {
      alert("Your browser does not support AJAX.");
      return null;
   }		 
} 

function bitirmeYuzdesi(){
	return parseInt(document.getElementById('sonSayfaHidden').value) * 100 / parseInt(document.getElementById('sayfaSayisi').innerHTML);
}
 
function sureDolduTemizle(){
        document.getElementById('anaMetin').innerHTML =   "<font id='hata'>S&uuml;reniz Doldu...</font>";          
		document.getElementById('eklenmeTarihi').innerHTML =  "-";		
		document.getElementById('hazirlayan').innerHTML =   "-";
		document.getElementById('sayfaSayisi').innerHTML =  "-";		
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('sonrakiKonu').innerHTML =   "";		
		document.getElementById('oncekiKonu').innerHTML =  "";		
		document.getElementById('sayfaNo').innerHTML =  "-";
		document.getElementById('bitirmeYuzdesi').innerHTML =  "";
		document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
		document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('konu_id').value =   "";
		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
}
 
function setOutputKonu(sayfaNo, konu, noCount){
	
	if(noCount === undefined) noCount=0;
	
    if(httpObject.readyState == 1){
		//yukleniyor
		document.getElementById('yukleniyor').style.visibility = "visible";	
			
	}else
    if(httpObject.readyState == 4 && httpObject.status == 200){
        var response = httpObject.responseText;
        var items = response.split("|");
		var birSayi, kayitSayisi, yuzdesi;
		var eskiYeri;

		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		document.getElementById('ileriGeri').style.visibility = 'visible' ;
		document.getElementById('cevapSuresi').style.visibility = 'hidden' ;
		
        document.getElementById('anaMetin').innerHTML =   items[0];          
		document.getElementById('eklenmeTarihi').innerHTML =  items[1];		
		document.getElementById('hazirlayan').innerHTML =   items[2];
		document.getElementById('sayfaSayisi').innerHTML =  items[3];		
		kayitSayisi = items[3];
		document.getElementById('konuAdi').innerHTML =   items[5];

		if(items[7]=="-" || items[6]=="-" || items[7]=="" || items[6]=="0")
			document.getElementById('oncekiKonu').innerHTML =   "";		
			else
			document.getElementById('oncekiKonu').innerHTML =   "<img src=\"img/page-prev.gif\" border=\"0\" style=\"vertical-align:middle\" alt=\"prev\"/> <a href='lessons.php?konu="+ items[6] +"'>" + items[7] + "</a>";		
		if(items[8]=="-" || items[9]=="-" || items[8]=="" || items[9]=="")
			document.getElementById('sonrakiKonu').innerHTML =   "";		
			else
			document.getElementById('sonrakiKonu').innerHTML =   "<a href='lessons.php?konu="+ items[8] +"'>" + items[9] + "</a>  <img src=\"img/page-next.gif\" border=\"0\" style=\"vertical-align:middle\" alt=\"next\"/>";		

		document.getElementById('konu_id').value = konu;		
		
		if (noCount==0){
			document.getElementById('calismaSuresi').innerHTML =  "-";
			$("#calismaSuresi").stopTime();
			if(items[3]>0) sayacTetik();
		}

			if(items[10]>0) {sayacTetik2(items[10]);}
			
			if(items[11]>0 && items[11]!="-") {	
				document.getElementById('sayfa_id').value = items[11];
				document.getElementById('cevapLink').href = "soruCevapla.php?sayfa="+items[11];
				document.getElementById('cevapVer').style.visibility = 'visible' ;
				document.getElementById('ileriGeri').style.visibility = 'hidden' ;
				document.getElementById('cevapSuresi').style.visibility = 'visible' ;
				if (document.getElementById("cevapVer")!=null) fadeUp(document.getElementById("cevapVer"),255,255,0,0,0,150);
				document.getElementById('cevapSuresi').innerHTML = '' ;
				$("#cevapSuresi").stopTime();//�nceki timer kapan�r			
				}
		
		document.getElementById('sayfaNo').innerHTML =  sayfaNo;
		document.getElementById('bitirmeYuzdesi').innerHTML =  "";
		
		eskiYeri = document.getElementById('sonSayfaHidden').value;		
		
		if (sayfaNo<eskiYeri) {
		  	yuzdesi = eskiYeri*100/kayitSayisi;
			}
		  else{
			yuzdesi = sayfaNo*100/kayitSayisi;
		  	document.getElementById('sonSayfaHidden').value=sayfaNo;
		  }
		
		if(yuzdesi == Number.NaN) 
		    document.getElementById('bitirmeYuzdesi').innerHTML =  "";
			else
			document.getElementById('bitirmeYuzdesi').innerHTML =  "<img src='img/progressbar.png' alt='progress' width='" + Math.round(yuzdesi) + "' height='5' border='0' title='%"+ Math.round(yuzdesi) +" ilerlediniz'/>";
		
		if (kayitSayisi>0) {
			if (sayfaNo<=1) {
				document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
			}else {
				birSayi = sayfaNo - 1;
				document.getElementById('geriDugmesi').innerHTML  ='<a href="#" onclick="konuSec2('+birSayi+',1);return false;"><img src="img/2leftarrow.png" border="0" style="vertical-align:middle" alt="left"/></a>';
			}
			if (sayfaNo>=kayitSayisi) 	{
				document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';
			}else {
				birSayi = sayfaNo + 1;
				document.getElementById('ileriDugmesi').innerHTML ='<a href="#" onclick="konuSec2('+birSayi+',1);return false;"><img src="img/2rightarrow.png" border="0" style="vertical-align:middle" alt="right"/></a>';
			}
		}
		else {
			document.getElementById('sayfaNo').innerHTML =  '-';
			document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
			document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';
		    document.getElementById('bitirmeYuzdesi').innerHTML =  "";
//			document.getElementById('sonSayfaHidden').value=0;

		}
		
		document.getElementById('yukleniyor').style.visibility = "hidden";	
		
    }
}

function sayacTetik()  {
					$("#calismaSuresi").everyTime(1000,function(i) {
						$(this).html(i);
					});
};
 
function sayacTetik2(sure)  {
					$("#soruGeriSayim").oneTime((sure*60) + "s",function() {																		
						$("#calismaSuresi").stopTime();
						saveUserWork();//even if less then ignored limited time !!
						sureDolduTemizle();
					});
};


function konuSec2(sayfaNo, noCount){    
	
	if(noCount === undefined) noCount=0;
	
    httpObject = getHTTPObject();
    if (httpObject != null && sayfaNo != "") {
        httpObject.onreadystatechange = function() {
			document.getElementById("kapsayici").scrollTop = 0;
			setOutputKonu(sayfaNo, document.getElementById('konu_id').value, noCount);
		}
        httpObject.open("POST", "getSubOption.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('tur=3&sayfaNo=' + sayfaNo + '&secilen='+encodeURIComponent(document.getElementById('konu_id').value));
		if (document.getElementById("navigation")!=null) fadeUp(document.getElementById("navigation"),255,255,154,255,255,150);
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
		if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
		if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
    }
}
 
function setOutputOda(){
    if(httpObject.readyState == 4){
		//alert(httpObject.responseText);
    }
}
 
function odaSec(){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "setOda.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('oda='+encodeURIComponent(document.getElementById('oda').value));
        httpObject.onreadystatechange = setOutputOda;		
    }
}

function saveUserWork(){ 
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.onreadystatechange = setOutputOda;		
        httpObject.open("GET", "setUserWork.php?"+'konuID='+encodeURIComponent(document.getElementById('konu_id').value)+'&sure='+encodeURIComponent(document.getElementById('calismaSuresi').innerHTML)+'&sonSayfa='+encodeURIComponent(bitirmeYuzdesi()), false);
  		httpObject.send(null);		
    }
}

function setOutputAll(){	
    if(httpObject.readyState == 4){
		if(httpObject.responseText!="") {			
			w=window.open('about:blank','onizleme','height=600,width=700,top=100,left=100,toolbar=no, location=no,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes');
			w.document.open();
			w.document.writeln("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-9\" />");
			w.document.write("<title>&Ouml;nizleme/Preview</title></head><body>" + httpObject.responseText);			
			w.document.writeln("</body></html>");
			w.document.close();
			}
	}
}

function printIt()		{
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.onreadystatechange = setOutputAll;
        httpObject.open("GET", "getSubOption2.php?"+'konuID='+encodeURIComponent(document.getElementById('konu_id').value), true);
  		httpObject.send(null);	
    }
}

function setYardim(){
    if(httpObject.readyState == 4){
		document.getElementById('icerisi').innerHTML = (httpObject.responseText);
    }
}
 
function yardimGoster(gelen){
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.onreadystatechange = setYardim;
        httpObject.open("GET", "getYardim.php?"+'konu='+encodeURIComponent(gelen), true);
  		httpObject.send(null);	
    }
}

function yorumGonder(konuID, comment){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "addComment2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('yorum='+encodeURIComponent(comment) + '&konu=' + encodeURIComponent(konuID));
        httpObject.onreadystatechange = setOutputOda;		
    }
}


function setCevapSonuc(){
    if(httpObject.readyState == 4){
		document.getElementById('cevapSonucu').innerHTML = (httpObject.responseText);
		if(httpObject.responseText.indexOf("tick_circle")>0){	
 		 document.getElementById('ileriGeri').style.visibility = 'visible' ;
		 document.getElementById('cevapVer').style.visibility = "hidden";	
 		 document.getElementById('cevapDegerlendirmeYeri').style.visibility = "hidden";	
		 document.getElementById('cevapSuresi').innerHTML = '' ;
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),0,255,0,0,150,0);
		 $("#cevapSuresi").stopTime();//�nceki timer kapan�r			
		}else{
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),255,0,0,150,0,0);
		}
		 
    }
} 

function cevapDegerlendir(cevap, id){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "soruCevapla2.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('cevap='+encodeURIComponent(cevap) + '&id=' + encodeURIComponent(id));
        httpObject.onreadystatechange = setCevapSonuc;		
    }
}

var httpObject = null;