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
  checkLoginLang(true,true,"siteSettings2.php");	   
  $seciliTema=temaBilgisi();	
  
  require("lib/SQL_Export.php");
 	 
 if(isset($_GET[dump]) && $_GET[dump]=="1")
  {
			$mysql_host = $_host;
			$mysql_database= $_db;	
			$mysql_username= $_username;	
			$mysql_password=$_password;		
			$print_form=0;
		
		  ob_start(); /* start buffering */  
		  echo "your cvs or sql output!";    
		  $content = _mysqldump($mysql_database); /* get the buffer */
		  ob_end_clean();
		  $content = gzencode($content, 9);    
		  header("Content-Type: application/force-download");
		  header("Content-Type: application/octet-stream");
		  header("Content-Type: application/download");
		  header("Content-Description: Download SQL Export");  
		  header('Content-Disposition: attachment; filename="'.$mysql_host."_".$mysql_database."_".date('YmdHis').'.txt.zip"'); 
		  echo $content;
		  trackUser($currentFile,"success,SQLDump",$adi);
		  die('');		
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
<title>eOgr -<?php echo $metin[156]?></title>
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
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
          <h1 id="name-text" class="logo-name"><a href="index.php"> <?php echo ayarGetir("okulGenelAdi")?> </a></h1>
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
          <div class="cleared"></div>
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
                    <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[156]?> </span> </h2>
                    <div class="PostContent"> <span title="<?php echo $metin[111]?>"> <?php echo $metin[48]?> </span><br />
                      <span> <?php echo $metin[215]?> </span><br />
                      <?php
	if ($tur=="2")	{
	 //yönetici ise
			
			 if(isset($_POST[sqlial]) && $_POST[sqlial]=="sqlimp")
			  {
						require("lib/SQL_Import.php");
			
						mysql_query("SET NAMES 'latin1'");
						mysql_query("SET CHARACTER SET latin1");
						mysql_query("SET COLLATION_CONNECTION = 'latin1_turkish_ci'");
			
						$host =  $_host;
						$dbUser =  $_username;
						$dbPassword =  $_password;
							$sqlGelen = str_replace("\'", "'", $_POST["sqlAl"]);
							$sqlGelen = str_replace('\"', '"', $sqlGelen);
							/*$sqlGelen = str_replace( 'Ä±', 'ý',$sqlGelen);
							$sqlGelen = str_replace('Ã¼','&uuml;',  $sqlGelen);
							$sqlGelen = str_replace('ÄY','ð',  $sqlGelen);
							$sqlGelen = str_replace('ÅY','þ',  $sqlGelen);
							$sqlGelen = str_replace('Ã§','&ccedil;',  $sqlGelen);
							$sqlGelen = str_replace('Ã¶','&ouml;',  $sqlGelen);*/
						$sqlFile = $sqlGelen;
						
						$baglan2=mysql_connect($host, $dbUser, $dbPassword);
						
						if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
						
						$yol22 = $baglan2;
						
						if (mysql_select_db( $_db, $yol22)) {
						
								$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);
									
								$importumuz = $newImport -> importa ();
								
								if ($importumuz == 0) {
									echo "<font id='tamam'>$metin[538]</font><br/>";
									trackUser($currentFile,"success,SQLImp",$adi);
									}
								 else{
									echo "<font id='hata'>".$importumuz."</font><br/>";
									trackUser($currentFile,"fail,SQLImp",$adi);
								 }
							//mysql_close($yol22);			
						}		
						 
			  }
			
			 if(isset($_GET["optim"]) && $_GET["optim"]=="1")
			  {
						require("lib/SQL_Import.php");
			
						$host =  $_host;
						$dbUser =  $_username;
						$dbPassword =  $_password;
						$sqlFile = "REPAIR  TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating, eo_files, eo_friends, eo_askanswer, eo_askanswerrate, eo_askquestion; 
		OPTIMIZE TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating, eo_files, eo_friends, eo_askanswer, eo_askanswerrate, eo_askquestion;";
						
						$baglan2=mysql_connect($host, $dbUser, $dbPassword);
						
						if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
						
						$yol22 = $baglan2;
						
						if (mysql_select_db( $_db, $yol22)) {
						
								$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);
									
								$importumuz = $newImport -> importa ();
								
								if ($importumuz == 0){
									trackUser($currentFile,"success,DBOptim",$adi);
									echo ("<font id='tamam'>$metin[539]</font><br/>");
								}
								 else {
									echo "<font id='hata'>".$importumuz."</font><br/>";
									trackUser($currentFile,"fail,DBOptim",$adi);
								 }
						mysql_close($yol22);				
						}	
						 
						$sqlFile = "";
			  }				
			
}	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
	  
                      ?>
                      <br />
                      <form id="sqlimp" name="sqlimp" method="post" action="siteSettings2.php">
                        <label title="<?php echo "SQL Import"?>"> <?php echo $metin[157]?> :
                          <textarea name="sqlAl" cols="85" rows="10"><?php echo $sqlFile?>
