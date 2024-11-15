<?php
   if (!is_null($oModelForm)) {
      ?>
      <div id="id">
         <?php echo $oModelForm->id; ?>
      </div>
      <div id="first_name">
         <?php echo $oModelForm->first_name; ?>
      </div>
      <div id="middle_name">
         <?php echo $oModelForm->middle_name; ?>
      </div>
      <div id="last_name">
         <?php echo $oModelForm->last_name; ?>
      </div>
      <div id="identification">
         <?php echo $oModelForm->identification; ?>
      </div>
      <div id="business">
         <?php echo $oModelForm->business; ?>
      </div>
      <div id="comments">
         <?php echo $oModelForm->comments; ?>
      </div>
      <?php
   }
   else { ?><div id="aj:no_replace_no_afteraction" /><?php }
   
exit;
?>

