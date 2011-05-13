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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
	<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta http-equiv="pragma" content="no-cache"/>
	<meta http-equiv="Expires" content="-1"/>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>eOgr -<?php echo $metin[443]?></title>
	<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
	<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
	<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
	<link rel="shortcut icon" href="img/favicon.ico"/>
	<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
	<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="lib/script.js"></script>
	<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
	<script src="lib/jquery-1.6.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
    
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
	height: 300px;
	overflow: hidden;
	margin:5px;
}
.menu ul {
	margin: 0;
	padding: 0;
	height: 300px;
	width: 750px;
	display: block;
	list-style: none;
	overflow: hidden;
	list-style-image:none;
}
.menu ul > li {
	float: left;
	list-style:none;
	list-style-image:none;
	margin: 0px;
	width: 170px;
	height: 300px;
	-moz-border-radius-topleft: 15px;
	border-top-left-radius: 15px;
}
.menu ul > li > div {
	position: relative;
	padding-top:5px;
	margin-left:-5px;
}
.menu ul > li > div > a {
	width:140px;
	display:block;
	padding:5px;
	color:#00F;
}
.menu ul > li > div > a:hover {
	color:#000;
	background-color:#ccc;
}
.menu ul > li > div > a:active {
	color:#000;
	background-color:#aaa;
}
.menu ul > li > div > a.active {
	color:#d00;
	border-bottom:dotted 1px #D40000;
	border-left:dotted 1px #D40000;
}
.menu ul li {
	background-color:#FDD017;
	background-image:none;
	overflow-y:auto;
	overflow-x:hidden;
	opacity:0.8;
	filter:alpha(opacity=80);
	text-align: left;
	display: block;
}
.okul {
	background-color:#FDD017;
}
sinif {
	background-color:#FDD017;
}
.ders {
	background-color:#FDD017;
}
.menu ul li.konu {
	background-color:#FDD017;
	-moz-border-radius: 15px 0px;
	border-radius: 15px 0px;
	width: 170px;
}
#loading {
	text-align: center;
	visibility: hidden;
}
.scroll-pane {
	width: 200px;
	height: 200px;
	overflow: auto;
	background: #ccc;
	float: left;
}
</style>
	<link type="text/css" href="lib/jquery.jscrollpane.css" rel="stylesheet" media="all" />
	<script type="text/javascript" src="lib/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="lib/jquery.jscrollpane.min.js"></script>
	<script language="javascript">
jQuery.noConflict();
jQuery(document).ready(function() {
    /**
     * jQuery Accordion
     */

var hiz = 250;
var sinif = $(".sinif div");
var ders = $(".ders div");
var konu = $(".konu div");
var loading = $("#loading");

	$(".okul div a").live("mouseover",function() {
		showLoading();
		
		$(".okul div a").removeClass("active");
		$(this).toggleClass("active");

		sinif.load("dataFill.php?okul=" + this.id);
		ders.load("dataFill.php?okuldan=1&sinif=" + this.id);
		konu.load("dataFill.php?okuldan=2&ders=" + this.id, hideLoading);
	});
	$(".sinif div a").live("mouseover",function() {
		showLoading();
		$(".sinif div a").removeClass("active");
		$(this).toggleClass("active");

		ders.load("dataFill.php?sinif=" + this.id);
		konu.load("dataFill.php?siniftan=1&ders=" + this.id, hideLoading);
	});
	$(".ders div a").live("mouseover",function() {
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[443]?> </span> </h2>
                <div class="PostContent" style="overflow:hidden;"><br />
                      <div class="containerStripe">
                    <div class="outerStripe">
                          <div class="menu">
                        <ul>
                              <li class="okul">
                            <div>
                                  <?php
								echo okulAdlari();
							?>
                                </div>
                          </li>
                              <li class="sinif">
                            <div>
                                  <?php
								echo sinifAdlari('all');
							?>
                                </div>
                          </li>
                              <li class="ders">
                            <div>
                                  <?php
								echo dersAdlari('all');
							?>
                                </div>
                          </li>
                              <li class="konu">
                            <div>
                                  <?php
								echo konuAdlari('all');
							?>
                                </div>
                          </li>
                            </ul>
                      </div>
                          <div id="loading" align="center"> <img src="img/ajax-loader.gif" alt="Loading/Yukleniyor" /> </div>
                        </div>
                  </div>
                    </div>
                <?php
				?>
                <?php
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));		  
if($seceneklerimiz[6]=="1" and $kullaniciSecen[6]=="1")
{
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
                          <div class="BlockContent" style="background-color:#FFA">
                        <div class="BlockContent-body">
                              <div>
                            <div class="msg_list">
                                  <div class="msg_body">
                                <div id="sidetreecontrol"><a href="?#"  style="color:#00F"><?php echo $metin[458]?></a> | <a href="?#"  style="color:#00F"><?php echo $metin[459]?></a> | <a  href="#"  style="color:#00F"><?php echo $metin[460]?></a></div>
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