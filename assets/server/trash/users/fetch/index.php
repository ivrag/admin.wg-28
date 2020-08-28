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

        $raw = $db->asc("firstname");

        $data = [];

        if (intval(count($raw)) > 0) {
          foreach ($raw as $val) {
            array_push($data, array(
                "id" => $val["id"],
                "uid" => $val["uid"],
                "firstname" => $val["firstname"],
                "lastname" => $val["lastname"],
                "username" => $val["username"],
                "email" => $val["email"]
            ));
          }

          echo json_encode($data);
        } else {
          $rsp = array(
            "status" => False
          );
          echo json_encode($rsp);
        }
      }
    }
}