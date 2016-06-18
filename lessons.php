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

    // header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    // header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    // header("Cache-Control: no-store, no-cache, must-revalidate");
    // header("Cache-Control: post-check=0, pre-check=0", false);
    // header("Pragma: no-cache");

      session_start (); 
      $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(false,true,"lessons.php");	   
  $seciliTema=temaBilgisi();	
  
ob_start (); // Buffer output
  if(isset($_GET["mode"]) and !empty($_GET["mode"])){
	   if(in_array($_GET["mode"],array("1","2","3"))){
		  $eMode = $_GET["mode"];
		  if($eMode!="1")
			  $_SESSION["mode"]= $eMode;   
	   }else
		  $eMode = "3";
  }else{
	  if(isset($_SESSION["mode"])){
	   if(in_array($_SESSION["mode"],array("2","3")))
		  	$eMode = $_SESSION["mode"];
		}
		else
		  	$eMode = "3"; //genel varsay�lan
  }  
  
  if(!isset($_GET["konu"]))				
    $_GET["konu"]="";

  if(isset($_SESSION["usern"]))
		$kullaniciSecen = explode("-",ayarGetir3(RemoveXSS($_SESSION["usern"])));
	else
	 	$kullaniciSecen = array("","","","","","","","","","","","","","","");
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
		<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
		<meta http-equiv="cache-control" content="no-cache"/>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="01 Jan 1970 00:00:00 GMT"/>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>eOgr -<?php echo $metin[55]?>
        <!--TITLE-->
        </title>
		<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="lib/script.js"></script>
		<script type="text/javascript" src="lib/flashMode.js"></script>
		<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
		<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="lib/hijax.js"></script>
		<link href="theme/ratings.css" rel="stylesheet" type="text/css" />
		<link href="theme/lessons.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/ico" href="img/favicon.ico"/>
		<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
		<script language="javascript" type="text/javascript" src="lib/dataFillLessons.js"></script>
		<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
		<link href="lib/ui-lightness/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="lib/bs_js/jquery-2.2.0.js"></script>
		<script language="JavaScript" type="text/javascript" src="lib/jquery-ui-1.10.2.custom.min.js"></script>
		<script language="javascript" type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
		<script language="javascript" type="text/javascript" src="lib/jquery-add_bookmark.js"></script>
		<script type="text/javascript" src="lib/jquery.easing.1.2.js"></script>
		<script type="text/javascript" src="lib/facebox/facebox.js"></script>
		<script src="lib/jquery.cookie.js" type="text/javascript"></script>
		<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				  $('a[rel*=facebox]').facebox({        
				  }) ;				  
				  
				//$(".msg_body").hide();
				$(".msg_head").click(function(){
					$(this).next(".msg_body").slideToggle(200);
				});
				//$(".msg_body2").hide();
				$(".msg_head2").click(function(){
					$(this).next(".msg_body2").slideToggle(200);
				});
				

			});

		</script>
		<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" language="javascript">
		var ns = (document.layers)? true:false;
		var ie = (document.all)? true:false;
		if (ns) document.captureEvents(Event.MOUSEDOWN || Event.CLICK);
		document.onclick = sourcecodeprotect;
		document.onmousedown = sourcecodeprotect;

		// ***********************************************************
		function sourcecodeprotect(e) {
		  if (ns&&(e.which==3)) return false;
		  else if (ie&&(window.event.button==2)) {
			//alert("Source code protected");
			}
		  else return true;
		  }

		//***********************************************************
		function cleanup() {
		  if (ns) document.releaseEvents(Event.MOUSEDOWN || Event.CLICK);
		}
				$(function() {
					$(this).bind("contextmenu", function(e) {
						e.preventDefault();
					});
				}); 
		</script>
		<link rel="stylesheet" href="lib/scrollTop/ap-scroll-top.css" type="text/css" media="all" />
		<script src="lib/scrollTop/ap-scroll-top.js"></script>
		<script type="text/javascript">
            // Setup plugin with default settings
            $(document).ready(function() {

                $.apScrollTop({
                    'onInit': function(evt) {
                        console.log('apScrollTop: init');
                    }
                });

                // Add event listeners
                $.apScrollTop().on('apstInit', function(evt) {
                    console.log('apScrollTop: init');
                });

                $.apScrollTop().on('apstToggle', function(evt, details) {
                    console.log('apScrollTop: toggle / is visible: ' + details.visible);
                });

                $.apScrollTop().on('apstCssClassesUpdated', function(evt) {
                    console.log('apScrollTop: cssClassesUpdated');
                });

                $.apScrollTop().on('apstPositionUpdated', function(evt) {
                    console.log('apScrollTop: positionUpdated');
                });

                $.apScrollTop().on('apstEnabled', function(evt) {
                    console.log('apScrollTop: enabled');
                });

                $.apScrollTop().on('apstDisabled', function(evt) {
                    console.log('apScrollTop: disabled');
                });

                $.apScrollTop().on('apstBeforeScrollTo', function(evt, details) {
                    console.log('apScrollTop: beforeScrollTo / position: ' + details.position + ', speed: ' + details.speed);

                    // You can return a single number here, which means that to this position
                    // browser window scolls to
                    /*
                    return 100;
                    */

                    // .. or you can return an object, containing position and speed:
                    /*
                    return {
                        position: 100,
                        speed: 100
                    };
                    */

                    // .. or do not return anything, so the default values are used to scroll
                });

                $.apScrollTop().on('apstScrolledTo', function(evt, details) {
                    console.log('apScrollTop: scrolledTo / position: ' + details.position);
                });

                $.apScrollTop().on('apstDestroy', function(evt, details) {
                    console.log('apScrollTop: destroy');
                });

            });


            // Add change events for options
            $('#option-enabled').on('change', function() {
                var enabled = $(this).is(':checked');
                $.apScrollTop('option', 'enabled', enabled);
            });

            $('#option-visibility-trigger').on('change', function() {
                var value = $(this).val();
                if (value == 'custom-function') {
                    $.apScrollTop('option', 'visibilityTrigger', function(currentYPos) {
                        var imagePosition = $('#image-for-custom-function').offset();
                        return (currentYPos > imagePosition.top);
                    });
                }
                else {
                    $.apScrollTop('option', 'visibilityTrigger', parseInt(value));
                }
            });

            $('#option-visibility-fade-speed').on('change', function() {
                var value = parseInt($(this).val());
                $.apScrollTop('option', 'visibilityFadeSpeed', value);
            });

            $('#option-scroll-speed').on('change', function() {
                var value = parseInt($(this).val());
                $.apScrollTop('option', 'scrollSpeed', value);
            });

            $('#option-position').on('change', function() {
                var value = $(this).val();
                $.apScrollTop('option', 'position', value);
            });
		</script>
		</head>
		<?php flush(); ?>
		<body onselectstart="//return false;" ondragstart="return false" oncontextmenu="return false" onunload="cleanup()" >
        <?php
				 require("menu.php");
			?>
        <div class="container">
          <?php
		if($eMode!="1"){
      ?>
          <div class="well well-sm">
            <div class="row">
              <div class="col-xs-12">
                <?php
	
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));

	 if(isset($_SESSION["usern"]))
		$kullaniciSecen = explode("-",ayarGetir3(RemoveXSS($_SESSION["usern"])));
			
                ?>
                <?php				
				echo " $metin[556] : ";
				?>
                <div class="btn-group"> <a href='?konu=<?php echo RemoveXSS($_GET["konu"])?>&amp;mode=2' class="btn btn-primary<?php  		
		if($eMode=="2") echo " active";		
		?>">
                  <?php 				
			echo $metin[552];
		?>
                  </a><a href='?konu=<?php echo RemoveXSS($_GET["konu"])?>&amp;mode=3' class="btn btn-primary <?php  		
		if($eMode=="3") echo " active";		
		?>">
                  <?php		
			echo $metin[557];
		?>
                  </a><a href='userSettings.php#ozel' class="btn btn-primary"><?php echo $metin[554]?></a>
                  <?php
				  
		  //if($seceneklerimiz[13]=="1" and $kullaniciSecen[13]=="1" ) require("ping.php");
		  ?>
                </div>
              </div>
            </div>
          </div>
          <?php
	    }
		//else 
		//echo "<div>&nbsp;??</div>"; //
      ?>
          <div class="row">
            <div class="col-lg-8">
              <?php  

	$_SESSION["cevaplar"] = ""; 
	//eskiler silinir
	$_SESSION["hataSay"] = ""; 
	//eskiler silinir
	$_SESSION["cevaplar"][0] = ""; 
	//dizi olusturuldu
	$_SESSION["hataSay"][0] = ""; 
	//dizi olusturuldu
	$_SESSION['cevapSuresi'] = ""; 
	//eski degeri yok edelim 

