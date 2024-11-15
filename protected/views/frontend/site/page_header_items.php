<?php $sUser = FString::STRING_EMPTY; ?>

<div id="id_page_header_items">
   <div class="header_logo">
      <?php if (Application::getAppBusinessLogoImage() != null) { ?>
            <div class="header_item_bottom">
                <div class="header_logo_image">
                   <img src="<?php echo Application::getAppBusinessLogoImage();?>" height="35px"/>
                </div>
            </div>
            <?php if (strlen(Application::getAppBusinessText()) > 0) { ?>
               <?php if (strlen(Application::getAppBusinessTextDetail()) > 0) $vAlign = 'bottom';
                     else $vAlign = 'middle'; ?>
                     
               <div class="header_item_<?php echo $vAlign; ?>"> 
                  <div class="header_logo_text">
                     <?php echo Application::getAppBusinessText(); ?>
                  </div>
                  <?php if (strlen(Application::getAppBusinessTextDetail()) > 0) { ?>
                     <div class="header_logo_text_detail">
                        <?php echo Application::getAppBusinessTextDetail(); ?>
                     </div>
                  <?php } ?>
               </div>
            <?php } ?>
      <?php } ?>
   </div>
   <div class="header_items">
      <div class="header_item">
         <div class="header_item_image">
             <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/header_item_user.png';?>" />
         </div>
         <div class="header_item_text">
            <?php echo $this->sLoginUserName; ?>
         </div>
      </div>

      <div class="header_item">
         <div class="header_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
   
      <?php
      $sEmployeeDepartment = FString::STRING_EMPTY;
      
      $oUser = Users::getUser(Yii::app()->user->id);
      if (!is_null($oUser)) {
         $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
         if (!is_null($oEmployee)) {                                           
            $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
            if (!is_null($oEmployeeDepartment)) {
               if (!FString::isNullOrEmpty($oEmployeeDepartment->responsability)) $sEmployeeDepartment = $oEmployeeDepartment->responsability . '_' . $oEmployeeDepartment->department;
               else $sEmployeeDepartment = $oEmployeeDepartment->department;   
            }
         }
      }
      
      if (!FString::isNullOrEmpty($sEmployeeDepartment)) { ?>
         <div class="header_item">
            <div class="header_item_image">
                <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/header_item_department.png';?>" />
            </div>
            <div class="header_item_text">
               <?php echo Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $sEmployeeDepartment); ?>
            </div>
         </div>

         <div class="header_item">
            <div class="header_item_separator">
               <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
            </div>
         </div>
      <?php
      }
      ?>
      
      <div class="header_item">
         <div class="header_item_image">
             <?php
             $oUnreadEventsUser = EventsUsers::getEventsUsers($oUser->id, null, false);
             if (count($oUnreadEventsUser) > 0) $sCssColor = 'color_red';
             else $sCssColor = 'color_white';
             ?>
             <a href="<?php echo Yii::app()->controller->createUrl('frontend/site/viewEventsNotifications');?>" rel="fancybox" style="text-decoration:none">
                <div class="header_item_notification_number <?php echo $sCssColor; ?>">
                   <?php echo count($oUnreadEventsUser); ?>
                </div>

                <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/header_item_notifications.png';?>" />
             </a> 
         </div>
         <div class="header_item_text" style="vertical-align:bottom">
            <?php 
            $sNotifyEventsUrl = 'window.location = \'' . Yii::app()->controller->createUrl('frontend/site/changeStateEventsNotification') . '\'';
            if ($oUser->notify_events) $sStateNotifyEvents = '<font style="color:green; font-weight:bold; cursor:pointer" onclick="' . $sNotifyEventsUrl . '">' . Yii::t('system', 'SYS_NOTIFICATIONS_ENABLED') . '</font>';
            else $sStateNotifyEvents = '<font style="color:red; font-weight:bold; cursor:pointer" onclick="' . $sNotifyEventsUrl . '">' . Yii::t('system', 'SYS_NOTIFICATIONS_DISABLED') . '</font>';
            
            echo Yii::t('rainbow', 'MODEL_USERS_FIELD_NOTIFYEVENTS') . ': ' . $sStateNotifyEvents; ?>
         </div>
      </div>

      <div class="header_item">
         <div class="header_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <div class="header_item">
         <div class="header_item_image">
             <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/header_item_scene.png';?>" />
         </div>
         <div class="header_item_text">
            <a href="<?php echo Yii::app()->controller->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewScene');?>" rel="fancybox_maxPopup">
               <?php echo Yii::t('frontend', 'HEADER_MENU_ITEM_SCENE'); ?>
            </a>
         </div>
      </div>
    
      <div class="header_item">
         <div class="header_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <div class="header_item">
         <div class="header_item_image">
             <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/header_item_credentials.png';?>" />
         </div>
         <div class="header_item_text">
            <a href="<?php echo Yii::app()->controller->createUrl('frontend/site/updateCredentials');?>" rel="fancybox_minPopup">
               <?php echo Yii::t('frontend', 'HEADER_MENU_ITEM_CREDENTIALS'); ?>
            </a>
         </div>
      </div>
      
      <div class="header_item">
         <div class="header_item_separator">
            <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'tool_separator_1.png';?>" />
         </div>
      </div>
      
      <?php 
      if (!is_null($oUser)) { 
         $sLanguage = $oUser->language;
      }
      else $sLanguage = FApplication::LANGUAGE_ES;
      ?>
      
      <div class="header_item">
         <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('frontend/site/changeLanguage', array('sLanguage'=>Yii::t('system', 'SYS_LANGUAGE_ES_ABBREVIATION'))) . '\''; ?>      
         <?php echo FWidget::showButton('language' .  Yii::t('system', 'SYS_LANGUAGE_ES_ABBREVIATION'), Yii::t('system', 'SYS_LANGUAGE_ES_ABBREVIATION'), $sAction, ($sLanguage == FApplication::LANGUAGE_ES)); ?>
      </div>
      <div class="header_item">
         <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('frontend/site/changeLanguage', array('sLanguage'=>Yii::t('system', 'SYS_LANGUAGE_CA_ABBREVIATION'))) . '\''; ?>      
         <?php echo FWidget::showButton('language' . Yii::t('system', 'SYS_LANGUAGE_CA_ABBREVIATION'), Yii::t('system', 'SYS_LANGUAGE_CA_ABBREVIATION'), $sAction, ($sLanguage == FApplication::LANGUAGE_CA)); ?>
      </div>   
   </div>
</div>