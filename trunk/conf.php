<?php
require 'lib/flood-protection.php'; // include the class
require 'database.php'; 

	$protect = new flood_protection();
	$protect -> host 		= $_host;
	$protect -> password 	= $_password; 
	$protect -> username 	= $_username; 
	$protect -> db 			= $_db; 	


	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];

function baglan()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan())   die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");

$yol 	= 	baglan();
$yol1	=	baglan();		

	if (!@mysql_select_db($_db, $yol))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}else{
		$sql = "SELECT * FROM eo_users";	
		$yol = baglan();
		$result = @mysql_query($sql, $yol);
		if(!$result)
			die("<font id='hata'> Tablo <a href=install.php>kurulumunu (installation)</a> yapmad&#305;n&#305;z!</font>");
		@mysql_free_result($result); 	
	}

function temizle($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("\'", "`", $metin);
    $metin = str_replace('\"', '�', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "�", $metin);
    $metin = str_replace(">", "�", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}

function browserdili() {
         $lang=split('[,;]',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=split('[-]',$lang);
         return $lang[0];
}

function check_source()  
{  
	global  $_source1;
	global  $_source2;
	
  if ( eregi("^$_source1",$_SERVER[HTTP_REFERER]) || eregi("^$_source2",$_SERVER[HTTP_REFERER]) 
  	  ) { 
	//header("Location:hata.html");
    return true;
  }
  else  
    return false;  
}  

function sessionDestroy(){
	  @session_destroy();
	  @session_start(); 	  
}

function temaBilgisi(){
	$result = "silverModern";
	$adresten = RemoveXSS($_GET["theme"]);
	$cerezden = RemoveXSS($_COOKIE["theme"]);

	if($adresten!="")
	  {

		  setcookie("theme",$adresten,time()+60*60*24*30);
		  
		  switch ($adresten){
			  case "0":	$result="silverModern";break;
			  case "1":	$result="darkOrange";break;
			  case "2":	$result="lightGreen";break;
			  default:	$result="silverModern"; 			  
		  }
	  }
	  else{
		  switch ($cerezden){
			  case "0":	$result="silverModern";break;
			  case "1":	$result="darkOrange";break;
			  case "2":	$result="lightGreen";break;
			  default:	$result="silverModern"; 			  
		  }
	  }
	  
	  return $result;
}

function dilCevir($dil){
      if ($dil=="TR")
        require("lib/tr.php"); 
      elseif ($dil=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         
}

function araKalin($neyi)
{
	$sonuc="";
	
	$arayici =  temizle($_GET['arama']);   
	
	if ($arayici=="") return $neyi;
	
	$posit1=strpos($neyi, strtolower($arayici));	

	if($posit1>=0)
	  $sonuc=str_replace(strtolower($arayici), "��".strtolower($arayici)."``", $neyi);
	  	 
	$posit2=strpos($neyi, strtoupper($arayici));	

	if($posit2>=0)
	  $sonuc=str_replace(strtoupper($arayici), "��".strtoupper($arayici)."``", $sonuc);

    $sonuc=str_replace("��", "<font class='araSari'>", $sonuc);
    $sonuc=str_replace("``", "</font>", $sonuc);

	return $sonuc; 
}

function tarihOku($gelenTarih){
	//Y-m-d > d-m-Y 	
	return date("d-m-Y", strtotime($gelenTarih));
}

function tarihYap($gelenTarih){
	//d-m-Y > Y-m-d 
	if (date('Y-m-d', strtotime($gelenTarih))=="1970-01-01")
		return "0000-00-00";
	else
		return date('Y-m-d', strtotime($gelenTarih));
}

function tarihOku2($gelenTarih){
	//Y-m-d H:i:s > d-m-Y H:i:s
	return date('d-m-Y H:i:s', strtotime($gelenTarih));
}

function tarihYap2($gelenTarih){
	//d-m-Y H:i:s > Y-m-d H:i:s
	if (date('Y-m-d', strtotime($gelenTarih))=="1970-01-01 00:00:00")
		return "0000-00-00 00:00:00";
	else
		return date('Y-m-d H:i:s', strtotime($gelenTarih));
}

function currentFileCheck($fileName){
	global $currentFile; 
	if($currentFile!=$fileName ) die ("<font id='hata'>Dosya uyumlu de�il!</font>");
}	

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

function GetSQLValueStringNo($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

 $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

function validInput($gelen)  
{  
  $pattern 	= "[^a-z0-9A-Z]" ;  
  $valid	= ereg($pattern, $gelen) ;  
  if($valid) 
    return false;
   else
    return true;  
}  

function getTableSize($tableN){
	
	$yol1 = baglan();
	$res = mysql_query("SHOW TABLE STATUS LIKE '$tableN'", $yol1);
	if ($res) {
	  if(mysql_result($res, 0, "Data_free")>0) $araDeger = "<font color='red'><strong>".number_format(mysql_result($res, 0, "Data_free") ,0,",","."). " B</strong></font>";	
	  
	$sonuc = number_format(mysql_result($res, 0, "Data_length") + 
							mysql_result($res, 0, "Index_length"),0,",",".")." B " .$araDeger ;
 	 @mysql_free_result($res); 			
	  return  $sonuc ;
	}
	
	return 0;
}

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
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='lessonsEdit.php?tab=1&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a>, ";
				     
				   $sonuc = substr($sonuc,0,strlen($sonuc)-2);
				   if (empty($sonuc)) 
				     	$sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[218]";
					 else
					 	$sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[219] : ".$sonuc;
				}					
		   
		 break;
		 case "eo_3ders":
		 
				$sql1 =    "SELECT eo_3ders.id 
							FROM eo_3ders
							LEFT OUTER JOIN eo_2sinif ON eo_2sinif.id  = eo_3ders.sinifID
							WHERE eo_2sinif.sinifAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='lessonsEdit.php?tab=2&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				   $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[220]"; 
				   else 					 
				   $sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[221] : ".$sonuc;
				}					
		   
		 break;
		 case "eo_4konu":
		 
				$sql1 =    "SELECT eo_4konu.id 
							FROM eo_4konu
							LEFT OUTER JOIN eo_3ders ON eo_3ders.id  = eo_4konu.dersID
							WHERE eo_3ders.dersAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='lessonsEdit.php?tab=3&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				     $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[222]";
					 else
					 $sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[223] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT id ,oncekiKonuID
							FROM eo_4konu
							WHERE eo_4konu.oncekiKonuID<>0 ";
				

				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    {
							$sqlici =    "SELECT eo_4konu.id 
										FROM eo_4konu
										WHERE eo_4konu.id = ".$row_gelen['oncekiKonuID']  ;
							
			
							$resultici = mysql_query($sqlici, $yol1);
							if ($resultici){
								if (@mysql_numrows($resultici)==0)
							    	$sonuc2 .= "<a href='lessonsEdit.php?tab=3&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a> ";
							}
							@mysql_free_result($resultici); 	

					}
					
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[224]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[225] : ".$sonuc2;
				}					
		   
		 break;
		 case "eo_5sayfa":
		 
				$sql1 =    "SELECT eo_5sayfa.id 
							FROM eo_5sayfa
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_5sayfa.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='lessonsEdit.php?tab=4&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				     $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[226]";
					 else
					 $sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[227] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT eo_5sayfa.id 
							FROM eo_5sayfa
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_5sayfa.ekleyenID
							WHERE eo_users.userName is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc2 .= "<a href='lessonsEdit.php?tab=4&id=".$row_gelen['id']."&upd=1'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[228]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[229] : ".$sonuc2;
				}					
		   
		 break;
		 case "eo_userworks":
		 
				$sql1 =    "SELECT eo_userworks.id 
							FROM eo_userworks
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_userworks.userID
							WHERE eo_users.userName is NULL and eo_userworks.userID<>-1";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='dataWorkList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				    $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]";
					else
					$sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT eo_userworks.id 
							FROM eo_userworks
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_userworks.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc2 .= "<a href='dataWorkList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233] : ".$sonuc2;
				}					
		   
		 break;
		 case "eo_sinifogre":
		 
				$sql1 =    "SELECT eo_sinifogre.id 
							FROM eo_sinifogre
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_sinifogre.userID
							WHERE eo_users.userName is NULL ";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "[".$row_gelen['id']."] ";
				     
				   if (empty($sonuc)) 
				    $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[234]";
					else
					$sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[235] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT eo_sinifogre.id 
							FROM eo_sinifogre
							LEFT OUTER JOIN eo_2sinif ON eo_2sinif.id  = eo_sinifogre.sinifID
							WHERE eo_2sinif.sinifAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc2 .= "[".$row_gelen['id']."] ";
				     
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[236]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[237] : ".$sonuc2;
				}					
		   
		 break;
		 case "eo_comments":
		 
				$sql1 =    "SELECT eo_comments.id 
							FROM eo_comments
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_comments.userID
							WHERE eo_users.userName is NULL and eo_comments.userID<>-1";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='dataCommentList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				    $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]";
					else
					$sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT eo_comments.id 
							FROM eo_comments
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_comments.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc2 .= "<a href='dataCommentList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233] : ".$sonuc2;
				}					
		   
		 break;
		 case "eo_rating":
		 
				$sql1 =    "SELECT eo_rating.id 
							FROM eo_rating
							LEFT OUTER JOIN eo_users ON eo_users.id  = eo_rating.userID
							WHERE eo_users.userName is NULL and eo_rating.userID<>-1";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc .= "<a href='dataRatingList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc)) 
				    $sonuc = "<img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[230]";
					else
					$sonuc = "<img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[231] : ".$sonuc;
				}					
		   
				$sql1 =    "SELECT eo_rating.id 
							FROM eo_rating
							LEFT OUTER JOIN eo_4konu ON eo_4konu.id  = eo_rating.konuID
							WHERE eo_4konu.konuAdi is NULL";
				
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $sonuc2 = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $sonuc2 .= "<a href='dataRatingList.php'>[".$row_gelen['id']."]</a> ";
				     
				   if (empty($sonuc2)) 
				      $sonuc .= " - <img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[232]";
					  else
					  $sonuc .= " - <img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[233] : ".$sonuc2;
				}					
		   
		 break;
	 }
	@mysql_free_result($result1); 
	return $sonuc;
}

