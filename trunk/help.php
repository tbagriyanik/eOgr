<?php
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  require("conf.php");	$time = getmicrotime();
	
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
<title>eOgr -<?php echo $metin[243]?></title>
<script language="JavaScript" type="text/javascript" src="lib/dataFill.js"></script>
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img/favicon.ico"/>
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

	if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) {   
	   sessionDestroy();
		die("<font id='hata'>$metin[400]</font>"); //session?
		exit;
	}
		
?>
                  <div id="menu">
                    <h4><?php echo $metin[271]?> </h4>
                    <ul>
                    
                      <li><a href="#" onclick="yardimGoster(1);return false;"><?php echo $metin[261]?></a></li>
                      <li><a href="#" onclick="yardimGoster(2);return false;"><?php echo $metin[262]?></a></li>
                      <li><a href="#" onclick="yardimGoster(3);return false;"><?php echo $metin[263]?></a></li>
                      <li><a href="#" onclick="yardimGoster(4);return false;"><?php echo $metin[264]?></a></li>
                      <li><a href="#" onclick="yardimGoster(5);return false;"><?php echo $metin[265]?></a></li>
                      <li><a href="#" onclick="yardimGoster(6);return false;"><?php echo $metin[421]?></a></li>
                      <li><a href="#" onclick="yardimGoster(7);return false;"><?php echo $metin[422]?></a></li>
                      <li><a href="#" onclick="yardimGoster(8);return false;"><?php echo $metin[423]?></a></li>
                      <li><a href="#" onclick="yardimGoster(9);return false;"><?php echo $metin[424]?></a></li>
                      <li><a href="#" onclick="yardimGoster(10);return false;"><?php echo $metin[425]?></a></li>
                      <li><a href="#" onclick="yardimGoster(11);return false;"><?php echo $metin[426]?></a></li>
                      <li><a href="#" onclick="yardimGoster(12);return false;"><?php echo $metin[427]?></a></li>
                      <li><a href="#" onclick="yardimGoster(13);return false;"><?php echo $metin[428]?></a></li>
                      <li><a href="#" onclick="yardimGoster(14);return false;"><?php echo $metin[429]?></a></li>
                      <li><a href="#" onclick="yardimGoster(15);return false;"><?php echo $metin[430]?></a></li>
                      <li><a href="#" onclick="yardimGoster(16);return false;"><?php echo $metin[431]?></a></li>

                    </ul>
                  </div>
                  <div id="icerisi"> <?php echo $metin[272]?> <?php echo $metin[75]?> </div>
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
