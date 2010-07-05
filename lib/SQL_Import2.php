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

    //Conexion a la base de datos
    function dbConnect () {
    $con = mysql_connect($this -> host, $this -> user, $this -> pass);
    }
    
    //Volcamos los datos
    function import () 
    {   
    
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
           if ($this -> CodigoError == 0)
           {
           $Salida ["exito"] =  1;
        }else{
        $Salida ["exito"] =  0;           
        $Salida ["errorCode"] = $this -> CodigoError;
        $Salida ["errorText"] =  $this -> TextoError;
           }

    return $Salida;
    }

} 
   
?> 