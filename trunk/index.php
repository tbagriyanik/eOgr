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
  session_start(); 
  ob_start();

  	$_SESSION['aThing'] = md5($_SERVER['HTTP_USER_AGENT']);
	$_SESSION["newUser"]="";
	$_SESSION["passRem"]="";

  require("conf.php");  
  		
  $time = getmicrotime();

  if (empty($_GET["lng"]) && empty($_COOKIE["lng"])){
        $taraDili= browserdili(); 
        if($taraDili!="TR") $taraDili="EN";
		setcookie("lng",$taraDili,time()+60*60*24*30);
		header("Location: index.php");
    }
   else
    {
			$siteSecenekleri = explode("-",ayarGetir("ayar5char"));
			if($siteSecenekleri[2]=="1"){
				if(isset($_COOKIE["lng"])) $taraDili=RemoveXSS($_COOKIE["lng"]);	
				
				if(isset($_GET["lng"])) $taraDili=RemoveXSS($_GET["lng"]);		 
				if(!empty($_GET["lng"])) {
				if($taraDili=="TR") 
				   $taraDili="EN"; else
				if($taraDili=="EN") 
				   $taraDili="TR"; else 
				   $taraDili="EN";
				}
				setcookie("lng",$taraDili,time()+60*60*24*30);
			}
	}

  checkLoginLang(false,true,"index.php");	   
  $seciliTema=temaBilgisi();
    
  if(isset($_GET["logout"])) 
  if($_GET["logout"]=="1") 
  {
	  sessionDestroy();
	  unset($_SESSION["usern"]);
  }

   if(isset($_GET["oldPath"]))
    {
		if(in_array($_GET["oldPath"],
				array("index.php",
					"lessons.php",
					"dataActions.php",
					"dataChatActions.php",
					"dataCommentList.php",
					"dataCommentList2.php",
					"dataRatingList.php",
					"dataWorkList.php",
					"dataWorkList2.php",
					"fileShare.php",
					"help.php",
					"kursDetay.php",
					"kursDetay2.php",
					"lessonsEdit.php",
					"login.php",
					"newUser.php",
					"passwordRemember.php",
					"rssEdit.php",
					"siteSettings.php",
					"siteSettings2.php",
					"siteSettings3.php",
					"stats.php",
					"userSettings.php",
					"siteNotices.php",
					"siteMap.php",
					"friends.php",
					"dataFriendActions.php",
					"askQuestion.php",
					"install.php"
					)))
			header("Location: ".$_GET["oldPath"]);
		else
			header("Location: index.php"); 				
	}

   if(isset($_GET["forgetMe"]))
    {
		if(!empty($_GET["forgetMe"])) {
		setcookie("remUser","",time()-9999);	
		header("Location: index.php");
		}
	}

    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  
	if ($_SESSION['aThing'] != "") {   	
  	 if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) {   
	    sessionDestroy();
		die("<font id='hata'> ".$metin[400]."</font><br/>".$metin[402]); //session?
		exit;
	 }
	}
	
	$dosyUpload = dosya_uploads_uyumu();
	//bir sorun var ise otomatik salt okunur uploads dizini
	if(!empty($dosyUpload)){
		@chmod($_uploadFolder,0755);//yetki sorunu var olabilir		
	}
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
<meta name="keywords" content="elearning, cms, lms, learning management, education, eogrenme" />
<meta name="description" content="eOgr - Open source online education, elearning project" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<title>eOgr</title>
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<script src="lib/jquery-1.4.3.min.js" type="text/javascript"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<script type="text/javascript" src="lib/jquery.badBrowser.js"></script>
<script type="text/javascript">
		jQuery(document).ready(function($) {
			
				//$("#browserWarning").hide(); 
				
				$('#warningClose').click(function(){
					//setBadBrowser('browserWarning','seen');
					$.cookie('browserWarning', '1');
					$('#browserWarning').slideUp('slow');
					return false;
				});
					
				 if(badBrowser()) {
					 if(parseInt(getBadBrowser('browserWarning')) == Number.NaN){
						$('#browserWarning').show(); 
						$('#browserWarning').slideUp(5);
 						$('#browserWarning').slideDown(500);
					 }
					}else
					$("#browserWarning").hide();

				if(parseInt(getBadBrowser('browserWarning')) > 0) 
					{
					$('#browserWarning').slideUp(1);
					$("#browserWarning").hide();
					}				
								
		})		
</script>
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<?php
$remUser = false;
if (isset($_COOKIE["remUser"]))
  if (strlen($_COOKIE["remUser"])>0){
   $remUser = true;
  }
 
