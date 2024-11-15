<?php      
class FModuleVisitorsManagement {     
   const TYPE_VISIT_VISIT = 'VISIT';
   const TYPE_VISIT_SUBCONTRACT = 'SUBCONTRACT';
   const TYPE_VISIT_PROVIDER = 'PROVIDER';
   const TYPE_VISIT_COMMERCIAL = 'COMMERCIAL';
   const TYPE_VISIT_OTHER = 'OTHER';
   
   const TYPE_PEOPLE_VISIT = 'VISIT';
   const TYPE_PEOPLE_EMPLOYEE = 'EMPLOYEE';
   const TYPE_PEOPLE_VISIT_EMPLOYEE = 'VISIT_EMPLOYEE';
   
   const STATUS_OUTSIDE = 0;
   const STATUS_INSIDE = 1;
   
   const STATISTIC_TYPE_VISIT = 'STATISTIC_TYPE_VISIT';
   const STATISTIC_TYPE_VISITOR = 'STATISTIC_TYPE_VISITOR';
   const STATISTIC_TYPE_BUSINESS = 'STATISTIC_TYPE_BUSINESS';
      
   const STATISTIC_TYPE_PERIOD_DAY = 'STATISTIC_TYPE_PERIOD_DAY';
   const STATISTIC_TYPE_PERIOD_MONTH = 'STATISTIC_TYPE_PERIOD_MONTH';
   const STATISTIC_TYPE_PERIOD_YEAR = 'STATISTIC_TYPE_PERIOD_YEAR';
   
   public static function enrollVisitByIdGroupDeviceAndIdVisit($nIdGroupDevice, $nIdVisit) {
      $bResultEnroll = true;
      
      $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdVisit);
      if (!is_null($oVisitorsVisit)) {
         $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::getAccessControlDevicesGroupsDevicesByIdGroupDevice($nIdGroupDevice);
         foreach($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
            $bResultEnroll = $bResultEnroll && FModuleVisitorsManagement::enrollVisitByIdVisitAndIdDevice($oVisitorsVisit->id, $oAccessControlDeviceGroupDevice->id_device);       
         }
      }
      
      if ($bResultEnroll) {
         FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_SUCCESS'));
      }
      
      return $bResultEnroll;
   }
   
   public static function enrollVisitByIdVisitAndIdDevice($nIdVisit, $nIdDevice) {
      $bResultEnroll = false;
      $oVisitorsVisit = null;
      $oAccessControlDevice = null;
      
      try {
         $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdVisit);
         $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdDevice);
         
         if ((!is_null($oVisitorsVisit)) && (!is_null($oAccessControlDevice))) {
            $sAccessCodeCardId = '""';
            $sAccessCodeCardCustomId = '""';
            $sAccessCodeFIR = '""';
            $sAccessCodeFIR2 = '""';
            
            if (!FString::isNullOrEmpty($oVisitorsVisit->card_code)) {
               $sAccessCodeCardId = $oVisitorsVisit->card_code;
               $sAccessCodeCardCustomId = '0';
            }
             
            $sCommandOutput = shell_exec('C:\wamp\www\WebAppRainbow\protected\components\BioStar\BioStarEnroll ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $oVisitorsVisit->id_biostar . ' ' . $sAccessCodeCardId . ' ' . $sAccessCodeCardCustomId . ' ' . $sAccessCodeFIR . ' ' . $sAccessCodeFIR2);
            
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultEnroll = true; 
               
            if (!$bResultEnroll) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oVisitorsVisit->visitor_full_name, '{2}'=>$oAccessControlDevice->name, '{3}'=>$sCommandOutput)));    
         }
         
         return $bResultEnroll;  
      } catch(Exception $e) {
         if ((!is_null($oVisitorsVisit)) && (!is_null($oAccessControlDevice))) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oVisitorsVisit->visitor_full_name, '{2}'=>$oAccessControlDevice->name)));
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'ENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdVisit, '{2}'=>$nIdDevice)));
         
         return false; 
      }
   }
   
   public static function disenrollVisitByIdGroupDeviceAndIdVisit($nIdGroupDevice, $nIdVisit) {
      $bResultDisenroll = true;
      
      $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdVisit);
      if (!is_null($oVisitorsVisit)) {
         $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::getAccessControlDevicesGroupsDevicesByIdGroupDevice($nIdGroupDevice);
         foreach($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
            $bResultDisenroll = $bResultDisenroll && FModuleVisitorsManagement::disenrollVisitByIdVisitAndIdDevice($oVisitorsVisit->id, $oAccessControlDeviceGroupDevice->id_device);       
         }
      }
      
      if ($bResultDisenroll) {
        FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_SUCCESS'));   
      }
         
      return $bResultDisenroll;
   }
   
   public static function disenrollVisitByIdVisitAndIdDevice($nIdVisit, $nIdDevice) {
      $bResultDisenroll = false;
      $oVisitorsVisit = null;
      $oAccessControlDevice = null;
      
      try {
         $oVisitorsVisit = VisitorsVisits::getVisitorsVisit($nIdVisit);
         $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdDevice);
         
         if ((!is_null($oVisitorsVisit)) && (!is_null($oAccessControlDevice))) {
            $sCommandOutput = shell_exec('C:\wamp\www\WebAppRainbow\protected\components\BioStar\BioStarDisenroll ' . $oAccessControlDevice->ipv4 . ' 1471 ' . $oVisitorsVisit->id_biostar);
            
            if (strpos($sCommandOutput, 'SUCCESS')) $bResultDisenroll = true; 
         }
         
         if (!$bResultDisenroll) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oVisitorsVisit->visitor_full_name, '{2}'=>$oAccessControlDevice->name, '{3}'=>$sCommandOutput)));    
         
         return $bResultDisenroll;  
      } catch(Exception $e) {
         if ((!is_null($oVisitorsVisit)) && (!is_null($oAccessControlDevice))) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$oVisitorsVisit->visitor_full_name, '{2}'=>$oAccessControlDevice->name)));
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'DISENROLL_SYNCHRONIZATION_ERROR', array('{1}'=>$nIdVisit, '{2}'=>$nIdDevice)));
         
         return false; 
      }
   }
   
   public static function getIdBiostarVisit() {
      $nIdBiostar = null;
      
      $oVisitorsVisits = VisitorsVisits::model()->findAll('id_biostar IS NOT NULL ORDER BY id_biostar ASC');
      if (count($oVisitorsVisits) > 0) {
         $i = 0;
         while(($i < count($oVisitorsVisits)) && (is_null($nIdBiostar))) {
            $oVisit = $oVisitorsVisits[$i];
            
            if ($oVisit->id_biostar != (FModuleAccessControlManagement::BIOSTAR_START_ID_VISIT + $i)) $nIdBiostar = (FModuleAccessControlManagement::BIOSTAR_START_ID_VISIT + $i);   
            $i++;
         }
         
         if (is_null($nIdBiostar)) {
            $nIdBiostar = (FModuleAccessControlManagement::BIOSTAR_START_ID_VISIT + $i); 
            
            if ($nIdBiostar > FModuleAccessControlManagement::BIOSTAR_END_ID_VISIT) $nIdBiostar = null;       
         } 
      }
      else $nIdBiostar = FModuleAccessControlManagement::BIOSTAR_START_ID_VISIT;
      
      return $nIdBiostar;   
   }
}
?>