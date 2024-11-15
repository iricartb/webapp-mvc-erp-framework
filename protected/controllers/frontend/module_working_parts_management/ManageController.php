<?php

class ManageController extends FrontendController {
    
   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow admin user to perform actions
            'actions'=>array('viewZones', 'viewRegions', 'viewEquipments', 'viewRisks', 'viewIPEs', 'viewPreventionMeans', 'viewMethods', 'viewDynamicTexts', 'viewPriorities', 'viewDetailZone', 'viewDetailZoneRegion', 'viewDetailRegion', 'viewDetailRegionEquipment', 'viewDetailEquipment', 'viewDetailEquipmentRisk', 'viewDetailRisk', 'viewDetailRiskIPE', 'viewDetailIPE', 'viewDetailPreventionMean', 'viewDetailMethod', 'viewDetailMethodRisk', 'viewDetailMethodIPE', 'viewDetailMeasure', 'viewDetailEquipmentCondition', 'viewDetailPriority', 'updateZone', 'updateZoneRegion', 'updateRegion', 'updateRegionEquipment', 'updateEquipment', 'updateEquipmentRisk', 'updateRisk', 'updateRiskIPE', 'updateIPE', 'updatePreventionMean', 'updateMethod', 'updateMethodRisk', 'updateMethodIPE', 'updateMeasure', 'updateEquipmentCondition', 'updatePriority', 'deleteZone', 'deleteZoneRegion', 'deleteRegion', 'deleteRegionEquipment', 'deleteEquipment', 'deleteEquipmentRisk', 'deleteRisk', 'deleteRiskIPE', 'deleteIPE', 'deletePreventionMean', 'deleteMethod', 'deleteMethodRisk', 'deleteMethodIPE', 'deleteMeasure', 'deleteEquipmentCondition', 'deletePriority'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)))',
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
         $oZone->module = strtoupper(FApplication::MODULE_WORKING_PARTS_MANAGEMENT);
         
         $oZone->save();
      }
      else {    
         if (isset($_POST['ZonesRegions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
            
            $oZoneRegion->attributes = $_POST['ZonesRegions'];
            $oZoneRegion->module = strtoupper(FApplication::MODULE_WORKING_PARTS_MANAGEMENT);
              
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
         $oRegion->module = strtoupper(FApplication::MODULE_WORKING_PARTS_MANAGEMENT);
         
         $oRegion->save();
      }
      else {    
         if (isset($_POST['RegionsEquipments'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
            
            $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
            $oRegionEquipment->module = strtoupper(FApplication::MODULE_WORKING_PARTS_MANAGEMENT);
              
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
      $oEquipmentRisk = new EquipmentsRisks();
      $oEquipmentFilters = new Equipments();
      $oEquipmentFilters->unsetAttributes();
      $oEquipmentRiskFilters = new EquipmentsRisks();
      $oEquipmentRiskFilters->unsetAttributes();
      
      if (isset($_POST['Equipments'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-form', $oEquipment);
      
         $oEquipment->attributes = $_POST['Equipments'];
         $oEquipment->module = strtoupper(FApplication::MODULE_WORKING_PARTS_MANAGEMENT);
         
         $oEquipment->save();
      }
      else {    
         if (isset($_POST['EquipmentsRisks'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-risk-form', $oEquipmentRisk);
            
            $oEquipmentRisk->attributes = $_POST['EquipmentsRisks'];

            $oEquipmentRisk->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['Equipments'])) $oEquipmentFilters->attributes = $_GET['Equipments'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['EquipmentsRisks'])) $oEquipmentRiskFilters->attributes = $_GET['EquipmentsRisks'];   
         }   
      }

      $oEquipment->unsetAttributes();
      $oEquipmentRisk->unsetAttributes();
      $this->render('viewEquipments', array('oModelForm'=>$oEquipment, 'oModelFormFilters'=>$oEquipmentFilters, 'oModelFormAssociation'=>$oEquipmentRisk, 'oModelFormAssociationFilters'=>$oEquipmentRiskFilters));    
   }
   public function actionViewRisks() {
      $oRisk = new Risks();
      $oRiskIpe = new RisksIPEs();
      $oRiskFilters = new Risks();
      $oRiskFilters->unsetAttributes();
      $oRiskIpeFilters = new RisksIPEs();
      $oRiskIpeFilters->unsetAttributes();
      
      if (isset($_POST['Risks'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('risk-form', $oRisk);
      
         $oRisk->attributes = $_POST['Risks'];
           
         $oRisk->save();
      }
      else {    
         if (isset($_POST['RisksIPEs'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('risk-ipe-form', $oRiskIpe);
            
            $oRiskIpe->attributes = $_POST['RisksIPEs'];
              
            $oRiskIpe->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['Risks'])) $oRiskFilters->attributes = $_GET['Risks'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['RisksIPEs'])) $oRiskIpeFilters->attributes = $_GET['RisksIPEs'];   
         }   
      }

      $oRisk->unsetAttributes();
      $oRiskIpe->unsetAttributes();
      $this->render('viewRisks', array('oModelForm'=>$oRisk, 'oModelFormFilters'=>$oRiskFilters, 'oModelFormAssociation'=>$oRiskIpe, 'oModelFormAssociationFilters'=>$oRiskIpeFilters));     
   }
   public function actionViewIPEs() {
      $oIPE = new IPEs();
      $oIPEFilters = new IPEs();
      $oIPEFilters->unsetAttributes();
       
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('ipe-form', $oIPE);
      
      if (isset($_POST['IPEs'])) {  
         $oIPE->attributes = $_POST['IPEs'];
           
         $oIPE->save();
      }
      else { 
         // Filters Grid Get Parameters
         if (isset($_GET['IPEs'])) $oIPEFilters->attributes = $_GET['IPEs'];
      }

      $oIPE->unsetAttributes();
      $this->render('viewIPEs', array('oModelForm'=>$oIPE, 'oModelFormFilters'=>$oIPEFilters));     
   }
   public function actionViewPreventionMeans() {
      $oPreventionMean = new PreventionMeans();
      $oPreventionMeanFilters = new PreventionMeans();
      $oPreventionMeanFilters->unsetAttributes();
       
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('prevention-mean-form', $oPreventionMean);
      
      if (isset($_POST['PreventionMeans'])) {  
         $oPreventionMean->attributes = $_POST['PreventionMeans'];
           
         $oPreventionMean->save();
      }
      else { 
         // Filters Grid Get Parameters
         if (isset($_GET['PreventionMeans'])) $oPreventionMeanFilters->attributes = $_GET['PreventionMeans'];
      }

      $oPreventionMean->unsetAttributes();
      $this->render('viewPreventionMeans', array('oModelForm'=>$oPreventionMean, 'oModelFormFilters'=>$oPreventionMeanFilters));     
   }
   public function actionViewMethods() {
      $oMethod = new Methods();
      $oMethodRisk = new MethodsRisks();
      $oMethodIPE = new MethodsIPEs();
      $oMethodFilters = new Methods();
      $oMethodRiskFilters = new MethodsRisks();
      $oMethodIPEFilters = new MethodsIPEs();
      $oMethodFilters->unsetAttributes();
      $oMethodRiskFilters->unsetAttributes();
      $oMethodIPEFilters->unsetAttributes();
      
      if (isset($_POST['Methods'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('method-form', $oMethod);
         $oMethod->attributes = $_POST['Methods'];
         
         $oMethod->save();
      }
      else {
         if (isset($_POST['MethodsRisks'])) {
            FForm::validateAjaxForm('method-risk-form', $oMethodRisk);
            
            $oMethodRisk->attributes = $_POST['MethodsRisks'];

            $oMethodRisk->save();
         }
         else {
            if (isset($_POST['MethodsIPEs'])) {
               FForm::validateAjaxForm('method-ipe-form', $oMethodIPE);
               
               $oMethodIPE->attributes = $_POST['MethodsIPEs'];

               $oMethodIPE->save();
            }
            else {
               // Filters Grid Get Parameters
               if (isset($_GET['Methods'])) $oMethodFilters->attributes = $_GET['Methods']; 
               
               // Filters Grid Get Parameters
               if (isset($_GET['MethodsRisks'])) $oMethodRiskFilters->attributes = $_GET['MethodsRisks'];  
               
               // Filters Grid Get Parameters
               if (isset($_GET['MethodsIPEs'])) $oMethodIPEFilters->attributes = $_GET['MethodsIPEs'];
            }
         }
      }   
      
      $oMethod->unsetAttributes();
      $oMethodRisk->unsetAttributes();
      $oMethodIPE->unsetAttributes();
      $this->render('viewMethods', array('oModelForm'=>$oMethod, 'oModelFormFilters'=>$oMethodFilters, 'oModelFormAssociationRisk'=>$oMethodRisk, 'oModelFormAssociationRiskFilters'=>$oMethodRiskFilters, 'oModelFormAssociationIPE'=>$oMethodIPE, 'oModelFormAssociationIPEFilters'=>$oMethodIPEFilters));          
   }
   public function actionViewDynamicTexts() {
      $oMeasure = new Measures();
      $oMeasureFilters = new Measures();
      $oMeasureFilters->unsetAttributes();
      $oEquipmentCondition = new EquipmentConditions();
      $oEquipmentConditionFilters = new EquipmentConditions();
      $oEquipmentConditionFilters->unsetAttributes();
      $bError = false;
      
      if (isset($_POST['Measures'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('measure-form', $oMeasure);
         
         if ($_POST['Measures']['visible_default_working_part']) {
            $nWorkingPartsMeasures = count(Measures::getMeasures(true, null, null));
            
            if ($nWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS) {
               Yii::app()->user->setFlash('error-measure', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS)));
               $bError = true;
            }  
         }
         if ($_POST['Measures']['visible_default_special_working_part']) {
            $nSpecialWorkingPartsMeasures = count(Measures::getMeasures(null, true, null));
                  
            if ($nSpecialWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS) {
               Yii::app()->user->setFlash('error-measure', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS)));
               $bError = true;
            }  
         }
         if ($_POST['Measures']['visible_default_maintenance_working_part']) {
            $nMaintenanceWorkingPartsMeasures = count(Measures::getMeasures(null, null, true));
   
            if ($nMaintenanceWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS) {
               Yii::app()->user->setFlash('error-measure', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS)));
               $bError = true;
            }  
         }
         
         if (!$bError) {
            $oMeasure->attributes = $_POST['Measures'];
              
            if (strtolower($oMeasure->description) != strtolower(FString::STRING_OTHERS)) $oMeasure->save();
         }
      }
      else {
         if (isset($_POST['EquipmentConditions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-condition-form', $oEquipmentCondition);
            
            if (isset($_POST['EquipmentConditions'])) {
               if ($_POST['EquipmentConditions']['visible_default_working_part']) {
                  $nWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(true, null, null));
                  
                  if ($nWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS) {
                     Yii::app()->user->setFlash('error-equipment-condition', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS)));
                     $bError = true;
                  }  
               }
               if ($_POST['EquipmentConditions']['visible_default_special_working_part']) {
                  $nSpecialWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(null, true, null));
                        
                  if ($nSpecialWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS) {
                     Yii::app()->user->setFlash('error-equipment-condition', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS)));
                     $bError = true;
                  }  
               }
               if ($_POST['EquipmentConditions']['visible_default_maintenance_working_part']) {
                  $nMaintenanceWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(null, null, true));
         
                  if ($nMaintenanceWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS) {
                     Yii::app()->user->setFlash('error-equipment-condition', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS)));
                     $bError = true;
                  }  
               }
               
               if (!$bError) {
                  $oEquipmentCondition->attributes = $_POST['EquipmentConditions'];
                    
                  if (strtolower($oEquipmentCondition->description) != strtolower(FString::STRING_OTHERS)) $oEquipmentCondition->save();
               }
            }
            else {
               if (isset($_GET['Measures'])) $oMeasureFilters->attributes = $_GET['Measures'];
               if (isset($_GET['EquipmentConditions'])) $oEquipmentConditionFilters->attributes = $_GET['EquipmentConditions'];   
            }   
         }   
      }
      
      $oMeasure->unsetAttributes();
      $oEquipmentCondition->unsetAttributes();
      $this->render('viewDynamicTexts', array('oModelFormMeasure'=>$oMeasure, 'oModelFormMeasureFilters'=>$oMeasureFilters, 'oModelFormEquipmentCondition'=>$oEquipmentCondition, 'oModelFormEquipmentConditionFilters'=>$oEquipmentConditionFilters));          
   }    
   public function actionViewPriorities() {
      $oPriority = new Priorities();
      $oPriorityFilters = new Priorities();
      $oPriorityFilters->unsetAttributes();
      
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('priority-form', $oPriority);
      
      if (isset($_POST['Priorities'])) {
         $oPriority->attributes = $_POST['Priorities'];
           
         $oPriority->save();
      }
      else { 
         // Filters Grid Get Parameters
         if (isset($_GET['Priorities'])) $oPriorityFilters->attributes = $_GET['Priorities'];
      }

      $oPriority->unsetAttributes();
      $this->render('viewPriorities', array('oModelForm'=>$oPriority, 'oModelFormFilters'=>$oPriorityFilters));    
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
   public function actionViewDetailEquipmentRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentRisk = EquipmentsRisks::getEquipmentRisk($nIdForm);
       
      if (!is_null($oEquipmentRisk)) $this->render('viewDetailEquipmentRisk', array('oModelForm'=>$oEquipmentRisk));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRisk = Risks::getRisk($nIdForm);
       
      if (!is_null($oRisk)) $this->render('viewDetailRisk', array('oModelForm'=>$oRisk));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailRiskIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRiskIPE = RisksIPEs::getRiskIPE($nIdForm);
       
      if (!is_null($oRiskIPE)) $this->render('viewDetailRiskIPE', array('oModelForm'=>$oRiskIPE));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oIPE = IPEs::getIPE($nIdForm);
       
      if (!is_null($oIPE)) $this->render('viewDetailIPE', array('oModelForm'=>$oIPE));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailPreventionMean($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPreventionMean = PreventionMeans::getPreventionMean($nIdForm);
       
      if (!is_null($oPreventionMean)) $this->render('viewDetailPreventionMean', array('oModelForm'=>$oPreventionMean));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailMethod($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethod = Methods::getMethod($nIdForm);
       
      if (!is_null($oMethod)) $this->render('viewDetailMethod', array('oModelForm'=>$oMethod));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailMethodRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethodRisk = MethodsRisks::getMethodRisk($nIdForm);
       
      if (!is_null($oMethodRisk)) $this->render('viewDetailMethodRisk', array('oModelForm'=>$oMethodRisk));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailMethodIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethodIPE = MethodsIPEs::getMethodIPE($nIdForm);
       
      if (!is_null($oMethodIPE)) $this->render('viewDetailMethodIPE', array('oModelForm'=>$oMethodIPE));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailMeasure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMeasure = Measures::getMeasure($nIdForm);
       
      if (!is_null($oMeasure)) $this->render('viewDetailMeasure', array('oModelForm'=>$oMeasure));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailEquipmentCondition($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentCondition = EquipmentConditions::getEquipmentCondition($nIdForm);
       
      if (!is_null($oEquipmentCondition)) $this->render('viewDetailEquipmentCondition', array('oModelForm'=>$oEquipmentCondition));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailPriority($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPriority = Priorities::getPriority($nIdForm);
       
      if (!is_null($oPriority)) $this->render('viewDetailPriority', array('oModelForm'=>$oPriority));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
    
   public function actionUpdateZone($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZone = Zones::getZone($nIdForm);
                               
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-form', $oZone);
         
            if (isset($_POST['Zones'])) {
               $oZone->attributes = $_POST['Zones'];
                 
               $oZone->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailZone', array('nIdForm'=>$oZone->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
         
            if (isset($_POST['ZonesRegions'])) {
               $oZoneRegion->attributes = $_POST['ZonesRegions'];
                 
               $oZoneRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailZoneRegion', array('nIdForm'=>$oZoneRegion->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-form', $oRegion);
         
            if (isset($_POST['Regions'])) {
               $oRegion->attributes = $_POST['Regions'];
                 
               $oRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailRegion', array('nIdForm'=>$oRegion->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
         
            if (isset($_POST['RegionsEquipments'])) {
               $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
                 
               $oRegionEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailRegionEquipment', array('nIdForm'=>$oRegionEquipment->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-form', $oEquipment);
         
            if (isset($_POST['Equipments'])) {
               $oEquipment->attributes = $_POST['Equipments'];
                 
               $oEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailEquipment', array('nIdForm'=>$oEquipment->id)));
            }
            else $this->render('updateEquipment', array('oModelForm'=>$oEquipment));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }  
   public function actionUpdateEquipmentRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentRisk = EquipmentsRisks::getEquipmentRisk($nIdForm);
                               
      if (!is_null($oEquipmentRisk)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-risk-form', $oEquipmentRisk);
      
         if (isset($_POST['EquipmentsRisks'])) {
            $oEquipmentRisk->attributes = $_POST['EquipmentsRisks'];
              
            $oEquipmentRisk->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailEquipmentRisk', array('nIdForm'=>$oEquipmentRisk->id)));
         }
         else $this->render('updateEquipmentRisk', array('oModelForm'=>$oEquipmentRisk));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRisk = Risks::getRisk($nIdForm);
                               
      if (!is_null($oRisk)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('risk-form', $oRisk);
      
         if (isset($_POST['Risks'])) {
            $oRisk->attributes = $_POST['Risks'];
              
            $oRisk->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailRisk', array('nIdForm'=>$oRisk->id)));
         }
         else $this->render('updateRisk', array('oModelForm'=>$oRisk));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateRiskIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oRiskIPE = RisksIPEs::getRiskIPE($nIdForm);
                               
      if (!is_null($oRiskIPE)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('risk-ipe-form', $oRiskIPE);
      
         if (isset($_POST['RisksIPEs'])) {
            $oRiskIPE->attributes = $_POST['RisksIPEs'];
              
            $oRiskIPE->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailRiskIPE', array('nIdForm'=>$oRiskIPE->id)));
         }
         else $this->render('updateRiskIPE', array('oModelForm'=>$oRiskIPE));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oIPE = IPEs::getIPE($nIdForm);
                               
      if (!is_null($oIPE)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('ipe-form', $oIPE);
      
         if (isset($_POST['IPEs'])) {
            $oIPE->attributes = $_POST['IPEs'];
              
            $oIPE->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailIPE', array('nIdForm'=>$oIPE->id)));
         }
         else $this->render('updateIPE', array('oModelForm'=>$oIPE));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdatePreventionMean($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPreventionMean = PreventionMeans::getPreventionMean($nIdForm);
                               
      if (!is_null($oPreventionMean)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('prevention-mean-form', $oPreventionMean);
      
         if (isset($_POST['PreventionMeans'])) {
            $oPreventionMean->attributes = $_POST['PreventionMeans'];
              
            $oPreventionMean->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailPreventionMean', array('nIdForm'=>$oPreventionMean->id)));
         }
         else $this->render('updatePreventionMean', array('oModelForm'=>$oPreventionMean));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateMethod($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethod = Methods::getMethod($nIdForm);
                               
      if (!is_null($oMethod)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('method-form', $oMethod);
      
         if (isset($_POST['Methods'])) {
            $oMethod->attributes = $_POST['Methods'];
              
            $oMethod->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailMethod', array('nIdForm'=>$oMethod->id)));
         }
         else $this->render('updateMethod', array('oModelForm'=>$oMethod));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateMethodRisk($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethodRisk = MethodsRisks::getMethodRisk($nIdForm);
                               
      if (!is_null($oMethodRisk)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('method-risk-form', $oMethodRisk);
      
         if (isset($_POST['MethodsRisks'])) {
            $oMethodRisk->attributes = $_POST['MethodsRisks'];
              
            $oMethodRisk->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailMethodRisk', array('nIdForm'=>$oMethodRisk->id)));
         }
         else $this->render('updateMethodRisk', array('oModelForm'=>$oMethodRisk));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateMethodIPE($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMethodIPE = MethodsIPEs::getMethodIPE($nIdForm);
                               
      if (!is_null($oMethodIPE)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('method-ipe-form', $oMethodIPE);
      
         if (isset($_POST['MethodsIPEs'])) {
            $oMethodIPE->attributes = $_POST['MethodsIPEs'];
              
            $oMethodIPE->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailMethodIPE', array('nIdForm'=>$oMethodIPE->id)));
         }
         else $this->render('updateMethodIPE', array('oModelForm'=>$oMethodIPE));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateMeasure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMeasure = Measures::getMeasure($nIdForm);
      $bError = false;
                               
      if (!is_null($oMeasure)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('measure-form', $oMeasure);
      
         if (isset($_POST['Measures'])) {
            if (($_POST['Measures']['visible_default_working_part']) && (!$oMeasure->visible_default_working_part)) {
               $nWorkingPartsMeasures = count(Measures::getMeasures(true, null, null));
               
               if ($nWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
            if (($_POST['Measures']['visible_default_special_working_part']) && (!$oMeasure->visible_default_special_working_part)) {
               $nSpecialWorkingPartsMeasures = count(Measures::getMeasures(null, true, null));
               
               if ($nSpecialWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
            if (($_POST['Measures']['visible_default_maintenance_working_part']) && (!$oMeasure->visible_default_maintenance_working_part)) {
               $nMaintenanceWorkingPartsMeasures = count(Measures::getMeasures(null, null, true));
               
               if ($nMaintenanceWorkingPartsMeasures >= FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEMEASURES_FORM_SUBMIT_ERROR_MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
         
            if (!$bError) {
               $oMeasure->attributes = $_POST['Measures'];
                 
               $oMeasure->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailMeasure', array('nIdForm'=>$oMeasure->id)));
            }
            else $this->render('updateMeasure', array('oModelForm'=>$oMeasure));
         }
         else $this->render('updateMeasure', array('oModelForm'=>$oMeasure));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateEquipmentCondition($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEquipmentCondition = EquipmentConditions::getEquipmentCondition($nIdForm);
      $bError = false;                                                    
                               
      if (!is_null($oEquipmentCondition)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-condition-form', $oEquipmentCondition);
      
         if (isset($_POST['EquipmentConditions'])) {
            if (($_POST['EquipmentConditions']['visible_default_working_part']) && (!$oEquipmentCondition->visible_default_working_part)) {
               $nWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(true, null, null));
               
               if ($nWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
            if (($_POST['EquipmentConditions']['visible_default_special_working_part']) && (!$oEquipmentCondition->visible_default_special_working_part)) {
               $nSpecialWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(null, true, null));
                     
               if ($nSpecialWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
            if (($_POST['EquipmentConditions']['visible_default_maintenance_working_part']) && (!$oEquipmentCondition->visible_default_maintenance_working_part)) {
               $nMaintenanceWorkingPartsEquipmentConditions = count(EquipmentConditions::getEquipmentConditions(null, null, true));
      
               if ($nMaintenanceWorkingPartsEquipmentConditions >= FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS) {
                  Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWUPDATEEQUIPMENTCONDITIONS_FORM_SUBMIT_ERROR_MAX_EQUIPMENTCONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS', array('{1}'=>FModuleWorkingPartsManagement::MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS)));
                  $bError = true;
               }  
            }
         
            if (!$bError) {
               $oEquipmentCondition->attributes = $_POST['EquipmentConditions'];
                 
               $oEquipmentCondition->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailEquipmentCondition', array('nIdForm'=>$oEquipmentCondition->id)));
            }
            else $this->render('updateEquipmentCondition', array('oModelForm'=>$oEquipmentCondition));
         }
         else $this->render('updateEquipmentCondition', array('oModelForm'=>$oEquipmentCondition));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdatePriority($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPriority = Priorities::getPriority($nIdForm);
                               
      if (!is_null($oPriority)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('priority-form', $oPriority);
      
         if (isset($_POST['Priorities'])) {
            $oPriority->attributes = $_POST['Priorities'];
              
            $oPriority->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDetailPriority', array('nIdForm'=>$oPriority->id)));
         }
         else $this->render('updatePriority', array('oModelForm'=>$oPriority));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   } 

   
   public function actionDeleteZone($nIdForm) {
      $oZone = Zones::getZone($nIdForm);
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) $oZone->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteZoneRegion($nIdForm) {
      $oZoneRegion = ZonesRegions::getZoneRegion($nIdForm);
      if (!is_null($oZoneRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) $oZoneRegion->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteRegion($nIdForm) {
      $oRegion = Regions::getRegion($nIdForm);
      if (!is_null($oRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) $oRegion->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteRegionEquipment($nIdForm) {
      $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdForm);
      if (!is_null($oRegionEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) $oRegionEquipment->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteEquipment($nIdForm) {
      $oEquipment = Equipments::getEquipment($nIdForm);
      if (!is_null($oEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) $oEquipment->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
        
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewEquipments'));
   }
   public function actionDeleteEquipmentRisk($nIdForm) {
      $oEquipmentRisk = EquipmentsRisks::getEquipmentRisk($nIdForm);
      if (!is_null($oEquipmentRisk)) $oEquipmentRisk->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewEquipments'));
   }
   public function actionDeleteRisk($nIdForm) {
      $oRisk = Risks::getRisk($nIdForm);
      if (!is_null($oRisk)) $oRisk->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRisks'));
   }
   public function actionDeleteRiskIPE($nIdForm) {
      $oRiskIPE = RisksIPEs::getRiskIPE($nIdForm);
      if (!is_null($oRiskIPE)) $oRiskIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRisks'));
   }
   public function actionDeleteIPE($nIdForm) {
      $oIPE = IPEs::getIPE($nIdForm);
      if (!is_null($oIPE)) $oIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewIPEs'));
   }
   public function actionDeletePreventionMean($nIdForm) {
      $oPreventionMean = PreventionMeans::getPreventionMean($nIdForm);
      if (!is_null($oPreventionMean)) $oPreventionMean->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewPreventionMeans'));
   }
   public function actionDeleteMethod($nIdForm) {
      $oMethod = Methods::getMethod($nIdForm);
      if (!is_null($oMethod)) $oMethod->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'));
   }
   public function actionDeleteMethodRisk($nIdForm) {
      $oMethodRisk = MethodsRisks::getMethodRisk($nIdForm);
      if (!is_null($oMethodRisk)) $oMethodRisk->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'));
   }
   public function actionDeleteMethodIPE($nIdForm) {
      $oMethodIPE = MethodsIPEs::getMethodIPE($nIdForm);
      if (!is_null($oMethodIPE)) $oMethodIPE->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'));
   }
   public function actionDeleteMeasure($nIdForm) {
      $oMeasure = Measures::getMeasure($nIdForm);
      if (!is_null($oMeasure)) $oMeasure->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDynamicTexts'));
   }
   public function actionDeleteEquipmentCondition($nIdForm) {
      $oEquipmentCondition = EquipmentConditions::getEquipmentCondition($nIdForm);
      if (!is_null($oEquipmentCondition)) $oEquipmentCondition->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewDynamicTexts'));
   }
   public function actionDeletePriority($nIdForm) {
      $oPriority = Priorities::getPriority($nIdForm);
      if (!is_null($oPriority)) $oPriority->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewPriorities'));
   }
}