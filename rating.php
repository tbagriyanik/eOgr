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
@header("Content-Type: text/html; charset=utf-8"); 

     $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 

/*
baglan2:
veritabaný baðlantýsý
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
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();mysqli_set_charset($yol1, "utf8");

	if (!$yol1)
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}
/*
temizle2:
xss temizliði
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
kullanýcý kimlik bilgisi
*/
function getUserIDrate($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
		$result1->data_seek(0);    
		$data = $result1->fetch_array(); 		
        return ($data["id"]);
    }else {
	   return ("");
	}
}
/*
oyGonder:
konuya oy verme
*/
function oyGonder($userID, $konuID, $rate){
	global $yol1;
				
    $sql1 = "SELECT id, userID, konuID FROM eo_rating where userID='".temizle2($userID)."' AND konuID='".temizle2($konuID)."' limit 0,1"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
		$result1->data_seek(0);    
		$data = $result1->fetch_array(); 		
        //return ($data["id"]);
        $kayno = $data["id"];
	   
		$datem	=	date("Y-n-j H:i:s");		
			
    	$sql2 = "update eo_rating SET value='$rate', rateDate='$datem' where id = '" .$kayno. "' LIMIT 1";
	    $result2 = mysqli_query($yol1,$sql2); 
		
    }else {
			
		$datem	=	date("Y-n-j H:i:s");		
			
    	$sql2 = "insert into eo_rating VALUES (NULL , '$userID', '$konuID' , '$rate', '$datem')"; 		
	    $result2 = mysqli_query($yol1,$sql2); 
		
	   	return ("");
	}
		
	return "";
}
/*
oyGetir:
konunun kullanýcý oy bilgisi
*/
function oyGetir($userID, $konuID){
	global $yol1;
	
    $sql1 = "SELECT value FROM eo_rating where userID='".temizle2($userID)."' AND konuID='".temizle2($konuID)."' limit 0,1"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
		$result1->data_seek(0);    
		$data = $result1->fetch_array(); 		
        return ($data["value"]);
	   //return mysqli_result($result1, 0, "value");
	}
	return 0;
}
/*
oyToplam:
konunun oy toplamý
*/
function oyToplam($konuID){
	global $yol1;
	
    $sql1 = "SELECT count(*) as Toplam FROM eo_rating where konuID='".temizle2($konuID)."'"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
		$result1->data_seek(0);    
		$data = $result1->fetch_array(); 		
        return ($data["Toplam"]);
	   //return mysqli_result($result1, 0, "Toplam");
	}
	return 0;
}
/*
oyOrtalama:
konunun oy ortalamasý
*/
function oyOrtalama($konuID){
	global $yol1;
	
    $sql1 = "SELECT avg(value) as Ort FROM eo_rating where konuID='".temizle2($konuID)."'"; 	

    $result1 = mysqli_query($yol1,$sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
		$result1->data_seek(0);    
		$data = $result1->fetch_array(); 		
        return ($data["Ort"]);
	   //return mysqli_result($result1, 0, "Ort");
	}
	return 0;
}


if(isset($_SESSION["usern"]) && getUserIDrate($_SESSION["usern"],$_SESSION["userp"])=="") die ("");

$id = $_SESSION["aktifDers"];

if (!empty($id)) {
	//eðer ders sayfasýndan gelen bir DEÐER var ise 
	//yoksa adresten gelindi ise olmaz
		if (isset($_GET['konu2']) && $_GET['konu2'] == $id && !empty($_GET['konu2'])) {
		 if (isset($_SESSION["usern"]) && isset($_GET['rating']) && is_numeric($_GET['rating']) && $_GET['rating']>0 && $_GET['rating']<6 ) {
				oyGonder(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ),temizle2($_GET['rating']));
				echo $metin[275];
		 } else
		  die("Oy hatalý");
		}
		if (isset($_SESSION["usern"]) && oyGetir(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ))>0) {
		 echo "
		 <p style='margin-top:5px;'>".$metin[249]." :</p>
		  <ul class=\"rate".oyGetir(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ))."\">";
		 } else {
		 echo "
		 <p style='margin-top:5px;'>".$metin[248]." :</p>
		  <ul>";
		}
		
		echo '
		   <li  style="list-style-type:none;"><label class="rate1" title="'.$metin[250].'" href="?konu2='.$id.'&amp;rating=1">1</label></li>
		   <li  style="list-style-type:none;"><label class="rate2" title="'.$metin[251].'" href="?konu2='.$id.'&amp;rating=2">2</label></li>
		   <li  style="list-style-type:none;"><label class="rate3" title="'.$metin[252].'" href="?konu2='.$id.'&amp;rating=3">3</label></li>
		   <li  style="list-style-type:none;"><label class="rate4" title="'.$metin[253].'" href="?konu2='.$id.'&amp;rating=4">4</label></li>
		   <li  style="list-style-type:none;"><label class="rate5" title="'.$metin[254].'" href="?konu2='.$id.'&amp;rating=5">5</label></li>
		  </ul>';
		  if(oyToplam($id)>0)
			echo "$metin[273] : ".oyToplam($id).", $metin[274] : ".round(oyOrtalama($id),1);   
			else
			echo "$metin[278]";
}
?>