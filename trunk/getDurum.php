<?php
    header("Content-Type: text/html; charset=iso-8859-9");
	require("conf.php"); 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }

function getKonuKayitliKullanici($gelenID){
	global $yol1;
	$sql1	= 	"select sadeceKayitlilarGorebilir from eo_4konu where id ='".temizle($gelenID)."'";
	$result1= 	mysql_query($sql1,$yol1);

	if($result1) {
		mysql_fetch_row($result1);
		return @mysql_result($result1,1,"sadeceKayitlilarGorebilir");
	}
	else
		return "";
}
	 
    $adi	=temizle(substr($_SESSION["usern"],0,15));
    $par	=temizle($_SESSION["userp"]);	
	$tur	=checkRealUser($adi,$par);	 
	 
	if( !in_array($tur, array("1","2","0")) and getKonuKayitliKullanici(temizle($_GET['konu']))=="1") 
			echo "0";
		else
			echo "1";
?>