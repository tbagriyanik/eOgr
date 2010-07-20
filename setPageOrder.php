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
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
	require("conf.php");  
	
	if (!check_source()) die ("<font id='hata'>Error! </font>");	
 
parse_str($_POST['data']);
$konusu = temizle($_SESSION['konuID']);

$action 				= $_POST['action'];
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){

	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {

		$query = "update eo_5sayfa set sayfaSirasi='".$listingCounter."' where id='".$recordIDValue. "' and konuID='".$konusu."'";
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;
	}
}

?>