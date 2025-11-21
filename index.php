<?php include 'conexion.php'; include 'operaciones.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mariskas</title>
    <link rel="stylesheet" href="style/index8.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h1>Mariskas</h1>
            <input type="checkbox" id="menu-toggle" class="menu-toggle">
            <label for="menu-toggle" class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
        <nav class="navbar">
            <a href="index.php?vista=inicio" class="nav-link">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span>Inicio</span>
            </a>
            <a href="index.php?vista=almacen" class="nav-link">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                </svg>
                <span>Productos</span>
            </a>
            <a href="index.php?vista=clientes&proceso=datos" class="nav-link">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <span>Clientes</span>
            </a>
            <a href="index.php?vista=proveedores" class="nav-link">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 18.5a1.5 1.5 0 01-1.5-1.5 1.5 1.5 0 011.5-1.5 1.5 1.5 0 011.5 1.5 1.5 1.5 0 01-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9a1.5 1.5 0 01-1.5-1.5 1.5 1.5 0 011.5-1.5 1.5 1.5 0 011.5 1.5 1.5 1.5 0 01-1.5 1.5M5 9.5h3.5V12H3.04L5 9.5M20 4H4c-1.1 0-2 .9-2 2v11h2a3 3 0 013 3 3 3 0 013-3h6a3 3 0 013 3 3 3 0 013-3h2V6c0-1.1-.9-2-2-2z"/>
                </svg>
                <span>Proveedores</span>
            </a>
            <a href="index.php?vista=facturas" class="nav-link">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                    <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2zm0-4H8V8h8v2z"/>
                </svg>
                <span>Facturas</span>
            </a>
        </nav>
    </header>
    <main>
        <article>
            <?php
                $permitidas = ['inicio', 'almacen', 'clientes', 'proveedores', 'facturas'];
                $ruta = $_GET['vista'] ?? 'inicio';
                
                if (in_array($ruta, $permitidas)) {
                    include "modulos/$ruta" . ".php";
                } else {
                    include "modulos/inicio.php";
                }
                
            ?>
        </article>
    </main>
    <footer>
        © 2025 Mariskas — Sabor que Rompe Olas. Playa garantizada en cada bocado.
    </footer>

</body>
</html>