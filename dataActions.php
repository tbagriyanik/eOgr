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
	checkLoginLang(true,true,"dataActions.php");	
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
<title>eOgr -<?php echo $metin[66]?></title>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[66]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if ($tur=="2")	{
	 //yöneticiler işlem yapabilir
	 
$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_usertrack WHERE id=%s",
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

$adminGizle = temizle((isset($_GET["adminGizle"]))?$_GET["adminGizle"]:"");

$_SESSION["adminGizle"] = "";
if(!empty($_GET["go_button"]) and $_GET["go_button"]=="Filtrele" && empty($_GET["adminGizle"]))
 {  
  $adminGizle = "";
 }
  else
  {
  $adminGizle = "evet";
  }

if(empty($_GET["adminGizle"])) 
  $adminGizle = $_SESSION["adminGizle"];
  else
  $_SESSION["adminGizle"] = "";
$filtr2="";
if (isset($_GET['ord']) && $_GET['ord'] != "")
   {
	   if ($adminGizle=="evet") 
	     $adGiz = "userName not in (select userName from eo_users where userType='2')";
		 else
		 $adGiz = "1=1";
	   
	   switch($_GET['ord']){
	   case '0': $filtr2=" where processName='login.php' and $adGiz "; break;  
	   case '1': $filtr2=" where processName='lessonsEdit.php' and $adGiz"; break;  
	   case '2': $filtr2=" where processName='userSettings.php' and $adGiz"; break;  
	   case '3': $filtr2=" where processName='siteSettings.php' and $adGiz"; break;  
	   case '4': $filtr2=" where (processName='newUser.php' or processName='passwordRemember.php') and $adGiz"; break;  
	   default:  
			 $filtr2=" where $adgiz";	      
		 break;
	   }
   }

if ($adminGizle=="evet" && $adGiz=="") 
	 $filtr2=" where userName not in (select userName from eo_users where userType='2') ";  

$arayici =  temizle((isset($_GET['arama']))?$_GET['arama']:"");   
  if ($arayici!="") 
   {
	   if ($adminGizle=="evet")
		    $filtr2=" where (userName like '%$arayici%' or processName like '%$arayici%' or otherInfo like '%$arayici%' ) and userName not in (select userName from eo_users where userType='2') ";
	   else
		    $filtr2=" where (userName like '%$arayici%' or processName like '%$arayici%' or otherInfo like '%$arayici%' ) ";
   }

if(!empty($_POST["sil"]) && $_POST["silIzin"]=="evet") {
   $silinenler = "''";
   for ($i = 0; $i < count($_POST["sil"]); $i++)
      $silinenler .= ",'".temizle($_POST["sil"][$i])."'";
	$silSorgu= "DELETE FROM eo_usertrack WHERE id in ($silinenler)";
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
	
	  if ($sirAlan!="")
	    $query_eoUsers = "SELECT * FROM eo_usertrack $filtr2 ORDER BY $sirAlan $siraYonu";   
	   else {
	    $query_eoUsers = "SELECT * FROM eo_usertrack $filtr2 ORDER BY dateTime DESC";  
		$sirAlan="dateTime";
	   }
//echo  $query_eoUsers ;
 if (!empty($_GET["upd"]) and $_GET["upd"]=="1")
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
	   $s1 = (isset($_GET["ord"]))?$_GET["ord"]:"";
	   $a1 = (isset($_GET["arama"]))?$_GET["arama"]:"";
	   $aa1 = (isset($_GET["pageNum_eoUsers"]))?$_GET["pageNum_eoUsers"]:"";
	   
?>
                  <form id="formSilme" name="formSilme" method="post" action="dataActions.php">
                    <table border="0" align="center" cellpadding="3" cellspacing="0" width="850">
                      <tr align="center">
                        <th width="82"><?php if ($sirAlan=="id") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=id&amp;ord=<?php echo $s1?>&amp;arama=<?php echo $a1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[26]?> </a></th>
                        <th width="138"><?php if ($sirAlan=="userName") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userName")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=userName&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[17]?> </a></th>
                        <th width="161"><?php if ($sirAlan=="processName") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="processName")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=processName&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[31]?> </a></th>
                        <th width="136"><?php if ($sirAlan=="otherInfo") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="otherInfo")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=otherInfo&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[32]?> </a></th>
                        <th width="133"><?php if ($sirAlan=="dateTime") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="dateTime")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=dateTime&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> <?php echo $metin[33]?> </a></th>
                        <th width="100"><?php if ($sirAlan=="IP") {?>
                          <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="IP")?"desc":"asc"?>.png" alt="desc" border="0" style="vertical-align: middle;" />
                          <?php } ?>
                          <a href="?order=IP&amp;arama=<?php echo $a1?>&amp;ord=<?php echo $s1?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $aa1?>"> IP</a></th>
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
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo getUserID2($row_eoUsers['userName']); ?>" rel="facebox"><?php echo araKalin($row_eoUsers['userName']); ?></a></td>
                        <td <?php echo "style=\"background-color: $row_color;\""?>><a href='<?php echo ($row_eoUsers['processName']); ?>'><?php echo araKalin($row_eoUsers['processName']); ?></a></td>
                        <td <?php
						if(strpos($row_eoUsers['otherInfo'],"fail")!==false) 
							echo "style='background-color:#F44'";
						elseif(strpos($row_eoUsers['otherInfo'],"request")!==false)
							echo "style=\"background-color: #0F0;\"";
						else
							echo "style=\"background-color: $row_color;\"";
						?>><?php echo araKalin($row_eoUsers['otherInfo']); ?></td>
                        <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo tarihOku2($row_eoUsers['dateTime']); ?></td>
                        <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php   echo $row_eoUsers['IP'];  ?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>',<?php echo $row_eoUsers['id']; ?>,'<?php echo $metin[104]?>');"><img src="img/cross.png" alt="delete" width="16" height="16" border="0" style="vertical-align: middle;"  title="<?php echo $metin[102]?>"/></a> |
                          <input type="checkbox" name="sil[]" id="kayitSecici<?php echo $row_eoUsers['id']; ?>" value="<?php echo $row_eoUsers['id']; ?>" /></td>
                      </tr>
                      <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); ?>
                      <tr>
                        <td colspan="7" align="center" valign="middle" class="tabloAlt" ><label>
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
                  <form name="formFilt" id="formFilt" method="get" action="dataActions.php">
                    <p>
                      <select name="ord" id="ord">
                        <option value="" <?php if (!(strcmp("", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[107]?> </option>
                        <option value="0" <?php if (!(strcmp("0", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[143]?> </option>
                        <option value="1" <?php if (!(strcmp("1", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[144]?> </option>
                        <option value="2" <?php if (!(strcmp("2", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[145]?> </option>
                        <option value="3" <?php if (!(strcmp("3", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[146]?> </option>
                        <option value="4" <?php if (!(strcmp("4", htmlentities($s1)))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[147]?> </option>
                      </select>
                      <input type="submit" name="go_button" id= "go_button" value="<?php echo $metin[109]?>"/>
                      <label>
                        <input name="adminGizle" type="checkbox" id="adminGizle" value="evet" <?php echo ($adminGizle=="evet")?"checked='checked'":"" ?>/>
                        <?php echo $metin[142]?> </label>
                    </p>
                  </form>
                  <form method="get" id="sayfaSec" name="sayfaSec" action="dataActions.php">
                    <p>
                      <label> <?php echo $metin[110]?> :
                        <input name="pageCnt" type="text" id="pageCnt" value="<?php echo $maxRows_eoUsers?>" size="5" maxlength="5" />
                      </label>
                      <label>
                        <input type="submit" name="gonder" id="gonder" value="<?php echo $metin[30]?>" />
                      </label>
                    </p>
                  </form>
                  <form id="aramak" name="aramak" method="get" action="dataActions.php">
                    <label> <?php echo $metin[29]?> :
                      <input name="arama" type="text" size="20" maxlength="20" value="<?php echo $arayici?>"  title="<?php echo $metin[141]?>"/>
                    </label>
                    <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
                  </form>
                  <?php  
		if(istekteBulunanSay()>0)
			printf("<br/>$metin[663]",istekteBulunanSay());					  
   }
if ($totalRows_eoUsers==0) echo "<font id='hata'> $metin[497]</font><br/>Geri d&ouml;nmek i&ccedil;in <a href=dataActions.php>tıklatınız</a>";

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
