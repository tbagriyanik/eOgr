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
	
	@session_start();
	ob_start (); // Buffer output
	header("Content-Type: text/html; charset=utf-8");          

	$taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
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
/*
baglan2:
veritabaný baðlantýsý
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysqli_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!$yol1)
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}
/*
temizle2:
xss temizleme
*/
function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    //$metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlentities($metin));
    return $metin;
}
/*
rasgeleCevapHazirla:
cevap seçeneklerinin rasgele yerlerinin deðiþtirilmesi
*/
function &rasgeleCevapHazirla($toplamCevapAdet)
	{
		$aranolar="";				
				
		$numbers = range (1,$toplamCevapAdet);//1-6 arasý cevap arasýnda
		srand ((float)microtime()*1000000);
		shuffle ($numbers);
		while (list (, $number) = each ($numbers)) {
			$aranolar .= "$number/";
			}
				
		return ($aranolar);
	}
/*
secenekleriGetir:
soru seçeneklerinin getirilmesi
*/
function secenekleriGetir($id)
{
	global $yol1;
	global $metin;

	if(@array_key_exists($id,$_SESSION["cevaplar"]))
	 if($_SESSION["cevaplar"][$id]=="D")
	  return "Zaten Cevap Verdiniz.";

    $sql1 = "SELECT id, secenek1, secenek2, secenek3, secenek4, secenek5, secenek6, cevap FROM eo_5sayfa where id='$id' limit 0,1"; 	

    $result1 = mysqli_query($yol1, $sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1)
    {
	   $cevap = temizle2(mysqli_result($result1, 0, "cevap"));
	   $secenek1 = temizle2(mysqli_result($result1, 0, "secenek1"));
	   $secenek2 = temizle2(mysqli_result($result1, 0, "secenek2"));
	   $secenek3 = temizle2(mysqli_result($result1, 0, "secenek3"));
	   $secenek4 = temizle2(mysqli_result($result1, 0, "secenek4"));
	   $secenek5 = temizle2(mysqli_result($result1, 0, "secenek5"));
	   $secenek6 = temizle2(mysqli_result($result1, 0, "secenek6"));
	   
	   $sonuc = "";
	   
	   if($cevap!="" && $secenek1=="" && $secenek2=="" && $secenek3=="" && $secenek4=="" && $secenek5=="" && $secenek6==""){
		   //KLASÝK soru türü
	     $sonuc = "<input type='text' size='20' maxlength='20' id='tekCevap' name='tekCevap' value='' onkeypress='    
		 var evt  = (evt) ? evt : ((event) ? event : null);  
		 var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		 	if (evt.keyCode == 13)  cevapDegerlendir(document.getElementById(\"tekCevap\").value,$id); '/><br/><br/>";
	     $sonuc .= "<input type='button' value='$metin[351]' onclick='cevapDegerlendir(document.getElementById(\"tekCevap\").value,$id);' />";
	   }
		else if (strlen($cevap)==1)	{ 
		 //TEK SEÇENEK doðru - TEST
  	   $toplamCevapAdedi=(!empty($secenek1))+(!empty($secenek2))+(!empty($secenek3))+(!empty($secenek4))+(!empty($secenek5))+(!empty($secenek6));
				
	   $araCevDizi=preg_split('$[/]$', rasgeleCevapHazirla($toplamCevapAdedi));
			
			if(isset($araCevDizi[0]))
				switch ($araCevDizi[0])
				{
					case 1:$sor_a="a";$sor_a_met=$secenek1;break;
					case 2:$sor_a="b";$sor_a_met=$secenek2;break;
					case 3:$sor_a="c";$sor_a_met=$secenek3;break;
					case 4:$sor_a="d";$sor_a_met=$secenek4;break;
					case 5:$sor_a="e";$sor_a_met=$secenek5;break;
					case 6:$sor_a="f";$sor_a_met=$secenek6;break;
					default:$sor_a="a";$sor_a_met=$secenek1;
				}
			if(isset($araCevDizi[1]))
				switch ($araCevDizi[1])
				{
					case 1:$sor_b="a";$sor_b_met=$secenek1;break;
					case 2:$sor_b="b";$sor_b_met=$secenek2;break;
					case 3:$sor_b="c";$sor_b_met=$secenek3;break;
					case 4:$sor_b="d";$sor_b_met=$secenek4;break;
					case 5:$sor_b="e";$sor_b_met=$secenek5;break;
					case 6:$sor_b="f";$sor_b_met=$secenek6;break;
					default:$sor_b="b";$sor_b_met=$secenek2;
				}
			if(isset($araCevDizi[2]))
				switch ($araCevDizi[2])
				{
					case 1:$sor_c="a";$sor_c_met=$secenek1;break;
					case 2:$sor_c="b";$sor_c_met=$secenek2;break;
					case 3:$sor_c="c";$sor_c_met=$secenek3;break;
					case 4:$sor_c="d";$sor_c_met=$secenek4;break;
					case 5:$sor_c="e";$sor_c_met=$secenek5;break;
					case 6:$sor_c="f";$sor_c_met=$secenek6;break;
					default:$sor_c="c";$sor_c_met=$secenek3;
				}
			if(isset($araCevDizi[3]))
				switch ($araCevDizi[3])
				{
					case 1:$sor_d="a";$sor_d_met=$secenek1;break;
					case 2:$sor_d="b";$sor_d_met=$secenek2;break;
					case 3:$sor_d="c";$sor_d_met=$secenek3;break;
					case 4:$sor_d="d";$sor_d_met=$secenek4;break;
					case 5:$sor_d="e";$sor_d_met=$secenek5;break;
					case 6:$sor_d="f";$sor_d_met=$secenek6;break;
					default:$sor_d="d";$sor_d_met=$secenek4;
				}
			if(isset($araCevDizi[4]))
				switch ($araCevDizi[4])
				{
					case 1:$sor_e="a";$sor_e_met=$secenek1;break;
					case 2:$sor_e="b";$sor_e_met=$secenek2;break;
					case 3:$sor_e="c";$sor_e_met=$secenek3;break;
					case 4:$sor_e="d";$sor_e_met=$secenek4;break;
					case 5:$sor_e="e";$sor_e_met=$secenek5;break;
					case 6:$sor_e="f";$sor_e_met=$secenek6;break;
					default:$sor_e="e";$sor_e_met=$secenek5;
				}
			if(isset($araCevDizi[5]))
				switch ($araCevDizi[5])
				{
					case 1:$sor_f="a";$sor_f_met=$secenek1;break;
					case 2:$sor_f="b";$sor_f_met=$secenek2;break;
					case 3:$sor_f="c";$sor_f_met=$secenek3;break;
					case 4:$sor_f="d";$sor_f_met=$secenek4;break;
					case 5:$sor_f="e";$sor_f_met=$secenek5;break;
					case 6:$sor_f="f";$sor_f_met=$secenek6;break;
					default:$sor_f="e";$sor_f_met=$secenek6;
				}
				
	     if($secenek1!="")
			 $sonuc .= "<input type='radio' value='A' name='cevap' class='cevap' style='width:35px;' onclick='cevapDegerlendir(\"$sor_a\",$id);' onkeypress='' /> $sor_a_met<br/><br/>";
	     if($secenek2!="")
		     $sonuc .= "<input type='radio' value='B' name='cevap' class='cevap' style='width:35px;'  onclick='cevapDegerlendir(\"$sor_b\",$id);' /> $sor_b_met<br/><br/>";
	     if($secenek3!="")
	    	 $sonuc .= "<input type='radio' value='C' name='cevap' class='cevap' style='width:35px;'  onclick='cevapDegerlendir(\"$sor_c\",$id);' /> $sor_c_met<br/><br/>";
	     if($secenek4!="")
		     $sonuc .= "<input type='radio' value='D' name='cevap' class='cevap' style='width:35px;'  onclick='cevapDegerlendir(\"$sor_d\",$id);' /> $sor_d_met<br/><br/>";
	     if($secenek5!="")
		     $sonuc .= "<input type='radio' value='E' name='cevap' class='cevap' style='width:35px;'  onclick='cevapDegerlendir(\"$sor_e\",$id);' /> $sor_e_met<br/><br/>";
	     if($secenek6!="")
		     $sonuc .= "<input type='radio' value='F' name='cevap' class='cevap' style='width:35px;'  onclick='cevapDegerlendir(\"$sor_f\",$id);' /> $sor_f_met";
		} else {
			//ÇOK SEÇÝMLÝ soru 
			$_SESSION["cevaplar"][$id]= "";
			$_SESSION["hataSay"][$id]= "";
  	   $toplamCevapAdedi=(!empty($secenek1))+(!empty($secenek2))+(!empty($secenek3))+(!empty($secenek4))+(!empty($secenek5))+(!empty($secenek6));
				
	   $araCevDizi=preg_split('$[/]$', rasgeleCevapHazirla($toplamCevapAdedi));

				switch ($araCevDizi[0])
				{
					case 1:$sor_a="a";$sor_a_met=$secenek1;break;
					case 2:$sor_a="b";$sor_a_met=$secenek2;break;
					case 3:$sor_a="c";$sor_a_met=$secenek3;break;
					case 4:$sor_a="d";$sor_a_met=$secenek4;break;
					case 5:$sor_a="e";$sor_a_met=$secenek5;break;
					case 6:$sor_a="f";$sor_a_met=$secenek6;break;
					default:$sor_a="a";$sor_a_met=$secenek1;
				}
				switch ($araCevDizi[1])
				{
					case 1:$sor_b="a";$sor_b_met=$secenek1;break;
					case 2:$sor_b="b";$sor_b_met=$secenek2;break;
					case 3:$sor_b="c";$sor_b_met=$secenek3;break;
					case 4:$sor_b="d";$sor_b_met=$secenek4;break;
					case 5:$sor_b="e";$sor_b_met=$secenek5;break;
					case 6:$sor_b="f";$sor_b_met=$secenek6;break;
					default:$sor_b="b";$sor_b_met=$secenek2;
				}
				switch ($araCevDizi[2])
				{
					case 1:$sor_c="a";$sor_c_met=$secenek1;break;
					case 2:$sor_c="b";$sor_c_met=$secenek2;break;
					case 3:$sor_c="c";$sor_c_met=$secenek3;break;
					case 4:$sor_c="d";$sor_c_met=$secenek4;break;
					case 5:$sor_c="e";$sor_c_met=$secenek5;break;
					case 6:$sor_c="f";$sor_c_met=$secenek6;break;
					default:$sor_c="c";$sor_c_met=$secenek3;
				}
				switch ($araCevDizi[3])
				{
					case 1:$sor_d="a";$sor_d_met=$secenek1;break;
					case 2:$sor_d="b";$sor_d_met=$secenek2;break;
					case 3:$sor_d="c";$sor_d_met=$secenek3;break;
					case 4:$sor_d="d";$sor_d_met=$secenek4;break;
					case 5:$sor_d="e";$sor_d_met=$secenek5;break;
					case 6:$sor_d="f";$sor_d_met=$secenek6;break;
					default:$sor_d="d";$sor_d_met=$secenek4;
				}
				switch ($araCevDizi[4])
				{
					case 1:$sor_e="a";$sor_e_met=$secenek1;break;
					case 2:$sor_e="b";$sor_e_met=$secenek2;break;
					case 3:$sor_e="c";$sor_e_met=$secenek3;break;
					case 4:$sor_e="d";$sor_e_met=$secenek4;break;
					case 5:$sor_e="e";$sor_e_met=$secenek5;break;
					case 6:$sor_e="f";$sor_e_met=$secenek6;break;
					default:$sor_e="e";$sor_e_met=$secenek5;
				}
				switch ($araCevDizi[5])
				{
					case 1:$sor_f="a";$sor_f_met=$secenek1;break;
					case 2:$sor_f="b";$sor_f_met=$secenek2;break;
					case 3:$sor_f="c";$sor_f_met=$secenek3;break;
					case 4:$sor_f="d";$sor_f_met=$secenek4;break;
					case 5:$sor_f="e";$sor_f_met=$secenek5;break;
					case 6:$sor_f="f";$sor_f_met=$secenek6;break;
					default:$sor_f="e";$sor_f_met=$secenek6;
				}
				
			$sonuc.="<p>$metin[455]".getCevapSay($id)."</p>";
	     if($secenek1!="")
			 $sonuc .= "<input type='checkbox' value='A' name='cevap' id='cevap1' class='cevap' style='width:35px;' onclick='document.getElementById(\"cevap1\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_a\",$id);' /> $sor_a_met<br/><br/>";
	     if($secenek2!="")
		     $sonuc .= "<input type='checkbox' value='B' name='cevap' id='cevap2' class='cevap' style='width:35px;'  onclick='document.getElementById(\"cevap2\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_b\",$id);' /> $sor_b_met<br/><br/>";
	     if($secenek3!="")
	    	 $sonuc .= "<input type='checkbox' value='C' name='cevap' id='cevap3' class='cevap' style='width:35px;'  onclick='document.getElementById(\"cevap3\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_c\",$id);' /> $sor_c_met<br/><br/>";
	     if($secenek4!="")
		     $sonuc .= "<input type='checkbox' value='D' name='cevap' id='cevap4' class='cevap' style='width:35px;'  onclick='document.getElementById(\"cevap4\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_d\",$id);' /> $sor_d_met<br/><br/>";
	     if($secenek5!="")
		     $sonuc .= "<input type='checkbox' value='E' name='cevap' id='cevap5' class='cevap' style='width:35px;'  onclick='document.getElementById(\"cevap5\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_e\",$id);' /> $sor_e_met<br/><br/>";
	     if($secenek6!="")
		     $sonuc .= "<input type='checkbox' value='F' name='cevap' id='cevap6' class='cevap' style='width:35px;'  onclick='document.getElementById(\"cevap6\").style.visibility = \"hidden\";
			 cevapDegerlendir2(\"$sor_f\",$id);' /> $sor_f_met";

		}		//soru seçenekleri bitti
		
	   if($sonuc == "")
	     $sonuc = "$metin[350]";
       return $sonuc;
    }else {
	   return ("");
	}
}
		echo "<h4>$metin[347]</h4>";
?>

<div id="cevapSonucu"></div>
<div id="cevapDegerlendirmeYeri">
  <?php
/*main*/
 if (isset($_GET['sayfa']) && is_numeric($_GET['sayfa']) && $_GET['sayfa']>0  ) {
		echo secenekleriGetir(temizle2($_GET['sayfa']));
 		}
?>
</div>
<script language="javascript">
/*
tekCevapFocus:
tek cevaptaki metin kutusuna odaklanýr
*/
function tekCevapFocus()
{
if (document.getElementById("tekCevap")!=null)  document.getElementById("tekCevap").focus();
}

window.setTimeout("tekCevapFocus()",500);
if (document.getElementById("cevapSuresi")!=null) fadeUp(document.getElementById("cevapSuresi"),255,0,0,150,0,0);

</script>

<script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $(".cevap").keydown(function(e) {
                var evt = e || window.event;                
                if (evt.keyCode >= 37 && evt.keyCode <= 40) {
                    return false;
                }
            });
        });        
</script> 
