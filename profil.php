<?php
session_start();
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
veritaban�na ba�lan
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
    //$metin = str_replace('"', '�', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "�", $metin);
    $metin = str_replace(">", "�", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}
/*
getUserIDrate:
kullan�c�n�n kimlik bilgisi
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
Sec2Time22:
saniyenin �st birime d�n��t�r�lmesi
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
kullAdi:
kullan�c�n�n ad�
*/
function kullAdi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userName FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "userName"));
    }else {
	   return ("");
	}
}
/*
kullGercekAdi:
kullan�c�n�n ger�ek ad�
*/
function kullGercekAdi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT realName FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "realName"));
    }else {
	   return ("");
	}
}
/*
kullTur:
kullan�c�n�n t�r�
*/
function kullTur($id)
{
	global $yol1;
	global $metin;
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userType FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
		switch (mysql_result($result1, 0, "userType")){
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
kullan�c�n�n �yelik tarihi
*/
function uyeTarihi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT requestDate FROM eo_users where id='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return date("d-m-Y", strtotime((mysql_result($result1, 0, "requestDate"))));
    }else {
	   return ("");
	}
}
/*
sonGiris:
kullan�c�n�n son giri� tarihi
*/
function sonGiris($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT dateTime FROM eo_usertrack where userName='".kullAdi($id)."' and processName='login.php' and otherInfo='success,Login' order by dateTime DESC limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return date("d-m-Y", strtotime((mysql_result($result1, 0, "dateTime"))));
    }else {
	   return ("");
	}
}
/*
girisSayisi:
kullan�c�n�n giri� say�s�
*/
function girisSayisi($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_usertrack where userName='".kullAdi($id)."' and processName='login.php' and otherInfo='success,Login' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
girisSayisiRank:
kullan�c�n�n giri� say�s� seviyesi
*/
function girisSayisiRank($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userName ,count(eo_usertrack.id) as say 
		FROM eo_usertrack
		where processName='login.php' and otherInfo='success,Login' 
		group by userName
		order by say DESC, userName"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysql_numrows($result1);$i++){
			 $rank = $i + 1;
			 if(mysql_result($result1, $i, "userName")==kullAdi($id)) break;
		 }
		  
       return ($rank."/".@mysql_numrows($result1));
    }else {
	   return (0);
	}
	return 0;
}
/*
sayfaEklemeSay:
��retmenin sayfa ekleme say�s�
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
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1 && mysql_numrows($result1) == 1)
				{
				   return (mysql_result($result1, 0, "say"));
				}else {
				   return ("");
				}
}
/*
dersCalismaSay:
kullan�c�n�n ders �al��mas say�s�
*/
function dersCalismaSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
dersCalismaSure:
kullan�c�n�n ders �al��ma s�resi
*/
function dersCalismaSure($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT sum(toplamZaman) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
dersCalismaOrt:
kullan�c�n�n ders �al��ma ortalamas�
*/
function dersCalismaOrt($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(lastPage) as say FROM eo_userworks where userID='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
yorumSay:
kullan�c�n�n yorum say�s�
*/
function yorumSay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_comments where userID='".$id."' and active=1 limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
yorumSayPasif:
kullan�c�n�n pasif yorum say�s�
*/
function yorumSayPasif($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_comments where userID='".$id."' and active<>'1' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
oySay:
kullan�c�n�n oy say�s�
*/
function oySay($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT count(*) as say FROM eo_rating where userID='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
oyOrt:
kullan�c�n�n oy ortalamas� 
*/
function oyOrt($id)
{
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT avg(value) as say FROM eo_rating where userID='".$id."' limit 0,1"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1){
       return (mysql_result($result1, 0, "say"));
    }else {
	   return ("");
	}
}
/*
getOgrenciSiniflari2:
kullan�c�n�n s�n�f bilgileri
*/
function getOgrenciSiniflari2($id){
	global $yol1;
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT * FROM eo_sinifogre, eo_2sinif, eo_1okul where eo_sinifogre.userID='".
				$id."' and eo_sinifogre.sinifID = eo_2sinif.id and eo_1okul.id = eo_2sinif.okulID 
				order by eo_2sinif.sinifAdi ";	
    
	$result1 = mysql_query($sql1, $yol1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= $row_gelen['sinifAdi']." (".$row_gelen['okulAdi']."), ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     
				   return ($ekle);
				}else {
				   return ("");
				}
}
/*
dersCalismaOrtRank:
kullan�c�n�n ders �al��ma d�zeyi
*/
function dersCalismaRank($id){
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userID ,count(id) as say 
		FROM eo_userworks
		where userID>0 
		group by userID
		order by say DESC, userID"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysql_numrows($result1);$i++){
			 $rank = $i + 1;
			 if(mysql_result($result1, $i, "userID")==$id ) break;
		 }
		  
       return ($rank."/".@mysql_numrows($result1));
    }else {
	   return (0);
	}
	return 0;
}
/*
dersCalismaOrtRank:
kullan�c�n�n ders �al��ma ortalama d�zeyi
*/
function dersCalismaOrtRank($id){
	global $yol1;	
	$id = substr(temizle2($id),0,15);
    $sql1 = "SELECT userID , avg(lastPage) as say 
		FROM eo_userworks
		where userID>0 
		group by userID
		order by say DESC, userID"; 	
    $result1 = mysql_query($sql1, $yol1); 

    if ($result1){
		$rank=0;
		 for($i=0; $i<@mysql_numrows($result1);$i++){
			 $rank = $i + 1;
			 if(mysql_result($result1, $i, "userID")==$id ) break;
		 }
		  
       return ($rank."/".@mysql_numrows($result1));
    }else {
	   return (0);
	}
	return 0;
}

/*main*/
 if (isset($_GET['kim']) && is_numeric($_GET['kim']) && $_GET['kim']>0 && getUserIDrate($_SESSION["usern"],$_SESSION["userp"])!="" ) {
		echo "<h3>$metin[312]</h3>";
		echo "<strong>$metin[17] :</strong> ".kullAdi($_GET["kim"])." - <span style='text-transform: capitalize;'>".strtolower(kullGercekAdi($_GET["kim"]))."</span><br/>";
		echo "<strong>$metin[22] :</strong> ".kullTur($_GET["kim"])."<br/>";
		echo "<strong>$metin[23] :</strong> ".uyeTarihi($_GET["kim"])."<br/>";
	if(sonGiris($_GET["kim"])!="")	
		echo "<strong>$metin[313] :</strong> ".sonGiris($_GET["kim"])."<br/>";
	if(getOgrenciSiniflari2($_GET["kim"])!="")	
		echo "<strong>$metin[314] :</strong> ".getOgrenciSiniflari2($_GET["kim"])."<br/>";

	$rank1 = ((girisSayisiRank($_GET["kim"])>0)?"$metin[324] ".girisSayisiRank($_GET["kim"]):"");	
	if(girisSayisi($_GET["kim"])>0)
		echo "<strong>$metin[315] :</strong> ".girisSayisi($_GET["kim"])." <u>$rank1</u><br/>";
		
	$rank2 = ((dersCalismaRank($_GET["kim"])>0)?"$metin[324] ".dersCalismaRank($_GET["kim"]):"");	
	if(dersCalismaSay($_GET["kim"])>0)
		echo "<strong>$metin[316] :</strong> ".dersCalismaSay($_GET["kim"])." <u>$rank2</u><br/>";
		
	if(dersCalismaSure($_GET["kim"])!="")
		echo "<strong>$metin[317] :</strong> ".Sec2Time22(dersCalismaSure($_GET["kim"]))."<br/>";
		
	$rank3 = ((dersCalismaOrtRank($_GET["kim"])>0)?"$metin[324] ".dersCalismaOrtRank($_GET["kim"]):"");	
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
		echo " ($metin[323] ".round(oyOrt($_GET["kim"]),1).")";
	if($_GET['set']!="1"){
		echo"<br/><br/>";
		echo "<a href=\"mail.php?to=".$_GET["kim"]."\" class=\"external\" onclick='window.open(\"mail.php?to=".$_GET["kim"]."\");return false;'>$metin[69]</a>";
	 }
 } else
  echo "EMPTY";  


?>