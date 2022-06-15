<!DOCTYPE html>
<html lang='es'>

<head>
  <title>Orders manager</title>
  <link rel="icon" href="/Imagenes/docs.png">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="/Maquetacion/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form id="formulario" name="formularlo" method="post" action="control.php">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="usr" name="usr" class="form-control" placeholder="Nombre de usuario" required="required" autofocus="autofocus" value="admin">
              <label for="usr">Usuario</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Contraseña" required="required" value="admin">
              <label for="pwd">Contraseña</label>
            </div>
          </div>
          <input type="submit" id="ingresar" name="ingresar" value="Ingresar" class="btn btn-primary btn-block">
          <div class="text-center"><br />
            <label>
              <?php
              $e = null;
              if (isset($_GET['error'])) {
                $e = $_GET['error'];
                if ($e == 1) {
                  echo "Usuario o contraseña incorrecta";
                } else if ($e == 2) {
                  echo "Debe ingresar al sistema";
                } else if ($e == 3) {
                  echo "El usuario fue inabilitado";
                } else if ($e == 4) {
                  echo "Error de nivel de acceso: ";
                } else if ($e == 5) {
                  echo "Cadena de conexión a Database erronea";
                }
              }
              ?>
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
</body>

</html>