function getStats($num)
{
	global $metin;
	$num = (int) substr($num,0,15);
	
	switch($num){
		case 0:
		//&ouml;�rencilerden en fazla &ccedil;al��anlar
				$sql1 =    "SELECT eo_users.userName as userName,eo_users.id, count(*) as toplam 
							FROM eo_users,eo_userworks 
							WHERE userType=0 and eo_users.id = eo_userworks.userID
							GROUP BY userName
							ORDER BY toplam DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 1:
		//&ouml;�rencilerden en az &ccedil;al��anlar
				$sql1 =    "SELECT eo_users.userName as userName, eo_users.userType as userType, count(*) as toplam 
							FROM eo_users,eo_userworks 
							WHERE userType=0 and eo_users.id = eo_userworks.userID
							GROUP BY userName
							ORDER BY toplam ASC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = "";
				   if(@mysql_numrows($result1)<ayarGetir("ayar2int")) return "";
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= $row_gelen['userName'].", ";
				     
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 2:
		//en fazla &ccedil;al���lan konular
				$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu,eo_userworks 
							WHERE eo_4konu.id = eo_userworks.konuID
							GROUP BY konuAdi
							ORDER BY toplam DESC, konuAdi";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   if(mysql_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return "";
				   $sayGelen=1;
				   while($row_gelen = mysql_fetch_assoc($result1)){
				    $ekle .= "<li style=\"list-style-type:none;\"><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				   }
					
				   if(mysql_num_rows($result1)>0) $ekle .= "</ul>";
				  if (mysql_num_rows($result1) > ayarGetir("ayar2int"))	
				    $ekle .="<div><a href='getFullList.php?case=2' rel='facebox' class='more'>$metin[162]</a></div>";
			   	   @mysql_free_result($result1);	
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 3:
		//en az &ccedil;al���lan konular
				$sql1 =    "SELECT eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu 
							LEFT OUTER JOIN eo_userworks
							ON eo_4konu.id = eo_userworks.konuID
							GROUP BY konuAdi
							ORDER BY toplam ASC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= $row_gelen['konuAdi'].", ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
					@mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 4:
		//demo kullan�c�lar�n en fazla girdi�i dersler
				$sql1 =    "SELECT eo_4konu.id,eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu 
							LEFT OUTER JOIN eo_userworks
							ON eo_4konu.id = eo_userworks.konuID
							WHERE eo_userworks.userID=-1
							GROUP BY konuAdi
							ORDER BY toplam DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= "<a href='lessons.php?konu=".$row_gelen['id']."' >".$row_gelen['konuAdi']."</a>, " ;
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 6:
		//en fazla ders d&uuml;zenleyen &ouml;�retmenler/y&ouml;neticiler
				$sql1 =    "SELECT eo_users.userName as userName, eo_users.id, count(*) as toplam 
							FROM eo_5sayfa 
							LEFT OUTER JOIN eo_users
							ON eo_5sayfa.ekleyenID = eo_users.id
							WHERE eo_users.userType>0
							GROUP BY userName
							ORDER BY toplam DESC
							LIMIT 0,".ayarGetir("ayar2int");
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= "<a href=\"profil.php?kim=".$row_gelen['id']."\" rel='facebox'>"
					         .$row_gelen['userName']."</a>, ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 8:		
		//toplam &ccedil;al��ma s&uuml;resi
				$sql1 =    "SELECT SUM(eo_userworks.toplamZaman) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = mysql_result($result1, 0, "toplam");	 
				   @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
		case 9:
		//ortalama &ccedil;al��ma s&uuml;resi
				$sql1 =    "SELECT AVG(eo_userworks.toplamZaman) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = mysql_result($result1, 0, "toplam");	 	
				   @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
								
				break;
		case 10:
		//ortalama &ccedil;al��ma y&uuml;zdesi
				$sql1 =    "SELECT AVG(eo_userworks.lastPage) as toplam 
							FROM eo_userworks";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   $ekle = mysql_result($result1, 0, "toplam");	
				   @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;		
		case 11:
		//�u anki kullan�c�n�n &ccedil;al��ma konular� ve say�lar�
				$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
							FROM eo_4konu,eo_userworks, eo_users 
							WHERE eo_4konu.id = eo_userworks.konuID and eo_users.id = eo_userworks.userID
							      and eo_users.id = ".getUserID($_SESSION["usern"],$_SESSION["userp"])."
							GROUP BY konuAdi
							ORDER BY toplam DESC, konuAdi";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   if(mysql_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return "";	 
				   
				   $sayGelen = 1;
				   while($row_gelen = mysql_fetch_assoc($result1)){
				    $ekle .= "<li style='list-style-type:none;'><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				   }
					
				   	$ekle .= "</ul>";
					
					if (mysql_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=11' rel='facebox' class='more'>$metin[162]</a></div>"; 
					@mysql_free_result($result1);   
				   return ($ekle);
				}else {
				   return ("");
				}
				
				break;
				
		case 12:
		//�u anki kullan�c�n�n bitirdi�i dersler
				$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
									eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi, 
									sum(eo_userworks.toplamZaman) as toplam 
							FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
							WHERE eo_4konu.id = eo_userworks.konuID and 
								  eo_users.id = eo_userworks.userID and
								  eo_3ders.id = eo_4konu.dersID and
								  eo_2sinif.id = eo_3ders.sinifID and
								  eo_1okul.id = eo_2sinif.okulID and
							      eo_users.id = ".getUserID($_SESSION["usern"],$_SESSION["userp"])."
							GROUP BY dersAdi
							ORDER BY toplam DESC";
				
				$yol1 = baglan();
				$result1 = mysql_query($sql1, $yol1);
				if ($result1)
				{
				   if(mysql_num_rows($result1)>0 && ayarGetir("ayar2int")>0) $ekle = "<ul>"; else return ""; 
				   $sayGelen = 1;
				   while($row_gelen = mysql_fetch_assoc($result1)){
				    $ekle .= "<li style='list-style-type:none;'>".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - ".$row_gelen['dersAdi']." <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font></li>";
					$sayGelen++;
					if ($sayGelen > ayarGetir("ayar2int")) break 1;
				}
					
				   $ekle .= "</ul>";
				   
				   if (mysql_num_rows($result1) > ayarGetir("ayar2int"))	
					   $ekle .="<div><a href='getFullList.php?case=12' rel='facebox' class='more'>$metin[162]</a></div>"; 
					@mysql_free_result($result1);
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
					   "order by tarih desc,kadi ";	
				$yol = baglan();
				$result = mysql_query($sql, $yol);
				if($result)
				 {
					 if (@mysql_numrows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysql_numrows($result)<ayarGetir("ayar2int"))?@mysql_numrows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysql_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							if ($data["tarih"]=="0000-00-00 00:00:00")
								$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>";
								else
								$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>"." <font size='-3'>".tarihOku($data["tarih"])."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
				   
					   if (mysql_num_rows($result) > ayarGetir("ayar2int"))	
						   $ekle .="<div><a href='getFullList.php?case=13' rel='facebox' class='more'>$metin[162]</a></div>"; 
					   
					 }		
					 @mysql_free_result($result);
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
					   "order by ortalama desc,kadi";	
				$yol = baglan();
				$result = mysql_query($sql, $yol);
				if($result)
				 {
					 if (@mysql_numrows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysql_numrows($result)<ayarGetir("ayar2int"))?@mysql_numrows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysql_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a>".
								          " <font title='$metin[273] : ".$data["toplam"].", $metin[274] : ".round($data["ortalama"],1)
										  ."'>".yildizYap(round($data["ortalama"]))."</font>";								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
					 if (mysql_num_rows($result) > ayarGetir("ayar2int"))	
						   $ekle .="<div><a href='getFullList.php?case=14' rel='facebox' class='more'>$metin[162]</a></div>"; 
					   
					 }	
					 @mysql_free_result($result);
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
				$yol = baglan();
				$result = mysql_query($sql, $yol);
				if($result)
				 {
					 if (@mysql_numrows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysql_numrows($result)<ayarGetir("ayar2int"))?@mysql_numrows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysql_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
							if (mysql_num_rows($result) > ayarGetir("ayar2int"))	
						   		$ekle .="<div><a href='getFullList.php?case=15' rel='facebox' class='more'>$metin[162]</a></div>";
					 }		
					 @mysql_free_result($result);
					return $ekle; 
				}else {
				   return ("");
				}
				
				break;		
		case 16:
		//son demo �al��malar�
				$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
					   " count(*) as toplam ".
					   "from eo_userworks, eo_4konu ".
					   "where eo_userworks.konuID=eo_4konu.id ".
					   " and eo_userworks.userID=-1 ".
					   "GROUP BY kadi ".
					   "order by toplam desc,kadi";	
				$yol = baglan();
				$result = mysql_query($sql, $yol);
				if($result)
				 {
					 if (@mysql_numrows($result) > 0 && ayarGetir("ayar2int")>0) {
						
						$donguSon = (@mysql_numrows($result)<ayarGetir("ayar2int"))?@mysql_numrows($result):ayarGetir("ayar2int");
						
						$ekle =  "<ul>";
						for($i=0; $i<$donguSon ;$i++){
							$data = mysql_fetch_assoc($result);
							$ekle .=  "<li style='list-style-type:none;'>";
							$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
								
							$ekle .=  "</li>";
							}
							$ekle .=  "</ul>";
							if (mysql_num_rows($result) > ayarGetir("ayar2int"))	
						   		$ekle .="<div><a href='getFullList.php?case=16' rel='facebox' class='more'>$metin[162]</a></div>";
					 }		
					 @mysql_free_result($result);
					return $ekle; 
				}else {
				   return ("");
				}
				
				break;		
	} //switch	

return "";
}

function yildizYap($num){
	if($num>0 && $num<6){
		for($i=1;$i<=$num;$i++){
			$sonuc.="<img src='img/star.gif' border='0' style='vertical-align:middle' alt='star' />";
		}
	}else
		$sonuc = "problem";

	return $sonuc;	
}

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

function yorumlariGetir($konu){
    $sql1 = "SELECT eo_comments.id as comID ,eo_comments.comment, eo_comments.commentDate, eo_users.userName, eo_users.id as id
				FROM eo_comments, eo_users, eo_4konu 
				where 
				eo_comments.konuID = eo_4konu.id and eo_comments.userID = eo_users.id 
				and eo_comments.active = 1 and eo_4konu.id = ".$konu."
				order by eo_comments.commentDate";
	
    $yol1 = baglan();
	$result1 = mysql_query($sql1, $yol1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1)){
					  if($row_gelen['id'] == getUserID($_SESSION["usern"],$_SESSION["userp"]) || getUserType($_SESSION["usern"]) == 2 ) 
					 	$yorumSil = " - <a href='yorumSil.php?id=".$row_gelen['comID']."' rel='facebox'><img src=\"img/erase.png\" alt=\"delete\" width=\"16\" height=\"16\" border=\"0\" style=\"vertical-align: middle;\"  title=\"$metin[102]\"/> Yorumu Sil</a>";  
						else
						$yorumSil = "";
				    $ekle .= "<div class='yorumItem'><p>".smileAdd($row_gelen['comment'])." </p><a href='profil.php?kim=".$row_gelen['id']."' rel='facebox'>".$row_gelen['userName']."</a> - ".tarihOku2($row_gelen['commentDate'])." $yorumSil</div>";					
				   }
				   @mysql_free_result($result1);  
				   return ($ekle);
				}else {
				   return ("");
				}
	return ""; 
}

