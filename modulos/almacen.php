
<link rel="stylesheet" href="style/modulos3.css">
<section>
    <div id="sidebar">
        <nav>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=almacen">Productos Actuales</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=almacen&proceso=registrar">Registrar nuevo producto</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=almacen&proceso=buscar">Actualizar algun producto</a>
        </nav>
    </div>
    <div id="content">
        <?php $proceso = $_GET['proceso'] ?? 'datos'; ?>
        <?php if ($proceso != 'datos'):?>       
        <div id="formulario">
            <?php if ($proceso == 'registrar'): ?>
                <h1>Agregar nuevo producto</h1>
                <form action="operaciones.php" method="post">
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="nombre">Producto</label>
                            <input type="text" name="nombre" id="nombre">
                        </div>
                        <div class="pregunta">
                            <label for="costo">Proveedor</label>
                            <select name="proveedor" id="proveedor">
                                <?php 
                                $sql = "SELECT a.ProductoID, a.ProveedorID, p.NombreEmpresa AS NombreProveedor
                                        FROM almacen a
                                        JOIN proveedores p ON a.ProveedorID = p.ProveedorID";
                                
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['ProveedorID']); ?>">
                                        <?php echo htmlspecialchars($row['NombreProveedor']); ?>
                                    </option>
                                <?php endwhile;?>
                            </select>
                        </div>
                        <div class="pregunta">
                            <label for="desc">Descripción</label>
                            <input type="text" name="desc" id="desc">
                        </div>
                    </div>
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" name="cantidad" id="cantidad">
                        </div>
                        <div class="pregunta">
                            <label for="unidad">Unidad de Medida</label>
                            <input type="text" name="unidad" id="unidad">
                        </div>
                        <div class="pregunta">
                            <label for="precio">Precio de Venta</label>
                            <input type="text" name="precio" id="precio">
                        </div>
                        <div class="pregunta">
                            <label for="costo">Costo de Compra</label>
                            <input type="text" name="costo" id="costo">
                        </div>
                    </div>

                    <input type="hidden" name="proceso" id="proceso" value="insert">
                    <input type="hidden" name="provenecia" id="provenencia" value="almacen">
                    <input type="hidden" name="ruta" id="ruta" value="vista=almacen&proceso=datos">

                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=almacen" class="btn btn-secondary">Cancelar</a>
                </form>
            <?php elseif ($proceso == 'buscar'): ?>
                <h1>Seleccione un cliente</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <input type="hidden" name="vista" value="almacen">
                    <input type="hidden" name="proceso" value="actualizar">

                    <div class="preguntas">
                        <div class="pregunta">
                            <select name="buscar" id="buscar">
                                <option value="">-- Selecciones Alguno --</option>
                                <?php 
                                $sql = "SELECT ProductoID, Nombre FROM almacen";
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['ProductoID']); ?>"><?php echo htmlspecialchars($row['Nombre']); ?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            <?php elseif ($proceso == 'actualizar'):?>
                <?php
                    $id = intval($_GET['buscar'] ?? null);
                    $sql = 'SELECT * FROM almacen WHERE ProductoID =' . $id;
                    $consulta = mysqli_query($con, $sql);
                ?>
                <?php if ($row = mysqli_fetch_array($consulta)): ?>
                    <h1>Actualizar producto</h1>
                    <form action="operaciones.php" method="post">
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="nombre">Producto</label>
                                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($row['Nombre']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="proveedor">Proveedor</label>
                                <select name="proveedor" id="proveedor">
                                    <?php 
                                    $id_original = intval($row['ProveedorID']);
                                    $sql = "SELECT ProveedorID, NombreEmpresa FROM proveedores";
                                    
                                    $consulta = mysqli_query($con, $sql);
                                    ?>
                                    <?php while ($row_opcion = mysqli_fetch_array($consulta)): ?>
                                        <option 
                                            value="<?php echo htmlspecialchars($row_opcion['ProveedorID']); ?>" <?php echo ($row_opcion['ProveedorID'] == $id_original) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($row_opcion['NombreEmpresa']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="pregunta">
                                <label for="desc">Descripción</label>
                                <input type="text" name="desc" id="desc" value="<?php echo htmlspecialchars($row['Descripcion']); ?>">
                            </div>
                            
                        </div>
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($row['CantidadStock']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="unidad">Unidad de Medida</label>
                                <input type="text" name="unidad" id="unidad" value="<?php echo htmlspecialchars($row['UnidadMedida']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="precio">Precio de Venta</label>
                                <input type="number" name="precio" id="precio" value="<?php echo htmlspecialchars($row['PrecioVenta']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="costo">Costo de Compra</label>
                                <input type="number" name="costo" id="costo" value="<?php echo htmlspecialchars($row['CostoCompra']); ?>">
                            </div>
                            
                        </div>
                        
                        <input type="hidden" name="proceso" id="proceso" value="update">
                        <input type="hidden" name="provenecia" id="provenencia" value="almacen">
                        <input type="hidden" name="ruta" id="ruta" value="vista=almacen&proceso=datos">
                        
                        <input type="hidden" name="id" id="id" value="<?php echo intval($row['ProductoID']); ?>">
                        <input type="hidden" name="campo" id="campo" value="ProductoID">

                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=almacen" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif;?>
        <div id="resultados">
            <h1>Productos Actuales</h1>
            <?php
            $sql = "SELECT a.*, p.NombreEmpresa AS NombreProveedor
                    FROM almacen a
                    JOIN proveedores p ON a.ProveedorID = p.ProveedorID";
            $consulta = mysqli_query($con, $sql);
            ?>
            <?php if (mysqli_num_rows($consulta) > 0):?>
                <?php while ($row = mysqli_fetch_array($consulta)): ?>
                    <details>
                        <summary>
                            <span><?php echo htmlspecialchars($row['Nombre']); ?></span>
                            <form action="operaciones.php" method="post">
                                <input type="hidden" name="campo" id="campo" value="ProductoID">
                                <input type="hidden" name="proceso" id="proceso" value="delete">
                                <input type="hidden" name="provenencia" id="provenencia" value="almacen">
                                <input type="hidden" name="ruta" id="ruta" value="vista=almacen&proceso=datos">
                                <input type="hidden" name="id" id="id" value="<?php echo intval($row['ProductoID'])?>">

                                <button>Eliminar</button>
                            </form>
                        </summary>
                        <p><b>Producto:</b> <?php echo htmlspecialchars($row['Nombre'])?></p>
                        <p><b>Descripción:</b> <?php echo htmlspecialchars($row['Descripcion'])?></p>
                        <p><b>Unidad de Medida:</b> <?php echo htmlspecialchars($row['UnidadMedida'])?></p>
                        <p><b>Cantidad de Stock:</b> <?php echo htmlspecialchars($row['CantidadStock'])?></p>
                        <p><b>Precio de Venta:</b> <?php echo htmlspecialchars($row['PrecioVenta'])?></p>
                        <p><b>Costo de Compra:</b> <?php echo htmlspecialchars($row['CostoCompra'])?></p>
                        <p><b>Proveedor:</b> <?php echo htmlspecialchars($row['NombreProveedor'])?></p>
                    </details>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No se encontraron registros</h1>
            <?php endif; ?>
        </div>
    </div>
</section>