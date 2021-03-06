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
@session_start();
ob_start (); // Buffer output
@header("Content-Type: text/html; charset=utf-8"); 

  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"profil.php");	   
  $seciliTema=temaBilgisi();	
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
/*
baglan2:
veritabanına bağlan
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
	global  $_db;
	 
    return 	@mysqli_connect($_host, $_username, $_password, $_db);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href='install.php' target='_parent'>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();mysqli_set_charset($yol1, "utf8");

	if (!$yol1)
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href='install.php' target='_parent'>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href='install.php' target='_parent'>installing page</a>!<br/>
			 </font>");
	}
include('lib/graphs.inc.php');	
/*
temizle2:
xss temizleme
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
    $metin = trim(htmlentities($metin));
    return $metin;
}
/*
getUserIDrate:
kullanıcının kimlik bilgisi
*/
function getUserIDrate($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
       return (mysqli_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
Sec2Time22:
saniyenin üst birime dönüştürülmesi
*/
function Sec2Time22($time){
  if(is_numeric($time)){
    $value = "";
    if($time >= 31556926){
      $value = floor($time/31556926)."y ";
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value .= floor($time/86400)."d ";
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
kullTur:
kullanıcının türü
*/
function kullTur($id)
{
	global $yol1;
	global $metin;
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userType FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
		switch (mysqli_result($result1, 0, "userType")){
			case -1:
		       return "<img src=\"img/pasif_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[93]\"/> $metin[93]";  break;
			case 0:
		       return "<img src=\"img/ogr_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[94]\"/> $metin[94]";  break;
			case 1:
		       return "<img src=\"img/ogrt_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[95]\"/> $metin[95]";  break;
			case 2:
		       return "<img src=\"img/admin_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[96]\"/> $metin[96]";  break;
			default:
			   return "$metin[92]";
		}		
    }else {
	   return ("");
	}
}
/*
uyeTarihi:
kullanıcının üyelik tarihi
*/
function uyeTarihi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT requestDate FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate(mysqli_result($result1, 0, "requestDate"));		
       return $insansi;
    }else {
	   return ("");
	}
}
/*
sonGiris:
kullanıcının son giriş tarihi
*/
function sonGiris($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT dateTime FROM eo_usertrack where userName='".kullAdi($id)."' and processName='login.php' and otherInfo='success,Login' order by dateTime DESC limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate(mysqli_result($result1, 0, "dateTime"));		
       return $insansi;
    }else {
	   return ("");
	}
}
/*
girisSayisi:
kullanıcının giriş sayısı
*/
function girisSayisi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_usertrack where userName='".kullAdi($id)."' and processName='login.php' and otherInfo='success,Login' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
sayfaEklemeSay:
öğretmenin sayfa ekleme sayısı
*/
function sayfaEklemeSay($id){
				global $yol1;	
				$id = substr(temizle2($id),0,15);
				$sql1 =    "SELECT  count(*) as say 
							FROM eo_5sayfa 
							LEFT OUTER JOIN eo_users
							ON eo_5sayfa.ekleyenID = eo_users.id
							WHERE eo_users.userType>0 
							  and eo_users.id = ".$id."
							GROUP BY userName";
				
				$result1 = mysqli_query($yol1,$sql1);
				if ($result1 && mysqli_num_rows($result1) == 1)
				{
				   return (mysqli_result($result1, 0, "say"));
				}else {
				   return ("");
				}
}
/*
dersCalismaSay:
kullanıcının ders çalışmas sayısı
*/
function dersCalismaSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
dersCalismaSure:
kullanıcının ders çalışma süresi
*/
function dersCalismaSure($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT sum(toplamZaman) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
dersCalismaOrt:
kullanıcının ders çalışma ortalaması
*/
function dersCalismaOrt($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(lastPage) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
yorumSay:
kullanıcının yorum sayısı
*/
function yorumSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_comments where userID='".$id."' and active=1 limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
yorumSayPasif:
kullanıcının pasif yorum sayısı
*/
function yorumSayPasif($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_comments where userID='".$id."' and active<>'1' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
oySay:
kullanıcının oy sayısı
*/
function oySay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_rating where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
oyOrt:
kullanıcının oy ortalaması 
*/
function oyOrt($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(value) as say FROM eo_rating where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
dosyaSay:
kullanıcının paylaştığı dosya sayısı 
*/
function dosyaSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(fileName) as say FROM eo_files where userID='".$id."' limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
arkadasSay:
kullanıcının arkadaş sayısı 
*/
function arkadasSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(id) as say FROM eo_friends where 
	        (davetEdenID='".$id."' or davetEdilenID='".$id."')
			and kabul='1'
			 limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
soruSay:
kullanıcının soru sayısı 
*/
function soruSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(id) as say FROM eo_askquestion
			Where userID = $id 
			 limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
cevapSay:
kullanıcının cevap sayısı 
*/
function cevapSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(id) as say FROM eo_askanswer
			Where userID = $id 
			limit 0,1"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1){
       return (mysqli_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
getOgrenciSiniflari2:
kullanıcının sınıf bilgileri
*/
function getOgrenciSiniflari2($id){
	global $yol1;
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT * FROM eo_sinifogre, eo_2sinif, eo_1okul where eo_sinifogre.userID='".
				$id."' and eo_sinifogre.sinifID = eo_2sinif.id and eo_1okul.id = eo_2sinif.okulID 
				order by eo_2sinif.sinifAdi ";	
    
	$result1 = mysqli_query($yol1,$sql1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysqli_fetch_assoc($result1))
				    $ekle .= $row_gelen['sinifAdi']." (".$row_gelen['okulAdi']."), ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     
				   return ($ekle);
				}else {
				   return ("");
				}
}
/*
girisSayisiRank:
kullanıcının giriş sayısı seviyesi
*/
function girisSayisiRank($id,$grafikli,$sadeYuzde=false)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userName ,count(eo_usertrack.id) as say 
		FROM eo_usertrack
		where processName='login.php' and otherInfo='success,Login' 
		group by userName
		order by say DESC, userName"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysqli_num_rows($result1);$i++){
			 $rank = $i + 1;
			 if(mysqli_result($result1, $i, "userName")==kullAdi($id)) break;
		 }	
		 
	   if($grafikli) 
	     rankGrafik(@mysqli_num_rows($result1)-$rank,@mysqli_num_rows($result1));
	   
	   if($sadeYuzde and @mysqli_num_rows($result1)>0)		
	      return 100-round($rank*100/@mysqli_num_rows($result1));
		  
       return ("$rank /".@mysqli_num_rows($result1));
    }else {
	   return (0);
	}
	return 0;
}
/*
dersCalismaOrtRank:
kullanıcının ders çalışma düzeyi
*/
function dersCalismaRank($id,$grafikli,$sadeYuzde=false){
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userID ,count(id) as say 
		FROM eo_userworks
		where userID>0 
		group by userID
		order by say DESC, userID"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysqli_num_rows($result1);$i++){
			 $rank = $i + 1;
			 if(mysqli_result($result1, $i, "userID")==$id ) break;
		 }
		 
	   if($grafikli) 
	     rankGrafik(@mysqli_num_rows($result1)-$rank,@mysqli_num_rows($result1));
	   
	   if($sadeYuzde and @mysqli_num_rows($result1)>0)		
	      return 100-round($rank*100/@mysqli_num_rows($result1));
		  
       return ($rank."/".@mysqli_num_rows($result1));
    }else {
	   return (0);
	}
	return 0;
}
/*
dersCalismaOrtRank:
kullanıcının ders çalışma ortalama düzeyi
*/
function dersCalismaOrtRank($id,$grafikli,$sadeYuzde=false){
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userID , avg(lastPage) as say 
		FROM eo_userworks
		where userID>0 
		group by userID
		order by say DESC, userID"; 	
    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysqli_num_rows($result1);$i++){
			 $rank = $i + 1;
			 if(mysqli_result($result1, $i, "userID")==$id ) break;
		 }
		 
	   if($grafikli) 
	     rankGrafik(@mysqli_num_rows($result1)-$rank,@mysqli_num_rows($result1));
	   
	   if($sadeYuzde and @mysqli_num_rows($result1)>0)		
	      return 100-round($rank*100/@mysqli_num_rows($result1));
		  
       return ($rank."/".@mysqli_num_rows($result1));
    }else {
	   return (0);
	}
	return 0;
}

