<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

        require_once dirname(__FILE__) . "/../../../config.php";
        require_once ROOT."assets/php/autoload.php";

        $user_id = intval($_SESSION["wg28-user"]["id"]);
        $current = $_POST["current_password"];
        $new = $_POST["new_password"];
        $repeat = $_POST["repeat_password"];

        $checkDB = new DataController($_AdminUsers);

        $checkData = $checkDB->selectId($user_id);
        $db_password = $checkData["password"];

        // check for empty values
        if (!empty($current) && !empty($new) && !empty($repeat)) {
            // password comparison
            if ($new === $repeat) {
                // check password length
                if (strlen($new) > 5) {
                    // check current password
                    if (password_verify($current, $db_password)) {
                        $db = new DataController($_AdminUsers);

                        $updateColumns = [
                            "password"
                        ];

                        $hashed_password = password_hash($new, PASSWORD_DEFAULT);

                        $updateValues = [
                            $hashed_password
                        ];

                        $checkUpdate = $db->update($user_id, $updateColumns, $updateValues);

                        if ($checkUpdate) {
                            $rawPwd = $new;
                            $three = substr($rawPwd, 0, 3);
                            $remain = strlen($new) - 3;
                            $final = $three;
                            for ($i = 0; $i < $remain; $i++) {
                                $final .= "*";
                            }
                            $rsp = array(
                                "status" => True,
                                "upd_pwd" => $final
                            );
                        }
                    } else {
                        $rsp = array(
                            "status" => False,
                            "type" => "wrong",
                            "title" => "Falsches Passwort",
                            "msg" => "Das aktuelle Passwort ist falsch."
                        );
                    }
                } else {
                    $rsp = array(
                        "status" => False,
                        "type" => "length",
                        "title" => "Passwort Länge",
                        "msg" => "Das Passwort muss mindestens 6 Zeichen lang sein."
                    );
                }
            } else {
                $rsp = array(
                    "status" => False,
                    "type" => "comparison",
                    "title" => "Passwortkontrolle",
                    "msg" => "Die Passwortkontrolle ist fehlgeschlagen. Das neue Password und die Passwortwiederholung müssen übereinstimmen."
                ); 
            }
        } else {
            $rsp = array(
                "status" => False,
                "type" => "empty",
                "title" => "Leere Felder",
                "msg" => "Es wurden leere Felder erkannt."
            );
        }

        echo json_encode($rsp);
        exit();
    }
}