<script type="text/javascript" src="web/js/evnt/modelo.js" ></script>
<br/><div class='ui-widget-header'>Registro de Modelos</div>
<div id="frmtotal">
	<div id="msg" ></div>
	<form id="_form" name="_form" action="" method="GET">
		<table  align='center' width="40%"  cellspacing="4"cellpadding="0" border="0" >
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		
			<tr>
				<td colspan="3" class='ui-alex'>Marca:</td>
				<td>
                    <input type="hidden" name="oper" id="oper" value="<?php echo $p;?>"/>
					<?php echo $marca;?>
			   </td>
			</tr>
			<tr>
				<td colspan="3" class='ui-alex'>Modelo:</td>
				<td>
                    <input name="idmodelo" id="idmodelo" type="hidden" value="<?php echo $obj->idmodelo?>"/>
					<input  type="text"  name="descripcion" id="descripcion" style='width:100%' value="<?php echo $obj->descripcion;?>" class="ui-widget-content ui-corner-all"/>
			   </td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5" align="center" >
					<?php if($p==1){?>
					<label class='uiButton uiButtonConfirm'><input type="submit" name="grabar" id="grabar" value="registrar"  /></label>
					<?php }if($p==2){?>
					<label class='uiButton uiButtonConfirm'> <input type="submit" name="actualiza" id="actualiza" value="actualizar"  /></label>
					<?php }?>
					<label class='uiButton uiButtonConfirm'> <input type="button" name="regresar" id="regresar" value="atras"  onclick="atras();"/></label>							
				</td>
			</tr>
			
		</table>
	</form>
</div><br/>