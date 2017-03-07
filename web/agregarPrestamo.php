<?php
    require_once("config/db/session.php");
    require_once("config/db/handler.php");
    $page_title = "Agregar Prestamo";
    $page_maintance = true;
    require_once("config/page/header.php");

    if(isset($_GET['IdCliente'])) {
        $IdCliente = $_GET['IdCliente'];
    }
    
    if(isset($_GET['Referencia'])) {
        $url_referencia = $_GET['Referencia'];
    }

    $IdUsuario = $_SESSION['login_user_id'];

    $idpre = mysql_fetch_array(mysql_query("select (max(IdPrestamo) + 1) as 'idpre' from prestamo"))['idpre'];
    $Cliente = ObtenerCliente($IdCliente);
        
    if ($idpre < 9) {
        $CodigoPrestamo = "PRE00000" . $idpre;
    } else {
        if ($idpre > 100) {
            if ($idpre > 1000) {
                $CodigoPrestamo = "PRE00" . $idpre;
            } else {
                $CodigoPrestamo = "PRE000" . $idpre;
            }
        } else {
            $CodigoPrestamo = "PRE0000" . $idpre;
        }
    }
    
    if (isset($_POST['submitted'])) { 
        foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
        $sql = "INSERT INTO `prestamo` ( `IdUsuario` ,  `IdCliente` ,  `CodigoPrestamo` ,  `Monto` ,  `Titulo` ,  `Detalle` ,  `Estado` ,  `FechaDesembolso` ,  `FechaCorte` ,  `Mora` ,  `PeriodoPago` ,  `Interes` ,  `Plazo` ,  `MontoPagado` ,  `MontoParcial` ,  `MontoPendiente` ,  `CuotaDiaria` ,  `CuotaSemanal` ,  `CuotaQuincenal` ,  `CuotaMensual` ,  `CuotasPagadas` ,  `CuotasRestantes`  ) VALUES(  '{$_POST['IdUsuario']}' ,  '{$_POST['IdCliente']}',  '{$_POST['CodigoPrestamo']}' ,  '{$_POST['Monto']}', '{$_POST['Titulo']}' ,  '{$_POST['Detalle']}' ,  '{$_POST['Estado']}' ,  '{$_POST['FechaDesembolso']}' ,  '{$_POST['FechaCorteEnviar']}' ,  '{$_POST['Mora']}' ,  '{$_POST['PeriodoPago']}' ,  '{$_POST['Interes']}' ,  '{$_POST['Plazo']}' ,  '{$_POST['MontoPagado']}' ,  '{$_POST['MontoParcial']}' ,  '{$_POST['MontoPendiente']}' ,  '{$_POST['CuotaDiariaEnviar']}' ,  '{$_POST['CuotaSemanalEnviar']}' ,  '{$_POST['CuotaQuincenalEnviar']}' ,  '{$_POST['CuotaMensualEnviar']}' ,  '{$_POST['CuotasPagadas']}' ,  '{$_POST['CuotasRestantes']}'  ) "; 
        mysql_query($sql) or die(mysql_error()); 
        
        
        if (strpos($_POST['TipoPago'], 'Recomendado') !== false) {
            redirect("agregarPrestamo_Pago.php?IdPrestamo=" . $idpre . "&Referencia=" . ConvertirReferencia($url_referencia));
        }
        
        //redirect($url_referencia);
    } 
