<?php
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  require("conf.php");
  	$time = getmicrotime();
	
     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
	
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
<title>eOgr - <?php echo $metin[65]?></title>
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script src="lib/jquery-1.3.2.min.js" type="text/javascript"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
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
          <h1 id="name-text" class="logo-name"><a href="index.php"><?php echo ayarGetir("okulGenelAdi")?></a></h1>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[65]?> </span> </h2>
                <div class="PostContent"> <?php echo $metin[83]?>
                  <?php

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;" alt="warning"/> &#220;zg&#252;n&#252;z, iste&#287;inize &#351;u anda cevap veremiyoruz.'.
		  '<br/>L&#252;ften bir s&#252;re sonra <a href='.$_SERVER['PHP_SELF'].'>tekrar</a> deneyiniz!'); // die there flooding
		}

	currentFileCheck("passwordRemember.php");

 if(isset($_POST['form']) && $_SESSION["passRem"]!="yes"){          
	
			switch ($_POST['form'])
			{
				case 'parola':
					$allowed = array();
					$allowed[] = 'userName';
					$allowed[] = 'email';
					$allowed[] = 'form';
					$allowed[] = 'myform_key';
					$allowed[] = 'sumb';
					$sent = array_keys($_POST);
					if ($allowed != $sent)
					{
						die("<font id='hata'> Formda bir hata meydana geldi!</font><br/>Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); //form data?
						exit;
					}
					break;
			}
		
				$_SESSION["passRem"]="yes";
				
				$sonuc= newParola($_POST['userName'], $_POST['email']);

				switch ($sonuc){
					case 'mailErr':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> Parola yenileme isteğiniz tamamlanamadı! Şu anda eposta g&ouml;nderemiyoruz.</font><br/>".
						  "Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 	
						break;
					case 'notValid':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> Parola yenileme isteğiniz tamamlanamadı! Eposta bilginiz doğrulanamadı.</font><br/>".
						  "Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 	
						break;
					case 'noUser':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> Parola yenileme isteğiniz tamamlanamadı! Kullanıcı adı veya eposta bilgileriniz bulunamadı.</font><br/>".
						  "Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 	
						break;
					case 'emptyData':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> Parola yenileme isteğiniz tamamlanamadı! Kullanıcı adı veya eposta boş bırakıldı.</font><br/>".
						  "Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 	
						break;
					case 'allOK':
					    trackUser($currentFile,"success,NewPwd",$_POST['userName']);
						echo ("<font id='tamam'> Parola yenileme isteğiniz tamamlandı!</font>Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 				
						break;
					case 'noChange':
					    trackUser($currentFile,"fail,$sonuc",$_POST['userName']);
						echo ("<font id='hata'> Parola yenileme isteğiniz tamamlanamadı! Kullanıcı adı veya eposta bilgileriniz g&uuml;ncellenemiyor. Gelecek olan epostayı g&ouml;zardı ediniz.</font>"."Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); 	
						break;
				}
		
	}else{		

if($_SESSION["passRem"]=="yes") die("<font id='hata'> Tekrar yeni parola başvurusu yapıldı.</font><br/>Ana sayfaya d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); //form data?
?>
                  <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
                  <div id="contact-wrapper">
                    <form action="passwordRemember.php" method="post" id="form1">
                      <fieldset>
                        <legend><?php echo $metin[65]?></legend>
                        <div>
                          <label for="userName"> <?php echo $metin[39]?> :</label>
                          <input name="userName" type="text" id="userName" size="15" maxlength="15"  class="required" />
                        </div>
                        <div>
                          <label for="email"> <?php echo $metin[41]?> :</label>
                          <input name="email" type="text" id="email" size="20" maxlength="50" class="required email" />
                        </div>
                        <div>
                          <input name="form" type="hidden" value="parola" />
                          <input type="hidden" name="myform_key" value="<?php echo md5("eyogurt"); ?>" />
                          <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[44]?>" />
                        </div>
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
</body>
</html>
