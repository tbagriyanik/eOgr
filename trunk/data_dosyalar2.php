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
@session_start();
  require("conf.php");  		

  checkLoginLang(true,true,"data_dosyalar2.php");	   
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>eOgr - File List</title>
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatables/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="lib/datatables/table.css" type="text/css" media="screen" charset="utf-8" />
<link href="theme/file.css" rel="stylesheet" type="text/css" />
<style media="all" type="text/css">
body {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
</style>

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
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" align="center">
  <thead>
    <tr>
      <th width="10%"><?php echo $metin[26]?></th>
      <th width="25%"><?php echo $metin[17]?></th>
      <th width="45%"><?php echo $metin[657]." (".$metin[465].", ".$metin[129].")"?></th>
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