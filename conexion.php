<?php

$con = mysqli_connect(
    getenv("DB_HOST"),
    getenv("DB_USERNAME"),
    getenv("DB_PASSWORD"),
    getenv("DB_NAME"),
    getenv("DB_PORT")
);

if (!$con) {
    die("Error al conectar: " . mysqli_connect_error());
}