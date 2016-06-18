<?php
function _mysqldump($mysqli_database, $yol)
{
			$sonuc = 	("SET NAMES 'utf-8';\n");
			$sonuc .=  	("SET CHARACTER SET utf8;\n");
			$sonuc .=  	("SET COLLATION_CONNECTION = 'utf8_general_ci';\n");
			
	$sql="SHOW TABLES IN $mysqli_database LIKE 'eo_%'";
	$result= mysqli_query($yol, $sql);
	if( $result)
	{
		while( $row= mysqli_fetch_row($result))
		{
			$sonuc .= _mysqldump_table_structure($row[0], $yol);
			$sonuc .= _mysqldump_table_data($row[0], $yol);
		}
	}
	else
	{
			$sonuc .=  "/* no tables in $mysqli_database */\n";
	}
	mysqli_free_result($result);
	return $sonuc;
}

function _mysqldump_table_structure($table, $yol)
{
		$sonuc .= "/* Table structure for table `$table` */\n";
		$sonuc .= "DROP TABLE IF EXISTS `$table`;\n\n";

		$sql="show create table `$table`; ";
		$result=mysqli_query($yol, $sql);		
		if( $result)
		{ 
			if($row= mysqli_fetch_assoc($result))
			{
				$sonuc .= $row['Create Table'].";\n\n";
			}
		}
		mysqli_free_result($result);
		return $sonuc; 
}

function _mysqldump_table_data($table, $yol)
{

	$sql="select * from `$table`;";
	$result=mysqli_query($yol, $sql);
	if( $result)
	{
		$num_rows= mysqli_num_rows($result);
		$num_fields= mysqli_num_fields($result);

		if( $num_rows > 0)
		{
			$sonuc .= "/* dumping data for table `$table` */\n";

			$field_type=array();
			$i=0;
			while( $i < $num_fields)
			{
				$meta= mysqli_fetch_field($result, $i);
				array_push($field_type, $meta->type);
				$i++;
			}

			//print_r( $field_type);
			$sonuc .= "insert into `$table` values\n";
			$index=0;
			while( $row= mysqli_fetch_row($result))
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
	mysqli_free_result($result);
	return $sonuc;
}
?>