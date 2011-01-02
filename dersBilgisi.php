<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
@session_start();
ob_start();
@header("Content-Type: text/html; charset=iso-8859-9"); 

     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 
require("conf.php");	
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
/*
baglan2:
veritabaný baðlantýsý
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!@mysql_select_db($_db, $yol1))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}
/*
temizle2:
xss temizleme iþlemi
*/
function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    //$metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}
/*
getUserIDrate:
kullanýcýnýn kimlik bilgisi getirir
*/
function getUserIDrate($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
konuAdi:
kimlik ile konunun adýnýn getirilmesi
*/
function konuAdi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT konuAdi FROM eo_4konu where id='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "konuAdi"));
    }else {
	   return ("");
	}
}
/*
dersOkulSinif:
kimlik ile ders okul ve sýnýf bilgisini alma
*/
function dersOkulSinif($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT eo_3ders.dersAdi as dersAdi, eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi FROM eo_4konu 
	 		inner join eo_3ders on eo_4konu.dersID=eo_3ders.id 
			inner join eo_2sinif on eo_2sinif.id=eo_3ders.sinifID 
			inner join eo_1okul on eo_1okul.id=eo_2sinif.okulID where eo_4konu.id=$id
			group by dersAdi"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return ("<br/>&nbsp;&nbsp;".mysql_result($result1, 0, "dersAdi")." (".mysql_result($result1, 0, "okulAdi")." - ".mysql_result($result1, 0, "sinifAdi").")");
    }else {
	   return ("");
	}
}
/*
sayfaSayisi:
bir konudaki sayfa sayýsýný bulma
*/
function sayfaSayisi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_4konu ".
	 		"inner join eo_5sayfa on eo_4konu.id=eo_5sayfa.konuID ".
			"where eo_4konu.id=$id"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
sonGuncellenmeTarihi:
belli bir konunun son güncellenme tarihi
*/
function sonGuncellenmeTarihi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT eo_5sayfa.konuID as idsi, eo_4konu.konuAdi as kadi,".
					   "eo_3ders.dersAdi as dersAdi, max(eo_5sayfa.eklenmeTarihi) as tarih ".
					   "from eo_5sayfa, eo_4konu, eo_3ders ".
					   "where eo_5sayfa.konuID=eo_4konu.id ".
					   "and eo_4konu.dersID=eo_3ders.id ".
					   "and eo_4konu.id=$id ".
					   "GROUP BY kadi ".
					   "order by tarih desc,kadi "; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
     	$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate(mysql_result($result1, 0, "tarih"));							
										
       return $insansi;
    }else {
	   return ("");
	}
}
/*
calisilmaSay:
kimlik ile ders çalýþma sayýsý
*/
function calisilmaSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say from eo_userworks 
	        where konuID=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
calisilmaSureToplam:
belli bir konudaki çalýþma süresi
*/
function calisilmaSureToplam($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT sum(toplamZaman) as toplam from eo_userworks 
	        where konuID=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return Sec2Time2(mysql_result($result1, 0, "toplam"));
    }else {
	   return ("");
	}
}
/*
calisilmaBitmeOrt:
belli bir konunun bitirilme ortalamasý
*/
function calisilmaBitmeOrt($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(lastPage) as ort from eo_userworks 
	        where konuID=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "ort"));
    }else {
	   return ("");
	}
}
/*
oyOrani:
konunun oy ortalamasý
*/
function oyOrani($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(value) as ort from eo_rating 
	        where konuID=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "ort"));
    }else {
	   return ("");
	}
}
/*
oyOrani:
konunun oy sayýsý
*/
function oySay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(value) as ort from eo_rating 
	        where konuID=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "ort"));
    }else {
	   return ("");
	}
}
/*
yorumSay:
konunun yorum sayýsý
*/
function yorumSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say from eo_comments 
	        where konuID=$id and active=1";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
yorumPasifSay:
konunun pasif oy sayýsý
*/
function yorumPasifSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say from eo_comments 
	        where konuID=$id and active<>1";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
