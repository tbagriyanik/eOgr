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
bitirmeYuzdesi:
ders çalýþmada ilerleme çubuðunun deðerinin bulunmasý
*/
function bitirmeYuzdesi(){
	return parseInt(document.getElementById('sonSayfaHidden').value) * 100 / parseInt(document.getElementById('sayfaSayisi').innerHTML);
}
/*
sureDolduTemizle:
genel olarak ders sayfasýndaki bölümlerin temizlenmesi
*/
function sureDolduTemizle(){
		$("#calismaSuresi").stopTime();
		$("#cevapSuresi").stopTime();
		window.clearTimeout(timeoutId);
				
        document.getElementById('anaMetin').innerHTML =   "<font id='hata'>Özür dileriz, s&uuml;reniz dolmuþ veya sayfa geç yükleniyor olabilir.<p>Sayfayý <a href='lessons.php?konu="+document.getElementById('konu_id').value+"'>yenilemeyi</a> deneyiniz veya <a href='index.php'>oturum</a> açýnýz.</p></font>";          
		document.getElementById('eklenmeTarihi').innerHTML =  "-";		
		document.getElementById('hazirlayan').innerHTML =   "-";
		document.getElementById('sayfaSayisi').innerHTML =  "-";		
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('soruGeriSayim').innerHTML =   "";		
		document.getElementById('sonrakiKonu').innerHTML =   "";		
		document.getElementById('oncekiKonu').innerHTML =  "";		
		document.getElementById('cevapSuresi').innerHTML = '' ;
		document.getElementById('gercekCevapSuresi').innerHTML =   "";		
		document.getElementById('slideGecisSuresi').innerHTML =   "";		
		document.getElementById('sayfaNo').innerHTML =  "-";
		document.getElementById('calismaSuresi').innerHTML =  "-";
		document.getElementById('bitirmeYuzdesi').innerHTML =  "";
		document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
		document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('konu_id').value =   "";
		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		document.getElementById('sunuDurdur').style.visibility = 'hidden';
		document.getElementById('yukleniyor').style.visibility = "hidden";
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
}

var timeoutId = null;
var connectionTimeout = 60000; // 60sec 
var items = new Array(); 		//ders sayfalarý bilgileri

