<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../../../config.php";
      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {

        $db = new DataController($_AdminUsers_TRASH);

        $current = intval($db->count());

        $taken = (100/2500) * $current;

        $free = 100 - $taken;

        $class;
        if ($taken >= 0 && $taken <= 50) {
          $class = "bg-success";
        } elseif ($taken > 50 && $taken <= 75) {
          $class = "bg-info";
        } elseif ($taken > 75 && $taken <= 95) {
          $class = "bg-warning";
        } elseif ($taken > 95 && $taken <= 100) {
          $class = "bg-danger";
        }

        $rsp = array(
          "status" => True,
          "current" => $current,
          "of" => 2500,
          "taken" => number_format($taken, 2),
          "free" => number_format($free, 2),
          "class" => $class
        );
      } else {
        $rsp = array(
          "status" => False,
          "title" => "Zugang verweigert",
          "msg" => "Sie haben keine Rechte, um diese Aktion durchzuführen."
        );
      }

      echo json_encode($rsp);
    }
}