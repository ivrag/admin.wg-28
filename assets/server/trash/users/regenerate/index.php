<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../../../config.php";
      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {
          $raw = $_POST["id"];

          if (is_numeric($raw)) {
            $id = intval($raw);

            $genPWD =   ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            $genLen = count($genPWD) - 1;

            $ranPWD = $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)] . "-" . $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)] . "-" . $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)] . $genPWD[rand(0, $genLen)];

            $users = new DataController($_AdminUsers);
            $deleted = new DataController($_AdminUsers_TRASH);

            $del_info = $deleted->selectId($id);

            $firstname = $del_info["firstname"];
            $lastname = $del_info["lastname"];
            $username = $del_info["username"];
            $email = $del_info["email"];

            $insertColumns = [
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
                $firstname,
                $lastname,
                $username,
                password_hash($ranPWD, PASSWORD_DEFAULT),
                $email,
                0,
                0,
                0,
                0,
                0,
                0
            ];

            $checkInsert = $users->insert($insertColumns, $insertValues) or die("unable to communicate to mysql...");

            if ($checkInsert["status"] === true) {
                $checkDeleted = $deleted->delete($id);
                if ($checkDeleted) {
                    $rsp = array(
                        "status" => True,
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "username" => $username,
                        "pwd" => $ranPWD
                    );
                } else {
                    $rsp = array(
                        "status" => False,
                        "title" => "Fehler",
                        "msg" => "Beim wiederherstellen eines Benutzers ist ein Fehler aufgetreten. Versichern Sie sich, dass Ihre Internetverbindung stabil ist und versuchen Sie es erneut."
                    );
                }
            } else {
                $rsp = array(
                    "status" => False,
                    "title" => "Fehler",
                    "msg" => "Beim wiederherstellen eines Benutzers ist ein Fehler aufgetreten. Versichern Sie sich, dass Ihre Internetverbindung stabil ist und versuchen Sie es erneut."
                );
            }
          } else {
            $rsp = array(
                "status" => False,
                "title" => "Unerwartete Daten",
                "msg" => "Es wurden unerwartete Daten übermittelt."
            );
          }

          echo json_encode($rsp);
      }
    }
}