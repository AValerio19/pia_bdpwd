<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $proceso = htmlspecialchars($_POST['proceso'] ?? '');
    $provenecia = htmlspecialchars($_POST['provenecia'] ?? '');

    switch ($provenecia){
        case 'almacen':
            $campos = [
                'Nombre' => ['nombre', 'string'], 
                'Descripcion' => ['desc', 'string'],
                'UnidadMedida' => ['unidad', 'string'],
                'CantidadStock' => ['cantidad', 'int'], 
                'PrecioVenta' => ['precio', 'int'], 
                'CostoCompra' => ['costo', 'int'], 
                'ProveedorID' => ['proveedor', 'int']];
            break;
        case 'clientes':
            $campos = [
                'Nombre' => ['nombre', 'string'], 
                'Direccion' => ['dir','string'], 
                'Telefono' => ['telefono', 'string'], 
                'Email' => ['correo', 'string'], 
                'RFC' => ['rfc', 'string']
            ];
            break;
        case 'proveedores':
            $campos = [
                'NombreEmpresa' => ['empresa', 'string'], 
                'ContactoNombre' => ['contacto', 'string'], 
                'Telefono' => ['telefono', 'string'], 
                'Direccion' => ['dir', 'string'], 
                'TipoMarisco' => ['marisco', 'string']
            ];
            break;
        case 'facturas':
            $campos = [
                'ClienteID' => ['clienteId', 'int'], 
                'FechaFactura' => ['fecha', 'string'], 
                'Total' => ['total', 'decimal'], 
                'EstadoPago' => ['estado', 'string']
            ];
            break;
        case 'detalleFactura':
            $campos = [
                'FacturaID' => '', 
                'ProductoID' => '', 
                'Cantidad' => '', 
                'PrecioUnitario' => '', 
                'Subtotal' => ''
            ];
            break;
        default: 
            break;
    }

    switch ($proceso) {
        case 'insert':
            insert($con, $campos,  $provenecia);
            break;
        case 'update':
            update($con, $campos,  $provenecia);
            break;
        case 'delete':
            delete($con);
        default:
            break;
    }
}

function delete($con) {
    $tablas_permitidas = ['clientes', 'almacen', 'proveedores', 'facturas']; 
    $campos_permitidos = ['ClienteID', 'ProductoID', 'ProveedorID', 'FacturaID']; 
    
    $provenecia = $_POST['provenencia'] ?? '';
    $campo = $_POST['campo'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if (!in_array($provenecia, $tablas_permitidas) || !in_array($campo, $campos_permitidos)) {
        header('Location: index.php?error=acceso_denegado');
        exit;
    }

    $sql = "DELETE FROM $provenecia WHERE $campo = $id";
    mysqli_query($con, $sql);

    $ruta = mysqli_real_escape_string($con, $_POST['ruta']);
    $ubicacion = 'Location: index.php?' . $ruta;
    header($ubicacion);
    exit;
}

function insert($con, $campos, $provenencia){
    $nombres_campos = [];
    $valores_sql = [];   

    foreach ($campos as $nombre_campo_bd => $info) {
        
        list($clave_post, $tipo_dato) = $info;
        $valor = $_POST[$clave_post] ?? '';

        $valor_limpio = mysqli_real_escape_string($con, $valor);
        $nombres_campos[] = $nombre_campo_bd;

        if (strtolower($tipo_dato) === 'string') {
            $valores_sql[] = "'" . $valor_limpio . "'";
        } elseif (strtolower($tipo_dato) === 'int' || strtolower($tipo_dato) === 'decimal') {
            $valores_sql[] = is_numeric($valor_limpio) ? $valor_limpio : 0;
        } else {
            $valores_sql[] = "'" . $valor_limpio . "'";
        }
    }

    $campos_str = implode(', ', $nombres_campos);
    $valores_str = implode(', ', $valores_sql);

    $sql_base = "INSERT INTO $provenencia ($campos_str) VALUES ($valores_str)";
    mysqli_query($con, $sql_base);

    $ruta = mysqli_real_escape_string($con, $_POST['ruta']);
    $ubicacion = 'Location: index.php?' . $ruta;
    header($ubicacion);
    exit;
}

function update($con, $campos, $provenencia) {

    $campo = htmlspecialchars($_POST['campo']);
    $id = intval($_POST['id']);

    // OBTENER DATOS ACTUALES
    $sql_actual = "SELECT * FROM $provenencia WHERE $campo = $id LIMIT 1";
    $res_actual = mysqli_query($con, $sql_actual);

    if (!$res_actual) {
        die("Error obteniendo registro actual: " . mysqli_error($con));
    }

    $actual = mysqli_fetch_assoc($res_actual);

    $pares_set = [];

    foreach ($campos as $nombre_campo_bd => $info) {

        list($clave_post, $tipo_dato) = $info;
        $nuevo_valor = $_POST[$clave_post] ?? '';

        $nuevo_norm = trim(preg_replace('/\s+/', ' ', $nuevo_valor));
        $actual_norm = trim(preg_replace('/\s+/', ' ', $actual[$nombre_campo_bd]));

        if ($nuevo_norm === $actual_norm) {
            continue;  
        }

        $valor_limpio = mysqli_real_escape_string($con, $nuevo_norm);

        if (in_array(strtolower($tipo_dato), ['string','date'])) {
            $valor_formateado = "'$valor_limpio'";
        } elseif (in_array(strtolower($tipo_dato), ['int','decimal'])) {
            $valor_formateado = is_numeric($valor_limpio) ? $valor_limpio : 0;
        } else {
            $valor_formateado = "'$valor_limpio'";
        }

        $pares_set[] = "$nombre_campo_bd = $valor_formateado";
    }

    if (empty($pares_set)) {
        header("Location: index.php?" . $_POST['ruta']);
        exit;
    }

    $set_str = implode(', ', $pares_set);
    $sql_update = "UPDATE $provenencia SET $set_str WHERE $campo = $id";

    $resultado = mysqli_query($con, $sql_update);

    if (!$resultado) {
        die("Error en la consulta UPDATE: " . mysqli_error($con) . "<br>SQL: " . $sql_update);
    }

    header("Location: index.php?" . $_POST['ruta']);
    exit;
}
