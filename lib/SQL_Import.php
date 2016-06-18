<?php
//SQLImporter
//Version 1.0
//Import the data stored in a SQL file into a MySql Database
//Rubén Crespo Álvarez - rumailster@gmail.com [peachep.wordpress.com]

class sqlImport {
	
	function sqlImport ($host, $user, $pass, $db, $ArchivoSql) {
    $this -> host = $host;
    $this -> user = $user;
    $this -> pass = $pass;
	$this -> db = $db;
    $this -> ArchivoSql = $ArchivoSql;
    }

    function importa () 
    {   
    	$this -> con = mysqli_connect($this -> host, $this -> user, $this -> pass, $this -> db);
   		if ($this -> con !== false) 
   		{
			mysqli_set_charset($this -> con, 'utf8'); 
		$sqlFile = $this -> ArchivoSql;		
     	$sqlArray = explode(';', $sqlFile);
		$errors = "";
     		foreach ($sqlArray as $stmt) 
     		{
       			if (strlen($stmt) > 3)
       			{
            		$result = mysqli_query($this -> con,$stmt);
             	 	if (!$result)
             	 	{
					$errors = $errors.mysqli_errno().": ".htmlentities(mysqli_error())."<br/><br/>";					 
              		}
              
        		}
        
     	 	}

     	 }
     	return $errors; 
	}
}    
?> 