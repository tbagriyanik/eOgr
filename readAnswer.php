<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Fo4undation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	ob_start();
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"readAnswer.php");	
	$seciliTema=temaBilgisi();
	
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-9'/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr</title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link href="theme/cevap.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
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
trim:
sað ve soldaki boþluklarý siler
*/
function trim(stringToTrim)
{
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
/*
setOutputOda:
sohbet odasýnýn iþlemi
*/  
function setOutputOda(){
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		 if(trim(httpObject.responseText) != "" || trim(httpObject.responseText) != "?"){
			alert(httpObject.responseText);
			location.reload();
		 }
    }
}
/*
cevapKaydet:
soruya cevap göndermek
*/
function cevapKaydet(icerik, gonderen, soruID){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "addCevap.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject.send('cevap='+encodeURIComponent(icerik) + '&gonderen=' + encodeURIComponent(gonderen) + '&soruID=' + encodeURIComponent(soruID) );	
		httpObject.onreadystatechange = setOutputOda;	
    }
}
/*
setOutputOda2:
sohbet odasýnýn iþlemi
*/  
function setOutputOda2(){
    if(httpObject2.readyState == 4)
	 if(httpObject2.status == 200 || httpObject2.status == 304){
		 if(trim(httpObject2.responseText) != "" || trim(httpObject2.responseText) != "?"){
			alert(httpObject2.responseText);
			location.reload();
		 }
    }
}
/*
cevapSil:
cevap silme
*/
function cevapSil(id, gonderen){ 
 if(confirm("Cevap silinsin mi?")==1){   
    httpObject2 = getHTTPObject();
    if (httpObject2 != null) {
        httpObject2.open("POST", "delCevap.php", true);
		httpObject2.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject2.send('cevap='+encodeURIComponent(id) + '&gonderen=' + encodeURIComponent(gonderen) );	
		httpObject2.onreadystatechange = setOutputOda2;	
    }
 }
}
/*
setOutputOda3:
sohbet odasýnýn iþlemi
*/  
function setOutputOda3(){
    if(httpObject3.readyState == 4)
	 if(httpObject3.status == 200 || httpObject3.status == 304){
		 if(trim(httpObject3.responseText) != "" || trim(httpObject3.responseText) != "?"){
			alert(httpObject3.responseText);
			location.reload();
		 }
    }
}
/*
cevapOy:
cevaba oy verilmesi
*/
function cevapOy(deger, gonderen, cevapID){ 
    httpObject3 = getHTTPObject();
    if (httpObject3 != null) {
        httpObject3.open("POST", "oyCevap.php", true);
		httpObject3.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-9');
  		httpObject3.send('deger='+encodeURIComponent(deger) + '&gonderen=' + encodeURIComponent(gonderen) + '&cevapID=' + encodeURIComponent(cevapID) );	
		httpObject3.onreadystatechange = setOutputOda3;	
    }
}
</script>
</head>
<body>
<?php
		$adi	=temizle(substr($_SESSION["usern"],0,15));
		$par	=temizle($_SESSION["userp"]);
		$tur	=checkRealUser($adi,$par);
		$gecerliKullID = getUserID2($adi);

	if ($tur=="2" or $tur=="1" or $tur=="0")	{	
	 //öðrenci, öðretmen ve yönetici girebilir
	 $gelenID = (int)RemoveXSS($_GET["oku"]);
	 if(!($gelenID>0)) die("?");
	 $srg = "select * from eo_askquestion where id=$gelenID limit 0,1";
	 $sorgu = mysql_query($srg);
	 $soru_bilgileri = mysql_fetch_array($sorgu);	
if($soru_bilgileri["question"]<>""){					
?>
<div id="kapsayici">
  <div id="soruMetni">
    <pre><?php echo $soru_bilgileri["question"]?></pre>
  </div>
  <div id="soruSoran"><?php echo getUserName($soru_bilgileri["userID"])?></div>
  <div class="temizle"></div>
  <div id="dersAdi"><?php echo getDersAdi($soru_bilgileri["dersID"])?></div>
  <div id="soruTarihi">
    <?php 
  		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($soru_bilgileri["eklenmeTarihi"]);
		echo $insansi
		?>
  </div>
  <div class="temizle"></div>
</div>
<?php
	 $soruID = $soru_bilgileri["id"];	
	 $srgCev = "select *,(
	 					select sum(eo_askanswerrate.degeri) from eo_askanswerrate
						where cevapID=eo_askanswer.id
						) as totalOy from eo_askanswer 
	 			where eo_askanswer.soruID='$soruID' 
				order by totalOy DESC, eo_askanswer.eklenmeTarihi DESC";
	 $sorguCev = mysql_query($srgCev);
	if(@mysql_num_rows($sorguCev)>0){
?>
<h4>Cevaplar</h4>
<?php 	 
	while($cevap_bilgileri = mysql_fetch_array($sorguCev)){		
?>
<div class="kapsayiciCevap">
  <div class="cevapMetni">
    <pre><?php echo $cevap_bilgileri["answer"]?></pre>
  </div>
  <div class="puanVer"><a href="#" class="evetOy" title="Doðru" 
    onclick=" cevapOy('1',<?php echo $gecerliKullID ?>,<?php echo $cevap_bilgileri["id"] ?> );
   return false;"></a> <a href="#" class="hayirOy" title="Yanlýþ" 
   onclick=" cevapOy('-1',<?php echo $gecerliKullID ?>,<?php echo $cevap_bilgileri["id"] ?> );
   return false;"></a></div>
  <div class="cevaplayan"><?php echo getUserName($cevap_bilgileri["userID"])?></div>
  <div class="temizle"></div>
  <div class="puanlama">
    <?php
	  if($tur=="2" or $cevap_bilgileri["userID"]==$gecerliKullID){	  
  ?>
    <a href="#" onclick="javascript:cevapSil(<?php echo $cevap_bilgileri["id"]?>,<?php echo $gecerliKullID?>);return false;"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a>&nbsp;
    <?php
	  }
  ?>
    <?php
		echo cevapOyToplami($cevap_bilgileri["id"]);
    ?>
  </div>
  <div class="cevapTarihi">
    <?php 
  		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($cevap_bilgileri["eklenmeTarihi"]);
		echo $insansi
		?>
  </div>
  <div class="temizle"></div>
</div>
<?php
			 }//while
		}else
		echo "<strong>Þimdilik cevap verilmemiþtir.</strong>";
?>
<div id="kapsayiciEkle">
  <form>
    <strong>Sizin Cevabýnýz</strong><br />
    <textarea id="cevabim" cols="50" rows="5" style="background-color:#FFF;border:1px solid #000;" ></textarea>
    <input type="image" width="25" alt="<?php echo $metin[121]?>" title="<?php echo $metin[121]?>" src="img/save.png" onclick=" cevapKaydet(trim(document.getElementById('cevabim').value.substr(0,250)),<?php echo $gecerliKullID ?>,<?php echo $gelenID ?> );
   //$('#kapsayiciEkle').hide('slow');
   return false;">
  </form>
</div>
<?php
}
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
