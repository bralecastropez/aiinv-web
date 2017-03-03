<?php
    require_once("../db/session.php");
    require_once("../db/handler.php");

    if(isset($_GET['IdPrestamo'])) { 
        $IdPrestamo = $_GET['IdPrestamo']; 
    } 
    $Prestamo = ObtenerPrestamo($IdPrestamo);

    if (isset($_POST['submitted'])) { 
        for($i = 1; $i < ($Prestamo['CuotasRestantes'] + 1); $i++) {
            $sql = $_POST[$i];
            mysql_query($sql) or die(mysql_error());
            echo "Se agrego el pago";
        }
        //redirect("agregarPago.php");
    }
?>
    <!DOCTYPE html>
    <html>

    <head>

        <head>
            <title>AIINV - DYNAMICS PROGRESSIVE SYSTEMS</title>
            <link rel="shortcut icon" type="image/png" href="../../img/ic_launcher.png" />

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, shrink-to-fit=no" />
            <meta http-equiv="x-ua-compatible" content="ie=edge" />

            <!-- Font Awesome -->
            <link rel="stylesheet" href="../../css/mdl/MaterialIcons.css" />
            <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css" />

            <!-- Bootstrap core CSS -->
            <link rel="stylesheet" href="../../css/bootstrap.min.css" />

            <!-- Material Design Bootstrap-->
            <link rel="stylesheet" href="../../css/mdb.min.css" />

            <!-- MDL -->
            <link rel="stylesheet" href="../../css/mdl/material.min.css">
            <script type="text/javascript" src="../../css/mdl/material.min.js"></script>

            <!-- User Styles -->
            <link rel="stylesheet" href="../../css/styles.css">
            <link rel="stylesheet" href="../../css/style.css">

            <!-- Primefaces Core -->
            <link rel="stylesheet" href="../../css/core-layout.css">

            <!-- Select -->
            <link rel="stylesheet" href="../../css/mdl-selectfield/dist/mdl-selectfield.min.css">
            <link rel="stylesheet" href="../../css/mdl-select/getmdl-select.min.css" />

            <!-- Style for Inputs -->
            <style>
                .mdl-textfield,
                .mdl-selectfield {
                    width: 100%;
                }

            </style>

            <!-- Select js -->
            <script src="../../css/mdl-selectfield/dist/mdl-selectfield.min.js"></script>

            <!-- Date picker -->
            <link rel="stylesheet" href="../../css/bootstrap-material-datetimepicker.css" />

            <!-- jQuery Mask-Plugin -->
            <script type="text/javascript" src="../../js/jquery.mask.js"></script>

            <!-- Stepper -->
            <link rel="stylesheet" href="../../css/mdl-stepper/stepper.min.css">
            <!-- Stepper Javascript minified -->
            <script defer src="../../css/mdl-stepper/stepper.min.js"></script>

        </head>
    </head>

    <body>
        <script type="text/javascript" src="../../css/mdl/material.min.js"></script>

        <!-- JQuery -->
        <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>

        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="../../js/tether.min.js"></script>

        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="../../js/mdb.min.js"></script>

        <script type="text/javascript" src="../../js/moment.min.js"></script>
        <script type="text/javascript" src="../../js/bootstrap-material-datetimepicker.js"></script>
        <script type="text/javascript" src="../../js/jquery.mask.min.js"></script>
        <script defer src="../../css/mdl-select/getmdl-select.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#FechaNacimiento').bootstrapMaterialDatePicker({
                    format: 'YYYY-MM-DD h:mm:ss',
                    time: false,
                    clearButton: true
                });
                /*$material.init()*/
            });

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.fecha').mask('0000/00/00 00:00:00');
                $(".dpi").mask("0000 00000 0000");
                $(".nit").mask("0000000-A");
                $(".telefono").mask("0000-0000");
                $('.creditodecimal').mask("##0", {
                    reverse: true
                });
                $('.credito').mask("#,##0,000", {
                    reverse: true
                });
            });

        </script>

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
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<input type="text" id="' + i + '" value="' + (consulta(i, cuotaDiaria, fechaDesembolso, "days")) + '" />');
                    }
                    break;
                case "Semanal":
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<input type="text" id="' + i + '" value="' + (consulta(i, cuotaSemanal, fechaDesembolso, "weeks")) + '" />');
                    }
                    break;
                case "Quincenal":
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<input type="text" id="' + i + '" value="' + (consulta((i * 2), cuotaQuincenal, fechaDesembolso, "weeks")) + '" />');
                    }
                    break;
                case "Mensual":
                    document.write('<form name="envio" id="envio" method="post" action="" data-toggle="validator" role="form">');
                    for (i = 1; i < (cuotasRestantes + 1); i++) {
                        document.write('<p><input type="hidden" name="' + i + '" id="' + i + '" value="' + consulta(i, cuotaMensual, fechaDesembolso, "months") + '" /></p>');
                    }
                    document.write('<input type="hidden" name="submitted" value="1" />');
                    document.write('<input type="submit" value="1" />');
                    document.write('</form>');
                    break;
            }

        </script>
        <script>
            $(document).ready(function() {
                //$("#envio").submit();
            });

        </script>

        <script>
            var al = function() {
                for (i = 1; i < (cuotasRestantes + 1); i++) {
                    //alert($("#" + i).val());
                }
            };

        </script>
    </body>

    </html>



    <?php 



?>
