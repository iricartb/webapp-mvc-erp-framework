<?php

class MaintenanceController extends FrontendController {
    
   /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewProviders', 'viewFinancialCosts', 'viewContractingProcedures', 'viewDocumentsContractingProcedures', 'viewDetailProvider', 'viewDetailContractingProcedure', 'viewDetailDocumentContractingProcedure', 'viewDetailFinancialCost', 'viewDetailFinancialCostLine', 'updateProvider', 'updateFinancialCost', 'updateFinancialCostLine', 'updateContractingProcedure', 'updateDocumentContractingProcedure', 'deleteProvider', 'deleteFinancialCostLine', 'deleteFinancialCostAccountingAccount', 'deleteContractingProcedure', 'deleteDocumentContractingProcedure', 'synchronizeProvidersFromExternalDB'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)))',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
    
    
   public function actionViewProviders() {
      $oProvider = new Providers();
      $oProviderFilters = new Providers();
      $oProviderFilters->unsetAttributes();
      
      if (isset($_POST['Providers'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('provider-form', $oProvider);
      
         $oProvider->attributes = $_POST['Providers'];
         if (isset($_POST['Providers']['account'])) $oProvider->account = $_POST['Providers']['account'];
         if (isset($_POST['Providers']['mail'])) $oProvider->mail = $_POST['Providers']['mail'];
         
         $oProvider->module = FApplication::MODULE_PURCHASES_MANAGEMENT;
                                                                        
         $oProvider->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['Providers'])) $oProviderFilters->attributes = $_GET['Providers'];   
      }

      $oProvider->unsetAttributes();
      $this->render('viewProviders', array('oModelForm'=>$oProvider, 'oModelFormFilters'=>$oProviderFilters));    
   }
   public function actionViewFinancialCosts() {
      $oPurchasesFinancialCostFilters = new PurchasesFinancialCosts();
      $oPurchasesFinancialCostFilters->unsetAttributes();
      
      // Filters Grid Get Parameters
      if (isset($_GET['PurchasesFinancialCosts'])) $oPurchasesFinancialCostFilters->attributes = $_GET['PurchasesFinancialCosts'];
      
      $this->render('viewFinancialCosts', array('oModelFormFilters'=>$oPurchasesFinancialCostFilters));   
   }
   public function actionViewContractingProcedures() {
      $oPurchasesContractingProcedure = new PurchasesContractingProcedures();
      $oPurchasesContractingProcedureFilters = new PurchasesContractingProcedures();
      $oPurchasesContractingProcedureFilters->unsetAttributes();
      
      if (isset($_POST['PurchasesContractingProcedures'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('purchases-contracting-procedure-form', $oPurchasesContractingProcedure);
      
         $oPurchasesContractingProcedure->attributes = $_POST['PurchasesContractingProcedures'];

         $oPurchasesContractingProcedure->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['PurchasesContractingProcedures'])) $oPurchasesContractingProcedureFilters->attributes = $_GET['PurchasesContractingProcedures'];    
      }

      $oPurchasesContractingProcedure->unsetAttributes();
      
      $this->render('viewContractingProcedures', array('oModelForm'=>$oPurchasesContractingProcedure, 'oModelFormFilters'=>$oPurchasesContractingProcedureFilters));    
   }
   public function actionViewDocumentsContractingProcedures() {
      $oPurchasesDocumentContractingProcedure = new PurchasesDocumentsContractingProcedures();
      $oPurchasesDocumentContractingProcedureFilters = new PurchasesDocumentsContractingProcedures();
      $oPurchasesDocumentContractingProcedureFilters->unsetAttributes();
      
      if (isset($_POST['PurchasesDocumentsContractingProcedures'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('purchases-document-contracting-procedure-form', $oPurchasesDocumentContractingProcedure);
         
         $oPurchasesDocumentContractingProcedure->attributes = $_POST['PurchasesDocumentsContractingProcedures'];

         $oPurchasesDocumentContractingProcedure->save();
      }
      else {
         // Filters Grid Get Parameters
         if (isset($_GET['PurchasesDocumentsContractingProcedures'])) $oPurchasesDocumentContractingProcedureFilters->attributes = $_GET['PurchasesDocumentsContractingProcedures'];   
      }   

      $oPurchasesDocumentContractingProcedure->unsetAttributes();
      
      $this->render('viewDocumentsContractingProcedures', array('oModelForm'=>$oPurchasesDocumentContractingProcedure, 'oModelFormFilters'=>$oPurchasesDocumentContractingProcedureFilters));    
   }
   
   
   public function actionViewDetailFinancialCost($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFinancialCost = PurchasesFinancialCosts::getPurchasesFinancialCost($nIdForm);
       
      if (!is_null($oPurchasesFinancialCost)) $this->render('viewDetailFinancialCost', array('oModelForm'=>$oPurchasesFinancialCost));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFinancialCostLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdForm);
                                                                      
      if (!is_null($oPurchasesFinancialCostLine)) $this->render('viewDetailFinancialCostLine', array('oModelForm'=>$oPurchasesFinancialCostLine)); 
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionUpdateFinancialCost($nIdForm) {
      $oPurchasesFinancialCostLine = new PurchasesFinancialCostsLines();  
      $oPurchasesFinancialCostLineFilters = new PurchasesFinancialCostsLines();
      $oPurchasesFinancialCostLineFilters->unsetAttributes();
      
      $oPurchasesFinancialCost = PurchasesFinancialCosts::getPurchasesFinancialCost($nIdForm);
      if (!is_null($oPurchasesFinancialCost)) {
         if (FModulePurchasesManagement::allowUpdateFinancialCost($nIdForm)) {        
            if (isset($_POST['PurchasesFinancialCostsLines'])) {  
               // Ajax validation request=>Conditional validator
               FForm::validateAjaxForm('purchases-financial-cost-line-form', $oPurchasesFinancialCostLine);
         
               $oPurchasesFinancialCostLine->attributes = $_POST['PurchasesFinancialCostsLines'];
      
               $oPurchasesFinancialCostLine->id_financial_cost = $nIdForm;
               
               $oPurchasesFinancialCostLine->save();
            }
            else {
               // Filters Grid Get Parameters
               if (isset($_GET['PurchasesFinancialCostsLines'])) $oPurchasesFinancialCostLineFilters->attributes = $_GET['PurchasesFinancialCostsLines'];
            } 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
      
      $oPurchasesFinancialCostLine->unsetAttributes();
      $oPurchasesFinancialCostLineFilters->unsetAttributes();
      
      $oPurchasesFinancialCostLine->id_financial_cost = $nIdForm;
      
      $this->render('updateFinancialCost', array('oModelForm'=>$oPurchasesFinancialCostLine, 'oModelFormFilters'=>$oPurchasesFinancialCostLineFilters)); 
   }
   public function actionUpdateFinancialCostLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdForm);
                               
      if (!is_null($oPurchasesFinancialCostLine)) {
         if (FModulePurchasesManagement::allowUpdateFinancialCostLine($nIdForm)) {    
            $oModelFormAccountingAccount = new PurchasesFinancialCostsAccountingAccounts();  
         
            if (isset($_POST['PurchasesFinancialCostsLines'])) {
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-financial-cost-line-form', $oPurchasesFinancialCostLine);
               
               $oPurchasesFinancialCostLine->attributes = $_POST['PurchasesFinancialCostsLines'];
               
               $nConsumption = PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($nIdForm);
               if ($oPurchasesFinancialCostLine->max_price >= $nConsumption) {
                  $oPurchasesFinancialCostLine->save();
                  
                  $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDetailFinancialCostLine', array('nIdForm'=>$oPurchasesFinancialCostLine->id)));
               }
               else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFINANCIALCOSTLINE_FORM_ERROR_MAX_PRICE', array('{1}'=>$nConsumption)));
            }
            else if (isset($_POST['PurchasesFinancialCostsAccountingAccounts'])) {
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-financial-cost-accounting-account-form', $oPurchasesFinancialCostLine);
               
               $oModelFormAccountingAccount->attributes = $_POST['PurchasesFinancialCostsAccountingAccounts']; 
               
               $oModelFormAccountingAccount->id_financial_cost_line = $nIdForm;
               
               $oModelFormAccountingAccount->save(); 
            }
            
            $oModelFormAccountingAccount->unsetAttributes();
            
            $this->render('updateFinancialCostLine', array('oModelForm'=>$oPurchasesFinancialCostLine, 'oModelFormAccountingAccount'=>$oModelFormAccountingAccount));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }
   public function actionUpdateContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::getPurchasesContractingProcedure($nIdForm);
                               
      if (!is_null($oPurchasesContractingProcedure)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('purchases-contracting-procedure-form', $oPurchasesContractingProcedure);
      
         if (isset($_POST['PurchasesContractingProcedures'])) {
            $oPurchasesContractingProcedure->attributes = $_POST['PurchasesContractingProcedures'];
              
            $oPurchasesContractingProcedure->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDetailContractingProcedure', array('nIdForm'=>$oPurchasesContractingProcedure->id)));
         }
         else $this->render('updateContractingProcedure', array('oModelForm'=>$oPurchasesContractingProcedure));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateDocumentContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::getPurchasesDocumentContractingProcedure($nIdForm);
                               
      if (!is_null($oPurchasesDocumentContractingProcedure)) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('purchases-document-contracting-procedure-form', $oPurchasesDocumentContractingProcedure);
      
         if (isset($_POST['PurchasesDocumentsContractingProcedures'])) {
            $oPurchasesDocumentContractingProcedure->attributes = $_POST['PurchasesDocumentsContractingProcedures'];

            $oPurchasesDocumentContractingProcedure->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDetailDocumentContractingProcedure', array('nIdForm'=>$oPurchasesDocumentContractingProcedure->id)));
         }
         else $this->render('updateDocumentContractingProcedure', array('oModelForm'=>$oPurchasesDocumentContractingProcedure));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionViewDetailProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oProvider = Providers::getProvider($nIdForm);
       
      if (!is_null($oProvider)) $this->render('viewDetailProvider', array('oModelForm'=>$oProvider));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::getPurchasesContractingProcedure($nIdForm);
       
      if (!is_null($oPurchasesContractingProcedure)) $this->render('viewDetailContractingProcedure', array('oModelForm'=>$oPurchasesContractingProcedure));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailDocumentContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::getPurchasesDocumentContractingProcedure($nIdForm);
       
      if (!is_null($oPurchasesDocumentContractingProcedure)) $this->render('viewDetailDocumentContractingProcedure', array('oModelForm'=>$oPurchasesDocumentContractingProcedure));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
    
   
   public function actionUpdateProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oProvider = Providers::getProvider($nIdForm);
                               
      if (!is_null($oProvider)) {
         if (FApplication::canUpdateDeleteProvider($nIdForm, FApplication::MODULE_PURCHASES_MANAGEMENT)) {
            FForm::validateAjaxForm('provider-form', $oProvider);
         
            if (isset($_POST['Providers'])) {
               $oProvider->attributes = $_POST['Providers'];
               if (isset($_POST['Providers']['account'])) $oProvider->account = $_POST['Providers']['account'];
               if (isset($_POST['Providers']['mail'])) $oProvider->mail = $_POST['Providers']['mail'];
         
               $oProvider->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDetailProvider', array('nIdForm'=>$oProvider->id)));
            }
            else $this->render('updateProvider', array('oModelForm'=>$oProvider));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionSynchronizeProvidersFromExternalDB() {
      FModulePurchasesManagement::synchronizeProvidersFromExternalDB();
      
      $this->redirect($this->createUrl('viewProviders'));   
   }
   
   public function actionDeleteProvider($nIdForm) {
      $oProvider = Providers::getProvider($nIdForm);
      if (!is_null($oProvider)) {
         if (FApplication::canUpdateDeleteProvider($nIdForm, FApplication::MODULE_PURCHASES_MANAGEMENT)) {
            $oProvider->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewProviders'));
   }
   public function actionDeleteFinancialCostLine($nIdForm, $nIdFormParent) {
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdForm);
      if (!is_null($oPurchasesFinancialCostLine)) {
         if (FModulePurchasesManagement::allowDeleteFinancialCostLine($nIdForm)) {
            $oPurchasesFinancialCostLine->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateFinancialCost', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFinancialCostAccountingAccount($nIdForm, $nIdFormParent) {
      $oPurchasesFinancialCostsAccountingAccount = PurchasesFinancialCostsAccountingAccounts::getPurchasesFinancialCostAccountingAccount($nIdForm);
      if (!is_null($oPurchasesFinancialCostsAccountingAccount)) {
         if (FModulePurchasesManagement::allowDeleteFinancialCostLine($nIdFormParent)) {
            $oPurchasesFinancialCostsAccountingAccount->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateFinancialCostLine', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteContractingProcedure($nIdForm) {
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::getPurchasesContractingProcedure($nIdForm);
      if (!is_null($oPurchasesContractingProcedure)) {
         if (FModulePurchasesManagement::allowDeleteContractingProcedure($nIdForm)) {
            $oPurchasesContractingProcedure->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewContractingProcedures'));  
   }
   public function actionDeleteDocumentContractingProcedure($nIdForm) {
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::getPurchasesDocumentContractingProcedure($nIdForm);
      if (!is_null($oPurchasesDocumentContractingProcedure)) {
         $oPurchasesDocumentContractingProcedure->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDocumentsContractingProcedures'));  
   }
}