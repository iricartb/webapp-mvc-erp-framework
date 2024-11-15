<?php $this->pageTitle = Yii::app()->name . ' - Error'; ?>

<?php if (!$deleteRecord) { ?>
   <div id="div_error_container_header">
      <div id="div_error_container_header_text">
         Error <?php echo $code; ?>
      </div>
   </div>
   <div id="div_error_container_body">
      <div id="div_error_container_body_box">
         <div id="div_error_container_body_box_image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SITE;?>exclamation.png" />
         </div>
         <div id="div_error_container_body_box_text">
            <div class="error">
               <?php echo CHtml::encode($message); ?>
            </div>
         </div>
      </div>
   </div>
<?php } else { ?>
   <div id="div_error_delete_record_container_header">
      <div id="div_error_delete_record_container_header_text">
         <?php echo $code; ?>
      </div>
   </div>
   <div id="div_error_delete_record_container_body">
      <div id="div_error_container_body_box">
         <div id="div_error_container_body_box_image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SITE;?>information.png" />
         </div>
         <div id="div_error_container_body_box_text">
            <div class="error">
               <?php echo CHtml::encode($message); ?>
            </div>
         </div>
      </div>
   </div>
<?php } ?>