function isKonu($id){
	 
	$id = substr($id,0,15);
	if(is_numeric($id)){
			$sql1 = "SELECT id FROM eo_4konu where id='".temizle($id)."' limit 0,1";
			
			$yol1 = baglan();
			$result1 = @mysql_query($sql1, $yol1);
			if ($result1 && @mysql_numrows($result1) == 1)
			{   	
			@mysql_free_result($result1);
			   return true;
			}else {
			   return false;
			}
	}
	return false;
}

function konuAdiGetir($id){
	$id = substr($id,0,15);
    $sql1 = "SELECT konuAdi FROM eo_4konu where id='".temizle($id)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {  $sonuc = @mysql_result($result1, 0, "konuAdi");
	@mysql_free_result($result1); 	   
       return $sonuc;
    }else {
	   return "";
	}
	
	return "";
}

function konuYorumSayisiGetir($id){
	$id = substr($id,0,15);
    $sql1 = "SELECT count(*) as toplam FROM eo_comments where konuID='".temizle($id)."' and active=1";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {  
	    if(@mysql_result($result1, 0, "toplam")>0)
			$sonuc = " - ". @mysql_result($result1, 0, "toplam");
		@mysql_free_result($result1); 	   
       	return $sonuc;
    }else {
	   return "";
	}
	
	return "";
}

