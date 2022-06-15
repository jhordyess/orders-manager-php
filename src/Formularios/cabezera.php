<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
  <a class="navbar-brand mr-1" href="#">Orders manager</a>
  <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>
  <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
  </form>
  <?php //include ("seguridad.php"); 
  ?>
  <ul class="navbar-nav ml-auto ml-md-0">
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <b>Usuario:</b>
        <span id="alterable">
          <?php echo "Jhordy"/* $_SESSION['nombre'] */; ?>
        </span>
        <i class="fas fa-user-circle fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal2">Mostrar perfil</a>
        <a class="dropdown-item" href="/Formularios/usuario/modificar.php">Modificar usuario</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Cerrar sesion</a>
      </div>
    </li>
  </ul>
</nav>