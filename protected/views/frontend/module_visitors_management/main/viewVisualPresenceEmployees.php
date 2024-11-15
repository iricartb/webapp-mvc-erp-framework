<script type="text/javascript">jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady('.item-image-fade-round-border', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>', 1.0, 1000, 0.3, 1000, true, true, true, 0.3, 0); jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady('.item-image-fade-20-round-border', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0);</script>

<?php
$i = 0;
$sActionClickSentence = FString::STRING_EMPTY;
$sStyle = FString::STRING_EMPTY;

foreach ($oModelForm as $oEmployee) {
   if ($i == 0) { ?>
   <div class="first_row">
   <?php } else if (($i % 5) == 0) { ?>
   <div class="row">
   <?php } ?>

   <?php if (($i != 0) && (((($i + 1) % 5) == 0) || (($i + 1) == count($oModelForm)))) { ?>
   <div class="last_cell">   
   <?php } else { ?>
   <div class="cell">   
   <?php } ?>
   
      <?php 
      if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->show_checkin_manual)) {
         $sActionClickSentence = "onclick=\"window.location.href = '" . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/updateVisualPresence', array('nIdForm'=>$oEmployee->id)) . "'\"";
         $sStyle = 'cursor:pointer;';
      }
      ?>
      
      <div id="id_item_<?php echo $i; ?>" <?php echo $sActionClickSentence;?> style="<?php echo $sStyle;?>">
         <div class="item-image">
            <?php 
               if (strlen($oEmployee->image) > 0) $sSourceImage = FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oEmployee->image;
               else if ($oEmployee->inside) $sSourceImage = FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . 'anonymous_inside.png';
               else $sSourceImage = FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . 'anonymous.png';
            
			   $oAccessControlCheckin = AccessControlCheckInManual::getLastAccessControlCheckinByEmployee($oEmployee->identification);
			   $sInformation = FString::STRING_EMPTY;
			   
			   if (!is_null($oAccessControlCheckin)) {
			      $sInformation = FDate::getTimeZoneFormattedDate($oAccessControlCheckin->date, true);  
			   }			
			?>
			
            <?php if ($oEmployee->inside) { ?> 
			   
               <img class="item-image-normal-round-border" src="<?php echo $sSourceImage;?>" width="124px" height="100px" title="<?php echo $sInformation; ?>">
            <?php } else { ?>      
               <img class="item-image-fade-round-border" src="<?php echo $sSourceImage;?>" width="124px" height="100px" title="<?php echo $sInformation; ?>">
            <?php } ?>
         </div>
         <div class="item-image-description-center" style="font-size:12px">
            <?php echo $oEmployee->first_name . FString::STRING_SPACE . $oEmployee->middle_name; ?>
         </div>
      </div>
   </div>
   
   <?php if (($i != 0) && (((($i + 1) % 5) == 0) || (($i + 1) == count($oModelForm)))) { ?>
   </div>
   <?php } ?>
   
   <?php
   $i++; 
} ?>