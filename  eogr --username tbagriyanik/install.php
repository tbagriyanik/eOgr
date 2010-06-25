<?php

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

function browserdili() {
         $lang=split('[,;]',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
         $lang=strtoupper($lang[0]);
         $lang=split('[-]',$lang);
         return $lang[0];
}

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
  
	
	$seciliTema="silverModern";
	if($_GET["theme"]!="")
	  {
		  setcookie("theme",temizle($_GET["theme"]),time()+60*60*24*30);
		  
		  switch ($_GET["theme"]){
			  case "0":	$seciliTema="silverModern";break;
			  case "1":	$seciliTema="darkOrange";break;
			  case "2":	$seciliTema="lightGreen";break;
			  default:	$seciliTema="silverModern"; 			  
		  }
	  }
	  else{
		  switch ($_COOKIE["theme"]){
			  case "0":	$seciliTema="silverModern";break;
			  case "1":	$seciliTema="darkOrange";break;
			  case "2":	$seciliTema="lightGreen";break;
			  default:	$seciliTema="silverModern"; 			  
		  }
	  }	
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
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
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
$sql = 	"CREATE TABLE  eo_floodprotection (      
  IP char(32) NOT NULL,   
  TIME char(20) NOT NULL, 
  PRIMARY KEY (IP)                  
 ) ;";

$sql .= "INSERT INTO eo_users (id, userName, userPassword, realName, userEmail, userBirthDate, userType, requestDate) VALUES 
	(1, \"admin\", \"7b21848ac9af35be0ddb2d6b9fc3851934db8420\", \"super kullanici\", \"admin@eogr.com\", \"2008-11-15\", 2, \"2008-11-15 00:00:00\");";

	
$sql .= "CREATE TABLE eo_usertrack (
  id int(11) NOT NULL auto_increment  PRIMARY KEY,
  IP varchar(40) NOT NULL,
  dateTime datetime NOT NULL,
  processName varchar(20) NOT NULL,
  userName varchar(15) NOT NULL,
  otherInfo varchar(15) NOT NULL
); ";

$sql .= "CREATE TABLE eo_shoutbox (
             messageid    int(11) not null auto_increment PRIMARY KEY,
             name         varchar(30) not null,
             url          varchar(100) not null,
             message      text not null,
             ip           int(11) not null,
             date         datetime not null default '0000-00-00 00:00:00');
       ";

$sql .= "
CREATE TABLE eo_1okul (
  id int(11) NOT NULL auto_increment  PRIMARY KEY ,
  okulAdi varchar(50) NOT NULL  UNIQUE KEY 
);";

$sql .= "INSERT INTO eo_1okul (id, okulAdi) VALUES
(1, 'Meslek Lisesi');";

$sql .= "CREATE TABLE eo_2sinif (
  id int(11) NOT NULL auto_increment  PRIMARY KEY ,
  sinifAdi varchar(50) NOT NULL ,
  okulID int(11) NOT NULL
);";

$sql .= "INSERT INTO eo_2sinif (id, sinifAdi, okulID) VALUES
(1, '10.sinif', 1),
(2, '11.sinif', 1);
";

$sql .= "CREATE TABLE eo_3ders (
id int(11) NOT NULL auto_increment  PRIMARY KEY ,
  dersAdi varchar(50) NOT NULL ,
  sinifID int(11) NOT NULL
) ;";

$sql .= "INSERT INTO eo_3ders (id, dersAdi, sinifID) VALUES
(1, 'Matematik', 1),
(2, 'Turkce', 1),
(3, 'Turkce', 2),
(4, 'Matematik', 2),
(5, 'Bilisim Temelleri', 1),
(6, 'Paket Programlama', 1);
";

