<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

        require_once dirname(__FILE__) . "/../../../config.php";
        require_once ROOT."assets/php/autoload.php";

        $user_id = intval($_SESSION["wg28-user"]["id"]);
        $firstname = htmlentities($_POST["firstname"]);
        $lastname = htmlentities($_POST["lastname"]);
        $username = htmlentities($_POST["username"]);
        $email = htmlentities($_POST["email"]);

        // check for empty values
        if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email)) {
            // check username lenght
            if (strlen($username) > 4) {
                // check username chars
                if (preg_match("/^[a-zA-Z0-9\s.-]+$/", $username)) {
                    // check email
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $db = new DataController($_AdminUsers);

                        $updateColumns = [
                            "firstname",
                            "lastname",
                            "username",
                            "email"
                        ];
                        $updateValues = [
                            $firstname,
                            $lastname,
                            $username,
                            $email
                        ];

                        $checkUpdate = $db->update($user_id, $updateColumns, $updateValues);

                        if ($checkUpdate) {
                            $rsp = array(
                                "status" => True,
                                "firstname" => $firstname,
                                "lastname" => $lastname,
                                "username" => $username,
                                "email" => $email
                            );
                        } else {
                            if (isset($checkUpdate["type"])) {
                                if ($checkUpdate["type"] === "duplicate-entry") {
                                    $rsp = array(
                                        "status" => False,
                                        "title" => "Benutzer vorhanden ?!",
                                        "msg" => "Es ist bereits ein Nutzer mit identischem Benutzernamen oder derselben E-Mail Adresse vorhanden. Suchen Sie den Benutzer im Suchfeld und ändern Sie stattdessen dort die gewünschten Parameter ab. Diese Vorkehrung dient dazu doppelte Benutzer zu vermeiden, damit die Datenbank sauber gehalten wird."
                                    );
                                }
                            }
                        }
                    } else {
                        $rsp = array(
                            "status" => False,
                            "type" => "email",
                            "title" => "Fälschliche E-Mail Adresse",
                            "msg" => "Die von Ihnen angegebene E-Mail Adresse ist nicht korrekt."
                        );
                    }
                } else {
                    $rsp = array(
                        "status" => False,
                        "type" => "username",
                        "title" => "Zeichen des Benutzernamens",
                        "msg" => "Ihr Benutzername kann nur die Zeichen A-Z, a-z, 0-9 und - enthalten."
                    ); 
                }
            } else {
                $rsp = array(
                    "status" => False,
                    "type" => "username",
                    "title" => "Länge des Benutzernamens",
                    "msg" => "Der Benutzername muss mindestens 5 Zeichen lang sein."
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