/*main*/
 if (isset($_GET['kim']) && is_numeric($_GET['kim']) && $_GET['kim']>0 && getUserIDrate($_SESSION["usern"],$_SESSION["userp"])!="" and kullAdi($_GET["kim"])<>"") {
		echo "<h3 style=\"color:#000;\">$metin[312]</h3><p style=\"color:#000;\">";
		echo "<strong>$metin[17] :</strong> ".kullAdi($_GET["kim"])." - <span style='text-transform: capitalize;'>".mb_strtolower(kullGercekAdi($_GET["kim"]))."</span><br/>";
		echo "<strong>$metin[22] :</strong> ".kullTur($_GET["kim"])."<br/>";
		echo "<strong>$metin[23] :</strong> ".uyeTarihi($_GET["kim"])."<br/>";
	if(sonGiris($_GET["kim"])!="")	
		echo "<strong>$metin[313] :</strong> ".sonGiris($_GET["kim"])."<br/>";
	if(getOgrenciSiniflari2($_GET["kim"])!="")	
		echo "<strong>$metin[314] :</strong> ".getOgrenciSiniflari2($_GET["kim"])."<br/>";

	$rank1 = ((girisSayisi($_GET["kim"])>0 and girisSayisiRank($_GET["kim"],false,true)>0)?
			"$metin[324] ".girisSayisiRank($_GET["kim"],true):"");	
	if(girisSayisi($_GET["kim"])>0)
		echo "<strong>$metin[315] :</strong> ".girisSayisi($_GET["kim"])." <u>$rank1</u><br/>";
		
	$rank2 = ((dersCalismaSay($_GET["kim"])>0 and dersCalismaRank($_GET["kim"],false,true)>0)?		
			"$metin[324] ".dersCalismaRank($_GET["kim"],true):"");	
	if(dersCalismaSay($_GET["kim"])>0)
		echo "<strong>$metin[316] :</strong> ".dersCalismaSay($_GET["kim"])." <u>$rank2</u><br/>";
		
	if(dersCalismaSure($_GET["kim"])!="")
		echo "<strong>$metin[317] :</strong> ".Sec2Time22(dersCalismaSure($_GET["kim"]))."<br/>";
		
	$rank3 = ((dersCalismaOrt($_GET["kim"])>0 and dersCalismaOrtRank($_GET["kim"],false,true)>0)?
			"$metin[324] ".dersCalismaOrtRank($_GET["kim"],true):"");	
	if(dersCalismaOrt($_GET["kim"])>0)
		echo "<strong>$metin[318] :</strong> ".round(dersCalismaOrt($_GET["kim"]),1)."% <u>$rank3</u><br/>";
	if(sayfaEklemeSay($_GET["kim"])>0)
		echo "<strong>$metin[319] :</strong> ".sayfaEklemeSay($_GET["kim"])."<br/>";
		
		if(yorumSay($_GET["kim"])>0) 
			echo "<strong>$metin[320] :</strong> ".yorumSay($_GET["kim"])."<br/>";
			
		if(yorumSayPasif($_GET["kim"])>0)
			echo "<strong>$metin[321] :</strong> ".yorumSayPasif($_GET["kim"])."<br/>";
	
	if(oySay($_GET["kim"])>0)
		echo "<strong>$metin[322] :</strong> ".oySay($_GET["kim"]);
	if(oyOrt($_GET["kim"])>0)
		echo " ($metin[323] ".round(oyOrt($_GET["kim"]),1).")"."<br/>";
		
	if(dosyaSay($_GET["kim"])>0)
		echo "<strong>$metin[470] :</strong> ".dosyaSay($_GET["kim"])."<br/>";
	
	if(arkadasSay($_GET["kim"])>0)
		echo "<strong>$metin[630] :</strong> ".arkadasSay($_GET["kim"])."<br/>";
	
	if(soruSay($_GET["kim"])>0)
		echo "<strong>$metin[635] :</strong> ".soruSay($_GET["kim"])."<br/>";
	
	if(cevapSay($_GET["kim"])>0)
		echo "<strong>$metin[636] :</strong> ".cevapSay($_GET["kim"])."<br/>";
	
	$aktivi1 = girisSayisiRank($_GET["kim"],false,true);
	$aktivi2 = dersCalismaRank($_GET["kim"],false,true);
	$aktivi3 = dersCalismaOrtRank($_GET["kim"],false,true);
	$aktivSonuc = (int)($aktivi1>50)+(int)($aktivi2>50)+(int)($aktivi3>50);	

	if(girisSayisi($_GET["kim"])>0)
		switch($aktivSonuc){
			case 0:
				/*echo '<strong>'.$metin[555].' :</strong>&nbsp; 
				<span style="background: transparent url(img/activity-level.png)
				 no-repeat top left;background-position: -48px 0px;
				 width:16px;height:16px;margin: 0; padding: 0; 
				position: absolute;display: inline;"></span><br/>';	*/
			break;
			case 1:
				echo '<strong>'.$metin[555].' :</strong>&nbsp;  
				<span style="background: transparent url(img/activity-level.png)
				 no-repeat top left;background-position: -32px 0px;
				width:16px;height:16px;margin: 0; padding: 0; 
				position: absolute;display: inline;"></span><br/>';	
			break;
			case 2:
				echo '<strong>'.$metin[555].' :</strong>&nbsp;  
				<span style="background: transparent url(img/activity-level.png)
				 no-repeat top left;background-position: -16px 0px;
				width:16px;height:16px;margin: 0; padding: 0; 
				position: absolute;display: inline;"></span><br/>';	
			break;
			case 3:
				echo '<strong>'.$metin[555].' :</strong>&nbsp;
				<span style="background: transparent url(img/activity-level.png)
				 no-repeat top left;background-position: 0px 0px;
				width:16px;height:16px;margin: 0; padding: 0; 
				position: absolute;display: inline;"></span><br/>';	
			break;
		}
if(isset($_GET['set']))	
	$ayar = $_GET['set'];
	else
	$ayar = "0";
	
	if($ayar!="1"){
		echo"<br/><br/>";
		echo "<a href=\"mail.php?to=".$_GET["kim"]."\" class=\"external\" onclick='window.open(\"mail.php?to=".$_GET["kim"]."\");return false;'>$metin[69]</a>";
		echo " | <a href='friends.php?kisi=".$_GET["kim"]."' target='_parent'>$metin[580]</a>";
		if($_SESSION["tur"]==1 or $_SESSION["tur"]==2)
		  if(dersCalismaSay($_GET["kim"])>0)	
			echo " | <a href=\"kursDetay.php?user=".$_GET["kim"]."\" target='_parent'>$metin[461]</a>";
	 echo "</p>";
	 }
 } else
  echo "$metin[540]";  

?>