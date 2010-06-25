<?php
	header("Content-Type: application/rss+xml; charset=ISO-8859-9");
	include("lib/RSS.class.php");
	$rss = new RSS();
	echo $rss->GetFeed();
?>