</textarea>
                        </label>
                        <input type="hidden" name="sqlial" value="sqlimp" />
                        <input name="al" type="submit" id="al" value="<?php echo $metin[158]?>"/>
                      </form>
                      <h4><?php echo $metin[211]?> :</h4>
                      <pre style="margin-left:-80px;line-height:12px;">
                      eo_1okul		<?php echo getTableSize("eo_1okul"); ?> - (<?php echo $metin[212]?>)<br />
                      <strong>eo_2sinif		<?php echo getTableSize("eo_2sinif"); ?> :</strong> <?php echo yetimKayitNolar("eo_2sinif")?><br />
                      <strong>eo_3ders		<?php echo getTableSize("eo_3ders"); ?> :</strong> <?php echo yetimKayitNolar("eo_3ders")?><br />
                      <strong>eo_4konu		<?php echo getTableSize("eo_4konu"); ?> :</strong> <?php echo yetimKayitNolar("eo_4konu")?><br />
                      <strong>eo_5sayfa		<?php echo getTableSize("eo_5sayfa"); ?> :</strong> <?php echo yetimKayitNolar("eo_5sayfa")?><br />
                      <strong>eo_userworks	<?php echo getTableSize("eo_userworks"); ?> :</strong> <?php echo yetimKayitNolar("eo_userworks")?><br />
                      <strong>eo_sinifogre	<?php echo getTableSize("eo_sinifogre"); ?> :</strong> <?php echo yetimKayitNolar("eo_sinifogre")?><br />
                      <strong>eo_rating		<?php echo getTableSize("eo_rating"); ?> :</strong> <?php echo yetimKayitNolar("eo_rating")?><br />
                      <strong>eo_comments	<?php echo getTableSize("eo_comments"); ?> :</strong> <?php echo yetimKayitNolar("eo_comments")?><br />
                      <strong>eo_files		<?php echo getTableSize("eo_files"); ?> :</strong> <?php echo yetimKayitNolar("eo_files")?><br />
                      <strong>eo_friends	<?php echo getTableSize("eo_friends"); ?> :</strong> <?php echo yetimKayitNolar("eo_friends")?><br />
                      <strong>eo_askquestion	<?php echo getTableSize("eo_askquestion"); ?> :</strong> <?php echo yetimKayitNolar("eo_askquestion")?><br />
                      <strong>eo_askanswer	<?php echo getTableSize("eo_askanswer"); ?> :</strong> <?php echo yetimKayitNolar("eo_askanswer")?><br />
                      <strong>eo_askanswerrate	<?php echo getTableSize("eo_askanswerrate"); ?> :</strong> <?php echo yetimKayitNolar("eo_askanswerrate")?><br />
                      eo_users			<?php echo getTableSize("eo_users"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_shoutbox		<?php echo getTableSize("eo_shoutbox"); ?> - (<?php echo $metin[212].", ".$metin[238]; ?>)<br />
                      eo_usertrack		<?php echo getTableSize("eo_usertrack"); ?> - (<?php echo $metin[212].", ".$metin[238];?>)<br />
                      eo_floodprotection	<?php echo getTableSize("eo_floodprotection"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_sitesettings		<?php echo getTableSize("eo_sitesettings"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_details	<?php echo getTableSize("eo_webref_rss_details"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_items	<?php echo getTableSize("eo_webref_rss_items"); ?> - (<?php echo $metin[212]?>)</pre>
                    </div>
                    <div class="cleared"></div>
                  </div>
                </div>
              </div>
              <div class="cleared"></div>
              <div class="contentLayout">
                <div class="content">
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
      </div>
    </div>
  </div>
</div>
</body>
</html>