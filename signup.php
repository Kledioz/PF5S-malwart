<?php
include_once "connections/funciones.php";
$sesionUsuario = null;
$errores = [];

if (isset($_SESSION['id_user'])) {
  header('Location: cpanel.php');
}

if (isset($_POST['send-login'])) {
  include_once "connections/conn.php";

  // Validacion de correo
  if (isset($_POST['correo'])) {
    if ($_POST['correo'] == '') {
      $errores[] = "No se ingreso correo";
    } else {
      if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El e-mail no es valido";
      }
    }
  } else {
    $errores[] = "No se ingreso correo";
  }

  // Validacion de contraseña
  if ((!isset($_POST['pass'])) || $_POST['pass'] == '') {
    $errores[] = "No se ingreso la contraseña";
  }

  //Validacion de nombre
  if ((!isset($_POST['nombre'])) || $_POST['nombre'] == '') {
    $errores[] = "No se ingreso el nombre";
  }

  //Validacion de apellido
  if ((!isset($_POST['apellido'])) || $_POST['apellido'] == '') {
    $errores[] = "No se ingreso el apellido";
  }

  //Validacion de direccion
  if ((!isset($_POST['direccion'])) || $_POST['direccion'] == '') {
    $errores[] = "No se ingreso la direccion";
  }

  //Validacion de telefono
  if ((!isset($_POST['telefono'])) || $_POST['telefono'] == '') {
    $errores[] = "No se ingreso el telefono";
  }

  if(count($errores) == 0){
    $email = trim($_POST['correo']);
    $pass = trim($_POST['pass']);
    $nom = trim($_POST['nombre']);
    $apell = trim($_POST['apellido']);
    $direc = trim($_POST['direccion']);
    $tel = trim($_POST['telefono']);

    $reg_errores = registrarUsuario($email,$pass, $nom, $apell, $direc, $tel);

    if(count($reg_errores) == 0){
      header('Location: nowLogin.php');
    } else {
      $errores = array_merge($errores,$reg_errores);
    }

  }
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "Registro";
include "head.html"
?>

<body>
  <!-- Navigation -->
  <?php
  include "navbar.php";
  ?>

  <!-- Page Content -->
  <div class="container mt-5 mb-5 col-sm-11 col-md-8 col-lg-4 col-xl-4">
    </br></br>
    <div class="shadow card" style="border-top: 10px solid #138496">
      <div class="card-body">
        <h4 class="card-title text-center">Crear cuenta</h4>
        <hr>
        <?php imprimirErrores($errores) ?>
        <form method="POST">
          <label><i class="fa fa-envelope"></i> Correo electronico</label>
          <input name="correo" type="email" class="form-control" placeholder="tucorreo@gmail.com">
          <br>
          <label><i class="fa fa-asterisk"></i> Contraseña</label>
          <input name="pass" type="password" class="form-control" placeholder="********">
          <br>
          <label><i class="fa fa-user-circle-o"></i> Nombre</label>
          <input name="nombre" type="text" class="form-control" placeholder="Nombre">
          <br>
          <label><i class="fa fa-user-circle-o"></i> Apellido</label>
          <input name="apellido" type="text" class="form-control" placeholder="Apellido">
          <br>
          <label><i class="fa fa-map-marker"></i> Direccion</label>
          <input name="direccion" type="text" class="form-control" placeholder="Direccion">
          <br>
          <label><i class="fa fa-phone"></i> Telefono</label>
          <input name="telefono" type="tel" class="form-control" placeholder="622-123-1234" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
          <br>
          <button name="send-login" type="submit" class="btn btn-info btn-lg ml-auto d-block">Crear cuenta</button>
        </form>
        <hr>
        <p>Ya tienes cuenta?</p>
        <a class="btn btn-primary" href="login.php" role="button">Iniciar sesión</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php
  include "footer.html"
  ?>

</body>

</html>