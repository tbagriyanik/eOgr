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
require "database.php";

$db_name 		= $_db;
$db_username 	= $_username;			
$db_password 	= $_password;
$db_host 		= $_host ;

/////////////////////////////////////////////////////////////////
$sessVar =   session_start (); 
/*
browserdili:
tarayıcının dil bilgisini alır
*/
function browserdili() {
         $lang=preg_split('/[,;]/i',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=preg_split('/[-]/i',$lang);
         return $lang[0];
}
/*
is_ajax:
ajax desteği var mı
*/
function is_ajax()
{
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
/*
dilCevir:
dil değiştirme yeri
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
temizle: metin girişi, 
XSS temizliği
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
    $metin = trim(htmlentities($metin));
    return $metin;
} 
/*
numToTheme:
sayısaldan tema klasör adı getirir
*/
function numToTheme($gelen){
	$result = "";
    $themeArray=glob('theme/*', GLOB_ONLYDIR);
	$i=0;
    foreach($themeArray as $thme){
	   $temaGel = explode("/",$thme);	
	   if($gelen==$i){		   
	    return $temaGel[1];
	   }
	   $i++;
	}
	return $result;		 
} 
/*
temaBilgisi:
temanın değiştirilmesi
*/
function temaBilgisi(){	
	$result = numToTheme(0);//ilk tema
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
	<title>eOgr -<?php echo " ".$metin[71]?></title>
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
		$("#msg_body2").hide();
		$("#msg_head").click(function(){
			$(this).next("#msg_body2").slideToggle(200);
		});
      }) 
	</script>
	<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="lib/jquery.cookie.js"></script>
	<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
    <script language="javascript" type="text/javascript" src="lib/fade.js"></script>
	</head>
	<body>
<?php //require("menu.php");?>
<div class="container">
      <div class="logo col-lg-12">
    <h1 id="name-text" class="logo-name"><a href="index.php">eOgr</a></h1>
    <div id="slogan-text" class="logo-text">&nbsp;</div>
  </div>
      <div class="navbar navbar-default col-lg-12">
    <ul class="artmenu">
          <li><a href="index.php" class="navbar-brand"><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a></li>
          <li class="active"><a href="install.php" class=" active navbar-brand"><span><span><img src="img/database.gif" border="0" style="vertical-align: middle;" alt="install"/> <?php echo $metin[71]?> </span></span></a></li>
        </ul>
    <div class="l"> </div>
    <div class="r">
          <div>&nbsp;</div>
        </div>
  </div>
      <div class="PostContent col-lg-12">
    <?php if(file_exists("installation_Database.sql")){?>
    <p><strong> <?php echo $metin[73]?> </strong></p>
    <p><strong> <?php echo $metin[398]?> </strong></p>
    <a href="installation_Database.sql"><?php echo $metin[399]?> - <?php echo filesize("installation_Database.sql")?> B</a><br />
    <br />
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <input name="submit" type="submit" value="<?php echo $metin[46]?>" />
        </form>
    <?php }else{?>
    Veritabanı dosyanız bulunamadı. Kurulum yapılamıyor!
    <?php }?>
  </div>
      <div class="container">
    <div class="col-lg-12">
          <div class="PostContent">
        <?php

	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
	
	if($currentFile!="install.php") echo ("<font id='hata'>Dosya uyumlu değil!</font><br/>"); 

	if(isset($_POST['submit']))
	{

		  require("lib/SQL_Import2.php");
		  
					$sqlFile = "installation_Database.sql";
					
					$baglan2= @mysqli_connect($host, $dbUser, $dbPassword, $_db);
					
					if(!$baglan2) echo("<font id='hata'>MySQL sunucuya bağlantı yapılamadı!<br/> L&#252;ften,'database.php' dosyasını d&uuml;zenleyiniz veya MySQL sunucunuzun açık olduğundan emin olunuz.</font>".mysqli_connect_error()."<br/>Tekrar denemek i&ccedil;in <a href=install.php>tıklatınız</a>!");
					else{
					$yol22 = $baglan2;mysqli_set_charset($yol22, "utf8");
					//$vtSec = @mysqli_select_db( $_db, $yol22);
					if(!$baglan2){							 
					  $vtYapsql = "CREATE DATABASE $db_name DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
					  $result = @mysqli_query($yol22,$vtYapsql);
					  if(!$result) 
						die ("<font id='hata'>Veritabanı oluşturulamadı. Yetkilerinizi kontrol ediniz!</font>");
						else
						 echo("<font id='tamam'>$db_name veritabanı oluşturuldu!</font>");
					  	}						 
					 //2. tıklama giderildi
					mysqli_close($baglan2);					 	
					$baglan2= @mysqli_connect($host, $dbUser, $dbPassword, $_db);
					$yol22 = $baglan2;
					mysqli_set_charset($yol22, 'utf8'); 
					//$vtSec = @mysqli_select_db( $_db, $yol22);
							
					  $newImport = new sqlImport ($host, $dbUser, $dbPassword, $_db, $sqlFile);								
					  //$importumuz = $newImport -> importa ();
					  $newImport -> import ();
				
					  $import = $newImport -> ShowErr ();
						
						if ($import["exito"] != 1)
						{
							echo "$metin[681]</p>";//başarılı kurulum
						} else {
							if(isset($import ["errorCode"]) or isset($import ["errorText"]) )
								echo $import ["errorCode"]." ".$import ["errorText"];
							echo "";
						}
									
						
					}
	  @mysqli_close($yol22);	
	}
?>
      </div>
          <div class="PostContent">
        <?php 
				  echo "<h2 id='msg_head' style=\"cursor:pointer;\"><img src=\"img/page-next.gif\" alt='next' border='0' style=\"vertical-align: middle;\"/> $metin[579]</h2>";
                ?>
        <div id="msg_body2">
              <?php 
				  echo '<ul><li><strong>PHP</strong>\'nin sürümü : ' . phpversion()."</li>";
				  $baglan3= @mysqli_connect($host, $dbUser, $dbPassword, $_db);
				  
				  try{
					  mysqli_set_charset($baglan3, "utf8");
					if($baglan3)
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : ".mysqli_get_server_info($baglan3)."</li>"; 	
					  else
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 
				  }
				  catch(Exception $e){
					  echo "<li>MySQL <strong>sunucu</strong> sürümü : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }				  
				  
				  echo "<li>MySQL <strong>istemci</strong> sürümü : ".mysqli_get_client_info($baglan3)."</li>"; 	
				  if(!empty($dbPassword))
					  echo "<li>Veritabanı bağlantı <strong>parolası</strong> : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li>Veritabanı bağlantı <strong>parolası</strong> : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> boş!</li>";								  				  				if(file_exists("installation_Database.sql"))
					  echo "<li><strong>Kurulum</strong> için gereken SQL dosyası : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>"; 	
					  else
					  echo "<li><strong>Kurulum</strong> için gereken SQL dosyası : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";//mysqli_error();
				  try{
					if(preg_match("/777/",decoct(@fileperms($_uploadFolder))) 
				  or preg_match("/766/",decoct(@fileperms($_uploadFolder)))) {
					  echo "<li>Dosya <strong>paylaşımı</strong> için gereken klasör : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				  }else{
					  echo "<li>Dosya <strong>paylaşımı</strong> için gereken klasör : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yazılabilir değil!</li>";
					  }  
				  }
				  catch(Exception $e){
					  echo "<li>Dosya <strong>paylaşımı</strong> için gereken klasör : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> başka bir sorun!</li>";
				  }	  
				  
				  if(function_exists("gzencode"))
				    echo "<li>Dosya <strong>sıkıştırma</strong> komutu (gzencode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Dosya <strong>sıkıştırma</strong> komutu (gzencode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('gd') && function_exists('gd_info'))
				    echo "<li>Grafik <strong>kütüphanesi</strong> desteği (GD) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Grafik <strong>kütüphanesi</strong> desteği (GD) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('iconv') && function_exists('iconv'))
				    echo "<li>Karakter kümesi <strong>çevrimi</strong> desteği (iconv) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li>Karakter kümesi <strong>çevrimi</strong> desteği (iconv) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('json') && function_exists('json_decode'))
				    echo "<li><strong>JSON</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>JSON</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('curl') && function_exists('curl_init'))
				    echo "<li><strong>cURL</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>cURL</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
					if(extension_loaded('pdf') && function_exists('pdf_new'))
				    echo "<li><strong>PDFLib</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>PDFLib</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(extension_loaded('mysqli'))
				    echo "<li><strong>mySQLi</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>mySQLi</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  /*if(is_ajax())
				    echo "<li><strong>AJAX</strong> komutları desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>AJAX</strong> komutları desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";*/	
				  if(ini_get('memory_limit'))
				    echo "<li><strong>Bellek</strong> maksimum desteği : ".ini_get('memory_limit')."</li>";
				   else
				   	echo "<li><strong>Bellek</strong> maksimum desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('upload_max_filesize'))
				    echo "<li><strong>Dosya</strong> gönderim maksimum boyut desteği : ".ini_get('upload_max_filesize')."</li>";
				   else
				   	echo "<li><strong>Dosya</strong> gönderim maksimum boyut desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('post_max_size'))
				    echo "<li><strong>POST</strong> gönderim maksimum boyut desteği : ".ini_get('post_max_size')."</li>";
				   else
				   	echo "<li><strong>POST</strong> gönderim maksimum boyut desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  if(ini_get('file_uploads')==1)
				    echo "<li><strong>Dosya</strong> gönderme izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Dosya</strong> gönderme izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";		
				  if(ini_get('register_globals')==1)
				    echo "<li><strong>Global</strong> değişkenler (register_globals) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık! - tavsiye edilmez</li>";
				   else
				   	echo "<li><strong>Global</strong> değişkenler (register_globals) : kapalı <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";		
				  if(ini_get('magic_quotes_gpc')==1)
				    echo "<li><strong>Özel çift tırnak</strong> değerler (magic_quotes_gpc) : açık <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Özel çift tırnak</strong> değerler (magic_quotes_gpc) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> kapalı!</li>";	
				  try{
				  $modHT = apache_get_modules()	;
				  if(in_array("mod_rewrite",$modHT))
				    echo "<li><strong>htaccess</strong> çalışma durumu (mod_rewrite) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>htaccess</strong> çalışma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";						  
				  }
				  catch(Exception $e){
					  echo "<li><strong>htaccess</strong> çalışma durumu (mod_rewrite) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";
				  }						
				  if($sessVar)
				    echo "<li><strong>Oturum</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Oturum</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if( ini_get('safe_mode') )
				    echo "<li><strong>Güvenli</strong> mod (safe_mode) : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Güvenli</strong> mod (safe_mode) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if( ini_get('display_errors') )
				    echo "<li><strong>Hata</strong> bildirimi (display_errors) : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";
				   else
				   	echo "<li><strong>Hata</strong> bildirimi (display_errors) : işlevsiz! <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";	
				  if( function_exists('mail') )
				    echo "<li><strong>Eposta</strong> desteği : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>Eposta</strong> desteği : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok!</li>";	
				  if(ini_get('allow_url_fopen')!=1)
				    echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_fopen</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";		
				  if(ini_get('allow_url_include')!=1)
				    echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>allow_url_include</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";		
				  if(ini_get('display_errors')!=1)
				    echo "<li><strong>display_errors</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>display_errors</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";		
				  if(ini_get('expose_php')!=1)
				    echo "<li><strong>expose_php</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>expose_php</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";		
				  if(ini_get('open_basedir')==1)
				    echo "<li><strong>open_basedir</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>open_basedir</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> yok - tavsiye edilmez!</li>";		
				  if(ini_get('use_trans_sid')!=1)
				    echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/tick_circle.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/></li>";
				   else
				   	echo "<li><strong>use_trans_sid</strong> izni : <img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> açık - tavsiye edilmez!</li>";	
?>
              <script language="javascript" type="text/javascript">
		document.write("<li>Dil : " + navigator.userLanguage +"</li>")	;
		document.write("<li>Çerez Desteği : " + navigator.cookieEnabled +"</li>")	;
		document.write("<li>JavaScript Desteği : " + navigator.javaEnabled() +"</li>")	;
		document.write("<li>Tarayıcınız : " + navigator.userAgent +"</li>")	;
	</script>
              <?php						
				//--------------------------------------	
				  echo "</ul>";
				  echo "<hr noshade=\"noshade\"/><p>$metin[578]</p>";
				  ?>
            </div>
      </div>
        </div>
  </div>
      <footer class="footer">
    <div class="Footer-inner">
          <?php  //require "footer.php";?>
        </div>
  </footer>
    </div>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>