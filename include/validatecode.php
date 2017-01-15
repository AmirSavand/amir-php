<?php

// Check if code matches the session one
if (!Amir::isValidSessionCode("code_login", $_POST["token"])) {

    // Failed to validate, if you want to keep record of attackers, do it here
    die("Die attacker, die!");
}
