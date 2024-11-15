<?php
class JobController extends Controller {
   
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array();
	}
   
   public function actionDailyScheduler() {
      if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) {
         try {
            $this->jobDigitalDiaryManagementNotifyDailyEvents();  
         } catch(Exception $e) { } 
      }
      
      $this->actionProvidersScheduler();
   }
  
   public function actionProvidersScheduler() {
      if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) || (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PURCHASES_MANAGEMENT))) {
         try {
            $this->jobPurchasesManagementCreateFinancialCosts();
            
            $this->jobPurchasesManagementSynchronizeProvidersFromExternalDB();  
         } catch(Exception $e) { } 
      }  
   }  
   
   public function actionScheduler() {
      if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) { 
         try {
            $this->jobPlantMaintenanceManagementScheduledTasks();  
         } catch(Exception $e) { } 
      }
   }
    
   private function jobDigitalDiaryManagementNotifyDailyEvents() {
      $oDigitalDiaryModuleParameters = DigitalDiaryModuleParameters::getDigitalDiaryModuleParameters();
      if (!is_null($oDigitalDiaryModuleParameters)) {
         $oMail = new FMail($oDigitalDiaryModuleParameters->notify_smtp_host, $oDigitalDiaryModuleParameters->notify_smtp_user, $oDigitalDiaryModuleParameters->notify_smtp_passwd, $oDigitalDiaryModuleParameters->notify_smtp_port, $oDigitalDiaryModuleParameters->notify_smtp_ssl);
              
         $sSubject = FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')) . ': ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_NOTIFYDAILYEVENTS_NOTIFY_MAIL_SUBJECT', array('{1}'=>FDate::getTimeZoneFormattedDate(date('Y-m-d', strtotime("-1 day")))));
         $sBody = FString::STRING_EMPTY;
                         
         $oDigitalDiaryDailyNotifications = DigitalDiaryDailyNotifications::getDigitalDiaryDailyNotifications();
         if (count($oDigitalDiaryDailyNotifications) > 0) {
            $oMorningDigitalDiaryFormsTurnEvents = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormsTurnEventsByDateAndTurn(date('Y-m-d', strtotime("-1 day")), FApplication::TYPE_TURN_MORNING);
            $oAfternoonDigitalDiaryFormsTurnEvents = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormsTurnEventsByDateAndTurn(date('Y-m-d', strtotime("-1 day")), FApplication::TYPE_TURN_AFTERNOON);
            $oNightDigitalDiaryFormsTurnEvents = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormsTurnEventsByDateAndTurn(date('Y-m-d', strtotime("-1 day")), FApplication::TYPE_TURN_NIGHT);
            
            $bPaddingSection = false;
            $sBody = '<table>'; 
            
            if ((count($oMorningDigitalDiaryFormsTurnEvents) > 0) || (count($oAfternoonDigitalDiaryFormsTurnEvents) > 0) || (count($oNightDigitalDiaryFormsTurnEvents) > 0)) { 
               if (count($oMorningDigitalDiaryFormsTurnEvents) > 0) {
                  $bPaddingSection = true;
                  $sBody .= '</table>';
                  $bFirst = true;
                  
                  foreach($oMorningDigitalDiaryFormsTurnEvents as $oMorningDigitalDiaryFormTurnEvent) {
                     $sBody .= '<table>';
                     if ($bFirst) $sCssStyle = 'height:25px; vertical-align:bottom';
                     else $sCssStyle = 'height:40px; vertical-align:bottom';
                     
                     $bFirst = false;
                     $sBody .= '<tr style="' . $sCssStyle . '"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER') . ': ' . $oMorningDigitalDiaryFormTurnEvent->owner . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="height:25px; vertical-align:bottom"><td>' . $oMorningDigitalDiaryFormTurnEvent->comments . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="font-weight:bold"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_REGION') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION') . '</td></tr>';
                     
                     $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesByIdFormFK($oMorningDigitalDiaryFormTurnEvent->id);
                     foreach($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
                        $sEquipment = $oDigitalDiaryFormTurnEventLine->equipment; 
              
                        if ($oDigitalDiaryFormTurnEventLine->urgent) $sCssUrgent = 'background-color: rgba(255, 0, 0, 0.4); vertical-align:top';
                        else $sCssUrgent = 'vertical-align:top';
                                                                  
                        $sBody .= '<tr><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->hour . '</td><td></td><td style="vertical-align:top">' . FString::castStrToCapitalLetters($oDigitalDiaryFormTurnEventLine->section_name) . '</td><td></td><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->zone . '/' . $oDigitalDiaryFormTurnEventLine->region . '</td><td></td><td style="vertical-align:top">' . $sEquipment . '</td><td></td><td style="' . $sCssUrgent . '">' . $oDigitalDiaryFormTurnEventLine->description . '</td></tr>';
                     }
                     $sBody .= '</table>';   
                  }
               }
               
               if (count($oAfternoonDigitalDiaryFormsTurnEvents) > 0) {
                  if ($bPaddingSection) { 
                     $sBody .= '<br><br><br><table>';
                  }
                  
                  $bPaddingSection = true;
                  
                  $sBody .= '</table>';
                  $bFirst = true;
                  
                  foreach($oAfternoonDigitalDiaryFormsTurnEvents as $oAfternoonDigitalDiaryFormTurnEvent) {
                     $sBody .= '<table>';
                     if ($bFirst) $sCssStyle = 'height:25px; vertical-align:bottom';
                     else $sCssStyle = 'height:40px; vertical-align:bottom';
                     
                     $bFirst = false;
                     $sBody .= '<tr style="' . $sCssStyle . '"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER') . ': ' . $oAfternoonDigitalDiaryFormTurnEvent->owner . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="height:25px; vertical-align:bottom"><td>' . $oAfternoonDigitalDiaryFormTurnEvent->comments . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="font-weight:bold"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_REGION') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION') . '</td></tr>';
                     
                     $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesByIdFormFK($oAfternoonDigitalDiaryFormTurnEvent->id);
                     foreach($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
                        $sEquipment = $oDigitalDiaryFormTurnEventLine->equipment; 
              
                        if ($oDigitalDiaryFormTurnEventLine->urgent) $sCssUrgent = 'background-color: rgba(255, 0, 0, 0.4); vertical-align:top';
                        else $sCssUrgent = 'vertical-align:top';
                                            
                        $sBody .= '<tr><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->hour . '</td><td></td><td style="vertical-align:top">' . FString::castStrToCapitalLetters($oDigitalDiaryFormTurnEventLine->section_name) . '</td><td></td><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->zone .  '/' . $oDigitalDiaryFormTurnEventLine->region . '</td><td></td><td style="vertical-align:top">' . $sEquipment . '</td><td></td><td style="' . $sCssUrgent . '">' . $oDigitalDiaryFormTurnEventLine->description . '</td></tr>';
                     }
                     $sBody .= '</table>';   
                  }
               }
               
               if (count($oNightDigitalDiaryFormsTurnEvents) > 0) { 
                  if ($bPaddingSection) { 
                     $sBody .= '<br><br><br><table>';
                  }
                  
                  $sBody .= '</table>';
                  $bFirst = true;
                  
                  foreach($oNightDigitalDiaryFormsTurnEvents as $oNightDigitalDiaryFormTurnEvent) {
                     $sBody .= '<table>';
                     if ($bFirst) $sCssStyle = 'height:25px; vertical-align:bottom';
                     else $sCssStyle = 'height:40px; vertical-align:bottom';
                     
                     $bFirst = false;
                     $sBody .= '<tr style="' . $sCssStyle . '"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER') . ': ' . $oNightDigitalDiaryFormTurnEvent->owner . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="height:25px; vertical-align:bottom"><td>' . $oNightDigitalDiaryFormTurnEvent->comments . '</td></tr>';
                     $sBody .= '</table>';
                     
                     $sBody .= '<table>';
                     $sBody .= '<tr style="font-weight:bold"><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_REGION') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT') . '</td><td style="padding-right:30px;"></td><td>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION') . '</td></tr>';
                     
                     $oDigitalDiaryFormTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLinesByIdFormFK($oNightDigitalDiaryFormTurnEvent->id);
                     foreach($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
                        $sEquipment = $oDigitalDiaryFormTurnEventLine->equipment; 
              
                        if ($oDigitalDiaryFormTurnEventLine->urgent) $sCssUrgent = 'background-color: rgba(255, 0, 0, 0.4); vertical-align:top';
                        else $sCssUrgent = 'vertical-align:top';
                                                     
                        $sBody .= '<tr><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->hour . '</td><td></td><td style="vertical-align:top">' . FString::castStrToCapitalLetters($oDigitalDiaryFormTurnEventLine->section_name) . '</td><td></td><td style="vertical-align:top">' . $oDigitalDiaryFormTurnEventLine->zone . '/' . $oDigitalDiaryFormTurnEventLine->region . '</td><td></td><td style="vertical-align:top">' . $sEquipment . '</td><td></td><td style="' . $sCssUrgent . '">' . $oDigitalDiaryFormTurnEventLine->description . '</td></tr>';
                     }
                     $sBody .= '</table>';   
                  }
               }   
            }
            else $sBody .= '</table>';
                 
            foreach($oDigitalDiaryDailyNotifications as $oDigitalDiaryDailyNotification) {
               $oMail->send($oDigitalDiaryModuleParameters->notify_smtp_mail, $oDigitalDiaryDailyNotification->mail, $sSubject, $sBody, true, FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER')));   
            }
         }
      }
   }
   
   private function jobPurchasesManagementCreateFinancialCosts() {
      $oPurchasesFinancialCostByYear = PurchasesFinancialCosts::getPurchasesFinancialCostByYear(date('Y', strtotime('+6 month')));  
      if (is_null($oPurchasesFinancialCostByYear)) {
         $oPurchasesFinancialCost = new PurchasesFinancialCosts();
         $oPurchasesFinancialCost->year = date('Y', strtotime('+6 month')); 
         
         if ($oPurchasesFinancialCost->save()) { 
            $oPurchasesFinancialCostByLastYear = PurchasesFinancialCosts::getPurchasesFinancialCostByYear($oPurchasesFinancialCost->year - 1);  
            if (!is_null($oPurchasesFinancialCostByLastYear)) {
               $oPurchasesFinancialCostLinesLastYear = PurchasesFinancialCostsLines::getPurchasesFinancialCostsLinesByIdFormFK($oPurchasesFinancialCostByLastYear->id);
               foreach($oPurchasesFinancialCostLinesLastYear as $oPurchasesFinancialCostLineLastYear) {
                  $oPurchasesFinancialCostLine = new PurchasesFinancialCostsLines();
                  
                  $oPurchasesFinancialCostLine->group = $oPurchasesFinancialCostLineLastYear->group;
                  $oPurchasesFinancialCostLine->concept = $oPurchasesFinancialCostLineLastYear->concept;
                  $oPurchasesFinancialCostLine->department = $oPurchasesFinancialCostLineLastYear->department;
                  $oPurchasesFinancialCostLine->max_price = 0;
                  $oPurchasesFinancialCostLine->id_financial_cost = $oPurchasesFinancialCost->id;
                  
                  $oPurchasesFinancialCostLine->save();      
               }    
            }  
         }
      } 
   }
   
   private function jobPurchasesManagementSynchronizeProvidersFromExternalDB() {
      FModulePurchasesManagement::synchronizeProvidersFromExternalDB();
   }
   
   private function jobPlantMaintenanceManagementScheduledTasks() {
      $oMaintenanceScheduledTasks = MaintenanceScheduledTasks::getMaintenanceScheduledTasks();
      
      foreach ($oMaintenanceScheduledTasks as $oMaintenanceScheduledTask) {
         if ((!is_null($oMaintenanceScheduledTask->execution_date)) && (FDate::isDateMinorEqual($oMaintenanceScheduledTask->execution_date, date('Y-m-d H:i:s')))) {
            $oMaintenanceFormTask = new MaintenanceFormsTasks();
            $oMaintenanceFormTask->name = $oMaintenanceScheduledTask->name;
            $oMaintenanceFormTask->task = $oMaintenanceScheduledTask->task;
            $oMaintenanceFormTask->type_task = $oMaintenanceScheduledTask->type_task;
            $oMaintenanceFormTask->owner = $oMaintenanceScheduledTask->owner;
            $oMaintenanceFormTask->priority = $oMaintenanceScheduledTask->priority;
            $oMaintenanceFormTask->priority_number = $oMaintenanceScheduledTask->priority_number;
            $oMaintenanceFormTask->id_zone = $oMaintenanceScheduledTask->id_zone;
            $oMaintenanceFormTask->zone = Zones::getZoneName($oMaintenanceScheduledTask->id_zone);
            $oMaintenanceFormTask->id_region = $oMaintenanceScheduledTask->id_region;
            $oMaintenanceFormTask->region = Regions::getRegionName($oMaintenanceScheduledTask->id_region);
            $oMaintenanceFormTask->id_equipment = $oMaintenanceScheduledTask->id_equipment;
            $oMaintenanceFormTask->equipment = Equipments::getEquipmentName($oMaintenanceScheduledTask->id_equipment);  
            $oMaintenanceFormTask->start_date = date('Y-m-d H:i:s');
            $oMaintenanceFormTask->status = FModulePlantMaintenanceManagement::STATUS_PENDING;
            
            if ((!FString::isNullOrEmpty($oMaintenanceScheduledTask->attachment)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment))) {
               if (copy(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS . $oMaintenanceScheduledTask->attachment, FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS . $oMaintenanceScheduledTask->attachment)) {
                  $oMaintenanceFormTask->attachment = $oMaintenanceScheduledTask->attachment; 
               }
            }
            
            $oMaintenanceFormTask->id_scheduled_task = $oMaintenanceScheduledTask->id;
            $oMaintenanceFormTask->id_user = $oMaintenanceScheduledTask->id_user;
            $oMaintenanceFormTask->admin = true;
            $oMaintenanceFormTask->data_completed = true;
            
            if ($oMaintenanceFormTask->save()) {
               $oMaintenanceScheduledTaskComponents = MaintenanceScheduledTasksComponents::getMaintenanceScheduledTaskComponentsByIdFormFK($oMaintenanceScheduledTask->id);
               foreach($oMaintenanceScheduledTaskComponents as $oMaintenanceScheduledTaskComponent) {
                  $oMaintenanceFormTaskComponent = new MaintenanceFormTaskComponents();
                  $oMaintenanceFormTaskComponent->id_component = $oMaintenanceScheduledTaskComponent->id_component;
                  $oMaintenanceFormTaskComponent->component = Components::getComponentName($oMaintenanceScheduledTaskComponent->id_component);
                  $oMaintenanceFormTaskComponent->id_form_task = $oMaintenanceFormTask->id;
                  $oMaintenanceFormTaskComponent->save();   
               } 
              
               $oMaintenanceScheduledTaskDepartments = MaintenanceScheduledTasksDepartments::getMaintenanceScheduledTaskDepartmentsByIdFormFK($oMaintenanceScheduledTask->id);
               foreach($oMaintenanceScheduledTaskDepartments as $oMaintenanceScheduledTaskDepartment) {
                  $oMaintenanceFormTaskDepartment = new MaintenanceFormTaskDepartments();
                  $oMaintenanceFormTaskDepartment->name = $oMaintenanceScheduledTaskDepartment->name;
                  $oMaintenanceFormTaskDepartment->id_form_task = $oMaintenanceFormTask->id;
                  if ($oMaintenanceFormTaskDepartment->save()) {
                     if ($oMaintenanceScheduledTask->alarm) {
                        Events::addSystemEvent('EVENT_NEW_FORM_MAINTENANCE_TASK_TITLE', 'EVENT_NEW_FORM_MAINTENANCE_TASK', $oMaintenanceScheduledTask->task, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, array(array(null, $oMaintenanceScheduledTaskDepartment->name)));      
                     }
                  }  
               }         
            }
            
            if (($oMaintenanceScheduledTask->repeat_minutes == 0) && ($oMaintenanceScheduledTask->repeat_hours == 0) && ($oMaintenanceScheduledTask->repeat_days == 0) && ($oMaintenanceScheduledTask->repeat_months == 0) && ($oMaintenanceScheduledTask->repeat_years == 0)) {
               $oMaintenanceScheduledTask->delete();
            }
            else {
               $oDate = strtotime($oMaintenanceScheduledTask->execution_date);
               $oDate = strtotime(date('Y-m-d H:i', strtotime('+' . $oMaintenanceScheduledTask->repeat_years . ' years', $oDate)));
               $oDate = strtotime(date('Y-m-d H:i', strtotime('+' . $oMaintenanceScheduledTask->repeat_months . ' months', $oDate)));
               $oDate = strtotime(date('Y-m-d H:i', strtotime('+' . $oMaintenanceScheduledTask->repeat_days . ' days', $oDate)));
               $oDate = strtotime(date('Y-m-d H:i', strtotime('+' . $oMaintenanceScheduledTask->repeat_hours . ' hours', $oDate)));     
               $sExecutionTime = date('Y-m-d H:i', strtotime('+' . $oMaintenanceScheduledTask->repeat_minutes . ' minutes', $oDate));
               
               $oMaintenanceScheduledTask->execution_date = $sExecutionTime;
               
               $oMaintenanceScheduledTask->save();
            }  
         }    
      } 
   }
}