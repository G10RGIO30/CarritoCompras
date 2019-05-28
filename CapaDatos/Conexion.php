<?php

class Conexion {

    var $BaseDatos;
    var $Servidor;
    var $Usuario;
    var $Clave;
    /* identificador de conexiï¿½n y consulta */
    var $Conexion_ID;
    var $Consulta_ID;

    /* nï¿½mero de error y texto error */
    var $Errno = 0;
    var $Error = "";

    function  Conexion() {
        $this->BaseDatos = "bdtutorial";
        $this->Servidor = "localhost";
        $this->Usuario = "root";
        $this->Clave = "";
    }

    function conectar() {
        $this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);
        if (!$this->Conexion_ID) {
            $this->Error = "Ha fallado la conexion.";
            return 0;
        }

        if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
            $this->Error = "Imposible abrir " . $this->BaseDatos;
            return 0;
        }
        return $this->Conexion_ID;
    }

}

?>
