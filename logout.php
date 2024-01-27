<?php
require_once "functions.php";
startSession();
session_destroy();
// unset($_SESSION['login'])
header('Location: ./');