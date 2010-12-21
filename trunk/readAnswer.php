<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Fo4undation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	ob_start();
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"readAnswer.php");	
	$seciliTema=temaBilgisi();
	
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-9'/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr</title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link href="theme/cevap.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
		$adi	=temizle(substr($_SESSION["usern"],0,15));
		$par	=temizle($_SESSION["userp"]);
		$tur=checkRealUser($adi,$par);

	if ($tur=="2" or $tur=="1" or $tur=="0")	{	
	 //öðrenci, öðretmen ve yönetici girebilir
	 $gelenID = (int)RemoveXSS($_GET["oku"]);
	 if(!($gelenID>0)) die("?");
	 $srg = "select * from eo_askquestion where id=$gelenID limit 0,1";
	 $sorgu = mysql_query($srg);
	 $soru_bilgileri = mysql_fetch_array($sorgu);	
?>
<div id="kapsayici">
  <div id="soruMetni"><?php echo $soru_bilgileri["question"]?></div>
  <div id="soruSoran"><?php echo getUserName($soru_bilgileri["userID"])?></div>
  <div class="temizle"></div>
  <div id="dersAdi"><?php echo getDersAdi($soru_bilgileri["dersID"])?></div>
  <div id="soruTarihi">
    <?php 
  		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($soru_bilgileri["eklenmeTarihi"]);
		echo $insansi
		?>
  </div>
  <div class="temizle"></div>
</div>
<?php
	 $soruID = $soru_bilgileri["id"];	
	 $srgCev = "select * from eo_askanswer where soruID=$soruID order by eklenmeTarihi DESC";
	 $sorguCev = mysql_query($srgCev);
	if(@mysql_num_rows($sorguCev)>0){
?>
<h4>Cevaplar</h4>
<?php 	 
	while($cevap_bilgileri = mysql_fetch_array($sorguCev)){		
?>
<div class="kapsayiciCevap">
  <div class="cevapMetni"><?php echo $cevap_bilgileri["answer"]?></div>
  <div class="puanVer"><a href="#" class="evetOy" title="Doðru"></a> <a href="#" class="hayirOy" title="Yanlýþ"></a></div>
  <div class="cevaplayan"><?php echo getUserName($cevap_bilgileri["userID"])?></div>
  <div class="temizle"></div>
  <div class="puanlama"> puan </div>
  <div class="cevapTarihi">
    <?php 
  		$humanRelativeDate = new HumanRelativeDate();
		$insansi = $humanRelativeDate->getTextForSQLDate($cevap_bilgileri["eklenmeTarihi"]);
		echo $insansi
		?>
  </div>
  <div class="temizle"></div>
</div>
<?php
			 }//while
		}else
		echo "Þimdilik cevap verilmemiþtir.";			
?>
<div class="kapsayiciEkle">
  <form>
    Sizin Cevabýnýz<br />
    <textarea name="cevabim" cols="50" rows="5" style="background-color:#FFF;border:thin solid #ccc;" ></textarea>
    <button>Gönder</button>
  </form>
</div>
<?php			 
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
