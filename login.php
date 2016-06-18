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
	
    session_start (); 
	ob_start (); // Buffer output
	require("conf.php");		

	$time = getmicrotime();
	   $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
   
			if (isset($_POST["remUser"])){
			  if ($_POST["remUser"]=="1"){
			   setcookie("remUser",$_POST["userN"],time() + 60*60*24*30);
			  } 
			}
		   else {
			  $_POST["remUser"]="0";
			  setcookie("remUser","",time()-9999);
		   }
		   
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
	  @header("Location: error.php?error=4");
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
		}

  
	if(isset($_POST['form'])){
		switch ($_POST['form']){
			case 'login':
				$allowed = array();
				$allowed[] = 'form';
				$allowed[] = 'userN';
				$allowed[] = 'userP';
				$allowed[] = 'sumb';
				$allowed[] = 'remUser';
				$sent = array_keys($_POST);
				if ($allowed != $sent){
					die("<font id='hata'> ".$metin[400]." (1)</font><br/>".$metin[402]); //form data?
					exit;
				}
				break;
		} 
	} 	   
	
	currentFileCheck("login.php");	
	
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
	<title>eOgr -<?php echo $metin[60]?></title>
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
	<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
	<script type="text/javascript" src="lib/jquery.cookie.js"></script>
	<script type="text/javascript" src="lib/jquery.validate.min.js"></script>
	<script type="text/javascript">
$().ready(function() {
	
	/*$(function(){
    $('#userN, #userP').keydown(function(e){
        if (e.keyCode == 13) {
            $('#formLogin').submit();
            return false;
        	}
    	});
	});*/


	$("#formLogin").validate({
		rules: {
			userN: {
				required: true,
				minlength: 5,
				maxlength: 15
			},
			userP: {
				required: true,
				minlength: 5,
				maxlength: 15
			}
		},
		messages: {
			userN: {
				required: "<?php echo $metin[607]?>",
				minlength: "<?php echo $metin[608]?>"
			},
			userP: {
				required: "<?php echo $metin[610]?>",
				minlength: "<?php echo $metin[609]?>"
			}
		}
	});	
});
</script>
	<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
	<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
	<script type="text/javascript">
	Shadowbox.init({
		handleOversize: "drag",
		modal: true
	});
	</script>
	<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body>
    <?php require("menu.php");?>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <?php
	$adi	=substr(temizle((isset($_POST["userN"]))?$_POST["userN"]:""),0,15);
	$par	=sha1(substr(temizle((isset($_POST["userP"]))?$_POST["userP"]:""),0,15));
	//$adi	=substr(@temizle($_POST["userN"]),0,15);
	//$par	=sha1(substr(@temizle($_POST["userP"]),0,15));
	
/*   if ($adi=="" && isset($_SESSION["usern"])) {
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
	  }	*/
	
   if ($adi=="") {
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
	  }
	  else
	  {
	   if(checkRealUser($adi,$par)=="-2")	   
		   	trackUser($currentFile,"fail,Login",$adi);	//first time bad login
	   else {	
	   
			//eğer 5 dakika içinde zaten girmiş ise (flood gibi)			
			  $sonGirisDakikasi=sonLoginDakikasi($adi);			  
				if ($sonGirisDakikasi>=0 and $sonGirisDakikasi<5) { 
					sessionDestroy();
					header("Location: error.php?error=7");
					die ("<font id='hata'> ".$metin[404]." (1)</font><p>".$metin[402]."</p>");			
				}				   
			
		    setcookie("theme",kullaniciTema($adi),time()+60*60*24*30);	
	   		trackUser($currentFile,"success,Login",$adi);	//first time good login
			header("Location: index.php");
	     }
	  }
  
