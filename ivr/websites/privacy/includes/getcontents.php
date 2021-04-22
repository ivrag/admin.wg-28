<?php
ob_start();
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
        require_once dirname(__FILE__) . "/../../../../config.php";

        require_once ROOT."assets/php/autoload.php";

        $dbGET = new DataController($_AdminWebsite);
        $id = NULL;
        foreach ($dbGET->read() as $val) {
            if ($val["name"] === "privacy") {
                $id = $val["id"];
                break;
            }
        }

        $db = new DataController($_AdminWebsite);
        echo json_encode(["contents" => json_decode($db->selectId($id)["contents"]), "img_url" => ROOT_DIR . "ivr/websites/includes/upload/"]);
    }
}
$length = ob_get_length();
header('Content-Length: '.$length."\r\n");
ob_end_flush();