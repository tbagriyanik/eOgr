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
	header("Content-Type: text/html; charset=iso-8859-9");          

	require "conf.php";	
	
	checkLoginLang(true,true,"addComment2.php");
/*
baglan2: parametresiz, 
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
getUserIDcomment: kullanýcý adý ve parola
kullanýcý adý ve parolasý ile kimlik bilgisi elde edilir
*/
function getUserIDcomment($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle($usernam)."' AND userPassword='".temizle($passwor)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
yorumGonder: kullanýcý adý,konu no ve yorum
kullanýcý adý ile belli bir konuya yorum eklenir
*/

function yorumGonder($userID, $konuID, $yorum){
	global $yol1;				
		
		$datem	=	date("Y-n-j H:i:s");		
		
		if(!empty($yorum) && !empty($konuID) && !empty($userID)) {
			$yorum = iconv( "UTF-8","ISO-8859-9",$yorum);
			$uyeTur = getUserType($_SESSION["usern"]);
			//üye öðretmen veya yönetici ise onay ver
			if($uyeTur>=1)
				$sql2 = "insert into eo_comments VALUES (NULL , '$userID', '$konuID' , '$yorum', '$datem' , 1)"; 
			 else			  
				$sql2 = "insert into eo_comments VALUES (NULL , '$userID', '$konuID' , '$yorum', '$datem' , 0)"; 

			$result2 = mysql_query($sql2, $yol1); 
			return $result2;
		 }
		
	return false;
}

$yorumGel = str_replace("'", "`", $_POST['yorum']);

if (isset($_POST['yorum']) 
				       	&& !empty($_POST['yorum']) 
						&& getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="") {
	if (yorumGonder(getUserIDcomment($_SESSION["usern"],
			$_SESSION["userp"]), 
			temizle($_POST['konu']),RemoveXSS($yorumGel)) )
		echo iconv( "ISO-8859-9","UTF-8",$metin[293]);
		else
		echo "Error!";
} else {
   echo "";
   }

?>