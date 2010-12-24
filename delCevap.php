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
	session_start();
	header("Content-Type: text/html; charset=iso-8859-9"); 
	
	require "conf.php";		
	checkLoginLang(true,true,"delCevap.php");
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
cevapSahibi: 
kullanýcý kendi cevabýný silebilir
*/
function cevapSahibi($cevapID)
{
	global $yol1;
	
	$usernam = substr(temizle($usernam),0,15);
    $sql1 = "SELECT userID FROM eo_askanswer 
			where id='".temizle($cevapID)."'  limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "userID"));
    }else {
	   return ("");
	}
}
/*
cevapSil: cevap ID, kullanýcý ID
kullanýcý cevap siliyor
*/

function cevapSil($cevapID, $userID){
	global $yol1,$tur,$currentFile;				
		if(!empty($userID) && !empty($cevapID)) {
  		 if($tur=="2" or cevapSahibi($cevapID)==$userID){
			$sql2 = "DELETE FROM eo_askanswerrate 
					 WHERE cevapID = $cevapID"; 

			$result2 = mysql_query($sql2, $yol1); 
						
			$sql2 = "DELETE FROM eo_askanswer 
					 WHERE id = $cevapID"; 

			$result2 = mysql_query($sql2, $yol1); 
						
			if($result2) {
				echo "Cevap ve oylar silindi.";
				trackUser($currentFile,"success,DelAnsw",RemoveXSS($_SESSION["usern"]));
				}
 			 else {
  			 	echo "Cevap ve oylar silinemedi!";
				trackUser($currentFile,"fail,DelAnsw",RemoveXSS($_SESSION["usern"]));
			  };
		 }
		}else
		     echo "Cevap ve oylar silinemiyor!";
}

$adi	=temizle(substr($_SESSION["usern"],0,15));
$par	=temizle($_SESSION["userp"]);
$tur	=checkRealUser($adi,$par);

$gonderen 	= RemoveXSS($_POST['gonderen']);
$cevapID 	= RemoveXSS($_POST['cevap']);
$gonderenID	= getUserIDcomment($_SESSION["usern"],$_SESSION["userp"]);

if (isset($_POST['cevap'])        	
		&& ($_POST['cevap']<>"")        	
		&& $gonderenID!=""
		&& $gonderenID==$gonderen) 
	cevapSil($cevapID,$gonderen);
	else
	echo "?";
?>