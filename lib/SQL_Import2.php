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

    function import () 
    {   
    	$this -> con = mysqli_connect($this -> host, $this -> user, $this -> pass, $this -> db);
           if ($this -> con !== false) 
           {

         $f = fopen($this -> ArchivoSql,"r");
         $sqlFile = fread($f, filesize($this -> ArchivoSql));
         $sqlArray = explode(';', $sqlFile);

             foreach ($sqlArray as $stmt) 
             {
                   if (strlen($stmt) > 3)
                   {
                    $result = mysqli_query($this -> con,$stmt);
                      if (!$result)
                      {						  
                     $CodigoError = mysqli_errno($this -> con);
                     $TextoError = mysqli_error($this -> con);
                     break;
                      }
              
                }
        
              }
          }
          
    }//Fin de Dump
    
    //controlamos y mostramos los posibles errores en el proceso
    function ShowErr () 
    {    
           if (isset($this -> CodigoError) and $this -> CodigoError == 0)
           {
           $Salida ["exito"] =  1;
        }else{
        $Salida ["exito"] =  0; 
		if(!empty($this -> CodigoError))          
	        $Salida ["errorCode"] = $this -> CodigoError;
		if(!empty($this -> TextoError))          
	        $Salida ["errorText"] =  $this -> TextoError;
           }

    return $Salida;
    }

} 
   
?> 