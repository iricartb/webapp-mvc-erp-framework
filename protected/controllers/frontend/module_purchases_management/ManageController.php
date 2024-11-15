<?php

class ManageController extends FrontendController {
    
   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
       return array( 
           array('allow', // allow admin user to perform actions
               'actions'=>array('viewRangePrices'),
               'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)))',
           ),
           array('deny',  // deny all users                                
               'users'=>array('*'),
           ),
       );
   }
   
   
   public function actionViewRangePrices() {
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      if (!is_null($oPurchasesModuleParameters)) {
         if (isset($_POST['PurchasesModuleParameters'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('purchases-module-parameters-form', $oPurchasesModuleParameters);
         
            $oPurchasesModuleParameters->range_price_without_authorization = $_POST['PurchasesModuleParameters']['range_price_without_authorization'];
            $oPurchasesModuleParameters->range_price_provider_year = $_POST['PurchasesModuleParameters']['range_price_provider_year'];
            $oPurchasesModuleParameters->range_price_three_offers = $_POST['PurchasesModuleParameters']['range_price_three_offers'];
            $oPurchasesModuleParameters->range_price_tendering = $_POST['PurchasesModuleParameters']['range_price_tendering'];
                        
            if ($oPurchasesModuleParameters->range_price_three_offers < $oPurchasesModuleParameters->range_price_tendering) {                                 
               $oPurchasesModuleParameters->save();
               
               $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
               FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWRANGEPRICES_FORM_RANGE_PRICES_SUCCESS'));   
            }
            else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWRANGEPRICES_FORM_ERROR_RANGE_PRICES'));  
         }

         $this->render('viewRangePrices', array('oModelForm'=>$oPurchasesModuleParameters));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));        
   }
}