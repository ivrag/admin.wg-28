<?php
session_start();

if (isset($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
    header("Location: ./dashboard/");
} else {
    header("Location: ./login/");
}