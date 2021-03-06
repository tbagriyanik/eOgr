﻿<?php  
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
  checkLoginLang(true,true,"siteSettings.php");	   
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
<title>eOgr -<?php echo $metin[472]?></title>
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
onaylı olarak silme
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
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[472]?> </span> </h2>
      <div class="PostContent">
        <?php
	if ($tur=="2")	{
	 //yönetici ise

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  if ( 
     GetSQLValueString($_POST['userName'], "text")=='NULL' || 
     GetSQLValueString($_POST['realName'], "text")=='NULL' || 
     GetSQLValueString($_POST['userEmail'], "text")=='NULL' || 
     GetSQLValueString($_POST['userBirthDate'], "text")=='NULL' || 
     GetSQLValueString($_POST['requestDate'], "text")=='NULL' || 
     GetSQLValueString($_POST['userType'], "text")=='NULL' ||
     GetSQLValueString($_POST['ayarlar'], "text")=='NULL'  	 
      )
	   echo "<font id='hata'>&Uuml;ye bilgilerinde eksik alanlar vardır.</font>";
	else{   

		if (!empty($_POST['prldeg']) and $_POST['prldeg']!="secili" && GetSQLValueString($_POST['userPassword'], "text")=='NULL')
          	 echo "<font id='hata'>Yeni bir parola yazmadınız!</font>";
			 
		else {  

		  if (!empty($_POST['prldeg']) and $_POST['prldeg']=="secili") 
			$updateSQL = sprintf("UPDATE eo_users SET userName=%s, realName=%s, userEmail=%s, userBirthDate='%s', userType=%s, requestDate='%s', ayarlar=%s WHERE id=%s",
							   temizle(GetSQLValueString($_POST['userName'], "text")),
							   temizle(GetSQLValueString($_POST['realName'], "text")),
							   temizle(GetSQLValueString($_POST['userEmail'], "text")),
							   tarihYap(temizle($_POST['userBirthDate'])),
							   temizle(GetSQLValueString($_POST['userType'], "int")),
							   tarihYap2(temizle($_POST['requestDate'])),
							   temizle(GetSQLValueString($_POST['ayarlar'], "text")),
							   temizle(GetSQLValueString($_POST['id'], "int"))
							   );
			else  
			$updateSQL = sprintf("UPDATE eo_users SET userName=%s, userPassword=sha1(%s), realName=%s, userEmail=%s, userBirthDate='%s', userType=%s, requestDate='%s', ayarlar=%s WHERE id=%s",
							   temizle(GetSQLValueString($_POST['userName'], "text")),
							   temizle(GetSQLValueString($_POST['userPassword'], "text")),
							   temizle(GetSQLValueString($_POST['realName'], "text")),
							   temizle(GetSQLValueString($_POST['userEmail'], "text")),
							   tarihYap(temizle($_POST['userBirthDate'])),
							   temizle(GetSQLValueString($_POST['userType'], "int")),
							   tarihYap2(temizle($_POST['requestDate'])),
							   temizle(GetSQLValueString($_POST['ayarlar'], "text")),
							   temizle(GetSQLValueString($_POST['id'], "int"))
							   );
		
		  //mysqli_select_db($_db, $yol);
		  $Result1 = mysqli_query($yol, $updateSQL);
		  if($Result1) {
			   	trackUser($currentFile,"success,MemberInfo",$adi);
				echo ("<font id='tamam'> $metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,MemberInfo",$adi);
				echo ("<font id='hata'> &Uuml;ye bilgilerinde hata olduğundan g&uuml;ncelleme işleminiz tamamlanamadı!</font>");
			}
		}
	}			
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 if ( 
     GetSQLValueString($_POST['userName2'], "text")=='NULL' || 
     GetSQLValueString($_POST['userPassword2'], "text")=='NULL' ||
     GetSQLValueString($_POST['realName2'], "text")=='NULL' || 
     GetSQLValueString($_POST['userEmail2'], "text")=='NULL' || 
     GetSQLValueString($_POST['userBirthDate2'], "text")=='NULL' || 
     GetSQLValueString($_POST['userType2'], "text")=='NULL' 
      )
	   echo "<font id='hata'>Yeni &uuml;ye bilgilerinde eksik alanlar vardır.</font>";
	else{   
	  
  $insertSQL = sprintf("INSERT INTO eo_users (userName, userPassword, realName, userEmail, userBirthDate, userType, requestDate) VALUES (%s, sha1(%s), %s, %s, '%s', %s, '%s')",

                       temizle(GetSQLValueString($_POST['userName2'], "text")),
                       temizle(GetSQLValueString($_POST['userPassword2'], "text")),
                       temizle(GetSQLValueString($_POST['realName2'], "text")),
                       temizle(GetSQLValueString($_POST['userEmail2'], "text")),
                       tarihYap(temizle($_POST['userBirthDate2'])),
                       temizle(GetSQLValueString($_POST['userType2'], "text")),
                       date("Y-n-j H:i:s") );

  //mysqli_select_db($_db, $yol);
  $Result1 = mysqli_query( $yol, $insertSQL);
  if ($Result1) {
			  trackUser($currentFile,"success,NewMember",$adi);
			  echo "<font id='tamam'> $metin[537]</font>";
  }
  else{
			  trackUser($currentFile,"fail,NewMember",$adi);
			  echo "<font id='hata'>Yeni &uuml;ye işleminiz tamamlanamadı! &Ouml;rneğin, aynı isimde bir &uuml;yelik zaten varolabilir.</font>";
  }
  }
}

