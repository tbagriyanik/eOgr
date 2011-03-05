<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
 if(isset($_SESSION["usern"])){
	 $adi	=(substr($_SESSION["usern"],0,15));
	 $par	=($_SESSION["userp"]);
 }
 if(!($adi=="" or $par=="")) {
?>
<div id="containerFB">
  <div class="panelFB">
    <?php
	$sayfa = basename($_SERVER["PHP_SELF"]);
	switch ($sayfa){
		case "index.php":
		 	echo "<p>$metin[566]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='login.php'>$metin[569]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[570]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "kursDetay.php":
		 	echo "<p>$metin[565]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='login.php'>$metin[569]</a></li>";
		 	echo "<li><a href='stats.php'>$metin[576]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "lessonsList.php":
		case "lessons.php":
		 	echo "<p>$metin[564]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='login.php'>$metin[569]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "login.php":
		 	echo "<p>$metin[563]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "userSettings.php":
		 	echo "<p>$metin[562]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='stats.php'>$metin[576]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "stats.php":
		 	echo "<p>$metin[561]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "fileShare.php":
		 	echo "<p>$metin[560]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='stats.php'>$metin[576]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "friends.php":
		 	echo "<p>$metin[559]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='stats.php'>$metin[576]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='askQuestion.php'>$metin[643]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		case "askQuestion.php":
		 	echo "<p>$metin[642]</p>";
		 	echo "<img src=\"img/help.png\" border=\"0\" style=\"vertical-align:top\" alt='info'/> 
			$metin[567] <ul>";
		 	echo "<li><a href='index.php'>$metin[574]</a></li>";
		 	echo "<li><a href='lessonsList.php'>$metin[568]</a></li>";
		 	echo "<li><a href='kursDetay.php'>$metin[575]</a></li>";
		 	echo "<li><a href='stats.php'>$metin[576]</a></li>";
		 	echo "<li><a href='friends.php'>$metin[571]</a></li>";
		 	echo "<li><a href='fileShare.php'>$metin[572]</a></li>";
		 	echo "<li><a href='userSettings.php'>$metin[573]</a></li>";
		 	echo "</ul> $metin[558]";
		break;
		default:
			echo $metin[444];
	}
    ?>
    <div style="clear:both;"></div>
  </div>
</div>
<a class="triggerFB" href="#">&nbsp;</a> 
<script type="text/javascript">
    $(document).ready(function($) { 
	$(".triggerFB").click(function(){
		$(".panelFB").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
  });
</script>
<?php
 }
?>
<!--
<div id="banner" style="position:fixed;" >
  <div style="text-align:left;display:inline-table;border:none;height:400px;margin:0;padding:0;position:relative;visibility:visible;width:120px"><a href="index.php"><img src="img/reklam.png" border="0" /></a></div>
</div>
-->  