?>
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
        <div class="contentLeft">
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
  if (checkRealUser($_SESSION["usern"],$_SESSION["userp"])==-2){$_SESSION["usern"]="";$_SESSION["userp"]="";
?>
                  <script type="text/javascript" src="lib/jquery.validate.min.js"></script> 
                  <script type="text/javascript">
$().ready(function() {
	$("#form1").validate({
		rules: {
			userN: {
				required: true,
				minlength: 5,
				maxlength: 15
			},
			userP: {
				required: true,
				minlength: 5,
				maxlength: 15
			}
		},
		messages: {
			userN: {
				required: "<?php echo $metin[607]?>",
				minlength: "<?php echo $metin[608]?>"
			},
			userP: {
				required: "<?php echo $metin[610]?>",
				minlength: "<?php echo $metin[609]?>"
			}
		}
	});	
});
  </script>
                  <div id="contact-wrapper">
                    <form id="form1" method="post" action="login.php">
                      <label for="userN"> <?php echo $metin[0]?> : </label>
                      <input type="hidden" name="form" value="login" />
                      <div>
                        <input name="userN" type="text" id="userN" size="18" maxlength="15" class="required"  style="width:150px" 
                     value="<?php echo ($remUser)?temizle($_COOKIE["remUser"]):""?>" />
                      </div>
                      <label for="userP"> <?php echo $metin[1]?> : </label>
                      <div>
                        <input name="userP" type="password" id="userP" size="18" maxlength="15" class="required"  style="width:150px" />
                      </div>
                      <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[2]?>"  />
                      &nbsp;
                      <?php
	 if (!empty($_COOKIE["remUser"])){
    ?>
                      <a href="index.php?forgetMe=1"><span><span><?php echo $metin[196]?></span></span></a>
                      <?php
	} else {
    ?>
                      <br/>
                      <br/>
                      <label>
                        <input type="checkbox" name="remUser" id="remUser" value="1"/>
                        <?php echo $metin[193]?> </label>
                      <?php
	}
    ?>
                      <br />
                      <br />
                      <a href="newUser.php"><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[3]?></a>&nbsp;|&nbsp;<a href="passwordRemember.php"><?php echo $metin[4]?></a>
                    </form>
                    <br />
                  </div>
                  <script type="text/javascript">
  $(document).ready(function(){
    $("#form1").validate();
  });
  </script>
                  <?php
	}
	else{

	 switch($_SESSION["tur"]){
	  case '-1':$ktut=$metin[85];break;	  
	  case '0':$ktut=$metin[86];break;	  
	  case '1':$ktut=$metin[87];break;	  
	  case '2':$ktut=$metin[88];break;	  
	  default:$ktut=$metin[89];
	 } 

?>
                  <p style="text-align:left"> <?php echo $metin[7]?> , <?php echo temizle($_SESSION["userr"])." ".$ktut." "?> </p>
                  <p> <?php echo $metin[5]?> </p>
                  <p> <?php echo $metin[6]?> </p>
                  <?php
				  if($_SESSION["tur"]=='0') {
					  $siniflar = getOgrenciSiniflari();
					  if($siniflar!="")
					  echo $metin[210]." : ".$siniflar;
				  }
	}
?>
                  <p><?php echo $metin[623]?> <img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <a href="kursDetay2.php"><span><span> <?php echo $metin[461]?> </span></span></a> </p>
                </div>
                <div class="cleared"></div>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[77]?> </span> </span> </h2>
                <div class="PostContent"> <?php echo $metin[76]?> <?php echo $metin[164]?><br />
                  <?php
						 if (totalGet(0)>0){
							 echo "<strong>".$metin[8]." </strong><br/>";
							 echo totalGet(0)." (".$metin[9]." ".totalGet(1).")";
							 echo "<br /> ";
						 }
						 if (totalGet(2)>0){
							 echo "<strong>".$metin[10]." </strong><br/>";
							 echo totalGet(2)." (".$metin[49]." ".totalGet(3).")";						 
							 echo "<br /><br /> ";
						 }
						 if (sonUyeAdiGetir("ad")!=""){
						     $humanRelativeDate = new HumanRelativeDate();
							 $insansi = $humanRelativeDate->getTextForSQLDate(sonUyeAdiGetir("tarih"));
							 printf($metin[445],sonUyeAdiGetir("ad"),$insansi);
							 $uyeListesi=getUsersOnline();
							 if(!empty($uyeListesi)){
								 echo "<br/>$metin[446]<br/><strong>";
								 foreach($uyeListesi as $eleman){
									 echo $eleman." ";
									 }
								 echo "</strong>";	 
							 }
							 echo " <br />";							 
						 }
						 
						 ?>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sidebar1">
        <?php
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
	$kullaniciSecen = explode("-",ayarGetir3(RemoveXSS($_SESSION["usern"])));
