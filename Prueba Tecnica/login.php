<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <div class="container">
        
        <div class="container">
            <?php
            //verificamos si el formulario de inicio de sesión ha sido enviado, comprobando si el botón de envío (login) ha sido presionado
            if (isset($_POST["login"])) {    
            //El código recupera los datos ingresados por el usuario en el formulario y los almacena en variables:
                $email = $_POST["email"];
                $password = $_POST["password"];
            /*conectamos la base de datos utilizando require_once 
            para incluir el archivo "databasepd.php" que contiene la configuración de la conexión */
                require_once "databasepd.php";
            //Se realiza una consulta a la base de datos para obtener la fila de usuario que coincida con el correo electrónico ingresado
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //El código verifica si se encontró un usuario con el correo electrónico ingresado en la base de datos
                if ($user) {
                    if (password_verify($password, $user["password"])) { //Si las credenciales son correctas, inicia la sesión y redirige al usuario a "index.html"
                        session_start();
                        $_SESSION["user"] = "yes";
                        header("Location: index.html");
                        die();
                    } else {
                    //// Si la contraseña no coincide, muestra un mensaje de error
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                //// Si no se encuentra un usuario con el correo electrónico ingresado, muestra un mensaje de error
                    echo "<div class='alert alert-danger'>El email no coincide</div>";
                }
            }
            ?>
            <h1 class="login">Log In!</h1>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="email" placeholder="Enter Email:" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Password:" name="password" class="form-control">
                </div>
                <div class="form-btn">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                </div>
            </form>
        </div>

</body>

</html>