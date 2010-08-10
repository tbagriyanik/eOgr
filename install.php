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
require 'lib/flood-protection.php'; // include the class

$db_name 		= $_db;
$db_username 	= $_username;			
$db_password 	= $_password;
$db_host 		= $_host ;

/////////////////////////////////////////////////////////////////
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
/*
browserdili:
tarayýcýnýn dil bilgisini alýr
*/
function browserdili() {
         $lang=split('[,;]',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=split('[-]',$lang);
         return $lang[0];
}
/*
getStats:
fake func
*/
function getStats(){
}
/*
Sec2Time2:
saniyeyi üst zaman birimlerine çevirir
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
   
        $taraDili= $_COOKIE["lng"]; 
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
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}  
/*
temaBilgisi:
temanýn deðiþtirilmesi
*/
function temaBilgisi(){
	$result = "silverModern";
	$cerezden = temizle($_COOKIE["theme"]);

	 if($cerezden!="" and is_dir('theme/'.$cerezden)){

		  $result=$cerezden;
	  }
	  
	  if(empty($cerezden)) 
	    setcookie("theme",$result,time()+60*60*24*30);

	  return $result;
}	
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
          <li><a href="index.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a></li>
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
    $protect = new flood_protection();
    $protect -> host         = $_host;
    $protect -> password     = $_password; 
    $protect -> username     = $_username; 
    $protect -> db             = $_db; 
    
    if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
      die('<br/><img src="img/warning.png" align="absmiddle" border="0" style="vertical-align: middle;" alt=\"warning\"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
}

	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
	
	if($currentFile!="install.php") echo ("<font id='hata'>Dosya uyumlu deðil!</font><br/>"); 

	if(isset($_POST['submit']))
	{

		  require("lib/SQL_Import2.php");
		  
					$host =  $_host;
					$dbUser =  $_username;
					$dbPassword =  $_password;
					$sqlFile = "installation_Database.sql";
					
					$baglan2= @mysql_connect($host, $dbUser, $dbPassword);
					
					if(!$baglan2) echo("<font id='hata'>MySQL sunucuya baðlantý yapýlamadý! L&#252;ften,'database.php' dosyasýný d&uuml;zenleyiniz.</font>".mysql_error()."<br/>Tekrar denemek i&ccedil;in <a href=install.php>týklatýnýz</a>!");
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
							
					  $newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);								
					  //$importumuz = $newImport -> importa ();
					  $newImport -> import ();
				
					  $import = $newImport -> ShowErr ();
						
						if ($import["exito"] != 1)
						{
							echo "<font id='tamam'><br/>";
						} else {
							echo $import ["errorCode"]." ".$import ["errorText"];
							echo "<font id='tamam'>Veritabaný kurulmuþ haldedir.<br/>Tablo oluþturmaya devam etmek için 'Otomatik Kurulum' d&uuml;ðmesine tekrar basýnýz.<br/>Tablolarý zaten oluþturdu iseniz, bu uyarýyý gözardý ediniz. </font>".$metin[47]."<br/>Varsayýlan kullanýcý adý ve parolasý: admin 11111</font>";
						}
									
						
					}
	  mysql_close($yol22);	
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