$filtr1="";
$filtr2="";

$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
  if ($arayici!="") 
    $filtr2=" where (userName like '%$arayici%' or realName like '%$arayici%' ) ";
	else
	$filtr2=" where 1=1 ";

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (!empty($_GET['delCon']) and $_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_users WHERE id=%s",
                       temizle(GetSQLValueString($_GET['id'], "int")));

  ////mysqli_select_db($_db, $yol);
  $Result1 = mysqli_query($yol,$deleteSQL);
 if ($Result1) {
			  trackUser($currentFile,"success,DelMember",$adi);
			  echo "<font id='uyari'> $metin[501]</font>";
  }
  else{
			  trackUser($currentFile,"fail,DelMember",$adi);
			  echo "<font id='hata'>&Uuml;ye silme işleminiz tamamlanamadı!</font>";
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

////mysqli_select_db($_db, $yol);

if (isset($_GET['ord']) && $_GET['ord'] != "")
   {
	   $filtr1=" and userType=".GetSQLValueString($_GET['ord'], "int");
	   $filtr2=" where userType=".GetSQLValueString($_GET['ord'], "int");
   }

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
	   $query_eoUsers = "SELECT * FROM eo_users where id='$upID' $filtr1 ORDER BY $sirAlan $siraYonu";
	   else 
	   { 
	   $sirAlan = "requestDate";
	   $query_eoUsers = "SELECT * FROM eo_users where id='$upID' $filtr1 ORDER BY $sirAlan DESC";
	   }
   }
   else
    {
	  if ($sirAlan!="")
	    $query_eoUsers = "SELECT * FROM eo_users $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
  	    $sirAlan = "requestDate";
	    $query_eoUsers = "SELECT * FROM eo_users $filtr2 ORDER BY $sirAlan DESC";  
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
  $totalRows_eoUsers = temizle($_GET['totalRows_eoUsers']);
} else {
  $all_eoUsers = mysqli_query($yol,$query_eoUsers);
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

if (!isset($_GET["upd"]))
	$_GET["upd"]="";
 if ($_GET["upd"]!="1" && $totalRows_eoUsers>0)
   {
	   $s1 = (isset($_GET["ord"]))?$_GET["ord"]:"";
	   $a1 = (isset($_GET["arama"]))?$_GET["arama"]:"";
	   $aa1 = (isset($_GET["pageNum_eoUsers"]))?$_GET["pageNum_eoUsers"]:"";
	   
?>
        <table border="0" align="center" cellpadding="3" cellspacing="0" >
          <tr>
            <th width="50"><?php if ($sirAlan=="id") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=id&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[26]?> </a></th>
            <th width="150"><?php if ($sirAlan=="userName") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userName")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=userName&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[17]?> </a></th>
            <th width="200"><?php if ($sirAlan=="realName") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="realName")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=realName&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[19]?> </a></th>
            <th width="120"><?php if ($sirAlan=="userType") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userType")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"   border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=userType&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[22]?> </a></th>
            <th width="200"><?php if ($sirAlan=="requestDate") {?>
              <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="requestDate")?"desc":"asc"?>.png" alt="Sıralama Y&ouml;n&uuml;"  border="0" style="vertical-align: middle;"/>
              <?php } ?>
              <a href="?order=requestDate&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[23]?> </a></th>
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
          <tr bgcolor="#CCFFFF" title="<?php echo "[".$row_eoUsers['userEmail']."] ".tarihOku($row_eoUsers['userBirthDate']) ?>">
            <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo $row_eoUsers['id']; ?></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><a href='profil.php?kim=<?php echo $row_eoUsers['id']; ?>' rel="facebox"><?php echo araKalin($row_eoUsers['userName']); ?></a></td>
            <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo araKalin($row_eoUsers['realName']); ?></td>
            <td align="left" nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php  
	   if ($row_eoUsers['userType']=="-1") echo "<img src=\"img/pasif_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"pasif\"/> ".$metin[93];else
	   if ($row_eoUsers['userType']=="0") echo "<img src=\"img/ogr_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogrenci\"/> ".$metin[94];else
	   if ($row_eoUsers['userType']=="1") echo "<img src=\"img/ogrt_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"ogretmen\"/> ".$metin[95];else
	   if ($row_eoUsers['userType']=="2") echo "<img src=\"img/admin_user.png\" border=\"0\" style=\"vertical-align: middle;\" alt=\"admin\"/> ".$metin[96];else echo $metin[92];
	  ?></td>
            <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['requestDate']); ?></td>
            <td align="center" valign="middle" width="50" nowrap="nowrap" ><a href="<?php echo $currentPage;?>?id=<?php echo $row_eoUsers['id'];?>&amp;upd=1&amp;pageNum_eoUsers=<?php echo $pageNum_eoUsers?>"><img src="img/edit.png" alt="edit" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[103]?>"/></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[102]?>"/></a></td>
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
            <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, max(0, $pageNum_eoUsers - 1), $queryString_eoUsers); ?>"><img src="img/page-prev.gif" border="0"  alt="prev"/></a> </div></td>
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

