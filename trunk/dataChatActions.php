<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://www.tuzlaatl.k12.tr/eogr
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
	checkLoginLang(true,true,"dataChatActions.php");	
	$seciliTema=temaBilgisi();
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
<title>eOgr -<?php echo $metin[67]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[67]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if ($tur=="2" or $tur=="1")	{
	 //

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1") && $tur=="2") {
  $deleteSQL = sprintf("DELETE FROM eo_shoutbox WHERE messageid=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_baglanti, $yol);
  $Result1 = mysql_query($deleteSQL, $yol) or die(mysql_error());
  if ($Result1) echo "<font id='uyari'>$metin[501]</font>";
}
  
  $pageCnt=temizle($_GET['pageCnt']);

  if($pageCnt=="")  
    $pageCnt=GetSQLValueString($_SESSION['pageCnt3'], "int"); 
	else
	$_SESSION['pageCnt3']=$pageCnt;
  
  if ($pageCnt>=1)
	$maxRows_eoUsers = $pageCnt;
    else
	$maxRows_eoUsers =  ayarGetir("veriHareketleriSayisi");
	
$pageNum_eoUsers = 0;
if (isset($_GET['pageNum_eoUsers'])) {
  $pageNum_eoUsers = $_GET['pageNum_eoUsers'];
}
$startRow_eoUsers = $pageNum_eoUsers * $maxRows_eoUsers;

mysql_select_db($database_baglanti, $yol);

$arayici =  temizle($_GET['arama']);   
  if ($arayici!="") 
   {
		    $filtr2=" where (name like '%$arayici%' or message like '%$arayici%') ";
   }

if(!empty($_POST["sil"]) && $_POST["silIzin"]=="evet" && $tur=="2") {
   $silinenler = "''";
   for ($i = 0; $i < count($_POST["sil"]); $i++)
      $silinenler .= ",'".$_POST["sil"][$i]."'";
	$silSorgu= "DELETE FROM eo_shoutbox WHERE messageid in ($silinenler)";
	$sonuc = mysql_query($silSorgu, $yol);
	if ($sonuc) 
	 echo "<font id='uyari'>$metin[501]</font>";
	 else
	 echo "<font id='hata'>Se&ccedil;ilen kayıt(lar) silinemedi!</font>";
 }   

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3") && $tur=="2") {
  if ( 
     GetSQLValueString($_POST['messageid'], "text")=='NULL' || 
     GetSQLValueString($_POST['message'], "text")=='NULL'  	 
      )
	   echo "<font id='hata'>Bilgilerinde eksik alanlar vardır.</font>";
	else{   
	
			$gelenyorum = str_replace("\r\n", "<br/>", $_POST['message']);
			$gelenyorum = RemoveXSS($gelenyorum);

			$updateSQL = sprintf("UPDATE eo_shoutbox SET message='%s' WHERE messageid=%s",
							   $gelenyorum,
							   temizle(GetSQLValueString($_POST['messageid'], "int"))
							   );
			
		
		  mysql_select_db($database_baglanti, $yol);
		  $Result1 = mysql_query($updateSQL, $yol);
		  if($Result1) {
			   	trackUser($currentFile,"success,ChatMess",$adi);
				echo ("<font id='tamam'> $metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,ChatMess",$adi);
				echo ("<font id='hata'> Bilgide hata olduğundan g&uuml;ncelleme işleminiz tamamlanamadı!</font>");
			}
		
	}			
}

if (empty($_SESSION["siraYonu2"])) {  
		$siraYonu="desc";
		$_SESSION["siraYonu2"]=$siraYonu;
	}
	else
	if ($_GET["yonU"]!="dur" && $_GET['siraYap']=="OK"){
	$siraYonu=($_SESSION["siraYonu2"]=="desc")?"asc":"desc";
	$_SESSION["siraYonu2"]=$siraYonu;
	}
	else
	$siraYonu=$_SESSION["siraYonu2"];
	
	$sirAlan=temizle($_GET['order']);
	
	  if ($sirAlan!="")
	    $query_eoUsers = "SELECT * FROM eo_shoutbox $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
	    $query_eoUsers = "SELECT * FROM eo_shoutbox $filtr2 ORDER BY date DESC";  
		$sirAlan="date";
	   }
