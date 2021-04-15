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
  $ivr_websites_active = [
    "home" => False,
    "projects" => [
      "wohnung_28" => False
    ],
    "about" => False,
    "contact" => False,
    "impressum" => False,
    "privacy" => False
  ];

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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "profile") {
    $track = [
      "dashboard" => "../dashboard/",
      "addresses" => "../addresses/",
      "terms" => "../terms/",
      "ip" => "../ip/",
      "advertisement" => "../advertisement/",
      "newsletter"  => "../newsletter/",
      "users" => "../users/",
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "./",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
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
      "users_trash" => "../users_trash/",
      "ivr_websites_home" => "../ivr/websites/home",
      "ivr_websites_wohnung_28" => "../ivr/websites/projects/wohnung_28",
      "ivr_websites_about" => "../ivr/websites/about",
      "ivr_websites_contact" => "../ivr/websites/contact",
      "ivr_websites_impressum" => "../ivr/websites/impressum",
      "ivr_websites_privacy" => "../ivr/websites/privacy"
    ];
    $logo = "../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/home") {
    $ivr_websites_active["home"] = True;

    $track = [
      "dashboard" => "../../../dashboard/",
      "addresses" => "../../../addresses/",
      "terms" => "../../../terms/",
      "ip" => "../../../ip/",
      "advertisement" => "../../../advertisement/",
      "newsletter"  => "../../../",
      "users" => "../../../users/",
      "users_trash" => "../../../users_trash/",
      "ivr_websites_home" => "./",
      "ivr_websites_wohnung_28" => "../projects/wohnung_28",
      "ivr_websites_about" => "../about",
      "ivr_websites_contact" => "../contact",
      "ivr_websites_impressum" => "../impressum",
      "ivr_websites_privacy" => "../privacy"
    ];
    $logo = "../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/projects/wohnung_28") {
    $ivr_websites_active["projects"]["wohnung_28"] = True;

    $track = [
      "dashboard" => "../../../../dashboard/",
      "addresses" => "../../../../addresses/",
      "terms" => "../../../../terms/",
      "ip" => "../../../../ip/",
      "advertisement" => "../../../../advertisement/",
      "newsletter"  => "../../../../",
      "users" => "../../../../users/",
      "users_trash" => "../../../../users_trash/",
      "ivr_websites_home" => "../../home",
      "ivr_websites_wohnung_28" => "./",
      "ivr_websites_about" => "../../about",
      "ivr_websites_contact" => "../../contact",
      "ivr_websites_impressum" => "../../impressum",
      "ivr_websites_privacy" => "../../privacy"
    ];
    $logo = "../../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/about") {
    $ivr_websites_active["about"] = True;

    $track = [
      "dashboard" => "../../../dashboard/",
      "addresses" => "../../../addresses/",
      "terms" => "../../../terms/",
      "ip" => "../../../ip/",
      "advertisement" => "../../../advertisement/",
      "newsletter"  => "../../../",
      "users" => "../../../users/",
      "users_trash" => "../../../users_trash/",
      "ivr_websites_home" => "../home",
      "ivr_websites_wohnung_28" => "../projects/wohnung_28",
      "ivr_websites_about" => "./",
      "ivr_websites_contact" => "../contact",
      "ivr_websites_impressum" => "../impressum",
      "ivr_websites_privacy" => "../privacy"
    ];
    $logo = "../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/contact") {
    $ivr_websites_active["contact"] = True;

    $track = [
      "dashboard" => "../../../dashboard/",
      "addresses" => "../../../addresses/",
      "terms" => "../../../terms/",
      "ip" => "../../../ip/",
      "advertisement" => "../../../advertisement/",
      "newsletter"  => "../../../",
      "users" => "../../../users/",
      "users_trash" => "../../../users_trash/",
      "ivr_websites_home" => "../home",
      "ivr_websites_wohnung_28" => "../projects/wohnung_28",
      "ivr_websites_about" => "../about",
      "ivr_websites_contact" => "./",
      "ivr_websites_impressum" => "../impressum",
      "ivr_websites_privacy" => "../privacy"
    ];
    $logo = "../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/impressum") {
    $ivr_websites_active["impressum"] = True;

    $track = [
      "dashboard" => "../../../dashboard/",
      "addresses" => "../../../addresses/",
      "terms" => "../../../terms/",
      "ip" => "../../../ip/",
      "advertisement" => "../../../advertisement/",
      "newsletter"  => "../../../",
      "users" => "../../../users/",
      "users_trash" => "../../../users_trash/",
      "ivr_websites_home" => "../home",
      "ivr_websites_wohnung_28" => "../projects/wohnung_28",
      "ivr_websites_about" => "../about",
      "ivr_websites_contact" => "../contact",
      "ivr_websites_impressum" => "./",
      "ivr_websites_privacy" => "../privacy"
    ];
    $logo = "../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../lib/img/brand/brand-ivr-dark.svg";
  } elseif ($page === "ivr/websites/privacy") {
    $ivr_websites_active["privacy"] = True;

    $track = [
      "dashboard" => "../../../dashboard/",
      "addresses" => "../../../addresses/",
      "terms" => "../../../terms/",
      "ip" => "../../../ip/",
      "advertisement" => "../../../advertisement/",
      "newsletter"  => "../../../",
      "users" => "../../../users/",
      "users_trash" => "../../../users_trash/",
      "ivr_websites_home" => "../home",
      "ivr_websites_wohnung_28" => "../projects/wohnung_28",
      "ivr_websites_about" => "../about",
      "ivr_websites_contact" => "../contact",
      "ivr_websites_impressum" => "./impressum",
      "ivr_websites_privacy" => "./"
    ];
    $logo = "../../../lib/img/logo/logo-ivr-dark.svg";
    $brand = "../../../lib/img/brand/brand-ivr-dark.svg";
  } else {
    header("Location: ".ROOT_DIR."404");
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
    <img id="wg-28-rounded-brand" src="<?php echo $logo ?>" width="30rem" alt="Wohnung 28">
  </div>
  <div class="sidebar-brand-text mx-3">
    <img id="wg-28-brand" src="<?php echo $brand ?>" width="145rem" alt="Wohnung 28">
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

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  IVR AG
</div>
<li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIvrPages" aria-expanded="true" aria-controls="collapseTrash">
      <i class="fas fa-globe"></i>
        <span>Webseite</span>
      </a>
      <div id="collapseIvrPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?php echo ($ivr_websites_active["home"]) ? 'active' : '' ?>" href="<?php echo $track["ivr_websites_home"] ?>">Home</a>
          <a class="collapse-item <?php echo ($ivr_websites_active["projects"]["wohnung_28"]) ? 'active' : '' ?>" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Projekte <span class="float-right"><i class="fas fa-caret-down"></i></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="<?php echo $track["ivr_websites_wohnung_28"] ?>">Wohnung 28</a>
          </div>
          <a class="collapse-item <?php echo ($ivr_websites_active["about"]) ? 'active' : '' ?>" href="<?php echo $track["ivr_websites_about"] ?>">Über uns</a>
          <a class="collapse-item <?php echo ($ivr_websites_active["contact"]) ? 'active' : '' ?>" href="<?php echo $track["ivr_websites_contact"] ?>">Kontakt</a>
          <a class="collapse-item <?php echo ($ivr_websites_active["impressum"]) ? 'active' : '' ?>" href="<?php echo $track["ivr_websites_impressum"] ?>">Impressum</a>
          <a class="collapse-item <?php echo ($ivr_websites_active["privacy"]) ? 'active' : '' ?>" href="<?php echo $track["ivr_websites_privacy"] ?>">Datenschutz</a>

        </div>
      </div>
  </li>

  <?php
  // if ($rights["address-rights"] || $rights["policy-rights"] || $rights["ip-rights"]) {
  //   echo '<!-- Divider -->
  //   <hr class="sidebar-divider">
    
  //   <!-- Heading -->
  //   <div class="sidebar-heading">
  //     Wohnung 28
  //   </div>';

  //   if ($rights["address-rights"]) {
  //     echo '<li class="nav-item ' . ($addresses_active ? "active" : "") . '">
  //     <a class="nav-link" href="' . $track["addresses"] . '">
  //     <i class="fas fa-map-marked-alt"></i>
  //       <span>Adressen</span></a>
  //     </li>';
  //   }

  //   if ($rights["policy-rights"]) {
  //     echo '<li class="nav-item ' . ($terms_active ? "active" : "") . '">
  //     <a class="nav-link" href="' . $track["terms"] . '">
  //     <i class="fas fa-handshake"></i>
  //       <span>Richtlinien</span></a>
  //     </li>';
  //   }
  // }

  // if ($rights["ip-rights"]) {
  //   echo '<li class="nav-item ' . ($ip_active ? "active" : "") . '">
  //   <a class="nav-link" href="' . $track["ip"] . '">
  //   <i class="fas fa-server"></i>
  //     <span>IP-Freigabe</span></a>
  //   </li>';
  // }

  // if ($rights["ad-rights"]) {
  //   echo '<!-- Divider -->
  //   <hr class="sidebar-divider">
  //   <!-- Heading -->
  //   <div class="sidebar-heading">
  //     Inserate
  //   </div>
  
  //   <li class="nav-item ' . ($advertisement_active ? "active" : "") . '">
  //     <a class="nav-link" href="' . $track["advertisement"] . '">
  //     <i class="fas fa-file-code"></i>
  //       <span>Inserate</span></a>
  //     </li>';
  // }

  // if ($rights["newsletter-rights"]) {
  //   echo '<!-- Divider -->
  //   <hr class="sidebar-divider">
  
  //   <!-- Heading -->
  //   <div class="sidebar-heading">
  //     Newsletter
  //   </div>
  
  //   <!-- Nav Item - Newsletter -->
  //   <li class="nav-item ' . ($newsletter_active ? "active" : "") . '">
  //       <a class="nav-link" href="' . $track["newsletter"] . '">
  //       <i class="fas fa-paper-plane"></i>
  //       <span>Newsletter</span></a>
  //   </li>';
  // }

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