<?php
require("conf.php");  
	if (!check_source()) die ("<font id='hata'>Error! </font>");	

 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
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