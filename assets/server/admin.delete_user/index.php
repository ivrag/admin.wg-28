<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../config.php";

      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

        if (intval($checkDATA["user_rights"]) === 1) {
            $rawId = $_POST["id"];

            if (is_numeric($rawId)) {
                $users = new DataController($_AdminUsers);
                $trash = new DataController($_AdminUsers_TRASH);

                if (intval($trash->count()) < 2500) {
                    $id = intval($rawId);

                    $user_info = $users->selectId($id);
    
                    $uid = intval($user_info["id"]);
                    $firstname = $user_info["firstname"];
                    $lastname = $user_info["lastname"];
                    $username = $user_info["username"];
                    $password = $user_info["password"];
                    $email = $user_info["email"];
                    $user_rights = intval($user_info["user_rights"]);
                    $ad_rights = intval($user_info["ad_rights"]);
                    $address_rights = intval($user_info["address_rights"]);
                    $policy_rights = intval($user_info["policy_rights"]);
                    $ip_rights = intval($user_info["ip_rights"]);
                    $newsletter_rights = intval($user_info["newsletter_rights"]);
    
                    $insertColumns = [
                        "uid",
                        "firstname",
                        "lastname",
                        "username",
                        "password",
                        "email",
                        "user_rights",
                        "ad_rights",
                        "address_rights",
                        "policy_rights",
                        "ip_rights",
                        "newsletter_rights"
                    ];
    
                    $insertValues = [
                        $uid,
                        $firstname,
                        $lastname,
                        $username,
                        $password,
                        $email,
                        $user_rights,
                        $ad_rights,
                        $address_rights,
                        $policy_rights,
                        $ip_rights,
                        $newsletter_rights
                    ];
    
                    $checkInsert = $trash->insert($insertColumns, $insertValues);
    
                    if ($checkInsert["status"] === True) {
                        $checkDelete = $users->delete($id);
    
                        if ($checkDelete === True) {
                            $rsp = array(
                                "status" => True,
                                "title" => "Benutzer gelöscht",
                                "msg" => "$firstname $lastname wurde erfolgreich in den Papierkorb verschoben."
                            );
                        } else {
                            $rsp = array(
                                "status" => False,
                                "title" => "Fehler",
                                "msg" => "Der Benutzer $firstname $lastname konnte nicht gelöscht werden."
                            );
                        }
                    } else {
                        $rsp = array(
                            "status" => False,
                            "title" => "Fehler",
                            "msg" => "Der Benutzer $firstname $lastname konnte nicht gelöscht werden."
                        );
                    }
                } else {
                    $rsp = array(
                        "status" => False,
                        "title" => "Benutzerpapierkorb gefüllt",
                        "msg" => "Der Benutzer konnte nicht gelöscht werden, da der Papierkorb für Benutzer voll ist."
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