konuKisitlamalari:
konunun kýsýtlamalarý
*/
function konuKisitlamalari($id){
	global $yol1;	
	global $metin;
	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT DATE_FORMAT(bitisTarihi,'%d-%m-%Y') as bitisTarihi , oncekiKonuID, konuyuKilitle, calismaSuresiDakika, 
			calismaHakSayisi, sadeceKayitlilarGorebilir, sinifaDahilKullaniciGorebilir 
			from eo_4konu 
	        where id=$id ";

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
		$sonuc = "";
		if(mysql_result($result1, 0, "konuyuKilitle")>0)
			$sonuc .= "<br/>&nbsp;&nbsp;<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' /> $metin[179] "; 
		if(mysql_result($result1, 0, "sadeceKayitlilarGorebilir")>0)
			$sonuc .= "<br/>&nbsp;&nbsp;<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />  $metin[181] "; 
		if(mysql_result($result1, 0, "calismaSuresiDakika")>0)
			$sonuc .= "<br/>&nbsp;&nbsp;<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" /> $metin[169] : ". mysql_result($result1, 0, "calismaSuresiDakika") . " $metin[171]"; 
		if(mysql_result($result1, 0, "bitisTarihi")!="00-00-0000")
			$sonuc .= "<br/>&nbsp;&nbsp;$metin[330] : ". mysql_result($result1, 0, "bitisTarihi"); 
		if(mysql_result($result1, 0, "oncekiKonuID")>0) {
			
			$sqlici =    "SELECT eo_4konu.konuAdi FROM eo_4konu
							WHERE eo_4konu.id = ".mysql_result($result1, 0, "oncekiKonuID") ;							
			
							$resultici = mysql_query($sqlici, $yol1);
							if ($resultici){
								if (@mysql_numrows($resultici)==1)
							    	$sonuc .= "<br/>&nbsp;&nbsp;$metin[166] : <a href='lessons.php?konu=".mysql_result($result1, 0, "oncekiKonuID")."'>".
										mysql_result($resultici, 0, "konuAdi").
										"</a> ";
							}							
		}
		if(mysql_result($result1, 0, "calismaHakSayisi")>0)
			$sonuc .= "<br/>&nbsp;&nbsp;$metin[325] : ". mysql_result($result1, 0, "calismaHakSayisi"); 
		if(mysql_result($result1, 0, "sinifaDahilKullaniciGorebilir")>0)
			$sonuc .= "<br/>&nbsp;&nbsp;$metin[326]"; 
       return ($sonuc);
    }else {
	   return ("");
	}	
}

/*main*/
 if (isset($_GET['ders']) && is_numeric($_GET['ders']) && $_GET['ders']>0 && isset($_SESSION["usern"]) &&  getUserIDrate($_SESSION["usern"],$_SESSION["userp"])!="" ) {
		echo "<h3>$metin[327]</h3>";
		echo "<strong>$metin[175] :</strong> ".konuAdi($_GET["ders"])."<br/>";
		echo "<strong>$metin[328] :</strong> <i>".dersOkulSinif($_GET["ders"])."</i><br/>";
	
	if(sayfaSayisi($_GET["ders"])>0)
		echo "<strong>$metin[329] :</strong> ".sayfaSayisi($_GET["ders"])."<br/>";
		
	if(sonGuncellenmeTarihi($_GET["ders"])!="")
		echo "<strong>$metin[331] :</strong> ".sonGuncellenmeTarihi($_GET["ders"])."<br/>";

	if(calisilmaSay($_GET["ders"])>0)	
		echo "<strong>$metin[332] :</strong> ".calisilmaSay($_GET["ders"])."<br/>";
		
	if(calisilmaSureToplam($_GET["ders"])>0)	
		echo "<strong>$metin[333] :</strong> ".calisilmaSureToplam($_GET["ders"])."<br/>";
	
	if(calisilmaBitmeOrt($_GET["ders"])>0)
		echo "<strong>$metin[334] :</strong> ".round(calisilmaBitmeOrt($_GET["ders"]),1)."%<br/>";
		
	if(oyOrani($_GET["ders"])>0)	
		echo "<strong>$metin[335] :</strong> <font title='$metin[341] : ".oySay($_GET["ders"]).", $metin[323] : ".round(oyOrani($_GET["ders"]),1)."'>".yildizYap(round(oyOrani($_GET["ders"])))."</font><br/>";
		
	if(yorumSay($_GET["ders"])>0)	
		echo "<strong>$metin[336] :</strong> ".yorumSay($_GET["ders"])."<br/>";
		
	if(yorumPasifSay($_GET["ders"])>0)	
	    echo "<strong>$metin[337] :</strong> ".yorumPasifSay($_GET["ders"])."<br/>";
		
	if(konuKisitlamalari($_GET["ders"])!="")	
	    echo "<strong>$metin[338] :</strong> <i>".konuKisitlamalari($_GET["ders"])."</i><br/>";
	
	if(!isset($_GET['set']) or $_GET['set']!="1"){	
			echo"<br/>";
			echo "<a href=\"lessons.php?konu=".$_GET["ders"]."\" ><img src=\"img/lessons.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"lessons\"/> $metin[339]</a>";
	}
 } else
  echo "$metin[340]";  


?>