?>
              <div id="kapsayici"><span id="anaMetin"><font id='uyari'><?php echo $metin[176]?></font></span> </div>
            </div>
            <div class="col-lg-4">
              <?php
	if($eMode=="1")
	  	echo ("<div id='lgout' style='top:-13px;'><a href='#' onclick='window.close();'>".$metin[34]."</a></div>");
	?>
              <div id="navigation"><span id="konuAdi">-</span> <span id="aktifKonuNo" style="visibility:hidden"></span><br />
                <?php echo $metin[174]?> : <span id="hazirlayan">-</span><br/>
                (<span id="eklenmeTarihi">-</span>)<br />
                <span id="sayfaNo">-</span> / <span id="sayfaSayisi">-</span> <span id="yukleniyor" style="visibility:hidden;"><img src="img/loadingRect2.gif" border="0" alt="loading"  style="vertical-align:middle"  title="loading" /></span><br />
                <span id="bitirmeYuzdesi"></span> </div>
              <input type="hidden" id="sonSayfaHidden" name="sonSayfaHidden" value="0" />
              <input type="hidden" id="konu_id" name="konu_id" />
              <input type="hidden" id="sayfa_id" name="sayfa_id" />
              <?php
                  
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
				    $tur = checkRealUser($adi,$par); 
					
  				   	if($tur!="-2" and !in_array($eMode,array("1","2"))){ 
                  ?>
              <div id="navigation2">
                <?php 					
					  if(($tur==1 || $tur==2) && isKonu($_GET["konu"])){ 
                    ?>
                <label style="color:#0000ff;" onclick='konuDuzenle();'> <img src="img/edit.png" alt="<?php echo $metin[103];?>"  title="<?php echo $metin[103];?>" width="16" height="16" border="0" style="vertical-align: middle;" /> <?php echo $metin[241]?></label>
                <?php
					  }
                    ?>
                <?php
if($seceneklerimiz[7]=="1"  and $kullaniciSecen[7]=="1" and isKonu($_GET["konu"])){
?>
                <br />
                <br />
                <label  class="external" onclick="printIt();"> <img src="img/preview.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[207]?>" /> <?php echo $metin[207]?></label>
                <?php
					  }
                    ?>
                <?php
if(isKonu($_GET["konu"])){
?>
                <br />
                <br />
                <a href="dersBilgisi.php?ders=<?php echo RemoveXSS($_GET["konu"])?>&amp;set=1" rel="facebox"> <img src="img/info.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[301]?>" /> <?php echo $metin[301]?></a>
                <?php
					  }
                    ?>
                <br />
                <br />
                <label id="addBookmarkContainer" title="<?php echo $metin[300]?>" > <img src="img/favcenter.gif" border="0" style="vertical-align:middle" alt="<?php echo $metin[244]?>"/> </label>
                <br />
                <br />
                <a href="askQuestion.php" title="<?php echo $metin[628]?>" > <img src="img/question.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[628]?>"/> <?php echo $metin[628]?></a>
                <?php
if($seceneklerimiz[9]=="1" and $kullaniciSecen[9]=="1"){
   if(isset($_GET["konu"]) && !empty($_GET["konu"]))
	  if(isKonu($_GET["konu"]))
	   {		  
	   
?>
                <br />
                <br />
                <div class="rating">
                  <?php
						$_SESSION["aktifDers"] = RemoveXSS($_GET["konu"]);
						include "rating.php";
                    ?>
                </div>
                <?php
	   }
}
?>
              </div>
            </div>
            <?php
					  }	
                 ?>
          </div>
          <?php
