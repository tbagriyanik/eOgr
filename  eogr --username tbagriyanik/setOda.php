<?php
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
		echo "Form Error!";
}else 	  
 sessionDestroy();

?>