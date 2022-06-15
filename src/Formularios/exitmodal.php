<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Desea salir?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Seleccione "Salir" si desea cerrar la sesion actual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="/salir.php">Salir</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="logoutModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos de perfil actual</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        require 'conexion.php';
        $query = "SELECT u.nombre,u.ap_paterno,u.ap_materno,u.usuario,u.nivel
FROM  `usuario` as u where u.id_usuario=" . "1"; //$_SESSION['id']
        $r = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($r)) {
          echo "<h6>Nombre completo</h6>";
          echo "<label>" . $row['nombre'] . " " . $row['ap_paterno'] . " " . $row['ap_materno'] . "</label>";
          echo "<h6>Nombre de usuario</h6>";
          echo "<label>" . $row['usuario'] . "</label>";
          echo "<h6>Nivel de acceso</h6>";
          echo "<label>" . $row['nivel'] . "</label>";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<div class="box" style="display: none;">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <div style="padding-top: 13px;padding-left: 7px"><i class="fas fa-exclamation-triangle"></i> Debe imprimir su itinerario</div>
</div>