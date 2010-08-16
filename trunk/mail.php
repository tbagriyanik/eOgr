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
    header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");    
	
	if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
	 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"mail.php");	  
  check_source(); 
  $seciliTema=temaBilgisi();	

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
		@header("Location:error.php?error=4");
	  echo('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> &#220;zg&#252;n&#252;z, iste&#287;inize &#351;u anda cevap veremiyoruz.'.
		  '<br/>L&#252;ften bir s&#252;re sonra <a href='.$_SERVER['PHP_SELF'].'>tekrar</a> deneyiniz!'); // die there flooding
		$hata = true;
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
<title>eOgr -<?php echo $metin[69]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script src="lib/jquery-1.4.2.min.js" type="text/javascript"></script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[69]?> </span> </h2>
                <div class="PostContent">
                  <?php   
echo ("<div id='lgout'><a href='#' onclick='window.close();'>".$metin[34]."</a></div><br/>");
				  
   $address1	=	temizle($_REQUEST["to"]);
   $address1 	= 	getMailAddress($address1);
	if(!email_valid($address1) && !empty($address1)){
			echo "<font id='hata'>&Ouml;z&uuml;r dileriz, kullanýcýnýn eposta adresi bilgisinde sorun var!</font>";
			$hata = true;
	}
		
   if(isset($_POST["konu"])){

			if ($_POST["ccode"] != $_SESSION["ccode"]) {
			  echo ("<font id='hata'> Kod boþ veya hatalý girildi!</font>");
			  $hata = true;
			  $_SESSION["ccode"] = "";
			}else{
				   $_SESSION["ccode"] = "";
				   $subject=temizle($_POST["konu"]);
				   $address=temizle($_POST["address"]);
				   $address = getMailAddress($address);
				   $bodisi=temizle($_POST["icerik"]);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-9' . "\r\n";
//	$headers .= 'From: tbagriyanik@gmail.com' . "\r\n" .'Reply-To: tbagriyanik@gmail.com' . "\r\n" .
							   'X-Mailer: PHP/' . phpversion();
					if(email_valid($address)){
						if (@mail("$address", "eOgr - $subject", "$bodisi",$headers)){
							 echo("<font id='tamam'>Epostanýz G&ouml;nderildi!</font>");
							 $hata = true;
								}	
							 else {
							 echo("<font id='hata'>&Ouml;z&uuml;r dileriz, þu anda mesajýnýz g&ouml;nderilemiyor!</font>");
							 $hata = true;
							 }
					}
					else 
						echo "<font id='hata'>&Ouml;z&uuml;r dileriz, kullanýcýnýn eposta adresi bilgisinde sorun var!</font>";
						$hata = true;
						}
	   }
	   
   $address = $_GET["to"];
   
   if(empty($address) &&  isset($_POST["address"]))  $address = $_POST["address"];
				   
   if(empty($address) || !is_numeric($address))
   {
	    echo("<font id='hata'>Eposta bilgisi boþ olamaz!</font>");
		$hata = true;
 	    $_SESSION["ccode"] = "";

   }
	
	if($hata==false)
    {
		$ccode = newPassw();
		$_SESSION["ccode"]=$ccode;
?>
                  <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
                  <div id="contact-wrapper">
                    <form id="form1" method="post" action="mail.php">
                      <fieldset>
                        <label for="konu"> <?php echo $metin[124]?> :</label>
                        <div>
                          <input name="konu" type="text" id="konu" size="50" maxlength="50" class="required" />
                        </div>
                        <label for="icerik"> <?php echo $metin[125]?> :</label>
                        <div>
                          <textarea name="icerik" id="icerik" cols="65" rows="8" class="required"></textarea>
                        </div>
                        <input type="hidden" name="address" value='<?php echo $address?>'/>
                        <input type="hidden" name="ccode" value="<?php echo $ccode ?>" />
                        <input type="submit" name="button" id="button" value="<?php echo $metin[100]?>" />
                      </fieldset>
                    </form>
                  </div>
                  <script type="text/javascript">
  $(document).ready(function(){
    $("#form1").validate();
  });
  </script>
                  <?php
	}

?>
                </div>
                <div class="cleared"></div>
              </div>
              &nbsp;</div>
          </div>
          <div class="cleared"></div>
          <div class="Footer">
            <div class="Footer-inner"> </div>
            <div class="Footer-background"></div>
          </div>
        </div>
      </div>
      <div class="cleared"></div>
    </div>
  </div>
</div>
<script type="text/javascript" language="javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
if (document.getElementById("konu")!=null)  document.getElementById("konu").focus();
</script>
</body>
</html>
