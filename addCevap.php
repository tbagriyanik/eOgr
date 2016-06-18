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
	header("Content-Type: text/html; charset=UTF-8"); 
	
	require "conf.php";		
	checkLoginLang(true,true,"addCevap.php");
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
	global  $_db;
    return 	@mysqli_connect($_host, $_username, $_password, $_db);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!$yol1)
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

    $result1 = mysqli_query($yol1, $sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
       return (mysqli_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
cevapYaz: cevapYazizi, kullanýcý ID
kullanýcý cevap yazýyor
*/

function cevapYaz($cevapYazisi, $userID, $soruID){
	global $yol1,$currentFile;				
		if(!empty($userID) && !empty($soruID)) {
			$cevapYazisi = mb_substr(strip_tags($cevapYazisi),0,300);
			$cevapYazisi = str_replace("'", "`",$cevapYazisi);
			$cevapYazisi = RemoveXSS($cevapYazisi);
			$dateN = date("Y-m-d H:i:s");
			
			$sql2 = "INSERT INTO eo_askanswer 
					(answer,userID,soruID,eklenmeTarihi)
			 		VALUES
					('$cevapYazisi','$userID', '$soruID', '$dateN')
					"; 

			$result2 = mysqli_query($yol1, $sql2); 			
			if($result2) {
				echo "Cevabýnýz eklendi.";
				trackUser($currentFile,"success,AddAnsw",RemoveXSS($_SESSION["usern"]));
				}
			 else {
				echo "Cevabýnýz eklenemedi!";
				trackUser($currentFile,"fail,AddAnsw",RemoveXSS($_SESSION["usern"]));
			 }
		 }else
		 echo "Cevabýnýz eklenemiyor!";
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