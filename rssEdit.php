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
  checkLoginLang(true,true,"rssEdit.php");	   
  $seciliTema=temaBilgisi();
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
<title>eOgr -<?php echo $metin[70]?></title>
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
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
/*
delWithCon:
onay ile silme
*/
function delWithCon(deletepage_url,field_value,messagetext) { 
  if (confirm(messagetext)==1){
    location.href = eval('\"'+deletepage_url+'?id='+field_value+'&delCon=1\"');
  }
}
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[70]?> </span> </h2>
      <div class="PostContent">
        <?php
	if ($tur=="2")	{
	 //

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  if ( 
     GetSQLValueString($_POST['title'], "text")=='NULL' || 
     GetSQLValueString($_POST['description3'], "text")=='NULL' 
      )
	   echo "<p>&nbsp;</p><font id='hata'>Haber bilgilerinde eksik alanlar vardır.</font>";
	else{   
	
			$gelenyorum = str_replace("\r\n", "<br/>", $_POST['description3']);
			$gelenyorum = RemoveXSS($gelenyorum);	

			$updateSQL = sprintf("UPDATE eo_webref_rss_items SET title=%s, description='%s', link=%s, pubDate='%s' WHERE id=%s",
							   temizle(GetSQLValueString($_POST['title'], "text")),
							   $gelenyorum,
							   temizle(GetSQLValueString($_POST['link3'], "text")),
							   tarihYap2(temizle($_POST['pubDate'])),
							   temizle(GetSQLValueString($_POST['id'], "int")));
		
		  //mysqli_select_db($_db, $yol);
		  $Result1 = mysqli_query($yol, $updateSQL);
		  if($Result1) {
			   	trackUser($currentFile,"success,RSSUpdate",$adi);
				echo ("<p>&nbsp;</p><font id='tamam'> $metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,RSSUpdate",$adi);
				echo ("<p>&nbsp;</p><font id='hata'> Haber bilgilerinde hata olduğunda g&uuml;ncelleme işleminiz tamamlanamadı!</font>");
			}
		}
	}			

