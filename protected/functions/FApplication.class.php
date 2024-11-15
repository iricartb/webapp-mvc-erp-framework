<?php      
class FApplication {
   const SYSTEM_UNIX = 'UNIX';
   const SYSTEM_APPLE = 'APPLE';
   const SYSTEM_WINDOWS = 'WINDOWS'; 
   
   const LANGUAGE_ES = 'ES';
   const LANGUAGE_CA = 'CA';
   
   const TYPE_TURN_MORNING = '1-MORNING';
   const TYPE_TURN_AFTERNOON = '2-AFTERNOON';
   const TYPE_TURN_NIGHT = '3-NIGHT';
   
   const TYPE_HIGHCHART_GRAPHIC_CAKE = 'CAKE';
   const TYPE_HIGHCHART_GRAPHIC_SEMICIRCLE = 'SEMICIRCLE';
   const TYPE_HIGHCHART_GRAPHIC_COLUMNS = 'COLUMNS';
   const TYPE_HIGHCHART_GRAPHIC_BARS = 'BARS';
   
   const FOLDER_IMAGES_APPLICATION_BUSINESS = 'images/rainbow/business/';
   const FOLDER_IMAGES_APPLICATION_EMPLOYEES = 'images/rainbow/employees/';
   const FOLDER_IMAGES_APPLICATION_EVENTS = 'images/rainbow/events/';
   const FOLDER_IMAGES_APPLICATION_SCENE = 'images/rainbow/scene/';
   const FOLDER_IMAGES_APPLICATION_ZONES = 'images/rainbow/zones/';
   const FOLDER_IMAGES_APPLICATION_REGIONS = 'images/rainbow/regions/';
   const FOLDER_IMAGES_APPLICATION_EQUIPMENTS = 'images/rainbow/equipments/';
   const FOLDER_IMAGES_APPLICATION_SITE = 'images/site/';
   const FOLDER_IMAGES_APPLICATION_FRONTEND = 'images/frontend/';
   const FOLDER_IMAGES_GENERIC_16x16 = 'images/generic/16x16/';
   const FOLDER_IMAGES_GENERIC_24x24 = 'images/generic/24x24/';
   const FOLDER_IMAGES_GENERIC_48x48 = 'images/generic/48x48/';
   const FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES = 'images/frontend/module_warehouse_management/articles/';
      
   const FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT = 'documents/frontend/module_purchases_management/';
   
   const FOLDER_PROTECTED_DOCUMENTS_APPLICATION_EQUIPMENTS = 'protected/documents/rainbow/equipments/';
   const FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_SCHEDULEDTASKS = 'protected/documents/frontend/module_plant_maintenance_management/scheduled_tasks/';
   const FOLDER_PROTECTED_DOCUMENTS_MODULE_PLANT_MAINTENANCE_TASKS = 'protected/documents/frontend/module_plant_maintenance_management/tasks/';
   const FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS = 'protected/documents/frontend/module_purchases_management/offers/';
   const FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS = 'protected/documents/frontend/module_purchases_management/orders/';
   const FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES = 'protected/documents/frontend/module_purchases_management/deliveries/';
   
   const LAYOUT_SITE = '//layouts/site';
   const LAYOUT_BACKEND = '//layouts/backend';
   const LAYOUT_FRONTEND = '//layouts/frontend';
   const LAYOUT_ERROR = '//layouts/error';
   const LAYOUT_POPUP = '//layouts/popup';
   const LAYOUT_POPUP_SIMPLE = '//layouts/popup_simple';
     
   const ROLE_MASTER = 'MASTER';
   const ROLE_ADMIN = 'ADMIN';
   const ROLE_USER = 'USER';
    
   const ROLE_MODULE_ADMIN = 'ADMIN';
   const ROLE_MODULE_USER = 'USER';
   const ROLE_MODULE_RESTRICTED_USER = 'RESTRICTED_USER';
   
   const EMPLOYEE_BUSINESS = 'BUSINESS';
   const EMPLOYEE_SUBCONTRACT = 'SUBCONTRACT';
   const EMPLOYEE_EXTERNAL = 'EXTERNAL';  
   const EMPLOYEE_ACCESS_CODE_NULL = 'ACCESS_CODE_NULL';
   const EMPLOYEE_ACCESS_CODE_NOT_NULL = 'ACCESS_CODE_NOT_NULL';
   const EMPLOYEE_INSIDE_YES = 'INSIDE_YES';
   const EMPLOYEE_INSIDE_NO = 'INSIDE_NO';
  
   const EMPLOYEE_RESPONSABILITY_MANAGER = 'MANAGER';
   const EMPLOYEE_RESPONSABILITY_DIRECTOR = 'DIRECTOR';
   const EMPLOYEE_RESPONSABILITY_BOSS = 'BOSS';
   const EMPLOYEE_RESPONSABILITY_ADMINISTRATOR = 'ADMINISTRATOR';
   const EMPLOYEE_RESPONSABILITY_TECHNICAL = 'TECHNICAL';
   const EMPLOYEE_RESPONSABILITY_RESPONSIBLE = 'RESPONSIBLE';
   const EMPLOYEE_RESPONSABILITY_AUXILIAR = 'AUXILIAR';
   
