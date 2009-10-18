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

function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    $metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}

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

function oyGonder($userID, $konuID, $rate){
	global $yol1;
				
    $sql1 = "SELECT id, userID, konuID FROM eo_rating where userID='".temizle2($userID)."' AND konuID='".temizle2($konuID)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
        $kayno = mysql_result($result1, 0, "id");
	   
		$datem	=	date("Y-n-j H:i:s");		
			
    	$sql2 = "update eo_rating SET value='$rate', rateDate='$datem' where id = '" .$kayno. "' LIMIT 1";
	    $result2 = mysql_query($sql2, $yol1); 
		
    }else {
			
		$datem	=	date("Y-n-j H:i:s");		
			
    	$sql2 = "insert into eo_rating VALUES (NULL , '$userID', '$konuID' , '$rate', '$datem')"; 		
	    $result2 = mysql_query($sql2, $yol1); 
		
	   	return ("");
	}
		
	return "";
}

function oyGetir($userID, $konuID){
	global $yol1;
	
    $sql1 = "SELECT value FROM eo_rating where userID='".temizle2($userID)."' AND konuID='".temizle2($konuID)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
	   return mysql_result($result1, 0, "value");
	}
	return 0;
}

function oyToplam($konuID){
	global $yol1;
	
    $sql1 = "SELECT count(*) as Toplam FROM eo_rating where konuID='".temizle2($konuID)."'"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
	   return mysql_result($result1, 0, "Toplam");
	}
	return 0;
}

function oyOrtalama($konuID){
	global $yol1;
	
    $sql1 = "SELECT avg(value) as Ort FROM eo_rating where konuID='".temizle2($konuID)."'"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
	   return mysql_result($result1, 0, "Ort");
	}
	return 0;
}


if(getUserIDrate($_SESSION["usern"],$_SESSION["userp"])=="") die ("EMPTY!");

if (!isset($id) && isset($_GET['konu2']) && !empty($_GET['konu2'])) {
 $id = temizle2($_GET['konu2']);
}

if (isset($_GET['konu2']) && $_GET['konu2'] == $id && !empty($_GET['konu2'])) {
 if (isset($_GET['rating']) && is_numeric($_GET['rating']) && $_GET['rating']>0 && $_GET['rating']<6 ) {
  		oyGonder(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ),temizle2($_GET['rating']));
		echo $metin[275];
 } else
  echo "Oy hatalý";
}
if (oyGetir(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ))>0) {
 echo "
 <p>".$metin[249]." :</p>
  <ul class=\"rate".oyGetir(getUserIDrate($_SESSION["usern"],$_SESSION["userp"]), temizle2($id ))."\">";
 } else {
 echo "
 <p>".$metin[248]." :</p>
  <ul>";
}

echo '
   <li  style="list-style-type:none;"><a class="rate1" title="'.$metin[250].'" href="?konu2='.$id.'&amp;rating=1">1</a></li>
   <li  style="list-style-type:none;"><a class="rate2" title="'.$metin[251].'" href="?konu2='.$id.'&amp;rating=2">2</a></li>
   <li  style="list-style-type:none;"><a class="rate3" title="'.$metin[252].'" href="?konu2='.$id.'&amp;rating=3">3</a></li>
   <li  style="list-style-type:none;"><a class="rate4" title="'.$metin[253].'" href="?konu2='.$id.'&amp;rating=4">4</a></li>
   <li  style="list-style-type:none;"><a class="rate5" title="'.$metin[254].'" href="?konu2='.$id.'&amp;rating=5">5</a></li>
  </ul>';
  if(oyToplam($id)>0)
	echo "$metin[273] : ".oyToplam($id).", $metin[274] : ".round(oyOrtalama($id),1);   
	else
	echo "$metin[278]";
?>