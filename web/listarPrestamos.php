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
                    <th>Cuota Mensual</th>
                    <th class="mdl-data-table__cell--non-numeric">Estado</th>
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
                    <tr>
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
                            <?php echo $prestamo['Monto']; ?>
                        </td>
                        <td>
                            <?php echo $prestamo['Interes']; ?>
                        </td>
                        <td>
                            <?php echo $prestamo['CuotaMensual']; ?>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <?php if($prestamo['Estado'] == 'Activo'): ?>
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
  <input type="checkbox" id="switch-1" class="mdl-switch__input" readonly checked>
  <span class="mdl-switch__label"></span>
</label>
                            <?php else: ?>
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
  <input type="checkbox" id="switch-2" class="mdl-switch__input" readonly>
  <span class="mdl-switch__label"></span>
</label>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
    <?php 
        }
    ?>


    <?php
echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>IdPrestamo</b></td>"; 
echo "<td><b>IdUsuario</b></td>"; 
echo "<td><b>IdCliente</b></td>"; 
echo "<td><b>CodigoPrestamo</b></td>"; 
echo "<td><b>FechaDesembolso</b></td>"; 
echo "<td><b>FechaCorte</b></td>"; 
echo "<td><b>Mora</b></td>"; 
echo "<td><b>PeriodoPago</b></td>"; 
echo "<td><b>Interes</b></td>"; 
echo "<td><b>Plazo</b></td>"; 
echo "<td><b>Detalle</b></td>"; 
echo "<td><b>Estado</b></td>"; 
echo "<td><b>MontoPagado</b></td>"; 
echo "<td><b>MontoParcial</b></td>"; 
echo "<td><b>MontoPendiente</b></td>"; 
echo "<td><b>CuotaDiaria</b></td>"; 
echo "<td><b>CuotaSemanal</b></td>"; 
echo "<td><b>CuotaQuincenal</b></td>"; 
echo "<td><b>CuotaMensual</b></td>"; 
echo "<td><b>CuotasPagadas</b></td>"; 
echo "<td><b>CuotasRestantes</b></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `prestamo`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['IdPrestamo']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['IdUsuario']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['IdCliente']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CodigoPrestamo']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['FechaDesembolso']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['FechaCorte']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['Mora']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['PeriodoPago']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['Interes']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['Detalle']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['Plazo']) . "</td>";   ?>
        <td>
            <?php if($row['Estado'] == 'Activo'): ?>
            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
  <input type="checkbox" id="switch-1" class="mdl-switch__input" readonly checked>
  <span class="mdl-switch__label"></span>
</label>
            <?php else: ?>
            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
  <input type="checkbox" id="switch-2" class="mdl-switch__input" readonly>
  <span class="mdl-switch__label"></span>
</label>
            <?php endif; ?>
        </td>
        <?php
echo "<td valign='top'>" . nl2br( $row['Estado']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['MontoPagado']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['MontoParcial']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['MontoPendiente']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CuotaDiaria']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CuotaSemanal']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CuotaQuincenal']) . "</td>";  ?>
            <?php
echo "<td valign='top'>" . nl2br( $row['CuotaMensual']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CuotasPagadas']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['CuotasRestantes']) . "</td>";  
echo "<td valign='top'><a href=modificarPrestamo.php?IdPrestamo={$row['IdPrestamo']}>Edit</a></td><td><a href=eliminarPrestamo.php?IdPrestamo={$row['IdPrestamo']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=agregarPrestamo.php>New Row</a>"; 
    require_once("config/page/footer.php");
?>
