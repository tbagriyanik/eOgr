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
	checkLoginLang(true,true,"addCevap.php");
	//check_source();
/*
baglan2: parametresiz, 
veritaban� ba�lant�s�
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
getUserIDcomment: kullan�c� ad� ve parola
kullan�c� ad� ve parolas� ile kimlik bilgisi elde edilir
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
cevapYaz: cevapYazizi, kullan�c� ID
kullan�c� cevap yaz�yor
*/

function cevapYaz($cevapYazisi, $userID, $soruID){
	global $yol1,$currentFile;				
		if(!empty($userID) && !empty($soruID)) {
			$cevapYazisi = substr(strip_tags(iconv( "UTF-8","ISO-8859-9",$cevapYazisi)),0,300);
			$cevapYazisi = str_replace("'", "`",$cevapYazisi);
			$cevapYazisi = RemoveXSS($cevapYazisi);
			$dateN = date("Y-m-d H:i:s");
			
			$sql2 = "INSERT INTO eo_askanswer 
					(answer,userID,soruID,eklenmeTarihi)
			 		VALUES
					('$cevapYazisi','$userID', '$soruID', '$dateN')
					"; 

			$result2 = mysql_query($sql2, $yol1); 			
			if($result2) {
				echo "Cevab�n�z eklendi.";
				trackUser($currentFile,"success,AddAnsw",RemoveXSS($_SESSION["usern"]));
				}
			 else {
				echo "Cevab�n�z eklenemedi!";
				trackUser($currentFile,"fail,AddAnsw",RemoveXSS($_SESSION["usern"]));
			 }
		 }else
		 echo "Cevab�n�z eklenemiyor!";
}

$cevapGel 	= str_replace("'", "`", $_POST['cevap']);
$gonderen 	= $_POST['gonderen'];
$soruID 	= $_POST['soruID'];
$gonderenID	= getUserIDcomment($_SESSION["usern"],$_SESSION["userp"]);

if (isset($_POST['cevap'])        	
		&& ($_POST['cevap']<>"")        	
		&& $gonderenID!=""
		&& $gonderenID==$gonderen) 
	cevapYaz(RemoveXSS($cevapGel),RemoveXSS($gonderen),RemoveXSS($soruID) );
	else
	echo "?";
?>