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
		header("Content-Type: text/html; charset=iso-8859-9"); 
      	session_start (); 
	  	ob_start();
       
		require("conf.php");  	
     
		$taraDili=$_COOKIE["lng"];    
	    if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
	    dilCevir($taraDili);
   
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
/*
anaMetniOku:
sayfa bilgisinin ana metnini getirir
*/
function anaMetniOku($sayfaNo)
{ 
 	$sayfaCevapla = explode("|",$_SESSION["sayfalar"][$sayfaNo]);
	$cevapDegeri = $sayfaCevapla[11];
	if($cevapDegeri=="-") 
	   return $_SESSION["sayfalar"][$sayfaNo];
	
		$cevaplanmisMi = @array_key_exists($cevapDegeri,$_SESSION["cevaplar"]);
		
		if(!$cevaplanmisMi) 
		   return $_SESSION["sayfalar"][$sayfaNo];			
		   
		$sayfaCevapla[11] = "-";//sayfalar sonradan güncellenmemiþti, þimdi deðer deðiþtirildi
	
  $sonuc = implode("|",$sayfaCevapla);
  return $sonuc;
}

if (isset($_POST['tur']) && isset($_POST['secilen'])){
	  if($_POST['tur']==3){//metinler gelsin
			echo anaMetniOku(temizle($_POST['sayfaNo']) );
	  }
   }else
   echo "";

?>