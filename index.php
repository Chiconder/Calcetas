<?php

$alert = ' ';


 session_start();

if(!empty($_POST)) //Aqui quiere decir que el usuario le ha dado clic en el boton ingresar
   
   {
   
       if(empty($_POST['user']) || empty($_POST['pass'])) // con empty se está comprobando en caso de que esté vacío
     
     {  

      $alert = " <h1> Por favor ingrese su usuario y contraseña</h1>"; // es en caso de que no se haya llenado el campo usuario y el campo contraseña.  

     }
       else {

       require_once "conexion.php"; // aqui estamos requeriendo el archivo de la base de datos para conectarnos

      
      $user =  mysqli_real_escape_string($conection, $_POST["user"]);  // aqui se está guardando lo que se está enviando a través del post en usuario en una variable user
      $clave = mysqli_real_escape_string($conection, $_POST["pass"]); // aqui se está guardando lo que se está enviando a través del post en usuario en una variable contrasena
      
      
      $query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' AND contrasena = '$clave' and estatus=1");
      
      
      
      $result= mysqli_num_rows($query);


      mysqli_close($conection);


       if($result > 0){     // aqui quiere decir que ha encontrado un registro.
        
            $data = mysqli_fetch_array($query); // aqui se guardará un array del query hecho en la parte de arriba es decir un id, nombre, correo, usuario

            print_r($data); // el print_r sirve para informacion variables que contengan informacion

            $_SESSION['active'] = true;   // Aquí se está iniciando la session estamos son variables de session
            $_SESSION['id_usuario'] = $data['id_usuario']; // Una vez ingresado correctamente el usuario y contraseña se generarán todas estas variables de session
            $_SESSION['correo'] = $data['correo']; // 
            $_SESSION['usuario'] = $data['usuario']; // 
            //$_SESSION['rol'] = $data['rol']; // 
            //$_SESSION['tiempo'] = time(); //la función time me devuelve la hora actual

        
                //la contraseña no se la pasa por variable de sesion por lo que es privado
            
        
            header('location: sistema/'); // Sirve para redireccionar la carpeta, es decir aquí nos estamos dirigiendo a la carpeta llamada sistema
       }
       
       else 
       {

         $alert=" <label class='Error'> La direccion o la contraseña son invalidos </label>"; // Al ingresar el usuario y la clave en el formulario y estas no coincidan con la de la base de datos mostrará el mensaje que contiene en la variable alert

         session_destroy();

        
        }
        
       }

       }




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de seción</title>
    <link rel="stylesheet" href="login/styles/style.css">
</head>
<body>
   <div id="principal">
        <form action="" method="POST">
            <fieldset>
                <legend align="center">
                    <img src="login/img/usuario.png" alt="" id="user">
                </legend>
                <legend>

                    <h1>¡Bienvenido!</h1>
                    <h3>Inicia sesión</h3>
                    <div class="inicioSesion" id="inicioSesion">

                        <img src="./img/otroAvatar.png" alt="" class="imgSes">
                      <input placeholder="Usuario" type="text" name="user">
                     
                        <img src="./img/candado.png" alt="" class="imgSes">
                        <input placeholder="Contraseña" ty2pe="password" name="pass">
                         <div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>
                   </div>
                   
                    <br>
                    <p class="NoR"> ¿No tienes una cuenta? <a class="reg"  href="sistema/registro_user.php" target="_blank">Regístrate</a></p> 
                    <button type="submit" class="Login" id="login">Login</button>
                   
               
                </legend>
            </fieldset>
        </form>    
    
    
    
   </div>
</body>
</html>