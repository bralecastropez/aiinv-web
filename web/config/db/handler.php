<?php 
    require_once("db_conf.php");
    
    function ObtenerGrupo ($IdGrupo) {
        $query_grupo = mysql_query("select * from grupo where idgrupo='$IdGrupo'");

        if($query_grupo === FALSE) { die(mysql_error()); }
        
        return mysql_fetch_array($query_grupo);
    }
    function ObtenerPrestamo ($IdPrestamo) {
        $query_prestamo = mysql_query("select * from prestamo where idprestamo='$IdPrestamo'");

        if($query_prestamo === FALSE) { die(mysql_error()); }
        
        return mysql_fetch_array($query_prestamo);
    }
    function ObtenerUsuario ($IdUsuario) {
        $query_usuario = mysql_query("select * from usuario where idusuario='$IdUsuario'");

        if($query_usuario === FALSE) { die(mysql_error()); }
        
        return mysql_fetch_array($query_usuario);
    }
    function ObtenerCliente ($IdCliente) {
        $query_cliente = mysql_query("select * from cliente where idcliente='$IdCliente'");

        if($query_cliente === FALSE) { die(mysql_error()); }
        
        return mysql_fetch_array($query_cliente);
    }
    function ConvertirReferencia($url) {
        $url = str_replace("&Tab=1", "", $url);
        $url = str_replace("&Tab=2", "", $url);
        $url = str_replace("&Tab=3", "", $url);
        $url = str_replace("&Tab=4", "", $url);
        $url = str_replace("&Tab=5", "", $url);
        $url = str_replace("/", "%2F", $url);
        $url = str_replace("?", "%3F", $url);
        $url = str_replace("&", "%26", $url);
        $url_r = $url;
        return $url_r;
    }
