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
 $adi	=(substr($_SESSION["usern"],0,15));
 $par	=($_SESSION["userp"]);
 if(!($adi=="" or $par=="")) {
?>

<div id="containerFB">
  <div class="panelFB">
    <?php
	$sayfa = basename($_SERVER["PHP_SELF"]);
	switch ($sayfa){
		case "index.php":
		 	echo "<p>Ana sayfadas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giri� sayfas�na gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "kursDetay.php":
		 	echo "<p>Kurs bilgilerinizin bulundu�u sayfadas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giri� sayfas�na gidebilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "lessons.php":
		 	echo "<p>Ders �al��ma sayfadas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya d�nebilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giri� sayfas�na gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "login.php":
		 	echo "<p>Giri� sayfadas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya d�nebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "userSettings.php":
		 	echo "<p>Kullan�c� bilgilerinizin bulundu�u sayfadas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya d�nebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "stats.php":
		 	echo "<p>Site istatistikleri sayfadas�ndas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya d�nebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya payla�abilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
		break;
		case "fileShare.php":
		 	echo "<p>�dev ve dosya payla��m sayfadas�ndas�n�z.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			�sterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya d�nebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders �al��abilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullan�c� bilgilerinizi de�i�tirebilirsiniz</a></li>";
		 	echo "</ul> Ba�ar�lar Dileriz!";
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
