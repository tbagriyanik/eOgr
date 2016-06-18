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
  checkLoginLang(true,true,"siteSettings2.php");	   
  $seciliTema=temaBilgisi();	
  
  require("lib/SQL_Export.php");
 	 
 if(isset($_GET["dump"]) && $_GET["dump"]=="1")
  {
			$mysqli_host = $_host;
			$mysqli_database= $_db;	
			$mysqli_username= $_username;	
			$mysqli_password=$_password;		
			$print_form=0;
		
		  ob_start(); /* start buffering */  
		  echo "eOgr - SQL output";    
		  $content = _mysqldump($mysqli_database, $yol); /* get the buffer */
		  ob_end_clean();
		  //$content = gzencode($content, 9);   //PHP 7?  
		  header("Content-Type: application/force-download");
		  header("Content-Type: application/octet-stream");
		  header("Content-Type: application/download");		  
		  header('Content-Length: ' . strlen($content));
		  header("Content-Description: Download SQL Export");  
		  header('Content-Disposition: attachment; filename="'.$mysqli_host."_".$mysqli_database."_".date('YmdHis').'.txt"'); 
		  echo $content;
		  ob_end_flush();
		  trackUser($currentFile,"success,SQLDump",$adi);
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
<title>eOgr -<?php echo $metin[156]?></title>
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
<script type="text/javascript">
    jQuery(document).ready(function($) {
		$("#msg_body2").hide();
		$("#msg_head").click(function(){
			$(this).next("#msg_body2").slideToggle(200);
		});
      }) 
</script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[156]?> </span> </h2>
      <div class="PostContent">
        <table border="0" cellpadding="5" cellspacing="5" align="center">
          <tr>
            <td align="right"><span title="<?php echo $metin[111]?>"> <?php echo $metin[48]?> </span></td>
            <td align="right"><?php echo $metin[215]?> </span><br /></td>
          </tr>
          <tr>
            <td align="right"><?php echo $metin[666]?></td>
            <td align="right"><?php echo $metin[680]?></td>
          </tr>
        </table>
        <?php
	if ($tur=="2")	{
	 //yönetici ise
			
			 if(isset($_POST["sqlial"]) && $_POST["sqlial"]=="sqlimp")
			  {
						require("lib/SQL_Import.php");
			
						mysqli_query($yol, "SET NAMES 'utf-8'");
						mysqli_query($yol, "SET CHARACTER SET utf8");
						mysqli_query($yol, "SET COLLATION_CONNECTION = 'utf8_general_ci'");
			
						$host =  $_host;
						$dbUser =  $_username;
						$dbPassword =  $_password;
							$sqlGelen = str_replace("\'", "'", $_POST["sqlAl"]);
							$sqlGelen = str_replace('\"', '"', $sqlGelen);
							/*$sqlGelen = str_replace( 'Ä±', 'ı',$sqlGelen);
							$sqlGelen = str_replace('Ã¼','&uuml;',  $sqlGelen);
							$sqlGelen = str_replace('ÄY','ğ',  $sqlGelen);
							$sqlGelen = str_replace('ÅY','ş',  $sqlGelen);
							$sqlGelen = str_replace('Ã§','&ccedil;',  $sqlGelen);
							$sqlGelen = str_replace('Ã¶','&ouml;',  $sqlGelen);*/
						$sqlFile = $sqlGelen;
						
						$baglan2=mysqli_connect($host, $dbUser, $dbPassword);
						
						if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
						
						$yol22 = $baglan2;
						
						if ($yol22) {
						
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
							//mysqli_close($yol22);			
						}		
						 
			  }
			
			 if(isset($_GET["fixLesson"]) && $_GET["fixLesson"]=="1")			  {
				 printf("<font id='tamam'>$metin[667]</font>",lessonPageFix());				 
			  }
			 if(isset($_GET["eraseOld"]) && $_GET["eraseOld"]=="1")			  {
				 printf("<font id='tamam'>$metin[679]</font>",eraseOlderTracks());				 
			  }
			 if(isset($_GET["optim"]) && $_GET["optim"]=="1")			  {
						require("lib/SQL_Import.php");
			
						$host =  $_host;
						$dbUser =  $_username;
						$dbPassword =  $_password;
						$dbName = $_db;
						$sqlFile = "REPAIR  TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating, eo_files, eo_friends, eo_askanswer, eo_askanswerrate, eo_askquestion, eo_livelesson; 
		OPTIMIZE TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating, eo_files, eo_friends, eo_askanswer, eo_askanswerrate, eo_askquestion, eo_livelesson;";
						
						$baglan2=mysqli_connect($host, $dbUser, $dbPassword, $_db);
						
						if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
						
						$yol22 = $baglan2;
						
						if ($yol22) {
						
								$newImport = new sqlImport ($host, $dbUser, $dbPassword, $_db, $sqlFile);
									
								$importumuz = $newImport -> importa ();
								
								if ($importumuz == 0){
									trackUser($currentFile,"success,DBOptim",$adi);
									echo ("<font id='tamam'>$metin[539]</font><br/>");
								}
								 else {
									echo "<font id='hata'>".$importumuz."</font><br/>";
									trackUser($currentFile,"fail,DBOptim",$adi);
								 }
						mysqli_close($yol22);				
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
            <textarea name="sqlAl" id="sqlAl"cols="55" rows="5"><?php echo (isset($sqlFile))?$sqlFile:""?>
</textarea>
          </label>
          <input type="hidden" name="sqlial" value="sqlimp" />
          <input name="al" type="submit" id="al" value="<?php echo $metin[158]?>"/>
        </form>
        <h4 id='msg_head' style="cursor:pointer;"><img src="img/page-next.gif" alt='next' border='0' style="vertical-align: middle;"/><?php echo $metin[211]?></h4>
        <pre id="msg_body2" style="margin-left:-50px;line-height:12px;font-family:'Courier New', Courier, monospace">
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
                      <strong>eo_livelesson	<?php echo getTableSize("eo_livelesson"); ?> :</strong> <?php echo yetimKayitNolar("eo_livelesson")?><br />
                      eo_users			<?php echo getTableSize("eo_users"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_shoutbox		<?php echo getTableSize("eo_shoutbox"); ?> - (<?php echo $metin[212].", ".$metin[238]; ?>)<br />
                      eo_usertrack		<?php echo getTableSize("eo_usertrack"); ?> - (<?php echo $metin[212].", ".$metin[238];?>)<br />
                      eo_floodprotection	<?php echo getTableSize("eo_floodprotection"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_sitesettings		<?php echo getTableSize("eo_sitesettings"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_details	<?php echo getTableSize("eo_webref_rss_details"); ?> - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_items	<?php echo getTableSize("eo_webref_rss_items"); ?> - (<?php echo $metin[212]?>)</pre>
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