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
	checkLoginLang(true,true,"stats.php");	
	$seciliTema=temaBilgisi();	

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
<title>eOgr -<?php echo $metin[197]?></title>
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[197]?> </span> </h2>
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
                  <?php
	 
	 	
		 if (trim(getStats(13))!=""){//son g&uuml;ncellenen
			 echo "<div class='ikiKolon'>";
			 echo "<strong>".$metin[84]."</strong>".getStats(13)."</div>";
		 }
		 if (trim(getStats(2))!=""){//en fazla &ccedil;alýþýlan
			 echo "<div class='ikiKolon'><strong>".$metin[200]."</strong><br/>".getStats(2)."</div><div class=clear></div>";
		 }		 
		 if (trim(getStats(14))!=""){//oylar
			 echo "<div class='ikiKolon'><strong>".$metin[276]."</strong><br/>".getStats(14)."</div>";
		 }		 
		 if (trim(getStats(15))!=""){//yorumlar
			 echo "<div class='ikiKolon'><strong>".$metin[277]."</strong><br/>".getStats(15)."</div>";
		 }		 
	 		 
		 echo "<div class='tekKolon'>";

					 if (trim(getStats(18))!="") echo "<strong><img src=\"img/i_low.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[457]." :</strong> ".getStats(18)."<br/>";
					 if (trim(getStats(0))!="") echo "<strong><img src=\"img/i_note.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[198]." :</strong> ".getStats(0)."<br/>";
					 if (trim(getStats(1))!="") echo "<strong><img src=\"img/i_medium.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[199]." :</strong> ".getStats(1)."<br/>";
					 if (trim(getStats(17))!="") echo "<strong><img src=\"img/i_warn.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[456]." :</strong> ".getStats(17)."<br/>";
					 if (trim(getStats(3))!="") echo "<strong><img src=\"img/i_high.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"info\"/> ".$metin[201]." :</strong> ".getStats(3)."<br/>";
			//		 if (trim(getStats(4))!="") echo "<strong>".$metin[202]." :</strong> ".getStats(4)."<br/>";
					 if (trim(getStats(6))!="") echo "<strong><img src=\"img/ogrt_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogretmen\"/> ".$metin[203]." :</strong> ".getStats(6)."<br/>";
					 if (trim(getStats(8))!="") echo "<strong>".$metin[204]." :</strong> ".Sec2Time2(round(getStats(8)))."<br/>";
					 if (trim(getStats(9))!="") echo "<strong>".$metin[205]." :</strong> ".Sec2Time2(round(getStats(9)))."<br/>";
					 if (trim(getStats(10))!="") echo "<strong>".$metin[206]." :</strong> %".round(getStats(10))."<br/>";
		echo "</div>";			 
					 ?>
                  <?php
if(getGrafikRecordCount()>5) {
	echo "<div class='ikiKolon'>";
	echo "<p style=\"color:#000;font-weight: bold;\">".$metin[342]."</p>";
	$sampleData = getGrafikValues(15);
	$labels = getGrafikLabels(15);

    $chart = new BAR_GRAPH("vBar");
	$chart->values = grafikGunNormallestirData($sampleData,$labels);
	$chart->labels = grafikGunNormallestirLabel($sampleData,$labels);
	$chart->showValues = 2;	
	$chart->labelSize =9;
	$chart->titleSize =9;
	$chart->absValuesSize  =9;
	$chart->absValuesBorder = "0px";
	echo $chart->create();   
	echo "</div>";
}
if(getGrafikRecordCount2()>5) {
	echo "<div class='ikiKolon'>";
	echo "<p style=\"color:#000;font-weight: bold;\">".$metin[343]."</p>";
	$sampleData2 = getGrafikValues2(15);
	$labels2 = getGrafikLabels2(15);

    $chart2 = new BAR_GRAPH("vBar");
	$chart2->values = grafikGunNormallestirData($sampleData2,$labels2);
	$chart2->labels = grafikGunNormallestirLabel($sampleData2,$labels2);
	$chart2->showValues = 2;	
	$chart2->labelSize =9;
	$chart2->titleSize =9;
	$chart2->absValuesSize  =9;
	$chart2->absValuesBorder = "0px";
	echo $chart2->create();   
	echo "</div>";
}
?>
                </div>
                <div class="cleared"></div>
              </div>
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
<?php  						
 require "feedback.php";
?>
</body>
</html>
