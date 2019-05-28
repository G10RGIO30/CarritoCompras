<?php
include_once("Conexion.php");
include_once("DetalleVenta.php");

class Venta {
    private $codigoVenta;
    private $cliente;
    private $fecha;
    private $detalleVenta;
    //Metodo utilizado para obtener el codigo siguiente del producto
    function codigoSiguiente($cn) {
        $cod = 0;
        $sql = "SELECT IFNULL(MAX(codigoVenta),0)+1 as codigo FROM Venta";
        try {
            $result = mysql_query($sql, $cn);
            $registros = array();
            while ($reg = mysql_fetch_array($result)) {
                $cod = $reg['codigo'];
                break;
            }
        } catch (exception $e) {

        }
        return $cod;
    }
    //Metodo utilizado para insertar una venta a la base de datos
    function insertarVenta() {
        $rpta;
        try {
            //Creamos un objeto de la clase conexion
            $miconexion = new Conexion();
            //Obtenemos la conexion
            $cn = $miconexion->conectar();
            //Comenzamos la transaccion
            mysql_query("BEGIN", $cn);
            //Obtenemos el codigo del siguiente producto
            $this->codigoVenta=$this->codigoSiguiente($cn);
            //Elaboramos la sentencia
            $sql = "INSERT INTO Venta VALUES($this->codigoVenta,'$this->cliente',CURDATE())";
            //Ejecutamos la sentencia
            $result = mysql_query($sql, $cn);
            if (!$result) {
                //Si no obtiene resultados anulamos la transaccion
                mysql_query("ROLLBACK", $cn);
                $rpta = false;
            } else {
                foreach($this->detalleVenta as $k => $v){
                    $detalle=new DetalleVenta();
                    $detalle->setCodigoVenta($this->codigoVenta);
                    $detalle->setCodigoProducto($v['codigo']);
                    $detalle->setCantidad($v['cantidad']);
                    $detalle->setDescuento($v['descuento']);
                    $rpta=$detalle->insertarDetalleVenta($cn);
                    if(!$rpta){
                        break;
                    }
                }
                if($rpta){
                    mysql_query("COMMIT", $cn);
                }else{
                    mysql_query("ROLLBACK", $cn);
                }
            }
            //Cerramos la conexion
            mysql_close($cn);
        } catch (exception $e) {
            try {
                mysql_query("ROLLBACK", $cn);
            } catch (exception $e1) {

            }
            try {
                mysql_close($cn);
            } catch (exception $e1) {

            }
            $rpta = false;
        }
        return $rpta;
    }

     //Metodo utilizado para obtener un producto
    function buscarVenta() {
        //Le deciamos que la locacion es lenguaje español
        setlocale(LC_CTYPE, 'es');
        //La sentencia a ejecutar
        $sql = "
SELECT
	v.codigoVenta AS CodigoVenta,
	v.cliente AS Cliente,
	v.fecha AS Fecha,
	d.codigoProducto AS CodigoProducto,
	p.nombre AS Nombre,
	p.precio AS Precio,
	d.cantidad AS Cantidad,
	d.descuento AS Descuento, 
	p.precio*d.cantidad AS Parcial,
	((p.precio*d.cantidad)-d.descuento) AS SubTotal,
	(
	SELECT
		SUM((dT.cantidad * pT.precio)-dT.descuento) AS TotalPagar
	FROM
		DetalleVenta AS dT INNER JOIN
		Producto AS pT ON dT.codigoProducto = pT.codigoProducto
	WHERE
		dT.codigoVenta=v.codigoVenta
	) AS TotalPagar
FROM
	Venta AS v INNER JOIN
	DetalleVenta AS d ON v.codigoVenta = d.codigoVenta INNER JOIN
	Producto AS p ON d.codigoProducto = p.codigoProducto
ORDER BY
	CodigoVenta, Nombre";
        try {
            //Creamos un objeto de la clase conexion
            $miconexion = new Conexion();
            //Obtenemos la conexion
            $cn = $miconexion->conectar();
            //Ejecutamos la sentencia
            $rs = mysql_query($sql, $cn);
            //Creamos un array que almacenara los datos de la sentencia
            $registros = array();
            //Recorremos el resultado de la consulta y lo almacenamos en el array
            while ($reg = mysql_fetch_array($rs)) {
                array_push($registros, $reg);
            }
            //Liberamos recursos
            mysql_free_result($rs);
            mysql_close($cn);
        } catch (exception $e) {
            try {
                mysql_free_result($rs);
            } catch (exception $e) {

            }
            try {
                mysql_close($cn);
            } catch (exception $e) {

            }
        }
        return $registros;
    }

    function getCodigoVenta() {
        return $this->codigoVenta;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getDetalleVenta() {
        return $this->detalleVenta;
    }

    function setCodigoVenta($codigoVenta) {
        $this->codigoProducto = $codigoVenta;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setDetalleVenta($detalleVenta) {
        $this->detalleVenta = $detalleVenta;
    }
}

?>
