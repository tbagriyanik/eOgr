<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
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
		  	$eMode = "3"; //genel varsayýlan
  }  
  
  if(!isset($_GET["konu"]))				
    $_GET["konu"]="";

  if(isset($_SESSION["usern"]))
		$kullaniciSecen = explode("-",ayarGetir3(RemoveXSS($_SESSION["usern"])));
	else
	 	$kullaniciSecen = array("","","","","","","","","","","","","","","");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
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
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/dataFillLessons.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery-add_bookmark.js"></script>
<script type="text/javascript" src="lib/jquery.easing.1.2.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link rel="stylesheet" href="lib/jquery-treeview/jquery.treeview.css" />
<script src="lib/jquery.cookie.js" type="text/javascript"></script>
<script src="lib/jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
		jQuery(document).ready(function($) {
			$("#lessonTree").treeview({
				animated: "fast",
				collapsed: true,
				persist: "cookie",
				control:"#sidetreecontrol"
			});
		});
		
function degerOku(isim) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(isim + "=");
		if (c_start != -1) {
			c_start = c_start + isim.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1) {
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}

function degerYaz(isim, deger, expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = isim + "=" + escape(deger) + ((expiredays === null) ? "" : ";expires=" + exdate.toGMTString());
}		
</script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
	
	$(document).ready(function(){
		$(".msg_body").hide();
		$(".msg_head").click(function(){
			$(this).next(".msg_body").slideToggle(200);
		});
		//$(".msg_body2").hide();
		$(".msg_head2").click(function(){
			$(this).next(".msg_body2").slideToggle(200);
		});
		
			$("#ileriDugmesi, #geriDugmesi, #oncekiKonu, #sonrakiKonu").hover(function() {
			$(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
			$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
				.animate({
					marginTop: '-8px', /* The next 4 lines will vertically align this image */ 
					marginLeft: '-6px',
					top: '50%',
					left: '50%',
					width: '40px', /* Set new width */
					height: '40px' /* Set new height */
				}, 100); /* this value of "200" is the speed of how fast/slow this hover animates */
		
			} , function() {
			$(this).css({'z-index' : '0'}); /* Set z-index back to 0 */
			$(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
				.animate({
					marginTop: '0', /* The next 4 lines will vertically align this image */ 
					marginLeft: '0',
					top: '0',
					left: '0',
					width: '25px', /* Set width back to default */
					height: '25px' /* Set height back to default */
				}, 150);
		});			
		
		$("#oncekiKonu, #sonrakiKonu").hover(function() {
			$(this).css({'z-index' : '1000'}); /*Add a higher z-index value so this image stays on top*/ 
			$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
				.animate({
					marginTop: '-6px', /* The next 4 lines will vertically align this image */ 
					marginLeft: '-6px',
					top: '20%',
					left: '20%',
					width: '32px', /* Set new width */
					height: '32px' /* Set new height */
				}, 100); /* this value of "200" is the speed of how fast/slow this hover animates */
		
			} , function() {
			$(this).css({'z-index' : '1000'}); /* Set z-index back to 0 */
			$(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
				.animate({
					marginTop: '0', /* The next 4 lines will vertically align this image */ 
					marginLeft: '0',
					top: '0px',
					left: '0',
					width: '16px', /* Set width back to default */
					height: '16px' /* Set height back to default */
				}, 150);
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
</head>
<?php flush(); ?>
<body id="intro" onselectstart="//return false;" ondragstart="return false" oncontextmenu="return false" onunload="cleanup()" >
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
      <?php
		if($eMode!="1"){
      ?>
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
	
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));

	 if(isset($_SESSION["usern"]))
		$kullaniciSecen = explode("-",ayarGetir3(RemoveXSS($_SESSION["usern"])));

		require("menu.php");	
                ?>
        <div style="position:relative ; padding:2px;margin:5px;background-color:transparent;font-size:11px;clear:left;left:auto;height:20px">
          <?php				
				echo " $metin[556] : ";
		
			  if(isset($_GET["konu"]))				
                if(isKonu($_GET["konu"])){
				?>
          <label onclick="location.href='lessons.php';window.open('lessons.php?konu=<?php echo RemoveXSS($_GET["konu"])?>&amp;mode=1');return false;" class="external">
            <?php 	echo $metin[553];?>
          </label>
          &nbsp; |
          <?php
				}
        ?>
          <a href='?konu=<?php echo RemoveXSS($_GET["konu"])?>&amp;mode=2'>
          <?php 		
		if($eMode=="2") 
			echo "<strong>$metin[552]</strong>";
		else
			echo $metin[552];
		?>
          </a> | <a href='?konu=<?php echo RemoveXSS($_GET["konu"])?>&amp;mode=3'>
          <?php  		
		if($eMode=="3") 
			echo "<strong>$metin[557]</strong>";
		else
			echo $metin[557];
		?>
          </a> | <a href='userSettings.php#ozel'><?php echo $metin[554]?></a> 
		  <?php
		  if($seceneklerimiz[13]=="1" and $kullaniciSecen[13]=="1" ) require("ping.php");
		  ?>
		  </div>
        <div class="l"> </div>
        <div class="r">
          <div>&nbsp;</div>
        </div>
      </div>
      <?php
	    }
		else 
		echo "<div>&nbsp;</div>";
      ?>
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
                <div class="PostContent" style="height:542px;overflow:hidden;">
                  <?php  

	$_SESSION["cevaplar"] = ""; 
	//eskiler silinir
	$_SESSION["hataSay"] = ""; 
	//eskiler silinir
	$_SESSION["cevaplar"][0] = ""; 
	//dizi oluþturuldu
	$_SESSION["hataSay"][0] = ""; 
	//dizi oluþturuldu
	$_SESSION['cevapSuresi'] = ""; 
	//eski deðeri yok edelim 

?>
                  <div id="oncekiKonu"></div>
                  <div id="sonrakiKonu"></div>
                  <div id="resizeMe">
                    <div id="kapsayici"><span id="anaMetin" ><font id='uyari'><?php echo $metin[176]?></font></span><div id="resizeS"><img src="img/angle-nxs.gif" alt="slider" /></div>
                    </div>
                  </div>
                  <div id="navigation"><span id="konuAdi">-</span> <span id="aktifKonuNo" style="visibility:hidden"></span><br />
                    <?php echo $metin[174]?> : <span id="hazirlayan">-</span><br/>
                    (<span id="eklenmeTarihi">-</span>)<br />
                    <span id="sayfaNo">-</span> / <span id="sayfaSayisi">-</span> <br />
                    <span id="yukleniyor" style="visibility:hidden;"><img src="img/loadingRect2.gif" border="0" alt="loading"  style="vertical-align:middle"  title="loading" /></span><br />
                    <span id="bitirmeYuzdesi"></span><br />
                    <?php echo $metin[240]?> : <span id="calismaSuresi">-</span> <?php echo $metin[172]?>&nbsp;
                    <?php (ayarGetir("ayar3int")>0) ? printf($metin[247],ayarGetir("ayar3int")) : ""; ?>
                    <span id="soruGeriSayim"></span><br/>
                    <span id="cevapVer"><a href='soruCevapla.php' id="cevapLink" rel='facebox' onclick="cevapSureBasla();"><img src="img/hand.up.gif" border="0" style="vertical-align:middle" alt="cevap"/> <?php echo $metin[344]?></a></span>
                    <form name="sunum" style="text-align:right">
                      <span id="cevapSuresi" style="/*position:absolute;top:15px;left:440px;*/font-size:18px;text-align:right;font-weight:bolder;"></span>
                      <input type="checkbox" id="sunuDurdur" name="sunuDurdur" title="<?php echo $metin[604]?>"
                    value="1" onclick="
                    if(document.sunum.sunuDurdur.checked)
	                    $('#cevapSuresi').stopTime();
                        else
                        sayacTetik3(document.getElementById('cevapSuresi').innerHTML);
                    "/>
                    </form>
                  </div>
                  <div id="ileriGeri"> <span id="geriDugmesi"><img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/></span> <span id="ileriDugmesi"><img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/></span> <span id="hint"><?php echo $metin[486];?><span class="hint-pointer">&nbsp;</span></span></div>
                  <input type="hidden" id="sonSayfaHidden" name="sonSayfaHidden" value="0" />
                  <input type="hidden" id="konu_id" name="konu_id" />
                  <input type="hidden" id="sayfa_id" name="sayfa_id" />
                  <span id="gercekCevapSuresi" style="visibility:hidden"></span> <span id="slideGecisSuresi" style="visibility:hidden"></span>
                  <?php
                  if($eMode=="1")
					  	echo ("<div id='lgout' style='top:-13px;'><a href='#' onclick='window.close();'>".$metin[34]."</a></div><br/>");
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
                  <?php
					  }	
                 ?>
                </div>
                <div class="cleared"></div>
              </div>
              &nbsp;</div>
          </div>
          <?php
if($seceneklerimiz[8]=="1" and $kullaniciSecen[8]=="1" and isKonu($_GET["konu"]) && $tur>-2 and $eMode!="2" and $eMode!="1"){
?>
          <div class="Post">
            <div class="Block">
              <div class="Block-tl"></div>
              <div class="Block-tr"></div>
              <div class="Block-bl"></div>
              <div class="Block-br"></div>
              <div class="Block-tc"></div>
              <div class="Block-bc"></div>
              <div class="Block-cl"></div>
              <div class="Block-cr"></div>
              <div class="Block-cc"></div>
              <div class="Block-body">
                <div class="BlockContent">
                  <div class="BlockContent-body">
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
                      <table border="0" width="800" cellpadding="3" cellspacing="3" class="pageme">
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
                    <script>
$(document).ready(function() {

  $("#refresh").click(function() {
     //$(".msg_body2").load("yorumListesi.php");
  	location.reload();
	return false;
	});
});

  </script> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
}
          
	$sampleData2 = getGrafikValues3(20, $_GET["konu"]);
	$labels2 = getGrafikLabels3(20, $_GET["konu"]);

if($seceneklerimiz[14]=="1" and $kullaniciSecen[14]=="1" and isKonu($_GET["konu"]) and !empty($sampleData2) and count($sampleData2)>1 and $eMode!="2" and $eMode!="1" ){ 
?>
          <div class="Post">
            <div class="Block">
              <div class="Block-tl"></div>
              <div class="Block-tr"></div>
              <div class="Block-bl"></div>
              <div class="Block-br"></div>
              <div class="Block-tc"></div>
              <div class="Block-bc"></div>
              <div class="Block-cl"></div>
              <div class="Block-cr"></div>
              <div class="Block-cc"></div>
              <div class="Block-body">
                <div class="BlockContent">
                  <div class="BlockContent-body">
                    <div>
                      <div class="msg_list">
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
}
	if($seceneklerimiz[14]=="1" and $kullaniciSecen[14]=="1" and ($tur==0 || $tur==1 || $tur==2) && isKonu($_GET["konu"]) and $eMode!="2" and $eMode!="1"){
?>
          <div class="Post">
            <div class="Block">
              <div class="Block-tl"></div>
              <div class="Block-tr"></div>
              <div class="Block-bl"></div>
              <div class="Block-br"></div>
              <div class="Block-tc"></div>
              <div class="Block-bc"></div>
              <div class="Block-cl"></div>
              <div class="Block-cr"></div>
              <div class="Block-cc"></div>
              <div class="Block-body">
                <div class="BlockContent">
                  <div class="BlockContent-body">
                    <div>
                      <div class="msg_list">
                        <p class="msg_head"><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="users"/>&nbsp;<?php echo $metin[479]?></p>
                        <div class="msg_body">
                          <?php 	
						$gelen = RemoveXSS($_GET["konu"]);						
	                    echo sonCalisanKullanicilar($gelen);					  
                    ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
	}
?>
          <?php
if($seceneklerimiz[6]=="1" and $kullaniciSecen[6]=="1" and $eMode!="2" and $eMode!="1"){
?>
          <div class="Post">
            <div class="Block">
              <div class="Block-tl"></div>
              <div class="Block-tr"></div>
              <div class="Block-bl"></div>
              <div class="Block-br"></div>
              <div class="Block-tc"></div>
              <div class="Block-bc"></div>
              <div class="Block-cl"></div>
              <div class="Block-cr"></div>
              <div class="Block-cc"></div>
              <div class="Block-body">
                <div class="BlockContent">
                  <div class="BlockContent-body">
                    <div>
                      <div class="msg_list">
                        <p class="msg_head"><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/>&nbsp;<?php echo $metin[443]?></p>
                        <div class="msg_body">
                          <div id="sidetreecontrol"><a href="?#"><?php echo $metin[458]?></a> | <a href="?#"><?php echo $metin[459]?></a> | <a  href="#"><?php echo $metin[460]?></a></div>
                          <?php echo dersAgaci(1)?> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
}
?>
          <script language="javascript" type="text/javascript">  
document.getElementById('ileriGeri').style.visibility = 'visible' ;
document.getElementById('cevapVer').style.visibility = 'hidden' ;
document.getElementById('sunuDurdur').style.visibility = 'hidden';

/*
konuDuzenle:
konu düzenleme baðýnýn çalýþmasý
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
cevaplama için süre baþlangýcý
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
          <div class="cleared"></div>
          <?php  						
				 if($eMode!="1") 	{									
              ?>
          <div class="Footer">
            <div class="Footer-inner">
              <?php  						
						 require "footer.php";
              ?>
            </div>
            <div class="Footer-background"></div>
            <?php  						
				 }
              ?>
          </div>
        </div>
        <div class="cleared"></div>
      </div>
      <div class="cleared"></div>
    </div>
  </div>
</div>
<?php
 if($eMode!="1") 						
	 require "feedback.php";
?>
<script type="text/javascript">
$(document).ready(
	function()
	{
		var deger = degerOku('dersYukseklik');
		if(deger>300){
			$('#kapsayici').height (deger);
		}
			
		$('#resizeMe').Resizable(
			{
				minHeight: 350,
				maxHeight: 500,
				handlers: {
					s: '#resizeS'
				},
				onResize: function(size)
				{
					$('#kapsayici', this).css('height', size.height - 1 + 'px');
					degerYaz('dersYukseklik', size.height - 6, 7);					
				}
			}
		);
	}
);
</script> 
<script type="text/javascript" src="lib/resize.js"></script>
</body>
</html>