<?php 
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"siteSettings.php");	   
  $seciliTema=temaBilgisi();	
  
  require("lib/SQL_Export.php");
 	 
 if(isset($_GET[dump]) && $_GET[dump]=="1")
  {
			$mysql_host = $_host;
			$mysql_database= $_db;	
			$mysql_username= $_username;	
			$mysql_password=$_password;		
			$print_form=0;
		
		  ob_start(); /* start buffering */  
		  echo "your cvs or sql output!";    
		  $content = _mysqldump($mysql_database); /* get the buffer */
		  ob_end_clean();
		  $content = gzencode($content, 9);    
		  header("Content-Type: application/force-download");
		  header("Content-Type: application/octet-stream");
		  header("Content-Type: application/download");
		  header("Content-Description: Download SQL Export");  
		  header('Content-Disposition: attachment; filename="'.$mysql_host."_".$mysql_database."_".date('YmdHis').'.txt.zip"'); 
		  echo $content;
		  die('');		
  }
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
<title>eOgr -<?php echo $metin[58]?></title>
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
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
onaylý olarak silme
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
          <h1 id="name-text" class="logo-name"><a href="index.php"> <?php echo ayarGetir("okulGenelAdi")?> </a></h1>
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
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[58]?> </span> </h2>
                <div class="PostContent">
                  <?php
	if ($tur=="2")	{
	 //

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_settings"])) && ($_POST["MM_settings"] == "form5")) {

  if ( 
     temizle($_POST['okulGenelAdi'])=="" || 
     temizle($_POST['versiyon'])=="" || 
     temizle($_POST['sayfaBlokSayisi'])=="" || 
     temizle($_POST['sayfaKullaniciSayisi'])=="" || 
     temizle($_POST['ayar1int'])=="" || 
     temizle($_POST['ayar2int'])=="" || 
     temizle($_POST['ayar3int'])=="" || 
     temizle($_POST['veriHareketleriSayisi'])==""
      )
	   echo "<font id='hata'>Site bilgilerinde eksik alanlar vardýr.</font>";
	else{   
			
			if(empty($_POST['ayar5char1'])) $_POST['ayar5char1']="0"; else $_POST['ayar5char1']="1";
			if(empty($_POST['ayar5char2'])) $_POST['ayar5char2']="0"; else $_POST['ayar5char2']="1";
			if(empty($_POST['ayar5char3'])) $_POST['ayar5char3']="0"; else $_POST['ayar5char3']="1";
			if(empty($_POST['ayar5char4'])) $_POST['ayar5char4']="0"; else $_POST['ayar5char4']="1";
			if(empty($_POST['ayar5char5'])) $_POST['ayar5char5']="0"; else $_POST['ayar5char5']="1";
			if(empty($_POST['ayar5char6'])) $_POST['ayar5char6']="0"; else $_POST['ayar5char6']="1";
			if(empty($_POST['ayar5char7'])) $_POST['ayar5char7']="0"; else $_POST['ayar5char7']="1";
			if(empty($_POST['ayar5char8'])) $_POST['ayar5char8']="0"; else $_POST['ayar5char8']="1";
			if(empty($_POST['ayar5char9'])) $_POST['ayar5char9']="0"; else $_POST['ayar5char9']="1";
			if(empty($_POST['ayar5char10'])) $_POST['ayar5char10']="0"; else $_POST['ayar5char10']="1";
			if(empty($_POST['ayar5char11'])) $_POST['ayar5char11']="0"; else $_POST['ayar5char11']="1";
			if(empty($_POST['ayar5char12'])) $_POST['ayar5char12']="0"; else $_POST['ayar5char12']="1";
			if(empty($_POST['ayar5char13'])) $_POST['ayar5char13']="0"; else $_POST['ayar5char13']="1";
			if(empty($_POST['ayar5char14'])) $_POST['ayar5char14']="0"; else $_POST['ayar5char14']="1";
			if(empty($_POST['ayar5char15'])) $_POST['ayar5char15']="0"; else $_POST['ayar5char15']="1";
			
			$ayar5char = temizle($_POST['ayar5char1']."-".$_POST['ayar5char2']."-".$_POST['ayar5char3']."-".
						         $_POST['ayar5char4']."-".$_POST['ayar5char5']."-".$_POST['ayar5char6']."-".
								 $_POST['ayar5char7']."-".$_POST['ayar5char8']."-".$_POST['ayar5char9']."-".
								 $_POST['ayar5char10']."-".$_POST['ayar5char11']."-".$_POST['ayar5char12']."-".
								 $_POST['ayar5char13']."-".$_POST['ayar5char14']."-".$_POST['ayar5char15']);

			$updateSQL = sprintf("UPDATE eo_sitesettings SET okulGenelAdi=%s, versiyon=%s, sayfaBlokSayisi=%s, sayfaKullaniciSayisi=%s, veriHareketleriSayisi=%s, ayar4char=%s, ayar1int=%s, ayar2int=%s, ayar3int=%s, ayar5char='%s' WHERE id=1",
							   temizle(GetSQLValueString($_POST['okulGenelAdi'], "text")),
							   temizle(GetSQLValueString($_POST['versiyon'], "text")),
							   temizle(GetSQLValueString($_POST['sayfaBlokSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['sayfaKullaniciSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['veriHareketleriSayisi'], "int")),
							   temizle(GetSQLValueString($_POST['ayar4char'], "text")),
							   temizle(GetSQLValueString($_POST['ayar1int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar2int'], "int")),
							   temizle(GetSQLValueString($_POST['ayar3int'], "int")),
							   $ayar5char
							   );
		  mysql_select_db($database_baglanti, $yol);
		  $Result1 = mysql_query($updateSQL, $yol);
		  if($Result1) {
			   	trackUser($currentFile,"success,SiteInfo",$adi);
				echo ("<font id='tamam'> Site bilgilerini g&uuml;ncelleme iþleminiz tamamlandý!</font>");
		    }
			else {
			    trackUser($currentFile,"fail,SiteInfo",$adi);
				echo ("<font id='hata'> Site bilgilerinde hata olduðunda g&uuml;ncelleme iþleminiz tamamlanamadý!</font>");
			}
	}
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
	   echo "<font id='hata'>&Uuml;ye bilgilerinde eksik alanlar vardýr.</font>";
	else{   

		if ($_POST['prldeg']!="secili" && GetSQLValueString($_POST['userPassword'], "text")=='NULL')
          	 echo "<font id='hata'>Yeni bir parola yazmadýnýz!</font>";
			 
		else {  

		  if ($_POST['prldeg']=="secili") 
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
		
		  mysql_select_db($database_baglanti, $yol);
		  $Result1 = mysql_query($updateSQL, $yol);
		  if($Result1) {
			   	trackUser($currentFile,"success,MemberInfo",$adi);
				echo ("<font id='tamam'> &Uuml;ye bilgilerini g&uuml;ncelleme iþleminiz tamamlandý!</font>");
		    }
			else {
			    trackUser($currentFile,"fail,MemberInfo",$adi);
				echo ("<font id='hata'> &Uuml;ye bilgilerinde hata olduðundan g&uuml;ncelleme iþleminiz tamamlanamadý!</font>");
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
	   echo "<font id='hata'>Yeni &uuml;ye bilgilerinde eksik alanlar vardýr.</font>";
	else{   
	  
  $insertSQL = sprintf("INSERT INTO eo_users (userName, userPassword, realName, userEmail, userBirthDate, userType, requestDate) VALUES (%s, sha1(%s), %s, %s, '%s', %s, '%s')",

                       temizle(GetSQLValueString($_POST['userName2'], "text")),
                       temizle(GetSQLValueString($_POST['userPassword2'], "text")),
                       temizle(GetSQLValueString($_POST['realName2'], "text")),
                       temizle(GetSQLValueString($_POST['userEmail2'], "text")),
                       tarihYap(temizle($_POST['userBirthDate2'])),
                       temizle(GetSQLValueString($_POST['userType2'], "text")),
                       date("Y-n-j H:i:s") );

  mysql_select_db($database_baglanti, $yol);
  $Result1 = mysql_query($insertSQL, $yol);
  if ($Result1) {
			  trackUser($currentFile,"success,NewMember",$adi);
			  echo "<font id='tamam'> Yeni &uuml;ye ekleme iþleminiz tamamlandý!</font>";
  }
  else{
			  trackUser($currentFile,"fail,NewMember",$adi);
			  echo "<font id='hata'>Yeni &uuml;ye iþleminiz tamamlanamadý! &Ouml;rneðin, ayný isimde bir &uuml;yelik zaten varolabilir.</font>";
  }
  }
}

$arayici =  temizle($_GET['arama']);   
  if ($arayici!="") 
    $filtr2=" where (userName like '%$arayici%' or realName like '%$arayici%' ) ";

if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1")) {
  $deleteSQL = sprintf("DELETE FROM eo_users WHERE id=%s",
                       temizle(GetSQLValueString($_GET['id'], "int")));

  mysql_select_db($database_baglanti, $yol);
  $Result1 = mysql_query($deleteSQL, $yol);
 if ($Result1) {
			  trackUser($currentFile,"success,DelMember",$adi);
			  echo "<font id='uyari'> &Uuml;ye silme iþleminiz tamamlandý!</font>";
  }
  else{
			  trackUser($currentFile,"fail,DelMember",$adi);
			  echo "<font id='hata'>&Uuml;ye silme iþleminiz tamamlanamadý!</font>";
  }

}
  
  $pageCnt=GetSQLValueString($_GET['pageCnt'], "int");

  if($pageCnt=="NULL")  
    $pageCnt=GetSQLValueString($_SESSION['pageCnt'], "int"); 
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

mysql_select_db($database_baglanti, $yol);

if (isset($_GET['ord']) && $_GET['ord'] != "")
   {
	   $filtr1=" and userType=".GetSQLValueString($_GET['ord'], "int");
	   $filtr2=" where userType=".GetSQLValueString($_GET['ord'], "int");
   }

if (empty($_SESSION["siraYonu"])) {  
		$siraYonu="desc";
		$_SESSION["siraYonu"]=$siraYonu;
	} else {
		if ($_GET["yonU"]!="dur" && $_GET['siraYap']=="OK"){
			$siraYonu=($_SESSION["siraYonu2"]=="desc")?"asc":"desc";
			$_SESSION["siraYonu2"]=$siraYonu;
			}
	else
		$siraYonu=$_SESSION["siraYonu2"];
	}

$sirAlan = temizle($_GET['order']);
	
if ($_GET["upd"]=="1")
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
	

 if(isset($_POST[sqlial]) && $_POST[sqlial]=="sqlimp")
  {
			require("lib/SQL_Import.php");

			mysql_query("SET NAMES 'latin1'");
			mysql_query("SET CHARACTER SET latin1");
			mysql_query("SET COLLATION_CONNECTION = 'latin1_turkish_ci'");

			$host =  $_host;
			$dbUser =  $_username;
			$dbPassword =  $_password;
				$sqlGelen = str_replace("\'", "'", $_POST["sqlAl"]);
				$sqlGelen = str_replace('\"', '"', $sqlGelen);
				/*$sqlGelen = str_replace( 'Ä±', 'ý',$sqlGelen);
				$sqlGelen = str_replace('Ã¼','&uuml;',  $sqlGelen);
				$sqlGelen = str_replace('ÄY','ð',  $sqlGelen);
				$sqlGelen = str_replace('ÅY','þ',  $sqlGelen);
				$sqlGelen = str_replace('Ã§','&ccedil;',  $sqlGelen);
				$sqlGelen = str_replace('Ã¶','&ouml;',  $sqlGelen);*/
			$sqlFile = $sqlGelen;
			
			$baglan2=mysql_connect($host, $dbUser, $dbPassword);
			
			//echo $sqlFile;
			
			if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
			
			$yol22 = $baglan2;
			
			if (mysql_select_db( $_db, $yol22)) {
			
					$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);
						
					$importumuz = $newImport -> importa ();
					
					if ($importumuz == 0)
						echo "<font id='tamam'>Veritabanýnda deðiþiklik(ler) yapýldý!</font><br/>";
					 else
						echo "<font id='hata'>".$importumuz."</font><br/>";
				//mysql_close($yol22);			
			}		
			 
  }

 if(isset($_GET["optim"]) && $_GET["optim"]=="1")
  {
			require("lib/SQL_Import.php");

			$host =  $_host;
			$dbUser =  $_username;
			$dbPassword =  $_password;
			$sqlFile = "REPAIR  TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating; OPTIMIZE TABLE eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_5sayfa, eo_floodprotection, eo_shoutbox, eo_sitesettings, eo_users, eo_sinifogre, eo_usertrack, eo_userworks, eo_webref_rss_details, eo_webref_rss_items,eo_comments,eo_rating;";
			
			$baglan2=mysql_connect($host, $dbUser, $dbPassword);
			
			if(!$baglan2)echo("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
			
			$yol22 = $baglan2;
			
			if (mysql_select_db( $_db, $yol22)) {
			
					$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);
						
					$importumuz = $newImport -> importa ();
					
					if ($importumuz == 0){
						die ("<font id='tamam'>Tablolarýn optimizasyon ve tamir iþlemleri bitti!<br/>Geri dönmek için <a href=siteSettings.php>týklatýnýz</a></font><br/>");
					}
					 else
						echo "<font id='hata'>".$importumuz."</font><br/>";
			mysql_close($yol22);				
			}	
			 
			$sqlFile = "";
  }	

 if ($_GET["upd"]=="1")
	$query_limit_eoUsers = sprintf("%s", $query_eoUsers);
 else
	$query_limit_eoUsers = sprintf("%s LIMIT %d, %d", $query_eoUsers, $startRow_eoUsers, $maxRows_eoUsers);

$eoUsers = mysql_query($query_limit_eoUsers, $yol) or die(mysql_error());

$row_eoUsers = mysql_fetch_assoc($eoUsers);
$totalRows_eoUsers = mysql_num_rows($eoUsers);

if (isset($_GET['totalRows_eoUsers'])) {
  $totalRows_eoUsers = temizle($_GET['totalRows_eoUsers']);
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
        stristr($param, "siraYap") == false)  {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_eoUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_eoUsers = sprintf("&amp;totalRows_eoUsers=%d%s", $totalRows_eoUsers, $queryString_eoUsers);

if ($_GET["upd"]!="1" && $totalRows_eoUsers>0)
   {
?>
                  <table border="0" align="center" cellpadding="3" cellspacing="0" >
                    <tr>
                      <th width="50"><?php if ($sirAlan=="id") {?>
                        <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="Sýralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                        <?php } ?>
                        <a href="?order=id&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[26]?> </a></th>
                      <th width="150"><?php if ($sirAlan=="userName") {?>
                        <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userName")?"desc":"asc"?>.png" alt="Sýralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                        <?php } ?>
                        <a href="?order=userName&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[17]?> </a></th>
                      <th width="200"><?php if ($sirAlan=="realName") {?>
                        <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="realName")?"desc":"asc"?>.png" alt="Sýralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                        <?php } ?>
                        <a href="?order=realName&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[19]?> </a></th>
                      <th width="120"><?php if ($sirAlan=="userType") {?>
                        <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userType")?"desc":"asc"?>.png" alt="Sýralama Y&ouml;n&uuml;"   border="0" style="vertical-align: middle;"/>
                        <?php } ?>
                        <a href="?order=userType&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[22]?> </a></th>
                      <th width="200"><?php if ($sirAlan=="requestDate") {?>
                        <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="requestDate")?"desc":"asc"?>.png" alt="Sýralama Y&ouml;n&uuml;"  border="0" style="vertical-align: middle;"/>
                        <?php } ?>
                        <a href="?order=requestDate&amp;ord=<?php echo $_GET["ord"]?>&amp;arama=<?php echo $_GET["arama"]?>&amp;siraYap=OK&amp;pageNum_eoUsers=<?php echo $_GET['pageNum_eoUsers']?>"> <?php echo $metin[23]?> </a></th>
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
                    <?php } while ($row_eoUsers = mysql_fetch_assoc($eoUsers)); ?>
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
if ($totalRows_eoUsers==0) die( "<font id='hata'> Aranan &uuml;ye veya d&uuml;zenlenecek &uuml;ye bulunamadý!</font>");

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
                        <td bgcolor="#CCFFFF"><input type="text" name="userEmail" id="userEmail" value="<?php echo GetSQLValueStringNo($row_eoUsers['userEmail'],"text"); ?>" size="32" /></td>
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
?>
                  <br/>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table border="0" align="center" cellpadding="3" cellspacing="0">
                      <tr valign="baseline">
                        <th colspan="2" align="right" nowrap="nowrap"><div align="center"> <img src="img/user_add.gif" alt="<?php echo $metin[108]?>" width="16" height="16" border="0" style="vertical-align: middle;" /> <?php echo $metin[108]?> </div></th>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right"><label for="userName2"> <?php echo $metin[17]?> :</label></td>
                        <td bgcolor="#CCFFFF"><input type="text" name="userName2" id="userName2" value="<?php echo $_POST["userName2"]?>" size="32" />
                          *</td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right"><label for="userPassword2"> <?php echo $metin[18]?> :</label></td>
                        <td bgcolor="#CCFFFF"><input type="text" name="userPassword2" id="userPassword2" value="<?php echo $_POST["userPassword2"]?>" size="32" />
                          *</td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right"><label for="realName2"> <?php echo $metin[19]?> :</label></td>
                        <td bgcolor="#CCFFFF"><input type="text" name="realName2" id="realName2" value="<?php echo $_POST["realName2"]?>" size="32" />
                          *</td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right"><label for="userEmail2"> <?php echo $metin[20]?> :</label></td>
                        <td bgcolor="#CCFFFF"><input type="text" name="userEmail2" id="userEmail2" value="<?php echo $_POST["userEmail2"]?>" size="32" />
                          *</td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right"><label for="userBirthDate2"> <?php echo $metin[21]?> :</label></td>
                        <td bgcolor="#CCFFFF"><input type="text" name="userBirthDate2" id="userBirthDate2" value="<?php echo $_POST["userBirthDate2"]?>" size="32" />
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
                  <form name="formFilt" id="formFilt" method="post" action="siteSettings.php">
                    <select name="jumpMenu" id="jumpMenu">
                      <option value="siteSettings.php?ord=" <?php if (!(strcmp("", htmlentities($_GET["ord"])))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[107]?> </option>
                      <option value="siteSettings.php?ord=-1" <?php if (!(strcmp("-1", htmlentities($_GET["ord"])))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[93]?> </option>
                      <option value="siteSettings.php?ord=0" <?php if (!(strcmp("0", htmlentities($_GET["ord"])))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[94]?> </option>
                      <option value="siteSettings.php?ord=1" <?php if (!(strcmp("1", htmlentities($_GET["ord"])))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[95]?> </option>
                      <option value="siteSettings.php?ord=2" <?php if (!(strcmp("2", htmlentities($_GET["ord"])))) {echo "selected=\"selected\"";} ?>> <?php echo $metin[96]?> </option>
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
                  <br />
                  <form id="aramak" name="aramak" method="get" action="siteSettings.php">
                    <label title="<?php echo $metin[122]?>"> <?php echo $metin[29]?> :
                      <input name="arama" type="text" size="20" maxlength="20" value="<?php echo $arayici?>" />
                    </label>
                    <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;" />
                  </form>
                  <?php
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
                    <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <img src="img/database.gif" border="0" style="vertical-align: middle;" alt="database"/> <?php echo $metin[156]?> </span> </h2>
                    <div class="PostContent"> <span title="<?php echo $metin[111]?>"> <?php echo $metin[48]?> </span><br />
                      <span> <?php echo $metin[215]?> </span><br />
                      <br />
                      <form id="sqlimp" name="sqlimp" method="post" action="siteSettings.php">
                        <label title="<?php echo "SQL Import"?>"> <?php echo $metin[157]?> :
                          <textarea name="sqlAl" cols="85" rows="10"><?php echo $sqlFile?>
</textarea>
                        </label>
                        <input type="hidden" name="sqlial" value="sqlimp" />
                        <input name="al" type="submit" id="al" value="<?php echo $metin[158]?>"/>
                      </form>
                      <h4><?php echo $metin[211]?> :</h4>
                      eo_1okul (<?php echo getTableSize("eo_1okul"); ?>) - (<?php echo $metin[212]?>)<br />
                      <strong>eo_2sinif (<?php echo getTableSize("eo_2sinif"); ?>) :</strong> <?php echo yetimKayitNolar("eo_2sinif")?><br />
                      <strong>eo_3ders (<?php echo getTableSize("eo_3ders"); ?>) :</strong> <?php echo yetimKayitNolar("eo_3ders")?><br />
                      <strong>eo_4konu (<?php echo getTableSize("eo_4konu"); ?>) :</strong> <?php echo yetimKayitNolar("eo_4konu")?><br />
                      <strong>eo_5sayfa (<?php echo getTableSize("eo_5sayfa"); ?>) :</strong> <?php echo yetimKayitNolar("eo_5sayfa")?><br />
                      <strong>eo_userworks (<?php echo getTableSize("eo_userworks"); ?>) :</strong> <?php echo yetimKayitNolar("eo_userworks")?><br />
                      <strong>eo_sinifogre (<?php echo getTableSize("eo_sinifogre"); ?>) :</strong> <?php echo yetimKayitNolar("eo_sinifogre")?><br />
                      <strong>eo_rating (<?php echo getTableSize("eo_rating"); ?>) :</strong> <?php echo yetimKayitNolar("eo_rating")?><br />
                      <strong>eo_comments (<?php echo getTableSize("eo_comments"); ?>) :</strong> <?php echo yetimKayitNolar("eo_comments")?><br />
                      eo_users (<?php echo getTableSize("eo_users"); ?>) - (<?php echo $metin[212]?>)<br />
                      eo_shoutbox (<?php echo getTableSize("eo_shoutbox"); ?>) - (<?php echo $metin[212].", ".$metin[238]; ?>)<br />
                      eo_usertrack (<?php echo getTableSize("eo_usertrack"); ?>) - (<?php echo $metin[212].", ".$metin[238];?>)<br />
                      eo_floodprotection (<?php echo getTableSize("eo_floodprotection"); ?>) - (<?php echo $metin[212]?>)<br />
                      eo_sitesettings (<?php echo getTableSize("eo_sitesettings"); ?>) - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_details (<?php echo getTableSize("eo_webref_rss_details"); ?>) - (<?php echo $metin[212]?>)<br />
                      eo_webref_rss_items (<?php echo getTableSize("eo_webref_rss_items"); ?>) - (<?php echo $metin[212]?>)<br />
                    </div>
                    <div class="cleared"></div>
                  </div>
                </div>
              </div>
              <div class="cleared"></div>
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
                        <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"> <?php echo $metin[112]?> </span> </h2>
                        <div class="PostContent">
                          <form name="form5"  action="siteSettings.php" method="post">
                            <table width="90%" border="0" cellspacing="0" cellpadding="3">
                              <tr>
                                <th colspan="2"><?php echo $metin[113]?></th>
                              </tr>
                              <tr>
                                <td width="400" align="right"><label for="okulGenelAdi"> <?php echo $metin[114]?> :</label></td>
                                <td><input type="text" maxlength="15" size="15" name="okulGenelAdi" id="okulGenelAdi" value="<?php echo ayarGetir("okulGenelAdi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="versiyon"> <?php echo $metin[115]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="versiyon" id="versiyon" value="<?php echo ayarGetir("versiyon")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="sayfaBlokSayisi"> <?php echo $metin[116]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="sayfaBlokSayisi" id="sayfaBlokSayisi" value="<?php echo ayarGetir("sayfaBlokSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="sayfaKullaniciSayisi"> <?php echo $metin[117]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="sayfaKullaniciSayisi" id="sayfaKullaniciSayisi" value="<?php echo ayarGetir("sayfaKullaniciSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="veriHareketleriSayisi"> <?php echo $metin[118]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="veriHareketleriSayisi" id="veriHareketleriSayisi" value="<?php echo ayarGetir("veriHareketleriSayisi")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar1int"> <?php echo $metin[150]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar1int" id="ayar1int" value="<?php echo ayarGetir("ayar1int")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar2int"> <?php echo $metin[151]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar2int" id="ayar2int" value="<?php echo ayarGetir("ayar2int")?>"/>
                                  *</td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar3int"> <?php echo $metin[245]?> :</label></td>
                                <td><input type="text" maxlength="10" size="10" name="ayar3int" id="ayar3int" value="<?php echo ayarGetir("ayar3int")?>"/>
                                  * </td>
                              </tr>
                              <tr>
                                <td align="right"><label for="ayar4char"> <?php echo $metin[119]?> :</label></td>
                                <td><input type="text" maxlength="50" size="30" name="ayar4char" id="ayar4char" value="<?php echo ayarGetir("ayar4char")?>"/>
                                  <font size="-1"><?php echo $metin[120]?></font></td>
                              </tr>
                              <tr>
                                <td align="right"><?php echo $metin[216]?> :</td>
                                <?php
								  $secenekler = explode("-",ayarGetir("ayar5char"));
								?>
                                <td><label>
                                    <input type="checkbox" name="ayar5char1" 
            id="ayar5char1" value="1" <?php if($secenekler[0]=="1") 
			echo " checked='checked'"; else echo ""; ?> />
                                    RSS</label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char2" 
            id="ayar5char2" value="1" <?php if($secenekler[1]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[154];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char3" 
            id="ayar5char3" value="1" <?php if($secenekler[2]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[139];?></label>
                                  <br/>
                                  <label>
                                    <input type="checkbox" name="ayar5char4" 
            id="ayar5char4" value="1" <?php if($secenekler[3]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[155];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char5" 
            id="ayar5char5" value="1" <?php if($secenekler[4]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[217];?></label>
                                  <br /></td>
                              </tr>
                              <tr>
                                <td align="right"><?php echo $metin[255]?> :</td>
                                <td><label>
                                    <input type="checkbox" name="ayar5char7" 
            id="ayar5char7" value="1" <?php if($secenekler[6]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[257];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char8" 
            id="ayar5char8" value="1" <?php if($secenekler[7]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[258];?></label>
                                  <br/>
                                  <label>
                                    <input type="checkbox" name="ayar5char9" 
            id="ayar5char9" value="1" <?php if($secenekler[8]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[259];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char10" 
            id="ayar5char10" value="1" <?php if($secenekler[9]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[260];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char14" 
            id="ayar5char14" value="1" <?php if($secenekler[13]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[307];?></label>
                                  <br /></td>
                              </tr>
                              <tr>
                                <td align="right"><?php echo $metin[303]?> :</td>
                                <td><label>
                                    <input type="checkbox" name="ayar5char6" 
            id="ayar5char6" value="1" <?php if($secenekler[5]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[256];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char11" 
            id="ayar5char11" value="1" <?php if($secenekler[10]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[304];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char12" 
            id="ayar5char12" value="1" <?php if($secenekler[11]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[305];?></label>
                                  <br />
                                  <label>
                                    <input type="checkbox" name="ayar5char13" 
            id="ayar5char13" value="1" <?php if($secenekler[12]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[306];?></label>
                                  <br/>
                                  <label>
                                    <input type="checkbox" name="ayar5char15" 
            id="ayar5char15" value="1" <?php if($secenekler[14]=="1") 
			echo " checked='checked'"; else echo ""; ?>/>
                                    <?php echo $metin[308];?></label>
                                  <br /></td>
                              </tr>
                              <tr>
                                <td colspan="2" align="center"  class="tabloAlt"><input type="hidden" name="MM_settings" value="form5" />
                                  <input type="submit" value="<?php echo $metin[121]?>" />
                                  &nbsp;
                                  <input type="button" value="<?php echo $metin[246]?>" onclick="getDefaults();" /></td>
                              </tr>
                            </table>
                          </form>
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
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
/*
getDefaults:
site ayarlarýnýn varsayýlanlarýnýn atanmasý
*/
function getDefaults(){
	document.getElementById('okulGenelAdi').value = "Net Okul" ;
	document.getElementById('versiyon').value = "versiyon" ;
	document.getElementById('sayfaBlokSayisi').value = "5" ;
	document.getElementById('sayfaKullaniciSayisi').value = "10" ;
	document.getElementById('veriHareketleriSayisi').value = "10" ;
	document.getElementById('ayar1int').value = "5" ;
	document.getElementById('ayar2int').value = "10" ;
	document.getElementById('ayar3int').value = "10" ;
	document.getElementById('ayar4char').value = "admin@eogr.com" ;
	document.getElementById('ayar5char1').checked = true;
	document.getElementById('ayar5char2').checked = true;
	document.getElementById('ayar5char3').checked = true;
	document.getElementById('ayar5char4').checked = true;
	document.getElementById('ayar5char5').checked = true;
	document.getElementById('ayar5char6').checked = true;
	document.getElementById('ayar5char7').checked = true;
	document.getElementById('ayar5char8').checked = true;
	document.getElementById('ayar5char9').checked = true;
	document.getElementById('ayar5char10').checked = true;
	document.getElementById('ayar5char11').checked = true;
	document.getElementById('ayar5char12').checked = true;
	document.getElementById('ayar5char13').checked = true;
	document.getElementById('ayar5char14').checked = true;
	document.getElementById('ayar5char15').checked = true;
}
</script>
</body>
</html>
<?php 
@mysql_free_result($eoUsers);
?>