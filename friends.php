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
	ob_start();
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
       
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"friends.php");
		if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
		@header("Location: error.php?error=4");	
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;" alt="warning"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
		}	
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
<title>eOgr -<?php echo $metin[549]?></title>
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
//http://www.netlobo.com/url_query_string_javascript.html
function gup( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}
			
		$(document).ready(function($) { 
		if(gup("kisi")!="")	{
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "bold");
			$("#tab4D > span").css ("font-weight", "100");
			$("#tab1").hide("slow");	
			$("#tab2").hide("slow");	
			$("#tab3").show("slow");	
			$("#tab4").hide("slow");	
		}
		else if(parseInt($.cookie('seciliTab'))==1){	
			$("#tab1D > span").css ("font-weight", "bold");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "100");
			$("#tab1").show("slow");	
			$("#tab2").hide("slow");	
			$("#tab3").hide("slow");	
			$("#tab4").hide("slow");	
		}
		else if(parseInt($.cookie('seciliTab'))==2)	{
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "bold");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "100");
			$("#tab1").hide("slow");	
			$("#tab2").show("slow");	
			$("#tab3").hide("slow");	
			$("#tab4").hide("slow");	
		}
		else if(parseInt($.cookie('seciliTab'))==3)	{
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "bold");
			$("#tab4D > span").css ("font-weight", "100");
			$("#tab1").hide("slow");	
			$("#tab2").hide("slow");	
			$("#tab3").show("slow");	
			$("#tab4").hide("slow");	
		}
		else if(parseInt($.cookie('seciliTab'))==4)	{
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "bold");
			$("#tab1").hide("slow");	
			$("#tab2").hide("slow");	
			$("#tab3").hide("slow");	
			$("#tab4").show("slow");	
		}
		else {
			$("#tab1D > span").css ("font-weight", "bold");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "100");
//			$("#tab1").hide("slow");	
			$("#tab2").hide("slow");	
			$("#tab3").hide("slow");	
			$("#tab4").hide("slow");	
		}

                var COOKIE_NAME = 'seciliTab';
                var options = { path: '/', expires: 10 };

                $('#tab1D').click(function() {
					$("#tab1").show("slow");
					$("#tab2").hide("slow");
					$("#tab3").hide("slow");
					$("#tab4").hide("slow");
			$("#tab1D > span").css ("font-weight", "bold");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "100");
					$.cookie(COOKIE_NAME, '1', options);					
                    return false;
                });

                $('#tab2D').click(function() {
					$("#tab1").hide("slow");
					$("#tab2").show("slow");
					$("#tab3").hide("slow");
					$("#tab4").hide("slow");
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "bold");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "100");
					$.cookie(COOKIE_NAME, '2', options);
                    return false;
                });

                $('#tab3D').click(function() {
					$("#tab1").hide("slow");
					$("#tab2").hide("slow");
					$("#tab3").show("slow");
					$("#tab4").hide("slow");
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "bold");
			$("#tab4D > span").css ("font-weight", "100");
					$.cookie(COOKIE_NAME, '3', options);
                    return false;
                });
				

                $('#tab4D').click(function() {
					$("#tab1").hide("slow");
					$("#tab2").hide("slow");
					$("#tab3").hide("slow");
					$("#tab4").show("slow");
			$("#tab1D > span").css ("font-weight", "100");
			$("#tab2D > span").css ("font-weight", "100");
			$("#tab3D > span").css ("font-weight", "100");
			$("#tab4D > span").css ("font-weight", "bold");
					$.cookie(COOKIE_NAME, '4', options);
                    return false;
                });
				
            });


   jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script type="text/javascript" src="lib/dataFill.js"></script>
