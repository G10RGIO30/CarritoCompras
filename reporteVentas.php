<?php
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=reporteVentas.xls');
header('Pragma: no-cache');
header('Expires: 0');
include_once 'CapaDatos/Venta.php';
$ven = new Venta();
$lista = $ven->buscarVenta();
?>
<table border="1">
    <tr >
        <td style="background-color: chocolate">Cod</td>
        <td style="background-color: chocolate">Cliente</td>
        <td style="background-color: chocolate">Producto</td>
        <td style="background-color: chocolate">Precio</td>
        <td style="background-color: chocolate">Cantidad</td>
        <td style="background-color: chocolate">Parcial</td>
        <td style="background-color: chocolate">Descuento</td>
        <td style="background-color: chocolate">Sub. Total</td>
        <td style="background-color: chocolate">Total</td>
    </tr>
    <?php
    if (count($lista) > 0) {
        for ($i = 0; $i < (count($lista)); $i++) {
    ?>
            <tr>
                <td><?php echo ($lista[$i]['CodigoVenta']); ?></td>
                <td><?php echo ($lista[$i]['Cliente']); ?></td>
                <td><?php echo ($lista[$i]['Nombre']); ?></td>
                <td><?php echo number_format(($lista[$i]['Precio']), 2); ?></td>
                <td><?php echo number_format(($lista[$i]['Cantidad']), 2); ?></td>
                <td><?php echo number_format(($lista[$i]['Parcial']), 2); ?></td>
                <td><?php echo number_format(($lista[$i]['Descuento']), 2); ?></td>
                <td><?php echo number_format(($lista[$i]['SubTotal']), 2); ?></td>
                <td><?php echo number_format(($lista[$i]['TotalPagar']), 2); ?></td>
            </tr>
    <?php
        }
    }
    ?>
</table>