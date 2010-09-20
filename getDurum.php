<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://www.tuzlaatl.k12.tr/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
    header("Content-Type: text/plain");
    session_start (); 
	ob_start();
	require("conf.php"); 
/*
getKonuKayitliKullanici:
konunun sadece kayýtlý kullanýcýlar bilgisi
*/
function getKonuKayitliKullanici($gelenID){
	global $yol1;
	$sql1	= 	"select sadeceKayitlilarGorebilir from eo_4konu where id ='".temizle($gelenID)."'";
	$result1= 	mysql_query($sql1,$yol1);

	if($result1 and mysql_num_rows($result1)==1) {
		mysql_fetch_row($result1);
		return mysql_result($result1,0,"sadeceKayitlilarGorebilir");
	}
	else
		return "1";
}
	 
    $adi	=temizle(substr($_SESSION["usern"],0,15));
    $par	=temizle($_SESSION["userp"]);
	
	if ($adi=="" or $par=="")	
		$tur = -2;
	  else
		$tur =checkRealUser($adi,$par);	 
	 
	if($tur=="-2" and getKonuKayitliKullanici(temizle($_GET['konu']))=="1") 
			echo "0";
		else
			echo "1";
?>