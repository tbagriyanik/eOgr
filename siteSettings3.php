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
  checkLoginLang(true,true,"siteSettings3.php");	   
  $seciliTema=temaBilgisi();
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
	<title>eOgr -<?php echo $metin[112]?></title>
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
	</head>
	<body>
    <?php require("menu.php");?>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[112]?> </span> </h2>
          <div class="PostContent">
            <?php
	if ($tur=="2")	{
	 //yönetici ise
	 
if ((isset($_POST["MM_settings"])) && ($_POST["MM_settings"] == "form5")) {

  if ( 
     temizle($_POST['okulGenelAdi'])=="" || 
     temizle($_POST['versiyon'])=="" || 
     temizle($_POST['sayfaBlokSayisi'])=="" || 
     temizle($_POST['sayfaKullaniciSayisi'])=="" || 
     temizle($_POST['ayar1int'])=="" || 
     temizle($_POST['ayar2int'])=="" || 
     temizle($_POST['ayar3int'])=="" || 
     temizle($_POST['uploadFolder'])=="" || 
     temizle($_POST['siteUnlockPwd'])=="" || 
     temizle($_POST['defaultTheme'])=="" || 
     temizle($_POST['defaultLang'])=="" || 
     temizle($_POST['filesToPlay'])=="" || 
     temizle($_POST['fileMaxUploadSize'])=="" || 
     temizle($_POST['videoChatSession'])=="" || 
     temizle($_POST['whiteBoardSession'])=="" || 
     temizle($_POST['veriHareketleriSayisi'])==""
      )
	   echo "<font id='hata'>Site bilgilerinde eksik alanlar vardır.</font>";
	else{   
			
			if(empty($_POST['ayar5char1'])) $_POST['ayar5char1']="0"; else $_POST['ayar5char1']="1";
			if(empty($_POST['ayar5char2'])) $_POST['ayar5char2']="0"; else $_POST['ayar5char2']="1";
			if(empty($_POST['ayar5char3'])) $_POST['ayar5char3']="0"; else $_POST['ayar5char3']="1";
			if(empty($_POST['ayar5char4'])) $_POST['ayar5char4']="0"; else $_POST['ayar5char4']="1";
			if(empty($_POST['ayar5char5'])) $_POST['ayar5char5']="0"; else $_POST['ayar5char5']="1";
			if(empty($_POST['ayar5char6'])) $_POST['ayar5char6']="0"; else $_POST['ayar5char6']="1";
			if(empty($_POST['ayar5char7'])) $_POST['ayar5char7']="0"; else $_POST['ayar5char7']="1";
			if(empty($_POST['ayar5char8'])) $_POST['ayar5char8']="0"; else $_POST['ayar5char8']="1";
			if(empty($_POST['ayar5char9'])) $_POST['ayar5char9']="0"; else $_POST['ayar5char9']="1";
			if(empty($_POST['ayar5char10'])) $_POST['ayar5char10']="0"; else $_POST['ayar5char10']="1";
			if(empty($_POST['ayar5char11'])) $_POST['ayar5char11']="0"; else $_POST['ayar5char11']="1";
			if(empty($_POST['ayar5char12'])) $_POST['ayar5char12']="0"; else $_POST['ayar5char12']="1";
			if(empty($_POST['ayar5char13'])) $_POST['ayar5char13']="0"; else $_POST['ayar5char13']="1";
			if(empty($_POST['ayar5char14'])) $_POST['ayar5char14']="0"; else $_POST['ayar5char14']="1";
			if(empty($_POST['ayar5char15'])) $_POST['ayar5char15']="0"; else $_POST['ayar5char15']="1";
			if(empty($_POST['ayar5char16'])) $_POST['ayar5char16']="0"; else $_POST['ayar5char16']="1";
			if(empty($_POST['ayar5char17'])) $_POST['ayar5char17']="0"; else $_POST['ayar5char17']="1";

  if($_POST['ayar5char16']=="1") {
	 echo "<font id='tamam'> Site bakıma alındı.</font>";
	 trackUser($currentFile,"success,SiteLock",$adi);
  }
	
  if($_POST['ayar5char17']=="1") {
	 if(@chmod($_uploadFolder,0777)){		  
		 echo "<font id='tamam'> Paylaşım klasörü yazılabilir.</font>";
		 trackUser($currentFile,"success,SharedWrite",$adi);
	 }
  }else{
	 if(@chmod($_uploadFolder,0755)){		  
		 echo "<font id='tamam'> Paylaşım klasörü salt okunur.</font>";
		 trackUser($currentFile,"success,SharedReadOnly",$adi);
	 }
  }	
			
			$ayar5char = temizle($_POST['ayar5char1']."-".$_POST['ayar5char2']."-".$_POST['ayar5char3']."-".
						         $_POST['ayar5char4']."-".$_POST['ayar5char5']."-".$_POST['ayar5char6']."-".
								 $_POST['ayar5char7']."-".$_POST['ayar5char8']."-".$_POST['ayar5char9']."-".
								 $_POST['ayar5char10']."-".$_POST['ayar5char11']."-".$_POST['ayar5char12']."-".
								 $_POST['ayar5char13']."-".$_POST['ayar5char14']."-".$_POST['ayar5char15']."-".
								 $_POST['ayar5char16']."-".$_POST['ayar5char17']);

			$updateSQL = sprintf("
			UPDATE eo_sitesettings 
			SET okulGenelAdi=%s, versiyon=%s, sayfaBlokSayisi=%s, 
			sayfaKullaniciSayisi=%s, veriHareketleriSayisi=%s, 
			ayar4char=%s, ayar1int=%s, ayar2int=%s, ayar3int=%s, 
			ayar5char='%s',
			uploadFolder = %s,
			siteUnlockPwd = %s,
			defaultTheme = %s,
			defaultLang = %s,
			filesToPlay = %s,
			fileMaxUploadSize = %s,
			videoChatSession = %s,
			whiteBoardSession = %s
			
			WHERE id='1'",
							   temizle(GetSQLValueString($_POST['okulGenelAdi'], "text")),
							   temizle(GetSQLValueString($_POST['versiyon'], "text")),
							   temizle(GetSQLValueString($_POST['sayfaBlokSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['sayfaKullaniciSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['veriHareketleriSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['ayar4char'], "text")),
							   temizle(GetSQLValueString($_POST['ayar1int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar2int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar3int'], "int")),
							   $ayar5char,
							   temizle(GetSQLValueString($_POST['uploadFolder'], "text")),
							   temizle(GetSQLValueString($_POST['siteUnlockPwd'], "text")),
							   temizle(GetSQLValueString($_POST['defaultTheme'], "text")),
							   temizle(GetSQLValueString($_POST['defaultLang'], "text")),
							   temizle(GetSQLValueString($_POST['filesToPlay'], "text")),
							   temizle(GetSQLValueString($_POST['fileMaxUploadSize'], "int")),
							   temizle(GetSQLValueString($_POST['videoChatSession'], "text")),
							   temizle(GetSQLValueString($_POST['whiteBoardSession'], "text"))
							   );
		  //mysqli_select_db($_db, $yol);
		  $Result1 = mysqli_query($yol, $updateSQL);
		  if($Result1) {
			   	trackUser($currentFile,"success,SiteInfo",$adi);
				echo ("<font id='uyari'> $metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,SiteInfo",$adi);
				echo ("<font id='hata'> Site bilgilerinde hata olduğunda g&uuml;ncelleme işleminiz tamamlanamadı!</font>");
			}
	}
}

?>
            <br />
            <br />
            <?php
		
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
	
?>
            <form name="form5"  action="siteSettings3.php" method="post">
              <table width="90%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <th colspan="2"><?php echo $metin[113]?></th>
                </tr>
                <tr>
                  <td width="400" align="right"><label for="okulGenelAdi"> <?php echo $metin[114]?> :</label></td>
                  <td><input type="text" maxlength="15" size="15" name="okulGenelAdi" id="okulGenelAdi" value="<?php echo ayarGetir("okulGenelAdi")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="versiyon"> <?php echo $metin[115]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="versiyon" id="versiyon" value="<?php echo ayarGetir("versiyon")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="sayfaBlokSayisi"> <?php echo $metin[116]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="sayfaBlokSayisi" id="sayfaBlokSayisi" value="<?php echo ayarGetir("sayfaBlokSayisi")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="sayfaKullaniciSayisi"> <?php echo $metin[117]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="sayfaKullaniciSayisi" id="sayfaKullaniciSayisi" value="<?php echo ayarGetir("sayfaKullaniciSayisi")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="veriHareketleriSayisi"> <?php echo $metin[118]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="veriHareketleriSayisi" id="veriHareketleriSayisi" value="<?php echo ayarGetir("veriHareketleriSayisi")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="ayar1int"> <?php echo $metin[150]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="ayar1int" id="ayar1int" value="<?php echo ayarGetir("ayar1int")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="ayar2int"> <?php echo $metin[151]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="ayar2int" id="ayar2int" value="<?php echo ayarGetir("ayar2int")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="ayar3int"> <?php echo $metin[245]?> :</label></td>
                  <td><input type="text" maxlength="10" size="10" name="ayar3int" id="ayar3int" value="<?php echo ayarGetir("ayar3int")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="ayar4char"> <?php echo $metin[119]?> :</label></td>
                  <td><input type="text" maxlength="50" size="30" name="ayar4char" id="ayar4char" value="<?php echo ayarGetir("ayar4char")?>"/>
                    <tt><?php echo $metin[120]?></tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="uploadFolder"> <?php echo "uploadFolder"?> :</label></td>
                  <td><input type="text" maxlength="50" size="30" name="uploadFolder" id="uploadFolder" value="<?php echo ayarGetir("uploadFolder")?>"/>
                    <br />
                    <tt>
                    <?php
	if(substr(sprintf('%o', @fileperms($_uploadFolder)), -4)=="0755"){
		echo "<strong>$_uploadFolder</strong> $metin[532]";
	}else{
		echo "<strong>$_uploadFolder</strong> $metin[533]";
	}
                                  ?>
                    </tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="siteUnlockPwd"> <?php echo "siteUnlockPwd"?> :</label></td>
                  <td><label id="gg">#</label>
                    <input type="text" maxlength="50" size="15" name="siteUnlockPwd" id="siteUnlockPwd" value="<?php echo ayarGetir("siteUnlockPwd")?>" style="display: none;"/>
                    <script language="javascript">

$("#gg").click(function () {
$("#siteUnlockPwd").toggle();
return false;
});
</script></td>
                </tr>
                <tr>
                  <td align="right"><label for="defaultTheme"> <?php echo "defaultTheme"?> :</label></td>
                  <td><select name="defaultTheme" id="defaultTheme">
                      <?php	
	$themeArray=glob('theme/*', GLOB_ONLYDIR);
	$i=0;
	foreach($themeArray as $thme){
?>
                      <option value="<?php $temaGel = explode("/",$thme);
	  echo $temaGel[1];?>" <?php if (ayarGetir("defaultTheme")==$temaGel[1]) {echo "selected=\"selected\"";} ?>>
                    <?php 	  
	  echo $temaGel[1];
	  ?>
                    </option>
                      <?php
	  $i++;
	}
?>
                    </select>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="defaultLang"> <?php echo "defaultLang"?> :</label></td>
                  <td><input type="text" maxlength="50" size="5" name="defaultLang" id="defaultLang" value="<?php echo ayarGetir("defaultLang")?>"/>
                    <tt>TR EN</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="filesToPlay"> <?php echo "filesToPlay"?> :</label></td>
                  <td><input type="text" maxlength="100" size="50" name="filesToPlay" id="filesToPlay" value="<?php echo ayarGetir("filesToPlay")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><label for="fileMaxUploadSize"> <?php echo "fileMaxUploadSize"?> :</label></td>
                  <td><input type="text" maxlength="50" size="5" name="fileMaxUploadSize" id="fileMaxUploadSize" value="<?php echo ayarGetir("fileMaxUploadSize")?>"/>
                    <tt>MB</tt></td>
                </tr>
                <tr>
                  <td align="right"><a href="http://www.tokbox.com"><?php echo "http://www.tokbox.com"?></a></td>
                  <td><input type="text" maxlength="50" size="50" name="videoChatSession" id="videoChatSession" value="<?php echo ayarGetir("videoChatSession")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><a href="http://flockdraw.com"><?php echo "http://flockdraw.com"?></a></td>
                  <td><input type="text" maxlength="50" size="10" name="whiteBoardSession" id="whiteBoardSession" value="<?php echo ayarGetir("whiteBoardSession")?>"/>
                    <tt>*</tt></td>
                </tr>
                <tr>
                  <td align="right"><?php echo $metin[216]?> :</td>
                  <?php
								  $secenekler = explode("-",ayarGetir("ayar5char"));
								?>
                  <td><label>
                      <input type="checkbox" name="ayar5char1" 
            id="ayar5char1" value="1" <?php if($secenekler[0]=="1") 
			echo " checked='checked'"; else echo ""; ?> />
                      <?php echo $metin[535]?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char2" 
            id="ayar5char2" value="1" <?php if($secenekler[1]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[154];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char3" 
            id="ayar5char3" value="1" <?php if($secenekler[2]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[139];?></label>
                    <br/>
                    <label>
                      <input type="checkbox" name="ayar5char4" 
            id="ayar5char4" value="1" <?php if($secenekler[3]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[155];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char5" 
            id="ayar5char5" value="1" <?php if($secenekler[4]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[217];?></label>
                    <br /></td>
                </tr>
                <tr>
                  <td align="right"><?php echo $metin[255]?> :</td>
                  <td><label>
                      <input type="checkbox" name="ayar5char7" 
            id="ayar5char7" value="1" <?php if($secenekler[6]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[257];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char8" 
            id="ayar5char8" value="1" <?php if($secenekler[7]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[258];?></label>
                    <br/>
                    <label>
                      <input type="checkbox" name="ayar5char9" 
            id="ayar5char9" value="1" <?php if($secenekler[8]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[259];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char10" 
            id="ayar5char10" value="1" <?php if($secenekler[9]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[260];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char14" 
            id="ayar5char14" value="1" <?php if($secenekler[13]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[307];?></label>
                    <br/>
                    <label>
                      <input type="checkbox" name="ayar5char15" 
            id="ayar5char15" value="1" <?php if($secenekler[14]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[308];?></label></td>
                </tr>
                <tr>
                  <td align="right"><?php echo $metin[303]?> :</td>
                  <td><label>
                      <input type="checkbox" name="ayar5char6" 
            id="ayar5char6" value="1" <?php if($secenekler[5]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[256];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char11" 
            id="ayar5char11" value="1" <?php if($secenekler[10]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[304];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char12" 
            id="ayar5char12" value="1" <?php if($secenekler[11]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[305];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char13" 
            id="ayar5char13" value="1" <?php if($secenekler[12]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <?php echo $metin[306];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char16" 
            id="ayar5char16" value="1" <?php if($secenekler[15]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <img src="img/lock.png" alt="imp" border="0" style="vertical-align: middle;" /> <?php echo $metin[528];?></label>
                    <br />
                    <label>
                      <input type="checkbox" name="ayar5char17" 
            id="ayar5char17" value="1" <?php if($secenekler[16]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                      <img src="img/lessons.gif" alt="imp" border="0" style="vertical-align: middle;" /> <?php echo $metin[529];
	echo "</td></tr><tr><td colspan='2'>";
	printf($metin[534],smartShort($_siteUnlockPwd,0));
	?></label></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"  class="tabloAlt"><input type="hidden" name="MM_settings" value="form5" />
                    <input type="submit" value="<?php echo $metin[121]?>" />
                    &nbsp;
                    <input type="button" value="<?php echo $metin[246]?>" onclick="getDefaults();" /></td>
                </tr>
              </table>
            </form>
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
    <script type="text/javascript">
/*
getDefaults:
site ayarlarının varsayılanlarının atanması
*/
function getDefaults(){
	document.getElementById('okulGenelAdi').value = "Net Course" ;
	document.getElementById('versiyon').value = "version" ;
	document.getElementById('sayfaBlokSayisi').value = "5" ;
	document.getElementById('sayfaKullaniciSayisi').value = "10" ;
	document.getElementById('veriHareketleriSayisi').value = "10" ;
	document.getElementById('ayar1int').value = "5" ;
	document.getElementById('ayar2int').value = "10" ;
	document.getElementById('ayar3int').value = "10" ;
	document.getElementById('ayar4char').value = "admin@email.com" ;
	document.getElementById('ayar5char1').checked = true;
	document.getElementById('ayar5char2').checked = true;
	document.getElementById('ayar5char3').checked = true;
	document.getElementById('ayar5char4').checked = true;
	document.getElementById('ayar5char5').checked = true;
	document.getElementById('ayar5char6').checked = true;
	document.getElementById('ayar5char7').checked = true;
	document.getElementById('ayar5char8').checked = true;
	document.getElementById('ayar5char9').checked = true;
	document.getElementById('ayar5char10').checked = true;
	document.getElementById('ayar5char11').checked = true;
	document.getElementById('ayar5char12').checked = true;
	document.getElementById('ayar5char13').checked = true;
	document.getElementById('ayar5char14').checked = true;
	document.getElementById('ayar5char15').checked = true;
	document.getElementById('ayar5char16').checked = false;
	document.getElementById('ayar5char17').checked = true;
}
</script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>