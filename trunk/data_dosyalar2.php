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
								"sFirst":    "<<",
								"sPrevious": "<",
								"sNext":     ">",
								"sLast":     ">>"
							}
						},
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "data_dosyalar.php",
					"bAutoWidth": true,
					"aaSorting": [[0,'desc']],
					"sPaginationType": "full_numbers",
					"bStateSave": true,
					"aoColumns": [
						{ "sClass": "right"  },
						{ },
						{  },
						{ "sClass": "right"  }
					]
				} );
	/* Add a click handler to the rows - this could be used as a callback */
	$("#example tbody").click(function(event) {
		$(oTable.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
	});
	
	/* Add a click handler for the delete row */
	$('#delete').click( function() {
		var anSelected = fnGetSelected( oTable );
		oTable.fnDeleteRow( anSelected[0] );
		alert(anSelected[0] );
	} );
	
	/* Init the table */
	oTable = $('#example').dataTable( );
} );


/* Get the rows which are currently selected */
function fnGetSelected( oTableLocal )
{
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();
	
	for ( var i=0 ; i<aTrs.length ; i++ )
	{
		if ( $(aTrs[i]).hasClass('row_selected') )
		{
			aReturn.push( aTrs[i] );
		}
	}
	return aReturn;
}
</script>
</head>

<body>
<p><a href="javascript:void(0)" id="delete"><?php echo $metin[37]?></a></p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" align="center">
  <thead>
    <tr>
      <th width="10%"><?php echo $metin[26]?></th>
      <th width="25%"><?php echo $metin[17]?></th>
      <th width="45%"><?php echo $metin[657]." (".$metin[465].", ".$metin[129].")"?></th>
      <th width="5%"><?php echo $metin[466]?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="4" class="dataTables_empty"><img src="img/ajax-loader.gif"></td>
    </tr>
  </tbody>
</table>
</body>
</html>