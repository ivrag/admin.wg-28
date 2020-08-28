<?php
@session_start();

if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

  if ($page == "dashboard") {
    $profile_path = "../profile/";
    $logoff_path = "../logoff/";
  }

  if ($page == "users") {
    $profile_path = "../profile/";
    $logoff_path = "../logoff/";
  }

  if ($page == "profile") {
    $profile_path = "./";
    $logoff_path = "../logoff/";
  }

  if ($page == "users_trash") {
    $profile_path = "../profile/";
    $logoff_path = "../logoff/";
  }
?>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

  <div class="topbar-divider d-none d-sm-block"></div>

  <!-- Nav Item - Profile -->
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo ($id === 1) ? '<i class="fas fa-user-shield fa-lg"></i>' : '<i class="fas fa-user fa-lg"></i>' ?>
    </a>
    <!-- Dropdown - Profile -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="profileDropdown">
      <a class="dropdown-item" href="<?php echo $profile_path ?>">
      <i class="fas fa-user-circle mr-2 text-gray-400"></i> Profil
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="<?php echo $logoff_path ?>">
        <i class="fas fa-power-off mr-2 text-gray-400"></i> Abmelden
      </a>
    </div>
  </li>

</ul>
<?php
}
?>