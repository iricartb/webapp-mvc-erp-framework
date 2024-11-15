<?php

class MainController extends FrontendController {

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewScene', 'viewDetailFormTask'),
            'expression'=>'((Users::getNumAvaliableModulesForUser(Yii::app()->user->id) > 0) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)))',
         ),
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewFormsTasks', 'viewAttachmentFormTask', 'viewFormsDailyEvents', 'viewDetailFormDailyEvent', 'viewDetailFormDailyEventLine'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)',
         ),  
         array('allow', // allow authenticated user and have valid module roles to perform actions                                                                                                                                          
            'actions'=>array('createFormTask', 'updateFormTask', 'updateFormDailyEvent', 'updateFormDailyEventLine', 'refreshFormTaskRegions', 'refreshFormTaskEquipments', 'refreshFormTaskSupplies', 'refreshFormTaskComponents', 'refreshFormTaskStatus', 'deleteFormTask', 'deleteFormTaskSupply', 'deleteFormTaskEmployee', 'deleteFormTaskWorkingPart', 'deleteFormDailyEvent', 'deleteFormDailyEventLine'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)))',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   
   public function actionViewScene() {
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewBuildScene&bReadOnly=1'));
	}
   public function actionViewFormsTasks() {
      $oMaintenanceFormTask = new MaintenanceFormsTasks();

      // Delete incomplete forms
      $oMaintenanceFormsTasks = MaintenanceFormsTasks::getMaintenanceFormsTasks(false, Yii::app()->user->id);
      foreach($oMaintenanceFormsTasks as $oMaintenanceFormTask) {
        
         $nIdMaintenanceFormTask = $oMaintenanceFormTask->id;
         if ($oMaintenanceFormTask->delete()) {
            if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
               $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
               foreach($oFormsWorkingParts as $oFormWorkingPart) $oFormWorkingPart->delete();
               
               $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
               foreach($oFormsMaintenanceWorkingParts as $oFormMaintenanceWorkingPart) $oFormMaintenanceWorkingPart->delete();
            
               $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts(null, null, $nIdMaintenanceFormTask);
               foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) $oFormSpecialWorkingPart->delete();
            }
         } 
      }
      
      $oMaintenanceFormTask->unsetAttributes();
      $oMaintenanceFormTask->sFilterStatusPending = true;
      $oMaintenanceFormTask->sFilterStatusRunning = true;
      
      // Filters Grid Get Parameters
      if (isset($_GET['MaintenanceFormsTasks'])) {
         $oMaintenanceFormTask->attributes = $_GET['MaintenanceFormsTasks'];
         if (isset($_GET['MaintenanceFormsTasks']['start_date'])) $oMaintenanceFormTask->start_date = $_GET['MaintenanceFormsTasks']['start_date'];
         if (isset($_GET['MaintenanceFormsTasks']['sFilterStatusPending'])) $oMaintenanceFormTask->sFilterStatusPending = $_GET['MaintenanceFormsTasks']['sFilterStatusPending'];
         if (isset($_GET['MaintenanceFormsTasks']['sFilterStatusRunning'])) $oMaintenanceFormTask->sFilterStatusRunning = $_GET['MaintenanceFormsTasks']['sFilterStatusRunning'];
         if (isset($_GET['MaintenanceFormsTasks']['sFilterStatusFinalized'])) $oMaintenanceFormTask->sFilterStatusFinalized = $_GET['MaintenanceFormsTasks']['sFilterStatusFinalized'];
      }

      $this->render('viewFormsTasks', array('oModelForm'=>$oMaintenanceFormTask)); 
   }
   public function actionViewAttachmentFormTask($nIdForm) {
     $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
     
     if (!is_null($oMaintenanceFormTask)) {
        if ((!FString::isNullOrEmpty($oMaintenanceFormTask->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $oMaintenanceFormTask->attachment))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oMaintenanceFormTask->attachment, '.'), '.' . FString::getLastToken($oMaintenanceFormTask->attachment, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $oMaintenanceFormTask->attachment));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewFormsDailyEvents() {
      $oMaintenanceFormDailyEvent = new MaintenanceFormsDailyEvents();
      $oMaintenanceFormDailyEventFilters = new MaintenanceFormsDailyEvents();
      $oMaintenanceFormDailyEventFilters->unsetAttributes();
      $bError = false;
       
      // Ajax validation request=>Conditional validator
      FForm::validateAjaxForm('maintenance-form-daily-event-form', $oMaintenanceFormDailyEvent);
      
      if ((isset($_POST['MaintenanceFormsDailyEvents'])) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {  
         $oMaintenanceFormDailyEvent->attributes = $_POST['MaintenanceFormsDailyEvents'];
         
         $oMaintenanceFormDailyEvent->date = FDate::getEnglishDate($_POST['MaintenanceFormsDailyEvents']['date']);
            
         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceFormDailyEvent->owner = $sCurrentUser;
         else $bError = true;
      
         if (!$bError) {
            $oMaintenanceFormDailyEventUnique = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEventByAttributes($oMaintenanceFormDailyEvent->date, $oMaintenanceFormDailyEvent->owner);
            
            if (is_null($oMaintenanceFormDailyEventUnique)) {
               $oMaintenanceFormDailyEvent->save();
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else {
         if (isset($_POST['MaintenanceFormsDailyEvents'])) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
         else { 
            // Filters Grid Get Parameters
            if (isset($_GET['MaintenanceFormsDailyEvents'])) $oMaintenanceFormDailyEventFilters->attributes = $_GET['MaintenanceFormsDailyEvents'];
         }
      }
      
      $oMaintenanceFormDailyEvent->unsetAttributes(); 
      $this->render('viewFormsDailyEvents', array('oModelForm'=>$oMaintenanceFormDailyEvent, 'oModelFormFilters'=>$oMaintenanceFormDailyEventFilters)); 
   }
   
   
   public function actionViewDetailFormTask($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
        
      if (!is_null($oMaintenanceFormTask)) $this->render('viewDetailFormTask', array('oModelForm'=>$oMaintenanceFormTask));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormDailyEvent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEvent($nIdForm);

      if (!is_null($oMaintenanceFormDailyEvent)) $this->render('viewDetailFormDailyEvent', array('oModelForm'=>$oMaintenanceFormDailyEvent));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormDailyEventLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceFormDailyEventLine = MaintenanceFormDailyEventLines::getMaintenanceFormDailyEventLine($nIdForm);

      if (!is_null($oMaintenanceFormDailyEventLine)) $this->render('viewDetailFormDailyEventLine', array('oModelForm'=>$oMaintenanceFormDailyEventLine));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionCreateFormTask($nIdZone = null, $nIdRegion = null, $nIdEquipment = null) {
      $oMaintenanceFormTask = new MaintenanceFormsTasks();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceFormTask->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oMaintenanceFormTask->name = FString::STRING_EMPTY;
         $oMaintenanceFormTask->task = FString::STRING_EMPTY;
         $oMaintenanceFormTask->priority = FString::STRING_EMPTY;
         $oMaintenanceFormTask->priority_number = 0;
         $oMaintenanceFormTask->status = FModulePlantMaintenanceManagement::STATUS_PENDING;
         $oMaintenanceFormTask->start_date = date('Y-m-d H:i:s');
         $oMaintenanceFormTask->id_user = Yii::app()->user->id;
         $oMaintenanceFormTask->admin = Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
   
         if (!FString::isNullOrEmpty($nIdZone)) {
            $oZone = Zones::getZone($nIdZone);
            if (!is_null($oZone)) $oMaintenanceFormTask->id_zone = $oZone->id;
         }
         if (!FString::isNullOrEmpty($nIdRegion)) {
            $oRegion = Regions::getRegion($nIdRegion);
            if (!is_null($oRegion)) $oMaintenanceFormTask->id_region = $oRegion->id;
         }
         if (!FString::isNullOrEmpty($nIdEquipment)) { 
            $oEquipment = Equipments::getEquipment($nIdEquipment);  
            if (!is_null($oEquipment)) $oMaintenanceFormTask->id_equipment = $oEquipment->id; 
         }
            
         if ($oMaintenanceFormTask->save(false)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$oMaintenanceFormTask->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   
   
   public function actionRefreshFormTaskRegions($nIdForm, $nIdZone) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
         
         if (!is_null($oMaintenanceFormTask)) {
            $this->layout = null;
            $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskEquipments') . '&nIdForm=' . $oMaintenanceFormTask->id . '&nIdRegion=';
            $sRefreshEquipmentsUrl = "aj('" . $sRefreshEquipmentsUrl . "' + this.value, null, 'id_equipment')";              

            $sJsRefreshDisappearEquipmentOthers = "$('#MaintenanceFormsTasks_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
            $sJsRefreshComponentClear = "$('#MaintenanceFormsTasks_sComponents option').remove()";
                                 
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshDisappearEquipmentOthers . ';' . $sRefreshEquipmentsUrl . ';' . $sJsRefreshComponentClear . ';' . "\" name=\"MaintenanceFormsTasks[id_region]\" id=\"MaintenanceFormsTasks_id_region\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdZone)) {
               $oZonesRegions = ZonesRegions::getZonesRegionsByIdZone($nIdZone);
               
               foreach($oZonesRegions as $oZoneRegion) {
                  $oRegion = Regions::getRegion($oZoneRegion->id_region);
                  if (!is_null($oRegion)) {
                     $sContent .= "<option value=\"" . $oRegion->id . "\">" . $oRegion->name . "</option>";    
                  }
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormTaskEquipments($nIdForm, $nIdRegion) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
         
         if (!is_null($oMaintenanceFormTask)) {
            $this->layout = null;
            $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskComponents') . '&nIdForm=' . $oMaintenanceFormTask->id . '&nIdEquipment=';
            $sRefreshComponentsUrl = "aj('" . $sRefreshComponentsUrl . "' + this.value, null, 'MaintenanceFormsTasks_sComponents')";              
            
            $sJsRefreshEquipmentOthers = "$('#MaintenanceFormsTasks_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
                                    
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshEquipmentOthers . ';' . $sRefreshComponentsUrl . ';' . "\" name=\"MaintenanceFormsTasks[id_equipment]\" id=\"MaintenanceFormsTasks_id_equipment\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdRegion)) {
               $oRegionsEquipments = RegionsEquipments::getRegionsEquipmentsByIdRegion($nIdRegion);
               
               foreach($oRegionsEquipments as $oRegionEquipment) {
                  $oEquipment = Equipments::getEquipment($oRegionEquipment->id_equipment);
                  if (!is_null($oEquipment)) {
                     $sContent .= "<option value=\"" . $oEquipment->id . "\">" . $oEquipment->name . "</option>";    
                  }
               } 
               
               $sContent .= "<option value=\"" . FApplication::EQUIPMENT_OTHERS . "\">" . Yii::t('system', 'SYS_OTHERS_M') . "</option>"; 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormTaskComponents($nIdForm, $nIdEquipment) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
         
         if (!is_null($oMaintenanceFormTask)) { 
            $this->layout = null;
            $sContent = FString::STRING_EMPTY;
            $oComponents = Components::getComponents($nIdEquipment);
            
            if (!FString::isNullOrEmpty($nIdEquipment)) {
               foreach($oComponents as $oComponent) {
                  $sContent .= "<option value=\"" . $oComponent->id . "\">" . $oComponent->name . "</option>";      
               }
            }
                  
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionRefreshFormTaskSupplies($nIdForm, $nIdSubcategory) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
         
         if (!is_null($oMaintenanceFormTask)) {
            $this->layout = null;
            
            $sContent = "<select style=\"width:200px;\" name=\"MaintenanceFormTaskSupplies[id_supply]\" id=\"MaintenanceFormTaskSupplies_id_supply\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION') . "</option>";
            if (!FString::isNullOrEmpty($nIdSubcategory)) {
               $oArticles = Articles::getArticlesByIdSubcategory($nIdSubcategory);
               
               foreach($oArticles as $oArticle) {
                  $sDisableOption = FString::STRING_EMPTY;
                  if ($oArticle->quantity == 0) $sDisableOption = 'disabled';
                  
                  $sContent .= "<option value=\"" . $oArticle->id . "\"" . $sDisableOption . ">" . $oArticle->name . " (" . $oArticle->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . ")</option>";    
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormTaskStatus($nIdForm, $sStatus) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
         
         if (!is_null($oMaintenanceFormTask)) {
            if (($sStatus == FModulePlantMaintenanceManagement::STATUS_PENDING) || ($sStatus == FModulePlantMaintenanceManagement::STATUS_RUNNING) || ($sStatus == FModulePlantMaintenanceManagement::STATUS_FINALIZED)) {
               $this->layout = null;
               $sContent = FString::STRING_EMPTY;
               $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/refreshFormTaskStatus') . '&nIdForm=' . $oMaintenanceFormTask->id . '&sStatus=';
               
               // Status pending
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_PENDING) {
                  $sContent .= "<div id=\"id_item_pending\" class=\"cell\">";
               } else {
                  $sContent .= "<div id=\"id_item_pending\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModulePlantMaintenanceManagement::STATUS_PENDING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModulePlantMaintenanceManagement::STATUS_PENDING . "\'');" . "\">";
               }
               $sContent .= "<div class=\"item-image\">";
      
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_PENDING) {
                  $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
               } else {
                  $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
               }
               $sContent .= "</div>";
               
               $sContent .= "<div class=\"item-image-description-center\">";
               $sContent .= "<font color=\"" . FModulePlantMaintenanceManagement::COLOR_STATUS_PENDING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_PENDING') . "</font>";
               $sContent .= "</div></div>";
               
               // Status running
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_RUNNING) {
                  $sContent .= "<div id=\"id_item_running\" class=\"cell\">";
               } else {
                  $sContent .= "<div id=\"id_item_running\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModulePlantMaintenanceManagement::STATUS_RUNNING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModulePlantMaintenanceManagement::STATUS_RUNNING . "\'');" . "\">";
               }
               $sContent .= "<div class=\"item-image\">";
               
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_RUNNING) {
                  $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
               } else {
                  $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
               }
               $sContent .= "</div>";
               
               $sContent .= "<div class=\"item-image-description-center\">";
               $sContent .= "<font color=\"" . FModulePlantMaintenanceManagement::COLOR_STATUS_RUNNING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_RUNNING') . "</font>";
               $sContent .= "</div></div>";
               
               // Status finalized
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_FINALIZED) {
                  $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\">";
               } else {
                  $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModulePlantMaintenanceManagement::STATUS_FINALIZED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModulePlantMaintenanceManagement::STATUS_FINALIZED . "\'');" . "\">";
               }
               $sContent .= "<div class=\"item-image\">";
               
               if ($sStatus == FModulePlantMaintenanceManagement::STATUS_FINALIZED) {
                  $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
               } else {
                  $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
               }
               $sContent .= "</div>";
               
               $sContent .= "<div class=\"item-image-description-center\">";
               $sContent .= "<font color=\"" . FModulePlantMaintenanceManagement::COLOR_STATUS_FINALIZED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_FINALIZED') . "</font>";
               $sContent .= "</div></div>";
               
               $this->renderText($sContent);  
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   
   
   public function actionUpdateFormTask($nIdForm, $nAction = 0, $sIdComponents = FString::STRING_EMPTY, $sIdDepartments = FString::STRING_EMPTY) { 
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
      $bError = false;
      
      if (!is_null($oMaintenanceFormTask)) {
         $oMaintenanceFormTaskComponents = MaintenanceFormTaskComponents::getMaintenanceFormTaskComponentsByIdFormFK($oMaintenanceFormTask->id);
         $oMaintenanceFormTaskDepartments = MaintenanceFormTaskDepartments::getMaintenanceFormTaskDepartmentsByIdFormFK($oMaintenanceFormTask->id);
         $oMaintenanceFormTaskSupply = new MaintenanceFormTaskSupplies();
         $oMaintenanceFormTaskEmployee = new MaintenanceFormTaskEmployees();
         
         if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormTask($nIdForm)) {
            if (isset($_POST['MaintenanceFormsTasks'])) {
               if ($nAction == 0) {
                  FForm::validateAjaxForm('maintenance-form-task-form', $oMaintenanceFormTask);
                  
                  $sTempAttachment = $oMaintenanceFormTask->attachment;
                  $oMaintenanceFormTask->attributes = $_POST['MaintenanceFormsTasks'];
 
                  $bFormTaskLocked = (Yii::app()->user->id != $oMaintenanceFormTask->id_user);
                  if (!$bFormTaskLocked) {
                     $oIdsDepartments = explode(',', $sIdDepartments);
                     if ((count($oIdsDepartments) == 0) || ($sIdDepartments == FString::STRING_NULL)) {
                        $bError = true; 
                        Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_SUBMIT_ERROR_DEPARTMENT_NOT_SELECTED'));
                     }
                  }
                  
                  if (!$bError) {
                     if (($_POST['MaintenanceFormsTasks']['status'] == FModulePlantMaintenanceManagement::STATUS_FINALIZED) && ($_POST['MaintenanceFormsTasks']['type_task'] == FModulePlantMaintenanceManagement::TYPE_TASK_REPAIR)) {
                        if (((isset($_POST['MaintenanceFormsTasks']['failure_reason'])) && (FString::isNullOrEmpty($_POST['MaintenanceFormsTasks']['failure_reason']))) || ((isset($_POST['MaintenanceFormsTasks']['failure_solution'])) && (FString::isNullOrEmpty($_POST['MaintenanceFormsTasks']['failure_solution'])))) {
                           $bError = true; 
                           Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEFORMTASK_FORM_SUBMIT_ERROR_FINALIZE_FIELDS_EMPTY'));
                        }      
                     }
                  }

                  if (!$bError) {
                     if (isset($_POST['MaintenanceFormsTasks']['priority'])) {
                        $oMaintenancePriority = MaintenancePriorities::getMaintenancePriorityByDescription($_POST['MaintenanceFormsTasks']['priority']);
                        if (!is_null($oMaintenancePriority)) $oMaintenanceFormTask->priority_number = $oMaintenancePriority->priority;
                     }
                     
                     if (isset($_POST['MaintenanceFormsTasks']['id_zone'])) $oMaintenanceFormTask->zone = Zones::getZoneName($_POST['MaintenanceFormsTasks']['id_zone']);
                     if (isset($_POST['MaintenanceFormsTasks']['id_region'])) $oMaintenanceFormTask->region = Regions::getRegionName($_POST['MaintenanceFormsTasks']['id_region']);
                     if (isset($_POST['MaintenanceFormsTasks']['id_equipment'])) {
                        if ($_POST['MaintenanceFormsTasks']['id_equipment'] != FApplication::EQUIPMENT_OTHERS) {
                           $oMaintenanceFormTask->equipment = Equipments::getEquipmentName($_POST['MaintenanceFormsTasks']['id_equipment']);
                        }
                     }
                     
                     if ($_POST['MaintenanceFormsTasks']['status'] == FModulePlantMaintenanceManagement::STATUS_PENDING) {
                        $oMaintenanceFormTask->execution_date = null;
                        $oMaintenanceFormTask->end_date = null;   
                     }
                     else if ($_POST['MaintenanceFormsTasks']['status'] == FModulePlantMaintenanceManagement::STATUS_RUNNING) {
                        if (FString::isNullOrEmpty($oMaintenanceFormTask->execution_date)) $oMaintenanceFormTask->execution_date = date('Y-m-d H:i:s'); 
                        $oMaintenanceFormTask->end_date = null;      
                     }
                     else if ($_POST['MaintenanceFormsTasks']['status'] == FModulePlantMaintenanceManagement::STATUS_FINALIZED) {
                        if (FString::isNullOrEmpty($oMaintenanceFormTask->end_date)) $oMaintenanceFormTask->end_date = date('Y-m-d H:i:s');      
                     }
                     
                     if (!$bFormTaskLocked) { 
                        $oMaintenanceFormTask->attachment = null;    
                        $oFile = CUploadedFile::getInstanceByName('MaintenanceFormsTasks[attachment]');
                        if ($oFile) {
                           $sOriginalFilename = sha1_file($oFile->tempName);
                           $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                           $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                              
                           if (FFile::isCommonRedeableTextFromFileType($oFile->extensionName, true)) {  
                              $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS;
                              $sOriginalFileUrl = $sPath . $sOriginalFile;
                                       
                              if ($oFile->saveAs($sOriginalFileUrl)) {
                                 if ((!FString::isNullOrEmpty($sTempAttachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $sTempAttachment)) && ($sTempAttachment != $sOriginalFile)) {
                                    $oMaintenanceFormsTasks = MaintenanceFormsTasks::getMaintenanceFormsTasks(null, null, $sTempAttachment);
                                    if (count($oMaintenanceFormsTasks == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $sTempAttachment);
                                 } 
                                 
                                 $oMaintenanceFormTask->attachment = $sOriginalFile;
                              } 
                           }  
                        }
                     }  
                     else $oMaintenanceFormTask->attachment = $sTempAttachment; 
                     
                     $oMaintenanceModuleParameters = MaintenanceModuleParameters::getMaintenanceModuleParameters();
                     $bAllowCreateWorkingPart = false;
                     if (!is_null($oMaintenanceModuleParameters)) {
                        $bAllowCreateWorkingPart = $oMaintenanceModuleParameters->allow_create_working_part;     
                     }
                     
                     if ((!$bAllowCreateWorkingPart) && (isset($_POST['MaintenanceFormsTasks']['sWorkingPartPost'])) && (isset($_POST['MaintenanceFormsTasks']['sWorkingPartNumberPost']))) {
                        $oMaintenanceFormTask->working_part = $_POST['MaintenanceFormsTasks']['sWorkingPartPost'];
                        if ($oMaintenanceFormTask->working_part != FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE) {
                           $oMaintenanceFormTask->working_part_number = $_POST['MaintenanceFormsTasks']['sWorkingPartNumberPost'];
                           if (FString::isNullOrEmpty($oMaintenanceFormTask->working_part_number)) {
                              $oMaintenanceFormTask->working_part = FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE; 
                              $oMaintenanceFormTask->working_part_number = null;    
                           }
                        }
                        else $oMaintenanceFormTask->working_part_number = null; 
                     }
                     
                     $oMaintenanceFormTask->data_completed = true;
                     
                     if ($oMaintenanceFormTask->save()) {
                        if (($oMaintenanceFormTask->status == FModulePlantMaintenanceManagement::STATUS_FINALIZED) && (!FString::isNullOrEmpty($oMaintenanceFormTask->working_part_number))) {
                           if ($oMaintenanceFormTask->working_part == FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NORMAL) { 
                              $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($oMaintenanceFormTask->working_part_number);
                              if (!is_null($oFormWorkingPart)) {      
                                 if (FString::isNullOrEmpty($oFormWorkingPart->failure_reason)) $oFormWorkingPart->failure_reason = $oMaintenanceFormTask->failure_reason;
                                 if (FString::isNullOrEmpty($oFormWorkingPart->failure_solution)) $oFormWorkingPart->failure_solution = $oMaintenanceFormTask->failure_solution;
                                 if (FString::isNullOrEmpty($oFormWorkingPart->comments)) $oFormWorkingPart->comments = $oMaintenanceFormTask->comments;
                                 
                                 $oFormWorkingPart->save(false);  
                              }
                           }
                           else if ($oMaintenanceFormTask->working_part == FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_MAINTENANCE) {
                              $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($oMaintenanceFormTask->working_part_number);
                              if (!is_null($oFormMaintenanceWorkingPart)) {
                                 if (FString::isNullOrEmpty($oFormMaintenanceWorkingPart->failure_reason)) $oFormMaintenanceWorkingPart->failure_reason = $oMaintenanceFormTask->failure_reason;
                                 if (FString::isNullOrEmpty($oFormMaintenanceWorkingPart->failure_solution)) $oFormMaintenanceWorkingPart->failure_solution = $oMaintenanceFormTask->failure_solution;
                                 if (FString::isNullOrEmpty($oFormMaintenanceWorkingPart->comments)) $oFormMaintenanceWorkingPart->comments = $oMaintenanceFormTask->comments;
                                 
                                 $oFormMaintenanceWorkingPart->save(false);
                              }
                           }    
                        }
                        
                        if (!$bFormTaskLocked) {
                           // Delete all components
                           $oIdsComponents = explode(',', $sIdComponents); 
                           
                           $oMaintenanceFormTaskComponents = MaintenanceFormTaskComponents::getMaintenanceFormTaskComponentsByIdFormFK($oMaintenanceFormTask->id);
                           foreach($oMaintenanceFormTaskComponents as $oMaintenanceFormTaskComponent) $oMaintenanceFormTaskComponent->delete();
                         
                           foreach($oIdsComponents as $nIdComponent) {  
                              $oComponent = Components::getComponent($nIdComponent);
                              if (!is_null($oComponent)) {  
                                 $oMaintenanceFormTaskComponent = new MaintenanceFormTaskComponents();
                                 $oMaintenanceFormTaskComponent->id_component = $oComponent->id;
                                 $oMaintenanceFormTaskComponent->component = Components::getComponentName($oComponent->id);
                                 $oMaintenanceFormTaskComponent->id_form_task = $oMaintenanceFormTask->id; 
                               
                                 $oMaintenanceFormTaskComponent->save(); 
                              } 
                           }
                        
                           // Delete all departments
                           $oMaintenanceFormTaskDepartments = MaintenanceFormTaskDepartments::getMaintenanceFormTaskDepartmentsByIdFormFK($oMaintenanceFormTask->id);
                           
                           foreach($oMaintenanceFormTaskDepartments as $oMaintenanceFormTaskDepartment) $oMaintenanceFormTaskDepartment->delete();
                         
                           foreach($oIdsDepartments as $nIdDepartment) {
                              $oMaintenanceFormTaskDepartment = new MaintenanceFormTaskDepartments();
                              $oMaintenanceFormTaskDepartment->name = $nIdDepartment;
                              $oMaintenanceFormTaskDepartment->id_form_task = $oMaintenanceFormTask->id; 
                               
                              $oMaintenanceFormTaskDepartment->save();
                           }
                           
                           if (($oMaintenanceFormTask->id_user == Yii::app()->user->id) && (isset($_POST['MaintenanceFormsTasks']['bAlarm']))) {
                              if ($_POST['MaintenanceFormsTasks']['bAlarm'] == 1) {
                                 $oMaintenanceFormTaskDepartments = MaintenanceFormTaskDepartments::getMaintenanceFormTaskDepartmentsByIdFormFK($oMaintenanceFormTask->id);
                                 foreach($oMaintenanceFormTaskDepartments as $oMaintenanceFormTaskDepartment) {
                                    Events::addSystemEvent('EVENT_NEW_FORM_MAINTENANCE_TASK_TITLE', 'EVENT_NEW_FORM_MAINTENANCE_TASK', $oMaintenanceFormTask->task, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, array(array(null, $oMaintenanceFormTaskDepartment->name)));      
                                 }
                              }   
                           }
                        }
                        
                        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsTasks'));   
                     }
                  }
               }
               else if ($nAction == 1) {
                  if (FString::isNullOrEmpty($oMaintenanceFormTask->working_part_number)) {
                     FForm::validateAjaxForm('maintenance-form-task-working-part-form', $oMaintenanceFormTask); 
                     
                     $oMaintenanceFormTask->attributes = $_POST['MaintenanceFormsTasks'];
                     
                     if (isset($_POST['MaintenanceFormsTasks']['sWorkingPartPost'])) {
                        $nTypeWorkingPart = $_POST['MaintenanceFormsTasks']['sWorkingPartPost'];
                        
                        $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
                        $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                        if ($nTypeWorkingPart == FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NORMAL) {
                           $oFormWorkingPart = new FormsWorkingParts();
                           
                           if ($sCurrentUser != FString::STRING_EMPTY) $oFormWorkingPart->owner = $sCurrentUser; 
                           $oFormWorkingPart->task = $oMaintenanceFormTask->task;
                           $oFormWorkingPart->id_zone = $oMaintenanceFormTask->id_zone; 
                           $oFormWorkingPart->zone = $oMaintenanceFormTask->zone;
                           $oFormWorkingPart->id_region = $oMaintenanceFormTask->id_region;
                           $oFormWorkingPart->region = $oMaintenanceFormTask->region;
                           $oFormWorkingPart->id_equipment = $oMaintenanceFormTask->id_equipment;
                           $oFormWorkingPart->equipment = $oMaintenanceFormTask->equipment;
                           
                           $bStudioMechanical = false; $bStudioElectric = false;
                           foreach($oMaintenanceFormTaskDepartments as $oMaintenanceFormTaskDepartment) {
                              if ($oMaintenanceFormTaskDepartment->name == FApplication::EMPLOYEE_DEPARTMENT_MECHANICAL) $bStudioMechanical = true;   
                              else if ($oMaintenanceFormTaskDepartment->name == FApplication::EMPLOYEE_DEPARTMENT_ELECTRIC) $bStudioElectric = true;
                           }
                           
                           $oFormWorkingPart->equipment_studio_mechanic = $bStudioMechanical;
                           $oFormWorkingPart->equipment_studio_electric = $bStudioElectric;
                           
                           if (!is_null($oWorkingPartModuleParameters)) {
                              if ($oWorkingPartModuleParameters->working_part_show_status_created) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
                              else if ($oWorkingPartModuleParameters->working_part_show_status_pending) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING;
                              else if ($oWorkingPartModuleParameters->working_part_show_status_running) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
                              else if ($oWorkingPartModuleParameters->working_part_show_status_halted) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_HALTED;
                              else if ($oWorkingPartModuleParameters->working_part_show_status_finalized) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                              else $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;       
                           }
                           else $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         
                           $oFormWorkingPart->start_date = date('Y-m-d H:i:s');
                           $oFormWorkingPart->id_maintenance_form_task = $oMaintenanceFormTask->id;
                           $oFormWorkingPart->id_user = Yii::app()->user->id;
                           $oFormWorkingPart->data_completed = true;
                           
                           if ($oFormWorkingPart->save(false)) {
                              // Create components
                              foreach($oMaintenanceFormTaskComponents as $oMaintenanceFormTaskComponent) {
                                 $oFormWorkingPartComponent = new FormWorkingPartComponents();
                                 $oFormWorkingPartComponent->id_component = $oMaintenanceFormTaskComponent->id_component; 
                                 $oFormWorkingPartComponent->component = $oMaintenanceFormTaskComponent->component;
                                 $oFormWorkingPartComponent->id_form_working_part = $oFormWorkingPart->id;
                                 $oFormWorkingPartComponent->save();
                              }
                              
                              // Create default equipment conditions
                              $oDefaultEquipmentConditions = EquipmentConditions::getEquipmentConditions(true);
                              foreach($oDefaultEquipmentConditions as $oEquipmentCondition) {
                                 $oFormWorkingPartEquipmentCondition = new FormWorkingPartEquipmentConditions();
                                 $oFormWorkingPartEquipmentCondition->description = $oEquipmentCondition->description;
                                 $oFormWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                                 $oFormWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                                 $oFormWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                                 $oFormWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                                 $oFormWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;
                                 $oFormWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
                                 $oFormWorkingPartEquipmentCondition->value = 3;
                                 $oFormWorkingPartEquipmentCondition->id_form_working_part = $oFormWorkingPart->id;
                                 
                                 $oFormWorkingPartEquipmentCondition->save();
                              }
                              $oFormWorkingPartEquipmentCondition = new FormWorkingPartEquipmentConditions();
                              $oFormWorkingPartEquipmentCondition->description = strtoupper(FString::STRING_OTHERS);
                              $oFormWorkingPartEquipmentCondition->custom = true;
                              $oFormWorkingPartEquipmentCondition->value = 3;
                              $oFormWorkingPartEquipmentCondition->id_form_working_part = $oFormWorkingPart->id;
                              $oFormWorkingPartEquipmentCondition->save();
                              
                              // Create default measures
                              $oDefaultMeasures = Measures::getMeasures(true);
                              foreach($oDefaultMeasures as $oMeasure) {
                                 $oFormWorkingPartMeasure = new FormWorkingPartMeasures();
                                 $oFormWorkingPartMeasure->description = $oMeasure->description;
                                 $oFormWorkingPartMeasure->alert = $oMeasure->alert;
                                 $oFormWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                                 $oFormWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                                 $oFormWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                                 $oFormWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                                 $oFormWorkingPartMeasure->information = $oMeasure->information;
                                 $oFormWorkingPartMeasure->value = 3;
                                 $oFormWorkingPartMeasure->id_form_working_part = $oFormWorkingPart->id;
                                 
                                 $oFormWorkingPartMeasure->save();  
                              } 
                              $oFormWorkingPartMeasure = new FormWorkingPartMeasures();
                              $oFormWorkingPartMeasure->description = strtoupper(FString::STRING_OTHERS);
                              $oFormWorkingPartMeasure->custom = true;
                              $oFormWorkingPartMeasure->value = 3;
                              $oFormWorkingPartMeasure->id_form_working_part = $oFormWorkingPart->id;
                              $oFormWorkingPartMeasure->save();
                              
                              // Copy all Risks & Ipes of equipment
                              if ($oFormWorkingPart->id_equipment != FApplication::EQUIPMENT_OTHERS) {
                                 $oEquipment = Equipments::getEquipment($oFormWorkingPart->id_equipment);
                                 if (!is_null($oEquipment)) {
                                    $oEquipmentsRisks = EquipmentsRisks::getEquipmentsRisksByIdEquipment($oEquipment->id);
                                    foreach($oEquipmentsRisks as $oEquipmentsRisk) {
                                       $oRisk = Risks::getRisk($oEquipmentsRisk->id_risk);
                                       if (!is_null($oRisk)) {
                                          $oFormWorkingPartRisk = new FormWorkingPartRisks();
                                          $oFormWorkingPartRisk->name = $oRisk->name;
                                          $oFormWorkingPartRisk->id_form_working_part = $oFormWorkingPart->id;
                                          
                                          if ($oFormWorkingPartRisk->save()) {
                                             $oRisksIPEs = RisksIPEs::getRisksIPEsByIdRisk($oRisk->id);
                                             foreach($oRisksIPEs as $oRisksIPE) {
                                                $oIPE = IPEs::getIPE($oRisksIPE->id_ipe);
                                                if (!is_null($oIPE)) {
                                                   $oFormWorkingPartIPE = new FormWorkingPartIPEs();
                                                   $oFormWorkingPartIPE->name = $oIPE->name;
                                                   $oFormWorkingPartIPE->id_form_working_part = $oFormWorkingPart->id;
                                                   
                                                   $oFormWorkingPartIPE->save();
                                                }
                                             }
                                          } 
                                       }
                                    }
                                 }    
                              }
                              
                              // Copy employee
                              $oFormWorkingPartEmployee = new FormWorkingPartEmployees();
                              $oFormWorkingPartEmployee->name = $sCurrentUser;
                              
                              $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
                              $oFormWorkingPartEmployee->business = FString::STRING_EMPTY;
                              if ((!is_null($oEmployee)) && ($oEmployee->type == FApplication::EMPLOYEE_BUSINESS)) {
                                 $oFormWorkingPartEmployee->business = Application::getBusinessName();  
                              }
                              $oFormWorkingPartEmployee->id_form_working_part = $oFormWorkingPart->id; 
                              $oFormWorkingPartEmployee->save(false);
                              
                              $oMaintenanceFormTask->working_part = $nTypeWorkingPart;
                              $oMaintenanceFormTask->working_part_number = $oFormWorkingPart->id;
                              if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceFormTask->working_part_owner = $sCurrentUser;
                              
                              $oMaintenanceFormTask->save();
                           }
                        }
                        else if ($nTypeWorkingPart == FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_MAINTENANCE) {
                           $oFormMaintenanceWorkingPart = new FormsMaintenanceWorkingParts();
                           
                           if ($sCurrentUser != FString::STRING_EMPTY) $oFormMaintenanceWorkingPart->owner = $sCurrentUser; 
                           $oFormMaintenanceWorkingPart->task = $oMaintenanceFormTask->task;
                           $oFormMaintenanceWorkingPart->id_zone = $oMaintenanceFormTask->id_zone; 
                           $oFormMaintenanceWorkingPart->zone = $oMaintenanceFormTask->zone;
                           $oFormMaintenanceWorkingPart->id_region = $oMaintenanceFormTask->id_region;
                           $oFormMaintenanceWorkingPart->region = $oMaintenanceFormTask->region;
                           $oFormMaintenanceWorkingPart->id_equipment = $oMaintenanceFormTask->id_equipment;
                           $oFormMaintenanceWorkingPart->equipment = $oMaintenanceFormTask->equipment;

                           if (!is_null($oWorkingPartModuleParameters)) {
                              if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
                              else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
                              else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_finalized) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                              else $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;       
                           }
                           else $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         
                           $oFormMaintenanceWorkingPart->start_date = date('Y-m-d H:i:s');
                           $oFormMaintenanceWorkingPart->id_maintenance_form_task = $oMaintenanceFormTask->id;
                           $oFormMaintenanceWorkingPart->id_user = Yii::app()->user->id;
                           $oFormMaintenanceWorkingPart->data_completed = true;
                           
                           if ($oFormMaintenanceWorkingPart->save(false)) {
                              // Create components
                              foreach($oMaintenanceFormTaskComponents as $oMaintenanceFormTaskComponent) {
                                 $oFormMaintenanceWorkingPartComponent = new FormMaintenanceWorkingPartComponents();
                                 $oFormMaintenanceWorkingPartComponent->id_component = $oMaintenanceFormTaskComponent->id_component; 
                                 $oFormMaintenanceWorkingPartComponent->component = $oMaintenanceFormTaskComponent->component;
                                 $oFormMaintenanceWorkingPartComponent->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                                 $oFormMaintenanceWorkingPartComponent->save();
                              }
                              
                              // Create default equipment conditions
                              $oDefaultEquipmentConditions = EquipmentConditions::getEquipmentConditions(null, null, true);
                              foreach($oDefaultEquipmentConditions as $oEquipmentCondition) {
                                 $oFormMaintenanceWorkingPartEquipmentCondition = new FormMaintenanceWorkingPartEquipmentConditions();
                                 $oFormMaintenanceWorkingPartEquipmentCondition->description = $oEquipmentCondition->description;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->value = 3;
                                 $oFormMaintenanceWorkingPartEquipmentCondition->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                                 
                                 $oFormMaintenanceWorkingPartEquipmentCondition->save();
                              }
                              $oFormMaintenanceWorkingPartEquipmentCondition = new FormMaintenanceWorkingPartEquipmentConditions();
                              $oFormMaintenanceWorkingPartEquipmentCondition->description = strtoupper(FString::STRING_OTHERS);
                              $oFormMaintenanceWorkingPartEquipmentCondition->custom = true;
                              $oFormMaintenanceWorkingPartEquipmentCondition->value = 3;
                              $oFormMaintenanceWorkingPartEquipmentCondition->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                              $oFormMaintenanceWorkingPartEquipmentCondition->save();
                              
                              // Create default measures
                              $oDefaultMeasures = Measures::getMeasures(null, null, true);
                              foreach($oDefaultMeasures as $oMeasure) {
                                 $oFormMaintenanceWorkingPartMeasure = new FormMaintenanceWorkingPartMeasures();
                                 $oFormMaintenanceWorkingPartMeasure->description = $oMeasure->description;
                                 $oFormMaintenanceWorkingPartMeasure->alert = $oMeasure->alert;
                                 $oFormMaintenanceWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                                 $oFormMaintenanceWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                                 $oFormMaintenanceWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                                 $oFormMaintenanceWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                                 $oFormMaintenanceWorkingPartMeasure->information = $oMeasure->information;
                                 $oFormMaintenanceWorkingPartMeasure->value = 3;
                                 $oFormMaintenanceWorkingPartMeasure->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                                 
                                 $oFormMaintenanceWorkingPartMeasure->save();  
                              } 
                              $oFormMaintenanceWorkingPartMeasure = new FormMaintenanceWorkingPartMeasures();
                              $oFormMaintenanceWorkingPartMeasure->description = strtoupper(FString::STRING_OTHERS);
                              $oFormMaintenanceWorkingPartMeasure->custom = true;
                              $oFormMaintenanceWorkingPartMeasure->value = 3;
                              $oFormMaintenanceWorkingPartMeasure->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                              $oFormMaintenanceWorkingPartMeasure->save();
                              
                              // Copy all Risks & Ipes of equipment
                              if ($oFormMaintenanceWorkingPart->id_equipment != FApplication::EQUIPMENT_OTHERS) {
                                 $oEquipment = Equipments::getEquipment($oFormMaintenanceWorkingPart->id_equipment);
                                 if (!is_null($oEquipment)) {
                                    // Copy all Risks & Ipes of equipment
                                    $oEquipmentsRisks = EquipmentsRisks::getEquipmentsRisksByIdEquipment($oEquipment->id);
                                    foreach($oEquipmentsRisks as $oEquipmentsRisk) {
                                       $oRisk = Risks::getRisk($oEquipmentsRisk->id_risk);
                                       if (!is_null($oRisk)) {
                                          $oFormMaintenanceWorkingPartRisk = new FormMaintenanceWorkingPartRisks();
                                          $oFormMaintenanceWorkingPartRisk->name = $oRisk->name;
                                          $oFormMaintenanceWorkingPartRisk->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                                          
                                          if ($oFormMaintenanceWorkingPartRisk->save()) {
                                             $oRisksIPEs = RisksIPEs::getRisksIPEsByIdRisk($oRisk->id);
                                             foreach($oRisksIPEs as $oRisksIPE) {
                                                $oIPE = IPEs::getIPE($oRisksIPE->id_ipe);
                                                if (!is_null($oIPE)) {
                                                   $oFormMaintenanceWorkingPartIPE = new FormMaintenanceWorkingPartIPEs();
                                                   $oFormMaintenanceWorkingPartIPE->name = $oIPE->name;
                                                   $oFormMaintenanceWorkingPartIPE->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                                                   
                                                   $oFormMaintenanceWorkingPartIPE->save();
                                                }
                                             }
                                          } 
                                       }
                                    }
                                 }    
                              }
                              
                              $oMaintenanceFormTask->working_part = $nTypeWorkingPart;
                              $oMaintenanceFormTask->working_part_number = $oFormMaintenanceWorkingPart->id;
                              if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceFormTask->working_part_owner = $sCurrentUser;
                              
                              $oMaintenanceFormTask->save();
                           }                                       
                        } 
                        else if ($nTypeWorkingPart == FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_SPECIAL) {
                           $oFormSpecialWorkingPart = new FormsSpecialWorkingParts();
                           
                           if ($sCurrentUser != FString::STRING_EMPTY) $oFormSpecialWorkingPart->owner = $sCurrentUser; 
                           $oFormSpecialWorkingPart->task = $oMaintenanceFormTask->task;
                           $oFormSpecialWorkingPart->work_description = $oMaintenanceFormTask->task;
                           
                           if (!is_null($oWorkingPartModuleParameters)) {
                              if ($oWorkingPartModuleParameters->special_working_part_show_status_created) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
                              else if ($oWorkingPartModuleParameters->special_working_part_show_status_running) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
                              else if ($oWorkingPartModuleParameters->special_working_part_show_status_finalized) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                              else $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;       
                           }
                           else $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
                           
                           $oFormSpecialWorkingPart->start_date = date('Y-m-d H:i:s');
                           $oFormSpecialWorkingPart->id_maintenance_form_task = $oMaintenanceFormTask->id;
                           $oFormSpecialWorkingPart->id_user = Yii::app()->user->id;
                           $oFormSpecialWorkingPart->data_completed = true;
                           
                           if ($oFormSpecialWorkingPart->save(false)) {
                              // Create components
                              foreach($oMaintenanceFormTaskComponents as $oMaintenanceFormTaskComponent) {
                                 $oFormMaintenanceWorkingPartComponent = new FormMaintenanceWorkingPartComponents();
                                 $oFormMaintenanceWorkingPartComponent->id_component = $oMaintenanceFormTaskComponent->id_component; 
                                 $oFormMaintenanceWorkingPartComponent->component = $oMaintenanceFormTaskComponent->component;
                                 $oFormMaintenanceWorkingPartComponent->save();
                              }
                              
                              // Create default equipment conditions
                              $oDefaultEquipmentConditions = EquipmentConditions::getEquipmentConditions(null, true, null);
                              foreach($oDefaultEquipmentConditions as $oEquipmentCondition) {
                                 $oFormSpecialWorkingPartEquipmentCondition = new FormSpecialWorkingPartEquipmentConditions();
                                 $oFormSpecialWorkingPartEquipmentCondition->description = $oEquipmentCondition->description;
                                 $oFormSpecialWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                                 $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                                 $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                                 $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                                 $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;
                                 $oFormSpecialWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
                                 $oFormSpecialWorkingPartEquipmentCondition->value = 3;
                                 $oFormSpecialWorkingPartEquipmentCondition->id_form_special_working_part = $oFormSpecialWorkingPart->id;
                                 
                                 $oFormSpecialWorkingPartEquipmentCondition->save();
                              }
                              $oFormSpecialWorkingPartEquipmentCondition = new FormSpecialWorkingPartEquipmentConditions();
                              $oFormSpecialWorkingPartEquipmentCondition->description = strtoupper(FString::STRING_OTHERS);
                              $oFormSpecialWorkingPartEquipmentCondition->custom = true;
                              $oFormSpecialWorkingPartEquipmentCondition->value = 3;
                              $oFormSpecialWorkingPartEquipmentCondition->id_form_special_working_part = $oFormSpecialWorkingPart->id;
                              $oFormSpecialWorkingPartEquipmentCondition->save();
                              
                              // Create default measures
                              $oDefaultMeasures = Measures::getMeasures(null, true, null);
                              foreach($oDefaultMeasures as $oMeasure) {
                                 $oFormSpecialWorkingPartMeasure = new FormSpecialWorkingPartMeasures();
                                 $oFormSpecialWorkingPartMeasure->description = $oMeasure->description;
                                 $oFormSpecialWorkingPartMeasure->alert = $oMeasure->alert;
                                 $oFormSpecialWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                                 $oFormSpecialWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                                 $oFormSpecialWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                                 $oFormSpecialWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                                 $oFormSpecialWorkingPartMeasure->information = $oMeasure->information;
                                 $oFormSpecialWorkingPartMeasure->value = 3;
                                 $oFormSpecialWorkingPartMeasure->id_form_special_working_part = $oFormSpecialWorkingPart->id;
                                 
                                 $oFormSpecialWorkingPartMeasure->save();  
                              } 
                              $oFormSpecialWorkingPartMeasure = new FormSpecialWorkingPartMeasures();
                              $oFormSpecialWorkingPartMeasure->description = strtoupper(FString::STRING_OTHERS);
                              $oFormSpecialWorkingPartMeasure->custom = true;
                              $oFormSpecialWorkingPartMeasure->value = 3;
                              $oFormSpecialWorkingPartMeasure->id_form_special_working_part = $oFormSpecialWorkingPart->id;
                              $oFormSpecialWorkingPartMeasure->save();
                              
                              // Copy employee
                              $oFormSpecialWorkingPartEmployee = new FormSpecialWorkingPartEmployees();
                              $oFormSpecialWorkingPartEmployee->name = $sCurrentUser;
                              
                              $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
                              $oFormSpecialWorkingPartEmployee->business = FString::STRING_EMPTY;
                              if ((!is_null($oEmployee)) && ($oEmployee->type == FApplication::EMPLOYEE_BUSINESS)) {
                                 $oFormSpecialWorkingPartEmployee->business = Application::getBusinessName();  
                              }
                              $oFormSpecialWorkingPartEmployee->id_form_special_working_part = $oFormSpecialWorkingPart->id; 
                              $oFormSpecialWorkingPartEmployee->save(false);
                              
                              $oMaintenanceFormTask->working_part = $nTypeWorkingPart;
                              $oMaintenanceFormTask->working_part_number = $oFormSpecialWorkingPart->id;
                              if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceFormTask->working_part_owner = $sCurrentUser;
                              
                              $oMaintenanceFormTask->save();
                           }     
                        } 
                     }
                  }
               }
            }
            else if (isset($_POST['MaintenanceFormTaskSupplies'])) {              
               $bErrorTransaction = false;
               $nQuantity = 0;
               FForm::validateAjaxForm('maintenance-form-task-supply-form', $oMaintenanceFormTaskSupply);
                
               try {
                  $oTransactionWarehouse = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                  $oTransactionMaintenance = Yii::app()->db_rainbow_plantmaintenancemanagement->beginTransaction();
                  
                  $oMaintenanceFormTaskSupply->attributes = $_POST['MaintenanceFormTaskSupplies'];
                  
                  if ((isset($_POST['MaintenanceFormTaskSupplies']['id_supply'])) && (isset($_POST['MaintenanceFormTaskSupplies']['quantity']))) {
                     $oArticle = Articles::getArticle($oMaintenanceFormTaskSupply->id_supply);
                     if (!is_null($oArticle)) {
                        if ($_POST['MaintenanceFormTaskSupplies']['quantity'] > $oArticle->quantity) {
                           $nQuantity = $oArticle->quantity; 
                        }
                        else $nQuantity = $_POST['MaintenanceFormTaskSupplies']['quantity'];
                     }
                  }
                  
                  if ($nQuantity > 0) {
                     $oMaintenanceFormTaskSupply->supply = $oArticle->name;
                     $oMaintenanceFormTaskSupply->supply_code = $oArticle->code; 
                     $oMaintenanceFormTaskSupply->quantity = $nQuantity;
                     
                     $oMaintenanceFormTaskSupply->id_form_task = $nIdForm;
                     
                     if ($oMaintenanceFormTaskSupply->save()) {
                        if (FString::isNullOrEmpty($oMaintenanceFormTask->id_warehouse_form_output)) {
                           $oWarehouseFormOutput = new WarehouseFormsOutputs();
                           
                           $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                           if ($sCurrentUser != FString::STRING_EMPTY) $oWarehouseFormOutput->owner = $sCurrentUser;
                           
                           $oWarehouseFormOutput->date = date('Y-m-d H:i:s');
                           $oWarehouseFormOutput->type = FModuleWarehouseManagement::TYPE_OUTPUT_MAINTENANCE;
                           $oWarehouseFormOutput->id_user = Yii::app()->user->id; 
                           $oWarehouseFormOutput->id_maintenance_form_task = $oMaintenanceFormTask->id; 
                           
                           $oWarehouseFormOutput->data_completed = true; 
                           
                           if ($oWarehouseFormOutput->save(false)) {
                              $oMaintenanceFormTask->id_warehouse_form_output = $oWarehouseFormOutput->id;
                              if (!$oMaintenanceFormTask->save(false)) $bErrorTransaction = true;
                           }
                           else $bErrorTransaction = true;
                        }
                        else {
                           $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($oMaintenanceFormTask->id_warehouse_form_output);   
                           
                           if (is_null($oWarehouseFormOutput)) $bErrorTransaction = true;
                        }
                        
                        if (!$bErrorTransaction) {
                           $oWarehouseFormOutputArticle = new WarehouseFormOutputArticles();
                           $oWarehouseFormOutputArticle->id_category = $oArticle->subcategory->category->id;
                           $oWarehouseFormOutputArticle->category = $oArticle->subcategory->category->name;
                           $oWarehouseFormOutputArticle->id_subcategory = $oArticle->subcategory->id;
                           $oWarehouseFormOutputArticle->subcategory = $oArticle->subcategory->name;
                           $oWarehouseFormOutputArticle->id_article = $oArticle->id;
                           $oWarehouseFormOutputArticle->article = $oArticle->name;
                           $oWarehouseFormOutputArticle->article_code = $oArticle->code;
                           $oWarehouseFormOutputArticle->article_description = $oArticle->description;
                           $oWarehouseFormOutputArticle->quantity = $nQuantity;
                           $oWarehouseFormOutputArticle->id_form_output = $oWarehouseFormOutput->id; 
                           
                           if ($oWarehouseFormOutputArticle->save()) {
                              $oArticle = Articles::getArticle($oMaintenanceFormTaskSupply->id_supply);
                              if (!is_null($oArticle)) {
                                 $oArticle->quantity -= $nQuantity;
                                  
                                 if (!$oArticle->save()) $bErrorTransaction = true;
                              }
                           }
                           else $bErrorTransaction = true;
                        }  
                     }
                     else $bErrorTransaction = true;
                  }
                  else $bErrorTransaction = true;
                   
                  if (!$bErrorTransaction) {
                     $oTransactionMaintenance->commit(); 
                     $oTransactionWarehouse->commit();  
                  }      
                  else {
                     $oTransactionMaintenance->rollBack();
                     $oTransactionWarehouse->rollBack();
                  }
               } catch(Exception $e) {
                  $oTransactionMaintenance->rollBack();
                  $oTransactionWarehouse->rollBack(); 
               } 
            }
            else if (isset($_POST['MaintenanceFormTaskEmployees'])) {
               FForm::validateAjaxForm('maintenance-form-task-employee-form', $oMaintenanceFormTaskEmployee); 
               
               $oMaintenanceFormTaskEmployee->attributes = $_POST['MaintenanceFormTaskEmployees'];
               $oMaintenanceFormTaskEmployee->id_form_task = $nIdForm;
               
               $oMaintenanceFormTaskEmployee->save(); 
            }
            
            $oMaintenanceFormTaskSupply->unsetAttributes();
            $oMaintenanceFormTaskSupply->nIdSubcategory = null;
            $oMaintenanceFormTaskEmployee->unsetAttributes();
             
            $this->render('updateFormTask', array('oModelForm'=>$oMaintenanceFormTask, 'oModelFormComponents'=>$oMaintenanceFormTaskComponents, 'oModelFormDepartments'=>$oMaintenanceFormTaskDepartments, 'oModelFormSupply'=>$oMaintenanceFormTaskSupply, 'oModelFormEmployee'=>$oMaintenanceFormTaskEmployee));             
         }  
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));                                                                                                                                                                          
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormDailyEvent($nIdForm) {
      $oMaintenanceFormDailyEventLine = new MaintenanceFormDailyEventLines();

      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEvent($nIdForm);
      if (!is_null($oMaintenanceFormDailyEvent)) {
         if ((isset($_POST['MaintenanceFormDailyEventLines'])) && (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($nIdForm))) {  
            // Ajax validation request=>Conditional validator
            FForm::validateAjaxForm('maintenance-form-daily-event-line-form', $oMaintenanceFormDailyEventLine);
      
            $oMaintenanceFormDailyEventLine->attributes = $_POST['MaintenanceFormDailyEventLines'];

            $oMaintenanceFormDailyEventLine->hour = FFormat::getFormatTimeTwoDigits($_POST['MaintenanceFormDailyEventLines']['sHourHour'] . ':' . $_POST['MaintenanceFormDailyEventLines']['sHourMinutes']);
            $oMaintenanceFormDailyEventLine->duration = FFormat::getFormatTimeTwoDigits($_POST['MaintenanceFormDailyEventLines']['sDurationHour'] . ':' . $_POST['MaintenanceFormDailyEventLines']['sDurationMinutes']);
            $oMaintenanceFormDailyEventLine->id_form_daily_event = $nIdForm;
            
            $oMaintenanceFormDailyEventLine->save();
         }
         else if (isset($_POST['MaintenanceFormDailyEventLines'])) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));

         $oMaintenanceFormDailyEventLine->unsetAttributes();
         $oMaintenanceFormDailyEventLine->id_form_daily_event = $nIdForm;
          
         $this->render('updateFormDailyEvent', array('oModelForm'=>$oMaintenanceFormDailyEventLine));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionUpdateFormDailyEventLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceFormDailyEventLine = MaintenanceFormDailyEventLines::getMaintenanceFormDailyEventLine($nIdForm); 
          
      if (!is_null($oMaintenanceFormDailyEventLine)) {
         if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($oMaintenanceFormDailyEventLine->id_form_daily_event)) {
               
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('maintenance-form-daily-event-line-form', $oMaintenanceFormDailyEventLine);
         
            if (isset($_POST['MaintenanceFormDailyEventLines'])) {
               $oMaintenanceFormDailyEventLine->attributes = $_POST['MaintenanceFormDailyEventLines'];

               $oMaintenanceFormDailyEventLine->hour = FFormat::getFormatTimeTwoDigits($_POST['MaintenanceFormDailyEventLines']['sHourHour'] . ':' . $_POST['MaintenanceFormDailyEventLines']['sHourMinutes']);
               $oMaintenanceFormDailyEventLine->duration = FFormat::getFormatTimeTwoDigits($_POST['MaintenanceFormDailyEventLines']['sDurationHour'] . ':' . $_POST['MaintenanceFormDailyEventLines']['sDurationMinutes']);
            
               $oMaintenanceFormDailyEventLine->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewDetailFormDailyEventLine', array('nIdForm'=>$oMaintenanceFormDailyEventLine->id)));
            }
            else {
               $oMaintenanceFormDailyEventLine->sHourHour = (int) FDate::getHour($oMaintenanceFormDailyEventLine->hour);
               $oMaintenanceFormDailyEventLine->sHourMinutes = (int) FDate::getMinutes($oMaintenanceFormDailyEventLine->hour); 
               $oMaintenanceFormDailyEventLine->sDurationHour = (int) FDate::getHour($oMaintenanceFormDailyEventLine->duration);
               $oMaintenanceFormDailyEventLine->sDurationMinutes = (int) FDate::getMinutes($oMaintenanceFormDailyEventLine->duration);
               
               $this->render('updateFormDailyEventLine', array('oModelForm'=>$oMaintenanceFormDailyEventLine));
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   } 
   
   
   public function actionDeleteFormTask($nIdForm) {
      $bErrorTransaction = false;
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
      if (!is_null($oMaintenanceFormTask)) {
         $bAllowDelete = FModulePlantMaintenanceManagement::allowDeleteMaintenanceFormTask($oMaintenanceFormTask->id);
      
         if ($bAllowDelete) {
            try { 
               $oTransactionWarehouse = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
               $oTransactionMaintenance = Yii::app()->db_rainbow_plantmaintenancemanagement->beginTransaction();
               
               $nIdMaintenanceFormTask = $oMaintenanceFormTask->id;
                        
               if ((!FString::isNullOrEmpty($oMaintenanceFormTask->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $oMaintenanceFormTask->attachment))) {
                  $oMaintenanceFormsTasks = MaintenanceFormsTasks::getMaintenanceFormsTasks(null, null, $oMaintenanceFormTask->attachment);
                  if (count($oMaintenanceFormsTasks == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $oMaintenanceFormTask->attachment);
               }  
                  
               if ($oMaintenanceFormTask->delete()) {
                  if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
                     $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
                     foreach($oFormsWorkingParts as $oFormWorkingPart) {
                        if (!$oFormWorkingPart->delete()) $bErrorTransaction = true; 
                     }
                     
                     $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
                     foreach($oFormsMaintenanceWorkingParts as $oFormMaintenanceWorkingPart) {
                        if (!$oFormMaintenanceWorkingPart->delete()) $bErrorTransaction = true;   
                     }
                  
                     $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts(null, null, $nIdMaintenanceFormTask);
                     foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) {
                        if (!$oFormSpecialWorkingPart->delete()) $bErrorTransaction = true;
                     }
                  }
                  
                  if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
                     if (!FSTring::isNullOrEmpty($oMaintenanceFormTask->id_warehouse_form_output)) {
                        $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($oMaintenanceFormTask->id_warehouse_form_output);
                        if (!is_null($oWarehouseFormOutput)) {
                           $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
                           foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
                              $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                              if (!is_null($oArticle)) {
                                 $oArticle->quantity += $oWarehouseFormOutputArticle->quantity;

                                 if (!$oArticle->save()) $bErrorTransaction = true;   
                              }
                           }
                            
                           if (!$oWarehouseFormOutput->delete()) $bErrorTransaction = true;
                        }      
                     }      
                  }
               }
               else $bErrorTransaction = true;
               
               if (!$bErrorTransaction) {
                  $oTransactionMaintenance->commit(); 
                  $oTransactionWarehouse->commit();  
               }      
               else {
                  $oTransactionMaintenance->rollBack();
                  $oTransactionWarehouse->rollBack();
               }
            } catch(Exception $e) {
               $oTransactionMaintenance->rollBack();
               $oTransactionWarehouse->rollBack();
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsTasks'));
   }
   public function actionDeleteFormTaskSupply($nIdForm, $nIdFormParent) {
      $bErrorTransaction = false;
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdFormParent);
      
      if (!is_null($oMaintenanceFormTask)) {
         $oMaintenanceFormTaskSupply = MaintenanceFormTaskSupplies::getMaintenanceFormTaskSupply($nIdForm);
         if (!is_null($oMaintenanceFormTaskSupply)) { 
            if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormTask($nIdFormParent)) {
               if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
                  try { 
                     $oTransactionWarehouse = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                     $oTransactionMaintenance = Yii::app()->db_rainbow_plantmaintenancemanagement->beginTransaction();
                     
                     $oMaintenanceFormTaskSupplies = MaintenanceFormTaskSupplies::getMaintenanceFormTaskSuppliesByIdFormFK($nIdFormParent);
                     if (count($oMaintenanceFormTaskSupplies) == 1) {
                        if (!FSTring::isNullOrEmpty($oMaintenanceFormTask->id_warehouse_form_output)) {
                           $nIdWarehouseFormOutput = $oMaintenanceFormTask->id_warehouse_form_output; 
                           $oMaintenanceFormTask->id_warehouse_form_output = null;
                           
                           if ($oMaintenanceFormTask->save(false)) {      
                              $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdWarehouseFormOutput);
                              if (!is_null($oWarehouseFormOutput)) $oWarehouseFormOutput->delete(); 
                           } 
                           else $bErrorTransaction = true;    
                        }      
                     }
                     
                     $oArticle = Articles::getArticle($oMaintenanceFormTaskSupply->id_supply);
                     if (!is_null($oArticle)) {
                        $oArticle->quantity += $oMaintenanceFormTaskSupply->quantity;

                        if ($oArticle->save()) {
                           if (!$oMaintenanceFormTaskSupply->delete()) $bErrorTransaction = true;
                        }
                        else $bErrorTransaction = true;   
                     }   
            
                     if (!$bErrorTransaction) {
                        $oTransactionMaintenance->commit(); 
                        $oTransactionWarehouse->commit();  
                     }      
                     else {
                        $oTransactionMaintenance->rollBack();
                        $oTransactionWarehouse->rollBack();
                     }
                  } catch(Exception $e) {
                     $oTransactionMaintenance->rollBack();
                     $oTransactionWarehouse->rollBack();
                  } 
               }
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
         } 

         $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$nIdFormParent)));
      } 
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionDeleteFormTaskEmployee($nIdForm, $nIdFormParent) {
      $oMaintenanceFormTaskEmployee = MaintenanceFormTaskEmployees::getMaintenanceFormTaskEmployee($nIdForm);

      if (!is_null($oMaintenanceFormTaskEmployee)) { 
         if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormTask($nIdFormParent)) {   
            $oMaintenanceFormTaskEmployee->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      } 

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$nIdFormParent)));
   }    
   public function actionDeleteFormTaskWorkingPart($nIdForm) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
      
      if (!is_null($oMaintenanceFormTask)) {
         if (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormTask($nIdForm)) {
            $nIdMaintenanceFormTask = $oMaintenanceFormTask->id;
            if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
               $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
               foreach($oFormsWorkingParts as $oFormWorkingPart) $oFormWorkingPart->delete();
               
               $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(null, null, null, null, null, $nIdMaintenanceFormTask);
               foreach($oFormsMaintenanceWorkingParts as $oFormMaintenanceWorkingPart) $oFormMaintenanceWorkingPart->delete();
            
               $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts(null, null, $nIdMaintenanceFormTask);
               foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) $oFormSpecialWorkingPart->delete();
            }
            
            $oMaintenanceFormTask->working_part = FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE;
            $oMaintenanceFormTask->working_part_number = null;
            $oMaintenanceFormTask->working_part_owner = null;
            $oMaintenanceFormTask->save();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      } 

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormTask', array('nIdForm'=>$nIdForm)));
   }  
   public function actionDeleteFormDailyEvent($nIdForm) {
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEvent($nIdForm);
      
      if ((!is_null($oMaintenanceFormDailyEvent)) && (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($nIdForm))) {
         $oMaintenanceFormDailyEvent->delete();     
      }
      else if (!is_null($oMaintenanceFormDailyEvent)) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/viewFormsDailyEvents'));
   }    
   public function actionDeleteFormDailyEventLine($nIdForm, $nIdFormParent) {
      $oMaintenanceFormDailyEventLine = MaintenanceFormDailyEventLines::getMaintenanceFormDailyEventLine($nIdForm);

      if ((!is_null($oMaintenanceFormDailyEventLine)) && (FModulePlantMaintenanceManagement::allowUpdateMaintenanceFormDailyEvent($nIdFormParent))) {
         $oMaintenanceFormDailyEventLine->delete();
      }
      else if (!is_null($oMaintenanceFormDailyEventLine)) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/updateFormDailyEvent', array('nIdForm'=>$nIdFormParent)));
   } 
}