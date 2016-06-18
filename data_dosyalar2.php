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
  require("conf.php");  		

  checkLoginLang(true,true,"data_dosyalar2.php");	   
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eOgr - File List</title>
<script language="javascript" type="text/javascript" src="lib/jquery-1.9.1.min.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatables/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="lib/datatables/table.css" type="text/css" media="screen" charset="utf-8" />
<link href="theme/file.css" rel="stylesheet" type="text/css" />
<style media="all" type="text/css">
body {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 14px;
}
</style>
<script language="JavaScript" type="text/javascript">
<!--
/*
delWithCon:
onay ile silme işlemi
*/
function delWithCon(field_value) { 
  if (confirm("<?php echo $metin[104]?>")==1){
    location.href = eval('\"data_dosyalar2.php?id='+field_value+'&delCon=1\"');
  }
  return false;
}

//-->
</script>
<script type="text/javascript" charset="utf-8">
var oTable;
var giRedraw = false;

			$(document).ready(function() {
				$('#example').dataTable( {
					"oLanguage": {
							"sProcessing": "<?php echo $metin[656]?>",
							"sLengthMenu": "<?php echo $metin[110]?> _MENU_",
							"sZeroRecords": "<?php echo $metin[497]?>",
							"sInfo": "_START_ / _END_ : _TOTAL_",
							"sInfoEmpty": "",
							"sInfoFiltered": "(_MAX_)",
							"sInfoPostFix": "",
							"sSearch": "<?php echo $metin[29]?>",
							"sUrl": "",
							"oPaginate": {
								"sFirst":    "&laquo;",
								"sPrevious": "&lsaquo;",
								"sNext":     "&rsaquo;",
								"sLast":     "&raquo;"
							}
						},
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "data_dosyalar.php",
					"bAutoWidth": true,					
					"aaSorting": [[0,'desc']],
					"sPaginationType": "full_numbers",
					"bStateSave": true,
					"aoColumnDefs": [
								{ "bSortable": false, "aTargets": [ 4 ] }
							],					
					"aoColumns": [
						{ "sClass": "right"  },
						{ },
						{  },
						{ "sClass": "right"  },
						{ }
					]
				} );
	
	/* Init the table */
	oTable = $('#example').dataTable( );
} );

</script>
</head>

<body>
<?php
if ((isset($_GET['id'])) && ($_GET['id'] != "") && ($_GET['delCon'] == "1") && 
			(getUserID2($_SESSION['usern'])==dosyaKimID($_GET['id']) or getUserType($_SESSION['usern'])=='2')) {
	if(preg_match("/777/",decoct(@fileperms($_uploadFolder))) 
	  or preg_match("/766/",decoct(@fileperms($_uploadFolder)))) {
		  dosyaSil(RemoveXSS($_GET['id'])); 			
		  $deleteSQL = sprintf("DELETE FROM eo_files WHERE id=%s",
							   GetSQLValueString($_GET['id'], "int"));		
		  //mysqli_select_db($_db, $yol);
		  $Result1 = mysqli_query($yol,$deleteSQL) or die(mysqli_error());
		  if ($Result1) echo "<font id='uyari'> $metin[501]</font>";  
	}
}  
?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" align="center">
  <thead>
    <tr>
      <th width="10%"><?php echo $metin[26]?></th>
      <th width="20%"><?php echo $metin[17]?></th>
      <th width="50%"><?php echo $metin[657]." (".$metin[465].", ".$metin[129].")"?></th>
      <th width="5%"><?php echo $metin[466]?></th>
      <th width="5%">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="5" class="dataTables_empty"><img src="img/ajax-loader.gif"></td>
    </tr>
  </tbody>
</table>
</body>
</html>