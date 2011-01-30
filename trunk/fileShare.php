<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	ob_start();
    @session_start (); 
    $_SESSION ['ready'] = TRUE; 
       
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"fileShare.php");	
	$seciliTema=temaBilgisi();
	
	if(isset($_GET['show']))
	 if(in_array($_GET['show'],array(1,2))) {
		  if($_GET['show']==1)
			  $content = dosyaGoster('index.php'); /* get the buffer */
		  else if($_GET['show']==2)
			  $content = dosyaGoster('.htaccess'); /* get the buffer */			  
		  else
		      $content = "boþ";	  
		  header("Content-Type: text/html");
		  echo $content;
		  die('');		 
	  }
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
<title>eOgr -<?php echo $metin[464]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />

<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/file.css" rel="stylesheet" type="text/css" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    });
</script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
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
          <h1 id="name-text" class="logo-name"><a href="index.php"><?php echo ayarGetir("okulGenelAdi")?></a></h1>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[464]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if (in_array($tur, array("1","2","0")))	{
	 //

$currentPage = $_SERVER["PHP_SELF"];
//if (!check_source()) die ("<font id='hata'>$metin[295]</font>");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	if(isset($_GET['clean']))
	 if($_GET['clean']==1) {
		 $silSonuc = dosyaTemizle();
		 if(!empty($silSonuc))
	  	     echo "<font id='uyari'><strong>$metin[500] :</strong> <br/>$silSonuc</font>";
	 }

$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
if($seceneklerimiz[16]=="1")
 if(preg_match("/777/",decoct(@fileperms($_uploadFolder))) 
  or preg_match("/766/",decoct(@fileperms($_uploadFolder)))) {
?>
                  <blockquote style="width:400px;"> <a href="lib/ajaxupload" onclick="window.open('lib/ajaxupload','upload','height=330,width=450,top=100,left=100,toolbar=no, location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=yes');
return false;" class="external"><?php echo $metin[494]?></a> | <a href="fileShare.php"><img src="img/reload.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[99]?>" /> <?php echo $metin[99]?></a> </blockquote>
                  <?php	
}
?>
<iframe src="data_dosyalar2.php" frameborder="0" scrolling="auto" width="850" height="450" align="middle" marginheight="45" allowtransparency="false" style="background-color: transparent"></iframe>
                  <?php  

if ($tur=="2") {
	$dosyUpload = dosya_uploads_uyumu();
	//bir sorun var ise otomatik salt okunur uploads dizini
	if(!empty($dosyUpload)){
		@chmod($_uploadFolder,0755);	//yetki sorunu var olabilir		
	}
	if(empty($dosyUpload))
		  echo "<font id='uyari'> $metin[496]</font>";
	  else {
		  echo "<font id='hata'> $metin[498]<br/>$dosyUpload<br/>";
		  echo "<a href='fileShare.php?clean=1'>$metin[499]!</a></font>";	
	  }
	  echo "<p>$metin[495] : ";
	  if (file_exists($_uploadFolder.'/.htaccess'))
		  	echo "<a href='fileShare.php?show=2' target=\"_blank\" class='external'>.htaccess</a> ";
		  else
		  	echo " <img src='img/i_high.png' alt='no file' title='$metin[468]' /> .htaccess ";			
	  if (file_exists($_uploadFolder.'/index.php'))
		  	echo "<a href='fileShare.php?show=1' target=\"_blank\" class='external'>index.php</a> ";
		  else
		  	echo " <img src='img/i_high.png' alt='no file' title='$metin[468]' /> index.php ";
	  echo "</p>";			
 }//if tur=2
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
<?php  						
 require "feedback.php"; 
?>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
