<?php
session_start();
header("Content-Type: text/html; charset=iso-8859-9"); 

     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 

function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!@mysql_select_db($_db, $yol1))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}

function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    $metin = str_replace('"', '�', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "�", $metin);
    $metin = str_replace(">", "�", $metin);
    $metin = iconv( "UTF-8", "ISO-8859-9",trim(htmlspecialchars($metin)));
    return $metin;
}

function getUserIDcomment($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}

function listeGetir($userID, $durum){
	global $yol1;							
	global $metin;	
	
		if(!empty($durum) && !empty($userID)) {			  
				
				$num = (int) substr($durum,0,15);
				
				switch($num){
					case 2:
					//en fazla &ccedil;al���lan konular
							$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
										FROM eo_4konu,eo_userworks 
										WHERE eo_4konu.id = eo_userworks.konuID
										GROUP BY konuAdi
										ORDER BY toplam DESC, konuAdi";							

							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)>0)  $ekle = "<ul>"; else return "";
							   
							   while($row_gelen = mysql_fetch_assoc($result1))
								$ekle .= "<li style=\"list-style-type:disc;\"><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
								
							   $ekle .= "</ul>";
							   echo $ekle;	
							   return ($ekle);
							}else {
							   return ("");
							}
							
							break;
					case 11:
					//�u anki kullan�c�n�n &ccedil;al��ma konular� ve say�lar�
							$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
										FROM eo_4konu,eo_userworks, eo_users 
										WHERE eo_4konu.id = eo_userworks.konuID and eo_users.id = eo_userworks.userID
											  and eo_users.id = ".$userID."
										GROUP BY konuAdi
										ORDER BY toplam DESC, konuAdi";
							
							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)>0) $ekle = "<ul>"; else return "";	 
							   
							   while($row_gelen = mysql_fetch_assoc($result1)){
								$ekle .= "<li style='list-style-type:disc;'><a href='lessons.php?konu=".$row_gelen['id']."'>".$row_gelen['konuAdi']."</a> <font size='-3'>".$row_gelen['toplam']."</font></li>";
							   }
								
								$ekle .= "</ul>";
								echo $ekle;
							   return true;
							}else {
							   return "";
							}
							
							break;
							
					case 12:
					//�u anki kullan�c�n�n bitirdi�i dersler
							$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
												eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi, 
												sum(eo_userworks.toplamZaman) as toplam 
										FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
										WHERE eo_4konu.id = eo_userworks.konuID and 
											  eo_users.id = eo_userworks.userID and
											  eo_3ders.id = eo_4konu.dersID and
											  eo_2sinif.id = eo_3ders.sinifID and
											  eo_1okul.id = eo_2sinif.okulID and
											  eo_users.id = ".$userID."
										GROUP BY dersAdi
										ORDER BY toplam DESC";
							
							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)>0) $ekle = "<ul>"; else return "";	 
							   while($row_gelen = mysql_fetch_assoc($result1))
								$ekle .= "<li style='list-style-type:disc;'>".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - ".$row_gelen['dersAdi']." <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font></li>";
								
							   if(mysql_num_rows($result1)>0) $ekle .= "</ul>";
								echo $ekle;
							   return ($ekle);
							}else {
							   return ("");
							}
							
							break;
					
					case 13:
					//son g&uuml;ncellenen konular
							$sql = "SELECT eo_5sayfa.konuID as idsi, eo_4konu.konuAdi as kadi,".
								   "eo_3ders.dersAdi as dersAdi, max(eo_5sayfa.eklenmeTarihi) as tarih ".
								   "from eo_5sayfa, eo_4konu, eo_3ders ".
								   "where eo_5sayfa.konuID=eo_4konu.id ".
								   "and eo_4konu.dersID=eo_3ders.id ".
								   "GROUP BY kadi ".
								   "order by tarih desc,kadi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
									
									$ekle =  "<ul>";
									for($i=0;$i<@mysql_numrows($result);$i++){
										$data = mysql_fetch_assoc($result);
										$ekle .=  "<li style='list-style-type:disc;'>";
										if ($data["tarih"]=="0000-00-00 00:00:00")
											$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>";
											else
											$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]." - ".$data["dersAdi"]."</a>"." <font size='-3'>".tarihOku($data["tarih"])."</font>";
											
										$ekle .=  "</li>";
										}
										$ekle .=  "</ul>";
								 }		
								echo $ekle; 
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
					case 14:
					//en fazla oy verilen konular
							$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
								   " avg(eo_rating.value) as ortalama, count(eo_rating.value) as toplam ".
								   "from eo_rating, eo_4konu ".
								   "where eo_rating.konuID=eo_4konu.id ".
								   "GROUP BY kadi ".
								   "order by ortalama desc,kadi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
									
									$ekle =  "<ul>";
									for($i=0;$i<@mysql_numrows($result);$i++){
										$data = mysql_fetch_assoc($result);
										$ekle .=  "<li style='list-style-type:disc;'>";
										$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a>".
													  " <font size='1' title='$metin[273] : ".$data["toplam"].", $metin[274] : ".round($data["ortalama"],1)
													  ."'>".(round($data["ortalama"]))."</font>";								
										$ekle .=  "</li>";
										}
										$ekle .=  "</ul>";
								 }		
								 echo $ekle;
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
					case 15:
					//en fazla yorum eklenen konular
							$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
								   " count(*) as toplam ".
								   "from eo_comments, eo_4konu ".
								   "where eo_comments.konuID=eo_4konu.id ".
								   " and eo_comments.active=1 ".
								   "GROUP BY kadi ".
								   "order by toplam desc,kadi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
									
									$ekle =  "<ul>";
									for($i=0;$i<@mysql_numrows($result);$i++){
										$data = mysql_fetch_assoc($result);
										$ekle .=  "<li style='list-style-type:disc;'>";
										$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
											
										$ekle .=  "</li>";
										}
										$ekle .=  "</ul>";
								 }		
								 echo $ekle;
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
				case 16:
				//son demo �al��malar�
						$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
							   " count(*) as toplam ".
							   "from eo_userworks, eo_4konu ".
							   "where eo_userworks.konuID=eo_4konu.id ".
							   " and eo_userworks.userID=-1 ".
							   "GROUP BY kadi ".
							   "order by toplam desc,kadi";	
						$result = mysql_query($sql, $yol1);
						if($result)
						 {
							 if (@mysql_numrows($result) > 0) {
								
								$donguSon = @mysql_numrows($result);
								
								$ekle =  "<ul>";
								for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result);
									$ekle .=  "<li style='list-style-type:disc;'>";
									$ekle .=  "<a href=\"lessons.php?konu=".$data["idsi"]."\">".$data["kadi"]."</a> <font size='-3'>".($data["toplam"])."</font>";
										
									$ekle .=  "</li>";
									}
									$ekle .=  "</ul>";
							 }		
							 @mysql_free_result($result);
							 echo $ekle;
							return $ekle; 
						}else {
						   return ("");
						}
						
						break;		
				} //switch	
			
			return "";

}
		
	return false;
}

function tarihOku($gelenTarih){
	//Y-m-d > d-m-Y 	
	return date("d-m-Y", strtotime($gelenTarih));
}

function Sec2Time2($time){
  if(is_numeric($time)){
    $value = "";
    if($time >= 31556926){
      $value = floor($time/31556926)."y ";
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value .= floor($time/86400)."d ";
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value .= strlen(floor($time/3600))==1?"0".floor($time/3600).":":floor($time/3600).":";
      $time = ($time%3600);
    }
    if($time >= 60){
      $value .= strlen(floor($time/60))==1?"0".floor($time/60).":":floor($time/60).":";
      $time = ($time%60);
    }
    $value .= strlen(floor($time))==1?"0".floor($time)."s":floor($time)."s";
    return $value;
  }else{
    return (bool) FALSE;
  }
}

if (isset($_GET['case']) && !empty($_GET['case']) && getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="" ) {
	if ( !listeGetir(getUserIDcomment($_SESSION["usern"],$_SESSION["userp"]), temizle2($_GET['case'])) )		
		echo "PROBLEM!";
} elseif ($_GET['case']=="16") {
	if ( !listeGetir("-1", temizle2($_GET['case'])) )		
		echo "PROBLEM!";
}
else
   echo "EMPTY!";
   

?>