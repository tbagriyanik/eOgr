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

	$adi	=substr(@temizle($_POST["userN"]),0,15);
	$par	=sha1(substr(@temizle($_POST["userP"]),0,15));
	
   if ($adi=="" && isset($_SESSION["usern"])) {
	    $adi	=temizle(substr((isset($_SESSION["usern"]))?$_SESSION["usern"]:"",0,15));
    	$par	=temizle((isset($_SESSION["userp"]))?$_SESSION["userp"]:"");
	  }
	  
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
$bilgi4 = "";$bilgi8 = "";$bilgi12 = "";
?>
<script type="text/javascript" src="lib/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script type="text/javascript" src="lib/jquery.easing.1.2.js"></script>
<script type="text/javascript" src="lib/as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
<?php
if($seceneklerimiz[5]=="1" and $kullaniciSecen[5]=="1"){
	$imge =  ' <img src="img/imp.gif" border="0" style="vertical-align: baseline;" alt="new" />';
	$bilgi1 = sonTarihGetir("sohbet");
	$bilgi1 = ($bilgi1)?$imge:'';
	$bilgi2 = sonTarihGetir("yorum");
	$bilgi2 = ($bilgi2)?$imge:'';
	$bilgi3 = sonTarihGetir("oy");
	$bilgi3 = ($bilgi3)?$imge:'';
	$bilgi4 = sonTarihGetir("ders");
	$bilgi4 = ($bilgi4)?$imge:'';
	$bilgi5 = sonTarihGetir("uye");
	$bilgi5 = ($bilgi5)?$imge:'';
	$bilgi6 = sonTarihGetir("dosya");
	$bilgi6 = ($bilgi6)?$imge:'';
	$bilgi7 = sonTarihGetir("haber");
	$bilgi7 = ($bilgi7)?$imge:'';
	$bilgi8 = sonTarihGetir("islem");
	$bilgi8 = ($bilgi8)?$imge:'';
	$bilgi9 = sonTarihGetir("calis");
	$bilgi9 = ($bilgi9)?$imge:'';
	$bilgi10 = sonTarihGetir("arkadas");
	$bilgi10 = ($bilgi10)?$imge:'';
	$bilgi11 = sonTarihGetir("soru");
	$bilgi11 = ($bilgi11)?$imge:'';
?>

<div class="aramaDiv"> <a href="index.php" target="_parent"><img src="img/home.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[54]?>" title="<?php echo $metin[54]?>" /></a>&nbsp;&nbsp;<a href="help.php" target="_blank" onclick="window.open('help.php');return false;" ><img src="img/help.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[243]?>" title="<?php echo $metin[243]?>" /></a>&nbsp;&nbsp;<a href="siteMap.php" target="_parent"><img src="img/sitemap.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[547]?>" title="<?php echo $metin[547]?>" /></a>&nbsp;&nbsp;
  <input name="searchterm" type="text" id="searchterm" size="15" maxlength="50" title="<?php echo $metin[177]?>"/>
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


	$tur=checkRealUser($adi,$par);
	if($tur=="-2") 
	{
?>
<script type="text/javascript" src="lib/tlogin/twitterLogin.js"></script> 
<script type="text/javascript" src="lib/jquery.validate.min.js"></script> 
<script type="text/javascript">
$().ready(function() {
	
	/*$(function(){
    $('#userN, #userP').keydown(function(e){
        if (e.keyCode == 13) {
            $('#formLogin').submit();
            return false;
        	}
    	});
	});*/

			$(window).scroll(function() {
				$("#loginForm").fadeOut(100);
				$("#loginButton a").removeClass("active");
			});

	$("#formLogin").validate({
		rules: {
			userN: {
				required: true,
				minlength: 5,
				maxlength: 15
			},
			userP: {
				required: true,
				minlength: 5,
				maxlength: 15
			}
		},
		messages: {
			userN: {
				required: "<?php echo $metin[607]?>",
				minlength: "<?php echo $metin[608]?>"
			},
			userP: {
				required: "<?php echo $metin[610]?>",
				minlength: "<?php echo $metin[609]?>"
			}
		}
	});	
});
  </script> 
<!-- BEGIN DEMO -->
<div id="loginWrapper"> 
  <!-- BEGIN LOGIN BUTTON -->
  <div id="loginButton"> <a href="#"><?php echo $metin[2];?></a> </div>
  <!-- END LOGIN BUTTON --> 
  
  <!-- BEGIN HIDDEN FORM -->
  <div id="loginForm">
    <fieldset>
      <form id="formLogin" method="post" action="login.php">
        <label for="userN"> <?php echo $metin[0]?> : </label>
        <input type="hidden" name="form" value="login" />
        <div>
          <input name="userN" type="text" id="userN" size="18" maxlength="15" class="required"  style="width:150px" 
                     value="<?php echo ($remUser)?temizle($_COOKIE["remUser"]):""?>" />
        </div>
        <label for="userP"> <?php echo $metin[1]?> : </label>
        <div>
          <input name="userP" type="password" id="userP" size="18" maxlength="15" class="required"  style="width:150px" />
        </div>
        <br />
        <input type="submit" name="sumb" id="sumb" value="<?php echo $metin[2]?>"  />
        &nbsp;
        <?php
	 if ($remUser){
    ?>
        <a href="index.php?forgetMe=1"><span><span><?php echo $metin[196]?></span></span></a>
        <input type="hidden" name="remUser" id="remUser" value="1" />
        <?php
	} else {
    ?>
        <p>
          <label>
            <input type="checkbox" name="remUser" id="remUser" value="1" <?php
	 if ($remUser){
    ?>checked="checked"<?php }?>/>
            <?php echo $metin[193]?> </label>
        </p>
        <?php
	}
    ?>
      </form>
    </fieldset>
  </div>
  <!-- END HIDDEN FORM --> 
</div>
<!-- END MENU DEMO --> 
<script type="text/javascript">
  $(document).ready(function(){
    $("#formLogin").validate();
  });
  </script>
<ul class="artmenu"  style="list-style-type:none">
  <li><a href="index.php" <?php
						 if ($currentFile=="index.php") echo "class=\" active\"";
                        ?>><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a> </li>
  <li><a href="lessonsList.php"
						<?php
						 if ($currentFile=="lessonsList.php" or $currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> <?php //echo dersAgaci()?> </li>
  <li><a href="newUser.php"
						<?php
						 if ($currentFile=="newUser.php" || $currentFile=="passwordRemember.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[64]?> </span></span></a>
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
						 if ($currentFile=="index.php" || $currentFile=="kursDetay.php" || $currentFile=="fileShare.php" || $currentFile=="stats.php" || $currentFile=="login.php" || $currentFile=="lessonsEdit.php"|| $currentFile=="dataWorkList.php"|| $currentFile=="dataChatActions.php"|| $currentFile=="dataRatingList.php" || $currentFile=="friends.php"|| $currentFile=="dataCommentList2.php"|| $currentFile=="askQuestion.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a>
    <ul>
      <li><a href="login.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="login"/> <?php echo $metin[60]?> </span></span></a></li>
      <li><a href="kursDetay.php"><span><span><img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <?php echo $metin[461]?> </span></span></a></li>
      <li><a href="stats.php"><span><span> <?php echo $metin[197]?> </span></span></a></li>
      <li><a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?> </span></span></a></li>
      <li><a href="fileShare.php"><span><span> <?php echo $metin[463].$bilgi6?> </span></span></a></li>
      <li><a href="askQuestion.php"><span><span><img src="img/question.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[628]?>"/> <?php echo $metin[628].$bilgi11?> </span></span></a></li>
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
  <li><a href="lessonsList.php"
						<?php
						 if ($currentFile=="lessonsList.php" or $currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> <?php // echo dersAgaci()?> </li>
  <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1"){
	echo ("<li><a href=\"#\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=1000,height=450,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=yes,scrollbars=yes,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56].$bilgi1."</span></span></a></li>");
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
						 if ($currentFile=="siteNotices.php" || $currentFile=="siteSettings.php" || $currentFile=="siteSettings2.php" ||  $currentFile=="siteSettings3.php" || $currentFile=="rssEdit.php" || $currentFile=="dataChatActions.php" || $currentFile=="dataFriendActions.php" || $currentFile=="dataActions.php" || $currentFile=="dataWorkList2.php" || $currentFile=="dataRatingList.php" || $currentFile=="dataCommentList.php")
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
