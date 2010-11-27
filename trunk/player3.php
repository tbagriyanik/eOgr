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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>SWFObject</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>
<body>
<?php
	include "conf.php";

if(!empty($_GET["id"])){
	$yol = idtoDosyaAdi(RemoveXSS($_GET["id"]));
	$yol = ($_uploadFolder."/".$yol);
//	echo $oyna;	
	downloadSayac(RemoveXSS($_GET["id"]));	
}
?>
<object id="MediaPlayer" width=470 height=320 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components..." type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">
<param name="filename" value="<?php echo $yol;?>">
<param name="Showcontrols" value="True">
<param name="EnableFullScreenControls" value="1">
<param name='transparentatStart' value='true'>
<param name="autoStart" value="False">
<embed type="application/x-mplayer2" src="<?php echo $yol;?>" width=470 height=320></embed>
</object>
</body>
</html>