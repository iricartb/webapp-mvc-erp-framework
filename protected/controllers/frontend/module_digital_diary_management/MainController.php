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
            'actions'=>array('viewFormsTurnEvents', 'viewDetailFormTurnEvent', 'viewDetailFormTurnEventLine'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('allow', // allow authenticated user and have valid module roles to perform actions                                                                                                                                          
            'actions'=>array('updateFormTurnEvent', 'updateFormTurnEventLine', 'notifyFormTurnEvent', 'notifyFormTurnEventLine', 'refreshFormTurnEventLinesRegions', 'refreshFormTurnEventLinesEquipments', 'deleteFormTurnEvent', 'deleteFormTurnEventLine', 'deleteFormTurnEventEmployee'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)))',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewFormsTurnEvents() {
      $oDigitalDiaryFormTurnEvent = new DigitalDiaryFormsTurnEvents('new');
      $oDigitalDiaryFormTurnEventFilters = new DigitalDiaryFormsTurnEvents();
      $oDigitalDiaryFormTurnEventFilters->unsetAttributes();
      $bError = false;
       
      // Ajax validation request=>Conditional validator
      FForm::validateAjaxForm('digitaldiary-form-turn-event-form', $oDigitalDiaryFormTurnEvent);
      
      if ((isset($_POST['DigitalDiaryFormsTurnEvents'])) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT))) {  
         $oDigitalDiaryFormTurnEvent->attributes = $_POST['DigitalDiaryFormsTurnEvents'];
         
         $oDigitalDiaryFormTurnEvent->date = FDate::getEnglishDate($_POST['DigitalDiaryFormsTurnEvents']['date']);
            
         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) $oDigitalDiaryFormTurnEvent->owner = $sCurrentUser;
         else $bError = true;
      
         if (!$bError) {
            $oDigitalDiaryFormTurnEventUnique = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEventByAttributes($oDigitalDiaryFormTurnEvent->date, $oDigitalDiaryFormTurnEvent->turn, $oDigitalDiaryFormTurnEvent->owner);
            
            if (is_null($oDigitalDiaryFormTurnEventUnique)) {
               $oDigitalDiaryFormTurnEvent->status = FModuleDigitalDiaryManagement::STATUS_CREATED; 
               $oDigitalDiaryFormTurnEvent->start_date = date('Y-m-d H:i:s');
               $oDigitalDiaryFormTurnEvent->read_last_turn = true;
               
               if ($oDigitalDiaryFormTurnEvent->save()) {
                  // Copy all sections and notifications
                  $oDigitalDiarySections = DigitalDiarySections::getDigitalDiarySections();
                  foreach ($oDigitalDiarySections as $oDigitalDiarySection) {
                     $oDigitalDiaryFormTurnEventSection = new DigitalDiaryFormTurnEventSections();
                     $oDigitalDiaryFormTurnEventSection->name = $oDigitalDiarySection->name;
                     $oDigitalDiaryFormTurnEventSection->description = $oDigitalDiarySection->description;
                     $oDigitalDiaryFormTurnEventSection->id_form_turn_event = $oDigitalDiaryFormTurnEvent->id;
                     
                     if ($oDigitalDiaryFormTurnEventSection->save()) {
                        $oDigitalDiarySectionsNotifications = DigitalDiarySectionsNotifications::getDigitalDiarySectionsNotificationsByIdSection($oDigitalDiarySection->id);
                        
                        foreach ($oDigitalDiarySectionsNotifications as $oDigitalDiarySectionNotification) {
                           $oDigitalDiaryFormTurnEventSectionNotification = new DigitalDiaryFormTurnEventSectionsNotifications();
                           $oDigitalDiaryFormTurnEventSectionNotification->mail = $oDigitalDiarySectionNotification->mail;
                           $oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events = $oDigitalDiarySectionNotification->only_recv_urgent_events;
                           $oDigitalDiaryFormTurnEventSectionNotification->id_form_turn_event_section = $oDigitalDiaryFormTurnEventSection->id;  
                           
                           $oDigitalDiaryFormTurnEventSectionNotification->save();  
                        }   
                     }
                  }
               }
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else {
         if (isset($_POST['DigitalDiaryFormsTurnEvents'])) $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
         else { 
            // Filters Grid Get Parameters
            if (isset($_GET['DigitalDiaryFormsTurnEvents'])) $oDigitalDiaryFormTurnEventFilters->attributes = $_GET['DigitalDiaryFormsTurnEvents'];
         }
      }
      
      $oDigitalDiaryFormTurnEvent->unsetAttributes(); 
      $this->render('viewFormsTurnEvents', array('oModelForm'=>$oDigitalDiaryFormTurnEvent, 'oModelFormFilters'=>$oDigitalDiaryFormTurnEventFilters)); 
   }
   
   
   public function actionViewDetailFormTurnEvent($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);

      if (!is_null($oDigitalDiaryFormTurnEvent)) $this->render('viewDetailFormTurnEvent', array('oModelForm'=>$oDigitalDiaryFormTurnEvent));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormTurnEventLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
       
      if (!is_null($oDigitalDiaryFormTurnEventLine)) $this->render('viewDetailFormTurnEventLine', array('oModelForm'=>$oDigitalDiaryFormTurnEventLine));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionUpdateFormTurnEvent($nIdForm) {
      $oDigitalDiaryFormTurnEventLine = new DigitalDiaryFormTurnEventLines();
      $oDigitalDiaryFormTurnEventEmployee = new DigitalDiaryFormTurnEventEmployees();
      $oMonitoringFormTurnRound = new MonitoringFormsTurnRounds();     
      
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      if (!is_null($oDigitalDiaryFormTurnEvent)) {    
         if ((isset($_POST['DigitalDiaryFormTurnEventLines'])) && (FModuleDigitalDiaryManagement::allowUpdateFormTurnEvent($oDigitalDiaryFormTurnEvent->id))) {  
            // Ajax validation request=>Conditional validator
            FForm::validateAjaxForm('digitaldiary-form-turn-event-line-form', $oDigitalDiaryFormTurnEventLine);
      
            $oDigitalDiaryFormTurnEventLine->attributes = $_POST['DigitalDiaryFormTurnEventLines'];
            $oDigitalDiaryFormTurnEventLine->zone = Zones::getZoneName($_POST['DigitalDiaryFormTurnEventLines']['id_zone']);
            $oDigitalDiaryFormTurnEventLine->region = Regions::getRegionName($_POST['DigitalDiaryFormTurnEventLines']['id_region']);
            
            if ($_POST['DigitalDiaryFormTurnEventLines']['id_equipment'] != FApplication::EQUIPMENT_OTHERS) {
               $oDigitalDiaryFormTurnEventLine->equipment = Equipments::getEquipmentName($_POST['DigitalDiaryFormTurnEventLines']['id_equipment']);
            }
            
            $oDigitalDiaryFormTurnEventLine->hour = date("H:i");
            $oDigitalDiaryFormTurnEventLine->id_form_turn_event = $nIdForm;
            
            if ($oDigitalDiaryFormTurnEventLine->save()) {
               $this->updateFormTurnEventStatus($nIdForm);
            }
         }
         else {
            if ((isset($_POST['DigitalDiaryFormTurnEventEmployees'])) && (FModuleDigitalDiaryManagement::allowUpdateFormTurnEvent($oDigitalDiaryFormTurnEvent->id))) { 
               // Ajax validation request=>Conditional validator
               FForm::validateAjaxForm('digitaldiary-form-turn-event-employee-form', $oDigitalDiaryFormTurnEventEmployee);
                           
               $oDigitalDiaryFormTurnEventEmployee->attributes = $_POST['DigitalDiaryFormTurnEventEmployees'];
               $oDigitalDiaryFormTurnEventEmployee->id_form_turn_event = $nIdForm;
               
               $bError = false;
               $oDigitalDiaryFormTurnEventEmployees = DigitalDiaryFormTurnEventEmployees::getDigitalDiaryFormTurnEventEmployeesByIdFormFK($nIdForm);
               foreach($oDigitalDiaryFormTurnEventEmployees as $oEmployee) {
                  if ($oEmployee->name == $oDigitalDiaryFormTurnEventEmployee->name) $bError = true;
               }
               
               if (!$bError) $oDigitalDiaryFormTurnEventEmployee->save();
            }
            else {         
               if ((isset($_POST['DigitalDiaryFormsTurnEvents'])) && (FModuleDigitalDiaryManagement::allowUpdateFormTurnEvent($oDigitalDiaryFormTurnEvent->id))) {
                  // Ajax validation request=>Conditional validator
                  FForm::validateAjaxForm('digitaldiary-form-turn-event-comments-form', $oDigitalDiaryFormTurnEvent);

                  $oDigitalDiaryFormTurnEvent->comments = $_POST['DigitalDiaryFormsTurnEvents']['comments'];  
                  $oDigitalDiaryFormTurnEvent->save();     
               }
            }
         }
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
      
      $oDigitalDiaryFormTurnEventLine->unsetAttributes();
      $oDigitalDiaryFormTurnEventEmployee->unsetAttributes();
      
      $oDigitalDiaryFormTurnEventLine->id_form_turn_event = $nIdForm;
       
      $this->render('updateFormTurnEvent', array('oModelForm'=>$oDigitalDiaryFormTurnEventLine, 'oModelFormEmployee'=>$oDigitalDiaryFormTurnEventEmployee, 'oModelFormTurnEvent'=>$oDigitalDiaryFormTurnEvent, 'oModelFormFilters'=>$oMonitoringFormTurnRound)); 
   }
   public function actionUpdateFormTurnEventLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
               
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (FModuleDigitalDiaryManagement::allowUpdateFormTurnEventLine($nIdForm)) {
               
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('digitaldiary-form-turn-event-line-form', $oDigitalDiaryFormTurnEventLine);
         
            if (isset($_POST['DigitalDiaryFormTurnEventLines'])) {
               if (($_POST['DigitalDiaryFormTurnEventLines']['section_name'] != $oDigitalDiaryFormTurnEventLine->section_name) || ($_POST['DigitalDiaryFormTurnEventLines']['zone'] != $oDigitalDiaryFormTurnEventLine->zone) || ($_POST['DigitalDiaryFormTurnEventLines']['region'] != $oDigitalDiaryFormTurnEventLine->region) || ($_POST['DigitalDiaryFormTurnEventLines']['equipment'] != $oDigitalDiaryFormTurnEventLine->equipment) || ($_POST['DigitalDiaryFormTurnEventLines']['description'] != $oDigitalDiaryFormTurnEventLine->description) || ($_POST['DigitalDiaryFormTurnEventLines']['urgent'] != $oDigitalDiaryFormTurnEventLine->urgent)) {
                  $oDigitalDiaryFormTurnEventLine->send = false;    
               }
               
               $oDigitalDiaryFormTurnEventLine->attributes = $_POST['DigitalDiaryFormTurnEventLines'];
               $oDigitalDiaryFormTurnEventLine->zone = Zones::getZoneName($_POST['DigitalDiaryFormTurnEventLines']['id_zone']);
               $oDigitalDiaryFormTurnEventLine->region = Regions::getRegionName($_POST['DigitalDiaryFormTurnEventLines']['id_region']);
               
               if ($_POST['DigitalDiaryFormTurnEventLines']['id_equipment'] != FApplication::EQUIPMENT_OTHERS) {
                  $oDigitalDiaryFormTurnEventLine->equipment = Equipments::getEquipmentName($_POST['DigitalDiaryFormTurnEventLines']['id_equipment']);
               }
               
               $oDigitalDiaryFormTurnEventLine->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/viewDetailFormTurnEventLine', array('nIdForm'=>$oDigitalDiaryFormTurnEventLine->id)));
            }
            else $this->render('updateFormTurnEventLine', array('oModelForm'=>$oDigitalDiaryFormTurnEventLine));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   } 
   
   
   public function actionNotifyFormTurnEvent($nIdForm) {
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      $bError = false;
      
      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesByIdFormFK($nIdForm);
         if (count($oDigitalDiaryFormTurnEventLines) > 0) {
            if (FModuleDigitalDiaryManagement::allowNotifyFormTurnEvent($nIdForm)) {
                // Send Email
                $oDigitalDiaryModuleParameters = DigitalDiaryModuleParameters::getDigitalDiaryModuleParameters();
                if (!is_null($oDigitalDiaryModuleParameters)) {
                   $oMail = new FMail($oDigitalDiaryModuleParameters->notify_smtp_host, $oDigitalDiaryModuleParameters->notify_smtp_user, $oDigitalDiaryModuleParameters->notify_smtp_passwd, $oDigitalDiaryModuleParameters->notify_smtp_port, $oDigitalDiaryModuleParameters->notify_smtp_ssl);
                   
                   $bGenericError = false;
                   $oDigitalDiaryFormTurnEventSections = DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($nIdForm);
                   foreach($oDigitalDiaryFormTurnEventSections as $oDigitalDiaryFormTurnEventSection) {
                      $sSubject = FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')) . ': ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_MAIL_SUBJECT', array('{1}'=>FString::STRING_EMPTY, '{2}'=>$oDigitalDiaryFormTurnEventSection->name, '{3}'=>FDate::getTimeZoneFormattedDate($oDigitalDiaryFormTurnEvent->date),'{4}'=>Yii::t('system', 'SYS_TURN_' . substr($oDigitalDiaryFormTurnEvent->turn, 2)), '{5}'=>$oDigitalDiaryFormTurnEvent->owner));
                      $sSubjectUrgent = FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')) . ': ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_MAIL_SUBJECT', array('{1}'=>Yii::t('system', 'SYS_URGENTS'), '{2}'=>$oDigitalDiaryFormTurnEventSection->name, '{3}'=>FDate::getTimeZoneFormattedDate($oDigitalDiaryFormTurnEvent->date),'{4}'=>Yii::t('system', 'SYS_TURN_' . substr($oDigitalDiaryFormTurnEvent->turn, 2)), '{5}'=>$oDigitalDiaryFormTurnEvent->owner));
                      
                      $sBody = FString::STRING_EMPTY;
                      $sBodyUrgent = FString::STRING_EMPTY;
                      
                      $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesBySectionNameAndIdFormFK($oDigitalDiaryFormTurnEventSection->name, $nIdForm);
                      if (count($oDigitalDiaryFormTurnEventLines) > 0) {
                         foreach($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
                            if (strlen($sBody) > 0) {
                               $sBody .= '<hr width="800px" noshade>';
                               $sBody .= $this->getTurnEventLineInformation($oDigitalDiaryFormTurnEventLine->id);
                            }
                            else $sBody = $this->getTurnEventLineInformation($oDigitalDiaryFormTurnEventLine->id); 
                            
                            if ($oDigitalDiaryFormTurnEventLine->urgent) {
                               if (strlen($sBodyUrgent) > 0) {
                                  $sBodyUrgent .= '<hr width="800px" noshade>';
                                  $sBodyUrgent .= $this->getTurnEventLineInformation($oDigitalDiaryFormTurnEventLine->id);
                               }
                               else $sBodyUrgent = $this->getTurnEventLineInformation($oDigitalDiaryFormTurnEventLine->id);
                            }
                         }
                         
                         $oDigitalDiaryFormTurnEventSectionNotifications = DigitalDiaryFormTurnEventSectionsNotifications::getDigitalDiaryFormTurnEventSectionNotificationsByIdFormFK($oDigitalDiaryFormTurnEventSection->id);
                         $bError = false;
                         
                         foreach($oDigitalDiaryFormTurnEventSectionNotifications as $oDigitalDiaryFormTurnEventSectionNotification) {
                            if ((($oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events) && (strlen($sBodyUrgent) > 0)) || (!$oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events)) {
                               if (!$oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events) { 
                                  if (!$oMail->send($oDigitalDiaryModuleParameters->notify_smtp_mail, $oDigitalDiaryFormTurnEventSectionNotification->mail, $sSubject, $sBody, true, FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')))) $bError = true;   
                               }
                               else {
                                  if (!$oMail->send($oDigitalDiaryModuleParameters->notify_smtp_mail, $oDigitalDiaryFormTurnEventSectionNotification->mail, $sSubjectUrgent, $sBodyUrgent, true, FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')))) $bError = true;      
                               }
                            }
                         }
                         
                         if (!$bError) {
                            foreach($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
                               $oDigitalDiaryFormTurnEventLine->send = true;
                               $oDigitalDiaryFormTurnEventLine->save();   
                            }
                         }
                         else $bGenericError = true;
                      }
                   }
         
                   if (!$bGenericError) {
                      $this->updateFormTurnEventStatus($nIdForm);
                      FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_SUCCESS'));   
                   }
                   else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_SEND'));  
                } 
                else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_CONFIGURATION')); 
            }
            else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
         }
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_LINES_NOT_EXIST')); 
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/viewFormsTurnEvents'));
   }
   public function actionNotifyFormTurnEventLine($nIdForm, $nIdFormParent) {
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      $bError = false;
      $nSectionId = null;
      
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (FModuleDigitalDiaryManagement::allowNotifyFormTurnEventLine($nIdForm)) {
             // Send Email
             $oDigitalDiaryModuleParameters = DigitalDiaryModuleParameters::getDigitalDiaryModuleParameters();
             if (!is_null($oDigitalDiaryModuleParameters)) {
                $sUrgent = FString::STRING_EMPTY;
                if ($oDigitalDiaryFormTurnEventLine->urgent) $sUrgent = Yii::t('system', 'SYS_URGENT'); 
                 
                $sSubject = FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')) . ': ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_MAIL_SUBJECT', array('{1}'=>$sUrgent, '{2}'=>$oDigitalDiaryFormTurnEventLine->section_name, '{3}'=>FDate::getTimeZoneFormattedDate($oDigitalDiaryFormTurnEventLine->formTurnEvent->date),'{4}'=>Yii::t('system', 'SYS_TURN_' . substr($oDigitalDiaryFormTurnEventLine->formTurnEvent->turn, 2)), '{5}'=>$oDigitalDiaryFormTurnEventLine->formTurnEvent->owner));
                $sBody = $this->getTurnEventLineInformation($nIdForm); 
                
                $oMail = new FMail($oDigitalDiaryModuleParameters->notify_smtp_host, $oDigitalDiaryModuleParameters->notify_smtp_user, $oDigitalDiaryModuleParameters->notify_smtp_passwd, $oDigitalDiaryModuleParameters->notify_smtp_port, $oDigitalDiaryModuleParameters->notify_smtp_ssl);
                
                $oDigitalDiaryFormTurnEventSections = DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($oDigitalDiaryFormTurnEventLine->id_form_turn_event);
                foreach ($oDigitalDiaryFormTurnEventSections as $oDigitalDiaryFormTurnEventSection) {
                   if ($oDigitalDiaryFormTurnEventSection->name == $oDigitalDiaryFormTurnEventLine->section_name) $nSectionId = $oDigitalDiaryFormTurnEventSection->id;   
                }
                
                if (!is_null($nSectionId)) {
                   $oDigitalDiaryFormTurnEventSectionNotifications = DigitalDiaryFormTurnEventSectionsNotifications::getDigitalDiaryFormTurnEventSectionNotificationsByIdFormFK($nSectionId);
                
                   foreach($oDigitalDiaryFormTurnEventSectionNotifications as $oDigitalDiaryFormTurnEventSectionNotification) {
                      if ((($oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events) && ($oDigitalDiaryFormTurnEventLine->urgent)) || (!$oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events)) { 
                         if (!$oMail->send($oDigitalDiaryModuleParameters->notify_smtp_mail, $oDigitalDiaryFormTurnEventSectionNotification->mail, $sSubject, $sBody, true, FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')))) $bError = true;
                      }
                   }
                   
                   if (!$bError) {
                      $oDigitalDiaryFormTurnEventLine->send = true;
                      $oDigitalDiaryFormTurnEventLine->save();
                      
                      $this->updateFormTurnEventStatus($oDigitalDiaryFormTurnEventLine->id_form_turn_event);
                      
                      FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_SUCCESS'));
                   }
                   else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_SEND')); 
                }
                else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_SECTION_NOT_EXIST')); 
             } 
             else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_CONFIGURATION')); 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$nIdFormParent)));
   }
   
                 
   public function actionRefreshFormTurnEventLinesRegions($nIdZone) {
      $this->layout = null;
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/refreshFormTurnEventLinesEquipments') . '&nIdRegion=';
      $sRefreshEquipmentsUrl = "aj('" . $sRefreshEquipmentsUrl . "' + this.value, null, 'id_equipment')";              
      $sJsRefreshDisappearEquipmentOthers = "$('#DigitalDiaryFormTurnEventLines_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";
                                  
      $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshDisappearEquipmentOthers . ';' . $sRefreshEquipmentsUrl . ';' . "\" name=\"DigitalDiaryFormTurnEventLines[id_region]\" id=\"DigitalDiaryFormTurnEventLines_id_region\">";   
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
   public function actionRefreshFormTurnEventLinesEquipments($nIdRegion) {
      $this->layout = null;
      
      $sJsRefreshEquipmentOthers = "$('#DigitalDiaryFormTurnEventLines_equipment').val(''); jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', this.value == '" . FApplication::EQUIPMENT_OTHERS . "', 1.0, 1000)";
         
      $sContent = "<select style=\"width:300px;\" onchange=\"" . $sJsRefreshEquipmentOthers . "\" name=\"DigitalDiaryFormTurnEventLines[id_equipment]\" id=\"DigitalDiaryFormTurnEventLines_id_equipment\">";   
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
   
   
   public function actionDeleteFormTurnEvent($nIdForm) {
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);

      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         if (FModuleDigitalDiaryManagement::allowDeleteFormTurnEvent($nIdForm)) $oDigitalDiaryFormTurnEvent->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/viewFormsTurnEvents'));
   }
   public function actionDeleteFormTurnEventLine($nIdForm, $nIdFormParent) {
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);

      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (FModuleDigitalDiaryManagement::allowDeleteFormTurnEventLine($nIdForm)) {
            $oDigitalDiaryFormTurnEventLine->delete();
            $this->updateFormTurnEventStatus($oDigitalDiaryFormTurnEventLine->id_form_turn_event);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$nIdFormParent)));
   } 
   public function actionDeleteFormTurnEventEmployee($nIdForm, $nIdFormParent) {
      $oDigitalDiaryFormTurnEventEmployee = DigitalDiaryFormTurnEventEmployees::getDigitalDiaryFormTurnEventEmployee($nIdForm);
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);

      if (!is_null($oDigitalDiaryFormTurnEventEmployee)) {
         if (FModuleDigitalDiaryManagement::allowDeleteFormTurnEventEmployee($nIdForm)) {
            $oDigitalDiaryFormTurnEventEmployee->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$nIdFormParent)));
   }
   
   
   // Private Methods
   private function getTurnEventLineInformation($nIdForm) {
      $sOutput = FString::STRING_EMPTY;
      
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
          $sOutput .= '<table>';
          
          if ($oDigitalDiaryFormTurnEventLine->urgent) {
             $sOutput .= '<tr><td><font color="red"><b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT') . '</b></font></td>';
             $sOutput .= '<td></td></tr>';   
          }
          
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_DATE') . ': </td>';
          $sOutput .= '<td>' . FDate::getTimeZoneFormattedDate($oDigitalDiaryFormTurnEventLine->formTurnEvent->date) . '</td></tr>';
          
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_TURN') . ': </td>';
          $sOutput .= '<td>' . Yii::t('system', 'SYS_TURN_' . substr($oDigitalDiaryFormTurnEventLine->formTurnEvent->turn, 2)) . '</td></tr>';
                                      
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR') . ': </td>';
          $sOutput .= '<td>' . $oDigitalDiaryFormTurnEventLine->hour . '</td></tr>';
          
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME') . ': </td>';
          $sOutput .= '<td>' . $oDigitalDiaryFormTurnEventLine->section_name . '</td></tr>';
          
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE') . ': </td>';
          $sOutput .= '<td>' . $oDigitalDiaryFormTurnEventLine->zone . '/' . $oDigitalDiaryFormTurnEventLine->region . '</td></tr>';
          
          $sEquipment = $oDigitalDiaryFormTurnEventLine->equipment; 
            
          $sOutput .= '<tr><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT') . ': </td>';
          $sOutput .= '<td>' . $sEquipment . '</td></tr>';
          $sOutput .= '</table>';
          
          $sOutput .= '<table style="padding-top:20px; width:800px;">';
          $sOutput .= '<tr><td bgcolor="#FCFFBD">' . $oDigitalDiaryFormTurnEventLine->description . '</td></tr>';
          $sOutput .= '</table>';
      }
      
      return $sOutput;   
   }
   private function updateFormTurnEventStatus($nIdForm) {
      $bCompleted = true;
      
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesByIdFormFK($nIdForm);
         
         if (count($oDigitalDiaryFormTurnEventLines) > 0) {
            foreach ($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
               if (!$oDigitalDiaryFormTurnEventLine->send) $bCompleted = false;    
            }   
         }  
         else $bCompleted = false;    
         
         if ($bCompleted) $oDigitalDiaryFormTurnEvent->status = FModuleDigitalDiaryManagement::STATUS_FINALIZED;
         else $oDigitalDiaryFormTurnEvent->status = FModuleDigitalDiaryManagement::STATUS_CREATED; 
         
         $oDigitalDiaryFormTurnEvent->save(); 
      } 
   }
}