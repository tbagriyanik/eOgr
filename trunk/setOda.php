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
	header("Content-Type: text/html; charset=iso-8859-9"); 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
if (md5($_SERVER['HTTP_USER_AGENT']) == $_SESSION['aThing']) {
	$_SESSION["oda"]= $_POST['oda'];
	if(isset($_POST['oda']))
		echo iconv( "ISO-8859-9","UTF-8", "Oda degistirildi...");
		else
		echo "";
}else 	  
 sessionDestroy();

?>