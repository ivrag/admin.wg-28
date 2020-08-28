<?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {

      require_once dirname(__FILE__) . "/../../../config.php";

      require_once ROOT."assets/php/autoload.php";

      $checkDB = new DataController($_AdminUsers);
      $checkDATA = $checkDB->selectId(intval($_SESSION["wg28-user"]["id"]));

      if (intval($checkDATA["user_rights"]) === 1) {
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        $dataset = isset($_POST["dataset"]) ? $_POST["dataset"] : 20;

        $pgn = new Pagination($_AdminUsers);

        $total = $pgn->getTotal();
        $realTotal = intval($total - 2);
        $pgn->setTotal($realTotal);

        if (is_numeric($dataset)) {
          $pgn->setLimit(intval($dataset));
        } else {
          var_dump($_POST["dataset"]);
          $rsp = array(
            "status" => false,
            "msg" => "Unbekannter Datentyp!"
          );
          echo json_encode($rsp);
          return False;
        }

        $pgn->setOrder("id", "desc");

        $data = [];

        $ignore = "id!=1 AND id!=" . $_SESSION["wg28-user"]["id"];

        $rawData = $pgn->getDataIgnore($page, $ignore);

        if ($rawData["status"] !== False) {
          foreach ($rawData["data"] as $val) {
            if (intval($val["id"]) !== 1 && intval($val["id"]) !== intval($_SESSION["wg28-user"]["id"])) {
              array_push($data, array(
                "id" => intval($val["id"]),
                "firstname" => $val["firstname"],
                "lastname" => $val["lastname"],
                "username" => $val["username"],
                "email" => $val["email"],
                "user_rights" => boolval($val["user_rights"]),
                "ad_rights" => boolval($val["ad_rights"]),
                "address_rights" => boolval($val["address_rights"]),
                "policy_rights" => boolval($val["policy_rights"]),
                "ip_rights" => boolval($val["ip_rights"]),
                "newsletter_rights" => boolval($val["newsletter_rights"])
              ));
            }
          }
  
          $rsp = array(
            "status" => True,
            "page" => $rawData["page"],
            "links" => $rawData["links"],
            "data" => $data
          );
        } else {
          $rsp = array(
            "status" => False
          );
        }

        echo json_encode($rsp);
      }
    }
}