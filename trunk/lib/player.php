<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://www.tuzlaatl.k12.tr/eogr
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

	include "../conf.php";

if(!empty($_GET["id"])){
	$yol = $_source1."/".$_uploadFolder."/".idtoDosyaAdi(RemoveXSS($_SESSION["id"])); 
	$oyna = "<script type=\"text/javascript\" src=\"../lib/swfobject.js\"></script>
			<div id=\"player\">content</div>
			<script type=\"text/javascript\">
			var so = new SWFObject('../lib/player.swf','mpl','470','320','9');
			so.addParam('allowscriptaccess','always');
			so.addParam('allowfullscreen','true');
			so.addParam('logo','../img/logo1.png');
			  so.addVariable('backcolor','CCCCCC');
			  so.addVariable('frontcolor','000000');
			  so.addVariable('lightcolor','000000');
			  so.addVariable('screencolor','0000FF');
			  so.addParam('flashvars', 'file=$yol&image=../img/logo1.png');
			so.write('player');
			</script>";
	echo $oyna;
	echo "<br/>Kod:<textarea cols=80 rows=8>$oyna</textarea>";		
}
?>