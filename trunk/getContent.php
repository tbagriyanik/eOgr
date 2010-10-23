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
    session_start (); 
	ob_start();
	require("conf.php"); 
/*
getOncekiKonuAdi:
önceki konunun adýný getirme
*/
function getOncekiKonuAdi($gelenID){
	global $yol1;
	$sql1	= 	"select konuAdi from eo_4konu where id ='".temizle($gelenID)."'";
	$result1= 	mysql_query($sql1,$yol1);

	if($result1) {
		mysql_fetch_row($result1);
		return @mysql_result($result1,$sayfaNo,"konuAdi");
	}
	else
		return "";
}
/*
getSonrakiKonu:
sonraki konunun bilgisi
*/
function getSonrakiKonu($suAnkiID, $alanAdi){
	global $yol1;
	$sql1	= 	"select $alanAdi from eo_4konu where oncekiKonuID ='".temizle($suAnkiID)."'";
	$result1= 	mysql_query($sql1,$yol1);

	if($result1) {
		mysql_fetch_row($result1);
		return @mysql_result($result1,$sayfaNo,"$alanAdi");
	}
	else
		return "";
}

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
/*
konudakiSayfaSayisi:
seçili konuda kaç sayfa var
*/
function konudakiSayfaSayisi($gelen){
	global $yol1;
	$sql1	= 	"select 
	            eo_5sayfa.id
				from eo_5sayfa, eo_4konu 
				where eo_5sayfa.konuID='$gelen' and (eo_4konu.id=eo_5sayfa.konuID)";
				
	$result1= 	mysql_query($sql1,$yol1);

    if($result1) 
	 return @mysql_numrows($result1);
	else 
	 return 0;	
}
/*
anaMetniOku:
sayfa bilgisinin ana metnini getirir
*/
function anaMetniOku($gelen, $sayfaNo)
{
	global $yol1;
	global $metin;
	
	if (empty($gelen)) return "<font id='uyari'>$metin[176]</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
	if (empty($sayfaNo)) return "<font id='uyari'>$metin[176]</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
	
	$sql1	= 	"select 
	            eo_5sayfa.id,eo_5sayfa.anaMetin as ana,eo_5sayfa.cevap as cevap,
				eo_5sayfa.eklenmeTarihi as tarih,				
				eo_5sayfa.slideGecisSuresi as sgSuresi,
				eo_5sayfa.cevapSuresi as cSuresi,
				eo_users.userName as user, 
				eo_4konu.konuAdi as konuAdi,eo_4konu.konuyuKilitle as konuyuKilitle,		
				eo_4konu.oncekiKonuID as oncekiKonuID, eo_4konu.calismaHakSayisi as calismaHakSayisi,	
				eo_4konu.calismaSuresiDakika as calismaSuresiDakika,
				eo_4konu.sinifaDahilKullaniciGorebilir as sinifaDahilKullaniciGorebilir,
				eo_4konu.bitisTarihi as bitisTarihi, eo_4konu.sadeceKayitlilarGorebilir as skg, 
				eo_4konu.id as aktifKonuNo
				from eo_5sayfa, eo_users, eo_4konu 
				where eo_5sayfa.konuID='$gelen' and 
				(eo_users.id=eo_5sayfa.ekleyenID) and (eo_4konu.id=eo_5sayfa.konuID) 
				order by eo_5sayfa.sayfaSirasi";
				
	$result1= 	mysql_query($sql1,$yol1);

	if($result1) {
		mysql_fetch_row($result1);
		
		$kayitSayisi = @mysql_numrows($result1);
		
		if ($sayfaNo<0) 
		  	$sayfaNo=0; 	
		else if ($sayfaNo>$kayitSayisi)	
		    $sayfaNo = $kayitSayisi - 1; 
		else		
			$sayfaNo = $sayfaNo - 1 ; 		//0 index kayit baslangicidir
		
	
	 $humanRelativeDate = new HumanRelativeDate();
	 $insansi = $humanRelativeDate->getTextForSQLDate(@mysql_result($result1,$sayfaNo,"tarih"));
		$tarih			= $insansi;
		$user			= @mysql_result($result1,$sayfaNo,"user");
		$cevap			= @mysql_result($result1,$sayfaNo,"cevap");
		$konuAdi		= @mysql_result($result1,$sayfaNo,"konuAdi");
		$konuyuKilitle	= @mysql_result($result1,$sayfaNo,"konuyuKilitle");
		$bitisTarihi	= @mysql_result($result1,$sayfaNo,"bitisTarihi");
		$sKayitlilarG	= @mysql_result($result1,$sayfaNo,"skg");
		$aktifKonuNo	= @mysql_result($result1,$sayfaNo,"aktifKonuNo");
		$oncekiKonuID	= @mysql_result($result1,$sayfaNo,"oncekiKonuID");
		$calismaHakS	= @mysql_result($result1,$sayfaNo,"calismaHakSayisi");
		$sgSuresi		= temizle(@mysql_result($result1,$sayfaNo,"sgSuresi"));
		$cSuresi		= temizle(@mysql_result($result1,$sayfaNo,"cSuresi"));
		$calismaSuresiD	= ($sKayitlilarG)?@mysql_result($result1,$sayfaNo,"calismaSuresiDakika"):"0";
		$sinifOgreK		= ($sKayitlilarG)?@mysql_result($result1,$sayfaNo,"sinifaDahilKullaniciGorebilir"):"0";
		$oncekiKonuAdi	= getOncekiKonuAdi($oncekiKonuID);
		$sonrakiKonuID	= getSonrakiKonu($gelen,"id");
		$sonrakiKonuAdi	= getSonrakiKonu($gelen,"konuAdi");		
		
		if($bitisTarihi!="0000-00-00")
			$gunFarki = getDayCount(date("Y-n-j"),$bitisTarihi);
			else
			$gunFarki = 1;
					
    $adi	=temizle(substr($_SESSION["usern"],0,15));
    $par	=temizle($_SESSION["userp"]);	
	$tur	=checkRealUser($adi,$par);			
		
	if($kayitSayisi>0) {
			
			if($sKayitlilarG=="1" && !in_array($tur, array("1","2","0"))) //login olmamýþ
				return "<font id='hata'>'$konuAdi' ".$metin[181]."<br/><a href='newUser.php'><img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[149]."' title='".$metin[149]."' />$metin[3]!</a>&nbsp;&nbsp;<a href='index.php'><img src=\"img/home.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"main\"/> $metin[2]</a></font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
				
			if($sKayitlilarG=="1" && in_array($tur, array("1","2","0"))) //login olmuþ, hak sayýsýna bak
			  {
				if (kullaniciHakSayisi($gelen, $adi, $par)>= $calismaHakS &&  $calismaHakS>0) return "<font id='hata'>'$konuAdi', ".$metin[208]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
			  }
				
			if($sKayitlilarG=="1" && $tur=="0") //login olmuþ, &ouml;ðrenci sýnýfa dahil mi?
			  {				  
				if (ogrenciSinifaDahil($adi, $par, $gelen)==0 &&  $sinifOgreK==1) return "<font id='hata'>'$konuAdi', ".$metin[214]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
			  }
				
			if($konuyuKilitle=="1") 
				return "<font id='hata'><img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' /> '$konuAdi' ".$metin[179]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
				
			if($gunFarki <= 0) 
				return "<font id='hata'>'$konuAdi' ".$metin[180]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";				
				
			$cevaplanmisMi = @array_key_exists(mysql_result($result1,$sayfaNo,"id"),$_SESSION["cevaplar"]);
			
			if(($cevap!="" || is_numeric($cevap)) && !$cevaplanmisMi) 
			   $cevap = mysql_result($result1,$sayfaNo,"id");
			   else			  
				$cevap = "-";
			
			return html_entity_decode(@mysql_result($result1,$sayfaNo,"ana"))."|".
					$tarih. "|".$user."|".$kayitSayisi."|".$sayfaNo."|".$konuAdi.
					"|".$oncekiKonuID."|".$oncekiKonuAdi."|".$sonrakiKonuID.
					"|".$sonrakiKonuAdi."|".$calismaSuresiD."|".$cevap.
					"|".$aktifKonuNo."|".$cSuresi."|".$sgSuresi;
						
			}
		else
		return "<font id='hata'><img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[209]."' title='".$metin[209]."' />".$metin[182]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
	 }
	else	
        return "<font id='hata'>".$metin[183]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
 
 return "<font id='hata'>".$metin[184]."</font>|-|-|-|-|-|-|-|-|-|-|-|-|-|-";
}
/*
konuHazirla:
konu bilgilerini oturuma kaydeder
*/
function konuHazirla($konuID){
	global $yol1;
	$sql = "SELECT id FROM eo_5sayfa
			WHERE konuID = '$konuID'
			ORDER BY sayfaSirasi";
	$result = @mysql_query($sql,$yol1);
	
	$_SESSION["sayfalar"]=array();//önce eskileri sileriz
	$i=1;
	while($gelen=@mysql_fetch_array($result)){		
		$_SESSION["sayfalar"][$i]=anaMetniOku($konuID,$i);
		$i++;
	}	
}
	 
    $adi	=temizle(substr($_SESSION["usern"],0,15));
    $par	=temizle($_SESSION["userp"]);
	
	if ($adi=="" or $par=="")	
		$tur = -2;
	  else
		$tur =checkRealUser($adi,$par);	 
	 
	 if(temizle($_POST['konu'])<>"")
		 konuHazirla(temizle($_POST['konu']));
//	 print_r($_SESSION["sayfalar"]);
//  dönüþ deðeri yok...
?>