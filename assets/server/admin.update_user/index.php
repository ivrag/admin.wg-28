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
        $firstname = htmlentities($_POST["firstname"]);
        $lastname = htmlentities($_POST["lastname"]);
        $rights = json_decode($_POST["rights"]);

        if (gettype($rights->user_rights) === "boolean" &&
            gettype($rights->ad_rights) === "boolean" &&
            gettype($rights->address_rights) === "boolean" &&
            gettype($rights->policy_rights) === "boolean" &&
            gettype($rights->ip_rights) === "boolean" &&
            gettype($rights->newsletter_rights) === "boolean") {
          
          $user_rights = htmlentities(intval($rights->user_rights));
          $ad_rights = htmlentities(intval($rights->ad_rights));
          $address_rights = htmlentities(intval($rights->address_rights));
          $policy_rights = htmlentities(intval($rights->policy_rights));
          $ip_rights = htmlentities(intval($rights->ip_rights));
          $newsletter_rights = htmlentities(intval($rights->newsletter_rights));

          $updateColumns = [
            "user_rights",
            "ad_rights",
            "address_rights",
            "policy_rights",
            "ip_rights",
            "newsletter_rights"
          ];

          $updateValues = [
            $user_rights,
            $ad_rights,
            $address_rights,
            $policy_rights,
            $ip_rights,
            $newsletter_rights
          ];

          $db = new DataController($_AdminUsers);
          $updateCheck = $db->update($id, $updateColumns, $updateValues);

          if ($updateCheck) {
            $rsp = array(
              "status" => True,
              "title" => "Rechte geändert",
              "msg" => "Die Rechte für " . $firstname . " " . $lastname . " wurden erfolgreich geändert."
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
            "title" => "Unerwartete Rechtwerte",
            "msg" => "Unerwartete Werte wurden übermittelt."
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
      exit();

    }
}