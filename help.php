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
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
  	require("conf.php");	
	$time = getmicrotime();
	
     $taraDili=$_COOKIE["lng"];    
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo " ".$metin[243]?></title>
<script language="JavaScript" type="text/javascript" src="lib/dataFill.js"></script>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" /><link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<style type="text/css">
<!--
#menu {
	position:relative;
	width:30%;
	z-index:1;
	float: left;
	border-top-width: 4px;
	border-top-style: solid;
	border-top-color: #930;
	margin: 5px;
	padding: 3px;
}
#icerisi {
	position:relative;
	width:65%;
	z-index:2;
	float: left;
	border-top-width: 4px;
	border-top-style: solid;
	border-top-color: #06F;
	margin: 5px;
	padding: 3px;
}
-->
</style>
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
          <h1 id="name-text" class="logo-name"><?php echo ayarGetir("okulGenelAdi")?></h1>
          <div id="slogan-text" class="logo-text"> <?php echo $metin[286]?> </div>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[243]?> </span> </h2>
                <div class="PostContent">
                  <?php   
echo ("<div id='lgout'><a href='#' onclick='window.close();'>".$metin[34]."</a></div><br/>");
?>
                  <?php

	currentFileCheck("help.php");
		
?>
                  <div id="menu">
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
                  <div id="icerisi"> <?php echo $metin[272]?> <?php echo $metin[75]?> <br />
                    <script type="text/javascript" src="http://www.ohloh.net/p/465111/widgets/project_languages.js"></script><br />
                    <script type="text/javascript" src="http://www.ohloh.net/p/465111/widgets/project_partner_badge.js"></script> 
                    <br/>
                    <br/>                    
                    <a href="http://validator.w3.org/check?uri=http%3A%2F%2Fyunus.sourceforge.net%2Feogr%2Findex.php;No200=1"><img
        src="http://www.w3.org/Icons/valid-xhtml10"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a> &nbsp; <a href="http://feed2.w3.org/check.cgi?url=http%3A//yunus.sourceforge.net/eogr/rss.php"><img src="http://validator.w3.org/feed/images/valid-rss-rogers.png" alt="[Valid RSS]" title="Validate my RSS feed" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fyunus.sourceforge.net%2Feogr%2Fhelp.php&amp;profile=css3&amp;usermedium=all&amp;warning=no&amp;lang=en"> <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="Valid CSS!" /> </a> </div>
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
</body>
</html>
