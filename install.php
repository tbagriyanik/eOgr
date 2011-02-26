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

require "database.php";

$db_name 		= $_db;
$db_username 	= $_username;			
$db_password 	= $_password;
$db_host 		= $_host ;

/////////////////////////////////////////////////////////////////
$sessVar =   session_start (); 
/*
browserdili:
tarayýcýnýn dil bilgisini alýr
*/
function browserdili() {
         $lang=preg_split('/[,;]/i',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=preg_split('/[-]/i',$lang);
         return $lang[0];
}
/*
is_ajax:
ajax desteði var mý
*/
function is_ajax()
{
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
/*
dilCevir:
dil deðiþtirme yeri
*/
function dilCevir($dil){
      if ($dil=="TR")
        require("lib/tr.php"); 
      elseif ($dil=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         
}
   
        $taraDili= (isset($_COOKIE["lng"]))?$_COOKIE["lng"]:""; 
		if($taraDili=="")
			$taraDili= browserdili(); 
        if($taraDili!="TR") $taraDili="EN";
		setcookie("lng",$taraDili,time()+60*60*24*30);
		
		dilCevir($taraDili);
/*
temizle: metin giriþi, 
XSS temizliði
*/
function temizle($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("\'", "`", $metin);
    $metin = str_replace('\"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "<", $metin);
    $metin = str_replace(">", ">", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}  
/*
temaBilgisi:
temanýn deðiþtirilmesi
*/
function temaBilgisi(){
	global $_defaultTheme;
	$result = $_defaultTheme;
	$cerezden = temizle((isset($_COOKIE["theme"]))?$_COOKIE["theme"]:"");

	 if($cerezden!="" and is_dir('theme/'.$cerezden)){

		  $result=$cerezden;
	  }
	  
	  if(empty($cerezden)) 
	    setcookie("theme",$result,time()+60*60*24*30);

	  return $result;
}	

require 'lib/flood-protection.php'; // include the class
    $protect = new flood_protection();
    $protect -> host         = $_host;
    $protect -> password     = $_password; 
    $protect -> username     = $_username; 
    $protect -> db             = $_db; 
    
    if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
  	  @header("Location: error.php?error=4");
      die('<br/><img src="img/warning.png" align="absmiddle" border="0" style="vertical-align: middle;" alt=\"warning\"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
}
	$host =  $_host;
	$dbUser =  $_username;
	$dbPassword =  $_password;

	$seciliTema= temaBilgisi();
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
<title>eOgr -<?php echo $metin[71]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
		$("#msg_body2").hide();
		$("#msg_head").click(function(){
			$(this).next("#msg_body2").slideToggle(200);
		});
      }) 
</script>
<script type="text/javascript" src="lib/script.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
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
          <h1 id="name-text" class="logo-name"><a href="index.php">eOgr</a></h1>
          <div id="slogan-text" class="logo-text">&nbsp;</div>
        </div>
      </div>
      <div class="nav">
        <ul class="artmenu">
          <li><a href="index.php"><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a></li>
          <li><a href="install.php" class=" active"><span><span><img src="img/database.gif" border="0" style="vertical-align: middle;" alt="install"/> <?php echo $metin[71]?> </span></span></a></li>
        </ul>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[71]?> </span> </h2>
                <div class="PostContent">
                  <?php

	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
	
	if($currentFile!="install.php") echo ("<font id='hata'>Dosya uyumlu deðil!</font><br/>"); 

	if(isset($_POST['submit']))
	{

		  require("lib/SQL_Import2.php");
		  
					$sqlFile = "installation_Database.sql";
					
					$baglan2= @mysql_connect($host, $dbUser, $dbPassword);
					
					if(!$baglan2) echo("<font id='hata'>MySQL sunucuya baðlantý yapýlamadý!<br/> L&#252;ften,'database.php' dosyasýný d&uuml;zenleyiniz veya MySQL sunucunuzun açýk olduðundan emin olunuz.</font>".mysql_error()."<br/>Tekrar denemek i&ccedil;in <a href=install.php>týklatýnýz</a>!");
					else{
					$yol22 = $baglan2;
					$vtSec = @mysql_select_db( $_db, $yol22);
					if(!$vtSec){							 
					  $vtYapsql = "CREATE DATABASE $db_name;";
					  $result = @mysql_query($vtYapsql);
					  if(!$result) 
						die ("<font id='hata'>Veritabaný oluþturulamadý. Yetkilerinizi kontrol ediniz!</font>");
						else
						 echo("<font id='tamam'>$db_name veritabaný oluþturuldu!</font>");
					  	}						 
					 //2. týklama giderildi
					mysql_close($baglan2);					 	
					$baglan2= @mysql_connect($host, $dbUser, $dbPassword);
					$yol22 = $baglan2;
					$vtSec = @mysql_select_db( $_db, $yol22);
							
					  $newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);								
					  //$importumuz = $newImport -> importa ();
					  $newImport -> import ();
				
					  $import = $newImport -> ShowErr ();
						
						if ($import["exito"] != 1)
						{
							echo "<font id='uyari'>Tablolar oluþturuldu!</font><p>$metin[47] Varsayýlan yönetici kullanýcý adý ve parolasý: <strong>admin 11111</strong></p>";
						} else {
							if(isset($import ["errorCode"]) or isset($import ["errorText"]) )
								echo $import ["errorCode"]." ".$import ["errorText"];
							echo "";
						}
									
						
					}
	  @mysql_close($yol22);	
	}
?>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
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
                <div class="PostContent">
                  <?php if(file_exists("installation_Database.sql")){?>
                  <p><strong> <?php echo $metin[73]?> </strong></p>
                  <p><strong> <?php echo $metin[398]?> </strong></p>
                  <a href="installation_Database.sql"><?php echo $metin[399]?> - <?php echo filesize("installation_Database.sql")?> B</a><br />
                  <br />
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input name="submit" type="submit" value="<?php echo $metin[46]?>" />
                  </form>
                  <?php }else{?>
                  Veritabaný dosyanýz bulunamadý. Kurulum yapýlamýyor!
                  <?php }?>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
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
                <div class="PostContent">
                  <?php 
				  echo "<h2 id='msg_head' style=\"cursor:pointer;\">$metin[579]</h2>";
                ?>
                <div id="msg_body2">
                  <?php 
				  echo '<ul><li><strong>PHP</strong>\'nin sürümü : ' . phpversion()."</li>";
				  $baglan3= @mysql_connect($host, $dbUser, $dbPassword);
				  
				  try{
					if($baglan3)
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : ".mysql_get_server_info()."</li>"; 	
					  else
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 
				  }
				  catch(Exception $e){
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }				  
				  
				  echo "<li>MySQL <strong>istemci</strong> sürümü : ".mysql_get_client_info()."</li>"; 	
				  if(!empty($dbPassword))
					  echo "<li>Veritabaný baðlantý <strong>parolasý</strong> : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li>Veritabaný baðlantý <strong>parolasý</strong> : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> boþ!</li>";								  				  				if(file_exists("installation_Database.sql"))
					  echo "<li><strong>Kurulum</strong> için gereken SQL dosyasý : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li><strong>Kurulum</strong> için gereken SQL dosyasý : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";//mysql_error();
				  try{
					if(preg_match("/777/",decoct(@fileperms($_uploadFolder))) 
				  or preg_match("/766/",decoct(@fileperms($_uploadFolder)))) {
					  echo "<li>Dosya <strong>paylaþýmý</strong> için gereken klasör : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }else{
					  echo "<li>Dosya <strong>paylaþýmý</strong> için gereken klasör : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yazýlabilir deðil!</li>";
					  }  
				  }
				  catch(Exception $e){
					  echo "<li>Dosya <strong>paylaþýmý</strong> için gereken klasör : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> baþka bir sorun!</li>";
				  }	  
				  
				  if(function_exists("gzencode"))
				    echo "<li>Dosya <strong>sýkýþtýrma</strong> komutu (gzencode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Dosya <strong>sýkýþtýrma</strong> komutu (gzencode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('gd') && function_exists('gd_info'))
				    echo "<li>Grafik <strong>kütüphanesi</strong> desteði (GD) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Grafik <strong>kütüphanesi</strong> desteði (GD) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('iconv') && function_exists('iconv'))
				    echo "<li>Karakter kümesi <strong>çevrimi</strong> desteði (iconv) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Karakter kümesi <strong>çevrimi</strong> desteði (iconv) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('json') && function_exists('json_decode'))
				    echo "<li><strong>JSON</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>JSON</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('curl') && function_exists('curl_init'))
				    echo "<li><strong>cURL</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>cURL</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
					if(extension_loaded('pdf') && function_exists('pdf_new'))
				    echo "<li><strong>PDFLib</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>PDFLib</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('mysqli'))
				    echo "<li><strong>mySQLi</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>mySQLi</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  /*if(is_ajax())
				    echo "<li><strong>AJAX</strong> komutlarý desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>AJAX</strong> komutlarý desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";*/	
				  if(ini_get('memory_limit'))
				    echo "<li><strong>Bellek</strong> maksimum desteði : ".ini_get('memory_limit')."</li>";
				   else
				   	echo "<li><strong>Bellek</strong> maksimum desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('upload_max_filesize'))
				    echo "<li><strong>Dosya</strong> gönderim maksimum boyut desteði : ".ini_get('upload_max_filesize')."</li>";
				   else
				   	echo "<li><strong>Dosya</strong> gönderim maksimum boyut desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('post_max_size'))
				    echo "<li><strong>POST</strong> gönderim maksimum boyut desteði : ".ini_get('post_max_size')."</li>";
				   else
				   	echo "<li><strong>POST</strong> gönderim maksimum boyut desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('file_uploads')==1)
				    echo "<li><strong>Dosya</strong> gönderme izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Dosya</strong> gönderme izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";		
				  if(ini_get('register_globals')==1)
				    echo "<li><strong>Global</strong> deðiþkenler (register_globals) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk! - tavsiye edilmez</li>";
				   else
				   	echo "<li><strong>Global</strong> deðiþkenler (register_globals) : kapalý <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('magic_quotes_gpc')==1)
				    echo "<li><strong>Özel çift týrnak</strong> deðerler (magic_quotes_gpc) : açýk <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Özel çift týrnak</strong> deðerler (magic_quotes_gpc) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> kapalý!</li>";	
				  try{
				  $modHT = apache_get_modules()	;
				  if(in_array("mod_rewrite",$modHT))
				    echo "<li><strong>htaccess</strong> çalýþma durumu (mod_rewrite) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>htaccess</strong> çalýþma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";						  
				  }
				  catch(Exception $e){
					  echo "<li><strong>htaccess</strong> çalýþma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  }						
				  if($sessVar)
				    echo "<li><strong>Oturum</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Oturum</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if( ini_get('safe_mode') )
				    echo "<li><strong>Güvenli</strong> mod (safe_mode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Güvenli</strong> mod (safe_mode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if( ini_get('display_errors') )
				    echo "<li><strong>Hata</strong> bildirimi (display_errors) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";
				   else
				   	echo "<li><strong>Hata</strong> bildirimi (display_errors) : iþlevsiz! <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if( function_exists('mail') )
				    echo "<li><strong>Eposta</strong> desteði : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Eposta</strong> desteði : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if(ini_get('allow_url_fopen')!=1)
				    echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";		
				  if(ini_get('allow_url_include')!=1)
				    echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";		
				  if(ini_get('display_errors')!=1)
				    echo "<li><strong>display_errors</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>display_errors</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";		
				  if(ini_get('expose_php')!=1)
				    echo "<li><strong>expose_php</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>expose_php</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";		
				  if(ini_get('open_basedir')==1)
				    echo "<li><strong>open_basedir</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>open_basedir</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok - tavsiye edilmez!</li>";		
				  if(ini_get('use_trans_sid')!=1)
				    echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açýk - tavsiye edilmez!</li>";	
?>
	<script language="javascript" type="text/javascript">
		document.write("<li>Dil : " + navigator.userLanguage +"</li>")	;
		document.write("<li>Çerez Desteði : " + navigator.cookieEnabled +"</li>")	;
		document.write("<li>JavaScript Desteði : " + navigator.javaEnabled() +"</li>")	;
		document.write("<li>Tarayýcýnýz : " + navigator.userAgent +"</li>")	;
	</script>
<?php						
				//--------------------------------------	
				  echo "</ul>";
				  echo "<hr noshade=\"noshade\"/><p>$metin[578]</p>";
				  ?>
                  </div>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cleared"></div>
      <div class="Footer">
        <div class="Footer-inner">
          <div class="Footer-text"> <a href='index.php?lng=<?php echo $taraDili?>&amp;oldPath=install.php' title='Dil se&ccedil;iniz Choose a language'> <?php echo ($taraDili=="TR")?"<img src='img/turkish.png' border='0' alt='dil' style='vertical-align: bottom;' />":"<img src='img/english.png' border='0' alt='language' style='vertical-align: bottom;'/>"?> </a> </div>
        </div>
        <div class="Footer-background"></div>
      </div>
    </div>
  </div>
  <div class="cleared"></div>
</div>
<script language="javascript" type="text/javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
</script>
</body>
</html>