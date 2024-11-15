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
            'actions'=>array('viewForms', 'viewFormsQuestions', 'viewDetailGroupForm', 'viewDetailForm', 'viewDetailFormQuestion', 'viewDetailDevice', 'updateGroupForm', 'updateForm', 'updateFormQuestion', 'deleteGroupForm', 'deleteForm', 'deleteFormQuestion'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)))',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewForms() {
      $oMonitoringGroupForm = new MonitoringGroupForms();
      $oMonitoringForm = new MonitoringForms();
      $oMonitoringGroupFormFilters = new MonitoringGroupForms();
      $oMonitoringGroupFormFilters->unsetAttributes();
      $oMonitoringFormFilters = new MonitoringForms();
      $oMonitoringFormFilters->unsetAttributes();
      
      if (isset($_POST['MonitoringGroupForms'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('monitoring-group-form-form', $oMonitoringGroupForm);
      
         $oMonitoringGroupForm->attributes = $_POST['MonitoringGroupForms'];
         $oMonitoringGroupForm->save();
      }
      else {    
         if (isset($_POST['MonitoringForms'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('monitoring-form-form', $oMonitoringForm);
            
            $oMonitoringForm->attributes = $_POST['MonitoringForms'];
            $oMonitoringForm->id_zone_region = $_POST['MonitoringForms']['id_zone_region'];
            
            $oMonitoringForm->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['MonitoringGroupForms'])) $oMonitoringGroupFormFilters->attributes = $_GET['MonitoringGroupForms'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['MonitoringForms'])) {
               $oMonitoringFormFilters->attributes = $_GET['MonitoringForms'];   
               $oMonitoringFormFilters->id_zone_region = $_GET['MonitoringForms']['id_zone_region'];       
            }
         }   
      }

      $oMonitoringGroupForm->unsetAttributes();
      $oMonitoringForm->unsetAttributes();
      $this->render('viewForms', array('oModelForm'=>$oMonitoringGroupForm, 'oModelFormFilters'=>$oMonitoringGroupFormFilters, 'oModelFormAssociation'=>$oMonitoringForm, 'oModelFormAssociationFilters'=>$oMonitoringFormFilters));     
   }
   public function actionViewFormsQuestions() {
      $bSetDefaultValues = false;
      $bError = false;
      $oMonitoringFormQuestion = new MonitoringFormsQuestions();
      $oMonitoringFormQuestionFilters = new MonitoringFormsQuestions();
      $oMonitoringFormQuestionFilters->unsetAttributes();
      
      if (isset($_POST['MonitoringFormsQuestions'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('monitoring-form-question-form', $oMonitoringFormQuestion);
      
         $oMonitoringFormQuestion->attributes = $_POST['MonitoringFormsQuestions'];
         $oMonitoringFormQuestion->field_type = $_POST['MonitoringFormsQuestions']['field_type']; 
         $oMonitoringFormQuestion->repeat = $_POST['MonitoringFormsQuestions']['repeat']; 
         $oMonitoringFormQuestion->start_hour = $_POST['MonitoringFormsQuestions']['start_hour']; 
         $oMonitoringFormQuestion->end_hour = $_POST['MonitoringFormsQuestions']['end_hour']; 
         
         $sFieldValueOptions = FString::STRING_EMPTY;
         if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_options)) {
            $nNumTokens = FString::getNumTokens($oMonitoringFormQuestion->field_value_options, ',');
            for($i = 1; $i <= $nNumTokens; $i++) {
               $sToken = FString::getToken($oMonitoringFormQuestion->field_value_options, ',', $i);
               $sToken = str_replace(FString::STRING_SPACE, '', $sToken);
               
               if (strlen($sToken) > 0) {
                  if (strlen($sToken) > 10) $sToken = substr($sToken, 0, 10);
                  
                  if (strlen($sFieldValueOptions) > 0) $sFieldValueOptions .= ',' . $sToken; 
                  else $sFieldValueOptions = $sToken;
               } 
            }
            
            $oMonitoringFormQuestion->field_value_options = $sFieldValueOptions;
         } 
               
         if ($oMonitoringFormQuestion->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_NUMERIC) {
            if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_default)) {
               if (!is_numeric($oMonitoringFormQuestion->field_value_default)) {
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMSQUESTIONS_FORM_SUBMIT_ERROR_VALUE_DEFAULT_IS_NOT_NUMERIC'));
                  $bError = true;
               }
            }
            
            if (!$bError) {
               if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_options)) {
                  $nNumTokens = FString::getNumTokens($oMonitoringFormQuestion->field_value_options, ',');
                  for($i = 1; (($i <= $nNumTokens) && (!$bError)); $i++) {
                     $sToken = FString::getToken($oMonitoringFormQuestion->field_value_options, ',', $i);
                     if (!is_numeric($sToken)) { 
                        FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMSQUESTIONS_FORM_SUBMIT_ERROR_VALUE_OPTION_IS_NOT_NUMERIC'));
                        $bError = true; 
                     }  
                  } 
               }      
            }  
         }
         else if ($oMonitoringFormQuestion->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT) {
            $oMonitoringFormQuestion->field_required = true;
            
            if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_default)) {
               if (($oMonitoringFormQuestion->field_value_default != '0') && ($oMonitoringFormQuestion->field_value_default != '1')) { 
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMSQUESTIONS_FORM_SUBMIT_ERROR_VALUE_DEFAULT_IS_NOT_BIT'));
                  $bError = true;
               }
            }   
         }
         
         if (!$bError) {
            if ((!(FString::isNullOrEmpty($oMonitoringFormQuestion->start_hour))) || (!(FString::isNullOrEmpty($oMonitoringFormQuestion->end_hour)))) { 
               if ((FString::isNullOrEmpty($oMonitoringFormQuestion->start_hour)) || (FString::isNullOrEmpty($oMonitoringFormQuestion->end_hour))) {
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMSQUESTIONS_FORM_SUBMIT_ERROR_HOUR_RANGE_IS_INVALID'));
                  $bError = true;   
               }
            }
         }
         
         if (!$bError) {
            $oMonitoringFormQuestion->save();
            
            $oMonitoringFormQuestion->unsetAttributes();
            $bSetDefaultValues = true;
         }
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['MonitoringFormsQuestions'])) $oMonitoringFormQuestionFilters->attributes = $_GET['MonitoringFormsQuestions'];
         else $bSetDefaultValues = true;  
      }
      
      if ($bSetDefaultValues) {
         $oMonitoringFormQuestion->field_type = FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_NUMERIC;
         $oMonitoringFormQuestion->field_required = true;
         $oMonitoringFormQuestion->repeat = FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_DIALY;
      }

      $this->render('viewFormsQuestions', array('oModelForm'=>$oMonitoringFormQuestion, 'oModelFormFilters'=>$oMonitoringFormQuestionFilters));
   }
   
   
   public function actionViewDetailGroupForm($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringGroupForm = MonitoringGroupForms::getMonitoringGroupForm($nIdForm);
       
      if (!is_null($oMonitoringGroupForm)) $this->render('viewDetailGroupForm', array('oModelForm'=>$oMonitoringGroupForm));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailForm($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringForm = MonitoringForms::getMonitoringForm($nIdForm);
       
      if (!is_null($oMonitoringForm)) $this->render('viewDetailForm', array('oModelForm'=>$oMonitoringForm));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormQuestion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringFormQuestion = MonitoringFormsQuestions::getMonitoringFormQuestion($nIdForm);
       
      if (!is_null($oMonitoringFormQuestion)) $this->render('viewDetailFormQuestion', array('oModelForm'=>$oMonitoringFormQuestion));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionUpdateGroupForm($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringGroupForm = MonitoringGroupForms::getMonitoringGroupForm($nIdForm);
                               
      if (!is_null($oMonitoringGroupForm)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('monitoring-group-form-form', $oMonitoringGroupForm);
      
         if (isset($_POST['MonitoringGroupForms'])) {
            $oMonitoringGroupForm->attributes = $_POST['MonitoringGroupForms'];
              
            $oMonitoringGroupForm->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewDetailGroupForm', array('nIdForm'=>$oMonitoringGroupForm->id)));
         }
         else $this->render('updateGroupForm', array('oModelForm'=>$oMonitoringGroupForm));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateForm($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringForm = MonitoringForms::getMonitoringForm($nIdForm);
                               
      if (!is_null($oMonitoringForm)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('monitoring-form-form', $oMonitoringForm);
      
         if (isset($_POST['MonitoringForms'])) {
            $oMonitoringForm->attributes = $_POST['MonitoringForms'];
            $oMonitoringForm->id_zone_region = $_POST['MonitoringForms']['id_zone_region'];
              
            $oMonitoringForm->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewDetailForm', array('nIdForm'=>$oMonitoringForm->id)));
         }
         else $this->render('updateForm', array('oModelForm'=>$oMonitoringForm));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormQuestion($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringFormQuestion = MonitoringFormsQuestions::getMonitoringFormQuestion($nIdForm);
                                          
      if (!is_null($oMonitoringFormQuestion)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('monitoring-form-question-form', $oMonitoringFormQuestion);
                            
         if (isset($_POST['MonitoringFormsQuestions'])) {
            $bError = false;
            $oMonitoringFormQuestion->attributes = $_POST['MonitoringFormsQuestions'];
            $oMonitoringFormQuestion->field_type = $_POST['MonitoringFormsQuestions']['field_type']; 
            $oMonitoringFormQuestion->repeat = $_POST['MonitoringFormsQuestions']['repeat']; 
            $oMonitoringFormQuestion->start_hour = $_POST['MonitoringFormsQuestions']['start_hour']; 
            $oMonitoringFormQuestion->end_hour = $_POST['MonitoringFormsQuestions']['end_hour']; 
            
            $sFieldValueOptions = FString::STRING_EMPTY;
            if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_options)) {
               $nNumTokens = FString::getNumTokens($oMonitoringFormQuestion->field_value_options, ',');
               for($i = 1; $i <= $nNumTokens; $i++) {
                  $sToken = FString::getToken($oMonitoringFormQuestion->field_value_options, ',', $i);
                  $sToken = str_replace(FString::STRING_SPACE, '', $sToken);
                  
                  if (strlen($sToken) > 0) {
                     if (strlen($sToken) > 10) $sToken = substr($sToken, 0, 10);
                     
                     if (strlen($sFieldValueOptions) > 0) $sFieldValueOptions .= ',' . $sToken; 
                     else $sFieldValueOptions = $sToken;
                  } 
               }
               
               $oMonitoringFormQuestion->field_value_options = $sFieldValueOptions;
            } 
                  
            if ($oMonitoringFormQuestion->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_NUMERIC) {
               if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_default)) {
                  if (!is_numeric($oMonitoringFormQuestion->field_value_default)) {
                     FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_SUBMIT_ERROR_VALUE_DEFAULT_IS_NOT_NUMERIC'));
                     $bError = true;
                  }
               }
               
               if (!$bError) {
                  if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_options)) {
                     $nNumTokens = FString::getNumTokens($oMonitoringFormQuestion->field_value_options, ',');
                     for($i = 1; (($i <= $nNumTokens) && (!$bError)); $i++) {
                        $sToken = FString::getToken($oMonitoringFormQuestion->field_value_options, ',', $i);
                        if (!is_numeric($sToken)) { 
                           FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_SUBMIT_ERROR_VALUE_OPTION_IS_NOT_NUMERIC'));
                           $bError = true; 
                        }  
                     } 
                  }      
               }  
            }
            else if ($oMonitoringFormQuestion->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT) {
               $oMonitoringFormQuestion->field_required = true;
               
               if (!FString::isNullOrEmpty($oMonitoringFormQuestion->field_value_default)) {
                  if (($oMonitoringFormQuestion->field_value_default != '0') && ($oMonitoringFormQuestion->field_value_default != '1')) { 
                     FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_SUBMIT_ERROR_VALUE_DEFAULT_IS_NOT_BIT'));
                     $bError = true;
                  }
               }   
            }
            
            if (!$bError) {
               if ((!(FString::isNullOrEmpty($oMonitoringFormQuestion->start_hour))) || (!(FString::isNullOrEmpty($oMonitoringFormQuestion->end_hour)))) { 
                     if ((FString::isNullOrEmpty($oMonitoringFormQuestion->start_hour)) || (FString::isNullOrEmpty($oMonitoringFormQuestion->end_hour))) {
                        FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_UPDATEFORMQUESTION_FORM_SUBMIT_ERROR_HOUR_RANGE_IS_INVALID'));
                        $bError = true;   
                     }  
               }
            }
         
            if (!$bError) {
               $oMonitoringFormQuestion->save();
              
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewDetailFormQuestion', array('nIdForm'=>$oMonitoringFormQuestion->id)));
            }
            else $this->render('updateFormQuestion', array('oModelForm'=>$oMonitoringFormQuestion));
         }
         else $this->render('updateFormQuestion', array('oModelForm'=>$oMonitoringFormQuestion));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionDeleteGroupForm($nIdForm) {
      $oMonitoringGroupForm = MonitoringGroupForms::getMonitoringGroupForm($nIdForm);
      if (!is_null($oMonitoringGroupForm)) $oMonitoringGroupForm->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewForms'));
   }
   public function actionDeleteForm($nIdForm) {
      $oMonitoringForm = MonitoringForms::getMonitoringForm($nIdForm);
      if (!is_null($oMonitoringForm)) $oMonitoringForm->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewForms'));
   }
   public function actionDeleteFormQuestion($nIdForm) {
      $oMonitoringFormQuestion = MonitoringFormsQuestions::getMonitoringFormQuestion($nIdForm);
      if (!is_null($oMonitoringFormQuestion)) $oMonitoringFormQuestion->delete();

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewFormsQuestions'));
   }
}