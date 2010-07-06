<?php

	$adi	=substr(temizle($_POST["userN"]),0,15);
	$par	=sha1(substr(temizle($_POST["userP"]),0,15));
	
   if ($adi=="") {
	   $adi	=temizle(substr($_SESSION["usern"],0,15));
	   $par	=temizle($_SESSION["userp"]);
	  }
	  
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
$kullaniciSecen = explode("-",ayarGetir3($adi));

if($seceneklerimiz[5]=="1" and $kullaniciSecen[5]=="1"){
?>
<script  type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script  type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script type="text/javascript" src="lib/as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>

<div class="aramaDiv">
  <input name="searchterm" type="text" id="searchterm" size="15" maxlength="50" title="<?php echo $metin[177]?>"/>
 <img src="img/view.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[168]?>" title="<?php echo $metin[168]?>"/> </div>
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
                        ?>><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a> </li>
  <li><a href="lessons.php"
						<?php
						 if ($currentFile=="lessons.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55]?> </span></span></a> <?php echo dersAgaci()?> </li>
  <li><a href="newUser.php"
						<?php
						 if ($currentFile=="newUser.php" || $currentFile=="passwordRemember.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[149] ?> </span></span></a>
    <ul>
      <li><a href="newUser.php"><span><span> <?php echo $metin[64]?> </span></span></a></li>
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
						 if ($currentFile=="index.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?> </span></span></a> </li>
  <?php
  if ($_SESSION["usern"]!="" || $_POST["userN"]!=""){
?>
  <li><a href="lessons.php"
						<?php
						 if ($currentFile=="login.php" || $currentFile=="lessons.php" || $currentFile=="lessonsEdit.php"|| $currentFile=="dataWorkList.php" || $currentFile=="dataCommentList2.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55]?> </span></span></a>
    <ul>
      <li><a href="lessons.php"><span><span>
        <?php
				    echo $metin[61];
					$boyut=20-strlen($metin[61]);
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?>
        &#8250; </span></span></a> <?php echo dersAgaci()?> </li>
      <li><a href="login.php"><span><span> <?php echo $metin[60]?> </span></span></a></li>
      <?php
							 if ($tur=='2' || $tur=='1'){
                            ?>
      <li><a href="lessonsEdit.php"><span><span> <?php echo $metin[62]?> </span></span></a></li>
      <li><a href="dataWorkList.php"><span><span> <?php echo $metin[186]?> </span></span></a></li>
      <li><a href="dataCommentList2.php"><span><span> <?php echo $metin[259]?> </span></span></a></li>
      <?php
							 }
                            ?>
    </ul>
  </li>
  <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1"){
	echo ("<li><a href=\"chat.php\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=310,height=330,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=no,scrollbars=0,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56]."</span></span></a></li>");
  }
?>
  <li><a href="userSettings.php"
						<?php
						 if ($currentFile=="userSettings.php" || $currentFile=="newUser.php" || $currentFile=="passwordRemember.php" )
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[63]?> </span></span></a> </li>
  <?php
							 if ($tur=='2'){
                            ?>
  <li><a href="siteSettings.php"
						<?php
						 if ($currentFile=="siteSettings.php" || $currentFile=="rssEdit.php" || $currentFile=="dataChatActions.php" || $currentFile=="dataActions.php" || $currentFile=="dataWorkList2.php" || $currentFile=="dataRatingList.php" || $currentFile=="dataCommentList.php")
						   echo "class=\" active\"";
                        ?>                       
                        ><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[58]?> </span></span></a>
    <ul>
      <li><a href="siteSettings.php"><span><span> <?php echo $metin[58]?> </span></span></a></li>
      <li><a href="rssEdit.php"><span><span> <?php echo $metin[70]?> </span></span></a></li>
      <li><a href="dataActions.php"><span><span>
        <?php
				    echo $metin[185];
					$boyut=20-strlen($metin[185]);
					for($boy=1;$boy<=$boyut;$boy++) echo "&nbsp;";
				  ?>
        &#8250; </span></span></a>
        <ul>
          <li><a href="dataActions.php"><span><span> <?php echo $metin[66]?> </span></span></a></li>
          <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67]?> </span></span></a></li>
          <li><a href="dataWorkList2.php"><span><span> <?php echo $metin[186]?> </span></span></a></li>
          <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287]?> </span></span></a></li>
          <li><a href="dataCommentList.php"><span><span> <?php echo $metin[288]?> </span></span></a></li>
        </ul>
      </li>
      <li><a href="install.php"><span><span> <?php echo $metin[71]?> </span></span></a></li>
    </ul>
  </li>
  <?php
							 }
                            ?>
  <li><a href="index.php?logout=1"><span><span><img src="img/logout.png" border="0" style="vertical-align: middle;" alt="logout"/>
    <?php if (!empty($adi)) echo temizle($adi)." "; ?>
    <?php echo $metin[59]?> </span></span></a>
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
