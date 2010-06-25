<?php
session_start();

	$taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 
require("conf.php");	
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

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
    $metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = iconv( "ISO-8859-9","ISO-8859-9",trim(htmlspecialchars($metin)));
    return $metin;
}

function &rasgeleCevapHazirla($toplamCevapAdet)
	{
		$aranolar="";				
				
		$numbers = range (1,$toplamCevapAdet);//1-5 arasý cevap arasýnda
		srand ((float)microtime()*1000000);
		shuffle ($numbers);
		while (list (, $number) = each ($numbers)) {
			$aranolar .= "$number/";
			}
				
		return ($aranolar);
	}

function secenekleriGetir($id)
{
	global $yol1;
	global $metin;
	
	if(array_key_exists($id,$_SESSION["cevaplar"])) return "Zaten Cevap Verdiniz.";
	
    $sql1 = "SELECT id, secenek1, secenek2, secenek3, secenek4, secenek5, cevap FROM eo_5sayfa where id='$id' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
	   $cevap = temizle2(mysql_result($result1, 0, "cevap"));
	   $secenek1 = temizle2(mysql_result($result1, 0, "secenek1"));
	   $secenek2 = temizle2(mysql_result($result1, 0, "secenek2"));
	   $secenek3 = temizle2(mysql_result($result1, 0, "secenek3"));
	   $secenek4 = temizle2(mysql_result($result1, 0, "secenek4"));
	   $secenek5 = temizle2(mysql_result($result1, 0, "secenek5"));
	   
	   $sonuc = "";
	   
	   if($cevap!="" && $secenek1=="" && $secenek2=="" && $secenek3=="" && $secenek4=="" && $secenek5==""){
	     $sonuc = "<input type='text' size='20' maxlength='20' id='tekCevap' name='tekCevap' value='' onkeypress='    
		 var evt  = (evt) ? evt : ((event) ? event : null);  
		 var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		 	if (evt.keyCode == 13)  cevapDegerlendir(document.getElementById(\"tekCevap\").value,$id); '/><br/><br/>";
	     $sonuc .= "<input type='button' value='$metin[351]' onclick='cevapDegerlendir(document.getElementById(\"tekCevap\").value,$id);' />";
	   }
		else	{ 
		
  	   $toplamCevapAdedi=(!empty($secenek1))+(!empty($secenek2))+(!empty($secenek3))+(!empty($secenek4))+(!empty($secenek5));
				
	   $araCevDizi=split('[/]', rasgeleCevapHazirla($toplamCevapAdedi));

				switch ($araCevDizi[0])
				{
					case 1:$sor_a="a";$sor_a_met=$secenek1;break;
					case 2:$sor_a="b";$sor_a_met=$secenek2;break;
					case 3:$sor_a="c";$sor_a_met=$secenek3;break;
					case 4:$sor_a="d";$sor_a_met=$secenek4;break;
					case 5:$sor_a="e";$sor_a_met=$secenek5;break;
					default:$sor_a="a";$sor_a_met=$secenek1;
				}
				switch ($araCevDizi[1])
				{
					case 1:$sor_b="a";$sor_b_met=$secenek1;break;
					case 2:$sor_b="b";$sor_b_met=$secenek2;break;
					case 3:$sor_b="c";$sor_b_met=$secenek3;break;
					case 4:$sor_b="d";$sor_b_met=$secenek4;break;
					case 5:$sor_b="e";$sor_b_met=$secenek5;break;
					default:$sor_b="b";$sor_b_met=$secenek2;
				}
				switch ($araCevDizi[2])
				{
					case 1:$sor_c="a";$sor_c_met=$secenek1;break;
					case 2:$sor_c="b";$sor_c_met=$secenek2;break;
					case 3:$sor_c="c";$sor_c_met=$secenek3;break;
					case 4:$sor_c="d";$sor_c_met=$secenek4;break;
					case 5:$sor_c="e";$sor_c_met=$secenek5;break;
					default:$sor_c="c";$sor_c_met=$secenek3;
				}
				switch ($araCevDizi[3])
				{
					case 1:$sor_d="a";$sor_d_met=$secenek1;break;
					case 2:$sor_d="b";$sor_d_met=$secenek2;break;
					case 3:$sor_d="c";$sor_d_met=$secenek3;break;
					case 4:$sor_d="d";$sor_d_met=$secenek4;break;
					case 5:$sor_d="e";$sor_d_met=$secenek5;break;
					default:$sor_d="d";$sor_d_met=$secenek4;
				}
				switch ($araCevDizi[4])
				{
					case 1:$sor_e="a";$sor_e_met=$secenek1;break;
					case 2:$sor_e="b";$sor_e_met=$secenek2;break;
					case 3:$sor_e="c";$sor_e_met=$secenek3;break;
					case 4:$sor_e="d";$sor_e_met=$secenek4;break;
					case 5:$sor_e="e";$sor_e_met=$secenek5;break;
					default:$sor_e="e";$sor_e_met=$secenek5;
				}
				
	     if($secenek1!="")
			 $sonuc .= "<input type='button' value='A' style='width:50px;' onclick='cevapDegerlendir(\"$sor_a\",$id);' /> $sor_a_met<br/><br/>";
	     if($secenek2!="")
		     $sonuc .= "<input type='button' value='B' style='width:50px;'  onclick='cevapDegerlendir(\"$sor_b\",$id);' /> $sor_b_met<br/><br/>";
	     if($secenek3!="")
	    	 $sonuc .= "<input type='button' value='C' style='width:50px;'  onclick='cevapDegerlendir(\"$sor_c\",$id);' /> $sor_c_met<br/><br/>";
	     if($secenek4!="")
		     $sonuc .= "<input type='button' value='D' style='width:50px;'  onclick='cevapDegerlendir(\"$sor_d\",$id);' /> $sor_d_met<br/><br/>";
	     if($secenek5!="")
		     $sonuc .= "<input type='button' value='E' style='width:50px;'  onclick='cevapDegerlendir(\"$sor_e\",$id);' /> $sor_e_met";
		}
		
	   if($sonuc == "")
	     $sonuc = "$metin[350]";
       return $sonuc;
    }else {
	   return ("");
	}
}
		echo iconv( "ISO-8859-9","ISO-8859-9", "<h4>$metin[347]</h4>");
?>

<div id="cevapSonucu"></div>
<div id="cevapDegerlendirmeYeri">
  <?php
/*main*/
 if (isset($_GET['sayfa']) && is_numeric($_GET['sayfa']) && $_GET['sayfa']>0  ) {
		echo iconv( "ISO-8859-9","ISO-8859-9", secenekleriGetir(temizle2($_GET['sayfa'])));
 		}
?>
</div>
<script language="javascript">
function tekCevapFocus()
{
if (document.getElementById("tekCevap")!=null)  document.getElementById("tekCevap").focus();
}

window.setTimeout("tekCevapFocus()",500);
if (document.getElementById("cevapSuresi")!=null) fadeUp(document.getElementById("cevapSuresi"),255,0,0,150,0,0);
</script>