//echo  $query_eoUsers ;
 if ($_GET["upd"]=="1")
	$query_limit_eoUsers = "SELECT * FROM eo_shoutbox where messageid='".RemoveXSS($_GET["messageid"])."'";
 else
	$query_limit_eoUsers = sprintf("%s LIMIT %d, %d", $query_eoUsers, $startRow_eoUsers, $maxRows_eoUsers);

$eoUsers = mysql_query($query_limit_eoUsers, $yol) or die(mysql_error());
$row_eoUsers = mysql_fetch_assoc($eoUsers);
$totalRows_eoUsers = mysql_num_rows($eoUsers);

if (isset($_GET['totalRows_eoUsers'])) {
  $totalRows_eoUsers = $_GET['totalRows_eoUsers'];
} else {
  $all_eoUsers = mysql_query($query_eoUsers);
  $totalRows_eoUsers = mysql_num_rows($all_eoUsers);
}
$totalPages_eoUsers = ceil($totalRows_eoUsers/$maxRows_eoUsers)-1;

$queryString_eoUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_eoUsers") == false && 
        stristr($param, "totalRows_eoUsers") == false && 
        stristr($param, "siraYap") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_eoUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_eoUsers = sprintf("&amp;totalRows_eoUsers=%d%s", $totalRows_eoUsers, $queryString_eoUsers);

if ($_GET["upd"]=="1" && isset($_GET["messageid"]) && $tur=="2" ){
	//güncelleme
?>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
                    <table width="500" border="0" align="center" cellpadding="3" cellspacing="0">
                      <tr valign="baseline">
                        <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <?php echo $metin[451]?> </div></th>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap"><?php echo $metin[26]?> :</td>
                        <td><?php echo $row_eoUsers['messageid']; ?></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap"><label for="message"> <?php echo $metin[50]?> :</label></td>
                        <td bgcolor="#CCFFFF"><textarea name="message" id="message" cols="60" rows="8"><?php echo GetSQLValueStringNo($row_eoUsers['message'],"text"); ?></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td colspan="2" align="center" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[25]?>" />
                          <input name="geri" type="button" id="geri" onclick="location.href = &quot;dataChatActions.php&quot;;" value="<?php echo $metin[28]?>" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form3" />
                    <input type="hidden" name="messageid" value="<?php echo $row_eoUsers['messageid']; ?>" />
                  </form>
                  <?php	
}
else if ($totalRows_eoUsers>0)
   {
?>
                  <form id="formSilme" name="formSilme" method="post" action="dataChatActions.php">
                    <table border="0" align="center" cellpadding="3" cellspacing="0" width="850">
                      <tr>
                        <th><?php if ($sirAlan=="messageid") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="messageid")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=messageid&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[26]?> </a></th>
                        <th width="138"><?php if ($sirAlan=="name") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="name")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=name&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[17]?> </a></th>
                        <th width="500"><?php if ($sirAlan=="message") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="message")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=message&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[50]?> </a></th>
                        <th><?php if ($sirAlan=="ip") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="ip")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=ip&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[51]?> </a></th>
                        <th><?php if ($sirAlan=="date") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="date")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=date&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[33]?> </a></th>
                      </tr>
                      <?php 
  $satirRenk=0;
  do { 
    	$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  ?>
                      <tr >
                        <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo $row_eoUsers['messageid']; ?></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo getUserID2($row_eoUsers['name']); ?>" rel="facebox"><?php echo araKalin($row_eoUsers['name']); ?></a></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?> title="<?php echo $row_eoUsers['message']?>"><?php echo araKalin(smileAdd(temizle(smartShort($row_eoUsers['message'],45)))); ?></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><?php
		echo odaGetir($row_eoUsers['ip']);				
	  ?></td>
                        <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['date']); ?></td>
                        <?php  if($tur=="2"){ ?>
                        <td align="center" nowrap="nowrap" valign="middle" ><a href="<?php echo $currentPage;?>?messageid=<?php echo $row_eoUsers['messageid'];?>&amp;upd=1&amp;pageNum_eoUsers=<?php echo $pageNum_eoUsers?>"><img src="img/edit.png" alt="edit" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[103]?>"/></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['messageid']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a> |
                          <input type="checkbox" name="sil[]" id="kayitSecici<?php echo $row_eoUsers['messageid']; ?>" value="<?php echo $row_eoUsers['messageid']; ?>" /></td>
                        <?php } ?>
                      </tr>
                      <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); ?>
                      <?php  if($tur=="2"){ ?>
                      <tr>
                        <td colspan="7" align="center" valign="middle" class="tabloAlt" ><label>
                            <input name="tumunuSec" type="checkbox" id="tumunuSec" onclick="javascript: 
    for (var i=0;i&lt;document.formSilme.elements.length;i++)
    {
      var e=document.formSilme.elements[i];
      if (e.type == 'checkbox' &amp;&amp; e.name !='tumunuSec' &amp;&amp; e.name !='silIzin')
        e.checked=!e.checked;
    }
 " value="" />
                            <?php echo $metin[35]?> </label>
                          |
                          <label>
                            <input name="silIzin" type="checkbox" id="silIzin" value="evet" />
                            <?php echo $metin[36]?> </label>
                          <label>
                            <input type="submit" name="Sil" id="Sil" value="<?php echo $metin[37]?>" />
                          </label></td>
                      </tr>
                      <?php } ?>
                    </table>
                    <?php