if($seceneklerimiz[8]=="1" and $kullaniciSecen[8]=="1" and isKonu($_GET["konu"]) && $tur>-2 and $eMode!="2" and $eMode!="1"){
?>
          <div class="col-lg-6 msg_head2">
            <p class="msg_head2"><img src="img/comment.gif" border="0" style="vertical-align: middle;" alt="comment"/>&nbsp;<?php echo $metin[259]?>
              <?php 
					 $yorumSayisi = konuYorumSayisiGetir($_GET["konu"]);
					 echo $yorumSayisi;
					 ?>
            </p>
            <div class="msg_body2">
              <?php 					
						$yorumlar = yorumlariGetir($_GET["konu"]); 
						if ($yorumlar!=""){
?>
              <link href="lib/pager.css" rel="stylesheet" type="text/css" />
              <script type="text/javascript" src="lib/jquery.quickpager.js"></script> 
              <script type="text/javascript">
/* <![CDATA[ */

$(document).ready(function() {
	$(".pageme tbody").quickPager( {
		pageSize: 5,
		currentPage: 1,
		pagerLocation: "after"
	});
});

/* ]]> */
</script>
              <table border="0" cellpadding="5" cellspacing="0" class="pageme">
                <tbody>
                  <?php
	  echo $yorumlar;
?>
                </tbody>
                <tfoot>
                  <tr>
                    <?php
					if($tur!="-2"){ 
                  	?>
                    <a name="yorumlar"></a> <a href="addComment.php?konu3=<?php echo RemoveXSS($_GET["konu"]);?>" rel="facebox"><img src="img/plus.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[242]?>" /> <?php echo $metin[242]?></a> | <a href="#" id="refresh"><img src="img/reload.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[99]?>" /> <?php echo $metin[99]?></a><br />
                    <br />
                    <?php 
					}?>
                  </tr>
                </tfoot>
              </table>
              <div class="pager"></div>
              <?php
						  
						}
						else  
						  echo $metin[279].' <a name="yorumlar"></a> <a href="addComment.php?konu3='.RemoveXSS($_GET["konu"]).'" rel="facebox"><img src="img/plus.png" border="0" style="vertical-align:middle" alt="$metin[242]" /> '.$metin[242].'</a> | <a href="#" id="refresh"><img src="img/reload.png" border="0" style="vertical-align:middle" alt="'.$metin[99].'" /> '.$metin[99].'</a>';
					?>
            </div>
          </div>
          <script>
$(document).ready(function() {

  $("#refresh").click(function() {
     //$(".msg_body2").load("yorumListesi.php");
  	location.reload();
	return false;
	});
});

  </script>
          <?php
}
          
	$sampleData2 = getGrafikValues3(20, $_GET["konu"]);
	$labels2 = getGrafikLabels3(20, $_GET["konu"]);

