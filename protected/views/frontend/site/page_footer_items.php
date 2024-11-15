<?php $sUser = FString::STRING_EMPTY; ?>

<div id="id_page_footer_items">
   <div class="footer_items">
      <div class="footer_item">
         <div class="footer_item_text">
            &copy <?php echo Yii::app()->params['companyName']; ?>
         </div>
      </div>

      <div class="footer_item">
         <div class="footer_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
   
      <div class="footer_item">
         <div class="footer_item_text">
            <?php echo Yii::app()->params['companyPhone']; ?>
         </div>
      </div>

      <div class="footer_item">
         <div class="footer_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <div class="footer_item">
         <div class="footer_item_text">
            <?php echo Yii::app()->params['companyMail']; ?>
         </div>
      </div>
      
      <div class="footer_item">
         <div class="footer_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <div class="footer_item">
         <div class="footer_item_text">
            <?php echo php_uname('s') . FString::STRING_SPACE . php_uname('n') . FString::STRING_SPACE . php_uname('v'); ?>
         </div>
      </div>
      
      <div class="footer_item">
         <div class="footer_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <div class="footer_item">
         <div class="footer_item_text">
            <?php echo Yii::app()->params['applicationName'] . ' - ' . Yii::app()->params['applicationVersion']; ?>
         </div>
      </div>
   </div>
</div>