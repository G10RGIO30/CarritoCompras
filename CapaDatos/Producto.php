<?php
include_once("Conexion.php");
class Producto {

    private $codigoProducto;
    private $nombre;
    private $precio;
    //Metodo utilizado para obtener el codigo siguiente del producto
    function codigoSiguiente($cn) {
        $cod = 0;
        $sql = "SELECT IFNULL(MAX(codigoProducto),0)+1 as codigo FROM Producto";
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
    //Metodo utilizado para insertar un producto a la base de datos
    function insertarProducto() {
        $rpta;
        try {
            //Creamos un objeto de la clase conexion
            $miconexion = new Conexion();
            //Obtenemos la conexion
            $cn = $miconexion->conectar();
            //Comenzamos la transaccion
            mysql_query("BEGIN", $cn);
            //Obtenemos el codigo del siguiente producto
            $this->codigoProducto =$this->codigoSiguiente($cn);
            //Elaboramos la sentencia
            $sql = "INSERT INTO Producto VALUES($this->codigoProducto,'$this->nombre',$this->precio)";
            //Ejecutamos la sentencia
            $result = mysql_query($sql, $cn);
            if (!$result) {
                //Si no obtiene resultados anulamos la transaccion
                mysql_query("ROLLBACK", $cn);
                $rpta = false;
            } else {
                //Si obtiene resultados confirmamos la transaccion
                mysql_query("COMMIT", $cn);
                $rpta = true;
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

    //Metodo utilizado para actualizar un producto
    function actualizarProducto() {
        $rpta;
        try {
            //Creamos un objeto de la clase conexion
            $miconexion = new Conexion();
            //Obtenemos la conexion
            $cn = $miconexion->conectar();
            //Comenzamos la transaccion
            mysql_query("BEGIN", $cn);
            //Elaboramos la sentencia
            $sql = "UPDATE Producto SET nombre='$this->nombre', precio=$this->precio WHERE codigoProducto=$this->codigoProducto";
            //Ejecutamos la sentencia
            $result = mysql_query($sql, $cn);
            $rpta;
            if (!$result) {
                //Si no obtiene resultados anulamos la transaccion
                mysql_query("ROLLBACK", $cn);
                $rpta = false;
            } else {
                //Si obtiene resultados confirmamos la transaccion
                mysql_query("COMMIT", $cn);
                $rpta = true;
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
    function buscarProducto() {
        //Le deciamos que la locacion es lenguaje español
        setlocale(LC_CTYPE, 'es');
        //La sentencia a ejecutar
        $sql = "SELECT * FROM Producto WHERE codigoProducto=$this->codigoProducto";
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

    //Metodo utilizado para obtener todos los productos
    function buscarProductoTodos() {
        //Le deciamos que la locacion es lenguaje español
        setlocale(LC_CTYPE, 'es');
        //La sentencia a ejecutar
        $sql = "SELECT * FROM Producto ORDER BY nombre";
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
    //Get y Set de la clase
    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

}

?>
