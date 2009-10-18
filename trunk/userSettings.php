<?php
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }	 
  require("conf.php");	$time = getmicrotime();
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
<title>eOgr - <?php echo $metin[57]?></title>
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<script src="lib/jquery-1.3.2.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : 'loading.gif',
        close_image   : 'closelabel.gif'
      }) 
    })
</script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[57]?> </span> </h2>
                <div class="PostContent">
                  <?php

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> &#220;zg&#252;n&#252;z, iste&#287;inize &#351;u anda cevap veremiyoruz.'.
		  '<br/>L&#252;ften bir s&#252;re sonra <a href='.$_SERVER['PHP_SELF'].'>tekrar</a> deneyiniz!'); // die there flooding
		}
		
	currentFileCheck("userSettings.php");

	if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) {   
	   sessionDestroy();
		die("<font id='hata'> Oturum a&ccedil;ma hatası meydana geldi.</font>Geri d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); //session?
		exit;
	}

   $adi	=temizle(substr($_SESSION["usern"],0,15));
   $par	=temizle($_SESSION["userp"]);
  
	if($adi==""|| $par=="") die("<font id='hata'> Kullanıcı adı veya parola boş olamaz.</font>Geri d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>"); //EMPTY?
 
    $tur=checkRealUser($adi,$par);
	
	if ($tur<=-1 || $tur>2) { 
	   sessionDestroy();
	   die ("<font id='hata'> Kullanıcı adı veya parolanız hatalıdır. Hesabınız pasif halde olabilir.</font>Geri d&ouml;nmek i&ccedil;in <a href='index.php'>tıklatınız</a>");
	  }
	  else 
	  {
		$_SESSION["tur"] 	= $tur;
	    $_SESSION["usern"] 	= $adi;
    	$_SESSION["userp"] 	= $par;
	  }	

?>
                  <?php 
	if ($tur=="-1")	{
	   sessionDestroy();
	  die ("<p>&nbsp;</p><font id='hata'>Hesabınız pasif haldedir. İşlem yapma izniniz yoktur!</font>");
	 }

$editFormAction = $_SERVER['PHP_SELF'];


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  if (      
     GetSQLValueString($_POST['realName'], "text")=='NULL' || 
     GetSQLValueString($_POST['userEmail'], "text")=='NULL' || 
     GetSQLValueString($_POST['userBirthDate'], "text")=='NULL' 
      )
	 echo "<p>&nbsp;</p><font id='hata'>&Uuml;ye bilgilerinizde eksik alanlar vardır.</font>";
	else{   
        
		if ($_POST['prldeg']!="secili" 
				  && (GetSQLValueString($_POST['userPassword'], "text")=='NULL' 
				   || GetSQLValueString($_POST['userPassword2'], "text")=='NULL' 
				   || $_POST["userPassword"]!=$_POST["userPassword2"] ) )
          	 echo "<p>&nbsp;</p><font id='hata'>Yeni parolanızı yazmadınız veya tekrarı boş ge&ccedil;tiniz!</font>";
			 
		else {  

		  if ($_POST['prldeg']=="secili") 
			$updateSQL = sprintf("UPDATE eo_users SET realName=%s, userEmail=%s, userBirthDate='%s' WHERE id=%s",
							   GetSQLValueString($_POST['realName'], "text"),
							   GetSQLValueString($_POST['userEmail'], "text"),
							   tarihYap($_POST['userBirthDate']),
							   GetSQLValueString($_POST['id'], "int"));
			else  
			$updateSQL = sprintf("UPDATE eo_users SET userPassword=sha1(%s), realName=%s, userEmail=%s, userBirthDate='%s' WHERE id=%s",
							   GetSQLValueString($_POST['userPassword'], "text"),
							   GetSQLValueString($_POST['realName'], "text"),
							   GetSQLValueString($_POST['userEmail'], "text"),
							   tarihYap($_POST['userBirthDate']),
							   GetSQLValueString($_POST['id'], "int"));

		  mysql_select_db($database_baglanti, $yol);
		  
		  $Result1 = mysql_query($updateSQL, $yol);
		  
		  if($Result1){
			 echo "<font id='tamam'> &Uuml;ye bilgilerinizi g&uuml;ncelleme işleminiz tamamlandı!</font>";
  		     trackUser($currentFile,"success,UserInf",$adi);
			 if ($_POST['prldeg']!="secili") {
			   trackUser($currentFile,"success,PasswdC",$adi);
			   die("<font id='hata'> Parolanızı değiştirdiğiniz i&ccedil;in tekrar oturum a&ccedil;manız gerekmektedir!</font>");
			  }
		    }
			else {
  		    trackUser($currentFile,"fail,UserInf",$adi);
			echo "<font id='hata'> &Uuml;ye bilgilerinizde hata olduğunda g&uuml;ncelleme işleminiz tamamlanamadı! &Ouml;rneğin kullanılan bir eposta adresi girdiniz.</font>";			
			}
		}
	}			
}

