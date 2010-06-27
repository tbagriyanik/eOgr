<?php
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
	   $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
	
	$seciliTema=temaBilgisi();	

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
			  
	if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) {   
	   sessionDestroy();
		die("<font id='hata'>$metin[400] (2)</font>"); //session?
		exit;
	}
	
include_once "lib/simpleChart.php";
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
<title>eOgr -<?php echo $metin[60]?></title>
<script type="text/javascript" src="lib/script.js"></script>
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
<link href="theme/grafik.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[60]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
		}

    currentFileCheck("login.php");
	
		switch ($_POST['form'])
		{
			case 'login':
				$allowed = array();
				$allowed[] = 'form';
				$allowed[] = 'userN';
				$allowed[] = 'userP';
				$allowed[] = 'sumb';
				$allowed[] = 'remUser';
				$sent = array_keys($_POST);
				if ($allowed != $sent)
				{
					die("<font id='hata'> ".$metin[400]." (1)</font><br/>".$metin[402]); //form data?
					exit;
				}
				break;
		}     

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

	 if (trim(getStats(11))!=""){
		 echo "<br/><div class='ikiKolon'>";
		 echo "<strong>".$metin[213]."</strong><br/>".getStats(11)."</div>";
		 if (trim(getStats(12))!=""){
			 echo "<div class='ikiKolon'><strong>".$metin[239]."</strong><br/>".getStats(12)."</div>";
		 }		 
	 }			
		 
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <?php echo $metin[197]?> </span> </h2>
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

					 if (trim(getStats(0))!="") echo "<strong><img src=\"img/ogr_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[198]." :</strong> ".getStats(0)."<br/>";
			//		 if (trim(getStats(1))!="") echo "<strong>".$metin[199]." :</strong> ".getStats(1)."<br/>";
			//		 if (trim(getStats(3))!="") echo "<strong>".$metin[201]." :</strong> ".getStats(3)."<br/>";
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
	$sampleData = getGrafikValues(20);
	$labels = getGrafikLabels(20);

    $chart = new simpleChart($sampleData,$labels);
    $chart->verticalPoints = getGrafikMax(20)+1;
    $chart->setMaxValue(getGrafikMax(20)+1);
    $chart->setTitle("$metin[342]");	
	
	echo $chart->showChart();   
echo "</div>";
}
if(getGrafikRecordCount2()>5) {
 echo "<div class='ikiKolon'>";
	$sampleData2 = getGrafikValues2(20);
	$labels2 = getGrafikLabels2(20);

    $chart2 = new simpleChart($sampleData2,$labels2);
    $chart2->verticalPoints = getGrafikMax2(20) +1;
    $chart2->setMaxValue(getGrafikMax2(20)+1);
    $chart2->setTitle("$metin[343]");	
	
	echo $chart2->showChart();   
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
</body>
</html>
