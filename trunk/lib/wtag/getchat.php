<?php
session_start();
ob_start (); // Buffer output
header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/xml; charset=iso_8859-9");
//header("Content-Type: text/html; charset=iso_8859-9"); 

// Configuration file is required.
require_once("conf.php");

// Retrieve last 20 messages from database and order them in descending order 
$oda=$_SESSION["oda"];
$sql->query("SELECT date, name, url, message FROM eo_shoutbox where ip='$oda' ORDER BY messageid DESC LIMIT 20");

include_once("response.php");
?>
