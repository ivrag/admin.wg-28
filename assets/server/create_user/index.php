<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

        require_once dirname(__FILE__) . "/../../../config.php";

        require_once ROOT."assets/php/autoload.php";

        $checkDB = new DataController($_AdminUsers);
        $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

        if (intval($checkDATA["user_rights"]) === 1) {
            $values = json_decode($_POST["values"]);
            $firstname = htmlentities($values->firstname);
            $lastname = htmlentities($values->lastname);
            $username = htmlentities($values->username);
            $email = htmlentities($values->email);
            $password = htmlentities($values->password);
            $password_repeat = htmlentities($values->password_repeat);

            $rights = $values->rights;

            $user_rights = $rights->user_rights;
            $ad_rights = $rights->ad_rights;
            $address_rights = $rights->address_rights;
            $terms_rights = $rights->terms_rights;
            $ip_rights = $rights->ip_rights;
            $newsletter_rights = $rights->newsletter_rights;

            // validate user information

            // check for empty values
            if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password) && !empty($password_repeat)) {
                // check username length
                if (strlen($username) > 4) {
                    // check username chars
                    if (preg_match("/^[a-zA-Z0-9\s.-]+$/", $username)) {
                        // check email
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            // check password comparison
                            if ($password === $password_repeat) {
                                // check password length
                                if (strlen($password) > 5) {
                                    // check for unexpected boolean values
                                    if (gettype($user_rights) === "boolean" &&
                                    gettype($ad_rights) === "boolean" &&
                                    gettype($address_rights) === "boolean" &&
                                    gettype($terms_rights) === "boolean" &&
                                    gettype($ip_rights) === "boolean" &&
                                    gettype($newsletter_rights) === "boolean") {

                                        $db = new DataController($_AdminUsers);

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

                                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                                        $insertValues = [
                                            $firstname,
                                            $lastname,
                                            $username,
                                            $hashedPassword,
                                            $email,
                                            $user_rights,
                                            $ad_rights,
                                            $address_rights,
                                            $terms_rights,
                                            $ip_rights,
                                            $newsletter_rights
                                        ];

                                        $checkInsertion = $db->insert($insertColumns, $insertValues);

                                        if ($checkInsertion["status"] === True) {
                                            $rsp = array(
                                                "status" => True
                                            );
                                        } else {
                                            if (isset($checkInsertion["type"])) {
                                                if ($checkInsertion["type"] === "duplicate-entry") {
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
                                            "title" => "Unerwartete Rechtwerte",
                                            "msg" => "Unerwartete Werte wurden übermittelt."
                                        );
                                    }
                                } else {
                                    $rsp = array(
                                        "status" => False,
                                        "type" => "password",
                                        "title" => "Passwort Länge",
                                        "msg" => "Das Passwort muss mindestens 6 Zeichen lang sein."
                                    );  
                                }
                            } else {
                                $rsp = array(
                                    "status" => False,
                                    "type" => "password",
                                    "title" => "Passwortkontrolle",
                                    "msg" => "Die Passwortkontrolle ist fehlgeschlagen. Das Password und die Passwortwiederholung müssen übereinstimmen."
                                ); 
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
        } else {
            $rsp = array(
                "status" => False,
                "type" => "permission-denied",
                "title" => "Zugang verweigert",
                "msg" => "Sie haben keine Rechte, um diese Aktion durchzuführen."
            );
        }
        
        echo json_encode($rsp);
        exit();
    }
}