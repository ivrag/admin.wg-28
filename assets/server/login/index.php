<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $un = htmlentities($_POST["username"]);
    $pwd = htmlentities($_POST["password"]);

    require_once dirname(__FILE__) . "/../../../config.php";
    require_once ROOT."assets/php/autoload.php";

    $db = new DataController($_AdminUsers);

    $data = $db->read();

    $auth = False;

    sleep(1);

    foreach($data as $val) {
        if ($un === $val["username"] && password_verify($pwd, $val["password"])) {
    
            $_SESSION["auth"] = True;
    
            $_SESSION["wg28-user"] = array(
                "id" => intval($val["id"]),
                "username" => $un,
                "email" => $val["email"],
                "rights" => [
                    "user-rights" => intval($val["user_rights"]),
                    "ad-rights" => intval($val["ad_rights"]),
                    "address-rights" => intval($val["address_rights"]),
                    "policy-rights" => intval($val["policy_rights"]),
                    "ip-rights" => intval($val["ip_rights"]),
                    "newsletter-rights" => intval($val["newsletter_rights"])
                ]
            );

            $auth = True;
    
            $rsp = array(
                "status" => True,
                "url" => "../dashboard/"
            );
            break;
        }
    }

    if ($auth === False) {
        sleep(4);
        $rsp = array(
            "status" => False,
            "msg" => "Der Benutzername oder das Passwort stimmt nicht."
        );
    }

    echo json_encode($rsp);
    exit();
}