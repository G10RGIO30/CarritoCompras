<?php
include_once 'CapaDatos/Producto.php';
$pro = new Producto();
$pro->setCodigoProducto($_REQUEST['codigoProducto']);
$lista = $pro->buscarProducto();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Programando con Café - Carrito de compras con PHP</title>
    </head>
    <body>
        <?php include_once 'Include/Cabezera.php'; ?>
        <form method="post" action="CapaNegocios/Prod_ModificarProducto.php">
            <div>
                <table border="1">
                        <tr>
                            <td>Codigo</td>
                            <td><input type="text" name="txtCodigo" value="<?php echo ($lista[0]['codigoProducto']);?>" readonly /></td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td><input type="text" name="txtNombre" value="<?php echo($lista[0]['nombre']);?>" /></td>
                        </tr>
                        <tr>
                            <td>Precio</td>
                            <td><input type="text" name="txtPrecio" value="<?php echo($lista[0]['precio']);?>" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Actualizar" name="btnActualizar" /></td>
                        </tr>
                </table>
                </div>
        </form>

    </body>
</html>
