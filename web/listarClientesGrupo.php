<?php
    require_once("config/db/session.php");
    require_once("config/db/handler.php");
    $page_title = "Clientes Por Grupo";
    require_once("config/page/header.php");

    if(isset($_GET['IdGrupo'])) {
        $Grupo = ObtenerGrupo($_GET['IdGrupo']);
    }
?>
    <style>
        .mdl-card {
            width: 100%;
            margin: 10px;
            height: 50px;
        }
        
        .mdl-card>.mdl-card__actions>.pull-right {
            border-top-color: gray;
            padding-right: 10px;
        }
        
        .mdl-card>.mdl-card__actions {
            height: auto;
        }
        
        #sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
        }

    </style>
    <a id="add-maintance" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" href="agregarCliente.php">
        <i class="material-icons" style="color: white;">add</i>
    </a>
    <div class="mdl-tooltip" data-mdl-for="add-maintance">
        Agregar Cliente
    </div>

    <div class="Container100" style="background-color: rgb(244, 67, 54); color: white;">
        <div style="margin: 10px;">
            <table style="width: 100%;">
                <tr>
                    <td><b>Grupo: </b> La Asunción
                    </td>
                    <td><b>Nombres de Grupos:</b> Seleccionados</td>
                </tr>
                <tr>
                    <td><b>Cantidad de Prestamos:</b>
                        <?php
                    $cantidad = mysql_fetch_array(mysql_query("select count(*) as 'cantidad' from prestamo 
	inner join cliente cli on prestamo.idcliente = cli.idcliente
where cli.IdGrupo = " . $Grupo['IdGrupo']));
                    echo $cantidad['cantidad'];
                ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Cantidad de Clientes: </b>
                        <?php
                    $cantidad = mysql_fetch_array(mysql_query("SELECT count(*) AS 'cantidad' FROM `cliente` WHERE IdGrupo = " . $Grupo['IdGrupo']));
                    echo $cantidad['cantidad'];
                ?>
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <br/>
    <br/>

    <div class="Container100">
        <div class="ContainerIndent TextAlCenter">

            <!--<h5>
    <p>
        <b>Grupo</b><br/>
        <?php //echo $Grupo['Nombre']; ?>
    </p>
    <p>
        <b>Cantidad de Clientes</b><br/>
        <?php //echo $Grupo['Nombre']; ?>
    </p>
</h5>
<br/>
<h5 style="color: lightgray;">
    Cantidad de Clientes:
    <?php
                    $cantidad = mysql_fetch_array(mysql_query("SELECT count(*) AS 'cantidad' FROM `cliente` WHERE IdGrupo = " . $Grupo['IdGrupo']));
                    echo $cantidad['cantidad'];
                ?>
</h5>-->
        </div>
        <hr/>
    </div>
    <?php
    $result = mysql_query("SELECT * FROM `cliente` WHERE IdGrupo = " . $Grupo['IdGrupo']) or trigger_error(mysql_error()); 
    while($row = mysql_fetch_array($result)){ 
        foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
    ?>
        <div class="ContainerIndent" style="margin-right: 30px;">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-card--border">
                    <h2 class="mdl-card__title-text">
                        <?php echo $row['Nombre'] . " " . $row['Apellido']; ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-card--border">
                    <div class="col-md-6">
                        <div>
                            <b>C&oacute;digo Cliente:</b>
                            <?php echo $row['CodigoCliente']; ?>
                        </div>
                        <div>
                            <b>Grupo:</b>
                            <?php echo ObtenerGrupo($row['IdGrupo'])['Nombre']; ?>
                        </div>
                        <div>
                            <b>L&iacute;mite Cr&eacute;dito:</b> Q.
                            <?php echo $row['LimiteCredito'] ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <b>DPI:</b>
                            <?php echo $row['DPI']; ?>
                        </div>
                        <div>
                            <b>Nit:</b>
                            <?php echo $row['NIT']; ?>
                        </div>
                        <div>
                            <b>Fecha de Modificaci&oacute;n:</b>
                            <?php echo $row['FechaModificacion'] ?>
                        </div>
                    </div>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <button class="mdl-button mdl-js-button mdl-button--primary mdl-js-ripple-effect">
                  Ver Pagos
                </button>
                    <button class="mdl-button mdl-js-button mdl-button--accent mdl-js-ripple-effect">
                  Ver Prestamos
                </button>
                </div>
                <div class="mdl-card__menu">
                    <button id="demo-menu-lower-right<?php echo $row['IdCliente']; ?>" class="mdl-button mdl-js-button mdl-button--icon">
                  <i class="material-icons">more_vert</i>
                </button>

                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right<?php echo $row['IdCliente']; ?>">
                        <a href="eliminarCliente.php?IdCliente=<?php echo $row[ 'IdCliente']; ?>">
                            <li class="mdl-menu__item">
                                <button class="mdl-button mdl-js-button mdl-button--icon">
                              <i class="material-icons">info</i>
                            </button> Ver
                            </li>
                        </a>
                        <a href="modificarCliente.php?IdCliente=<?php echo $row[ 'IdCliente']; ?>">
                            <li class="mdl-menu__item">
                                <button class="mdl-button mdl-js-button mdl-button--icon">
                              <i class="material-icons">create</i>
                            </button> Editar
                            </li>
                        </a>
                        <a href="eliminarCliente.php?IdCliente=<?php echo $row[ 'IdCliente']; ?>">
                            <li class="mdl-menu__item">
                                <button class="mdl-button mdl-js-button mdl-button--icon">
                              <i class="material-icons">delete</i>
                            </button> Eliminar
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php require_once("config/page/footer.php"); ?>
