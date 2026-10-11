<script type="text/javascript" src="web/js/evnt/val_frmuser.js" ></script>
<div class='ui-widget-header'>Registro de Usuario</div>
	<div id="frmtotal_view">
	    <div id="msg" ></div>
        <form id="_form" name="_form" action="" method="POST" enctype="multipart/form-data" target="fotoim">
		<input type="hidden" name="controller" value="user" />
        <input type="hidden" name="action" value="save_photo_temp" />
			<table width="500" cellspacing="4" cellpadding="0"   border="0">
  <tr>
    <td width="128" >Perfil:</td>
    <td width="357" ><select name ='perfil' disabled='true'><?php echo $perfil;?></select></td>
    <td width="145" rowspan="5"><div class="fotos_u" id="userfoto">
	<img width='153px' height='150px' src="view/fotos_user/<?php echo $obj->usuario_photo; ?>.jpg"/>
	</div></td>

  </tr>
  <tr>
    <td>Nombres:</td>
    <td>
	<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $obj->idusuario; ?>"/>
	<input type="text" name="usuario_nombres" id="usuario_nombres" readonly="readonly" value="<?php echo $obj->nombres; ?>" size="30" maxlength="100"/></td>
  </tr>
      <tr>
		<td width="128">Domicilio:</td>
		<td > <input type="text" name="usuario_direccion" readonly="readonly" id="usuario_direccion" value="<?php echo $obj->usuario_direccion; ?>" size="30" maxlength="100"/>
		</td>
				</tr>
				<tr>
					<td width="128">Telefono:</td>
					<td colspan='2'>
						<input type="text" readonly="readonly" name="usuario_telefono" id="usuario_telefono" value="<?php echo $obj->usuario_telefono; ?>" size="13" maxlength="100" onkeypress="return permite(event,'num')"/>
						DNI :<input readonly="readonly" type="text"  name="usuario_numdoc" id="usuario_numdoc" size="13" maxlength="8" value="<?php echo $obj->usuario_numdoc;?>" onkeypress="return permite(event,'num')"/>
					</td>
				</tr>
				
				<tr>
					<td>Usuario:</td>
					<td colspan='2'>
					<input  type="text"  name="usuario_nick" id="usuario_nick" size="13" maxlength="13" value="<?php echo $obj->usuario;?>" readonly="readonly"/>  <!--onkeydown="javascript:validarU();"-->
						Clave:<input disabled='true' type="password" name="usuario_password" id="usuario_password" size="13" maxlength="13"  onkeydown="javascript:validar();"/>
					</td>
					<td>
						<div id="resp"></div>
						<div id="res"></div>
					</td>
				</tr>
				<tr>
				<td>fecha_nac</td>
				<td><input readonly="readonly" name="f" id="f" value="<?php echo $obj->usuario_fechanac; ?>" size="20" maxlength="20">
				</td>
				</tr>
				
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				                <tr>
			        <td colspan="4" align="center" >
								<div style="clear:both; height:20px;"></div>
								<div align="center" style="margin:5px auto 10px auto;">
								<input type="button" value="Cerrar" onclick="closeWindow();" style="padding:2px 5px 2px 5px; float:none;" />
								</div>
						</td>
                </tr>
</table>


		</form>
    </div><!-- end for frm busqueda-->
                                   
				<!-- end for center-->
			 