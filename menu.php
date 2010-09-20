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

	$adi	=substr(@temizle($_POST["userN"]),0,15);
	$par	=sha1(substr(@temizle($_POST["userP"]),0,15));
	
   if ($adi=="") {
	   $adi	=temizle(substr($_SESSION["usern"],0,15));
	   $par	=temizle($_SESSION["userp"]);
	  }
	  
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
$kullaniciSecen = explode("-",ayarGetir3($adi));

if($seceneklerimiz[5]=="1" and $kullaniciSecen[5]=="1"){
?>
<?php
	$bilgi1 = sonTarihGetir("sohbet");
	$bilgi1 = ($bilgi1)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi2 = sonTarihGetir("yorum");
	$bilgi2 = ($bilgi2)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi3 = sonTarihGetir("oy");
	$bilgi3 = ($bilgi3)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi4 = sonTarihGetir("ders");
	$bilgi4 = ($bilgi4)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi5 = sonTarihGetir("uye");
	$bilgi5 = ($bilgi5)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi6 = sonTarihGetir("dosya");
	$bilgi6 = ($bilgi6)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi7 = sonTarihGetir("haber");
	$bilgi7 = ($bilgi7)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi8 = sonTarihGetir("islem");
	$bilgi8 = ($bilgi8)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
	$bilgi9 = sonTarihGetir("calis");
	$bilgi9 = ($bilgi9)?' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />':'';
?>
<script  type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script  type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script type="text/javascript" src="lib/as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>

<div class="aramaDiv"> <a href="index.php" target="_parent"><img src="img/home.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[54]?>" title="<?php echo $metin[54]?>" /></a>&nbsp;&nbsp;<a href="help.php" target="_blank" onclick="window.open('help.php');return false;" ><img src="img/help.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[243]?>" title="<?php echo $metin[243]?>" /></a>&nbsp;&nbsp;<a href="siteMap.php" target="_parent"><img src="img/sitemap.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[547]?>" title="<?php echo $metin[547]?>" /></a>&nbsp;&nbsp;
  <input name="searchterm" type="text" id="searchterm" size="15" maxlength="50" title="<?php echo $metin[177]?>"/>
  <img src="img/view.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[168]?>" title="<?php echo $metin[168]?>"/></div>
<script type="text/javascript">
                        var options = {
                            script:"lib/as/test.php?",
                            varname:"input",
                            json:true,
                            shownoresults:false,
                            maxresults:5,
                            callback: function (obj) { 							
								location.href = eval('\"lessons.php?konu='+obj.id+'\"');
							}
                        };
                        var as_json = new bsn.AutoSuggest('searchterm', options);                                                
                    </script>
<?php
}


	$tur=checkRealUser($adi,$par);
	if($tur=="-2") 
	{
?>
<ul class="artmenu"  style="list-style-type:none">
  <li><a href="index.php" <?php
						 if ($currentFile=="index.php") echo "class=\" active\"";
                        ?>><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a> </li>
  <li><a href="lessons.php"
						<?php
						 if ($currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> <?php echo dersAgaci()?> </li>
  <li><a href="newUser.php"
						<?php
						 if ($currentFile=="newUser.php" || $currentFile=="passwordRemember.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[149]?> </span></span></a>
    <ul>
      <li><a href="newUser.php"><span><span><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[64]?> </span></span></a></li>
      <li><a href="passwordRemember.php"><span><span> <?php echo $metin[65]?> </span></span></a></li>
    </ul>
  </li>
</ul>
<?php

}
	else
	{
?>
<ul class="artmenu">
  <li><a href="index.php" 
						<?php
						 if ($currentFile=="index.php" || $currentFile=="kursDetay.php" || $currentFile=="fileShare.php" || $currentFile=="stats.php" || $currentFile=="login.php" || $currentFile=="lessonsEdit.php"|| $currentFile=="dataWorkList.php"|| $currentFile=="dataChatActions.php"|| $currentFile=="dataRatingList.php" || $currentFile=="friends.php"|| $currentFile=="dataCommentList2.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a>
    <ul>
      <li><a href="login.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="login"/> <?php echo $metin[60]?> </span></span></a></li>
      <li><a href="kursDetay.php"><span><span> <?php echo $metin[461]?> </span></span></a></li>
      <li><a href="stats.php"><span><span> <?php echo $metin[197]?> </span></span></a></li>
      <li><a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?> </span></span></a></li>
      <li><a href="fileShare.php"><span><span> <?php echo $metin[463].$bilgi6?> </span></span></a></li>
      <?php
							 if ($tur=='2' || $tur=='1'){
                            ?>
      <li><a href="lessonsEdit.php"><span><span> <?php echo $metin[62].$bilgi4?> </span></span></a></li>
      <li><a href="dataWorkList.php"><span><span>
        <?php
				    echo $metin[185];
					$boyut=20-strlen($metin[185]);
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?>
        &#8250; </span></span></a>
        <ul>
          <li><a href="dataWorkList.php"><span><span> <?php echo $metin[186].$bilgi9?> </span></span></a></li>
          <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
          <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
          <li><a href="dataCommentList2.php"><span><span> <?php echo $metin[288].$bilgi2?> </span></span></a></li>
        </ul>
      </li>
      <?php
							 }
                            ?>
    </ul>
  </li>
  <?php
  if ($_SESSION["usern"]!="" || $_POST["userN"]!=""){
?>
  <li><a href="lessons.php"
						<?php
						 if ($currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> <?php echo dersAgaci()?> </li>
  <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1"){
	echo ("<li><a href=\"chat.php\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=310,height=330,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=no,scrollbars=0,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56].$bilgi1."</span></span></a></li>");
  }
?>
  <li><a href="userSettings.php"
						<?php
						 if ($currentFile=="userSettings.php" || $currentFile=="newUser.php" || $currentFile=="passwordRemember.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[57]?> </span></span></a> </li>
  <?php
							 if ($tur=='2'){
                            ?>
  <li><a href="siteNotices.php"
						<?php
						 if ($currentFile=="siteNotices.php" || $currentFile=="siteSettings.php" || $currentFile=="siteSettings2.php" ||  $currentFile=="siteSettings3.php" || $currentFile=="rssEdit.php" || $currentFile=="dataChatActions.php" || $currentFile=="dataActions.php" || $currentFile=="dataWorkList2.php" || $currentFile=="dataRatingList.php" || $currentFile=="dataCommentList.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[58]?> </span></span></a>
    <ul>
      <li><a href="siteNotices.php"><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[471]?> </span></span></a></li>
      <li><a href="siteSettings.php"><span><span> <?php echo $metin[472].$bilgi5?> </span></span></a></li>
      <li><a href="siteSettings2.php"><span><span><img src="img/database.gif" border="0" style="vertical-align: middle;" alt="install"/> <?php echo $metin[156]?> </span></span></a></li>
      <li><a href="siteSettings3.php"><span><span> <?php echo $metin[112]?> </span></span></a></li>
      <li><a href="rssEdit.php"><span><span> <?php echo $metin[70].$bilgi7?> </span></span></a></li>
      <?php
	   if (file_exists("install.php")){
	  ?>
      <li><a href="install.php"><span><span> <?php echo $metin[71]?> </span></span></a></li>
      <?php
	   }
	  ?>
      <li><a href="dataActions.php"><span><span>
        <?php
				    echo $metin[185];
					$boyut=20-strlen($metin[185]);
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?>
        &#8250; </span></span></a>
        <ul>
          <li><a href="dataActions.php"><span><span> <?php echo $metin[66].$bilgi8?> </span></span></a></li>
          <li><a href="dataWorkList2.php"><span><span> <?php echo $metin[186].$bilgi9?> </span></span></a></li>
          <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
          <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
          <li><a href="dataCommentList.php"><span><span> <?php echo $metin[288].$bilgi2?> </span></span></a></li>
        </ul>
      </li>
    </ul>
  </li>
  <?php
							 }
                            ?>
  <li><a href="index.php?logout=1"><span><span><img src="img/logout.png" border="0" style="vertical-align: middle;" alt="logout"/>
    <?php if (!empty($adi)) echo temizle($adi)." "; ?>
    <?php echo $metin[59]?> </span></span></a></li>
  <?php
	 if (!empty($_COOKIE["remUser"])){
    ?>
  <ul>
    <li> <a href="index.php?forgetMe=1"><span><span><?php echo $metin[196]?></span></span></a> </li>
  </ul>
  <?php
	}
    ?>
  </li>
  <?php
  }
?>
</ul>
<?php
	}
?>
