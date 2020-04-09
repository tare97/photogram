<!DOCTYPE html>
<!--Project of Tarek, Photogram.-->
<!--Login Home page-->
<?php
session_start();
//Revisa que la sesion esta logeada , impidiendote que salgas mediante la modificación de la url.
if(isset($_SESSION['logueado'])&& $_SESSION['logueado'] == TRUE){
    header("Location: home.php");
}
?>
<!--Estructure of login page-->
<html lang="es">
    <head>
        <!--Latin characters-->
        <meta charset="UTF-8">       
        <!--Title of the page.-->
        <title>Photogram.</title>  
        <!--( Etiqueta == Label ) for phone or tablet-->
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <!--Links of CSS or JAVASCRIPT--> 
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <!--wrapper == envoltorio-->
        <div id="wrapper">
            <!--Left-->
            <div class="w-left"><img src="images/celulares.png"></div>
            <!--Right-->
            <div class="w-right">
                <!--Text of errordate-->
                <?php
                    // Revisa que el elemento 'error' no sea nulo, de lo contrario no entrara.
                    if(isset($_GET['error'])){
                        echo "<center>Error el usuario o contraseña no coinciden</center>";
                    }
                ?> 
                <!--Coding of login-->
                <?php
                    // Revisa que el elemento 'entrar' no sea nulo, de lo contrario no entrara.
                    if(isset($_POST['entrar'])){
                        require("conexion.php");
                        //DEFINIMOS LAS VARIABLES QUE USAREMOS.
                        // real_escape_string() => escapa los caracteres especiales.
                        $username = $mysqli->real_escape_string($_POST['usuario']);
                        // md5 => para la encriptación de la contraseña.
                        $password = md5($_POST['password']);
                        // la consulta que haremos a la base de datos.
                        $consulta = "SELECT username,password FROM users WHERE username = '$username' AND password = '$password'";
                        
                        //CONEXION
                        if($resultado = $mysqli->query($consulta)){
                            while($row = $resultado->fetch_array()){
                                $userok = $row['username'];
                                $passok = $row['password'];
                            }
                            $resultado->close;
                        }
                        $mysqli->close();
                        
                        if(isset($username) && isset($password)){
                            if($username == $userok && $password == $passok){
                                
                                session_start();
                                $_SESSION['logueado'] = TRUE;
                                header("Location: home.php");
                            }
                            
                            else{
                                Header("Location: index.php?error=login");
                            }
                        }
                    }
                ?>
                <div class="main-content">
                    <!--Logo-->
                    <div class="header">
                        <img src="images/logo.png">
                    </div>
                    <!--Part number one-->
                    <div class="l-part">
                        <!--Login form-->
                        <form action="" method="post">
                            <!--User-->
                            <input type="text" placeholder="Usuario" class="input" name="usuario" />
                            <!--(overlap = superposición) text-->
                            <div class="overlap-text">
                                <!--Password-->
                                <input type="password" placeholder="Contraseña" class="input" name="password" />
                                <!--(olvidar == forget) password or user name-->
                                <a href="#">Olvidastes?</a>
                            </div>
                            <!--Button for login-->
                            <input type="submit" value="Entrar" class="btn" name="entrar" />
                        </form>
                    </div>
                </div>    
                <!--Foot part-->
                <div class="sub-content">
                    <!--Part number two-->
                    <div class="s-part">
                        <!--Sign in new user-->
                        ¿No tienes una cuenta? <a href="registro.php">Regístrate</a>
                    </div>
                </div>
                <center>
                    <img src="images/appstores.png">
                </center>
            </div>
        </div>

    </body>
</html>
