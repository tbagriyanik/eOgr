<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net

Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
require 'lib/flood-protection.php'; // include the class
require 'database.php'; 

require("lib/HTMLCleaner.php");	//ms word html temizleme

$taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
if(!($taraDili=="TR" || $taraDili=="EN")) 
  require_once("lib/humanRelativeDate.class.php");
else if($taraDili=="TR") 
  require_once("lib/humanRelativeDate.classTR.php");
else  
  require_once("lib/humanRelativeDate.class.php");

	$protect = new flood_protection();
	$protect -> host 		= $_host;
	$protect -> password 	= $_password; 
	$protect -> username 	= $_username; 
	$protect -> db 			= $_db; 	


	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
/*
baglan: parametresiz, 
veritabanı bağlantısı
*/
function baglan()
{
	global  $_host;
	global  $_username;
	global  $_password;
	global  $_db;
	$result = @mysqli_connect($_host, $_username, $_password , $_db);
	mysqli_set_charset($result, "utf8");
    return 	$result;
}

if(!baglan()) {  
 @header("Location: error.php?error=5");
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
}

$yol 	= 	baglan();
$yol1	=	baglan();

	if (!$yol)
	{
		@header("Location: error.php?error=5");
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}else{
		mysqli_query($yol,"SET NAMES 'utf8'");
		$sql = "SELECT * FROM eo_users";	
		$yol = baglan();mysqli_set_charset($yol, "utf8");
		$result = @mysqli_query($yol, $sql);
		if(!$result){
		   @header("Location: error.php?error=6");
			die("<font id='hata'> Tablo <a href=install.php>kurulumunu (installation)</a> yapmad&#305;n&#305;z!</font>");
		}
		@mysqli_free_result($result); 	
	}

//global değerler
$_uploadFolder = ayarGetir("uploadFolder");	
$_siteUnlockPwd = ayarGetir("siteUnlockPwd");	
$_defaultTheme = ayarGetir("defaultTheme");	
$_defaultLang = ayarGetir("defaultLang");	
$_filesToPlay = explode(",",ayarGetir("filesToPlay"));	
$_fileMaxUploadSize = ayarGetir("fileMaxUploadSize");	
$_videoChatSession = ayarGetir("videoChatSession");	
$_whiteBoardSession = ayarGetir("whiteBoardSession");	

