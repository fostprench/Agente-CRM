<!----
<script type="text/javascript" src="../web/js/funciones.js"></script>
<script>
	$(function(){
		$("#Buscar").click(function(e)
		{
		  q = $("#q").val();
		  if(q==''){$("#q").focus(); PreventDefault(e);}
		  $("#emergente").load("index.php?controller=Cliente&action=mostrar&q="+q, function(){
			$.blockUI({
				message: $("#emergente"),
				css:{
					top: '2%',
					width: '60%',
					height: '80%',
					left: '25%'
				 }
			}); 
		});
		  
		});
		
    });
</script>
<?php  
$cont=0;
foreach($rows as $key => $val)
		{
		   $cont++;
		}
?>
 
<div class='ui-widget-header' style='text-align:center;color:white;'>Clientes Registrados</div>
<div id="frmtotal">
	<div id="msg" ></div>
	<form id="_form_1" name="_form_1" action="#" method="GET" style="text-align: center;">
		<input type="hidden" name="controller" value="Cliente" />
        <input type="hidden" name="action" value="mostrar" />
		<input type="hidden" name="p" value="1" />
        <input type="text" name="q" id="q" class="input_text ui-widget-content " value="<?php echo $query;?>" style="width: 70%; margin-left: 3px; margin-top: 5px; margin-bottom: 3px; " />
        <input type="button" value="Buscar" name="Buscar" id="Buscar"/>
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
			<td align="center"><a href="javascript:devolver_cliente('<?php  echo $val[0]; ?>','<?php  echo $val[1]; ?>','<?php  echo $val[2]; ?>','<?php  echo $val[3]; ?>');" title="devolver"><img src="web/images/accept.png"  border="0"></a></td>
		</tr>
			<?php }?>
	</table>
	<div id="res" style="display:none;">
	
	</div>
	<?php echo $pag;?>
</div>
<div style="clear:both; height:20px;"></div>
<div align="center" style="margin:5px auto 10px auto;">
<input type="button" value="Cerrar" onclick="closeWindow();" style="padding:2px 5px 2px 5px; float:none;" />
</div>