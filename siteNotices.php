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
	ob_start();
  session_start (); 
  $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"siteNotices.php");	   
  $seciliTema=temaBilgisi();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="tarik bagriyanik">
<link href="theme/<?php echo $seciliTema?>/bootstrap-theme.css" rel="stylesheet">
<link href="theme/docs.min.css" rel="stylesheet">
<link href="theme/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="theme/justified-nav.css" rel="stylesheet">
<script src="lib/bs_js/ie-emulation-modes-warning.js"></script>
<title>eOgr -<?php echo $metin[471]?></title>
<link rel="icon" href="img/favicon.ico">
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="elearning, cms, lms, learning management, education, eogrenme" />
<meta name="description" content="eOgr - Open source online education, elearning project" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<script src="lib/bs_js/jquery-2.2.0.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			
		  }) 
		})
	</script>
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
/*
delWithCon:
onaylı olarak silme
*/
function delWithCon(deletepage_url,field_value,messagetext) { 
  if (confirm(messagetext)==1){
    location.href = eval('\"'+deletepage_url+'?id='+field_value+'&delCon=1\"');
  }
}
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[471]?> </span> </h2>
      <div class="PostContent" style="background:#FFF;color:#000;padding:5px;">
        <?php
if ($tur=="2")	{//yönetici ise
  
	//fileShare.php'den	 
	$dosyUpload = dosya_uploads_uyumu();
	//bir sorun var ise otomatik salt okunur uploads dizini
	if(!empty($dosyUpload)){
		@chmod($_uploadFolder,0755);//linux yetki sorunu var, olmuyor		
	}
	if(empty($dosyUpload))
		  echo "<font id='tamam'> $metin[496] ($_uploadFolder)</font>";
	  else {
		  echo "<font id='hata'> $metin[498] ($_uploadFolder)<br/>$dosyUpload<br/>";
		  echo "<a href='fileShare.php?clean=1'>$metin[499]!</a></font>";	
	  }
	echo "<br/>";
		if(istekteBulunanSay()>0)
			printf("$metin[663]<br/>",istekteBulunanSay());					  	
 	//son yapılan işlemler ve tarihi	
	$bilgi1 = sonSatirGetir("sohbet");
	if(!empty($bilgi1))	echo $metin[474]."<p class='ozetBilgi'>".$bilgi1."</p>";
	$bilgi2 = sonSatirGetir("yorum");
	if(!empty($bilgi2))	echo $metin[475]."<p class='ozetBilgi'>".$bilgi2."</p>";
	$bilgi3 = sonSatirGetir("oy");
	if(!empty($bilgi3))	echo $metin[476]."<p class='ozetBilgi'>".$bilgi3."</p>";
	$bilgi4 = sonSatirGetir("ders");
	if(!empty($bilgi4))	echo $metin[477]."<p class='ozetBilgi'>".$bilgi4."</p>";
	$bilgi5 = sonSatirGetir("uye");
	if(!empty($bilgi5))	echo $metin[473]."<p class='ozetBilgi'>".$bilgi5."</p>";
	$bilgi6 = sonSatirGetir("dosya");
	if(!empty($bilgi6))	echo $metin[478]."<p class='ozetBilgi'>".$bilgi6."</p>";
	$bilgi7 = sonSatirGetir("arkadas");
	if(!empty($bilgi7))	echo "<strong><a href=\"dataFriendActions.php\">$metin[594]</a> :</strong>"."<p class='ozetBilgi'>".$bilgi7."</p>";
	$bilgi8 = sonSatirGetir("soru");
	if(!empty($bilgi8))	echo $metin[637]."<p class='ozetBilgi'>".$bilgi8."</p>";

	$bilgiSayfa1 = enFazlaIslemGetir(1);
	if(!empty($bilgiSayfa1))	echo "<strong>".$metin[633]." ($metin[544]) :</strong> <p class='ozetBilgi'>".$bilgiSayfa1."</p>";
	$bilgiSayfa2 = enFazlaIslemGetir(2);
	if(!empty($bilgiSayfa2))	echo "<strong>".$metin[634]." ($metin[544]) :</strong> <p class='ozetBilgi'>".$bilgiSayfa2."</p>";

	if (getTrackCount(false)>0){
						 echo "<p><strong>".$metin[194]." : </strong><br/>".getTrackCount(false)." (<a href='dataActions.php'>".$metin[195]." ".getTrackCount(true)."</a> %".round(getTrackCount(true)*100/getTrackCount(false),1).")</p>";
						 }
	
}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="Footer-inner">
      <?php  require "footer.php";?>
    </div>
  </footer>
</div>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>