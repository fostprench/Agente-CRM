<table border="0" style=" margin: 0 auto;" >
    <tbody>
        <tr>            
            <?php foreach ($rows as $key => $value) { ?>
                <?php if ($value['active']==0) { ?>
            <td>
			<?php if($order==""){?>
            <a href="javascript:_paginacion('<?php echo $url;?>&q=<?php echo $query;?>&p=<?php echo $value['value'];?>&order=<?php echo $order;?>');" class="links">
              <?php }else
			  {?>
			   <a href="javascript:_order('<?php echo $order;?>','<?php echo $url;?>&q=<?php echo $query;?>&p=<?php echo $value['value'];?>');" class="links">
			        
					   <?php }
                            switch ($value['type']) {
                                case 1:
                                    echo $value['value'];
                                    break;
                                case 2:
                                    echo 'Anterior';
                                    break;
                                case 3:
                                    echo 'Siguiente';
                                    break;
                                default:
                                    break;
                            }
                        ?>
                    </a>
                </td>
                <?php } else { ?>
                <td>
                    <span class="links activo" ><?php echo $value['value']; ?></span>
                 </td>
                <?php }  ?>

            <?php } ?>
        </tr>
    </tbody>
</table>
