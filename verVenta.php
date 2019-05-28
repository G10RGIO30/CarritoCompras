<?php
include_once 'CapaDatos/Venta.php';
$ven = new Venta();
$lista = $ven->buscarVenta();
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
                <td>Código</td>
                <td>Cliente</td>
                <td>Producto</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Parcial</td>
                <td>Descuento</td>
                <td>Sub. Total</td>
                <td>Total</td>
            </tr>
        <?php
         if(count($lista)>0){
             for($i=0;$i<(count($lista));$i++) {
        ?>
            <tr>
                <td><?php echo ($lista[$i]['CodigoVenta']);?></td>
                <td><?php echo ($lista[$i]['Cliente']);?></td>
                <td><?php echo ($lista[$i]['Nombre']);?></td>
                <td><?php echo number_format(($lista[$i]['Precio']),2);?></td>
                <td><?php echo number_format(($lista[$i]['Cantidad']),2);?></td>
                <td><?php echo number_format(($lista[$i]['Parcial']),2);?></td>
                <td><?php echo number_format(($lista[$i]['Descuento']),2);?></td>
                <td><?php echo number_format(($lista[$i]['SubTotal']),2);?></td>
                <td><?php echo number_format(($lista[$i]['TotalPagar']),2);?></td>
            </tr>
        <?php
             }
         }
        ?>
        </table>
        </div>
    </body>
</html>
