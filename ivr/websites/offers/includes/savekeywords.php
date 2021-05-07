<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
        $data = $_POST["keyWordsData"];
        require_once dirname(__FILE__) . "/../../../../config.php";

        require_once ROOT."assets/php/autoload.php";

        $dbGET = new DataController($_AdminWebsite);
        $id = NULL;
        foreach ($dbGET->read() as $val) {
            if ($val["name"] === "offers") {
                $id = $val["id"];
                break;
            }
        }

        $db = new DataController($_AdminWebsite);
        $db->update($id, ["keywords"], [$data]);

        echo json_encode(["success" => 1]);
    }
}