$upID =  getUserID($adi, $par); 
mysql_select_db($database_baglanti, $yol);

if($upID=="") die("<font id='hata'>Kimlik hatası</font>");

$query_eoUsers ="select * from eo_users where id='$upID'";

$eoUsers = mysql_query($query_eoUsers, $yol); 

// if(mysql_query($query_limit_eoUsers, $yol))  die(mysql_error());
$row_eoUsers = mysql_fetch_row($eoUsers);

?>

                  <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
                  <div id="contact-wrapper">
                    <form action="<?php echo $editFormAction; ?>" method="post" id="form1">
                      <fieldset>
                        <?php echo $metin[17]?> : <?php echo GetSQLValueStringNo($row_eoUsers[1], "text"); ?> (<?php echo $row_eoUsers[0]; ?>)&nbsp;&nbsp;
                        <a href='profil.php?kim=<?php echo $upID;?>&amp;set=1' rel="facebox"><?php echo $metin[311]?></a> <br />

                        <?php echo $metin[22]?> :
                        <?php if (!(strcmp("", GetSQLValueStringNo($row_eoUsers[6], "text")))) {echo $metin[92];} ?>
                        <?php if (!(strcmp(-1, GetSQLValueStringNo($row_eoUsers[6], "text")))) {echo "<img src=\"img/pasif_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"pasif\"/> ".$metin[93];} ?>
                        <?php if (!(strcmp(0, GetSQLValueStringNo($row_eoUsers[6], "text")))) {echo "<img src=\"img/ogr_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[94];} ?>
                        <?php if (!(strcmp(1, GetSQLValueStringNo($row_eoUsers[6], "text")))) {echo "<img src=\"img/ogrt_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogretmen\"/> ".$metin[95];} ?>
                        <?php if (!(strcmp(2, GetSQLValueStringNo($row_eoUsers[6], "text")))) {echo "<img src=\"img/admin_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"admin\"/> ".$metin[96];} ?><br />
                        <?php echo $metin[23]?> : <?php echo tarihOku(GetSQLValueStringNo($row_eoUsers[7], "text")); ?><br /><br />

                        <label for="userPassword"> <?php echo $metin[18]?> :</label>
                        <div>
                          <input name="userPassword" id="userPassword" type="password" value="" size="32" maxlength="40" style="width:150px"  />
                          <font color="red"> <strong> <?php echo $metin[90]?> </strong></font> </div>
                        <label for="userPassword2">
						<?php echo $metin[152]?> :</label>
                        <div>
                          <input name="userPassword2" id="userPassword2" type="password" value="" size="32" maxlength="40" style="width:150px" />
                        </div>
                        
                        <label for="realName"> 
						<?php echo $metin[38]?> :</label>
                        <div>
                          <input name="realName" id="realName" type="text" value="<?php echo GetSQLValueStringNo($row_eoUsers[3], "text"); ?>" size="32" maxlength="50" style="width:150px"  class="required" />
                        </div>
                        <label for="userEmail"> <?php echo $metin[20]?> :</label>
                        <div>
                          <input name="userEmail" id="userEmail" type="text" size="32" maxlength="50"   class="required email" value="<?php echo GetSQLValueStringNo($row_eoUsers[4], "text"); ?>"  style="width:250px" />
                        </div>
                        <label for="userBirthDate"> <?php echo $metin[21]?> :</label>
                        <div>
                          <input name="userBirthDate" id="userBirthDate" type="text" value="<?php echo tarihOku(GetSQLValueStringNo($row_eoUsers[5], "text")); ?>" size="32" maxlength="50" class="required" style="width:150px" />
                        </div>                        
                        <label>
                          <input name="prldeg" type="checkbox" id="prldeg" checked="checked"  value="secili"/>
                          <?php echo $metin[24]?> </label><br />
                        <label>
                          <input type="submit" value="<?php echo $metin[25]?>" />
                        </label>
                        <br />
                        <?php echo $metin[91]?>

                        <input type="hidden" name="MM_update" value="form3" />
                        <input type="hidden" name="id" value="<?php echo $row_eoUsers[0]; ?>" />
                      </fieldset>
                    </form>
                  </div>
                  <script type="text/javascript">
  $(document).ready(function(){
    $("#form1").validate();
  });
  </script>
                </div>
                <div class="cleared"></div>
              </div>
              &nbsp;</div>
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