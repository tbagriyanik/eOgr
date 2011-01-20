<?php
//SQLImporter
//Version 1.0
//Import the data stored in a SQL file into a MySql Database
//Rubén Crespo Álvarez - rumailster@gmail.com [peachep.wordpress.com]

class sqlImport {
    
    //recogemos las variables
    function sqlImport ($host, $user,$pass, $ArchivoSql) {
    $this -> host = $host;
    $this -> user = $user;
    $this -> pass = $pass;
    $this -> ArchivoSql = $ArchivoSql;
    }

    //Volcamos los datos
    function import () 
    {   
    	$this -> con = mysql_connect($this -> host, $this -> user, $this -> pass);
           if ($this -> con !== false) 
           {

         $f = fopen($this -> ArchivoSql,"r");
         $sqlFile = fread($f, filesize($this -> ArchivoSql));
         $sqlArray = explode(';', $sqlFile);

             foreach ($sqlArray as $stmt) 
             {
                   if (strlen($stmt) > 3)
                   {
                    $result = mysql_query($stmt);
                      if (!$result)
                      {						  
                     $CodigoError = mysql_errno();
                     $TextoError = mysql_error();
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