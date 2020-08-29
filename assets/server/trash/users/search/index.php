<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../../../config.php";
      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {
        $str = $_POST["str"];

        $db = new DataController($_AdminUsers_TRASH);

        $searchColumns = [
          "uid",
          "firstname",
          "lastname",
          "username",
          "email"
        ];

        $q = $db->search($str, $searchColumns);

        if ($q !== "nof") {
          $data = [];

          foreach($q as $val) {
            array_push($data, array(
              "id" => $val["id"],
              "uid" => $val["uid"],
              "firstname" => $val["firstname"],
              "lastname" => $val["lastname"],
              "username" => $val["username"],
              "email" => $val["email"]
            ));
          }

          $rsp = array(
            "status" => True,
            "data" => $data
          );
        } else {
          $rsp = array(
            "status" => False,
            "type" => "nof"
          );
        }
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