   const EMPLOYEE_DEPARTMENT_MANAGEMENT = 'MANAGEMENT';
   const EMPLOYEE_DEPARTMENT_ADMINISTRATION = 'ADMINISTRATION';
   const EMPLOYEE_DEPARTMENT_MECHANICAL = 'MECHANICAL';
   const EMPLOYEE_DEPARTMENT_ELECTRIC = 'ELECTRIC';
   const EMPLOYEE_DEPARTMENT_AGRICULTURE = 'AGRICULTURE';
   const EMPLOYEE_DEPARTMENT_GENERAL = 'GENERAL';
   const EMPLOYEE_DEPARTMENT_DEFENSE = 'DEFENSE';
   const EMPLOYEE_DEPARTMENT_SECURITY = 'SECURITY';
   const EMPLOYEE_DEPARTMENT_IT = 'IT';
   const EMPLOYEE_DEPARTMENT_TECHNICAL_DIRECTOR = 'TECHNICAL_DIRECTOR';
   const EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE = 'TECHNICAL_OFFICE';
   const EMPLOYEE_DEPARTMENT_PURCHASING = 'PURCHASING';
   const EMPLOYEE_DEPARTMENT_MARKETING = 'MARKETING';
   const EMPLOYEE_DEPARTMENT_COMMERCIAL = 'COMMERCIAL';
   const EMPLOYEE_DEPARTMENT_MAINTENANCE = 'MAINTENANCE';
   const EMPLOYEE_DEPARTMENT_ENGINEERING = 'ENGINEERING';
   const EMPLOYEE_DEPARTMENT_INVENTORY = 'INVENTORY';
   const EMPLOYEE_DEPARTMENT_OPERATING = 'OPERATING';
   const EMPLOYEE_DEPARTMENT_OPERATING_TURN = 'OPERATING_TURN';
   const EMPLOYEE_DEPARTMENT_RRHH = 'RRHH';
   const EMPLOYEE_DEPARTMENT_DESIGN = 'DESIGN';
   const EMPLOYEE_DEPARTMENT_SYSTEM = 'SYSTEM';
   const EMPLOYEE_DEPARTMENT_QUALITY = 'QUALITY';
   const EMPLOYEE_DEPARTMENT_ACCOUNTING = 'ACCOUNTING';
   const EMPLOYEE_DEPARTMENT_FINANCE = 'FINANCE';
   const EMPLOYEE_DEPARTMENT_CIVIL_LAW = 'CIVIL_LAW';
   const EMPLOYEE_DEPARTMENT_EDUCATION = 'EDUCATION';
   const EMPLOYEE_DEPARTMENT_PHYSIC = 'PHYSIC';
   const EMPLOYEE_DEPARTMENT_CHEMISTRY = 'CHEMISTRY';
   const EMPLOYEE_DEPARTMENT_GEOLOGY = 'GEOLOGY';
   const EMPLOYEE_DEPARTMENT_GEOMETRY = 'GEOMETRY';
   const EMPLOYEE_DEPARTMENT_HOMICIDE = 'HOMICIDE';
   const EMPLOYEE_DEPARTMENT_HISTORY = 'HISTORY';
   const EMPLOYEE_DEPARTMENT_IMMIGRATION = 'IMMIGRATION';
   const EMPLOYEE_DEPARTMENT_INDUSTRY = 'INDUSTRY';
   const EMPLOYEE_DEPARTMENT_JUSTICE = 'JUSTICE';
   const EMPLOYEE_DEPARTMENT_LOGISTIC = 'LOGISTIC';
   const EMPLOYEE_DEPARTMENT_LANGUAGE = 'LANGUAGE';
   const EMPLOYEE_DEPARTMENT_MATHEMATIC = 'MATHEMATIC';
   const EMPLOYEE_DEPARTMENT_OPERATION = 'OPERATION';
   const EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY = 'PREVENTION_SECURITY';
   const EMPLOYEE_DEPARTMENT_CLAIM = 'CLAIM';
   const EMPLOYEE_DEPARTMENT_HEALTH = 'HEALTH';
   const EMPLOYEE_DEPARTMENT_TREASURY = 'TREASURY';
   const EMPLOYEE_DEPARTMENT_I_D = 'I+D';
   const EMPLOYEE_DEPARTMENT_TECHNOLOGY = 'TECHNOLOGY';
   const EMPLOYEE_DEPARTMENT_WAREHOUSE = 'WAREHOUSE';
   const EMPLOYEE_DEPARTMENT_OTHERS = 'OTHERS';
  
   const EMPLOYEE_MAX_TOLERANCE = 30;
  
