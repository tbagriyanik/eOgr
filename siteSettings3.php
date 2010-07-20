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
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"siteSettings3.php");	   
  $seciliTema=temaBilgisi();	
 
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
<title>eOgr -<?php echo $metin[112]?></title>
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
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
     temizle($_POST['veriHareketleriSayisi'])==""
      )
	   echo "<font id='hata'>Site bilgilerinde eksik alanlar vardýr.</font>";
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
			
			$ayar5char = temizle($_POST['ayar5char1']."-".$_POST['ayar5char2']."-".$_POST['ayar5char3']."-".
						         $_POST['ayar5char4']."-".$_POST['ayar5char5']."-".$_POST['ayar5char6']."-".
								 $_POST['ayar5char7']."-".$_POST['ayar5char8']."-".$_POST['ayar5char9']."-".
								 $_POST['ayar5char10']."-".$_POST['ayar5char11']."-".$_POST['ayar5char12']."-".
								 $_POST['ayar5char13']."-".$_POST['ayar5char14']."-".$_POST['ayar5char15']);

			$updateSQL = sprintf("UPDATE eo_sitesettings SET okulGenelAdi=%s, versiyon=%s, sayfaBlokSayisi=%s, sayfaKullaniciSayisi=%s, veriHareketleriSayisi=%s, ayar4char=%s, ayar1int=%s, ayar2int=%s, ayar3int=%s, ayar5char='%s' WHERE id=1",
							   temizle(GetSQLValueString($_POST['okulGenelAdi'], "text")),
							   temizle(GetSQLValueString($_POST['versiyon'], "text")),
							   temizle(GetSQLValueString($_POST['sayfaBlokSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['sayfaKullaniciSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['veriHareketleriSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['ayar4char'], "text")),
							   temizle(GetSQLValueString($_POST['ayar1int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar2int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar3int'], "int")),
							   $ayar5char
							   );
		  mysql_select_db($database_baglanti, $yol);
		  $Result1 = mysql_query($updateSQL, $yol);
		  if($Result1) {
			   	trackUser($currentFile,"success,SiteInfo",$adi);
				echo ("<font id='tamam'> Site bilgilerini g&uuml;ncelleme iþleminiz tamamlandý!</font>");
		    }
			else {
			    trackUser($currentFile,"fail,SiteInfo",$adi);
				echo ("<font id='hata'> Site bilgilerinde hata olduðunda g&uuml;ncelleme iþleminiz tamamlanamadý!</font>");
			}
	}
}

?>
<br />
<br />
<?php
		
	}
	else
	  die($metin[447]);
	
?>                        
                          <form name="form5"  action="siteSettings3.php" method="post">
                            <table width="90%" border="0" cellspacing="0" cellpadding="3">
                              <tr>
                                <th colspan="2"><?php echo $metin[113]?></th>
                              </tr>
                              <tr>
                                <td width="400" align="right"><label for="okulGenelAdi"> <?php echo $metin[114]?> :</label></td>
                                <td><input type="text" maxlength="15" size="15" name="okulGenelAdi" id="okulGenelAdi" value="<?php echo ayarGetir("okulGenelAdi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="versiyon"> <?php echo $metin[115]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="versiyon" id="versiyon" value="<?php echo ayarGetir("versiyon")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="sayfaBlokSayisi"> <?php echo $metin[116]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="sayfaBlokSayisi" id="sayfaBlokSayisi" value="<?php echo ayarGetir("sayfaBlokSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="sayfaKullaniciSayisi"> <?php echo $metin[117]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="sayfaKullaniciSayisi" id="sayfaKullaniciSayisi" value="<?php echo ayarGetir("sayfaKullaniciSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="veriHareketleriSayisi"> <?php echo $metin[118]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="veriHareketleriSayisi" id="veriHareketleriSayisi" value="<?php echo ayarGetir("veriHareketleriSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar1int"> <?php echo $metin[150]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar1int" id="ayar1int" value="<?php echo ayarGetir("ayar1int")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar2int"> <?php echo $metin[151]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar2int" id="ayar2int" value="<?php echo ayarGetir("ayar2int")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar3int"> <?php echo $metin[245]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar3int" id="ayar3int" value="<?php echo ayarGetir("ayar3int")?>"/>
                                  * </td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar4char"> <?php echo $metin[119]?> :</label></td>
                                <td><input type="text" maxlength="50" size="30" name="ayar4char" id="ayar4char" value="<?php echo ayarGetir("ayar4char")?>"/>
                                  <font size="-1"><?php echo $metin[120]?></font></td>
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
                                    RSS</label>
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
                                  <br /></td>
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
                                  <br/>
                                  <label>
                                    <input type="checkbox" name="ayar5char15" 
            id="ayar5char15" value="1" <?php if($secenekler[14]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[308];?></label>
                                  <br /></td>
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
                        <div class="cleared"></div>
                      </div>
                    </div>
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
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
/*
getDefaults:
site ayarlarýnýn varsayýlanlarýnýn atanmasý
*/
function getDefaults(){
	document.getElementById('okulGenelAdi').value = "Net Okul" ;
	document.getElementById('versiyon').value = "versiyon" ;
	document.getElementById('sayfaBlokSayisi').value = "5" ;
	document.getElementById('sayfaKullaniciSayisi').value = "10" ;
	document.getElementById('veriHareketleriSayisi').value = "10" ;
	document.getElementById('ayar1int').value = "5" ;
	document.getElementById('ayar2int').value = "10" ;
	document.getElementById('ayar3int').value = "10" ;
	document.getElementById('ayar4char').value = "admin@eogr.com" ;
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
}
</script>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>