function getOgrenciSiniflari(){
	$usernam = getUserID($_SESSION["usern"],$_SESSION["userp"]); 
	
    $sql1 = "SELECT * FROM eo_sinifogre, eo_2sinif, eo_1okul where eo_sinifogre.userID='".
				temizle($usernam)."' and eo_sinifogre.sinifID = eo_2sinif.id and eo_1okul.id = eo_2sinif.okulID 
				order by eo_2sinif.sinifAdi ";
	
    $yol1 = baglan();
	$result1 = mysql_query($sql1, $yol1);
		if ($result1)
				{
				   $ekle = "";	 
				   while($row_gelen = mysql_fetch_assoc($result1))
				    $ekle .= $row_gelen['sinifAdi']." (".$row_gelen['okulAdi']."), ";
					
				   $ekle = substr($ekle,0,strlen($ekle)-2);	 //son , silindi
				     @mysql_free_result($result1);
				   return ($ekle);
				}else {
				   return ("");
				}
}

function getpasifYorumlar(){
    $sql1 = "SELECT count(*) as sayac FROM eo_comments where active <> 1 ";
	
    $yol1 = baglan();
	$result1 = mysql_query($sql1, $yol1);
		if ($result1 && @mysql_numrows($result1) > 0)
				{  $sonuc = @mysql_result($result1, 0, "sayac")	;
				   @mysql_free_result($result1);		     
				   return ($sonuc);
				}else {
				   return 0;
				}	
}

function checkRealUser($usernam, $passwor)
{
	$usernam = substr($usernam,0,15);
	
	if (!validInput($usernam) || !validInput($passwor)) return -2;
	
    $sql1 = "SELECT realName, userName, userPassword, userType FROM eo_users where userName='".temizle($usernam)."' AND userPassword='".temizle($passwor)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {
   	   $_SESSION["userr"] 	= temizle(@mysql_result($result1, 0, "realName"));
	   $sonuc = @mysql_result($result1, 0, "userType");
	   @mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (-2);
	}
}