<style type="text/css">
#tabs {
	text-align: right;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #999;
	top: 10px;
	padding: 5px;
}
.tabContent {
	padding: 10px;
	background-color: #FFF;
	color: #000;
}
</style>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="col-lg-12">
    <div class="Post-inner">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[549]?> </span> </h2>
      <div class="PostContent">
        <?php
	if (in_array($tur, array("1","2","0")))	{
	 //

$currentPage = $_SERVER["PHP_SELF"];
//if (!check_source()) die ("<font id='hata'>$metin[295]</font>");
		
//-----------------------here we go		
	 switch($_SESSION["tur"]){
	  case '-1':$ktut=$metin[85];break;	  
	  case '0':$ktut=$metin[86];break;	  
	  case '1':$ktut=$metin[87];break;	  
	  case '2':$ktut=$metin[88];break;	  
	  default:$ktut=$metin[89];
	 } 
$geceliKullID = getUserID2($adi);	
if(isset($_GET["kisi"]))				 
	if(!empty($_GET["kisi"])){
		$_SESSION["seciliArkadas"] = RemoveXSS($_GET["kisi"]);
	}
?>
        <p> <?php echo $metin[7]?>, <?php echo temizle($_SESSION["userr"])."&nbsp;<a href='profil.php?kim=".$geceliKullID."&amp;set=1' rel=\"facebox\">$metin[311]</a>".$ktut;?> </p>
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
					 		 
	 //index.php'den 
	 $uyeListesi=getUsersOnline();
		 if(!empty($uyeListesi)){
			 echo "<p>"."$metin[446]<strong>";
			 foreach($uyeListesi as $eleman){
				 echo "<a href='profil.php?kim=".getUserID2($eleman)."' rel='facebox'>".$eleman."</a> ";
				 }
			 echo "</strong></p>";	 
		 }
		 
if(isset($_GET["ekle"]))				 
	if(!empty($_GET["ekle"])){
		if(arkadasTeklifEt(RemoveXSS($_GET["ekle"])))
			echo "<font id='tamam'>$metin[625]</font>";
		 else
			echo "<font id='hata'>$metin[626]</font>";
	}
if(isset($_GET["reddet"]))				 
	if(!empty($_GET["reddet"])){
		if(arkadasReddet(RemoveXSS($_GET["reddet"])))
			echo "<font id='tamam'>$metin[603]</font>";
		 else
			echo "<font id='hata'>$metin[626]</font>";
	}
	//login sayfasından				 
	  $bekleyenArkadas = getFriendApprovals();
	   if(!empty($bekleyenArkadas)) {
				echo "<font id='uyari'>".$metin[592]." ";
				echo $bekleyenArkadas."</font>";
		   }else{
				echo "<font id='tamam'>$metin[593]</font>" ;
		   }	   
?>
        <div class="aramaDiv2">
          <p> <?php echo $metin[589]?> :
            <input name="searchterm2" type="text" id="searchterm2" size="30" maxlength="50" title="<?php echo $metin[590]?>"/>
          </p>
        </div>
        <script type="text/javascript">
                        var options = {
                            script:"lib/as/test2.php?",
                            varname:"input",
                            json:true,
                            shownoresults:false,
                            maxresults:3,
                            callback: function (obj) {								
								location.href = "friends.php?kisi="+obj.id;
							}
                        };
                        var as_json = new bsn.AutoSuggest('searchterm2', options);                                                
</script>
        <div id="tabs"> <a href="#" id="tab1D"><span><?php echo $metin[583]?></span></a> | <a href="#" id="tab2D"><span><?php echo $metin[582]?></span></a> | <a href="#" id="tab3D"><span><?php echo $metin[580]?></span></a> | <a href="#" id="tab4D"><span><?php echo $metin[581]?></span></a></div>
        <div id="tab1" class="tabContent">
          <?php
					//ARKADASLARIM
		
		$arkadaslarim = arkadasListesi();			
		$arkadaslarDogum = arkadasDogumListesi();
		$taniyorOlabilir = arkadasTaniyor();
					
	if($arkadaslarim!=""){				
		echo "<p><img src=\"img/users.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"users\"/> <strong>$metin[549] :</strong> $arkadaslarim</p>";
		if($arkadaslarDogum!="")
		echo "<p> 
		<img src=\"img/birthday.gif\" border=\"0\" style=\"vertical-align:middle\" alt=\"$metin[618]\" title=\"$metin[618]\"/>
		<strong>$metin[618] : </strong>$arkadaslarDogum		
		</p>";
		if($taniyorOlabilir!="")
		echo "<p> 
		<img src=\"img/friendsFriend.png\" border=\"0\" style=\"vertical-align:middle\" alt=\"$metin[631]\" title=\"$metin[631]\"/>
		<strong>$metin[631] : </strong>$taniyorOlabilir		
		</p>";
	}else{
		echo "<font id='uyari'>$metin[588]</font>";
	}
                  ?>
        </div>
        <div id="tab2" class="tabContent">
          <?php
					//BEN
	echo "<h3>$metin[585] : </h3>";			  
	$bilg_1 = sonBilgileriGetir("sohbet",$geceliKullID);
	if(!empty($bilg_1))	echo $metin[474]."<p class='ozetBilgi'>".$bilg_1."</p>";
	$bilg_2 = sonBilgileriGetir("yorum",$geceliKullID);
	if(!empty($bilg_2))	echo $metin[475]."<p class='ozetBilgi'>".$bilg_2."</p>";
	$bilg_3 = sonBilgileriGetir("oy",$geceliKullID);
	if(!empty($bilg_3))	echo $metin[476]."<p class='ozetBilgi'>".$bilg_3."</p>";
	$bilg_4 = sonBilgileriGetir("ders",$geceliKullID);
	if(!empty($bilg_4))	echo $metin[477]."<p class='ozetBilgi'>".$bilg_4."</p>";
	$bilg_6 = sonBilgileriGetir("dosya",$geceliKullID);
	if(!empty($bilg_6))	echo $metin[478]."<p class='ozetBilgi'>".$bilg_6."</p>";				  
	$bilg_7 = sonBilgileriGetir("soru",$geceliKullID);
	if(!empty($bilg_7))	echo $metin[644]."<p class='ozetBilgi'>".$bilg_7."</p>";				  
	if(empty($bilg_1) and empty($bilg_2) and empty($bilg_3) and empty($bilg_4) and empty($bilg_6) and empty($bilg_7))
	  echo "<font id='uyari'>$metin[586]</font>";			  
                  ?>
        </div>
        <div id="tab3" class="tabContent">
          <?php
					//ARKADAS
if(isset($_SESSION["seciliArkadas"]))
	$seciliKisi = RemoveXSS($_SESSION["seciliArkadas"]);
	else
	$seciliKisi = "";
	
if($seciliKisi<>"" and getUserName($seciliKisi)!="-") {
	echo "<p>$metin[584] : <strong><a href='profil.php?kim=".$seciliKisi."' rel='facebox'>".getUserName($seciliKisi)."</a></strong></p>";				  
	$bil_1 = sonBilgileriGetir("sohbet",$seciliKisi);
	if(!empty($bil_1))	echo $metin[474]."<p class='ozetBilgi'>".$bil_1."</p>";
	$bil_2 = sonBilgileriGetir("yorum",$seciliKisi);
	if(!empty($bil_2))	echo $metin[475]."<p class='ozetBilgi'>".$bil_2."</p>";
	$bil_3 = sonBilgileriGetir("oy",$seciliKisi);
	if(!empty($bil_3))	echo $metin[476]."<p class='ozetBilgi'>".$bil_3."</p>";
	$bil_4 = sonBilgileriGetir("ders",$seciliKisi);
	if(!empty($bil_4))	echo $metin[477]."<p class='ozetBilgi'>".$bil_4."</p>";
	$bil_6 = sonBilgileriGetir("dosya",$seciliKisi);
	if(!empty($bil_6))	echo $metin[478]."<p class='ozetBilgi'>".$bil_6."</p>";	
	$bil_7 = sonBilgileriGetir("soru",$seciliKisi);
	if(!empty($bil_7))	echo $metin[644]."<p class='ozetBilgi'>".$bil_7."</p>";	
	if(empty($bil_1) and empty($bil_2) and empty($bil_3) and empty($bil_4) and empty($bil_6) and empty($bil_7))
	  echo "<font id='uyari'>$metin[586]</font>";	
	if ($seciliKisi!=$geceliKullID and 
	    !arkadasTeklifVarMi($geceliKullID,$seciliKisi) and
		!arkadasMi($geceliKullID,$seciliKisi)
		)   			  
		echo "<p><a href='friends.php?ekle=".$seciliKisi."'><img src=\"img/user_add.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[591]\"/> $metin[591]</a></p>";
	if (arkadasTeklifVarMi($geceliKullID,$seciliKisi) or arkadasMi($geceliKullID,$seciliKisi))
		echo "<p>$metin[619] : ".getArkadaslikDavetTarihi($geceliKullID,$seciliKisi)."</p>";	
	if (arkadasMi($geceliKullID,$seciliKisi)) {
		echo "<p>$metin[620] : ".getArkadaslikKabulTarihi($geceliKullID,$seciliKisi)."</p>";	
		echo "<p><a href='friends.php?reddet=$seciliKisi'><img src=\"img/pasif_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"$metin[624]\"/> $metin[624]</a></p>";	
		echo "<p><strong>$metin[617] :</strong> <br/>";
?>
          <script language="javascript" type="text/javascript">
/*
getHTTPObject:
Ajax nesnesinin hazırlanması
*/
function getHTTPObject(){
  var xmlhttp = null;
  if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
   	    if (xmlhttp.overrideMimeType) {
            xmlhttp.overrideMimeType('text/xml; charset=UTF-8');
         }
  } else if(window.ActiveXObject) {
   try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
   } catch (e) {
    try {
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
	 alert("Your browser does not support AJAX.");
     xmlhttp = null;
    }
   }
  }
  return xmlhttp;		 
} 
/*
duvarKaydet:
arkadaş ile ortak olan duvara yaz
*/
function duvarKaydet(icerik, gonderen, alan){    
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("POST", "addWall.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObject.send('duvar='+encodeURIComponent(icerik) + '&gonderen=' + encodeURIComponent(gonderen) + '&alan=' + encodeURIComponent(alan));		
    }
}
</script>
          <textarea id="duvarYazisi" cols="45" rows="4" style="background-color:#FFF;border:thin solid #ccc;"><?php echo arkadasDuvarYazisi($geceliKullID,$seciliKisi)?></textarea>
          &nbsp;
          <input type="image" alt="<?php echo $metin[121]?>" title="<?php echo $metin[121]?>" src="img/plus.png" onclick="fadeUp(document.getElementById('duvarYazisi'),255,255,0,150,0,0);
    duvarKaydet(document.getElementById('duvarYazisi').value.substr(0,139),<?php echo $geceliKullID ?>,<?php echo $seciliKisi ?>);">
          <?php		
		echo "</p>";
	}
}else
	echo "<font id='uyari'>$metin[587]</font>";
                  ?>
        </div>
        <div id="tab4" class="tabContent">
          <?php
					//HERKES 
	if(in_array($tur, array("0","1","2"))){				
		$bilgi1 = sonBilgileriGetir("sohbet","");
		if(!empty($bilgi1))	echo $metin[474]."<p class='ozetBilgi'>".$bilgi1."</p>";
		$bilgi2 = sonBilgileriGetir("yorum","");
		if(!empty($bilgi2))	echo $metin[475]."<p class='ozetBilgi'>".$bilgi2."</p>";
		$bilgi3 = sonBilgileriGetir("oy","");
		if(!empty($bilgi3))	echo $metin[476]."<p class='ozetBilgi'>".$bilgi3."</p>";
		$bilgi4 = sonBilgileriGetir("ders","");
		if(!empty($bilgi4))	echo $metin[477]."<p class='ozetBilgi'>".$bilgi4."</p>";
		$bilgi5 = sonBilgileriGetir("uye","");
		if(!empty($bilgi5))	echo $metin[473]."<p class='ozetBilgi'>".$bilgi5."</p>";
		$bilgi6 = sonBilgileriGetir("dosya","");
		if(!empty($bilgi6))	echo $metin[478]."<p class='ozetBilgi'>".$bilgi6."</p>";				  
		$bilgi7 = sonBilgileriGetir("soru","");
		if(!empty($bilgi7))	echo $metin[644]."<p class='ozetBilgi'>".$bilgi7."</p>";				  
	}else{
		echo "<font id='hata'>$metin[400]</font>";
	}
                  ?>
        </div>
        <?php	

//------------------------end of all
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
	
?>
      </div>
      <div class="cleared"></div>
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
 @mysqli_free_result($eoUsers);
?>