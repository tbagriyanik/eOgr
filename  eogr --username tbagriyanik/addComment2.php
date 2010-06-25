<?php
session_start();
header("Content-Type: text/html; charset=iso-8859-9"); 

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
    $metin = iconv( "UTF-8", "ISO-8859-9",trim(htmlspecialchars($metin)));
    return $metin;
}

function getUserIDcomment($usernam, $passwor)
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

function yorumGonder($userID, $konuID, $yorum){
	global $yol1;				
		
		$datem	=	date("Y-n-j H:i:s");		
		
		if(!empty($yorum) && !empty($konuID) && !empty($userID)) {
						  
			$sql2 = "insert into eo_comments VALUES (NULL , '$userID', '$konuID' , '$yorum', '$datem' , 0)"; 

			$result2 = mysql_query($sql2, $yol1); 
			return $result2;
		 }
		
	return false;
}

if (isset($_POST['yorum']) 
				       	&& !empty($_POST['yorum']) 
						&& getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="") {
	if (yorumGonder(getUserIDcomment($_SESSION["usern"],$_SESSION["userp"]), temizle2($_POST['konu']),temizle2($_POST['yorum'])) )
		echo iconv( "ISO-8859-9","UTF-8",$metin[293]);
		else
		echo "PROBLEM!";
} else {
   echo "EMPTY!";
   }

?>