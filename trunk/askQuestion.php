<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Fo4undation; either
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-9'/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo $metin[628]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<link href="lib/ui.totop.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
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
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
/*
delWithCon:
onay ile silme iþlemi
*/
function delWithCon(deletepage_url,field_value,messagetext) { 
  if (confirm(messagetext)==1){
    location.href = eval('\"'+deletepage_url+'?id='+field_value+'&delCon=1\"');
  }
}

//-->
</script>
</head>
<body>
<div class="PageBackgroundGradient"></div>
<div class="Main">
  <div class="Sheet">
    <div class="Sheet-tl"></div>
    <div class="Sheet-tr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-br">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-tc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cc"></div>
    <div class="Sheet-body">
      <div class="Header">
        <div class="Header-png"></div>
        <div class="Header-jpeg"></div>
        <div class="logo">
          <h1 id="name-text" class="logo-name"><a href="index.php"><?php echo ayarGetir("okulGenelAdi")?></a></h1>
          <div id="slogan-text" class="logo-text"> <?php echo $metin[286]?> </div>
        </div>
      </div>
      <div class="nav">
        <?php
				 require("menu.php");
                ?>
        <div class="l"> </div>
        <div class="r">
          <div>&nbsp;</div>
        </div>
      </div>
      <div class="contentLayout">
        <div class="content">
          <div class="Post">
            <div class="Post-tl"></div>
            <div class="Post-tr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-br">
              <div>&nbsp;</div>
            </div>
            <div class="Post-tc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cc"></div>
            <div class="Post-body">
              <div class="Post-inner">
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[628]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if ($tur=="2" or $tur=="1" or $tur=="0")	{	
	 //öðrenci, öðretmen ve yönetici girebilir
	
	if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
		if($tur=="2" or soruEkleyenID($_GET['id'])==getUserID($_SESSION["usern"],$_SESSION["userp"])){
		  mysql_select_db($database_baglanti, $yol);
		  
		  $deleteSQL1 = sprintf("DELETE FROM eo_askanswerrate WHERE cevapID in
		    					(select id from eo_askanswer WHERE soruID in
								  (select id from eo_askquestion where id=%s)
								)",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result1 = mysql_query($deleteSQL1, $yol) or die(mysql_error());
		  
		  $deleteSQL2 = sprintf("DELETE FROM eo_askanswer WHERE soruID in
								  (select id from eo_askquestion where id=%s)
								",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result2 = mysql_query($deleteSQL2, $yol) or die(mysql_error());
		  
		  $deleteSQL3 = sprintf("DELETE FROM eo_askquestion WHERE id=%s",
							   GetSQLValueString($_GET['id'], "int"));		
		  $Result3 = mysql_query($deleteSQL3, $yol) or die(mysql_error());
		  if ($Result3) $delSonuc ="<font id='uyari'>Soru ve cevaplarý silindi</font>";
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
                    <legend>Sorunuz</legend>
                    <form action="askQuestion.php" method="post" name="soruGonder">
                      <textarea cols="50" rows="5" name="soru" style="height:93px;border:1px solid #000;"></textarea>
                      <select name="dersID" size="7" style="height:100px;">
                        <option value="" selected="selected">Seçiniz</option>
                        <?php echo dersAdlariOption();?>
                      </select>
                      <input type="hidden" name="ccode3" value="<?php echo $ccode3 ?>" />
                      <input type="submit" name="gonder" value="Gönder" />
                    </form>
                  </fieldset>
                  <p>
                  
                  <form action="askQuestion.php" method="get" name="soruAra">
                    Arama :
                    <input type="text" maxlength="50" size="50" name="ara" value="<?php echo RemoveXSS($_GET["ara"]);?>"  />
                    <input name="arama" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
                  </form>
                  </p>
                  <?php
					$currentPage = $_SERVER["PHP_SELF"];
					
				  	$devam = RemoveXSS($_GET['devam']);
					
					if($_SESSION['soruLimit']=="") 	
						$_SESSION['soruLimit'] = 5;

					$limit = RemoveXSS($_SESSION['soruLimit']);
					$arama = str_replace("'", "`", $_GET['ara']);
					$arama = substr(temizle($arama),0,250);
					
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
					 	
					$veriSonuc = mysql_query($veriSQL,$yol1);
					$kaySay = @mysql_num_rows($veriSonuc);
					if($kaySay>0){
                  ?>
                  <p>
                  
                  <table width="100%" cellspacing="0" cellpadding="2">
                    <caption style="font-weight:bold;font-size:16px;">
                    Sorular
                    </caption>
                    <tr>
                      <th width="15%">Gönderen</th>
                      <th width="35%">Soru (cevap sayýsý)</th>
                      <th >Ders</th>
                      <th width="20%">Tarih</th>
                    </tr>
                    <?php
					$satirRenk=0;
					while($satir=mysql_fetch_assoc($veriSonuc)){
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
                        <?php echo "<a href='readAnswer.php?oku=".$satir['id']."'  rel=\"shadowbox;height=400;width=800\" title='Cevap Oku'>".smartShort($satir['question'],30)."</a> ".cevapSayisiGetir($satir['id'])."" ;?></td>
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
				 	 echo "<a href='askQuestion.php?devam=1&amp;ara=$arama'><font class=\"more\">Devamý...</font></a>";
					 echo "<p>$tumKaySay soru var.</p>";
			}
	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
          <div class="cleared"></div>
          <div class="Footer">
            <div class="Footer-inner">
              <?php  						
						 require "footer.php";
                        ?>
            </div>
            <div class="Footer-background"></div>
          </div>
        </div>
      </div>
      <div class="cleared"></div>
    </div>
  </div>
</div>
<?php  						
 require "feedback.php";
?>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
