<?php

require_once dirname(__FILE__) . "/../../../config.php";
require_once ROOT . "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

$_AdminUsers = [
  "server" => $_ENV["ADMIN_SERVER"],
  "database" => $_ENV["ADMIN_DB"],
  "table" => $_ENV["ADMIN_USERS_TABLE"],
  "username" => $_ENV["ADMIN_DB_UN"],
  "password" => $_ENV["ADMIN_DB_PWD"]
];

$_AdminUsers_TRASH = [
  "server" => $_ENV["ADMIN_SERVER"],
  "database" => $_ENV["ADMIN_DB"],
  "table" => $_ENV["ADMIN_TRASH_TABLE"],
  "username" => $_ENV["ADMIN_DB_UN"],
  "password" => $_ENV["ADMIN_DB_PWD"]
];

$_Visitors = [
  "server" => $_ENV["ADMIN_VISIT_SERVER"],
  "database" => $_ENV["ADMIN_VISIT_DB"],
  "table" => $_ENV["ADMIN_VISIT_TABLE"],
  "username" => $_ENV["ADMIN_VISIT_UN"],
  "password" => $_ENV["ADMIN_VISIT_PWD"]
];