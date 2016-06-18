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
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Pragma: no-cache");
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
  require("conf.php");	
  $time = getmicrotime();
  checkLoginLang(true,true,"dataCommentList2.php");		
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
	<title>eOgr -<?php echo $metin[288]?></title>
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
	</head>
	<body>
    <?php require("menu.php");?>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[288]?> </span> </h2>
          <div class="PostContent">
            <?php
	if ($tur=="2" || $tur=="1")	{
	 //
$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

  $pageCnt=temizle((isset($_GET['pageCnt']))?$_GET['pageCnt']:"");

  if($pageCnt=="")  
    $pageCnt=GetSQLValueString((isset($_SESSION['pageCnt3']))?$_SESSION['pageCnt3']:"", "int"); 
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

//mysqli_select_db($_db, $yol);

$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
  if ($arayici!="") 
		    $filtr2=" LEFT OUTER JOIN eo_users ON eo_comments.userID = eo_users.id
						LEFT OUTER JOIN eo_4konu ON eo_comments.konuID = eo_4konu.id 
						where (userName like '%$arayici%' or konuAdi like '%$arayici%') ";
   else
		    $filtr2=" LEFT OUTER JOIN eo_users ON eo_comments.userID = eo_users.id 
						LEFT OUTER JOIN eo_4konu ON eo_comments.konuID = eo_4konu.id 
						";

if(!empty($_GET["id"])  && isset($_GET["value"]) and ($_GET["value"]=="0" || $_GET["value"]=="1")) {
	$gelenID = temizle($_GET["id"]);
	$gelenDeger = temizle($_GET["value"]);
	
	if($gelenDeger=="0") $gelenDeger = "1"; 
	else if ($gelenDeger=="1") $gelenDeger = "0";
	else $gelenDeger = "0";
	
	$gelenSorgu= "update eo_comments set active=$gelenDeger WHERE id = ($gelenID)";
	$sonuc = mysqli_query($yol, $gelenSorgu);
	if ($sonuc) {
	 echo "<font id='uyari'>Se&ccedil;ilen kayıt güncellendi</font>";
	 trackUser($currentFile,"CmtUpd-$gelenDeger-$gelenID",$adi);
	}
	 else
	 echo "<font id='hata'>Se&ccedil;ilen kayıt güncellenemedi!</font>";
	
}
 

if(empty($_GET["yonU"]))  $_GET["yonU"]="";

if (empty($_SESSION["siraYonu2"])) {  
		$siraYonu="desc";
		$_SESSION["siraYonu2"]=$siraYonu;
	}
	else
	if (!empty($_GET['siraYap']) and $_GET["yonU"]!="dur" && $_GET['siraYap']=="OK"){
	$siraYonu=($_SESSION["siraYonu2"]=="desc")?"asc":"desc";
	$_SESSION["siraYonu2"]=$siraYonu;
	}
	else
	$siraYonu=$_SESSION["siraYonu2"];
	
	$sirAlan=temizle((isset($_GET['order']))?$_GET['order']:"");
	
	  if ($sirAlan!="")
	    $query_eoUsers = "SELECT eo_comments.id as id, eo_comments.konuID as konuID, eo_users.id as userID, eo_comments.active, eo_comments.comment, eo_comments.commentDate,eo_users.userName as userName, eo_4konu.konuAdi as konuAdi FROM eo_comments $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
	    $query_eoUsers = "SELECT eo_comments.id as id, eo_comments.konuID as konuID, eo_users.id as userID, eo_comments.active,eo_comments.comment, eo_comments.commentDate, eo_users.userName as userName, eo_4konu.konuAdi as konuAdi FROM eo_comments $filtr2 ORDER BY eo_comments.commentDate DESC";  
		$sirAlan="commentDate";
	   }

 if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
	$query_limit_eoUsers = sprintf("%s", $query_eoUsers);
 else
	$query_limit_eoUsers = sprintf("%s LIMIT %d, %d", $query_eoUsers, $startRow_eoUsers, $maxRows_eoUsers);

$eoUsers = mysqli_query($yol, $query_limit_eoUsers);
 if (!$eoUsers) echo mysqli_error();
$row_eoUsers = @mysqli_fetch_assoc($eoUsers);
$totalRows_eoUsers = @mysqli_num_rows($eoUsers);

