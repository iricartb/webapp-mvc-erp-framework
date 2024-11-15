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
            'actions'=>array('viewZones', 'viewRegions', 'viewEquipments', 'viewSections', 'viewDailyNotifications', 'viewDetailZone', 'viewDetailZoneRegion', 'viewDetailRegion', 'viewDetailRegionEquipment', 'viewDetailEquipment', 'viewDetailSection', 'viewDetailSectionNotification', 'viewDetailDailyNotification', 'updateZone', 'updateZoneRegion', 'updateRegion', 'updateRegionEquipment', 'updateEquipment', 'updateSection', 'updateSectionNotification', 'updateDailyNotification', 'deleteZone', 'deleteZoneRegion', 'deleteRegion', 'deleteRegionEquipment', 'deleteEquipment', 'deleteSection', 'deleteSectionNotification', 'deleteDailyNotification'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)))',
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
         $oZone->module = strtoupper(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT);
         
         $oZone->save();
      }
      else {    
         if (isset($_POST['ZonesRegions'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
            
            $oZoneRegion->attributes = $_POST['ZonesRegions'];
            $oZoneRegion->module = strtoupper(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT);
              
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
         $oRegion->module = strtoupper(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT);
         
         $oRegion->save();
      }
      else {    
         if (isset($_POST['RegionsEquipments'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
            
            $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
            $oRegionEquipment->module = strtoupper(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT);
            
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
      $oEquipmentFilters = new Equipments();
      $oEquipmentFilters->unsetAttributes();
      
      if (isset($_POST['Equipments'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('equipment-form', $oEquipment);
      
         $oEquipment->attributes = $_POST['Equipments'];
         $oEquipment->module = strtoupper(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT);
         
         $oEquipment->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['Equipments'])) $oEquipmentFilters->attributes = $_GET['Equipments'];   
      }

      $oEquipment->unsetAttributes();
      $this->render('viewEquipments', array('oModelForm'=>$oEquipment, 'oModelFormFilters'=>$oEquipmentFilters));    
   }
   public function actionViewSections() {
      $oDigitalDiarySection = new DigitalDiarySections();
      $oDigitalDiarySectionNotification = new DigitalDiarySectionsNotifications();
      $oDigitalDiarySectionFilters = new DigitalDiarySections();
      $oDigitalDiarySectionFilters->unsetAttributes();
      $oDigitalDiarySectionNotificationFilters = new DigitalDiarySectionsNotifications();
      $oDigitalDiarySectionNotificationFilters->unsetAttributes();
      
      if (isset($_POST['DigitalDiarySections'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('digitaldiary-section-form', $oDigitalDiarySection);
      
         $oDigitalDiarySection->attributes = $_POST['DigitalDiarySections'];
         $oDigitalDiarySection->save();
      }
      else {    
         if (isset($_POST['DigitalDiarySectionsNotifications'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('digitaldiary-section-notification-form', $oDigitalDiarySectionNotification);
            
            $oDigitalDiarySectionNotification->attributes = $_POST['DigitalDiarySectionsNotifications'];
            
            $oDigitalDiarySectionNotification->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['DigitalDiarySections'])) $oDigitalDiarySectionFilters->attributes = $_GET['DigitalDiarySections'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['DigitalDiarySectionsNotifications'])) $oDigitalDiarySectionNotificationFilters->attributes = $_GET['DigitalDiarySectionsNotifications'];   
         }   
      }

      $oDigitalDiarySection->unsetAttributes();
      $oDigitalDiarySectionNotification->unsetAttributes();
      $this->render('viewSections', array('oModelForm'=>$oDigitalDiarySection, 'oModelFormFilters'=>$oDigitalDiarySectionFilters, 'oModelFormAssociation'=>$oDigitalDiarySectionNotification, 'oModelFormAssociationFilters'=>$oDigitalDiarySectionNotificationFilters));     
   }
   public function actionViewDailyNotifications() {
      $oDigitalDiaryDialyNotification = new DigitalDiaryDailyNotifications();
      $oDigitalDiaryDialyNotificationFilters = new DigitalDiaryDailyNotifications();
      $oDigitalDiaryDialyNotificationFilters->unsetAttributes();
      
      if (isset($_POST['DigitalDiaryDailyNotifications'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('digitaldiary-daily-notification-form', $oDigitalDiaryDialyNotificationFilters);
      
         $oDigitalDiaryDialyNotification->attributes = $_POST['DigitalDiaryDailyNotifications'];
         $oDigitalDiaryDialyNotification->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['DigitalDiaryDailyNotifications'])) $oDigitalDiarySectionNotificationFilters->attributes = $_GET['DigitalDiaryDialyNotifications'];   
      }

      $oDigitalDiaryDialyNotification->unsetAttributes();
      $this->render('viewDailyNotifications', array('oModelForm'=>$oDigitalDiaryDialyNotification, 'oModelFormFilters'=>$oDigitalDiaryDialyNotificationFilters));
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
   public function actionViewDetailSection($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiarySection = DigitalDiarySections::getDigitalDiarySection($nIdForm);
       
      if (!is_null($oDigitalDiarySection)) $this->render('viewDetailSection', array('oModelForm'=>$oDigitalDiarySection));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailSectionNotification($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiarySectionNotification = DigitalDiarySectionsNotifications::getDigitalDiarySectionNotification($nIdForm);
       
      if (!is_null($oDigitalDiarySectionNotification)) $this->render('viewDetailSectionNotification', array('oModelForm'=>$oDigitalDiarySectionNotification));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailDailyNotification($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiaryDailyNotification = DigitalDiaryDailyNotifications::getDigitalDiaryDailyNotification($nIdForm);
       
      if (!is_null($oDigitalDiaryDailyNotification)) $this->render('viewDetailDailyNotification', array('oModelForm'=>$oDigitalDiaryDailyNotification));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
       
   
   public function actionUpdateZone($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oZone = Zones::getZone($nIdForm);
                               
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-form', $oZone);
         
            if (isset($_POST['Zones'])) {
               $oZone->attributes = $_POST['Zones'];
                 
               $oZone->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailZone', array('nIdForm'=>$oZone->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('zone-region-form', $oZoneRegion);
         
            if (isset($_POST['ZonesRegions'])) {
               $oZoneRegion->attributes = $_POST['ZonesRegions'];
                 
               $oZoneRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailZoneRegion', array('nIdForm'=>$oZoneRegion->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-form', $oRegion);
         
            if (isset($_POST['Regions'])) {
               $oRegion->attributes = $_POST['Regions'];
                 
               $oRegion->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailRegion', array('nIdForm'=>$oRegion->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('region-equipment-form', $oRegionEquipment);
         
            if (isset($_POST['RegionsEquipments'])) {
               $oRegionEquipment->attributes = $_POST['RegionsEquipments'];
                 
               $oRegionEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailRegionEquipment', array('nIdForm'=>$oRegionEquipment->id)));
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
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('equipment-form', $oEquipment);
         
            if (isset($_POST['Equipments'])) {
               $oEquipment->attributes = $_POST['Equipments'];
                 
               $oEquipment->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailEquipment', array('nIdForm'=>$oEquipment->id)));
            }
            else $this->render('updateEquipment', array('oModelForm'=>$oEquipment));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateSection($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiarySection = DigitalDiarySections::getDigitalDiarySection($nIdForm);
                               
      if (!is_null($oDigitalDiarySection)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('digitaldiary-section-form', $oDigitalDiarySection);
      
         if (isset($_POST['DigitalDiarySections'])) {
            $oDigitalDiarySection->attributes = $_POST['DigitalDiarySections'];
              
            $oDigitalDiarySection->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailSection', array('nIdForm'=>$oDigitalDiarySection->id)));
         }
         else $this->render('updateSection', array('oModelForm'=>$oDigitalDiarySection));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateSectionNotification($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiarySectionNotification = DigitalDiarySectionsNotifications::getDigitalDiarySectionNotification($nIdForm);
                               
      if (!is_null($oDigitalDiarySectionNotification)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('digitaldiary-section-notification-form', $oDigitalDiarySectionNotification);
      
         if (isset($_POST['DigitalDiarySectionsNotifications'])) {
            $oDigitalDiarySectionNotification->attributes = $_POST['DigitalDiarySectionsNotifications'];
              
            $oDigitalDiarySectionNotification->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailSectionNotification', array('nIdForm'=>$oDigitalDiarySectionNotification->id)));
         }
         else $this->render('updateSectionNotification', array('oModelForm'=>$oDigitalDiarySectionNotification));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateDailyNotification($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiaryDailyNotification = DigitalDiaryDailyNotifications::getDigitalDiaryDailyNotification($nIdForm);
                               
      if (!is_null($oDigitalDiaryDailyNotification)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('digitaldiary-daily-notification-form', $oDigitalDiaryDailyNotification);
      
         if (isset($_POST['DigitalDiaryDailyNotifications'])) {
            $oDigitalDiaryDailyNotification->attributes = $_POST['DigitalDiaryDailyNotifications'];
              
            $oDigitalDiaryDailyNotification->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDetailDailyNotification', array('nIdForm'=>$oDigitalDiaryDailyNotification->id)));
         }
         else $this->render('updateDailyNotification', array('oModelForm'=>$oDigitalDiaryDailyNotification));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionDeleteZone($nIdForm) {
      $oZone = Zones::getZone($nIdForm);
      if (!is_null($oZone)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment($nIdForm, null, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $oZone->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteZoneRegion($nIdForm) {
      $oZoneRegion = ZonesRegions::getZoneRegion($nIdForm);
      if (!is_null($oZoneRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, $nIdForm, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $oZoneRegion->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewZones'));
   }
   public function actionDeleteRegion($nIdForm) {
      $oRegion = Regions::getRegion($nIdForm);
      if (!is_null($oRegion)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, $nIdForm, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $oRegion->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteRegionEquipment($nIdForm) {
      $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdForm);
      if (!is_null($oRegionEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, $nIdForm, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $oRegionEquipment->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewRegions'));
   }
   public function actionDeleteEquipment($nIdForm) {
      $oEquipment = Equipments::getEquipment($nIdForm);
      if (!is_null($oEquipment)) {
         if (FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $nIdForm, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $oEquipment->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
        
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewEquipments'));
   }
   public function actionDeleteSection($nIdForm) {
      $oDigitalDiarySection = DigitalDiarySections::getDigitalDiarySection($nIdForm);
      if (!is_null($oDigitalDiarySection)) $oDigitalDiarySection->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewSections'));
   }
   public function actionDeleteSectionNotification($nIdForm) {
      $oDigitalDiarySectionNotification = DigitalDiarySectionsNotifications::getDigitalDiarySectionNotification($nIdForm);
      if (!is_null($oDigitalDiarySectionNotification)) $oDigitalDiarySectionNotification->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewSections'));
   }
   public function actionDeleteDailyNotification($nIdForm) {
      $oDigitalDiaryDailyNotification = DigitalDiaryDailyNotifications::getDigitalDiaryDailyNotification($nIdForm);
      if (!is_null($oDigitalDiaryDailyNotification)) $oDigitalDiaryDailyNotification->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewDailyNotifications'));
   }
}