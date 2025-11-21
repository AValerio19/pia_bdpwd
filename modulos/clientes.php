
<link rel="stylesheet" href="style/modulos3.css">
<section>
    <div id="sidebar">
        <nav>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=clientes">Clientes Actuales</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=clientes&proceso=registrar">Registrar nuevo cliente</a>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=clientes&proceso=buscar">Actualizar algun cliente</a>
        </nav>
    </div>
    <div id="content">
        <?php $proceso = $_GET['proceso'] ?? 'datos'; ?>
        <?php if ($proceso != 'datos'):?>       
        <div id="formulario">
            <?php if ($proceso == 'registrar'): ?>
                <h1>Agregar nuevo cliente</h1>
                <form action="operaciones.php" method="post">
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" name="nombre" id="nombre">
                        </div>
                        <div class="pregunta">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" id="telefono">
                        </div>
                        <div class="pregunta">
                            <label for="rfc">RFC</label>
                            <input type="text" name="rfc" id="rfc">
                        </div>
                        <div class="pregunta">
                            <label for="correo">Correo</label>
                            <input type="text" name="correo" id="correo">
                        </div>
                    </div>
                    <div class="preguntas">
                        <div class="pregunta">
                            <label for="dir">Direccion</label>
                            <input type="text" name="dir" id="dir">
                        </div>
                    </div>

                    <input type="hidden" name="proceso" id="proceso" value="insert">
                    <input type="hidden" name="provenecia" id="provenencia" value="clientes">
                    <input type="hidden" name="ruta" id="ruta" value="vista=clientes&proceso=datos">

                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=clientes" class="btn btn-secondary">Cancelar</a>
                </form>
            <?php elseif ($proceso == 'buscar'): ?>
                <h1>Seleccione un cliente</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <input type="hidden" name="vista" value="clientes">
                    <input type="hidden" name="proceso" value="actualizar">

                    <div class="preguntas">
                        <div class="pregunta">
                            <select name="buscar" id="buscar">
                                <option value="">-- Selecciones Alguno --</option>
                                <?php 
                                $sql = "SELECT ClienteID, Nombre FROM clientes";
                                $consulta = mysqli_query($con, $sql);
                                ?>
                                <?php while ($row = mysqli_fetch_array($consulta)):?>
                                    <option value="<?php echo htmlspecialchars($row['ClienteID']); ?>"><?php echo htmlspecialchars($row['Nombre']); ?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            <?php elseif ($proceso == 'actualizar'):?>
                <?php
                    $id = intval($_GET['buscar'] ?? null);
                    $sql = 'SELECT * FROM clientes WHERE ClienteID =' . $id;
                    $consulta = mysqli_query($con, $sql);
                ?>
                <?php if ($row = mysqli_fetch_array($consulta)): ?>
                    <h1>Actualizar cliente</h1>
                    <form action="operaciones.php" method="post">
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="nombre">Nombre Completo</label>
                                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($row['Nombre']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="telefono">Telefono</label>
                                <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($row['Telefono']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="rfc">RFC</label>
                                <input type="text" name="rfc" id="rfc" value="<?php echo htmlspecialchars($row['RFC']); ?>">
                            </div>
                            <div class="pregunta">
                                <label for="correo">Correo</label>
                                <input type="text" name="correo" id="correo" value="<?php echo htmlspecialchars($row['Email']); ?>">
                            </div>
                        </div>
                        <div class="preguntas">
                            <div class="pregunta">
                                <label for="dir">Direccion</label>
                                <input type="text" name="dir" id="dir" value="<?php echo htmlspecialchars($row['Direccion']); ?>">
                            </div>
                        </div>
                        
                        <input type="hidden" name="proceso" id="proceso" value="update">
                        <input type="hidden" name="provenecia" id="provenencia" value="clientes">
                        <input type="hidden" name="ruta" id="ruta" value="vista=clientes&proceso=datos">
                        
                        <input type="hidden" name="id" id="id" value="<?php echo intval($row['ClienteID']); ?>">
                        <input type="hidden" name="campo" id="campo" value="ClienteID">

                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?vista=clientes" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif;?>
        <div id="resultados">
            <h1>Clientes Actuales</h1>
            <?php
            $sql = "SELECT * FROM clientes";
            $consulta = mysqli_query($con, $sql);
            ?>
            <?php if (mysqli_num_rows($consulta) > 0):?>
                <?php while ($row = mysqli_fetch_array($consulta)): ?>
                    <details>
                        <summary>
                            <span><?php echo htmlspecialchars($row['Nombre']); ?></span>
                            <form action="operaciones.php" method="post">
                                <input type="hidden" name="campo" id="campo" value="ClienteID">
                                <input type="hidden" name="proceso" id="proceso" value="delete">
                                <input type="hidden" name="provenencia" id="provenencia" value="clientes">
                                <input type="hidden" name="ruta" id="ruta" value="vista=clientes&proceso=datos">
                                <input type="hidden" name="id" id="id" value="<?php echo intval($row['ClienteID'])?>">

                                <button>Eliminar</button>
                            </form>
                        </summary>
                        <p><b>Correo:</b> <?php echo htmlspecialchars($row['Email'])?></p>
                        <p><b>Direccion:</b> <?php echo htmlspecialchars($row['Direccion'])?></p>
                        <p><b>Telefono:</b> <?php echo htmlspecialchars($row['Telefono'])?></p>
                        <p><b>RFC:</b> <?php echo htmlspecialchars($row['RFC'])?></p>
                    </details>
                <?php endwhile; ?>
            <?php else: ?>
                <h1>No se encontraron registros</h1>
            <?php endif; ?>
        </div>
    </div>
</section>