/*
temizle: metin girişi, 
XSS temizliği
*/
function temizle($metin)
{
    //$metin = str_replace("&", "", $metin); //javascript &uuml; silmemeli
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("\'", "`", $metin);
    $metin = str_replace('\"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(strip_tags($metin));
	//htmlentities ve htmlspecialchars TR problemi var artık
    return $metin;
}
/*
temizleOzel: metin girişi, 
özel temizlik (ders kaydetmede)
*/
function temizleOzel($metin)
{
	$metin	= str_replace("&amp;", "&",$metin);
	$metin	= str_replace("&lt;", "<",$metin);
	$metin	= str_replace("&gt;", ">",$metin);
	$metin	= str_replace("&quot;", "\"",$metin);
	$metin	= str_replace("&apos;", "`",$metin);
	$metin	= str_replace("&#65533;", "`",$metin);
	$metin	= str_replace("&#8220;", "\"",$metin);
	$metin	= str_replace("&#8221;", "\"",$metin);
	$metin	= str_replace("&#8216;", "`",$metin);
	$metin	= str_replace("—", "-",$metin);
	$metin	= str_replace("–", "-",$metin);
	$metin	= str_replace("‘", "`",$metin);
	$metin	= str_replace("’", "`",$metin);
	$metin	= str_replace("”", "\"",$metin);
	$metin	= str_replace("“", "\"",$metin);
	$metin	= str_replace("…", "...",$metin);
	$metin	= str_replace("&#8230;", "...",$metin);
    return $metin;
}
/*
browserdili: parametresiz, 
aktif tarayıcının dil ayarını bulma
*/
function browserdili() {
	if(empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return "";
	
         $lang=	preg_split('/[,;]/i',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=	strtoupper($lang[0]);
         $lang=	preg_split('/[-]/i',$lang);
         return $lang[0];
}
/*
check_source:  
sayfa güvenliği için kontrol
*/
function check_source()  
{  
	global  $_source1;
	global  $_source2;
	if(!isset($_SERVER['HTTP_REFERER']))
		return false;
	
	$adresteki = $_SERVER['HTTP_REFERER'];
//	$adresteki = $_SESSION['this_page'];
	
  if (!( preg_match("|^$_source1|i",$adresteki) || preg_match("|^$_source2|i",$adresteki))  ) { 
	@header("Location: error.php?error=3");
	return false;
  }else{
	return true;
  }
}  
/*
sessionDestroy:
oturum bilgilerinin silinmesi
*/
function sessionDestroy(){
	  @session_destroy();
	  @session_start(); 	  
}
/*
numToTheme:
sayısaldan tema klasör adı getirir
*/
function numToTheme($gelen){
	global $_defaultTheme;
	$result = $_defaultTheme;
    $themeArray=glob('theme/*', GLOB_ONLYDIR);
	$i=0;
    foreach($themeArray as $thme){
	   $temaGel = explode("/",$thme);	
	   if($gelen==$i){		   
	    return $temaGel[1];
	   }
	   $i++;
	}
	return $result;		 
}
/*
kullaniciTema:
kullanıcı hangi tema seçmiş
*/
function kullaniciTema($kadi=""){
	global $_defaultTheme;
	$result = $_defaultTheme;
	
	if(empty($kadi)) return $result; //kullanıcı girmemişse varsayılan tema olur
	
	$secenekler = explode("-",ayarGetir3($kadi));	

	if($secenekler[15]<>""){
	    return numToTheme($secenekler[15]);//16.değer kayıtlı tema sayısı
	}
	else
		return $result;
}
/*
temaBilgisi:
temanın değiştirilmesi
*/
function temaBilgisi(){
	global $_defaultTheme;
	$result = $_defaultTheme;

	$siteSecenekleri = explode("-",ayarGetir("ayar5char"));	
	
	if ($siteSecenekleri[1]=="1"){
			if(isset($_SESSION["usern"]))
				$result = kullaniciTema($_SESSION["usern"]); 
			else
				$result = kullaniciTema(); 	

		if(isset($_GET["theme"]))
			$adresten = RemoveXSS($_GET["theme"]);
			else
			$adresten = "";
			
		$cerezden = RemoveXSS((isset($_COOKIE["theme"]))?$_COOKIE["theme"]:"");
	
		if($adresten!="" and is_dir('theme/'.$adresten))
		  {
			  setcookie("theme",$adresten,time()+60*60*24*30);
			  $result=$adresten;
		  }
		  else	if($cerezden!="" and is_dir('theme/'.$cerezden)){
	
			  $result=$cerezden;
		  }
		  
		  if(empty($cerezden)) 
			setcookie("theme",$result,time()+60*60*24*30);
	}
	  return $result;
}
/*
dilCevir:
dil ayarının yapıldığı yer
*/
function dilCevir($dil){
      if ($dil=="TR")
        require("lib/tr.php"); 
      elseif ($dil=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         
}
/*
checkLoginThemeLang:
giriş, dil ve sayfa adı kontrolü
*/
function checkLoginLang($lgn,$lng,$src){
	global $metin;
	global $adi;
	global $taraDili;
	global $_defaultLang;

	
	if($lng){
  		   $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
		   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili=$_defaultLang;
		   dilCevir($taraDili);		
		}
		
	if($lgn){
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");	
		  
			if($adi==""|| $par==""){ //EMPTY?
			   @header("Location: error.php?error=2");
			   die("<font id='hata'> ".$metin[403]."</font><br/>".$metin[402]); 
			}
		 
		   $tur=checkRealUser($adi,$par);
			
			if ($tur<=-1 || $tur>2) { 
			   sessionDestroy();
			   @header("Location: error.php?error=7");
			   die ("<font id='hata'> ".$metin[404]." (0)</font><br/>".$metin[402]);
			  }
			  else 
			  {
				$_SESSION["tur"] 	= $tur;
				$_SESSION["usern"] 	= $adi;
				$_SESSION["userp"] 	= $par;
			  }	
		}

	if(!empty($src)){
		currentFileCheck($src); 
	}
}
/*
araKalin:
arama kelimesinin renklendirilmesi, TR sorunu var.
*/
function araKalin($neyi)
{
	$sonuc="";
	
	$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
	
	if ($arayici=="") return $neyi;
	
	$posit1=strpos($neyi, mb_strtolower($arayici));	

	if($posit1>=0)
	  $sonuc=str_replace(mb_strtolower($arayici), "´´".mb_strtolower($arayici)."``", $neyi);
	  	 
	$posit2=strpos($neyi, mb_strtoupper($arayici));	

	if($posit2>=0)
	  $sonuc=str_replace(mb_strtoupper($arayici), "´´".mb_strtoupper($arayici)."``", $sonuc);

    $sonuc=str_replace("´´", "<font class='araSari'>", $sonuc);
    $sonuc=str_replace("``", "</font>", $sonuc);

	return $sonuc; 
}
/*
tarihOku:
TR formatında tarih bilgisi biçimi
*/
function tarihOku($gelenTarih){
	//Y-m-d > d-m-Y 	
	return date("d-m-Y", strtotime($gelenTarih));
}
/*
tarihOku3:
TR formatında tarih bilgisi biçimi
*/
function tarihOku3($gelenTarih){
	//Y-m-d > d-m-Y 	
	return date("d.m.Y", strtotime($gelenTarih));
}
/*
tarihYap:
TR formatında tarih bilgisi biçimi
*/
function tarihYap($gelenTarih){
	//d-m-Y > Y-m-d 
	if (date('Y-m-d', strtotime($gelenTarih))=="1970-01-01")
		return "0000-00-00";
	else
		return date('Y-m-d', strtotime($gelenTarih));
}
/*
tarihOku2:
TR formatında tarih bilgisi biçimi
*/
function tarihOku2($gelenTarih){
	//Y-m-d H:i:s > d-m-Y H:i:s
	return date('d-m-Y H:i:s', strtotime($gelenTarih));
}
/*
tarihYap2:
TR formatında tarih bilgisi biçimi
*/
function tarihYap2($gelenTarih){
	//d-m-Y H:i:s > Y-m-d H:i:s
	if (date('Y-m-d', strtotime($gelenTarih))=="1970-01-01 00:00:00")
		return "0000-00-00 00:00:00";
	else
		return date('Y-m-d H:i:s', strtotime($gelenTarih));
}
/*
currentFileCheck:
dosya isminin güvenlik nedeni ile kontrol edilmesi
*/
function currentFileCheck($fileName){
	global $currentFile;
	global $metin; 
	if($currentFile!=$fileName ){ 
	 @header("Location: error.php?error=8");
	 die ("<font id='hata'>$metin[449]</font>");
	}
}	
/*
GetSQLValueString:
tablodan String türünde veri alma
*/
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $yol1;		
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = mysqli_real_escape_string($yol1, $theValue);

 switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
/*
GetSQLValueStringNo:
tablodan Sayı türünde veri alma
*/
function GetSQLValueStringNo($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	global $yol1;	
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

 $theValue = mysqli_real_escape_string($yol1, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? $theValue : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? $theValue : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
/*
validInput:
TR ve boşluk harici karakter kontrolü
*/
function validInput($gelen)  
{  
  $pattern 	= '|^[a-z0-9_]*$|i' ;  
  $valid	= preg_match($pattern, $gelen) ; 
  if($valid) 
    return true;
   else
    return false;  
}  
/*
getTableSize:
tablo boyutunu Byte cinsinde alma
*/
function getTableSize($tableN){
	
	$yol1 = baglan();
	$araDeger = "";
	$res = mysqli_query($yol1, "SHOW TABLE STATUS LIKE '$tableN'");
	if ($res) {
	  if(mysqli_result($res, 0, "Data_free")>0) 
	    $araDeger = "<font color='red'><strong>".number_format(mysqli_result($res, 0, "Data_free") ,0,",","."). " B</strong></font>";	
	  
	$sonuc = "&nbsp;&nbsp;". number_format(mysqli_result($res, 0, "Data_length") + 
							mysqli_result($res, 0, "Index_length"),0,",",".")." B $araDeger [".mysqli_result($res, 0, "Rows")."]" ;
 	 @mysqli_free_result($res); 			
	  return  $sonuc ;
	}
	
	return 0;
}
/*
yetimKayitNolar:
bir tablonun yetim kayıtlarının sayısını bulur
*/
function yetimKayitNolar($tablo){
	$sonuc = "-";
	$yol1 = baglan();
	global $metin;
	
	switch ($tablo){
		 case "eo_2sinif":
		 
				$sql1 =    "SELECT eo_2sinif.id 
							FROM eo_2sinif
							LEFT OUTER JOIN eo_1okul ON eo_1okul.id  = eo_2sinif.okulID
							WHERE eo_1okul.okulAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_2sinif WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				     	$sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[218]";
					 else
					 	$sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[219]</label>";
				}					
		   
		 break;
		 case "eo_3ders":
		 
				$sql1 =    "SELECT eo_3ders.id 
							FROM eo_3ders
							LEFT OUTER JOIN eo_2sinif ON eo_2sinif.id  = eo_3ders.sinifID
							WHERE eo_2sinif.sinifAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_3ders WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[220]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[221]</label>";
				}					
		   
		 break;
		 case "eo_4konu":
		 
				$sql1 =    "SELECT eo_4konu.id 
							FROM eo_4konu
							LEFT OUTER JOIN eo_3ders ON eo_3ders.id  = eo_4konu.dersID
							WHERE eo_3ders.dersAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_4konu WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[222]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[223]</label>";
				}					
		   
				$sql1 =    "SELECT id ,oncekiKonuID
							FROM eo_4konu
							WHERE eo_4konu.oncekiKonuID<>0 ";
				

				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))    {
							$sqlici =    "SELECT eo_4konu.id 
										FROM eo_4konu
										WHERE eo_4konu.id = ".$row_gelen['oncekiKonuID']  ;
							
			
							$resultici = mysqli_query($yol1,$sqlici);
							if ($resultici){
								if (@mysqli_num_rows($resultici)==0)
							    	$sonuc2 .= $row_gelen['id'].", ";
							}
							@mysqli_free_result($resultici); 	

					}
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_4konu WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[224]";
					  else
					  $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[225]</label>";
				}					
		   
		 break;
		 case "eo_5sayfa":
		 
				$sql1 =    "SELECT eo_5sayfa.id 
							FROM eo_5sayfa
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_5sayfa.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_5sayfa WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[226]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[227]</label>";
				}					
		   
				$sql1 =    "SELECT eo_5sayfa.id 
							FROM eo_5sayfa
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_5sayfa.ekleyenID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1) {
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_5sayfa WHERE id IN ($sonuc2);"; 
				    
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[228]";
					  else					  
					  $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[229]</label>";
				}					
		   
		 break;
		 case "eo_userworks":
		 
				$sql1 =    "SELECT eo_userworks.id 
							FROM eo_userworks
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_userworks.userID
							WHERE eo_users.userName is NULL and eo_userworks.userID<>-1";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1) {
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_userworks WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231]</label>";
				}					
		   
				$sql1 =    "SELECT eo_userworks.id 
							FROM eo_userworks
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_userworks.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_userworks WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233]</label>";
				}					
		   
		 break;
		 case "eo_sinifogre":
		 
				$sql1 =    "SELECT eo_sinifogre.id 
							FROM eo_sinifogre
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_sinifogre.userID
							WHERE eo_users.userName is NULL ";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_sinifogre WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[234]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}					
		   
				$sql1 =    "SELECT eo_sinifogre.id 
							FROM eo_sinifogre
							LEFT OUTER JOIN eo_2sinif ON eo_2sinif.id  = eo_sinifogre.sinifID
							WHERE eo_2sinif.sinifAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_sinifogre WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[236]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[237]</label>";
				}					
		   
		 break;
		 case "eo_comments":
		 
				$sql1 =    "SELECT eo_comments.id 
							FROM eo_comments
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_comments.userID
							WHERE eo_users.userName is NULL and eo_comments.userID<>-1";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_comments WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231]</label>";
				}					
		   
				$sql1 =    "SELECT eo_comments.id 
							FROM eo_comments
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_comments.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_comments WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233]</label>";
				}					
		   
		 break;
		 case "eo_rating":
		 
				$sql1 =    "SELECT eo_rating.id 
							FROM eo_rating
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_rating.userID
							WHERE eo_users.userName is NULL and eo_rating.userID<>-1";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_rating WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231]</label>";
				}					
		   
				$sql1 =    "SELECT eo_rating.id 
							FROM eo_rating
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_rating.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_rating WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233]</label>";
				}					
		   
		 break;
		 case "eo_files":
		 
				$sql1 =    "SELECT eo_files.id 
							FROM eo_files
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_files.userID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_files WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}					
		   
		 break;
		 case "eo_friends":
		 
				$sql1 =    "SELECT eo_friends.id 
							FROM eo_friends
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_friends.davetEdenID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_friends WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}	
								
				$sql1 =    "SELECT eo_friends.id 
							FROM eo_friends
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_friends.davetEdilenID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_friends WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}					
		   
		 break;
		 case "eo_askquestion":
		 
				$sql1 =    "SELECT eo_askquestion.id 
							FROM eo_askquestion
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_askquestion.userID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askquestion WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}	
								
				$sql1 =    "SELECT eo_askquestion.id 
							FROM eo_askquestion
							LEFT OUTER JOIN eo_3ders ON eo_3ders.id  = eo_askquestion.dersID
							WHERE eo_3ders.id is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askquestion WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[220]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233]</label>";
				}					
		   
		 break;
		 case "eo_askanswer":
		 
				$sql1 =    "SELECT eo_askanswer.id 
							FROM eo_askanswer
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_askanswer.userID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askanswer WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}	
								
				$sql1 =    "SELECT eo_askanswer.id 
							FROM eo_askanswer
							LEFT OUTER JOIN eo_askquestion ON eo_askquestion.id  = eo_askanswer.soruID
							WHERE eo_askquestion.id is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askanswer WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[640]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[641]</label>";
				}	
								
		break;								
		 case "eo_askanswerrate":
		 
				$sql1 =    "SELECT eo_askanswerrate.id 
							FROM eo_askanswerrate
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_askanswerrate.userID
							WHERE eo_users.id is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askanswerrate WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}	
								
				$sql1 =    "SELECT eo_askanswerrate.id 
							FROM eo_askanswerrate
							LEFT OUTER JOIN eo_askanswer ON eo_askanswer.id  = eo_askanswerrate.cevapID
							WHERE eo_askanswer.id is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_askanswerrate WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[638]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[639]</label>";
				}	
								
		break;	
		 case "eo_livelesson":
		 
				$sql1 =    "SELECT eo_livelesson.id 
							FROM eo_livelesson
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_livelesson.userID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_livelesson WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]"; 
				   else 					 
				   $sonuc = "<label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235]</label>";
				}	
								
				$sql1 =    "SELECT eo_livelesson.id 
							FROM eo_livelesson
							LEFT OUTER JOIN eo_3ders ON eo_3ders.id  = eo_livelesson.dersID
							WHERE eo_3ders.id is NULL";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{
				   $sonuc2 = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc2 .= $row_gelen['id'].", ";
					
	  			   $sonuc2 = substr($sonuc2,0,strlen($sonuc2)-2);	 //son , silindi					   
				   	
				   $silinecekler = "DELETE FROM eo_livelesson WHERE id IN ($sonuc2);"; 
		
				   if (empty($sonuc2)) 
				   $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[220]"; 
				   else 					 
				   $sonuc .= " - <label onclick=\"document.sqlimp.sqlAl.value = '$silinecekler';\" ><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233]</label>";
				}					
		   
		 break;									
	 }
	@mysqli_free_result($result1); 
	return $sonuc;
}
/*
temizleWordHTML:
sayfalardaki word temizliği
*/
function temizleWordHTML($word){
	global $yol1;
	if($word!= ""){
		$cleaner=new HTMLCleaner();
	
		$cleaner->Options['UseTidy']=false;
		$cleaner->Options['OutputXHTML']=false;
		$cleaner->Options['Optimize']=true;
		
		$cleaner->html=$word;
		$cleanHTML=$cleaner->cleanUp('latin1');
		
		return $cleanHTML;		
	}else{
		return "";			
	}	
}
/*
arkadasListesi:
oturum açan kişinin arkadaş listesi
*/
function arkadasListesi($gelen=""){
	global $metin,$yol1;
	if($gelen==""){
		$aktifKullID = getUserID2($_SESSION["usern"]);
		$sql1 =    "SELECT * 
				FROM eo_friends
				WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
				ORDER BY id
				LIMIT 0,50";
		$sonuc = "";	
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{				    
				   while($row_gelen = mysqli_fetch_assoc($result1)) {
					if($row_gelen['davetEdenID']!=$aktifKullID)
					    $sonuc .= "<a href='friends.php?kisi=".$row_gelen['davetEdenID']."'>".kullAdi($row_gelen['davetEdenID'])."</a> ";				     
					else
						$sonuc .= "<a href='friends.php?kisi=".$row_gelen['davetEdilenID']."'>".kullAdi($row_gelen['davetEdilenID'])."</a> ";						
				   }
				}	
	}
	  else{
		$aktifKullID = getUserID2($_SESSION["usern"]);		 	
		$sql1 =    "SELECT davetEdenID,davetEdilenID 
				FROM eo_friends
				WHERE (davetEdilenID='$gelen' or davetEdenID='$gelen') 
				 and  (davetEdilenID<>'$aktifKullID' and davetEdenID<>'$aktifKullID')
				 and kabul='1'
				LIMIT 0,5";
		$sonuc = array();	
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{				    
				   while($row_gelen = mysqli_fetch_assoc($result1)) {
					if($row_gelen['davetEdenID']==$gelen)
					    $sonuc[] = $row_gelen['davetEdilenID'];				     
					else
					    $sonuc[] = $row_gelen['davetEdenID'];				     
				   }
				}	
	  	}
	return $sonuc;
}
/*
arkadasDogumListesi:
oturum açan kişinin arkadaşlarından doğum gününe 15 gün kalanlar
*/
function arkadasDogumListesi(){
	global $metin,$yol1;
	$aktifKullID = getUserID2($_SESSION["usern"]);
	$sonuc = "";	
				
	$sql1 =    "SELECT eo_users.id,
				eo_users.userBirthDate,DAYOFYEAR( eo_users.userBirthDate + INTERVAL YEAR( NOW() ) 
				   - YEAR( eo_users.userBirthDate ) YEAR ) - DAYOFYEAR( NOW() ) as fark 
				FROM eo_users				
				WHERE 
				  (
				  eo_users.id in (
				  SELECT  davetEdenID
					FROM eo_friends
					WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
				  ) or
				  eo_users.id in (
				  SELECT  davetEdilenID
					FROM eo_friends
					WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
				  )
				  ) and
				  eo_users.id <> '$aktifKullID' and 
				 (DAYOFYEAR( eo_users.userBirthDate + INTERVAL YEAR( NOW() ) 
				   - YEAR( eo_users.userBirthDate ) YEAR ) - DAYOFYEAR( NOW() ) 
				    BETWEEN 0 AND 15)
				ORDER BY fark 	
				LIMIT 0,5";
				//echo "$sql1";
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{				    
				   while($row_gelen = mysqli_fetch_assoc($result1)) {
					   if($row_gelen['fark']!="0")
					    $fark = $row_gelen['fark']." $metin[621] ";
						else
						$fark = " $metin[622] ";
					    $sonuc .= "<a href='friends.php?kisi=".$row_gelen['id']."'>".kullAdi($row_gelen['id'])."</a> $fark";						
				   }
				}	
	return $sonuc;
}
/*
arkadasTaniyor:
oturum açan kişinin arkadaşlarının arkadaşı olabilir
*/
function arkadasTaniyor(){
	global $metin,$yol1;
	$aktifKullID = getUserID2($_SESSION["usern"]);
	$sonuc = "";	
				
	$sql1 =    "SELECT eo_users.id
				FROM eo_users				
				WHERE 
				  (
				  eo_users.id in (
				  SELECT  davetEdenID
					FROM eo_friends
					WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
				  ) or
				  eo_users.id in (
				  SELECT  davetEdilenID
					FROM eo_friends
					WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
				  )
				  ) and
				  eo_users.id <> '$aktifKullID' 				 
				LIMIT 0,50";
				//echo "$sql1";
				$sonuc = "";
				$sonucA = array();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)	{				    
				   while($row_gelen = mysqli_fetch_assoc($result1)) {
					    $sonucA = array_merge($sonucA,arkadasListesi($row_gelen['id']));						
				   }
				   $sonucA = array_unique($sonucA);//tekrarlardan kurtulalım
				   
					$aktifKullID = getUserID2($_SESSION["usern"]);
					$sql1 =    "SELECT * 
							FROM eo_friends
							WHERE (davetEdilenID='$aktifKullID' or davetEdenID='$aktifKullID') and kabul='1'
							";
					$sonucKendi = array();	
							
							$result1 = mysqli_query($yol1,$sql1);
							if ($result1)	{				    
							   while($row_gelen = mysqli_fetch_assoc($result1)) {
								if($row_gelen['davetEdenID']!=$aktifKullID)
									$sonucKendi[] = $row_gelen['davetEdenID'];				     
								else
									$sonucKendi[] = $row_gelen['davetEdilenID'];						
							   }
							}
					$sonucA = array_diff($sonucA, $sonucKendi);//bir önceki arkadaşlar ve biz çıkmayalım
					
				   sort($sonucA);
			 	   foreach($sonucA as $eleman){
					  $sonuc .= "<a href='friends.php?kisi=".$eleman."'>".kullAdi($eleman)."</a> ";
				   }
				}	
	return $sonuc;
}
/*
getFriendApprovals:
kullanıcının bekleyen arkadaşlık istekleri
*/
function getFriendApprovals(){
	global $metin,$yol1;
	$aktifKullID = getUserID2($_SESSION["usern"]);
	$sonuc = "";
	$sql1 =    "SELECT * 
				FROM eo_friends
				WHERE davetEdilenID='$aktifKullID' and kabul='0'
				LIMIT 0,5";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1){				  	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $sonuc .= "<a href='askForFriendship.php?adi=".kullAdi($row_gelen['davetEdenID'])."&amp;id=".$row_gelen['davetEdenID']."' rel='facebox'>".kullAdi($row_gelen['davetEdenID'])."</a> ";		     
				}	
	return $sonuc;
}
/*
arkadasKabulDurumu:
arkadaş teklifi durumu
*/
function arkadasKabulDurumu($id){
	global $metin;
	switch($id){
		case 0://beklemede
		 echo "<img src=\"img/i_warn.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[599]\" title=\"$metin[599]\"/>";
		 break;
		case 1://kabul
		 echo "<img src=\"img/i_note.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[600]\" title=\"$metin[600]\"/>";
		 break;
		case 2://red
		 echo "<img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[601]\" title=\"$metin[601]\"/>";
		 break;
		default:
		 return "";
	}
}
/*
arkadasTeklifEt:
birine arkadaş isteği gönderme
*/
function arkadasTeklifEt($id){
	global $yol1;				
	$gonderenID	= getUserID($_SESSION["usern"],$_SESSION["userp"]);
	$datem	=	date("Y-n-j H:i:s");		
		
		if(!empty($gonderenID) && !empty($id)) {			
		//eğer zaten arkadaş teklifi var veya önceden reddedildiyse
			if(!arkadasTeklifVarMi2($gonderenID,$id)){
				//yok yeni bir arkadaşlık
				$sql2 = "INSERT INTO eo_friends
				    (kabul, davetEdenID, davetEdilenID, davetTarihi)
				 	VALUES 
					('0','$gonderenID','$id','$datem')";  

				$result2 = mysqli_query($yol1,$sql2); 
				return $result2;
			}else{
				//önceden birşeyler olmuş!
				$sql2 = "UPDATE eo_friends
				    SET kabul='0',davetTarihi ='$datem'
				   WHERE (davetEdenID='$gonderenID' and davetEdilenID='$id') or 
				   		(davetEdilenID='$gonderenID' and davetEdenID='$id')";  

				$result2 = mysqli_query($yol1,$sql2); 
				return $result2;
			}
		 }
	
	return false;
}
/*
arkadasTeklifVarMi:
daha önceden var mı arkadaş teklifi?
*/
function arkadasTeklifVarMi($gonderenID,$id){
	
	$sql1 = "SELECT * FROM eo_friends 
			WHERE 
			((davetEdenID='$gonderenID' and davetEdilenID='$id') or
			 (davetEdilenID='$gonderenID' and davetEdenID='$id'))
			 and kabul = '0' 
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	return ($result1 && @mysqli_num_rows($result1) == 1); 
}
/*
arkadasTeklifVarMi2:
daha önceden var mı arkadaş teklifi veya Red mi edilmişti?
*/
function arkadasTeklifVarMi2($gonderenID,$id){
	
	$sql1 = "SELECT * FROM eo_friends 
			WHERE 
			((davetEdenID='$gonderenID' and davetEdilenID='$id') or
			 (davetEdilenID='$gonderenID' and davetEdenID='$id'))
			 and (kabul = '0' or kabul='2')
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	return ($result1 && @mysqli_num_rows($result1) == 1); 
}
/*
arkadasMi:
arkadaş iseler TRUE
*/
function arkadasMi($gonderenID,$id){
	
	$sql1 = "SELECT * FROM eo_friends 
			WHERE 
			((davetEdenID='$gonderenID' and davetEdilenID='$id') or
			 (davetEdilenID='$gonderenID' and davetEdenID='$id') )
			 and
			kabul = '1' 
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	return ($result1 && @mysqli_num_rows($result1) == 1); 
}
/*
getArkadaslikDavetTarihi:
arkadaş ile ne zaman teklif edildi
*/
function getArkadaslikDavetTarihi($kendi,$diger){
	
	$sql1 = "SELECT davetTarihi FROM eo_friends 
			WHERE 
			(davetEdenID='$kendi' and davetEdilenID='$diger') or
			(davetEdilenID='$kendi' and davetEdenID='$diger') 
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	$duvarYazisi = @mysqli_fetch_array($result1);
	
		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($duvarYazisi[0]);

	return $insansi; 
}
/*
getArkadaslikKabulTarihi:
arkadaş ile ne zaman kabul edildi
*/
function getArkadaslikKabulTarihi($kendi,$diger){
	
	$sql1 = "SELECT kabulTarihi FROM eo_friends 
			WHERE 
			(davetEdenID='$kendi' and davetEdilenID='$diger') or
			(davetEdilenID='$kendi' and davetEdenID='$diger') 
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	$duvarYazisi = @mysqli_fetch_array($result1);
	
		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($duvarYazisi[0]);

	return $insansi; 
}
/*
arkadasDuvarYazisi:
arkadaş ile ortak duvar yazısı getirme
*/
function arkadasDuvarYazisi($kendi,$diger){
	
	$sql1 = "SELECT duvarYazisi FROM eo_friends 
			WHERE 
			(davetEdenID='$kendi' and davetEdilenID='$diger') or
			(davetEdilenID='$kendi' and davetEdenID='$diger') 
			LIMIT 0,1";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	$duvarYazisi = @mysqli_fetch_array($result1);
	return RemoveXSS($duvarYazisi[0]); 
}
/*
arkadasReddet: reddedilen kisi id
kullanıcı adı ile kisi red edilir
*/
function arkadasReddet($kisi){
		global $yol1;				
		
		$datem	=	date("Y-n-j H:i:s");		
		$gonderenID	= getUserID($_SESSION["usern"],$_SESSION["userp"]);
		
		if(!empty($gonderenID) && !empty($kisi)) {			
				$sql2 = "UPDATE eo_friends
				   SET kabul='2',kabulTarihi ='$datem'
				   WHERE (davetEdenID='$gonderenID' and davetEdilenID='$kisi') or 
				   		(davetEdilenID='$gonderenID' and davetEdenID='$kisi')
				   "; 

			$result2 = mysqli_query($yol1,$sql2); 
			return $result2;
		 }		
	return false;
}
/*
dosyaSil:
dosyanın fiziksel olarak silinmesi
*/
function dosyaSil($id){
	global $_uploadFolder;
	$sql1 = "select fileName from eo_files where id='$id'";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) == 1){
		$sonuc = @mysqli_fetch_array($result1);
		if(file_exists($_uploadFolder."/".$sonuc[0]))
			@unlink($_uploadFolder."/".$sonuc[0]);
			//varsa artık silelim
	  }
   	@mysqli_free_result($result1);	 
}
/*
dosyaSil2:
dosyanın veritabanından silinmesi
*/
function dosyaSil2($id){
	$yol1 = baglan();
	$sql1 = "delete from eo_files where id='$id' limit 1";
	$result1 = mysqli_query($yol1,$sql1);
   	@mysqli_free_result($result1);	 
}
/*
dosyaListele:
bir klasördeki dosya listesi dizi olarak alınır
*/
function dosyaListele($klasor){
	$dosyaListesi = array();
	$dizin=@opendir($klasor);
	while ($file = @readdir($dizin)) {
		if ( $file!="." AND $file!=".." AND $file!="" )	{
			$dosyaListesi []=$file;
		}
	}
	@closedir($dizin);
//	sort($dosyaListesi);
	return $dosyaListesi;
}
/*
dosya_uploads_uyumu:
veritabanı listesinden uploads dosyaların isim kontrolü
*/
function dosya_uploads_uyumu(){
	$sonuc = "";
	$dosyalarVTdeki = array();
	
	global $_uploadFolder;
	$sql1 = "select fileName from eo_files";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) > 0){
		while ($gelen = @mysqli_fetch_array($result1)){
			$dosyalarVTdeki[]=$gelen[0];
			if(!file_exists($_uploadFolder."/".$gelen[0]))
			 $sonuc .= "* ".$gelen[0]."<br/>"; 
			 //vtdeki dosya klasörde yok ise 			
		}
	  }
	 
	 foreach(dosyaListele($_uploadFolder) as $eleman){		   
		 	if(!in_array($eleman,array(".svn",".htaccess","index.php")) and !in_array($eleman,$dosyalarVTdeki)) {
				$sonuc .= "~ ".$eleman."<br/>"; 
				//klasördeki dosya vt içinde yok ise
				}		 
		 }
	 
	 return $sonuc;
   	@mysqli_free_result($result1);	 
}
/*
klasorSil:
klasör içindekiler ile silinir
*/
function klasorSil($dir) {
if (substr($dir, strlen($dir)-1, 1)!= '/')
$dir .= '/';
//echo $dir; //silinen klasörün adı
if ($handle = opendir($dir)) {
	while ($obj = readdir($handle)) {
		if ($obj!= '.' && $obj!= '..') {
			if (is_dir($dir.$obj)) {
				if (!klasorSil($dir.$obj))
					return false;
				} elseif (is_file($dir.$obj)) {
					if (!@unlink($dir.$obj))
						return false;
					}
			}
	}
		closedir($handle);
		if (!@rmdir($dir))
		return false;
		return true;
	}
return false;
}
/*
dosyaTemizle:
gereksiz dosyaları upload klasöründen ve veritabanından siler
*/
function dosyaTemizle(){
	$sonuc = "";
	$dosyalarVTdeki = array();
	
	global $_uploadFolder, $metin;
	$sql1 = "select fileName,id from eo_files";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) > 0){
		while ($gelen = @mysqli_fetch_array($result1)){
			$dosyalarVTdeki[]=$gelen[0];
			if(!file_exists($_uploadFolder."/".$gelen[0])){
			 $sonuc .= "* ".$gelen[0]." $metin[503]<br/>"; 
			 dosyaSil2($gelen[1]);
			}
			 //vtdeki dosya klasörde yok ise 			
		}
	  }
	 
	 foreach(dosyaListele($_uploadFolder) as $eleman){		   
		 	if(!in_array($eleman,array(".svn",".htaccess","index.php")) and !in_array($eleman,$dosyalarVTdeki)) {
				$sonuc .= "~ ".$eleman." $metin[502]<br/>";
				if(is_dir($_uploadFolder."/".$eleman))
					klasorSil($_uploadFolder."/".$eleman);
				 else 
					@unlink($_uploadFolder."/".$eleman);
				//klasördeki dosya vt içinde yok ise
				}		 
		 }
	 
	 return $sonuc;
   	@mysqli_free_result($result1);
}
/*
dosyaGoster:
gelen dosya içeriğini gösterir
*/
function dosyaGoster($filename){
	global $_uploadFolder;
	if (!file_exists($_uploadFolder."/$filename")) 
	   return "dosya yok";	   
	   
	$handle = fopen($_uploadFolder."/$filename", "r");
        $sData = '';
        while(!feof($handle))
            $sData .= fread($handle, filesize($_uploadFolder."/$filename"));
        fclose($handle);	
	return $sData;
}
/*
file_ext:
dosya uzantısını bulur
*/
function file_ext($filename) 
{ 
 $filename = strtolower($filename) ; 
 $exts = preg_split('$[/\\.]$', $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
} 
/*
idtoDosyaAdi:
gelen id ile dosya adı döner
*/
function idtoDosyaAdi($gelen){
	$gelen = RemoveXSS($gelen);
	$sql1 = "select fileName from eo_files where id='$gelen'";
	
	$yol1 = baglan();
	
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) == 1){
		$sonuc = @mysqli_fetch_array($result1);
	  }
   	@mysqli_free_result($result1);	 
	return $sonuc[0];	
}
/*
getSizeAsString:
Returns the size of a file (given in byte) as a String with kB/MB unit
 */
