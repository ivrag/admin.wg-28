<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../config.php";

      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {
        $id = intval($_POST["id"]);

        $db = new DataController($_AdminUsers);

        $data = $db->selectId($id);

        $response = [];

        $response["id"] = intval($data["id"]);
        $response["firstname"] = $data["firstname"];
        $response["lastname"] = $data["lastname"];
        $response["username"] = $data["username"];
        $response["email"] = $data["email"];
        $response["user_rights"] = boolval($data["user_rights"]);
        $response["ad_rights"] = boolval($data["ad_rights"]);
        $response["address_rights"] = boolval($data["address_rights"]);
        $response["policy_rights"] = boolval($data["policy_rights"]);
        $response["ip_rights"] = boolval($data["ip_rights"]);
        $response["newsletter_rights"] = boolval($data["newsletter_rights"]);

        echo json_encode($response);
      }
    }
}