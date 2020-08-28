<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../config.php";

      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

        if (intval($checkDATA["user_rights"]) === 1) {
            $id = $_POST["id"];

            if (is_numeric($id)) {
                $db = new DataController($_AdminUsers);

                $updateColumns = [
                    "user_rights",
                    "ad_rights",
                    "address_rights",
                    "policy_rights",
                    "ip_rights",
                    "newsletter_rights"
                ];

                $updateValues = [
                    0,
                    0,
                    0,
                    0,
                    0,
                    0
                ];

                $updateCheck = $db->update($id, $updateColumns, $updateValues);

                if ($updateCheck) {
                    $rsp = array(
                        "status" => True,
                        "title" => "Rechte geändert",
                        "msg" => "Der Benutzer wurde erfolgreich blockiert."
                    );
                } else {
                    $rsp = array(
                        "status" => False,
                        "title" => "Bearbeitung fehlgeschlagen",
                        "msg" => "Die Bearbeitung der Rechte ist fehlgeschlagen."
                    );
                }
            } else {
                $rsp = array(
                    "status" => False,
                    "title" => "Bearbeitung fehlgeschlagen",
                    "msg" => "Die Bearbeitung der Rechte ist fehlgeschlagen."
                );
            }

            echo json_encode($rsp);
            exit();

        }
    }
}