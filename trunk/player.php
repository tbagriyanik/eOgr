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
	
	header("Content-Type: text/html; charset=UTF-8");

	include "conf.php";

if(!empty($_GET["id"])){
	$yol = idtoDosyaAdi(RemoveXSS($_GET["id"]));
	if(file_ext($yol)=="mp3") 
		   $provider = "so.addParam('provider','sound');";
	   else
		   $provider = "so.addParam('provider','video');";
	$yolUp = ($_uploadFolder);
	$oyna = "<script type=\"text/javascript\" src=\"lib/swfobject.js\"></script>
			<div id=\"player\">content</div>
			<script type=\"text/javascript\">
			var so = new SWFObject('$yolUp/player.swf','mpl','470','320','9');
			so.addParam('allowscriptaccess','always');
			so.addParam('allowfullscreen','true');
			so.addParam('logo','img/logo1.png');
			so.addParam('wmode','transparent');$provider
		    so.addParam('flashvars', 'file=$yol&image=img/logo1.png');
			so.write('player');
			</script>";
	echo $oyna;	
	downloadSayac(RemoveXSS($_GET["id"]));	
}
?>