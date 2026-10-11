
<select name="<?php echo $name; ?>" id="<?php echo $name; ?>"  class="form-control" >
    <option value="">::Seleccione::</option>
    <?php foreach ($rows as $key => $value) { ?>
        <?php if ($code != $value[0] ) { ?>
    <option value="<?php echo $value[0]; ?>"> <?php echo strtoupper($value[1].' - '.$value[2]) ?> </option>
        <?php } else { ?>
            <option selected="selected" value="<?php echo $value[0]; ?>"> <?php echo $value[1].' - '.$value[2]; ?> </option>
        <?php }  ?>
    <?php } ?>
</select>
