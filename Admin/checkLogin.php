<?php
include_once "../functions.php";
startSession();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 'OK') {
    header('Location: ./login.php');
    die;
}