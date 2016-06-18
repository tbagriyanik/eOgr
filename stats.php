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
	
	ob_start (); // Buffer output
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
    require("conf.php");	
	$time = getmicrotime();  
	checkLoginLang(true,true,"stats.php");	
	$seciliTema=temaBilgisi();	

include('lib/graphs.inc.php');
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
<title>eOgr -<?php echo $metin[197]?></title>
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
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="col-lg-12">
    <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[197]?> </span> </h2>
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
	 if($_SESSION["tur"]=='1' || $_SESSION["tur"]=='2') {
					  $pasifYorumlar = getpasifYorumlar();
		  if($pasifYorumlar>0){
						  echo $metin[294]." : <a href=dataCommentList2.php>".$pasifYorumlar." <img src='img/uyari.gif' border='0' style=\"vertical-align: middle;\" alt=\"imp\" /></a>";
			   		  	  echo "<br/>";
			  }
	  }			  

	 if (trim(getStats(11))!=""){
		 echo "<br/><div class='ikiKolon'>";
		 echo "<strong>".$metin[213]."</strong><br/>".getStats(11)."</div>";
		 if (trim(getStats(12))!=""){
			 echo "<div class='ikiKolon'><strong>".$metin[239]."</strong><br/>".getStats(12)."</div>";
		 }		 
	 }else
	  echo "$metin[485]";			
		 
?>
      <div class="cleared"></div>
      <?php
	 
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
	 	
		 if (trim(getStats(13))!=""){//son g&uuml;ncellenen
			 echo "<div class='ikiKolon'>";
			 echo "<strong>".$metin[84]."</strong>".getStats(13)."</div>";
		 }
		 if (trim(getStats(2))!=""){//en fazla &ccedil;alışılan
			 echo "<div class='ikiKolon'><strong>".$metin[200]."</strong><br/>".getStats(2)."</div><div class=clear></div>";
		 }		 
		 if (trim(getStats(14))!=""){//oylar
			 echo "<div class='ikiKolon'><strong>".$metin[276]."</strong><br/>".getStats(14)."</div>";
		 }		 
		 if (trim(getStats(15))!=""){//yorumlar
			 echo "<div class='ikiKolon'><strong>".$metin[277]."</strong><br/>".getStats(15)."</div>";
		 }		 
	 		 
					 ?>
      <div class="cleared"></div>
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
  </div>
</div>
<footer class="footer">
  <div class="Footer-inner">
    <?php  require "footer.php";?>
  </div>
</footer>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>