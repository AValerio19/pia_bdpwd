<?php
$con = mysqli_connect("localhost", "root", "", "mariscos_5l3");
if (!$con) {
    die("No se establecio la conexion con el servidor". mysqli_error($con));
}