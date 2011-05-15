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
      session_start (); 
	  ob_start();
      $_SESSION ['ready'] = TRUE; 

	  $token = md5(uniqid(rand(), true));
	  $_SESSION['token'] = $token;
	  
	require("conf.php");  	
	checkLoginLang(true,true,"chat.php");
	
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
	if($seceneklerimiz[10]!="1"){
		header("Location: error.php?error=12");
		}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>eOgr -<?php echo $metin[56]?></title>
<script language="javascript" type="text/javascript" src="lib/dataFill.js"></script>
<link rel="stylesheet" type="text/css" href="lib/wtag/css/main.css" />
<link rel="stylesheet" type="text/css" href="lib/wtag/css/main-style.css" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="lib/wtag/css/ie-style.css" />
<![endif]-->
<script language="javascript"  type="text/javascript" src="lib/wtag/js/dom-drag.js"></script>
<script language="javascript"  type="text/javascript" src="lib/wtag/js/scroll.js"></script>
<script language="javascript"  type="text/javascript" src="lib/wtag/js/conf.js"></script>
<script language="javascript"  type="text/javascript" src="lib/wtag/js/ajax.js"></script>
<script language="javascript"  type="text/javascript" src="lib/wtag/js/drop_down.js"></script>
<!-- 2. End Meta and links -->
<style type="text/css">
<!--
body {
	margin-left: 2px;
	margin-top: 2px;
	margin-right: 2px;
	margin-bottom: 2px;
	background-color: #FFF;
}
body, td, th {
	font-family: Lucida Console, Monaco, monospace;
	font-size: 11px;
}
h3 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
.ozelli {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	padding:10px;
	margin:10px;
}
a {
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
}
-->
</style>
</head>
<body>
<?php
  $dersVarMi = suAndaDersVarMi();
 if($dersVarMi!=false){
	 echo "<h4>$dersVarMi</h4>";
?>
<div id="box">
  <div id="chat">
    <div id="scrollArea">
      <div id="scroller"></div>
    </div>
    <div id="container">
      <div id='content'></div>
    </div>
    <div id='form'>
      <form id='cform' name='cform' action="#" >
        <div id='field_set'>
          <input type='hidden' id='token' name='token' value='<?php echo $token; ?>' />
          <input name='name' type='text' disabled="disabled" id='name' value='<?php echo $adi; ?>' readonly="readonly" />
          <br />
          <select id="oda" name="oda" onchange="odaSec();" style="background-color:#FFF;border:none;border-color:#FFF;height:20px;font-size:10px;margin-top:3px;">
            <option value="0" <?php 
				if(!isset($_SESSION["oda"])) $_SESSION["oda"]="0";
					if ($_SESSION["oda"]=="0") echo "selected='selected'"?>> <?php echo $metin[97]?> </option>
            <option value="1" <?php if ($_SESSION["oda"]=="1") echo "selected='selected'"?>><?php printf($metin[605],1) ?></option>
            <option value="2" <?php if ($_SESSION["oda"]=="2") echo "selected='selected'"?>><?php printf($metin[605],2) ?></option>
            <option value="3" <?php if ($_SESSION["oda"]=="3") echo "selected='selected'"?>><?php printf($metin[605],3) ?></option>
            <option value="4" <?php if ($_SESSION["oda"]=="4") echo "selected='selected'"?>><?php printf($metin[605],4) ?></option>
            <option value="5" <?php if ($_SESSION["oda"]=="5") echo "selected='selected'"?>><?php printf($metin[605],5) ?></option>
            <option value="6" <?php if ($_SESSION["oda"]=="6") echo "selected='selected'"?>><?php printf($metin[605],6) ?></option>
            <option value="7" <?php if ($_SESSION["oda"]=="7") echo "selected='selected'"?>><?php printf($metin[605],7) ?></option>
            <option value="8" <?php if ($_SESSION["oda"]=="8") echo "selected='selected'"?>><?php printf($metin[605],8) ?></option>
            <option value="9" <?php if ($_SESSION["oda"]=="9") echo "selected='selected'"?>><?php printf($metin[605],9) ?></option>
          </select>
          <input type='hidden' id='url' name='url' value='http://' />
          <textarea rows='4' cols='10' id='message'  name='message' >mesaj</textarea>
          <div id="odaMesaj"></div>
        </div>
      </form>
    </div>
    <div id="chat_menu">
      <div id='refresh'>
        <p> <?php echo $metin[99]?> </p>
      </div>
      <div id='emo'>
        <ul id="show_sm">
          <li>Smiley
            <ul id="smiley_box">
              <li> <img class='smileys' src='lib/wtag/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' onclick = "tagSmiley(':)');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' onclick = "tagSmiley(':(');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' onclick = "tagSmiley(';)');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/tongue.gif' width='15' height='15' alt=':-P' title=':-P' onclick = "tagSmiley(':-P');"/></li>
              <li> <img class='smileys' src='lib/wtag/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' onclick = "tagSmiley('S-)');"/></li>
              <li> <img class='smileys' src='lib/wtag/smileys/angry.gif' width='15' height='15' alt='](' title='](' onclick = "tagSmiley('](');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' onclick = "tagSmiley(':*)');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/grin.gif' width='15' height='15' alt=':-D' title=':-D' onclick = "tagSmiley(':-D');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/cry.gif' width='15' height='15' alt='QQ' title='QQ' onclick = "tagSmiley('QQ');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' onclick = "tagSmiley('=O');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' onclick = "tagSmiley('=/');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' onclick = "tagSmiley('8-)');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' onclick = "tagSmiley(':-X');" /></li>
              <li> <img class='smileys' src='lib/wtag/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' onclick = "tagSmiley('O:]');" /></li>
            </ul>
          </li>
        </ul>
      </div>
      <div id='submit'>
        <p> <?php echo $metin[100]?> </p>
      </div>
    </div>
  </div>
