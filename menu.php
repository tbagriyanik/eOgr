<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net

Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/

	$adi	=substr(@temizle($_POST["userN"]),0,15);
	$par	=sha1(substr(@temizle($_POST["userP"]),0,15));	
	
   if ($adi=="" && isset($_SESSION["usern"])) {
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
	  }
	  
	$tur=checkRealUser($adi,$par);  
	
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
$kullaniciSecen = explode("-",ayarGetir3($adi));

$remUser = false;
if (isset($_COOKIE["remUser"]))
  if (strlen($_COOKIE["remUser"])>0){
   $remUser = true;
  } 

$bilgi1 = "";$bilgi5 = "";$bilgi9 = "";
$bilgi2 = "";$bilgi6 = "";$bilgi10 = "";
$bilgi3 = "";$bilgi7 = "";$bilgi11 = "";
$bilgi4 = "";$bilgi8 = "";
?>
<script type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script type="text/javascript" src="lib/jquery.easing.1.2.js"></script>
<script type="text/javascript" src="lib/as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>

<nav  class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true" title="<?php echo $metin[54]?>"></span> <?php echo ayarGetir("okulGenelAdi")?></a> </div>
    <?php
if($seceneklerimiz[5]=="1" and $kullaniciSecen[5]=="1"){
	$imge1 =  ' <img src="img/imp_1.gif" border="0" style="vertical-align: baseline;" alt="new" />';
	$imge2 =  ' <img src="img/imp_2.gif" border="0" style="vertical-align: baseline;" alt="newish" />';
	$imge3 =  ' <img src="img/imp_3.gif" border="0" style="vertical-align: baseline;" alt="not so new" />';

		if(sonTarihGetir("sohbet",0))
		  	$bilgi1 = $imge1;
		elseif(sonTarihGetir("sohbet",1))
			$bilgi1 = $imge2;  
		elseif(sonTarihGetir("sohbet",2))
			$bilgi1 = $imge3;  
		else
			$bilgi1 = "";

		if(sonTarihGetir("yorum",0))
		  	$bilgi2 = $imge1;
		elseif(sonTarihGetir("yorum",1))
			$bilgi2 = $imge2;  
		elseif(sonTarihGetir("yorum",2))
			$bilgi2 = $imge3;  
		else
			$bilgi2 = "";

		if(sonTarihGetir("oy",0))
		  	$bilgi3 = $imge1;
		elseif(sonTarihGetir("oy",1))
			$bilgi3 = $imge2;  
		elseif(sonTarihGetir("oy",2))
			$bilgi3 = $imge3;  
		else
			$bilgi3 = "";

		if(sonTarihGetir("ders",0))
		  	$bilgi4 = $imge1;
		elseif(sonTarihGetir("ders",1))
			$bilgi4 = $imge2;  
		elseif(sonTarihGetir("ders",2))
			$bilgi4 = $imge3;  
		else
			$bilgi4 = "";

		if(sonTarihGetir("uye",0))
		  	$bilgi5 = $imge1;
		elseif(sonTarihGetir("uye",1))
			$bilgi5 = $imge2;  
		elseif(sonTarihGetir("uye",2))
			$bilgi5 = $imge3;  
		else
			$bilgi5 = "";

		if(sonTarihGetir("dosya",0))
		  	$bilgi6 = $imge1;
		elseif(sonTarihGetir("dosya",1))
			$bilgi6 = $imge2;  
		elseif(sonTarihGetir("dosya",2))
			$bilgi6 = $imge3;  
		else
			$bilgi6 = "";

		if(sonTarihGetir("haber",0))
		  	$bilgi7 = $imge1;
		elseif(sonTarihGetir("haber",1))
			$bilgi7 = $imge2;  
		elseif(sonTarihGetir("haber",2))
			$bilgi7 = $imge3;  
		else
			$bilgi7 = "";

		if(sonTarihGetir("islem",0))
		  	$bilgi8 = $imge1;
		elseif(sonTarihGetir("islem",1))
			$bilgi8 = $imge2;  
		elseif(sonTarihGetir("islem",2))
			$bilgi8 = $imge3;  
		else
			$bilgi8 = "";

		if(sonTarihGetir("calis",0))
		  	$bilgi9 = $imge1;
		elseif(sonTarihGetir("calis",1))
			$bilgi9 = $imge2;  
		elseif(sonTarihGetir("calis",2))
			$bilgi9 = $imge3;  
		else
			$bilgi9 = "";

		if(sonTarihGetir("arkadas",0))
		  	$bilgi10 = $imge1;
		elseif(sonTarihGetir("arkadas",1))
			$bilgi10 = $imge2;  
		elseif(sonTarihGetir("arkadas",2))
			$bilgi10 = $imge3;  
		else
			$bilgi10 = "";

		if(sonTarihGetir("soru",0))
		  	$bilgi11 = $imge1;
		elseif(sonTarihGetir("soru",1))
			$bilgi11 = $imge2;  
		elseif(sonTarihGetir("soru",2))
			$bilgi11 = $imge3;  
		else
			$bilgi11 = "";
?>
    <div id="navbar1" class="navbar-collapse collapse">
      <div class="navbar-text navbar-right" style="margin:0 !important">
        <?php 
	 if($tur=="-2"){
	?>
        <a href="login.php" class="btn btn-info btn-xs"><?php echo $metin[2];?></a>
        <?php }?>
        <a href="help.php" target="_blank" onclick="window.open('help.php');return false;" ><span class="glyphicon glyphicon-info-sign breadcrumb" aria-hidden="true" style="margin-top:5px !important;" title="<?php echo $metin[243]?>"></span></a>&nbsp;<a href="siteMap.php" target="_parent"><span class="glyphicon glyphicon-map-marker breadcrumb" aria-hidden="true" style="margin-top:5px !important;" title="<?php echo $metin[547]?>"></span></a>&nbsp;&nbsp;
        <input name="searchterm" type="text" id="searchterm" size="15" maxlength="50" title="<?php echo $metin[177]?>" style="height:20px;font-size:12px;"/>
      </div>
      <script type="text/javascript">
                        var options = {
                            script:"getLesson.php?",
                            varname:"input",
                            json:true,
                            shownoresults:false,
                            maxresults:5,
                            callback: function (obj) { 	
								document.location.href = eval('\"lessons.php?konu='+obj.id+'\"');
							}
                        };
                        var as_json = new bsn.AutoSuggest('searchterm', options);                                                
                    </script>
      <?php
}
	if($tur=="-2") 
	{
?>
      <ul class="nav navbar-nav">
        <li><a href="index.php" <?php
						 if ($currentFile=="index.php") echo "class=\" active\"";
                        ?>><?php echo $metin[54]?> </a> </li>
        <li><a href="lessonsList.php"
						<?php
						 if ($currentFile=="lessonsList.php" or $currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </a>
          <?php //echo dersAgaci()?>
        </li>
        <li><a href="newUser.php"><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[64]?> </a></li>
        <li><a href="passwordRemember.php"> <?php echo $metin[65]?> </a></li>
      </ul>
      <?php

}
	else
	{
?>
      <ul class="nav navbar-nav">
        <li class="dropdown"><a href="index.php"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
						<?php
						 if ($currentFile=="index.php" || $currentFile=="kursDetay.php" || $currentFile=="fileShare.php" || $currentFile=="stats.php" || $currentFile=="login.php" || $currentFile=="lessonsEdit.php"|| $currentFile=="dataWorkList.php"|| $currentFile=="dataChatActions.php"|| $currentFile=="dataRatingList.php" || $currentFile=="friends.php"|| $currentFile=="dataCommentList2.php"|| $currentFile=="askQuestion.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><?php echo $metin[54]?> </span></span><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="login.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="login"/> <?php echo $metin[60]?> </span></span></a></li>
            <li><a href="kursDetay.php"><span><span><img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <?php echo $metin[461]?> </span></span></a></li>
            <li><a href="stats.php"><span><span> <?php echo $metin[197]?> </span></span></a></li>
            <li><a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?> </span></span></a></li>
            <li><a href="fileShare.php"><span><span> <?php echo $metin[463].$bilgi6?> </span></span></a></li>
            <li><a href="askQuestion.php"><span><span><span class="glyphicon glyphicon-question-sign" aria-hidden="true" title="<?php echo $metin[628]?>"></span> <?php echo $metin[628].$bilgi11?> </span></span></a></li>
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
              <ul >
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
        <li><a href="lessonsList.php"
						<?php
						 if ($currentFile=="lessonsList.php" or $currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a>
          <?php // echo dersAgaci()?>
        </li>
        <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1" and yaklasanEtkinlikListesi()!=""){
	echo ("<li><a href=\"#\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=590,height=400,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=yes,scrollbars=yes,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56].$bilgi1."</span></span></a></li>");
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
        <li class="dropdown"><a href="siteNotices.php"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
						<?php
						 if ($currentFile=="siteNotices.php" || $currentFile=="siteSettings.php" || $currentFile=="siteSettings2.php" ||  $currentFile=="siteSettings3.php" || $currentFile=="rssEdit.php" || $currentFile=="dataChatActions.php" || $currentFile=="dataFriendActions.php" || $currentFile=="dataActions.php" || $currentFile=="dataWorkList2.php" || $currentFile=="dataRatingList.php" || $currentFile=="dataCommentList.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[58]?> </span></span><span class="caret"></span></a>
          <ul class="dropdown-menu">
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
                <li><a href="dataFriendActions.php"><span><span> <?php echo $metin[594].$bilgi10?> </span></span></a></li>
              </ul>
            </li>
          </ul>
        </li>
        <?php
							 }
                            ?>
        <li><a href="index.php?logout=1"><span><span><img src="img/logout.png" border="0" style="vertical-align: middle;" alt="logout"/>
          <?php if (!empty($adi)) echo temizle($adi)." "; ?>
          <?php echo $metin[59]?> </span></span></a>
          <?php
	 if ($remUser){
    ?>
          <ul>
            <li> <a href="index.php?forgetMe=1"><span><span><?php echo $metin[196]?></span></span></a> </li>
          </ul>
          <?php
	}
    ?>
          <?php
  }
?>
        </li>
      </ul>
      <?php
	}	
?>
    </div>
  </div>
</nav>
