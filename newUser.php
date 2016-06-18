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
  checkLoginLang(false,true,"newUser.php");	   
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
<title>eOgr -<?php echo $metin[64]?></title>
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
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript">  
/*
test:
kullanıcı adı testi
*/
function test(){  
    val = document.getElementById("userName").value;  
    validate(val, {'target':'msg','preloader':'pr'});  
}  
/*
test2:
kullanıcı mail adresi testi
*/
function test2(){  
    val = document.getElementById("email").value;  
    validate2(val, {'target':'msg2','preloader':'pr2'});  
}  
</script>
<style type="text/css">
/*register texboxes*/
dl {
	position: relative;
	width: 400px;
}
dt {
	clear: both;
	float: left;
	width: 160px;
	padding: 4px 0 2px 0;
	text-align: left;
}
dd {
	float: left;
	width: 225px;
	margin: 0 0 8px 0;
	padding-left: 6px;
}
.hint {
	display: none;
	position: absolute;
	right: -260px;
	width: 300px;
	margin-top: -4px;
	border: 1px solid #c93;
	padding: 10px 12px;
	background: #ffc url(img/pointer.gif) no-repeat -10px 5px;
	color: #000;
	text-align: justify;
	font-size: 16px;
}
.hint .hint-pointer {
	position: absolute;
	left: -10px;
	top: 0px;
	width: 10px;
	height: 19px;
	background: url(img/pointer.gif) left top no-repeat;
}
</style>
<script type="text/javascript" language="javascript">
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

function prepareInputsForHints() {
	var inputs = document.getElementsByTagName("input");
	for (var i=0; i<inputs.length; i++){
		// test to see if the hint span exists first
		if (inputs[i].parentNode.getElementsByTagName("span")[0]) {
			// the span exists!  on focus, show the hint
			inputs[i].onfocus = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
			}
			// when the cursor moves away from the field, hide the hint
			inputs[i].onblur = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "none";
			}
		}
	}
	// repeat the same tests as above for selects
	var selects = document.getElementsByTagName("select");
	for (var k=0; k<selects.length; k++){
		if (selects[k].parentNode.getElementsByTagName("span")[0]) {
			selects[k].onfocus = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
			}
			selects[k].onblur = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "none";
			}
		}
	}
}
addLoadEvent(prepareInputsForHints);
</script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="col-lg-12"><div class="PostContent">
  
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[64]?> </span> </h2>
                <div class="PostContent">
                  <?php