function kullaniciHakSayisi($gelen, $adi, $par){
	
	$kulID = getUserID($adi, $par);
	
    $sql1 = "SELECT count(*) as toplam FROM eo_userworks where userID='$kulID' and konuID='".temizle($gelen)."'";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1)
    {  $sonuc =@mysql_result($result1, 0, "toplam");
	   @mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}
}

function getUserType($usernam)
{
	$usernam = substr($usernam,0,15);
    $sql1 = "SELECT userType FROM eo_users where userName='".temizle($usernam)."' limit 0,1";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {	$sonuc = @mysql_result($result1, 0, "userType");
	@mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (-2);
	}
}

function getUserID($usernam, $passwor)
{
	$usernam = substr($usernam,0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle($usernam)."' AND userPassword='".temizle($passwor)."' limit 0,1"; 
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    { 
	   $sonuc = @mysql_result($result1, 0, "id");	
	   @mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (-1);
	}
}

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
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {  $sonuc = @mysql_result($result1, 0, "total");
	@mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}
}

function getTrackCount($isBad){
	
	if ($isBad) 	
		$sql1 = "SELECT count(*) as total FROM eo_usertrack where otherInfo like 'fail%'";
	else
		$sql1 = "SELECT count(*) as total FROM eo_usertrack";
	
    $yol1 = baglan();
    $result1 = @mysql_query($sql1, $yol1);
    if ($result1 && @mysql_numrows($result1) == 1)
    {	$sonuc = @mysql_result($result1, 0, "total");
		@mysql_free_result($result1);
       return ($sonuc);
    }else {
	   return (0);
	}	
}

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
    return trim(htmlspecialchars(stripslashes($ret))); 
}
	
function trackUser($processName, $otherInfo, $userName)
{
	global $yol1;
	
	$CurrentRemoteAddr=GetVar("REMOTE_ADDR", NULL);	
	$datem	=	date("Y-n-j H:i:s");
	
	$processName	=temizle($processName);
	$otherInfo		=temizle($otherInfo);
	$userName		=temizle($userName);
	
	$sql1	= 	"Insert into eo_usertrack VALUES (NULL , '$CurrentRemoteAddr', '$datem' , '$processName', '$userName', '$otherInfo')";
	$result1= 	@mysql_query($sql1,$yol1);
	$sonuc =$result1; 
	@mysql_free_result($result1);
	return $sonuc;
}

function trackUserLesson($userID, $konuID, $zaman, $sonSayfa)
{
	global $yol1;
	
	$datem	=	date("Y-n-j H:i:s");
	
	$userID		=temizle($userID);
	$konuID		=temizle($konuID);
	$zaman		=temizle($zaman);
	$sonSayfa	=temizle($sonSayfa);
	
	$sql1	= 	"Insert into eo_userworks VALUES (NULL , '$userID', '$konuID' , '$zaman', '$sonSayfa', '$datem')";
	$result1= 	@mysql_query($sql1,$yol1);
	@mysql_free_result($result1);
	return $result1;
}

function newPassw()
{
   $seed="";
   for ($i = 1; $i <= 8; $i++)
       $seed .= substr('0123456789abcdefghijklmnoprstuvyz', rand(1,32), 1);
   return ($seed);
}

function email_valid ($email) {  
	if (eregi("^[a-z0-9._-]+@[a-z0-9._-]+.[a-z]{2,6}$", $email)) 
    	{ return TRUE; } else { return FALSE; }      
} 

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
	$result2	= @mysql_query($sql2,$yol1);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-9' . "\r\n";
//	$headers .= 'From: tbagriyanik@gmail.com' . "\r\n" .'Reply-To: tbagriyanik@gmail.com' . "\r\n" .
//							   'X-Mailer: PHP/' . phpversion();
	
   if ($result2 && @mysql_numrows($result2) == 1){
	if (@mail($email, "eOgr Parola", "Merhaba, eOgr projesindeki:\nKullanici Adiniz = $userName \nYeni Parolaniz= $yeni \n Iyi gunler dileriz.", $headers))
	    {         
			$sql1	= 	"Update eo_users SET userPassword='".sha1($yeni)."' where userName='$userName' and userEmail='$email'";
			$result1= 	@mysql_query($sql1,$yol1);
			if($result1)
			  $result1 = "allOK";
			  else
			  $result1 = "noChange";
		}	else 
		 	$result1="mailErr";
    }   else
	   $result1="noUser";
   @mysql_free_result($result2);
	return $result1;	
}

function newUserMail($userName, $email)
{
	global $yol1;
	
	$result1="";
	
	$userName	=trim(substr(temizle($userName),0,15));
	$email		=trim(substr(temizle($email),0,50));
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-9' . "\r\n";
//	$headers .= 'From: tbagriyanik@gmail.com' . "\r\n" .'Reply-To: tbagriyanik@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	
	if ($userName=="" || $email=="") return "emptyData";
	
	if (@mail(ayarGetir("ayar4char"), "eOgr Yeni Uye/New User", "eOgr Yeni Uye/New User:\nKullanici Adi = $userName \nEposta Adresi= $email \n Iyi gunler dileriz.",$headers))
	    {         
			  $result1 = "allOK";
		}	
		else 
		 	$result1="mailErr";
      
	
	return $result1;	
}

function getMailAddress($id){	
	global $yol1;
	
	$sql1	= 	"select userEmail from eo_users where id=".$id. " limit 0,1";
	$result1= 	@mysql_query($sql1,$yol1);
	
	if ($result1)
	    {         
			$result1 = @mysql_result($result1,0,"userEmail");
		}	     
	@mysql_free_result($result1);
	return $result1;	
}

