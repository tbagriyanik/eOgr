<?php
	header("Content-Type: text/html; charset=iso-8859-9"); 

	if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
	 	
	require("conf.php");

		if (!check_source()) die ("<font id='hata'>Error!</font>");	

if (md5($_SERVER['HTTP_USER_AGENT']) == $_SESSION['aThing']) {
   	$adi	=temizle(substr($_SESSION["usern"],0,15));
   	$par	=temizle($_SESSION["userp"]);
  
   if(temizle($_GET["sonSayfa"])>0)
	  echo trackUserLesson(getUserID($adi, $par), temizle($_GET["konuID"]), temizle($_GET["sure"]), temizle($_GET["sonSayfa"]));
	}else
	   sessionDestroy();

?>