//http://www.netlobo.com/url_query_string_javascript.html
function gup( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}
/*
setOutputOda:
içi boþ fonksiyon
*/
function setOutputOda(){
}
/*
setOutputKonu:
konudaki bilgilerin ekrana getirilmesi
*/
function setOutputKonu(sayfaNo, konu, noCount){

	if(noCount === undefined) noCount=0;

    if(httpObject.readyState != 4){
		//yukleniyor
		document.getElementById('yukleniyor').style.visibility = "visible";			
		window.clearTimeout(timeoutId);
		timeoutId = window.setTimeout(function() { 
										httpObject.onreadystatechange = function(){};
                                        httpObject.abort();          
										sureDolduTemizle();							                                        //alert("Connection timeout!\nBaðlantý zaman aþýmý!"); 
                                    }, connectionTimeout);		
		//dolaþamasýn diye			
	};
	
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){	
		window.clearTimeout(timeoutId);
		document.getElementById('yukleniyor').style.visibility = "hidden";
		
        var response = httpObject.responseText;
		
		//alert("3- setOutpuKonu " + sayfaNo + " " + items.length);
		
		if(items.length!=15 || items=="1"){//bazen sadece 1 geliyor...
			//return; //exit function
		}

		var birSayi, kayitSayisi, yuzdesi;
		var eskiYeri;		

		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		document.getElementById('ileriGeri').style.visibility = 'visible' ;
		document.getElementById('cevapSuresi').style.visibility = 'hidden' ;
		document.getElementById('sunuDurdur').style.visibility = 'hidden';
		
        document.getElementById('anaMetin').innerHTML =   items[0];                 
		document.getElementById('anaMetin').tabindex = -1;
		document.getElementById('anaMetin').focus();
		//eriþilebilirlik
		
		document.getElementById('aktifKonuNo').innerHTML =   items[12];          		
		document.getElementById('gercekCevapSuresi').innerHTML =   items[13];          
		document.getElementById('slideGecisSuresi').innerHTML =   items[14];          
		
		document.getElementById('eklenmeTarihi').innerHTML =  items[1];		
		document.getElementById('hazirlayan').innerHTML =   items[2];
		document.getElementById('sayfaSayisi').innerHTML =  items[3];		
		kayitSayisi = items[3];
		document.getElementById('konuAdi').innerHTML =   items[5];

		if(items[7]=="-" || items[6]=="-" || items[7]=="" || items[6]=="0")
			document.getElementById('oncekiKonu').innerHTML =   "";		
			else
			document.getElementById('oncekiKonu').innerHTML =   "<img src=\"img/page-prev.gif\" border=\"0\" style=\"vertical-align:middle\" alt=\"prev\"/> <a href='lessons.php?konu="+ items[6] +"&amp;mode="+gup("mode")+"'>" + items[7] + "</a>";		
		if(items[8]=="-" || items[9]=="-" || items[8]=="" || items[9]=="")
			document.getElementById('sonrakiKonu').innerHTML =   "";		
			else
			document.getElementById('sonrakiKonu').innerHTML =   "<a href='lessons.php?konu="+ items[8] +"&amp;mode="+gup("mode")+"'>" + items[9] + "</a>  <img src=\"img/page-next.gif\" border=\"0\" style=\"vertical-align:middle\" alt=\"next\"/>";		

		document.getElementById('konu_id').value = konu;		
		
		if (noCount==0){
			document.getElementById('calismaSuresi').innerHTML =  "-";
			$("#calismaSuresi").stopTime();
			if(items[3]>0) sayacTetik();
		}

			if(items[10]>0) {sayacTetik2(items[10]);}
			
			if(items[11]>0 && items[11]!="-") {//Soru varsa	
				document.getElementById('sayfa_id').value = items[11];
				document.getElementById('cevapLink').href = "soruCevapla.php?sayfa="+items[11];
				document.getElementById('cevapVer').style.visibility = 'visible' ;
				document.getElementById('ileriGeri').style.visibility = 'hidden' ;
				document.getElementById('cevapSuresi').style.visibility = 'visible' ;
				if (document.getElementById("cevapVer")!=null) fadeUp(document.getElementById("cevapVer"),255,255,0,0,0,150);
				document.getElementById('cevapSuresi').innerHTML = '' ;
				$("#cevapSuresi").stopTime();//önceki timer kapanýr			
				}				
			else if(items[14]>0 && items[14]!="-") {//Slayt varsa	
				document.getElementById('sayfa_id').value = items[11];
				document.getElementById('cevapSuresi').style.visibility = 'visible' ;
				document.getElementById('cevapSuresi').innerHTML = items[14];
				if (document.getElementById("cevapSuresi")!=null) fadeUp(document.getElementById("cevapSuresi"),0,255,0,0,0,150);
				$("#cevapSuresi").stopTime();//önceki timer kapanýr	
				sayacTetik3(items[14]);	
				document.getElementById('sunuDurdur').style.visibility = 'visible';	
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
				//konu seçili ise hint gösterilebilir!
					var timeoutHint = null;
					var valTimeout = 10; 
					var timeoutHint2 = null;
					var valTimeout2 = 9000; 
					
				if(document.getElementById('ileriGeri').style.visibility == 'visible' 
				    && sayfaNo==1 && eskiYeri<1){
					
					window.clearTimeout(timeoutHint);
					window.clearTimeout(timeoutHint2);
					
					timeoutHint = window.setTimeout(function() {
						$('#hint').fadeIn(500,null);	 
						document.getElementById("hint").style.display = "inline";	
						 }, valTimeout);
					timeoutHint2 = window.setTimeout(function() { 
						//document.getElementById("hint").style.display = "none";	
						$('#hint').fadeOut(750,null);	 
						 }, valTimeout2);
				}else{
					window.clearTimeout(timeoutHint);
					window.clearTimeout(timeoutHint2);
					$('#hint').fadeOut(750,null);
				}

			}
		}
		else {
			document.getElementById('sayfaNo').innerHTML =  '-';
			document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
			document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';
		    document.getElementById('bitirmeYuzdesi').innerHTML =  "";
//			document.getElementById('sonSayfaHidden').value=0;

		}
		fix_flash();
		document.getElementById('yukleniyor').style.visibility = "hidden";	
		
    }
}
/*
sayacTetik:
sayfadaki çalýþma süresinin çalýþmasý
*/
function sayacTetik()  {
					$("#calismaSuresi").everyTime(1000,function(i) {
						$(this).html(i);
						loginDurumu();
					});
};
/*
sayacTetik2:
cevap verme süresinin çalýþmasý
*/ 
function sayacTetik2(sure)  {
					$("#soruGeriSayim").oneTime((sure*60) + "s",function() {																		
						$("#calismaSuresi").stopTime();
						saveUserWork();//even if less then ignored limited time !!
						sureDolduTemizle();
					});
};
/*
sayacTetik3:
slayt geçiþ süresinin çalýþmasý
*/ 
function sayacTetik3(sure)  {
	if(!document.sunum.sunuDurdur.checked)	
					$("#cevapSuresi").everyTime(1000,function(i) {
						$(this).html(sure-i);
						if(i==sure) {//slayt süresi bitti ise sonraki sayfaya geç
						  $("#cevapSuresi").stopTime();
						  sayfa = document.getElementById('sayfaNo').innerHTML;
						  sonsayfa = document.getElementById('sayfaSayisi').innerHTML;
						  if(sayfa==sonsayfa)  
						    sayfa=1;
							else
 						    sayfa++;
						  konuSec2(sayfa,1);//1 normal zamaný etkilememesi içindir						 						
						}
					});
};
/*
konuSec2:
alt seçeneklerin veritabanýndan istenmesi
*/
function konuSec2(sayfaNo, noCount){    

	$('#hint').fadeOut(750,null);
	
	if(noCount === undefined) noCount=0;	
	if(sayfaNo == "" || parseInt(sayfaNo)==0) {
		 return;
	}
				
	if(httpObject!=null) {//önceki istek bitmeli
		httpObject.onreadystatechange = function(){};
		httpObject.abort;
	}
	
	delete httpObject;
	httpObject = getHTTPObject();
	
    if (httpObject != null && sayfaNo != "") {
		/*document.getElementById('geriDugmesi').innerHTML  ='<img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/>';
		document.getElementById('ileriDugmesi').innerHTML ='<img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/>';	*/
        httpObject.open("POST", "getSubOption.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('sayfaNo=' + sayfaNo);
        httpObject.onreadystatechange = function() {
			 if(httpObject.readyState == 4)
				 if(httpObject.status == 200 || httpObject.status == 304){			

					if(httpObject.responseText==""){
						document.getElementById('anaMetin').innerHTML =   "<font id='hata'>Sayfa yüklenemedi!<p>Baþka bir ders <a href='lessons.php'>seçiniz</a>.</p></font>";
						return;
					}
					
					var response = httpObject.responseText;
					//alert(response);
					items = response.split("|");
					
					document.getElementById("kapsayici").scrollTop = 0;
					setOutputKonu(sayfaNo, document.getElementById('konu_id').value, noCount);
				 }
		}
		
		if (document.getElementById("navigation")!=null) fadeUp(document.getElementById("navigation"),255,255,154,255,255,150);
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
		if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
		if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
    }
}
/*
konuHazirla:
sayfa ilk açýldýðýnda ders içeriðini alma
*/
function konuHazirla(konuNo){    
    httpObject2 = getHTTPObject();
    if (httpObject2 != null && konuNo>0) {
        httpObject2.open("POST", "getContent.php", true);
		httpObject2.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject2.send('konu='+encodeURIComponent(konuNo));
        httpObject2.onreadystatechange = function(){
			if(httpObject2.readyState == 4 && (httpObject2.status == 200 || httpObject2.status == 304)){

				if(httpObject2.responseText=="OK")					
					konuSec2(1); //içerik geldi ve 1. sayfa seçilir	
				 else
				    document.getElementById('anaMetin').innerHTML =   "<font id='hata'>Sayfalar yüklenemedi!<p>Baþka bir ders <a href='lessons.php'>seçiniz</a>.</p></font>";	
					
				}else{
					document.getElementById('anaMetin').innerHTML =   "<font id='uyari'>Sayfalar yükleniyor!<p>Sayfayý <a href='lessons.php?konu="+document.getElementById('konu_id').value+"'>yenileyebilirsiniz</a>.</p></font>";
					}			
		};		
    }
}
/*
saveUserWork:
ders bittiðinde kullanýcýya ders bilgisinin kaydedilmesi
*/
function saveUserWork(){ 
    httpObject3 = getHTTPObject();
    if (httpObject3 != null) {
        httpObject3.onreadystatechange = setOutputOda;		
        httpObject3.open("GET", "setUserWork.php?"+'konuID='+encodeURIComponent(document.getElementById('konu_id').value)+'&sure='+encodeURIComponent(document.getElementById('calismaSuresi').innerHTML)+'&sonSayfa='+encodeURIComponent(bitirmeYuzdesi()), false);
  		httpObject3.send(null);		
    }
}
/*
yorumGonder:
derse kullanýcýnýn yorum eklemesi
*/
function yorumGonder(konuID, comment){    
    httpObject4 = getHTTPObject();
    if (httpObject4 != null) {
        httpObject4.open("POST", "addComment2.php", true);
		httpObject4.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject4.send('yorum='+encodeURIComponent(comment) + '&konu=' + encodeURIComponent(konuID));
        httpObject4.onreadystatechange = setOutputOda;		
    }
}
/*
setCevapSonuc:
soruya cevap verilmesi
*/
function setCevapSonuc(){
    if(httpObjectCevap.readyState == 4)
	 if(httpObjectCevap.status == 200 || httpObjectCevap.status == 304){
		document.getElementById('cevapSonucu').innerHTML = (httpObjectCevap.responseText);
		//gelen bilgide tick_circle yazýsý kontrol ediliyor
		if(httpObjectCevap.responseText.indexOf("tick_circle")>0){	
 		 document.getElementById('ileriGeri').style.visibility = 'visible' ;
		 document.getElementById('cevapVer').style.visibility = "hidden";	
 		 document.getElementById('cevapDegerlendirmeYeri').style.visibility = "hidden";	
		 document.getElementById('cevapSuresi').innerHTML = '' ;
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),0,255,0,0,150,0);
		 $("#cevapSuresi").stopTime();//önceki timer kapanýr			
		}else{
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),255,0,0,150,0,0);
		}		 
    }
} 
/*
cevapDegerlendir:
gelen cevap deðerinin veritabanýndan karþýlaþtýrýlmasý
*/
function cevapDegerlendir(cevap, id){    
    httpObjectCevap = getHTTPObject();
    if (httpObjectCevap != null) {
        httpObjectCevap.open("POST", "soruCevapla2.php", true);
		httpObjectCevap.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObjectCevap.send('cevap='+encodeURIComponent(cevap) + '&id=' + encodeURIComponent(id));
        httpObjectCevap.onreadystatechange = setCevapSonuc;		
    }
}
/*
cevapDegerlendir2:
gelen cevap deðerinin veritabanýndan karþýlaþtýrýlmasý, MULTIPLE CHOICE
*/
function cevapDegerlendir2(cevap, id){    
    httpObjectCevap = getHTTPObject();
    if (httpObjectCevap != null) {
        httpObjectCevap.open("POST", "soruCevapla3.php", true);
		httpObjectCevap.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObjectCevap.send('cevap='+encodeURIComponent(cevap) + '&id=' + encodeURIComponent(id));
        httpObjectCevap.onreadystatechange = setCevapSonuc;		
    }
}
/*
durumGuncelle:
sayfa durumunun güncellenmesi
*/
function durumGuncelle(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		if(httpObject.responseText=="0") {
			sureDolduTemizle();							  							
		  }
	}
}
/*
loginDurumu:
kayýtlý kullanýcýlar için oturum açýk olduðunun kontrol edilmesi
*/
function loginDurumu(){	
    httpObject7 = getHTTPObject();
    if (httpObject7 != null) {
		konu = document.getElementById('konu_id').value;
        httpObject7.open("GET", "getDurum.php?konu="+encodeURIComponent(konu), true);
  		httpObject7.send(null);	
        httpObject7.onreadystatechange = durumGuncelle;		
    }
}

var httpObject = null;