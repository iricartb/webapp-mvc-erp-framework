<?php      
class FModuleAccessControlManagement {     
   const TYPE_TIMETABLE_CONTINUOUS = 'CONTINUOUS';
   const TYPE_TIMETABLE_SHIFT = 'SHIFT';
   const TIMETABLE_MAX_TOLERANCE = 30;
   
   const TYPE_CHRONOGRAM_HOLIDAY = 'HOLIDAY';
   const TYPE_CHRONOGRAM_PAUSE = 'PAUSE';
   const TYPE_CHRONOGRAM_VACATION = 'VACATION';
   const TYPE_CHRONOGRAM_WORKING = 'WORKING';
   const TYPE_CHRONOGRAM_ABSENCE_PERSONAL = 'ABSENCE_PERSONAL';
   const TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY = 'ABSENCE_TEMPORARY_DISABILITY';
   const TYPE_CHRONOGRAM_ABSENCE_PERMISSION = 'ABSENCE_PERMISSION';
   const TYPE_CHRONOGRAM_ABSENCE_LEAVE = 'ABSENCE_LEAVE';
    
   const TYPE_ACCESS_CODE_CARD = 0;
   const TYPE_ACCESS_CODE_FINGERPRINT = 1;
   
   const TYPE_MAIN_INPUT = 0;
   const TYPE_MAIN_OUTPUT = 1;
   const TYPE_INPUT = 2;
   const TYPE_OUTPUT = 3;
   const TYPE_INPUT_OUTPUT = 4;
   
   const TYPE_SYNCHRONIZE_ENROLL = 'ENROLL';
   const TYPE_SYNCHRONIZE_DISENROLL = 'DISENROLL';
   
   const CHRONOGRAM_COLOR_HOLIDAY = '#FFF6D6';
   const CHRONOGRAM_COLOR_VACATION = '#D6FFD6';
   const CHRONOGRAM_COLOR_WORKING = '#FFD6D6';
   const CHRONOGRAM_COLOR_PAUSE = '#D6FFD6';
   const CHRONOGRAM_COLOR_ABSENCE_PERSONAL = '#DCDCDC';
   const CHRONOGRAM_COLOR_ABSENCE_TEMPORARY_DISABILITY = '#DCDCDC';
   const CHRONOGRAM_COLOR_ABSENCE_PERMISSION = '#DCDCDC';
   const CHRONOGRAM_COLOR_ABSENCE_LEAVE = '#DCDCDC';
   
   const CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT = 'INPUT';
   const CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT = 'OUTPUT';
   const CHRONOGRAM_CHECKIN_ALGORITHM_DISCART_CHECKIN_SECONDS = 30;
   const CHRONOGRAM_CHECKIN_ALGORITHM_DISCART_CHECKIN_MANUAL_SECONDS = 30;
   const CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME = '6:00';
   const CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME = '22:00';
   
   const CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE = 'CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE';
   const CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MANUAL = 'CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MANUAL';
    
   const REPORT_CHECKINCHRONOGRAM_COLOR_HOLIDAY_PAUSE = 'D6FFD6';
   const REPORT_CHECKINCHRONOGRAM_COLOR_ABSENCE = 'EDEDED';
   const REPORT_CHECKINCHRONOGRAM_COLOR_WORKING = 'FFE3C8';
   const REPORT_CHECKINCHRONOGRAM_NOT_CHECKIN = '--';
   const REPORT_CHECKINCHRONOGRAM_PREVIOUS_DAY = '<<';
   const REPORT_CHECKINCHRONOGRAM_NEXT_DAY = '>>';
   
   const STATUS_DEVICE_ONLINE = 'STATUS_ONLINE';
   const STATUS_DEVICE_OFFLINE = 'STATUS_OFFLINE';
   const STATUS_DEVICE_DISABLED = 'STATUS_DISABLED';
   
   const BIOSTAR_START_ID_VISIT = 1;
   const BIOSTAR_END_ID_VISIT = 1000;
   const BIOSTAR_START_ID_EMPLOYEE = 1001;
   const BIOSTAR_END_ID_EMPLOYEE = 15000;
   
