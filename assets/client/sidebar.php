<?php
@session_start();

if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
  require_once dirname(__FILE__) . "/../../config.php";

  $dashboard_active = False;
  $users_active = False;
  $user_trash_active = False;
  $addresses_active = False;
  $terms_active = False;
  $ip_active = False;
  $advertisement_active = False;
  $newsletter_active = False;

  if ($page === "dashboard") {
    $dashboard_active = True;

    $track = [
      "dashboard" => "./",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "users") {
    $users_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "./",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "profile") {
    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "users_trash") {
    $user_trash_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "./"
    ];
  } elseif ($page === "addresses") {
    $addresses_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "./",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "terms") {
    $terms_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "./",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "ip") {
    $ip_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "./",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "advertisement") {
    $advertisement_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "./",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } elseif ($page === "newsletter") {
    $newsletter_active = True;

    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "./",
      "users" => "../users/",
      "users_trash" => "../users_trash/"
    ];
  } else {
    header("Location: /2020/admin.wg-28/404");
  }

  require_once ROOT."assets/php/autoload.php";

  $db = new DataController($_AdminUsers);

  $id = intval($_SESSION["wg28-user"]["id"]);
  $data = $db->selectId($id);
  $rights = [
    "ad-rights" => intval($data["ad_rights"]),
    "address-rights" => intval($data["address_rights"]),
    "policy-rights" => intval($data["policy_rights"]),
    "ip-rights" => intval($data["ip_rights"]),
    "newsletter-rights" => intval($data["newsletter_rights"]),
    "user-rights" => intval($data["user_rights"])
  ];
?>

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $track["dashboard"] ?>">
  <div class="sidebar-brand-icon">
    <img id="wg-28-rounded-brand" src="../lib/img/logo/logo-ivr-dark.svg" width="30rem" alt="Wohnung 28">
  </div>
  <div class="sidebar-brand-text mx-3">
    <img id="wg-28-brand" src="../lib/img/brand/brand-ivr-dark.svg" width="145rem" alt="Wohnung 28">
  </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?php echo ($dashboard_active) ? 'active' : '' ?>">
  <a class="nav-link" href="<?php echo $track["dashboard"] ?>">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Übersicht</span></a>
</li>

  <?php

  if ($rights["address-rights"] || $rights["policy-rights"] || $rights["ip-rights"]) {
    echo '<!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
      Wohnung 28
    </div>';

    if ($rights["address-rights"]) {
      echo '<li class="nav-item ' . ($addresses_active ? "active" : "") . '">
      <a class="nav-link" href="' . $track["addresses"] . '">
      <i class="fas fa-map-marked-alt"></i>
        <span>Adressen</span></a>
      </li>';
    }
    ?>

    <?php
    if ($rights["policy-rights"]) {
      echo '<li class="nav-item ' . ($terms_active ? "active" : "") . '">
      <a class="nav-link" href="' . $track["terms"] . '">
      <i class="fas fa-handshake"></i>
        <span>Richtlinien</span></a>
      </li>';
    }
  }
    ?>

    <?php
    if ($rights["ip-rights"]) {
      echo '<li class="nav-item ' . ($ip_active ? "active" : "") . '">
      <a class="nav-link" href="' . $track["ip"] . '">
      <i class="fas fa-server"></i>
        <span>IP-Freigabe</span></a>
      </li>';
    }
  ?>


<?php
  if ($rights["ad-rights"]) {
    echo '<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
      Inserate
    </div>
  
    <li class="nav-item ' . ($advertisement_active ? "active" : "") . '">
      <a class="nav-link" href="' . $track["advertisement"] . '">
      <i class="fas fa-file-code"></i>
        <span>Inserate</span></a>
      </li>';
  }
  ?>

  <?php
  if ($rights["newsletter-rights"]) {
    echo '<!-- Divider -->
    <hr class="sidebar-divider">
  
    <!-- Heading -->
    <div class="sidebar-heading">
      Newsletter
    </div>
  
    <!-- Nav Item - Newsletter -->
    <li class="nav-item ' . ($newsletter_active ? "active" : "") . '">
        <a class="nav-link" href="' . $track["newsletter"] . '">
        <i class="fas fa-paper-plane"></i>
        <span>Newsletter</span></a>
    </li>';
  }

  if ($rights["user-rights"]) {
    echo '<!-- Divider -->
    <hr class="sidebar-divider">
  
    <!-- Heading -->
    <div class="sidebar-heading">
      App
    </div>
  
    <!-- Nav Item - Users -->
    <li class="nav-item ' . ($users_active ? "active" : "") . '">
        <a class="nav-link" href="' . $track["users"] . '">
        <i class="fas fa-users"></i>
        <span>Benutzer</span></a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link ' . ($user_trash_active ? "" : "collapsed") . '" href="#" data-toggle="collapse" data-target="#collapseTrash" aria-expanded="true" aria-controls="collapseTrash">
        <i class="fas fa-trash-alt"></i>
        <span>Papierkorb</span>
      </a>
      <div id="collapseTrash" class="collapse ' . ($user_trash_active ? "show" : "") . '" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item ' . ($user_trash_active ? "active" : "") . '" href="' . $track["users_trash"] . '">Gelöschte Benutzer</a>
        </div>
      </div>
    </li>';
  }
  ?>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<?php
}
?>