if ((isset($_POST["MM_settings"])) && ($_POST["MM_settings"] == "form5")) {
  if ( 
     GetSQLValueString($_POST['title3'], "text")=='NULL' || 
     GetSQLValueString($_POST['description'], "text")=='NULL' || 
     GetSQLValueString($_POST['link'], "text")=='NULL' || 
     GetSQLValueString($_POST['language'], "text")=='NULL' 
      )
	   echo "<p>&nbsp;</p><font id='hata'>Haber ayar bilgilerinde eksik alanlar vardır.</font>";
	else{   
			$updateSQL = sprintf("UPDATE eo_webref_rss_details SET title=%s, description=%s, link=%s, language=%s WHERE id=1",
							   temizle(GetSQLValueString($_POST['title3'], "text")),
							   temizle2(GetSQLValueString($_POST['description'], "text")),
							   temizle(GetSQLValueString($_POST['link'], "text")),
							   temizle(GetSQLValueString($_POST['language'], "text")));
		  //mysqli_select_db($_db, $yol);
		  $Result1 = mysqli_query($yol, $updateSQL);
		  if($Result1) {
			   	trackUser($currentFile,"success,RSSInfo",$adi);
				echo ("<p>&nbsp;</p><font id='tamam'> $metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,RSSInfo",$adi);
				echo ("<p>&nbsp;</p><font id='hata'> Haber ayar bilgilerinde hata olduğunda g&uuml;ncelleme işleminiz tamamlanamadı!</font>");
			}
	}
}
	

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 if ( 
     GetSQLValueString($_POST['title2'], "text")=='NULL' || 
     GetSQLValueString($_POST['description2'], "text")=='NULL' 
      )
	   echo "<p>&nbsp;</p><font id='hata'>Yeni haber bilgilerinde eksik alanlar vardır.</font>";
	else{   
	  		$gelenyorum = str_replace("\r\n", "<br/>", $_POST['description2']);
			$gelenyorum = RemoveXSS($gelenyorum);	

  $insertSQL = sprintf("INSERT INTO eo_webref_rss_items (title, description, link, pubDate) VALUES (%s, '%s', %s, '%s')",

                       temizle(GetSQLValueString($_POST['title2'], "text")),
                       $gelenyorum,
                       temizle(GetSQLValueString($_POST['link2'], "text")),
                       tarihYap2(temizle($_POST['pubDate2']))
					   );

  //mysqli_select_db($_db, $yol);
  $Result1 = mysqli_query($yol, $insertSQL);
  if ($Result1) {
			  trackUser($currentFile,"success,NewRSS",$adi);
			  echo "<p>&nbsp;</p><font id='tamam'> $metin[537]</font>";
  }
  else{
			  trackUser($currentFile,"fail,NewRSS",$adi);
			  echo "<p>&nbsp;</p><font id='hata'>Yeni haber işleminiz tamamlanamadı!</font>";
  }
  }
}
$filtr2="";
$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
  if ($arayici!="") 
    $filtr2=" where (title like '%$arayici%' or description like '%$arayici%' ) ";

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (!empty($_GET['delCon']) and $_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_webref_rss_items WHERE id=%s",
                       temizle(GetSQLValueString($_GET['id'], "int")));

  //mysqli_select_db($_db, $yol);
  $Result1 = mysqli_query($yol, $deleteSQL);
 if ($Result1) {
			  trackUser($currentFile,"success,DelRSS",$adi);
			  echo "<p>&nbsp;</p><font id='uyari'> $metin[501]</font>";
  }
  else{
			  trackUser($currentFile,"fail,DelRSS",$adi);
			  echo "<p>&nbsp;</p><font id='hata'>Haber silme işleminiz tamamlanamadı!</font>";
  }

}
  
  $pageCnt=GetSQLValueString((isset($_GET['pageCnt']))?$_GET['pageCnt']:"", "int");

  if($pageCnt=="NULL")  
    $pageCnt=GetSQLValueString((isset($_SESSION['pageCnt']))?$_SESSION['pageCnt']:"", "int"); 
	else
	$_SESSION['pageCnt']=$pageCnt;
  
  if ($pageCnt>=1)
	$maxRows_eoUsers = $pageCnt;
    else
	$maxRows_eoUsers = ayarGetir("sayfaKullaniciSayisi");
	
$pageNum_eoUsers = 0;
if (isset($_GET['pageNum_eoUsers'])) {
  $pageNum_eoUsers = $_GET['pageNum_eoUsers'];
}
$startRow_eoUsers = $pageNum_eoUsers * $maxRows_eoUsers;

//mysqli_select_db($_db, $yol);

if(empty($_GET["yonU"]))  $_GET["yonU"]="";

if (empty($_SESSION["siraYonu"])) {  
		$siraYonu="desc";
		$_SESSION["siraYonu"]=$siraYonu;
	} else {
		if (!empty($_GET['siraYap']) and $_GET["yonU"]!="dur" && $_GET['siraYap']=="OK"){
			$siraYonu=($_SESSION["siraYonu2"]=="desc")?"asc":"desc";
			$_SESSION["siraYonu2"]=$siraYonu;
			}
			else
			$siraYonu=(isset($_SESSION["siraYonu2"]))?$_SESSION["siraYonu2"]:"";
	}

$sirAlan = temizle((isset($_GET['order']))?$_GET['order']:"");
	
if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
   {
   $upID =  GetSQLValueString($_GET['id'], "int"); 
      if ($sirAlan!="")
	   $query_eoUsers = "SELECT * FROM eo_webref_rss_items where id='$upID' ORDER BY $sirAlan $siraYonu";
	   else 
	   { 
	   $sirAlan = "pubDate";
	   $query_eoUsers = "SELECT * FROM eo_webref_rss_items where id='$upID' ORDER BY $sirAlan DESC";
	   }
   }
   else
    {
	  if ($sirAlan!="")
	    $query_eoUsers = "SELECT * FROM eo_webref_rss_items $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
  	    $sirAlan = "pubDate";
	    $query_eoUsers = "SELECT * FROM eo_webref_rss_items $filtr2 ORDER BY $sirAlan DESC";  
	   }
	}

 if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
	$query_limit_eoUsers = sprintf("%s", $query_eoUsers);
 else
	$query_limit_eoUsers = sprintf("%s LIMIT %d, %d", $query_eoUsers, $startRow_eoUsers, $maxRows_eoUsers);