if ((!empty($_POST["ccode2"]) and !empty($_SESSION["ccode2"])) and $_POST["ccode2"] != $_SESSION["ccode2"]) {
	$_SESSION["ccode2"]="";
	echo ("<font id='hata'> ".$metin[406]."</font>");
}elseif((!empty($_POST["userPassword2"]) and !empty($_POST["userPassword1"])) and $_POST["userPassword2"]!=$_POST["userPassword1"] || $_POST["userName"]==$_POST["userPassword1"] || $_POST["userPassword1"]=="12345678" ) {
	$_SESSION["ccode2"]="";
	echo($metin[407]);
}elseif(!empty($_SESSION["newUser"]) and $_SESSION["newUser"]=="yes") {
	$_SESSION["ccode2"]="";
	echo($metin[410]); //form data?	
}else{
    if(isset($_POST['form']) && isset($_POST['onay']) && isset($_SESSION["newUser"]) && $_POST["onay"]=="OK" && $_SESSION["newUser"]!="yes"){          
	
			switch ($_POST['form'])
			{
				case 'uyelik':
					$allowed = array();
					$allowed[] = 'form';
					$allowed[] = 'realN';
					$allowed[] = 'userName';
					$allowed[] = 'userPassword1';
					$allowed[] = 'userPassword2';
					$allowed[] = 'email';
					$allowed[] = 'birth';
					$allowed[] = 'onay';
					$allowed[] = 'ccode2';
					$allowed[] = 'sumb';
					$sent = array_keys($_POST);
					if ($allowed != $sent)
					{
						$_SESSION["ccode2"]="";	
						die("<font id='hata'> ".$metin[400]." (1)</font><br/>".$metin[402]); //form data?
						exit;
					}
					break;
			}
			
			{			
			
				$_SESSION["newUser"]="yes";
				$_SESSION["ccode2"]="";
				
				if (addnewUser($_POST['realN'], $_POST['userName'], $_POST['userPassword1'], $_POST['email'], $_POST['birth'])) {
					trackUser($currentFile,"success,NewUser",$_POST['userName']);
					echo "<br/>$metin[7], ".temizle($_POST["realN"])."<br/><br/>";	
					echo ($metin[408]); 
					$_SESSION["tur"] 	= "0";//varsayılan öğrencidir...
					$_SESSION["usern"] 	= $_POST['userName'];
					$_SESSION["userp"] 	= sha1($_POST['userPassword1']);
					trackUser($currentFile,"success,Login",$_SESSION["usern"]);
					
						if(ayarGetir("ayar4char")!="") {
						if (newUserMail($_POST['userName'], $_POST['email'])=="allOK")
							 {
								 echo "<br/><br/>Yeni &Uuml;yelik Epostası Başarılıdır.";
							 }
							 else
							 {
								 echo "<br/><br/>Yeni &Uuml;yelik Epostası Başarılı olamadı!";
							 }
						}
				   }
				else {
					trackUser($currentFile,"fail,NewUser",$_POST['userName']);
					echo ($metin[409]); 				
				}
			}
	}else{		

require_once("lib/phplivex.php");
/*
validate:
yeni kullanıcı adı testi
*/
function validate($username){ 
  global $metin;
  if(strlen($username)>=5) {
	//usleep(250000);
    if(checkUserName($username)) 
	    $msg = $metin[411];  
  }
    return $msg;  
}  
/*
validate2:
yeni kullanıcı mail adresi testi
*/
function validate2($email){ 
  global $metin;
  if(strlen($email)>=5){     
	//usleep(250000);
    if(checkEmail($email)) $msg = $metin[412];  	
  }
    return $msg;  
}  
$ajax = new PHPLiveX(array("validate","validate2")); 
$ajax->Run(); 


?>
                  <?php echo $metin[165]?> </div>
                <div class="cleared"></div>
             
                  <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
                  <script type="text/javascript">
				  $().ready(function() {
					$("#form1").validate({
						rules: {
							realN: {
								required: true,
								minlength: 5,
								maxlength: 30
							},
							userName: {
								required: true,
								minlength: 5,
								maxlength: 15
							},
							userPassword1: {
								required: true,
								minlength: 5,
								maxlength: 15
							},
							userPassword2: {
								required: true,
								minlength: 5,
								maxlength: 15,				
								equalTo: "#userPassword1"
							},
							birth: {
								required: true,
								maxlength: 10,	
								dateDE: true			
							},
							email: {
								minlength: 5,
								maxlength: 50,				
								required: true,
								email: true
							},
							onay: "required"
						},
						messages: {
							realN: "<?php echo $metin[606]?>",
							userName: {
								required: "<?php echo $metin[607]?>",
								minlength: "<?php echo $metin[608]?>"
							},
							userPassword1: {
								required: "<?php echo $metin[610]?>",
								minlength: "<?php echo $metin[609]?>"
							},
							userPassword2: {
								required: "<?php echo $metin[610]?>",
								minlength: "<?php echo $metin[609]?>",
								equalTo: "<?php echo $metin[611]?>"
							},
							birth: {
								required: "<?php echo $metin[612]?>",
								dateDE: "<?php echo $metin[614]?>"
							},
							email: "<?php echo $metin[613]?>",
							onay: "<?php echo $metin[615]?>"
						}
					});	
				});
                  </script>
                  <div id="contact-wrapper">
                    <?php
					$ccode2 = newPassw();
					$_SESSION["ccode2"]=$ccode2;
                  ?>
                    <form action="newUser.php" method="post" id="form1" >
                      <input name="form" type="hidden" value="uyelik" />
                      <fieldset>
                        <legend><?php echo $metin[78]?> </legend>
                        <dl>
                          <dt>
                            <label for="realN"> <?php echo $metin[38]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="realN" type="text" id="realN" size="35" maxlength="30" class="required"  style="width:150px" value="<?php echo (isset($_POST["realN"]))?temizle($_POST["realN"]):""?>"/>
                              <span class="hint"><?php echo $metin[280];?><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dt>
                            <label for="userName"> <?php echo $metin[39]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="userName" type="text" id="userName" size="35" maxlength="15" class="required"  style="width:150px" onkeyup="test();" value="<?php echo (isset($_POST["userName"]))?temizle($_POST["userName"]):""?>"/>
                              <span class="hint"><?php echo $metin[281];?><br />
                              <span id="msg"></span><span id="pr" style="visibility:hidden;"><img src="img/loadingRect2.gif" border="0"  style="vertical-align: middle;" alt="loading" /></span><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dt>
                            <label for="userPassword1"> <?php echo $metin[40]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="userPassword1" type="password" id="userPassword1" size="35"  style="width:150px" maxlength="15"  class="required password"  />
                              <span class="hint"><?php echo $metin[282];?><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dt>
                            <label for="userPassword2"> <?php echo $metin[152]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="userPassword2" id="userPassword2" type="password" value="" size="35" maxlength="15"   class="required" style="width:150px" />
                              <span class="hint"><?php echo $metin[283];?><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dt>
                            <label for="email"> <?php echo $metin[41]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="email" type="text" id="email" size="35" maxlength="50"  style="width:150px" class="required email"  onkeyup="test2();" value="<?php echo (isset($_POST["email"]))?temizle($_POST["email"]):""?>"/>
                              <span class="hint"><?php echo $metin[284];?><br />
                              <span id="msg2"></span><span id="pr2" style="visibility:hidden;"><img src="img/loadingRect2.gif" border="0" style="vertical-align: middle;"  alt="loading" /></span><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dt>
                            <label for="birth"> <?php echo $metin[42]?> :</label>
                          </dt>
                          <dd>
                            <div>
                              <input name="birth" type="text" id="birth" size="35" maxlength="30"  style="width:150px" class="required dateDE" value="<?php echo (isset($_POST["birth"]))?temizle($_POST["birth"]):"31.12.1990"?>"/>
                              <span class="hint"><?php echo $metin[285];?><span class="hint-pointer">&nbsp;</span></span> </div>
                          </dd>
                          <dd>
                            <div>
                              <label><?php echo $metin[43]?>
                                <input type="checkbox" name="onay" id="onay" value="OK"  class="required" />
                              </label>
                            </div>
                          </dd>
                          <dd>
                            <input type="hidden" name="ccode2" value="<?php echo $ccode2 ?>" />
                            <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[44]?>" />
                          </dd>
                        </dl>
                      </fieldset>
                    </form>
                  </div>
                  <?php
	}
}	
?>
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