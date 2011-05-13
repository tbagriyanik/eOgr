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
$_host 			= 'localhost';
$_password 		= ''; 
$_username 		= 'root'; 
$_db 			= 'eogr'; 

$_source1		= "http://localhost/eogr";		//for check_source()
$_source2		= "http://127.0.0.1/eogr";		//MUST set to the exact values!

$_uploadFolder	= "uploads";						
//766 or 777 permission needs this folder, NOT obligatory!

$_siteUnlockPwd	= "11111";							
//when the site maintenance is engaged, this password is needed to REOPEN the site

$_defaultTheme 	= "silverModern";
//what will be the default THEME... simple, silverModern, darkOrange, lightGreen

$_defaultLang 	= "TR";
//what will be the default LANGUAGE... TR:turkish, EN:english

$_filesToPlay	= array("flv","swf","mp3","avi","mp4","wmv","mov","rm","ra","rpm","ram","asf","mpg","mpeg","mkv","ogg","qt","wav","mid","pdf");
//what FILE TYPES suitable to be played 

$_fileMaxUploadSize = 10;
//if upload is enabled, the file size LIMIT in Mega Bytes
?>
