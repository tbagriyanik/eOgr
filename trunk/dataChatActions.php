<?php 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  require("conf.php");	$time = getmicrotime();
  
     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
	
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
        loading_image : 'loading.gif',
        close_image   : 'closelabel.gif'
      }) 
    })
</script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
/*
delWithCon:
onay ile silme i�lemi
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

	currentFileCheck("dataChatActions.php");
  
   $adi	=temizle(substr($_SESSION["usern"],0,15));
   $par	=temizle($_SESSION["userp"]);
  
	if($adi==""|| $par=="") die("<font id='hata'> ".$metin[403]."</font><br/>".$metin[402]); //EMPTY?
 
   $tur=checkRealUser($adi,$par);
	
	if ($tur<=-1 || $tur>2) { 
	   sessionDestroy();
	   die ("<font id='hata'> ".$metin[404]."</font><br/>".$metin[402]);
	  }
	  else 
	  {
		$_SESSION["tur"] 	= $tur;
	    $_SESSION["usern"] 	= $adi;
    	$_SESSION["userp"] 	= $par;
	  }	

	if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['aThing']) { 
	sessionDestroy();
		die("<font id='hata'> ".$metin[400]."</font><br/>".$metin[402]); //session?
		exit;
	}
  
	if ($tur=="-1")	{
	   sessionDestroy();
	   die ("<font id='hata'>Hesab�n�z pasif haldedir. ��lem yapma izniniz yoktur!</font>");
	 }else
	if ($tur=="2")	{
	 //

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_shoutbox WHERE messageid=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_baglanti, $yol);
  $Result1 = mysql_query($deleteSQL, $yol) or die(mysql_error());
  if ($Result1) echo "<font id='uyari'>Se&ccedil;ili kay�t silinmi�tir!</font>";
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

if(!empty($_POST["sil"]) && $_POST["silIzin"]=="evet") {
   $silinenler = "''";
   for ($i = 0; $i < count($_POST["sil"]); $i++)
      $silinenler .= ",'".$_POST["sil"][$i]."'";
	$silSorgu= "DELETE FROM eo_shoutbox WHERE messageid in ($silinenler)";
	$sonuc = mysql_query($silSorgu, $yol);
	if ($sonuc) 
	 echo "<font id='uyari'>Se&ccedil;ilen kay�t(lar) silinmi�tir</font>";
	 else
	 echo "<font id='hata'>Se&ccedil;ilen kay�t(lar) silinemedi!</font>";
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
	$query_limit_eoUsers = sprintf("%s", $query_eoUsers);
 else
	$query_limit_eoUsers = sprintf("%s LIMIT %d, %d", $query_eoUsers, $startRow_eoUsers, $maxRows_eoUsers);

$eoUsers = mysql_query($query_limit_eoUsers, $yol) or die(mysql_error());
//$eoUsers = mysql_query($query_eoUsers, $yol) or die(mysql_error());
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

if ($totalRows_eoUsers>0)
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
                        <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo araKalin(smileAdd(temizle($row_eoUsers['message']))); ?></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><?php
	   if ($row_eoUsers['ip']==0) echo "Bah&ccedil;e"; else
	   if ($row_eoUsers['ip']==1) echo "S�n�f1"; else
	   if ($row_eoUsers['ip']==2) echo "S�n�f2"; else
	   if ($row_eoUsers['ip']==3) echo "S�n�f3"; else
	   if ($row_eoUsers['ip']==4) echo "S�n�f4"; else
	   if ($row_eoUsers['ip']==5) echo "S�n�f5"; else
	   if ($row_eoUsers['ip']==6) echo "S�n�f6"; else
	   if ($row_eoUsers['ip']==7) echo "S�n�f7"; else
	   if ($row_eoUsers['ip']==9) echo "S�n�f9"; else
	   if ($row_eoUsers['ip']==8) echo "S�n�f8"; 
	  ?></td>
                        <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['date']); ?></td>
                        <td align="center" nowrap="nowrap" valign="middle" ><a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['messageid']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a> |
                          <input type="checkbox" name="sil[]" id="kayitSecici<?php echo $row_eoUsers['messageid']; ?>" value="<?php echo $row_eoUsers['messageid']; ?>" /></td>
                      </tr>
                      <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); ?>
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
if ($totalRows_eoUsers==0) echo "<font id='hata'> Arama sonucuna uyan bilgi bulunamad� veya hi&ccedil; kay�t yok!</font><br/>Geri d&ouml;nmek i&ccedil;in <a href=dataChatActions.php>t�klat�n�z</a>";

	}
	else
	  die("<p>&nbsp;</p><font id='hata'>Bu sayfa i&ccedil;in &ouml;�renci veya &ouml;�retmenlerin i�lem yapma izni yoktur!</font>");
	
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
