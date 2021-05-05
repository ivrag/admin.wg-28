<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
        require_once dirname(__FILE__) . "/../../../../config.php";

        require_once ROOT."assets/php/autoload.php";

        $dbGET = new DataController($_AdminWebsite);
        $id = NULL;
        foreach ($dbGET->read() as $val) {
            if ($val["name"] === "contact") {
                $id = $val["id"];
                break;
            }
        }

        $db = new DataController($_AdminWebsite);
        echo json_encode(["contents" => json_decode($db->selectId($id)["contents"]), "img_url" => ROOT . "ivr/websites/includes/upload/"]);
    }
}