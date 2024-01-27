<?php
startSession();
session_destroy();
// unset($_SESSION['login'])
header('Location: ./login.php');