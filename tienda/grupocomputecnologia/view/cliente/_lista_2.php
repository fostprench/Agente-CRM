<script type="text/javascript" src="../web/js/funciones.js"></script>
<script type="text/javascript">
	$(function(){
    	$( "#q" ).focus();
		$("#save").click(function()
		{
		  $("#result").slideUp();
		  $.post('index.php','controller=cliente&action=_frmext',function(data)
		  {
		   $("#res").empty().append(data);
		  });
		  $("#res").slideDown();
		   document.getElementById("save").style.visibility="hidden";
		
		});
		
    });
</script>
<?php  
$cont=0;
foreach($rows as $key => $val)
		{
		   $cont++;
		}
	//	echo "cont".$cont;
		?>

<div class='ui-widget-header'>Clientes</div>
<div id="frmtotal">
	<div id="msg" ></div>
	<form id="_form_1" name="_form_1" action="" method="GET">
		<input type="hidden" name="controller" value="cliente" />
        <input type="hidden" name="action" value="mostrar" />
		<input type="hidden" name="p" value="1" />
        <input type="text" name="q" id="q" class="input_text ui-widget-content " value="" style="width: 360px; margin-left: 3px; margin-top: 5px; margin-bottom: 3px; " />
        <input type="submit" value="Buscar"/>
		<?php
		if($cont==0)
		{?>
		<input type="button" name="save" id="save" value="nuevo"/>
		<?php 
		}
		?>
	</form>
	<table  id="result" width="98%" style="border:1px solid #666; font-size:14px; margin-bottom:5px;" align="center">
		<thead>
			<?php
			foreach ($cabecera as $c)
			{
				echo "<th align='left' class='ui-widget-header'>".$c."</th>";
			}
			?>
			<th align="center" width="30" class="ui-widget-header">ok</th>
		</thead>
		<?php  foreach($rows as $key => $val)
		{?>
		<tr style="border-bottom:1px solid #666; background:#F0F0F0;">

			<td align="left"><?php  echo $val[0]; ?></td>
			<td align="left"><?php  echo $val[1]; ?></td>
			<td align="left"><?php  echo $val[2]; ?></td>
			<td align="left"><?php  echo $val[3]; ?></td>
			<td align="center"><a href="javascript:devolver_cliente_venta('<?php  echo $val[0]; ?>','<?php  echo $val[2]; ?>');" title="devolver"><img src="web/images/accept.png"  border="0"></a></td>
		</tr>
			<?php }?>
	</table>
	<div id="res" style="display:none;">
	
	</div>
	<?php echo $pag;?>
</div>