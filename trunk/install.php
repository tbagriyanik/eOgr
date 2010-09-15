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

require "database.php";

$db_name 		= $_db;
$db_username 	= $_username;			
$db_password 	= $_password;
$db_host 		= $_host ;

/////////////////////////////////////////////////////////////////
$sessVar =   session_start (); 
/*
browserdili:
taray�c�n�n dil bilgisini al�r
*/
function browserdili() {
         $lang=split('[,;]',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=split('[-]',$lang);
         return $lang[0];
}
/*
is_ajax:
ajax deste�i var m�
*/
function is_ajax()
{
	return (isset($_SERVER['X_REQUESTED_WITH']) AND
	strtolower($_SERVER['X_REQUESTED_WITH']) === 'xmlhttprequest');
}
/*
getStats:
fake func
*/
function getStats(){
}
/*
Sec2Time2:
saniyeyi �st zaman birimlerine �evirir
*/
function Sec2Time2($time){
  if(is_numeric($time)){
    $value = "";
    if($time >= 31556926){
      $value = floor($time/31556926)."y ";
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value .= floor($time/86400)."d ";
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value .= strlen(floor($time/3600))==1?"0".floor($time/3600).":":floor($time/3600).":";
      $time = ($time%3600);
    }
    if($time >= 60){
      $value .= strlen(floor($time/60))==1?"0".floor($time/60).":":floor($time/60).":";
      $time = ($time%60);
    }
    $value .= strlen(floor($time))==1?"0".floor($time)."s":floor($time)."s";
    return $value;
  }else{
    return (bool) FALSE;
  }
}
/*
dilCevir:
dil de�i�tirme yeri
*/
function dilCevir($dil){
      if ($dil=="TR")
        require("lib/tr.php"); 
      elseif ($dil=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         
}
   
        $taraDili= $_COOKIE["lng"]; 
        if($taraDili!="TR") $taraDili="EN";
		setcookie("lng",$taraDili,time()+60*60*24*30);
		
		dilCevir($taraDili);
/*
temizle: metin giri�i, 
XSS temizli�i
*/
function temizle($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("\'", "`", $metin);
    $metin = str_replace('\"', '�', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "<", $metin);
    $metin = str_replace(">", ">", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}  
/*
temaBilgisi:
teman�n de�i�tirilmesi
*/
function temaBilgisi(){
	global $_defaultTheme;
	$result = $_defaultTheme;
	$cerezden = temizle($_COOKIE["theme"]);

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
  	  @header("Location:error.php?error=4");
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
	
	if($currentFile!="install.php") echo ("<font id='hata'>Dosya uyumlu de�il!</font><br/>"); 

	if(isset($_POST['submit']))
	{

		  require("lib/SQL_Import2.php");
		  
					$sqlFile = "installation_Database.sql";
					
					$baglan2= @mysql_connect($host, $dbUser, $dbPassword);
					
					if(!$baglan2) echo("<font id='hata'>MySQL sunucuya ba�lant� yap�lamad�! L&#252;ften,'database.php' dosyas�n� d&uuml;zenleyiniz.</font>".mysql_error()."<br/>Tekrar denemek i&ccedil;in <a href=install.php>t�klat�n�z</a>!");
					else{
					$yol22 = $baglan2;
					$vtSec = @mysql_select_db( $_db, $yol22);
					if(!$vtSec){							 
							  $vtYapsql = "CREATE DATABASE $db_name;";
							  $result = @mysql_query($vtYapsql);
							  if(!$result) 
								die ("<font id='hata'>Veritaban� olu�turulamad�. Yetkilerinizi kontrol ediniz!</font>");
								else
								 echo("<font id='tamam'>$db_name veritaban� olu�turuldu!</font>");
					  	}						 
							
					  $newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);								
					  //$importumuz = $newImport -> importa ();
					  $newImport -> import ();
				
					  $import = $newImport -> ShowErr ();
						
						if ($import["exito"] != 1)
						{
							echo "<font id='tamam'><br/>";
						} else {
							echo $import ["errorCode"]." ".$import ["errorText"];
							echo "<font id='tamam'>Veritaban� kurulmu� haldedir.<br/>Tablo olu�turmaya devam etmek i�in 'Otomatik Kurulum' d&uuml;�mesine tekrar bas�n�z.<br/>Tablolar� zaten olu�turdu iseniz, bu uyar�y� g�zard� ediniz. </font>".$metin[47]."<br/>Varsay�lan kullan�c� ad� ve parolas�: admin 11111</font>";
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
                  Veritaban� dosyan�z bulunamad�. Kurulum yap�lam�yor!
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
				  echo "<h2>eOgr Projesinin Temel Gereksinimleri ve Sunucu Testi : </h2><ul>";
				//--------------------------------------	
				  echo '<li><strong>PHP</strong>\'nin s�r�m� : ' . phpversion()."</li>";
				  $baglan3= @mysql_connect($host, $dbUser, $dbPassword);
				  
				  try{
					if($baglan3)
					  echo "<li>MySQL <strong>sunucu</strong> s�r�m� : ".mysql_get_server_info()."</li>"; 	
					  else
					  echo "<li>MySQL <strong>sunucu</strong> s�r�m� : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 
				  }
				  catch(Exception $e){
					  echo "<li>* MySQL <strong>sunucu</strong> s�r�m� : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }				  
				  
				  echo "<li>MySQL <strong>istemci</strong> s�r�m� : ".mysql_get_client_info()."</li>"; 	
				  if(!empty($dbPassword))
					  echo "<li>Veritaban� ba�lant� <strong>parolas�</strong> : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li>Veritaban� ba�lant� <strong>parolas�</strong> : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> bo�!</li>";								  				  if(file_exists("installation_Database.sql"))
					  echo "<li><strong>Kurulum</strong> i�in gereken SQL dosyas� : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li><strong>Kurulum</strong> i�in gereken SQL dosyas� : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";//mysql_error();
				  try{
					if(eregi("777",decoct(fileperms($_uploadFolder))) 
				  or eregi("766",decoct(fileperms($_uploadFolder)))) {
					  echo "<li>Dosya <strong>payla��m�</strong> i�in gereken klas�r : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }else{
					  echo "<li>* Dosya <strong>payla��m�</strong> i�in gereken klas�r : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
					  }  
				  }
				  catch(Exception $e){
					  echo "<li>Dosya <strong>payla��m�</strong> i�in gereken klas�r : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }	  
				  
				  if(function_exists("gzencode"))
				    echo "<li>Dosya <strong>s�k��t�rma</strong> komutu (gzencode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Dosya <strong>s�k��t�rma</strong> komutu (gzencode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(extension_loaded('gd') && function_exists('gd_info'))
				    echo "<li>Grafik <strong>k�t�phanesi</strong> deste�i (GD) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Grafik <strong>k�t�phanesi</strong> deste�i (GD) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(extension_loaded('iconv') && function_exists('iconv'))
				    echo "<li>Karakter k�mesi <strong>�evrimi</strong> deste�i (iconv) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Karakter k�mesi <strong>�evrimi</strong> deste�i (iconv) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(extension_loaded('json') && function_exists('json_decode'))
				    echo "<li><strong>JSON</strong> deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>JSON</strong> deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(extension_loaded('curl') && function_exists('curl_init'))
				    echo "<li><strong>cURL</strong> deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>cURL</strong> deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
					if(extension_loaded('pdf') && function_exists('pdf_new'))
				    echo "<li><strong>PDFLib</strong> deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>PDFLib</strong> deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(extension_loaded('mysqli'))
				    echo "<li><strong>mySQLi</strong> deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>mySQLi</strong> deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(is_ajax())
				    echo "<li><strong>AJAX</strong> komutlar� deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>AJAX</strong> komutlar� deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if(ini_get('memory_limit'))
				    echo "<li><strong>Bellek</strong> maksimum deste�i : ".ini_get('memory_limit')."</li>";
				   else
				   	echo "<li><strong>Bellek</strong> maksimum deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(ini_get('upload_max_filesize'))
				    echo "<li><strong>Dosya</strong> g�nderim maksimum boyut deste�i : ".ini_get('upload_max_filesize')."</li>";
				   else
				   	echo "<li><strong>Dosya</strong> g�nderim maksimum boyut deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(ini_get('post_max_size'))
				    echo "<li><strong>POST</strong> g�nderim maksimum boyut deste�i : ".ini_get('post_max_size')."</li>";
				   else
				   	echo "<li><strong>POST</strong> g�nderim maksimum boyut deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  if(ini_get('file_uploads')==1)
				    echo "<li><strong>Dosya</strong> g�nderme izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Dosya</strong> g�nderme izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('register_globals')==1)
				    echo "<li><strong>Global</strong> de�i�kenler (register_globals) : <u>a��k!</u> - tavsiye edilmez <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Global</strong> de�i�kenler (register_globals) : kapal� <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('magic_quotes_gpc')==1)
				    echo "<li><strong>�zel �ift t�rnak</strong> de�erler (magic_quotes_gpc) : a��k <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>�zel �ift t�rnak</strong> de�erler (magic_quotes_gpc) : <u>kapal�!</u> <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  try{
				  $modHT = apache_get_modules()	;
				  if(in_array("mod_rewrite",$modHT))
				    echo "<li><strong>htaccess</strong> �al��ma durumu (mod_rewrite) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>htaccess</strong> �al��ma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";						  
				  }
				  catch(Exception $e){
					  echo "<li>* <strong>htaccess</strong> �al��ma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }						
				  if($sessVar)
				    echo "<li><strong>Oturum</strong> deste�i : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Oturum</strong> deste�i : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if( ini_get('safe_mode') )
				    echo "<li><strong>G�venli</strong> mod (safe_mode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>G�venli</strong> mod (safe_mode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if( ini_get('display_errors') )
				    echo "<li><strong>Hata</strong> bildirimi (display_errors) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Hata</strong> bildirimi (display_errors) : i�levsiz! <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if( ini_get('SMTP') )
				    echo "<li><strong>Eposta</strong> SMTP de�eri : ". ini_get('SMTP')."</li>";
				   else
				   	echo "<li><strong>Eposta</strong> SMTP de�eri : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if(ini_get('allow_url_fopen')!=1)
				    echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('allow_url_include')!=1)
				    echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('display_errors')!=1)
				    echo "<li><strong>display_errors</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>display_errors</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('expose_php')!=1)
				    echo "<li><strong>expose_php</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>expose_php</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('open_basedir')==1)
				    echo "<li><strong>open_basedir</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>open_basedir</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('use_trans_sid')!=1)
				    echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				//--------------------------------------	
				  echo "</ul>";
				  echo "<hr noshade=\"noshade\"/><p>E�er varsa <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> k�rm�z� simge ile g�sterilen uyar�lar� dikkate al�n�z.<br/>Bu de�erler tavsiye edilmez veya tehlikeye neden olabilir!</p>";
				  ?>
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