$sql .= "CREATE TABLE eo_4konu (
  id int(11) NOT NULL auto_increment  PRIMARY KEY ,
  konuAdi varchar(50) NOT NULL,
  dersID int(11) NOT NULL,
  bitisTarihi date NOT NULL,
  oncekiKonuID int(11) NOT NULL,
  konuyuKilitle tinyint(1) NOT NULL,
  sadeceKayitlilarGorebilir tinyint(1) NOT NULL,
  sinifaDahilKullaniciGorebilir tinyint(1) NOT NULL,
  calismaSuresiDakika int(11) NOT NULL,
  calismaHakSayisi int(11) NOT NULL
) ;";

$sql .= "INSERT INTO eo_4konu (id, konuAdi, dersID) VALUES
(1, 'Programlama Temelleri', 5),
(2, 'Anakart', 5),
(3, 'Kelime Islemci Programi', 6),
(4, 'Hesap Tablosu Programi', 6);";

$sql .= "CREATE TABLE eo_5sayfa (
  id int(11) NOT NULL auto_increment  PRIMARY KEY ,
  anaMetin varchar(10000) NOT NULL,
  konuID int(11) NOT NULL,
  secenek1 varchar(1000) NOT NULL,
  secenek2 varchar(1000) NOT NULL,
  secenek3 varchar(1000) NOT NULL,
  secenek4 varchar(1000) NOT NULL,
  secenek5 varchar(1000) NOT NULL,
  cevap varchar(50) NOT NULL,
  ekleyenID int(11) NOT NULL,
  eklenmeTarihi datetime NOT NULL,
  sayfaSirasi int(11) NOT NULL
) ;";

$sql .= "INSERT INTO eo_5sayfa (id, anaMetin, konuID, secenek1, secenek2, secenek3, secenek4, secenek5, cevap, ekleyenID, eklenmeTarihi) VALUES
(1, 'ilk eklenen konu... algoritma nedir ne ise yarar', 1, 'sudur budur', 'falan filan', '', '', '', '', 1, '2009-01-20 18:29:54'),
(2, 'programlama nedir ne ile yazilir neden ....', 1, 'sudur budur', 'falan filan', '', '', '', '', 1, '2009-01-20 18:29:54');
";

$sql .= "CREATE TABLE eo_sitesettings (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  okulGenelAdi varchar(15) NOT NULL,
  versiyon varchar(10) NOT NULL,
  sayfaBlokSayisi int(11) NOT NULL,
  sayfaKullaniciSayisi int(11) NOT NULL,
  veriHareketleriSayisi int(11) NOT NULL,
  ayar1int int(11) NOT NULL,
  ayar2int int(11) NOT NULL,
  ayar3int int(11) NOT NULL,
  ayar4char varchar(50) DEFAULT NULL,
  ayar5char varchar(50) DEFAULT NULL
  );";

$sql .= "INSERT INTO eo_sitesettings (id, okulGenelAdi, versiyon, sayfaBlokSayisi, sayfaKullaniciSayisi, veriHareketleriSayisi, ayar1int, ayar2int, ayar3int, ayar4char, ayar5char) VALUES (1, 'Net Okul', 'version', 5, 10, 10, 5, 10, 10, 'admin@eogr.com', '1-1-1-1-1-1-1-1-1-1-1-1-1-1-1');";


$sql .= "
CREATE TABLE eo_webref_rss_details (
  id int(11) NOT NULL auto_increment PRIMARY KEY,
  title text NOT NULL,
  description mediumtext NOT NULL,
  link text,
  language text,
  image_title text,
  image_url text,
  image_link text,
  image_width text,
  image_height text
);  ";

$sql .= "INSERT INTO eo_webref_rss_details (id, title, description, link, language, image_title, image_url, image_link, image_width, image_height) VALUES
(1, 'eOgr', 'eOgrenme - eLearning RSS Feed', 'http://eogr.com', 'TR', '', '', '', '', '');";

$sql .= "CREATE TABLE eo_webref_rss_items (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title text NOT NULL,
  description mediumtext NOT NULL,
  link text,
  pubDate DATETIME NOT NULL
  );";

$sql .= "INSERT INTO eo_webref_rss_items (id, title, description, link, pubDate) VALUES
(1, 'eOgr', 'Bir haber ornegi...', '', '2009-06-14 21:29:13');";

