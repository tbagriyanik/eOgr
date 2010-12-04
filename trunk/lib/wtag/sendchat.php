<?php
session_start();
ob_start (); // Buffer output
header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=iso-8859-9"); 

// Configuration file is required.
require_once("conf.php");

// Check if the fields are not empty
// Check if name, url or message are not longer than the maximum length allowed
// For security and spam protection reasons check if $_POST['token'] has the same value as $_SESSION['token']
if (((isset($_POST['name']))
    && (trim($_POST['name'] !== "" ))
    && (trim($_POST['name'] !== "name" ))
    && (strlen($_POST['name']) < 26))
    && ((isset($_POST['url']))
    && (strlen($_POST['url']) < 100))
    && ((isset($_POST['message']))
    && (trim($_POST['message']) !== "" )
    && (trim($_POST['message']) !== "message" )
    && (strlen($_POST['message']) < 400))
    && (isset($_SESSION['token'])
    && $_POST['token'] == $_SESSION['token'])) {

    $name = $_POST['name'];
    $url = trim($_POST['url']);

    if ((strstr($url, 'http://') && strlen($url) == 7) || $url == "") {
    
    unset($url);
   
    }
  
    $msg=$_POST['message'];
 

    // Get a sender IP (it will be in use in the next wTag version)
    $remote = $_SERVER["REMOTE_ADDR"];
    // Store it converted
    $converted_address=ip2long($remote);
	$oda=$_SESSION["oda"];
   
    $name = iconv( "UTF-8", "ISO-8859-9",temizle($name));
    $url = iconv( "UTF-8", "ISO-8859-9",temizle($url));
    $msg = iconv( "UTF-8", "ISO-8859-9",temizle($msg));

	// Insert a new message into database
  if($msg != "")
    $sql->query("INSERT INTO eo_shoutbox SET name= '$name', url='$url', message= '$msg', ip='$oda', date=now()");

    // Get the id for the last inserted message
    $lastid = $sql->get_id();
   
    // Delete oldest messages
    if ($lastid > 300) {
	
    $sql->query("DELETE FROM eo_shoutbox WHERE messageid <($lastid-20)");
    
    }

    // Retrieve last 20 messages
    $sql->query("SELECT date, name, url, message FROM eo_shoutbox WHERE messageid <= $lastid and ip='$oda' ORDER BY messageid DESC LIMIT 20");

    }

    else

    {
    // Just retrieve last 20 messages
    $sql->query("SELECT date, name, url, message FROM eo_shoutbox where ip='$oda' ORDER BY messageid DESC LIMIT 20");
       
    }


include_once("response.php");
?>