if($seceneklerimiz[14]=="1" and $kullaniciSecen[14]=="1" and isKonu($_GET["konu"]) and !empty($sampleData2) and count($sampleData2)>1 and $eMode!="2" and $eMode!="1" ){ 
?>
          <div class="col-lg-6 msg_list">
            <p class="msg_head"><img src="img/history.png" border="0" style="vertical-align: middle;" alt="lessons"/>&nbsp;<?php echo $metin[197]?></p>
            <div class="msg_body">
              <?php 							
							include('lib/graphs.inc.php');						
							$chart2 = new BAR_GRAPH("vBar");
							$chart2->values = grafikGunNormallestirData($sampleData2,$labels2);
							$chart2->labels = grafikGunNormallestirLabel($sampleData2,$labels2);
							$chart2->showValues = 2;	
							$chart2->labelSize =9;
							$chart2->titleSize =9;
							$chart2->absValuesSize  =9;
							$chart2->absValuesBorder = "0px";
						    echo $chart2->create(); 
						?>
            </div>
          </div>
          <?php
}
	if($seceneklerimiz[14]=="1" and $kullaniciSecen[14]=="1" and ($tur==0 || $tur==1 || $tur==2) && isKonu($_GET["konu"]) and $eMode!="2" and $eMode!="1"){
?>
          <div class="col-lg-6 msg_list">
            <p class="msg_head"><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="users"/>&nbsp;<?php echo $metin[479]?></p>
            <div class="msg_body">
              <?php 	
						$gelen = RemoveXSS($_GET["konu"]);						
	                    echo sonCalisanKullanicilar($gelen);					  
                    ?>
            </div>
          </div>
          <?php
	}
?>
          <?php	 
	 if(isset($_GET["konu"]) && isKonu($_GET["konu"])){
		  echo "<script type=\"text/javascript\">
		  	document.getElementById('konu_id').value=".RemoveXSS($_GET["konu"]).";
			document.getElementById('sonSayfaHidden').value=0;
			konuHazirla(".RemoveXSS($_GET["konu"]).");
			</script>";
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', " - ".konuAdiGetir($_GET["konu"]), $pageContents);	   			
	 }
	   else{
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', "", $pageContents);	   
	   }
	   
