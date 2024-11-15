<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/commands.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_COMMANDS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_DESCRIPTION'); ?>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_SETDATETIME'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandDateTime = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_SETDATETIME') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandDateTime') . '\' }';
            echo FWidget::showIconImageButton('commandDateTime', 'time.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_SETDATETIME'), $sActionCommandDateTime, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_OPENDOORS'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandOpenDoors = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_OPENDOORS') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandOpenDoors') . '\' }';
            echo FWidget::showIconImageButton('commandOpenDoors', 'open_door.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_OPENDOORS'), $sActionCommandOpenDoors, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_LOCKDOORS'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandLockDoors = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_LOCKDOORS') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandLockDoors') . '\' }';
            echo FWidget::showIconImageButton('commandLockDoors', 'lock.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_LOCKDOORS'), $sActionCommandLockDoors, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_UNLOCKDOORS'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandUnlockDoors = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_UNLOCKDOORS') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandUnlockDoors') . '\' }';
            echo FWidget::showIconImageButton('commandUnlockDoors', 'unlock.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_UNLOCKDOORS'), $sActionCommandUnlockDoors, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_FREEOUT'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandFreeOut = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_FREEOUT') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandFreeOut') . '\' }';
            echo FWidget::showIconImageButton('commandFreeOut', 'free_out.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_FREEOUT'), $sActionCommandFreeOut, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

<div class="form_content">
   <div class="first_row">
      <div class="cell_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_HEADER_UNFREEOUT'); ?>
      </div>
   </div>
   <div class="row">
      <div class="last_cell">
         <?php
            $sActionCommandUnfreeOut = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_CONFIRMATION_UNFREEOUT') . '\')) { window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/updateCommandUnfreeOut') . '\' }';
            echo FWidget::showIconImageButton('commandUnfreeOut', 'unfree_out.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCOMMANDS_FORM_BUTTON_UNFREEOUT'), $sActionCommandUnfreeOut, false, '12px', '18px', '48x48');
         ?>
      </div>
   </div>
</div>

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
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>