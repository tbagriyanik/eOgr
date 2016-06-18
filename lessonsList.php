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
	ob_start (); // Buffer output
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(false,true,"lessonsList.php");	   

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
	<title>eOgr - <?php echo $metin[443]?></title>
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
	<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
	<style type="text/css">
div.containerStripe {
	background-color: transparent;
}
div.outerStripe {
	margin: 0 auto;
	width: 752px;
}
div.menu {
	width: 750px;
	height: 200px;
	overflow: hidden;
	margin: 5px;
}
.menu ul {
	margin: 0;
	padding: 0;
	height: 200px;
	width: 750px;
	display: block;
	list-style: none;
	overflow: hidden;
	list-style-image: none;
}
.menu ul > li {
	float: left;
	list-style: none;
	list-style-image: none;
	margin: 0px;
	width: 170px;
	height: 200px;
	-moz-border-radius-topleft: 15px;
	border-top-left-radius: 15px;
}
.menu ul > li > div {
	position: relative;
	padding-top: 5px;
	margin-left: -5px;
}
.menu ul > li > div > a {
	width: 140px;
	display: block;
	padding: 5px;
	color: #00F !important;
}
.menu ul > li > div > a:hover {
	color: #000;
	background-color: #ccc;
}
.menu ul > li > div > a:active {
	color: #000;
	background-color: #aaa;
}
.menu ul > li > div > a.active {
	color: #d00;
	border-bottom: dotted 1px #D40000;
	border-left: dotted 1px #D40000;
}
.menu ul li {
	background-color: #FDD017;
	background-image: none;
	overflow-y: auto;
	overflow-x: hidden;
	opacity: 0.8;
	filter: alpha(opacity=80);
	text-align: left;
	display: block;
}
.okul {
	background-color: #FDD017;
}
sinif {
	background-color: #FDD017;
}
.ders {
	background-color: #FDD017;
}
.menu ul li.konu {
	background-color: #FDD017;
	-moz-border-radius: 15px 0px;
	border-radius: 15px 0px;
	width: 170px;
}
#loading {
	text-align: center;
	visibility: hidden;
}
#loading2 {
	display: block;
}
.scroll-pane {
	width: 200px;
	height: 200px;
	overflow: auto;
	background: #ccc;
	float: left;
}
</style>
	<script language="javascript">
//jQuery.noConflict();
jQuery(document).ready(function() {
    /**
     * jQuery Accordion
     */
$("#dersAgacimiz").attr("style", "height:auto");
$("#loading2").hide("slow");
var hiz = 250;
var sinif = $(".sinif div");
var ders = $(".ders div");
var konu = $(".konu div");
var loading = $("#loading");

	$(".okul div a").bind("mouseover",function() {
		showLoading();
		
		$(".okul div a").removeClass("active");
		$(this).toggleClass("active");

		sinif.load("dataFill.php?okul=" + this.id);
		ders.load("dataFill.php?okuldan=1&sinif=" + this.id);
		konu.load("dataFill.php?okuldan=2&ders=" + this.id, hideLoading);
	});
	$(".sinif div a").bind("mouseover",function() {
		showLoading();
		$(".sinif div a").removeClass("active");
		$(this).toggleClass("active");

		ders.load("dataFill.php?sinif=" + this.id);
		konu.load("dataFill.php?siniftan=1&ders=" + this.id, hideLoading);
	});
	$(".ders div a").bind("mouseover",function() {
		showLoading();
		$(".ders div a").removeClass("active");
		$(this).toggleClass("active");

		konu.load("dataFill.php?ders=" + this.id, hideLoading);
	});
	
	//show loading bar
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"})
		;
	}
	//hide loading bar
	function hideLoading(){
		loading.fadeTo(1000, 0);
	};

    $('.menu ul > li').hover(function() {
        // if the element is currently being animated (to a easeOut)...
        if ($(this).is(':animated')) {
            $(this).stop().animate({
                opacity: 1
            }, {
                duration: hiz,
                easing: "swing"
            });
        } else {
            // ease in quickly
            $(this).stop().animate({
                opacity: 1,
            }, {
                duration: hiz,
                easing: "swing"
            });
        }
    }, function() {
        // on hovering out, ease the element out
        if ($(this).is(':animated')) {
            $(this).stop().animate({
                opacity: 0.8
            }, {

                duration: hiz,
                easing: "swing"
            })
        } else {
            // ease out slowly
            $(this).stop(':animated').animate({
                opacity: 0.8
            }, {
                duration: hiz,
                easing: "swing"
            });
        }
    });
	
});
</script>
	<script src="lib/jquery.cookie.js" type="text/javascript"></script>
	<link rel="stylesheet" href="lib/jquery-treeview/jquery.treeview.css" />
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
	</script>
	</head>
	<body>
