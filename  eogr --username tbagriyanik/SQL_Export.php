<?php
function _mysqldump($mysql_database)
{
			$sonuc = ("SET NAMES 'latin1';\n");
			$sonuc .= ("SET CHARACTER SET latin1;\n");
			$sonuc .= ("SET COLLATION_CONNECTION = 'latin1_swedish_ci';\n");
			$sonuc .= "/*For Turkish Settings*/\n\n";
			
	$sql="SHOW TABLES IN $mysql_database LIKE 'eo_%'";
	$result= mysql_query($sql);
	if( $result)
	{
		while( $row= mysql_fetch_row($result))
		{
			$sonuc .=(_mysqldump_table_structure($row[0]));
			$sonuc .=(_mysqldump_table_data($row[0]));
		}
	}
	else
	{
		$sonuc .= "/* no tables in $mysql_database */\n";
	}
	
	mysql_free_result($result);
	return gzencode($sonuc);
}

function _mysqldump_table_structure($table)
{
	$sonuc .= "/* Table structure for table `$table` */\n";
		$sonuc .= "DROP TABLE IF EXISTS `$table`;\n\n";

		$sql="show create table `$table`; ";
		$result=mysql_query($sql);
		if( $result)
		{
			if($row= mysql_fetch_assoc($result))
			{
				$sonuc .= $row['Create Table'].";\n\n";
			}
		}
		mysql_free_result($result);
		return $sonuc;
}

function _mysqldump_table_data($table)
{

	$sql="select * from `$table`;";
	$result=mysql_query($sql);
	if( $result)
	{
		$num_rows= mysql_num_rows($result);
		$num_fields= mysql_num_fields($result);

		if( $num_rows > 0)
		{
			$sonuc .= "/* dumping data for table `$table` */\n";

			$field_type=array();
			$i=0;
			while( $i < $num_fields)
			{
				$meta= mysql_fetch_field($result, $i);
				array_push($field_type, $meta->type);
				$i++;
			}

			//print_r( $field_type);
			$sonuc .= "insert into `$table` values\n";
			$index=0;
			while( $row= mysql_fetch_row($result))
			{
				$sonuc .= "(";
				for( $i=0; $i < $num_fields; $i++)
				{
					if( is_null( $row[$i]))
						$sonuc .= "null";
					else
					{
						switch( $field_type[$i])
						{
							case 'int':
								$sonuc .= $row[$i];
								break;
							case 'string':
							case 'blob' :
							default:
								$sonuc .= "'".($row[$i])."'";

						}
					}
					if( $i < $num_fields-1)
						$sonuc .= ",";
				}
				$sonuc .= ")";

				if( $index < $num_rows-1)
					$sonuc .= ",";
				else
					$sonuc .= ";";
				$sonuc .= "\n";

				$index++;
			}
		}
	}
	mysql_free_result($result);
	return $sonuc;
}
?>