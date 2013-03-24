<?php
$xml = '<?xml version="1.0"?>';
$xml .= '<root>';

while ($row=$sql->fetch_row()) {

$date = $row['date'];
$name = $row['name'];
$url = $row['url'];
$message = $row['message'];

$name = htmlentities(iconv( "ISO-8859-9","UTF-8", $name));
$url = htmlentities($url);
$message = htmlentities( iconv( "ISO-8859-9","UTF-8", $message));
if(empty($message)) continue;
$xml .= '<msg>';
$xml .= '<date>' . $date . '</date>';
$xml .= '<name>' . $name . '</name>';
$xml .= '<url>' . $url . '</url>';
$xml .= '<message>' . $message. '</message>';

$xml .= '</msg>';
  
}

$xml .= '</root>';
echo $xml;
?>