?>
    <br/>
    <br/>
    <form method="post" action="" data-toggle="validator" role="form">
        <section class="mdl-stepper-demo Wid100">
            <div align="center">
                <ul class="mdl-stepper mdl-stepper--feedback mdl-stepper--horizontal" id="demo-stepper-horizontal-linear-feedback">
                    <li class="mdl-step">
                        <span class="mdl-step__label">
              <span class="mdl-step__title">
                <span class="mdl-step__title-text">Prestamista</span>
                        <span class="mdl-step__title-message">Datos Generales</span>
                        </span>
                        </span>
                        <div class="mdl-step__content">
                            <div class="Container100">
                                <div class="ContainerIndent">
                                    <div>
                                        <p class="Fleft"><b>Ingrese un T&iacute;tulo: </b></p>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <input class="mdl-textfield__input" type="text" maxlength="40" required pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$" name="Titulo" id="Titulo" />
                                            <label class="mdl-textfield__label" for="Titulo">T&iacute;tulo</label>
                                            <span class="mdl-textfield__error">Debe ingresar un t&iacute;tulo v&aacute;lido</span>
                                        </div>
                                    </div><br/>
                                    <div>
                                        <p class="Fleft"><b>Ingrese un Detalle del Prestamo: </b></p>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <input class="mdl-textfield__input" type="text" maxlength="40" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$" name="Detalle" id="Detalle" />
                                            <label class="mdl-textfield__label" for="Detalle">Detalle</label>
                                            <span class="mdl-textfield__error">Debe ingresar un detalle v&aacute;lido</span>
                                        </div>
                                    </div><br/>
                                    <div class="Container100">
                                        <div class="Container50 MaintanceResponsive">
                                            <p class="Fleft"><b>Seleccione la Fecha de Desembolso:</b></p>
                                            <div class="ContainerIndent">
                                                <div class="mdl-textfield mdl-js-textfield">
                                                    <input placeholder="Fecha Desembolso" type="text" id="FechaDesembolso" name="FechaDesembolso" required name="FechaDesembolso" class="mdl-textfield__input" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Container50 MaintanceResponsive">
                                            <p class="Fleft"><b>Seleccione un Estado:</b></p>
                                            <div class="ContainerIndent">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                    <input class="mdl-textfield__input" type="text" id="Estado" name="Estado" min="6" value="Activo" required readonly tabIndex="-1" />
                                                    <ul for="Estado" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                        <li class="mdl-menu__item">Activo</li>
                                                        <li class="mdl-menu__item">Inactivo</li>
                                                    </ul>
                                                    <span class="mdl-textfield__error">Seleccione un estado</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdl-step__actions mdl-card--border">
                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored" data-stepper-next>
                            Siguiente
                        </button>
                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-stepper-cancel>
                            Cancelar
                        </button>
                        </div>
                    </li>
                    <li class="mdl-step">
                        <span class="mdl-step__label">
                        <span class="mdl-step__title">
                            <span class="mdl-step__title-text">Prestamo/Plazo</span>
                        <span class="mdl-step__title-message">Datos Espec&iacute;ficos</span>
                        </span>
                        </span>
                        <div class="mdl-step__content">
                            <div class="Container100">
                                <div class="Container50 MaintanceResponsive">
                                    <div class="ContainerIndent">
                                        <div>
                                            <p class="Fleft"><b>Seleccione un Tipo de Pago:</b></p>
                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                <input class="mdl-textfield__input" type="text" id="TipoPago" name="TipoPago" min="6" value="Generar Autom&aacute;ticamente (Recomendado)" required readonly tabIndex="-1" />
                                                <ul for="TipoPago" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                    <li class="mdl-menu__item"><b>Generar Autom&aacute;ticamente (Recomendado)</b></li>
                                                    <li class="mdl-menu__item">No Generar</li>
                                                </ul>
                                                <span class="mdl-textfield__error">Seleccione un estado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Container50 MaintanceResponsive">
                                    <div class="ContainerIndent">
                                        <div>
                                            <p class="Fleft"><b>Seleccione el Impuesto por Retraso (Mora):</b></p>
                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                <input class="mdl-textfield__input" type="text" id="Mora" name="Mora" min="6" value="1% x Dia" required readonly tabIndex="-1" />
                                                <ul for="Mora" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                    <li class="mdl-menu__item">1% x Dia</li>
                                                    <li class="mdl-menu__item">3% x Dia</li>
                                                    <li class="mdl-menu__item">10% x Semana</li>
                                                    <li class="mdl-menu__item">12% x Semana</li>
                                                    <li class="mdl-menu__item">15% x Semana</li>
                                                    <li class="mdl-menu__item">10% x Mes</li>
                                                    <li class="mdl-menu__item">12% x Mes</li>
                                                    <li class="mdl-menu__item">15% x Mes</li>
                                                </ul>
                                                <span class="mdl-textfield__error">Seleccione un estado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Container100">
                                    <div class="Container50">
                                        <div class="ContainerIndent">
                                            <p class="Fleft"><b>Seleccione el Plazo: </b></p>
                                            <div class="input-group">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                    <input class="mdl-textfield__input" onclick="actualizarPrestamo();" onkeyup="actualizarPrestamo();" type="text" id="Plazo" name="Plazo" min="6" value="18 Meses" required readonly tabIndex="-1" />
                                                    <ul for="Plazo" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                        <li class="mdl-menu__item">3 Meses</li>
                                                        <li class="mdl-menu__item">6 Meses</li>
                                                        <li class="mdl-menu__item">12 Meses</li>
                                                        <li class="mdl-menu__item">18 Meses</li>
                                                        <li class="mdl-menu__item">24 Meses</li>
                                                        <li class="mdl-menu__item">36 Meses</li>
                                                        <li class="mdl-menu__item">48 Meses</li>
                                                    </ul>
                                                    <span class="mdl-textfield__error">Seleccione un estado v&aacute;lido</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Container50">
                                        <div class="ContainerIndent">
                                            <p class="Fleft"><b>Seleccione el Inter&eacute;s: </b></p>
                                            <div class="input-group">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                    <input class="mdl-textfield__input" type="text" id="Interes" name="Interes" onclick="actualizarPrestamo();" onkeyup="actualizarPrestamo();" min="6" value="12%" required readonly tabIndex="-1" />
                                                    <ul for="Interes" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                        <li class="mdl-menu__item ">10%</li>
                                                        <li class="mdl-menu__item ">12%</li>
                                                        <li class="mdl-menu__item ">14%</li>
                                                        <li class="mdl-menu__item ">16%</li>
                                                        <li class="mdl-menu__item ">18%</li>
                                                    </ul>
                                                    <span class="mdl-textfield__error">Seleccione un inter&eacute;s v&aacute;lido</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Container100">
                                        <div class="ContainerIndent">
                                            <br/>
                                            <p class="Fleft"><b>Ingrese un Monto: </b></p><br/>
                                            <p>Monto M&aacute;ximo Permitido: (<b>Q. <?php echo $Cliente['LimiteCredito']; ?></b>)</p>
                                            <div class="input-group">
                                                <span class="input-group-addon">Q</span>
                                                <div class="mdl-textfield mdl-js-textfield">
                                                    <input class="monto mdl-textfield__input creditodecimal" type="text" name="Monto" id="Monto" required onkeyup="actualizarPrestamoMonto(this.value);" />
                                                    <span class="mdl-textfield__error">Debe ingresar un monto v&aacute;lido</span>
                                                </div>
                                                <span class="input-group-addon">.00</span>
                                            </div>
                                        </div>
                                        <br/>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdl-step__actions">
                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored" data-stepper-next>
                            Siguiente
                        </button>
                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-stepper-cancel>
                            Cancelar
                        </button>
                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-stepper-back>
                            Regresar
                        </button>
                        </div>
                    </li>
                    <li class="mdl-step" data-step-transient-message="Se estan agregando los pagos">
                        <span class="mdl-step__label">
                        <span class="mdl-step__title">
                            <span class="mdl-step__title-text">Agregar Prestamo</span>
                        <span class="mdl-step__title-message">Finalizaci&oacute;n</span>
                        </span>
                        </span>
                        <div class="mdl-step__content">
                            <div class="col-md-12">

                                <div class="Container100">
                                    <div class="ContainerIndent">
                                        <div class="Container50">
                                            <div class="ContainerIndent">
                                                <p class="Fleft"><b>Seleccione el Periodo de Pago: </b></p>
                                                <div class="input-group">
                                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                                        <input class="mdl-textfield__input" type="text" id="PeriodoPago" name="PeriodoPago" onclick="actualizarPrestamo();" onkeyup="actualizarPrestamo();" min="6" value="Mensual" required readonly tabIndex="-1" />
                                                        <ul for="PeriodoPago" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                            <li class="mdl-menu__item ">Diario</li>
                                                            <li class="mdl-menu__item ">Semanal</li>
                                                            <li class="mdl-menu__item ">Quincenal</li>
                                                            <li class="mdl-menu__item ">Mensual</li>
                                                        </ul>
                                                        <span class="mdl-textfield__error">Seleccione un periodo v&aacute;lido</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Container50">
                                            <div class="ContainerIndent">
                                                <div>
                                                    <button type="button" onclick="actualizarPrestamo();" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                                      Actualizar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp Wid90">
                                    <tbody>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">C&oacute;digo del Prestamo</td>
                                            <td>
                                                <div id="DetalleCodigoPrestamo">
                                                    <?php echo $CodigoPrestamo; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">Fecha de Corte</td>
                                            <td>
                                                <div id="FechaCorte"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">Cuota Diaria</td>
                                            <td>
                                                <div id="Diaria"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">Cuota Semanal</td>
                                            <td>
                                                <div id="Semanal"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">Cuota Quincenal</td>
                                            <td>
                                                <div id="Quincenal">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">Cuota Mensual</td>
                                            <td>
                                                <div id="Mensual"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mdl-step__actions">
                            <input type='hidden' value='1' name='submitted' />
                            <input type="hidden" value="<?php echo $CodigoPrestamo; ?>" name="CodigoPrestamo" />
                            <input type="hidden" value="<?php echo $IdCliente; ?>" name="IdCliente" />
                            <input type="hidden" value="<?php echo $IdUsuario; ?>" name="IdUsuario" />
                            <input type="hidden" id="FechaCorteEnviar" name="FechaCorteEnviar" />
                            <input type="hidden" id="FechaDesembolsoEnviar" name="FechaDesembolsoEnviar" />
                            <input type="hidden" id="MontoPagado" name="MontoPagado" value="0" />
                            <input type="hidden" id="MontoParcial" name="MontoParcial" />
                            <input type="hidden" id="MontoPendiente" name="MontoPendiente" />
                            <input type="hidden" id="CuotasPagadas" name="CuotasPagadas" value="0" />
                            <input type="hidden" id="CuotasRestantes" name="CuotasRestantes" />
                            <input type="hidden" id="CuotaDiariaEnviar" name="CuotaDiariaEnviar" />
                            <input type="hidden" id="CuotaSemanalEnviar" name="CuotaSemanalEnviar" />
                            <input type="hidden" id="CuotaQuincenalEnviar" name="CuotaQuincenalEnviar" />
                            <input type="hidden" id="CuotaMensualEnviar" name="CuotaMensualEnviar" />
                            <input type="hidden" id="MontoEnviar" name="MontoEnviar" />
                            <input type="hidden" id="TituloEnviar" name="TituloEnviar" />
                            <input type="hidden" id="DetalleEnviar" name="DetalleEnviar" />


                            <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-stepper-back>
                            Regresar
                        </button>

                            <button type="button" class="mdl-button mdl-js-button mdl-button--accent " onclick="regresar();" data-stepper-cancel>
                            Cancelar
                        </button>

                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " type='submit' onclick="verify();" data-stepper-next>
                            Agregar
                        </button>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </form>
    <br/>
    <br/>

    <?php require_once("config/page/footer.php"); ?>

    <script>
        (function() {
            var stepperHorizontal = function() {
                var selector = '.mdl-stepper#demo-stepper-horizontal-linear-feedback';
                var stepperElement = document.querySelector(selector);
                var Stepper;
                var steps;

                var titulo = document.querySelector("#Titulo");
                var fechaDesembolso = document.querySelector("#FechaDesembolso");
                var monto = document.querySelector("#Monto");

                if (!stepperElement) return;

                Stepper = stepperElement.MaterialStepper;

                if (!Stepper) {
                    console.error('MaterialStepper instance is not available for selector: ' + selector + '.');
                    return;
                }

                steps = stepperElement.querySelectorAll('.mdl-step');
                for (var i = 0; i < steps.length; i++) {
                    steps[i].addEventListener('onstepnext', function(e) {
                        switch (Stepper.getActiveId()) {
                            case 1:
                                if (titulo.value.length == 0) {
                                    Stepper.error('Debe ingresar un t&iacute;tulo v&aacute;lido');
                                } else {
                                    if (fechaDesembolso.value.length == 0) {
                                        Stepper.error('Debe seleccionar una fecha de desembolso');
                                    } else {
                                        Stepper.next();
                                    }
                                }
                                break;
                            case 2:
                                if (monto.value <= 0) {
                                    Stepper.error('Debe ingresar un monto válido');
                                } else {
                                    Stepper.next();
                                }
                                break;
                            case 3:
                                break;
                        }
                    });
                    steps[i].addEventListener('onsteperror', function(event) {
                        console.log('Ops! something goes wrong with this step');
                    });
                }

                stepperElement.addEventListener('onstepnext', function(event) {
                    //Stepper.next();
                    switch (Stepper.getActiveId()) {
                        case 1:
                            if (titulo.value.length == 0) {
                                Stepper.error('Debe ingresar un título válido');
                            } else {
                                if (fechaDesembolso.value.length == 0) {
                                    Stepper.error('Debe seleccionar una fecha de desembolso');
                                } else {
                                    Stepper.next();
                                }
                            }
                            break;
                        case 2:
                            if (monto.value <= 0) {
                                Stepper.error('Debe ingresar un monto v&aacute;lido');
                            } else {
                                Stepper.next();
                            }
                            break;
                        case 3:
                            actualizarPrestamo();
                            break;
                    }
                });
                stepperElement.addEventListener('onstepback', function(event) {
                    Stepper.back();
                });
            };

            window.addEventListener('load', stepperHorizontal)
        })();

    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#FechaDesembolso').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                time: false,
                clearButton: true
            });
            $('#FechaCorte').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD h:mm:ss',
                time: false,
                clearButton: true
            });
            $('#Monto').mask('##0', {
                reverse: true
            });
        });

    </script>

    <script type="text/javascript">
        var actualizarPrestamoMonto = function(Monto) {
            var In = $("#Interes").val().replace("%", "");
            var Pl = $("#Plazo").val().replace(" Meses", "");

            var Interes = (In / 100) + 1;
            var Plazo = Pl;
            var MontoAPagar = Monto * Interes;


            var FechaCorte = moment($("#FechaDesembolso").val()).add(Plazo, 'months');

            $("#FechaCorte").text(FechaCorte.format('LL'));

            var FechaDesembolsoEnviar = moment($("#FechaDesembolso").val()).format('YYYY-MM-DD h:mm:ss');
            var FechaCorteEnviar = FechaCorte.format('YYYY-MM-DD h:mm:ss');

            var CuotaMensual = MontoAPagar / Plazo;
            var CuotaQuincenal = CuotaMensual / 2;
            var CuotaSemanal = CuotaQuincenal / 2;
            var CuotaDiaria = CuotaSemanal / 7;

            CuotaDiaria = parseFloat(CuotaDiaria).toFixed(2);
            CuotaSemanal = parseFloat(CuotaSemanal).toFixed(2);
            CuotaQuincenal = parseFloat(CuotaQuincenal).toFixed(2);
            CuotaMensual = parseFloat(CuotaMensual).toFixed(2);

            $("#Diaria").text("Q. " + CuotaDiaria);
            $("#Semanal").text("Q. " + CuotaSemanal);
            $("#Quincenal").text("Q. " + CuotaQuincenal);
            $("#Mensual").text("Q. " + CuotaMensual);

            //Cuotas Restantes
            //alert($("#PeriodoPago").val());
            switch ($("#PeriodoPago").val()) {
                case "Mensual":
                    $("#CuotasRestantes").val(Plazo);
                    break;
                case "Quincenal":
                    $("#CuotasRestantes").val(Plazo * 2);
                    break;
                case "Semanal":
                    $("#CuotasRestantes").val(Plazo * 4);
                    break;
                case "Diario":
                    var MontoPagado = 0;
                    var NoPagos = 0;
                    for (i = 0; i < (Plazo * 30); i++) {
                        MontoPagado = CuotaDiaria * i;
                        if (MontoPagado <= MontoAPagar) {
                            NoPagos = NoPagos + 1;
                        } else {
                            break;
                        }
                    }
                    $("#CuotasRestantes").val(NoPagos);
                    break;
            }

            //Inputs
            $("#CuotaDiariaEnviar").val(CuotaDiaria);
            $("#CuotaSemanalEnviar").val(CuotaSemanal);
            $("#CuotaQuincenalEnviar").val(CuotaQuincenal);
            $("#CuotaMensualEnviar").val(CuotaMensual);
            $("#FechaCorteEnviar").val(FechaCorteEnviar);
            $("#FechaDesembolsoEnviar").val(FechaDesembolsoEnviar);

            //$("#CuotasRestantes").val(Plazo);
            //alert($("#CuotasRestantes").val());

            $("#MontoParcial").val(parseFloat(MontoAPagar).toFixed(2));
            $("#MontoPendiente").val(parseFloat(MontoAPagar).toFixed(2));
            $("#MontoEnviar").val(parseFloat(Monto).toFixed(2));
            $("#TituloEnviar").val($("#Titulo").val());
            $("#DetalleEnviar").val($("#Detalle").val());
        };

        var actualizarPrestamo = function() {
            actualizarPrestamoMonto($("#Monto").val());
        };

    </script>
    <script type="text/javascript">
        var agregarPagos = function() {
            $("#myModal").modal();
        };

    </script>
