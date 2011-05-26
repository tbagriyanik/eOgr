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
<link rel="stylesheet" type="text/css" href="lib/wtag/css/main.css" />
<link rel="stylesheet" type="text/css" href="lib/wtag/css/main-style.css" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="lib/wtag/css/ie-style.css" />
<![endif]-->

<!-- 2. End Meta and links -->
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 2px;
	margin-right: 2px;
	margin-bottom: 2px;
	background-color: #FFC;
}
body, td, th {
	font-family: Lucida Console, Monaco, monospace;
	font-size: 11px;
}
h4 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
	margin:5px;
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
#whiteBoard {
	float:right;
	height: 340px;
	width: 300px;
	margin-left:5px;
	padding:0;
	bor_der:thick #F00 solid;
}
#videoChat {
	float:left;
	height: 340px;
	width: 300px;
	margin-left:5px;
	padding:0;
}
#defaultCountdown {
	float:right;
	font-family:"Courier New", Courier, monospace;
	font-size:16px;
}
#lgout {
	position:absolute;
	top:20px;
	width:auto;
	height:auto;
	z-index:1;
	left: auto;
	right: 12px;
	background-image: url(img/close.gif);
	background-repeat: no-repeat;
	background-position: 3px 3px;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 5px;
	padding-left: 24px;
	color: #000;
}
-->
</style>
</head>
<body>
<?php
  $dersVarMi = suAndaDersVarMi();
 if($dersVarMi!=false){
	 echo "<h4>$dersVarMi &nbsp;<div id=\"defaultCountdown\"></div> <a href='#' onclick='window.close();' id=\"lgout\">".$metin[34]."</a>&nbsp;</h4>";
?>
<script language="javascript" type="text/javascript" src="lib/dataFill.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/wtag/js/dom-drag.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/wtag/js/scroll.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/wtag/js/conf.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/wtag/js/ajax.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/wtag/js/drop_down.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/jquery-1.6.1.min.js"></script> 
<script language="javascript"  type="text/javascript" src="lib/jquery.countdown.js"></script> 
<script type="text/javascript">
    window.onload = maxWindow;

    function maxWindow() {
        window.moveTo(0, 0);

		var screenW = 990, screenH = 550;
		if (parseInt(navigator.appVersion)>3) {
		 screenW = screen.width;
		 screenH = screen.height;
		}
		else if (navigator.appName == "Netscape" 
			&& parseInt(navigator.appVersion)==3
			&& navigator.javaEnabled()
		   ) 
		{
		 var jToolkit = java.awt.Toolkit.getDefaultToolkit();
		 var jScreenSize = jToolkit.getScreenSize();
		 screenW = jScreenSize.width;
		 screenH = jScreenSize.height;
		}
		
		window.resizeTo(screenW,screenH);
		if (document.getElementById("whiteBoard")!=null){
			document.getElementById("whiteBoard").style.height=(screenH - 330) +"px";
			document.getElementById("whiteBoard").style.width=(screenW - 650)+"px";
		}
		startChat();
}

</script> 
<script type="text/javascript"> 
$(function () {
	var austDay;
	austDay = (parseInt($('#zaman').text())+1)*60;
	$('#defaultCountdown').countdown({until:austDay, compact: true, 
    layout: '{hnn}{sep}{mnn}{sep}{snn}',
	expiryUrl: 'chat.php'});
});
</script>
<div id="zaman" style="display:none"><?php echo suAndaDersDakika();?></div>
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
<div id="videoChat">
  <iframe id="basicEmbed" src="https://api.opentok.com/hl/embed/<?php 
echo $_videoChatURL;
?>" width="300" height="340" frameborder="0"></iframe>
</div>
<div id="whiteBoard">
  <object width="100%" height="100%">
    <param name="allowFullscreen" value="true" />
    <param name="wmode" value="transparent" />
    <param name="flashvars" value="room=<?php echo $_whiteBoardURL;?>" />
    <param name="movie" value="http://flockdraw.com/whiteboard.swf?18" />
    <embed src="http://flockdraw.com/whiteboard.swf?15" flashvars="room=<?php echo $_whiteBoardURL;?>" width="100%" height="100%" allowfullscreen="true" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
  </object>
</div>
<div style="margin:5px;clear:both;"><?php echo $metin[101];?></div>
<?php
 }else{
?>
<h3><?php echo $metin[677];?> : </h3>
<ol class="ozelli">
  <?php
	echo yaklasanEtkinlikListesi();
?>
</ol>
<h3 style="color:#808080;"><?php echo $metin[678];?> : </h3>
<font style="color:#808080;">
<ol class="ozelli">
  <?php
	echo tamamlanmisEtkinlikListesi();
?>
</ol>
</font>
<?php
 }
 echo $metin[674];
?>
</body>
</html>