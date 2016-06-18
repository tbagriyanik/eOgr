<?php
/*
the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/
@session_start();

include ("conf.php");

$aUsers =array();
$aID 	=array();
$aInfo	=array();

	$result = mysqli_query($yol, "select konuAdi from eo_4konu order by id");
	for($i = 0; $sonuc = mysqli_fetch_assoc($result); $i++) 
	{
		$aUsers[$i] =temizle(($sonuc ["konuAdi"])); 
	};
	
	$result = mysqli_query($yol, "select id from eo_4konu order by id");
	for($i = 0; $sonuc = mysqli_fetch_assoc($result); $i++) 
	{
		$aID[$i] = temizle(($sonuc ["id"]));
	};

	$result = mysqli_query($yol, "select eo_3ders.dersAdi as dersAdi from eo_3ders,eo_4konu where eo_4konu.dersID=eo_3ders.id order by eo_4konu.id");
	for($i = 0; $sonuc = mysqli_fetch_assoc($result); $i++) 
	{
		$aInfo[$i] = temizle(($sonuc ["dersAdi"]));
	};
	
	if(!empty($_GET['input']))
		$input = mb_strtolower($_GET['input']);
	else	
		$input = "";
																					
	$len = strlen($input);
	$limit = 5;
	
	
	$aResults = array();
	$count = 0;
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//

			if (mb_strtolower(substr(($aUsers[$i]),0,$len)) == $input || strpos( mb_strtolower($aUsers[$i]),$input) > 0 )
			{
				$count++;
				$aResults[] = array( "id"=> $aID[$i] ,"value"=>$aUsers[$i], "info"=>$aInfo[$i] );
			}
			
			if ($limit && $count==$limit)
				break;
		}
	}
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"".$aResults[$i]['info']."\" }";
		}
		echo implode(", ", $arr);
		echo "]}";
?>