<?php require("menu.php");?>
<div class="container">
      <div class="col-lg-12">
    <div class="PostContent" style="overflow:hidden;">
          <form name="arama" method="get" action="lessonsList.php">
        Ders Arama :
        <input type="text" name="ara" id="ara" maxlength="50" size="30" value="<?php
					if (isset($_GET["ara"]))
						echo RemoveXSS($_GET["ara"]);
                    ?>" autofocus title="Arama için en az 3 harf girilmelidir."/>
        <input type="image" name="araImg" src="img/view.png" />
      </form>
          <?php
if(!empty($_GET["ara"]) and strlen($_GET["ara"])>2 and strlen($_GET["ara"])<51):
$arananlar = sayfaKonuDersArama($_GET["ara"]);

 if(!empty($arananlar)){
?>
          <link href="lib/pager.css" rel="stylesheet" type="text/css" />
          <script type="text/javascript" src="lib/jquery.quickpager.js"></script> 
          <script type="text/javascript">
/* <![CDATA[ */

$(document).ready(function() {
	$(".pageme tbody").quickPager( {
		pageSize: 10,
		currentPage: 1,
		pagerLocation: "after"
	});	
});

/* ]]> */
</script>
          <table border="0" width="100%" cellpadding="5" cellspacing="0" class="pageme">
        <tbody style="background-color:#eee;font-size:11px;">
              <?php
	  echo $arananlar;
?>
            </tbody>
      </table>
          <div class="pager"></div>
          <?php
 }else
	echo "<font id='uyari'>$metin[497]</font>";
else:
	if(!empty($_GET["ara"]))
		echo "<font id='uyari'>$metin[497]</font>";
endif;
?>
        </div>
    <?php
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));		  
if($seceneklerimiz[6]=="1" and $kullaniciSecen[6]=="1")
{
?>
    <div class="Post">          
              <div id="loading2" align="center"> <img src="img/ajax-loader.gif" alt="Loading/Yukleniyor" /> </div>
              <?php 
								if(empty($_GET["ara"]))	{
						  ?>
            
                <div class="msg_list">
                    <div class="msg_body">
                    <div id="sidetreecontrol"><a href="?#"  style="color:#00F"><?php echo $metin[458]?></a> | <a href="?#"  style="color:#00F"><?php echo $metin[459]?></a> | <a  href="#"  style="color:#00F"><?php echo $metin[460]?></a></div>
                    <?php 
								  echo dersAgaci(1);
								?>
					</div>
                </div>
                <!--<div class="containerStripe">
                                <div class="outerStripe">
                                      <div class="menu">
                                    <ul>
                                          <li class="okul">
                                        <div>
                                              <?php
								//echo okulAdlari();
							?>
                                            </div>
                                      </li>
                                          <li class="sinif">
                                        <div>
                                              <?php
								//echo sinifAdlari('all');
							?>
                                            </div>
                                      </li>
                                          <li class="ders">
                                        <div>
                                              <?php
								//echo dersAdlari('all');
							?>
                                            </div>
                                      </li>
                                          <li class="konu">
                                        <div>
                                              <?php
								//echo konuAdlari('all');
							?>
                                            </div>
                                      </li>
                                        </ul>
                                  </div>
                                      <div id="loading" align="center"> <img src="img/ajax-loader.gif" alt="Loading/Yukleniyor" /> </div>
                                    </div>
                              </div>--> 
              </div>                
        <?php
								}
                        ?>
      </div>      
  </div>
      <?php
}
?>
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