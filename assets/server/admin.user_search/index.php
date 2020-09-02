<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

        require_once dirname(__FILE__) . "/../../../config.php";

        require_once ROOT."assets/php/autoload.php";

        $checkDB = new DataController($_AdminUsers);
        $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

        if (intval($checkDATA["user_rights"]) === 1) {
            $str = $_POST["search"];

            $db = new DataController($_AdminUsers);

            $cols = [
                "id",
                "firstname",
                "lastname",
                "username",
                "email"
            ];

            $db->concat = [
                "firstname",
                "lastname"
            ];

            $q = $db->search($str, $cols);

            if ($q !== "nof") {
                $data = [];
                foreach ($q as $val) {
                    $subData = [
                        "id" => $val["id"],
                        "firstname" => $val["firstname"],
                        "lastname" => $val["lastname"],
                        "username" => $val["username"],
                        "email" => $val["email"],
                        "email" => $val["email"],
                        "user_rights" => boolval($val["user_rights"]),
                        "ad_rights" => boolval($val["ad_rights"]),
                        "address_rights" => boolval($val["address_rights"]),
                        "policy_rights" => boolval($val["policy_rights"]),
                        "ip_rights" => boolval($val["ip_rights"]),
                        "newsletter_rights" => boolval($val["newsletter_rights"])
                    ];
                    array_push($data, $subData);
                }
                $rsp = array(
                    "status" => True,
                    "data" => $data
                );
            } else {
                $rsp = array(
                    "status" => False,
                    "type" => "nof"
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

        