<?php
session_start();
session_register('itemsEnCesta');
//Estableciendo los datos al carrito
$codigo = $_REQUEST['txtCodigo'];
$nombre = $_REQUEST['txtNombre'];
$cantidad = $_REQUEST['txtCantidad'];
$pu = $_REQUEST['txtPrecio'];
$parcial = ($cantidad * $pu);
$descuento = 0;
if ($parcial > 50) {
    $descuento = ($parcial * 0.05);
}
$itemsEnCesta = $_SESSION['itemsEnCesta'];
if ($codigo) {
    if (!isset($itemsEnCesta)) {
        $itemsEnCesta[$codigo] = array("codigo" => $codigo,
            "nombre" => $nombre,
            "cantidad" => $cantidad,
            "pu" => $pu,
            "parcial" => $parcial,
            "descuento" => $descuento,
            "subtotal" => ($parcial - $descuento));
    } else {
        $itemsEnCesta[$codigo] = array("codigo" => $codigo,
            "nombre" => $nombre,
            "cantidad" => $cantidad,
            "pu" => $pu,
            "parcial" => $parcial,
            "descuento" => $descuento,
            "subtotal" => ($parcial - $descuento));
    }
}
$_SESSION['itemsEnCesta'] = $itemsEnCesta;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Programando con Café - Carrito de compras con PHP</title>
    </head>
    <body>
<?php include_once 'Include/Cabezera.php'; ?>
        <div>
            <form action="CapaNegocios/Vent_RegistrarVenta.php" method="post">
                <table border="1">
                    <tr style="background-color: chocolate">
                        <td colspan="6" >Carrito de Compras</td>
                    </tr>
                    <tr style="background-color: chocolate">
                        <td>Cliente</td>
                        <td colspan="5" ><input type="text" name="txtCliente" value="" /></td>
                    </tr>
                    <tr style="background-color: chocolate">
                        <td>Nombre</td>
                        <td>Cantidad</td>
                        <td>Precio</td>
                        <td>Parcial</td>
                        <td>Descuento</td>
                        <td>Sub.Total</td>
                    </tr>
<?php
if (isset($itemsEnCesta)) {
foreach ($itemsEnCesta as $k => $v) {
?>
                    <tr>
                        <td><?php echo ($v['nombre']); ?></td>
                        <td><?php echo number_format(($v['cantidad']), 2); ?></td>
                        <td><?php echo number_format(($v['pu']), 2); ?></td>
                        <td><?php echo number_format(($v['parcial']), 2); ?></td>
                        <td><?php echo number_format(($v['descuento']), 2); ?></td>
                        <td><?php echo number_format(($v['subtotal']), 2); ?></td>
                    </tr>
<?php
                }
}
?>
                    <tr style="background-color: chocolate">
                        <td colspan="6" ><input type="submit" value="Registrar Venta" name="btnRegistrarVenta" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
