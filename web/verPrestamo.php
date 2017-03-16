<?php 
    require_once("config/db/session.php");
    require_once("config/db/handler.php");
    $page_title = "Ver Prestamo";
    require_once("config/page/header.php");

    if(isset($_GET['IdPrestamo'])) {
        $IdPrestamo = $_GET['IdPrestamo'];
    }
    
    if(isset($_GET['Referencia'])) {
        $url_referencia = $_GET['Referencia'];
    }
    
    $Prestamo = ObtenerPrestamo($IdPrestamo);
    $Cliente = ObtenerCliente($Prestamo['IdCliente']);
    

?>
<br/>
<br/>
<div class="Container100">
    <div class="ContainerIndent TextAlCenter">
        <h5>
            <?php 
                    echo "Cliente: <b style='color: darkgray;'> " . $Cliente['Nombre'] . " " . $Cliente['Apellido'] . "</b>";
                ?>
        </h5>
    </div>
    <hr/>
</div>
<span class="mdl-badge" data-badge="4">Inbox</span>
<?php 
    require_once("config/page/footer.php");
?>
