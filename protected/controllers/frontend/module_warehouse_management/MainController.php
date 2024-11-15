<?php

class MainController extends FrontendController {

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(        
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewFormsInputs', 'viewFormsOutputs', 'viewArticleBarcode', 'viewDetailFormInput', 'viewDetailFormOutput'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)',
         ),  
         array('allow', // allow authenticated user and have valid module roles to perform actions                                                                                                                                          
            'actions'=>array('createFormInput', 'createFormOutput', 'refreshFormInputSubcategoriesByArticleCode', 'refreshFormInputArticlesByArticleCode', 'refreshFormOutputSubcategoriesByArticleCode', 'refreshFormOutputArticlesByArticleCode', 'refreshFormInputArticles', 'refreshFormInputPrice', 'refreshFormOutputPrice', 'refreshFormInputLocation', 'refreshFormInputArticleBarcode', 'refreshFormInputArticlePriceBarcode', 'refreshFormOutputArticlePriceBarcode', 'refreshFormInputArticleLocationBarcode', 'refreshFormOutputArticles', 'refreshFormOutputEmployeeDepartment', 'refreshFormOutputLocation', 'refreshFormOutputArticleBarcode', 'refreshFormOutputArticleLocationBarcode', 'viewDetailFormInputPurchaseOrder', 'viewDetailFormRequestOffer', 'updateFormInput', 'updateFormOutput', 'updateFormInputArticle', 'updateFormInputArticleBarcode', 'updateFormOutputArticleBarcode', 'updateFormOutputArticle', 'deleteFormInput', 'deleteFormOutput', 'deleteFormInputArticle', 'deleteFormOutputArticle'),
            'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)))',
         ),
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewFormsPurchaseOrders', 'viewDetailFormPurchaseOrder'),
            'expression'=>'Modules::getIsAvaliableModuleByName(FApplication::MODULE_PURCHASES_MANAGEMENT)',
         ), 
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   
   public function actionViewFormsInputs() {
      $bErrorTransaction = false;
      $oWarehouseFormInput = new WarehouseFormsInputs();
      $sNoticeArticlesPendingStock = FString::STRING_EMPTY;
      
      $oArticlesPendingStock = Articles::getArticlesStockPending();
      foreach($oArticlesPendingStock as $oArticlePendingStock) {
         if (strlen($sNoticeArticlesPendingStock) > 0) $sNoticeArticlesPendingStock .= '<br/><br/>';
         
         $sNoticeArticlesPendingStock .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'NOTICE_ARTICLES_PENDING_STOCK', array('{1}'=>$oArticlePendingStock->getFullName(), '{2}'=>$oArticlePendingStock->quantity_min, '{3}'=>$oArticlePendingStock->quantity, '{4}'=>$oArticlePendingStock->quantity_min - $oArticlePendingStock->quantity, '{5}'=>$oArticlePendingStock->name));   
      }
      
      if (strlen($sNoticeArticlesPendingStock) > 0) {
         Yii::app()->user->setFlash('notice-generic', $sNoticeArticlesPendingStock);       
      }
      
      // Delete incomplete forms
      try {
         $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
         
         $oWarehouseFormsInputs = WarehouseFormsInputs::getWarehouseFormsInputs(false, Yii::app()->user->id);
         foreach($oWarehouseFormsInputs as $oWarehouseFormInput) {
            $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
            if (count($oWarehouseFormInputArticles) > 0) {
               $oWarehouseFormInput->data_completed = true;
               if (FString::isNullOrEmpty($oWarehouseFormInput->status)) $oWarehouseFormInput->status = FModuleWarehouseManagement::STATUS_SUCCESS;
               
               if (!$oWarehouseFormInput->save(false)) $bErrorTransaction = true;            
            }
            else {
               if (!$oWarehouseFormInput->delete()) $bErrorTransaction = true;            
            }
         }
         
         $oWarehouseFormsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputs(false, Yii::app()->user->id);
         foreach($oWarehouseFormsOutputs as $oWarehouseFormOutput) { 
            $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
            if (count($oWarehouseFormOutputArticles) > 0) {
               $oWarehouseFormOutput->data_completed = true;

               if (!$oWarehouseFormOutput->save(false)) $bErrorTransaction = true;            
            }
            else {
               if (!$oWarehouseFormOutput->delete()) $bErrorTransaction = true;            
            }         
         }
         
         if (!$bErrorTransaction) {
            $oTransaction->commit(); 
         }      
         else {
            $oTransaction->rollBack(); 
         }
      } catch(Exception $e) {
         $oTransaction->rollBack(); 
      }

      $oWarehouseFormInput->unsetAttributes();
      
      // Filters Grid Get Parameters
      if (isset($_GET['WarehouseFormsInputs'])) {
         $oWarehouseFormInput->attributes = $_GET['WarehouseFormsInputs'];
      } 
      
      $this->render('viewFormsInputs', array('oModelForm'=>$oWarehouseFormInput)); 
   }
   public function actionViewFormsOutputs() {
      $bErrorTransaction = false;
      $oWarehouseFormOutput = new WarehouseFormsOutputs();

      $sNoticeArticlesPendingStock = FString::STRING_EMPTY;
      
      $oArticlesPendingStock = Articles::getArticlesStockPending();
      foreach($oArticlesPendingStock as $oArticlePendingStock) {
         if (strlen($sNoticeArticlesPendingStock) > 0) $sNoticeArticlesPendingStock .= '<br/><br/>';
         
         $sNoticeArticlesPendingStock .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'NOTICE_ARTICLES_PENDING_STOCK', array('{1}'=>$oArticlePendingStock->getFullName(), '{2}'=>$oArticlePendingStock->quantity_min, '{3}'=>$oArticlePendingStock->quantity, '{4}'=>$oArticlePendingStock->quantity_min - $oArticlePendingStock->quantity, '{5}'=>$oArticlePendingStock->name));  
      }
      
      if (strlen($sNoticeArticlesPendingStock) > 0) {
         Yii::app()->user->setFlash('notice-generic', $sNoticeArticlesPendingStock);       
      }
      
      // Delete incomplete forms
      try {
         $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
         
         $oWarehouseFormsInputs = WarehouseFormsInputs::getWarehouseFormsInputs(false, Yii::app()->user->id);
         foreach($oWarehouseFormsInputs as $oWarehouseFormInput) {
            $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
            if (count($oWarehouseFormInputArticles) > 0) {
               $oWarehouseFormInput->data_completed = true;
               if (FString::isNullOrEmpty($oWarehouseFormInput->status)) $oWarehouseFormInput->status = FModuleWarehouseManagement::STATUS_SUCCESS;
               
               if (!$oWarehouseFormInput->save(false)) $bErrorTransaction = true;            
            }
            else {
               if (!$oWarehouseFormInput->delete()) $bErrorTransaction = true;            
            }
         }
         
         $oWarehouseFormsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputs(false, Yii::app()->user->id);
         foreach($oWarehouseFormsOutputs as $oWarehouseFormOutput) { 
            $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
            if (count($oWarehouseFormOutputArticles) > 0) {
               $oWarehouseFormOutput->data_completed = true;

               if (!$oWarehouseFormOutput->save(false)) $bErrorTransaction = true;            
            }
            else {
               if (!$oWarehouseFormOutput->delete()) $bErrorTransaction = true;            
            }         
         }
         
         if (!$bErrorTransaction) {
            $oTransaction->commit(); 
         }      
         else {
            $oTransaction->rollBack(); 
         }
      } catch(Exception $e) {
         $oTransaction->rollBack(); 
      } 

      $oWarehouseFormOutput->unsetAttributes();
      
      // Filters Grid Get Parameters
      if (isset($_GET['WarehouseFormsOutputs'])) {
         $oWarehouseFormOutput->attributes = $_GET['WarehouseFormsOutputs'];
      } 
      
      $this->render('viewFormsOutputs', array('oModelForm'=>$oWarehouseFormOutput)); 
   }
   public function actionViewFormsPurchaseOrders() {
      $oPurchasesFormPurchaseOrder = new PurchasesFormsPurchaseOrders();
      
      $oPurchasesFormPurchaseOrder->unsetAttributes();
      $oPurchasesFormPurchaseOrder->sFilterStatusPending = true;
      $oPurchasesFormPurchaseOrder->sFilterStatusPartialFinalized = false;
      $oPurchasesFormPurchaseOrder->sFilterStatusFinalized = false;
      
      // Filters Grid Get Parameters 
      if (isset($_GET['PurchasesFormsPurchaseOrders'])) {
         $oPurchasesFormPurchaseOrder->attributes = $_GET['PurchasesFormsPurchaseOrders'];
         
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id'])) $oPurchasesFormPurchaseOrder->id = $_GET['PurchasesFormsPurchaseOrders']['id'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id_provider'])) $oPurchasesFormPurchaseOrder->id_provider = $_GET['PurchasesFormsPurchaseOrders']['id_provider'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['accept_date'])) $oPurchasesFormPurchaseOrder->accept_date = $_GET['PurchasesFormsPurchaseOrders']['accept_date'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id_financial_cost_line'])) $oPurchasesFormPurchaseOrder->id_financial_cost_line = $_GET['PurchasesFormsPurchaseOrders']['id_financial_cost_line'];
     
         if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPending'])) $oPurchasesFormPurchaseOrder->sFilterStatusPending = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPending'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPartialFinalized'])) $oPurchasesFormPurchaseOrder->sFilterStatusPartialFinalized = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPartialFinalized'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusFinalized'])) $oPurchasesFormPurchaseOrder->sFilterStatusFinalized = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusFinalized'];
      }
      
      $this->render('viewFormsPurchaseOrders', array('oModelForm'=>$oPurchasesFormPurchaseOrder)); 
   }
   public function actionViewArticleBarcode($nIdForm) {
      $this->layout = null;
      $oArticle = Articles::getArticle($nIdForm);
      
      if ($oArticle) $this->render('viewArticleBarcode', array('oModelForm'=>$oArticle));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }
   
   
   public function actionViewDetailFormInput($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
      
      if (!is_null($oWarehouseFormInput)) $this->render('viewDetailFormInput', array('oModelForm'=>$oWarehouseFormInput, 'oModelFormArticles'=>$oWarehouseFormInputArticles));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormOutput($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
      
      if (!is_null($oWarehouseFormOutput)) $this->render('viewDetailFormOutput', array('oModelForm'=>$oWarehouseFormOutput, 'oModelFormArticles'=>$oWarehouseFormOutputArticles));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormInputPurchaseOrder($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);

      if (!is_null($oPurchasesFormPurchaseOrder)) $this->renderPartial('viewDetailFormInputPurchaseOrder', array('oModelForm'=>$oPurchasesFormPurchaseOrder), false, true);
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormRequestOffer($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormRequestOffer)) $this->renderPartial('viewDetailFormRequestOffer', array('oModelForm'=>$oPurchasesFormRequestOffer), false, true);
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormPurchaseOrder($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);

      if (!is_null($oPurchasesFormPurchaseOrder)) $this->render('viewDetailFormPurchaseOrder', array('oModelForm'=>$oPurchasesFormPurchaseOrder));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionCreateFormInput() {
      $oWarehouseFormInput = new WarehouseFormsInputs();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oWarehouseFormInput->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oWarehouseFormInput->date = date('Y-m-d H:i:s');
         $oWarehouseFormInput->type = FModuleWarehouseManagement::TYPE_INPUT_WAYBILL;
         $oWarehouseFormInput->id_user = Yii::app()->user->id;
          
         if ($oWarehouseFormInput->save(false)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInput', array('nIdForm'=>$oWarehouseFormInput->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   public function actionCreateFormOutput() {
      $oWarehouseFormOutput = new WarehouseFormsOutputs();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oWarehouseFormOutput->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oWarehouseFormOutput->date = date('Y-m-d H:i:s');
         $oWarehouseFormOutput->type = FModuleWarehouseManagement::TYPE_OUTPUT_PLANT;
         $oWarehouseFormOutput->id_user = Yii::app()->user->id;
          
         if ($oWarehouseFormOutput->save(false)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutput', array('nIdForm'=>$oWarehouseFormOutput->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   
   
   public function actionRefreshFormInputSubcategoriesByArticleCode($nIdForm, $sIdSubcategory, $nIdArticle) {           
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            $nIdSubcategory = null;
      
            $sRefreshArticlesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputArticles') . '&nIdForm=' . $oWarehouseFormInput->id . '&nIdSubcategory='; 
            $sRefreshArticlesUrl = "aj('" . $sRefreshArticlesUrl . "' + this.value, null, 'id_article');";  
            
            $sContent = "<select style=\"width:530px;\" onchange=\"" . $sRefreshArticlesUrl . "\" name=\"WarehouseFormInputArticles[id_subcategory]\" id=\"WarehouseFormInputArticles_id_subcategory\">";  
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);
               if (!is_null($oArticle)) {
                  $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                  if (!is_null($oWarehouseArticleSubcategory)) {
                     if ($oWarehouseArticleSubcategory->name == $sIdSubcategory) {
                        $nIdSubcategory = $oArticle->id_subcategory;   
                     }
                  }
               }
            }
            
            $oWarehouseArticlesSubcategories = WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories();
            foreach($oWarehouseArticlesSubcategories as $oWarehouseArticleSubcategory) {
               if ($oWarehouseArticleSubcategory->id == $nIdSubcategory) $sContent .= "<option value=\"" . $oWarehouseArticleSubcategory->id . "\" selected>" . $oWarehouseArticleSubcategory->name . "</option>";     
               else $sContent .= "<option value=\"" . $oWarehouseArticleSubcategory->id . "\">" . $oWarehouseArticleSubcategory->name . "</option>";    
            } 
  
            $sContent .= "</select>"; 
            
            $this->renderText($sContent);   
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormInputArticlesByArticleCode($nIdForm, $sIdSubcategory, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            $nIdSubcategory = null;
            
            $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputPrice') . '&nIdForm=' . $oWarehouseFormInput->id . '&nIdArticle=';
            $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputLocation') . '&nIdForm=' . $oWarehouseFormInput->id . '&nIdArticle=';
            $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + this.value, null, 'id_price_cost');";              
            $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + this.value, null, 'id_location_subcategory')";              
            
            $sContent = "<select style=\"width:715px;\" onchange=\"" . $sRefreshPriceUrl . $sRefreshLocationUrl . "\" name=\"WarehouseFormInputArticles[id_article]\" id=\"WarehouseFormInputArticles_id_article\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);
               if (!is_null($oArticle)) {
                  $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                  if (!is_null($oWarehouseArticleSubcategory)) {
                     if ($oWarehouseArticleSubcategory->name == $sIdSubcategory) {
                        $nIdSubcategory = $oArticle->id_subcategory;   
                     }
                  }
               }
            }
            
            if (!FString::isNullOrEmpty($nIdSubcategory)) {
               $oArticles = Articles::getArticlesByIdSubcategory($nIdSubcategory, false);
               
               foreach($oArticles as $oArticle) {
                  if ($oArticle->id == $nIdArticle) $sContent .= "<option value=\"" . $oArticle->id . "\" selected>" . $oArticle->getFullName() . "</option>";   
                  else $sContent .= "<option value=\"" . $oArticle->id . "\">" . $oArticle->getFullName() . "</option>";    
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionRefreshFormOutputSubcategoriesByArticleCode($nIdForm, $sIdSubcategory, $nIdArticle) {           
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            $nIdSubcategory = null;
      
            $sRefreshArticlesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticles') . '&nIdForm=' . $oWarehouseFormOutput->id . '&nIdSubcategory='; 
            $sRefreshArticlesUrl = "aj('" . $sRefreshArticlesUrl . "' + this.value, null, 'id_article');";  
            
            $sContent = "<select style=\"width:530px;\" onchange=\"" . $sRefreshArticlesUrl . "\" name=\"WarehouseFormOutputArticles[id_subcategory]\" id=\"WarehouseFormOutputArticles_id_subcategory\">";  
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);
               if (!is_null($oArticle)) {
                  $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                  if (!is_null($oWarehouseArticleSubcategory)) {
                     if ($oWarehouseArticleSubcategory->name == $sIdSubcategory) {
                        $nIdSubcategory = $oArticle->id_subcategory;   
                     }
                  }
               }
            }
            
            $oWarehouseArticlesSubcategories = WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories();
            foreach($oWarehouseArticlesSubcategories as $oWarehouseArticleSubcategory) {
               if ($oWarehouseArticleSubcategory->id == $nIdSubcategory) $sContent .= "<option value=\"" . $oWarehouseArticleSubcategory->id . "\" selected>" . $oWarehouseArticleSubcategory->name . "</option>";     
               else $sContent .= "<option value=\"" . $oWarehouseArticleSubcategory->id . "\">" . $oWarehouseArticleSubcategory->name . "</option>";    
            } 
  
            $sContent .= "</select>"; 
            
            $this->renderText($sContent);   
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormOutputArticlesByArticleCode($nIdForm, $sIdSubcategory, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            $nIdSubcategory = null;
            
            $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputPrice') . '&nIdForm=' . $oWarehouseFormOutput->id . '&nIdArticle=';
            $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputLocation') . '&nIdForm=' . $oWarehouseFormOutput->id . '&nIdArticle=';
            $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + this.value, null, 'id_price_cost');";              
            $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + this.value, null, 'id_location_subcategory')";              
            
            $sContent = "<select style=\"width:715px;\" onchange=\"" . $sRefreshPriceUrl . $sRefreshLocationUrl . "\" name=\"WarehouseFormOutputArticles[id_article]\" id=\"WarehouseFormOutputArticles_id_article\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);
               if (!is_null($oArticle)) {
                  $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                  if (!is_null($oWarehouseArticleSubcategory)) {
                     if ($oWarehouseArticleSubcategory->name == $sIdSubcategory) {
                        $nIdSubcategory = $oArticle->id_subcategory;   
                     }
                  }
               }
            }
            
            if (!FString::isNullOrEmpty($nIdSubcategory)) {
               $oArticles = Articles::getArticlesByIdSubcategory($nIdSubcategory, false);
               
               foreach($oArticles as $oArticle) {                        
                  if ($oArticle->id == $nIdArticle) $sContent .= "<option value=\"" . $oArticle->id . "\" selected>" . $oArticle->getFullName() . " (" . $oArticle->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . ")</option>";   
                  else $sContent .= "<option value=\"" . $oArticle->id . "\">" . $oArticle->getFullName() . " (" . $oArticle->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . ")</option>";    
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionRefreshFormInputArticles($nIdForm, $nIdSubcategory) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputPrice') . '&nIdForm=' . $oWarehouseFormInput->id . '&nIdArticle=';
            $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputLocation') . '&nIdForm=' . $oWarehouseFormInput->id . '&nIdArticle=';
            $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + this.value, null, 'id_price_cost');";              
            $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + this.value, null, 'id_location_subcategory')";              
            
            $sContent = "<select style=\"width:715px;\" onchange=\"" . $sRefreshPriceUrl . $sRefreshLocationUrl . "\" name=\"WarehouseFormInputArticles[id_article]\" id=\"WarehouseFormInputArticles_id_article\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdSubcategory)) {
               $oArticles = Articles::getArticlesByIdSubcategory($nIdSubcategory, false);
               
               foreach($oArticles as $oArticle) {
                  $sContent .= "<option value=\"" . $oArticle->id . "\">" . $oArticle->getFullName() . "</option>";    
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormInputPrice($nIdForm, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormInputArticles[price_cost]\" id=\"WarehouseFormInputArticles_price_cost\" type=\"text\" value=\"0.000\" />";

            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);   
               if (!is_null($oArticle)) {
                  $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormInputArticles[price_cost]\" id=\"WarehouseFormInputArticles_price_cost\" type=\"text\" value=\"" . $oArticle->price_medium . "\" />";
               }
            }

            $this->renderText($sContent);   
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormInputLocation($nIdForm, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:432px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormInputArticles[location_subcategory]\" id=\"WarehouseFormInputArticles_location_subcategory\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticle($nIdArticle);   
            if (!is_null($oArticle)) {
               $sContent .= WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory);
            }
            
            $sContent .= "\"></input>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormInputArticleBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:530px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormInputArticles[article]\" id=\"WarehouseFormInputArticles_article\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {
               $sContent .= $oArticle->getFullName();
            }
            
            $sContent .= "\"></input>";
            
            if (!is_null($oArticle)) {
               $sContent .= "<input style=\"width:530px;\" name=\"WarehouseFormInputArticles[id_article]\" id=\"WarehouseFormInputArticles_id_article\" type=\"hidden\" value=\"";
               $sContent .= $oArticle->id;
               $sContent .= "\"></input>";
            }                
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormInputArticlePriceBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormInputArticles[price_cost]\" id=\"WarehouseFormInputArticles_price_cost\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {     
               $sContent .= $oArticle->price_medium;
            }
            else {
               $sContent .= '0.000';
            }
            
            $sContent .= "\"></input>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormInputArticleLocationBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
         
         if (!is_null($oWarehouseFormInput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:530px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormInputArticles[location_subcategory]\" id=\"WarehouseFormInputArticles_location_subcategory\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {
               $sContent .= WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory);
            }
            
            $sContent .= "\"></input>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormOutputArticles($nIdForm, $nIdSubcategory) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputPrice') . '&nIdForm=' . $oWarehouseFormOutput->id . '&nIdArticle=';
            $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputLocation') . '&nIdForm=' . $oWarehouseFormOutput->id . '&nIdArticle=';          
            $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + this.value, null, 'id_price_cost');";              
            $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + this.value, null, 'id_location_subcategory')"; 
            
            $sContent = "<select style=\"width:715px;\" onchange=\"" . $sRefreshPriceUrl . $sRefreshLocationUrl . "\" name=\"WarehouseFormOutputArticles[id_article]\" id=\"WarehouseFormOutputArticles_id_article\">";   
            $sContent .= "<option value=\"\">" . Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT') . "</option>";
            if (!FString::isNullOrEmpty($nIdSubcategory)) {
               $oArticles = Articles::getArticlesByIdSubcategory($nIdSubcategory, true);
               
               foreach($oArticles as $oArticle) {
                  if ($oArticle->quantity > 0) {
                     $sContent .= "<option value=\"" . $oArticle->id . "\">" . $oArticle->getFullName() . " (" . $oArticle->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . ")</option>";    
                  }
               } 
            }
            $sContent .= "</select>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormOutputEmployeeDepartment($nIdForm) {
      $this->layout = null;
      $sContent = "<input style=\"width:180px;\" name=\"WarehouseFormsOutputs[employee_department]\" id=\"WarehouseFormsOutputs_employee_department\" disabled=\"disabled\" type=\"text\" value=\"\" />";
      
      $oEmployee = Employees::getEmployee($nIdForm);
      if (!is_null($oEmployee)) {
         $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);  
         if (!is_null($oEmployeeDepartment)) { 
            $sContent = "<input style=\"width:180px;\" name=\"WarehouseFormsOutputs[employee_department]\" id=\"WarehouseFormsOutputs_employee_department\" disabled=\"disabled\" type=\"text\" value=\"" . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartment->department) . "\" />";
         }  
      }
     
      $this->renderText($sContent);
   }
   public function actionRefreshFormOutputPrice($nIdForm, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormOutputArticles[price_cost]\" id=\"WarehouseFormOutputArticles_price_cost\" type=\"text\" value=\"0.000\" readonly=\"readonly\" />";

            if (!FString::isNullOrEmpty($nIdArticle)) {
               $oArticle = Articles::getArticle($nIdArticle);   
               if (!is_null($oArticle)) {
                  $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormOutputArticles[price_cost]\" id=\"WarehouseFormOutputArticles_price_cost\" type=\"text\" value=\"" . $oArticle->price_medium . "\" readonly=\"readonly\" />";
               }
            }

            $this->renderText($sContent);   
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionRefreshFormOutputLocation($nIdForm, $nIdArticle) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:432px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormOutputArticles[location_subcategory]\" id=\"WarehouseFormOutputArticles_location_subcategory\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticle($nIdArticle);   
            if (!is_null($oArticle)) {
               $sContent .= WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory);
            }
            
            $sContent .= "\"></input>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormOutputArticleBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:530px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormOutputArticles[article]\" id=\"WarehouseFormOutputArticles_article\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {
               $sContent .= $oArticle->getFullName();
            }
            
            $sContent .= "\"></input>";
            
            if (!is_null($oArticle)) {
               $sContent .= "<input style=\"width:530px;\" name=\"WarehouseFormOutputArticles[id_article]\" id=\"WarehouseFormOutputArticles_id_article\" type=\"hidden\" value=\"";
               $sContent .= $oArticle->id;
               $sContent .= "\"></input>";
            }
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormOutputArticlePriceBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:105px;\" name=\"WarehouseFormOutputArticles[price_cost]\" id=\"WarehouseFormOutputArticles_price_cost\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {
               $sContent .= $oArticle->price_medium;
            }
            else {
               $sContent .= '0.000';
            }
           
            $sContent .= "\" readonly=\"readonly\"></input>";
            
            $this->renderText($sContent);     
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionRefreshFormOutputArticleLocationBarcode($nIdForm, $sBarcode) {
      if ((strlen($nIdForm) > 0) && (is_numeric($nIdForm))) {
         $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
         
         if (!is_null($oWarehouseFormOutput)) {
            $this->layout = null;
            
            $sContent = "<input style=\"width:530px; background-color:#dedede\" readonly=\"readonly\" name=\"WarehouseFormOutputArticles[location_subcategory]\" id=\"WarehouseFormOutputArticles_location_subcategory\" type=\"text\" value=\"";   
            
            $oArticle = Articles::getArticleByCodeBarcode($sBarcode);
            if (!is_null($oArticle)) {
               $sContent .= WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory);
            }
            
            $sContent .= "\"></input>";
            
            $this->renderText($sContent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionUpdateFormInput($nIdForm) { 
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      $bError = false;
      $bErrorTransaction = false;
      
      if (!is_null($oWarehouseFormInput)) {
         $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
         $oWarehouseFormInputArticle = new WarehouseFormInputArticles();
         $oPurchasesFormPurchaseOrder = new PurchasesFormsPurchaseOrders();
         $oPurchasesFormRequestOffer = new PurchasesFormsRequestOffers();
            
         if (FModuleWarehouseManagement::allowUpdateWarehouseFormInput($nIdForm)) {
            if (isset($_GET['WarehouseFormsInputs']['id_provider'])) {
               $oWarehouseFormInput->id_provider = $_GET['WarehouseFormsInputs']['id_provider']; 
               $oWarehouseFormInput->type = $_GET['WarehouseFormsInputs']['type']; 
               $oWarehouseFormInput->code = $_GET['WarehouseFormsInputs']['code']; 
               $oWarehouseFormInput->id_form_purchase_order = null;

               $oWarehouseFormInput->save(false);
            }
            else if (isset($_POST['WarehouseFormsInputs'])) {
               if (isset($_POST['WarehouseFormsInputs']['id_provider'])) $oWarehouseFormInput->id_provider = $_POST['WarehouseFormsInputs']['id_provider'];
                         
               FForm::validateAjaxForm('warehouse-form-input-form', $oWarehouseFormInput);

               try {
                  $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                  $oWarehouseFormInput->attributes = $_POST['WarehouseFormsInputs'];
                  $oWarehouseFormInput->status = $_POST['WarehouseFormsInputs']['status'];
                  
                  if ((($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_WAYBILL) || ($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_REPAIR)) && (!FString::isNullOrEmpty($_POST['WarehouseFormsInputs']['id_form_purchase_order']))) {
                     $oWarehouseFormInput->id_form_purchase_order = $_POST['WarehouseFormsInputs']['id_form_purchase_order'];
                  }
                  
                  if (!$bError) {  
                     if (count($oWarehouseFormInputArticles) == 0) {
                        $bError = true; 
                        Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_SUBMIT_ERROR_EMPTY_ARTICLES'));   
                     }
                     
                     if ((($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_WAYBILL) || ($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_REPAIR)) && (FString::isNullOrEmpty($_POST['WarehouseFormsInputs']['id_form_purchase_order']))) {
                        $bError = true; 
                        Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_SUBMIT_ERROR_NOT_PURCHASE_ORDER_SELECTED'));   
                     }
                  }
                   
                  if (!$bError) {    
                     if (isset($_POST['WarehouseFormsInputs']['comments'])) $oWarehouseFormInput->comments = $_POST['WarehouseFormsInputs']['comments']; 

                     if (isset($_POST['WarehouseFormsInputs']['id_provider'])) {
                        $oProvider = Providers::getProvider($oWarehouseFormInput->id_provider);
                        if (!is_null($oProvider)) {
                           $oWarehouseFormInput->provider = $oProvider->name; 
                        }
                     }
                     
                     if (($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_BENEFIT) || ($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_REGULARIZATION)) {
                        $oWarehouseFormInput->code = null;
                        $oWarehouseFormInput->id_form_purchase_order = null;          
                     }
                            
                     $oFile = CUploadedFile::getInstanceByName('WarehouseFormsInputs[delivery]'); 

                     if (($oFile) && ((($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_WAYBILL) || ($oWarehouseFormInput->type == FModuleWarehouseManagement::TYPE_INPUT_REPAIR)) && (!FString::isNullOrEmpty($_POST['WarehouseFormsInputs']['id_form_purchase_order'])))) {
                        $sOriginalFilename = sha1_file($oFile->tempName);
                        $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                        $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                       
                        $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES;
                        $sOriginalFileUrl = $sPath . $sOriginalFile;
                                 
                        if ($oFile->saveAs($sOriginalFileUrl)) {
                           $oPurchasesFormPurchaseOrderTmp = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($oWarehouseFormInput->id_form_purchase_order);
                           
                           if (!is_null($oPurchasesFormPurchaseOrderTmp)) {
                              $oPurchasesFormPurchaseOrderTmp->delivery = $sOriginalFile;
                              
                              if (($oPurchasesFormPurchaseOrderTmp->save()) && (!$oWarehouseFormInput->data_completed)) {
                                 Events::addSystemEvent('EVENT_NEW_FORM_PURCHASE_ORDER_WAREHOUSE_FORM_INPUT_TITLE', 'EVENT_NEW_FORM_PURCHASE_ORDER_WAREHOUSE_FORM_INPUT', $oPurchasesFormPurchaseOrderTmp->description, FApplication::MODULE_PURCHASES_MANAGEMENT, FApplication::MODULE_PURCHASES_MANAGEMENT, null, $oPurchasesFormPurchaseOrderTmp->id_user);
                              }
                           }
                        } 
                     }
                     
                     $oWarehouseFormInput->data_completed = true;
                     
                     if (!$oWarehouseFormInput->save()) $bErrorTransaction = true;

                     if (!$bErrorTransaction) {
                        $oTransaction->commit(); 
                     }      
                     else {
                        $oTransaction->rollBack(); 
                     }
                     
                     $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/viewFormsInputs'));   
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }

            if (FString::isNullOrEmpty($oWarehouseFormInput->status)) $oWarehouseFormInput->status = FModuleWarehouseManagement::STATUS_SUCCESS;
            if (FString::isNullOrEmpty($oWarehouseFormInput->type)) $oWarehouseFormInput->type = FModuleWarehouseManagement::TYPE_INPUT_WAYBILL;  
            
            $this->render('updateFormInput', array('oModelForm'=>$oWarehouseFormInput, 'oModelFormArticle'=>$oWarehouseFormInputArticle, 'oModelFormPurchaseOrder'=>$oPurchasesFormPurchaseOrder, 'oModelFormRequestOffer'=>$oPurchasesFormRequestOffer, 'oModelFormArticles'=>$oWarehouseFormInputArticles));             
         }  
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));                                                                                                                                                                          
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormInputArticle($nIdForm) {     
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      $oArticle = null;
      $this->layout = null;
      $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_NO_AFTERACTION_ALTERNATIVE;
      $bErrorTransaction = false;
               
      try {     
         $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
         if (!is_null($oWarehouseFormInput)) {
            if (FModuleWarehouseManagement::allowUpdateWarehouseFormInput($oWarehouseFormInput->id)) {
               $oWarehouseFormInputArticle = new WarehouseFormInputArticles();
                              
               if (isset($_POST['WarehouseFormInputArticles'])) {
                  FForm::validateAjaxForm('warehouse-form-input-article-form', $oWarehouseFormInputArticle);
                  
                  $oWarehouseFormInputArticle->attributes = $_POST['WarehouseFormInputArticles'];   

                  $oWarehouseFormInputArticleTmp = null;
                  if (isset($_POST['WarehouseFormInputArticles']['id_article'])) {
                     $oWarehouseFormInputArticleTmp = WarehouseFormInputArticles::getWarehouseFormInputArticleByIdArticleAndPriceCostAndIdFormFK($_POST['WarehouseFormInputArticles']['id_article'], $_POST['WarehouseFormInputArticles']['price_cost'], $oWarehouseFormInput->id);
                  }

                  if (is_null($oWarehouseFormInputArticleTmp)) {
                     if (isset($_POST['WarehouseFormInputArticles']['id_subcategory'])) {
                        $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oWarehouseFormInputArticle->id_subcategory);
                        if (!is_null($oWarehouseArticleSubcategory)) {
                           $oWarehouseFormInputArticle->subcategory = $oWarehouseArticleSubcategory->name;
                           $oWarehouseFormInputArticle->id_category = $oWarehouseArticleSubcategory->category->id;
                           $oWarehouseFormInputArticle->category = $oWarehouseArticleSubcategory->category->name;
                        }
                     }
                                   
                     if (isset($_POST['WarehouseFormInputArticles']['id_article'])) {  
                        $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                        if (!is_null($oArticle)) {
                           $oWarehouseFormInputArticle->article = $oArticle->name;
                           $oWarehouseFormInputArticle->article_ipe = $oArticle->ipe;
                           $oWarehouseFormInputArticle->article_description = $oArticle->description;
                           $oWarehouseFormInputArticle->id_location_subcategory = $oArticle->id_location_subcategory; 
                           $oWarehouseFormInputArticle->location_subcategory = $oArticle->location_subcategory->name;
                           
                           if (!FString::isNullOrEmpty($oWarehouseFormInputArticle->article_code_barcode)) $oWarehouseFormInputArticle->article_code_barcode = $oArticle->code_barcode; 
                           if (!FString::isNullOrEmpty($oWarehouseFormInputArticle->article_code_kks)) $oWarehouseFormInputArticle->article_code_kks = $oArticle->code_kks;   
                        } 
                     }
                                           
                     $oWarehouseFormInputArticle->id_form_input = $oWarehouseFormInput->id;
                  }
                  else {
                     $oWarehouseFormInputArticle = $oWarehouseFormInputArticleTmp;
                     $oWarehouseFormInputArticle->quantity += $_POST['WarehouseFormInputArticles']['quantity'];    
                  }  
 
                  if ($oWarehouseFormInputArticle->save()) {
                     $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                     if (!is_null($oArticle)) {
                        $nBeforeQuantity = $oArticle->quantity;
                            
                        $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $_POST['WarehouseFormInputArticles']['quantity'], $_POST['WarehouseFormInputArticles']['price_cost'], true);
                  
                        $oArticle->quantity += $_POST['WarehouseFormInputArticles']['quantity'];
                        
                        if (!$oArticle->save(false)) $bErrorTransaction = true;
                     } 
                  }    
               }
            }
         }
         
         if (!$bErrorTransaction) {
            $oTransaction->commit();
            $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_YES_AFTERACTION;   
         }      
         else {         
            $oTransaction->rollBack(); 
         }   
      } catch(Exception $e) {  
         $oTransaction->rollBack(); 
      }  
      
      $this->renderText($sContent);
   }
   public function actionUpdateFormInputArticleBarcode($nIdForm) {
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      $oArticle = null;
      $this->layout = FApplication::LAYOUT_POPUP;
      $bErrorTransaction = false;  
      
      if (!is_null($oWarehouseFormInput)) {
         if (FModuleWarehouseManagement::allowUpdateWarehouseFormInput($oWarehouseFormInput->id)) {
            $oWarehouseFormInputArticle = new WarehouseFormInputArticles();
            
            if (isset($_POST['WarehouseFormInputArticles'])) {
               FForm::validateAjaxForm('warehouse-form-input-article-form', $oWarehouseFormInputArticle);
               
               try {
                  $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                  
                  $oWarehouseFormInputArticle->attributes = $_POST['WarehouseFormInputArticles'];  
                  
                  $oWarehouseFormInputArticleTmp = null;
                  if (isset($_POST['WarehouseFormInputArticles']['id_article'])) {
                     $oWarehouseFormInputArticleTmp = WarehouseFormInputArticles::getWarehouseFormInputArticleByIdArticleAndPriceCostAndIdFormFK($_POST['WarehouseFormInputArticles']['id_article'], $_POST['WarehouseFormInputArticles']['price_cost'], $oWarehouseFormInput->id);
                  }
                  
                  if (is_null($oWarehouseFormInputArticleTmp)) {             
                     if (isset($_POST['WarehouseFormInputArticles']['id_article'])) {  
                        $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                        if (!is_null($oArticle)) {
                           $oWarehouseFormInputArticle->article = $oArticle->name;
                           $oWarehouseFormInputArticle->article_ipe = $oArticle->ipe;
                           $oWarehouseFormInputArticle->article_description = $oArticle->description;
                           $oWarehouseFormInputArticle->id_location_subcategory = $oArticle->id_location_subcategory; 
                           $oWarehouseFormInputArticle->location_subcategory = $oArticle->location_subcategory->name;
                           
                           $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                           if (!is_null($oWarehouseArticleSubcategory)) {
                              $oWarehouseFormInputArticle->id_subcategory = $oWarehouseArticleSubcategory->id;
                              $oWarehouseFormInputArticle->subcategory = $oWarehouseArticleSubcategory->name;
                              $oWarehouseFormInputArticle->id_category = $oWarehouseArticleSubcategory->category->id;
                              $oWarehouseFormInputArticle->category = $oWarehouseArticleSubcategory->category->name;
                           }
                        
                           if (!FString::isNullOrEmpty($oWarehouseFormInputArticle->article_code_barcode)) $oWarehouseFormInputArticle->article_code_barcode = $oArticle->code_barcode; 
                           if (!FString::isNullOrEmpty($oWarehouseFormInputArticle->article_code_kks)) $oWarehouseFormInputArticle->article_code_kks = $oArticle->code_kks;  
                        } 
                     }
                                           
                     $oWarehouseFormInputArticle->id_form_input = $oWarehouseFormInput->id;
                  }
                  else {
                     $oWarehouseFormInputArticle = $oWarehouseFormInputArticleTmp;
                     $oWarehouseFormInputArticle->quantity += $_POST['WarehouseFormInputArticles']['quantity'];    
                  }
                  
                  if ($oWarehouseFormInputArticle->save()) {
                     $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                     if (!is_null($oArticle)) {
                        $nBeforeQuantity = $oArticle->quantity;
                        
                        $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $_POST['WarehouseFormInputArticles']['quantity'], $_POST['WarehouseFormInputArticles']['price_cost'], true);
                  
                        $oArticle->quantity += $_POST['WarehouseFormInputArticles']['quantity'];

                        if (!$oArticle->save(false)) $bErrorTransaction = true;
                     } 
                  } 
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit();
                     
                     FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUTARTICLEBARCODE_FORM_SUBMIT_SUCCESS', array('{1}'=>$_POST['WarehouseFormInputArticles']['quantity'], '{2}'=>$oWarehouseFormInputArticle->article, '{3}'=>$oWarehouseFormInputArticle->price_cost)));  
                  }      
                  else {
                     $oTransaction->rollBack(); 
                     
                     FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUTARTICLEBARCODE_FORM_SUBMIT_ERROR'));
                  }
               }   
               catch(Exception $e) {
                  $oTransaction->rollBack(); 
               }
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
                                                            
         $oWarehouseFormInputArticle->quantity = 1;
         $oWarehouseFormInputArticle->price_cost = '0.000';
         $oWarehouseFormInputArticle->article = FString::STRING_EMPTY;
         $oWarehouseFormInputArticle->location_subcategory = FString::STRING_EMPTY;
         
         $this->render('updateFormInputArticleBarcode', array('oModelForm'=>$oWarehouseFormInput, 'oModelFormArticle'=>$oWarehouseFormInputArticle));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }
   public function actionUpdateFormOutput($nIdForm) { 
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      $bError = false;
      $bErrorTransaction = false;
      
      if (!is_null($oWarehouseFormOutput)) {
         $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
         $oWarehouseFormOutputArticle = new WarehouseFormOutputArticles();
            
         if (FModuleWarehouseManagement::allowUpdateWarehouseFormOutput($nIdForm)) {
            if (isset($_POST['WarehouseFormsOutputs'])) {
               FForm::validateAjaxForm('warehouse-form-output-form', $oWarehouseFormOutput);
               
               try {
                  $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                  $oWarehouseFormOutput->attributes = $_POST['WarehouseFormsOutputs'];

                  if (isset($_POST['WarehouseFormsOutputs']['id_provider'])) {
                     $oProvider = Providers::getProvider($_POST['WarehouseFormsOutputs']['id_provider']);
                     if (!is_null($oProvider)) {
                        $oWarehouseFormOutput->id_provider = $oProvider->id;
                        $oWarehouseFormOutput->provider = $oProvider->name;
                     }
                     else {
                        $oWarehouseFormOutput->id_provider = null;
                        $oWarehouseFormOutput->provider = null;  
                     }
                  }
                  
                  if (isset($_POST['WarehouseFormsOutputs']['code'])) {
                     $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInputByCode($_POST['WarehouseFormsOutputs']['code']);
                     if ((!is_null($oWarehouseFormInput)) && (!is_null($oWarehouseFormInput->id_provider))) {
                        $oWarehouseFormOutput->id_provider = $oWarehouseFormInput->id_provider;
                        
                        $oProvider = Providers::getProvider($oWarehouseFormInput->id_provider);
                        if (!is_null($oProvider)) {
                           $oWarehouseFormOutput->provider = $oProvider->name; 
                        }
                     }
                  }
                            
                  if (isset($_POST['WarehouseFormsOutputs']['id_employee'])) {
                     $oEmployee = Employees::getEmployee($_POST['WarehouseFormsOutputs']['id_employee']);
                     if (!is_null($oEmployee)) {
                        $oWarehouseFormOutput->id_employee = $oEmployee->id;
                        $oWarehouseFormOutput->employee = $oEmployee->full_name;
                        
                        $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                        if (!is_null($oEmployeeDepartment)) { 
                           $oWarehouseFormOutput->employee_department = $oEmployeeDepartment->department;
                        }
                     }  
                  }
                     
                  if (count($oWarehouseFormOutputArticles) == 0) {
                     $bError = true; 
                     Yii::app()->user->setFlash('notice', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_FORM_SUBMIT_ERROR_EMPTY_ARTICLES'));   
                  }
                  
                  if (!$bError) {    
                     if (isset($_POST['WarehouseFormsOutputs']['comments'])) $oWarehouseFormOutput->comments = $_POST['WarehouseFormsOutputs']['comments']; 
                     
                     $oWarehouseFormOutput->data_completed = true;
                     
                     if ($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_PLANT) {
                        $oWarehouseFormOutput->code = null;
                        $oWarehouseFormOutput->id_provider = null;
                        $oWarehouseFormOutput->provider = null;   
                     }
                     else if ($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION) {
                        $oWarehouseFormOutput->id_employee = null;
                        $oWarehouseFormOutput->employee = null;
                        $oWarehouseFormOutput->employee_department = null;
                        $oWarehouseFormOutput->id_form_working_part = null;    
                     }
                     else if (($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR) || ($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT)) {
                        $oWarehouseFormOutput->code = null;
                        $oWarehouseFormOutput->id_employee = null;  
                        $oWarehouseFormOutput->employee = null;
                        $oWarehouseFormOutput->employee_department = null;
                        $oWarehouseFormOutput->id_form_working_part = null;
                     }
                     else {
                        $oWarehouseFormOutput->code = null;
                        $oWarehouseFormOutput->id_provider = null;
                        $oWarehouseFormOutput->provider = null;
                        $oWarehouseFormOutput->id_employee = null;  
                        $oWarehouseFormOutput->employee = null;
                        $oWarehouseFormOutput->employee_department = null;
                        $oWarehouseFormOutput->id_form_working_part = null;
                     }
                     
                     if (!$oWarehouseFormOutput->save()) $bErrorTransaction = true;
                     
                     if (!$bErrorTransaction) {
                        $oTransaction->commit(); 
                     }      
                     else {
                        $oTransaction->rollBack(); 
                     }
                     
                     $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/viewFormsOutputs'));   
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }

            $this->render('updateFormOutput', array('oModelForm'=>$oWarehouseFormOutput, 'oModelFormArticle'=>$oWarehouseFormOutputArticle, 'oModelFormArticles'=>$oWarehouseFormOutputArticles));             
         }  
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));                                                                                                                                                                          
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormOutputArticle($nIdForm) {
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      $oArticle = null;
      $this->layout = null;
      $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_NO_AFTERACTION_ALTERNATIVE;
      $bErrorTransaction = false;
      $nQuantity = 0;
      
      try {
         $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
         if (!is_null($oWarehouseFormOutput)) {
            if (FModuleWarehouseManagement::allowUpdateWarehouseFormOutput($oWarehouseFormOutput->id)) { 
               $oWarehouseFormOutputArticle = new WarehouseFormOutputArticles();
                              
               if (isset($_POST['WarehouseFormOutputArticles'])) {
                  FForm::validateAjaxForm('warehouse-form-output-article-form', $oWarehouseFormOutputArticle);
                  
                  $oWarehouseFormOutputArticle->attributes = $_POST['WarehouseFormOutputArticles'];   
                  
                  if (isset($_POST['WarehouseFormOutputArticles']['quantity'])) {
                     $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                     if (!is_null($oArticle)) {
                        if ($_POST['WarehouseFormOutputArticles']['quantity'] > $oArticle->quantity) {
                           $nQuantity = 0; 
                        }
                        else $nQuantity = $_POST['WarehouseFormOutputArticles']['quantity'];
                     }
                  }
                  
                  if ($nQuantity > 0) {
                     $oWarehouseFormOutputArticleTmp = null;
                     if (isset($_POST['WarehouseFormOutputArticles']['id_article'])) {                                                             
                        $oWarehouseFormOutputArticleTmp = WarehouseFormOutputArticles::getWarehouseFormOutputArticleByIdArticleAndPriceCostAndIdFormFK($_POST['WarehouseFormOutputArticles']['id_article'], $_POST['WarehouseFormOutputArticles']['price_cost'], $oWarehouseFormOutput->id);
                     }

                     if (is_null($oWarehouseFormOutputArticleTmp)) {
                        if (isset($_POST['WarehouseFormOutputArticles']['id_subcategory'])) {
                           $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oWarehouseFormOutputArticle->id_subcategory);
                           if (!is_null($oWarehouseArticleSubcategory)) {
                              $oWarehouseFormOutputArticle->subcategory = $oWarehouseArticleSubcategory->name;
                              $oWarehouseFormOutputArticle->id_category = $oWarehouseArticleSubcategory->category->id;
                              $oWarehouseFormOutputArticle->category = $oWarehouseArticleSubcategory->category->name;
                           }
                        }
                        
                        if (isset($_POST['WarehouseFormOutputArticles']['id_article'])) {
                           $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                           if (!is_null($oArticle)) {
                              $oWarehouseFormOutputArticle->article = $oArticle->name;
                              $oWarehouseFormOutputArticle->article_ipe = $oArticle->ipe;
                              $oWarehouseFormOutputArticle->article_description = $oArticle->description; 
                              $oWarehouseFormOutputArticle->id_location_subcategory = $oArticle->id_location_subcategory; 
                              $oWarehouseFormOutputArticle->location_subcategory = $oArticle->location_subcategory->name;
                           
                              if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->article_code_barcode)) $oWarehouseFormOutputArticle->article_code_barcode = $oArticle->code_barcode;  
                              if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->article_code_kks)) $oWarehouseFormOutputArticle->article_code_kks = $oArticle->code_kks;    
                           }
                        }
                        
                        $oWarehouseFormOutputArticle->quantity = $nQuantity;                      
                        $oWarehouseFormOutputArticle->id_form_output = $oWarehouseFormOutput->id;
                     }
                     else {
                        $oWarehouseFormOutputArticle = $oWarehouseFormOutputArticleTmp;
                        $oWarehouseFormOutputArticle->quantity += $nQuantity;    
                     }  
                  
                     if ($oWarehouseFormOutputArticle->save()) {
                        $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                        if (!is_null($oArticle)) {
                           $oArticle->quantity -= $nQuantity;
                           
                           if ($oArticle->quantity < 0) $bErrorTransaction = true;
                  
                           if (!$bErrorTransaction) {
                              if (!$oArticle->save(false)) $bErrorTransaction = true;
                           }
                        } 
                     }
                  }
                  else $bErrorTransaction = true;    
               }
            }
         }
         
         if (!$bErrorTransaction) {
            $oTransaction->commit(); 
            $sContent = FAjax::STATUS_RESPONSE_YES_REPLACE_YES_AFTERACTION;   
         }      
         else {
            $oTransaction->rollBack(); 
            
            $sContent = FAjax::STATUS_RESPONSE_YES_REPLACE_NO_AFTERACTION;
            
            if (!is_null($oArticle)) {
               $sContent .= '<div class="flash-error">';
               $sContent .= Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUTARTICLE_FORM_SUBMIT_ERROR_NOT_AVAILABLE_ARTICLES', array('{1}'=>$oArticle->name, '{2}'=>$oArticle->quantity));
               $sContent .= '</div>';
            }
         }
      } catch(Exception $e) {
         $oTransaction->rollBack(); 
      }  
      
      $this->renderText($sContent);
   }
   public function actionUpdateFormOutputArticleBarcode($nIdForm) {
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      $oArticle = null;
      $this->layout = FApplication::LAYOUT_POPUP;
      $bErrorTransaction = false;  
      
      if (!is_null($oWarehouseFormOutput)) {
         if (FModuleWarehouseManagement::allowUpdateWarehouseFormOutput($oWarehouseFormOutput->id)) {
            $oWarehouseFormOutputArticle = new WarehouseFormOutputArticles();
            
            if (isset($_POST['WarehouseFormOutputArticles'])) {
               FForm::validateAjaxForm('warehouse-form-output-article-form', $oWarehouseFormOutputArticle);
               
               try {
                  $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
                  
                  $oWarehouseFormOutputArticle->attributes = $_POST['WarehouseFormOutputArticles'];  
                  
                  if (isset($_POST['WarehouseFormOutputArticles']['quantity'])) {
                     $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                     if (!is_null($oArticle)) {
                        if ($_POST['WarehouseFormOutputArticles']['quantity'] > $oArticle->quantity) {
                           $nQuantity = 0; 
                        }
                        else $nQuantity = $_POST['WarehouseFormOutputArticles']['quantity'];
                     }
                  }
                  
                  if ($nQuantity > 0) {
                     $oWarehouseFormOutputArticleTmp = null;
                     if (isset($_POST['WarehouseFormOutputArticles']['id_article'])) {
                        $oWarehouseFormOutputArticleTmp = WarehouseFormOutputArticles::getWarehouseFormOutputArticleByIdArticleAndPriceCostAndIdFormFK($_POST['WarehouseFormOutputArticles']['id_article'], $_POST['WarehouseFormOutputArticles']['price_cost'], $oWarehouseFormOutput->id);
                     }

                     if (is_null($oWarehouseFormOutputArticleTmp)) {
                        if (isset($_POST['WarehouseFormOutputArticles']['id_article'])) {
                           $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                           if (!is_null($oArticle)) {
                              $oWarehouseFormOutputArticle->article = $oArticle->name;
                              $oWarehouseFormOutputArticle->article_ipe = $oArticle->ipe;
                              $oWarehouseFormOutputArticle->article_description = $oArticle->description; 
                              $oWarehouseFormOutputArticle->id_location_subcategory = $oArticle->id_location_subcategory; 
                              $oWarehouseFormOutputArticle->location_subcategory = $oArticle->location_subcategory->name;
                           
                              $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($oArticle->id_subcategory);
                              if (!is_null($oWarehouseArticleSubcategory)) {
                                 $oWarehouseFormOutputArticle->id_subcategory = $oWarehouseArticleSubcategory->id;
                                 $oWarehouseFormOutputArticle->subcategory = $oWarehouseArticleSubcategory->name;
                                 $oWarehouseFormOutputArticle->id_category = $oWarehouseArticleSubcategory->category->id;
                                 $oWarehouseFormOutputArticle->category = $oWarehouseArticleSubcategory->category->name;
                              }

                              if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->article_code_barcode)) $oWarehouseFormOutputArticle->article_code_barcode = $oArticle->code_barcode;  
                              if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->article_code_kks)) $oWarehouseFormOutputArticle->article_code_kks = $oArticle->code_kks;   
                           }
                        }
                        
                        $oWarehouseFormOutputArticle->quantity = $nQuantity;                      
                        $oWarehouseFormOutputArticle->id_form_output = $oWarehouseFormOutput->id;
                     }
                     else {
                        $oWarehouseFormOutputArticle = $oWarehouseFormOutputArticleTmp;
                        $oWarehouseFormOutputArticle->quantity += $nQuantity;    
                     }  
                     
                     if ($oWarehouseFormOutputArticle->save()) {
                        $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                        if (!is_null($oArticle)) {
                           $oArticle->quantity -= $nQuantity;
                                                 
                           if ($oArticle->quantity < 0) $bErrorTransaction = true;
                  
                           if (!$bErrorTransaction) { 
                              if (!$oArticle->save(false)) $bErrorTransaction = true;
                           }
                        } 
                     }
                  }
                  else $bErrorTransaction = true;  
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit();
                     
                     FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUTARTICLEBARCODE_FORM_SUBMIT_SUCCESS', array('{1}'=>$_POST['WarehouseFormOutputArticles']['quantity'], '{2}'=>$oWarehouseFormOutputArticle->article, '{3}'=>$oWarehouseFormOutputArticle->price_cost)));  
                  }      
                  else {
                     $oTransaction->rollBack(); 
                     
                     if (!is_null($oArticle)) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUTARTICLEBARCODE_FORM_SUBMIT_ERROR_NOT_AVAILABLE_ARTICLES', array('{1}'=>$oArticle->name, '{2}'=>$oArticle->quantity)));
                  }
               }   
               catch(Exception $e) {
                  $oTransaction->rollBack(); 
               }
            }
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
           
         $oWarehouseFormOutputArticle->quantity = 1;
         $oWarehouseFormOutputArticle->price_cost = '0.000';
         $oWarehouseFormOutputArticle->article = FString::STRING_EMPTY;
         $oWarehouseFormOutputArticle->location_subcategory = FString::STRING_EMPTY;
         
         $this->render('updateFormOutputArticleBarcode', array('oModelForm'=>$oWarehouseFormOutput, 'oModelFormArticle'=>$oWarehouseFormOutputArticle));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }
   
   
   public function actionDeleteFormInput($nIdForm) {
      $bErrorTransaction = false;
      
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nIdForm);
      if ((!is_null($oWarehouseFormInput)) && ($oWarehouseFormInput->data_completed)) {
         $bAllowDelete = FModuleWarehouseManagement::allowDeleteWarehouseFormInput($oWarehouseFormInput->id);
      
         if ($bAllowDelete) {
            try {
               $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
               $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
               foreach($oWarehouseFormInputArticles as $oWarehouseFormInputArticle) {
                  $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                  if (!is_null($oArticle)) {
                     $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $oWarehouseFormInputArticle->quantity, $oWarehouseFormInputArticle->price_cost, false);
                  
                     $oArticle->quantity -= $oWarehouseFormInputArticle->quantity;

                     if ($oArticle->quantity < 0) $bErrorTransaction = true;
            
                     // If not exist exit article 
                     $oWarehouseFormOutputArticle = WarehouseFormOutputArticles::getLastWarehouseFormOutputArticleByIdArticle($oArticle->id);
                     if ((!is_null($oWarehouseFormOutputArticle)) && ($oWarehouseFormInput->date <= $oWarehouseFormOutputArticle->formOutput->date)) $bErrorTransaction = true;
                                    
                     if (!$bErrorTransaction) { 
                        if (!$oArticle->save(false)) $bErrorTransaction = true;
                     }   
                  } 
               }
               
               if (!$bErrorTransaction) { 
                  if (!$oWarehouseFormInput->delete()) $bErrorTransaction = true; 
               }
               
               if (!$bErrorTransaction) {
                  $oTransaction->commit(); 
               }      
               else {
                  $oTransaction->rollBack(); 
               } 
            } catch(Exception $e) {
               $oTransaction->rollBack(); 
            } 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/viewFormsInputs'));
   }
   public function actionDeleteFormInputArticle($nIdForm, $nIdFormParent) {
      $bErrorTransaction = false;
                                                
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::getWarehouseFormInputArticle($nIdForm);
      if (!is_null($oWarehouseFormInputArticle)) {
         $bAllowDelete = FModuleWarehouseManagement::allowDeleteWarehouseFormInput($oWarehouseFormInputArticle->id_form_input);
         if ($bAllowDelete) {
            try {
               $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
               $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($oWarehouseFormInputArticle->id_form_input);
               if (!is_null($oWarehouseFormInput)) {
                  $oArticle = Articles::getArticle($oWarehouseFormInputArticle->id_article);
                  if (!is_null($oArticle)) {
                     $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $oWarehouseFormInputArticle->quantity, $oWarehouseFormInputArticle->price_cost, false);
                  
                     $oArticle->quantity -= $oWarehouseFormInputArticle->quantity;
                        
                     if ($oArticle->quantity < 0) $bErrorTransaction = true;
                  
                     // If not exist exit article 
                     $oWarehouseFormOutputArticle = WarehouseFormOutputArticles::getLastWarehouseFormOutputArticleByIdArticle($oArticle->id);
                     if ((!is_null($oWarehouseFormOutputArticle)) && ($oWarehouseFormInput->date <= $oWarehouseFormOutputArticle->formOutput->date)) $bErrorTransaction = true;
                        
                     if (!$bErrorTransaction) { 
                        if ($oArticle->save(false)) {
                           if (!$oWarehouseFormInputArticle->delete()) $bErrorTransaction = true;   
                        } 
                        else $bErrorTransaction = true;  
                     } 
                  }    
               }
               
               if (!$bErrorTransaction) {
                  $oTransaction->commit(); 
               }      
               else {
                  $oTransaction->rollBack(); 
               }
            } catch(Exception $e) {
               $oTransaction->rollBack(); 
            } 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInput', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormOutput($nIdForm) {
      $bErrorTransaction = false;
      
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);
      if ((!is_null($oWarehouseFormOutput)) && ($oWarehouseFormOutput->data_completed)) {
         $bAllowDelete = FModuleWarehouseManagement::allowDeleteWarehouseFormOutput($oWarehouseFormOutput->id);
      
         if ($bAllowDelete) {
            try {
               $oTransactionWarehouse = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
               $oTransactionMaintenance = Yii::app()->db_rainbow_plantmaintenancemanagement->beginTransaction();
               
               if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {
                  if (!is_null($oWarehouseFormOutput->id_maintenance_form_task)) {
                     $oMaintenanceFormTask = MaintenanceFormsTasks::getMaintenanceFormTask($oWarehouseFormOutput->id_maintenance_form_task);
                     if (!is_null($oMaintenanceFormTask)) {
                        $oMaintenanceFormTask->id_warehouse_form_output = null;
                        if ($oMaintenanceFormTask->save(false)) {
                           $oMaintenanceFormTaskSupplies = MaintenanceFormTaskSupplies::getMaintenanceFormTaskSuppliesByIdFormFK($oWarehouseFormOutput->id_maintenance_form_task);
                           foreach($oMaintenanceFormTaskSupplies as $oMaintenanceFormTaskSupply) $oMaintenanceFormTaskSupply->delete();   
                        }
                     }   
                  }
               }
               
               $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
               foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
                  $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                  if (!is_null($oArticle)) {         
                     $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $oWarehouseFormOutputArticle->quantity, $oWarehouseFormOutputArticle->price_cost, true);
                  
                     $oArticle->quantity += $oWarehouseFormOutputArticle->quantity;

                     // If not exist input article 
                     $oWarehouseFormInputArticle = WarehouseFormInputArticles::getLastWarehouseFormInputArticleByIdArticle($oArticle->id);
                     if ((!is_null($oWarehouseFormInputArticle)) && ($oWarehouseFormOutput->date <= $oWarehouseFormInputArticle->formInput->date)) $bErrorTransaction = true;
                       
                     if (!$bErrorTransaction) { 
                        if (!$oArticle->save(false)) $bErrorTransaction = true;  
                     } 
                  } 
               }
               
               if (!$bErrorTransaction) { 
                  if (!$oWarehouseFormOutput->delete()) $bErrorTransaction = true; 
               }
                                   
               if (!$bErrorTransaction) {
                  $oTransactionWarehouse->commit(); 
                  $oTransactionMaintenance->commit();
               }      
               else {
                  $oTransactionWarehouse->rollBack();
                  $oTransactionMaintenance->rollBack(); 
               } 
            } catch(Exception $e) {
               $oTransactionWarehouse->rollBack(); 
               $oTransactionMaintenance->rollBack(); 
            } 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED'))); 
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/viewFormsOutputs'));
   }
   public function actionDeleteFormOutputArticle($nIdForm, $nIdFormParent) {
      $bErrorTransaction = false;
                                          
      $oWarehouseFormOutputArticle = WarehouseFormOutputArticles::getWarehouseFormOutputArticle($nIdForm);
      if (!is_null($oWarehouseFormOutputArticle)) {
         $bAllowDelete = FModuleWarehouseManagement::allowDeleteWarehouseFormOutput($oWarehouseFormOutputArticle->id_form_output);
         if ($bAllowDelete) {
            try {
               $oTransaction = Yii::app()->db_rainbow_warehousemanagement->beginTransaction();
               $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($oWarehouseFormOutputArticle->id_form_output);
               if (!is_null($oWarehouseFormOutput)) {
                  $oArticle = Articles::getArticle($oWarehouseFormOutputArticle->id_article);
                  if (!is_null($oArticle)) {
                     $oArticle->price_medium = FModuleWarehouseManagement::recalcWarehouseArticlePriceMedium($oArticle->quantity, $oArticle->price_medium, $oWarehouseFormOutputArticle->quantity, $oWarehouseFormOutputArticle->price_cost, true);
                  
                     $oArticle->quantity += $oWarehouseFormOutputArticle->quantity;

                     // If not exist input article 
                     $oWarehouseFormInputArticle = WarehouseFormInputArticles::getLastWarehouseFormInputArticleByIdArticle($oArticle->id);
                     if ((!is_null($oWarehouseFormInputArticle)) && ($oWarehouseFormOutput->date <= $oWarehouseFormInputArticle->formInput->date)) $bErrorTransaction = true;
                       
                     if (!$bErrorTransaction) { 
                        if ($oArticle->save(false)) {
                           if (!$oWarehouseFormOutputArticle->delete()) $bErrorTransaction = true;   
                        } 
                        else $bErrorTransaction = true;  
                     } 
                  }    
               }
               if (!$bErrorTransaction) {
                  $oTransaction->commit(); 
               }      
               else {
                  $oTransaction->rollBack(); 
               }
            } catch(Exception $e) {
               $oTransaction->rollBack(); 
            } 
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutput', array('nIdForm'=>$nIdFormParent)));
   }
}