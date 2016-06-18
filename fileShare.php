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
		      $content = "boş";	  
		  header("Content-Type: text/html");
		  echo $content;
		  die('');		 
	  }
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
	<title>eOgr -<?php echo $metin[464]?></title>
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
	</head>
	<body>
    <?php require("menu.php");?>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
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
            <blockquote style="width:500px;"> <a href="lib/ajaxupload" onclick="window.open('lib/ajaxupload','upload','height=350,width=490,top=100,left=100,toolbar=no, location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=yes');
return false;" class="external"><?php echo $metin[494]?></a> | <a href="fileShare.php"><img src="img/reload.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[99]?>" /> <?php echo $metin[99]?></a>
              <?php	
}
if($tur>0){
?>
              &nbsp;|&nbsp;<a href="fileShare.php?tumDosyalar=1" title="Ders içinde kullanılan dosyaları da görüntüler">Ders Dosyalar&#305;</a>
              <?php	
}
if($tur>0 and isset($_GET["tumDosyalar"]))//tüm dosyaları öğrenciler göremez
	$_SESSION["tumDosyalar"]="olsun";
 else
    unset($_SESSION["tumDosyalar"]);	
?>
            </blockquote>
            <iframe src="data_dosyalar2.php" frameborder="0" scrolling="auto" width="870" height="485" align="middle" marginheight="45" allowtransparency="false" style="background-color: transparent"></iframe>
            <?php  

if ($tur=="2") {
	$dosyUpload = dosya_uploads_uyumu();
	//bir sorun var ise otomatik salt okunur uploads dizini
	if(!empty($dosyUpload)){
		@chmod($_uploadFolder,0755);	//yetki sorunu var olabilir		
	}
	if(empty($dosyUpload))
		  echo "<font id='tamam'> $metin[496]</font>";
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