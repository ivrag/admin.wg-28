<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../../../config.php";
      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {
        $rawId = $_POST["id"];

        if (is_numeric($rawId)) {
            $id = intval($rawId);

            $db = new DataController($_AdminUsers_TRASH);

            $checkDelete = $db->delete($id);

            if ($checkDelete) {
                $rsp = array(
                    "status" => True
                );
            } else {
                $rsp = array(
                    "status" => False
                );
            }

            echo json_encode($rsp);
        }
      }
    }
}