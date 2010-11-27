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
<script type="text/javascript" src="lib/swfobject2.js"></script>
<script type="text/javascript">
	swfobject.registerObject("myId", "9.0.0");
</script>
<style type="text/css" media="screen">
    object { display:block; }
</style>
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
<div>
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="myId" width="470" height="320" id="myId">
    <param name="movie" value="uploads/player.swf" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="uploads/player.swf" width="470" height="320">
      <!--<![endif]-->
      <div>
        <h1>Alternative content</h1>
        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
      </div>
	<param name="flashvars" value="file=<?php echo $yol;?>&amp;screencolor=ffffff">
	<param name="BGCOLOR" value="#FFFFFF" />
	<param name="wmode" value="transparent" />
      <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
  </object>
  
</div>
</body>
</html>