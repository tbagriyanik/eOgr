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
	checkLoginLang(true,true,"kursDetay.php");	
	check_source();
	$seciliTema=temaBilgisi();	
ob_start (); // Buffer output
include('lib/graphs.inc.php');
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
<title>eOgr - <?php echo $metin[461]?>
<!--TITLE-->
</title>
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery-print.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[461]?> </span> </h2>
                <div class="PostContent">
                  <?php
	
  $adi	=substr(temizle($_POST["userN"]),0,15);
  $par	=sha1(substr(temizle($_POST["userP"]),0,15));
  
   if ($adi=="") {
	   $adi	=temizle(substr($_SESSION["usern"],0,15));
	   $par	=temizle($_SESSION["userp"]);
	  }
	  else
	  {
	   if(checkRealUser($adi,$par)=="-2")	   
		   	trackUser($currentFile,"fail,Login",$adi);	//first time bad login
	   else {
	   		trackUser($currentFile,"success,Login",$adi);	//first time good login
	     }
	  }
  
	if($adi=="" || $par=="") die("<font id='hata'> ".$metin[403]."</font><br/>".$metin[402]); //EMPTY?
 
    $tur=checkRealUser($adi,$par);

	if ($tur<=-1 || $tur>2) { 
	   sessionDestroy();
	   die ("<font id='hata'> ".$metin[404]."</font><br/>".$metin[402]);
	  }
	  else 
	  {
		$_SESSION["tur"] 	= $tur;
	    $_SESSION["usern"] 	= ($adi);
    	$_SESSION["userp"] 	= ($par);
	  }	

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
				  
	$uID = temizle($_GET["user"]);
	if($uID!="") $_SESSION["kursUser"]=$uID;

//	if($uID != getUserID($_SESSION["usern"],$_SESSION["userp"]) and $_SESSION["tur"]==0) 
	  	//die($metin[448]);	 		  
		
	 if (trim(getStats(11))!=""){
		 echo "<br/><div class='ikiKolon'>";
		 echo "<strong>".$metin[213]."</strong><br/>".getStats(11)."</div>";
		 if (trim(getStats(12))!=""){
			 echo "<div class='ikiKolon'><strong>".$metin[239]."</strong><br/>".getStats(12)."</div>";
		 }		 
	 }else
	  echo "$metin[485]";			
		 
?>
                </div>
                <div class="cleared" ></div>
              </div>
            </div>
          </div>
          <?php
		  if(($_SESSION["tur"]==1 or $_SESSION["tur"]==2)and($uID!="" and $uID != getUserID($_SESSION["usern"],$_SESSION["userp"]))){
          ?>
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
                <div class="PostContent">
                  <div class="tekKolon"> Seçili Kullanýcý :
                    <?php				    
				    echo "<strong>".getUserName($uID)."</strong><br/>";
					echo getStats(12,$uID);
                  ?>
                  </div>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
          <?php
		  }
		  ?>
          <?php
					$dersID = temizle($_GET["kurs"]);
					$uID = temizle($_GET["user"]);
			if(! empty($dersID) ) {
          ?>
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
                <div class="PostContent">
                  <div class='printMe' style="margin:3px;">
                    <?php
	 				echo "<h4 align='center'>Ders Adý : ".
							getDersAdi($dersID)." (".getDerstekiKonuSay($dersID).")</h4>";
	 				echo "<h5>Çalýþanýn Adý : ".getUserName($uID)."</h5>";
					echo getKursTablo($dersID,$uID);
					?>
                  </div>
                  <hr noshade="noshade">
                  <p> <a href="#" class="yazdir external" style="background-color:white"><?php echo $metin[462]?></a> </p>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
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
<?php  						
 require "feedback.php";
?>
</body>
</html>
