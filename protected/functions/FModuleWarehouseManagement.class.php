<?php      
class FModuleWarehouseManagement {
   const TYPE_INPUT_WAYBILL = 'WAYBILL';
   const TYPE_INPUT_REGULARIZATION = 'REGULARIZATION';
   const TYPE_INPUT_REPAIR = 'REPAIR';
   const TYPE_INPUT_BENEFIT = 'BENEFIT';
   const TYPE_OUTPUT_PLANT = 'PLANT';
   const TYPE_OUTPUT_REGULARIZATION = 'REGULARIZATION';
   const TYPE_OUTPUT_MAINTENANCE = 'MAINTENANCE';
   const TYPE_OUTPUT_DEVOLUTION = 'DEVOLUTION';
   const TYPE_OUTPUT_REPAIR = 'REPAIR';
   const TYPE_OUTPUT_BENEFIT = 'BENEFIT';
   
   const REPORT_TYPE_INPUTS = 'INPUTS';
   const REPORT_TYPE_OUTPUTS = 'OUTPUTS';
   const REPORT_INPUTSOUTPUTS_ORDER_DATE = 'DATE';
   const REPORT_INPUTSOUTPUTS_ORDER_PROVIDER = 'PROVIDER';
   const REPORT_INPUTSOUTPUTS_COLOR_INPUTS = 'D6FFD6';
   const REPORT_INPUTSOUTPUTS_COLOR_OUTPUTS = 'FFE3C8';

   const REPORT_STOCK_ORDER_CODE = 'CODE';
   const REPORT_STOCK_ORDER_DESCRIPTION = 'DESCRIPTION';
   
   const REPORT_INVENTORY_ORDER_CODE = 'CODE';
   const REPORT_INVENTORY_ORDER_DESCRIPTION = 'DESCRIPTION';
   
   const STATUS_SUCCESS = 'SUCCESS';
   const STATUS_ALERT = 'ALERT';
   const STATUS_ERROR = 'ERROR';
   
   const COLOR_GRID_STATUS_SUCCESS = '#88e88f';
   const COLOR_GRID_STATUS_ALERT = '#f4e544';
   const COLOR_GRID_STATUS_ERROR = '#ff4848';
   
   const HISTORICAL_CROSSLINE_DATE = '2018-04-20 10:00:00'; 
   
   public static function allowUpdateWarehouseFormInput($nIdForm) { 
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);

