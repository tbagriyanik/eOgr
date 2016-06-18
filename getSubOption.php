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
	header("Content-Type: text/html; charset=utf-8"); 
    session_start (); 

 if(isset($_POST['sayfaNo']) && (int)$_POST['sayfaNo']>0){
	  
 	$sayfaCevapla = explode("|",$_SESSION["sayfalar"][$_POST['sayfaNo']]);
	$cevapDegeri = $sayfaCevapla[11];

		if($cevapDegeri=="-") {//soru deðilmiþ
		  echo $_SESSION["sayfalar"][$_POST['sayfaNo']];
		  exit();
		}
	
			$cevaplanmisMi = @array_key_exists($cevapDegeri,$_SESSION["cevaplar"]);
		
			if(!$cevaplanmisMi){ //bu soru daha cevaplanmamýþ
		   		echo $_SESSION["sayfalar"][$_POST['sayfaNo']];			
				exit();
			}
		   
			$sayfaCevapla[11] = "-";//sayfalar sonradan güncellenmemiþti, þimdi deðer deðiþtirildi
	
		  $sonuc = implode("|",$sayfaCevapla);
		echo $sonuc;		
   }else
   echo "";
?>