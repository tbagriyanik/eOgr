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
	
     $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);

	$seciliTema=temaBilgisi();	
	
    header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
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
<title>eOgr -<?php echo " ".$metin[243]?></title>
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
<script type="text/javascript" src="lib/dataFill.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<style type="text/css">
<!--
#menu {
	width: 30%;
	z-index: 1;
	float: left;
	margin: 5px;
	padding: 3px;
}
#icerisi {
	width: 61%;
	z-index: 2;
	float: left;
	margin: 5px;
	padding: 10px;
}
-->
</style>
</head>
<body>
<?php currentFileCheck("help.php");?>
<?php //require("menu.php");?>
<div class="container">
  <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[243]?> </span> </h2>
  <div style="float:right;">
  <?php   
echo ("<div id='lgout'><a href='#' onclick='window.close();'>".$metin[34]."</a></div>");
?>
</div>
  <div class="row">
    <div class="col-lg-12">
      <div id="menu" class="bs-callout bs-callout-warning bg-warning">
        <h4><?php echo $metin[271]?> </h4>
        <ul>
          <li><a href="#1" onclick="yardimGoster(1);return false;"><?php echo $metin[261]?></a></li>
          <li><a href="#2" onclick="yardimGoster(2);return false;"><?php echo $metin[262]?></a></li>
          <li><a href="#3" onclick="yardimGoster(3);return false;"><?php echo $metin[263]?></a></li>
          <li><a href="#4" onclick="yardimGoster(4);return false;"><?php echo $metin[264]?></a></li>
          <li><a href="#5" onclick="yardimGoster(5);return false;"><?php echo $metin[265]?></a></li>
          <li><a href="#6" onclick="yardimGoster(6);return false;"><?php echo $metin[421]?></a></li>
          <li><a href="#7" onclick="yardimGoster(7);return false;"><?php echo $metin[422]?></a></li>
          <li><a href="#8" onclick="yardimGoster(8);return false;"><?php echo $metin[423]?></a></li>
          <li><a href="#9" onclick="yardimGoster(9);return false;"><?php echo $metin[424]?></a></li>
          <li><a href="#10" onclick="yardimGoster(10);return false;"><?php echo $metin[425]?></a></li>
          <li><a href="#11" onclick="yardimGoster(11);return false;"><?php echo $metin[426]?></a></li>
          <li><a href="#12" onclick="yardimGoster(12);return false;"><?php echo $metin[427]?></a></li>
          <li><a href="#13" onclick="yardimGoster(13);return false;"><?php echo $metin[428]?></a></li>
          <li><a href="#14" onclick="yardimGoster(14);return false;"><?php echo $metin[429]?></a></li>
          <li><a href="#15" onclick="yardimGoster(15);return false;"><?php echo $metin[430]?></a></li>
          <li><a href="#16" onclick="yardimGoster(16);return false;"><?php echo $metin[431]?></a></li>
        </ul>
      </div>
      <div id="icerisi" class="bs-callout bs-callout-info bg-info"> <?php echo $metin[272]?> <?php echo $metin[75]?> <br />
        <script type="text/javascript" src="http://www.ohloh.net/p/465111/widgets/project_languages.js"></script><br />
        <script type="text/javascript" src="http://www.ohloh.net/p/465111/widgets/project_partner_badge.js"></script> 
        <br/>
        <br/>
        <a href="http://validator.w3.org/check?uri=http%3A%2F%2Fyunus.sourceforge.net%2Feogr%2Findex.php;No200=1"><img
        src="http://www.w3.org/Icons/valid-xhtml10"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a> &nbsp; <a href="http://feed2.w3.org/check.cgi?url=http%3A//yunus.sourceforge.net/eogr/rss.php"><img src="http://validator.w3.org/feed/images/valid-rss-rogers.png" alt="[Valid RSS]" title="Validate my RSS feed" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fyunus.sourceforge.net%2Feogr%2Fhelp.php&amp;profile=css3&amp;usermedium=all&amp;warning=no&amp;lang=en"> <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="Valid CSS!" /> </a> </div>
      <div id="tumIcerik"></div>
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