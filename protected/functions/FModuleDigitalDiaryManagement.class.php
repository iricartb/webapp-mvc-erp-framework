<?php      
class FModuleDigitalDiaryManagement {     
   const STATUS_CREATED = 'CREATED';
   const STATUS_FINALIZED = 'FINALIZED';
   
   const COLOR_GRID_STATUS_CREATED = '#E7BCBC';
   const COLOR_GRID_STATUS_FINALIZED = '#C3EABB';
   
   const REPORT_EVENTS_COLOR_URGENT = 'FFE3C8';
   
   const MODE_UPDATE_FORM_TURN_EVENT_COMMENTS_NONE = 0; 
   const MODE_UPDATE_FORM_TURN_EVENT_COMMENTS_OWNER = 1; 
   const MODE_UPDATE_FORM_TURN_EVENT_COMMENTS_OTHER = 2; 
   
   public static function allowViewMonitoringFormTurnRound($nIdFormTurnEvent) {
      return (!is_null(MonitoringFormsTurnRounds::getLastMonitoringFormTurnRoundByIdFormTurnEvent($nIdFormTurnEvent)));  
   }
   
   public static function allowNotifyFormTurnEvent($nIdForm) {
      $bAllowNotify = false;
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowNotify = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEvent->owner)) $bAllowNotify = true;
            }
         }
      }
      
      return $bAllowNotify; 
   }
   public static function allowNotifyFormTurnEventLine($nIdForm) {
      $bAllowNotify = false;
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowNotify = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEventLine->formTurnEvent->owner)) $bAllowNotify = true;
            }
         }
      }

      return $bAllowNotify; 
   }
   
   public static function allowUpdateFormTurnEventLine($nIdForm) {
      $bAllowUpdate = false;
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowUpdate = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEventLine->formTurnEvent->owner) && (FDate::getDiffHours($oDigitalDiaryFormTurnEventLine->formTurnEvent->start_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)) $bAllowUpdate = true;
            }
         }
      }

      return $bAllowUpdate;
   } 
   public static function allowUpdateFormTurnEvent($nIdForm) {
      $bAllowUpdate = false;
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowUpdate = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEvent->owner) && (FDate::getDiffHours($oDigitalDiaryFormTurnEvent->start_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)) $bAllowUpdate = true;
            }
         }
      }

      return $bAllowUpdate;
   }
   
   public static function allowDeleteFormTurnEvent($nIdForm) {
      $bAllowDelete = false;
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormTurnEvent($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEvent)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowDelete = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEvent->owner) && (FDate::getDiffHours($oDigitalDiaryFormTurnEvent->start_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)) $bAllowDelete = true;
            }
         }
      }

      return $bAllowDelete; 
   }
   public static function allowDeleteFormTurnEventLine($nIdForm) {
      $bAllowDelete = false;
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormTurnEventLine($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEventLine)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowDelete = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEventLine->formTurnEvent->owner) && (FDate::getDiffHours($oDigitalDiaryFormTurnEventLine->formTurnEvent->start_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)) $bAllowDelete = true;
            }
         }
      }

      return $bAllowDelete; 
   }
   public static function allowDeleteFormTurnEventEmployee($nIdForm) {
      $bAllowDelete = false;
      $oDigitalDiaryFormTurnEventEmployee = DigitalDiaryFormTurnEventEmployees::getDigitalDiaryFormTurnEventEmployee($nIdForm);
      
      if (!is_null($oDigitalDiaryFormTurnEventEmployee)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) $bAllowDelete = true;
         else { 
            $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
            if ($sCurrentUser != FString::STRING_EMPTY) {
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)) && ($sCurrentUser == $oDigitalDiaryFormTurnEventEmployee->formTurnEvent->owner) && (FDate::getDiffHours($oDigitalDiaryFormTurnEventEmployee->formTurnEvent->start_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)) $bAllowDelete = true;
            }
         }
      }

      return $bAllowDelete; 
   }
}
?>