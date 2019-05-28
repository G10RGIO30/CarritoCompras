<?php
include_once 'CapaDatos/Producto.php';
$pro = new Producto();
$lista = $pro->buscarProductoTodos();
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
        <table border="1">
            <tr style="background-color: chocolate">
                <td colspan="4" >Listado Producto</td>
            </tr>
            <tr style="background-color: chocolate">
                <td>Código</td>
                <td>Nombre</td>
                <td>Precio</td>
                <td>Proceso</td>
            </tr>
        <?php
         if(count($lista)>0){
             for($i=0;$i<(count($lista));$i++) {
                $dirModifica="modificarProducto.php?codigoProducto=".$lista[$i]['codigoProducto'];
                $dirAnadir="anadirCarrito.php?codigoProducto=".$lista[$i]['codigoProducto'];
        ?>
            <tr>
                <td><?php echo ($lista[$i]['codigoProducto']);?></td>
                <td><?php echo ($lista[$i]['nombre']);?></td>
                <td><?php echo ($lista[$i]['precio']);?></td>
                <td><a href="<?php echo $dirModifica;?>">Modificar</a> |
                    <a href="<?php echo $dirAnadir;?>">Añadir</a>
                </td>
            </tr>
        <?php
             }
         }
        ?>
        </table>
        </div>
    </body>
</html>