   const MODULE_VISITORS_MANAGEMENT = 'MODULE_VISITORS_MANAGEMENT';
   const MODULE_ACCESS_CONTROL_MANAGEMENT = 'MODULE_ACCESS_CONTROL_MANAGEMENT';
   const MODULE_WORKING_PARTS_MANAGEMENT = 'MODULE_WORKING_PARTS_MANAGEMENT';
   const MODULE_DIGITAL_DIARY_MANAGEMENT = 'MODULE_DIGITAL_DIARY_MANAGEMENT';
   const MODULE_PLANT_MAINTENANCE_MANAGEMENT = 'MODULE_PLANT_MAINTENANCE_MANAGEMENT';
   const MODULE_WAREHOUSE_MANAGEMENT = 'MODULE_WAREHOUSE_MANAGEMENT';
   const MODULE_PLANT_MONITORING_MANAGEMENT = 'MODULE_PLANT_MONITORING_MANAGEMENT';
   const MODULE_PURCHASES_MANAGEMENT = 'MODULE_PURCHASES_MANAGEMENT';
   const MODULE_HELPDESK_MANAGEMENT = 'MODULE_HELPDESK_MANAGEMENT';
   
   const ACCESS_OK = 0;
   const ACCESS_ERR_USERNAME_OR_PASSWD = -1;
   const ACCESS_ERR_NO_MODULES_AVALIABLES = -2;
   const ACCESS_ERR_NO_MODULES_AVALIABLES_OR_ASSIGNED = -3;
   
   const GRID_MAX_ITEMS_PER_PAGE_SMALL = 10;
   const GRID_MAX_ITEMS_PER_PAGE_MEDIUM = 25;
   const GRID_MAX_ITEMS_PER_PAGE_BIG = 50;
   const GRID_MAX_ITEMS_PER_PAGE_MORE_BIG = 100;
   
   const STATISTIC_MAX_ITEMS = 10;
   
   const CALENDAR_MIN_YEAR = 1902;
   const CALENDAR_MAX_YEAR = 9999;
   
   const FORM_COMBOBOX_MAX_YEARS = 5;
   
   const FORM_ACTION_SAVE = 'FORM_ACTION_SAVE';
   const FORM_ACTION_MODIFY = 'FORM_ACTION_MODIFY';
   const FORM_ACTION_DELETE = 'FORM_ACTION_DELETE';
   const FORM_ACTION_PRINT = 'FORM_ACTION_PRINT';
   const FORM_ACTION_COPY_PASTE = 'FORM_ACTION_COPY_PASTE';
   const FORM_ACTION_COPY_PASTE_CHRONOGRAM = 'FORM_ACTION_COPY_PASTE_CHRONOGRAM';
   
   const FILE_EXPORT_EXCEL = 'Excel5';

   const DETAIL_INFORMATION_SUMMARY = 'DETAIL_INFORMATION_SUMMARY';
   const DETAIL_INFORMATION_DETAILED = 'DETAIL_INFORMATION_DETAILED';
   const DETAIL_INFORMATION_VERY_DETAILED = 'DETAIL_INFORMATION_VERY_DETAILED';
    
   const ACCURACY_MINUTES = 'ACCURACY_MINUTES';
   const ACCURACY_SECONDS = 'ACCURACY_SECONDS';
   
   const EQUIPMENT_OTHERS = -1;
   
   public static function canUpdateDeleteZoneRegionEquipment($nIdZone = null, $nIdZoneRegion = null, $nIdRegion = null, $nIdRegionEquipment = null, $nIdEquipment = null, $sModule) {
      $bCanDelete = false;
      
      if (!FString::isNullOrEmpty($nIdZone)) {
         $oZone = Zones::getZone($nIdZone);
         $bCanDelete = (((!is_null($oZone)) && ($oZone->module == $sModule)));
      }
      else if (!FString::isNullOrEmpty($nIdZoneRegion)) { 
         $oZoneRegion = ZonesRegions::getZoneRegion($nIdZoneRegion);
         $bCanDelete = (((!is_null($oZoneRegion)) && ($oZoneRegion->module == $sModule)));      
      }
      else if (!FString::isNullOrEmpty($nIdRegion)) { 
         $oRegion = Regions::getRegion($nIdRegion);
         $bCanDelete = (((!is_null($oRegion)) && ($oRegion->module == $sModule)));      
      }
      else if (!FString::isNullOrEmpty($nIdRegionEquipment)) { 
         $oRegionEquipment = RegionsEquipments::getRegionEquipment($nIdRegionEquipment);
         $bCanDelete = (((!is_null($oRegionEquipment)) && ($oRegionEquipment->module == $sModule)));      
      }
      else if (!FString::isNullOrEmpty($nIdEquipment)) { 
         $oEquipment = Equipments::getEquipment($nIdEquipment);
         $bCanDelete = (((!is_null($oEquipment)) && ($oEquipment->module == $sModule)));      
      }

      return $bCanDelete;
   }
   
   public static function canUpdateDeleteProvider($nIdProvider, $sModule) {
      $bCanDelete = false;
      
      $oProvider = Providers::getProvider($nIdProvider);
      $bCanDelete = (((!is_null($oProvider)) && ($oProvider->module == $sModule)));
      
      return $bCanDelete;
   }
}
?>