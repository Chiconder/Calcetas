
<?php

 session_start();


 include "../conexion.php";


 if(!empty($_POST)) {//Aqui quiere decir que el usuario le ha dado clic en el boton crear usuario
     
    $alert=""; //declaramos la variable alerta para utilizarla más abajo

    if(empty($_POST['usuario']) || empty($_POST['correo']) ||
      empty($_POST['rol']) || empty($_POST['clave']) ||  empty($_POST['conf_clave'])) {// con empty se está comprobando en caso de que esté vacío
    
    
      $alert='<p class="msg_error"> Todos los campos son obligatorios </p>'; //AQUI ESTAMOS MANDANDO UN MENSAJE DE ALERTA DICEINDO QUE TODOS LOS CAMPOS SON OBLIGATORIOS
 
    }   
    else {

      //aqui lo que estamos haciendo es hacer uso del archivo de configuración y los 2 puntos quiere decir que se está retrocediendo una carpeta
   
      //$nombre= $_POST['nombre']; // aqui estamos almacenando en una variable $nombre lo que se escribió eb la caja texto nombre del formulario que se encuentra abajo 
      $usuario= $_POST['usuario'];  //
      $correo= $_POST['correo'];  //
      $rol= $_POST['rol'];  //con md5 se me está generando un hash al dar clic en el boton crear usuario
      $clave= $_POST['clave'];
      $conf_clave= $_POST['conf_clave']; //

    //   hola   = carlos
      

      $query= mysqli_query($conection,"SELECT *FROM usuario WHERE usuario ='$usuario' OR correo='$correo' "); //mysqli_query sirve para hacer una consulta a la base de datos

      $resul= mysqli_fetch_array($query);

      if($resul>0){ //en caso de que sea 1 quiere decir que está devolviendo un registro.

        $alert= '<p class="msg_error"> El correo o el usuario ya existen </p>';
      
      }

      else if($clave!= $conf_clave){

        $alert= '<p class="msg_clave"> Las claves tienen que coincidir </p>';

      }

      else{

        $query_insert = mysqli_query($conection, "INSERT INTO  usuario(usuario,correo,idrol,contrasena,conf_contrasena)
        VALUES ('$usuario','$correo','$rol','$clave','$conf_clave')"); //aqui se esta insertando un nuevo registro


        if($query_insert){
  
          $alert='<p class="msg_save"> Usuario creado correctamente </p>';


        }


        else {
  
        $alert='<p class="msg_error"> Error al crear al usuario  </p>';
      

        }
      }
    }
  
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../login/styles/register.css">
</head>
<body>
    <div id="parte1">
        <div id="registro">
            <form action="" method="post">
                <p id="parrafoInicio">¿Aún no estás registrado? ¿Qué esperas para hacerlo?</p>
                <p id="otroParrafo">Sólo rellena estos campos</p>
                <img src="../login/img/avatar.png" alt="" class="imgReg">
                <p class="campos">Usuario: <br><input type="text" name="usuario"></p>
                <img src="../login//img/correo-electronico.png" alt="" class="imgReg">
                <p class="campos">Correo: <br><input type="email" name="correo"></p>
                
                <br>
     
              <label for="rol"> Rol </label> <!-- el for=rol funciona para el momento de darle clic en el titulo Rol y automaticamente el cursor se muestre
      |       en las opciones de los roles para seleccionar --> 

             <?php

            //siempre para mostrar informacion en un formulario primero se realiza una consulta a la base de datos
            $query_rol= mysqli_query($conection,"SELECT *FROM rol"); //mysqli_query sirve para hacer una consulta a la base de datos

            mysqli_close($conection);


            $resul_rol = mysqli_num_rows($query_rol);


  
           ?>
      
          <select name="rol" id="rol">

            <?php

            if($resul_rol>0)
            
            {

            while($rol= mysqli_fetch_array($query_rol)){ //aqui lo que está haciendo es guardar cada uno de los registros encontradas al hacer un select en mysql 

              ?>
              
              <option value="<?php  echo $rol['idrol'] ?>"> <?php echo $rol['rol'] ?> </option> <!-- si es mayor a cero, es decir
                si se encuentra registros, esos registros lo llenará en cada uno de los select options //aqui me mostrará el id rol
                acompañado del nombre del rol--> 
              <?php

            }

            }

            ?>

          </select>
          <br>
          <br>



                <img src="../login/img/bloquear.png" alt="" class="imgReg">
                <p class="campos">Contraseña: <br><input type="password" name="clave" ></p>
                <img src="../login/img/llave.png" alt="" class="imgReg">
                <p class="campos">Confirmar Contraseña: <br><input type="password" name="conf_clave"></p>

                <div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>
                <button type="submit">Regístrate</button>
            </form>
        </div>    
        
        
    </div>

    <img src="./img/fondoRegistro.jpg" alt="" id="fondoReg">
    
    <div class="texto-encima">Nombre <br>Empresa</div>
   
</body>
</html>