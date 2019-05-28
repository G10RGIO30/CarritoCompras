<?php
include_once("Conexion.php");

class DetalleVenta {
    private $codigoVenta;
    private $codigoProducto;
    private $cantidad;
    private $descuento;
    
    //Metodo utilizado para insertar una venta a la base de datos
    function insertarDetalleVenta($cn) {
        $rpta;
        try {
            //Elaboramos la sentencia
            $sql = "INSERT INTO DetalleVenta VALUES($this->codigoVenta, $this->codigoProducto,$this->cantidad,$this->descuento)";
            //Ejecutamos la sentencia
            $result = mysql_query($sql, $cn);
            if (!$result) {
                $rpta = false;
            } else {
                $rpta = true;
            }

        } catch (exception $e) {
            $rpta = false;
        }
        return $rpta;
    }
    
    function getCodigoVenta() {
        return $this->codigoVenta;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function getCantidad() {
        return $this->cantidad;
    }
    function getDescuento() {
        return $this->descuento;
    }

    function setCodigoVenta($codigoVenta) {
        $this->codigoVenta= $codigoVenta;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

}

?>
