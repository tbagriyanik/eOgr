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
		 	echo "<h3>Ana sayfadasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "kursDetay.php":
		 	echo "<h3>Kurs bilgilerinizin bulunduğu sayfadasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "lessons.php":
		 	echo "<h3>Ders çalışma sayfadasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "login.php":
		 	echo "<h3>Giriş sayfadasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "userSettings.php":
		 	echo "<h3>Kullanıcı bilgilerinizin sayfadasındasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "stats.php":
		 	echo "<h3>Site istatistikleri sayfadasındasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "fileShare.php":
		 	echo "<h3>Ödev ve dosya paylaşım sayfadasındasınız.</h3>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
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
