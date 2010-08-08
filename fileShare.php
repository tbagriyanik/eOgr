<?php 
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://www.tuzlaatl.k12.tr/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
       
	require("conf.php"); 
	$time = getmicrotime();  	
	checkLoginLang(true,true,"fileShare.php");	
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
<title>eOgr -<?php echo $metin[464]?></title>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[464]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if (in_array($tur, array("1","2","0")))	{
	 //

$currentPage = $_SERVER["PHP_SELF"];
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
   
  dosyaSil(RemoveXSS($_GET['id'])); 
  	
  $deleteSQL = sprintf("DELETE FROM eo_files WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_baglanti, $yol);
  $Result1 = mysql_query($deleteSQL, $yol) or die(mysql_error());
  if ($Result1) echo "<font id='uyari'>Se&ccedil;ili kayıt silinmiştir!</font>";  
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
		    $filtr2=" where ((eo_files.fileName like '%$arayici%' or eo_users.userName like '%$arayici%') and eo_users.id=eo_files.userID) ";
   } else {
		    $filtr2=" where (eo_users.id=eo_files.userID) ";
   }

if (empty($_SESSION["siraYonu2"])) {  
		$siraYonu="asc";
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
	    $query_eoUsers = "SELECT eo_files.id as id, eo_users.userName as userName, eo_files.fileName as fileName,
						eo_files.downloadCount as downloadCount 
						FROM eo_files,eo_users $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
	    $query_eoUsers = "SELECT eo_files.id as id, eo_users.userName as userName, eo_files.fileName as fileName,
						eo_files.downloadCount as downloadCount 
						FROM eo_files,eo_users $filtr2 ORDER BY eo_users.userName ASC";  
		$sirAlan="userName";
	   }

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
?>
                  <blockquote style="width:400px;"> <a href="lib/ajaxupload" onclick="window.open('lib/ajaxupload','upload','height=330,width=450,top=100,left=100,toolbar=no, location=no,directories=no,status=no,menubar=no,resizable=no,scrollbars=yes');
return false;" class="external">Dosya Paylaş</a> | <a href="fileShare.php">Tazele</a> </blockquote>
                  <?php	
if ($totalRows_eoUsers>0)
   {
?>
                  <form id="formSilme" name="formSilme" method="post" action="fileShare.php">
                    <table border="0" align="center" cellpadding="3" cellspacing="0" width="850">
                      <tr>
                        <th><?php if ($sirAlan=="id") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=id&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[26]?> </a></th>
                        <th width="138"><?php if ($sirAlan=="userName") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userName")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=userName&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[17]?> </a></th>
                        <th width="500"><?php if ($sirAlan=="fileName") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="fileName")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=fileName&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[465]?> </a></th>
                        <th ><?php if ($sirAlan=="downloadCount") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="downloadCount")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=downloadCount&amp;arama=<?php echo $_GET["arama"]?>&amp;ord=<?php echo $_GET["ord"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[466]?> </a></th>
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
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo getUserID2($row_eoUsers['userName']); ?>" rel="facebox"><?php echo araKalin($row_eoUsers['userName']); ?></a></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><?php 
						if(!file_exists($_uploadFolder.'/'.$row_eoUsers['fileName'])) { 
							echo " <img src='img/i_high.png' alt='no file' title='$metin[468]' /> ";
							echo araKalin(temizle($row_eoUsers['fileName']));
						} else {
							echo "<a href='fileDownload.php?id=".$row_eoUsers['id']."&amp;file=".$row_eoUsers['fileName'].
							      "' class='external'>".araKalin($row_eoUsers['fileName'])."</a>";
							echo " (".getSizeAsString(filesize($_uploadFolder.'/'.$row_eoUsers['fileName'])).") ";
							echo date ("d M Y H:i",filemtime($_uploadFolder.'/'.$row_eoUsers['fileName']));  
						}
?></td>
                        <td align='right' <?php echo "style=\"background-color: $row_color;\""?>><?php echo temizle($row_eoUsers['downloadCount']); ?></td>
                        <?php
						 if($row_eoUsers['userName']==$_SESSION["usern"] or $tur=="2") {
                        ?>
                        <td align="center" nowrap="nowrap" valign="middle" ><a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a></td>
                        <?php
						 }
                          ?>
                      </tr>
                      <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); 						
                      ?>
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
                  <form method="get" id="sayfaSec" name="sayfaSec" action="fileShare.php">
                    <p>
                      <label> <?php echo $metin[110]?> :
                        <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
                      </label>
                      <label>
                        <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
                      </label>
                    </p>
                  </form>
                    <?php
   }
 ?>                  
                  <form id="aramak" name="aramak" method="get" action="fileShare.php">
                   <p> <label> <?php echo $metin[29]?> :
                      <input name="arama" type="text" size="20" maxlength="20"  title="<?php echo $metin[469]?>" value="<?php echo $arayici?>" />
                    </label>
                    <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/></p>
                  </form>
                  <?php  
   }
if ($totalRows_eoUsers==0) echo "<font id='hata'> Arama sonucuna uyan bilgi bulunamadı veya hi&ccedil; kayıt yok!</font>";

if ($tur=="2") {
	$dosyUpload = dosya_uploads_uyumu();
	if(empty($dosyUpload))
	  echo "<font id='uyari'> Veritabanı ile gönderme klasörü uyumludur!</font>";
	  else
	  echo "<font id='hata'> Veritabanı ile gönderme klasörü uyumlu değildir!<br/>$dosyUpload</font>";
}

	}
	else
	  die($metin[447]);
	
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