      if (!is_null($oWarehouseFormInput)) {
         if ($oWarehouseFormInput->date >= (FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE)) {                                                                                                                                                                              
            return (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && ($oWarehouseFormInput->id_user == Yii::app()->user->id))));
         }
      }
      
      return false;
   }
   public static function allowDeleteWarehouseFormInput($nIdForm) { 
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      
      if (!is_null($oWarehouseFormInput)) {
         if ($oWarehouseFormInput->date >= (FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE)) {
            return (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && ($oWarehouseFormInput->id_user == Yii::app()->user->id))) && (FDate::getDiffHours($oWarehouseFormInput->date, date('Y-m-d H:i:s')) < (FDate::NUM_HOURS_DAY * 7)));
         }
      }
      
      return false;
   }
   public static function allowUpdateWarehouseFormOutput($nIdForm) { 
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      
      if (!is_null($oWarehouseFormOutput)) {
         if ($oWarehouseFormOutput->date >= (FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE)) {
            return ((((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && ($oWarehouseFormOutput->id_user == Yii::app()->user->id))) && (FDate::getDiffHours($oWarehouseFormOutput->date, date('Y-m-d H:i:s')) < (FDate::NUM_HOURS_DAY * 7))) && ($oWarehouseFormOutput->type != FModuleWarehouseManagement::TYPE_OUTPUT_MAINTENANCE));
         }
      }
      
      return false;
   }
   public static function allowDeleteWarehouseFormOutput($nIdForm) { 
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      
      if (!is_null($oWarehouseFormOutput)) {
         if ($oWarehouseFormOutput->date >= (FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE)) {
            return (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) || ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && ($oWarehouseFormOutput->id_user == Yii::app()->user->id))) && (FDate::getDiffHours($oWarehouseFormOutput->date, date('Y-m-d H:i:s')) < (FDate::NUM_HOURS_DAY * 7)));
         }
      }
      
      return false;
   }
   public static function allowDeleteArticle($nIdForm) { 
      $oArticle = Articles::getArticle($nIdForm);
      
      if (!is_null($oArticle)) {
         $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdArticle($oArticle->id);
         $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdArticle($oArticle->id);
         
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (count($oWarehouseFormInputArticles) == 0) && (count($oWarehouseFormOutputArticles) == 0)); 
      }
      
      return false;
   }
   public static function allowDeleteWarehouseArticleCategory($nIdForm) {
      $oWarehouseArticleCategory = WarehouseArticlesCategories::getWarehouseArticleCategory($nIdForm);
      
      if (!is_null($oWarehouseArticleCategory)) {
         $oWarehouseArticlesSubcategories = WarehouseArticlesSubcategories::getWarehouseArticlesSubcategoriesByIdCategory($oWarehouseArticleCategory->id);
         
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (count($oWarehouseArticlesSubcategories) == 0)); 
      }
      
      return false;  
   }
   public static function allowDeleteWarehouseArticleSubcategory($nIdForm) {
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nIdForm);
      
      if (!is_null($oWarehouseArticleSubcategory)) {
         $oArticles = Articles::getArticlesByIdSubcategory($oWarehouseArticleSubcategory->id);

         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (count($oArticles) == 0));
      }
      
      return false;  
   }
   public static function allowDeleteWarehouseArticleLocationCategory($nIdForm) {
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategory($nIdForm);
      
      if (!is_null($oWarehouseArticleLocationCategory)) {
         $oWarehouseArticlesLocationsSubcategories = WarehouseArticlesLocationsSubcategories::getWarehouseArticlesLocationsSubcategoriesByIdLocationCategory($oWarehouseArticleLocationCategory->id);
         
         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (count($oWarehouseArticlesLocationsSubcategories) == 0)); 
      }
      
      return false;  
   }
   public static function allowDeleteWarehouseArticleLocationSubcategory($nIdForm) {
      $oWarehouseArticleLocationSubcategory = WarehouseArticlesLocationsSubcategories::getWarehouseArticleLocationSubcategory($nIdForm);
      
      if (!is_null($oWarehouseArticleLocationSubcategory)) {
         $oArticles = Articles::getArticlesByIdLocationSubcategory($oWarehouseArticleLocationSubcategory->id);

         return ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (count($oArticles) == 0));
      }
      
      return false;  
   }
   
   public static function recalcWarehouseArticlePriceMedium($nArticleQuantity, $nArticlePrice, $nNewArticleQuantity, $nNewArticlePrice, $bArticleInput = true) {
      if ($bArticleInput) {
         if (($nArticleQuantity + $nNewArticleQuantity) != 0) {
            return round(((($nArticleQuantity * $nArticlePrice) + ($nNewArticleQuantity * $nNewArticlePrice)) / ($nArticleQuantity + $nNewArticleQuantity)), 3);
         }
         else return round((($nArticleQuantity * $nArticlePrice) + ($nNewArticleQuantity * $nNewArticlePrice)), 3);
      }
      else {
         if (($nArticleQuantity - $nNewArticleQuantity) != 0) {
            return round(((($nArticleQuantity * $nArticlePrice) - ($nNewArticleQuantity * $nNewArticlePrice)) / ($nArticleQuantity - $nNewArticleQuantity)), 3);     
         }
         else return round((($nArticleQuantity * $nArticlePrice) - ($nNewArticleQuantity * $nNewArticlePrice)), 3);   
      }
   }
}
?>