function addnewUser($realName, $userName, $password, $email, $birth)
{
	global $yol1;

	$datem	=	date("Y-n-j H:i:s");
     
	if (strlen($realName)<5 || strlen($userName)<5 ||  strlen($email)<5 ||  strlen($birth)<5 || strlen($password)<5 ||
		strlen($realName)>30 || strlen($userName)>15 ||  strlen($email)>50 ||  strlen($birth)>10 || strlen($password)>15 ) return false; 
	
	if ($realName=="" || $userName=="" || $password=="" || $email=="" || $birth=="") return false;
	
	if ( !validInput($userName) || !validInput($password) ) return false;
  
	$realName	=trim(substr(temizle($realName),0,30));
	$userName	=trim(substr(temizle($userName),0,15));
  	$password	=trim(substr(temizle($password),0,15));
	$email		=trim(substr(temizle($email),0,50));
  	$birth		=tarihYap(trim(substr(temizle($birth),0,10)));
	
	$sql1	= 	"Insert into eo_users VALUES (NULL , '$userName', '".sha1($password)."' , '$realName', '$email', '$birth', '0', '$datem')";

	$result1= 	@mysql_query($sql1,$yol1);
	@mysql_free_result($result1);
	return $result1;
}

function getGrafikValues($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		$result = mysql_query($sql, $yol1);
		$data = array();
		while($row = mysql_fetch_assoc($result)) {
			if($row['count']>20) 
			  $data['values'][] = 20;
			else
		      $data['values'][] = $row['count'];
		}
		return $data['values'];
}

function getGrafikLabels($lmt){
	global $yol1;
	
		$sql = "SELECT DATE_FORMAT(calismaTarihi, '%d') AS date FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24  <= $lmt GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y') order by calismaTarihi";
		$result = mysql_query($sql, $yol1);
		$data = array();
		while($row = mysql_fetch_assoc($result)) {
		  $data['labels'][] = $row['date'];
		}
		return $data['labels'];
}

