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
ob_start (); // Buffer output
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
<script type="text/javascript" src="lib/script.js"></script>
<link href="stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/hijax.js"></script>
<link href="theme/ratings.css" rel="stylesheet" type="text/css" />
<link href="theme/lessons.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<script language="javascript" type="text/javascript" src="lib/dataFill.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : 'loading.gif',
        close_image   : 'closelabel.gif'
      }) 
    })
	
	$(document).ready(function(){
		$(".msg_body").hide();
		$(".msg_head").click(function(){
			$(this).next(".msg_body").slideToggle(200);
		});
		$(".msg_body2").hide();
		$(".msg_head2").click(function(){
			$(this).next(".msg_body2").slideToggle(200);
		});
	});
</script>
</head>
<body id="intro">
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
	currentFileCheck("lessons.php");
	
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
	
	require("menu.php");
	
	if($seceneklerimiz[13]=="1" ) require("ping.php");
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
                <div class="PostContent" style="height:450px;">
                  <?php  

	$_SESSION["cevaplar"] = ""; //eskiler silinir
	$_SESSION["cevaplar"][0] = ""; //dizi oluşturuldu
	$_SESSION['cevapSuresi'] = ""; //eski değeri yok edelim 

?>
                  <div id="oncekiKonu"></div>
                  <div id="sonrakiKonu"></div>
                  <div id="kapsayici"><div><div> <span id="anaMetin" ><font id='uyari'><?php echo $metin[176]?></font></span> </div></div></div>
                  <div id="navigation"><div><div><span id="konuAdi">-</span><br />
                    <?php echo $metin[174]?> : <span id="hazirlayan">-</span> (<span id="eklenmeTarihi">-</span>)<br />
                    <span id="sayfaNo">-</span> / <span id="sayfaSayisi">-</span> <br />
                    <span id="ileriGeri"> <span id="geriDugmesi"><img src="img/2leftarrowP.png" border="0" style="vertical-align:middle" alt="left"/></span> <span id="ileriDugmesi"><img src="img/2rightarrowP.png" border="0" style="vertical-align:middle" alt="right"/></span></span> &nbsp;&nbsp; <span id="yukleniyor" style="visibility:hidden;"><img src="img/loadingRect2.gif" border="0" alt="loading"  style="vertical-align:middle"  title="loading" /></span><br />
                    <span id="bitirmeYuzdesi"></span><br />
                    <?php echo $metin[240]?> : <span id="calismaSuresi">-</span> <?php echo $metin[172]?>&nbsp;
                    <?php (ayarGetir("ayar3int")>0) ? printf($metin[247],ayarGetir("ayar3int")) : ""; ?>
                    <span id="soruGeriSayim"></span><br/>
                    
                    <span id="cevapVer"><a href='soruCevapla.php' id="cevapLink" rel='facebox' onclick="cevapSureBasla();"><img src="img/hand.up.gif" border="0" style="vertical-align:middle" alt="cevap"/> <?php echo $metin[344]?></a></span>&nbsp; 
                    <span id="cevapSuresi" style="/*position:absolute;top:15px;left:440px;*/font-size:18px;text-align:right;font-weight:bolder;"></span>
