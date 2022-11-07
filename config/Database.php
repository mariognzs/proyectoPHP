<?php
    class Database{
        public static function conectar(){
            // mysql('localhost',usuario,password, base_de_datos);
            $conexion = new mysqli("localhost", "root", "", "proyectophp");
            $conexion->query("SET NAMES 'utf8'");

            return $conexion;
        }
    }
?>