   public static function getDayHours($sTime1, $sTime2, $sTimeDayPattern, $sTimeNightPattern) {
      if ((FDate::isDateMajor($sTime1, $sTimeDayPattern)) && (FDate::isDateMinor($sTime1, $sTimeNightPattern)) && (FDate::isDateMajor($sTime2, $sTimeDayPattern)) && (FDate::isDateMinor($sTime2, $sTimeNightPattern))) {
         return FDate::getDiffMinutes($sTime1, $sTime2);   
      } 
      else if ((FDate::isDateMajor($sTime1, $sTimeDayPattern)) && (FDate::isDateMinor($sTime1, $sTimeNightPattern))) return FDate::getDiffMinutes($sTime1, $sTimeNightPattern); 
      else if ((FDate::isDateMajor($sTime2, $sTimeDayPattern)) && (FDate::isDateMinor($sTime2, $sTimeNightPattern))) return FDate::getDiffMinutes($sTime2, $sTimeDayPattern); 
      else return 0;
   }
   
   // ---------------------------- COMMAND SET TIME ----------------------------
   public static function commandDateTime() {
      $bResultCommand = true;
      
      $oAccessControlDevices = AccessControlDevices::getAccessControlDevices();
      foreach($oAccessControlDevices as $oAccessControlDevice) {
         if (!$oAccessControlDevice->disabled) {
            $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandDateTimeByIdDevice($oAccessControlDevice->id);
         }   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'TIME_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
   public static function commandDateTimeByIdDevice($nIdDevice) {
      $bResultCommand = false;
      $oAccessControlDevice = null;
      
      try {
         $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdDevice);
         
         if (!is_null($oAccessControlDevice)) {
            $sDateTime = '\"' . date('Y-m-d H:i:s') . '\"';
            
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 BioStarTime ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $sDateTime);
            
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
               
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'TIME_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlDevice->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'TIME_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdDevice)));
         
