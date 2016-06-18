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
	ob_start (); // Buffer output
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(false,true,"passwordRemember.php");	   

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
		@header("Location: error.php?error=4");	
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;" alt="warning"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
		}
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
<title>eOgr -<?php echo $metin[65]?></title>
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
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="col-lg-12">
    <div class="Post-inner">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[65]?> </span> </h2>
      <div class="PostContent">
        <?php
function passwordMailTest(){				  
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "From:".ayarGetir("ayar4char"). "\r\nReply-To:".ayarGetir("ayar4char"). "\r\n" .
								   'X-Mailer: PHP/' . phpversion();
	if (@mail(ayarGetir("ayar4char"), "eOgr test", "just eOgr - delete me!",$headers))          
		return true;						   
	
	return false;  
}			
				   
if (isset($_POST['form']) || passwordMailTest()) {         

//no problem for sending EMAIL
 echo $metin[83];
 if(isset($_POST['form']) && $_SESSION["passRem"]!="yes"){          
	
			switch ($_POST['form'])
			{
				case 'parola':
					$allowed = array();
					$allowed[] = 'userName';
					$allowed[] = 'email';
					$allowed[] = 'form';
					$allowed[] = 'sumb';
					$sent = array_keys($_POST);
					if ($allowed != $sent)
					{
						die("<font id='hata'> ".$metin[400]." (1)</font><br/>".$metin[402]); //form data?
						exit;
					}
					break;
			}
		
				$_SESSION["passRem"]="yes";
				
				$sonuc= newParola($_POST['userName'], $_POST['email']);

				switch ($sonuc){
					case 'mailErr':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> $metin[413] $metin[415]</font><br/>".$metin[402]); 	
						break;
					case 'notValid':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> $metin[413] $metin[416]</font><br/>".$metin[402]); 	
						break;
					case 'noUser':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> $metin[413] $metin[417]</font><br/>".$metin[402]); 	
						break;
					case 'emptyData':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> $metin[413] $metin[418]</font><br/>".$metin[402]); 	
						break;
					case 'allOK':
					    trackUser($currentFile,"success,NewPwd",$_POST['userName']);
						echo ("<font id='tamam'> $metin[414] </font>".$metin[402]); 				
						break;
					case 'noChange':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> $metin[413] $metin[419]</font>".$metin[402]); 	
						break;
				}
		
	}else{		

if(!empty($_SESSION["passRem"]) and $_SESSION["passRem"]=="yes") die($metin[410]); //form data?
?>
        <script type="text/javascript" src="lib/jquery.validate.min.js"></script> 
        <script type="text/javascript">
					$().ready(function() {
						$("#form1").validate({
							rules: {
								userName: {
									required: true,
									minlength: 5,
									maxlength: 15
								},
								email: {
									minlength: 5,
									maxlength: 50,				
									required: true,
									email: true
								}
							},
							messages: {
								userName: {
									required: "<?php echo $metin[607]?>",
									minlength: "<?php echo $metin[608]?>"
								},
								email: "<?php echo $metin[613]?>"			
							}
						});	
					});
  </script>
        <div id="contact-wrapper">
          <form action="passwordRemember.php" method="post" id="form1">
            <fieldset>
              <legend><?php echo $metin[65]?></legend>
              <div style="width:600px;">
                <label for="userName"> <?php echo $metin[39]?> :</label>
                <input name="userName" type="text" id="userName" size="15" maxlength="15"  class="required" />
              </div>
              <div style="width:600px;">
                <label for="email"> <?php echo $metin[41]?> :</label>
                <input name="email" type="text" id="email" size="20" maxlength="50" class="required email" />
              </div>
              <div>
                <input name="form" type="hidden" value="parola" />
                <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[44]?>" />
              </div>
            </fieldset>
          </form>
        </div>
        <?php
	}
}	
else 
 	echo "<font id='hata'>$metin[682]</font>";	
?>
      </div>
      <div class="cleared"></div>
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