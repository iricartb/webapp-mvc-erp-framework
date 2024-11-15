<?php      
class FModuleWorkingPartsManagement {     
   const MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS = 8;
   const MAX_MEASURES_SPECIAL_WORKING_PARTS_SIMULTANEOUS = 10;
   const MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS = 8;
   
   const MAX_INFORMATION_TEXTS_WORKING_PARTS_SIMULTANEOUS = 0;
   const MAX_INFORMATION_TEXTS_SPECIAL_WORKING_PARTS_SIMULTANEOUS = 0;
   const MAX_INFORMATION_TEXTS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS = 0;
   
   const MAX_EQUIPMENT_CONDITIONS_WORKING_PARTS_SIMULTANEOUS = 7;
   const MAX_EQUIPMENT_CONDITIONS_SPECIAL_WORKING_PARTS_SIMULTANEOUS = 10;
   const MAX_EQUIPMENT_CONDITIONS_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS = 7;
   
   const STATUS_CREATED = 'CREATED';
   const STATUS_PENDING = 'PENDING';
   const STATUS_RUNNING = 'RUNNING';
   const STATUS_PENDING_ABSENCE = 'PENDING_ABSENCE';
   const STATUS_HALTED = 'HALTED';
   const STATUS_FINALIZED = 'FINALIZED';
   
   const COLOR_STATUS_CREATED = '#585cfe';
   const COLOR_STATUS_PENDING = '#cfc23a';
   const COLOR_STATUS_RUNNING = '#5c9b61';
   const COLOR_STATUS_PENDING_ABSENCE = '#cfc23a';
   const COLOR_STATUS_HALTED = '#a93030';
   const COLOR_STATUS_FINALIZED = '#8a8a8a';
   
   const COLOR_GRID_STATUS_CREATED = '#57aaff';
   const COLOR_GRID_STATUS_PENDING = '#f4e544';
   const COLOR_GRID_STATUS_RUNNING = '#88e88f';
   const COLOR_GRID_STATUS_PENDING_ABSENCE = '#f4e544';
   const COLOR_GRID_STATUS_HALTED = '#ff4848';
   const COLOR_GRID_STATUS_FINALIZED = '#cdcdcd';
   
   const REPORT_FONT_NAME = 'Arial';
   const REPORT_MAX_CHARS_TO_NEW_LINE = 60;
   
   const TYPE_WORK_CONFINED_SPACE = 'CONFINED_SPACE';
   const TYPE_WORK_VOLTAGE = 'VOLTAGE';                          
   const TYPE_WORK_HEIGHT = 'HEIGHT';
   const TYPE_WORK_FIRE_EXPLOSION = 'FIRE_EXPLOSION';
   
   const WORKING_PART_FULL_ABBREVIATION = 'WP';
   const WORKING_PART_MAINTENANCE_FULL_ABBREVIATION = 'WPIP';
   const WORKING_PART_SPECIAL_FULL_ABBREVIATION = 'WPS'; 
   
   public static function allowUpdateFormWorkRequest($nIdForm) { 
      $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($nIdForm);
      
      if (!is_null($oFormWorkRequest)) {
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && ($oFormWorkRequest->id_user == Yii::app()->user->id) && ($oFormWorkRequest->status != FModuleWorkingPartsManagement::STATUS_FINALIZED)));
      }
      
      return false;
   }
   public static function allowDeleteFormWorkRequest($nIdForm) { 
      $oFormWorkRequest = FormsWorkRequests::getFormWorkRequest($nIdForm);
      
      if (!is_null($oFormWorkRequest)) {  
         return ((Users::getIsMaster(Yii::app()->user->id)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && ($oFormWorkRequest->id_user == Yii::app()->user->id) && ($oFormWorkRequest->status != FModuleWorkingPartsManagement::STATUS_FINALIZED)));
      }
      
      return false;
   }
   
   
   public static function getRunningFormsWorkingParts() {
      $oArrayFormsWorkingParts = array();
      
      $oFormsWorkingParts = FormsWorkingParts::getRunningFormsWorkingParts();
      foreach($oFormsWorkingParts as $oFormWorkingPart) {
         $oArrayFormsWorkingParts = array_merge($oArrayFormsWorkingParts, array((FModuleWorkingPartsManagement::WORKING_PART_FULL_ABBREVIATION . '-' . $oFormWorkingPart->id)=>(Yii::t('rainbow', 'WORKING_PART_FULL_ABBREVIATION') . '-' . $oFormWorkingPart->id) . ': ' . $oFormWorkingPart->equipment_failure_reason));      
      }
      
      $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getRunningFormsMaintenanceWorkingParts();
      foreach($oFormsMaintenanceWorkingParts as $oFormMaintenanceWorkingPart) {
         $oArrayFormsWorkingParts = array_merge($oArrayFormsWorkingParts, array((FModuleWorkingPartsManagement::WORKING_PART_MAINTENANCE_FULL_ABBREVIATION . '-' . $oFormMaintenanceWorkingPart->id)=>(Yii::t('rainbow', 'WORKING_PART_MAINTENANCE_FULL_ABBREVIATION') . '-' . $oFormMaintenanceWorkingPart->id) . ': ' . $oFormMaintenanceWorkingPart->equipment_failure_reason));      
      }
      
      $oFormsSpecialWorkingParts = FormsSpecialWorkingParts::getRunningFormsSpecialWorkingParts();
      foreach($oFormsSpecialWorkingParts as $oFormSpecialWorkingPart) {
         $oArrayFormsWorkingParts = array_merge($oArrayFormsWorkingParts, array((FModuleWorkingPartsManagement::WORKING_PART_SPECIAL_FULL_ABBREVIATION . '-' . $oFormSpecialWorkingPart->id)=>(Yii::t('rainbow', 'WORKING_PART_SPECIAL_FULL_ABBREVIATION') . '-' . $oFormSpecialWorkingPart->id) . ': ' . $oFormSpecialWorkingPart->installation));      
      }
      
      return $oArrayFormsWorkingParts;
   }
}
?>