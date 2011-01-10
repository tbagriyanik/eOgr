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
	checkLoginLang(true,true,"addWall.php");
	//check_source();
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
duvarYaz: duvarYazisi, kullanýcý ID,arkadas ID
kullanýcý ile arkadaþýn ortak duvar yazýsý kaydý
*/

function duvarYaz($duvarYazisi, $userID, $arkadasID){
	global $yol1;				
		if(!empty($userID) && !empty($arkadasID)) {
			$duvarYazisi = strip_tags(iconv( "UTF-8","ISO-8859-9",$duvarYazisi));
			
			$sql2 = "UPDATE eo_friends 
			 		SET duvarYazisi='$duvarYazisi'
					WHERE (davetEdenID='$userID' and davetEdilenID='$arkadasID') 
						or
						(davetEdilenID='$userID' and davetEdenID='$arkadasID')"; 

			$result2 = mysql_query($sql2, $yol1); 			
			if($result2) echo "OK"; else echo "ER";
		 }else
		 echo "ERR";
}

$duvarGel = str_replace("'", "`", (isset($_POST['duvar']))?$_POST['duvar']:"");
$gonderen = (isset($_POST['gonderen']))?$_POST['gonderen']:"";
$alan = (isset($_POST['alan']))?$_POST['alan']:"";

if (isset($_POST['duvar'])        	
						&& getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="") 
	duvarYaz(RemoveXSS($duvarGel),RemoveXSS($gonderen),RemoveXSS($alan) );
?>