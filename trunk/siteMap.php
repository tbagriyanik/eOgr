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
  checkLoginLang(false,true,"siteMap.php");	   

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
<title>eOgr -<?php echo $metin[547]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<link href="lib/tlogin/css/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />

<script type="text/javascript" src="lib/script.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script src="lib/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.underShadow1 {
	background:#fff;
	opacity:0.5;
	filter:alpha(opacity=50);
	position:absolute;
	top:20px;
	left:220px;
	min-width:73%;
	min-height:80%;
	z-index:1000;
}
.underShadow2 {
	background:#fff;
	opacity:0.5;
	filter:alpha(opacity=50);
	position:absolute;
	top:20px;
	left:420px;
	min-width:50%;
	min-height:80%;
	z-index:1000;
}
.underShadow3 {
	background:#fff;
	opacity:0.5;
	filter:alpha(opacity=50);
	position:absolute;
	top:20px;
	left:620px;
	min-width:25%;
	min-height:80%;
	z-index:1000;
}
.underShadow4 {
	display:none;
}
</style>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[547]?> </span> </h2>
                <div class="PostContent">
                  <div id="contact-wrapper">
                    <?php
	$imge =  ' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />';
	$bilgi1 = sonTarihGetir("sohbet");
	$bilgi1 = ($bilgi1)?$imge:'';
	$bilgi2 = sonTarihGetir("yorum");
	$bilgi2 = ($bilgi2)?$imge:'';
	$bilgi3 = sonTarihGetir("oy");
	$bilgi3 = ($bilgi3)?$imge:'';
	$bilgi4 = sonTarihGetir("ders");
	$bilgi4 = ($bilgi4)?$imge:'';
	$bilgi5 = sonTarihGetir("uye");
	$bilgi5 = ($bilgi5)?$imge:'';
	$bilgi6 = sonTarihGetir("dosya");
	$bilgi6 = ($bilgi6)?$imge:'';
	$bilgi7 = sonTarihGetir("haber");
	$bilgi7 = ($bilgi7)?$imge:'';
	$bilgi8 = sonTarihGetir("islem");
	$bilgi8 = ($bilgi8)?$imge:'';
	$bilgi9 = sonTarihGetir("calis");
	$bilgi9 = ($bilgi9)?$imge:'';
	$bilgi10 = sonTarihGetir("arkadas");
	$bilgi10 = ($bilgi10)?$imge:'';
	$bilgi11 = sonTarihGetir("soru");
	$bilgi11 = ($bilgi11)?$imge:'';
?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td valign="top" style="background-color:#FFF !important"><ul>
                            <li><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="<?php echo $metin[551]?>"/> <?php echo $metin[551]?>
                              <ul style="list-style:none">
                                <li><a href="index.php"><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?></a> </li>
                                <li><a href="lessons.php"><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> </li>
                                <li><a href="newUser.php"><span><span><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[64]?> </span></span></a></li>
                                <li><a href="passwordRemember.php"><span><span> <?php echo $metin[65]?> </span></span></a></li>
                                <li><a href="kursDetay2.php"><img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <span><span> <?php echo $metin[461]?> </span></span></a></li>
                                <li><a href="rss.php"><span><span> <?php echo $metin[153].$bilgi7?></span></span></a></li>
                                <li> <a href="help.php" target="_blank" onclick="window.open('help.php');return false;" ><img src="img/help.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[243]?>" title="<?php echo $metin[243]?>" /> <?php echo $metin[243]?></a></li>
                                <li><a href="siteMap.php"><span><span><img src="img/sitemap.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[547]?>" title="<?php echo $metin[547]?>" /> <?php echo $metin[547]?></span></span></a></li>
                              </ul>
                          </ul>
                          <br /></td>
                        <td valign="top" style="background-color:#FFF !important;" ><p class="underShadow<?php
						switch($tur){
							case "-1":
							echo "1";
							break;
							case "0":
							echo "2";
							break;
							case "1":
							echo "3";
							break;
							case "2":
							echo "4";
							break;
							default:
							echo "1";
							break;
						}
                        ?>">
                          
                          <ul style="list-style:none">
                            <li><img src="img/ogr_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[94]?>"/> <?php echo $metin[94]?>
                              <ul style="list-style:none">
                                <li><a href="login.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="login"/> <?php echo $metin[60]?></span></span></a></li>
                                <li><a href="kursDetay.php"><img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <span><span> <?php echo $metin[461]?></span></span></a></li>
                                <li><a href="stats.php"><span><span> <?php echo $metin[197]?></span></span></a></li>
                                <li><a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?></span></span></a></li>
                                <li><a href="fileShare.php"><span><span> <?php echo $metin[463].$bilgi6?></span></span></a></li>
                                <li><a href="askQuestion.php"><span><span><img src="img/question.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[628]?>"/> <?php echo $metin[628].$bilgi11?> </span></span></a></li>
                                <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1"){
	echo ("<li><a href=\"chat.php\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=310,height=330,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=no,scrollbars=0,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56].$bilgi1."</span></span></a></li>");
  }