</div>
<iframe id="basicEmbed" src="<?php 
echo $_videoChatURL;
?>" width="350" height="340" style="border:none"></iframe>
<div style="margin-left:5px;clear:both;"> <?php echo $metin[101]?> </div>
<?php
 }else{
?>
<h3>Yaklaþan Son 3 Etkinlik : </h3>
<ol class="ozelli">
<?php
	echo yaklasanEtkinlikListesi();
?>
</ol>
<h3 style="color:#808080;">Tamamlanmýþ 3 Etkinlik : </h3>
<font style="text-decoration:line-through; color:#808080;">
<ol class="ozelli">
<?php
	echo tamamlanmisEtkinlikListesi();
?>
</ol>
</font>
<?php
 }
?>
<h3>Destek Programlarý : </h3>
<ul class="ozelli">
  <li><a href="http://explore.live.com/windows-live-messenger?os=other" target="_blank">Windows Live Messenger</a>, <a href="http://www.google.com/talk/" target="_blank">GTalk</a>, <a href="http://wwww.skype.com/" target="_blank">Skype</a> : Yazý, video ve ses baðlantý kurulmasý</li>
  <li><a href="http://www.teamviewer.com/" target="_blank">Teamviewer</a>, <a href="http://www.oovoo.com" target="_blank">oovoo (6 katýlýmcý)</a>, <a href="http://www.mikogo.com/" target="_blank">Mikogo (10 katýlýmcý)</a> : Masa&uuml;st&uuml; paylaþýmý</li>
  <li><a href="http://www.twiddla.com/" target="_blank">Twiddla</a>, <a href="http://www.scriblink.com/" target="_blank">scriblink (6 katýlýmcý)</a>, <a href="http://vyew.com" target="_blank">vyew (10 katýlýmcý)</a> : Beyaz tahta ve proje yönetimi</li>
</ul>
</body>
</html>