function getSizeAsString($size) {
	if ($size < 2) {
		return $size." Byte";
	}
	else if ($size < 1024) {
		return $size." Bytes";
	}
	else if ($size < 1048576) {
		return round(($size/1024), 0)." KB";
	}
	else {
		return round(($size/1048576), 1)." MB";
	}
}
/*
getDownloadCount:
kimlik ile indirme sayısı getirir
*/
function getDownloadCount($id){
	$id = RemoveXSS($id);
	$sql1 = "select downloadCount from eo_files where id='$id'";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) == 1){
		$sonuc = @mysqli_fetch_array($result1);
	  }
   	@mysqli_free_result($result1);	 
	return $sonuc[0]+1;
}
/*
getDosyaID:
dosya adı ile kimlik bilgisi getirir
*/
function getDosyaID($ad){
	$ad = RemoveXSS($ad);
	$sql1 = "select id from eo_files where fileName='$ad'";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) == 1){
		$sonuc = @mysqli_fetch_array($result1);
	  }
   	@mysqli_free_result($result1);	 
	return $sonuc[0];
}
/*
downloadSayac:
kimlik ile sayacı artıralım
*/
function downloadSayac ($id){
	$id = RemoveXSS($id);
	$sql1 = "UPDATE eo_files set downloadCount='".getDownloadCount($id)."' 
			where id='$id'";	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
   	@mysqli_free_result($result1);
}
/*
dosyaKaydet:
dosya ismini ve kullanıcı kimliği kaydedilir
*/
function dosyaKaydet($dosya,$uID){
	$uID = RemoveXSS($uID);
	$dosya = temizle($dosya);
	$sql1 = "INSERT into eo_files values(NULL, '$uID','$dosya','0')";	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
   	@mysqli_free_result($result1);
}
/*
istekteBulunanSay:
yetkisini değiştirmek isteyenlerin sayısı
*/
function istekteBulunanSay(){
	$sql1 = "select count(id) from eo_usertrack where otherInfo like 'request,%'";
	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
 	  if ($result1 && @mysqli_num_rows($result1) == 1){
		$sonuc = @mysqli_fetch_array($result1);
	  }
   	@mysqli_free_result($result1);	 
	return $sonuc[0];	
}
/*
isimleriAyniUyeler:
üyelerin tekrar üye olduklarının tespiti
*/
function isimleriAyniUyeler(){
	global $metin;
	$sql1 = "
			SELECT DISTINCT realName
			FROM eo_users
			WHERE 
			  realName in (
				SELECT realName
				FROM eo_users 		 			 
				GROUP BY realName
				HAVING (count(id)>1)
				)
			ORDER BY realName";	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	$liste ="";
	if(@mysqli_num_rows($result1)>0){
		
 	 while($gelen=@mysqli_fetch_array($result1)){
			$liste .= "<a href='siteSettings.php?arama=".$gelen['realName']."'>'".$gelen['realName']."'</a> ";
	 }//while
	}//if
   	@mysqli_free_result($result1);
	
	 return $liste; 	
}
/*
sonCalisanKullanicilar:
ders çalışma sayfasında son çalışan kullanıcı isimleri
*/
function sonCalisanKullanicilar($konuID){
	global $metin;
	$sql1 = "SELECT eo_users.id,eo_users.userName,
				eo_users.userType, max(eo_userworks.calismaTarihi) as calismaTarihi,
				eo_userworks.toplamZaman, eo_userworks.lastPage,
				count(eo_userworks.calismaTarihi) as say
			FROM eo_userworks
			LEFT OUTER JOIN eo_users 
			ON eo_userworks.userID = eo_users.id
			WHERE eo_userworks.konuID='$konuID' 
			
			GROUP BY eo_users.userName				
			ORDER BY calismaTarihi DESC,eo_users.userName
			LIMIT 0,".ayarGetir("ayar2int");	
	$yol1 = baglan();
	$result1 = @mysqli_query($yol1,$sql1);
	$liste = '<table cellpadding="5" cellspacing="0" class="table table-striped">';
	$satirRenk = 0;
	if(@mysqli_num_rows($result1)>0){
  	 $liste .= "<tr><th>$metin[17]</th><th>$metin[481]</th><th>$metin[240]</th><th>$metin[187]</th>
	 			<th>$metin[482]</th></tr>";
 	 while($gelen=@mysqli_fetch_array($result1)){
		$simge = "";
			$satirRenk++;
				if ($satirRenk & 1) { 
					$row_color = "#CCC"; 
					} else { 
					$row_color = "#ddd"; 
					}		
		if ($gelen['userType']=="-1" or $gelen['userType']=="" ) $simge =  "<img src=\"img/pasif_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[93]\"/> "; 
		else if ($gelen['userType']=="0") $simge =   "<img src=\"img/ogr_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[94]\"/> " ;
		else if ($gelen['userType']=="1") $simge =   "<img src=\"img/ogrt_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[95]\"/> ";
		else if ($gelen['userType']=="2") $simge =   "<img src=\"img/admin_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[96]\"/> ";

		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($gelen['calismaTarihi']);
		$liste .= "<tr>";
		if(!empty($gelen[1]))		
			$liste .= "<td align='left' style=\"background-color: $row_color;\"><a href='profil.php?kim=$gelen[0]' rel='facebox' style='color:#00F'>$simge $gelen[1]</a></td>".
					"<td style=\"background-color: $row_color;\">".$insansi."</td><td align='right' style=\"background-color: $row_color;\">".
					Sec2Time2($gelen['toplamZaman']).
					"</td><td align='right' style=\"background-color: $row_color;\">".$gelen['lastPage'].
					"</td><td align='right' style=\"background-color: $row_color;\">".$gelen['say']."</td>";
		 else
		    $liste .= "<td align='left' style=\"background-color: $row_color;\">$simge demo</td><td style=\"background-color: $row_color;\">".$insansi."</td><td align='right' style=\"background-color: $row_color;\">".
					Sec2Time2($gelen['toplamZaman']).
					"</td><td align='right' style=\"background-color: $row_color;\">".$gelen['lastPage'].
					"</td><td align='right' style=\"background-color: $row_color;\">".$gelen['say']."</td>";	
		$liste .= "</tr>";
	 }//while
	}//if
	$liste .="</table>";
   	@mysqli_free_result($result1);
	if($liste=="<table></table>")
	 return "Çalışan yok!";
	else
	 return $liste; 
}
/*
getStats:
belli bir istatistik bilgisini elde etme
*/
function getStats($num,$uID="")
{
	global $metin;
	$num = (int) substr($num,0,15);
	
	switch($num){
		case 0:
		//&ouml;ğrencilerden en fazla &ccedil;alışanlar
				$sql1 =    "SELECT eo_users.userName as userName,eo_users.id, count(*) as toplam 
							FROM eo_users,eo_userworks 
							WHERE userType=0 and eo_users.id = eo_userworks.userID
							GROUP BY userName
							ORDER BY toplam DESC,userName ASC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
				    	$ekle .= $row_gelen['userName'].", ";
						else
				    	$ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 1:
		//&ouml;ğrencilerden en az &ccedil;alışanlar
				$sql1 =    "SELECT eo_users.userName as userName,eo_users.id, count(*) as toplam 
							FROM eo_users,eo_userworks 
							WHERE userType=0 and eo_users.id = eo_userworks.userID
							GROUP BY userName
							ORDER BY toplam ASC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";
				   if(@mysqli_num_rows($result1)<ayarGetir("ayar2int")) return "";
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
				    		$ekle .= $row_gelen['userName'].", ";
						else
				    		$ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 2:
		//en fazla &ccedil;alışılan konular
				$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu,eo_userworks 
							WHERE eo_4konu.id = eo_userworks.konuID
							GROUP BY konuAdi
							ORDER BY toplam DESC, konuAdi";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   if(@mysqli_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return "";
				   $sayGelen=1;
				   while($row_gelen = mysqli_fetch_assoc($result1)){
				    $ekle .= "<li style=\"list-style-type:none;\"><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				   }
					
				   if(@mysqli_num_rows($result1)>0) $ekle .= "</ul>";
				  if (@mysqli_num_rows($result1) > ayarGetir("ayar2int"))	
				    $ekle .="<div><a href='getFullList.php?case=2' rel=\"shadowbox;height=400;width=800\" title='$metin[200]'  class='more'>$metin[162]</a></div>";
			   	   @mysqli_free_result($result1);	
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 3:
		//hiç &ccedil;alışılmamış konular
				$sql1 =    "SELECT eo_4konu.id as id, eo_4konu.konuAdi as konuAdi 
							FROM eo_4konu 
							LEFT OUTER JOIN eo_userworks
							ON eo_4konu.id = eo_userworks.konuID
							WHERE  eo_userworks.konuID IS NULL
							GROUP BY konuAdi
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
				    		$ekle .= $row_gelen['konuAdi'].", ";
						else
				    		$ekle .= "<a href='dersBilgisi.php?ders=".$row_gelen['id']."' rel='facebox'>".$row_gelen['konuAdi']."</a>, ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 4:
		//demo kullanıcıların en fazla girdiği dersler
				$sql1 =    "SELECT eo_4konu.id,eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu 
							LEFT OUTER JOIN eo_userworks
							ON eo_4konu.id = eo_userworks.konuID
							WHERE eo_userworks.userID=-1
							GROUP BY konuAdi
							ORDER BY toplam DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
						    $ekle .= "<a href='lessons.php?konu=".$row_gelen['id']."' >".$row_gelen['konuAdi']."</a>, " ;
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 6:
		//en fazla ders d&uuml;zenleyen &ouml;ğretmenler/y&ouml;neticiler
				$sql1 =    "SELECT eo_users.userName as userName, eo_users.id, count(*) as toplam 
							FROM eo_5sayfa 
							LEFT OUTER JOIN eo_users
							ON eo_5sayfa.ekleyenID = eo_users.id
							WHERE eo_users.userType>0
							GROUP BY userName
							ORDER BY toplam DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
					    	$ekle .= $row_gelen['userName'].", ";
						else
						    $ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 8:		
		//toplam &ccedil;alışma s&uuml;resi
				$sql1 =    "SELECT SUM(eo_userworks.toplamZaman) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $row_gelen = mysqli_fetch_assoc($result1);
				   $ekle = $row_gelen["toplam"];	 
				   @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 9:
		//ortalama &ccedil;alışma s&uuml;resi
				$sql1 =    "SELECT AVG(eo_userworks.toplamZaman) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $row_gelen = mysqli_fetch_assoc($result1);
				   $ekle = $row_gelen["toplam"];	 	
				   @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
								
				break;
		case 10:
		//ortalama &ccedil;alışma y&uuml;zdesi
				$sql1 =    "SELECT AVG(eo_userworks.lastPage) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $row_gelen = mysqli_fetch_assoc($result1);
				   $ekle = $row_gelen["toplam"];	
				   @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;		
		case 11:
		//şu anki kullanıcının &ccedil;alışma konuları ve sayıları
				$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu,eo_userworks, eo_users 
							WHERE eo_4konu.id = eo_userworks.konuID and eo_users.id = eo_userworks.userID
							      and eo_users.id = ".getUserID($_SESSION["usern"],$_SESSION["userp"])."
							GROUP BY konuAdi
							ORDER BY toplam DESC, konuAdi";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   if(@mysqli_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return "";	 
				   
				   $sayGelen = 1;
				   while($row_gelen = mysqli_fetch_assoc($result1)){
				    $ekle .= "<li style='list-style-type:none;'><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				   }
					
				   	$ekle .= "</ul>";
					
					if (@mysqli_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=11' rel=\"shadowbox;height=400;width=800\" title='$metin[213]'  class='more'>$metin[162]</a></div>"; 
					@mysqli_free_result($result1);   
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
				
		case 12:
		//şu anki kullanıcının bitirdiği dersler
				if($uID=="")
				//kendi kimliği lazım
					$uID = getUserID($_SESSION["usern"],$_SESSION["userp"]);	
					
				$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
									eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi,
									eo_3ders.id as dersID,  
									sum(eo_userworks.toplamZaman) as toplam 
							FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
							WHERE eo_4konu.id = eo_userworks.konuID and 
								  eo_users.id = eo_userworks.userID and
								  eo_3ders.id = eo_4konu.dersID and
								  eo_2sinif.id = eo_3ders.sinifID and
								  eo_1okul.id = eo_2sinif.okulID and
							      eo_users.id = ".$uID."
							GROUP BY dersAdi
							ORDER BY toplam DESC";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   if(@mysqli_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return ""; 
				   $sayGelen = 1;
				   while($row_gelen = mysqli_fetch_assoc($result1)){
				    $ekle .= "<li style='list-style-type:none;'>".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - <a href='kursDetay.php?kurs=".$row_gelen['dersID']."&amp;user=$uID'>".$row_gelen['dersAdi']."</a> <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				}
					
				   $ekle .= "</ul>";
				   
				   if (@mysqli_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=12&amp;user=$uID'  rel=\"shadowbox;height=400;width=800\" title='$metin[239]' class='more'>$metin[162]</a></div>"; 
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		
		case 13:
		//son g&uuml;ncellenen konular
							$sql = "SELECT eo_5sayfa.konuID as idsi, eo_4konu.konuAdi as kadi,".
								   "eo_3ders.dersAdi as dersAdi, max(eo_5sayfa.eklenmeTarihi) as tarih ".
								   "from eo_5sayfa, eo_4konu, eo_3ders ".
								   "where eo_5sayfa.konuID=eo_4konu.id ".
								   "and eo_4konu.dersID=eo_3ders.id ".
								   "GROUP BY kadi ".
								   "order by tarih desc,kadi";	
		
				// $sql = "SELECT eo_5sayfa.konuID AS idsi, eo_4konu.konuAdi AS kadi,
					// (select dersAdi from eo_3ders where eo_3ders.id=eo_4konu.dersID) as dersAdi , 
					// ( eo_5sayfa.eklenmeTarihi )AS tarih
					// FROM eo_5sayfa, eo_4konu
					// WHERE eo_5sayfa.konuID = eo_4konu.id
					// group by idsi 
					// ORDER BY tarih DESC , kadi";	   
				$yol = baglan();mysqli_set_charset($yol, "utf8");
				$result = mysqli_query($yol,$sql);
				if($result)
				 {
					 if (@mysqli_num_rows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysqli_num_rows($result)<ayarGetir("ayar2int"))?@mysqli_num_rows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysqli_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							
				     	$humanRelativeDate = new HumanRelativeDate();
						$insansi = $humanRelativeDate->getTextForSQLDate($data["tarih"]);
							
							if ($data["tarih"]=="0000-00-00 00:00:00")
								$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>";
								else
								$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>"." <font size='-3'>".$insansi."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
				   
					   if (@mysqli_num_rows($result) > ayarGetir("ayar2int"))	
						   $ekle .="<div><a href='getFullList.php?case=13' rel=\"shadowbox;height=400;width=800\" title='$metin[84]'  class='more'>$metin[162]</a></div>"; 
					   
					 }		
					 @mysqli_free_result($result);
				 if(isset($ekle))	 
					return $ekle; 
				}else {
				   return ("");
				}
				
				break;		
		case 14:
		//en fazla oy verilen konular
				$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
					   " avg(eo_rating.value) as ortalama, count(eo_rating.value) as toplam ".
					   "from eo_rating, eo_4konu ".
					   "where eo_rating.konuID=eo_4konu.id ".
					   "GROUP BY kadi ".
					   "order by ortalama desc,toplam DESC,konuAdi";	
				$yol = baglan();mysqli_set_charset($yol, "utf8");
				$result = mysqli_query($yol,$sql);
				if($result)
				 {
					 if (@mysqli_num_rows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysqli_num_rows($result)<ayarGetir("ayar2int"))?@mysqli_num_rows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysqli_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a>".
								          " <font title='$metin[273] : ".$data["toplam"].", $metin[274] : ".round($data["ortalama"],1)
										  ."'>".yildizYap(round($data["ortalama"]))."</font>";								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
					 if (@mysqli_num_rows($result) > ayarGetir("ayar2int"))	
						   $ekle .="<div><a href='getFullList.php?case=14'  rel=\"shadowbox;height=400;width=800\" title='$metin[276]' class='more'>$metin[162]</a></div>"; 
					   
					 }	
					 @mysqli_free_result($result);
				 if(isset($ekle))	 
					return $ekle; 
				}else {
				   return ("");
				}
				
				break;		
		case 15:
		//en fazla yorum eklenen konular
				$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
					   " count(*) as toplam ".
					   "from eo_comments, eo_4konu ".
					   "where eo_comments.konuID=eo_4konu.id ".
					   " and eo_comments.active=1 ".
					   "GROUP BY kadi ".
					   "order by toplam desc,kadi";	
				$yol = baglan();mysqli_set_charset($yol, "utf8");
				$result = mysqli_query($yol,$sql);
				if($result)
				 {
					 if (@mysqli_num_rows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysqli_num_rows($result)<ayarGetir("ayar2int"))?@mysqli_num_rows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysqli_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
							if (@mysqli_num_rows($result) > ayarGetir("ayar2int"))	
						   		$ekle .="<div><a href='getFullList.php?case=15'  rel=\"shadowbox;height=400;width=800\" title='$metin[277]' class='more'>$metin[162]</a></div>";
					 }		
					 @mysqli_free_result($result);
				 if(isset($ekle))	 
					return $ekle; 
				}else {
				   return ("");
				}
				
				break;
		case 16:
		//son demo çalışmaları
				$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
					   " count(*) as toplam ".
					   "from eo_userworks, eo_4konu ".
					   "where eo_userworks.konuID=eo_4konu.id ".
		//			   " and eo_userworks.userID=-1 ".
					   "GROUP BY kadi ".
					   "order by toplam desc,kadi";	
				$yol = baglan();mysqli_set_charset($yol, "utf8");
				$result = mysqli_query($yol,$sql);
				if($result)
				 {
					 if (@mysqli_num_rows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysqli_num_rows($result)<ayarGetir("ayar2int"))?@mysqli_num_rows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysqli_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
							if (@mysqli_num_rows($result) > ayarGetir("ayar2int"))	
						   		$ekle .="<div><a href='getFullList.php?case=16' rel=\"shadowbox;height=400;width=800\" title='$metin[302]' class='more'>$metin[162]</a></div>";
					 }		
					 @mysqli_free_result($result);
					if (!empty($ekle))	 return $ekle; 
				}else {
				   return ("");
				}
				
				break;		
		case 17:
		//&ouml;ğrencilerden 0 çalışanlar
				$sql1 =    "SELECT eo_users.userName as userName,eo_users.id 
							FROM eo_users 
							LEFT OUTER JOIN eo_userworks
							ON eo_users.id = eo_userworks.userID
							WHERE userType=0 and eo_userworks.userID is NULL  							
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";
				   if(@mysqli_num_rows($result1)<ayarGetir("ayar2int")) return "";
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
					    	$ekle .= $row_gelen['userName'].", ";
						else
						    $ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;						
		case 18:
		//en başarılı öğrenciler
				$sql1 =    "SELECT eo_users.userName as userName,eo_users.id, 
							avg(eo_userworks.lastPage) as basari 
							FROM eo_users, eo_userworks
							WHERE userType=0  
							      and 
								  eo_users.id = eo_userworks.userID
							GROUP BY userName
							ORDER BY basari DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   $ekle = "";
				   if(@mysqli_num_rows($result1)<ayarGetir("ayar2int")) return "";
				   while($row_gelen = mysqli_fetch_assoc($result1))
				   		if($_SESSION["userp"]=="")
					    	$ekle .= $row_gelen['userName'].", ";
						else
						    $ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;	
									
		case 19:
		//şu anki kullanıcının bitirdiği dersler
				if($uID=="")
				//kendi kimliği lazım
					$uID = getUserID($_SESSION["usern"],$_SESSION["userp"]);	
					
				$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
									eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi,
									eo_3ders.id as dersID,  
									sum(eo_userworks.toplamZaman) as toplam 
							FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
							WHERE eo_4konu.id = eo_userworks.konuID and 
								  eo_users.id = eo_userworks.userID and
								  eo_3ders.id = eo_4konu.dersID and
								  eo_2sinif.id = eo_3ders.sinifID and
								  eo_1okul.id = eo_2sinif.okulID and
							      eo_users.id = ".$uID."
							GROUP BY dersAdi
							ORDER BY toplam DESC";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   if(@mysqli_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return ""; 
				   $sayGelen = 1;
				   while($row_gelen = mysqli_fetch_assoc($result1)){
				    $ekle .= "<li style='list-style-type:none;'>".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - <a href='kursDetay2.php?kurs=".$row_gelen['dersID']."&amp;kisi=$uID'>".$row_gelen['dersAdi']."</a> <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				}
					
				   $ekle .= "</ul>";
				   
				   if (@mysqli_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=19'  rel=\"shadowbox;height=400;width=800\" title='$metin[239]' class='more'>$metin[162]</a></div>"; 
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		
		case 20:
		//son çalışılan konular
					
				$sql1 = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,
					    	MAX(eo_userworks.calismaTarihi) as tarih 
					   from eo_userworks, eo_4konu 
					   where eo_userworks.konuID=eo_4konu.id 
					   GROUP BY kadi 
					   order by tarih desc,konuAdi";
				
				$yol1 = baglan();
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1)
				{
				   if(mysqli_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return ""; 
				   $sayGelen = 1;
				   while($row_gelen = mysqli_fetch_row($result1)){
   				     	$humanRelativeDate = new HumanRelativeDate();
						$insansi = $humanRelativeDate->getTextForSQLDate($row_gelen[2]);							

				    $ekle .= "<li style='list-style-type:none;'><a href='lessons.php?konu=".$row_gelen[0]."'>".$row_gelen[1]."</a> <font size='-3'>".$insansi."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				}
					
				   $ekle .= "</ul>";
				   
				   if (@mysqli_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=20'  rel=\"shadowbox;height=400;width=800\" title='$metin[675]' class='more'>$metin[162]</a></div>"; 
					@mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
	} //switch	

return "";
}
/*
yildizYap:
gelen sayıya göre yıldız üretme
*/
function yildizYap($num){
	$sonuc ="";
	if($num>0 && $num<6){
		for($i=1;$i<=$num;$i++){
			$sonuc.="<img src='img/star.gif' border='0' style='vertical-align:middle' alt='star' />";
		}
	}else
		$sonuc = "problem";

	return $sonuc ;	
}
/*
smileAdd:
gelen metnin içine smiley resimleri ekleme
*/
function smileAdd($gelen){

	$icos = array(":)",":(",";)",":-P","S-)","](",":*)","O:]",":-X","8-)","=/","=O","QQ",":-D");
	$smileImg = array(
					  "<img src='lib/wtag/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' />",
					  "<img src='lib/wtag/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' />",
					  "<img src='lib/wtag/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' />",
					  "<img src='lib/wtag/smileys/tongue.gif' width='15' height='15' alt=':-P' title=':-P' />",
					  "<img src='lib/wtag/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' />",
					  "<img src='lib/wtag/smileys/angry.gif' width='15' height='15' alt='](' title='](' />",
					  "<img src='lib/wtag/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' />",
					  "<img src='lib/wtag/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' />",
					  "<img src='lib/wtag/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' />",
					  "<img src='lib/wtag/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' />",
					  "<img src='lib/wtag/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' />",
					  "<img src='lib/wtag/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' />",
					  "<img src='lib/wtag/smileys/cry.gif' width='15' height='15' alt='QQ' title='QQ' />",
					  "<img src='lib/wtag/smileys/grin.gif' width='15' height='15' alt=':-D' title=':-D' />"
		);

	$sonuc = str_replace($icos, $smileImg, $gelen);
 return $sonuc;	
}
/*
yorumlariGetir:
belli bir konuda yorum bilgilerini getirir
*/
function yorumlariGetir($konu){
	global $metin;
    $sql1 = "SELECT eo_comments.id as comID ,eo_comments.comment, eo_comments.commentDate, eo_users.userName, eo_users.id as id
				FROM eo_comments, eo_users, eo_4konu 
				where 
				eo_comments.konuID = eo_4konu.id and eo_comments.userID = eo_users.id 
				and eo_comments.active = 1 and eo_4konu.id = ".$konu."
				order by eo_comments.commentDate DESC";
	
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1)){
					  if($row_gelen['id'] == getUserID($_SESSION["usern"],$_SESSION["userp"]) || getUserType($_SESSION["usern"]) == 2 ) 
					 	$yorumSil = " | <a href='yorumSil.php?id=".$row_gelen['comID']."' rel='facebox'><img src=\"img/cross.png\" alt=\"delete\" width=\"16\" height=\"16\" border=\"0\" style=\"vertical-align: sub;\"  title=\"$metin[102]\"/> ".$metin[102]."</a>";  
						else
						$yorumSil = "";
				     	$humanRelativeDate = new HumanRelativeDate();
						$insansi = $humanRelativeDate->getTextForSQLDate($row_gelen['commentDate']);
				    $ekle .= "<tr><td><div class='yorumItem'><p style='font-size:16px;padding-bottom:6px;'>".smileAdd($row_gelen['comment'])." </p><a href='profil.php?kim=".$row_gelen['id']."' rel='facebox'>".$row_gelen['userName']."</a> $insansi $yorumSil</div></td></tr>";					
				   }
				   @mysqli_free_result($result1);  
				   return ($ekle);
				}else {
				   return ("");
				}
	return ""; 
}
/*
sayfaKonuDersArama:
ders listeleme sayfası
*/
function sayfaKonuDersArama($gelen){
	global $metin;
	$yol1 = baglan();
	$gelen = temizle(RemoveXSS($gelen));
	$giden = "";
	$sorgu = "SELECT *   
				FROM eo_5sayfa, eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_users 
				WHERE 
				  eo_3ders.id = eo_4konu.dersID and
				  eo_2sinif.id = eo_3ders.sinifID and
				  eo_1okul.id = eo_2sinif.okulID AND
				  eo_5sayfa.konuID = eo_4konu.id AND
				  eo_5sayfa.ekleyenID = eo_users.id AND
					(eo_5sayfa.anaMetin like '%$gelen%'
					 or
					 eo_4konu.konuAdi like '%$gelen%'
					 or
					 eo_3ders.dersAdi like '%$gelen%'
					 or
					 eo_2sinif.sinifAdi like '%$gelen%'
					 or
					 eo_1okul.okulAdi like '%$gelen%'
					 or
					 eo_users.userName like '%$gelen%'
					 or
					 eo_users.realName like '%$gelen%'
					 
					)
				 AND
				eo_5sayfa.cevap=''
				ORDER BY eo_5sayfa.konuID DESC, eo_5sayfa.eklenmeTarihi DESC";

	$sonuc = mysqli_query($yol1,$sorgu);
	if($sonuc){
		$giden = "";
		 while($satir = mysqli_fetch_array($sonuc)) {
			 $calis = "<a href='lessons.php?konu=$satir[2]' ><img src='img/lessons.gif' alt='calis' border='0' style=\"vertical-align: middle;\">";
			 $digerSimgeler = " ".($satir["konuyuKilitle"]?"<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[179]."\" title=\"".$metin[179]."\" />":"")
			 	." ".($satir["sadeceKayitlilarGorebilir"]?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[181]."\" title=\"".$metin[181]."\" />":"")
				." ".($satir["calismaSuresiDakika"]?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"");
			 $bilgi = ' <a href="dersBilgisi.php?ders='.$satir["konuID"].'" rel="facebox"><img src="img/info.png" border="0" style="vertical-align:middle" alt='.$metin[301].' /></a>';	
			$giden .= "<tr><td nowrap='nowrap'>$calis ".smartShort(strip_tags($satir[1]),25)."</a></td><td>".$satir["konuAdi"]." ".$satir["dersAdi"]." (".$satir["okulAdi"]."-".$satir["sinifAdi"].")</td><td align='right' nowrap='nowrap'>$digerSimgeler $bilgi</td></tr>";
		 }
		 $giden .= "";
		}
	return $giden;		
}
/*
isKonu:
kimlik numarasına sahip bir konu var mı?
*/
function isKonu($id){
	 
	$id = substr($id,0,15);
	if(is_numeric($id)){
			$sql1 = "SELECT id FROM eo_4konu where id='".temizle($id)."' limit 0,1";
			
			$yol1 = baglan();
			$result1 = @mysqli_query($yol1,$sql1);
			if ($result1 && @mysqli_num_rows($result1) == 1)
			{   	
			@mysqli_free_result($result1);
			   return true;
			}else {
			   return false;
			}
	}
	return false;
}
/*
dersAdiGetir:
kimlik numarasına ait konunun adını getirir
*/
function dersAdiGetir($id){
	$id = substr($id,0,15);
    $sql1 = "SELECT dersAdi FROM eo_3ders where id='".temizle($id)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {  $sonuc = @mysqli_result($result1, 0, "dersAdi");
	@mysqli_free_result($result1); 	   
       return $sonuc;
    }else {
	   return "";
	}
	
	return "";
}

/*
konuAdiGetir:
kimlik numarasına ait konunun adını getirir
*/
function konuAdiGetir($id){
	$id = substr($id,0,15);
    $sql1 = "SELECT konuAdi FROM eo_4konu where id='".temizle($id)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {  $sonuc = @mysqli_result($result1, 0, "konuAdi");
	@mysqli_free_result($result1); 	   
       return $sonuc;
    }else {
	   return "";
	}
	
	return "";
}
/*
konuYorumSayisiGetir:
konu kimliğindeki yorumların sayısını dönderir
*/
function konuYorumSayisiGetir($id){
	$id = substr($id,0,15);
    $sql1 = "SELECT count(*) as toplam FROM eo_comments where konuID='".temizle($id)."' and active=1";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {  
	    if(@mysqli_result($result1, 0, "toplam")>0)
			$sonuc = " - ". @mysqli_result($result1, 0, "toplam");
		@mysqli_free_result($result1); 	   		
       	return (isset($sonuc))?$sonuc:"";
    }else {
	   return "";
	}
	
	return "";
}
/*
getOgrenciSiniflari
öğrencinin ait olduğu sınıfları getirir
*/
function getOgrenciSiniflari(){
	$usernam = getUserID($_SESSION["usern"],$_SESSION["userp"]); 
	
    $sql1 = "SELECT * FROM eo_sinifogre, eo_2sinif, eo_1okul where eo_sinifogre.userID='".
				temizle($usernam)."' and eo_sinifogre.sinifID = eo_2sinif.id and eo_1okul.id = eo_2sinif.okulID 
				order by eo_2sinif.sinifAdi ";
	
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $ekle .= $row_gelen['sinifAdi']." (".$row_gelen['okulAdi']."), ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysqli_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
}
/*
getpasifYorumlar:
pasif haldeki yorumların sayısını bulur
*/
function getpasifYorumlar(){
    $sql1 = "SELECT count(*) as sayac FROM eo_comments where active <> 1 ";
	
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1 && @mysqli_num_rows($result1) > 0)
				{  $sonuc = @mysqli_result($result1, 0, "sayac")	;
				   @mysqli_free_result($result1);		     
				   return ($sonuc);
				}else {
				   return 0;
				}	
}
/*
sonLoginDakikasi:
kullanıcının son giriş zamanı dakika olarak alınır
*/
function sonLoginDakikasi($adi){
	//son başarılı giriş zamanından dakika olarak fark getir
    $sql1 = "SELECT TIME_TO_SEC(TIMEDIFF(now(),dateTime))/60 AS DiffMinute
			FROM eo_usertrack 
			where 
				userName = '$adi' and
				otherInfo = 'success,Login'
			order by dateTime DESC Limit 0,1 ";
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1 && @mysqli_num_rows($result1) > 0)
				{  //$sonuc = @mysqli_result($result1, 0, "DiffMinute");
					$sonuc = mysqli_fetch_assoc($result1)["DiffMinute"];		
				   @mysqli_free_result($result1);		     
				   return ((int)$sonuc);
				}else {
				   return -1;
				}
}
/*
checkRealUser:
kullanıcının var olup olmadığını kontrol eder
*/
function checkRealUser($usernam, $passwor)
{
	$usernam = substr($usernam,0,15);
	if($usernam=="") return -2;
	if (!validInput($usernam) || !validInput($passwor)) return -2;
	
    $sql1 = "SELECT realName, userName, userPassword, userType FROM eo_users where userName='".temizle($usernam)."' AND userPassword='".temizle($passwor)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {
		$row_gelen = mysqli_fetch_assoc($result1);
		$rn = $row_gelen["realName"];
   	   $_SESSION["userr"] 	= temizle($rn);
	   $sonuc = $row_gelen["userType"];
	   @mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (-2);
	}
}
/*
kullaniciHakSayisi:
konuyu çalışma sayısını bulur
*/
function kullaniciHakSayisi($gelen, $adi, $par){
	
	$kulID = getUserID($adi, $par);
	
    $sql1 = "SELECT count(*) as toplam FROM eo_userworks where userID='$kulID' and konuID='".temizle($gelen)."'";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1)
    {  $sonuc =@mysqli_result($result1, 0, "toplam");
	   @mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}
}
/*
kullAdi:
kullanıcının adı
*/
function kullAdi($id)
{
	global $yol1;	
	$id = substr(temizle($id),0,15);
    $sql1 = "SELECT userName FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && @mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "userName"));
    }else {
	   return ("");
	}
}
/*
getUserType:
kullanıcı türünü bulur, -2 bulunamadı,-1 pasif, 0 öğrenci, 1 öğretmen, 2 yönetici
*/
function getUserType($usernam)
{
	$usernam = substr($usernam,0,15);
    $sql1 = "SELECT userType FROM eo_users where userName='".temizle($usernam)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {	$sonuc = @mysqli_result($result1, 0, "userType");
	@mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (-2);
	}
}
/*
dosyaKimID:
dosya paylaşımındaki kullanıcı kimliği
*/
function dosyaKimID($gelen){
	$gelen = RemoveXSS($gelen);
    $sql1 = "SELECT userID FROM eo_files where id='$gelen' limit 0,1";
	
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1 && @mysqli_num_rows($result1)==1)
				{  $sonuc = @mysqli_result($result1, 0, "userID")	;
				   @mysqli_free_result($result1);		     
				   return ($sonuc);
				}else {
				   return 0;
				}	
}

