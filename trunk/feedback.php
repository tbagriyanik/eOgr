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
		 	echo "<p>Ana sayfadasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriþ sayfasýna gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "kursDetay.php":
		 	echo "<p>Kurs bilgilerinizin bulunduðu sayfadasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriþ sayfasýna gidebilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "lessons.php":
		 	echo "<p>Ders çalýþma sayfadasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriþ sayfasýna gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "login.php":
		 	echo "<p>Giriþ sayfadasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "userSettings.php":
		 	echo "<p>Kullanýcý bilgilerinizin bulunduðu sayfadasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "stats.php":
		 	echo "<p>Site istatistikleri sayfadasýndasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaþabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
		break;
		case "fileShare.php":
		 	echo "<p>Ödev ve dosya paylaþým sayfadasýndasýnýz.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			Ýsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalýþabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanýcý bilgilerinizi deðiþtirebilirsiniz</a></li>";
		 	echo "</ul> Baþarýlar Dileriz!";
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
