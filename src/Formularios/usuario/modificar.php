<?php // ("../seguridad.php"); 
?>
<!DOCTYPE html>
<html lang='es'>

<head>
  <title>Modificar usuario</title>
  <link rel="icon" href="/Imagenes/docs.png">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="/Maquetacion/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Modificar perfil</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>¿Desea modificar su perfil?</h4>
          <p>Ingrese su contraseña actual y modifique su cuenta.</p>
        </div>
        <form method="POST" action='modificando.php'>
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="usuario" name="usuario" class="form-control" required="required" autofocus="autofocus">
              <label for="usuario">Nombre de usuario</label>
            </div>
          </div>

          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="pwd1" name="pwd1" class="form-control" placeholder="Contraseña actual" required="required">
              <label for="pwd1">Contraseña actual</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="pwd2" name="pwd2" class="form-control" placeholder="Contraseña nueva" required="required">
              <label for="pwd2">Contraseña nueva</label>
            </div>

          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="pwd3" name="pwd3" class="form-control" placeholder="Contraseña nueva" required="required">
              <label for="pwd3">Repita contraseña nueva</label>
            </div>
          </div>
          <input type="submit" name="modificar" id="modificar" value="Guardar cambio" class="btn btn-primary">
          <a class="btn btn-primary" href="/Formularios/Pagina%20principal.php">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
</body>

</html>