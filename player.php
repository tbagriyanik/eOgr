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
	ob_start();
	session_start();
	include "conf.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>eOgr - Media Player</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>
<body>
<?php

if(!empty($_GET["id"])){
	$dosyaAdi = idtoDosyaAdi(RemoveXSS($_GET["id"]));
	$yol = ($_source1."/".$_uploadFolder."/".$dosyaAdi);
	downloadSayac(RemoveXSS($_GET["id"]));	
}else
	die("?");

	switch(file_ext($dosyaAdi)){
		case "mp3":
		case "mp4":
		case "flv":
			$oyna = "<script type=\"text/javascript\" src=\"lib/swfobject1.js\"></script>
					<div id=\"player\">eOgr</div>
					<script type=\"text/javascript\">
					var so = new SWFObject('lib/player.swf','mpl','465','320','9');
					so.addParam('allowscriptaccess','always');
					so.addParam('allowfullscreen','true');
					so.addParam('logo','img/logo1.png');
					so.addParam('wmode','transparent');$provider
					so.addParam('flashvars', 'file=$yol&amp;image=img/logo1.png');
					so.write('player');
					</script>";
			echo $oyna;	
		break;		
		case "swf":
?>
<script src="lib/swfobject_modified.js" type="text/javascript"></script>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="465" height="320" id="FlashID">
  <param name="movie" value="<?php echo $yol;?>" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  <param name="swfversion" value="6.0.65.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don't want users to see the prompt. -->
  <param name="expressinstall" value="lib/expressInstall.swf" />
  <param name="BGCOLOR" value="#FFFFFF" />
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. --> 
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="<?php echo $yol;?>" width="465" height="320">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    <param name="swfversion" value="6.0.65.0" />
    <param name="expressinstall" value="lib/expressInstall.swf" />
    <param name="BGCOLOR" value="#FFFFFF" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">
	swfobject.registerObject("FlashID");
</script>
<?php		
		break;
		case "mp3":
?>
<object type="audio/mpeg" data="<?php echo $yol;?>" width="465" height="320">
  <param name="src" value="<?php echo $yol;?>">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>
<?php
		break;		
		case "avi":
		case "asf":
		case "mp4":
		case "mpg":
		case "mpeg":
		case "mkv":
		case "wmv":
?>
<object id="MediaPlayer" width=465 height=320 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components..." type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">
  <param name="filename" value="<?php echo $yol;?>">
  <param name="Showcontrols" value="True">
  <param name="EnableFullScreenControls" value="1">
  <param name='transparentatStart' value='true'>
  <param name="autoStart" value="False">
  <embed type="application/x-mplayer2" src="<?php echo $yol;?>" width=465 height=320></embed>
</object>
<?php
		break;	
		case "mov":
		case "qt":
?>
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="465" height="320">
  <param name="src" value="<?php echo $yol;?>" />
  <param name="controller" value="true" />
  <param name="autoplay" value="false" />
  <param name="scale" value="tofit" />
  <!--[if !IE]>-->
  <object type="video/quicktime" data="<?php echo $yol;?>" 
    width="465" height="320">
    <param name="autoplay" value="false" />
    <param name="controller" value="true" />
    <param name="scale" value="tofit" />
  </object>
  <!--<![endif]-->
</object>
<?php		
		break;
		case "rm":
		case "rpm":
		case "ra":
		case "ram":
?>
<OBJECT id='rvocx' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'
        width="465" height="320">
  <param name='src' value="<?php echo $yol;?>">
  <param name='autostart' value="false">
  <param name='controls' value='ControlPanel'>
  <param name='console' value='video'>
  <param name='loop' value="false">
  <EMBED src="<?php echo $yol;?>" width="465" height="320" 
        loop="false" type='audio/x-pn-realaudio-plugin' controls='ControlPanel' console='video' autostart="false"> </EMBED>
</OBJECT>
<?php		
		break;
		case "ogg":
?>
<object type="application/ogg" data="<?php echo $yol;?>" width="465" height="320">
  <param name="src" value="<?php echo $yol;?>">
</object>
<?php		
		break;
		case "mid":
?>
<object type="audio/x-midi" data="<?php echo $yol;?>" width="465" height="320">
  <param name="src" value="<?php echo $yol;?>">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>
<?php
		break;
		case "wav":
?>
<object type="audio/x-wav" data="<?php echo $yol;?>" width="465" height="320">
  <param name="src" value="<?php echo $yol;?>">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>
<?php
		break;
		case "class":
?>
<APPLET code="<?php echo $yol;?>" width="465" height="320">
</APPLET>
<?php
		break;
	}
?>
</body>
</html>