?>
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
            <div class="BlockHeader">
              <div class="header-tag-icon">
                <div class="BlockHeader-text"> <?php echo $metin[153];echo " | <a href='rss.php' target='_blank' class='external'>$metin[480]</a>";?> </div>
              </div>
              <div class="l"></div>
              <div class="r">
                <div>&nbsp;</div>
              </div>
            </div>
            <div class="BlockContent">
              <div class="BlockContent-body">
                <div>
                  <ul>
                    <?php									
						if($seceneklerimiz[11]=="1" and $kullaniciSecen[11]=="1") {
										$sql1	= 	"select id from eo_webref_rss_items ORDER BY pubDate DESC LIMIT 0,".ayarGetir("ayar1int");										
										$result1= 	@mysql_query($sql1,$yol1);										
										$i=0;
										if(@mysql_numrows($result1)>0){
										while($i<@mysql_numrows($result1)) {	 
                                        ?>
                    <li>
                      <?php
												echo "<strong>",haberGetir($i,"title"),"</strong>&nbsp;";
															  						     
												$humanRelativeDate = new HumanRelativeDate();
												$insansi = $humanRelativeDate->getTextForSQLDate(haberGetir($i,"pubDate"));

												echo $insansi;                       ?>
                      <br />
                      <p> <?php echo smileAdd(haberGetir($i,"description"))?>
                        <?php
                                                              if (trim(haberGetir($i,"link"))!="")
																{
															   echo "<strong><a href='".haberGetir($i,"link")."' class='more'>";
															   echo ($metin[162]);
															   echo "</a></strong>";
															   }
                                                              ?>
                      </p>
                    </li>
                    <?php
												$i++;
												}
												
										 }
										 else
										  echo "<li>$metin[405]</li>";
						}
						else
						  echo "<li>$metin[405]</li>";
                                        ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
	
if($seceneklerimiz[12]=="1"  and $kullaniciSecen[12]=="1" and getStats(16)!="") {
?>
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
            <div class="BlockHeader">
              <div class="header-tag-icon">
                <div class="BlockHeader-text"><?php echo $metin[302]?></div>
              </div>
              <div class="l"></div>
              <div class="r">
                <div>&nbsp;</div>
              </div>
            </div>
            <div class="BlockContent">
              <div class="BlockContent-body">
                <div>
                  <div class="PostContent"> <?php echo getStats(16);?> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
}
?>
      </div>
    </div>
    <div class="cleared"></div>
    <div class="Footer">
      <div class="Footer-inner">
        <?php  						
						 require "footer.php";
                        ?>
        <div id='browserWarning'><?php echo $metin[541]?>
          <p><a href='http://getfirefox.com'><img src="img/firefox.gif" border="0" style="vertical-align: middle;" alt="FireFox" title="FireFox"/> FireFox</a> <a href='http://www.google.com/chrome'><img src="img/chrome.gif" border="0" style="vertical-align: middle;" alt="Chrome" title="Chrome"/> Chrome</a> <a href='http://www.apple.com/safari/'><img src="img/safari.gif" border="0" style="vertical-align: middle;" alt="Safari" title="Safari"/> Safari</a> <a href='http://www.microsoft.com/windows/downloads/ie/getitnow.mspx'><img src="img/ie.gif" border="0" style="vertical-align: middle;" alt="IE" title="IE"/> Internet Explorer</a></p>
          <p style="text-align:right !important"><a href='#' id='warningClose'><?php echo $metin[34]?></a></p>
        </div>
      </div>
      <div class="Footer-background"></div>
    </div>
  </div>
</div>
<div class="cleared"></div>
<script type="text/javascript">
<!--
/*if (document.getElementById("userN")!=null && document.getElementById("userN").value=="")  
   document.getElementById("userN").focus();
if (document.getElementById("userN")!=null && document.getElementById("userN").value!="")  
   document.getElementById("userP").focus();*/
if (document.getElementById("userP")!=null) 
   document.getElementById("userP").setAttribute( "autocomplete","off" );
//-->
</script>
<?php  						
 require "feedback.php"; 
?>
</body>
</html>