$eoUsers = mysqli_query($yol, $query_limit_eoUsers) or die(mysqli_error());

$row_eoUsers = mysqli_fetch_assoc($eoUsers);
$totalRows_eoUsers = mysqli_num_rows($eoUsers);

if (isset($_GET['totalRows_eoUsers'])) {
  $totalRows_eoUsers = $_GET['totalRows_eoUsers'];
} else {
  $all_eoUsers = mysqli_query($yol, $query_eoUsers);
  $totalRows_eoUsers = mysqli_num_rows($all_eoUsers);
}
$totalPages_eoUsers = ceil($totalRows_eoUsers/$maxRows_eoUsers)-1;

$queryString_eoUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_eoUsers") == false && 
        stristr($param, "totalRows_eoUsers") == false && 
        stristr($param, "siraYap") == false)  {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_eoUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_eoUsers = sprintf("&amp;totalRows_eoUsers=%d%s", $totalRows_eoUsers, $queryString_eoUsers);

if(!isset($_GET["upd"]))
	$_GET["upd"]="";
	
if ($_GET["upd"]!="1" && $totalRows_eoUsers>0)
   {
	   $s1 = (isset($_GET["ord"]))?$_GET["ord"]:"";
	   $a1 = (isset($_GET["arama"]))?$_GET["arama"]:"";
	   $aa1 = (isset($_GET["pageNum_eoUsers"]))?$_GET["pageNum_eoUsers"]:"";
	   
?>
        <br/>
        <table border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <th width="75"><?php if ($sirAlan=="id") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"   border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=id&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[26]?> </a></th>
            <th width=""><?php if ($sirAlan=="title") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="title")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"   border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=title&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[126]?> </a></th>
            <th width=""><?php if ($sirAlan=="description") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="description")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"   border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=description&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[127]?> </a></th>
            <th width="100"><?php if ($sirAlan=="link") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="link")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"  border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=link&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[128]?> </a></th>
            <th width="100"><?php if ($sirAlan=="pubDate") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="pubDate")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=pubDate&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[129]?> </a></th>
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
          <tr bgcolor="#CCFFFF">
            <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo $row_eoUsers['id']; ?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo araKalin($row_eoUsers['title']); ?></td>
            <td <?php echo "style=\"background-color: $row_color;\" title='".$row_eoUsers['description']."'"?>><?php echo smileAdd(araKalin(smartShort(temizle($row_eoUsers['description']),45))); ?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo $row_eoUsers['link']; ?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['pubDate']); ?></td>
            <td align="center" valign="middle" width="50" nowrap="nowrap"><a href="<?php echo $currentPage;?>?id=<?php echo $row_eoUsers['id'];?>&amp;upd=1&amp;pageNum_eoUsers=<?php echo $pageNum_eoUsers?>"><img src="img/edit.png" alt="edit" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[103]?>"/></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[102]?>"/></a></td>
          </tr>
          <?php } while ($row_eoUsers = mysqli_fetch_assoc($eoUsers)); ?>
        </table>
        <?php
	if ($totalRows_eoUsers>$maxRows_eoUsers)
	{
?>
        <table border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, 0, $queryString_eoUsers); ?>"><img src="img/page-first.gif" border="0" alt="first"/></a> </div></td>
            <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, max(0, $pageNum_eoUsers - 1), $queryString_eoUsers); ?>"><img src="img/page-prev.gif" border="0" alt="prev" /></a> </div></td>
            <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, min($totalPages_eoUsers, $pageNum_eoUsers + 1), $queryString_eoUsers); ?>"><img src="img/page-next.gif" border="0"  alt="next"/></a> </div></td>
            <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, $totalPages_eoUsers, $queryString_eoUsers); ?>"><img src="img/page-last.gif" border="0" alt="last" /></a> </div></td>
          </tr>
          <tr>
            <td colspan="4"><div align="center"><?php echo min($startRow_eoUsers + $maxRows_eoUsers, $totalRows_eoUsers) ?> / <?php echo $totalRows_eoUsers ?> </div></td>
          </tr>
        </table>
        <?php 
   }
   }
