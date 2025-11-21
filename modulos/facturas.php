
<link rel="stylesheet" href="style/modulos3.css">
<link rel="stylesheet" href="style/modal2.css">
<section>
    <div id="sidebar">
        <nav>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=facturas">Facturas Actuales</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=facturas&proceso=registrar">Registrar nueva factura</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=facturas&proceso=buscar">Actualizar alguna factura</a>
        </nav>
    </div>
    <div id="content">
        <?php $proceso = $_GET['proceso'] ?? 'datos'; ?>   
        <?php if ($proceso != 'datos'):?>           
        <div id="formulario">
            <?php if ($proceso == 'registrar'): ?>
                <h1>Agregar nueva factura</h1>
                <form action="operaciones.php" method="post">
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="clienteId">Cliente</label>
                            <select name="clienteId" id="clienteId">
                                <option value="">-- Selecciones Alguno --</option>
                                <?php 
                                $sql = "SELECT f.ClienteID, c.Nombre AS NombreCliente 
                                        FROM facturas f
                                        JOIN clientes c ON f.ClienteID = c.ClienteID";
                                
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['ClienteID']); ?>">
                                        <?php echo htmlspecialchars($row['NombreCliente']); ?>
                                    </option>
                                <?php endwhile;?>
                            </select>
                        </div>
                        <div class="pregunta">
                            <label for="fecha">Fecha de la Facturación</label>
                            <input type="date" name="fecha" id="fecha">
                        </div>
                    </div>
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="total">Total</label>
                            <input type="number" name="total" id="total">
                        </div>
                        <div class="pregunta">
                            <label for="estado">Estado de Pago</label>
                            <select name="estado" id="estado">
                                <option value="Pagada">Pagada</option>
                                <option value="Pendiente">Pendiente</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="proceso" id="proceso" value="insert">
                    <input type="hidden" name="provenecia" id="provenencia" value="facturas">
                    <input type="hidden" name="ruta" id="ruta" value="vista=facturas&proceso=datos">

                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=facturas" class="btn btn-secondary">Cancelar</a>
                </form>
            <?php elseif ($proceso == 'buscar'): ?>
                <h1>Seleccione una factura</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <input type="hidden" name="vista" value="facturas">
                    <input type="hidden" name="proceso" value="actualizar">

                    <div class="preguntas">
                        <div class="pregunta">
                            <select name="buscar" id="buscar">
                                <option value="">-- Selecciones Alguno --</option>
                                <?php 
                                $sql = "SELECT f.FacturaID, f.ClienteID, c.Nombre AS NombreCliente 
                                        FROM facturas f
                                        JOIN clientes c ON f.ClienteID = c.ClienteID";
                                
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['FacturaID']); ?>">
                                        <?php echo htmlspecialchars($row['NombreCliente']) . " (Factura: " . htmlspecialchars($row['FacturaID']) . ")"; ?>
                                    </option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            <?php elseif ($proceso == 'actualizar'):?>
                <?php
                    $id = intval($_GET['buscar'] ?? null);
                    $sql = 'SELECT * FROM facturas WHERE ClienteID =' . $id;
                    $consulta = mysqli_query($con, $sql);
                ?>
                <?php if ($row = mysqli_fetch_array($consulta)): ?>
                    <h1>Actualizar Factura</h1>
                    <form action="operaciones.php" method="post">
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="clienteId">Cliente</label>
                                <select name="clienteId" id="clienteId">
                                    <?php 
                                    $id_original = intval($row['ClienteID']);
                                    $sql = "SELECT f.ClienteID, c.Nombre AS NombreCliente 
                                            FROM facturas f
                                            JOIN clientes c ON f.ClienteID = c.ClienteID";
                                    
                                    $consulta = mysqli_query($con, $sql);
                                    ?>
                                    <?php while ($row_opcion = mysqli_fetch_array($consulta)):?>
                                        <option value="<?php echo htmlspecialchars($row_opcion['ClienteID']); ?>" <?php echo ($row_opcion['ClienteID'] == $id_original) ? 'selected' : '';?>>
                                            <?php echo htmlspecialchars($row_opcion['NombreCliente']); ?>
                                        </option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                            <div class="pregunta">
                                <label for="fecha">Fecha de la Facturación</label>
                                <input type="date" name="fecha" id="fecha" value="<?php echo htmlspecialchars($row['FechaFactura'])?>">
                            </div>
                        </div>
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="total">Total</label>
                                <input type="number" name="total" id="total" value="<?php echo htmlspecialchars($row['Total'])?>">
                            </div>
                            <div class="pregunta">
                                <label for="estado">Estado de Pago</label>
                                <select name="estado" id="estado">
                                    <option value="<?php echo htmlspecialchars($row['EstadoPago'])?>"><?php echo htmlspecialchars($row['EstadoPago'])?></option>
                                    <option value="Pagada">Pagada</option>
                                    <option value="Pendiente">Pendiente</option>
                                </select>
                            </div>
                        </div>
                        
                        <input type="hidden" name="proceso" id="proceso" value="update">
                        <input type="hidden" name="provenecia" id="provenencia" value="facturas">
                        <input type="hidden" name="ruta" id="ruta" value="vista=facturas&proceso=datos">

                        <input type="hidden" name="campo" id="campo" value="FacturaID">
                        <input type="hidden" name="id" id="id" value="<?php echo intval($row['FacturaID']); ?>">

                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=facturas" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div id="resultados">
            <h1>Facturas Actuales</h1>
            <?php
            $sql = "SELECT f.*, c.Nombre AS NombreCliente 
                        FROM facturas f
                        JOIN clientes c ON f.ClienteID = c.ClienteID";
            $consulta = mysqli_query($con, $sql);
            ?>
            <?php if (mysqli_num_rows($consulta) > 0):?>
                <?php while ($row = mysqli_fetch_array($consulta)): ?>
                    <details>
                        <summary>
                            <span>
                                #<?php echo htmlspecialchars($row['FacturaID']); ?> 
                                (Factura de: <?php echo htmlspecialchars($row['NombreCliente']); ?>)
                            </span>
                            <?php 
                            $sqlDetalles = "SELECT
                                                df.FacturaID,
                                                df.ProductoID,
                                                a.Nombre AS producto,
                                                df.Cantidad,
                                                df.PrecioUnitario,
                                                df.Subtotal
                                            FROM detallefactura df
                                            JOIN almacen a ON df.ProductoID = a.ProductoID;";
                            $consultaDetalles = mysqli_query($con, $sqlDetalles);

                            $detallesAgrupados = [];

                            while ($d = mysqli_fetch_assoc($consultaDetalles)) {
                                $detallesAgrupados[$d['FacturaID']][] = $d;
                            }
                            ?>
                            <button type="button" onclick='abrirModal(<?php echo json_encode($detallesAgrupados[$row["FacturaID"]] ?? []); ?>)'>
                                Detalles
                            </button>
                            <form action="operaciones.php" method="post">
                                <input type="hidden" name="campo" id="campo" value="FacturaID">
                                <input type="hidden" name="proceso" id="proceso" value="delete">
                                <input type="hidden" name="provenencia" id="provenencia" value="facturas">
                                <input type="hidden" name="ruta" id="ruta" value="vista=facturas&proceso=datos">
                                <input type="hidden" name="id" id="id" value="<?php echo intval($row['FacturaID'])?>">

                                <button>Eliminar</button>
                            </form>
                        </summary>
                        <p><b>Fecha de Facturacion:</b> <?php echo htmlspecialchars($row['FechaFactura'])?></p>
                        <p><b>Total:</b> <?php echo htmlspecialchars($row['Total'])?></p>
                        <p><b>Estado de Pago:</b> <?php echo htmlspecialchars($row['EstadoPago'])?></p>
                    </details>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No se encontraron registros</h1>
            <?php endif; ?>
        </div>
    </div>
</section>
<div id="modal" class="modal">
    <div id="fondo">
        <div class="modal-content">
            <span id="cerrarModal" class="cerrar">&times;</span>

            <h2>Detalles de la Factura</h2>
            <div id="modalBody"></div>
        </div>
    </div>
</div>
<script>
function abrirModal(detalles) {
    let html = `
        <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse: collapse;">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
    `;

    if (detalles.length === 0) {
        html += `<tr><td colspan="6">No hay detalles para esta factura</td></tr>`;
    } else {
        detalles.forEach(d => {
            html += `
                <tr>
                    <td>${d.producto}</td>
                    <td>${d.Cantidad}</td>
                    <td>${d.PrecioUnitario}</td>
                    <td>${d.Subtotal}</td>
                </tr>
            `;
        });
    }

    html += `</table>`;

    document.getElementById("modalBody").innerHTML = html;
    document.getElementById("modal").style.display = "flex";
}

document.getElementById("cerrarModal").onclick = function() {
    document.getElementById("modal").style.display = "none";
};

window.onclick = function(e) {
    if (e.target == document.getElementById("modal")) {
        document.getElementById("modal").style.display = "none";
    }
};
</script>
