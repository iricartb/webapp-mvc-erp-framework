<?php      
class FModulePlantMaintenanceManagement {
   const SCENE_WIDTH = 860;
   const SCENE_HEIGHT = 600;
   
   const TYPE_TASK_REVISION = 'REVISION';
   const TYPE_TASK_REPAIR = 'REPAIR';
   const TYPE_TASK_OTHERS = 'OTHERS';
   
   const TYPE_WORKING_PART_VALUE_NONE = 0;
   const TYPE_WORKING_PART_VALUE_NORMAL = 1;
   const TYPE_WORKING_PART_VALUE_MAINTENANCE = 2;
   const TYPE_WORKING_PART_VALUE_SPECIAL = 3;
   
   const STATUS_PENDING = 'PENDING';
   const STATUS_RUNNING = 'RUNNING';
   const STATUS_FINALIZED = 'FINALIZED';
   
   const COLOR_STATUS_PENDING = '#cfc23a';
   const COLOR_STATUS_RUNNING = '#5c9b61';
   const COLOR_STATUS_FINALIZED = '#8a8a8a';
   
   const COLOR_GRID_STATUS_PENDING = '#f4e544';
   const COLOR_GRID_STATUS_RUNNING = '#88e88f';
   const COLOR_GRID_STATUS_FINALIZED = '#cdcdcd';
   
   public static function allowUpdateMaintenanceFormTask($nIdForm) { 
      $bAllowUpdate = false;
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
      
      if (!is_null($oMaintenanceFormTask)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) $bAllowUpdate = true;
         else {  
            $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id);
            if (!is_null($oEmployee)) {
               $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
               
               if (count($oEmployeeDepartments) > 0) {
                  foreach($oEmployeeDepartments as $oEmployeeDepartment) {
                     $oMaintenanceFormTaskDepartments = MaintenanceFormTaskDepartments::getMaintenanceFormTaskDepartmentsByIdFormFK($oMaintenanceFormTask->id);
                     if (count($oMaintenanceFormTaskDepartments) > 0) {
                        foreach($oMaintenanceFormTaskDepartments as $oMaintenanceFormTaskDepartment) {
                           if ($oMaintenanceFormTaskDepartment->name == $oEmployeeDepartment->department) $bAllowUpdate = true;
                        }
                     }
                     else $bAllowUpdate = true; 
                  }
               }
            }
            
            $bAllowUpdate = $bAllowUpdate && ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (($oMaintenanceFormTask->admin == 0) || (($oMaintenanceFormTask->admin == 1) && ($oMaintenanceFormTask->data_completed == 1))) && ($oMaintenanceFormTask->status != FModulePlantMaintenanceManagement::STATUS_FINALIZED));   
         }
      }
      
      return $bAllowUpdate;
   }
   public static function allowDeleteMaintenanceFormTask($nIdForm) { 
      $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($nIdForm);
      
      if (!is_null($oMaintenanceFormTask)) {
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && ($oMaintenanceFormTask->admin == 0) && ($oMaintenanceFormTask->id_user == Yii::app()->user->id) && ($oMaintenanceFormTask->status != FModulePlantMaintenanceManagement::STATUS_FINALIZED)));
      }
      
      return false;
   }
   public static function allowUpdateMaintenanceFormDailyEvent($nIdForm) {
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEvent($nIdForm);
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if (!is_null($oMaintenanceFormDailyEvent)) {
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && ($sCurrentUser == $oMaintenanceFormDailyEvent->owner)));
      }
      
      return false;
   }
   public static function allowDeleteMaintenanceFormDailyEvent($nIdForm) {
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::getMaintenanceFormDailyEvent($nIdForm);
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if (!is_null($oMaintenanceFormDailyEvent)) {
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && ($sCurrentUser == $oMaintenanceFormDailyEvent->owner)));
      }
      
      return false;
   }
   
   public static function getDepartments() {
      $oArrayDepartments = array();
      
      $oDepartments = MaintenanceDepartments::getMaintenanceDepartments();
      foreach($oDepartments as $oDepartment) {
         $oArrayDepartments = array_merge($oArrayDepartments, array($oDepartment->name=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oDepartment->name)));         
      }
      
      return $oArrayDepartments;
   }
   
   public static function getDepartmentsByIdUser($idUser) {
      $oValidDepartments = array();
      
      $oEmployee = Users::getEmployeeByIdUser($idUser);
      if (!is_null($oEmployee)) {
         $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
         
         if (count($oEmployeeDepartments) > 0) {  
            foreach($oEmployeeDepartments as $oEmployeeDepartment) {
               $oDepartments = FModulePlantMaintenanceManagement::getDepartments();
               while (current($oDepartments)) {
                  if (key($oDepartments) == $oEmployeeDepartment->department) {
                     $oValidDepartments[key($oDepartments)] = current($oDepartments);
                  }
                  next($oDepartments);
               } 
            }
         }   
      }
      
      return $oValidDepartments; 
   }
}
?>