?>
                                <li><a href="userSettings.php"><span><span><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[57]?> </span></span></a> </li>
                              </ul>
                            </li>
                          </ul>
                          </p></td>
                        <td valign="top" style="background-color:#FFF !important"><ul style="list-style:none">
                            <li><img src="img/ogrt_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[95]?>"/> <?php echo $metin[95]?>
                              <ul style="list-style:none">
                                <li><a href="lessonsEdit.php"><span><span> <?php echo $metin[62].$bilgi4?></span></span></a></li>
                                <li><?php echo $metin[185];?>
                                  <ul style="list-style:none">
                                    <li><a href="dataWorkList.php"><span><span> <?php echo $metin[186].$bilgi9?></span></span></a></li>
                                    <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
                                    <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
                                    <li><a href="dataCommentList2.php"><span><span> <?php echo $metin[288].$bilgi2?></span></span></a></li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                          </ul></td>
                        <td valign="top" style="background-color:#FFF !important"><ul style="list-style:none">
                            <li><img src="img/admin_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[96]?>"/> <?php echo $metin[96]?>
                              <ul style="list-style:none">
                                <li><a href="siteNotices.php"><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[471]?> </span></span></a></li>
                                <li><a href="siteSettings.php"><span><span> <?php echo $metin[472].$bilgi5?> </span></span></a></li>
                                <li><a href="siteSettings2.php"><span><span><img src="img/database.gif" border="0" style="vertical-align: middle;" alt="install"/> <?php echo $metin[156]?> </span></span></a></li>
                                <li><a href="siteSettings3.php"><span><span> <?php echo $metin[112]?> </span></span></a></li>
                                <li><a href="rssEdit.php"><span><span> <?php echo $metin[70].$bilgi7?> </span></span></a> </li>
                                <li><?php echo $metin[185];?>
                                  <ul style="list-style:none">
                                    <li><a href="dataActions.php"><span><span> <?php echo $metin[66].$bilgi8?> </span></span></a></li>
                                    <li><a href="dataWorkList2.php"><span><span> <?php echo $metin[186].$bilgi9?> </span></span></a></li>
                                    <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
                                    <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
                                    <li><a href="dataCommentList.php"><span><span> <?php echo $metin[288].$bilgi2?></span></span></a></li>
                                    <li><a href="dataFriendActions.php"><span><span> <?php echo $metin[594].$bilgi10?></span></span></a></li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                          </ul></td>
                      </tr>
                      <tr>
                        <td colspan="4">&nbsp;&nbsp;<img src="img/imp.gif" border="0" style="vertical-align: middle;" alt="new" /> <?php echo $metin[550]?></td>
                      </tr>
                    </table>
                  </div>
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