if (isset($_GET['totalRows_eoUsers'])) {
  $totalRows_eoUsers = $_GET['totalRows_eoUsers'];
} else {
  $all_eoUsers = mysqli_query($yol,$query_eoUsers);
  $totalRows_eoUsers = @mysqli_num_rows($all_eoUsers);
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

if ($totalRows_eoUsers>0)
   {
	   $s1 = (isset($_GET["ord"]))?$_GET["ord"]:"";
	   $a1 = (isset($_GET["arama"]))?$_GET["arama"]:"";
	   $aa1 = (isset($_GET["pageNum_eoUsers"]))?$_GET["pageNum_eoUsers"]:"";
	   
?>
            <table border="0" align="center" cellpadding="3" cellspacing="0" width="850">
              <tr align="center">
                <th><?php if ($sirAlan=="id") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=id&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[26]?> </a></th>
                <th width="138" nowrap="nowrap"><?php if ($sirAlan=="userName") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userName")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=userName&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[17]?> </a></th>
                <th width="200"><?php if ($sirAlan=="konuAdi") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="konuAdi")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=konuAdi&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[175]?> </a></th>
                <th width="20"  nowrap="nowrap"><?php if ($sirAlan=="active") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="active")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=active&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[291]?> </a></th>
                <th  width="200" nowrap="nowrap"><?php if ($sirAlan=="comment") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="comment")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=comment&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[290]?> </a></th>
                <th><?php if ($sirAlan=="commentDate") {?>
                  <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="commentDate")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                  <?php } ?>
                  <a href="?order=commentDate&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[33]?> </a></th>
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
                <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo $row_eoUsers['id']; ?></td>
                <td <?php echo "style=\"background-color: $row_color;\""?>><?php if ($row_eoUsers['userName']!='') {?>
                  <a href="profil.php?kim=<?php echo $row_eoUsers['userID']; ?>" rel="facebox"><?php echo araKalin($row_eoUsers['userName']); ?></a>
                  <?php
                       }
                         else
                         	echo araKalin("demo");
                       ?></td>
                <td <?php echo "style=\"background-color: $row_color;\""?>><a href="dersBilgisi.php?ders=<?php echo $row_eoUsers['konuID']; ?>" rel="facebox">
                  <?php
                        echo ($row_eoUsers['konuAdi'])?araKalin($row_eoUsers['konuAdi']):"<span class=bosVeri>###</span>";; 
						?>
                  </a></td>
                <td align="center" nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><a href="?arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;id=<?php echo $row_eoUsers['id']; ?>&amp;siraYap=OK&amp;value=<?php echo ($row_eoUsers['active'])?>&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo ($row_eoUsers['active']=="0")?"<img src='img/unchecked.gif' border='0'/>":"<img src='img/checked.gif' border='0' />"?> </a></td>
                <td align="left" <?php echo "style=\"background-color: $row_color;\""?> title="<?php echo ($row_eoUsers['comment']);?>"><?php echo araKalin(smileAdd((smartShort($row_eoUsers['comment'],45)))); ?></td>
                <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['commentDate']); ?></td>
              </tr>
              <?php } while ($row_eoUsers = mysqli_fetch_assoc($eoUsers)); ?>
              <tr>
                <td colspan="6" align="left" valign="middle" class="tabloAlt" ><?php echo $metin[292]?></td>
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
                <td><div align="center"> <a href="<?php printf("%s?pageNum_eoUsers=%d%s&amp;yonU=dur", $currentPage, $totalPages_eoUsers, $queryString_eoUsers); ?>"><img src="img/page-last.gif" border="0" alt="last" /></a> </div></td>
              </tr>
              <tr>
                <td colspan="4"><div align="center"><?php echo min($startRow_eoUsers + $maxRows_eoUsers, $totalRows_eoUsers) ?> / <?php echo $totalRows_eoUsers ?> </div></td>
              </tr>
            </table>
            <?php
   }
 ?>
            <br />
            <form id="aramak" name="aramak" method="get" action="dataCommentList2.php">
              <label> <?php echo $metin[29]?> :
                <input name="arama" type="text" size="20" maxlength="20"  title="<?php echo $metin[188]?>" value="<?php echo $arayici?>" />
              </label>
              <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
            </form>
            <?php  
   }else echo "<font id='hata'> Arama sonucuna uyan bilgi bulunamadı veya hi&ccedil; kayıt yok!</font>";
?>
            <?php
	}
	else {
	  @header("Location: error.php?error=10");	
	  die($metin[448]);
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