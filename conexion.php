
<?php




$host= 'localhost';
$user= 'root';
$password= '';
$db = 'calcetines';


$conection = @mysqli_connect($host,$user,$password,$db);


 // mysqli_close($conection);


 if($conection){


  // echo "La conexion ha sido todo un éxito";

 }

else if(!$conection){

  echo "Ha ocurrido un error"; 

}



?>