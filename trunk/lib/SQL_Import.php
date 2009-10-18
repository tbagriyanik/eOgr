<?php
//SQLImporter
//Version 1.0
//Import the data stored in a SQL file into a MySql Database
//Rubén Crespo Álvarez - rumailster@gmail.com [peachep.wordpress.com]

class sqlImport {
	
	function sqlImport ($host, $user,$pass, $ArchivoSql) {
	$this -> host = $host;
	$this -> user = $user;
	$this -> pass = $pass;
	$this -> ArchivoSql = ($ArchivoSql);
	}

	function dbConnect () {
	$con = mysql_connect($this -> host, $this -> user, $this -> pass);
	}
	
	function importa () 
	{   
	
   		if ($this -> con !== false) 
   		{

		$sqlFile = $this -> ArchivoSql;		
     	$sqlArray = explode(';', $sqlFile);
		$errors = "";
     		foreach ($sqlArray as $stmt) 
     		{
       			if (strlen($stmt) > 3)
       			{
            		$result = mysql_query($stmt);
             	 	if (!$result)
             	 	{
					$errors = $errors.mysql_errno().": ".htmlentities(mysql_error())."<br/><br/>";					 
              		}
              
        		}
        
     	 	}

     	 }
     	return $errors; 
	}//Fin de Dump	

} 
   
?> 