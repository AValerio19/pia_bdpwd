<?php

$db_host = getenv("DB_HOST");
$db_user = getenv("DB_USER");
$db_pass = getenv("DB_PASS");
$db_name = getenv("DB_NAME");
$db_port = getenv("DB_PORT");

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$con) {
    die("Error al conectar: " . mysqli_connect_error());
}