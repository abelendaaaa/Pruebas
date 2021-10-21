<?php
 
include('config.php');
session_start();
 
if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (!$result) {
        echo '<p class="error">El usuario o la contraseña no son correctos!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            echo '<p class="success">Logeado correctamente!</p>';
                //Redireccion a la tabla si eres admin
                if($result['idAdmin']==1){
                    //ADMIN
                    // header( "refresh:1.5;url=http://localhost/home/sesion/register.php" );
                    // exit;
                }
                //Redirección al mapa si eres usuario normal
                else {
                    //USUARIO NORMAL
                    // header( "refresh:1.5;url=http://localhost/home/sesion/login.php" );
                    // exit;
                }
        } else {
            echo '<p class="error">El usuario o la contraseña no son correctas!</p>';
        }
    }
}
 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
<form method="post" action="" name="signin-form">
    <div class="form-element">
        <label>Usuario</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="login" class="boton" value="login">Iniciar sesión</button>
    <br><br><br>
    <div class="no_log">
        <p>Si aun no te has registrado hazlo aquí</p>
        <a href="register.php" class="msg_no_log">Resgistrarse</a>
    </div>
</form>
</body>
</html>