$sql .= "CREATE TABLE eo_userworks (
	  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	  userID int(11) NOT NULL,
	  konuID int(11) NOT NULL,
	  toplamZaman int(11) NOT NULL,
	  lastPage int(11) NOT NULL,
	  calismaTarihi datetime NOT NULL  
		);";

 
$sql .= "CREATE TABLE eo_sinifogre (
		id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		userID INT(11) NOT NULL ,
		sinifID INT(11) NOT NULL
		);";

$sql .= "CREATE TABLE eo_rating (
		id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		userID INT(11) NOT NULL ,
		konuID INT(11) NOT NULL ,
		value INT(11) NOT NULL ,
		rateDate DATETIME NOT NULL
		);";

$sql .= "CREATE TABLE eo_comments (
		  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		  userID int(11) NOT NULL,
		  konuID int(11) NOT NULL,
		  comment varchar(1000) NOT NULL,
		  commentDate datetime NOT NULL,
		  active tinyint(1) NOT NULL
		);";

		  require("lib/SQL_Import.php");
		  
					$host =  $_host;
					$dbUser =  $_username;
					$dbPassword =  $_password;
					$sqlFile = $sql;
					
					$baglan2= @mysql_connect($host, $dbUser, $dbPassword);
					
					if(!$baglan2) echo("<font id='hata'>MySQL sunucuya baðlantý yapýlamadý! L&#252;ften,'database.php' dosyasýný d&uuml;zenleyiniz.</font>".mysql_error()."<br/>Tekrar denemek i&ccedil;in <a href=install.php>týklatýnýz</a>!");
					else{
					$yol22 = $baglan2;
					$vtSec = @mysql_select_db( $_db, $yol22);
					if(!$vtSec)echo("<font id='hata'>MySQL veritabaný bulunamadý! L&#252;ften, 'database.php' dosyasýný d&uuml;zenleyiniz.</font>Tekrar denemek i&ccedil;in <a href=install.php>týklatýnýz</a>!");
						else {
							$result = @mysql_query("CREATE TABLE eo_users (  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
								   userName varchar(30) NOT NULL UNIQUE KEY ,
									  userPassword varchar(40) NOT NULL,
									  realName varchar(50) NOT NULL,
									  userEmail varchar(50) NOT NULL UNIQUE KEY ,
									  userBirthDate date NOT NULL,
									  userType tinyint(4) NOT NULL DEFAULT '0',
									  requestDate datetime NOT NULL
									  ) ;");
							if (!$result)
							{
							echo "<font id='hata'>Veritabaný zaten kurulmuþ haldedir. Tekrar kurmak i&ccedil;in baþka bir veritabaný se&ccedil;ebilirsiniz.</font>";
							}
							else					
							 {
							
									$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);								
									$importumuz = $newImport -> importa ();
									
									if ($importumuz == "")
										echo "<font id='tamam'>Tablolar Oluþturuldu: $db_name (veritabaný). </font>".$metin[47]."<br/>Varsayýlan kullanýcý adý ve parolasý: admin 11111<br/>";
									 else {
										$sql = "DROP TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_rating,eo_comments;";
										mysql_query($sql, $yol22);
										echo "<font id='hata'>Ýþlem hata(lar) oluþarak tamamlandý, bu sebeple varolan tablolar silindi. Tekrar Kurulum d&uuml;ðmesine basýnýz.</font><br/>".$importumuz."<br/>";
									 }
											
							}	
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
                  <p><strong> <?php echo $metin[73]?> </strong></p>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input name="submit" type="submit" value="<?php echo $metin[46]?>" />
                  </form>
                  <?php if(file_exists("installation_Database.sql")):?>
                  <p><strong> <?php echo $metin[398]?> </strong></p>
                  <a href="installation_Database.sql"><?php echo $metin[399]?> - <?php echo filesize("installation_Database.sql")?> B</a>
                  <?php endif?>
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