if ($totalRows_eoUsers==0) echo( "<font id='hata'> Aranan &uuml;ye veya d&uuml;zenlenecek &uuml;ye bulunamadı!</font>");
                  

if ($_GET["upd"]=="1" && isset($_GET["id"]) ){
?>
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
          <table width="500" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr valign="baseline">
              <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <?php echo $metin[105]?> </div></th>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><?php echo $metin[26]?> :</td>
              <td><?php echo $row_eoUsers['id']; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="userName"> <?php echo $metin[17]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userName" id="userName" value="<?php echo GetSQLValueStringNo($row_eoUsers['userName'],"text"); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="userPassword"> <?php echo $metin[18]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userPassword" id="userPassword" value="" size="32" />
                <font color="red"> <?php echo $metin[90]?> </font></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="realName"> <?php echo $metin[19]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="realName" id="realName" value="<?php echo GetSQLValueStringNo($row_eoUsers['realName'],"text"); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="userEmail"> <?php echo $metin[20]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userEmail" id="userEmail" value="<?php echo GetSQLValueStringNo($row_eoUsers['userEmail'],"text"); ?>" size="32" />
                <a href="mail.php?to=<?php echo $row_eoUsers['id'] ?>" title="mail" target="_blank"><img src="img/email.png" border="0" style="vertical-align: middle;"/></a> | <a href="mailto:<?php echo $row_eoUsers['userEmail'] ?>?Subject=eOgr" title="mail" target="_blank"><img src="img/email.png" border="0" style="vertical-align: middle;"/></a></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="userBirthDate"> <?php echo $metin[21]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userBirthDate" id="userBirthDate" value="<?php echo tarihOku($row_eoUsers['userBirthDate']); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="userType"> <?php echo $metin[22]?> :</label></td>
              <td bgcolor="#CCFFFF"><select name="userType" id="userType">
                  <option value="" <?php if (!(strcmp("", GetSQLValueStringNo($row_eoUsers['userType'],"text")))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[106]?> </option>
                  <option value="-1" <?php if (!(strcmp(-1, GetSQLValueStringNo($row_eoUsers['userType'],"text")))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[93]?> </option>
                  <option value="0" <?php if (!(strcmp(0, GetSQLValueStringNo($row_eoUsers['userType'],"text")))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[94]?> </option>
                  <option value="1" <?php if (!(strcmp(1, GetSQLValueStringNo($row_eoUsers['userType'],"text")))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[95]?> </option>
                  <option value="2" <?php if (!(strcmp(2, GetSQLValueStringNo($row_eoUsers['userType'],"text")))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[96]?> </option>
                </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap"><label for="requestDate"> <?php echo $metin[23]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="requestDate" id="requestDate" value="<?php echo tarihOku2($row_eoUsers['requestDate']); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" bgcolor="#CCFFFF"><label> <?php echo $metin[113]?> : </label></td>
              <td><input type="text" name="ayarlar" id="ayarlar" value="<?php echo $row_eoUsers['ayarlar']; ?>" size="35" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" nowrap="nowrap"><label>
                  <input name="prldeg" type="checkbox" id="prldeg" checked="checked"  value="secili"/>
                  <?php echo $metin[24]?> </label></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[25]?>" />
                <input name="geri" type="button" id="geri" onclick="location.href = &quot;siteSettings.php&quot;;" value="<?php echo $metin[28]?>" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2"><?php echo $metin[91]?></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form3" />
          <input type="hidden" name="id" value="<?php echo $row_eoUsers['id']; ?>" />
        </form>
        <?php
		  }
if ($_GET["upd"]!="1"){
	if ($totalRows_eoUsers>0):
?>
        <br />
        <form name="formFilt" id="formFilt" method="post" action="siteSettings.php">
          <select name="jumpMenu" id="jumpMenu">
            <option value="siteSettings.php?ord=" <?php if (!(strcmp("", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[107]?> </option>
            <option value="siteSettings.php?ord=-1" <?php if (!(strcmp("-1", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[93]?> </option>
            <option value="siteSettings.php?ord=0" <?php if (!(strcmp("0", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[94]?> </option>
            <option value="siteSettings.php?ord=1" <?php if (!(strcmp("1", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[95]?> </option>
            <option value="siteSettings.php?ord=2" <?php if (!(strcmp("2", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[96]?> </option>
          </select>
          <input type="button" name="go_button" id= "go_button" value="<?php echo $metin[109]?>" onclick="MM_jumpMenuGo('jumpMenu','parent',0)" />
        </form>
        <br />
        <form method="get" id="sayfaSec" name="sayfaSec" action="siteSettings.php">
          <label> <?php echo $metin[110]?> :
            <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
          </label>
          <label>
            <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
          </label>
        </form>
        <?php 
	endif;
?>
        <br />
        <form id="aramak" name="aramak" method="get" action="siteSettings.php">
          <label title="<?php echo $metin[122]?>"> <?php echo $metin[29]?> :
            <input name="arama" type="text" size="20" maxlength="20" value="<?php echo $arayici?>" />
          </label>
          <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;" />
        </form>
        <br />
        <?php
		if(isimleriAyniUyeler()!="")
			echo "<p><strong>$metin[632] :</strong><br/>". isimleriAyniUyeler()."</p>";
		if(istekteBulunanSay()>0)
			printf("$metin[663]<br/>",istekteBulunanSay());	
?>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table border="0" align="center" cellpadding="3" cellspacing="0">
            <tr valign="baseline">
              <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <img src="img/user_add.gif" alt="<?php echo $metin[108]?>" width="16" height="16" border="0" style="vertical-align: middle;" /> <?php echo $metin[108]?> </div></th>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="userName2"> <?php echo $metin[17]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userName2" id="userName2" value="<?php echo (isset($_POST["userName2"]))?$_POST["userName2"]:""?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="userPassword2"> <?php echo $metin[18]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userPassword2" id="userPassword2" value="<?php echo (isset($_POST["userPassword2"]))?$_POST["userPassword2"]:""?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="realName2"> <?php echo $metin[19]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="realName2" id="realName2" value="<?php echo (isset($_POST["realName2"]))?$_POST["realName2"]:""?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="userEmail2"> <?php echo $metin[20]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userEmail2" id="userEmail2" value="<?php echo (isset($_POST["userEmail2"]))?$_POST["userEmail2"]:""?>" size="32" />
                *</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="userBirthDate2"> <?php echo $metin[21]?> :</label></td>
              <td bgcolor="#CCFFFF"><input type="text" name="userBirthDate2" id="userBirthDate2" value="<?php echo (isset($_POST["userBirthDate2"]))?$_POST["userBirthDate2"]:""?>" size="32" />
                <font size="-1">* <?php echo $metin[310]?></font></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><label for="userType2"> <?php echo $metin[22]?> :</label></td>
              <td bgcolor="#CCFFFF"><select name="userType2" id="userType2">
                  <option selected="selected" value="" > <?php echo $metin[106]?> </option>
                  <option value="-1"> <?php echo $metin[93]?> </option>
                  <option value="0"> <?php echo $metin[94]?> </option>
                  <option value="1"> <?php echo $metin[95]?> </option>
                  <option value="2"> <?php echo $metin[96]?> </option>
                </select>
                *</td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="center" nowrap="nowrap" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[27]?>" /></td>
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