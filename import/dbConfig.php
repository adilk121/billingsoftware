<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'ei_tharichoice';
$dbPassword = '1JVHTD#%vrM0';
$dbName = 'ei_tharichoice';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}