<?php 
        require_once("config/db/session.php");
        require_once("config/db/handler.php");
        $page_title = "Pruebas";
        $page_maintance = true;
        require_once("config/page/header.php");

if(isset($_GET['IdPrestamo'])) {
        $IdPrestamo = $_GET['IdPrestamo'];
    }
    
    if(isset($_GET['Referencia'])) {
        $url_referencia = $_GET['Referencia'];
    }

    $Prestamo = ObtenerPrestamo($IdPrestamo);

?>


<?php 
require_once("config/page/footer.php");
?>
<script type="text/javascript">
    var consulta = function(i, cuota, fechaDes, tipo) {
        var NoPago = "0";
        if (i > 99) {
            NoPago = "0" + i;
        } else {
            if (i > 9) {
                NoPago = "00" + i;
            } else {
                NoPago = "000" + i;
            }
        }
        var fecha = moment(fechaDes).add(i, tipo);
        var query = "INSERT INTO `pago` (IdPrestamo, CodigoPago, NoPago, Fecha, Estado, TipoPago, CantidadPagada) VALUES (";
        query = query + "'<?php echo $IdPrestamo; ?>',";
        query = query + "'PRE-<?php echo $IdPrestamo; ?>-" + NoPago + "',";
        query = query + "'" + NoPago + "',";
        query = query + "'" + fecha.format("YYYY-MM-DD hh:mm:ss") + "',";
        query = query + "'Pendiente', 'Efectivo',";
        query = query + " " + cuota + ");";
        return query;
    };

    var cuotasRestantes = <?php echo $Prestamo['CuotasRestantes'];   ?>;
    var cuotaDiaria = <?php echo $Prestamo['CuotaDiaria'];   ?>;
    var cuotaSemanal = <?php echo $Prestamo['CuotaSemanal'];   ?>;
    var cuotaQuincenal = <?php echo $Prestamo['CuotaQuincenal'];   ?>;
    var cuotaMensual = <?php echo $Prestamo['CuotaMensual'];   ?>;
    var fechaDesembolso = moment("<?php echo $Prestamo['FechaDesembolso'];   ?>").format();
    var periodoPago = "<?php echo $Prestamo['PeriodoPago'];   ?>";

    for (i = 1; i < (cuotasRestantes + 1); i++) {
        alert(i);
        document.write('<input type="text" value="' + consulta(i, cuotaMensual, fechaDesembolso, "months") + '"/>');
        document.write("<br/>")
    }

</script>
