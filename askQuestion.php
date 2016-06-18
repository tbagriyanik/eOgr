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
	ob_start();
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"askQuestion.php");	
	$seciliTema=temaBilgisi();
	
	if($protect -> check_request(getenv('REMOTE_ADDR'))) { // check the user
	  @header("Location: error.php?error=4");
	  die('<br/><img src="img/warning.png" border="0" style="vertical-align: middle;"/> '. $metin[401]."<br/>".$metin[402]); // die there flooding
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="tarik bagriyanik">
<link href="theme/<?php echo $seciliTema?>/bootstrap-theme.css" rel="stylesheet">
<link href="theme/docs.min.css" rel="stylesheet">
<link href="theme/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="theme/justified-nav.css" rel="stylesheet">
<script src="lib/bs_js/ie-emulation-modes-warning.js"></script>
<title>eOgr -<?php echo $metin[628]?></title>
<link rel="icon" href="img/favicon.ico">
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="elearning, cms, lms, learning management, education, eogrenme" />
<meta name="description" content="eOgr - Open source online education, elearning project" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<script src="lib/bs_js/jquery-2.2.0.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			
		  }) 
		})
	</script>
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[628]?> </span> </h2>
      <div class="PostContent">
        <?php
	if ($tur=="2" or $tur=="1" or $tur=="0")	{	
	 //öğrenci, öğretmen ve yönetici girebilir
	
	if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
		if($tur=="2" or soruEkleyenID($_GET['id'])==getUserID($_SESSION["usern"],$_SESSION["userp"])){
		  //mysqli_select_db($_db, $yol);
		  
		  $deleteSQL1 = sprintf("DELETE FROM eo_askanswerrate WHERE cevapID in
		    					(select id from eo_askanswer WHERE soruID in
								  (select id from eo_askquestion where id=%s)
								)",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result1 = mysqli_query($yol, $deleteSQL1) or die(mysqli_error());
		  
		  $deleteSQL2 = sprintf("DELETE FROM eo_askanswer WHERE soruID in
								  (select id from eo_askquestion where id=%s)
								",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result2 = mysqli_query($yol, $deleteSQL2) or die(mysqli_error());
		  
		  $deleteSQL3 = sprintf("DELETE FROM eo_askquestion WHERE id=%s",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result3 = mysqli_query($yol, $deleteSQL3) or die(mysqli_error());
		  if ($Result3) $delSonuc ="<font id='uyari'>Soru ve cevapları silindi</font>";
		  trackUser($currentFile,"success,DelQue",$adi);
		  echo $delSonuc;
		}
	}
	
		if(isset($_POST["gonder"])) {
			if ($_POST["ccode3"]==$_SESSION["ccode3"]){
				if(!empty($_POST["soru"]) and !empty($_POST["dersID"])) {
					if(soruEkle($_POST)){
						  trackUser($currentFile,"success,AddQue",$adi);
						echo "<font id='tamam'>Sorunuz eklendi.</font>";
					}
					else{
						  trackUser($currentFile,"fail,AddQue",$adi);
						echo "<font id='hata'>Sorunuz eklenemedi!</font>";
					}
				}
			}			
		}
	
		$ccode3 = newPassw();
		$_SESSION["ccode3"]=$ccode3;	
?>
        <fieldset>
          <legend><?php echo $metin[645] ?></legend>
          <form action="askQuestion.php" method="post" name="soruGonder">
            <textarea cols="50" rows="5" name="soru" style="height:93px;border:1px solid #000;"></textarea>
            <select name="dersID" size="7" style="height:100px;">
              <option value="" selected="selected">-<?php echo $metin[106] ?>-</option>
              <?php echo dersAdlariOption();?>
            </select>
            <input type="hidden" name="ccode3" value="<?php echo $ccode3 ?>" />
            <input type="submit" name="gonder" value="<?php echo $metin[100] ?>" />
          </form>
        </fieldset>
        <p>
        <form action="askQuestion.php" method="get" name="soruAra">
          <?php echo $metin[29] ?> :
          <input type="text" maxlength="50" size="50" name="ara" value="<?php echo RemoveXSS((isset($_GET["ara"]))?$_GET["ara"]:"");?>"  />
          <input name="arama" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
        </form>
        </p>
        <?php
					$currentPage = $_SERVER["PHP_SELF"];
					
				  	$devam = RemoveXSS((isset($_GET["devam"]))?$_GET["devam"]:"");
					
					if(empty($_SESSION['soruLimit'])) 	
						$_SESSION['soruLimit'] = 5;

					$limit = RemoveXSS($_SESSION['soruLimit']);
					$arama = str_replace("'", "`", (isset($_GET["ara"]))?$_GET["ara"]:"");
					$arama = substr(temizle($arama),0,300);
					
					$tumKaySay = soruSayisiGetir($arama);
					
					if($devam=="1" and $tumKaySay>$_SESSION['soruLimit']){ 				
						$_SESSION['soruLimit'] += 3;
						$limit = RemoveXSS($_SESSION['soruLimit']);
					}
									  
				  	if($arama!="")
					  	$veriSQL = "SELECT * FROM eo_askquestion WHERE question 
							LIKE '%$arama%'
						 	ORDER BY eklenmeTarihi DESC LIMIT 0,$limit";
					 else
					  	$veriSQL = "SELECT * FROM eo_askquestion ORDER BY eklenmeTarihi DESC LIMIT 0,$limit";
					 	
					$veriSonuc = mysqli_query($yol1, $veriSQL);
					$kaySay = @mysqli_num_rows($veriSonuc);
					if($kaySay>0){
                  ?>
        <p>
        <table width="100%" cellspacing="0" cellpadding="2">
          <caption style="font-weight:bold;font-size:16px;">
          <?php echo $metin[646] ?>
          </caption>
          <tr>
            <th width="15%"><?php echo $metin[17] ?></th>
            <th width="35%"><?php echo $metin[647] ?></th>
            <th ><?php echo $metin[363] ?></th>
            <th width="20%"><?php echo $metin[129] ?></th>
          </tr>
          <?php
					$satirRenk=0;
					while($satir=mysqli_fetch_assoc($veriSonuc)){
						$humanRelativeDate = new HumanRelativeDate();
						$insansi = $humanRelativeDate->getTextForSQLDate($satir['eklenmeTarihi']);
    					$satirRenk++;
				        if ($satirRenk & 1) $row_color = "#CCC"; else $row_color = "#ddd"; 
								
                    ?>
          <tr>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo "<a href='profil.php?kim=".$satir['userID']."' rel='facebox'>".(kullAdi($satir['userID'])==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":kullAdi($satir['userID']))."</a>" ;?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php
					  	if($tur=="2" or $satir['userID']==getUserID($_SESSION["usern"],$_SESSION["userp"])){
                      ?>
              <a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $satir['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a>&nbsp;
              <?php
						}
                      ?>
              <?php echo "<a href='readAnswer.php?oku=".$satir['id']."'  rel=\"shadowbox;height=400;width=800\" title='$metin[649]'>".smartShort($satir['question'],30)."</a> ".cevapSayisiGetir($satir['id'])."" ;?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo (dersAdiGetir($satir['dersID'])==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":dersAdiGetir($satir['dersID'])) ;?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo $insansi ;?></td>
          </tr>
          <?php
					}
                    ?>
        </table>
        </p>
        <?php	
				  if($tumKaySay>$limit)
				 	 echo "<a href='askQuestion.php?devam=1&amp;ara=$arama'><font class=\"more\">Devamı...</font></a>";
					 printf("<p>".$metin[648]."</p>",$tumKaySay);
			}
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="Footer-inner">
      <?php  require "footer.php";?>
    </div>
  </footer>
</div>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script> 
<script language="javascript" type="text/javascript" src="lib/fade.js"></script> 
<script language="JavaScript" type="text/javascript">
<!--
/*
delWithCon:
onay ile silme işlemi
*/
function delWithCon(deletepage_url,field_value,messagetext) { 
  if (confirm(messagetext)==1){
    location.href = eval('\"'+deletepage_url+'?id='+field_value+'&delCon=1\"');
  }
}

//-->
</script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>