?>
        </div>
        <?php  						
				 if($eMode!="1") 	{									
              ?>
        <footer class="footer">
          <div class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="container">
              <div class="navbar-collapse collapse visible-xs">
                <div class="row"  id="ileriGeri">
                  <div class="col-xs-1"><span id="oncekiKonu"></span></div>
                  <div class="col-xs-1"><span id="sonrakiKonu"></span></div>
                  <div class="col-xs-2"><span id="geriDugmesi"></span></div>
                  <div class="col-xs-2"><span id="ileriDugmesi"></span></div>
                  <div class="col-xs-1" style="color:#FCF8E1; text-align:center;"><span id="cevapVer" title="<?php echo $metin[664]?>"><a href='soruCevapla.php' id="cevapLink" rel='facebox' onclick="cevapSureBasla();"><img src="img/hand.up.gif" border="0" style="vertical-align:middle" alt="cevap"/> <?php echo $metin[344]?></a></span></div>
                  <div class="col-xs-2" style="color:#FCF8E1;"><span id="calismaSuresi" class="badge">-</span> <?php echo $metin[172]?>
                    <?php (ayarGetir("ayar3int")>0) ? printf($metin[247],ayarGetir("ayar3int")) : ""; ?>
                  </div>
                  <div class="col-xs-1"><span id="soruGeriSayim" class="badge"></span></div>
                  <div class="col-xs-1">
                    <form name="sunum">
                      <span id="cevapSuresi" class="badge" style="color:#E8E717;"></span>
                      <input type="checkbox" id="sunuDurdur" name="sunuDurdur" title="<?php echo $metin[604]?>"
                    value="1" onclick="
                    if(document.sunum.sunuDurdur.checked)
	                    $('#cevapSuresi').stopTime();
                        else
                        sayacTetik3(document.getElementById('cevapSuresi').innerHTML);
                    "/>
                    </form>
                  </div>
                  <div class="col-xs-1"><span id="gercekCevapSuresi" style="visibility:hidden"></span> <span id="slideGecisSuresi" style="visibility:hidden"></span></div>
                </div>
              </div>
            </div>
          </div>
        </footer>
        <?php  						
				 }
              ?>
        <script src="lib/bs_js/bootstrap.js"></script> 
        <script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script> 
        <script language="javascript" type="text/javascript">  
document.getElementById('ileriGeri').style.visibility = 'visible' ;
document.getElementById('cevapVer').style.visibility = 'hidden' ;
document.getElementById('sunuDurdur').style.visibility = 'hidden';

/*
konuDuzenle:
konu duzenleme 
*/
function konuDuzenle(){
	if(document.getElementById('konu_id').value>0)
		location.href = "lessonsEdit.php?tab=4"+"&"+"seciliKonu=" + document.getElementById('konu_id').value;
	return false;
}

window.onbeforeunload = function () {	
  if (bitirmeYuzdesi() < 100 && parseInt(document.getElementById("calismaSuresi").innerHTML)> <?php echo ayarGetir("ayar3int");?> )	
   return "<?php echo $metin[345];?>";
}

window.onunload = function () {
  if (parseInt(document.getElementById("calismaSuresi").innerHTML)> <?php echo ayarGetir("ayar3int");?>)	
   saveUserWork();
}
/*
cevapSureBasla:
cevaplama icin sure baslar
*/
function cevapSureBasla(){

		if(document.getElementById('cevapSuresi').innerHTML==""){		
				$("#cevapSuresi").everyTime(1000,function(i) {
					
					csur = document.getElementById('gercekCevapSuresi').innerHTML;
						
						if(i> csur ){
						  	$("#cevapSuresi").stopTime();
							document.getElementById('cevapSuresi').innerHTML = '' ;
							document.getElementById('cevapVer').style.visibility = 'hidden' ;
							document.getElementById('cevapSonucu').style.visibility = 'hidden' ;
							document.getElementById('cevapDegerlendirmeYeri').innerHTML = "<"+"font id='hata'><?php echo $metin[346];?><"+"/font>";
							$("#calismaSuresi").stopTime();
							saveUserWork();
							}
						 else {
							$(this).html(csur -i);							
						 	}
					});	
		}
	}
	
fix_flash();	
</script> 
        <script type="text/javascript">

//ileri ve geri dolasma klavye tuslari: sag ok ve sol ok, Enter: Cevap ver.
	$(document).keydown(function(event) {
		var sayNosu;
		sayNosu = parseInt(document.getElementById('sayfaNo').innerHTML);
		switch (event.keyCode) {
			case 13: 
 			  if(document.getElementById('cevapVer').style.visibility == 'visible') 			  
			   if(document.getElementById("facebox_overlay")==null)
				if(sayNosu>0)
					$("#cevapLink").focus();
				break;
			case 37: 
				if(document.getElementById('geriDugmesi').innerHTML.indexOf("img/sayfa_l.png")>0)
				 if(document.getElementById('ileriGeri').style.visibility == 'visible')
				   if(document.getElementById("facebox_overlay")==null)
					  if(sayNosu>0)
						konuSec2(sayNosu-1,1);
				break;
			case 39: 
				if(document.getElementById('ileriDugmesi').innerHTML.indexOf("img/sayfa_r.png")>0)
				 if(document.getElementById('ileriGeri').style.visibility == 'visible')
				   if(document.getElementById("facebox_overlay")==null)
					  if(sayNosu>0)
						konuSec2(sayNosu+1,1);
				break;
		}
	});


$(document).ready(
	function()
	{
		var deger = degerOku('dersYukseklik');
		if(deger>300){
			$('#kapsayici').height (deger);
		}
		
	}
);
</script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>