if ($totalRows_eoUsers> $maxRows_eoUsers)
   {
?>
                    <table border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC" >
                      <tr>
                        <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, 0, $queryString_eoUsers); ?>"><img src="img/page-first.gif" border="0" alt="first" /></a> </div></td>
                        <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, max(0, $pageNum_eoUsers - 1), $queryString_eoUsers); ?>"><img src="img/page-prev.gif" border="0" alt="prev" /></a> </div></td>
                        <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, min($totalPages_eoUsers, $pageNum_eoUsers + 1), $queryString_eoUsers); ?>"><img src="img/page-next.gif" border="0"  alt="next"/></a> </div></td>
                        <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, $totalPages_eoUsers, $queryString_eoUsers); ?>"><img src="img/page-last.gif" border="0" alt="last" /></a> </div></td>
                      </tr>
                      <tr>
                        <td colspan="4"><div align="center"><?php echo min($startRow_eoUsers + $maxRows_eoUsers, $totalRows_eoUsers) ?> / <?php echo $totalRows_eoUsers ?> </div></td>
                      </tr>
                    </table>
                  </form>
                  <?php
   }
 ?>
                  <form method="get" id="sayfaSec" name="sayfaSec" action="dataChatActions.php">
                    <p>
                      <label> <?php echo $metin[110]?> :
                        <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
                      </label>
                      <label>
                        <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
                      </label>
                    </p>
                  </form>
                  <form id="aramak" name="aramak" method="get" action="dataChatActions.php">
                    <label> <?php echo $metin[29]?> :
                      <input name="arama" type="text" size="20" maxlength="20"  title="<?php echo $metin[140]?>" value="<?php echo $arayici?>" />
                    </label>
                    <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
                  </form>
                  <?php  
   }
if ($totalRows_eoUsers==0) echo "<font id='hata'> Arama sonucuna uyan bilgi bulunamadı veya hi&ccedil; kayıt yok!</font><br/>Geri d&ouml;nmek i&ccedil;in <a href=dataChatActions.php>tıklatınız</a>";

	}
	else {
	  @header("Location: error.php?error=9");	
	  die($metin[447]);
	}
?>
                </div>
                <div class="cleared"></div>
              </div>
              &nbsp;</div>
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
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>
