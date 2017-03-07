<?php
    require_once("config/db/session.php");
    require_once("config/db/handler.php");
    $page_title = "Agregar Pagos a Prestamo";
    $page_maintance = true;
    require_once("config/page/header.php");

    if(isset($_GET['IdPrestamo'])) { 
        $IdPrestamo = $_GET['IdPrestamo']; 
    }

    $Prestamo = ObtenerPrestamo($IdPrestamo);
    
    if(isset($_GET['Referencia'])) {
        $url_referencia = $_GET['Referencia'];
    }

    if (isset($_POST['submitted'])) { 
        for($i = 1; $i < ($Prestamo['CuotasRestantes'] + 1); $i++) {
            $sql = $_POST[$i];
            mysql_query($sql) or die(mysql_error());
        }
        redirect($url_referencia);
    }

    
?>
    <br/>
    <br/>

    <div>
        <h6 style="color: gray; text-align: center;">
            Agregando Pagos
            <br/>
            <br/>
            <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate Wid20" style="margin:0 auto;"></div>
        </h6>
        <script type="text/javascript" src="css/mdl/material.min.js"></script>

        <!-- JQuery -->
        <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>

        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="js/tether.min.js"></script>

        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="js/mdb.min.js"></script>

        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-material-datetimepicker.js"></script>
        <script type="text/javascript" src="js/jquery.mask.min.js"></script>
        <script defer src="css/mdl-select/getmdl-select.min.js"></script>
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

            //alert('<input type="text" value="' + consulta(3, cuotaDiaria, fechaDesembolso, "day") + '"/>');




            switch (periodoPago) {
                case "Diario":
                    document.write('<form name="envio" id="envio" method="post" action="" data-toggle="validator" role="form">');
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<p><input type="hidden" name="' + i + '" id="' + i + '" value="' + consulta(i, cuotaDiaria, fechaDesembolso, "days") + '" /></p>');
                    }
                    document.write('<input type="hidden" name="submitted" value="1" />');
                    document.write('</form>');
                    break;
                case "Semanal":
                    document.write('<form name="envio" id="envio" method="post" action="" data-toggle="validator" role="form">');
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<p><input type="hidden" name="' + i + '" id="' + i + '" value="' + consulta(i, cuotaSemanal, fechaDesembolso, "weeks") + '" /></p>');
                    }
                    document.write('<input type="hidden" name="submitted" value="1" />');
                    document.write('</form>');
                    break;
                case "Quincenal":
                    document.write('<form name="envio" id="envio" method="post" action="" data-toggle="validator" role="form">');
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<p><input type="hidden" name="' + i + '" id="' + i + '" value="' + consulta((i * 2), cuotaQuincenal, fechaDesembolso, "weeks") + '" /></p>');
                    }
                    document.write('<input type="hidden" name="submitted" value="1" />');
                    document.write('</form>');
                    break;
                case "Mensual":
                    document.write('<form name="envio" id="envio" method="post" action="" data-toggle="validator" role="form">');
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<p><input type="hidden" name="' + i + '" id="' + i + '" value="' + consulta(i, cuotaMensual, fechaDesembolso, "months") + '" /></p>');
                    }
                    document.write('<input type="hidden" name="submitted" value="1" />');
                    document.write('</form>');
                    break;
            }

        </script>
    </div>

    <?php require_once("config/page/footer.php");?>

    <!-- script -->
    <script type="text/javascript">
        var c = 0;
        var t;
        var timer_is_on = 0;

        function timedCount() {
            c = c + 1;
            t = setTimeout(function() {
                timedCount()
            }, 1000);
        }

        function startCount() {
            if (!timer_is_on) {
                timer_is_on = 1;
                timedCount();
            }
        }

        function stopCount() {
            clearTimeout(t);
            timer_is_on = 0;
        }

    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#envio").submit()
            }, 2000);

        });

    </script>
