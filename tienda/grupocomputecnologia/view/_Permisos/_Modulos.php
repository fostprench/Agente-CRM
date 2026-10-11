<form id="frmpermisos" name="frmpermisos" action="">

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
				<input type="checkbox" id="checkTodos"> MARCAR/DESMARCAR TODOS
	</div>			
</div>

<input name="id_perfil" id="id_perfil" type="hidden" value="<?php echo $id_perfil;?>">
<table class="table">
<tr style="background-color: #428bca; color:#fff;">
    <td align="center">&nbsp;MODULOS DEL SISTEMA</td>
   <td ><a href="" title="acceder"><img alt='a' src='web/images/acceder.png' style='border: 0'/></a></td>
   <td ><a href="" title="insertar"><img alt='a' src='web/images/add.png' style='border: 0'/></td>
   <td ><a href="" title="editar"><img alt='a' src='web/images/edit.png' style='border: 0'/></td>
   <td ><a href="" title="eliminar"><img alt='a' src='web/images/delete.png' style='border: 0'/></td>
</tr>

<?php
  $c=0;
   foreach($mod as $valor){
   $c=$c+1;
 ?>
<tr style='border-bottom:1px solid #666; background:#F5F5F5' 
onMouseOver="this.style.backgroundColor='#CCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#F5F5F5'" >
   <td style='text-align:left'><input type='hidden' name="codigo[]" id="codigo[]" value="<?php echo $valor['idmodulo']?>"/>
   <?php if($valor['idpermiso']=="")
	 {
	 $valor['idpermiso']=0;
	 }?>
   <input type='hidden' name="idpermiso[]" id="idpermiso[]" value="<?php echo $valor['idpermiso']?>" />
   <?php echo str_pad($c , 2 , "0", 0); ?>.<b><?php echo $valor['descripcion']?></b></td>
   <td>
    <?php if($valor['acceder']==1)
    {
     $checka="checked='checked'";
     }else  {$checka="";}?>
   <input type="checkbox" name="acceder[]" id="acceder[]" <?php echo $checka;?>/>
   </td>
   <td>
   <?php if($valor['insertar']==1)
    {
      $checki ="checked='checked'";
     }else {$checki="";}?>
    <input type="checkbox" name="insertar[]" id="insertar[]"  <?php echo $checki;?>/>
    </td>
    <td> <?php if($valor['modificar']==1)
    {
      $checkm ="checked='checked'";
     }else { $checkm="";}?>
    <input type="checkbox" name="modificar[]" id="modificar[]"  <?php echo $checkm;?>/>
	</td>
   <td>
     <?php if($valor['eliminar']==1)
    {
      $checke ="checked='checked'";
     }else { $checke="";}?>
    <input type="checkbox" name="eliminar[]" id="eliminar[]" <?php echo $checke;?>/>
   </td>
</tr>
<?php
$d = 0;
      foreach($valor['hijos'] as $valor2)
     {
	   if($valor2['idpermiso']=="")
	   {
	    $valor2['idpermiso']=0;
	    }
	  $d++;
	 ?>
	 <tr style='border-bottom:1px solid #666; background:#F5F5F5' 
onMouseOver="this.style.backgroundColor='#CCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#F5F5F5'" >
	 
	  <td style='text-align:left;padding-left:10px;'>&nbsp;&nbsp;&nbsp;<input type='hidden' name='codigo[]' id="codigo[]" value="<?php echo $valor2['idmodulo']?>" />
	   <input type='hidden' name="idpermiso[]" id="idpermiso[]" value="<?php echo $valor2['idpermiso']?>" />
	  <?php echo $c.".".$d." "; ?>.<?php echo $valor2['descripcion']?></td>
	   <td>
      <?php if($valor2['acceder']==1)
       {
        $checkaa ="checked='checked'";
       }else { $checkaa="";}?>
      <input type="checkbox" name="acceder[]" id="acceder[]" <?php echo $checkaa;?>/>
      </td>
	   <td>
      <?php if($valor2['insertar']==1)
      {
      $checkii ="checked='checked'";
      }else  {$checkii="";}?>
       <input type="checkbox" name="insertar[]" id="insertar[]" <?php echo $checkii;?>/>
      </td>
	   <td> <?php if($valor2['modificar']==1)
    {
      $checkmm ="checked='checked'";
     }else  {$checkmm="";}?>
    <input type="checkbox" name="modificar[]" id="modificar[]"  <?php echo $checkmm;?>/>
	</td>
	 <td>
     <?php if($valor2['eliminar']==1)
    {
      $checkee ="checked='checked'";
     }else  {$checkee="";}?>
    <input type="checkbox" name="eliminar[]" id="eliminar[]"<?php echo $checkee;?>/>
   </td>
	 </tr>
	 <?php
     }?>
  
  <?php

  } ?>
  </form>
  
  <script>
  		$("#checkTodos").change(function () {
			  $("input:checkbox").prop('checked', $(this).prop("checked"));
		 });
  </script>