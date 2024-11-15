<?php

class MaintenanceController extends FrontendController {
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('viewIncidences', 'viewDetailIncidence', 'updateIncidence', 'deleteIncidence', 'viewTimetables', 'viewDetailTimetable', 'updateTimetable', 'deleteTimetable', 'viewCheckins', 'viewDetailCheckin', 'updateCheckin', 'deleteCheckin', 'viewBusinesses', 'updateBusiness', 'viewDetailBusiness', 'deleteBusiness', 'viewEmployees', 'updateEmployee', 'updateEmployeeBiometric', 'viewDetailEmployee', 'deleteEmployee', 'viewEmployeesPendingSynchronization', 'updateEmployeesPendingSynchronization'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewIncidences() {
       $oAccessControlIncidence = new AccessControlIncidences();
       $oAccessControlIncidenceFilters = new AccessControlIncidences();
       $oAccessControlIncidenceFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-incidence-form', $oAccessControlIncidence);
       
       if (isset($_POST['AccessControlIncidences'])) {
          $oAccessControlIncidence->attributes = $_POST['AccessControlIncidences'];
            
          $oAccessControlIncidence->save();
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlIncidences'])) $oAccessControlIncidenceFilters->attributes = $_GET['AccessControlIncidences'];
       }
       
       $oAccessControlIncidence->unsetAttributes(); 
       $this->render('viewIncidences', array('oModelForm'=>$oAccessControlIncidence, 'oModelFormFilters'=>$oAccessControlIncidenceFilters));     
    }
    public function actionViewTimetables() {
       $oAccessControlTimetable = new AccessControlTimetables();
       $oAccessControlTimetableFilters = new AccessControlTimetables();
       $oAccessControlTimetableFilters->unsetAttributes();
       $bError = false;

       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-timetable-form', $oAccessControlTimetable);
       
       if (isset($_POST['AccessControlTimetables'])) {
          if ($_POST['AccessControlTimetables']['type'] == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
             if (FDate::isDateMajor($_POST['AccessControlTimetables']['hour1_t1'], $_POST['AccessControlTimetables']['hour2_t1'])) {
                $nMinutes = (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) + 24) * 60;
                $nMinutes += ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                
                $nMinutes -= ((((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + (((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']))));
             }  
             else {
                $nMinutes = ((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) * 60;
                $nMinutes += ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                
                $nMinutes -= ((((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + (((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']))));  
             }
             
             if ($nMinutes > (60 * 12)) {
                Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_MAX_HOURS'));
                $bError = true;
             } 
          }
          else {
             if ((FDate::isDateMajor($_POST['AccessControlTimetables']['hour2_t1'], $_POST['AccessControlTimetables']['hour1_t1'])) && (FDate::isDateMajor($_POST['AccessControlTimetables']['hour2_t2'], $_POST['AccessControlTimetables']['hour1_t2']))) {
                if (FDate::isDateMajor($_POST['AccessControlTimetables']['hour1_t2'], $_POST['AccessControlTimetables']['hour2_t1'])) {
                   $nMinutes = (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                   $nMinutes -= (((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']));     
                
                   $nMinutes += (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t2'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t2']));
                   $nMinutes -= (((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t2'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t2']));
                   
                   if ($nMinutes > (60 * 12)) {
                      Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_MAX_HOURS'));
                      $bError = true;
                   }
                }
                else {
                   Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_INCORRECT_INTERVALS'));
                   $bError = true;   
                }   
             }
             else {
                if ((!FString::isNullOrEmpty($_POST['AccessControlTimetables']['hour1_t2'])) && (!FString::isNullOrEmpty($_POST['AccessControlTimetables']['hour2_t2']))) { 
                   Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_NOT_NIGHT_TURN'));
                }
                else Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_EMPTY_TURN'));
                
                $bError = true;   
             }
          }
          
          if (!$bError) {
             $oAccessControlTimetable->attributes = $_POST['AccessControlTimetables'];
               
             $oAccessControlTimetable->save();
          }
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlTimetables'])) $oAccessControlTimetableFilters->attributes = $_GET['AccessControlTimetables'];
       }

       $oAccessControlTimetable->unsetAttributes();
       $this->render('viewTimetables', array('oModelForm'=>$oAccessControlTimetable, 'oModelFormFilters'=>$oAccessControlTimetableFilters));     
    }
    public function actionViewCheckins() {
       $oCheckin = new AccessControlCheckInMachine();
       $oCheckinCodeFilters = new AccessControlCheckInMachine();
       $oCheckinCodeFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-checkin-form', $oCheckin);
       
       if (isset($_POST['AccessControlCheckInMachine'])) {
          $oCheckin->attributes = $_POST['AccessControlCheckInMachine'];
          $oCheckin->date = FDate::getEnglishDate($_POST['AccessControlCheckInMachine']['date']);
          
          $oCheckin->type = $_POST['AccessControlCheckInMachine']['type'];  
          
          if ($oCheckin->type == FModuleAccessControlManagement::TYPE_INPUT_OUTPUT) {
             $oCheckin->type = null;   
          }
          
          $oCheckin->save();
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlCheckInMachine'])) { $oCheckinCodeFilters->attributes = $_GET['AccessControlCheckInMachine']; $oCheckinCodeFilters->start_date = $_GET['AccessControlCheckInMachine']['start_date']; $oCheckinCodeFilters->end_date = $_GET['AccessControlCheckInMachine']['end_date']; }
       }
       
       $oCheckin->unsetAttributes();
       $this->render('viewCheckins', array('oModelForm'=>$oCheckin, 'oModelFormFilters'=>$oCheckinCodeFilters));     
    }
    public function actionViewBusinesses() {
       $oBusiness = new Businesses();
       $oBusinessFilters = new Businesses();
       $oBusinessFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('business-form', $oBusiness);
       
       if (isset($_POST['Businesses'])) { 
          $oBusiness->attributes = $_POST['Businesses'];

          $oBusiness->save();
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['Businesses'])) {
             $oBusinessFilters->attributes = $_GET['Businesses'];
          }
       }
       
       $oBusiness->unsetAttributes();    
       
       $this->render('viewBusinesses', array('oModelForm'=>$oBusiness, 'oModelFormFilters'=>$oBusinessFilters));     
    }
    public function actionViewEmployees() {
       $oAccessControlEmployee = new AccessControlEmployees();
       $oAccessControlEmployeeFilters = new AccessControlEmployees();
       $oAccessControlEmployeeFilters->unsetAttributes();
       $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-employee-form', $oAccessControlEmployee);
       
       if (isset($_POST['AccessControlEmployees'])) { 
          try {
             $bErrorTransaction = false;
             $oTransaction = Yii::app()->db->beginTransaction();
                          
             $oAccessControlEmployee->attributes = $_POST['AccessControlEmployees'];
             $oAccessControlEmployee->strcpy_fullname();
             
             $oAccessControlEmployee->id_biostar = FModuleAccessControlManagement::getIdBiostarEmployee();
             
             if (!is_null($oAccessControlEmployee->id_biostar)) {
                $oAccessControlEmployee->type = FApplication::EMPLOYEE_BUSINESS;
                $oAccessControlEmployee->start_date = FDate::getEnglishDate($_POST['AccessControlEmployees']['start_date']);
                
                if ($oAccessControlEmployee->access_process_delay) $oAccessControlEmployee->access_tolerance = $_POST['AccessControlEmployees']['access_tolerance'];  
                else $oAccessControlEmployee->access_tolerance = 0;
                   
                $oFile = CUploadedFile::getInstanceByName('AccessControlEmployees[image]');
                if ($oFile) {
                   $sOriginalFilename = sha1_file($oFile->tempName);
                   $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                   $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                     
                   if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                      $sPath = FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES;
                      $sOriginalFileUrl = $sPath . $sOriginalFile;
                              
                      if ($oFile->saveAs($sOriginalFileUrl)) {
                        $oAccessControlEmployee->image = $sOriginalFile;
                      }
                      else $oAccessControlEmployee->image = null;  
                   }
                   else $oAccessControlEmployee->image = null;
                }
                else $oAccessControlEmployee->image = null;
              
                if ($oAccessControlEmployee->validate()) {
                   if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization)) {
                      $oAccessControlEmployee->pending_synchronize = true;
                      $oAccessControlEmployee->pending_synchronize_action = FModuleAccessControlManagement::TYPE_SYNCHRONIZE_ENROLL;
                      $oAccessControlEmployee->pending_synchronize_id_group_device = null;
                      
                      if (!$oAccessControlEmployee->save(false)) {
                         $bErrorTransaction = true;
                         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors()))));
                      } 
                   }
                   else {
                      if ($oAccessControlEmployee->save()) {
                         $bErrorTransaction = !FModuleAccessControlManagement::enrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->id_group_device, $oAccessControlEmployee->id);   
                      }
                      else {
                         $bErrorTransaction = true;
                         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors())))); 
                      }
                   }
                }
                else {
                   $bErrorTransaction = true;
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_SUBMIT_ERROR_ACCESS_CODES'));   
                }
                
                if (!$bErrorTransaction) { 
                   $oTransaction->commit();  
                }
                else $oTransaction->rollback();
             }
             else {
                $oTransaction->rollback();
                
                FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_SUBMIT_ERROR_MAX_IDBIOSTAR', array('{1}'=>FModuleAccessControlManagement::BIOSTAR_END_ID_EMPLOYEE)));
             }
          } catch (Exception $e) { 
             if (!is_null($oTransaction)) $oTransaction->rollback(); 
             
             FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEES_FORM_SUBMIT_ERROR', array('{1}'=>$e)));
          }   
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlEmployees'])) {
             $oAccessControlEmployeeFilters->attributes = $_GET['AccessControlEmployees'];
          }
       }
       
       if ((!isset($_POST['AccessControlEmployees'])) || ((isset($_POST['AccessControlEmployees'])) && (count($oAccessControlEmployee->getErrors()) == 0))) {
          $oAccessControlEmployee->unsetAttributes();    
       } 
       
       $this->render('viewEmployees', array('oModelForm'=>$oAccessControlEmployee, 'oModelFormFilters'=>$oAccessControlEmployeeFilters));     
    }
    public function actionViewEmployeesPendingSynchronization() {
       $oAccessControlEmployee = new AccessControlEmployees();
       $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    

       if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization)) {
          $this->render('viewEmployeesPendingSynchronization', array('oModelForm'=>$oAccessControlEmployee));        
       }
       else $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewEmployees'));
    }
    
    
    public function actionViewDetailIncidence($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlIncidence = AccessControlIncidences::getAccessControlIncidence($nIdForm);
                                          
       if (!is_null($oAccessControlIncidence)) $this->render('viewDetailIncidence', array('oModelForm'=>$oAccessControlIncidence));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailTimetable($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlTimetable = AccessControlTimetables::getAccessControlTimetable($nIdForm);
        
       if (!is_null($oAccessControlTimetable)) $this->render('viewDetailTimetable', array('oModelForm'=>$oAccessControlTimetable));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailCheckin($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oCheckin = AccessControlCheckInMachine::getAccessControlCheckin($nIdForm);
        
       if (!is_null($oCheckin)) $this->render('viewDetailCheckin', array('oModelForm'=>$oCheckin));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailBusiness($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oBusiness = Businesses::getBusiness($nIdForm);
        
       if (!is_null($oBusiness)) $this->render('viewDetailBusiness', array('oModelForm'=>$oBusiness));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailEmployee($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlEmployee = AccessControlEmployees::getAccessControlEmployee($nIdForm);
        
       if (!is_null($oAccessControlEmployee)) $this->render('viewDetailEmployee', array('oModelForm'=>$oAccessControlEmployee));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
       
    
    public function actionUpdateIncidence($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlIncidence = AccessControlIncidences::getAccessControlIncidence($nIdForm);
                                
       if (!is_null($oAccessControlIncidence)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-incidence-form', $oAccessControlIncidence);
       
          if (isset($_POST['AccessControlIncidences'])) {
             $oAccessControlIncidence->attributes = $_POST['AccessControlIncidences'];
               
             $oAccessControlIncidence->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailIncidence', array('nIdForm'=>$oAccessControlIncidence->id)));
          }
          else $this->render('updateIncidence', array('oModelForm'=>$oAccessControlIncidence));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateTimetable($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlTimetable = AccessControlTimetables::getAccessControlTimetable($nIdForm);
       $bError = false;
                                
       if (!is_null($oAccessControlTimetable)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-timetable-form', $oAccessControlTimetable);
       
          if (isset($_POST['AccessControlTimetables'])) {
             if ($_POST['AccessControlTimetables']['type'] == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                if (FDate::isDateMajor($_POST['AccessControlTimetables']['hour1_t1'], $_POST['AccessControlTimetables']['hour2_t1'])) {
                   $nMinutes = (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) + 24) * 60;
                   $nMinutes += ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                   
                   $nMinutes -= ((((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + (((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']))));
                }  
                else {
                   $nMinutes = ((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) * 60;
                   $nMinutes += ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                   
                   $nMinutes -= ((((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + (((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']))));  
                }
                
                if ($nMinutes > (60 * 12)) {
                   Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_MAX_HOURS'));
                   $bError = true;
                } 
             }
             else {
                if ((FDate::isDateMajor($_POST['AccessControlTimetables']['hour2_t1'], $_POST['AccessControlTimetables']['hour1_t1'])) && (FDate::isDateMajor($_POST['AccessControlTimetables']['hour2_t2'], $_POST['AccessControlTimetables']['hour1_t2']))) {
                   if (FDate::isDateMajor($_POST['AccessControlTimetables']['hour1_t2'], $_POST['AccessControlTimetables']['hour2_t1'])) {
                      $nMinutes = (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t1'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t1']));
                      $nMinutes -= (((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t1'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t1']));     
                   
                      $nMinutes += (((int) FDate::getHour($_POST['AccessControlTimetables']['hour2_t2'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour2_t2']));
                      $nMinutes -= (((int) FDate::getHour($_POST['AccessControlTimetables']['hour1_t2'])) * 60) + ((int) FDate::getMinutes($_POST['AccessControlTimetables']['hour1_t2']));
                      
                      if ($nMinutes > (60 * 12)) {
                         Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_MAX_HOURS'));
                         $bError = true;
                      }
                   }
                   else {
                      Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_INCORRECT_INTERVALS'));
                      $bError = true;   
                   }   
                }
                else {
                   if ((!FString::isNullOrEmpty($_POST['AccessControlTimetables']['hour1_t2'])) && (!FString::isNullOrEmpty($_POST['AccessControlTimetables']['hour2_t2']))) { 
                      Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_NOT_NIGHT_TURN'));
                   }
                   else Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWUPDATETIMETABLES_FORM_SUBMIT_ERROR_SHIFT_EMPTY_TURN'));
                   
                   $bError = true;   
                }
             }
             
             if (!$bError) {
                $oAccessControlTimetable->attributes = $_POST['AccessControlTimetables'];
                
                if ($_POST['AccessControlTimetables']['type'] == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                   $oAccessControlTimetable->hour1_t2 = null;
                   $oAccessControlTimetable->hour2_t2 = null;  
                }
                  
                $oAccessControlTimetable->save();
                  
                $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailTimetable', array('nIdForm'=>$oAccessControlTimetable->id)));
             }
             else $this->render('updateTimetable', array('oModelForm'=>$oAccessControlTimetable)); 
          }
          else $this->render('updateTimetable', array('oModelForm'=>$oAccessControlTimetable));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateCheckin($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oCheckin = AccessControlCheckInMachine::getAccessControlCheckin($nIdForm);
                   
       if (!is_null($oCheckin)) {
          if (is_null($oCheckin->type)) $oCheckin->type = FModuleAccessControlManagement::TYPE_INPUT_OUTPUT;
          
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-checkin-form', $oCheckin);
       
          if (isset($_POST['AccessControlCheckInMachine'])) {
             $oCheckin->attributes = $_POST['AccessControlCheckInMachine'];
             $oCheckin->date = FDate::getEnglishDate($_POST['AccessControlCheckInMachine']['date']);
             
             $oCheckin->type = $_POST['AccessControlCheckInMachine']['type'];  
          
             if ($oCheckin->type == FModuleAccessControlManagement::TYPE_INPUT_OUTPUT) {
                $oCheckin->type = null;   
             }
             
             $oCheckin->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailCheckin', array('nIdForm'=>$oCheckin->id)));
          }
          else $this->render('updateCheckin', array('oModelForm'=>$oCheckin));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateBusiness($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oBusiness = Businesses::getBusiness($nIdForm);

       if (!is_null($oBusiness)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('business-form', $oBusiness);
          
          if (isset($_POST['Businesses'])) {
             $oBusiness->attributes = $_POST['Businesses'];

             $oBusiness->save();  

             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailBusiness', array('nIdForm'=>$oBusiness->id)));
          }
          else $this->render('updateBusiness', array('oModelForm'=>$oBusiness)); 
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    } 
    public function actionUpdateEmployee($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       
       $oAccessControlEmployee = AccessControlEmployees::getAccessControlEmployee($nIdForm);
                                
       if (!is_null($oAccessControlEmployee)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-employee-form', $oAccessControlEmployee);
       
          if (isset($_POST['AccessControlEmployees'])) {
             $oAccessControlEmployee->attributes = $_POST['AccessControlEmployees'];
             $oAccessControlEmployee->strcpy_fullname();

             $oAccessControlEmployee->start_date = FDate::getEnglishDate($_POST['AccessControlEmployees']['start_date']);
             
             if ($oAccessControlEmployee->access_process_delay) $oAccessControlEmployee->access_tolerance = $_POST['AccessControlEmployees']['access_tolerance'];  
             else $oAccessControlEmployee->access_tolerance = 0;
             
             $oFile = CUploadedFile::getInstanceByName('AccessControlEmployees[image]');
             if ($oFile) {
                $sOriginalFilename = sha1_file($oFile->tempName);
                $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
              
                if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                   $sPath = FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES;
                   $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                   if ($oFile->saveAs($sOriginalFileUrl)) {
                      $oAccessControlEmployee->image = $sOriginalFile;
                   } 
                }
             }
             
             if ($oAccessControlEmployee->validate()) {  
                if ($oAccessControlEmployee->save(false)) {
                   $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailEmployee', array('nIdForm'=>$oAccessControlEmployee->id))); 
                }
                else {
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEE_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors()))));    
                }
             }
             else {
                if ((FString::isNullOrEmpty($oAccessControlEmployee->access_code)) && ((FString::isNullOrEmpty($oAccessControlEmployee->access_code_FIR)))) {
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEE_FORM_SUBMIT_ERROR_ACCESS_CODES'));   
                }
                else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEE_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors())))); 
             }
          }
          $this->render('updateEmployee', array('oModelForm'=>$oAccessControlEmployee));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateEmployeeBiometric($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       
       $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    
       $oAccessControlEmployee = AccessControlEmployees::getAccessControlEmployee($nIdForm);
          
       if (!is_null($oAccessControlEmployee)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-employee-biometric-form', $oAccessControlEmployee);
       
          if (isset($_POST['AccessControlEmployees'])) {
             try {
                $bErrorTransaction = false;
                $oTransaction = Yii::app()->db->beginTransaction();
                
                $nOldIdGroupDevice = $oAccessControlEmployee->id_group_device;
                $oAccessControlEmployee->attributes = $_POST['AccessControlEmployees'];  

                if (is_null($oAccessControlEmployee->id_biostar)) $oAccessControlEmployee->id_biostar = FModuleAccessControlManagement::getIdBiostarEmployee();
                
                if (!is_null($oAccessControlEmployee->id_biostar)) {
                   if ($oAccessControlEmployee->validate()) {
                      if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization)) {
                         $oAccessControlEmployee->pending_synchronize = true;
                         $oAccessControlEmployee->pending_synchronize_action = FModuleAccessControlManagement::TYPE_SYNCHRONIZE_ENROLL;
                         if ((!is_null($nOldIdGroupDevice)) && ($nOldIdGroupDevice != $oAccessControlEmployee->id_group_device)) $oAccessControlEmployee->pending_synchronize_id_group_device = $nOldIdGroupDevice; 
                         else $oAccessControlEmployee->pending_synchronize_id_group_device = null;
                         
                         if (!$oAccessControlEmployee->save(false)) {
                            $bErrorTransaction = true;
                            FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors()))));
                         }      
                      } else {
                         $oAccessControlEmployee->pending_synchronize = false;
                         $oAccessControlEmployee->pending_synchronize_action = null;
                         $oAccessControlEmployee->pending_synchronize_id_group_device = null; 
                         $oAccessControlEmployee->active = true;
                         
                         if ($oAccessControlEmployee->save(false)) {
                            if ((!is_null($nOldIdGroupDevice)) && ($nOldIdGroupDevice != $oAccessControlEmployee->id_group_device)) $bErrorTransaction = !FModuleAccessControlManagement::disenrollEmployeeByIdGroupDeviceAndIdEmployee($nOldIdGroupDevice, $oAccessControlEmployee->id);
                            
                            if (!$bErrorTransaction) {
                               $bErrorTransaction = !FModuleAccessControlManagement::enrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->id_group_device, $oAccessControlEmployee->id);   
                            }
                         }
                         else {
                            $bErrorTransaction = true;
                            FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oAccessControlEmployee->getErrors())))); 
                         }
                      }
                   }
                   else {
                      $bErrorTransaction = true;
                      FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_SUBMIT_ERROR_ACCESS_CODES'));   
                   }
                   
                   if (!$bErrorTransaction) { 
                      $oTransaction->commit();
                      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewDetailEmployee', array('nIdForm'=>$oAccessControlEmployee->id)));  
                   }
                   else $oTransaction->rollback();
                }
                else {
                   $oTransaction->rollback();
                   
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_SUBMIT_ERROR_MAX_IDBIOSTAR', array('{1}'=>FModuleAccessControlManagement::BIOSTAR_END_ID_EMPLOYEE)));
                }
             } catch (Exception $e) { 
                if (!is_null($oTransaction)) $oTransaction->rollback(); 
                
                FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_SUBMIT_ERROR', array('{1}'=>$e)));
             } 
          }
          
          $this->render('updateEmployeeBiometric', array('oModelForm'=>$oAccessControlEmployee));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateEmployeesPendingSynchronization() {
       $oAccessControlEmployee = new AccessControlEmployees();
       $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    

       if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization) && (count(AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true)) > 0)) {
          $oAccessControlEmployees = AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true);
          foreach($oAccessControlEmployees as $oAccessControlEmployee) {
             try {
                $bErrorTransaction = false;
                $oTransaction = Yii::app()->db->beginTransaction();
             
                if ((!FString::isNullOrEmpty($oAccessControlEmployee->pending_synchronize_action)) && (($oAccessControlEmployee->pending_synchronize_action == FModuleAccessControlManagement::TYPE_SYNCHRONIZE_ENROLL) || ($oAccessControlEmployee->pending_synchronize_action == FModuleAccessControlManagement::TYPE_SYNCHRONIZE_DISENROLL))) {
                   if ($oAccessControlEmployee->pending_synchronize_action == FModuleAccessControlManagement::TYPE_SYNCHRONIZE_ENROLL) {
                      $oAccessControlEmployee->active = true;
                      
                      if ((!is_null($oAccessControlEmployee->pending_synchronize_id_group_device)) && ($oAccessControlEmployee->pending_synchronize_id_group_device != $oAccessControlEmployee->id_group_device)) $bErrorTransaction = !FModuleAccessControlManagement::disenrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->pending_synchronize_id_group_device, $oAccessControlEmployee->id, false);
                            
                      if (!$bErrorTransaction) {
                         $bErrorTransaction = !FModuleAccessControlManagement::enrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->id_group_device, $oAccessControlEmployee->id, false);   
                      } 
                   }  
                   else {
                      if (!is_null($oAccessControlEmployee->id_group_device)) $bErrorTransaction = !FModuleAccessControlManagement::disenrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->id_group_device, $oAccessControlEmployee->id, false);
                                          
                      if (!$bErrorTransaction) {
                         $oAccessControlEmployee->isNewRecord = false;
                         
                         $oAccessControlEmployee->access_code = null;
                         $oAccessControlEmployee->access_code_FIR = null;
                         $oAccessControlEmployee->access_code_FIR_2 = null;
                         $oAccessControlEmployee->access_information = null;
                         $oAccessControlEmployee->show_visual_presence = false;
                         $oAccessControlEmployee->id_user = null;
                         $oAccessControlEmployee->id_group_device = null;
                         $oAccessControlEmployee->id_biostar = null;
                         $oAccessControlEmployee->end_date = date('Y-m-d');
                         $oAccessControlEmployee->active = false;
                      } 
                   } 
                }
                else {
                   $bErrorTransaction = true;
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_FORM_SUBMIT_ERROR_EMPLOYEE_NOT_VALID_ACTION', array('{1}'=>$oAccessControlEmployee->full_name)));   
                }
                
                if (!$bErrorTransaction) {
                   $oAccessControlEmployee->pending_synchronize = false;
                   $oAccessControlEmployee->pending_synchronize_action = null;
                   $oAccessControlEmployee->pending_synchronize_id_group_device = null;
                   
                   if (!$oAccessControlEmployee->save(false)) {
                      $bErrorTransaction = true;
                      FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_FORM_SUBMIT_ERROR_EMPLOYEE', array('{1}'=>$oAccessControlEmployee->full_name, '{2}'=>json_encode($oAccessControlEmployee->getErrors()))));
                   } 
                }
                         
                if (!$bErrorTransaction) { 
                   $oTransaction->commit();
                   FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_FORM_SUBMIT_SUCCESS_EMPLOYEE', array('{1}'=>$oAccessControlEmployee->full_name)));
                }
                else $oTransaction->rollback();
             } catch (Exception $e) { 
                if (!is_null($oTransaction)) $oTransaction->rollback(); 
                
                 FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_FORM_SUBMIT_ERROR_EMPLOYEE', array('{1}'=>$oAccessControlEmployee->full_name, '{2}'=>$e)));
             }                                                                                                           
          }
       }
       else $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewEmployees'));
       
       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewEmployeesPendingSynchronization'));
    }
    

    public function actionDeleteIncidence($nIdForm) {
       $oAccessControlIncidence = AccessControlIncidences::getAccessControlIncidence($nIdForm);
       if (!is_null($oAccessControlIncidence)) $oAccessControlIncidence->delete();

       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewIncidences'));
    }
    public function actionDeleteTimetable($nIdForm) {
       $oAccessControlTimetable = AccessControlTimetables::getAccessControlTimetable($nIdForm);
       if (!is_null($oAccessControlTimetable)) $oAccessControlTimetable->delete();

       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewTimetables'));
    }
    public function actionDeleteCheckin($nIdForm) {
       $oCheckin = AccessControlCheckInMachine::getAccessControlCheckin($nIdForm);
       if (!is_null($oCheckin)) $oCheckin->delete();

       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewCheckins'));
    }
    public function actionDeleteBusiness($nIdForm) {
       $oBusiness = Businesses::getBusiness($nIdForm);
       if (!is_null($oBusiness)) $oBusiness->delete();

       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewBusinesses'));
    }
    public function actionDeleteEmployee($nIdForm) {
       $oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();  
       
       try {
          $bErrorTransaction = false;
          $oTransaction = Yii::app()->db->beginTransaction();
         
          $oAccessControlEmployee = AccessControlEmployees::getAccessControlEmployee($nIdForm);
          if (!is_null($oAccessControlEmployee)) {
             if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization)) {
                $oAccessControlEmployee->pending_synchronize = true;
                $oAccessControlEmployee->pending_synchronize_action = FModuleAccessControlManagement::TYPE_SYNCHRONIZE_DISENROLL;
                $oAccessControlEmployee->pending_synchronize_id_group_device = null;
                   
                $bErrorTransaction = !$oAccessControlEmployee->save(false);    
             }
             else {
                $bErrorTransaction = !FModuleAccessControlManagement::disenrollEmployeeByIdGroupDeviceAndIdEmployee($oAccessControlEmployee->id_group_device, $oAccessControlEmployee->id);

                if (!$bErrorTransaction) {
                   $oAccessControlEmployee->isNewRecord = false;
                   
                   $oAccessControlEmployee->access_code = null;
                   $oAccessControlEmployee->access_code_FIR = null;
                   $oAccessControlEmployee->access_code_FIR_2 = null;
                   $oAccessControlEmployee->access_information = null;
                   $oAccessControlEmployee->show_visual_presence = false;
                   $oAccessControlEmployee->id_user = null;
                   $oAccessControlEmployee->id_group_device = null;
                   $oAccessControlEmployee->id_biostar = null;
                   $oAccessControlEmployee->end_date = date('Y-m-d');
                   $oAccessControlEmployee->pending_synchronize = false;
                   $oAccessControlEmployee->pending_synchronize_action = null;
                   $oAccessControlEmployee->pending_synchronize_id_group_device = null;
                   $oAccessControlEmployee->active = false;

                   $bErrorTransaction = !$oAccessControlEmployee->save(false);
                }
             }
          }
         
          if (!$bErrorTransaction) { 
             $oTransaction->commit();  
          }
          else $oTransaction->rollback();
       } catch (Exception $e) { if (!is_null($oTransaction)) $oTransaction->rollback(); }  
       
       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewEmployees'));
    }
}