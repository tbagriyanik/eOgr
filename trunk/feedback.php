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
		 	echo "<p>Ana sayfadasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "kursDetay.php":
		 	echo "<p>Kurs bilgilerinizin bulunduğu sayfadasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "lessons.php":
		 	echo "<p>Ders çalışma sayfadasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='login.php'>Giriş sayfasına gidebilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "login.php":
		 	echo "<p>Giriş sayfadasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "userSettings.php":
		 	echo "<p>Kullanıcı bilgilerinizin bulunduğu sayfadasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "stats.php":
		 	echo "<p>Site istatistikleri sayfadasındasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "fileShare.php":
		 	echo "<p>Ödev ve dosya paylaşım sayfadasındasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='friends.php'>Arkadaşlarınızı görebilirsiniz</a></li>";
		 	echo "<li><a href='userSettings.php'>Kullanıcı bilgilerinizi değiştirebilirsiniz</a></li>";
		 	echo "</ul> Başarılar Dileriz!";
		break;
		case "friends.php":
		 	echo "<p>Ödev ve dosya paylaşım sayfadasındasınız.</p>";
		 	echo "<img src=\"img/passwRenew.gif\" border=\"0\" style=\"vertical-align:middle\" alt='info'/> 
			İsterseniz : <ul>";
		 	echo "<li><a href='index.php'>Ana sayfaya dönebilirsiniz</a></li>";
		 	echo "<li><a href='lessons.php'>Ders çalışabilirsiniz</a></li>";
		 	echo "<li><a href='kursDetay.php'>Kurs durumunuza bakabilirsiniz</a></li>";
		 	echo "<li><a href='stats.php'>Site istatistiklerine bakabilirsiniz</a></li>";
		 	echo "<li><a href='fileShare.php'>Dosya paylaşabilirsiniz</a></li>";
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
