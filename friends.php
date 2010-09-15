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
	ob_start();
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
       
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"friends.php");	
	$seciliTema=temaBilgisi();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-9'/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo $metin[549]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[549]?> </span> </h2>
                <div class="PostContent"> 
                  <?php
	if (in_array($tur, array("1","2","0")))	{
	 //

$currentPage = $_SERVER["PHP_SELF"];
//if (!check_source()) die ("<font id='hata'>$metin[295]</font>");

		echo "<font id='tamam'>Bu özellik yapım aşamasındadır...</font>";
		
//-----------------------here we go		
	 //index.php'den 
	 $uyeListesi=getUsersOnline();
		 if(!empty($uyeListesi)){
			 echo "<br/>$metin[446]<strong>";
			 foreach($uyeListesi as $eleman){
				 echo "<a href='profil.php?kim=".getUserID2($eleman)."' rel='facebox'>".$eleman."</a> ";
				 }
			 echo "</strong>";	 
		 }
		 //iz sayısı
	if (getTrackCount(false)>0){
						 echo "<br/><strong>".$metin[194]." : </strong> ".getTrackCount(false)." ".$metin[195]." %".round(getTrackCount(true)*100/getTrackCount(false),1);
	 }
						 
	 switch($_SESSION["tur"]){
	  case '-1':$ktut=$metin[85];break;	  
	  case '0':$ktut=$metin[86];break;	  
	  case '1':$ktut=$metin[87];break;	  
	  case '2':$ktut=$metin[88];break;	  
	  default:$ktut=$metin[89];
	 } 
						 
?>	
                  <p> <?php echo $metin[7]?>, <?php echo temizle($_SESSION["userr"])."&nbsp;<a href='profil.php?kim=$upIDamp;set=1' rel=\"facebox\">$metin[311]</a> ".$ktut;?> </p>
                  <?php
				 if($_SESSION["tur"]=='0') {
					  $siniflar = getOgrenciSiniflari();
					  if($siniflar!=""){
						  echo $metin[210]." : ".$siniflar;
			   		  	  echo "<br/>";
					  }
				  }			  
				 if($_SESSION["tur"]=='1' || $_SESSION["tur"]=='2') {
					  $pasifYorumlar = getpasifYorumlar();
					  if($pasifYorumlar>0){
						  echo $metin[294]." : <a href=dataCommentList2.php>".$pasifYorumlar." <img src='img/uyari.gif' border='0' style=\"vertical-align: middle;\" alt=\"imp\" /></a>";
			   		  	  echo "<br/>";
					  }
				  }			  
					 		 
	// echo '<hr noshade="noshade" color="#333333">';

//------------------------end of all
	}
	else {
	  @header("Location:error.php?error=9");	
	  die($metin[447]);
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
<?php  						
 require "feedback.php"; 
?>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