         return false; 
      }
   }
   
   // --------------------------- COMMAND OPEN DOORS ---------------------------
   public static function commandOpenDoors() {
      $bResultCommand = true;
      
      $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
      foreach($oAccessControlControllers as $oAccessControlController) {
         $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandOpenDoorsByIdController($oAccessControlController->id);   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'OPENDOORS_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
    public static function commandOpenDoorsByIdController($nIdController) {
      $bResultCommand = false;
      $oAccessControlController = null;
      
      try {
         $oAccessControlController = AccessControlControllers::getAccessControlController($nIdController);
         
         if (!is_null($oAccessControlController)) {
            $oAccessControllerMAC = explode(':', $oAccessControlController->mac);
                  
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 EWSOpenDoors ' . $oAccessControlController->ipv4 . ' 4001 ' . hexdec($oAccessControllerMAC[3]) . ' ' .  hexdec($oAccessControllerMAC[4]) . ' ' .  hexdec($oAccessControllerMAC[5]));
               
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
                   
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'OPENDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlController->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'OPENDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdController)));
         
         return false; 
      }
   }
   
   // --------------------------- COMMAND LOCK DOORS ---------------------------
   public static function commandLockDoors() {
      $bResultCommand = true;
      
      $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
      foreach($oAccessControlControllers as $oAccessControlController) {
         $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandLockDoorsByIdController($oAccessControlController->id);   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'LOCKDOORS_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
    public static function commandLockDoorsByIdController($nIdController) {
      $bResultCommand = false;
      $oAccessControlController = null;
      
      try {
         $oAccessControlController = AccessControlControllers::getAccessControlController($nIdController);
         
         if (!is_null($oAccessControlController)) {
            $oAccessControllerMAC = explode(':', $oAccessControlController->mac);
            
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 EWSLockDoors ' . $oAccessControlController->ipv4 . ' 4001 ' . hexdec($oAccessControllerMAC[3]) . ' ' .  hexdec($oAccessControllerMAC[4]) . ' ' .  hexdec($oAccessControllerMAC[5]));
               
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
                   
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'LOCKDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlController->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'LOCKDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdController)));
         
         return false; 
      }
   }
   
   // -------------------------- COMMAND UNLOCK DOORS --------------------------
   public static function commandUnlockDoors() {
      $bResultCommand = true;
      
      $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
      foreach($oAccessControlControllers as $oAccessControlController) {
         $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandUnlockDoorsByIdController($oAccessControlController->id);   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNLOCKDOORS_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
    public static function commandUnlockDoorsByIdController($nIdController) {
      $bResultCommand = false;
      $oAccessControlController = null;
      
      try {
         $oAccessControlController = AccessControlControllers::getAccessControlController($nIdController);
         
         if (!is_null($oAccessControlController)) {
            $oAccessControllerMAC = explode(':', $oAccessControlController->mac);
            
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 EWSUnlockDoors ' . $oAccessControlController->ipv4 . ' 4001 ' . hexdec($oAccessControllerMAC[3]) . ' ' .  hexdec($oAccessControllerMAC[4]) . ' ' .  hexdec($oAccessControllerMAC[5]));
            
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
               
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNLOCKDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlController->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNLOCKDOORS_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdController)));
         
         return false; 
      }
   }
   
   // ---------------------------- COMMAND FREE OUT ----------------------------
   public static function commandFreeOut() {
      $bResultCommand = true;
      
      $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
      foreach($oAccessControlControllers as $oAccessControlController) {
         $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandFreeOutByIdController($oAccessControlController->id);   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'FREEOUT_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
    public static function commandFreeOutByIdController($nIdController) {
      $bResultCommand = false;
      $oAccessControlController = null;
      
      try {
         $oAccessControlController = AccessControlControllers::getAccessControlController($nIdController);
         
         if (!is_null($oAccessControlController)) {
            $oAccessControllerMAC = explode(':', $oAccessControlController->mac);
                  
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 EWSFreeOut ' . $oAccessControlController->ipv4 . ' 4001 ' . hexdec($oAccessControllerMAC[3]) . ' ' .  hexdec($oAccessControllerMAC[4]) . ' ' .  hexdec($oAccessControllerMAC[5]));
               
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
                   
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'FREEOUT_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlController->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'FREEOUT_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdController)));
         
         return false; 
      }
   }
   
   // --------------------------- COMMAND UNFREE OUT ---------------------------
   public static function commandUnfreeOut() {
      $bResultCommand = true;
      
      $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
      foreach($oAccessControlControllers as $oAccessControlController) {
         $bResultCommand = $bResultCommand && FModuleAccessControlManagement::commandUnfreeOutByIdController($oAccessControlController->id);   
      }
      
      if ($bResultCommand) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNFREEOUT_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultCommand;      
   }
   
    public static function commandUnfreeOutByIdController($nIdController) {
      $bResultCommand = false;
      $oAccessControlController = null;
      
      try {
         $oAccessControlController = AccessControlControllers::getAccessControlController($nIdController);
         
         if (!is_null($oAccessControlController)) {
            $oAccessControllerMAC = explode(':', $oAccessControlController->mac);
                  
            $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 EWSUnfreeOut ' . $oAccessControlController->ipv4 . ' 4001 ' . hexdec($oAccessControllerMAC[3]) . ' ' .  hexdec($oAccessControllerMAC[4]) . ' ' .  hexdec($oAccessControllerMAC[5]));
               
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultCommand = true; 
                   
            if (!$bResultCommand) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNFREEOUT_SYNCHRONIZATION_ERROR', array('{1}'=>$oAccessControlController->name, '{2}'=>$sCommandOutput)));    
         }
         
         return $bResultCommand;  
      } catch(Exception $e) {
         FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'UNFREEOUT_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdController)));
         
         return false; 
      }
   }
     
   // --------------------------- COMMAND ENROLL USER --------------------------
   public static function enrollEmployeesByIdGroupDeviceAndIdDevice($nIdGroupDevice, $nIdDevice, $bShowSuccess = true) {
      $bResultEnroll = true;
      
      $oEmployees = Employees::getEmployeesByIdGroupDevice($nIdGroupDevice); 
      foreach($oEmployees as $oEmployee) {
         $bResultEnroll = $bResultEnroll && FModuleAccessControlManagement::enrollEmployeeByIdEmployeeAndIdDevice($oEmployee->id, $nIdDevice);   
      }
      
      if ($bResultEnroll) {
         if ($bShowSuccess) FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultEnroll;
   }
   
   public static function enrollEmployeeByIdGroupDeviceAndIdEmployee($nIdGroupDevice, $nIdEmployee, $bShowSuccess = true) {
      $bResultEnroll = true;
      
      $oEmployee = Employees::getEmployee($nIdEmployee);
      if (!is_null($oEmployee)) {
         $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::getAccessControlDevicesGroupsDevicesByIdGroupDevice($nIdGroupDevice);
         foreach($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
            $bResultEnroll = $bResultEnroll && FModuleAccessControlManagement::enrollEmployeeByIdEmployeeAndIdDevice($oEmployee->id, $oAccessControlDeviceGroupDevice->id_device);       
         }
      }
      
      if ($bResultEnroll) {
         if ($bShowSuccess) FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultEnroll;
   }
   
   public static function enrollEmployeeByIdEmployeeAndIdDevice($nIdEmployee, $nIdDevice) {
      $bResultEnroll = false;
      $oEmployee = null;
      $oAccessControlDevice = null;
      
      try {
         $oEmployee = Employees::getEmployee($nIdEmployee);
         $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdDevice);
         
         if ((!is_null($oEmployee)) && (!is_null($oAccessControlDevice))) {
            if (!$oAccessControlDevice->disabled) {
               $sAccessCodeCardId = '\"\"';
               $sAccessCodeCardCustomId = '\"\"';
               $sAccessCodeFIR = '\"\"';
               $sAccessCodeFIR2 = '\"\"';
               
               if (!FString::isNullOrEmpty($oEmployee->access_code)) {
                  $sAccessCodeCardId = $oEmployee->access_code;
                  $sAccessCodeCardCustomId = '0';
               }
               
               if (!FString::isNullOrEmpty($oEmployee->access_code_FIR)) {
                  $sAccessCodeFIR = $oEmployee->access_code_FIR;
                  
                  if (!FString::isNullOrEmpty($oEmployee->access_code_FIR_2)) {
                     $sAccessCodeFIR2 = $oEmployee->access_code_FIR_2;
                  }
               }

               $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 BioStarEnroll ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $oEmployee->id_biostar . ' ' . $sAccessCodeCardId . ' ' . $sAccessCodeCardCustomId . ' ' . $sAccessCodeFIR . ' ' . $sAccessCodeFIR2);
               
               if (strpos($sCommandOutput, 'SUCCESS')) $bResultEnroll = true; 

			   if (!$bResultEnroll) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oEmployee->full_name, '{2}'=>$oAccessControlDevice->name, '{3}'=>$sCommandOutput)));    
            }
            else $bResultEnroll = true;
         }
         
         return $bResultEnroll;  
      } catch(Exception $e) {
         if ((!is_null($oEmployee)) && (!is_null($oAccessControlDevice))) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oEmployee->full_name, '{2}'=>$oAccessControlDevice->name)));
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdEmployee, '{2}'=>$nIdDevice)));
         
         return false; 
      }
   }
   
   // ------------------------- COMMAND DISENROLL USER -------------------------
   public static function disenrollEmployeesByIdGroupDeviceAndIdDevice($nIdGroupDevice, $nIdDevice, $bShowSuccess = true) {
      $bResultDisenroll = true;
      
      $oEmployees = Employees::getEmployeesByIdGroupDevice($nIdGroupDevice); 
      foreach($oEmployees as $oEmployee) {
         $bResultDisenroll = $bResultDisenroll && FModuleAccessControlManagement::disenrollEmployeeByIdEmployeeAndIdDevice($oEmployee->id, $nIdDevice);   
      }
     
      if ($bResultDisenroll) {
         if ($bShowSuccess) FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_SUCCESS'));   
      }
       
      return $bResultDisenroll;
   }
   
   public static function disenrollEmployeeByIdGroupDeviceAndIdEmployee($nIdGroupDevice, $nIdEmployee, $bShowSuccess = true) {
      $bResultDisenroll = true;
      
      $oEmployee = Employees::getEmployee($nIdEmployee);
      if (!is_null($oEmployee)) {
         $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::getAccessControlDevicesGroupsDevicesByIdGroupDevice($nIdGroupDevice);
         foreach($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
            $bResultDisenroll = $bResultDisenroll && FModuleAccessControlManagement::disenrollEmployeeByIdEmployeeAndIdDevice($oEmployee->id, $oAccessControlDeviceGroupDevice->id_device);       
         }
      }
      
      if ($bResultDisenroll) {
         if ($bShowSuccess) FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_SUCCESS'));   
      }
         
      return $bResultDisenroll;
   }
   
   public static function disenrollEmployeeByIdEmployeeAndIdDevice($nIdEmployee, $nIdDevice) {
      $bResultDisenroll = false;
      $oEmployee = null;
      $oAccessControlDevice = null;
      
      try {
         $oEmployee = Employees::getEmployee($nIdEmployee);
         $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdDevice);
         
         if ((!is_null($oEmployee)) && (!is_null($oAccessControlDevice))) {
            if (!$oAccessControlDevice->disabled) {
               $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 BioStarDisenroll ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $oEmployee->id_biostar);
               
               if (strpos($sCommandOutput, 'SUCCESS')) $bResultDisenroll = true; 
            }
            else $bResultDisenroll = true;
         }
         
         if (!$bResultDisenroll) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oEmployee->full_name, '{2}'=>$oAccessControlDevice->name, '{3}'=>$sCommandOutput)));    
         
         return $bResultDisenroll;  
      } catch(Exception $e) {
         if ((!is_null($oEmployee)) && (!is_null($oAccessControlDevice))) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oEmployee->full_name, '{2}'=>$oAccessControlDevice->name)));
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdEmployee, '{2}'=>$nIdDevice)));
         
         return false; 
      }
   }
   
   // ------------------------------ GET ID BIOSTAR ----------------------------
   public static function getIdBiostarEmployee() {
      $nIdBiostar = null;
      
      $oEmployees = Employees::model()->findAll('id_biostar IS NOT NULL ORDER BY id_biostar ASC');
      if (count($oEmployees) > 0) {
         $i = 0;
         while(($i < count($oEmployees)) && (is_null($nIdBiostar))) {
            $oEmployee = $oEmployees[$i];
            
            if ($oEmployee->id_biostar != (FModuleAccessControlManagement::BIOSTAR_START_ID_EMPLOYEE + $i)) $nIdBiostar = (FModuleAccessControlManagement::BIOSTAR_START_ID_EMPLOYEE + $i);   
            $i++;
         }
         
         if (is_null($nIdBiostar)) {
            $nIdBiostar = (FModuleAccessControlManagement::BIOSTAR_START_ID_EMPLOYEE + $i); 
            
            if ($nIdBiostar > FModuleAccessControlManagement::BIOSTAR_END_ID_EMPLOYEE) $nIdBiostar = null;       
         } 
      }
      else $nIdBiostar = FModuleAccessControlManagement::BIOSTAR_START_ID_EMPLOYEE;
      
      return $nIdBiostar;   
   }
   
   // ------------------------------- SYNCHRONIZE ------------------------------ 
   public static function synchronizeCheckins() {
       $nErrors = 0;
       $oAccessControlDevices = AccessControlDevices::getAccessControlDevices();    
       
       foreach($oAccessControlDevices as $oAccessControlDevice) {
          if (((is_null($oAccessControlDevice->type)) || ((!is_null($oAccessControlDevice->type)) && (($oAccessControlDevice->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) || ($oAccessControlDevice->type == FModuleAccessControlManagement::TYPE_MAIN_OUTPUT)))) && (!$oAccessControlDevice->disabled)) {
             try {
                $oTransaction = null;
                $bError = false;
                $sSyncDate = '\"\"';
                if (!FString::isNullOrEmpty($oAccessControlDevice->sync_date)) $sSyncDate = '\"' . FDate::getEnglishDate($oAccessControlDevice->sync_date) . '\"';
                
                $sCommandOutput = shell_exec('BioStarGatewayClient 192.168.200.1 BioStarQuery ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $sSyncDate);
                if (!(strpos($sCommandOutput, 'ERROR'))) {
                   $bErrorTransaction = false;
                   $sErrorTransactionParameter = '';
                   $oTransaction = Yii::app()->db_rainbow_accesscontrolmanagement->beginTransaction();
                  
                   $oAccessControlDevice->sync_date = date('Y-m-d H:i:s');   
                   if ($oAccessControlDevice->save()) {    
                      if ((strlen($sCommandOutput)) > 0) {
                         $sCommandOutput = rtrim($sCommandOutput, '@');
                         
                         $oCommandOutputLines = explode('@', $sCommandOutput); 
                         foreach($oCommandOutputLines as $sCommandOutputLine) {
                            
                            $oParameters = explode(FString::STRING_SPACE, $sCommandOutputLine);     
                            if (count($oParameters) == 5) {
                               $sParameterDateTime = $oParameters[0] . ' ' . $oParameters[1];
                               $oEmployee = Employees::getEmployeeByIdBiostar((int) $oParameters[2]);
                               
                               if (FDate::isDateTime($sParameterDateTime)) {
                                  if (!is_null($oEmployee)) {
                                     $oAccessControlCheckInMachine = new AccessControlCheckInMachine();
                                     
                                     $oAccessControlCheckInMachine->date = $sParameterDateTime;
                                     
                                     if ($oParameters[3] == '0') $oAccessControlCheckInMachine->employee_type_access_code = FModuleAccessControlManagement::TYPE_ACCESS_CODE_CARD;
                                     else $oAccessControlCheckInMachine->employee_type_access_code = FModuleAccessControlManagement::TYPE_ACCESS_CODE_FINGERPRINT;
                                    
								             if ($oParameters[4] != '65535') $oAccessControlCheckInMachine->incidence_code = $oParameters[4]; 
									                                   
                                     $oAccessControlCheckInMachine->employee_identification = $oEmployee->identification;
                                     $oAccessControlCheckInMachine->id_device = $oAccessControlDevice->id;  
              
                                     if (!is_null($oAccessControlDevice->type)) {
                                        $oAccessControlCheckInMachine->type = $oAccessControlDevice->type;    
                                     }
                                     
                                     $oAccessControlCheckInMachine->save();
                                  }
                               }
                               else {
                                  $sErrorTransactionParameter = 'LINE_INCORRECT_FORMAT';
                                  $bErrorTransaction = true;
                                  $nErrors++;  
                               }      
                            }
                            else {
                               $sErrorTransactionParameter = 'LINE_NUM_PARAMETERS';
                               $bErrorTransaction = true;
                               $nErrors++;   
                            }
                         }   
                      } 
                   }     
                   else {
                      $sErrorTransactionParameter = 'SAVE';
                      $bErrorTransaction = true;
                      $nErrors++;
                   }
                   
                   if (!$bErrorTransaction) { 
                      $oTransaction->commit();  
                   }
                   else {
                      $oTransaction->rollback();
                      
                      if (!$bError) FFlash::addHeaderError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_DEVICE', array('{1}'=>$oAccessControlDevice->name, '{2}'=>$oAccessControlDevice->ipv4))); 
                      FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_TRANSACTION', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_TRANSACTION_PARAMETER_' . $sErrorTransactionParameter))));           
                      $bError = true; 
                   }
                }     
                else { 
                   if (!$bError) FFlash::addHeaderError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_DEVICE', array('{1}'=>$oAccessControlDevice->name, '{2}'=>$oAccessControlDevice->ipv4))); 
                   FFlash::addError($sCommandOutput); 
                   
                   $bError = true; 
                   $nErrors++; 
                }
             } catch(Exception $e) {
                if (!is_null($oTransaction)) $oTransaction->rollback();
                 
                if (!$bError) FFlash::addHeaderError(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_DEVICE', array('{1}'=>$oAccessControlDevice->name, '{2}'=>$oAccessControlDevice->ipv4))); 
                FFlash::addError($e); 
                
                $bError = true; 
                $nErrors++;
             }
          }
       }
       
       if ($nErrors > 0) Yii::app()->user->setFlash('error_header', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_ERROR_HEADER', array('{1}'=>$nErrors)));
       else Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCHECKINCHRONOGRAMS_FORM_SUBMIT_OK_HEADER')); 
   }
}
?>