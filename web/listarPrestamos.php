<?php
    require_once("config/db/session.php");
    require_once("config/db/handler.php");
    $page_title = "Listado de Prestamos";
    require_once("config/page/header.php");
    
    $query_grupo = mysql_query("SELECT * FROM grupo");
?>
    <br/>
    <br/>
    <?php 
        while($grupo = mysql_fetch_array($query_grupo)){ 
            foreach($grupo AS $key => $value) { $grupo[$key] = stripslashes($value); }  
    ?>
    <div class="Container100">
        <div class="ContainerIndent TextAlCenter">
            <h5>
                <?php 
                    echo "<b style='color: darkgray;'>Grupo: " . $grupo['Nombre'] . "</b>";
                ?>
            </h5>
        </div>
        <hr/>
    </div>
    <div>
        <table class="mdl-data-table mdl-js-data-table Wid95" style="margin: 25px;">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Cliente</th>
                    <th class="mdl-data-table__cell--non-numeric">Periodo de Pago</th>
                    <th class="mdl-data-table__cell--non-numeric">Plazo</th>
                    <th class="mdl-data-table__cell--non-numeric">Fecha de Corte</th>
                    <th>Monto</th>
                    <th>Interes</th>
                    <th>Cuota</th>
                    <th class="mdl-data-table__cell--non-numeric">Estado</th>
                    <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $query_prestamos = mysql_query("select * from prestamo pre
	inner join cliente cli on cli.IdCliente = pre.IdCliente
where cli.IdGrupo = " . $grupo['IdGrupo']);
            while($prestamo = mysql_fetch_array($query_prestamos)){
                foreach($prestamo AS $key => $value)    {$prestamo[$key] = stripslashes($value);}
                $cliente = ObtenerCliente($prestamo['IdCliente']);
          ?>
                    <tr data-toggle="collapse" data-trget="#collapseOne_<?php echo $prestamo['IdPrestamo']; ?>">
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php echo $cliente['Nombre'] . " " . $cliente['Apellido']; ?>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php echo $prestamo['PeriodoPago']; ?>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php echo $prestamo['Plazo']; ?>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php echo $prestamo['FechaCorte']; ?>
                        </td>
                        <td>
                            <?php echo "Q. " . $prestamo['Monto']; ?>
                        </td>
                        <td>
                            <?php echo $prestamo['Interes']; ?>
                        </td>
                        <td>
                            <?php echo "Q. " . $prestamo['CuotaMensual']; ?>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php if($prestamo['Estado'] == 'Activo'): ?>
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-<?php echo $prestamo['IdPrestamo']; ?>">
  <input type="checkbox" id="switch-<?php echo $prestamo['IdPrestamo']; ?>" class="mdl-switch__input" readonly checked/>
  <span class="mdl-switch__label"></span>
                                
    <div class="mdl-tooltip" data-mdl-for="switch-<?php echo $prestamo['IdPrestamo']; ?>">
        Activo
    </div>
</label>
                            <?php else: ?>
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-<?php echo $prestamo['IdPrestamo']; ?>">
  <input type="checkbox" id="switch-<?php echo $prestamo['IdPrestamo']; ?>" class="mdl-switch__input" readonly/>
  <span class="mdl-switch__label"></span>
                                                         
    <div class="mdl-tooltip" data-mdl-for="switch-<?php echo $prestamo['IdPrestamo']; ?>">
        Inactivo
    </div>
</label>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="ShowMin Fright">
                                <div class="mdl-card__menu">
                                    <button id="demo-menu-lower-right<?php echo $prestamo['IdPrestamo']; ?>" class="mdl-button mdl-js-button mdl-button--icon">
                                  <i class="material-icons">more_vert</i>
                                </button>

                                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right<?php echo $prestamo['IdPrestamo']; ?>">
                                        <!--<a href="verGrupo.php?IdGrupo=<?php //echo $row[ 'IdGrupo']; ?>">
                        <li class="mdl-menu__item">
                            <button class="mdl-button mdl-js-button mdl-button--icon">
                              <i class="material-icons">info</i>
                            </button> Ver
                        </li>
                    </a>-->
                                        <a href="modificarPrestamo.php?IdPrestamo=<?php echo $prestamo['IdPrestamo']; ?>">
                                            <li class="mdl-menu__item">
                                                <button class="mdl-button mdl-js-button mdl-button--icon">
                                              <i class="material-icons">create</i>
                                            </button> Editar
                                            </li>
                                        </a>
                                        <a href="eliminarPrestamo.php?IdPrestamo=<?php echo $prestamo['IdPrestamo']; ?>">
                                            <li class="mdl-menu__item">
                                                <button class="mdl-button mdl-js-button mdl-button--icon">
                                              <i class="material-icons">delete</i>
                                            </button> Eliminar
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="ShowMax">
                                <button class="mdl-button mdl-js-button mdl-button--primary" onclick="ModificarPrestamo(<?php echo $prestamo['IdPrestamo']; ?>);">
                                    <i class="material-icons">create</i>
                                </button>
                                <button class="mdl-button mdl-js-button mdl-button--accent" onclick="EliminarPrestamo(<?php echo $prestamo['IdPrestamo']; ?>);">
                                    <i class="material-icons">delete</i>
                                </button>
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" onclick="VerPrestamo(<?php echo $prestamo['IdPrestamo']; ?>);">
                                    <span style="color: skyblue;" class="material-icons">remove_red_eye</span>
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr id="collapseOne_<?php echo $prestamo['IdPrestamo']; ?>" class="collapse">
                        <td colspan="9">
                            <div class="Fleft">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Detalle 1</td>
                                            <td>Detalle 2</td>
                                            <td>Detalle 3</td>
                                            <td>Detalle 4</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
    <?php 
        }
    require_once("config/page/footer.php");

    $Referencia = ConvertirReferencia($actual_link);
?>


    <script type="text/javascript">
        var ModificarPrestamo = function(idprestamo) {

        };

        var EliminarPrestamo = function(idprestamo) {

        };

        var VerPrestamo = function(idprestamo) {
            window.location.href = "verPrestamo.php?IdPrestamo=" + idprestamo + "&Referencia=<?php echo $Referencia; ?>";
        };

    </script>
