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
	checkLoginLang(true,true,"oyCevap.php");
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
cevapOyVar:
cevabý daha önceden verilmiþ mi
*/
function cevapOyVar($userID, $cevapID){
	global $yol1;				
	$sql2= "SELECT count(*) as say FROM eo_askanswerrate 
			WHERE userID='$userID' and cevapID='$cevapID'";
	$result2 = mysql_query($sql2, $yol1); 
	$satir = mysql_fetch_row($result2);
	return ($satir[0]>0);
}
/*
cevapOy: deger, kullanýcý ID, cevap ID
kullanýcý cevaba oy veriyor
*/

function cevapOy($deger, $userID, $cevapID){
	global $yol1,$currentFile;				
		if(!empty($userID) && !empty($cevapID)) {			
			
			if(cevapOyVar($userID, $cevapID))
				$sql2 = "UPDATE eo_askanswerrate 
					SET degeri='$deger'
					WHERE userID='$userID' and cevapID='$cevapID'					
					"; 
			else
				$sql2 = "INSERT INTO eo_askanswerrate 
					(degeri,userID,cevapID)
			 		VALUES
					('$deger','$userID', '$cevapID')
					"; 

			$result2 = mysql_query($sql2, $yol1); 			
			if($result2) {
				echo "Oy verdiniz.";
				trackUser($currentFile,"success,QuesVote",RemoveXSS($_SESSION["usern"]));
				} else {
				echo "Oy verilemedi!";
				trackUser($currentFile,"fail,QuesVote",RemoveXSS($_SESSION["usern"]));
				};
		 }else
		 echo "Oy verilemedi!";
}

$cevapGel 	= RemoveXSS($_POST['deger']);
$gonderen 	= RemoveXSS($_POST['gonderen']);
$cevapID 	= RemoveXSS($_POST['cevapID']);

if (isset($_POST['deger']) && ($_POST['deger']<>"") && 
	isset($_POST['gonderen']) && ($_POST['gonderen']<>"") &&
	isset($_POST['cevapID']) && ($_POST['cevapID']<>"") ) 
	cevapOy($cevapGel,$gonderen,$cevapID);
	else
	echo "?";
?>