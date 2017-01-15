<?php

// Creating connection handle
$sql = new mysqli("localhost", "amir-php", "", "amir-php");

// Checking error
if (mysqli_connect_error($sql)) {
    die(mysqli_connect_error($sql));
}
