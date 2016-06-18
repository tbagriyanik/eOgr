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
if(!isset($_GET["error"]))
 $_GET["error"]="";
if(!in_array($_GET["error"],array("5","6"))) {
	require("conf.php");
	checkLoginLang(false,true,"error.php");
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
}else
	header("Location: install.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="tarik bagriyanik">
<link href="theme/Simple/bootstrap-theme.css" rel="stylesheet">
<link href="theme/docs.min.css" rel="stylesheet">
<link href="theme/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="theme/justified-nav.css" rel="stylesheet">
<script src="lib/bs_js/ie-emulation-modes-warning.js"></script>
<title>eOgr -<?php echo $metin[489]?></title>
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
<?php //require("menu.php");?>
<div class="container">
  <div class="col-lg-12">
    <?php 
	if(isset($_SESSION["usern"]))
		$adi = RemoveXSS($_SESSION["usern"]);
	if(isset($_POST["reopenPwd"]))
		if($_POST["reopenPwd"]==$_siteUnlockPwd and 
			!empty($_siteUnlockPwd) and 
			!empty($_POST["reopenPwd"])){
			if(siteAc()) {  
				trackUser($currentFile,"success,SiteUnlock",$adi);
				die("<br/>$metin[531]<p>$metin[402]</p>");
			}
		}
?>
    <TABLE align="center" width="75%" height="100%" >
      <tr>
        <td height="100%" valign="middle" ><table align="center">
            <tr>
              <td><h3 align="center">eOgr - <?php echo $metin[489]?></h3>
                <p style="margin-top:50px;"> <font color="#FF0000" > <?php echo $metin[402]?></font> </p>
                <?php
	 switch ($_GET["error"]){
		 case "1":
		  echo "<font id='hata'> $metin[400]</font>"; //not login
		  break;
		 case "2":
		  echo "<font id='hata'> $metin[403]</font>"; //empty username
		  break;
		 case "3":
		  echo "<font id='hata'> $metin[295]</font>"; //source error
		  break;
		 case "4":
		  echo "<font id='hata'> $metin[401]</font>"; //flood
		  break;		 
		 case "7":			//bad login
		  echo "<font id='hata'> ".$metin[404]."</font>";
		  break;		  
 		 case "8":			//file name error
		  echo "<font id='hata'>$metin[449]</font>";
		  break;	
 		 case "9":			//not allowed for students/teachers
		  echo "<font id='hata'>$metin[447]</font>";
		  break;	
 		 case "10":			//not allowed for students
		  echo "<font id='hata'>$metin[448]</font>";
		  break;	
 		 case "11":			//site is closed 
		  echo "<font id='hata'>$metin[527]</font>";
		  break;	
 		 case "12":			//not allowed for all
		  echo "<font id='hata'>$metin[548]</font>";
		  break;	
		 default:			//file not found
		  echo "<font id='hata'>$metin[468]</font>";		  	  
	}
?>
                <p style="font-size:10px;">
                  <?php
 echo "<strong>$metin[491] :</strong> ".RemoveXSS($_SERVER['REMOTE_ADDR'])."<br/>";  
// echo "<strong>$metin[492] :</strong> ".RemoveXSS($_SERVER['HTTP_REFERER'])."<br/>"; 
 echo "<strong>$metin[129] :</strong> ".date("d-m-Y H:i:s")."<br/>"; 
 
 if($_GET["error"]!=11 and !empty($_SESSION["usern"]) and !empty($_SESSION["userp"])){
?>
                </p>
                <h5> <?php echo $metin[490]?> </h5>
                <?php
	 }

 if($seceneklerimiz[15]=="1" and $_GET["error"]==11){
?>
                <p>
                
                <form action="error.php?error=11" method="post" name="reopen">
                  <label>Enter Password :
                    <input name="reopenPwd" type="password" size="30" maxlength="30" autofocus="autofocus"/>
                  </label>
                </form>
                </p>
                <?php
 }
?></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <script type="text/javascript" language="javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
</script></div>
</div>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>