/*	if($adi=="" || $par=="") {
		header("Location: error.php?error=2");
		die("<font id='hata'> ".$metin[403]."</font><br/>".$metin[402]); //EMPTY?
	}    
*/	
	$pass = false;
	
    if($adi!="" && $par!="") {
		$tur=checkRealUser($adi,$par);
	
			//eğer pasif ise 
			if ($tur<=-1 || $tur>2) { 
			   sessionDestroy();
			   echo ("<font id='hata'> ".$metin[404]." </font><p>".$metin[402]."</p>");
			   $_SESSION["tur"] 	= "-1";
			  }
			  else 
			  {
				$_SESSION["tur"] 	= $tur;
				$_SESSION["usern"] 	= ($adi);
				$_SESSION["userp"] 	= ($par);
 			    $pass = true;
			  }	
		
			 switch($_SESSION["tur"]){
			  case '-1':$ktut=$metin[85];break;	  
			  case '0':$ktut=$metin[86];break;	  
			  case '1':$ktut=$metin[87];break;	  
			  case '2':$ktut=$metin[88];break;	  
			  default:$ktut=$metin[89];
			 } 
	}
if($pass){
?>
          <p> <?php echo $metin[7]?>, <?php echo temizle($_SESSION["userr"])." ".$ktut;?> </p>
          <div class="row">
            <?php
				 if($_SESSION["tur"]=='0') {
					  $siniflar = getOgrenciSiniflari();
					  if($siniflar!=""){
						  echo "<p>".$metin[210]." : ".$siniflar;
			   		  	  echo "</p>";
					  }
				  }			  
				 if($_SESSION["tur"]=='1' || $_SESSION["tur"]=='2') {
					  $pasifYorumlar = getpasifYorumlar();
					  if($pasifYorumlar>0){
						  echo "<p>".$metin[294]." : <a href=dataCommentList2.php>".$pasifYorumlar." <img src='img/uyari.gif' border='0' style=\"vertical-align: middle;\" alt=\"imp\" /></a>";
			   		  	  echo "</p>";
					  }
				  }			  

	 if (trim(getStats(11))!=""){
		 echo "<div class='col-lg-6 col-xs-12 bs-callout bs-callout-info bg-info'>";
		 echo "<strong>".$metin[213]."</strong><br/>".getStats(11)."</div>";
		 if (trim(getStats(12))!=""){
			 echo "<div class='col-lg-6 col-xs-12 bs-callout bs-callout-warning bg-warning'><strong>".$metin[239]."</strong><br/>".getStats(12)."</div>";
		 }		 
	 }else
	  echo "$metin[485]";			
		 
?>
          </div>
          <p class="clear"> <a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?> </span></span></a>
            <?php
					  $bekleyenArkadas = getFriendApprovals();
					   if(!empty($bekleyenArkadas)) {
								echo "<font id='tamam'>".$metin[592]." ";
								echo $bekleyenArkadas."</font>";
						   }else{
							 	echo "<font id='tamam'>$metin[593]</font>" ;
						   }	   
                      ?>
          </p>
          <?php
		  	}else{
          ?>
          <form id="formLogin" method="post" action="login.php">
            <label for="userN"> <?php echo $metin[0]?> : </label>
            <input type="hidden" name="form" value="login" />
            <div>
              <input name="userN" type="text" id="userN" size="18" maxlength="15" class="required"  style="width:150px" 
                     value="<?php echo ($remUser)?temizle($_COOKIE["remUser"]):""?>" />
            </div>
            <label for="userP"> <?php echo $metin[1]?> : </label>
            <div>
              <input name="userP" type="password" id="userP" size="18" maxlength="15" class="required"  style="width:150px" />
            </div>
            <br />
            <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[2]?>"  />
            &nbsp;
            <?php
	 if ($remUser){
    ?>
            <a href="index.php?forgetMe=1"><span><span><?php echo $metin[196]?></span></span></a>
            <input type="hidden" name="remUser" id="remUser" value="1" />
            <?php
	} else {
    ?>
            <p>
              <label>
                <input type="checkbox" name="remUser" id="remUser" value="1" <?php
	 if ($remUser){
    ?>checked="checked"<?php }?>/>
                <?php echo $metin[193]?> </label>
            </p>
            <?php
	}
    ?>
          </form>
          <script type="text/javascript">
  $(document).ready(function(){
    $("#formLogin").validate();
  });
</script>
          <?php 
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
    </div>
    <script type="text/javascript">
				<!--
				if (document.getElementById("userP")!=null) 
				   document.getElementById("userP").setAttribute( "autocomplete","off" );
				//-->
				</script> 
    <script src="lib/bs_js/bootstrap.js"></script> 
    <script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>