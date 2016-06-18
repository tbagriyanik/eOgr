<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net

Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	header("Content-Type: text/html; charset=utf-8"); 

	ob_start (); // Buffer output
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
	 	
	require("conf.php");

		if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

if (md5($_SERVER['HTTP_USER_AGENT']) == $_SESSION['aThing']) {
    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    $par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
  
   if(temizle($_GET["sonSayfa"])>0)
	  echo trackUserLesson(getUserID($adi, $par), temizle($_GET["konuID"]), temizle($_GET["sure"]), temizle($_GET["sonSayfa"]));
	}else
	   sessionDestroy();

?>