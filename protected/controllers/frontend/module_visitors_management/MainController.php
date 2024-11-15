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
                'actions'=>array('viewVisits', 'viewDetailVisit', 'viewVisualPresence', 'refreshVisualPresence', 'updateVisualPresence'),
                'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)',
            ),
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('updateVisit', 'updateVisitStatus'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)))',
            ),	
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('deleteVisit', 'viewHistoricalVisits'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionViewVisits() {
       $oVisitorsVisit = new VisitorsVisits();
       $oVisitorsVisit->scenario = 'add';
       $oVisitorsVisitFilters = new VisitorsVisits();
       $oVisitorsVisitFilters->unsetAttributes();
       $bNewVisit = false;
	   
       // Ajax validation request=>Conditional validator
       FForm::validateAjaxForm('visitors-visit-form', $oVisitorsVisit);
       
       if ((isset($_POST['VisitorsVisits'])) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT))) {  
          $oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
          if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management)) {
             $oEmployee = Employees::getEmployeeByIdentification($_POST['VisitorsVisits']['employee_identification']);
             if (!is_null($oEmployee)) {
                try {
                   $bErrorTransaction = false;
                   $oTransaction = Yii::app()->db_rainbow_visitorsmanagement->beginTransaction();
                   
                   $oVisitorsVisit->attributes = $_POST['VisitorsVisits'];
                   
                   $oVisitorsVisit->id_biostar = FModuleVisitorsManagement::getIdBiostarVisit();
                   
                   if (!is_null($oVisitorsVisit->id_biostar)) {  
                      $oVisitorsVisit->card_id = 0;
                      $oVisitorsVisit->employee = $oEmployee->full_name;
                      $oVisitorsVisit->status = true;
                      $oVisitorsVisit->start_date = date("YmdHis");
                      
                      if ($_POST['VisitorsVisits']['visitor_vehicle'] == false) $oVisitorsVisit->visitor_destiny_vehicle = FString::STRING_EMPTY;  

                      if ($oVisitorsVisit->save(false)) {
                         $bErrorTransaction = !FModuleVisitorsManagement::enrollVisitByIdGroupDeviceAndIdVisit($oVisitorsVisit->id_group_device, $oVisitorsVisit->id);   
                      }
                      else {
                         $bErrorTransaction = true;
                         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR', array('{1}'=>json_encode($oVisitorsVisit->getErrors())))); 
                      }
                      
                      if (!$bErrorTransaction) {
						       $bNewVisit = true;
                         $oTransaction->commit();
                         
                         Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_SUCCESS', array('{1}'=>$oVisitorsVisit->card_code)));  
                      }
                      else $oTransaction->rollback();
                   }
                   else {
                      $oTransaction->rollback();
                      
                      FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR_MAX_IDBIOSTAR', array('{1}'=>FModuleAccessControlManagement::BIOSTAR_END_ID_VISIT)));
                   }
                } catch (Exception $e) { 
                   if (!is_null($oTransaction)) $oTransaction->rollback(); 
                   
                   FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR', array('{1}'=>$e)));
                }
             }
             else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
          }
          else {
             $oCard = VisitorsCards::getVisitorCard($_POST['VisitorsVisits']['card_id']);
             $oEmployee = Employees::getEmployeeByIdentification($_POST['VisitorsVisits']['employee_identification']);
             
             if ((!is_null($oCard)) && (!$oCard->assigned) && (!is_null($oEmployee))) {
                $oVisitorsVisit->attributes = $_POST['VisitorsVisits'];
                
                $oVisitorsVisit->card_id = $oCard->id;
                $oVisitorsVisit->card_code = $oCard->code;
                $oVisitorsVisit->employee = $oEmployee->full_name;
                $oVisitorsVisit->status = true;
                $oVisitorsVisit->start_date = date("YmdHis");
                $oVisitorsVisit->id_group_device = 0;
                            
                if ($_POST['VisitorsVisits']['visitor_vehicle'] == false) $oVisitorsVisit->visitor_destiny_vehicle = FString::STRING_EMPTY;  
                
				if ($oVisitorsVisit->save()) {
				   $bNewVisit = true;
                
                   $oCard->assigned = true;
                   $oCard->save();
                
                   Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_SUCCESS', array('{1}'=>$oCard->code)));
                }
				else Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR', array('{1}'=>$oVisitorsVisit->getErrors())));
			 }
             else if ((!is_null($oCard)) && (!$oCard->assigned)) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
             else if (!is_null($oCard)) Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR_CARD_NOT_AVAILABLE', array('{1}'=>$oCard->code)));
             else Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_SUBMIT_ERROR_CARD_NOT_AVAILABLE_GENERIC'));
          }
		  
		  if ($bNewVisit) {
	         $oVisitor = Visitors::getVisitorByIdentification($oVisitorsVisit->visitor_identification); 
			 if (is_null($oVisitor)) {
			    $oVisitor = new Visitors();
				$oVisitor->first_name = $oVisitorsVisit->visitor_first_name;
				$oVisitor->middle_name = $oVisitorsVisit->visitor_middle_name;
				
				if (!FString::isNullOrEmpty($oVisitorsVisit->visitor_last_name)) {
				   $oVisitor->last_name = $oVisitorsVisit->visitor_last_name;
				}
				
				$oVisitor->full_name = $oVisitorsVisit->visitor_full_name;
				$oVisitor->identification = $oVisitorsVisit->visitor_identification;
				
				if (!FString::isNullOrEmpty($oVisitorsVisit->visitor_business)) {
				   $oVisitor->business = $oVisitorsVisit->visitor_business;
				}
				
				$oVisitor->save();
			 }
			 else {
				$oVisitor->first_name = $oVisitorsVisit->visitor_first_name;
				$oVisitor->middle_name = $oVisitorsVisit->visitor_middle_name;
				
				if (!FString::isNullOrEmpty($oVisitorsVisit->visitor_last_name)) {
				   $oVisitor->last_name = $oVisitorsVisit->visitor_last_name;
				}
				
				$oVisitor->full_name = $oVisitorsVisit->visitor_full_name;
				
				if (!FString::isNullOrEmpty($oVisitorsVisit->visitor_business)) {
				   $oVisitor->business = $oVisitorsVisit->visitor_business;
				}
				
			    $oVisitor->save();	 
			 }
		  }
       }
       else {
          if (isset($_POST['VisitorsVisits'])) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
          else { 
             // Filters Grid Get Parameters
             if (isset($_GET['VisitorsVisits'])) $oVisitorsVisitFilters->attributes = $_GET['VisitorsVisits'];
          }
       }
       
       $oVisitorsVisit->unsetAttributes();

       if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) {
          $oCard = VisitorsCards::getFirstFreeVisitorCard();
          if (!is_null($oCard)) {
             $oVisitorsVisit->card_id = $oCard->id;     
          } 
          
          $oVisitorsVisit->type = FModuleVisitorsManagement::TYPE_VISIT_VISIT; 
       }
	   
       $this->render('viewVisits', array('oModelForm'=>$oVisitorsVisit, 'oModelFormFilters'=>$oVisitorsVisitFilters));  
    }
    public function actionViewHistoricalVisits() {
       $oHistoricalVisitorsVisit = new VisitorsVisits();
       $oHistoricalVisitorsVisitFilters = new VisitorsVisits();
       $oHistoricalVisitorsVisitFilters->unsetAttributes();
       
       // Filters Grid Get Parameters
       if (isset($_GET['VisitorsVisits'])) $oHistoricalVisitorsVisitFilters->attributes = $_GET['VisitorsVisits'];

       $this->render('viewHistoricalVisits', array('oModelForm'=>$oHistoricalVisitorsVisit, 'oModelFormFilters'=>$oHistoricalVisitorsVisitFilters));  
    }
    public function actionViewVisualPresence() {
       $nIdModule = Modules::getIdModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT);
       if ((!is_null($nIdModule)) && (Modules::getIsValidSerialModule($nIdModule))) {                   
          $oEmployees = Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true, null, null, true, true);
           
          // Automatic update employees checkin
          $oAccessContolModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    
          if ((!is_null($oAccessContolModuleParameters)) && (!$oAccessContolModuleParameters->show_checkin_manual)) {
             foreach($oEmployees as $oEmployee) {
                $oLastAccessControlCheckInMachine = AccessControlCheckInMachine::getLastAccessControlCheckinByEmployee($oEmployee->identification);
                
                if (!is_null($oLastAccessControlCheckInMachine)) {
                   if ($oLastAccessControlCheckInMachine->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) $oEmployee->inside = true;
                   else $oEmployee->inside = false;
                   
                   $oEmployee->save(false);
                }
             }   
          }
       
          $this->render('viewVisualPresence', array('oModelForm'=>$oEmployees)); 
       } 
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
    }

    
    public function actionViewDetailVisit($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdForm);
        
       if (!is_null($oVisitorsVisit)) $this->render('viewDetailVisit', array('oModelForm'=>$oVisitorsVisit));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    
    
    public function actionRefreshVisualPresence() {
       $oEmployees = Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true, null, null, true, true);
  
       // Automatic update employees checkin
       $oAccessContolModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();    
       if ((!is_null($oAccessContolModuleParameters)) && (!$oAccessContolModuleParameters->show_checkin_manual)) {    
          FModuleAccessControlManagement::synchronizeCheckins();
          
          foreach($oEmployees as $oEmployee) {
             $oLastAccessControlCheckInMachine = AccessControlCheckInMachine::getLastAccessControlCheckinByEmployee($oEmployee->identification);
             
             if (!is_null($oLastAccessControlCheckInMachine)) {
                if ($oLastAccessControlCheckInMachine->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) $oEmployee->inside = true;
                else $oEmployee->inside = false;
                
                $oEmployee->save(false);
             }
          }   
       }
        
       $this->renderPartial('viewVisualPresenceEmployees', array('oModelForm'=>$oEmployees));  
    }
    
    
    public function actionUpdateVisit($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdForm);
       $bChangeCards = false;
	   
       if (!is_null($oVisitorsVisit)) {
          if ($oVisitorsVisit->status) {
             // Ajax validation request=>Conditional validator
             FForm::validateAjaxForm('visitors-visit-form', $oVisitorsVisit);
                
             if (isset($_POST['VisitorsVisits'])) {
				$oEmployee = Employees::getEmployeeByIdentification($_POST['VisitorsVisits']['employee_identification']);
                
                if (!is_null($oEmployee)) {
				   $nOldIdCard = $oVisitorsVisit->card_id;
                   $oVisitorsVisit->attributes = $_POST['VisitorsVisits'];
                   $nNewIdCard = $oVisitorsVisit->card_id;
				   
                   $oVisitorsVisit->employee = $oEmployee->full_name;
                   if ($_POST['VisitorsVisits']['visitor_vehicle'] == false) $oVisitorsVisit->visitor_destiny_vehicle = FString::STRING_EMPTY;  

                   $oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
                   if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && (!$oVisitorsModuleParameters->biostar_card_management)) {
                      if ($nOldIdCard != $nNewIdCard) {
                         $oOldCard = VisitorsCards::getVisitorCard($nOldIdCard);
                         $oNewCard = VisitorsCards::getVisitorCard($nNewIdCard);
                         
                         if ((!is_null($oOldCard)) && (!is_null($oNewCard)) && (!$oNewCard->assigned)) {
                            $oVisitorsVisit->card_id = $oNewCard->id;
                            $oVisitorsVisit->card_code = $oNewCard->code;
                            
                            $bChangeCards = true;
                         }
                      }   
                   }
				   
                   if ($oVisitorsVisit->save()) {
                      if ($bChangeCards) {
                         $oNewCard->assigned = true;
                         $oNewCard->save();
                         
                         $oOldCard->assigned = false;
                         $oOldCard->save(); 
                      }   
                   }
                     
                   $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewDetailVisit', array('nIdForm'=>$nIdForm)));
                }
                else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
             }
             else $this->render('updateVisit', array('oModelForm'=>$oVisitorsVisit));
          }
          else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateVisitStatus($nIdForm) {
        $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdForm);
 
        if (!is_null($oVisitorsVisit)) {
           if ($oVisitorsVisit->status) {
              $oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
              if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management)) {   
				 try {
                    $bErrorTransaction = false;
                    $oTransaction = Yii::app()->db_rainbow_visitorsmanagement->beginTransaction();
                  
                    $bErrorTransaction = !FModuleVisitorsManagement::disenrollVisitByIdGroupDeviceAndIdVisit($oVisitorsVisit->id_group_device, $oVisitorsVisit->id);

                    if (!$bErrorTransaction) {
                       $oVisitorsVisit->id_biostar = null;
                       $oVisitorsVisit->status = false;
                       $oVisitorsVisit->end_date = date("YmdHis");
                       
                       $oVisitorsVisit->save(false);
                    }

                    if (!$bErrorTransaction) { 
                       $oTransaction->commit(); 
                       
                       Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_BUTTON_EXIT_SUCCESS', array('{1}'=>$oVisitorsVisit->card_code))); 
                    } 
                    else $oTransaction->rollback();
                 } catch (Exception $e) { if (!is_null($oTransaction)) $oTransaction->rollback(); }
              }
              else {
                 $oCard = VisitorsCards::getVisitorCard($oVisitorsVisit->card_id);
                 
                 if (!is_null($oCard)) {
                    $oCard->assigned = false;
                    $oCard->save();
                 }
                 
                 $oVisitorsVisit->status = false;
                 $oVisitorsVisit->end_date = date("YmdHis");
                 
                 $oVisitorsVisit->save(false);

                 Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_BUTTON_EXIT_SUCCESS', array('{1}'=>$oCard->code)));
              }
           }
           else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
        
        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewVisits'));
    }
    public function actionUpdateVisualPresence($nIdForm) {
       $oEmployee = Employees::getEmployee($nIdForm);
       $nIdModule = Modules::getIdModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT);
   
       if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (!is_null($nIdModule)) && (Modules::getIsValidSerialModule($nIdModule))) {
          if (!is_null($oEmployee)) {
             $oEmployee->inside = !$oEmployee->inside;
             
             $oEmployee->save();
             
             // Check if Access Control module is available
             if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) {
                $oAccessControlCheckin = new AccessControlCheckInManual();
                $oAccessControlCheckin->employee_identification = $oEmployee->identification;
                $oAccessControlCheckin->date = date('Y-m-d H:i:s');
                
                if ($oEmployee->inside) $oAccessControlCheckin->type = FModuleAccessControlManagement::TYPE_MAIN_INPUT;
                else $oAccessControlCheckin->type = FModuleAccessControlManagement::TYPE_MAIN_OUTPUT;
                
                // Delete checkin if change the status very fast
                $bDeleteRecord = false;
                $bNotSave = false;
                $oAccessControlPreviousCheckin = AccessControlCheckInManual::getLastAccessControlCheckinByEmployee($oAccessControlCheckin->employee_identification);
                
                if ($oAccessControlCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_OUTPUT) {
                   if ((!is_null($oAccessControlPreviousCheckin)) && ($oAccessControlPreviousCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) && (FDate::getDiffSeconds($oAccessControlPreviousCheckin->date, $oAccessControlCheckin->date) <= FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DISCART_CHECKIN_MANUAL_SECONDS)) { $bDeleteRecord = true; $oAccessControlPreviousCheckin->delete(); }  
                   else if ((!is_null($oAccessControlPreviousCheckin)) && (!($oAccessControlPreviousCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT))) $bNotSave = true;
                }
                else {
                   if ((!is_null($oAccessControlPreviousCheckin)) && ($oAccessControlPreviousCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT)) $bNotSave = true;     
                }

                if ((!$bDeleteRecord) && (!$bNotSave)) $oAccessControlCheckin->save();
             }
          }
          $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewVisualPresence'));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));    
    }
    
    public function actionDeleteVisit($nIdForm) {
        $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdForm);
        
        if (!is_null($oVisitorsVisit)) {
           if ($oVisitorsVisit->status) {
              $oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
              if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management)) {   
                 try {
                    $bErrorTransaction = false;
                    $oTransaction = Yii::app()->db_rainbow_visitorsmanagement->beginTransaction();
                  
                    $bErrorTransaction = !FModuleVisitorsManagement::disenrollVisitByIdGroupDeviceAndIdVisit($oVisitorsVisit->id_group_device, $oVisitorsVisit->id);

                    if (!$bErrorTransaction) {
                       $oVisitorsVisit->delete();
                    }

                    if (!$bErrorTransaction) { 
                       $oTransaction->commit();  
                    } 
                    else $oTransaction->rollback();
                 } catch (Exception $e) { if (!is_null($oTransaction)) $oTransaction->rollback(); }
              }
              else {
                 $oCard = VisitorsCards::getVisitorCard($oVisitorsVisit->card_id);
                 
                 if (!is_null($oCard)) {
                    $oCard->assigned = false;
                    $oCard->save();
                 }
                 
                 $oVisitorsVisit->delete();
              }
           }
           else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
        }

        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewVisits'));
    }
}