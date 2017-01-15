<?php

// Default auth variables
$auth = [];

// Store all authentication keys with default values
foreach (Amir::$authenticationKeys as $key) {
    $auth[$key[0]] = $key[1];
}

// Get all authentication keys from session if exist
foreach ($auth as $key => $value) {
    if (empty($_SESSION["auth"][$key])) {
        break;
    }
    $auth[$key] = $_SESSION["auth"][$key];
}
?>
