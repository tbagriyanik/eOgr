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
	ob_start();
  session_start (); 
  $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"siteNotices.php");	   
  $seciliTema=temaBilgisi();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo $metin[471]?></title>
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
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
<div class="PageBackgroundGradient"></div>
<div class="Main">
  <div class="Sheet">
    <div class="Sheet-tl"></div>
    <div class="Sheet-tr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-br">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-tc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cc"></div>
    <div class="Sheet-body">
      <div class="Header">
        <div class="Header-png"></div>
        <div class="Header-jpeg"></div>
        <div class="logo">
          <h1 id="name-text" class="logo-name"><a href="index.php"> <?php echo ayarGetir("okulGenelAdi")?> </a></h1>
          <div id="slogan-text" class="logo-text"> <?php echo $metin[286]?> </div>
        </div>
      </div>
      <div class="nav">
        <?php
				 require("menu.php");
                ?>
        <div class="l"> </div>
        <div class="r">
          <div>&nbsp;</div>
        </div>
      </div>
      <div class="contentLayout">
        <div class="content">
          <div class="Post">
            <div class="Post-tl"></div>
            <div class="Post-tr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-br">
              <div>&nbsp;</div>
            </div>
            <div class="Post-tc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cc"></div>
            <div class="Post-body">
              <div class="Post-inner">
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[471]?> </span> </h2>
                <div class="PostContent" style="background:#FFF;color:#000;">
                  <?php
if ($tur=="2")	{//yönetici ise
  
	//fileShare.php'den	 
	$dosyUpload = dosya_uploads_uyumu();
	//bir sorun var ise otomatik salt okunur uploads dizini
	if(!empty($dosyUpload)){
		@chmod($_uploadFolder,0755);//linux yetki sorunu var, olmuyor		
	}
	if(empty($dosyUpload))
		  echo "<font id='uyari'> $metin[496] ($_uploadFolder)</font>";
	  else {
		  echo "<font id='hata'> $metin[498] ($_uploadFolder)<br/>$dosyUpload<br/>";
		  echo "<a href='fileShare.php?clean=1'>$metin[499]!</a></font>";	
	  }

	 //index.php'den 
	 $uyeListesi=getUsersOnline();
		 if(!empty($uyeListesi)){
			 echo "<br/>$metin[446]<strong>";
			 foreach($uyeListesi as $eleman){
				 echo $eleman." ";
				 }
			 echo "</strong>";	 
		 }
		 //iz sayısı
	if (getTrackCount(false)>0){
						 echo "<br/><strong>".$metin[194]." : </strong><br/>".getTrackCount(false)." (<a href='dataActions.php'>".$metin[195]." ".getTrackCount(true)."</a> %".round(getTrackCount(true)*100/getTrackCount(false),1).")";
						 }
						 		 
	 echo '<hr noshade="noshade" color="#333333">';
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
	
}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
                </div>
                <div class="cleared"></div>
              </div>
              &nbsp;</div>
          </div>
          <div class="cleared"></div>
          <div class="contentLayout">
            <div class="content">
              <div class="cleared"></div>
              <div class="contentLayout">
                <div class="content">
                  <div class="cleared"></div>
                  <div class="Footer">
                    <div class="Footer-inner">
                      <?php  						
						 require "footer.php";
                        ?>
                    </div>
                    <div class="Footer-background"></div>
                  </div>
                </div>
              </div>
              <div class="cleared"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>