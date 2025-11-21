<link rel="stylesheet" href="style/modulos2.css">
<section>
    <div id="sidebar">
        <nav>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=proveedores">Proveedores Actuales</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=proveedores&proceso=registrar">Registrar nuevo proveedor</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=proveedores&proceso=buscar">Actualizar alguna proveedor</a>
        </nav>
    </div>
    <div id="content">
        <?php $proceso = $_GET['proceso'] ?? 'datos'; ?>   
        <?php if ($proceso != 'datos'):?>           
        <div id="formulario">
            <?php if ($proceso == 'registrar'): ?>
                <h1>Agregar nuevo proveedor</h1>
                <form action="operaciones.php" method="post">
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="empresa">Nombre de la Empresa</label>
                            <input type="text" name="empresa" id="empresa">
                        </div>
                        <div class="pregunta">
                            <label for="contacto">Nombre del Contacto</label>
                            <input type="text" name="contacto" id="contacto">
                        </div>
                    </div>
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="telefono">Telefono</label>
                            <input type="tel" name="telefono" id="telefono">
                        </div>
                        <div class="pregunta">
                            <label for="dir">Dirección</label>
                            <input type="text" name="dir" id="dir">
                        </div>
                        <div class="pregunta">
                            <label for="marisco">Tipo de Marisco</label>
                            <input type="text" name="marisco" id="marisco">
                        </div>
                    </div>

                    <input type="hidden" name="proceso" id="proceso" value="insert">
                    <input type="hidden" name="provenecia" id="provenencia" value="proveedores">
                    <input type="hidden" name="ruta" id="ruta" value="vista=proveedores&proceso=datos">

                    <button type="submit">Registrar</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=proveedores">Cancelar</a>
                </form>
            <?php elseif ($proceso == 'buscar'): ?>
                <h1>Seleccione un proveedor</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <input type="hidden" name="vista" value="proveedores">
                    <input type="hidden" name="proceso" value="actualizar">

                    <div class="preguntas">
                        <div class="pregunta">
                            <select name="buscar" id="buscar">
                                <option value="">-- Selecciones Alguno --</option>
                                <?php 
                                $sql = "SELECT ProveedorID, NombreEmpresa, ContactoNombre FROM proveedores";
                                
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['ProveedorID']); ?>">
                                        <?php echo htmlspecialchars($row['NombreEmpresa']) . " (Contacto: " . htmlspecialchars($row['ContactoNombre']) . ")"; ?>
                                    </option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>

                    <button type="submit">Buscar</button>
                </form>
            <?php elseif ($proceso == 'actualizar'):?>
                <?php
                    $id = intval($_GET['buscar'] ?? null);
                    $sql = 'SELECT * FROM proveedores WHERE ProveedorID =' . $id;
                    $consulta = mysqli_query($con, $sql);
                ?>
                <?php if ($row = mysqli_fetch_array($consulta)): ?>
                    <h1>Actualizar Provedor</h1>
                    <form action="operaciones.php" method="post">
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="empresa">Nombre de la Empresa</label>
                                <input type="text" name="empresa" id="empresa" value="<?php echo htmlspecialchars($row['NombreEmpresa']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="contacto">Nombre del Contacto</label>
                                <input type="text" name="contacto" id="contacto" value="<?php echo htmlspecialchars($row['ContactoNombre']); ?>">
                            </div>
                        </div>
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="telefono">Telefono</label>
                                <input type="tel" name="telefono" id="telefono" value="<?php echo htmlspecialchars($row['Telefono']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="dir">Dirección</label>
                                <input type="text" name="dir" id="dir" value="<?php echo htmlspecialchars($row['Direccion']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="marisco">Tipo de Marisco</label>
                                <input type="text" name="marisco" id="marisco" value="<?php echo htmlspecialchars($row['TipoMarisco']); ?>">
                            </div>
                        </div>
                        
                        <input type="hidden" name="proceso" id="proceso" value="update">
                        <input type="hidden" name="provenecia" id="provenencia" value="proveedores">
                        <input type="hidden" name="ruta" id="ruta" value="vista=proveedores&proceso=datos">

                        <input type="hidden" name="campo" id="campo" value="ProveedorID">
                        <input type="hidden" name="id" id="id" value="<?php echo intval($row['ProveedorID']); ?>">

                        <button type="submit">Registrar</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=proveedores">Cancelar</a>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div id="resultados">
            <h1>Proveedores Actuales</h1>
            <?php
            $sql = "SELECT * FROM proveedores";
            $consulta = mysqli_query($con, $sql);
            ?>
            <?php if (mysqli_num_rows($consulta) > 0):?>
                <?php while ($row = mysqli_fetch_array($consulta)): ?>
                    <details>
                        <summary>
                            <span><?php echo htmlspecialchars($row['NombreEmpresa']); ?></span>
                            <form action="operaciones.php" method="post">
                                <input type="hidden" name="campo" id="campo" value="ProveedorID">
                                <input type="hidden" name="proceso" id="proceso" value="delete">
                                <input type="hidden" name="provenencia" id="provenencia" value="proveedores">
                                <input type="hidden" name="ruta" id="ruta" value="vista=proveedores&proceso=datos">
                                <input type="hidden" name="id" id="id" value="<?php echo intval($row['ProveedorID'])?>">

                                <button>Eliminar</button>
                            </form>
                        </summary>
                        <p><b>Nombre del Contacto:</b> <?php echo htmlspecialchars($row['ContactoNombre'])?></p>
                        <p><b>Telefono:</b> <?php echo htmlspecialchars($row['Telefono'])?></p>
                        <p><b>Direccion:</b> <?php echo htmlspecialchars($row['Direccion'])?></p>
                        <p><b>Tipo de Marisco:</b> <?php echo htmlspecialchars($row['TipoMarisco'])?></p>
                    </details>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No se encontraron registros</h1>
            <?php endif; ?>
        </div>
    </div>
</section>