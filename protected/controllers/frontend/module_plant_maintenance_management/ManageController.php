<?php

class ManageController extends FrontendController {                                                                                                     
    
   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
       return array( 
           array('allow', // allow authenticated user and have valid module roles to perform actions
              'actions'=>array('viewBuildScene'),
              'expression'=>'((Users::getNumAvaliableModulesForUser(Yii::app()->user->id) > 0) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)))',
           ),   
           array('allow', // allow admin user to perform actions                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
               'actions'=>array('viewZones', 'viewRegions', 'viewEquipments', 'viewComponents', 'viewAttachmentEquipment', 'viewScheduledTasks', 'viewPriorities', 'viewDepartments', 'viewAttachmentScheduledTask', 'viewDetailZone', 'viewDetailZoneRegion', 'viewDetailRegion', 'viewDetailRegionEquipment', 'viewDetailEquipment', 'viewDetailEquipmentComponent', 'viewDetailComponent', 'viewDetailScheduledTask', 'viewDetailPriority', 'viewDetailDepartment', 'refreshScheduledTasksRegions', 'refreshScheduledTasksEquipments', 'refreshScheduledTasksComponents', 'updateZone', 'updateZoneRegion', 'updateRegion', 'updateRegionEquipment', 'updateEquipment', 'updateEquipmentComponent', 'updateComponent', 'updateBuildSceneZone', 'updateBuildSceneRegion', 'updateBuildSceneEquipment', 'updateScheduledTask', 'updatePriority', 'updateDepartment', 'deleteZone', 'deleteZoneRegion', 'deleteRegion', 'deleteRegionEquipment', 'deleteEquipment', 'deleteEquipmentComponent', 'deleteComponent', 'deleteScheduledTask', 'deletePriority', 'deleteDepartment'),
               'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)))',
           ),
           array('deny',  // deny all users                                
               'users'=>array('*'),
           ),
       );
   }                           
   
                                
   public function actionViewZones() {
      $oZone = new Zones();
      $oZoneRegion = new ZonesRegions();
      $oZoneFilters = new Zones();
      $oZoneFilters->unsetAttributes();
      $oZoneRegionFilters = new ZonesRegions();
      $oZoneRegionFilters->unsetAttributes();
      
      if (isset($_POST['Zones'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('zone-form', $oZone);
      
         $oZone->attributes = $_POST['Zones'];
         $oZone->module = strtoupper(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
         
         $oFile = CUploadedFile::getInstanceByName('Zones[image]');
         if ($oFile) {
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                    
            if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
               $sPath = FApplication::FOLDER_IMAGES_APPLICATION_ZONES;
               $sOriginalFileUrl = $sPath . $sOriginalFile;
                        
               if ($oFile->saveAs($sOriginalFileUrl)) {
                  $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                 
                  FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                 
                  if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                 
                  $oZone->image = $sOutputFile;
               }
               else $oZone->image = null;  
            }
            else $oZone->image = null;
         }
         else $oZone->image = null;
         
         $oZone->save();
      }
      else {    
         if (isset($_POST['ZonesRegions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
            
            $oZoneRegion->attributes = $_POST['ZonesRegions'];
            $oZoneRegion->module = strtoupper(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
              
            $oZoneRegion->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['Zones'])) $oZoneFilters->attributes = $_GET['Zones'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['ZonesRegions'])) $oZoneRegionFilters->attributes = $_GET['ZonesRegions'];   
         }   
      }

      $oZone->unsetAttributes();
      $oZoneRegion->unsetAttributes();
      $this->render('viewZones', array('oModelForm'=>$oZone, 'oModelFormFilters'=>$oZoneFilters, 'oModelFormAssociation'=>$oZoneRegion, 'oModelFormAssociationFilters'=>$oZoneRegionFilters));    
   }
   public function actionViewRegions() {
      $oRegion = new Regions();
      $oRegionEquipment = new RegionsEquipments();
      $oRegionFilters = new Regions();
      $oRegionFilters->unsetAttributes();
      $oRegionEquipmentFilters = new RegionsEquipments();
      $oRegionEquipmentFilters->unsetAttributes();
      
      if (isset($_POST['Regions'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('region-form', $oRegion);
      
         $oRegion->attributes = $_POST['Regions'];
         $oRegion->module = strtoupper(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
         
         $oFile = CUploadedFile::getInstanceByName('Regions[image]');
         if ($oFile) {
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                    
            if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
               $sPath = FApplication::FOLDER_IMAGES_APPLICATION_REGIONS;
               $sOriginalFileUrl = $sPath . $sOriginalFile;
                        
               if ($oFile->saveAs($sOriginalFileUrl)) {
                  $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                 
                  FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                 
                  if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                 
                  $oRegion->image = $sOutputFile;
               }
               else $oRegion->image = null;  
            }
            else $oRegion->image = null;
         }
         else $oRegion->image = null;
         
         $oRegion->save();
      }
      else {    
         if (isset($_POST['RegionsEquipments'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
            
            $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
            $oRegionEquipment->module = strtoupper(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
            
            $oRegionEquipment->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['Regions'])) $oRegionFilters->attributes = $_GET['Regions'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['RegionsEquipments'])) $oRegionEquipmentFilters->attributes = $_GET['RegionsEquipments'];   
         }   
      }

      $oRegion->unsetAttributes();
      $oRegionEquipment->unsetAttributes();
      $this->render('viewRegions', array('oModelForm'=>$oRegion, 'oModelFormFilters'=>$oRegionFilters, 'oModelFormAssociation'=>$oRegionEquipment, 'oModelFormAssociationFilters'=>$oRegionEquipmentFilters));    
   }
   public function actionViewEquipments() {
      $oEquipment = new Equipments();
      $oEquipmentComponent = new EquipmentsComponents();
      $oEquipmentFilters = new Equipments();
      $oEquipmentFilters->unsetAttributes();
      $oEquipmentComponentFilters = new EquipmentsComponents();
      $oEquipmentComponentFilters->unsetAttributes();
      
      if (isset($_POST['Equipments'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-form', $oEquipment);
      
         $oEquipment->attributes = $_POST['Equipments'];
         $oEquipment->module = strtoupper(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT);
         
         if ((isset($_POST['Equipments']['installation_date'])) && (strlen($_POST['Equipments']['installation_date']) > 0)) $oEquipment->installation_date = FDate::getEnglishDate($_POST['Equipments']['installation_date']);

         $oFile = CUploadedFile::getInstanceByName('Equipments[image]');
         if ($oFile) {
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
               
            if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
               $sPath = FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS;
               $sOriginalFileUrl = $sPath . $sOriginalFile;
                        
               if ($oFile->saveAs($sOriginalFileUrl)) {
                  $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                 
                  FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                 
                  if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                 
                  $oEquipment->image = $sOutputFile;
               }
               else $oEquipment->image = null;  
            }
            else $oEquipment->image = null;
         }
         else $oEquipment->image = null;
         
         $oFile = CUploadedFile::getInstanceByName('Equipments[attachment]');
         if ($oFile) {
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
               
            if (FFile::isCommonRedeableTextFromFileType($oFile->extensionName, true)) {  
               $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS;
               $sOriginalFileUrl = $sPath . $sOriginalFile;
                        
               if ($oFile->saveAs($sOriginalFileUrl)) {
                  $oEquipment->attachment = $sOriginalFile;
               }
               else $oEquipment->attachment = null;  
            }
            else $oEquipment->attachment = null;
         }
         else $oEquipment->attachment = null;
         
         if (strtolower($oEquipment->name) != strtolower(FString::STRING_OTHERS)) $oEquipment->save();
      }
      else {   
         if (isset($_POST['EquipmentsComponents'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-component-form', $oEquipmentComponent);
            
            $oEquipmentComponent->attributes = $_POST['EquipmentsComponents'];

            $oEquipmentComponent->save();
         }
         else { 
            // Filters Grid Get Parameters
            if (isset($_GET['Equipments'])) $oEquipmentFilters->attributes = $_GET['Equipments']; 
            
            // Filters Grid Get Parameters
            if (isset($_GET['EquipmentsComponents'])) $oEquipmentComponentFilters->attributes = $_GET['EquipmentsComponents'];
         }  
      }

      $oEquipment->unsetAttributes();
      $oEquipmentComponent->unsetAttributes();
      $this->render('viewEquipments', array('oModelForm'=>$oEquipment, 'oModelFormFilters'=>$oEquipmentFilters, 'oModelFormAssociation'=>$oEquipmentComponent, 'oModelFormAssociationFilters'=>$oEquipmentComponentFilters));    
   }
   public function actionViewComponents() {
      $oComponent = new Components();
      $oComponentFilters = new Components();
      $oComponentFilters->unsetAttributes();
      
      if (isset($_POST['Components'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('component-form', $oComponent);
      
         $oComponent->attributes = $_POST['Components'];
         $oComponent->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['Components'])) $oComponentFilters->attributes = $_GET['Components'];   
      }

      $oComponent->unsetAttributes();
      $this->render('viewComponents', array('oModelForm'=>$oComponent, 'oModelFormFilters'=>$oComponentFilters));    
   }
   public function actionViewBuildScene($bReadOnly = false, $nIdZone = null, $nIdRegion = null) {
      $oZones = Zones::getZones();
      
      if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (strtolower(Users::getUserDefApplication(Yii::app()->user->id)) == strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && ($bReadOnly == false)) $bReadOnly = false;
      else {
         $bReadOnly = true;
         $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
         
         $sJsOnBeforeCss = "var nScreenHeight = screen.height;";
         $sJsOnBeforeCss .= "nScreenHeight = (nScreenHeight * 95) / 100;";
         $sJsOnBeforeCss .= "nScreenHeight = nScreenHeight - 195;";
         $sJsOnBeforeCss .= "$('.scene_map').css('height', nScreenHeight + 'px');";
         $sJsOnBeforeCss .= "var nScreenWidth = screen.width;";
         $sJsOnBeforeCss .= "nScreenWidth = (nScreenWidth * 95) / 100;";
         $sJsOnBeforeCss .= "nScreenWidth = nScreenWidth - 68;";
         $sJsOnBeforeCss .= "$('.scene_map').css('width', nScreenWidth + 'px');";
          
         $this->sJsOnBeforeCss = $sJsOnBeforeCss;
      }
      
      $this->render('viewBuildScene', array('oModelForm'=>$oZones, 'nModelFormIdZone'=>$nIdZone, 'nModelFormIdRegion'=>$nIdRegion, 'bReadOnly'=>$bReadOnly));
   }        
   public function actionViewAttachmentEquipment($nIdForm) {
     $oEquipment = Equipments::getEquipment($nIdForm);
     
     if (!is_null($oEquipment)) {
        if ((!FString::isNullOrEmpty($oEquipment->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oEquipment->attachment, '.'), '.' . FString::getLastToken($oEquipment->attachment, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewScheduledTasks($nIdZone = null, $nIdRegion = null, $nIdEquipment = null, $sIdComponents = FString::STRING_EMPTY, $sIdDepartments = FString::STRING_EMPTY) {
      $oMaintenanceScheduledTask = new MaintenanceScheduledTasks();
      $oMaintenanceScheduledTaskFilters = new MaintenanceScheduledTasks();
      $oMaintenanceScheduledTaskFilters->unsetAttributes();
      $bError = false;
      $bRefresh = false;
       
      if (isset($_POST['MaintenanceScheduledTasks'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('maintenance-scheduled-task-form', $oMaintenanceScheduledTask);
       
         $oMaintenanceScheduledTask->attributes = $_POST['MaintenanceScheduledTasks'];
          
         $oMaintenanceScheduledTask->execution_date = FDate::getEnglishDate($_POST['MaintenanceScheduledTasks']['execution_date']);
         $oMaintenancePriorities = MaintenancePriorities::getMaintenancePriorityByDescription($_POST['MaintenanceScheduledTasks']['priority']);
         if (!is_null($oMaintenancePriorities)) {
            $oMaintenanceScheduledTask->priority_number = $oMaintenancePriorities->priority;   
         }
         $oMaintenanceScheduledTask->id_user = Yii::app()->user->id;

         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceScheduledTask->owner = $sCurrentUser;
         else { 
            $bError = true; 
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_SUBMIT_ERROR_UNKNOWN'));
         }
        
         $oIdsDepartments = explode(',', $sIdDepartments);
         if ((count($oIdsDepartments) == 0) || ($sIdDepartments == FString::STRING_NULL)) {
            $bError = true; 
            Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_SUBMIT_ERROR_DEPARTMENT_NOT_SELECTED'));
         }
         
         if (!$bError) {
            $oFile = CUploadedFile::getInstanceByName('MaintenanceScheduledTasks[attachment]');
            if ($oFile) {
               $sOriginalFilename = sha1_file($oFile->tempName);
               $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
               $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                  
               if (FFile::isCommonRedeableTextFromFileType($oFile->extensionName, true)) {  
                  $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS;
                  $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                  if ($oFile->saveAs($sOriginalFileUrl)) {
                     $oMaintenanceScheduledTask->attachment = $sOriginalFile;
                  }
                  else $oMaintenanceScheduledTask->attachment = null;  
               }
               else $oMaintenanceScheduledTask->attachment = null;
            }
            else $oMaintenanceScheduledTask->attachment = null;
         
            if ($oMaintenanceScheduledTask->save()) {
               $oIdsComponents = explode(',', $sIdComponents);
               foreach($oIdsComponents as $nIdComponent) {
                  $oComponent = Components::getComponent($nIdComponent);
                  if (!is_null($oComponent)) {
                     $oMaintenanceScheduledTaskComponent = new MaintenanceScheduledTasksComponents();
                     $oMaintenanceScheduledTaskComponent->id_component = $oComponent->id;
                     $oMaintenanceScheduledTaskComponent->id_scheduled_task = $oMaintenanceScheduledTask->id; 
                      
                     $oMaintenanceScheduledTaskComponent->save();
                  } 
               }
               
               foreach($oIdsDepartments as $nIdDepartment) {
                  $oMaintenanceScheduledTaskDepartment = new MaintenanceScheduledTasksDepartments();
                  $oMaintenanceScheduledTaskDepartment->name = $nIdDepartment;
                  $oMaintenanceScheduledTaskDepartment->id_scheduled_task = $oMaintenanceScheduledTask->id; 
                   
                  $oMaintenanceScheduledTaskDepartment->save();
               }
            } 

            $oMaintenanceScheduledTask->unsetAttributes(); 
         }
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['MaintenanceScheduledTasks'])) $oMaintenanceScheduledTaskFilters->attributes = $_GET['MaintenanceScheduledTasks'];
         else {
            $oMaintenanceScheduledTask->unsetAttributes();  
            
            if (!FString::isNullOrEmpty($nIdZone)) {
               $oZone = Zones::getZone($nIdZone);
               if (!is_null($oZone)) $oMaintenanceScheduledTask->id_zone = $oZone->id;
            }
            if (!FString::isNullOrEmpty($nIdRegion)) {
               $oRegion = Regions::getRegion($nIdRegion);
               if (!is_null($oRegion)) $oMaintenanceScheduledTask->id_region = $oRegion->id;
            }
            if (!FString::isNullOrEmpty($nIdEquipment)) { 
               $oEquipment = Equipments::getEquipment($nIdEquipment);  
               if (!is_null($oEquipment)) $oMaintenanceScheduledTask->id_equipment = $oEquipment->id; 
            }
            
            if ((!FString::isNullOrEmpty($nIdZone)) || (!FString::isNullOrEmpty($nIdRegion)) || (!FString::isNullOrEmpty($nIdEquipment))) $bRefresh = true;
         }   
      }

      $this->render('viewScheduledTasks', array('oModelForm'=>$oMaintenanceScheduledTask, 'oModelFormFilters'=>$oMaintenanceScheduledTaskFilters, 'bRefreshPage'=>($bError || $bRefresh))); 
   }
   public function actionViewPriorities() {
      $oMaintenancePriority = new MaintenancePriorities();
      $oMaintenancePriorityFilters = new MaintenancePriorities();
      $oMaintenancePriorityFilters->unsetAttributes();
      
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('maintenance-priority-form', $oMaintenancePriority);
      
      if (isset($_POST['MaintenancePriorities'])) {
         $oMaintenancePriority->attributes = $_POST['MaintenancePriorities'];
           
         $oMaintenancePriority->save();
      }
      else { 
         // Filters Grid Get Parameters
         if (isset($_GET['MaintenancePriorities'])) $oMaintenancePriorityFilters->attributes = $_GET['MaintenancePriorities'];
      }

      $oMaintenancePriority->unsetAttributes();
      $this->render('viewPriorities', array('oModelForm'=>$oMaintenancePriority, 'oModelFormFilters'=>$oMaintenancePriorityFilters));    
   } 
   public function actionViewDepartments() {
      $oMaintenanceDepartment = new MaintenanceDepartments();
      $oMaintenanceDepartmentFilters = new MaintenanceDepartments();
      $oMaintenanceDepartmentFilters->unsetAttributes();
      
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('maintenance-department-form', $oMaintenanceDepartment);
      
      if (isset($_POST['MaintenanceDepartments'])) {
         $oMaintenanceDepartment->attributes = $_POST['MaintenanceDepartments'];
           
         $oMaintenanceDepartment->save();
      }
      else { 
         // Filters Grid Get Parameters
         if (isset($_GET['MaintenanceDepartments'])) $oMaintenanceDepartmentFilters->attributes = $_GET['MaintenanceDepartments'];
      }

      $oMaintenanceDepartment->unsetAttributes();
      $this->render('viewDepartments', array('oModelForm'=>$oMaintenanceDepartment, 'oModelFormFilters'=>$oMaintenanceDepartmentFilters));    
   } 
   public function actionViewAttachmentScheduledTask($nIdForm) {
     $oMaintenanceScheduledTask = MaintenanceScheduledTasks::getMaintenanceScheduledTask($nIdForm);
     
     if (!is_null($oMaintenanceScheduledTask)) {
        if ((!FString::isNullOrEmpty($oMaintenanceScheduledTask->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oMaintenanceScheduledTask->attachment, '.'), '.' . FString::getLastToken($oMaintenanceScheduledTask->attachment, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   
                             
   public function actionViewDetailZone($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZone = Zones::getZone($nIdForm);
       
      if (!is_null($oZone)) $this->render('viewDetailZone', array('oModelForm'=>$oZone));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailZoneRegion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZoneRegion = ZonesRegions::getZoneRegion($nIdForm);
       
      if (!is_null($oZoneRegion)) $this->render('viewDetailZoneRegion', array('oModelForm'=>$oZoneRegion));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }         
   public function actionViewDetailRegion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRegion = Regions::getRegion($nIdForm);
       
      if (!is_null($oRegion)) $this->render('viewDetailRegion', array('oModelForm'=>$oRegion));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailRegionEquipment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdForm);
       
      if (!is_null($oRegionEquipment)) $this->render('viewDetailRegionEquipment', array('oModelForm'=>$oRegionEquipment));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailEquipment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipment = Equipments::getEquipment($nIdForm);
       
      if (!is_null($oEquipment)) $this->render('viewDetailEquipment', array('oModelForm'=>$oEquipment));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailEquipmentComponent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentComponent = EquipmentsComponents::getEquipmentComponent($nIdForm);
       
      if (!is_null($oEquipmentComponent)) $this->render('viewDetailEquipmentComponent', array('oModelForm'=>$oEquipmentComponent));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailComponent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oComponent = Components::getComponent($nIdForm);
       
      if (!is_null($oComponent)) $this->render('viewDetailComponent', array('oModelForm'=>$oComponent));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailScheduledTask($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::getMaintenanceScheduledTask($nIdForm);
        
      if (!is_null($oMaintenanceScheduledTask)) $this->render('viewDetailScheduledTask', array('oModelForm'=>$oMaintenanceScheduledTask));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailPriority($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenancePriority = MaintenancePriorities::getMaintenancePriority($nIdForm);
       
      if (!is_null($oMaintenancePriority)) $this->render('viewDetailPriority', array('oModelForm'=>$oMaintenancePriority));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailDepartment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceDepartment = MaintenanceDepartments::getMaintenanceDepartment($nIdForm);
       
      if (!is_null($oMaintenanceDepartment)) $this->render('viewDetailDepartment', array('oModelForm'=>$oMaintenanceDepartment));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionRefreshScheduledTasksRegions($nIdZone) {
      $this->layout = null;
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksEquipments') . '&nIdRegion=';
      $sRefreshEquipmentsUrl = "aj('" . $sRefreshEquipmentsUrl . "' + this.value, null, 'id_equipment')";              
      $sJsRefreshComponentClear = "$('#MaintenanceScheduledTasks_sComponents option').remove()";
                                    
      $sContent = "<select style=\"width:300px;\" onchange=\"" . $sRefreshEquipmentsUrl . ';' . $sJsRefreshComponentClear . ';' . "\" name=\"MaintenanceScheduledTasks[id_region]\" id=\"MaintenanceScheduledTasks_id_region\">";   
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
   public function actionRefreshScheduledTasksEquipments($nIdRegion) {
      $this->layout = null;
      $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/refreshScheduledTasksComponents') . '&nIdEquipment=';
      $sRefreshComponentsUrl = "aj('" . $sRefreshComponentsUrl . "' + $('#MaintenanceScheduledTasks_id_equipment option:selected').val(), null, 'MaintenanceScheduledTasks_sComponents')";              

      $sContent = "<select style=\"width:300px;\" onchange=\"" . $sRefreshComponentsUrl . "\" name=\"MaintenanceScheduledTasks[id_equipment]\" id=\"MaintenanceScheduledTasks_id_equipment\">";   
      $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
      if (!FString::isNullOrEmpty($nIdRegion)) {
         $oRegionsEquipments = RegionsEquipments::getRegionsEquipmentsByIdRegion($nIdRegion);
       
         foreach($oRegionsEquipments as $oRegionEquipment) {
            $oEquipment = Equipments::getEquipment($oRegionEquipment->id_equipment);
            if (!is_null($oEquipment)) {
               $sContent .= "<option value=\"" . $oEquipment->id . "\">" . $oEquipment->name . "</option>";    
            }
         }
      }
      $sContent .= "</select>";
       
      $this->renderText($sContent);  
   }
   public function actionRefreshScheduledTasksComponents($nIdEquipment) {        
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
    
      if (!FString::isNullOrEmpty($nIdEquipment)) {
         $oEquipmentsComponents = EquipmentsComponents::getEquipmentsComponentsByIdEquipment($nIdEquipment);
    
         foreach($oEquipmentsComponents as $oEquipmentComponent) {
            $oComponent = Components::getComponent($oEquipmentComponent->id_component);
            if (!is_null($oComponent)) {
               $sContent .= "<option value=\"" . $oComponent->id . "\">" . $oComponent->name . "</option>";    
            }
         }
      }
       
      $this->renderText($sContent);   
   }
   
                     
   public function actionUpdateZone($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZone = Zones::getZone($nIdForm);
                               
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-form', $oZone);
         
            if (isset($_POST['Zones'])) {
               $oZone->attributes = $_POST['Zones'];
               $oZone->image = null;
               
               $oFile = CUploadedFile::getInstanceByName('Zones[image]');
               if ($oFile) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                 
                  if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                     $sPath = FApplication::FOLDER_IMAGES_APPLICATION_ZONES;
                     $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                     if ($oFile->saveAs($sOriginalFileUrl)) {
                        $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                       
                        FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                       
                        if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                                       
                        if ((!FString::isNullOrEmpty($oZone->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oZone->image))) {
                           $oZones = Zones::getZones($oZone->image);
                           if (count($oZones == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oZone->image);
                        } 
            
                        $oZone->image = $sOutputFile;
                     }  
                  }
               }
               
               $oZone->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailZone', array('nIdForm'=>$oZone->id)));
            }
            else $this->render('updateZone', array('oModelForm'=>$oZone));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateZoneRegion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZoneRegion = ZonesRegions::getZoneRegion($nIdForm);
                               
      if (!is_null($oZoneRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
         
            if (isset($_POST['ZonesRegions'])) {
               $oZoneRegion->attributes = $_POST['ZonesRegions'];
                 
               $oZoneRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailZoneRegion', array('nIdForm'=>$oZoneRegion->id)));
            }
            else $this->render('updateZoneRegion', array('oModelForm'=>$oZoneRegion));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateRegion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRegion = Regions::getRegion($nIdForm);
                               
      if (!is_null($oRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-form', $oRegion);
         
            if (isset($_POST['Regions'])) {
               $oRegion->attributes = $_POST['Regions'];
               $oRegion->image = null;
               
               $oFile = CUploadedFile::getInstanceByName('Regions[image]');
               if ($oFile) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                 
                  if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                     $sPath = FApplication::FOLDER_IMAGES_APPLICATION_REGIONS;
                     $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                     if ($oFile->saveAs($sOriginalFileUrl)) {
                        $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                       
                        FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                       
                        if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                                       
                        if ((!FString::isNullOrEmpty($oRegion->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oRegion->image))) {
                           $oRegions = Regions::getRegions(null, false, $oRegion->image);
                           if (count($oRegions == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oRegion->image);
                        } 
            
                        $oRegion->image = $sOutputFile;
                     }  
                  }
               }
         
               $oRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailRegion', array('nIdForm'=>$oRegion->id)));
            }
            else $this->render('updateRegion', array('oModelForm'=>$oRegion));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateRegionEquipment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdForm);
                               
      if (!is_null($oRegionEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
         
            if (isset($_POST['RegionsEquipments'])) {
               $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
                 
               $oRegionEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailRegionEquipment', array('nIdForm'=>$oRegionEquipment->id)));
            }
            else $this->render('updateRegionEquipment', array('oModelForm'=>$oRegionEquipment));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateEquipment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipment = Equipments::getEquipment($nIdForm);
                               
      if (!is_null($oEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-form', $oEquipment);
                        
            if (isset($_POST['Equipments'])) {
               $oEquipment->attributes = $_POST['Equipments'];
               $oEquipment->image = null;
               $oEquipment->attachment = null;
               
               if ((isset($_POST['Equipments']['installation_date'])) && (strlen($_POST['Equipments']['installation_date']) > 0)) $oEquipment->installation_date = FDate::getEnglishDate($_POST['Equipments']['installation_date']);

               $oFile = CUploadedFile::getInstanceByName('Equipments[image]');
               if ($oFile) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                 
                  if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                     $sPath = FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS;
                     $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                     if ($oFile->saveAs($sOriginalFileUrl)) {
                        $sOutputFile = $sOriginalFilename . FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE);
                       
                        FFile::resizeImageFile($sOriginalFileUrl, 200, 150, $sPath . $sOutputFile);
                       
                        if ($sOriginalFileExtension != FFile::getExtensionFromFileType(FFile::FILE_JPG_TYPE)) unlink($sOriginalFileUrl);
                                       
                        if ((!FString::isNullOrEmpty($oEquipment->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oEquipment->image))) {
                           $oEquipments = Equipments::getEquipments(false, null, null, false, $oEquipment->image);
                           if (count($oEquipments == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oEquipment->image);
                        } 
            
                        $oEquipment->image = $sOutputFile;
                     } 
                  }
               }
               
               $oFile = CUploadedFile::getInstanceByName('Equipments[attachment]');
               if ($oFile) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                     
                  if (FFile::isCommonRedeableTextFromFileType($oFile->extensionName, true)) {  
                     $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS;
                     $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                     if ($oFile->saveAs($sOriginalFileUrl)) {
                        if ((!FString::isNullOrEmpty($oEquipment->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment)) && ($oEquipment->attachment != $sOriginalFileUrl)) {
                           $oEquipments = Equipments::getEquipments(false, null, null, false, null, null, $oEquipment->attachment);
                           if (count($oEquipments == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment);
                        } 
                        
                        $oEquipment->attachment = $sOriginalFile;
                     }  
                  }
               }
               
               $oEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailEquipment', array('nIdForm'=>$oEquipment->id)));
            }
            else $this->render('updateEquipment', array('oModelForm'=>$oEquipment));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateEquipmentComponent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentComponent = EquipmentsComponents::getEquipmentComponent($nIdForm);
                               
      if (!is_null($oEquipmentComponent)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-component-form', $oEquipmentComponent);
      
         if (isset($_POST['EquipmentsComponents'])) {
            $oEquipmentComponent->attributes = $_POST['EquipmentsComponents'];
              
            $oEquipmentComponent->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailEquipmentComponent', array('nIdForm'=>$oEquipmentComponent->id)));
         }
         else $this->render('updateEquipmentComponent', array('oModelForm'=>$oEquipmentComponent));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateComponent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oComponent = Components::getComponent($nIdForm);
                               
      if (!is_null($oComponent)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('component-form', $oComponent);
      
         if (isset($_POST['Components'])) {
            $oComponent->attributes = $_POST['Components'];
              
            $oComponent->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailComponent', array('nIdForm'=>$oComponent->id)));
         }
         else $this->render('updateComponent', array('oModelForm'=>$oComponent));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateBuildSceneZone($nIdZone, $nCoordX, $nCoordY) {
      $oZone = Zones::getZone($nIdZone);
      if (!is_null($oZone)) {
         $oZone->scene_coord_x = $nCoordX; 
         $oZone->scene_coord_y = $nCoordY; 
         
         $oZone->save();  
      }   
   } 
   public function actionUpdateBuildSceneRegion($nIdRegion, $nCoordX, $nCoordY) {
      $oRegion = Regions::getRegion($nIdRegion);
      if (!is_null($oRegion)) {
         $oRegion->scene_coord_x = $nCoordX; 
         $oRegion->scene_coord_y = $nCoordY; 
         
         $oRegion->save();  
      }   
   }
   public function actionUpdateBuildSceneEquipment($nIdEquipment, $nCoordX, $nCoordY) {
      $oEquipment = Equipments::getEquipment($nIdEquipment);
      if (!is_null($oEquipment)) {
         $oEquipment->scene_coord_x = $nCoordX; 
         $oEquipment->scene_coord_y = $nCoordY; 
         
         $oEquipment->save();  
      }   
   }
   public function actionUpdateScheduledTask($nIdForm, $sIdComponents = FString::STRING_EMPTY, $sIdDepartments = FString::STRING_EMPTY) { 
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::getMaintenanceScheduledTask($nIdForm);
      $bError = false;

      if (!is_null($oMaintenanceScheduledTask)) {
         $oMaintenanceScheduledTaskComponents = MaintenanceScheduledTasksComponents::getMaintenanceScheduledTaskComponentsByIdFormFK($oMaintenanceScheduledTask->id);
         $oMaintenanceScheduledTaskDepartments = MaintenanceScheduledTasksDepartments::getMaintenanceScheduledTaskDepartmentsByIdFormFK($oMaintenanceScheduledTask->id);
         
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('maintenance-scheduled-task-form', $oMaintenanceScheduledTask);
    
         if (isset($_POST['MaintenanceScheduledTasks'])) {
            $sTempAttachment = $oMaintenanceScheduledTask->attachment;
            $oMaintenanceScheduledTask->attributes = $_POST['MaintenanceScheduledTasks'];
            $oMaintenanceScheduledTask->attachment = null;
               
            $oMaintenanceScheduledTask->execution_date = FDate::getEnglishDate($_POST['MaintenanceScheduledTasks']['execution_date']);
            $oMaintenancePriorities = MaintenancePriorities::getMaintenancePriorityByDescription($_POST['MaintenanceScheduledTasks']['priority']);
            if (!is_null($oMaintenancePriorities)) {
               $oMaintenanceScheduledTask->priority_number = $oMaintenancePriorities->priority;   
            }
            $oMaintenanceScheduledTask->id_user = Yii::app()->user->id;

            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) $oMaintenanceScheduledTask->owner = $sCurrentUser;
            else { 
               $bError = true; 
               Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_SUBMIT_ERROR_UNKNOWN'));
            }
           
            $oIdsDepartments = explode(',', $sIdDepartments);
            if ((count($oIdsDepartments) == 0) || ($sIdDepartments == FString::STRING_NULL)) {
               $bError = true; 
               Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWSCHEDULEDTASKS_FORM_SUBMIT_ERROR_DEPARTMENT_NOT_SELECTED'));
            }
         
            if (!$bError) {
               $oFile = CUploadedFile::getInstanceByName('MaintenanceScheduledTasks[attachment]');
               if ($oFile) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                     
                  if (FFile::isCommonRedeableTextFromFileType($oFile->extensionName, true)) {  
                     $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS;
                     $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                     if ($oFile->saveAs($sOriginalFileUrl)) {
                        if ((!FString::isNullOrEmpty($sTempAttachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $sTempAttachment)) && ($sTempAttachment != $sOriginalFile)) {
                           $oMaintenanceScheduledTasks = MaintenanceScheduledTasks::getMaintenanceScheduledTasks($sTempAttachment);
                           if (count($oMaintenanceScheduledTasks == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $sTempAttachment);
                        } 
                           
                        $oMaintenanceScheduledTask->attachment = $sOriginalFile;
                     }
                  }
               } 
                
               if ($oMaintenanceScheduledTask->save()) {
                  $bNewComponent = false;
                  $oIdsComponents = explode(',', $sIdComponents);
                  foreach($oIdsComponents as $nIdComponent) {
                     $oComponent = Components::getComponent($nIdComponent);
                     if (!is_null($oComponent)) {
                        $oMaintenanceScheduledTaskComponent = MaintenanceScheduledTasksComponents::getMaintenanceScheduledTaskComponentByIdComponentAndIdFormFK($oComponent->id, $oMaintenanceScheduledTask->id); 
                        if (is_null($oMaintenanceScheduledTaskComponent)) $bNewComponent = true;
                     } 
                  }
                
                  $oMaintenanceScheduledTaskComponents = MaintenanceScheduledTasksComponents::getMaintenanceScheduledTaskComponentsByIdFormFK($oMaintenanceScheduledTask->id);
                
                  if (($bNewComponent) || (count($oIdsComponents) != count($oMaintenanceScheduledTaskComponents))) {
                     // Delete all components
                     foreach($oMaintenanceScheduledTaskComponents as $oMaintenanceScheduledTaskComponent) $oMaintenanceScheduledTaskComponent->delete();
                   
                     foreach($oIdsComponents as $nIdComponent) {
                        $oComponent = Components::getComponent($nIdComponent);
                        if (!is_null($oComponent)) {
                           $oMaintenanceScheduledTaskComponent = new MaintenanceScheduledTasksComponents();
                           $oMaintenanceScheduledTaskComponent->id_component = $oComponent->id;
                           $oMaintenanceScheduledTaskComponent->id_scheduled_task = $oMaintenanceScheduledTask->id; 
                         
                           $oMaintenanceScheduledTaskComponent->save(); 
                        } 
                     }
                  }
                  
                  // Delete all departments
                  $oMaintenanceScheduledTaskDepartments = MaintenanceScheduledTasksDepartments::getMaintenanceScheduledTaskDepartmentsByIdFormFK($oMaintenanceScheduledTask->id);
                  
                  foreach($oMaintenanceScheduledTaskDepartments as $oMaintenanceScheduledTaskDepartment) $oMaintenanceScheduledTaskDepartment->delete();
                
                  foreach($oIdsDepartments as $nIdDepartment) {
                     $oMaintenanceScheduledTaskDepartment = new MaintenanceScheduledTasksDepartments();
                     $oMaintenanceScheduledTaskDepartment->name = $nIdDepartment;
                     $oMaintenanceScheduledTaskDepartment->id_scheduled_task = $oMaintenanceScheduledTask->id; 
                      
                     $oMaintenanceScheduledTaskDepartment->save();
                  }
               }

               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailScheduledTask', array('nIdForm'=>$oMaintenanceScheduledTask->id)));
            }
            else {  
               $this->render('updateScheduledTask', array('oModelForm'=>$oMaintenanceScheduledTask, 'oModelFormComponents'=>$oMaintenanceScheduledTaskComponents, 'oModelFormDepartments'=>$oMaintenanceScheduledTaskDepartments));   
            }
         }
         else $this->render('updateScheduledTask', array('oModelForm'=>$oMaintenanceScheduledTask, 'oModelFormComponents'=>$oMaintenanceScheduledTaskComponents, 'oModelFormDepartments'=>$oMaintenanceScheduledTaskDepartments));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }   
   public function actionUpdatePriority($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenancePriority = MaintenancePriorities::getMaintenancePriority($nIdForm);
                               
      if (!is_null($oMaintenancePriority)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('maintenance-priority-form', $oMaintenancePriority);
      
         if (isset($_POST['MaintenancePriorities'])) {
            $oMaintenancePriority->attributes = $_POST['MaintenancePriorities'];
              
            $oMaintenancePriority->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailPriority', array('nIdForm'=>$oMaintenancePriority->id)));
         }
         else $this->render('updatePriority', array('oModelForm'=>$oMaintenancePriority));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateDepartment($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMaintenanceDepartment = MaintenanceDepartments::getMaintenanceDepartment($nIdForm);
                               
      if (!is_null($oMaintenanceDepartment)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('maintenance-department-form', $oMaintenanceDepartment);
      
         if (isset($_POST['MaintenanceDepartments'])) {
            $oMaintenanceDepartment->attributes = $_POST['MaintenanceDepartments'];
              
            $oMaintenanceDepartment->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDetailDepartment', array('nIdForm'=>$oMaintenanceDepartment->id)));
         }
         else $this->render('updateDepartment', array('oModelForm'=>$oMaintenanceDepartment));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionDeleteZone($nIdForm) {
      $oZone = Zones::getZone($nIdForm);
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            if ((!FString::isNullOrEmpty($oZone->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oZone->image))) {
               $oZones = Zones::getZones($oZone->image);
               if (count($oZones == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oZone->image);
            }
                 
            if ((!FString::isNullOrEmpty($oZone->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image))) {
               $oZones = Zones::getZones(null, $oZone->scene_image);
               if (count($oZones == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image);
            }
            
            $oZone->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteZoneRegion($nIdForm) {
      $oZoneRegion = ZonesRegions::getZoneRegion($nIdForm);
      if (!is_null($oZoneRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) $oZoneRegion->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteRegion($nIdForm) {
      $oRegion = Regions::getRegion($nIdForm);
      if (!is_null($oRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            if ((!FString::isNullOrEmpty($oRegion->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oRegion->image))) {
               $oRegions = Regions::getRegions(null, false, $oRegion->image);
               if (count($oRegions == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oRegion->image);
            }
                 
            if ((!FString::isNullOrEmpty($oRegion->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'regions/' . $oRegion->scene_image))) {
               $oRegions = Regions::getRegions(null, false, null, $oRegion->scene_image);
               if (count($oRegions == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'regions/' . $oRegion->scene_image);
            }
            
            $oRegion->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteRegionEquipment($nIdForm) {
      $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdForm);
      if (!is_null($oRegionEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) $oRegionEquipment->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteEquipment($nIdForm) {
      $oEquipment = Equipments::getEquipment($nIdForm);
      if (!is_null($oEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
            if ((!FString::isNullOrEmpty($oEquipment->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oEquipment->image))) {
               $oEquipments = Equipments::getEquipments(false, null, null, false, $oEquipment->image);
               if (count($oEquipments == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oEquipment->image);
            }
            
            if ((!FString::isNullOrEmpty($oEquipment->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'equipments/' . $oEquipment->scene_image))) {
               $oEquipments = Equipments::getEquipments(false, null, null, false, null, $oEquipment->scene_image);
               if (count($oEquipments == 1)) unlink(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'equipments/' . $oEquipment->scene_image);
            }
            
            if ((!FString::isNullOrEmpty($oEquipment->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment))) {
               $oEquipments = Equipments::getEquipments(false, null, null, false, null, null, $oEquipment->attachment);
               if (count($oEquipments == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS . $oEquipment->attachment);
            }
            
            $oEquipment->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
        
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewEquipments'));
   }
   public function actionDeleteEquipmentComponent($nIdForm) {
      $oEquipmentComponent = EquipmentsComponents::getEquipmentComponent($nIdForm);
      if (!is_null($oEquipmentComponent)) {
         $oEquipmentComponent->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewEquipments'));
   }
   public function actionDeleteComponent($nIdForm) {
      $oComponent = Components::getComponent($nIdForm);
      if (!is_null($oComponent)) {
         $oComponent->delete();
      }
        
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewComponents'));
   }
   public function actionDeleteScheduledTask($nIdForm) {
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::getMaintenanceScheduledTask($nIdForm);
      if (!is_null($oMaintenanceScheduledTask)) {
         if ((!FString::isNullOrEmpty($oMaintenanceScheduledTask->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment))) {
            $oMaintenanceScheduledTasks = MaintenanceScheduledTasks::getMaintenanceScheduledTasks($oMaintenanceScheduledTask->attachment);
            if (count($oMaintenanceScheduledTasks == 1)) unlink(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment);
         }  
         
         $oMaintenanceScheduledTask->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewScheduledTasks'));
   }
   public function actionDeletePriority($nIdForm) {
      $oMaintenancePriority = MaintenancePriorities::getMaintenancePriority($nIdForm);
      if (!is_null($oMaintenancePriority)) $oMaintenancePriority->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewPriorities'));
   }
   public function actionDeleteDepartment($nIdForm) {
      $oMaintenanceDepartment = MaintenanceDepartments::getMaintenanceDepartment($nIdForm);
      if (!is_null($oMaintenanceDepartment)) $oMaintenanceDepartment->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewDepartments'));
   }
}