</div></div>
                    </div>
                  <input type="hidden" id="sonSayfaHidden" name="sonSayfaHidden" value="0" />
                  <input type="hidden" id="konu_id" name="konu_id" />
                  <input type="hidden" id="sayfa_id" name="sayfa_id" />
                  
                  <?php
				    $adi	=temizle(substr($_SESSION["usern"],0,15));
	   				$par	=temizle($_SESSION["userp"]);
				    $tur = checkRealUser($adi,$par); 
					
  				   	if($tur!="-2"){ 
                  ?>
                  <div id="navigation2">
                    <?php 
					  if(($tur==1 || $tur==2) && isKonu($_GET["konu"])){ 
                    ?>
                    <label onclick='konuDuzenle();'> <img src="img/edit.png" alt="<?php echo $metin[103];?>"  title="<?php echo $metin[103];?>" width="16" height="16" border="0" style="vertical-align: middle;" /> <?php echo $metin[241]?></label>
                    <?php
					  }
                    ?>
                    <?php
if($seceneklerimiz[7]=="1" && isKonu($_GET["konu"])){
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
                    <a href="dersBilgisi.php?ders=<?php echo $_GET["konu"]?>&amp;set=1" rel="facebox"> <img src="img/info.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[301]?>" /> <?php echo $metin[301]?></a>
                    <?php
					  }
                    ?>
                    <br />
                    <br />
                    <label onclick="CreateBookmarkLink();" title="<?php echo $metin[300]?>" > <img src="img/favcenter.gif" border="0" style="vertical-align:middle" alt="<?php echo $metin[244]?>"/> <?php echo $metin[244]?></label>
                    <?php
if($seceneklerimiz[9]=="1"){
   if(isset($_GET["konu"]) && !empty($_GET["konu"]))
	  if(isKonu($_GET["konu"]))
	   {		  
	   
?>
                    <br />
                    <br />
                    <div class="rating">
                      <?php
						$id = temizle($_GET["konu"]);
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
if($seceneklerimiz[8]=="1" && isKonu($_GET["konu"]) && $tur>-2){
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
                    <p class="msg_head2"><img src="img/comment.gif" border="0" style="vertical-align: middle;" alt="lessons"/>&nbsp;<?php echo $metin[259]?> <?php echo konuYorumSayisiGetir($_GET["konu"]);?></p>
                    <div class="msg_body2">
                      <?php
					if($tur!="-2"){ 
                  	?>
                      <a name="yorumlar"></a> <a href="addComment.php?konu3=<?php echo $_GET["konu"];?>" rel="facebox"><img src="img/add.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[242]?>" /> <?php echo $metin[242]?></a><br />
                      <br />
                      <?php 
					}
					
						if (yorumlariGetir($_GET["konu"])!="")
						  echo yorumlariGetir($_GET["konu"]);
						else  
						  echo "$metin[279]";
					?>
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
if($seceneklerimiz[6]=="1"){
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
                        <p class="msg_head"><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/><?php echo $metin[55]?></p>
                        <div class="msg_body"> <?php echo dersAgaci(1)?> </div>
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

function CreateBookmarkLink() {
	var strTitle	= document.title;
	var strURL		= location.href;
    if (window.sidebar) 
    { 
        // Mozilla Firefox Bookmark
        window.sidebar.addPanel(strTitle, strURL,"");
    }
    else if( window.external )
    {
        // IE Favorite
        window.external.AddFavorite(strURL, strTitle);
    }
    else if(window.opera && window.print)
    { 
        // Opera Hotlist
        var elem = document.createElement('a');
        elem.setAttribute('href',url);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    }
	
	return false;

}

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

function cevapSureBasla(){

		if(document.getElementById('cevapSuresi').innerHTML==""){		
				$("#cevapSuresi").everyTime(1000,function(i) {
						if(i>31){
						  	$("#cevapSuresi").stopTime();
							document.getElementById('cevapSuresi').innerHTML = '' ;
							document.getElementById('cevapVer').style.visibility = 'hidden' ;
							document.getElementById('cevapSonucu').style.visibility = 'hidden' ;
							document.getElementById('cevapDegerlendirmeYeri').innerHTML = "<"+"font id='hata'><?php echo $metin[346];?><"+"/font>";
							}
						 else {
							$(this).html(31-i);							
						 	}
					});	
		}
	}
</script>
          <?php	 
	 if(isset($_GET["konu"]) && isKonu($_GET["konu"])){
		  echo "<script type=\"text/javascript\">
		  	document.getElementById('konu_id').value=".
			temizle($_GET["konu"]).
			";document.getElementById('sonSayfaHidden').value=0;konuSec2(1);</script>";
			
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
</body>
</html>
