<?php
    header("Content-Type: text/html; charset=iso-8859-9");
	require("conf.php"); 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
/*
getKonuKayitliKullanici:
konunun sadece kay�tl� kullan�c�lar bilgisi
*/
function getKonuKayitliKullanici($gelenID){
	global $yol1;
	$sql1	= 	"select sadeceKayitlilarGorebilir from eo_4konu where id ='".temizle($gelenID)."'";
	$result1= 	mysql_query($sql1,$yol1);

	if($result1) {
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