function getGrafikMax($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks WHERE (unix_timestamp(now()) - unix_timestamp(calismaTarihi) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(calismaTarihi, '%d-%m-%y')  order by count DESC limit 0,1";
		$result = mysql_query($sql, $yol1);
		$row = mysql_fetch_assoc($result);
			if($row['count']>20) 
			  return 20;
			else
		      return $row['count'];
}

function getGrafikRecordCount(){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_userworks ";
		$result = mysql_query($sql, $yol1);
		$row = mysql_fetch_assoc($result);
		return $row['count'];
}

function getGrafikValues2($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(dateTime, '%d-%m-%y') order by dateTime";
		$result = mysql_query($sql, $yol1);
		$data = array();
		while($row = mysql_fetch_assoc($result)) {
			if($row['count']>20) 
			  $data['values'][] = 20;
			else
		      $data['values'][] = $row['count'];
		}
		return $data['values'];
}

function getGrafikLabels2($lmt){
	global $yol1;
	
		$sql = "SELECT DATE_FORMAT(dateTime, '%d') AS date FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(dateTime, '%d-%m-%y') order by dateTime";
		$result = mysql_query($sql, $yol1);
		$data = array();
		while($row = mysql_fetch_assoc($result)) {
		  $data['labels'][] = $row['date'];
		}
		return $data['labels'];
}

function getGrafikMax2($lmt){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_usertrack WHERE (unix_timestamp(now()) - unix_timestamp(dateTime) )/3600/24 <= $lmt GROUP BY DATE_FORMAT(dateTime, '%d-%m-%y')  order by count DESC limit 0,1";
		$result = mysql_query($sql, $yol1);
		$row = mysql_fetch_assoc($result);
			if($row['count']>20) 
			  return 20;
			else
		      return $row['count'];
}

function getGrafikRecordCount2(){
	global $yol1;
	
		$sql = "SELECT COUNT(*) AS count FROM eo_usertrack ";
		$result = mysql_query($sql, $yol1);
		$row = mysql_fetch_assoc($result);
		return $row['count'];
}

function ayTr($sayi){
	switch($sayi){
		case 1: return "Ocak";
		case 2: return "�ubat";
		case 3: return "Mart";
		case 4: return "Nisan";
		case 5: return "May�s";
		case 6: return "Haziran";
		case 7: return "Temmuz";
		case 8: return "A�ustos";
		case 9: return "Eyl�l";
		case 10: return "Ekim";
		case 11: return "Kas�m";
		case 12: return "Aral�k";
	}
}
function getSchoolNames()
{
	global $yol1;
	
	$sql1	= 	"select id,okulAdi from eo_1okul order by okulAdi";
	$result1= 	@mysql_query($sql1,$yol1);
	
	$i=0;
	$sonuc="";
	while($i<@mysql_numrows($result1)) 
	{
		$sonuc .= "<option value='".@mysql_result($result1,$i,"id")."'>".@mysql_result($result1,$i,"okulAdi")."</option>";
		$i++;
	}
	@mysql_free_result($result1);
	return $sonuc;
}

function checkUserName($name)
{
	global $yol1;
	
	$sql1	= 	"select count(*) as adet from eo_users where userName='".temizle($name)."'";
	$result1= 	@mysql_query($sql1,$yol1);
	
	if(@mysql_numrows($result1)>0){
  	 if(@mysql_result($result1,0,"adet")==0) {	
	  @mysql_free_result($result1);
	  return false;
	 }
	 else
  		return true;
	}else
	return false;
}

function getUserID2($name){
	global $yol1;
	
	$sql1	= 	"select id from eo_users where userName='".temizle($name)."'";
	$result1= 	@mysql_query($sql1,$yol1);
	
	if(@mysql_numrows($result1)>0)
	 	return @mysql_result($result1,0,"id");
	 else
  		return "(unknown)";	
}

function getKonuAdi($id){
	global $yol1;
	
	$sql1	= 	"select konuAdi from eo_4konu where id='".temizle($id)."'";
	$result1= 	@mysql_query($sql1,$yol1);
	
	if(@mysql_numrows($result1)>0)
	 	return @mysql_result($result1,0,"konuAdi");
	 else
  		return "";	
}

function checkEmail($name)
{
	global $yol1;
	
	$sql1	= 	"select count(*) as adet from eo_users where userEmail='".temizle($name)."'";
	$result1= 	@mysql_query($sql1,$yol1);
	
   if(@mysql_numrows($result1)>0){
		if(@mysql_result($result1,0,"adet")==0)	
		 return false;
		else
		 return true;		
   }else
  		return false;
}

function checkKonu($name)
{
	global $yol1;
	
	$sql1	= 	"select id from eo_4konu where konuAdi='".temizle($name)."'";

	$result1= 	@mysql_query($sql1,$yol1);

   if(@mysql_numrows($result1)>0)
	return (@mysql_result($result1,0,"id")==""?"":@mysql_result($result1,0,"id"));
	else
	return "";
}

function sayfaGetir($konuID, $sayfaNo)
{
	global $yol1;
	
	$sql1	= 	"select id,anaMetin from eo_5sayfa where konuID='".temizle($konuID)."' order by id";
	$result1= 	@mysql_query($sql1,$yol1);

   if(@mysql_numrows($result1)>0){
	if(@mysql_result($result1,0,"id")!="")
		$msg = html_entity_decode(@mysql_result($result1,$sayfaNo,"anaMetin"));
	}else	
		$msg = "<font id='uyari'>Bir konu se&ccedil;iniz...</font>";			 
   
   @mysql_free_result($result1);
	return $msg;
}

function ayarGetir($ayarAdi)
{
	global $yol1;
	
	$sql1	= 	"select ".temizle($ayarAdi)." from eo_sitesettings where id=1"; 
	$result1= 	@mysql_query($sql1,$yol1);

   if(@mysql_numrows($result1)>0){
	if(@mysql_result($result1,0,"$ayarAdi")!="")
		$sonuc = @mysql_result($result1,0,"$ayarAdi");
	}else	
		$sonuc = "";			 
   
   @mysql_free_result($result1);
	return $sonuc;
}

function ayarGetir2($ayarAdi)
{
	global $yol1;
	
	$sql1	= 	"select ".temizle($ayarAdi)." from eo_webref_rss_details where id=1";
	$result1= 	@mysql_query($sql1,$yol1);

   if(@mysql_numrows($result1)>0){
	if(@mysql_result($result1,0,"$ayarAdi")!="")
		$sonuc = @mysql_result($result1,0,"$ayarAdi");
	}else	
		$sonuc = "";			 
   
   @mysql_free_result($result1);
	return $sonuc;
}

function haberGetir($kayno, $alanAdi)
{
	global $yol1;
	
	$sql1	= 	"select ".temizle($alanAdi)." FROM eo_webref_rss_items	ORDER BY pubDate DESC LIMIT 1 OFFSET ".temizle($kayno);
	$result1= 	@mysql_query($sql1,$yol1);
   
	return @mysql_result($result1,0,"$alanAdi");
}

function smartShort($gelen){
	return (strlen($gelen)>20)?substr($gelen,0,17)."...":$gelen;
}

function getDersIDileSinif($gelen){
	$sql1 = "SELECT distinct eo_2sinif.id as id FROM eo_4konu 
	 		inner join eo_5sayfa on eo_4konu.id=eo_5sayfa.konuID 
	 		inner join eo_3ders on eo_4konu.dersID=eo_3ders.id 
			inner join eo_2sinif on eo_2sinif.id=eo_3ders.sinifID 
			where eo_4konu.id=".$gelen;
			
    $yol1 = baglan();
	$result1 = mysql_query($sql1, $yol1);
		if ($result1)
		  if (@mysql_numrows($result1)>0)
		   return (@mysql_result($result1,0,"id"));
@mysql_free_result($result1);
return "0";			
}

function ogrenciSinifaDahil($adi, $par, $gelen){
	$ogrID = getUserID($adi,$par);
	
    $sql1 = "SELECT count(*) as toplam FROM eo_sinifogre where eo_sinifogre.userID='".
			 $ogrID."' and eo_sinifogre.sinifID = ".getDersIDileSinif($gelen) ;
	
    $yol1 = baglan();
	$result1 = mysql_query($sql1, $yol1);
		if ($result1){
		   return (@mysql_result($result1,0,"toplam"));
		}
@mysql_free_result($result1);
return "0";
}

function dersAgaci($gelen=null){
	global $yol1;
	global $metin;
	
	if (!isset($gelen)) {
					
					$sqlOkul 	= "select * from eo_1okul order by okulAdi";
					$okulAdlari = mysql_query($sqlOkul, $yol1);
					$i=0;if(@mysql_numrows($okulAdlari)>0)echo "<ul>";
					while($i<@mysql_numrows($okulAdlari)){
				?>
				
				<li  style='list-style-type:none;' title='<?php echo $metin[296]?>'><a href="#"><span><span style="font-family:'Courier New', Courier, monospace;margin-left:0px;padding-left:0px;">
				  <?php 
				    echo smartShort(@mysql_result($okulAdlari,$i,"okulAdi"));
					$boyut=20-strlen(smartShort(@mysql_result($okulAdlari,$i,"okulAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
                  </span></span>
                  </a>
				  
					<?php
								$sqlSinif 	= "select * from eo_2sinif where okulID = '".@mysql_result($okulAdlari,$i,"id")."' order by sinifAdi";
								$sinifAdlari = mysql_query($sqlSinif, $yol1);
								$j=0;
								if(@mysql_numrows($sinifAdlari)>0) echo "<ul>";
								while($j<@mysql_numrows($sinifAdlari)){		   
						   ?>
					<li title='<?php echo $metin[297]?>'><a href="#"><span><span style="font-family:'Courier New', Courier, monospace">
					  <?php
					 echo smartShort(@mysql_result($sinifAdlari,$j,"sinifAdi")); 
					$boyut=20-strlen(smartShort(@mysql_result($sinifAdlari,$j,"sinifAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
					  </span></span></a>
					  
						<?php
										$sqlDers 	= "select * from eo_3ders where sinifID = '".@mysql_result($sinifAdlari,$j,"id")."' order by dersAdi";
										$dersAdlari = mysql_query($sqlDers, $yol1);
										$k=0;
										if(@mysql_numrows($dersAdlari)>0) echo "<ul>";
										while($k<@mysql_numrows($dersAdlari)){		   
									?>
						<li title='<?php echo $metin[298]?>'><a href="#"><span><span style="font-family:'Courier New', Courier, monospace">
					  <?php
					 echo smartShort(@mysql_result($dersAdlari,$k,"dersAdi")); 
					$boyut=20-strlen(smartShort(@mysql_result($dersAdlari,$k,"dersAdi")));
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?> 
				  &#8250;
						  </span></span></a>
						  
						  <?php
										$sqlKonu 	= "select * from eo_4konu where dersID = '".@mysql_result($dersAdlari,$k,"id")."' order by konuAdi";
										$konuAdlari = mysql_query($sqlKonu, $yol1);
										$l=0;
										if(@mysql_numrows($konuAdlari)>0) echo "<ul>";
										while($l<@mysql_numrows($konuAdlari)){		   
												$sqlSayfa 	= "select count(*) as toplam from eo_5sayfa where konuID = '".
														@mysql_result($konuAdlari,$l,"id")."'";
												$sayfaSayisi = mysql_query($sqlSayfa, $yol1);
												$s_sayisi = mysql_result($sayfaSayisi,0,"toplam");													   						  ?>
										<li title='<?php echo $metin[299]?>'><a href="lessons.php?konu=<?php echo @mysql_result($konuAdlari,$l,"id")?>"><span><span style="font-family:'Courier New', Courier, monospace">
										  <?php echo smartShort(@mysql_result($konuAdlari,$l,"konuAdi"))?>
						  <?php echo (mysql_result($konuAdlari,$l,"konuyuKilitle")?"<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />":"")?>
                          <?php echo (mysql_result($konuAdlari,$l,"sadeceKayitlilarGorebilir")?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />":"")?>
                          <?php echo (mysql_result($konuAdlari,$l,"calismaSuresiDakika")?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"")?>
                          <?php 
						  if($s_sayisi==0) 
						     echo "<img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[209]."\" title=\"".$metin[209]."\" />";
						  ?>
										  </span></span></a>
										  </li>
						  <?php
											$l++;
											}
											if(@mysql_numrows($konuAdlari)>0) echo "</ul>";
						  ?>

						</li>
						<?php
										$k++;
										}
										if(@mysql_numrows($dersAdlari)>0) echo "</ul>";
									?>
					  
					</li>
					<?php
								$j++;
								}
								if(@mysql_numrows($sinifAdlari)>0) echo "</ul>";
							?>
				</li>
				<?php	
						$i++;
					}	
					if(@mysql_numrows($okulAdlari)>0) echo "</ul>";
	}else
	{
					
					$sqlOkul 	= "select * from eo_1okul order by okulAdi";
					$okulAdlari = mysql_query($sqlOkul, $yol1);
					$i=0;if(@mysql_numrows($okulAdlari)>0) echo "<ul>";
					while($i<@mysql_numrows($okulAdlari)){
				?>
				
				<li style="color:#C9F;list-style-type:none;" title='<?php echo $metin[296]?>'>
				  <?php echo (@mysql_result($okulAdlari,$i,"okulAdi"))?>
				  
					<?php
								$sqlSinif 	= "select * from eo_2sinif where okulID = '".@mysql_result($okulAdlari,$i,"id")."' order by sinifAdi";
								$sinifAdlari = mysql_query($sqlSinif, $yol1);
								$j=0;
								if(@mysql_numrows($sinifAdlari)>0) echo "<ul>";
								while($j<@mysql_numrows($sinifAdlari)){		   
						   ?>
					<li style="list-style-type:none;color:#C3F" title='<?php echo $metin[297]?>'>
					  <?php echo (@mysql_result($sinifAdlari,$j,"sinifAdi"))?> 
						<?php
										$sqlDers 	= "select * from eo_3ders where sinifID = '".@mysql_result($sinifAdlari,$j,"id")."' order by dersAdi";
										$dersAdlari = mysql_query($sqlDers, $yol1);
										$k=0;
										if(@mysql_numrows($dersAdlari)>0) echo "<ul>";										
										while($k<@mysql_numrows($dersAdlari)){		   
									?>
						<li style="list-style-type:none;color:#C0F" title='<?php echo $metin[298]?>'>
						  <?php echo (@mysql_result($dersAdlari,$k,"dersAdi"))?>
						  
						  <?php
										$sqlKonu 	= "select * from eo_4konu where dersID = '".@mysql_result($dersAdlari,$k,"id")."' order by konuAdi";
										$konuAdlari = mysql_query($sqlKonu, $yol1);
										$l=0;
										if(@mysql_numrows($konuAdlari)>0) echo "<ul>";
										while($l<@mysql_numrows($konuAdlari)){		   
												$sqlSayfa 	= "select count(*) as toplam from eo_5sayfa where konuID = '".
														@mysql_result($konuAdlari,$l,"id")."'";
												$sayfaSayisi = mysql_query($sqlSayfa, $yol1);
												$s_sayisi = mysql_result($sayfaSayisi,0,"toplam");												   
						  ?>
										<li  style="list-style-type:none" title='<?php echo $metin[299]?>'><a href="lessons.php?konu=<?php echo @mysql_result($konuAdlari,$l,"id")?>" style="text-decoration:none">
										  <?php echo (@mysql_result($konuAdlari,$l,"konuAdi"))?></a>&nbsp;
                          <?php  if(mysql_result($konuAdlari,$l,"konuyuKilitle")) echo "<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />";?>
                          <?php echo (mysql_result($konuAdlari,$l,"sadeceKayitlilarGorebilir")?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />":"")?>
                          <?php echo (mysql_result($konuAdlari,$l,"calismaSuresiDakika")?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"")?>
                          <?php 
						  if($s_sayisi==0) 
						     echo "<img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[209]."\" title=\"".$metin[209]."\" />";
						  ?>
                          <?php echo "<a href='dersBilgisi.php?ders=".@mysql_result($konuAdlari,$l,"id")."' rel='facebox'><img src='img/info.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"info\" title=\"info\" /></a>";?>
										  
										  </li>
						  <?php
											$l++;
											}
											if(@mysql_numrows($konuAdlari)>0) echo "</ul>";
						  ?>
						</li>
						<?php
										$k++;
										}
										if(@mysql_numrows($dersAdlari)>0) echo "</ul>";
									?>
					</li>
					<?php
								$j++;
								}
								if(@mysql_numrows($sinifAdlari)>0) echo "</ul>";
							?>
				</li>
				<?php	
						$i++;
					}	
					if(@mysql_numrows($okulAdlari)>0) echo "</ul>";
	}
}

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

function Sec2Time2($time){
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

function getmicrotime()
{ 
  list($usec, $sec) = explode(" ",microtime()); 
  return ((float)$usec + (float)$sec);
}

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


?>