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
   header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");    
	
	ob_start (); // Buffer output
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
	 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"mail.php");	  
//  check_source(); 
  $seciliTema=temaBilgisi();	

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
		@header("Location: error.php?error=4");
	  echo('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> &#220;zg&#252;n&#252;z, iste&#287;inize &#351;u anda cevap veremiyoruz.'.
		  '<br/>L&#252;ften bir s&#252;re sonra <a href='.$_SERVER['PHP_SELF'].'>tekrar</a> deneyiniz!'); // die there flooding
		$hata = true;
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
	<title>eOgr -<?php echo $metin[69]?></title>
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
          <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[69]?> </span> </h2>
          <div class="PostContent">
            <?php   
echo ("<div id='lgout'><a href='#' onclick='window.close();'>".$metin[34]."</a></div><br/>");
				  
   $address1	=	temizle(isset($_REQUEST["to"])?$_REQUEST["to"]:"");
   $address1 	= 	getMailAddress($address1);
	if(!email_valid($address1) && !empty($address1)){
			echo "<font id='hata'>&Ouml;z&uuml;r dileriz, kullanıcının eposta adresi bilgisinde sorun var!</font>";
			$hata = true;
	}
		
   if(isset($_POST["konu"])){

			if ($_POST["ccode"] != $_SESSION["ccode"]) {
			  echo ("<font id='hata'> Kod boş veya hatalı girildi!</font>");
			  $hata = true;
			  $_SESSION["ccode"] = "";
			}else{
				   $_SESSION["ccode"] = "";
				   $subject=temizle($_POST["konu"]);
				   $address=temizle($_POST["address"]);
				   $address = getMailAddress($address);
				   $bodisi=temizle($_POST["icerik"]);
				   $gonderenMail = getMailAddress(getUserID2($_SESSION["usern"]));
				   if($gonderenMail=="")
				     $gonderenMail=ayarGetir("ayar4char");
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "From:".$gonderenMail. "\r\nReply-To:".$gonderenMail. "\r\n" .
							   'X-Mailer: PHP/' . phpversion();
					if(email_valid($address)){
						if (@mail("$address", "eOgr - $subject", "$bodisi",$headers)){
							 echo("<font id='tamam'>Epostanız G&ouml;nderildi!</font>");
							 $hata = true;
								}	
							 else {
							 echo("<font id='hata'>&Ouml;z&uuml;r dileriz, şu anda mesajınız g&ouml;nderilemiyor!</font>");
							 $hata = true;
							 }
					}
					else 
						echo "<font id='hata'>&Ouml;z&uuml;r dileriz, kullanıcının eposta adresi bilgisinde sorun var!</font>";
						$hata = true;
						}
	   }
	   
   $address = isset($_GET["to"])?$_GET["to"]:"";
   
   if(empty($address) &&  isset($_POST["address"]))  $address = $_POST["address"];
				   
   $hata=false;
   if(empty($address) || !is_numeric($address))   {
	    echo("<font id='hata'>Eposta bilgisi boş olamaz!</font>");
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
                    <textarea name="icerik" id="icerik" cols="50" rows="8" class="required"></textarea>
                  </div>
                  <input type="hidden" name="address" value='<?php echo $address?>'/>
                  <input type="hidden" name="ccode" value="<?php echo $ccode ?>" />
                  <input type="submit" name="button" id="button" value="<?php echo $metin[100]?>" />
                </fieldset>
              </form>
            </div>
            <script type="text/javascript">
  $(document).ready(function(){
    $("#form1").validate({
						rules: {
							konu: {
								required: true,
								minlength: 5,
								maxlength: 30
							},
							icerik: {
								required: true,
								minlength: 5,
								maxlength: 150
							}
						},
						messages: {
							konu: {
								required: "<?php echo $metin[665]?>"
							},
							icerik: {
								required: "<?php echo $metin[665]?>",
								minlength: "<?php echo $metin[609]?>"
							}
						}
					});
  });
  </script>
            <?php
	}

?>
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
    <script type="text/javascript" language="javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
if (document.getElementById("konu")!=null)  document.getElementById("konu").focus();
</script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>