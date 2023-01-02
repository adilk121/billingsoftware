<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'webkeyco_auto';
$dbPassword = 'autocreation@12345';
$dbName = 'webkeyco_auto-creation';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}