/*
getUserID:
kullanıcının kimlik numarasını bulur
*/
function getUserID($usernam, $passwor)
{
	$usernam = substr($usernam,0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle($usernam)."' AND userPassword='".temizle($passwor)."' limit 0,1"; 
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    { 
	   $sonuc = @mysqli_result($result1, 0, "id");	
	   @mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (-1);
	}
}
/*
totalGet:
istatistik bilgileri getirir
*/
function totalGet($numa)
{ 
  switch($numa) {
   case "0":  $sql1 = "SELECT count(*) as total FROM eo_users"; break;
   case "1":  $sql1 = "SELECT count(*) as total FROM eo_users where userType='1' or userType='2'"; break;
   case "2":  $sql1 = "SELECT count(*) as total FROM eo_3ders"; break;
   case "3":  $sql1 = "SELECT count(*) as total FROM eo_4konu"; break;
   case "4":  $sql1 = "SELECT count(*) as total FROM eo_5sayfa"; break;
   default : return -1;
   }
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    { 
		$row_gelen = mysqli_fetch_assoc($result1);
		$sonuc = $row_gelen["total"];
		//$sonuc = @mysqli_result($result1, 0, "total");
	@mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}
}
/*
sonUyeAdiGetir:
son üyenin ad ve tarih bilgileri getirir
*/
function sonUyeAdiGetir($alan){
	//alan ad veya tarih olabilir
    $sql1 = "SELECT userName, requestDate FROM eo_users order by requestDate DESC limit 0,1"; 
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    { 
		$row = mysqli_fetch_assoc($result1);
	  if($alan=="ad")
	   $sonuc = $row["userName"];	
	  elseif($alan=="tarih")
	   $sonuc = $row["requestDate"];	
	  else 
	   $sonuc = "";
	   @mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return ("");
	}	
}
/*
getTrackCount:
kötü ve iyi iz sayılarını getirir
*/
function getTrackCount($isBad){
	
	if ($isBad) 	
		$sql1 = "SELECT count(*) as total FROM eo_usertrack where otherInfo like 'fail%'";
	else
		$sql1 = "SELECT count(*) as total FROM eo_usertrack";
	
    $yol1 = baglan();
    $result1 = @mysqli_query($yol1,$sql1);
    if ($result1 && @mysqli_num_rows($result1) == 1)
    {	$sonuc = mysqli_fetch_assoc($result1)["total"];
		@mysqli_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}	
}
/*
GetVar:
global sunucu değişkenleri
*/
function GetVar($name,$default) {
	$ret = "";
    if($var = getenv($name)){
	    $ret = $var;
    	}
	elseif(@$_ENV["$name"]) {
    	$ret = $_ENV["$name"];
    	}
    elseif(@$_SERVER["$name"]) {
    	$ret = $_SERVER["$name"];
    	}
    else {
    	$ret = $default;
    }
    return trim(htmlentities(stripslashes($ret))); 
}
/*
trackUser:
kullanıcı işlemlerini kaydeder
*/
function trackUser($processName, $otherInfo, $userName)
{
	global $yol1;
	
	$CurrentRemoteAddr=GetVar("REMOTE_ADDR", NULL);	
	$datem	=	date("Y-m-d H:i:s"); // CURRENT_TIMESTAMP ??
	
	$processName	=temizle($processName);
	$otherInfo		=temizle($otherInfo);
	$userName		=temizle($userName);
	
	$sql1	= 	"Insert into eo_usertrack VALUES (NULL , '$CurrentRemoteAddr',  CURRENT_TIMESTAMP , '$processName', '$userName', '$otherInfo')";
	$result1= 	@mysqli_query($yol1,$sql1);
	$sonuc =$result1; 
	@mysqli_free_result($result1);
	return $sonuc;
}
/*
trackUserLesson:
çalışma bilgilerini kaydeder
*/
function trackUserLesson($userID, $konuID, $zaman, $sonSayfa)
{
	global $yol1;
	
	$datem	=	date("Y-n-j H:i:s");
	
	$userID		=temizle($userID);
	$konuID		=temizle($konuID);
	$zaman		=temizle($zaman);
	$sonSayfa	=temizle($sonSayfa);
	
	$sql1	= 	"Insert into eo_userworks VALUES (NULL , '$userID', '$konuID' , '$zaman', '$sonSayfa', '$datem')";
	$result1= 	@mysqli_query($yol1,$sql1);
	@mysqli_free_result($result1);
	return $result1;
}
/*
newPassw:
yeni parola üretir
*/
function newPassw()
{
   $seed="";
   for ($i = 1; $i <= 8; $i++)
       $seed .= substr('0123456789abcdefghijklmnoprstuvyz', rand(1,32), 1);
   return ($seed);
}
/*
email_valid:
eposta formatını kontrol eder
*/
function email_valid ($email) {  
	if(preg_match('/^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/',$email))
		return true;
	else
	    return false; 
} 
/*
newParola:
kullanıcıya yeni parola oluşturur
*/
function newParola($userName, $email)
{
	global $yol1;
	
	$result1="";
	
	$userName	=trim(substr(temizle($userName),0,15));
	$email		=trim(substr(temizle($email),0,50));
	
	if (!email_valid($email)) return "notValid";
  
	if ($userName=="" || $email=="") return "emptyData";
	
	$yeni	=	newPassw();
	
	$sql2 		= "select * from eo_users where userName='$userName' and userEmail='$email' limit 0,1";
	$result2	= @mysqli_query($yol1, $sql2);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From:".ayarGetir("ayar4char"). "\r\nReply-To:".ayarGetir("ayar4char"). "\r\n" .
							   'X-Mailer: PHP/' . phpversion();
	
   if ($result2 && @mysqli_num_rows($result2) == 1){
	if (@mail($email, "eOgr Parola", "Merhaba, eOgr projesindeki:\nKullanici Adiniz = $userName \nYeni Parolaniz= $yeni \n Iyi gunler dileriz.", $headers))
	    {         
			$sql1	= 	"Update eo_users SET userPassword='".sha1($yeni)."' where userName='$userName' and userEmail='$email'";
			$result1= 	@mysqli_query($yol1,$sql1);
			if($result1)
			  $result1 = "allOK";
			  else
			  $result1 = "noChange";
		}	else 
		 	$result1="mailErr";
    }   else
	   $result1="noUser";
   @mysqli_free_result($result2);
	return $result1;	
}
/*
newUserMail:
yeni üyelikte site ayarlarındaki yöneticiye mail atılır
*/
function newUserMail($userName, $email)
{
	global $yol1;
	
	$result1="";
	
	$userName	=trim(substr(temizle($userName),0,15));
	$email		=trim(substr(temizle($email),0,50));
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From:".ayarGetir("ayar4char"). "\r\nReply-To:".ayarGetir("ayar4char"). "\r\n" .
							   'X-Mailer: PHP/' . phpversion();
	
	if ($userName=="" || $email=="") return "emptyData";
	
	if (@mail(ayarGetir("ayar4char"), "eOgr Yeni Uye/New User", "eOgr Yeni Uye/New User:\nKullanici Adi = $userName \nEposta Adresi= $email \n Iyi gunler dileriz. ",$headers))
	    {         
			  $result1 = "allOK";
		}	
		else 
		 	$result1="mailErr";
      
	
	return $result1;	
}
/*
getMailAddress:
kullanıcının mail adresini getirir
*/
function getMailAddress($id){	
  if($id=="-1"){
	  return ayarGetir("ayar4char"); 
  }else{    
	global $yol1;
	
	$sql1	= 	"select userEmail from eo_users where id='".$id."' limit 0,1";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	if ($result1)
	    {         
			$result1 = @mysqli_result($result1,0,"userEmail");
		}	     
	@mysqli_free_result($result1);
	return $result1;	
  }
}
/*
addnewUser:
yeni kullanıcı ekler
*/
function addnewUser($realName, $userName, $password, $email, $birth)
{
	global $yol1;

	$datem	=	date("Y-n-j H:i:s");
    
	if (strlen($realName)<5 || strlen($userName)<5 ||  strlen($email)<5 ||  strlen($birth)<5 || strlen($password)<5 ||
		strlen($realName)>30 || strlen($userName)>15 ||  strlen($email)>50 ||  strlen($birth)>10 || strlen($password)>15 ) return false; 
	     
	if ($realName=="" || $userName=="" || $password=="" || $email=="" || $birth=="") return false;

	if (substr_count($password, substr($password,0,1))==strlen($password)) return false; 
	     
	if ( !validInput($userName) || !validInput($password) ) return false;
      
	$realName	=trim(substr(temizle($realName),0,30));
	$userName	=trim(substr(temizle($userName),0,15));
  	$password	=trim(substr(temizle($password),0,15));
	$email		=trim(substr(temizle($email),0,50));
  	$birth		=tarihYap(trim(substr(temizle($birth),0,10)));
	
	$sql1	= 	"Insert into eo_users VALUES (NULL , '$userName', '".sha1($password)."' , '$realName', '$email', '$birth', '0', '$datem','1-1-1-1-1-1-1-1-1-1-1-1-1-1-1-1')";

	$result1= 	@mysqli_query($yol1,$sql1);
	@mysqli_free_result($result1);
	return $result1;
}
/*
grafikGunNormallestirData:
dizideki boş günleri 0 ile doldurur
*/
function grafikGunNormallestirData($dataArray = null,$labelArray = null) {
		$newData = array();
		$newLabel = array();
		
		$baslangic = (int)$labelArray[0];
		$icIndex = 0;
 	    $newLabel[$icIndex] = $labelArray[0];
		$newData[$icIndex] = $dataArray[0];
 	    $icIndex++;	  
		
		for($i=1;$i<sizeof($dataArray);$i++) //kaç eleman var ise dön
		 {
		 	if ( (int)($labelArray[$i]) - $baslangic> 1) //en az 2 gün fark
			  {
				   for($j=0;$j<((int)($labelArray[$i]) - $baslangic - 1 );$j++){
					  if($j + 1 + (int)($baslangic)<10)  
					   $newLabel[$icIndex] = "0". ($j + 1 + (int)($baslangic));
					  else
					   $newLabel[$icIndex] = $j + 1 + (int)($baslangic);
					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  
				   }
				   
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			  elseif ( (int)($labelArray[$i]) - $baslangic == 1) {//1 gün fark varmış yani normal
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
			  } else { //negatif yani 2 - 31 gibi
	
    $last_month = date('m')-1;$year=date('Y');
	$timestamp = strtotime("$year-$last_month-01");    
	$number_of_days = date('t',$timestamp);
	
			    for($j=$baslangic;$j<$number_of_days;$j++){
					   $newLabel[$icIndex] = $j + 1 ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
			    for($j=1;$j<(int)($labelArray[$i]);$j++){
					  if($j<10)  
					   $newLabel[$icIndex] = "0". ($j);
					  else
					   $newLabel[$icIndex] = $j ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
				
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			
			$baslangic = (int)$labelArray[$i];
		 }
		 
        return $newData;
}
/*
grafikGunNormallestirLabel:
dizideki boş günleri 0 ile doldurur
*/
function grafikGunNormallestirLabel($dataArray = null,$labelArray = null) {
		$newData = array();
		$newLabel = array();
		
		$baslangic = (int)$labelArray[0];
		$icIndex = 0;
 	    $newLabel[$icIndex] = $labelArray[0];
		$newData[$icIndex] = $dataArray[0];
 	    $icIndex++;	  
		
		for($i=1;$i<sizeof($dataArray);$i++) //kaç eleman var ise dön
		 {
		 	if ( (int)($labelArray[$i]) - $baslangic> 1) //en az 2 gün fark
			  {
				   for($j=0;$j<((int)($labelArray[$i]) - $baslangic - 1 );$j++){
					  if($j + 1 + (int)($baslangic)<10)  
					   $newLabel[$icIndex] = "0". ($j + 1 + (int)($baslangic));
					  else
					   $newLabel[$icIndex] = $j + 1 + (int)($baslangic);
					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  
				   }
				   
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			  elseif ( (int)($labelArray[$i]) - $baslangic == 1) {//1 gün fark varmış yani normal
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
			  } else { //negatif yani 2 - 31 gibi
	
    $last_month = date('m')-1;$year=date('Y');
	$timestamp = strtotime("$year-$last_month-01");    
	$number_of_days = date('t',$timestamp);
	
			    for($j=$baslangic;$j<$number_of_days;$j++){
					   $newLabel[$icIndex] = $j + 1 ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
			    for($j=1;$j<(int)($labelArray[$i]);$j++){
					  if($j<10)  
					   $newLabel[$icIndex] = "0". ($j);
					  else
					   $newLabel[$icIndex] = $j ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
				
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			
			$baslangic = (int)$labelArray[$i];
		 }
		 
        return $newLabel;
}
/*
getGrafikValues:
grafik değerlerini dizi olarak getirir
*/
function getGrafikValues($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		      $data['values'][] = $row['count'];
		}
		if(count($data)<1)
			return 0;
		else
			return $data['values'];
}
/*
getGrafikLabels:
grafik etiketlerinin dizi olarak getirir
*/
function getGrafikLabels($lmt){
	global $yol1;
	
		$sql = "SELECT DATE_FORMAT(calismaTarihi, '%d') AS date FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		  $data['labels'][] = $row['date'];
		}
		if(count($data)<1)
			return 0;
		else
			return $data['labels'];
}
/*
getGrafikRecordCount:
grafik değerlerinin sayısını getirir
*/
function getGrafikRecordCount(){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks ";
		$result = mysqli_query($yol1,$sql);
		$row = mysqli_fetch_assoc($result);
		return $row['count'];
}
/*
getGrafikValues2:
grafik değerlerini getirir
*/
function getGrafikValues2($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(dateTime, '%d-%m-%y') order by dateTime";
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		      $data['values'][] = $row['count'];
		}
		if(count($data)<1)
			return 0;
		else
			return $data['values'];
}
/*
getGrafikLabels2:
grafik etiketlerini getirir
*/
function getGrafikLabels2($lmt){
	global $yol1;
	
		$sql = "SELECT DATE_FORMAT(dateTime, '%d') AS date FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(dateTime, '%d-%m-%y') order by dateTime";
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		  $data['labels'][] = $row['date'];
		}
		if(count($data)<1)
			return 0;
		else
			return $data['labels'];
}
/*
getGrafikValues3:
belli bir konudaki grafik değerlerini getirir
*/
function getGrafikValues3($lmt,$konu){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt and konuID='$konu' GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		      $data['values'][] = $row['count'];
		}
		if(isset($data['values']))
			return $data['values'];
}
/*
getGrafikLabels3:
belli bir konudaki grafik etiketlerini getirir
*/
function getGrafikLabels3($lmt,$konu){
	global $yol1;
	
		$sql = "SELECT DATE_FORMAT(calismaTarihi, '%d') AS date FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt and konuID='$konu' GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		  $data['labels'][] = $row['date'];
		}
		if(isset($data['labels']))
			return $data['labels'];
}
/*
getGrafikRecordCount2:
grafik değerlerinin sayısını getirir
*/
function getGrafikRecordCount2(){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_usertrack ";
		$result = mysqli_query($yol1,$sql);
		$row = mysqli_fetch_assoc($result);
		return $row['count'];
}
/*
ayTr:
Türkçe ay isimlerini getirir
*/
function ayTr($sayi){
	switch($sayi){
		case 1: return "Ocak";
		case 2: return "Şubat";
		case 3: return "Mart";
		case 4: return "Nisan";
		case 5: return "Mayıs";
		case 6: return "Haziran";
		case 7: return "Temmuz";
		case 8: return "Ağustos";
		case 9: return "Eylül";
		case 10: return "Ekim";
		case 11: return "Kasım";
		case 12: return "Aralık";
	}
}
/*
gunTr:
Türkçe ay isimlerini getirir
*/
function gunTr($gelen){
	switch($gelen){
		case "Mon": return "Pts";
		case "Tue": return "Sal";
		case "Wed": return "Çar";
		case "Thu": return "Per";
		case "Fri": return "Cum";
		case "Sat": return "Cts";
		case "Sun": return "Paz";
	}
}
/*
buTarihtekiOlayListesi:
gelen tarihteki olay özeti
*/
function buTarihtekiOlayListesi($gun,$ay,$yil,$my){
	global $metin;
	$tarih = date("d-m-Y",mktime(0, 0, 0, $ay, $gun, $yil)); 
	$tarih2 = date("Y-m-d",mktime(0, 0, 0, $ay, $gun, $yil)); 
	
	$sonuc = "";
	$say = olayIslemSayisi($tarih2,$my);
	if($say>0)
		$sonuc .= "<span class=\"desc\">$metin[544] : $say</span>";
									
	$say2 = dersIslemSayisi($tarih2,$my);
	if($say2>0)
		$sonuc .= "<span class=\"desc\">$metin[545] : $say2</span>";
		
	$say3 = sonDersCalisma($tarih2);
	if($say3!=""){
		$say3 = explode("|",$say3);
		$liste = "<span class=\"desc\">$metin[381] : ";
		$dersler = "";
		for($i=0;$i<count($say3)-1;$i++)
		  if($i%2==0)
			$dersler .= "<a href='../../lessons.php?konu=".$say3[$i+1]."' target='_parent'>$say3[$i]</a> ";		
		$sonuc .= "$liste $dersler</span>";		
	}
	
	$say4 = buTarihtekiCanliDers($tarih2);
	if($say4!=""){
		$say4 = explode("|",$say4);
		$liste = "<span class=\"desc\">$metin[673] : ";
		$dersler = "";
		for($i=0;$i<count($say4)-1;$i++)
			$dersler .= $say4[$i]." ";		
		$sonuc .= "$liste $dersler</span>";		
	}
	
		
	if ($sonuc=="") 
	  return "";
	 else
	  return "<li><span class=\"title\">$metin[543] : ".$tarih."</span>".$sonuc."</li>";
}
/*
olayIslemSayisi:
bir tarihteki işlem sayısı
*/
function olayIslemSayisi($tarih,$my){
	global $yol1;
	if($my=="&my=0")
		$sql1	= 	"select count(id) as say from eo_usertrack where DATE_FORMAT(dateTime, '%Y-%m-%d') = '$tarih'";
		else
		$sql1	= 	"select count(id) as say from eo_usertrack where DATE_FORMAT(dateTime, '%Y-%m-%d') = '$tarih' and userName='".$_SESSION["usern"]."'";
		
	$result1= 	@mysqli_query($yol1,$sql1);
	if($result1)
		return mysqli_fetch_assoc($result1)["say"];
		//return @mysqli_result($result1,0,"say");
	return 0;
}
/*
dersIslemSayisi:
bir tarihteki ders işlem sayısı
*/
function dersIslemSayisi($tarih,$my){
	global $yol1;
	
	if($my=="&my=0")
		$sql1	= 	"select count(id) as say from eo_userworks where DATE_FORMAT(calismaTarihi, '%Y-%m-%d') = '$tarih'";
		else
		$sql1	= 	"select count(id) as say from eo_userworks where DATE_FORMAT(calismaTarihi, '%Y-%m-%d') = '$tarih' and userID='".getUserID2($_SESSION["usern"])."'";
	$result1= 	@mysqli_query($yol1,$sql1);
	if($result1)
		return mysqli_fetch_assoc($result1)["say"];
		//return @mysqli_result($result1,0,"say");
	return 0;
}
/*
sonDersCalisma:
son çalışma tarihi gelen konu adı
*/
function sonDersCalisma($tarih){
	global $yol1;
	
	$sql1	= 	"select id, konuAdi from eo_4konu where DATE_FORMAT(bitisTarihi, '%Y-%m-%d') = '$tarih'";
	$result1= 	@mysqli_query($yol1,$sql1);
	if($result1){
		$ekle = "";
		while($gelen = @mysqli_fetch_array($result1)) {
			$ekle .= $gelen["konuAdi"]."|".$gelen["id"]."|";
			}
		return $ekle;
	}
	return 0;
}
/*
buTarihtekiCanliDers:
takvime canlı ders ekleme
*/
function buTarihtekiCanliDers($tarih){	
	global $yol1;
	
	$sql1	= 	"select eo_3ders.dersAdi 
			from eo_3ders,eo_livelesson			 
			where DATE_FORMAT(dateWhen, '%Y-%m-%d') = '$tarih'
				and 
				  eo_3ders.id=eo_livelesson.dersID	
			";
	$result1= 	@mysqli_query($yol1,$sql1);
	if($result1){
		$ekle = "";
		while($gelen = @mysqli_fetch_array($result1)) {
			$ekle .= $gelen["dersAdi"]."|";
			}
		return $ekle;
	}
	return 0;
}
/*
okulAdlari:
okul adları getirilir
*/
function okulAdlari(){
	global $yol1;
	
	$sql1	= 	"select id,okulAdi from eo_1okul order by okulAdi";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	$i=0;
	$sonuc="";
	while($i<@mysqli_num_rows($result1)) 
	{
		$sonuc .= "<a href='#' id='".@mysqli_result($result1,$i,"id")."'>".@mysqli_result($result1,$i,"okulAdi")."</a>";
		$i++;
	}
	@mysqli_free_result($result1);
	return $sonuc;	
}
/*
sinifAdlari:
sınıf adları getirilir
*/
function sinifAdlari($id){
	global $yol1;
	if($id=="all")
		$sql1	= 	"select id,sinifAdi from eo_2sinif order by sinifAdi";
	 else
		$sql1	= 	"select id,sinifAdi from eo_2sinif where okulID='".RemoveXSS($id)."' order by sinifAdi";
	 	
	$result1= 	@mysqli_query($yol1,$sql1);
	
	$i=0;
	$sonuc="";
	while($i<@mysqli_num_rows($result1)) 
	{
		$sonuc .= "<a href='#' id='".@mysqli_result($result1,$i,"id")."'>".@mysqli_result($result1,$i,"sinifAdi")."</a>";
		$i++;
	}
	@mysqli_free_result($result1);
	return $sonuc;	
}
/*
dersAdlari:
ders adları getirilir
*/
function dersAdlari($id,$nereden=""){
	global $yol1;
	
	if($id=="all")
		$sql1	= 	"select id,dersAdi from eo_3ders order by dersAdi";
	else if($nereden == "0")
		$sql1	= 	"select id,dersAdi from eo_3ders where sinifID='".RemoveXSS($id)."' order by dersAdi";
	else if($nereden == "1")
		$sql1	= 	"select eo_3ders.id,eo_3ders.dersAdi from eo_3ders,eo_2sinif 
					where
					 eo_3ders.sinifID = eo_2sinif.id and	 
					 eo_2sinif.okulID='".RemoveXSS($id)."' 
					order by eo_3ders.dersAdi";
		
	$result1= 	@mysqli_query($yol1,$sql1);
	
	$i=0;
	$sonuc="";
	while($i<@mysqli_num_rows($result1)) 
	{
		$sonuc .= "<a href='#' id='".@mysqli_result($result1,$i,"id")."'>".@mysqli_result($result1,$i,"dersAdi")."</a>";
		$i++;
	}
	@mysqli_free_result($result1);
	return $sonuc;	
}
/*
konuAdlari:
konu adları getirilir
*/
function konuAdlari($id,$nereden=""){
	global $yol1,$metin;
	
	if($id=="all")
		$sql1	= 	"select id,konuAdi,sadeceKayitlilarGorebilir from eo_4konu order by konuAdi";
	else if($nereden=="0")
		$sql1	= 	"select id,konuAdi,sadeceKayitlilarGorebilir from eo_4konu where dersID='".RemoveXSS($id)."' order by konuAdi";
	else if($nereden=="1")
		$sql1	= 	"select eo_4konu.id,eo_4konu.konuAdi,eo_4konu.sadeceKayitlilarGorebilir 
				from eo_4konu, eo_3ders 
				where 
					eo_4konu.dersID = eo_3ders.id and
					eo_3ders.sinifID='".RemoveXSS($id)."' 
				order by eo_4konu.konuAdi";
	else if($nereden=="2")
		$sql1	= 	"select eo_4konu.id,eo_4konu.konuAdi,eo_4konu.sadeceKayitlilarGorebilir  
				from eo_4konu, eo_3ders, eo_2sinif
				where 
					eo_4konu.dersID = eo_3ders.id and
					eo_3ders.sinifID = eo_2sinif.id and
					eo_2sinif.okulID='".RemoveXSS($id)."' 
				order by eo_4konu.konuAdi";
		
	$result1= 	@mysqli_query($yol1,$sql1);
	
	$i=0;
	$sonuc="";
	while($i<@mysqli_num_rows($result1)) 
	{
		if(@mysqli_result($result1,$i,"sadeceKayitlilarGorebilir")==1)
		 	$kayitliSimgesi = "<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />";
		 else
		 	$kayitliSimgesi = "";	
		$sonuc .= "<a href='lessons.php?konu=".@mysqli_result($result1,$i,"id")."'>$kayitliSimgesi ".@mysqli_result($result1,$i,"konuAdi")."</a>";
		$i++;
	}
	@mysqli_free_result($result1);
	return $sonuc;	
}
/*
getSchoolNames:
okul isimlerini getirir
*/
function getSchoolNames()
{
	global $yol1;
	
	$sql1	= 	"select id,okulAdi from eo_1okul order by okulAdi";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	$i=0;
	$sonuc="";
	while($i<@mysqli_num_rows($result1)) 
	{
		$sonuc .= "<option value='".@mysqli_result($result1,$i,"id")."'>".@mysqli_result($result1,$i,"okulAdi")."</option>";
		$i++;
	}
	@mysqli_free_result($result1);
	return $sonuc;
}
/*
checkUserName:
kullanıcı adının varlığını kontrol eder
*/
function checkUserName($name)
{
	global $yol1;
	
	$sql1	= 	"select count(*) as adet from eo_users where userName='".temizle($name)."'";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	if(@mysqli_num_rows($result1)>0){
  	 if(@mysqli_result($result1,0,"adet")==0) {	
	  @mysqli_free_result($result1);
	  return false;
	 }
	 else
  		return true;
	}else
	return false;
}
/*
getUserID2:
kullanıcının kimlik numarasını getirir
*/
function getUserID2($name){
	global $yol1;
	
	$sql1	= 	"select id from eo_users where userName='".temizle($name)."'";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	if(@mysqli_num_rows($result1)>0)
		return mysqli_fetch_assoc($result1)["id"];
	 	//return @mysqli_result($result1,0,"id");
	 else
  		return "";	
}
/*
getKonuAdi:
kimlik bilgisi ile konunun adını getirir
*/
function getKonuAdi($id){
	global $yol1;
	
	$sql1	= 	"select konuAdi from eo_4konu where id='".temizle($id)."'";
	$result1= 	@mysqli_query($yol1,$sql1);
	
	if(@mysqli_num_rows($result1)>0)
	 	return @mysqli_result($result1,0,"konuAdi");
	 else
  		return "";	
}
/*
checkEmail:
kullanıcı mail adresinin kontrol edilmesi
*/
function checkEmail($name)
{
	global $yol1;
	
	$sql1	= 	"select count(*) as adet from eo_users where userEmail='".temizle($name)."'";
	$result1= 	@mysqli_query($yol1,$sql1);
	
   if(@mysqli_num_rows($result1)>0){
		if(@mysqli_result($result1,0,"adet")==0)	
		 return false;
		else
		 return true;		
   }else
  		return false;
}
/*
checkKonu:
konu adı ile kimlik bilgisini bulma
*/
function checkKonu($name)
{
	global $yol1;
	
	$sql1	= 	"select id from eo_4konu where konuAdi='".temizle($name)."'";

	$result1= 	@mysqli_query($yol1,$sql1);

   if(@mysqli_num_rows($result1)>0)
	return (@mysqli_result($result1,0,"id")==""?"":@mysqli_result($result1,0,"id"));
	else
	return "";
}
/*
sayfaGetir:
bir konudaki istenen sayfanın ana metnini getirme
*/
function sayfaGetir($konuID, $sayfaNo)
{
	global $yol1;
	
	$sql1	= 	"select id,anaMetin from eo_5sayfa where konuID='".temizle($konuID)."' order by id";
	$result1= 	@mysqli_query($yol1,$sql1);

   if(@mysqli_num_rows($result1)>0){
	if(@mysqli_result($result1,0,"id")!="")
		$msg = html_entity_decode(@mysqli_result($result1,$sayfaNo,"anaMetin"));
	}else	
		$msg = "<font id='uyari'>Bir konu se&ccedil;iniz...</font>";			 
   
   @mysqli_free_result($result1);
	return $msg;
}
/*
siteAc:
sitenin ayarlarındaki aktivasyon
*/
function siteAc(){
	global $yol1;
	
	$sql1	= 	"select ayar5char from eo_sitesettings where id=1"; 
	$result1= 	@mysqli_query($yol1,$sql1);

   if(@mysqli_num_rows($result1)>0){
	if(@mysqli_result($result1,0,"ayar5char")!="")
		$sonuc = explode("-",@mysqli_result($result1,0,"ayar5char"));
		$sonuc[15]="0"; //site açık ise 0
		$sonuc = implode("-",$sonuc);
		
		$updateSQL = sprintf("UPDATE eo_sitesettings SET ayar5char='%s' WHERE id=1",$sonuc);
		$result2= 	@mysqli_query($yol1,$updateSQL);
		return $result2;		
	}			 

   @mysqli_free_result($result1);
   return false;	
}
/*
ayarGetir:
global site ayarlarının getirilmesi
*/
function ayarGetir($ayarAdi){
	global $yol1;
	
	$sql1	= 	"select ".temizle($ayarAdi)." from eo_sitesettings where id=1"; 

	$result1= 	mysqli_query($yol1, $sql1);
	
	echo mysqli_error($yol1);

   if(mysqli_num_rows($result1)>0){
		$row = mysqli_fetch_assoc($result1);
		if($row["$ayarAdi"]!="") $sonuc = $row["$ayarAdi"];
	}else	
		$sonuc = "";			 
   
   @mysqli_free_result($result1);
	return $sonuc;
}
/*
ayarGetir2:
rss için istenen site ayarlarının getirilmesi
*/
function ayarGetir2($ayarAdi)
{
	global $yol1;
	
	$sql1	= 	"select ".temizle($ayarAdi)." from eo_webref_rss_details where id=1";
	$result1= 	@mysqli_query($yol1,$sql1);

   if(@mysqli_num_rows($result1)>0){
	if(@mysqli_result($result1,0,"$ayarAdi")!="")
		$sonuc = @mysqli_result($result1,0,"$ayarAdi");
	}else	
		$sonuc = "";			 
   
   @mysqli_free_result($result1);
	return $sonuc;
}
/*
ayarGetir3:
kullanıcının site ayarlarının getirilmesi
*/
function ayarGetir3($adi)
{
	global $yol1;
	
	$sql1	= 	"select ayarlar from eo_users where userName='$adi'";
	 
	$result1= 	mysqli_query($yol1,$sql1);

   if(@mysqli_num_rows($result1)>0){
	   $row 	= mysqli_fetch_assoc($result1);
	if($row["ayarlar"]!="")
		$sonuc = $row["ayarlar"];
		else	
		$sonuc = "1-1-1-1-1-1-1-1-1-1-1-1-1-1-1-1";
	}else	
		$sonuc = "1-1-1-1-1-1-1-1-1-1-1-1-1-1-1-1";			 

   @mysqli_free_result($result1);
	return $sonuc;
}
/*
haberGetir:
rss haber içeriğinin getirilmesi
*/
function haberGetir($kayno, $alanAdi)
{
	global $yol1;
	
	$sql1	= 	"select ".temizle($alanAdi)." FROM eo_webref_rss_items	ORDER BY pubDate DESC LIMIT 1 OFFSET ".temizle($kayno);
	$result1= 	@mysqli_query($yol1,$sql1);
	$row 	= mysqli_fetch_assoc($result1);
	return $row["$alanAdi"];
}
/*
smartShort:
... noktalarının eklenmesi
*/
function smartShort($gelen,$boyut=20){
	return (strlen($gelen)>$boyut)?mb_substr($gelen,0,$boyut-3)."...":$gelen;
}
/*
getDersIDileSinif:
ders kimliğinden sınıf kimliği bulma
*/
function getDersIDileSinif($gelen){
	$sql1 = "SELECT distinct eo_2sinif.id as id FROM eo_4konu 
	 		inner join eo_5sayfa on eo_4konu.id=eo_5sayfa.konuID 
	 		inner join eo_3ders on eo_4konu.dersID=eo_3ders.id 
			inner join eo_2sinif on eo_2sinif.id=eo_3ders.sinifID 
			where eo_4konu.id=".$gelen;
			
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1)
		  if (@mysqli_num_rows($result1)>0)
		   return (@mysqli_result($result1,0,"id"));
@mysqli_free_result($result1);
return "0";			
}
/*
ogrenciSinifaDahil:
öğrencinin sınıfa dahil olduğunu kontrol eder
*/
function ogrenciSinifaDahil($adi, $par, $gelen){
	$ogrID = getUserID($adi,$par);
	
    $sql1 = "SELECT count(*) as toplam FROM eo_sinifogre where eo_sinifogre.userID='".
			 $ogrID."' and eo_sinifogre.sinifID = ".getDersIDileSinif($gelen) ;
	
    $yol1 = baglan();
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1){
		   return (@mysqli_result($result1,0,"toplam"));
		}
@mysqli_free_result($result1);
return "0";
}
/*
dersAgaci:
menü ve ders sayfasındaki ders ağacının yapımı
*/
function dersAgaci($gelen=null){
	global $yol1;
	global $metin;
	
	if (!isset($gelen)) {
					
					$sqlOkul 	= "select * from eo_1okul order by okulAdi";
					$okulAdlari = mysqli_query($yol1,$sqlOkul);
					$i=0;if(@mysqli_num_rows($okulAdlari)>0)echo "<ul>";
					while($i<@mysqli_num_rows($okulAdlari)){
				?>
				
				<li  style='list-style-type:none;' title='<?php echo @mysqli_result($okulAdlari,$i,"okulAdi")?>'><a href="#"><span><span style="font-family:'Lucida Console', Monaco, monospace;margin-left:0px;padding-left:0px;">
				  <?php 
				    echo smartShort(@mysqli_result($okulAdlari,$i,"okulAdi"));
					$boyut=20-strlen(smartShort(@mysqli_result($okulAdlari,$i,"okulAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
                  </span></span>
                  </a>
				  
					<?php
								$sqlSinif 	= "select * from eo_2sinif where okulID = '".@mysqli_result($okulAdlari,$i,"id")."' order by sinifAdi";
								$sinifAdlari = mysqli_query($yol1,$sqlSinif);
								$j=0;
								if(@mysqli_num_rows($sinifAdlari)>0) echo "<ul>";
								while($j<@mysqli_num_rows($sinifAdlari)){		   
						   ?>
					<li title='<?php echo @mysqli_result($sinifAdlari,$j,"sinifAdi")?>'><a href="#"><span><span style="font-family:'Lucida Console', Monaco, monospace">
					  <?php
					 echo smartShort(@mysqli_result($sinifAdlari,$j,"sinifAdi")); 
					$boyut=20-strlen(smartShort(@mysqli_result($sinifAdlari,$j,"sinifAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
					  </span></span></a>
					  
						<?php
										$sqlDers 	= "select * from eo_3ders where sinifID = '".@mysqli_result($sinifAdlari,$j,"id")."' order by dersAdi";
										$dersAdlari = mysqli_query($yol1,$sqlDers);
										$k=0;
										if(@mysqli_num_rows($dersAdlari)>0) echo "<ul>";
										while($k<@mysqli_num_rows($dersAdlari)){		   
									?>
						<li title='<?php echo @mysqli_result($dersAdlari,$k,"dersAdi")?>'><a href="#"><span><span style="font-family:'Lucida Console', Monaco, monospace">
					  <?php
					 echo smartShort(@mysqli_result($dersAdlari,$k,"dersAdi")); 
					$boyut=20-strlen(smartShort(@mysqli_result($dersAdlari,$k,"dersAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
						  </span></span></a>
						  
						  <?php
										$sqlKonu 	= "select * from eo_4konu where dersID = '".@mysqli_result($dersAdlari,$k,"id")."' order by konuAdi";
										$konuAdlari = mysqli_query($yol1,$sqlKonu);
										$l=0;
										if(@mysqli_num_rows($konuAdlari)>0) echo "<ul>";
										while($l<@mysqli_num_rows($konuAdlari)){		   
												$sqlSayfa 	= "select count(*) as toplam from eo_5sayfa where konuID = '".
														@mysqli_result($konuAdlari,$l,"id")."'";
												$sayfaSayisi = mysqli_query($yol1,$sqlSayfa);
												$s_sayisi = mysqli_result($sayfaSayisi,0,"toplam");													   						  ?>
										<li title='<?php echo @mysqli_result($konuAdlari,$l,"konuAdi")?>'><a href="lessons.php?konu=<?php echo @mysqli_result($konuAdlari,$l,"id")?>" style=""><span><span style="font-family:'Lucida Console', Monaco, monospace">
										  <?php echo smartShort(@mysqli_result($konuAdlari,$l,"konuAdi"))?>
						  <?php echo (mysqli_result($konuAdlari,$l,"konuyuKilitle")?"<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />":"")?>
                          <?php echo (mysqli_result($konuAdlari,$l,"sadeceKayitlilarGorebilir")?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />":"")?>
                          <?php echo (mysqli_result($konuAdlari,$l,"calismaSuresiDakika")?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"")?>
                          <?php 
						  if($s_sayisi==0) 
						     echo "<img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[209]."\" title=\"".$metin[209]."\" />";
						  ?>
										  </span></span></a>
										  </li>
						  <?php
											$l++;
											}
											if(@mysqli_num_rows($konuAdlari)>0) echo "</ul>";
						  ?>

						</li>
						<?php
										$k++;
										}
										if(@mysqli_num_rows($dersAdlari)>0) echo "</ul>";
									?>
					  
					</li>
					<?php
								$j++;
								}
								if(@mysqli_num_rows($sinifAdlari)>0) echo "</ul>";
							?>
				</li>
				<?php	
						$i++;
					}	
					if(@mysqli_num_rows($okulAdlari)>0) echo "</ul>";
	}else
	{//not in the menu Lesson List
					
					$sqlOkul 	= "select * from eo_1okul order by okulAdi";
					$okulAdlari = mysqli_query($yol1, $sqlOkul);
					$i=0;if(@mysqli_num_rows($okulAdlari)>0) echo "<ul id='lessonTree' class='treeview-famfamfam'>";
					while($i<@mysqli_num_rows($okulAdlari)){
				?>
				
				<li style="color:#C0F;" class="open">
				  <span><?php echo (@mysqli_result($okulAdlari,$i,"okulAdi"))?> </span>
				  
					<?php
								$sqlSinif 	= "select * from eo_2sinif where okulID = '".@mysqli_result($okulAdlari,$i,"id")."' order by sinifAdi";
								$sinifAdlari = mysqli_query($yol1, $sqlSinif);
								$j=0;
								if(@mysqli_num_rows($sinifAdlari)>0) echo "<ul>";
								while($j<@mysqli_num_rows($sinifAdlari)){		   
						   ?>
					<li style="color:#C0F" >
                    <span>
					  <?php echo (@mysqli_result($sinifAdlari,$j,"sinifAdi"))?> </span>
						<?php
										$sqlDers 	= "select * from eo_3ders where sinifID = '".@mysqli_result($sinifAdlari,$j,"id")."' order by dersAdi";
										$dersAdlari = mysqli_query($yol1,$sqlDers);
										$k=0;
										if(@mysqli_num_rows($dersAdlari)>0) echo "<ul>";										
										while($k<@mysqli_num_rows($dersAdlari)){		   
									?>
						<li style="color:#C0F">
						  <span><?php echo (@mysqli_result($dersAdlari,$k,"dersAdi"))?> </span>
						  
						  <?php
										$sqlKonu 	= "select * from eo_4konu where dersID = '".@mysqli_result($dersAdlari,$k,"id")."' order by konuAdi";
										$konuAdlari = mysqli_query($yol1,$sqlKonu);
										$l=0;
							if(@mysqli_num_rows($konuAdlari)>0) echo "<ul>";
										while($l<@mysqli_num_rows($konuAdlari)){		   
												$sqlSayfa 	= "select count(*) as toplam from eo_5sayfa where konuID = '".
														@mysqli_result($konuAdlari,$l,"id")."'";
												$sayfaSayisi = mysqli_query($yol1,$sqlSayfa);
												$s_sayisi = mysqli_result($sayfaSayisi,0,"toplam");												   
						  ?>
										<li class="noktasiz"><span><a href="lessons.php?konu=<?php echo @mysqli_result($konuAdlari,$l,"id")?>" style="text-decoration:none;color:#00F;">
										  <?php echo (@mysqli_result($konuAdlari,$l,"konuAdi"))?></a>&nbsp;
                          <?php  if(mysqli_result($konuAdlari,$l,"konuyuKilitle")) echo "<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />";?>
                          <?php echo (mysqli_result($konuAdlari,$l,"sadeceKayitlilarGorebilir")?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />":"")?>
                          <?php echo (mysqli_result($konuAdlari,$l,"calismaSuresiDakika")?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"")?>
                          <?php 
						  if($s_sayisi==0) 
						     echo "<img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[209]."\" title=\"".$metin[209]."\" />";
						  ?>
                          <?php echo "<a href='dersBilgisi.php?ders=".@mysqli_result($konuAdlari,$l,"id")."' rel='facebox'><img src='img/info.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"info\" title=\"info\" /></a>";?></span>
										  
										  </li>
						  <?php
											$l++;
											}
											if(@mysqli_num_rows($konuAdlari)>0) echo "</ul>";
						  ?>
						</li>
						<?php
										$k++;
										}
										if(@mysqli_num_rows($dersAdlari)>0) echo "</ul>";
									?>
					</li>
					<?php
								$j++;
								}
								if(@mysqli_num_rows($sinifAdlari)>0) echo "</ul>";
							?>
				</li>
				<?php	
						$i++;
					}	
					if(@mysqli_num_rows($okulAdlari)>0) echo "</ul>";
	}
}
/*
getCevapSay:
bir sayfadaki çoklu seçim sorularında doğru cevabının sayısı
*/
function getCevapSay($id){
	global $yol1;	
	
    $sql1 = "SELECT cevap FROM eo_5sayfa where id='$id' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 
	
    if ($result1 && @mysqli_num_rows($result1) == 1){
		$gelen = @mysqli_fetch_array($result1);
		$say = explode(",",$gelen[0]);
		return count($say);
	}
	
	return 0;
}
/*
getKonuUserStat:
kullanıcının bir konudaki istatistik bilgisi
*/
function getKonuUserStat($konuID, $uID, $type){
	global $yol1;	
	
	switch($type){
	case 1:
	    $sql1 = "SELECT MAX(lastPage) FROM eo_userworks where userID='$uID' and konuID='$konuID'"; 	
    	$result1 = mysqli_query($yol1,$sql1); 
		$gelen = @mysqli_fetch_array($result1);
		return $gelen[0];	
	 break;
	case 2:
	    $sql1 = "SELECT SUM(toplamZaman) FROM eo_userworks where userID='$uID' and konuID='$konuID'"; 	
    	$result1 = mysqli_query($yol1,$sql1); 
		$gelen = @mysqli_fetch_array($result1);
		return $gelen[0];	
	 break;
	case 3:
	    $sql1 = "SELECT COUNT(*) FROM eo_userworks where userID='$uID' and konuID='$konuID'"; 	
    	$result1 = mysqli_query($yol1,$sql1); 
		$gelen = @mysqli_fetch_array($result1);
		return $gelen[0];	
	 break;
	default:
	 return "-"; 
	}
}
/*
rankGrafik:
derecelendirme grafiği
*/
function rankGrafik($val,$max){
	if(empty($max) or $max==0) return;
//	if($val<15) return;
	echo "<p>";
	$graph = new BAR_GRAPH("pBar");
//	$graph->labels = "Sıra";
//	$graph->barBGColor = "#ccc";
	$graph->barColors = "img/h_blue.gif";
	$graph->values = "$val;$max";
	$graph->percValuesDecimals = 1;
	$graph->barWidth = 10;
	$graph->barLength = 1;
	$graph->barBorder = "0px groove gray";
	echo $graph->create();
	echo "</p>";
}
/*
getKursTablo:
çalışılan ders ile ilgili tablo yapımı
*/
function getKursTablo($dersID,$uID){
	global $yol1,$metin;	
	
    $sql1 = "SELECT id,konuAdi FROM eo_4konu where dersID='$dersID' order by konuAdi"; 	
    $result1 = mysqli_query($yol1,$sql1); 
	
    if ($result1 && @mysqli_num_rows($result1) > 0){
		$sonuc = '<table width="%99" border="0" align="center" cellpadding="5" cellspacing="0">';
		$sonuc .= "<tr>
		         	<th width='%50'>$metin[364]</th>
					<th width='%15'>$metin[504]</th>
					<th width='%15'>$metin[505]</th>
					<th width='%15'>$metin[506]</th>
					<th width='%5'>$metin[507]</th></tr>";

		$satirRenk = 0;
		$bitenler = 0;
		$tamamOlamayan = 0;
		$toplamKonu = getDerstekiKonuSay($dersID);

		while($gelen = @mysqli_fetch_array($result1)){
			$satirRenk++;
				if ($satirRenk & 1) { 
					$row_color = "#CCC"; 
					} else { 
					$row_color = "#ddd"; 
					}
			
			if(getKonuUserStat($gelen[0], $uID, 1))	{
				$yuzde = getKonuUserStat($gelen[0], $uID, 1);	
				$sure = getKonuUserStat($gelen[0], $uID, 2);	
				$calSay = getKonuUserStat($gelen[0], $uID, 3);	
				}
			  else {
				$yuzde = "0";
				$sure = "0";
				$calSay = "0";
			  }
				
			if($yuzde=="100"){ 
			  $bitenler++;
			  if($sure>=getStats(9))
			  //yüzde 100 bitirmiş ve süresi iyi
				$durum = "<img src='img/i_low.png' alt='good' title='$metin[511]'/>";	
			  else {
			  //yüzde 100 ama süresi düşük
			    $durum = "<img src='img/i_medium.png' alt='doubt' title='$metin[513]'/>";
				$tamamOlamayan++;
			  }
			}else
			  //yüzdesi 100 değilse
			   $durum  = "<img src='img/i_high.png' alt='bad' title='$metin[512]' />";				   			   
			
			$sonuc .= '<tr>
			           <td align="left" style="background-color:'.$row_color.';">
 					   <a href=\'dersBilgisi.php?ders='.$gelen[0].'\' rel=\'facebox\'>'.$gelen[1].'</a>				   					   </td>
					   <td align="right" style="background-color:'.$row_color.';">'.$yuzde.'</td>
					   <td align="right" style="background-color:'.$row_color.';">'.Sec2Time2(round($sure)).'</td>
					   <td align="right" style="background-color:'.$row_color.';">'.$calSay.'</td>
					   <td align="center" style="background-color:'.$row_color.';">'.$durum.'</td>
					   </tr>';
		}
		$sonuc .= "</table>";
		
		if($toplamKonu==$bitenler) {
			$sonuc .=  "<h5>$metin[509]</h5>";
			}
		 else if($bitenler!=0) {
		 	$sonuc .=  "<p><strong>$metin[508] :</strong> %".
						round($bitenler*100/$toplamKonu)."</p>";
		 }

		if($tamamOlamayan>0)
		  	$sonuc .= sprintf("<sub>$metin[510]</sub>",$tamamOlamayan,
			  			Sec2Time2(round(getStats(9)))
						);
		 
		return $sonuc;
	}
	
	return "-";
}
/*
eraseOlderTracks:
geçen yıllara ait kullanıcı veri hareketleri silinir
*/
function eraseOlderTracks(){
	global $yol1;	
	$say=0;		
    $sql1 = "DELETE FROM eo_usertrack WHERE DATE_FORMAT(NOW(),'%Y')-DATE_FORMAT(dateTime, '%Y')>0"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
	return $say;
}
/*
lessonPageFix:
&amp; &gt; simgeleri & ve < yapılır
*/
function lessonPageFix(){
	global $yol1;	
	$say=0;
		
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&amp;','&')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&lt;','<')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&gt;','>')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&quot;','\"')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&apos;','`')"; 
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#65533;','`')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#8220;','\"')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#8221;','\"')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#8216;','`')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#8217;','`')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'&#8230;','...')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'…','...')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'”','\"')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'“','\"')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'‘','`')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'’','`')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'–','-')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);
    $sql1 = "UPDATE eo_5sayfa SET anaMetin=REPLACE(anaMetin,'—','-')"; 	
    $result1 = mysqli_query($yol1,$sql1); 
    if ($result1) $say+=mysqli_affected_rows($yol1);	
	return $say;
}
/*
odaCevir:
gelen numaraya göre oda ismini getirir
*/
function odaGetir($gelen){
	global $metin;
	   if ($gelen==0) return $metin[97]; else
	   if ($gelen==1) return "$metin[98]1"; else
	   if ($gelen==2) return "$metin[98]2"; else
	   if ($gelen==3) return "$metin[98]3"; else
	   if ($gelen==4) return "$metin[98]4"; else
	   if ($gelen==5) return "$metin[98]5"; else
	   if ($gelen==6) return "$metin[98]6"; else
	   if ($gelen==7) return "$metin[98]7"; else
	   if ($gelen==9) return "$metin[98]9"; else
	   if ($gelen==8) return "$metin[98]8";
}
/*
sonTarihGetir:
bir tablodan bugünün tarihine göre işlem var ise TRUE döner
*/
function sonTarihGetir($tablo,$gun){
	global $yol1,$_uploadFolder;	
	$sonuc = false;
//	$bugun = date("d-m-Y");
	$bugun = date('d-m-Y', time()-($gun*86400));
		
	switch($tablo){
		case "oy":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_rating
					 WHERE DATE_FORMAT(rateDate, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "yorum":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_comments
					 WHERE DATE_FORMAT(commentDate, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "sohbet":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_shoutbox
					 WHERE DATE_FORMAT(date, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "uye":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_users
					 WHERE DATE_FORMAT(requestDate, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "ders":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_5sayfa
					 WHERE DATE_FORMAT(eklenmeTarihi, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "haber":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_webref_rss_items
					 WHERE DATE_FORMAT(pubDate, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "islem":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_usertrack
					 WHERE DATE_FORMAT(dateTime, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "calis":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_userworks
					 WHERE DATE_FORMAT(calismaTarihi, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "arkadas":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_friends
					 WHERE DATE_FORMAT(davetTarihi, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "soru":
			$sql1 = "SELECT count(*) as say 
					 FROM eo_askquestion
					 WHERE DATE_FORMAT(eklenmeTarihi, '%d-%m-%Y') = '$bugun'"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);						
				$sonuc = $gelen['say']>0;				
			}		
		break;
		case "dosya":
			$sonuc = sonDosyaTarihi($_uploadFolder);		
		break;
	}
	return $sonuc;
}
/*
sonDosyaTarihi:
klasör içindeki dosyalardan birinin tarihi bugün ile eşit ise TRUE
*/
function sonDosyaTarihi($dir) {
if (substr($dir, strlen($dir)-1, 1)!= '/')
$dir .= '/';

if ($handle = @opendir($dir)) {
	$i = 0;
	while ($obj = readdir($handle)) {
		if ($obj!= '.' and $obj!= '..')
				if (is_file($dir.$obj) and !($obj== 'index.php' or $obj== '.htaccess')) {
					$i++;
					//if ($i>1000) return false; //zaman aşımı gibi, çok dosya oldu bile
						$dTarih = date ("d-m-Y", filemtime($dir.$obj));
						$sTarih = date("d-m-Y");
						if($dTarih==$sTarih) return true;
					}			
	}
		closedir($handle);
		return false;
	}
return false;
}
/*
enFazlaIslemGetir:
Sayfa olarak en fazla yapılan işlem ve hata sayıları
*/
function enFazlaIslemGetir($islem){
	global $yol1;
	$sonuc = "";
	switch($islem){
		case "1":
			$sql1 = "SELECT processName, count(processName) as say 
					 FROM eo_usertrack
					 GROUP BY processName						
					 ORDER BY say DESC 
					 LIMIT 0,5"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1){
				while($gelen = @mysqli_fetch_array($result1)){				
					$sonuc .= "<a href='$gelen[0]'>".$gelen[0]."($gelen[1])</a> ";				
				}
			}							
		break;
		case "2":
			$sql1 = "SELECT processName, count(processName) as say 
					 FROM eo_usertrack
					 WHERE otherInfo like 'fail%'
					 GROUP BY processName						
					 ORDER BY say DESC 
					 LIMIT 0,5"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1){
				while($gelen = @mysqli_fetch_array($result1)){				
					$sonuc .= "<a href='$gelen[0]'>".$gelen[0]."($gelen[1])</a> ";				
				}
			}	
		break;		
	}
	return $sonuc;
}
/*
sonSatirGetir:
bir tablodan tarihe göre en son işlem satırı getirir
*/
function sonSatirGetir($tablo){
	global $yol1,$metin,$_uploadFolder;	
	$sonuc = "";
	$humanRelativeDate = new HumanRelativeDate();
		
	switch($tablo){
		case "oy":
			$sql1 = "SELECT * 
					 FROM eo_rating
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_rating.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_rating.konuID					 
					 ORDER BY eo_rating.rateDate DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){				
				$gelen = @mysqli_fetch_array($result1);			
					
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[4]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[5]' rel='facebox'>".$gelen[6]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[14]' rel='facebox'>".$gelen[15]."</a>, "
					.yildizYap($gelen[3]).", "
					.$insansi;
			}		
		break;
		case "yorum":
			$sql1 = "SELECT * 
					 FROM eo_comments
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_comments.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_comments.konuID					 
					 ORDER BY eo_comments.commentDate DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[4]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[7]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.smileAdd(smartShort($gelen[3])).", "
					.$insansi;
			}		
		break;
		case "sohbet":
			$sql1 = "SELECT * 
					 FROM eo_shoutbox
					 INNER JOIN eo_users 
					 ON eo_users.userName  = eo_shoutbox.name					 
					 ORDER BY eo_shoutbox.date DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[5]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[6]' rel='facebox'>".$gelen[1]."</a>, "
					.smileAdd(smartShort($gelen[3])).", "
					.odaGetir($gelen[4]).", "
					.$insansi;
			}		
		break;
		case "soru":
			$sql1 = "SELECT * 
					 FROM eo_askquestion
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_askquestion.userID					 
					 ORDER BY eo_askquestion.eklenmeTarihi DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[3]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[6]' rel='facebox'>".$gelen[7]."</a>, "
					.smileAdd(smartShort($gelen[2],20)).", "
					.$insansi;
			}		
		break;
		case "uye":
			$sql1 = "SELECT * 
					 FROM eo_users
					 ORDER BY requestDate DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[7]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[0]' rel='facebox'>".$gelen[1]."</a>, <span style='text-transform: capitalize;'>"
					.mb_strtolower($gelen[3])."</span>, "
					.$insansi;
			}		
		break;
		case "ders":
			$sql1 = "SELECT * 
					 FROM eo_userworks
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_userworks.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_userworks.konuID					 
					 ORDER BY eo_userworks.calismaTarihi DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[5]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[7]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.Sec2Time2($gelen[3]).", "
					.$gelen[4].", "
					.$insansi;
			}		
		break;
		case "arkadas":
			$sql1 = "SELECT * 
					 FROM eo_friends
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_friends.davetEdenID					 
					 ORDER BY eo_friends.id DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);		
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[3]);
				
				$sonuc = "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[8]."</a>, ".
					"<a href='profil.php?kim=$gelen[2]' rel='facebox'>".kullAdi($gelen[2])."</a>, "
					.($gelen[5]).", "
					.$insansi;
			}		
		break;
		case "dosya":
			$sql1 = "SELECT * 
					 FROM eo_files
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_files.userID					 
					 ORDER BY eo_files.id DESC limit 0,1"; 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) == 1){
				$gelen = @mysqli_fetch_array($result1);	
				if(file_exists($_uploadFolder."/".$gelen[2])) {	
					$insansi = $humanRelativeDate->getTextForSQLDate(date ("Y-m-d H:i:s", filemtime($_uploadFolder."/".$gelen[2])));
					
					$sonuc = "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[5]."</a>, "
						."<a href='fileDownload.php?id=$gelen[0]&file=$gelen[2]'>".$gelen[2]."</a>, "
						.$gelen[3].", ".$insansi;
				}
			}		
		break;
	}
	return $sonuc;
}
/*
sonBilgileriGetir:
(bir kullanıcının/herkes) bir tablodan son 1 haftadaki en son işlemleri getirir
*/
function sonBilgileriGetir($tablo, $userID){
	global $yol1,$metin,$_uploadFolder;	
	$sonuc = "";
	$humanRelativeDate = new HumanRelativeDate();

	if(!empty($userID))	{
			$kisiAdi = getUserName($userID);
			$kisiFiltre2 = " WHERE eo_shoutbox.name = '$kisiAdi' ";
			$kisiFiltre = " WHERE eo_users.id = '$userID' ";
		}
		else {
			$kisiFiltre2 = "";
			$kisiFiltre = "";
		}

			
	switch($tablo){
		case "oy":
			$sql1 = "SELECT * 
					 FROM eo_rating
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_rating.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_rating.konuID	
					 $kisiFiltre				 
					 ORDER BY eo_rating.rateDate DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			if ($result1 && @mysqli_num_rows($result1) >= 1){				
				while($gelen = @mysqli_fetch_array($result1)){			
					
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[4]);
				if(empty($userID))	{
				$sonuc .= "<a href='profil.php?kim=$gelen[5]' rel='facebox'>".$gelen[6]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[14]' rel='facebox'>".$gelen[15]."</a>, "
					.yildizYap($gelen[3]).", "
					.$insansi."<br/>";
				}else{
				$sonuc .= "<a href='dersBilgisi.php?ders=$gelen[14]' rel='facebox'>".$gelen[15]."</a>, "
					.yildizYap($gelen[3]).", "
					.$insansi."<br/>";
					}
				}
			}		
		break;
		case "yorum":
			if(empty($kisiFiltre))
			  $aramaFiltre = " WHERE active='1' ";
			  else
			  $aramaFiltre = " $kisiFiltre and active='1' ";
			$sql1 = "SELECT * 
					 FROM eo_comments
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_comments.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_comments.konuID					 
					 $aramaFiltre
					 ORDER BY eo_comments.commentDate DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[4]);
				
				if(empty($userID))	{
				$sonuc .= "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[7]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.smileAdd(smartShort($gelen[3])).", "
					.$insansi."<br/>";
				}else{
				$sonuc .= "<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.smileAdd(smartShort($gelen[3])).", "
					.$insansi."<br/>";
					}
				}
			}		
		break;
		case "sohbet":
			$sql1 = "SELECT * 
					 FROM eo_shoutbox
					 INNER JOIN eo_users 
					 ON eo_users.userName  = eo_shoutbox.name					 
					 $kisiFiltre2
					 ORDER BY eo_shoutbox.date DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[5]);
				
				if(empty($userID))	{
				$sonuc .= "<a href='profil.php?kim=$gelen[6]' rel='facebox'>".$gelen[1]."</a>, "
					.smileAdd(smartShort($gelen[3])).", "
					.odaGetir($gelen[4]).", "
					.$insansi."<br/>";
				}else{
				$sonuc .= 
						smileAdd(smartShort($gelen[3])).", "
					.odaGetir($gelen[4]).", "
					.$insansi."<br/>";
					}
				}
			}		
		break;
		case "uye":
			$sql1 = "SELECT * 
					 FROM eo_users
					 ORDER BY requestDate DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[7]);
				
				$sonuc .= "<a href='profil.php?kim=$gelen[0]' rel='facebox'>".$gelen[1]."</a>, <span style='text-transform: capitalize;'>"
					.mb_strtolower($gelen[3])."</span>, "
					.$insansi."<br/>";
				}
			}		
		break;
		case "ders":
			$sql1 = "SELECT * 
					 FROM eo_userworks
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_userworks.userID					 
					 INNER JOIN eo_4konu 
					 ON eo_4konu.id  = eo_userworks.konuID	
					 $kisiFiltre				 
					 ORDER BY eo_userworks.calismaTarihi DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[5]);
				
				if(empty($userID))	{
				$sonuc .= "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[7]."</a>, ".
					"<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.Sec2Time2($gelen[3]).", "
					.$gelen[4].", "
					.$insansi."<br/>";
				}else{
				$sonuc .= "<a href='dersBilgisi.php?ders=$gelen[2]' rel='facebox'>".$gelen[16]."</a>, "
					.Sec2Time2($gelen[3]).", "
					.$gelen[4].", "
					.$insansi."<br/>";
					}
				}
			}		
		break;
		case "soru":
			$sql1 = "SELECT *,
			             (select count(id) from eo_askanswer where soruID=eo_askquestion.id) as say 
					 FROM eo_askquestion
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_askquestion.userID					 
					 $kisiFiltre				 
					 ORDER BY eo_askquestion.eklenmeTarihi DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
				$insansi = $humanRelativeDate->getTextForSQLDate($gelen[3]);
				
				if(empty($userID))	{
				$sonuc .= "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[7]."</a>, ".
					"<a href='readAnswer.php?oku=$gelen[0]' rel=\"shadowbox;height=400;width=800\" title='Cevap Oku'>".smartShort($gelen['question'],30)."</a>, "
					.$gelen["say"].", "
					.$insansi."<br/>";
				}else{
				$sonuc .= "<a href='readAnswer.php?oku=$gelen[0]' rel=\"shadowbox;height=400;width=800\" title='Cevap Oku'>".smartShort($gelen['question'],30)."</a>, "
					.$gelen["say"].", "
					.$insansi."<br/>";
					}
				}
			}		
		break;
		case "dosya":
			$sql1 = "SELECT * 
					 FROM eo_files
					 INNER JOIN eo_users 
					 ON eo_users.id  = eo_files.userID					 
					 $kisiFiltre
					 ORDER BY eo_files.id DESC limit 0,".ayarGetir("ayar2int"); 	
			$result1 = mysqli_query($yol1,$sql1); 
			
			if ($result1 && @mysqli_num_rows($result1) >= 1){
				while($gelen = @mysqli_fetch_array($result1)){			
					if(file_exists($_uploadFolder."/".$gelen[2])) {	
						$insansi = $humanRelativeDate->getTextForSQLDate(date ("Y-m-d H:i:s", filemtime($_uploadFolder."/".$gelen[2])));
						
					if(empty($userID))	{
						$sonuc .= "<a href='profil.php?kim=$gelen[1]' rel='facebox'>".$gelen[5]."</a>, "
							."<a href='fileDownload.php?id=$gelen[0]&file=$gelen[2]'>".$gelen[2]."</a>, "
							.$gelen[3].", ".$insansi."<br/>";
					}else{
					$sonuc .= "<a href='fileDownload.php?id=$gelen[0]&file=$gelen[2]'>".$gelen[2]."</a>, "
							.$gelen[3].", ".$insansi."<br/>";
						}
				
					}
				}
			}		
		break;
	}
	return $sonuc;
}
/*
kullGercekAdi:
kullanıcının gerçek adı
*/
function kullGercekAdi($id)
{
	global $yol1;	
	$id = substr(temizle($id),0,15);
    $sql1 = "SELECT realName FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && @mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "realName"));
    }else {
	   return ("");
	}
}
/*
getUserName:
kimlik ile kullanıcı isimlerini alma
*/
function getUserName($id){
	global $yol1;	
	
    $sql1 = "SELECT userName, realName FROM eo_users where id='$id' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 
	
    if ($result1 && @mysqli_num_rows($result1) == 1){
		$gelen = @mysqli_fetch_array($result1);		
		return $gelen[0].", <span style='text-transform: capitalize;'>".mb_strtolower($gelen[1])."</span>";
	}
	
	return "-";
}
/*
getDerstekiKonuSay:
id ile dersteki konu sayısını alma
*/
function getDerstekiKonuSay($id){
	global $yol1;	
	
    $sql1 = "SELECT count(*) as say FROM eo_4konu where dersID='$id'"; 	
    $result1 = mysqli_query($yol1,$sql1); 
	
    if ($result1 && @mysqli_num_rows($result1) == 1){
		$gelen = @mysqli_fetch_array($result1);		
		return $gelen["say"];
	}
	
	return "0";
}
/*
getDersAdi:
id ile ders ismi alma
*/
function getDersAdi($id){
	global $yol1;	
	
    $sql1 = "SELECT dersAdi FROM eo_3ders where id='$id' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 
	
    if ($result1 && @mysqli_num_rows($result1) == 1){
		$gelen = @mysqli_fetch_array($result1);		
		return $gelen["dersAdi"];
	}
	
	return "";
}
/*
getDayCount:
iki tarih arasındaki gün sayısını bulur
*/
function getDayCount($fromDate, $toDate){
   $fst = explode("-", $fromDate);
   $first = date("Y-m-d", strtotime($fst[2] . "-" . $fst[1] . "-" . $fst[0]));
   $end = explode("-", $toDate);
   $last = date("Y-m-d", strtotime($end[2] . "-" . $end[1] . "-" . $end[0]));
   
   $today = $first;
   $dayCount = 0;
   while ($today<=$last){
       $today = date("Y-m-d", strtotime("+1 days", strtotime($today)));
       $day = date("w", strtotime("+1 days", strtotime($today)));
       $dayCount++;
   }
   return $dayCount;
}
/*
Sec2Time:
saniyeyi üst zaman birimlerine çevirir
*/
function Sec2Time($time){
  if(is_numeric($time)){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
    }
    if($time >= 60){
      $value["minutes"] = floor($time/60);
      $time = ($time%60);
    }
    $value["seconds"] = floor($time);
    return (array) $value;
  }else{
    return (bool) FALSE;
  }
}
/*
Sec2Time2:
saniyeyi üst zaman birimlerine çevirir
*/
function Sec2Time2($time){
  global $metin;
  if(is_numeric($time)){
    $value = "";
    if($time >= 31556926){
      $value = floor($time/31556926)."y ";
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value .= floor($time/86400)." $metin[621] ";
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value .= strlen(floor($time/3600))==1?"0".floor($time/3600).":":floor($time/3600).":";
      $time = ($time%3600);
    }
    if($time >= 60){
      $value .= strlen(floor($time/60))==1?"0".floor($time/60).":":floor($time/60).":";
      $time = ($time%60);
    }
    $value .= strlen(floor($time))==1?"0".floor($time)."s":floor($time)."s";
    return $value;
  }else{
    return (bool) FALSE;
  }
}
/*
getmicrotime:
geçen zamanı ölçme
*/
function getmicrotime()
{ 
  list($usec, $sec) = explode(" ",microtime()); 
  return ((float)$usec + (float)$sec);
}
/*
RemoveXSS:
xss temizleme
*/
function RemoveXSS($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
   
   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A &#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
   
      // &#x0040 @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // &#00064 @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }
   
   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);
   
   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
} 
/*
getUsersOnline:
çevrimiçi kullanıcı sayısı, usertrack tablosunda son 300 dakikadaki girişler
*/
function getUsersOnline() {
	global $yol1;
	
		$sql = "SELECT userName,(unix_timestamp(now()) - unix_timestamp(dateTime) )/60 as sure FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/60 <= 300 and otherInfo='success,Login' GROUP BY userName order by sure DESC,userName limit 0,".ayarGetir("ayar2int");
		
		$result = mysqli_query($yol1,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
		      $data['values'][] = $row['userName'];
		}
		if(isset($data['values']))
		return $data['values'];
}
/*
soruEkle:
soru eklenmesi
*/
function soruEkle($gelen){
	$soru = str_replace("'", "`", $gelen['soru']);
	$soruMetni = substr(RemoveXSS($soru),0,300);//soru çok uzun ise
	$datem	=	date("Y-n-j H:i:s");
	$gonderenID	= getUserID($_SESSION["usern"],$_SESSION["userp"]);

	global $yol1;
	
	$sql = "INSERT INTO eo_askquestion 
			(userID, question, eklenmeTarihi, dersID) 
			VALUES 
			($gonderenID,'$soruMetni','$datem',".temizle($gelen['dersID']).")";
		
	$result = mysqli_query($yol1,$sql);
		
	return $result;
}
/*
dersAdlariOption:
ders adlarını Option içine doldurarak getirir
*/
function dersAdlariOption(){
	global $yol1;	
	$sql = "SELECT id, dersAdi FROM eo_3ders ORDER BY dersAdi";		
	$result = mysqli_query($yol1,$sql);	
	$sonuc = "";
	while($satir=@mysqli_fetch_array($result)){
		$sonuc .= "<option value='$satir[0]'>$satir[1]</option>\n";
	}
	
	return $sonuc;
}
/*
cevapSayisiGetir:
sorulan sorunun cevap adedi
*/
function cevapSayisiGetir($id){
	global $yol1;	
	$sql = "SELECT count(id) FROM eo_askanswer WHERE soruID=$id";		
	$result = mysqli_query($yol1,$sql);	
	
	$satir=@mysqli_fetch_array($result);
	if($satir[0]>0) 
		return "($satir[0])";	
}
/*
soruSayisiGetir:
kac soru soruldu ise adeti
*/
function soruSayisiGetir($arama){
	global $yol1;	
	if($arama!="")
		$sql = "SELECT count(id) FROM eo_askquestion WHERE question LIKE '%$arama%'";		
	 else	
		$sql = "SELECT count(id) FROM eo_askquestion";		
	$result = mysqli_query($yol1,$sql);	
	
	$satir=@mysqli_fetch_array($result);
	return ($satir[0]);	
}
/*
soruEkleyenID:
sorunun sahibinin ID'si getirilir
*/
function soruEkleyenID($soruID){
	global $yol1;
	$soruID = (int) temizle($soruID);
	$sql = "SELECT userID FROM eo_askquestion WHERE id=$soruID";		
	$result = mysqli_query($yol1,$sql);	
	
	$satir=@mysqli_fetch_array($result);
	if($satir[0]!="") 
		return ($satir[0]);		
}
/*
son5oyVeren:
en son oy vermiş 5 kişi ismi
*/
function son5oyVeren($id,$deger){
	global $yol1;
	$id = (int) temizle($id);
	$sorgu = "SELECT eo_users.userName FROM eo_users,eo_askanswerrate
			WHERE eo_users.id = eo_askanswerrate.userID
			and eo_askanswerrate.cevapID='$id' 
			and eo_askanswerrate.degeri='$deger'
			ORDER BY eo_users.userName
			LIMIT 0,5";
	$result = mysqli_query($yol1, $sorgu);
	if ($result){
		$sonuc=" ";
		while($gelen=@mysqli_fetch_array($result))
		  $sonuc .= $gelen[0]." ";
		return $sonuc;  
	}else
	return "";	
}
/*
cevapOyToplami:
cevap için verilen oyların toplamı (son oy verenlerin adları)
*/
function cevapOyToplami($cevapID){
	global $yol1;
	global $metin;
	$cevapID = (int) temizle($cevapID);
	$sonuc="";
	
	//dogru diyenler
	$sql = "SELECT count(id) as say,cevapID FROM eo_askanswerrate 
		WHERE cevapID='$cevapID' and degeri='1'";		
	$result = mysqli_query($yol1,$sql);		
	$satir=@mysqli_fetch_array($result);
	if($satir[0]>0) 
		$sonuc .= $satir[0]." <span class='dogruOy' title='".son5oyVeren($satir[1],"1")."'></span> ";	
				
	//hata diyenler
	$sql = "SELECT count(id) as say,cevapID FROM eo_askanswerrate
		 WHERE cevapID='$cevapID' and degeri='-1'";		
	$result = mysqli_query($yol1,$sql);		
	$satir=@mysqli_fetch_array($result);
	if($satir[0]>0) 
		$sonuc .= $satir[0]." <span class='yanlisOy' title='".son5oyVeren($satir[1],"-1")."'></span> ";
	if($sonuc=="") $sonuc = $metin[655];
	
	return $sonuc;	
}
/*
istekListesi:
kullanıcının yetki değiştirme isteği tarihleri
*/
function istekListesi(){
	global $yol1;
	$lmt=30;//son 30 günlük yeter
	$user= temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
	
		$sql = "SELECT dateTime,DATE_FORMAT(dateTime, '%d-%m-%Y') as dt FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt and userName='$user' and otherInfo like 'request%' order by dateTime DESC";
		$result = mysqli_query($yol1,$sql);
		$data = "";
		while($row = mysqli_fetch_assoc($result)) {
		      $data .= $row['dt'].", ";
		}
		$data = substr($data,0,strlen($data)-2);	 //son , silindi					   
		return $data;		
}
/*
is_ajax:
ajax desteği var mı
*/
function is_ajax()
{
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}
/*
suAndaDersVarMi:
canli ders için kontrol
*/
function suAndaDersVarMi(){
	global $yol1;
	$lmt=1;//şimdiki 1 etkinlik
	
		$sql = "SELECT *,  TIMESTAMPDIFF(MINUTE, now(), DATE_ADD(dateWhen, INTERVAL length MINUTE)) as kalanlength FROM eo_livelesson
		 WHERE 
		 now() between dateWhen and
		 DATE_ADD(dateWhen, INTERVAL length MINUTE)  		  
		 order by dateWhen ASC
		 LIMIT 0,$lmt";
		$result = mysqli_query($yol1,$sql);
		$data = 0;
		while($row = mysqli_fetch_array($result)) {			
			$data++;
			$dersAdi = getUserName($row['userID']).", ".
			getDersAdi($row['dersID']). ", <strong>".$row["yontem"]."</strong>";
		}
		if($data==0)
			return false;
		else
			return $dersAdi;		
}
/*
suAndaDersDakika:
canli ders için kontrol
*/
function suAndaDersDakika(){
	global $yol1;
	$lmt=1;//şimdiki 1 etkinlik
	
		$sql = "SELECT *,  TIMESTAMPDIFF(MINUTE, now(), DATE_ADD(dateWhen, INTERVAL length MINUTE)) as kalanlength FROM eo_livelesson
		 WHERE 
		 now() between dateWhen and
		 DATE_ADD(dateWhen, INTERVAL length MINUTE)  		  
		 order by dateWhen ASC
		 LIMIT 0,$lmt";
		$result = mysqli_query($yol1,$sql);
		$data = 0;
		while($row = mysqli_fetch_array($result)) {			
			$data++;
			$dersAdi = 	$row["kalanlength"];
		}
		if($data==0)
			return 0;
		else
			return $dersAdi;		
}
/*
yaklasanEtkinlikListesi:
Gelecekteki canlı ders listesi
*/
function yaklasanEtkinlikListesi(){
	global $yol1,$metin;
	$lmt=3;//gelecek 3 etkinlik	

		$sql = "SELECT *,DATE_FORMAT(dateWhen, '%d-%m-%Y %H:%i') as dt FROM eo_livelesson
		 WHERE 
		 (unix_timestamp(now()) - unix_timestamp(dateWhen) )/3600/24 <= 0 
		 order by dateWhen ASC
		 LIMIT 0,$lmt";
		$result = mysqli_query($yol1,$sql);
		$data = "";
		while($row = mysqli_fetch_assoc($result)) {			
			$humanRelativeDate = new HumanRelativeDate();
			$tarihi = $humanRelativeDate->getTextForSQLDate($row['dateWhen']);
 	      	$data .= "<li>".getUserName($row['userID']).", ".
			getDersAdi($row['dersID']). ", ".
			$row["length"]." dakika <strong>".$row["yontem"]."</strong>".
			"<br/><span style='font-size:13px;font-style:italic'>".$row['dt']." (".$tarihi.")</span></li>";
		}
		if($data=="")
			return "";
		else
			return "<h4>".$metin[677]." : </h4><ul>".$data."</ul>";		
}
/*
tamamlanmisEtkinlikListesi:
Geçmiş canlı ders listesi
*/
function tamamlanmisEtkinlikListesi(){
	global $yol1,$metin;
	$lmt=3;//geçmiş 3 etkinlik
	
		$sql = "SELECT *,DATE_FORMAT(dateWhen, '%d-%m-%Y %H:%i') as dt FROM eo_livelesson
		 WHERE 
		 (unix_timestamp(now()) - unix_timestamp(dateWhen) )/3600/24 > 0 
		 order by dateWhen DESC
		 LIMIT 0,$lmt";
		$result = mysqli_query($yol1,$sql);
		$data = "";
		while($row = mysqli_fetch_assoc($result)) {			
			$humanRelativeDate = new HumanRelativeDate();
			$tarihi = $humanRelativeDate->getTextForSQLDate($row['dateWhen']);
 	      	$data .= "<li>".getUserName($row['userID']).", ".
			getDersAdi($row['dersID']). ", ".
			$row["length"]." dakika <strong>".$row["yontem"]."</strong>".
			"<br/><span style='font-size:13px;font-style:italic;'>".$row['dt']." (".$tarihi.")</span></li>";
		}
		if($data=="")
			return "<li>$metin[586]</li>";
		else
			return $data;		
}

/*
PHP 7'de mysqli_result yok 

function mysqli_result($result, $row, $field = 0) {    
    $result->data_seek($row);    
    $data = $result->fetch_array(); 
    return $data[$field];
}*/
function mysqli_result($res,$row=0,$col=0){
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

/*
Genel olarak session kontrol edilmesi
*/
//if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) {   
   //sessionDestroy();
//	echo("$metin[400]"); //session?
	//exit;
//} 

/*
Genel olarak üye pasif durumda ise hata verir
*/
if (isset($tur))
	if ($tur=="-1")	{
	   sessionDestroy();
	   echo ("$metin[450]");
	} 
/*
Site bakımda mı diye kontrol edildiği yer
*/
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
if ($seceneklerimiz[15]=="1"){
	if(basename(RemoveXSS($_SERVER['SCRIPT_FILENAME']))!="error.php") //sonsuz döngü
		header("Location: error.php?error=11");	
}

?>