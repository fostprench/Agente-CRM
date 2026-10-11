<?php
    include("../lib/functions.php");
?>
<script type="text/javascript" src="../../../fraternidad-mvc/view/Modulo/js/app/evt_form_modulo.js" ></script>
<!--<script type="text/javascript" src="../../../fraternidad-mvc/view/Modulo/js/validateradiobutton.js"></script>-->

<div class="div_container">
<h6 class="ui-widget-header">Datos de Modulo</h6>
<form id="frm" action="../../../fraternidad-mvc/view/Modulo/index.php" method="POST">
    <input type="hidden" name="controller" value="Modulo" />
    <input type="hidden" name="action" value="delete" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div style="margin:0 auto; width: 600px; ">

                <label for="idmodulo" class="labels">Codigo:</label>
                <input id="idmodulos" name="idmodulos" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idmodulos; ?>" readonly />
                <label for="idpadre" class="labels">Padre:</label>
                <?php echo $ModulosPadres; ?>
                <br/>
                <label for="descripcion" class="labels">Descripcion:</label>
                <input id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>"  readonly="readonly"/>
                 <br/>
                <label for="url" class="labels">URL:</label>
   		<input id="url" name="url" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->url; ?>" readonly="readonly"  />

                <label for="orden" class="labels">Orden:</label>
   		<input id="orden" name="orden" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->orden; ?>" readonly="readonly" />
                 <br/>

                <label for="estado" class="labels">Activo:</label>
                <?php
                    $item = array("Si","No");
                    $rep = $obj->estado;
                    printRadios('activo',$item,$rep);
                ?>

                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="delete" class="button">ELIMINAR</a>
                    <a href="../../../fraternidad-mvc/view/Modulo/index.php?controller=Modulo" class="button">ATRAS</a>
                </div>
        </div>
    </div>
</form>
</div>