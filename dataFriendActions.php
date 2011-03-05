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
	ob_start();
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
	require("conf.php");	
	$time = getmicrotime();  
	checkLoginLang(true,true,"dataFriendActions.php");	
	$seciliTema=temaBilgisi();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo $metin[594]?></title>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
</script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="JavaScript" type="text/JavaScript">
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
/*
selAll:
tüm onay kutularının seçimini tersler
*/
function selAll()
{
    for (var i=0;i<document.formSilme.elements.length;i++)
    {
      var e=document.formSilme.elements[i];
      if (e.type == 'checkbox' && e.name !='tumunuSec' && e.name !='silIzin')
        e.checked=!e.checked;
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[594]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if ($tur=="2")	{
	 //yöneticiler işlem yapabilir
	 
$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {

			$updateSQL = sprintf("UPDATE eo_friends SET duvarYazisi=%s WHERE id=%s",
							   RemoveXSS(GetSQLValueString($_POST['wall'], "text")),
							   temizle(GetSQLValueString($_POST['id'], "int"))
							   );
		
		  mysql_select_db($_db, $yol);
		  $Result1 = mysql_query($updateSQL, $yol);
		  if($Result1) {
			   	trackUser($currentFile,"success,WallInfo",$adi);
				echo ("<font id='tamam'>$metin[536]</font>");
		    }
			else {
			    trackUser($currentFile,"fail,WallInfo",$adi);
				echo ("<font id='hata'>$metin[626]</font>");
			}
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_friends WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($_db, $yol);
  $Result1 = mysql_query($deleteSQL, $yol) or die(mysql_error());
  if ($Result1) echo "<font id='uyari'>$metin[501]</font>";
}
  
  $pageCnt=GetSQLValueString((isset($_GET['pageCnt']))?$_GET['pageCnt']:"", "int");

  if($pageCnt=="NULL")  
    $pageCnt=GetSQLValueString((isset($_SESSION['pageCnt2']))?$_SESSION['pageCnt2']:"", "int"); 
	else
	$_SESSION['pageCnt2']=$pageCnt;
  
  if ($pageCnt>=1)
	$maxRows_eoUsers = $pageCnt;
    else
	$maxRows_eoUsers = ayarGetir("veriHareketleriSayisi");
	
$pageNum_eoUsers = 0;
if (isset($_GET['pageNum_eoUsers'])) {
  $pageNum_eoUsers = $_GET['pageNum_eoUsers'];
}
$startRow_eoUsers = $pageNum_eoUsers * $maxRows_eoUsers;

mysql_select_db($_db, $yol);

$filtr2=""; 
$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
  if ($arayici!="") 
   {
	    $filtr2=" where (userName like '%$arayici%' or duvarYazisi like '%$arayici%' ) ";
   }

if(!empty($_POST["sil"]) && !empty($_POST["silIzin"]) &&$_POST["silIzin"]=="evet") {
   $silinenler = "''";
   for ($i = 0; $i < count($_POST["sil"]); $i++)
      $silinenler .= ",'".temizle($_POST["sil"][$i])."'";
	$silSorgu= "DELETE FROM eo_friends WHERE id in ($silinenler)";
	$sonuc = mysql_query($silSorgu, $yol) or die(mysql_error());
	if ($sonuc) echo "<font id='uyari'>$metin[501]!</font>";
 }   

if(empty($_GET["yonU"]))  $_GET["yonU"]="";

if (empty($_SESSION["siraYonu"])) {  
		$siraYonu="desc";
		$_SESSION["siraYonu"]=$siraYonu;
	}
	else
	if (!empty($_GET['siraYap']) and $_GET["yonU"]!="dur" && $_GET['siraYap']=="OK"){
	$siraYonu=($_SESSION["siraYonu"]=="desc")?"asc":"desc";
	$_SESSION["siraYonu"]=$siraYonu;
	}
	else
	$siraYonu=$_SESSION["siraYonu"];
	
	$sirAlan=temizle((isset($_GET['order']))?$_GET['order']:"");
	
if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
   {
	   $upID =  GetSQLValueString($_GET['id'], "int"); 
	    $query_eoUsers = "
					SELECT eo_friends.id as id,eo_friends.*,eo_users.userName as userName FROM eo_friends
					INNER JOIN eo_users
					ON eo_users.id = eo_friends.davetEdenID
					WHERE eo_friends.id = '$upID'";   
   }
   else
    {
	  if ($sirAlan!="")
	    $query_eoUsers = "
					SELECT eo_friends.id as id,eo_friends.*,eo_users.userName as userName FROM eo_friends
					INNER JOIN eo_users
					ON eo_users.id = eo_friends.davetEdenID
					$filtr2 
					ORDER BY $sirAlan $siraYonu";   
	   else {
	    $query_eoUsers = "
					SELECT eo_friends.id as id,eo_friends.*,eo_users.userName as userName FROM eo_friends
					INNER JOIN eo_users
					ON eo_users.id = eo_friends.davetEdenID
					$filtr2 
					ORDER BY id DESC";  
		$sirAlan="id";
	   }
	}

 if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
	$query_limit_eoUsers = sprintf("%s", $query_eoUsers);
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

if (!empty($_GET["upd"]) and $_GET["upd"]=="1" && isset($_GET["id"]) ){	//güncelleme
?>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
                    <table width="500" border="0" align="center" cellpadding="3" cellspacing="0">
                      <tr valign="baseline">
                        <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <?php echo $metin[627]?> </div></th>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap"><?php echo $metin[26]?> :</td>
                        <td><?php echo $row_eoUsers['id']; ?></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap"><label for="wall"> <?php echo $metin[597]?> :</label></td>
                        <td bgcolor="#CCFFFF"><textarea name="wall" id="wall" cols="60" rows="8"><?php echo RemoveXSS($row_eoUsers['duvarYazisi']); ?></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td colspan="2" align="center" bgcolor="#CCFFFF" class="tabloAlt"><input type="submit" value="<?php echo $metin[25]?>" />
                          <input name="geri" type="button" id="geri" onclick="location.href = &quot;dataFriendActions.php&quot;;" value="<?php echo $metin[28]?>" /></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="form3" />
                    <input type="hidden" name="id" value="<?php echo $row_eoUsers['id']; ?>" />
                  </form>
                  <?php	
}
else if ($totalRows_eoUsers>0)
   {
	   $s1 = (isset($_GET["ord"]))?$_GET["ord"]:"";
	   $a1 = (isset($_GET["arama"]))?$_GET["arama"]:"";
	   $aa1 = (isset($_GET["pageNum_eoUsers"]))?$_GET["pageNum_eoUsers"]:"";
	   
?>
                  <form id="formSilme" name="formSilme" method="post" action="dataFriendActions.php">
                    <table border="0" align="center" cellpadding="3" cellspacing="0" width="850">
                      <tr align="center">
                        <th width="82"><?php if ($sirAlan=="id") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=id&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[26]?> </a></th>
                        <th ><?php if ($sirAlan=="davetEdenID") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="davetEdenID")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=davetEdenID&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[17]?> </a></th>
                        <th><?php if ($sirAlan=="davetEdilenID") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="davetEdilenID")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=davetEdilenID&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[17]?> </a></th>
                        <th><?php if ($sirAlan=="davetTarihi") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="davetTarihi")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=davetTarihi&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[595]?> </a></th>
                        <th><?php if ($sirAlan=="kabulTarihi") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="kabulTarihi")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=kabulTarihi&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[596]?> </a></th>
                        <th ><?php if ($sirAlan=="kabul") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="kabul")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=kabul&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[507]?></a></th>
                        <th ><?php echo $metin[597]?></th>
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
                        <td align="right" <?php echo "style=\"background-color: $row_color;\""?>  ><?php echo $row_eoUsers['id']; ?></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo ($row_eoUsers['davetEdenID']); ?>" rel="facebox"><?php echo araKalin($row_eoUsers['userName']); ?></a></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo ($row_eoUsers['davetEdilenID']); ?>" rel="facebox"><?php echo kullAdi($row_eoUsers['davetEdilenID']); ?></a></td>
                        <td nowrap="nowrap" align="right" <?php echo "style=\"background-color: $row_color;\"";?>><?php echo tarihOku($row_eoUsers['davetTarihi']); ?></td>
                        <td nowrap="nowrap" align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku($row_eoUsers['kabulTarihi']); ?></td>
                        <td align="center" <?php echo "style=\"background-color: $row_color;\""?>><?php echo arkadasKabulDurumu($row_eoUsers['kabul']);  ?></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?> title="<?php echo $row_eoUsers['duvarYazisi'];?>"><?php   echo araKalin(smartShort($row_eoUsers['duvarYazisi']));  ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><a href="<?php echo $currentPage;?>?id=<?php echo $row_eoUsers['id'];?>&amp;upd=1&amp;pageNum_eoUsers=<?php echo $pageNum_eoUsers?>"><img src="img/edit.png" alt="edit" width="16" height="16" border="0" style="vertical-align: middle;" title="<?php echo $metin[103]?>"/></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a> |
                          <input type="checkbox" name="sil[]" id="kayitSecici<?php echo $row_eoUsers['id']; ?>" value="<?php echo $row_eoUsers['id']; ?>" /></td>
                      </tr>
                      <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); ?>
                      <tr>
                        <td colspan="8" align="center" valign="middle" class="tabloAlt" ><label>
                            <input name="tumunuSec" type="checkbox" id="tumunuSec" onclick="selAll();" value="" />
                            <?php echo $metin[35]?> </label>
                          |
                          <label>
                            <input name="silIzin" type="checkbox" id="silIzin" value="evet" />
                            <?php echo $metin[36]?> </label>
                          <label>
                            <input type="submit" name="Sil" id="Sil" value="<?php echo $metin[37]?>" />
                          </label></td>
                      </tr>
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
                        <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, $totalPages_eoUsers, $queryString_eoUsers); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a> </div></td>
                      </tr>
                      <tr>
                        <td colspan="4"><div align="center"><?php echo min($startRow_eoUsers + $maxRows_eoUsers, $totalRows_eoUsers) ?> / <?php echo $totalRows_eoUsers ?> </div></td>
                      </tr>
                    </table>
                    <?php
   }
 ?>
                  </form>
                  <form method="get" id="sayfaSec" name="sayfaSec" action="dataFriendActions.php">
                    <p>
                      <label> <?php echo $metin[110]?> :
                        <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
                      </label>
                      <label>
                        <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
                      </label>
                    </p>
                  </form>
                  <form id="aramak" name="aramak" method="get" action="dataFriendActions.php">
                    <label> <?php echo $metin[29]?> :
                      <input name="arama" type="text" size="20" maxlength="20" value="<?php echo $arayici?>"  title="<?php echo $metin[598]?>"/>
                    </label>
                    <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
                  </form>
                  <?php  
   }
if ($totalRows_eoUsers==0) echo "<font id='hata'> $metin[497]</font><br/>Geri d&ouml;nmek i&ccedil;in <a href=dataFriendActions.php>tıklatınız</a>";

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