if ($totalRows_eoUsers==0) echo( "<p>&nbsp;</p><font id='hata'> Aranan haber veya d&uuml;zenlenecek haber bulunamadı!</font>");
 else{
	 if (empty($_GET["upd"])):
?>
        <br />
        <form method="get" id="sayfaSec" name="sayfaSec" action="rssEdit.php">
          <label> <?php echo $metin[110]?> :
            <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
          </label>
          <label>
            <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
          </label>
        </form>
        <br />
        <form id="aramak" name="aramak" method="get" action="rssEdit.php">
          <label title="<?php echo $metin[133]?>"> <?php echo $metin[29]?> :
            <input name="arama" type="text" size="20" maxlength="20" value="<?php echo $arayici?>" />
          </label>
          <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;" />
        </form>
        <?php
	endif;
 }
 
if (!empty($_GET["upd"]) and $_GET["upd"]=="1" && isset($_GET["id"]) ){
?>
        <br />
        <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
          <table width="500" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr valign="baseline">
              <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <?php echo $metin[131]?> </div></th>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><?php echo $metin[26]?> :</td>
              <td><?php echo $row_eoUsers['id']; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="title"> <?php echo $metin[126]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="title" id="title" value="<?php echo GetSQLValueStringNo($row_eoUsers['title'],"text"); ?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="description3"> <?php echo $metin[127]?> :</label></td>
              <td bgcolor="#CCFFFF"><textarea name="description3" id="description3" rows="5" cols="30" /><?php echo $row_eoUsers['description']; ?>
                </textarea>
                *</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="link3"> <?php echo $metin[128]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="link3" id="link3" value="<?php if (GetSQLValueStringNo($row_eoUsers['link'],"text")!='NULL') echo GetSQLValueStringNo($row_eoUsers['link'],"text"); ?>" size="32" />
                <font size="-1"><?php echo $metin[120]?></font></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="pubDate"> <?php echo $metin[129]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="pubDate" id="pubDate" value="<?php if (GetSQLValueStringNo($row_eoUsers['pubDate'],"text")!='NULL') echo tarihOku2(GetSQLValueStringNo($row_eoUsers['pubDate'],"text")); ?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[25]?>" />
                <input name="geri" type="button" id="geri" onclick="location.href = &quot;rssEdit.php&quot;;" value="<?php echo $metin[28]?>" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form3" />
          <input type="hidden" name="id" value="<?php echo $row_eoUsers['id']; ?>" />
        </form>
        <?php
		  }
if (isset($_GET["upd"]) and $_GET["upd"]!="1")
{
?>
        <br/>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table border="0" align="center" cellpadding="3" cellspacing="0">
            <tr valign="baseline">
              <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <?php echo $metin[130]?> </div></th>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="title2"> <?php echo $metin[126]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="title2" id="title2" value="" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="description2"> <?php echo $metin[127]?> :</label></td>
              <td bgcolor="#CCFFFF"><textarea name="description2" id="description2" rows="5" cols="30" />
                </textarea>
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="link2"> <?php echo $metin[128]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="link2" id="link2" value="" size="32" />
                <font size="-1"><?php echo $metin[120]?></font></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="pubDate2"> <?php echo $metin[129]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="pubDate2" id="pubDate2" value="<?php echo date("d-m-Y H:i:s")?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" nowrap="nowrap" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[132]?>" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
        <?php
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
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>