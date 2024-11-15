<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-notice">
       <?php echo Yii::app()->user->getFlash('error_header') . '<font id="id_flash_show_details_btn" class="show_details_btn" onclick="expandCollapseChangeText(\'id_flash_show_details_btn\', \'' . Yii::t('system', 'SYS_SHOW_DETAILS') . '\', \'' . Yii::t('system', 'SYS_HIDE_DETAILS') . '\'); jquerySimpleAnimationExpandCollapse(\'#id_flash_errors_detail_content_expand_collapse\');">' . Yii::t('system', 'SYS_SHOW_DETAILS') . '</font>';?>
      </div>
      <div id="id_flash_errors_detail_content_expand_collapse" class="flash-error-hidden">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>