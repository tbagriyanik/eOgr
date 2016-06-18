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
header("Content-Type: text/html; charset=UTF-8"); 

	  ob_start();
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
require("conf.php");  	

     $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
   
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

//Bu sayfa printIt içindir...   ********************************************************************************/
/*
anaMetniOku:
sayfa bilgisinin ana metnini getirir
*/
function anaMetniOku($konuID)
{
	global $yol1;
	global $metin;
	
	$sonuc = "";
	
	if (empty($konuID)) return "<font id='uyari'>$metin[176]</font>";
	
	$sql1	= 	"select eo_5sayfa.id,eo_5sayfa.anaMetin as ana ,eo_5sayfa.cevap as cevap, eo_5sayfa.eklenmeTarihi as tarih,eo_users.userName as user, 
					eo_4konu.konuAdi as konuAdi,eo_4konu.konuyuKilitle as konuyuKilitle, 
					eo_4konu.oncekiKonuID as oncekiKonuID, eo_4konu.calismaHakSayisi as calismaHakSayisi, 
					eo_4konu.sinifaDahilKullaniciGorebilir as sinifaDahilKullaniciGorebilir, 
					eo_4konu.bitisTarihi as bitisTarihi, eo_4konu.sadeceKayitlilarGorebilir as skg  
					from eo_5sayfa, eo_users, eo_4konu where eo_5sayfa.konuID='$konuID' and  
					(eo_users.id=eo_5sayfa.ekleyenID) and (eo_4konu.id=eo_5sayfa.konuID) and (eo_5sayfa.cevap='')
					order by eo_5sayfa.sayfaSirasi";
					// cevap boþ ise SORU deðildir, öyleyse ekrana listelenebilir
	$result1= 	mysqli_query($yol1,$sql1);

	if($result1) {		
		
		$kayitSayisi = @mysqli_num_rows($result1);
		
		$sonuc = "";
		
		while ($row = mysqli_fetch_array($result1, mysqli_ASSOC)) {	
			
					$tarih			= tarihOku($row["tarih"]);
					$user			= $row["user"];
					$konuAdi		= $row["konuAdi"];
					$konuyuKilitle	= $row["konuyuKilitle"];
					$bitisTarihi	= $row["bitisTarihi"];
					$sKayitlilarG	= $row["skg"];
					$calismaHakS	= $row["calismaHakSayisi"];
					$sinifOgreK		= $row["sinifaDahilKullaniciGorebilir"];
					$oncekiKonuID	= $row["oncekiKonuID"];
					
					if($bitisTarihi!="0000-00-00")
						$gunFarki = getDayCount(date("Y-n-j"),$bitisTarihi);
						else
						$gunFarki = 1;
								
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
		$tur	=checkRealUser($adi,$par);			
				
				if($kayitSayisi>0) {
						
						if($sKayitlilarG=="1" && !in_array($tur, array("1","2","0"))) 
							return "<font id='hata'>'$konuAdi' ".$metin[181]."<br/><a href='newUser.php'>$metin[3]!</a></font><hr noshade='noshade'/>";
							
						if($sKayitlilarG=="1" && in_array($tur, array("1","2","0"))) //login olmuþ, hak sayýsýna bak
						  {
							if (kullaniciHakSayisi($konuID, $adi, $par)>= $calismaHakS &&  $calismaHakS>0) 
							return "<font id='hata'>'$konuAdi', ".$metin[208]."</font><hr noshade='noshade'/>";
						  }
				
						if($sKayitlilarG=="1" && $tur=="0") //login olmuþ, &ouml;ðrenci sýnýfa dahil mi?
						  {
							if (ogrenciSinifaDahil($adi, $par, $konuID)==0 &&  $sinifOgreK==1) return "<font id='hata'>'$konuAdi', ".$metin[214]."</font>";
						  }
				
						if($konuyuKilitle=="1") 
							return "<font id='hata'>'$konuAdi' ".$metin[179]."</font><hr noshade='noshade'/>";
							
						if($gunFarki <= 0) 
							return "<font id='hata'>'$konuAdi' ".$metin[180]."</font><hr noshade='noshade'/>";
							
						$sonuc .= "<font size='-1' style='font-style:italic;'>$user $konuAdi $tarih</font><br/>";
						$sonuc .= html_entity_decode($row["ana"])."<hr noshade='noshade'/>";
									
						}
					else
					return "<font id='hata'>".$metin[182]."</font><hr noshade='noshade'/>";
					
		} //while
					return $sonuc;
				 }
				else	
					return "<font id='hata'>".$metin[183]."</font>";
 
 return "<font id='hata'>".$metin[184]."</font>";
}
	

if (isset($_GET['konuID'])){
	  if(!empty($_GET['konuID'])){//t&uuml;m metinler gelsin
			echo anaMetniOku(temizle($_GET['konuID']));
	  }
   }else
   echo "";

?>