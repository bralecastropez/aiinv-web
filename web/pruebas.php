<?php 
    require_once("config/db/session.php"); 
    require_once("config/db/handler.php"); 
    $page_title = "Listado de Grupos"; 
    $page_maintance = true;
    require_once("config/page/header.php");
?>
<script type="text/javascript">
    var clic = 0;
    var start = false;

</script>

<div class="myelement" id="myelement" name="myelement">

    <?php
    ObtenerTitulo("Listado de Grupos");
?>
        <div onclick="iniciar();" class="Container100" style="height: 50px; width: 100%; background-color: blue; color:white;">
            <div class="Container50">Click =</div>
            <div class="Container20" id="hola" name="hola"></div>

        </div>

        <?php
// El mensaje
$mensaje = "Esto es una prueba 1\r\nA ver si te llega correctamente 2\r\nUn saludo 3\r\n\n\n\nwww.ejemplocodigo.com";

// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
$mensaje = wordwrap($mensaje, 70, "\r\n");

// Enviamos el email
mail('bralecastropez@gmail.com', 'Probando la funcion MAIL desde PHP', $mensaje);


echo "EMAIL ENVIADOfasdfads...";

?>


            <?php 
    require_once("config/page/footer.php");
?>
            <script type="text/javascript">
                var enviarClick = function() {
                    clic += 1;
                    $("#hola").text(clic);
                };
                var terminar = function() {
                    alert("Se agoto el tiempo! \n Hiciste " + clic + " clics");
                    start = false;
                    clic = 0;
                    $("#hola").text(clic);
                };
                var iniciar = function() {
                    if (!start) {
                        start = true;
                        enviarClick();
                        myVar = setTimeout(terminar, (5 * 1000));

                    } else {
                        enviarClick();
                    }
                };

            </script>
