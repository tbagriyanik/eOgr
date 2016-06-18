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
      $_SESSION ['ready'] = TRUE; 
	require("conf.php");	
	$time = getmicrotime();  
	checkLoginLang(true,true,"kursDetay.php");	
	check_source();
	$seciliTema=temaBilgisi();	
ob_start (); // Buffer output
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
<title>eOgr -<?php echo $metin[461]?></title>
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
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<script language="javascript" type="text/javascript" src="lib/jquery-print.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      // Hook up the print link.
				$( ".yazdir" )
					.attr( "href", "javascript:void(0)" )
					.click(
						function(){
							// Print the DIV.
							$( ".printMe" ).print(); 
							// Cancel click event.
							return( false );
						}); 
    })
</script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[461]?> </span> </h2>
      <div class="PostContent">
        <?php

	 switch($_SESSION["tur"]){
	  case '-1':$ktut=$metin[85];break;	  
	  case '0':$ktut=$metin[86];break;	  
	  case '1':$ktut=$metin[87];break;	  
	  case '2':$ktut=$metin[88];break;	  
	  default:$ktut=$metin[89];
	 } 

?>
        <p> <?php echo $metin[7]?>, <?php echo temizle($_SESSION["userr"])." ".$ktut;?> </p>
        <?php
				  
	$uID = temizle((isset($_GET["user"]))?$_GET["user"]:"");

//	if($uID != getUserID($_SESSION["usern"],$_SESSION["userp"]) and $_SESSION["tur"]==0) 
	  	//die($metin[448]);	 		  
		
	 if (trim(getStats(11))!="" && empty($uID)){
		 if (trim(getStats(12,getUserID($_SESSION["usern"],$_SESSION["userp"])))!=""){
			 echo "<div class='tekKolon'><h3>".$metin[239]."</h3>".getStats(12,getUserID($_SESSION["usern"],$_SESSION["userp"]))."</div>";
		 }		 
	 }else {
		if(empty($uID)) 
		 echo "$metin[485]";			
	 }		 
?>
      </div>     
    </div>
    <?php
		  if(($_SESSION["tur"]==1 or $_SESSION["tur"]==2)and($uID!="" and !empty(getStats(12,$uID)))){
          ?>
    <div class="col-lg-12">
      <div class="tekKolon">
        <h3><?php echo $metin[584]?> :</h3>
        <?php				    
				    echo "<strong><a href='profil.php?kim=".$uID."' rel='facebox'><span style='text-transform: capitalize;'>".mb_strtolower(kullGercekAdi($uID))."</span></a></strong><br/>";
					echo getStats(12,$uID);
                  ?>
      </div>
    </div>
  </div>
  <?php
		  } 
		  ?>
  <?php
					$dersID = temizle((isset($_GET["kurs"]))?$_GET["kurs"]:"");
					$uID = temizle((isset($_GET["user"]))?$_GET["user"]:"");
			if(! empty($dersID) ) {
          ?>
  <div class="col-lg-12">
    <div class='printMe' style="margin:3px;">
      <?php
	 				echo "<h4 align='center'>$metin[363] : ".
							getDersAdi($dersID)." (".getDerstekiKonuSay($dersID).")</h4>";
	 				echo "<h5>$metin[17] : ".getUserName($uID)."</h5>";
					echo getKursTablo($dersID,$uID);
					?>
    </div>
    <hr noshade="noshade">
    <p> <a href="#" class="yazdir external" style="background-color:white"><?php echo $metin[462]?></a> </p>
  </div>
  <?php
			}
			
		if(isset($_GET["kurs"])){			
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', " - ".dersAdiGetir($_GET["kurs"]), $pageContents);	   			
		}	   else{
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', "", $pageContents);	   
	   }			
          ?>
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