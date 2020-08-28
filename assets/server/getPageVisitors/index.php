<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
    session_write_close();

    require_once dirname(__FILE__) . "/../../../config.php";
    require_once ROOT."assets/php/autoload.php";

    $db = new DataController($_Visitors);
    $data = $db->read();

    $rsp = array(
        "status" => True,
        "visit" => $data[0]["home"]
    );

    echo json_encode($rsp);
}