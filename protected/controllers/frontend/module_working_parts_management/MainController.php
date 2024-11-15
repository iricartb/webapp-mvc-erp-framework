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
            'actions'=>array('viewFormsWorkingParts', 'viewFormsMaintenanceWorkingParts', 'viewFormsSpecialWorkingParts', 'viewFormsWorkRequests', 'viewDetailFormWorkRequest'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('allow', // allow authenticated user and have valid module roles to perform actions                                                                                                                                          
            'actions'=>array('viewFormWorkingPartEmployees', 'viewFormWorkingPartRisksIPEs', 'viewFormWorkingPartDynamicTexts', 'viewFormMaintenanceWorkingPartRisksIPEs', 'viewFormMaintenanceWorkingPartDynamicTexts', 'viewFormSpecialWorkingPartEmployees', 'viewFormSpecialWorkingPartMeansIPEs', 'viewFormSpecialWorkingPartDynamicTexts', 'createFormWorkingPart', 'createFormMaintenanceWorkingPart', 'createFormSpecialWorkingPart', 'refreshFormWorkingPartRegions', 'refreshFormWorkingPartEquipments', 'refreshFormWorkingPartComponents', 'refreshFormWorkingPartStatus', 'refreshFormWorkingPartInformation', 'refreshFormWorkingPartMeasure', 'refreshFormWorkingPartEquipmentCondition', 'refreshFormMaintenanceWorkingPartRegions', 'refreshFormMaintenanceWorkingPartEquipments', 'refreshFormMaintenanceWorkingPartComponents', 'refreshFormMaintenanceWorkingPartStatus', 'refreshFormMaintenanceWorkingPartInformation', 'refreshFormMaintenanceWorkingPartMeasure', 'refreshFormMaintenanceWorkingPartEquipmentCondition', 'refreshFormSpecialWorkingPartStatus', 'refreshFormSpecialWorkingPartInformation', 'refreshFormSpecialWorkingPartMeasure', 'refreshFormSpecialWorkingPartEquipmentCondition', 'updateFormWorkingPart', 'updateFormWorkingPartEmployees', 'updateFormWorkingPartRisksIPEs', 'updateFormWorkingPartDynamicTexts', 'updateFormMaintenanceWorkingPart', 'updateFormMaintenanceWorkingPartRisksIPEs', 'updateFormMaintenanceWorkingPartDynamicTexts', 'updateFormSpecialWorkingPart', 'updateFormSpecialWorkingPartEmployees', 'updateFormSpecialWorkingPartMeansIPEs', 'updateFormSpecialWorkingPartDynamicTexts', 'updateFormWorkRequest', 'viewDetailFormWorkingPart', 'viewDetailFormMaintenanceWorkingPart', 'viewDetailFormSpecialWorkingPart', 'deleteFormWorkingPart', 'deleteFormWorkingPartEmployee', 'deleteFormWorkingPartRisk', 'deleteFormWorkingPartIPE', 'deleteFormWorkingPartMeasure', 'deleteFormWorkingPartEquipmentCondition', 'deleteFormWorkingPartComponent', 'deleteFormMaintenanceWorkingPart', 'deleteFormMaintenanceWorkingPartRisk', 'deleteFormMaintenanceWorkingPartIPE', 'deleteFormMaintenanceWorkingPartMeasure', 'deleteFormMaintenanceWorkingPartEquipmentCondition', 'deleteFormSpecialWorkingPart', 'deleteFormSpecialWorkingPartEmployee', 'deleteFormSpecialWorkingPartPreventionMean', 'deleteFormSpecialWorkingPartIPE', 'deleteFormSpecialWorkingPartMeasure', 'deleteFormSpecialWorkingPartEquipmentCondition', 'deleteFormWorkRequest'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)))',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   
   public function actionViewFormsWorkingParts() {
      $oFormWorkingPart = new FormsWorkingParts();
      $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
      
      // Delete incomplete forms
      $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(false, Yii::app()->user->id);
      foreach($oFormsWorkingParts as $oFormWorkingPart) $oFormWorkingPart->delete(); 
      
      $oFormWorkingPart->unsetAttributes();
      
      if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->working_part_show_status_running == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->working_part_show_status_finalized == false))) $oFormWorkingPart->sFilterStatusCreated = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending)) $oFormWorkingPart->sFilterStatusPending = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_running)) $oFormWorkingPart->sFilterStatusRunning = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence)) $oFormWorkingPart->sFilterStatusPendingAbsence = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_halted)) $oFormWorkingPart->sFilterStatusHalted = true;
      
      // Filters Grid Get Parameters 
      if (isset($_GET['FormsWorkingParts'])) {
         $oFormWorkingPart->attributes = $_GET['FormsWorkingParts'];
         if (isset($_GET['FormsWorkingParts']['start_date'])) $oFormWorkingPart->start_date = $_GET['FormsWorkingParts']['start_date'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusCreated'])) $oFormWorkingPart->sFilterStatusCreated = $_GET['FormsWorkingParts']['sFilterStatusCreated'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusPending'])) $oFormWorkingPart->sFilterStatusPending = $_GET['FormsWorkingParts']['sFilterStatusPending'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusRunning'])) $oFormWorkingPart->sFilterStatusRunning = $_GET['FormsWorkingParts']['sFilterStatusRunning'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusPendingAbsence'])) $oFormWorkingPart->sFilterStatusPendingAbsence = $_GET['FormsWorkingParts']['sFilterStatusPendingAbsence'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusHalted'])) $oFormWorkingPart->sFilterStatusHalted = $_GET['FormsWorkingParts']['sFilterStatusHalted'];
         if (isset($_GET['FormsWorkingParts']['sFilterStatusFinalized'])) $oFormWorkingPart->sFilterStatusFinalized = $_GET['FormsWorkingParts']['sFilterStatusFinalized'];
      }

      $this->render('viewFormsWorkingParts', array('oModelForm'=>$oFormWorkingPart)); 
   }   
   public function actionViewFormWorkingPartEmployees($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
      
      if (!is_null($oFormWorkingPart)) {
         if (!$oFormWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormWorkingPartEmployee = new FormWorkingPartEmployees();
         
         if (isset($_POST['FormWorkingPartEmployees'])) {
            $oFormWorkingPartEmployee->attributes = $_POST['FormWorkingPartEmployees'];
            $oFormWorkingPartEmployee->id_form_working_part = $oFormWorkingPart->id;
            $oFormWorkingPartEmployee->save();
         }

         $oFormWorkingPartEmployee->unsetAttributes();
         $oFormWorkingPartEmployee->id_form_working_part = $oFormWorkingPart->id;
         
         $oEmployees = null;
         $oVisitorsVisits = null;
         
         try {
            $oEmployees = RemoteEmployees::getInsideDataProviderEmployees();
                              
            $oVisitorsVisits = RemoteVisitorsVisits::getInsideDataProviderVisitorsVisits();
         } catch(Exception $oException) { }
         
         $this->render('viewFormWorkingPartEmployees', array('oModelForm'=>$oFormWorkingPartEmployee, 'oModelFormEmployees'=>$oEmployees, 'oModelFormVisitors'=>$oVisitorsVisits)); 
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormWorkingPartRisksIPEs($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
       
      if (!is_null($oFormWorkingPart)) {
         if (!$oFormWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormWorkingPartRisk = new FormWorkingPartRisks();
         $oFormWorkingPartIPE = new FormWorkingPartIPEs();

         if (isset($_POST['FormWorkingPartRisks'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-working-part-risk-form', $oFormWorkingPartRisk);
         
            $oFormWorkingPartRisk->attributes = $_POST['FormWorkingPartRisks'];
            $oFormWorkingPartRisk->id_form_working_part = $oFormWorkingPart->id;
            $oFormWorkingPartRisk->save();
         }
         else if (isset($_POST['FormWorkingPartIPEs'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-working-part-ipe-form', $oFormWorkingPartRisk);
         
            $oFormWorkingPartIPE->attributes = $_POST['FormWorkingPartIPEs'];
            $oFormWorkingPartIPE->id_form_working_part = $oFormWorkingPart->id;
            $oFormWorkingPartIPE->save();   
         }
         
         $oFormWorkingPartRisk->unsetAttributes();
         $oFormWorkingPartIPE->unsetAttributes();
         $oFormWorkingPartRisk->id_form_working_part = $oFormWorkingPart->id;
         $oFormWorkingPartIPE->id_form_working_part = $oFormWorkingPart->id;

         $this->render('viewFormWorkingPartRisksIPEs', array('oModelFormRisk'=>$oFormWorkingPartRisk, 'oModelFormIPE'=>$oFormWorkingPartIPE)); 
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormWorkingPartDynamicTexts($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
      $bError = false;
            
      if (!is_null($oFormWorkingPart)) {
         if (!$oFormWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormWorkingPartMeasure = new FormWorkingPartMeasures();
         $oFormWorkingPartEquipmentCondition = new FormWorkingPartEquipmentConditions();
         
         if (isset($_POST['FormWorkingPartMeasures'])) {             
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-working-part-measure-form', $oFormWorkingPartMeasure);
         
            $nWorkingPartMeasures = count(FormWorkingPartMeasures::getFormWorkingPartMeasuresByIdFormFK($oFormWorkingPart->id)); 
            if ($nWorkingPartMeasures >= (FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormWorkingPartMeasure->attributes = $_POST['FormWorkingPartMeasures'];
               
               $oMeasure = Measures::getMeasureByDescription($oFormWorkingPartMeasure->description);
               if (!is_null($oMeasure)) {
                  $oFormWorkingPartMeasure->alert = $oMeasure->alert;
                  $oFormWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                  $oFormWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                  $oFormWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                  $oFormWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                  $oFormWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action;
                  $oFormWorkingPartMeasure->information = $oMeasure->information;    
               }
               
               $oFormWorkingPartMeasure->value = 3;
               $oFormWorkingPartMeasure->id_form_working_part = $oFormWorkingPart->id;
               $oFormWorkingPartMeasure->save();
            }
         }
         else if (isset($_POST['FormWorkingPartEquipmentConditions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-working-part-equipment-condition-form', $oFormWorkingPartEquipmentCondition);
         
            $nWorkingPartEquipmentConditions = count(FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentConditionsByIdFormFK($oFormWorkingPart->id)); 
            if ($nWorkingPartEquipmentConditions >= (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormWorkingPartEquipmentCondition->attributes = $_POST['FormWorkingPartEquipmentConditions'];

               $oEquipmentCondition = EquipmentConditions::getEquipmentConditionByDescription($oFormWorkingPartEquipmentCondition->description);
               if (!is_null($oEquipmentCondition)) {
                  $oFormWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                  $oFormWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                  $oFormWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                  $oFormWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                  $oFormWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;  
                  $oFormWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
               }
               
               $oFormWorkingPartEquipmentCondition->value = 3;
               $oFormWorkingPartEquipmentCondition->id_form_working_part = $oFormWorkingPart->id;
               $oFormWorkingPartEquipmentCondition->save();
            }   
         }
         
         $oFormWorkingPartMeasure->unsetAttributes();
         $oFormWorkingPartEquipmentCondition->unsetAttributes();
         $oFormWorkingPartMeasure->id_form_working_part = $oFormWorkingPart->id;
         $oFormWorkingPartEquipmentCondition->id_form_working_part = $oFormWorkingPart->id;
         
         $this->render('viewFormWorkingPartDynamicTexts', array('oModelFormMeasure'=>$oFormWorkingPartMeasure, 'oModelFormEquipmentCondition'=>$oFormWorkingPartEquipmentCondition));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormsMaintenanceWorkingParts() {
      $oFormMaintenanceWorkingPart = new FormsMaintenanceWorkingParts();
      $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
      
      // Delete incomplete forms
      $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(false, Yii::app()->user->id);
      foreach($oFormsMaintenanceWorkingParts as $oFormMaintenanceWorkingPart) $oFormMaintenanceWorkingPart->delete(); 
      
      $oFormMaintenanceWorkingPart->unsetAttributes();

      if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_finalized == false))) $oFormMaintenanceWorkingPart->sFilterStatusCreated = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending)) $oFormMaintenanceWorkingPart->sFilterStatusPending = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running)) $oFormMaintenanceWorkingPart->sFilterStatusRunning = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending_absence)) $oFormMaintenanceWorkingPart->sFilterStatusPendingAbsence = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_halted)) $oFormMaintenanceWorkingPart->sFilterStatusHalted = true;
      
      // Filters Grid Get Parameters
      if (isset($_GET['FormsMaintenanceWorkingParts'])) {
         $oFormMaintenanceWorkingPart->attributes = $_GET['FormsMaintenanceWorkingParts'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['start_date'])) $oFormMaintenanceWorkingPart->start_date = $_GET['FormsMaintenanceWorkingParts']['start_date'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusCreated'])) $oFormMaintenanceWorkingPart->sFilterStatusCreated = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusCreated'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusPending'])) $oFormMaintenanceWorkingPart->sFilterStatusPending = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusPending'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusRunning'])) $oFormMaintenanceWorkingPart->sFilterStatusRunning = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusRunning'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusPendingAbsence'])) $oFormMaintenanceWorkingPart->sFilterStatusPendingAbsence = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusPendingAbsence'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusHalted'])) $oFormMaintenanceWorkingPart->sFilterStatusHalted = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusHalted'];
         if (isset($_GET['FormsMaintenanceWorkingParts']['sFilterStatusFinalized'])) $oFormMaintenanceWorkingPart->sFilterStatusFinalized = $_GET['FormsMaintenanceWorkingParts']['sFilterStatusFinalized'];
      }

      $this->render('viewFormsMaintenanceWorkingParts', array('oModelForm'=>$oFormMaintenanceWorkingPart)); 
   }
   public function actionViewFormMaintenanceWorkingPartRisksIPEs($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
       
      if (!is_null($oFormMaintenanceWorkingPart)) {
         if (!$oFormMaintenanceWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormMaintenanceWorkingPartRisk = new FormMaintenanceWorkingPartRisks();
         $oFormMaintenanceWorkingPartIPE = new FormMaintenanceWorkingPartIPEs();

         if (isset($_POST['FormMaintenanceWorkingPartRisks'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-maintenance-working-part-risk-form', $oFormMaintenanceWorkingPartRisk);
         
            $oFormMaintenanceWorkingPartRisk->attributes = $_POST['FormMaintenanceWorkingPartRisks'];
            $oFormMaintenanceWorkingPartRisk->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
            $oFormMaintenanceWorkingPartRisk->save();
         }
         else if (isset($_POST['FormMaintenanceWorkingPartIPEs'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-maintenance-working-part-ipe-form', $oFormMaintenanceWorkingPartIPE);
         
            $oFormMaintenanceWorkingPartIPE->attributes = $_POST['FormMaintenanceWorkingPartIPEs'];
            $oFormMaintenanceWorkingPartIPE->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
            $oFormMaintenanceWorkingPartIPE->save();   
         }
         
         $oFormMaintenanceWorkingPartRisk->unsetAttributes();
         $oFormMaintenanceWorkingPartIPE->unsetAttributes();
         $oFormMaintenanceWorkingPartRisk->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
         $oFormMaintenanceWorkingPartIPE->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;

         $this->render('viewFormMaintenanceWorkingPartRisksIPEs', array('oModelFormRisk'=>$oFormMaintenanceWorkingPartRisk, 'oModelFormIPE'=>$oFormMaintenanceWorkingPartIPE)); 
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormMaintenanceWorkingPartDynamicTexts($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
      $bError = false;
            
      if (!is_null($oFormMaintenanceWorkingPart)) {
         if (!$oFormMaintenanceWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormMaintenanceWorkingPartMeasure = new FormMaintenanceWorkingPartMeasures();
         $oFormMaintenanceWorkingPartEquipmentCondition = new FormMaintenanceWorkingPartEquipmentConditions();
         
         if (isset($_POST['FormMaintenanceWorkingPartMeasures'])) {             
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-maintenance-working-part-measure-form', $oFormMaintenanceWorkingPartMeasure);
         
            $nWorkingPartMeasures = count(FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasuresByIdFormFK($oFormMaintenanceWorkingPart->id)); 
            if ($nWorkingPartMeasures >= (FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormMaintenanceWorkingPartMeasure->attributes = $_POST['FormMaintenanceWorkingPartMeasures'];
               
               $oMeasure = Measures::getMeasureByDescription($oFormMaintenanceWorkingPartMeasure->description);
               if (!is_null($oMeasure)) {
                  $oFormMaintenanceWorkingPartMeasure->alert = $oMeasure->alert;
                  $oFormMaintenanceWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                  $oFormMaintenanceWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                  $oFormMaintenanceWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                  $oFormMaintenanceWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                  $oFormMaintenanceWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action;
                  $oFormMaintenanceWorkingPartMeasure->information = $oMeasure->information;    
               }
               
               $oFormMaintenanceWorkingPartMeasure->value = 3;
               $oFormMaintenanceWorkingPartMeasure->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
               $oFormMaintenanceWorkingPartMeasure->save();
            }
         }
         else if (isset($_POST['FormMaintenanceWorkingPartEquipmentConditions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-maintenance-working-part-equipment-condition-form', $oFormMaintenanceWorkingPartEquipmentCondition);
         
            $nWorkingPartEquipmentConditions = count(FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentConditionsByIdFormFK($oFormMaintenanceWorkingPart->id)); 
            if ($nWorkingPartEquipmentConditions >= (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormMaintenanceWorkingPartEquipmentCondition->attributes = $_POST['FormMaintenanceWorkingPartEquipmentConditions'];

               $oEquipmentCondition = EquipmentConditions::getEquipmentConditionByDescription($oFormMaintenanceWorkingPartEquipmentCondition->description);
               if (!is_null($oEquipmentCondition)) {
                  $oFormMaintenanceWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                  $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                  $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                  $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                  $oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;  
                  $oFormMaintenanceWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
               }
               
               $oFormMaintenanceWorkingPartEquipmentCondition->value = 3; 
               $oFormMaintenanceWorkingPartEquipmentCondition->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
               $oFormMaintenanceWorkingPartEquipmentCondition->save();
            }   
         }
         
         $oFormMaintenanceWorkingPartMeasure->unsetAttributes();
         $oFormMaintenanceWorkingPartEquipmentCondition->unsetAttributes();
         $oFormMaintenanceWorkingPartMeasure->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
         $oFormMaintenanceWorkingPartEquipmentCondition->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
         
         $this->render('viewFormMaintenanceWorkingPartDynamicTexts', array('oModelFormMeasure'=>$oFormMaintenanceWorkingPartMeasure, 'oModelFormEquipmentCondition'=>$oFormMaintenanceWorkingPartEquipmentCondition));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewFormsSpecialWorkingParts() {
      $oFormSpecialWorkingPart = new FormsSpecialWorkingParts();
      $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
      
      // Delete incomplete forms
      $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts(false, Yii::app()->user->id);
      foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) $oFormSpecialWorkingPart->delete(); 
      
      // Change status finalized forms
      /*$oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getFormsSpecialWorkingParts();
      foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) {
         if ((!is_null($oFormSpecialWorkingPart->start_date)) && (date('Y-m-d', strtotime($oFormSpecialWorkingPart->start_date)) != date('Y-m-d'))) {
            $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
            $oFormSpecialWorkingPart->save();
         }
      }*/
      
      $oFormSpecialWorkingPart->unsetAttributes();
      
      if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized == false))) $oFormSpecialWorkingPart->sFilterStatusCreated = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending)) $oFormSpecialWorkingPart->sFilterStatusPending = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_running)) $oFormSpecialWorkingPart->sFilterStatusRunning = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence)) $oFormSpecialWorkingPart->sFilterStatusPendingAbsence = true;
      if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted)) $oFormSpecialWorkingPart->sFilterStatusHalted = true;
      
      // Filters Grid Get Parameters
      if (isset($_GET['FormsSpecialWorkingParts'])) {
         $oFormSpecialWorkingPart->attributes = $_GET['FormsSpecialWorkingParts'];
         if (isset($_GET['FormsSpecialWorkingParts']['start_date'])) $oFormSpecialWorkingPart->start_date = $_GET['FormsSpecialWorkingParts']['start_date'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusCreated'])) $oFormSpecialWorkingPart->sFilterStatusCreated = $_GET['FormsSpecialWorkingParts']['sFilterStatusCreated'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusPending'])) $oFormSpecialWorkingPart->sFilterStatusPending = $_GET['FormsSpecialWorkingParts']['sFilterStatusPending'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusRunning'])) $oFormSpecialWorkingPart->sFilterStatusRunning = $_GET['FormsSpecialWorkingParts']['sFilterStatusRunning'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusPendingAbsence'])) $oFormSpecialWorkingPart->sFilterStatusPendingAbsence = $_GET['FormsSpecialWorkingParts']['sFilterStatusPendingAbsence'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusHalted'])) $oFormSpecialWorkingPart->sFilterStatusHalted = $_GET['FormsSpecialWorkingParts']['sFilterStatusHalted'];
         if (isset($_GET['FormsSpecialWorkingParts']['sFilterStatusFinalized'])) $oFormSpecialWorkingPart->sFilterStatusFinalized = $_GET['FormsSpecialWorkingParts']['sFilterStatusFinalized'];
      }

      $this->render('viewFormsSpecialWorkingParts', array('oModelForm'=>$oFormSpecialWorkingPart)); 
   }
   public function actionViewFormSpecialWorkingPartEmployees($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
      
      if (!is_null($oFormSpecialWorkingPart)) {
         if (!$oFormSpecialWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormSpecialWorkingPartEmployee = new FormSpecialWorkingPartEmployees();
         
         if (isset($_POST['FormSpecialWorkingPartEmployees'])) {
            $oFormSpecialWorkingPartEmployee->attributes = $_POST['FormSpecialWorkingPartEmployees'];
            $oFormSpecialWorkingPartEmployee->id_form_special_working_part = $oFormSpecialWorkingPart->id;
            $oFormSpecialWorkingPartEmployee->save();
         }

         $oFormSpecialWorkingPartEmployee->unsetAttributes();
         $oFormSpecialWorkingPartEmployee->id_form_special_working_part = $oFormSpecialWorkingPart->id;
         
         $oEmployees = null;
         $oVisitorsVisits = null;
         
         try {
            $oEmployees = RemoteEmployees::getInsideDataProviderEmployees();
                              
            $oVisitorsVisits = RemoteVisitorsVisits::getInsideDataProviderVisitorsVisits();
         } catch(Exception $oException) { }
         
         $this->render('viewFormSpecialWorkingPartEmployees', array('oModelForm'=>$oFormSpecialWorkingPartEmployee, 'oModelFormEmployees'=>$oEmployees, 'oModelFormVisitors'=>$oVisitorsVisits)); 
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormSpecialWorkingPartMeansIPEs($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
       
      if (!is_null($oFormSpecialWorkingPart)) {
         if (!$oFormSpecialWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormSpecialWorkingPartPreventionMean = new FormSpecialWorkingPartPreventionMeans();
         $oFormSpecialWorkingPartIPE = new FormSpecialWorkingPartIPEs();

         if (isset($_POST['FormSpecialWorkingPartPreventionMeans'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-special-working-part-prevention-mean-form', $oFormSpecialWorkingPartPreventionMean);
         
            $oFormSpecialWorkingPartPreventionMean->attributes = $_POST['FormSpecialWorkingPartPreventionMeans'];
            $oFormSpecialWorkingPartPreventionMean->id_form_special_working_part = $oFormSpecialWorkingPart->id;
            $oFormSpecialWorkingPartPreventionMean->save();
         }
         else if (isset($_POST['FormSpecialWorkingPartIPEs'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-special-working-part-ipe-form', $oFormSpecialWorkingPartIPE);
         
            $oFormSpecialWorkingPartIPE->attributes = $_POST['FormSpecialWorkingPartIPEs'];
            $oFormSpecialWorkingPartIPE->id_form_special_working_part = $oFormSpecialWorkingPart->id;
            $oFormSpecialWorkingPartIPE->save();   
         }
         
         $oFormSpecialWorkingPartPreventionMean->unsetAttributes();
         $oFormSpecialWorkingPartIPE->unsetAttributes();
         $oFormSpecialWorkingPartPreventionMean->id_form_special_working_part = $oFormSpecialWorkingPart->id;
         $oFormSpecialWorkingPartIPE->id_form_special_working_part = $oFormSpecialWorkingPart->id;

         $this->render('viewFormSpecialWorkingPartMeansIPEs', array('oModelFormPreventionMean'=>$oFormSpecialWorkingPartPreventionMean, 'oModelFormIPE'=>$oFormSpecialWorkingPartIPE)); 
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionViewFormSpecialWorkingPartDynamicTexts($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
      $bError = false;
            
      if (!is_null($oFormSpecialWorkingPart)) {
         if (!$oFormSpecialWorkingPart->data_completed) $this->layout = FApplication::LAYOUT_FRONTEND;
         
         $oFormSpecialWorkingPartMeasure = new FormSpecialWorkingPartMeasures();
         $oFormSpecialWorkingPartEquipmentCondition = new FormSpecialWorkingPartEquipmentConditions();
         
         if (isset($_POST['FormSpecialWorkingPartMeasures'])) {             
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-special-working-part-measure-form', $oFormSpecialWorkingPartMeasure);
         
            $nWorkingPartMeasures = count(FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasuresByIdFormFK($oFormSpecialWorkingPart->id)); 
            if ($nWorkingPartMeasures >= (FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormSpecialWorkingPartMeasure->attributes = $_POST['FormSpecialWorkingPartMeasures'];
               
               $oMeasure = Measures::getMeasureByDescription($oFormSpecialWorkingPartMeasure->description);
               if (!is_null($oMeasure)) {
                  $oFormSpecialWorkingPartMeasure->alert = $oMeasure->alert;
                  $oFormSpecialWorkingPartMeasure->visible_alert_value_yes = $oMeasure->visible_alert_value_yes;
                  $oFormSpecialWorkingPartMeasure->visible_alert_value_no = $oMeasure->visible_alert_value_no;
                  $oFormSpecialWorkingPartMeasure->visible_alert_value_np = $oMeasure->visible_alert_value_np;
                  $oFormSpecialWorkingPartMeasure->visible_alert_value_default = $oMeasure->visible_alert_value_default;
                  $oFormSpecialWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action;
                  $oFormSpecialWorkingPartMeasure->information = $oMeasure->information;    
               }
               
               $oFormSpecialWorkingPartMeasure->value = 3;
               $oFormSpecialWorkingPartMeasure->id_form_special_working_part = $oFormSpecialWorkingPart->id;
               $oFormSpecialWorkingPartMeasure->save();
            }
         }
         else if (isset($_POST['FormSpecialWorkingPartEquipmentConditions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-special-working-part-equipment-condition-form', $oFormSpecialWorkingPartEquipmentCondition);
         
            $nWorkingPartEquipmentConditions = count(FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentConditionsByIdFormFK($oFormSpecialWorkingPart->id)); 
            if ($nWorkingPartEquipmentConditions >= (FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS + 1)) {
               $bError = true;
            } 
            
            if (!$bError) {
               $oFormSpecialWorkingPartEquipmentCondition->attributes = $_POST['FormSpecialWorkingPartEquipmentConditions'];

               $oEquipmentCondition = EquipmentConditions::getEquipmentConditionByDescription($oFormSpecialWorkingPartEquipmentCondition->description);
               if (!is_null($oEquipmentCondition)) {
                  $oFormSpecialWorkingPartEquipmentCondition->alert = $oEquipmentCondition->alert;
                  $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_yes = $oEquipmentCondition->visible_alert_value_yes;
                  $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_no = $oEquipmentCondition->visible_alert_value_no;
                  $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_np = $oEquipmentCondition->visible_alert_value_np;
                  $oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_default = $oEquipmentCondition->visible_alert_value_default;  
                  $oFormSpecialWorkingPartEquipmentCondition->information = $oEquipmentCondition->information;
               }
               
               $oFormSpecialWorkingPartEquipmentCondition->value = 3; 
               $oFormSpecialWorkingPartEquipmentCondition->id_form_special_working_part = $oFormSpecialWorkingPart->id;
               $oFormSpecialWorkingPartEquipmentCondition->save();
            }   
         }
         
         $oFormSpecialWorkingPartMeasure->unsetAttributes();
         $oFormSpecialWorkingPartEquipmentCondition->unsetAttributes();
         $oFormSpecialWorkingPartMeasure->id_form_special_working_part = $oFormSpecialWorkingPart->id;
         $oFormSpecialWorkingPartEquipmentCondition->id_form_special_working_part = $oFormSpecialWorkingPart->id;
         
         $this->render('viewFormSpecialWorkingPartDynamicTexts', array('oModelFormMeasure'=>$oFormSpecialWorkingPartMeasure, 'oModelFormEquipmentCondition'=>$oFormSpecialWorkingPartEquipmentCondition));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewFormsWorkRequests() {
      $oFormWorkRequest = new FormsWorkRequests();
      $oFormWorkRequestFilters = new FormsWorkRequests();
      $oFormWorkRequestFilters->unsetAttributes();
      $bError = false;
      
      $oFormWorkRequestFilters->sFilterStatusPending = true;
      $oFormWorkRequestFilters->bFilterVisibleDate = true;
      
      // Ajax validation request=>Conditional validator
      FForm::validateAjaxForm('form-work-request-form', $oFormWorkRequest);
      
      if ((isset($_POST['FormsWorkRequests'])) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT))) {
         $oFormWorkRequest->attributes = $_POST['FormsWorkRequests'];
          
         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) $oFormWorkRequest->owner = $sCurrentUser;
         else $bError = true;
         
         if (!$bError) {
            $oPriority = Priorities::getPriorityByDescription($_POST['FormsWorkRequests']['priority']);
            if (!is_null($oPriority)) $oFormWorkRequest->priority_number = $oPriority->priority;
            
            $oFormWorkRequest->id_user = Yii::app()->user->id;
            $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_PENDING; 
            $oFormWorkRequest->start_date = date('Y-m-d H:i:s');
            
            $oFormWorkRequest->save();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else {
         if (isset($_POST['FormsWorkRequests'])) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
         else { 
            // Filters Grid Get Parameters
            if (isset($_GET['FormsWorkRequests'])) {
               $oFormWorkRequestFilters->attributes = $_GET['FormsWorkRequests'];   
               if (isset($_GET['FormsWorkRequests']['start_date'])) $oFormWorkRequestFilters->start_date = $_GET['FormsWorkRequests']['start_date'];
               
               if (isset($_GET['FormsWorkRequests']['sFilterStatusPending'])) $oFormWorkRequestFilters->sFilterStatusPending = $_GET['FormsWorkRequests']['sFilterStatusPending'];
               
               if (isset($_GET['FormsWorkRequests']['sFilterStatusFinalized'])) $oFormWorkRequestFilters->sFilterStatusFinalized = $_GET['FormsWorkRequests']['sFilterStatusFinalized'];                                                         
            }
         }
         
         if ((!$oFormWorkRequestFilters->sFilterStatusPending) && (!$oFormWorkRequestFilters->sFilterStatusFinalized)) $oFormWorkRequestFilters->bFilterVisibleDate = false; 
      }

      $oFormWorkRequest->unsetAttributes(); 
      $this->render('viewFormsWorkRequests', array('oModelForm'=>$oFormWorkRequest, 'oModelFormFilters'=>$oFormWorkRequestFilters));
   } 
   
   
   public function actionViewDetailFormWorkingPart($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);

      if (!is_null($oFormWorkingPart)) $this->render('viewDetailFormWorkingPart', array('oModelForm'=>$oFormWorkingPart));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormMaintenanceWorkingPart($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormMaintenaceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);

      if (!is_null($oFormMaintenaceWorkingPart)) $this->render('viewDetailFormMaintenanceWorkingPart', array('oModelForm'=>$oFormMaintenaceWorkingPart));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormSpecialWorkingPart($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);

      if (!is_null($oFormSpecialWorkingPart)) $this->render('viewDetailFormSpecialWorkingPart', array('oModelForm'=>$oFormSpecialWorkingPart));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormWorkRequest($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($nIdForm);

      if (!is_null($oFormWorkRequest)) $this->render('viewDetailFormWorkRequest', array('oModelForm'=>$oFormWorkRequest));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionCreateFormWorkingPart($nIdZone = null, $nIdRegion = null, $nIdEquipment = null) {
      $oFormWorkingPart = new FormsWorkingParts();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oFormWorkingPart->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
         
         $oFormWorkingPart->priority = FString::STRING_EMPTY;
         $oFormWorkingPart->priority_number = 0;
         $oFormWorkingPart->first_responsible = FString::STRING_EMPTY;
         $oFormWorkingPart->method_code = FString::STRING_EMPTY;
         $oFormWorkingPart->method_description = FString::STRING_EMPTY;
         
         if (!FString::isNullOrEmpty($nIdZone)) {
            $oFormWorkingPart->id_zone = $nIdZone;
            $oFormWorkingPart->zone = Zones::getZoneName($nIdZone);
         }
         else $oFormWorkingPart->zone = FString::STRING_EMPTY; 
         
         if (!FString::isNullOrEmpty($nIdRegion)) {
            $oFormWorkingPart->id_region = $nIdRegion;
            $oFormWorkingPart->region = Regions::getRegionName($nIdRegion);
         }
         else $oFormWorkingPart->region = FString::STRING_EMPTY;
         
         if (!FString::isNullOrEmpty($nIdEquipment)) {
            $oFormWorkingPart->id_equipment = $nIdEquipment;
            $oFormWorkingPart->equipment = Equipments::getEquipmentName($nIdEquipment);
         }
         else $oFormWorkingPart->equipment = FString::STRING_EMPTY;
         
         $oFormWorkingPart->equipment_failure_reason = FString::STRING_EMPTY; 
         
         if (!is_null($oWorkingPartModuleParameters)) {
            if ($oWorkingPartModuleParameters->working_part_show_status_created) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
            else if ($oWorkingPartModuleParameters->working_part_show_status_pending) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING;
            else if ($oWorkingPartModuleParameters->working_part_show_status_running) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
            else if ($oWorkingPartModuleParameters->working_part_show_status_pending_absence) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE;
            else if ($oWorkingPartModuleParameters->working_part_show_status_halted) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_HALTED;
            else if ($oWorkingPartModuleParameters->working_part_show_status_finalized) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
            else $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;       
         }
         else $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         
         $oFormWorkingPart->start_date = date('Y-m-d H:i:s');
         $oFormWorkingPart->id_user = Yii::app()->user->id;
         
         if ($oFormWorkingPart->save(false)) {
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
               $oFormWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action; 
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
            
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormWorkingPart', array('nIdForm'=>$oFormWorkingPart->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   public function actionCreateFormMaintenanceWorkingPart($nIdZone = null, $nIdRegion = null, $nIdEquipment = null) {
      $oFormMaintenanceWorkingPart = new FormsMaintenanceWorkingParts();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oFormMaintenanceWorkingPart->owner = $sCurrentUser;
      else $bError = true;
      
      if (!$bError) {
         $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
         
         $oFormMaintenanceWorkingPart->priority = FString::STRING_EMPTY;
         $oFormMaintenanceWorkingPart->priority_number = 0;
         $oFormMaintenanceWorkingPart->first_responsible = FString::STRING_EMPTY;
         $oFormMaintenanceWorkingPart->second_responsible = FString::STRING_EMPTY;
         $oFormMaintenanceWorkingPart->method_code = FString::STRING_EMPTY;
         $oFormMaintenanceWorkingPart->method_description = FString::STRING_EMPTY;

         if (!FString::isNullOrEmpty($nIdZone)) {
            $oFormMaintenanceWorkingPart->id_zone = $nIdZone;
            $oFormMaintenanceWorkingPart->zone = Zones::getZoneName($nIdZone);
         }
         else $oFormMaintenanceWorkingPart->zone = FString::STRING_EMPTY; 
         
         if (!FString::isNullOrEmpty($nIdRegion)) {
            $oFormMaintenanceWorkingPart->id_region = $nIdRegion;
            $oFormMaintenanceWorkingPart->region = Regions::getRegionName($nIdRegion);
         }
         else $oFormMaintenanceWorkingPart->region = FString::STRING_EMPTY;
         
         if (!FString::isNullOrEmpty($nIdEquipment)) {
            $oFormMaintenanceWorkingPart->id_equipment = $nIdEquipment;
            $oFormMaintenanceWorkingPart->equipment = Equipments::getEquipmentName($nIdEquipment);
         }
         else $oFormMaintenanceWorkingPart->equipment = FString::STRING_EMPTY;

         $oFormMaintenanceWorkingPart->equipment_failure_reason = FString::STRING_EMPTY; 

         if (!is_null($oWorkingPartModuleParameters)) {
            if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
            else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING;
            else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
            else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending_absence) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE;
            else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_halted) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_HALTED;
            else if ($oWorkingPartModuleParameters->maintenance_working_part_show_status_finalized) $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
            else $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;         
         }
         else $oFormMaintenanceWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         
         $oFormMaintenanceWorkingPart->start_date = date('Y-m-d H:i:s');
         $oFormMaintenanceWorkingPart->id_user = Yii::app()->user->id;
         
         if ($oFormMaintenanceWorkingPart->save(false)) {
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
               $oFormMaintenanceWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action;
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
            
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormMaintenanceWorkingPart', array('nIdForm'=>$oFormMaintenanceWorkingPart->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   public function actionCreateFormSpecialWorkingPart() {
      $oFormSpecialWorkingPart = new FormsSpecialWorkingParts();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oFormSpecialWorkingPart->owner = $sCurrentUser;
      else $bError = true;
      
      if (!$bError) {
         $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
         
         $oFormSpecialWorkingPart->first_responsible = FString::STRING_EMPTY;
         $oFormSpecialWorkingPart->method_code = FString::STRING_EMPTY;
         $oFormSpecialWorkingPart->method_description = FString::STRING_EMPTY;
         $oFormSpecialWorkingPart->installation = FString::STRING_EMPTY;
         $oFormSpecialWorkingPart->work = FString::STRING_EMPTY;
         $oFormSpecialWorkingPart->work_description = FString::STRING_EMPTY;

         if (!is_null($oWorkingPartModuleParameters)) {
            if ($oWorkingPartModuleParameters->special_working_part_show_status_created) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
            else if ($oWorkingPartModuleParameters->special_working_part_show_status_pending) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING;
            else if ($oWorkingPartModuleParameters->special_working_part_show_status_running) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_RUNNING;
            else if ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence) $oFormWorkingPart->status = FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE;
            else if ($oWorkingPartModuleParameters->special_working_part_show_status_halted) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_HALTED;
            else if ($oWorkingPartModuleParameters->special_working_part_show_status_finalized) $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
            else $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;      
         }
         else $oFormSpecialWorkingPart->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         
         $oFormSpecialWorkingPart->start_date = date('Y-m-d H:i:s');
         $oFormSpecialWorkingPart->id_user = Yii::app()->user->id;
         
         if ($oFormSpecialWorkingPart->save(false)) {
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
               $oFormSpecialWorkingPartMeasure->required_grade_preventive_action = $oMeasure->required_grade_preventive_action; 
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

            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormSpecialWorkingPart', array('nIdForm'=>$oFormSpecialWorkingPart->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
       
   
   public function actionRefreshFormWorkingPartRegions($nIdForm, $nIdZone) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
         
         if (!is_null($oFormWorkingPart)) {
            $this->layout = null;
            $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartInformation') . '&nIdForm=' . $oFormWorkingPart->id;
            $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartEquipments') . '&nIdForm=' . $oFormWorkingPart->id . '&nIdRegion=';
            $sRefreshEquipmentsUrl = "aj('" . $sRefreshEquipmentsUrl . "' + this.value, null, 'id_equipment')";              

            if ($oFormWorkingPart->data_completed) {
              $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";   
            }  
            else $sJsRefreshInformation = FString::STRING_EMPTY;
            $sJsRefreshDisappearEquipmentOthers = "$('#FormsWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
            $sJsRefreshComponentClear = "$('#FormsWorkingParts_sComponents option').remove()";
                                 
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshDisappearEquipmentOthers . ';' . $sRefreshEquipmentsUrl . ';' . $sJsRefreshComponentClear . ';' . $sJsRefreshInformation . "\" name=\"FormsWorkingParts[id_region]\" id=\"FormsWorkingParts_id_region\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdZone)) {
               $oRegions = Regions::getRegions($nIdZone);
               foreach($oRegions as $oRegion) {
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
   public function actionRefreshFormWorkingPartEquipments($nIdForm, $nIdRegion) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
         
         if (!is_null($oFormWorkingPart)) {
            $this->layout = null;
            $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartInformation') . '&nIdForm=' . $oFormWorkingPart->id;
            $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartComponents') . '&nIdForm=' . $oFormWorkingPart->id . '&nIdEquipment=';
            $sRefreshComponentsUrl = "aj('" . $sRefreshComponentsUrl . "' + this.value, null, 'FormsWorkingParts_sComponents')";              
            
            if ($oFormWorkingPart->data_completed) {
              $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";   
            }  
            else $sJsRefreshInformation = FString::STRING_EMPTY;
            $sJsRefreshEquipmentOthers = "$('#FormsWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
                                    
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshEquipmentOthers . ';' . $sRefreshComponentsUrl . ';' . $sJsRefreshInformation . "\" name=\"FormsWorkingParts[id_equipment]\" id=\"FormsWorkingParts_id_equipment\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdRegion)) {
               $oEquipments = Equipments::getEquipments($nIdRegion, null, null, null, true);
               foreach($oEquipments as $oEquipment) {
                  if (!is_null($oEquipment)) {
                     $sContent .= "<option value=\"" . $oEquipment->id . "\">" . $oEquipment->name . "</option>";    
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
   public function actionRefreshFormWorkingPartComponents($nIdForm, $nIdEquipment) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
         
         if (!is_null($oFormWorkingPart)) { 
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
   public function actionRefreshFormWorkingPartStatus($nIdForm, $sStatus) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
         
         if (!is_null($oFormWorkingPart)) {
            if (($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) || ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED)) {
               $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
               
               $this->layout = null;
               $sContent = FString::STRING_EMPTY;
               $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartStatus') . '&nIdForm=' . $oFormWorkingPart->id . '&sStatus=';
               $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormWorkingPartInformation') . '&nIdForm=' . $oFormWorkingPart->id;
               
               if ($oFormWorkingPart->data_completed) {
                 $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";    
               }  
               else $sJsRefreshInformation = FString::STRING_EMPTY;
     
               // Status created 
               if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_created == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->working_part_show_status_running == false) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence == false) && ($oWorkingPartModuleParameters->working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->working_part_show_status_finalized == false))) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\">";
                  } else {                                                                                                                                                                      
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_CREATED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_CREATED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";

                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_CREATED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_CREATED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
         
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_PENDING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status running
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_running)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_RUNNING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_RUNNING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_RUNNING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending absence
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_pending_absence)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING_ABSENCE . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status halted
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_halted)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_HALTED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_HALTED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_HALTED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_HALTED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status finalized
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->working_part_show_status_finalized)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_FINALIZED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_FINALIZED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_FINALIZED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               $this->renderText($sContent);  
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionRefreshFormWorkingPartInformation($nIdForm) {
      $this->layout = null;
      $sContent = "<div class=\"flash-notice\">";
      $sContent .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKINGPART_FORM_ONCHANGE_ALERT_SAVE');
      $sContent .= "</div>";
      
      $this->renderText($sContent);   
   }
   public function actionRefreshFormWorkingPartMeasure($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormWorkingPartMeasure = FormWorkingPartMeasures::getFormWorkingPartMeasure($nIdForm);
      if (!is_null($oFormWorkingPartMeasure)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormWorkingPartMeasure->visible_alert_value_np))) {
            $sContent = $oFormWorkingPartMeasure->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
   public function actionRefreshFormWorkingPartEquipmentCondition($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormWorkingPartEquipmentCondition = FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentCondition($nIdForm);
      if (!is_null($oFormWorkingPartEquipmentCondition)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormWorkingPartEquipmentCondition->visible_alert_value_np))) {
            $sContent = $oFormWorkingPartEquipmentCondition->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
   public function actionRefreshFormMaintenanceWorkingPartRegions($nIdForm, $nIdZone) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
         
         if (!is_null($oFormMaintenanceWorkingPart)) {
            $this->layout = null;
            $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartInformation') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id;
            $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartEquipments') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id . '&nIdRegion=';
            $sRefreshEquipmentsUrl = "aj('" . $sRefreshEquipmentsUrl . "' + this.value, null, 'id_equipment')";              

            if ($oFormMaintenanceWorkingPart->data_completed) {
              $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";   
            }  
            else $sJsRefreshInformation = FString::STRING_EMPTY;
            $sJsRefreshDisappearEquipmentOthers = "$('#FormsMaintenanceWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
            $sJsRefreshComponentClear = "$('#FormsMaintenanceWorkingParts_sComponents option').remove()";
                                 
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshDisappearEquipmentOthers . ';' . $sRefreshEquipmentsUrl . ';' . $sJsRefreshComponentClear . ';' . $sJsRefreshInformation . "\" name=\"FormsMaintenanceWorkingParts[id_region]\" id=\"FormsMaintenanceWorkingParts_id_region\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdZone)) {
               $oRegions = Regions::getRegions($nIdZone);
               foreach($oRegions as $oRegion) {
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
   public function actionRefreshFormMaintenanceWorkingPartEquipments($nIdForm, $nIdRegion) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
         
         if (!is_null($oFormMaintenanceWorkingPart)) {
            $this->layout = null;
            $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartInformation') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id;
            $sRefreshComponentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartComponents') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id . '&nIdEquipment=';
            $sRefreshComponentsUrl = "aj('" . $sRefreshComponentsUrl . "' + this.value, null, 'FormsMaintenanceWorkingParts_sComponents')";              
            
            if ($oFormMaintenanceWorkingPart->data_completed) {
              $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";   
            }  
            else $sJsRefreshInformation = FString::STRING_EMPTY;
            $sJsRefreshEquipmentOthers = "$('#FormsMaintenanceWorkingParts_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
                                    
            $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshEquipmentOthers . ';' . $sRefreshComponentsUrl . ';' . $sJsRefreshInformation . "\" name=\"FormsMaintenanceWorkingParts[id_equipment]\" id=\"FormsMaintenanceWorkingParts_id_equipment\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdRegion)) {
               $oEquipments = Equipments::getEquipments($nIdRegion, null, null, null, true);
               foreach($oEquipments as $oEquipment) {
                  if (!is_null($oEquipment)) {
                     $sContent .= "<option value=\"" . $oEquipment->id . "\">" . $oEquipment->name . "</option>";    
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
   public function actionRefreshFormMaintenanceWorkingPartComponents($nIdForm, $nIdEquipment) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
         
         if (!is_null($oFormMaintenanceWorkingPart)) { 
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
   public function actionRefreshFormMaintenanceWorkingPartStatus($nIdForm, $sStatus) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
         
         if (!is_null($oFormMaintenanceWorkingPart)) {
            if (($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) || ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED)) {
               $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
               
               $this->layout = null;
               $sContent = FString::STRING_EMPTY;
               $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartStatus') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id . '&sStatus=';
               $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormMaintenanceWorkingPartInformation') . '&nIdForm=' . $oFormMaintenanceWorkingPart->id;
               
               if ($oFormMaintenanceWorkingPart->data_completed) {
                 $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";                                                                 
               }  
               else $sJsRefreshInformation = FString::STRING_EMPTY;
               
               // Status created 
               if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_finalized == false))) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\">";
                  } else {                                                                                                                                                                      
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_CREATED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_CREATED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";

                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_CREATED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_CREATED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
         
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_PENDING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status running
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_running)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_RUNNING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_RUNNING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_RUNNING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending absence
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_pending_absence)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING_ABSENCE . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status halted
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_halted)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_HALTED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_HALTED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_HALTED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_HALTED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status finalized
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->maintenance_working_part_show_status_finalized)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_FINALIZED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_FINALIZED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_FINALIZED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED') . "</font>";
                  $sContent .= "</div></div>";
               }
                                     
               $this->renderText($sContent);   
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionRefreshFormMaintenanceWorkingPartInformation($nIdForm) {
      $this->layout = null;
      $sContent = "<div class=\"flash-notice\">";
      $sContent .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMMAINTENANCEWORKINGPART_FORM_ONCHANGE_ALERT_SAVE');
      $sContent .= "</div>";
      
      $this->renderText($sContent);   
   }
   public function actionRefreshFormMaintenanceWorkingPartMeasure($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormMaintenanceWorkingPartMeasure = FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasure($nIdForm);
      if (!is_null($oFormMaintenanceWorkingPartMeasure)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormMaintenanceWorkingPartMeasure->visible_alert_value_np))) {
            $sContent = $oFormMaintenanceWorkingPartMeasure->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
   public function actionRefreshFormMaintenanceWorkingPartEquipmentCondition($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormMaintenanceWorkingPartEquipmentCondition = FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentCondition($nIdForm);
      if (!is_null($oFormMaintenanceWorkingPartEquipmentCondition)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormMaintenanceWorkingPartEquipmentCondition->visible_alert_value_np))) {
            $sContent = $oFormMaintenanceWorkingPartEquipmentCondition->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
   public function actionRefreshFormSpecialWorkingPartStatus($nIdForm, $sStatus) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
         
         if (!is_null($oFormSpecialWorkingPart)) {
            if (($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) || ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) || ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) || ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED)) {
               $oWorkingPartModuleParameters = WorkingPartModuleParameters::getWorkingPartModuleParameters();
               
               $this->layout = null;
               $sContent = FString::STRING_EMPTY;
               $sRefreshStatusUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartStatus') . '&nIdForm=' . $oFormSpecialWorkingPart->id . '&sStatus=';
               $sRefreshInformationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/refreshFormSpecialWorkingPartInformation') . '&nIdForm=' . $oFormSpecialWorkingPart->id;
               
               if ($oFormSpecialWorkingPart->data_completed) {
                  $sJsRefreshInformation = "aj('" . $sRefreshInformationUrl . "', null, 'id_information', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "','" . FAjax::TYPE_METHOD_CONTENT_DECORATION_FADE . "', 500)";                                                              
               }  
               else $sJsRefreshInformation = FString::STRING_EMPTY;
               
               // Status created 
               if ((is_null($oWorkingPartModuleParameters)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created)) || ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_created == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_running == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted == false) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized == false))) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\">";
                  } else {                                                                                                                                                                      
                     $sContent .= "<div id=\"id_item_created\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_CREATED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_CREATED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_CREATED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_created.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_CREATED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_CREATED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
         
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status running
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_running)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_running\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_RUNNING . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_RUNNING . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_RUNNING) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_running.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_RUNNING . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_RUNNING') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status pending absence
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_pending_absence)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_pending_absence\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_pending_absence.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_PENDING_ABSENCE . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_PENDING_ABSENCE') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status halted
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_halted)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_halted\" class=\"cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_HALTED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_HALTED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_HALTED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_halted.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_HALTED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_HALTED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               // Status finalized
               if ((!is_null($oWorkingPartModuleParameters)) && ($oWorkingPartModuleParameters->special_working_part_show_status_finalized)) {
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\">";
                  } else {
                     $sContent .= "<div id=\"id_item_finalized\" class=\"last_cell\" style=\"cursor:pointer;\" onclick=\"aj('" . $sRefreshStatusUrl . FModuleWorkingPartsManagement::STATUS_FINALIZED . "', null, 'idStatus', null, null, 'jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(\'.item-image-fade-20-round-border\', \'" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS . "\', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0); document.getElementById(\'idStatusField\').value = \'" . FModuleWorkingPartsManagement::STATUS_FINALIZED . "\'');" . $sJsRefreshInformation . "\">";
                  }
                  $sContent .= "<div class=\"item-image\">";
                  
                  if ($sStatus == FModuleWorkingPartsManagement::STATUS_FINALIZED) {
                     $sContent .= "<img class=\"item-image-normal-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  } else {
                     $sContent .= "<img class=\"item-image-fade-20-round-border\" src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . "/status_finalized.png\" width=\"48px\" height=\"48px\">";
                  }
                  $sContent .= "</div>";
                  
                  $sContent .= "<div class=\"item-image-description-center\">";
                  $sContent .= "<font color=\"" . FModuleWorkingPartsManagement::COLOR_STATUS_FINALIZED . "\">" . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS_VALUE_FINALIZED') . "</font>";
                  $sContent .= "</div></div>";
               }
               
               $this->renderText($sContent);   
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionRefreshFormSpecialWorkingPartInformation($nIdForm) {
      $this->layout = null;
      $sContent = "<div class=\"flash-notice\">";
      $sContent .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMSPECIALWORKINGPART_FORM_ONCHANGE_ALERT_SAVE');
      $sContent .= "</div>";
      
      $this->renderText($sContent);   
   }
   public function actionRefreshFormSpecialWorkingPartMeasure($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormSpecialWorkingPartMeasure = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasure($nIdForm);
      if (!is_null($oFormSpecialWorkingPartMeasure)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormSpecialWorkingPartMeasure->visible_alert_value_np))) {
            $sContent = $oFormSpecialWorkingPartMeasure->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
   public function actionRefreshFormSpecialWorkingPartEquipmentCondition($nIdForm, $nValue) {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oFormSpecialWorkingPartEquipmentCondition = FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentCondition($nIdForm);
      if (!is_null($oFormSpecialWorkingPartEquipmentCondition)) {
         if (((!is_null($nValue)) && ($nValue == 1) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_yes)) || ((!is_null($nValue)) && ($nValue == 2) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_no)) || ((!is_null($nValue)) && ($nValue == 3) && ($oFormSpecialWorkingPartEquipmentCondition->visible_alert_value_np))) {
            $sContent = $oFormSpecialWorkingPartEquipmentCondition->alert;      
         }  
      }
      
      $this->renderText($sContent);     
   }
        
   
   public function actionUpdateFormWorkingPart($nIdForm, $sIdComponents = FString::STRING_EMPTY) {
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);

      if (!is_null($oFormWorkingPart)) {
         $oFormWorkingPartComponents = FormWorkingPartComponents::getFormWorkingPartComponentsByIdFormFK($oFormWorkingPart->id);
         
         if (!$oFormWorkingPart->data_completed) {
            $oPriorities = Priorities::getPriorities();
            if (count($oPriorities) > 0) {
               if ((count($oPriorities) % 2) == 0) $oFormWorkingPart->priority = $oPriorities[(count($oPriorities) / 2) - 1]->description;
               else $oFormWorkingPart->priority = $oPriorities[round(count($oPriorities) / 2) - 1]->description;
            }
            
            $oZones = Zones::getZones();
            if (count($oZones) == 1) {
               $oFormWorkingPart->id_zone = $oZones[0]->id;      
            }     
         }
         
         if (isset($_POST['FormsWorkingParts'])) {       
             // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-working-part-form', $oFormWorkingPart);
         
            $oZone = Zones::getZone($_POST['FormsWorkingParts']['id_zone']);
            $oEquipment = Equipments::getEquipment($_POST['FormsWorkingParts']['id_equipment']);
            $oRegion = Regions::getRegion($_POST['FormsWorkingParts']['id_region']);
            $oMethod = Methods::getMethodByCode($_POST['FormsWorkingParts']['method_code']);
            
            if ((!is_null($oMethod)) && (!$oMethod->undefined) && ($oFormWorkingPart->method_code != $oMethod->code)) {
               // Delete all Risks & Ipes
               $oFormWorkingPartRisks = FormWorkingPartRisks::getFormWorkingPartRisksByIdFormFK($nIdForm);
               foreach($oFormWorkingPartRisks as $oFormWorkingPartRisk) $oFormWorkingPartRisk->delete();
               
               $oFormWorkingPartIPEs = FormWorkingPartIPEs::getFormWorkingPartIPEsByIdFormFK($nIdForm);
               foreach($oFormWorkingPartIPEs as $oFormWorkingPartIPE) $oFormWorkingPartIPE->delete(); 
                  
               // Copy all Risks & Ipes of method
               $oMethodsRisks = MethodsRisks::getMethodsRisksByIdMethod($oMethod->id);
               foreach($oMethodsRisks as $oMethodRisk) {
                  $oRisk = Risks::getRisk($oMethodRisk->id_risk);
                  if (!is_null($oRisk)) {
                     $oFormWorkingPartRisk = new FormWorkingPartRisks();
                     $oFormWorkingPartRisk->name = $oRisk->name;
                     $oFormWorkingPartRisk->id_form_working_part = $oFormWorkingPart->id;
                     
                     $oFormWorkingPartRisk->save();
                  }
               } 
               
               $oMethodsIPEs = MethodsIPEs::getMethodsIPEsByIdMethod($oMethod->id);
               foreach($oMethodsIPEs as $oMethodIPE) {
                  $oIPE = IPEs::getIPE($oMethodIPE->id_ipe);
                  if (!is_null($oIPE)) {
                     $oFormWorkingPartIPE = new FormWorkingPartIPEs();
                     $oFormWorkingPartIPE->name = $oIPE->name;
                     $oFormWorkingPartIPE->id_form_working_part = $oFormWorkingPart->id;
                     
                     $oFormWorkingPartIPE->save();
                  }
               }                      
            }
            else if ((!is_null($oMethod)) && ($oMethod->undefined) && ($oFormWorkingPart->method_code != $oMethod->code)) {
               if ((!is_null($oEquipment)) && (!is_null($oRegion)) && (!is_null($oZone))) { 
                  if (($oFormWorkingPart->id_equipment != $oEquipment->id) || ($oFormWorkingPart->id_region != $oRegion->id) || ($oFormWorkingPart->id_zone != $oZone->id) || ($oFormWorkingPart->method_code != $oMethod->code)) {
                     
                     // Delete all Risks & Ipes
                     $oFormWorkingPartRisks = FormWorkingPartRisks::getFormWorkingPartRisksByIdFormFK($nIdForm);
                     foreach($oFormWorkingPartRisks as $oFormWorkingPartRisk) $oFormWorkingPartRisk->delete();
                     
                     $oFormWorkingPartIPEs = FormWorkingPartIPEs::getFormWorkingPartIPEsByIdFormFK($nIdForm);
                     foreach($oFormWorkingPartIPEs as $oFormWorkingPartIPE) $oFormWorkingPartIPE->delete();
                     
                     // Copy all Risks & Ipes of equipment
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
               else if ($_POST['FormsWorkingParts']['id_equipment'] == FApplication::EQUIPMENT_OTHERS) {
                  if ($oFormWorkingPart->equipment != $_POST['FormsWorkingParts']['equipment']) {
                     
                     // Delete all Risks & Ipes
                     $oFormWorkingPartRisks = FormWorkingPartRisks::getFormWorkingPartRisksByIdFormFK($nIdForm);
                     foreach($oFormWorkingPartRisks as $oFormWorkingPartRisk) $oFormWorkingPartRisk->delete();
                     
                     $oFormWorkingPartIPEs = FormWorkingPartIPEs::getFormWorkingPartIPEsByIdFormFK($nIdForm);
                     foreach($oFormWorkingPartIPEs as $oFormWorkingPartIPE) $oFormWorkingPartIPE->delete();   
                  }  
               }
            }
            
            $oFormWorkingPart->attributes = $_POST['FormsWorkingParts'];

            if ($_POST['FormsWorkingParts']['status'] == FModuleWorkingPartsManagement::STATUS_FINALIZED) $oFormWorkingPart->end_date = date('Y-m-d H:i:s');
            else $oFormWorkingPart->end_date = null;
            
            if (strlen($_POST['FormsWorkingParts']['second_responsible']) > 0) $oFormWorkingPart->second_responsible = $_POST['FormsWorkingParts']['second_responsible']; 
            if (strlen($_POST['FormsWorkingParts']['third_responsible']) > 0) $oFormWorkingPart->third_responsible = $_POST['FormsWorkingParts']['third_responsible']; 
            if (strlen($_POST['FormsWorkingParts']['id_form_work_request']) > 0) $oFormWorkingPart->id_form_work_request = $_POST['FormsWorkingParts']['id_form_work_request'];
             
            $oPriority = Priorities::getPriorityByDescription($_POST['FormsWorkingParts']['priority']);
            if (!is_null($oPriority)) $oFormWorkingPart->priority_number = $oPriority->priority;
            
            $oMethod = Methods::getMethodByCode($_POST['FormsWorkingParts']['method_code']);
            if (!is_null($oMethod)) $oFormWorkingPart->method_description = $oMethod->description;
            
            $oFormWorkingPart->zone = Zones::getZoneName($_POST['FormsWorkingParts']['id_zone']);
            $oFormWorkingPart->region = Regions::getRegionName($_POST['FormsWorkingParts']['id_region']);
            
            if ($_POST['FormsWorkingParts']['id_equipment'] != FApplication::EQUIPMENT_OTHERS) {
               $oFormWorkingPart->equipment = Equipments::getEquipmentName($_POST['FormsWorkingParts']['id_equipment']);
            }
               
            if ($oFormWorkingPart->save()) {
               // Delete all components 
               $oFormWorkingPartComponents = FormWorkingPartComponents::getFormWorkingPartComponentsByIdFormFK($nIdForm);
               foreach($oFormWorkingPartComponents as $oFormWorkingPartComponent) $oFormWorkingPartComponent->delete();
               
               $oIdsComponents = explode(',', $sIdComponents);
               foreach($oIdsComponents as $nIdComponent) {
                  $oComponent = Components::getComponent($nIdComponent);
                  if (!is_null($oComponent)) {
                     $oFormWorkingPartComponent = new FormWorkingPartComponents();
                     $oFormWorkingPartComponent->id_component = $oComponent->id;
                     $oFormWorkingPartComponent->component = $oComponent->name;
                     $oFormWorkingPartComponent->id_form_working_part = $oFormWorkingPart->id; 
                     
                     $oFormWorkingPartComponent->save();
                  } 
               }
            }
               
            if ($oFormWorkingPart->data_completed) {
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkingParts'));
            }
            else {
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartEmployees', array('nIdForm'=>$oFormWorkingPart->id)));
            } 
         }
         $this->render('updateFormWorkingPart', array('oModelForm'=>$oFormWorkingPart, 'oModelFormComponents'=>$oFormWorkingPartComponents));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormWorkingPartEmployees($nIdForm) {
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);

      if (!is_null($oFormWorkingPart)) {
         $oFormWorkingPartEmployees = FormWorkingPartEmployees::getFormWorkingPartEmployeesByIdFormFK($nIdForm);
         if (count($oFormWorkingPartEmployees) > 0) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIpes', array('nIdForm'=>$oFormWorkingPart->id)));       
         }   
         else {
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTEMPLOYEES_FORM_SUBMIT_ERROR'));
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartEmployees', array('nIdForm'=>$oFormWorkingPart->id)));    
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormWorkingPartRisksIPEs($nIdForm) {
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);

      if (!is_null($oFormWorkingPart)) {
         $oFormWorkingPartRisks = FormWorkingPartRisks::getFormWorkingPartRisksByIdFormFK($nIdForm);
         $oFormWorkingPartIPEs = FormWorkingPartIPEs::getFormWorkingPartIPEsByIdFormFK($nIdForm);
         if ((count($oFormWorkingPartRisks) > 0) && (count($oFormWorkingPartIPEs) > 0)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$oFormWorkingPart->id)));       
         }   
         else {
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTRISKSIPES_FORM_SUBMIT_ERROR'));
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs', array('nIdForm'=>$oFormWorkingPart->id)));    
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormWorkingPartDynamicTexts($nIdForm) {
      $bRequiredGradePreventiveAction = false;
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
      
      if (!is_null($oFormWorkingPart)) {
         if (isset($_POST['FormWorkingPartMeasures'])) {
            $oDataMeasures = $_POST['FormWorkingPartMeasures'];
            foreach($oDataMeasures as $oDataMeasure) {
               $idMeasure = $oDataMeasure['ID'];
               $oFormWorkingPartMeasure = FormWorkingPartMeasures::getFormWorkingPartMeasure($idMeasure);
               if (!is_null($oFormWorkingPartMeasure)) {
                  if (isset($oDataMeasure['value'])) $oFormWorkingPartMeasure->value = $oDataMeasure['value'];
                  if (isset($oDataMeasure['information_field'])) $oFormWorkingPartMeasure->information_field = $oDataMeasure['information_field'];
                  if (isset($oDataMeasure['custom_field'])) $oFormWorkingPartMeasure->custom_field = $oDataMeasure['custom_field'];
                  
                  $oFormWorkingPartMeasure->save();

                  if ($oFormWorkingPart->data_completed) Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         if (isset($_POST['FormWorkingPartEquipmentConditions'])) {
            $oDataEquipmentConditions = $_POST['FormWorkingPartEquipmentConditions'];
            foreach($oDataEquipmentConditions as $oDataEquipmentCondition) {
               $idEquipmentCondition = $oDataEquipmentCondition['ID'];
               $oFormWorkingPartEquipmentCondition = FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentCondition($idEquipmentCondition);
               if (!is_null($oFormWorkingPartEquipmentCondition)) {
                  if (isset($oDataEquipmentCondition['value'])) $oFormWorkingPartEquipmentCondition->value = $oDataEquipmentCondition['value'];
                  if (isset($oDataEquipmentCondition['information_field'])) $oFormWorkingPartEquipmentCondition->information_field = $oDataEquipmentCondition['information_field'];
                  if (isset($oDataEquipmentCondition['custom_field'])) $oFormWorkingPartEquipmentCondition->custom_field = $oDataEquipmentCondition['custom_field'];
                  
                  $oFormWorkingPartEquipmentCondition->save();
                  if ($oFormWorkingPart->data_completed) Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         
         if ($oFormWorkingPart->data_completed) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$oFormWorkingPart->id)));
         }
         else {
            $oFormWorkingPartMeasures = FormWorkingPartMeasures::getFormWorkingPartMeasuresByIdFormFK($nIdForm);
            foreach($oFormWorkingPartMeasures as $oFormWorkingPartMeasure) {
               if (($oFormWorkingPartMeasure->required_grade_preventive_action) && ($oFormWorkingPartMeasure->value == 1)) {
                  $bRequiredGradePreventiveAction = true;  
               } 
            }
            
            if (($bRequiredGradePreventiveAction) && (FString::isNullOrEmpty($oFormWorkingPart->third_responsible))) {
               Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_ERROR_GRADE_PREVENTIVE_ACTION', array('{1}'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormWorkingPart', array('nIdForm'=>$oFormWorkingPart->id)))));
               
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$oFormWorkingPart->id)));   
            }
            else {
               $oFormWorkingPart->data_completed = true;
               if ($oFormWorkingPart->save()) {
                  if (!is_null($oFormWorkingPart->id_form_work_request)) {
                     $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($oFormWorkingPart->id_form_work_request);
                     if (!is_null($oFormWorkRequest)) {
                        $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                        $oFormWorkRequest->comments = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_COMMENTS_VALUE_PT') . ': ' . $oFormWorkingPart->id . FString::STRING_SPACE . $oFormWorkRequest->comments;
                        $oFormWorkRequest->end_date = date('Y-m-d H:i:s');
                         
                        $oFormWorkRequest->save();
                     }
                  }
               }
                  
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkingParts')); 
            }  
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormMaintenanceWorkingPart($nIdForm, $sIdComponents = FString::STRING_EMPTY) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
                     
      if (!is_null($oFormMaintenanceWorkingPart)) {
         $oFormMaintenanceWorkingPartComponents = FormMaintenanceWorkingPartComponents::getFormMaintenanceWorkingPartComponentsByIdFormFK($oFormMaintenanceWorkingPart->id);
         
         if (!$oFormMaintenanceWorkingPart->data_completed) {
            $oPriorities = Priorities::getPriorities();
            if (count($oPriorities) > 0) {
               if ((count($oPriorities) % 2) == 0) $oFormMaintenanceWorkingPart->priority = $oPriorities[(count($oPriorities) / 2) - 1]->description;
               else $oFormMaintenanceWorkingPart->priority = $oPriorities[round(count($oPriorities) / 2) - 1]->description;
            }  
            
            $oZones = Zones::getZones();
            if (count($oZones) == 1) {
               $oFormMaintenanceWorkingPart->id_zone = $oZones[0]->id;      
            }    
         }
         
         if (isset($_POST['FormsMaintenanceWorkingParts'])) {       
             // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-maintenance-working-part-form', $oFormMaintenanceWorkingPart);
         
            $oZone = Zones::getZone($_POST['FormsMaintenanceWorkingParts']['id_zone']);
            $oEquipment = Equipments::getEquipment($_POST['FormsMaintenanceWorkingParts']['id_equipment']);
            $oRegion = Regions::getRegion($_POST['FormsMaintenanceWorkingParts']['id_region']);
            $oMethod = Methods::getMethodByCode($_POST['FormsMaintenanceWorkingParts']['method_code']);
            
            if ((!is_null($oMethod)) && (!$oMethod->undefined) && ($oFormMaintenanceWorkingPart->method_code != $oMethod->code)) {
               // Delete all Risks & Ipes
               $oFormMaintenanceWorkingPartRisks = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisksByIdFormFK($nIdForm);
               foreach($oFormMaintenanceWorkingPartRisks as $oFormMaintenanceWorkingPartRisk) $oFormMaintenanceWorkingPartRisk->delete();
               
               $oFormMaintenanceWorkingPartIPEs = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPEsByIdFormFK($nIdForm);
               foreach($oFormMaintenanceWorkingPartIPEs as $oFormMaintenanceWorkingPartIPE) $oFormMaintenanceWorkingPartIPE->delete();
                  
               // Copy all Risks & Ipes of method
               $oMethodsRisks = MethodsRisks::getMethodsRisksByIdMethod($oMethod->id);
               foreach($oMethodsRisks as $oMethodRisk) {
                  $oRisk = Risks::getRisk($oMethodRisk->id_risk);
                  if (!is_null($oRisk)) {
                     $oFormMaintenanceWorkingPartRisk = new FormMaintenanceWorkingPartRisks();
                     $oFormMaintenanceWorkingPartRisk->name = $oRisk->name;
                     $oFormMaintenanceWorkingPartRisk->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                     
                     $oFormMaintenanceWorkingPartRisk->save();
                  }
               } 
               
               $oMethodsIPEs = MethodsIPEs::getMethodsIPEsByIdMethod($oMethod->id);
               foreach($oMethodsIPEs as $oMethodIPE) {
                  $oIPE = IPEs::getIPE($oMethodIPE->id_ipe);
                  if (!is_null($oIPE)) {
                     $oFormMaintenanceWorkingPartIPE = new FormMaintenanceWorkingPartIPEs();
                     $oFormMaintenanceWorkingPartIPE->name = $oIPE->name;
                     $oFormMaintenanceWorkingPartIPE->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id;
                     
                     $oFormMaintenanceWorkingPartIPE->save();
                  }
               }                      
            }
            else if ((!is_null($oMethod)) && ($oMethod->undefined) && ($oFormMaintenanceWorkingPart->method_code != $oMethod->code)) {
               if ((!is_null($oEquipment)) && (!is_null($oRegion)) && (!is_null($oZone))) { 
                  if (($oFormMaintenanceWorkingPart->id_equipment != $oEquipment->id) || ($oFormMaintenanceWorkingPart->id_region != $oRegion->id) || ($oFormMaintenanceWorkingPart->id_zone != $oZone->id) || ($oFormMaintenanceWorkingPart->method_code != $oMethod->code)) {
                        
                     // Delete all Risks & Ipes
                     $oFormMaintenanceWorkingPartRisks = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisksByIdFormFK($nIdForm);
                     foreach($oFormMaintenanceWorkingPartRisks as $oFormMaintenanceWorkingPartRisk) $oFormMaintenanceWorkingPartRisk->delete();
                     
                     $oFormMaintenanceWorkingPartIPEs = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPEsByIdFormFK($nIdForm);
                     foreach($oFormMaintenanceWorkingPartIPEs as $oFormMaintenanceWorkingPartIPE) $oFormMaintenanceWorkingPartIPE->delete();
                     
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
               else if ($_POST['FormsMaintenanceWorkingParts']['id_equipment'] == FApplication::EQUIPMENT_OTHERS) {
                  if ($oFormMaintenanceWorkingPart->equipment != $_POST['FormsMaintenanceWorkingParts']['equipment']) {
                     // Delete all Risks & Ipes
                     $oFormMaintenanceWorkingPartRisks = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisksByIdFormFK($nIdForm);
                     foreach($oFormMaintenanceWorkingPartRisks as $oFormMaintenanceWorkingPartRisk) $oFormMaintenanceWorkingPartRisk->delete();
                     
                     $oFormMaintenanceWorkingPartIPEs = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPEsByIdFormFK($nIdForm);
                     foreach($oFormMaintenanceWorkingPartIPEs as $oFormMaintenanceWorkingPartIPE) $oFormMaintenanceWorkingPartIPE->delete();   
                  }  
               }
            }
            
            $oFormMaintenanceWorkingPart->attributes = $_POST['FormsMaintenanceWorkingParts'];
            
            if ($_POST['FormsMaintenanceWorkingParts']['status'] == FModuleWorkingPartsManagement::STATUS_FINALIZED) $oFormMaintenanceWorkingPart->end_date = date('Y-m-d H:i:s');
            else $oFormMaintenanceWorkingPart->end_date = null;
            
            if (strlen($_POST['FormsMaintenanceWorkingParts']['second_responsible']) > 0) $oFormMaintenanceWorkingPart->second_responsible = $_POST['FormsMaintenanceWorkingParts']['second_responsible']; 
            if (strlen($_POST['FormsMaintenanceWorkingParts']['third_responsible']) > 0) $oFormMaintenanceWorkingPart->third_responsible = $_POST['FormsMaintenanceWorkingParts']['third_responsible'];
            if (strlen($_POST['FormsMaintenanceWorkingParts']['fourth_responsible']) > 0) $oFormMaintenanceWorkingPart->fourth_responsible = $_POST['FormsMaintenanceWorkingParts']['fourth_responsible'];
            if (strlen($_POST['FormsMaintenanceWorkingParts']['fifth_responsible']) > 0) $oFormMaintenanceWorkingPart->fifth_responsible = $_POST['FormsMaintenanceWorkingParts']['fifth_responsible'];
            if (strlen($_POST['FormsMaintenanceWorkingParts']['sixth_responsible']) > 0) $oFormMaintenanceWorkingPart->sixth_responsible = $_POST['FormsMaintenanceWorkingParts']['sixth_responsible'];
            if (strlen($_POST['FormsMaintenanceWorkingParts']['id_form_work_request']) > 0) $oFormMaintenanceWorkingPart->id_form_work_request = $_POST['FormsMaintenanceWorkingParts']['id_form_work_request'];
            
            $oPriority = Priorities::getPriorityByDescription($_POST['FormsMaintenanceWorkingParts']['priority']);
            if (!is_null($oPriority)) $oFormMaintenanceWorkingPart->priority_number = $oPriority->priority;
            
            $oMethod = Methods::getMethodByCode($_POST['FormsMaintenanceWorkingParts']['method_code']);
            if (!is_null($oMethod)) $oFormMaintenanceWorkingPart->method_description = $oMethod->description;
            
            $oFormMaintenanceWorkingPart->zone = Zones::getZoneName($_POST['FormsMaintenanceWorkingParts']['id_zone']);
            $oFormMaintenanceWorkingPart->region = Regions::getRegionName($_POST['FormsMaintenanceWorkingParts']['id_region']);
            
            if ($_POST['FormsMaintenanceWorkingParts']['id_equipment'] != FApplication::EQUIPMENT_OTHERS) {
               $oFormMaintenanceWorkingPart->equipment = Equipments::getEquipmentName($_POST['FormsMaintenanceWorkingParts']['id_equipment']);
            }
            
            if ($oFormMaintenanceWorkingPart->save()) {
               // Delete all components 
               $oFormMaintenanceWorkingPartComponents = FormMaintenanceWorkingPartComponents::getFormMaintenanceWorkingPartComponentsByIdFormFK($nIdForm);
               foreach($oFormMaintenanceWorkingPartComponents as $oFormMaintenanceWorkingPartComponent) $oFormMaintenanceWorkingPartComponent->delete();
               
               $oIdsComponents = explode(',', $sIdComponents);
               foreach($oIdsComponents as $nIdComponent) {
                  $oComponent = Components::getComponent($nIdComponent);
                  if (!is_null($oComponent)) {
                     $oFormMaintenanceWorkingPartComponent = new FormMaintenanceWorkingPartComponents();
                     $oFormMaintenanceWorkingPartComponent->id_component = $oComponent->id;
                     $oFormMaintenanceWorkingPartComponent->component = $oComponent->name;
                     $oFormMaintenanceWorkingPartComponent->id_form_maintenance_working_part = $oFormMaintenanceWorkingPart->id; 
                     
                     $oFormMaintenanceWorkingPartComponent->save();
                  } 
               }
            }
            
            if ($oFormMaintenanceWorkingPart->data_completed) {
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsMaintenanceWorkingParts'));
            }
            else {
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartRisksIPEs', array('nIdForm'=>$oFormMaintenanceWorkingPart->id)));
            } 
         }                 
         $this->render('updateFormMaintenanceWorkingPart', array('oModelForm'=>$oFormMaintenanceWorkingPart, 'oModelFormComponents'=>$oFormMaintenanceWorkingPartComponents));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormMaintenanceWorkingPartRisksIPEs($nIdForm) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);

      if (!is_null($oFormMaintenanceWorkingPart)) {
         $oFormMaintenanceWorkingPartRisks = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisksByIdFormFK($nIdForm);
         $oFormMaintenanceWorkingPartIPEs = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPEsByIdFormFK($nIdForm);
         if ((count($oFormMaintenanceWorkingPartRisks) > 0) && (count($oFormMaintenanceWorkingPartIPEs) > 0)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$oFormMaintenanceWorkingPart->id)));       
         }   
         else {
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTRISKSIPES_FORM_SUBMIT_ERROR'));
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartRisksIPEs', array('nIdForm'=>$oFormMaintenanceWorkingPart->id)));    
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormMaintenanceWorkingPartDynamicTexts($nIdForm) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
      
      if (!is_null($oFormMaintenanceWorkingPart)) {
         if (isset($_POST['FormMaintenanceWorkingPartMeasures'])) {
            $oDataMeasures = $_POST['FormMaintenanceWorkingPartMeasures'];
            foreach($oDataMeasures as $oDataMeasure) {
               $idMeasure = $oDataMeasure['ID'];
               $oFormMaintenanceWorkingPartMeasure = FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasure($idMeasure);
               if (!is_null($oFormMaintenanceWorkingPartMeasure)) {
                  if (isset($oDataMeasure['value'])) $oFormMaintenanceWorkingPartMeasure->value = $oDataMeasure['value'];
                  if (isset($oDataMeasure['information_field'])) $oFormMaintenanceWorkingPartMeasure->information_field = $oDataMeasure['information_field'];
                  if (isset($oDataMeasure['custom_field'])) $oFormMaintenanceWorkingPartMeasure->custom_field = $oDataMeasure['custom_field'];
                  
                  $oFormMaintenanceWorkingPartMeasure->save();
                  Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         if (isset($_POST['FormMaintenanceWorkingPartEquipmentConditions'])) {
            $oDataEquipmentConditions = $_POST['FormMaintenanceWorkingPartEquipmentConditions'];
            foreach($oDataEquipmentConditions as $oDataEquipmentCondition) {
               $idEquipmentCondition = $oDataEquipmentCondition['ID'];
               $oFormMaintenanceWorkingPartEquipmentCondition = FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentCondition($idEquipmentCondition);
               if (!is_null($oFormMaintenanceWorkingPartEquipmentCondition)) {
                  if (isset($oDataEquipmentCondition['value'])) $oFormMaintenanceWorkingPartEquipmentCondition->value = $oDataEquipmentCondition['value'];
                  if (isset($oDataEquipmentCondition['information_field'])) $oFormMaintenanceWorkingPartEquipmentCondition->information_field = $oDataEquipmentCondition['information_field'];
                  if (isset($oDataEquipmentCondition['custom_field'])) $oFormMaintenanceWorkingPartEquipmentCondition->custom_field = $oDataEquipmentCondition['custom_field'];
                  
                  $oFormMaintenanceWorkingPartEquipmentCondition->save();
                  Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMMAINTENANCEWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         
         if ($oFormMaintenanceWorkingPart->data_completed) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$oFormMaintenanceWorkingPart->id)));
         }
         else {
            $oFormMaintenanceWorkingPart->data_completed = true;
            if ($oFormMaintenanceWorkingPart->save()) {
               if (!is_null($oFormMaintenanceWorkingPart->id_form_work_request)) {
                  $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($oFormMaintenanceWorkingPart->id_form_work_request);
                  if (!is_null($oFormWorkRequest)) {
                     $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                     $oFormWorkRequest->comments = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_COMMENTS_VALUE_PTIP') . ': ' . $oFormMaintenanceWorkingPart->id . FString::STRING_SPACE . $oFormWorkRequest->comments;
                     $oFormWorkRequest->end_date = date('Y-m-d H:i:s');
                      
                     $oFormWorkRequest->save();
                  }
               }
            }
            
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsMaintenanceWorkingParts'));   
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormSpecialWorkingPart($nIdForm) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);

      if (!is_null($oFormSpecialWorkingPart)) {
         if (isset($_POST['FormsSpecialWorkingParts'])) {       
             // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('form-special-working-part-form', $oFormSpecialWorkingPart);

            $oMethod = Methods::getMethodByCode($_POST['FormsSpecialWorkingParts']['method_code']);
            
            if ((!is_null($oMethod)) && (!$oMethod->undefined) && ($oFormSpecialWorkingPart->method_code != $oMethod->code)) {
               // Delete all Risks & Ipes
               $oFormSpecialWorkingPartIPEs = FormSpecialWorkingPartIPEs::getFormSpecialWorkingPartIPEsByIdFormFK($nIdForm);
               foreach($oFormSpecialWorkingPartIPEs as $oFormSpecialWorkingPartIPE) $oFormSpecialWorkingPartIPE->delete();
                  
               // Copy all Risks & Ipes of method
               $oMethodsIPEs = MethodsIPEs::getMethodsIPEsByIdMethod($oMethod->id);
               foreach($oMethodsIPEs as $oMethodIPE) {
                  $oIPE = IPEs::getIPE($oMethodIPE->id_ipe);
                  if (!is_null($oIPE)) {
                     $oFormSpecialWorkingPartIPE = new FormSpecialWorkingPartIPEs();
                     $oFormSpecialWorkingPartIPE->name = $oIPE->name;
                     $oFormSpecialWorkingPartIPE->id_form_special_working_part = $oFormSpecialWorkingPart->id;
                     
                     $oFormSpecialWorkingPartIPE->save();
                  }
               }                      
            }
            
            $oFormSpecialWorkingPart->attributes = $_POST['FormsSpecialWorkingParts'];
         
            if ($_POST['FormsSpecialWorkingParts']['status'] == FModuleWorkingPartsManagement::STATUS_FINALIZED) $oFormSpecialWorkingPart->end_date = date('Y-m-d H:i:s');
            else $oFormSpecialWorkingPart->end_date = null;

            if (strlen($_POST['FormsSpecialWorkingParts']['third_responsible']) > 0) $oFormSpecialWorkingPart->third_responsible = $_POST['FormsSpecialWorkingParts']['third_responsible'];            
            if (strlen($_POST['FormsSpecialWorkingParts']['supplement_instructions']) > 0) $oFormSpecialWorkingPart->supplement_instructions = $_POST['FormsSpecialWorkingParts']['supplement_instructions']; 
            if (strlen($_POST['FormsSpecialWorkingParts']['id_form_work_request']) > 0) $oFormSpecialWorkingPart->id_form_work_request = $_POST['FormsSpecialWorkingParts']['id_form_work_request'];
            
            if ($oFormSpecialWorkingPart->work == strtoupper(FString::STRING_OTHERS)) {
               $oFormSpecialWorkingPart->work_others = $_POST['FormsSpecialWorkingParts']['work_others'];       
            } 
            else $oFormSpecialWorkingPart->work_others = null; 
            
            $oMethod = Methods::getMethodByCode($_POST['FormsSpecialWorkingParts']['method_code']);
            if (!is_null($oMethod)) $oFormSpecialWorkingPart->method_description = $oMethod->description;
            
            if ($oFormSpecialWorkingPart->data_completed) {
               $oFormSpecialWorkingPart->save();
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts'));
            }
            else {
               $oFormSpecialWorkingPart->save();
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartEmployees', array('nIdForm'=>$oFormSpecialWorkingPart->id)));
            } 
         }
         $this->render('updateFormSpecialWorkingPart', array('oModelForm'=>$oFormSpecialWorkingPart));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormSpecialWorkingPartEmployees($nIdForm) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);

      if (!is_null($oFormSpecialWorkingPart)) {
         $oFormSpecialWorkingPartEmployees = FormSpecialWorkingPartEmployees::getFormSpecialWorkingPartEmployeesByIdFormFK($nIdForm);
         if (count($oFormSpecialWorkingPartEmployees) > 0) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIpes', array('nIdForm'=>$oFormSpecialWorkingPart->id)));       
         }   
         else {
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTEMPLOYEES_FORM_SUBMIT_ERROR'));
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartEmployees', array('nIdForm'=>$oFormSpecialWorkingPart->id)));    
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormSpecialWorkingPartMeansIPEs($nIdForm) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);

      if (!is_null($oFormSpecialWorkingPart)) {
         $oFormSpecialWorkingPartPreventionMeans = FormSpecialWorkingPartPreventionMeans::getFormSpecialWorkingPartPreventionMeansByIdFormFK($nIdForm);
         $oFormSpecialWorkingPartIPEs = FormSpecialWorkingPartIPEs::getFormSpecialWorkingPartIPEsByIdFormFK($nIdForm);
         if ((count($oFormSpecialWorkingPartPreventionMeans) > 0) && (count($oFormSpecialWorkingPartIPEs) > 0)) {   
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oFormSpecialWorkingPart->id)));       
         }   
         else {
            Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTMEANSIPES_FORM_SUBMIT_ERROR'));
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$oFormSpecialWorkingPart->id)));    
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormSpecialWorkingPartDynamicTexts($nIdForm) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
      
      if (!is_null($oFormSpecialWorkingPart)) {
         if (isset($_POST['FormSpecialWorkingPartMeasures'])) {
            $oDataMeasures = $_POST['FormSpecialWorkingPartMeasures'];
            foreach($oDataMeasures as $oDataMeasure) {
               $idMeasure = $oDataMeasure['ID'];
               $oFormSpecialWorkingPartMeasure = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasure($idMeasure);
               if (!is_null($oFormSpecialWorkingPartMeasure)) {
                  if (isset($oDataMeasure['value'])) $oFormSpecialWorkingPartMeasure->value = $oDataMeasure['value'];
                  if (isset($oDataMeasure['information_field'])) $oFormSpecialWorkingPartMeasure->information_field = $oDataMeasure['information_field'];
                  if (isset($oDataMeasure['custom_field'])) $oFormSpecialWorkingPartMeasure->custom_field = $oDataMeasure['custom_field'];
                  
                  $oFormSpecialWorkingPartMeasure->save();
                  if ($oFormSpecialWorkingPart->data_completed) Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         if (isset($_POST['FormSpecialWorkingPartEquipmentConditions'])) {
            $oDataEquipmentConditions = $_POST['FormSpecialWorkingPartEquipmentConditions'];
            foreach($oDataEquipmentConditions as $oDataEquipmentCondition) {
               $idEquipmentCondition = $oDataEquipmentCondition['ID'];
               $oFormSpecialWorkingPartEquipmentCondition = FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentCondition($idEquipmentCondition);
               if (!is_null($oFormSpecialWorkingPartEquipmentCondition)) {
                  if (isset($oDataEquipmentCondition['value'])) $oFormSpecialWorkingPartEquipmentCondition->value = $oDataEquipmentCondition['value'];
                  if (isset($oDataEquipmentCondition['information_field'])) $oFormSpecialWorkingPartEquipmentCondition->information_field = $oDataEquipmentCondition['information_field'];
                  if (isset($oDataEquipmentCondition['custom_field'])) $oFormSpecialWorkingPartEquipmentCondition->custom_field = $oDataEquipmentCondition['custom_field'];
                  
                  $oFormSpecialWorkingPartEquipmentCondition->save();
                  if ($oFormSpecialWorkingPart->data_completed) Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_SUCCESS'));
               }   
            }      
         }
         
         if ($oFormSpecialWorkingPart->data_completed) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oFormSpecialWorkingPart->id)));
         }
         else {
            $oFormSpecialWorkingPartMeasures = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasuresByIdFormFK($nIdForm);
            foreach($oFormSpecialWorkingPartMeasures as $oFormSpecialWorkingPartMeasure) {
               if (($oFormSpecialWorkingPartMeasure->required_grade_preventive_action) && ($oFormSpecialWorkingPartMeasure->value == 1)) {
                  $bRequiredGradePreventiveAction = true;  
               } 
            }
            
            if (($bRequiredGradePreventiveAction) && (FString::isNullOrEmpty($oFormSpecialWorkingPart->third_responsible))) {
               Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTDYNAMICTEXTS_FORM_SUBMIT_ERROR_GRADE_PREVENTIVE_ACTION', array('{1}'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormSpecialWorkingPart', array('nIdForm'=>$oFormSpecialWorkingPart->id)))));
               
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$oFormSpecialWorkingPart->id)));   
            }
            else {
               $oFormSpecialWorkingPart->data_completed = true;
               if ($oFormSpecialWorkingPart->save()) {
                  if (!is_null($oFormSpecialWorkingPart->id_form_work_request)) {
                     $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($oFormSpecialWorkingPart->id_form_work_request);
                     if (!is_null($oFormWorkRequest)) {
                        $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_FINALIZED; 
                        $oFormWorkRequest->comments = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_COMMENTS_VALUE_PTE') . ': ' . $oFormSpecialWorkingPart->id . FString::STRING_SPACE . $oFormWorkRequest->comments;
                        $oFormWorkRequest->end_date = date('Y-m-d H:i:s');
                         
                        $oFormWorkRequest->save();
                     }
                  }
               }
               
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts'));  
            } 
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormWorkRequest($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($nIdForm);
 
      if (!is_null($oFormWorkRequest)) {
         if (FModuleWorkingPartsManagement::allowUpdateFormWorkRequest($nIdForm)) {
            if ($oFormWorkRequest->status == FModuleWorkingPartsManagement::STATUS_FINALIZED) $oFormWorkRequest->bFinalized = true;
            else $oFormWorkRequest->bFinalized = false;
             
            // Ajax validation request=>Conditional validator
            FForm::validateAjaxForm('form-work-request-form', $oFormWorkRequest);
            
            if (isset($_POST['FormsWorkRequests'])) {
               $oFormWorkRequest->attributes = $_POST['FormsWorkRequests'];
            
               $oPriority = Priorities::getPriorityByDescription($_POST['FormsWorkRequests']['priority']);
               if (!is_null($oPriority)) $oFormWorkRequest->priority_number = $oPriority->priority;
               
               if (!FString::isNullOrEmpty($_POST['FormsWorkRequests']['visible_date'])) $oFormWorkRequest->visible_date = FDate::getEnglishDate($_POST['FormsWorkRequests']['visible_date']);
               else $oFormWorkRequest->visible_date = null;
               
               if ((isset($_POST['FormsWorkRequests']['bFinalized'])) && ($_POST['FormsWorkRequests']['bFinalized'])) {
                  $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_FINALIZED;
                  
                  $oFormWorkRequest->end_date = date('Y-m-d H:i:s');
               }
               else if ((isset($_POST['FormsWorkRequests']['bFinalized'])) && (!$_POST['FormsWorkRequests']['bFinalized'])) $oFormWorkRequest->status = FModuleWorkingPartsManagement::STATUS_PENDING;
               
               if ($oFormWorkRequest->status != FModuleWorkingPartsManagement::STATUS_FINALIZED) $oFormWorkRequest->end_date = null;
               
               $oFormWorkRequest->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewDetailFormWorkRequest', array('nIdForm'=>$oFormWorkRequest->id)));
            }
            else $this->render('updateFormWorkRequest', array('oModelForm'=>$oFormWorkRequest));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }    
   
       
   public function actionDeleteFormWorkingPart($nIdForm) {
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);
      if (!is_null($oFormWorkingPart)) {
         if ((!FString::isNullOrEmpty($oFormWorkingPart->id_maintenance_form_task)) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {
            $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($oFormWorkingPart->id_maintenance_form_task);
            if (!is_null($oMaintenanceFormTask)) {
               $oMaintenanceFormTask->working_part = FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE;
               $oMaintenanceFormTask->working_part_number = null;
               $oMaintenanceFormTask->working_part_owner = null;
               
               $oMaintenanceFormTask->save();
            } 
         }
         $oFormWorkingPart->delete();
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkingParts'));
   }
   public function actionDeleteFormWorkingPartEmployee($nIdForm, $nIdFormParent) {
      $oFormWorkingPartEmployee = FormWorkingPartEmployees::getFormWorkingPartEmployee($nIdForm);
      if (!is_null($oFormWorkingPartEmployee)) $oFormWorkingPartEmployee->delete();
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartEmployees', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkingPartRisk($nIdForm, $nIdFormParent) {
      $oFormWorkingPartRisk = FormWorkingPartRisks::getFormWorkingPartRisk($nIdForm);
      if (!is_null($oFormWorkingPartRisk)) $oFormWorkingPartRisk->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkingPartIPE($nIdForm, $nIdFormParent) {
      $oFormWorkingPartIPE = FormWorkingPartIPEs::getFormWorkingPartIPE($nIdForm);
      if (!is_null($oFormWorkingPartIPE)) $oFormWorkingPartIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkingPartMeasure($nIdForm, $nIdFormParent) {
      $oFormWorkingPartMeasure = FormWorkingPartMeasures::getFormWorkingPartMeasure($nIdForm);
      if ((!is_null($oFormWorkingPartMeasure)) && (!$oFormWorkingPartMeasure->custom)) $oFormWorkingPartMeasure->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkingPartEquipmentCondition($nIdForm, $nIdFormParent) {
      $oFormWorkingPartEquipmentCondition = FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentCondition($nIdForm);
      if ((!is_null($oFormWorkingPartEquipmentCondition)) && (!$oFormWorkingPartEquipmentCondition->custom)) $oFormWorkingPartEquipmentCondition->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkingPartComponent($nIdForm) {
      $oFormWorkingPartComponent = FormWorkingPartComponents::getFormWorkingPartComponent($nIdForm);
      if (!is_null($oFormWorkingPartComponent)) $oFormWorkingPartComponent->delete();  
   }
   public function actionDeleteFormMaintenanceWorkingPart($nIdForm) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);
      if (!is_null($oFormMaintenanceWorkingPart)) {
         if ((!FString::isNullOrEmpty($oFormMaintenanceWorkingPart->id_maintenance_form_task)) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {
            $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($oFormMaintenanceWorkingPart->id_maintenance_form_task);
            if (!is_null($oMaintenanceFormTask)) {
               $oMaintenanceFormTask->working_part = FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE;
               $oMaintenanceFormTask->working_part_number = null;
               $oMaintenanceFormTask->working_part_owner = null;
               
               $oMaintenanceFormTask->save();
            } 
         }
         $oFormMaintenanceWorkingPart->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsMaintenanceWorkingParts'));
   }
   public function actionDeleteFormMaintenanceWorkingPartRisk($nIdForm, $nIdFormParent) {
      $oFormMaintenanceWorkingPartRisk = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisk($nIdForm);
      if (!is_null($oFormMaintenanceWorkingPartRisk)) $oFormMaintenanceWorkingPartRisk->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartRisksIPEs', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormMaintenanceWorkingPartIPE($nIdForm, $nIdFormParent) {
      $oFormMaintenanceWorkingPartIPE = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPE($nIdForm);
      if (!is_null($oFormMaintenanceWorkingPartIPE)) $oFormMaintenanceWorkingPartIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartRisksIPEs', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormMaintenanceWorkingPartMeasure($nIdForm, $nIdFormParent) {
      $oFormMaintenanceWorkingPartMeasure = FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasure($nIdForm);
      if ((!is_null($oFormMaintenanceWorkingPartMeasure)) && (!$oFormMaintenanceWorkingPartMeasure->custom)) $oFormMaintenanceWorkingPartMeasure->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormMaintenanceWorkingPartEquipmentCondition($nIdForm, $nIdFormParent) {
      $oFormMaintenanceWorkingPartEquipmentCondition = FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentCondition($nIdForm);
      if ((!is_null($oFormMaintenanceWorkingPartEquipmentCondition)) && (!$oFormMaintenanceWorkingPartEquipmentCondition->custom)) $oFormMaintenanceWorkingPartEquipmentCondition->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormMaintenanceWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormSpecialWorkingPart($nIdForm) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);
      if (!is_null($oFormSpecialWorkingPart)) {
         if ((!FString::isNullOrEmpty($oFormSpecialWorkingPart->id_maintenance_form_task)) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {
            $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($oFormSpecialWorkingPart->id_maintenance_form_task);
            if (!is_null($oMaintenanceFormTask)) {
               $oMaintenanceFormTask->working_part = FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE;
               $oMaintenanceFormTask->working_part_number = null;
               $oMaintenanceFormTask->working_part_owner = null;
               
               $oMaintenanceFormTask->save();
            } 
         }
         
         $oFormSpecialWorkingPart->delete();
      }
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsSpecialWorkingParts'));
   }
   public function actionDeleteFormSpecialWorkingPartEmployee($nIdForm, $nIdFormParent) {
      $oFormSpecialWorkingPartEmployee = FormSpecialWorkingPartEmployees::getFormSpecialWorkingPartEmployee($nIdForm);
      if (!is_null($oFormSpecialWorkingPartEmployee)) $oFormSpecialWorkingPartEmployee->delete();
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartEmployees', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormSpecialWorkingPartPreventionMean($nIdForm, $nIdFormParent) {
      $oFormSpecialWorkingPartPreventionMean = FormSpecialWorkingPartPreventionMeans::getFormSpecialWorkingPartPreventionMean($nIdForm);
      if (!is_null($oFormSpecialWorkingPartPreventionMean)) $oFormSpecialWorkingPartPreventionMean->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$nIdFormParent)));    
   }
   public function actionDeleteFormSpecialWorkingPartIPE($nIdForm, $nIdFormParent) {
      $oFormSpecialWorkingPartIPE = FormSpecialWorkingPartIPEs::getFormSpecialWorkingPartIPE($nIdForm);
      if (!is_null($oFormSpecialWorkingPartIPE)) $oFormSpecialWorkingPartIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormSpecialWorkingPartMeasure($nIdForm, $nIdFormParent) {
      $oFormSpecialWorkingPartMeasure = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasure($nIdForm);
      if ((!is_null($oFormSpecialWorkingPartMeasure)) && (!$oFormSpecialWorkingPartMeasure->custom)) $oFormSpecialWorkingPartMeasure->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormSpecialWorkingPartEquipmentCondition($nIdForm, $nIdFormParent) {
      $oFormSpecialWorkingPartEquipmentCondition = FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentCondition($nIdForm);
      if ((!is_null($oFormSpecialWorkingPartEquipmentCondition)) && (!$oFormSpecialWorkingPartEquipmentCondition->custom)) $oFormSpecialWorkingPartEquipmentCondition->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartDynamicTexts', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormWorkRequest($nIdForm) {
      if (FModuleWorkingPartsManagement::allowDeleteFormWorkRequest($nIdForm)) {
         $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($nIdForm);
         
         if (!is_null($oFormWorkRequest)) $oFormWorkRequest->delete(); 
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkRequests'));   
   }
}