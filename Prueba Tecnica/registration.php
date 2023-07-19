<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarion Form</title>
     
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <?php

        /*verficamos si el formulario ha sido enviado, comprobando si el botón de envío (submit) ha sido 
            presionado */
        if (isset($_POST["submit"])) { 

            //el código recupera los datos ingresados por el usuario en el formulario y los almacena en variables:
            $fullName = $_POST["fullname"]; 
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            /*Esta funcion se utiliza para generar un hash seguro de la contraseña de un usuario. 
            Esto garantiza que las contraseñas no se almacenen en la base de datos en texto sin cifrar, 
            lo que brinda seguridad adicional */
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            //se crea una array para almacenar posibles errores durante la validacion    
            $errors = array();

            //Verifica que no haya campos vacíos
            if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "Todos los campos son obligatorios");
            }
            //Comprueba que el formato del correo electrónico sea válido:
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "email incorrecto");
            }
            //Asegura que la contraseña tenga al menos 5 caracteres:
            if (strlen($password) < 5) {
                array_push($errors, "La contraseña debe tener minimo 5 caracteres");
            }
            //Comprueba que las contraseñas ingresadas coincidan:
            if ($password !== $passwordRepeat) {
                array_push($errors, "Contraseña no son iguales");
            }

            /*conectamos la base de datos utilizando require_once 
            para incluir el archivo "databasepd.php" que contiene la configuración de la conexión */
            require_once "databasepd.php";

            //Consulta la base de datos para verificar si el correo electrónico ingresado está registrado en la tabla de "usuarios":
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email ya esta en uso");

            }

            /* Si se encuentran errores después de todas las validaciones, 
            se mostrarán en la página mediante un bucle foreach y se imprimirán en una sección div con la clase "alertalert-danger":*/
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                require_once "databasepd.php";
                
            //Si no hay errores, el código procede a insertar el nuevo usuario en la base de datos utilizando una consulta preparada para evitar ataques de inyección SQL:
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ? ,? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-succes'>El registro fue exitoso.</div>";
                } else {
                    die("Algo estuvo mal :( ");
                }
            }
        }
        ?>



        <form action="registration.php" method="post">
            <div class="form-groupT">
                <h1>Register</h1>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Enter your full name">
            </div><br>

            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div><br>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter your pasword">
            </div><br>

            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Enter your full name">
            </div><br><br>


            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Sign Up" name="submit">
            </div><br>

            <div class="form-btn2">
                <a href="login.php">Click aca si ya estas registrado</a>
            
            </div>
        </form>
    </div>
</body>

</html>