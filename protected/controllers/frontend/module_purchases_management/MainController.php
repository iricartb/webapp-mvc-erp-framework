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
            'actions'=>array('viewFormsRequestOffers', 'viewFormsContractingProcedure', 'viewFormsPurchaseOrders', 'viewFormsManagementContractingProcedure', 'viewAttachmentFormRequestOfferLine', 'viewAttachmentFormContractingProcedureLine', 'createFormRequestOffer', 'createFormContractingProcedure', 'createFormContractingProcedureLineObjective', 'createFormPurchaseOrderArticle', 'createFormPurchaseOrderInvoice', 'createFormContractingProcedureDocument', 'createFormContractingProcedureReviewDocument', 'changeStatusFormRequestOffer', 'changeStatusFormContractingProcedure', 'viewDetailFormRequestOffer', 'viewDetailFormContractingProcedure', 'viewDetailFormRequestOfferArticle', 'viewDetailFormContractingProcedureArticle', 'viewDetailFormRequestOfferLine', 'viewDetailFormContractingProcedureLine', 'viewDetailFormPurchaseOrder', 'updateFormRequestOffer', 'updateFormRequestOfferArticle', 'updateFormContractingProcedure', 'updateFormContractingProcedureGeneral', 'updateFormContractingProcedureMoreInformation', 'updateFormContractingProcedureNotifications', 'updateFormContractingProcedureDocumentation', 'updateFormContractingProcedureRecords', 'updateFormContractingProcedureStep1', 'updateFormContractingProcedureStep2', 'updateFormContractingProcedureEndStep', 'updateFormRequestOfferLine', 'updateFormContractingProcedureLine', 'updateFormContractingProcedureLineObjectives', 'updateFormPurchaseOrder', 'updateFormPurchaseOrderInvoices', 'notifyFormRequestOfferLine', 'notifyFormPurchaseOrder', 'selectFormRequestOfferLine', 'selectFormContractingProcedureLine', 'deleteFormRequestOffer', 'deleteFormContractingProcedure', 'deleteFormContractingProcedureDocument', 'deleteFormRequestOfferArticle', 'deleteFormContractingProcedureArticle', 'deleteFormRequestOfferLine', 'deleteFormContractingProcedureLine', 'deleteFormPurchaseOrder', 'deleteFormContractingProcedureLineObjective', 'deleteFormPurchaseOrderArticle', 'deleteFormPurchaseOrderInvoice', 'deleteFormContractingProcedureRecord', 'deleteFormContractingProcedureNotification'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)',
         ),                      
         array('allow',                                                                                                                                          
            'actions'=>array('viewAttachmentOfferFormPurchaseOrder', 'viewAttachmentOrderFormPurchaseOrder', 'viewAttachmentDeliveryFormPurchaseOrder'),
            'expression'=>'Modules::getIsAvaliableModuleByName(FApplication::MODULE_PURCHASES_MANAGEMENT)',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   
   public function actionViewFormsRequestOffers() {
      $oPurchasesFormRequestOffer = new PurchasesFormsRequestOffers();
                   
      // Delete incomplete forms
      $oPurchasesFormsRequestOffers = PurchasesFormsRequestOffers::getPurchasesFormsRequestOffers(false, false, Yii::app()->user->id);
      foreach($oPurchasesFormsRequestOffers as $oPurchasesFormRequestOffer) $oPurchasesFormRequestOffer->delete(); 
      
      $oPurchasesFormRequestOffer->unsetAttributes();
      
      $oPurchasesFormRequestOffer->sFilterStatusCreated = true;
      $oPurchasesFormRequestOffer->sFilterStatusPending = true;        
      $oPurchasesFormRequestOffer->sFilterStatusAccepted = true;
      $oPurchasesFormRequestOffer->sFilterStatusDiscarded = true;
   
      // Filters Grid Get Parameters 
      if (isset($_GET['PurchasesFormsRequestOffers'])) {
         $oPurchasesFormRequestOffer->attributes = $_GET['PurchasesFormsRequestOffers'];
         
         if (isset($_GET['PurchasesFormsRequestOffers']['id'])) $oPurchasesFormRequestOffer->id = $_GET['PurchasesFormsRequestOffers']['id'];
         if (isset($_GET['PurchasesFormsRequestOffers']['department'])) $oPurchasesFormRequestOffer->department = $_GET['PurchasesFormsRequestOffers']['department'];
         if (isset($_GET['PurchasesFormsRequestOffers']['id_financial_cost_line'])) $oPurchasesFormRequestOffer->id_financial_cost_line = $_GET['PurchasesFormsRequestOffers']['id_financial_cost_line'];

         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusCreated'])) $oPurchasesFormRequestOffer->sFilterStatusCreated = $_GET['PurchasesFormsRequestOffers']['sFilterStatusCreated'];
         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusPending'])) $oPurchasesFormRequestOffer->sFilterStatusPending = $_GET['PurchasesFormsRequestOffers']['sFilterStatusPending'];
         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusAccepted'])) $oPurchasesFormRequestOffer->sFilterStatusAccepted = $_GET['PurchasesFormsRequestOffers']['sFilterStatusAccepted'];
         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusDiscarded'])) $oPurchasesFormRequestOffer->sFilterStatusDiscarded = $_GET['PurchasesFormsRequestOffers']['sFilterStatusDiscarded'];
      }

      $this->render('viewFormsRequestOffers', array('oModelForm'=>$oPurchasesFormRequestOffer)); 
   }
   public function actionViewFormsContractingProcedure($date = null) {
      $oPurchasesFormContractingProcedure = new PurchasesFormsRequestOffers();

      // Delete incomplete forms
      $oPurchasesFormsContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormsRequestOffers(true, false, Yii::app()->user->id);
      foreach($oPurchasesFormsContractingProcedure as $oPurchasesFormContractingProcedure) $oPurchasesFormContractingProcedure->delete(); 
      
      $oPurchasesFormContractingProcedure->unsetAttributes();
      
      $oPurchasesFormContractingProcedure->sFilterStatusCreated = true;
      $oPurchasesFormContractingProcedure->sFilterStatusAccepted = true;
      $oPurchasesFormContractingProcedure->sFilterStatusDiscarded = true;
      
      // Filters Grid Get Parameters 
      if (isset($_GET['PurchasesFormsRequestOffers'])) {
         $oPurchasesFormContractingProcedure->attributes = $_GET['PurchasesFormsRequestOffers'];
         
         if (isset($_GET['PurchasesFormsRequestOffers']['id'])) $oPurchasesFormContractingProcedure->id = $_GET['PurchasesFormsRequestOffers']['id'];
         if (isset($_GET['PurchasesFormsRequestOffers']['id_financial_cost_line'])) $oPurchasesFormContractingProcedure->id_financial_cost_line = $_GET['PurchasesFormsRequestOffers']['id_financial_cost_line'];

         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusCreated'])) $oPurchasesFormContractingProcedure->sFilterStatusCreated = $_GET['PurchasesFormsRequestOffers']['sFilterStatusCreated'];
         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusAccepted'])) $oPurchasesFormContractingProcedure->sFilterStatusAccepted = $_GET['PurchasesFormsRequestOffers']['sFilterStatusAccepted'];
         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusDiscarded'])) $oPurchasesFormContractingProcedure->sFilterStatusDiscarded = $_GET['PurchasesFormsRequestOffers']['sFilterStatusDiscarded'];
      }

      $sCalendarYear = date("Y");
      $sCalendarMonth = date("m");
      
      if (!is_null($date)) {
         $oDate = explode('-', $date);
         if (count($oDate) == 2) {
            if ((is_numeric($oDate[0])) && (is_numeric($oDate[1]))) {
               if (($oDate[0] >= FApplication::CALENDAR_MIN_YEAR) && ($oDate[0] <= FApplication::CALENDAR_MAX_YEAR) && ($oDate[1] >= 1) && ($oDate[1] <= 12)) {
                  $sCalendarYear = $oDate[0];
                  $sCalendarMonth = $oDate[1];   
               }
            }   
         }   
      }
            
      $oCalendar = new FWidgetCalendar(FWidgetCalendar::CALENDAR_TYPE_FULL, FString::getFirstToken(Yii::app()->request->getUrl(), '&'), null, '2b5d95');

      $oPurchasesFormsRequestOffersNotifications = PurchasesFormsRequestOffersNotifications::getPurchasesFormsRequestOffersNotificationsByDates($sCalendarYear . '-' . $sCalendarMonth . '-01', $sCalendarYear . '-' . $sCalendarMonth . '-31');
      foreach($oPurchasesFormsRequestOffersNotifications as $oPurchasesFormRequestOfferNotification) {
         if (($oPurchasesFormRequestOfferNotification->public) || ($oPurchasesFormRequestOfferNotification->id_user == Yii::app()->user->id)) {
            $nIdExpedient = 0;
            $oContractingProcedureExpedient = explode('/', $oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient);
            if (count($oContractingProcedureExpedient) == 3) $nIdExpedient = intval($oContractingProcedureExpedient[2]);  
            
            $sEventColor = 'FModulePurchasesManagement::CALENDAR_EVENT_COLOR_' . ($nIdExpedient % 10);

            $oCalendar->addEvent($oPurchasesFormRequestOfferNotification->form_request_offer->contracting_procedure_expedient, $oPurchasesFormRequestOfferNotification->start_date, $oPurchasesFormRequestOfferNotification->end_date, eval('return ' . $sEventColor . ';'), $oPurchasesFormRequestOfferNotification->message);         
         }
      }

      $this->render('viewFormsContractingProcedure', array('oModelForm'=>$oPurchasesFormContractingProcedure, 'oModelFormCalendar'=>$oCalendar, 'sModelFormCalendarYear'=>$sCalendarYear, 'sModelFormCalendarMonth'=>$sCalendarMonth, 'oModelFormsRequestOffersNotifications'=>$oPurchasesFormsRequestOffersNotifications)); 
   }
   public function actionViewFormsPurchaseOrders() {
      $oPurchasesFormPurchaseOrder = new PurchasesFormsPurchaseOrders();
      
      $oPurchasesFormPurchaseOrder->unsetAttributes();
      $oPurchasesFormPurchaseOrder->sFilterStatusPending = true;
      $oPurchasesFormPurchaseOrder->sFilterStatusPartialFinalized = true;
      $oPurchasesFormPurchaseOrder->sFilterStatusFinalized = false;
      
      // Filters Grid Get Parameters 
      if (isset($_GET['PurchasesFormsPurchaseOrders'])) {
         $oPurchasesFormPurchaseOrder->attributes = $_GET['PurchasesFormsPurchaseOrders'];
         
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id'])) $oPurchasesFormPurchaseOrder->id = $_GET['PurchasesFormsPurchaseOrders']['id'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id_provider'])) $oPurchasesFormPurchaseOrder->id_provider = $_GET['PurchasesFormsPurchaseOrders']['id_provider'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['accept_date'])) $oPurchasesFormPurchaseOrder->accept_date = $_GET['PurchasesFormsPurchaseOrders']['accept_date'];
         if (isset($_GET['PurchasesFormsPurchaseOrders']['id_financial_cost_line'])) $oPurchasesFormPurchaseOrder->id_financial_cost_line = $_GET['PurchasesFormsPurchaseOrders']['id_financial_cost_line'];
     
         if ((isset($_GET['PurchasesFormsPurchaseOrders']['sFilterInvoiceNumber'])) && (strlen($_GET['PurchasesFormsPurchaseOrders']['sFilterInvoiceNumber']) > 0)) {
            $oPurchasesFormPurchaseOrder->sFilterInvoiceNumber = $_GET['PurchasesFormsPurchaseOrders']['sFilterInvoiceNumber'];
            $oPurchasesFormPurchaseOrder->sFilterStatusPending = true;
            $oPurchasesFormPurchaseOrder->sFilterStatusPartialFinalized = true;
            $oPurchasesFormPurchaseOrder->sFilterStatusFinalized = true;
         }
         else {
            if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPending'])) $oPurchasesFormPurchaseOrder->sFilterStatusPending = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPending'];
            if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPartialFinalized'])) $oPurchasesFormPurchaseOrder->sFilterStatusPartialFinalized = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusPartialFinalized'];
            if (isset($_GET['PurchasesFormsPurchaseOrders']['sFilterStatusFinalized'])) $oPurchasesFormPurchaseOrder->sFilterStatusFinalized = $_GET['PurchasesFormsPurchaseOrders']['sFilterStatusFinalized'];
         }
      }
      
      $this->render('viewFormsPurchaseOrders', array('oModelForm'=>$oPurchasesFormPurchaseOrder)); 
   }
   public function actionViewFormsManagementContractingProcedure() {
      $oPurchasesFormContractingProcedure = new PurchasesFormsRequestOffers();
      
      $oPurchasesFormContractingProcedure->unsetAttributes();
      $oPurchasesFormContractingProcedure->sFilterStatusControlContractingProcedureFinalized = false;
      
      // Filters Grid Get Parameters 
      if (isset($_GET['PurchasesFormsRequestOffers'])) {
         $oPurchasesFormContractingProcedure->attributes = $_GET['PurchasesFormsRequestOffers'];
         
         if (isset($_GET['PurchasesFormsRequestOffers']['id'])) $oPurchasesFormContractingProcedure->id = $_GET['PurchasesFormsRequestOffers']['id'];
         if (isset($_GET['PurchasesFormsRequestOffers']['accept_date'])) $oPurchasesFormContractingProcedure->accept_date = $_GET['PurchasesFormsRequestOffers']['accept_date'];

         if (isset($_GET['PurchasesFormsRequestOffers']['sFilterStatusControlContractingProcedureFinalized'])) $oPurchasesFormContractingProcedure->sFilterStatusControlContractingProcedureFinalized = $_GET['PurchasesFormsRequestOffers']['sFilterStatusControlContractingProcedureFinalized'];
      }
      
      $this->render('viewFormsManagementContractingProcedure', array('oModelForm'=>$oPurchasesFormContractingProcedure)); 
   }
   public function actionViewAttachmentFormRequestOfferLine($nIdForm) {
     $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
     
     if (!is_null($oPurchasesFormRequestOfferLine)) {
        if ((!FString::isNullOrEmpty($oPurchasesFormRequestOfferLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormRequestOfferLine->offer))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oPurchasesFormRequestOfferLine->offer, '.'), '.' . FString::getLastToken($oPurchasesFormRequestOfferLine->offer, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormRequestOfferLine->offer));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewAttachmentFormContractingProcedureLine($nIdForm) {
     $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
     
     if (!is_null($oPurchasesFormContractingProcedureLine)) {
        if ((!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormContractingProcedureLine->offer))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oPurchasesFormContractingProcedureLine->offer, '.'), '.' . FString::getLastToken($oPurchasesFormContractingProcedureLine->offer, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormContractingProcedureLine->offer));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewAttachmentOfferFormPurchaseOrder($nIdForm) {
     $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
     
     if (!is_null($oPurchasesFormPurchaseOrder)) {
        if ((!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormPurchaseOrder->offer))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oPurchasesFormPurchaseOrder->offer, '.'), '.' . FString::getLastToken($oPurchasesFormPurchaseOrder->offer, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormPurchaseOrder->offer));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewAttachmentOrderFormPurchaseOrder($nIdForm) {
     $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
     
     if (!is_null($oPurchasesFormPurchaseOrder)) {
        if ((!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->order)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $oPurchasesFormPurchaseOrder->order))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oPurchasesFormPurchaseOrder->order, '.'), '.' . FString::getLastToken($oPurchasesFormPurchaseOrder->order, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $oPurchasesFormPurchaseOrder->order));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionViewAttachmentDeliveryFormPurchaseOrder($nIdForm) {
     $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
     
     if (!is_null($oPurchasesFormPurchaseOrder)) {
        if ((!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->delivery)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES . $oPurchasesFormPurchaseOrder->delivery))) {
           $oAttachment = new FDocument(FString::getUntilLastStr($oPurchasesFormPurchaseOrder->delivery, '.'), '.' . FString::getLastToken($oPurchasesFormPurchaseOrder->delivery, '.'), file_get_contents(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES . $oPurchasesFormPurchaseOrder->delivery));
           
           $this->render('../../../generic/viewDocument', array('oModelForm'=>$oAttachment));
        }
        else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
     }
     else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('errTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   
   
   public function actionCreateFormRequestOffer() {
      $oPurchasesFormRequestOffer = new PurchasesFormsRequestOffers();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oPurchasesFormRequestOffer->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oPurchasesFormRequestOffer->description = FString::STRING_EMPTY;
         $oPurchasesFormRequestOffer->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         $oPurchasesFormRequestOffer->contracting_procedure = false;
         
         $oPurchasesFormRequestOffer->start_date = date('Y-m-d H:i:s');
         $oPurchasesFormRequestOffer->id_user = Yii::app()->user->id;
                         
         if ($oPurchasesFormRequestOffer->save(false)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$oPurchasesFormRequestOffer->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   public function actionCreateFormContractingProcedure() {
      $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
      $oPurchasesFormContractingProcedure = new PurchasesFormsRequestOffers();
      $bError = false;
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
      if ($sCurrentUser != FString::STRING_EMPTY) $oPurchasesFormContractingProcedure->owner = $sCurrentUser;
      else $bError = true;
        
      if (!$bError) {
         $oPurchasesFormContractingProcedure->description = FString::STRING_EMPTY;
         $oPurchasesFormContractingProcedure->status = FModuleWorkingPartsManagement::STATUS_CREATED;
         $oPurchasesFormContractingProcedure->contracting_procedure = true;

         $oPurchasesFormContractingProcedure->start_date = date('Y-m-d H:i:s');
         $oPurchasesFormContractingProcedure->id_user = Yii::app()->user->id;
         
         if ($oPurchasesFormContractingProcedure->save(false)) {
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureStep1', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));                 
   }
   public function actionCreateFormContractingProcedureLineObjective($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedureLine)) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedureLineObjectives($nIdForm)) {
            $oPurchasesFormContractingProcedureLineObjective = new PurchasesFormsRequestOffersLinesObjectives();
            $oPurchasesFormContractingProcedureLineObjective->quantity = 1;
            $oPurchasesFormContractingProcedureLineObjective->type = $oPurchasesFormContractingProcedureLine->form_request_offer->contracting_procedure_type;
            $oPurchasesFormContractingProcedureLineObjective->id_user = Yii::app()->user->id;
            $oPurchasesFormContractingProcedureLineObjective->id_form_request_offer_line = $nIdForm;
            
            if ($oPurchasesFormContractingProcedureLineObjective->save(false)) {
               $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($oPurchasesFormContractingProcedureLine->form_request_offer->id);
               if (!is_null($oPurchasesFormRequestOffer)) {
                  $oPurchasesFormRequestOffer->save(false);
               }   
            }
            
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureLineObjectives', array('nIdForm'=>$oPurchasesFormContractingProcedureLine->id)));        
         }   
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionCreateFormPurchaseOrderArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);

      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowUpdateFormPurchaseOrderArticles($nIdForm)) {
            $oPurchasesFormPurchaseOrderArticle = new PurchasesFormsPurchaseOrdersArticles();
            $oPurchasesFormPurchaseOrderArticle->id_form_purchase_order = $nIdForm;

            $oPurchasesFormPurchaseOrderArticle->save(false);  

            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrder', array('nIdForm'=>$oPurchasesFormPurchaseOrder->id)));        
         }   
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionCreateFormPurchaseOrderInvoice($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);

      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowUpdateFormPurchaseOrderInvoices($nIdForm)) {
            $oPurchasesFormPurchaseOrderInvoice = new PurchasesFormsPurchaseOrdersInvoices();
            $oPurchasesFormPurchaseOrderInvoice->id_form_purchase_order = $nIdForm;
            $oPurchasesFormPurchaseOrderInvoice->date = date('Y-m-d');
            
            $oPurchasesFormPurchaseOrderInvoice->save(false);  

            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrderInvoices', array('nIdForm'=>$oPurchasesFormPurchaseOrder->id)));        
         }   
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionCreateFormContractingProcedureDocument($nIdForm) {
      $oPurchasesFormContractingProcedureDocument = new PurchasesFormsRequestOffersDocuments();
      
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedure)) {                                                    
         if (isset($_POST['PurchasesFormsRequestOffersDocuments'])) {         
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('purchases-form-contracting-procedure-document-form', $oPurchasesFormContractingProcedureDocument);
            
            $oPurchasesFormContractingProcedureDocument->name = $_POST['PurchasesFormsRequestOffersDocuments']['name'];

            $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::getPurchasesDocumentContractingProcedureByType($_POST['PurchasesFormsRequestOffersDocuments']['type']);
            if (!is_null($oPurchasesDocumentContractingProcedure)) {
               $oPurchasesFormContractingProcedureDocument->type = $oPurchasesDocumentContractingProcedure->type;    
               $oPurchasesFormContractingProcedureDocument->type_description = $oPurchasesDocumentContractingProcedure->description; 
               $oPurchasesFormContractingProcedureDocument->folder = $oPurchasesDocumentContractingProcedure->folder;   
            }
            
            $oPurchasesFormContractingProcedureDocument->id_user = Yii::app()->user->id;
            $oPurchasesFormContractingProcedureDocument->date = date('Y-m-d H:i:s');
            $oPurchasesFormContractingProcedureDocument->id_form_request_offer = $oPurchasesFormContractingProcedure->id;
            
            $oPurchasesFormContractingProcedureDocument->save();
         }
         
         $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));              
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }  
   public function actionCreateFormContractingProcedureReviewDocument($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdFormParent);
      $oPurchasesFormContractingProcedureDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormRequestOfferDocument($nIdForm);
      $bErrorTransaction = false;
      
      if ((!is_null($oPurchasesFormContractingProcedure)) && (!is_null($oPurchasesFormContractingProcedureDocument))) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($oPurchasesFormContractingProcedure->id)) {
            try {
               $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();

               $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oPurchasesFormContractingProcedure->contracting_procedure_expedient));
               $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;
               
               $oPurchasesFormContractingProcedureReviewDocument = new PurchasesFormsRequestOffersDocuments();
               $oPurchasesFormContractingProcedureReviewDocument->type = $oPurchasesFormContractingProcedureDocument->type;
               $oPurchasesFormContractingProcedureReviewDocument->type_description = $oPurchasesFormContractingProcedureDocument->type_description;
               $oPurchasesFormContractingProcedureReviewDocument->name = $oPurchasesFormContractingProcedureDocument->name;
               $oPurchasesFormContractingProcedureReviewDocument->folder = $oPurchasesFormContractingProcedureDocument->folder;
               
               $oPurchasesFormContractingProcedureReviewDocument->id_user = Yii::app()->user->id;
               $oPurchasesFormContractingProcedureReviewDocument->date = date('Y-m-d H:i:s');
               
               $oPurchasesFormContractingProcedureLastReviewDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersLastChildDocumentByIdFormFK($oPurchasesFormContractingProcedureDocument->id, $oPurchasesFormContractingProcedure->id);
               if (!is_null($oPurchasesFormContractingProcedureLastReviewDocument)) {
                  $oPurchasesFormContractingProcedureReviewDocument->version = ($oPurchasesFormContractingProcedureLastReviewDocument->version + 1);
               }
               else {
                  $oPurchasesFormContractingProcedureReviewDocument->version = 1;
               }
               
               $sFilename = FString::getUntilLastStr($oPurchasesFormContractingProcedureDocument->document, '.') . ' - ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION_ABBREVIATION', array('{1}'=>$oPurchasesFormContractingProcedureReviewDocument->version)) . '.' . FString::getLastToken($oPurchasesFormContractingProcedureDocument->document, '.');
               $oPurchasesFormContractingProcedureReviewDocument->document = $sFilename;
                    
               if (!is_null($oPurchasesFormContractingProcedureLastReviewDocument)) {
                  copy($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureLastReviewDocument->folder . '/' . $oPurchasesFormContractingProcedureLastReviewDocument->document, $sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureLastReviewDocument->folder . '/' . $sFilename);        
               }
               else {
                  copy($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $oPurchasesFormContractingProcedureDocument->document, $sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $sFilename);
               }
                 
               $oPurchasesFormContractingProcedureReviewDocument->id_form_request_offer_document = $oPurchasesFormContractingProcedureDocument->id;
               $oPurchasesFormContractingProcedureReviewDocument->id_form_request_offer = $oPurchasesFormContractingProcedureDocument->id_form_request_offer;
                 
               if (!$oPurchasesFormContractingProcedureReviewDocument->save(false)) $bErrorTransaction = true;
               
               if (!$bErrorTransaction) {
                  $oTransaction->commit(); 
                  
                  $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));
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
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   
  
   public function actionChangeStatusFormRequestOffer($nIdForm) {         
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      $bErrorTransaction = false;
      
      if (!is_null($oPurchasesFormRequestOffer)) {
         if (FModulePurchasesManagement::allowChangeStatusFormRequestOffer($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {                         
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-request-offer-form', $oPurchasesFormRequestOffer);
                 
               try { 
                  $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
                  
                  $oPurchasesFormRequestOffer->status = $_POST['PurchasesFormsRequestOffers']['status'];
                  if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_PENDING) {
                     $oPurchasesFormRequestOffer->accept_date = null;
                     $oPurchasesFormRequestOffer->discard_reason = null;
                     $oPurchasesFormRequestOffer->user_accept_discard = null; 
                  }
                  else if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_DISCARDED) {
                     $oPurchasesFormRequestOffer->accept_date = null;
                     $oPurchasesFormRequestOffer->discard_reason = $_POST['PurchasesFormsRequestOffers']['discard_reason'];
                     
                     $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                     if (!FString::isNullOrEmpty($sCurrentUser)) $oPurchasesFormRequestOffer->user_accept_discard = $sCurrentUser;
                  }
                  else if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
                     $oPurchasesFormRequestOffer->accept_date = date('Y-m-d H:i:s');
                     $oPurchasesFormRequestOffer->discard_reason = null;
                     
                     $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                     if ($sCurrentUser != FString::STRING_EMPTY) $oPurchasesFormRequestOffer->user_accept_discard = $sCurrentUser;  
                     
                     $bFindRequestOfferLineSelected = false;
                     $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($nIdForm);
                     foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLineTmp) {
                        if ($oPurchasesFormRequestOfferLineTmp->selected) {
                           $oPurchasesFormRequestOfferLine = $oPurchasesFormRequestOfferLineTmp;
                           $bFindRequestOfferLineSelected = true;   
                        }
                     }
                     
                     if ($bFindRequestOfferLineSelected) {
                        $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($oPurchasesFormRequestOffer->id_financial_cost_line);
                        if (!is_null($oPurchasesFinancialCostLine)) {
                           if ($oPurchasesFormRequestOfferLine->price < $oPurchasesModuleParameters->range_price_three_offers) {                                                                                                                                                                   
                              Yii::app()->user->setFlash('success', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_CHANGESTATUSFORMREQUESTOFFER_FORM_SELECT_SUCCESS_TYPE_WITHOUT_AUTHORIZATION'));   
                           } 
                        } 
                     }     
                  }
                  
                  if (!$bErrorTransaction) {
                     if ($oPurchasesFormRequestOffer->save()) {
                        if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
                           FModulePurchasesManagement::createFormPurchaseOrderByFormRequestOffer($oPurchasesFormRequestOffer->id);
                           
                           $oUser = Users::getUser(Yii::app()->user->id);
                           if ((!is_null($oUser)) && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) {
                              $oMail = new FMail($oUser->mail_smtp_host, $oUser->mail_smtp_user, $oUser->mail_smtp_passwd, $oUser->mail_smtp_port, $oUser->mail_smtp_ssl);
                                
                              $sSubject = FString::STRING_EMPTY;
                              if (!FString::isNullOrEmpty(Application::getBusinessName())) {
                                 $sSubject = Application::getBusinessName() . ': ';  
                              }
                               
                              $sSubject .= FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_CHANGESTATUSFORMREQUESTOFFER_FORM_NOTIFY_MAIL_SUBJECT')); 
                              $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_CHANGESTATUSFORMREQUESTOFFER_FORM_NOTIFY_MAIL_BODY', array('{1}'=>$oPurchasesFormRequestOffer->description)); 
                                      
                              $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
                              foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLineTmp) { 
                                 if ($oPurchasesFormRequestOfferLineTmp->id != $oPurchasesFormRequestOfferLine->id) {  
                                    if ((!$oPurchasesFormRequestOfferLineTmp->selected) && (!is_null($oPurchasesFormRequestOfferLineTmp->offer))) {
                                       // Send Email
                                       $oProvider = Providers::getProvider($oPurchasesFormRequestOfferLineTmp->id_provider);
                                       $oUser = Users::getUser(Yii::app()->user->id);

                                       if ((!is_null($oProvider)) && (!FString::isNullOrEmpty($oProvider->mail))) {
                                          $oMail->send($oUser->mail_smtp_mail, $oProvider->mail, $sSubject, $sBody, true, $oPurchasesFormRequestOfferLine->form_request_offer->owner);   
                                       }
                                    }         
                                 }
                              }  
                           }
                                       
                           $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_CHANGESTATUSFORMREQUESTOFFER_FORM_NOTIFY_EVENT_STATUS_ACCEPT', array('{1}'=>$sCurrentUser, '{2}'=>$oPurchasesFormRequestOffer->description));
                           
                           Events::addSystemEvent('EVENT_NEW_FORM_REQUEST_OFFER_STATUS_ACCEPT_TITLE', 'EVENT_NEW_FORM_REQUEST_OFFER_STATUS_ACCEPT', $sBody, FApplication::MODULE_PURCHASES_MANAGEMENT, FApplication::MODULE_PURCHASES_MANAGEMENT, null, $oPurchasesFormRequestOffer->id_user);
                        }
                     }
                     else $bErrorTransaction = true;
                  }   
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit(); 
                     
                     $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormRequestOffer', array('nIdForm'=>$oPurchasesFormRequestOffer->id)));
                  }      
                  else {
                     $oTransaction->rollBack(); 
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }
                   
            $this->render('changeStatusFormRequestOffer', array('oModelForm'=>$oPurchasesFormRequestOffer));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   public function actionChangeStatusFormContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (FModulePurchasesManagement::allowChangeStatusFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {  
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-form', $oPurchasesFormContractingProcedure);
                 
               $oPurchasesFormContractingProcedure->status = $_POST['PurchasesFormsRequestOffers']['status'];
               if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_DISCARDED) {
                  $oPurchasesFormContractingProcedure->discard_reason = $_POST['PurchasesFormsRequestOffers']['discard_reason'];
                  
                  $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                  if (!FString::isNullOrEmpty($sCurrentUser)) $oPurchasesFormContractingProcedure->user_accept_discard = $sCurrentUser;
               } 
               else if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_CREATED) {
                  $oPurchasesFormContractingProcedure->accept_date = null;
                  $oPurchasesFormContractingProcedure->discard_reason = null;
                  $oPurchasesFormContractingProcedure->user_accept_discard = null;   
               }
               
               if ($oPurchasesFormContractingProcedure->save()) {
                  $oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormContractingProcedure->id);
                  foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLine) {
                     if ($oPurchasesFormContractingProcedureLine->selected) {
                        $oPurchasesFormContractingProcedureLine->selected = false;
                        $oPurchasesFormContractingProcedureLine->save();
                     }
                  }
               }
               
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormContractingProcedure', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));
            }
            
            $this->render('changeStatusFormContractingProcedure', array('oModelForm'=>$oPurchasesFormContractingProcedure));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionViewDetailFormRequestOffer($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormRequestOffer)) $this->render('viewDetailFormRequestOffer', array('oModelForm'=>$oPurchasesFormRequestOffer));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormContractingProcedure($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) $this->render('viewDetailFormContractingProcedure', array('oModelForm'=>$oPurchasesFormContractingProcedure));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormRequestOfferArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);

      if (!is_null($oPurchasesFormRequestOfferArticle)) $this->render('viewDetailFormRequestOfferArticle', array('oModelForm'=>$oPurchasesFormRequestOfferArticle));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormContractingProcedureArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedureArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedureArticle)) $this->render('viewDetailFormContractingProcedureArticle', array('oModelForm'=>$oPurchasesFormContractingProcedureArticle));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormRequestOfferLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);

      if (!is_null($oPurchasesFormRequestOfferLine)) $this->render('viewDetailFormRequestOfferLine', array('oModelForm'=>$oPurchasesFormRequestOfferLine));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormContractingProcedureLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedureLine)) $this->render('viewDetailFormContractingProcedureLine', array('oModelForm'=>$oPurchasesFormContractingProcedureLine));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailFormPurchaseOrder($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);

      if (!is_null($oPurchasesFormPurchaseOrder)) $this->render('viewDetailFormPurchaseOrder', array('oModelForm'=>$oPurchasesFormPurchaseOrder));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionUpdateFormRequestOffer($nIdForm) {
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      $oPurchasesFormRequestOffer->scenario = 'request_offers';
       
      $oPurchasesFormRequestOfferLine = new PurchasesFormsRequestOffersLines();
      $oPurchasesFormRequestOfferArticle = new PurchasesFormsRequestOffersArticles();
      $oPurchasesFormRequestOfferArticleFilters = new PurchasesFormsRequestOffersArticles();
      $oPurchasesFormRequestOfferLineFilters = new PurchasesFormsRequestOffersLines();
                                
      if (!is_null($oPurchasesFormRequestOffer)) {       
         if (FModulePurchasesManagement::allowUpdateFormRequestOffer($nIdForm)) {     
            if (isset($_POST['PurchasesFormsRequestOffers'])) {    
                // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-request-offer-form', $oPurchasesFormRequestOffer);
            
               $oPurchasesFormRequestOffer->description = $_POST['PurchasesFormsRequestOffers']['description'];
               $oPurchasesFormRequestOffer->id_financial_cost_line = $_POST['PurchasesFormsRequestOffers']['id_financial_cost_line'];
               
               $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($oPurchasesFormRequestOffer->id_financial_cost_line);
               if (!is_null($oPurchasesFinancialCostLine)) {
                  $oPurchasesFormRequestOffer->department = $oPurchasesFinancialCostLine->department;    
               }
               
               $oPurchasesFormRequestOffer->data_completed = true;
               
               $oPurchasesFormRequestOffer->save();
            }
            else if (isset($_POST['PurchasesFormsRequestOffersArticles'])) { 
                // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-request-offer-article-form', $oPurchasesFormRequestOfferArticle);
               
               $oPurchasesFormRequestOfferArticle->attributes = $_POST['PurchasesFormsRequestOffersArticles'];
               $oPurchasesFormRequestOfferArticle->quantity = $_POST['PurchasesFormsRequestOffersArticles']['quantity'];
               $oPurchasesFormRequestOfferArticle->description = $_POST['PurchasesFormsRequestOffersArticles']['description'];
               if ((isset($_POST['PurchasesFormsRequestOffersArticles']['requirements_date'])) && (strlen($_POST['PurchasesFormsRequestOffersArticles']['requirements_date']) > 0)) $oPurchasesFormRequestOfferArticle->requirements_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersArticles']['requirements_date']);
               $oPurchasesFormRequestOfferArticle->id_form_request_offer = $nIdForm;
         
               $oPurchasesFormRequestOfferArticle->save();
            }
            else if (isset($_POST['PurchasesFormsRequestOffersLines'])) { 
                // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-request-offer-line-form', $oPurchasesFormRequestOfferLine);
               
               $oPurchasesFormRequestOfferLine->attributes = $_POST['PurchasesFormsRequestOffersLines'];
               $oPurchasesFormRequestOfferLine->id_provider = $_POST['PurchasesFormsRequestOffersLines']['id_provider'];
               $oPurchasesFormRequestOfferLine->start_date = date('Y-m-d H:i:s');
               $oPurchasesFormRequestOfferLine->id_form_request_offer = $nIdForm;
         
               $oPurchasesFormRequestOfferLineCheck = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLineByProviderAndIdFormFK($oPurchasesFormRequestOfferLine->id_provider, $oPurchasesFormRequestOfferLine->id_form_request_offer);
               if (is_null($oPurchasesFormRequestOfferLineCheck)) {
                  $oPurchasesFormRequestOfferLine->save();
               }
               else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_ERROR_DUPLICATE_PROVIDER'));
            }
            else {
               // Filters Grid Get Parameters
               if (isset($_GET['PurchasesFormsRequestOffersArticles'])) $oPurchasesFormRequestOfferArticleFilters->attributes = $_GET['PurchasesFormsRequestOffersArticles'];  
               
               if (isset($_GET['PurchasesFormsRequestOffersLines'])) $oPurchasesFormRequestOfferLineFilters->attributes = $_GET['PurchasesFormsRequestOffersLines'];  
            }
            
            $oPurchasesFormRequestOfferArticle->unsetAttributes();
            $oPurchasesFormRequestOfferLine->unsetAttributes();
            $oPurchasesFormRequestOfferArticleFilters->unsetAttributes();
            $oPurchasesFormRequestOfferLineFilters->unsetAttributes();
            
            $oPurchasesFormRequestOfferArticle->quantity = 1;
                   
            $this->render('updateFormRequestOffer', array('oModelForm'=>$oPurchasesFormRequestOffer, 'oModelFormRequestOfferLine'=>$oPurchasesFormRequestOfferLine, 'oModelFormRequestOfferArticle'=>$oPurchasesFormRequestOfferArticle, 'oModelFormRequestOfferArticleFilters'=>$oPurchasesFormRequestOfferArticleFilters, 'oModelFormRequestOfferLineFilters'=>$oPurchasesFormRequestOfferLineFilters));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormRequestOfferArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
                               
      if (!is_null($oPurchasesFormRequestOfferArticle)) {
         if (FModulePurchasesManagement::allowUpdateFormRequestOfferArticle($nIdForm)) {
            FForm::validateAjaxForm('purchases-form-request-offer-article-form', $oPurchasesFormRequestOfferArticle);
         
            if (isset($_POST['PurchasesFormsRequestOffersArticles'])) {
               $oPurchasesFormRequestOfferArticle->attributes = $_POST['PurchasesFormsRequestOffersArticles'];
               
               if ((isset($_POST['PurchasesFormsRequestOffersArticles']['requirements_date'])) && (strlen($_POST['PurchasesFormsRequestOffersArticles']['requirements_date']) > 0)) $oPurchasesFormRequestOfferArticle->requirements_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersArticles']['requirements_date']);
               
               $oPurchasesFormRequestOfferArticle->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormRequestOfferArticle', array('nIdForm'=>$oPurchasesFormRequestOfferArticle->id)));
            }
            else $this->render('updateFormRequestOfferArticle', array('oModelForm'=>$oPurchasesFormRequestOfferArticle));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedureStep1($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      
      if (!is_null($oPurchasesFormContractingProcedure)) {
         $oPurchasesFormContractingProcedure->scenario = 'contracting_procedure';
         
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-form', $oPurchasesFormContractingProcedure);
               
               $oPurchasesFormContractingProcedure->attributes = $_POST['PurchasesFormsRequestOffers']; 
               
               if ($oPurchasesFormContractingProcedure->save(false)) {
                  $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureStep2', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));   
               }
            }
            
            $this->render('updateFormContractingProcedureStep1', array('oModelForm'=>$oPurchasesFormContractingProcedure));         
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedureStep2($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      
      if (!is_null($oPurchasesFormContractingProcedure)) {
         $oPurchasesFormContractingProcedure->scenario = 'contracting_procedure';
         
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-form', $oPurchasesFormContractingProcedure);
               
               $oPurchasesFormContractingProcedure->attributes = $_POST['PurchasesFormsRequestOffers']; 
               
               if ($oPurchasesFormContractingProcedure->save(false)) {
                  $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureEndStep', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));   
               }
            }
            
            $this->render('updateFormContractingProcedureStep2', array('oModelForm'=>$oPurchasesFormContractingProcedure));         
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedureEndStep($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
      $bErrorTransaction = false;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      
      if (!is_null($oPurchasesFormContractingProcedure)) {
         $oPurchasesFormContractingProcedure->scenario = 'contracting_procedure';
         
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            try { 
               $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
               
               $sIdExpedient = date('Y') . '/';
               if ($oPurchasesFormContractingProcedure->contracting_procedure_type == FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SERVICE) {
                  $sIdExpedient .= FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SERVICE_ABBREVIATION . '/';   
               }
               else if ($oPurchasesFormContractingProcedure->contracting_procedure_type == FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY) {
                  $sIdExpedient .= FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY_ABBREVIATION . '/';   
               }
               else $sIdExpedient .= FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_WORK_ABBREVIATION . '/';   
               
               $sIdExpedient .= str_pad(FModulePurchasesManagement::getContractingProcedureIdExpedient() + 1, 6, '0', STR_PAD_LEFT);
               
               $oPurchasesFormContractingProcedure->contracting_procedure_expedient = $sIdExpedient;
               $oPurchasesFormContractingProcedure->data_completed = true;
               
               if (!$oPurchasesFormContractingProcedure->save(false)) $bErrorTransaction = true;
               
               if (!$bErrorTransaction) {
                  $oTransaction->commit(); 
               }      
               else {
                  $oTransaction->rollBack(); 
               }
            } catch(Exception $e) {
               $oTransaction->rollBack(); 
            } 
               
            $this->render('updateFormContractingProcedureEndStep', array('oModelForm'=>$oPurchasesFormContractingProcedure));         
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedure($nIdForm) {
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$nIdForm)));
   }
   public function actionUpdateFormContractingProcedureGeneral($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      $oPurchasesFormContractingProcedureLine = new PurchasesFormsRequestOffersLines();
      $oPurchasesFormContractingProcedureLineFilters = new PurchasesFormsRequestOffersLines();

      if (!is_null($oPurchasesFormContractingProcedure)) {
         $oPurchasesFormContractingProcedure->scenario = 'contracting_procedure';
         
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-form', $oPurchasesFormContractingProcedure);
            
               $oPurchasesFormContractingProcedure->description = $_POST['PurchasesFormsRequestOffers']['description'];

               if (isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_expedient_external'])) $oPurchasesFormContractingProcedure->contracting_procedure_expedient_external = $_POST['PurchasesFormsRequestOffers']['contracting_procedure_expedient_external']; 
               
               if (isset($_POST['PurchasesFormsRequestOffers']['id_contracting_procedure'])) $oPurchasesFormContractingProcedure->id_contracting_procedure = $_POST['PurchasesFormsRequestOffers']['id_contracting_procedure'];
               
               if ((isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_project_code'])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffers']['contracting_procedure_project_code']))) $oPurchasesFormContractingProcedure->contracting_procedure_project_code = $_POST['PurchasesFormsRequestOffers']['contracting_procedure_project_code'];
               else $oPurchasesFormContractingProcedure->contracting_procedure_project_code = null;
               
               if ((isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_start_date'])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffers']['contracting_procedure_start_date']))) $oPurchasesFormContractingProcedure->contracting_procedure_start_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffers']['contracting_procedure_start_date']);
               else $oPurchasesFormContractingProcedure->contracting_procedure_start_date = null;
               
               if ((isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_end_date'])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffers']['contracting_procedure_end_date']))) $oPurchasesFormContractingProcedure->contracting_procedure_end_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffers']['contracting_procedure_end_date']);
               else $oPurchasesFormContractingProcedure->contracting_procedure_end_date = null;
           
               $oPurchasesFormContractingProcedure->save();
            }
            else if (isset($_POST['PurchasesFormsRequestOffersLines'])) { 
                // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-line-form', $oPurchasesFormContractingProcedureLine);
               
               $oPurchasesFormContractingProcedureLine->attributes = $_POST['PurchasesFormsRequestOffersLines'];
               $oPurchasesFormContractingProcedureLine->id_provider = $_POST['PurchasesFormsRequestOffersLines']['id_provider'];
               $oPurchasesFormContractingProcedureLine->start_date = date('Y-m-d H:i:s');
               $oPurchasesFormContractingProcedureLine->id_form_request_offer = $nIdForm;
         
               $oPurchasesFormContractingProcedureLineCheck = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLineByProviderAndIdFormFK($oPurchasesFormContractingProcedureLine->id_provider, $oPurchasesFormContractingProcedureLine->id_form_request_offer);
               if (is_null($oPurchasesFormContractingProcedureLineCheck)) {
                  $oPurchasesFormContractingProcedureLine->save();
               }
               else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_ERROR_DUPLICATE_PROVIDER'));
            }
            else {                               
               // Filters Grid Get Parameters
               if (isset($_GET['PurchasesFormsRequestOffersLines'])) $oPurchasesFormContractingProcedureLineFilters->attributes = $_GET['PurchasesFormsRequestOffersLines'];
            }

            $oPurchasesFormContractingProcedureLine->unsetAttributes();
            $oPurchasesFormContractingProcedureLineFilters->unsetAttributes();
         
            $this->render('updateFormContractingProcedureGeneral', array('oModelForm'=>$oPurchasesFormContractingProcedure, 'oModelFormContractingProcedureLine'=>$oPurchasesFormContractingProcedureLine, 'oModelFormContractingProcedureLineFilters'=>$oPurchasesFormContractingProcedureLineFilters));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedureMoreInformation($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) {
         $oPurchasesFormContractingProcedure->scenario = 'contracting_procedure';
         
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffers'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-form', $oPurchasesFormContractingProcedure);
            
               if (isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_service'])) $oPurchasesFormContractingProcedure->contracting_procedure_service = $_POST['PurchasesFormsRequestOffers']['contracting_procedure_service'];
               if (isset($_POST['PurchasesFormsRequestOffers']['contracting_procedure_comments'])) $oPurchasesFormContractingProcedure->contracting_procedure_comments = $_POST['PurchasesFormsRequestOffers']['contracting_procedure_comments'];

               $oPurchasesFormContractingProcedure->save();
            }

            $this->render('updateFormContractingProcedureMoreInformation', array('oModelForm'=>$oPurchasesFormContractingProcedure));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateFormContractingProcedureDocumentation($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      $oPurchasesFormContractingProcedureDocument = new PurchasesFormsRequestOffersDocuments();

      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            if (isset($_POST['PurchasesFormsRequestOffersDocuments'])) {
               if (is_dir(FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/')) {
                  $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oPurchasesFormContractingProcedure->contracting_procedure_expedient));
                  $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;
                  
                  if ((is_dir($sFolderExpedientPath)) || (mkdir($sFolderExpedientPath))) {
                     $nPurchasesFormsContractingProcedureDocuments = count($_POST['PurchasesFormsRequestOffersDocuments']['ID']);
                     
                     for($i = 1; $i <= $nPurchasesFormsContractingProcedureDocuments; $i++) {
                        $nIdPurchasesFormContractingProcedureDocument = $_POST['PurchasesFormsRequestOffersDocuments']['ID'][$i];
                        $oPurchasesFormContractingProcedureDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormRequestOfferDocument($nIdPurchasesFormContractingProcedureDocument);
                        
                        if (!is_null($oPurchasesFormContractingProcedureDocument)) {
                           $oFile = CUploadedFile::getInstanceByName('PurchasesFormsRequestOffersDocuments[document][' . $i . ']'); 
   
                           if ($oFile) {
                              if (!file_exists($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder)) { 
                                 mkdir($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder);     
                              } 
                              
                              if (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder)) {
                                 $sFilename = $oPurchasesFormContractingProcedureDocument->name . '.' . $oFile->getExtensionName();
                                              
                                 if (isset($_POST['PurchasesFormsRequestOffersDocuments']['version'][$i])) {
                                    $sFilename = $oPurchasesFormContractingProcedureDocument->type . ' - ' . $oPurchasesFormContractingProcedureDocument->name . ' - ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION_ABBREVIATION', array('{1}'=>$_POST['PurchasesFormsRequestOffersDocuments']['version'][$i])) . '.' . $oFile->getExtensionName();
                                 }
                                 else {
                                    $sFilename = $oPurchasesFormContractingProcedureDocument->type . ' - ' . $oPurchasesFormContractingProcedureDocument->name . '.' . $oFile->getExtensionName();
                                 }
                                 
                                 if ($oFile->saveAs($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $sFilename)) {
                                    if ((!FString::isNullOrEmpty($oPurchasesFormContractingProcedureDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $oPurchasesFormContractingProcedureDocument->document)) && ($oPurchasesFormContractingProcedureDocument->document != $sFilename)) {
                                       unlink($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $oPurchasesFormContractingProcedureDocument->document);   
                                    }
                                      
                                    $oPurchasesFormContractingProcedureDocument->document = $sFilename;
                                    $oPurchasesFormContractingProcedureDocument->date = date('Y-m-d H:i:s');
                                    $oPurchasesFormContractingProcedureDocument->id_user = Yii::app()->user->id;
                                 }
                              }
                           }
                           
                           $oPurchasesFormContractingProcedureDocument->save(false); 
                        }
                     }
                  }
                  else Yii::app()->user->setFlash('error', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_FORM_ERROR_CREATE_EXPEDIENT_FOLDER'));
               }
            }

            $oPurchasesFormContractingProcedureDocument->unsetAttributes();
            
            $this->render('updateFormContractingProcedureDocumentation', array('oModelForm'=>$oPurchasesFormContractingProcedure, 'oModelFormContractingProcedureDocument'=>$oPurchasesFormContractingProcedureDocument));   
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionUpdateFormContractingProcedureRecords($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            $oPurchasesFormContractingProcedureRecord = new PurchasesFormsRequestOffersRecords();  
            $oPurchasesFormContractingProcedureRecordFilters = new PurchasesFormsRequestOffersRecords();
            $oPurchasesFormContractingProcedureRecordFilters->unsetAttributes();
      
            if (isset($_POST['PurchasesFormsRequestOffersRecords'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-record-form', $oPurchasesFormContractingProcedureRecord);
            
               $oPurchasesFormContractingProcedureRecord->date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersRecords']['date']);
               $oPurchasesFormContractingProcedureRecord->provider = $_POST['PurchasesFormsRequestOffersRecords']['provider'];
               
               $oPurchasesFormContractingProcedureRecord->id_form_request_offer = $oPurchasesFormContractingProcedure->id;
               
               $oPurchasesFormContractingProcedureRecord->save();
            }

            $oPurchasesFormContractingProcedureRecord->unsetAttributes();
            
            $this->render('updateFormContractingProcedureRecords', array('oModelForm'=>$oPurchasesFormContractingProcedure, 'oModelFormContractingProcedureRecord'=>$oPurchasesFormContractingProcedureRecord, 'oModelFormContractingProcedureRecordFilters'=>$oPurchasesFormContractingProcedureRecordFilters));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionUpdateFormContractingProcedureNotifications($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedure($nIdForm)) {
            $oPurchasesFormContractingProcedureNotification = new PurchasesFormsRequestOffersNotifications();  
            $oPurchasesFormContractingProcedureNotificationFilters = new PurchasesFormsRequestOffersNotifications();
            $oPurchasesFormContractingProcedureNotificationFilters->unsetAttributes();
      
            if (isset($_POST['PurchasesFormsRequestOffersNotifications'])) {    
               // Ajax validation request=>Unique validator
               FForm::validateAjaxForm('purchases-form-contracting-procedure-notification-form', $oPurchasesFormContractingProcedureNotification);
            
               $oPurchasesFormContractingProcedureNotification->start_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersNotifications']['start_date']);
               $oPurchasesFormContractingProcedureNotification->end_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersNotifications']['end_date']);
               $oPurchasesFormContractingProcedureNotification->message = $_POST['PurchasesFormsRequestOffersNotifications']['message'];
               $oPurchasesFormContractingProcedureNotification->public = $_POST['PurchasesFormsRequestOffersNotifications']['public'];
               $oPurchasesFormContractingProcedureNotification->id_user = Yii::app()->user->id;
               
               $oPurchasesFormContractingProcedureNotification->id_form_request_offer = $oPurchasesFormContractingProcedure->id;
               
               $oPurchasesFormContractingProcedureNotification->save();
            }

            $oPurchasesFormContractingProcedureNotification->unsetAttributes();
            $oPurchasesFormContractingProcedureNotification->public = true;
            
            $this->render('updateFormContractingProcedureNotifications', array('oModelForm'=>$oPurchasesFormContractingProcedure, 'oModelFormContractingProcedureNotification'=>$oPurchasesFormContractingProcedureNotification, 'oModelFormContractingProcedureNotificationFilters'=>$oPurchasesFormContractingProcedureNotificationFilters));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
   public function actionUpdateFormRequestOfferLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      $bError = false;
                               
      if ((!is_null($oPurchasesFormRequestOfferLine)) && (!is_null($oPurchasesModuleParameters))) {
         if (FModulePurchasesManagement::allowUpdateFormRequestOfferLine($nIdForm)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('purchases-form-request-offer-line-form', $oPurchasesFormRequestOfferLine);
         
            if (isset($_POST['PurchasesFormsRequestOffersLines'])) {
               $oPurchasesFormRequestOfferLine->attributes = $_POST['PurchasesFormsRequestOffersLines'];
               $oPurchasesFormRequestOfferLine->offer = null;
               
               $oFile = CUploadedFile::getInstanceByName('PurchasesFormsRequestOffersLines[offer]');
               if (($oFile) && ($_POST['PurchasesFormsRequestOffersLines']['price'] >= 0) && ($_POST['PurchasesFormsRequestOffersLines']['price'] < $oPurchasesModuleParameters->range_price_three_offers)) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                 
                  $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS;
                  $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                  if ($oFile->saveAs($sOriginalFileUrl)) {
                     $oPurchasesFormRequestOfferLine->offer = $sOriginalFile;
                  }  
               }
               else if ((!$oFile) || ($_POST['PurchasesFormsRequestOffersLines']['price'] < 0)) {
                  $oPurchasesFormRequestOfferLine->price = 0;
                  
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFERLINE_FORM_ERROR_PRICE_AND_OFFER_NOT_NULL')); 
                  $bError = true;        
               }
               else if ($_POST['PurchasesFormsRequestOffersLines']['price'] >= $oPurchasesModuleParameters->range_price_three_offers) {
                  $oPurchasesFormRequestOfferLine->price = 0;
                  
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFERLINE_FORM_ERROR_PRICE_MUST_BE_SMALLER_THAN_THREE_OFFERS_RANGE', array('{1}'=>$oPurchasesModuleParameters->range_price_three_offers))); 
                  $bError = true;   
               }
               
               $oPurchasesFormRequestOfferLine->save();
                 
               if (!$bError) $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormRequestOfferLine', array('nIdForm'=>$oPurchasesFormRequestOfferLine->id)));
            }
            
            $this->render('updateFormRequestOfferLine', array('oModelForm'=>$oPurchasesFormRequestOfferLine));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormContractingProcedureLine($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      $bError = false;
                               
      if ((!is_null($oPurchasesFormContractingProcedureLine)) && (!is_null($oPurchasesModuleParameters))) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedureLine($nIdForm)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('purchases-form-contracting-procedure-line-form', $oPurchasesFormContractingProcedureLine);
         
            if (isset($_POST['PurchasesFormsRequestOffersLines'])) {
               $oPurchasesFormContractingProcedureLine->attributes = $_POST['PurchasesFormsRequestOffersLines'];
               $oPurchasesFormContractingProcedureLine->offer = null;
               
               $oFile = CUploadedFile::getInstanceByName('PurchasesFormsRequestOffersLines[offer]');
               if (($oFile) && ($_POST['PurchasesFormsRequestOffersLines']['price'] >= 0)) {
                  $sOriginalFilename = sha1_file($oFile->tempName);
                  $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                  $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                 
                  $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS;
                  $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                  if ($oFile->saveAs($sOriginalFileUrl)) {
                     $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($oPurchasesFormContractingProcedureLine->id_form_request_offer);
                     if (!is_null($oPurchasesFormContractingProcedure)) {
                        $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oPurchasesFormContractingProcedure->contracting_procedure_expedient));
                        $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;
                  
                        if (is_dir($sFolderExpedientPath)) {
                           if (!file_exists($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure)) {
                              mkdir($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure);
                           }
                           
                           if (file_exists($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure)) { 
                              copy($sOriginalFileUrl, $sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure . '/' . FString::castStrSpecialChars($oFile->getName()));
                           } 
                        }
                     }      

                     $oPurchasesFormContractingProcedureLine->offer = $sOriginalFile;
                  }  
               }
               else if ((!$oFile) || ($_POST['PurchasesFormsRequestOffersLines']['price'] < 0)) {
                  $oPurchasesFormContractingProcedureLine->price = 0;
                  
                  FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINE_FORM_ERROR_PRICE_AND_OFFER_NOT_NULL')); 
                  $bError = true;        
               }
               
               $oPurchasesFormContractingProcedureLine->save();
                 
               if (!$bError) $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormContractingProcedureLine', array('nIdForm'=>$oPurchasesFormContractingProcedureLine->id)));
            }
            
            $this->render('updateFormContractingProcedureLine', array('oModelForm'=>$oPurchasesFormContractingProcedureLine));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormContractingProcedureLineObjectives($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $bNotifyWarehouseSystemEvent = false;
      $bNotifyDepartmentSystemEvent = false;
      $bErrorCreateFormPurchaseOrder = false;
      $bSelectedCreateFormPurchaseOrder = false;
      $nIdFinancialCostLine = null;
      $nTotalPrice = 0;
      $bErrorTransaction = false;
      $sPurchasesFormPurchaseOrderDescription = FString::STRING_EMPTY;
       
      if (!is_null($oPurchasesFormContractingProcedureLine)) {
         if (FModulePurchasesManagement::allowUpdateFormContractingProcedureLineObjectives($nIdForm)) {
            $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($oPurchasesFormContractingProcedureLine->id_form_request_offer);
         
            if (isset($_POST['PurchasesFormsRequestOffersLinesObjectives'])) {
               $nPurchasesFormContractingProcedureLineObjectives = count($_POST['PurchasesFormsRequestOffersLinesObjectives']['ID']);
               
               for($i = 1; $i <= $nPurchasesFormContractingProcedureLineObjectives; $i++) {
                  $nIdPurchasesFormContractingProcedureLineObjective = $_POST['PurchasesFormsRequestOffersLinesObjectives']['ID'][$i];
                  $oPurchasesFormContractingProcedureLineObjective = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormRequestOfferLineObjective($nIdPurchasesFormContractingProcedureLineObjective);
                  
                  if (!is_null($oPurchasesFormContractingProcedureLineObjective)) {
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['type'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['type'][$i]))) $oPurchasesFormContractingProcedureLineObjective->type = $_POST['PurchasesFormsRequestOffersLinesObjectives']['type'][$i];

                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['description'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['description'][$i]))) $oPurchasesFormContractingProcedureLineObjective->description = $_POST['PurchasesFormsRequestOffersLinesObjectives']['description'][$i];
                     else if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['description'][$i])) && (FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['description'][$i]))) $oPurchasesFormContractingProcedureLineObjective->description = null;
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_date'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_date'][$i]))) $oPurchasesFormContractingProcedureLineObjective->estimated_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_date'][$i]); 
                     else $oPurchasesFormContractingProcedureLineObjective->estimated_date = null;
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_price'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_price'][$i]))) $oPurchasesFormContractingProcedureLineObjective->estimated_price = $_POST['PurchasesFormsRequestOffersLinesObjectives']['estimated_price'][$i];
                     else $oPurchasesFormContractingProcedureLineObjective->estimated_price = null;
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_date'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_date'][$i]))) {
                        $oPurchasesFormContractingProcedureLineObjective->accomplished_date = FDate::getEnglishDate($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_date'][$i]);
                        $oPurchasesFormContractingProcedureLineObjective->accomplished = true;
                     }
                     else {
                        $oPurchasesFormContractingProcedureLineObjective->accomplished_date = null;
                        $oPurchasesFormContractingProcedureLineObjective->accomplished = false;
                     }
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['id_financial_cost_line'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['id_financial_cost_line'][$i]))) $oPurchasesFormContractingProcedureLineObjective->id_financial_cost_line = $_POST['PurchasesFormsRequestOffersLinesObjectives']['id_financial_cost_line'][$i];
                     else if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['id_financial_cost_line'][$i])) && (FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['id_financial_cost_line'][$i]))) $oPurchasesFormContractingProcedureLineObjective->id_financial_cost_line = null;
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['quantity'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['quantity'][$i])) && (is_numeric($_POST['PurchasesFormsRequestOffersLinesObjectives']['quantity'][$i])) && ($_POST['PurchasesFormsRequestOffersLinesObjectives']['quantity'][$i] > 0)) {
                        $oPurchasesFormContractingProcedureLineObjective->quantity = $_POST['PurchasesFormsRequestOffersLinesObjectives']['quantity'][$i];                                     
                     }
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i])) && (is_numeric($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i])) && ($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i] >= 0)) $oPurchasesFormContractingProcedureLineObjective->accomplished_price = $_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i];                                     
                     else if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i])) && (FString::isNullOrEmpty($_POST['PurchasesFormsRequestOffersLinesObjectives']['accomplished_price'][$i]))) $oPurchasesFormContractingProcedureLineObjective->accomplished_price = null;

                     $oPurchasesFormContractingProcedureLineObjective->id_user = Yii::app()->user->id;
                     
                     $oPurchasesFormContractingProcedureLineObjective->save(false);
                     
                     if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['bSelected'][$i])) && ($_POST['PurchasesFormsRequestOffersLinesObjectives']['bSelected'][$i])) {
                        $bSelectedCreateFormPurchaseOrder = true;
                        
                        if ((!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineObjective->description)) && (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineObjective->id_financial_cost_line)) && (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineObjective->accomplished_price))) {
                           if ((!is_null($nIdFinancialCostLine)) && ($nIdFinancialCostLine != $oPurchasesFormContractingProcedureLineObjective->id_financial_cost_line)) $bErrorCreateFormPurchaseOrder = true;  
                           
                           $nTotalPrice += $oPurchasesFormContractingProcedureLineObjective->quantity * $oPurchasesFormContractingProcedureLineObjective->accomplished_price;
                           
                           $nIdFinancialCostLine = $oPurchasesFormContractingProcedureLineObjective->id_financial_cost_line;
                           
                           if (strlen($sPurchasesFormPurchaseOrderDescription) > 0) $sPurchasesFormPurchaseOrderDescription += FString::STRING_SPACE . $oPurchasesFormContractingProcedureLineObjective->description; 
                           else $sPurchasesFormPurchaseOrderDescription = $oPurchasesFormContractingProcedureLineObjective->description;  
                        }
                        else $bErrorCreateFormPurchaseOrder = true; 
                     } 
                  }
               }
               
               if (($bSelectedCreateFormPurchaseOrder) && (!$bErrorCreateFormPurchaseOrder)) {
                  try {
                     $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
                           
                     $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdFinancialCostLine);
                     if (!is_null($oPurchasesFinancialCostLine)) {

                        $oPurchasesFormPurchaseOrder = new PurchasesFormsPurchaseOrders();
                                          
                        $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                        $oPurchasesFormPurchaseOrder->owner = $sCurrentUser;
                        
                        $sCurrentUser = Users::getUserEmployeeFullName($oPurchasesFormContractingProcedure->id_user);   
                        $oPurchasesFormPurchaseOrder->user_accept = $sCurrentUser;
                        
                        $oPurchasesFormPurchaseOrder->description = $oPurchasesFormContractingProcedure->description;
                        $oPurchasesFormPurchaseOrder->department = $oPurchasesFinancialCostLine->department;
                        $oPurchasesFormPurchaseOrder->price = $nTotalPrice;
                        $oPurchasesFormPurchaseOrder->offer = $oPurchasesFormContractingProcedureLine->offer; 
                        $oPurchasesFormPurchaseOrder->status = FModulePurchasesManagement::STATUS_PENDING; 
                        $oPurchasesFormPurchaseOrder->accept_date = date('Y-m-d H:i:s');
                        $oPurchasesFormPurchaseOrder->id_provider = $oPurchasesFormContractingProcedureLine->id_provider;
                        $oPurchasesFormPurchaseOrder->id_user = Yii::app()->user->id;
                        $oPurchasesFormPurchaseOrder->id_financial_cost_line = $nIdFinancialCostLine;
                        $oPurchasesFormPurchaseOrder->id_form_request_offer = $oPurchasesFormContractingProcedure->id;

                        if ($oPurchasesFormPurchaseOrder->save(false)) {     
                           for($i = 1; $i <= $nPurchasesFormContractingProcedureLineObjectives; $i++) {
                              $nIdPurchasesFormContractingProcedureLineObjective = $_POST['PurchasesFormsRequestOffersLinesObjectives']['ID'][$i];
                              $oPurchasesFormContractingProcedureLineObjective = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormRequestOfferLineObjective($nIdPurchasesFormContractingProcedureLineObjective);
                              
                              if (!is_null($oPurchasesFormContractingProcedureLineObjective)) {
                                 if ((isset($_POST['PurchasesFormsRequestOffersLinesObjectives']['bSelected'][$i])) && ($_POST['PurchasesFormsRequestOffersLinesObjectives']['bSelected'][$i])) {
                                    $oPurchasesFormPurchaseOrderArticle = new PurchasesFormsPurchaseOrdersArticles();
                                    $oPurchasesFormPurchaseOrderArticle->quantity = $oPurchasesFormContractingProcedureLineObjective->quantity;
                                    $oPurchasesFormPurchaseOrderArticle->description = $oPurchasesFormContractingProcedureLineObjective->description;
                                    
                                    if ($oPurchasesFormContractingProcedureLineObjective->type == FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY) {
                                       $oPurchasesFormPurchaseOrderArticle->service = false;   
                                    }
                                    else $oPurchasesFormPurchaseOrderArticle->service = true;
                                    
                                    if (!$oPurchasesFormPurchaseOrderArticle->service) $bNotifyWarehouseSystemEvent = true;
                                    $bNotifyDepartmentSystemEvent = true;
                                    
                                    $oPurchasesFormPurchaseOrderArticle->price = $oPurchasesFormContractingProcedureLineObjective->accomplished_price;
                                    
                                    $oPurchasesFormPurchaseOrderArticle->id_form_purchase_order = $oPurchasesFormPurchaseOrder->id; 
                                            
                                    if (!$oPurchasesFormPurchaseOrderArticle->save()) $bErrorTransaction = true;
                                 }
                              }
                           }    
                           
                           FModulePurchasesManagement::createFormPurchaseOrderAttachment($oPurchasesFormPurchaseOrder->id);
                           
                           if ($bNotifyWarehouseSystemEvent) Events::addSystemEvent('EVENT_NEW_FORM_PURCHASE_ORDER_TITLE', 'EVENT_NEW_FORM_PURCHASE_ORDER', $oPurchasesFormPurchaseOrder->description, FApplication::MODULE_PURCHASES_MANAGEMENT, FApplication::MODULE_WAREHOUSE_MANAGEMENT, array(array(FApplication::EMPLOYEE_RESPONSABILITY_RESPONSIBLE, FApplication::EMPLOYEE_DEPARTMENT_WAREHOUSE), array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_WAREHOUSE)));
                           if ($bNotifyDepartmentSystemEvent) {
                              $sEmployeeDepartment = FString::STRING_EMPTY; 
                              $oEmployee = Employees::getEmployeeByIdUser($oPurchasesFormPurchaseOrder->id_user);
                              if (!is_null($oEmployee)) {                                           
                                 $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                                 if (!is_null($oEmployeeDepartment)) {
                                    $sEmployeeDepartment = $oEmployeeDepartment->department; 
                                 }
                              }
                  
                              if (!FString::isNullOrEmpty($sEmployeeDepartment)) {
                                 Events::addSystemEvent('EVENT_NEW_FORM_PURCHASE_ORDER_TITLE', 'EVENT_NEW_FORM_PURCHASE_ORDER', $oPurchasesFormPurchaseOrder->description, FApplication::MODULE_PURCHASES_MANAGEMENT, FApplication::MODULE_PURCHASES_MANAGEMENT, array(array(null, $sEmployeeDepartment)));
                              }
                           }
                        } 
                        else {
                           $bErrorTransaction = true;  
                        }
                     } 
                     else $bErrorTransaction = true;
                     
                     if (!$bErrorTransaction) {
                        $oTransaction->commit(); 
                        
                        FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINEOBJECTIVES_FORM_SELECT_SUCCESS', array('{1}'=>$oPurchasesFormPurchaseOrder->id))); 
                     }      
                     else { 
                        $oTransaction->rollBack(); 
                     }
                  } catch(Exception $e) {
                     $oTransaction->rollBack(); 
                  }    
               }
               else {
                  if (($bSelectedCreateFormPurchaseOrder) && ($bErrorCreateFormPurchaseOrder)) FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINEOBJECTIVES_FORM_SELECT_ERROR_NOT_VALID_OBJECTIVES'));    
               }
            }
            
            $this->render('updateFormContractingProcedureLineObjectives', array('oModelForm'=>$oPurchasesFormContractingProcedureLine));      
         }   
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormPurchaseOrder($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $bErrorTransaction = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      $sErrorTransaction = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_MODIFY_ERROR');
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
                     
      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowUpdateFormPurchaseOrder($nIdForm)) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('purchases-form-purchase-order-form', $oPurchasesFormPurchaseOrder);
         
            if (isset($_POST['PurchasesFormsPurchaseOrders'])) {
               try {
                  $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
                  
                  $oPurchasesFormPurchaseOrder->send_method = $_POST['PurchasesFormsPurchaseOrders']['send_method'];
                  $oPurchasesFormPurchaseOrder->payment_method = $_POST['PurchasesFormsPurchaseOrders']['payment_method'];
                  $oPurchasesFormPurchaseOrder->comments = $_POST['PurchasesFormsPurchaseOrders']['comments'];
                  
                  if ((isset($_POST['PurchasesFormsPurchaseOrders']['changes_price'])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsPurchaseOrders']['changes_price']))) {
                     if ((is_numeric($_POST['PurchasesFormsPurchaseOrders']['changes_price'])) && ($_POST['PurchasesFormsPurchaseOrders']['changes_price'] > 0)) {
                        if (!FString::isNullOrEmpty($_POST['PurchasesFormsPurchaseOrders']['changes_reason'])) {
                           $oPurchasesFormPurchaseOrder->changes_reason = $_POST['PurchasesFormsPurchaseOrders']['changes_reason'];
                           $oPurchasesFormPurchaseOrder->changes_price = $_POST['PurchasesFormsPurchaseOrders']['changes_price'];
                           
                           if (($oPurchasesFormPurchaseOrder->form_request_offer->contracting_procedure) && ($_POST['PurchasesFormsPurchaseOrders']['changes_price'] > $oPurchasesFormPurchaseOrder->price) && ($_POST['PurchasesFormsPurchaseOrders']['changes_price'] >= $oPurchasesModuleParameters->range_price_without_authorization)) {
                              $oPurchasesFormPurchaseOrder->changes_pending = true;
                           }
                           else {
                              $oPurchasesFormPurchaseOrder->price = $_POST['PurchasesFormsPurchaseOrders']['changes_price'];
                              $oPurchasesFormPurchaseOrder->changes_pending = false;
                           }
                        }
                        else {
                           $sErrorTransaction = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDER_FORM_MODIFY_ERROR_UPDATE_PRICE');
                           
                           $bErrorTransaction = true;     
                        }
                     }
                     else $bErrorTransaction = true;
                  }
                  
                  if (!$bErrorTransaction) {  
                     if ($_POST['PurchasesFormsPurchaseOrders']['bPartialFinalized']) {
                        if ($oPurchasesFormPurchaseOrder->status != FModulePurchasesManagement::STATUS_FINALIZED) $oPurchasesFormPurchaseOrder->status = FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED;   
                     }
                     else $oPurchasesFormPurchaseOrder->status = FModulePurchasesManagement::STATUS_PENDING;
                     
                     $oFile = CUploadedFile::getInstanceByName('PurchasesFormsPurchaseOrders[delivery]');
                     if ($oFile) {
                        $sOriginalFilename = sha1_file($oFile->tempName);
                        $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
                        $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                       
                        $sPath = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_DELIVERIES;
                        $sOriginalFileUrl = $sPath . $sOriginalFile;
                                 
                        if ($oFile->saveAs($sOriginalFileUrl)) {
                           $oPurchasesFormPurchaseOrder->delivery = $sOriginalFile;
                        }  
                     }
                     
                     if (FModulePurchasesManagement::allowUpdateFormPurchaseOrderArticles($oPurchasesFormPurchaseOrder->id)) {
                        if (isset($_POST['PurchasesFormsPurchaseOrdersArticles'])) {
                           $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($nIdForm);
                           $nPurchasesFormPurchaseOrderArticles = count($_POST['PurchasesFormsPurchaseOrdersArticles']['ID']);
                           
                           for($i = 1; $i <= $nPurchasesFormPurchaseOrderArticles; $i++) {
                              $nIdPurchasesFormPurchaseOrderArticle = $_POST['PurchasesFormsPurchaseOrdersArticles']['ID'][$i];
                              $oPurchasesFormPurchaseOrderArticle = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormPurchaseOrderArticle($nIdPurchasesFormPurchaseOrderArticle);
                              
                              if (!is_null($oPurchasesFormPurchaseOrderArticle)) {
                                 if ((isset($_POST['PurchasesFormsPurchaseOrdersArticles']['quantity'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsPurchaseOrdersArticles']['quantity'][$i])) && (is_numeric($_POST['PurchasesFormsPurchaseOrdersArticles']['quantity'][$i])) && ($_POST['PurchasesFormsPurchaseOrdersArticles']['quantity'][$i] > 0)) $oPurchasesFormPurchaseOrderArticle->quantity = $_POST['PurchasesFormsPurchaseOrdersArticles']['quantity'][$i];  

                                 if (isset($_POST['PurchasesFormsPurchaseOrdersArticles']['description'][$i])) $oPurchasesFormPurchaseOrderArticle->description = $_POST['PurchasesFormsPurchaseOrdersArticles']['description'][$i];   

                                 if ((isset($_POST['PurchasesFormsPurchaseOrdersArticles']['requirements_date'][$i])) && (!FString::isNullOrEmpty($_POST['PurchasesFormsPurchaseOrdersArticles']['requirements_date'][$i]))) $oPurchasesFormPurchaseOrderArticle->requirements_date = FDate::getEnglishDate($_POST['PurchasesFormsPurchaseOrdersArticles']['requirements_date'][$i]);
                                 else $oPurchasesFormPurchaseOrderArticle->requirements_date = null;
                                 
                                 if (isset($_POST['PurchasesFormsPurchaseOrdersArticles']['price'][$i])) $oPurchasesFormPurchaseOrderArticle->price = $_POST['PurchasesFormsPurchaseOrdersArticles']['price'][$i];   
                                 
                                 if (isset($_POST['PurchasesFormsPurchaseOrdersArticles']['comments'][$i])) $oPurchasesFormPurchaseOrderArticle->comments = $_POST['PurchasesFormsPurchaseOrdersArticles']['comments'][$i];   
                              }
                                
                              $oPurchasesFormPurchaseOrderArticle->save(false);   
                           }
                        }
                     }
                      
                     if ($oPurchasesFormPurchaseOrder->save()) {
                        FModulePurchasesManagement::createFormPurchaseOrderAttachment($oPurchasesFormPurchaseOrder->id);
                     }
                     else $bErrorTransaction = true;
                  }
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit(); 
                     
                     $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewDetailFormPurchaseOrder', array('nIdForm'=>$oPurchasesFormPurchaseOrder->id)));
                  }      
                  else { 
                     $oTransaction->rollBack();
                     
                     FFlash::addError($sErrorTransaction);  
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }
            else {
               if (($oPurchasesFormPurchaseOrder->status == FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) || ($oPurchasesFormPurchaseOrder->status == FModulePurchasesManagement::STATUS_FINALIZED)) {
                  $oPurchasesFormPurchaseOrder->bPartialFinalized = true;   
               }  
            }
            
            $oPurchasesFormPurchaseOrder->changes_price = null;
            $oPurchasesFormPurchaseOrder->changes_reason = null;
            
            $this->render('updateFormPurchaseOrder', array('oModelForm'=>$oPurchasesFormPurchaseOrder));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionUpdateFormPurchaseOrderInvoices($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      $bErrorTransaction = false;
      $bNotifySuccess = true;
      $sErrorTransaction = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_MODIFY_ERROR');
      
      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowUpdateFormPurchaseOrderInvoices($nIdForm)) {
            if (isset($_POST['PurchasesFormsPurchaseOrders'])) { 
               try {
                  $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
   
                  if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices'])) {
                     $nTotalSumInvoices = 0; 
                     $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($nIdForm);
                     $nPurchasesFormPurchaseOrderInvoices = count($_POST['PurchasesFormsPurchaseOrdersInvoices']['ID']);

                     for($i = 1; $i <= $nPurchasesFormPurchaseOrderInvoices; $i++) {
                        $nIdPurchasesFormPurchaseOrderInvoice = $_POST['PurchasesFormsPurchaseOrdersInvoices']['ID'][$i];
                        $oPurchasesFormPurchaseOrderInvoice = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormPurchaseOrderInvoice($nIdPurchasesFormPurchaseOrderInvoice);
                        
                        if (!is_null($oPurchasesFormPurchaseOrderInvoice)) {
                           if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['number'][$i])) $oPurchasesFormPurchaseOrderInvoice->number = $_POST['PurchasesFormsPurchaseOrdersInvoices']['number'][$i]; 
                           
                           if ((isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['date'][$i])) && (strlen($_POST['PurchasesFormsPurchaseOrdersInvoices']['date'][$i]) > 0)) $oPurchasesFormPurchaseOrderInvoice->date = FDate::getEnglishDate($_POST['PurchasesFormsPurchaseOrdersInvoices']['date'][$i]);  
                           else $oPurchasesFormPurchaseOrderInvoice->date = null;
                           
                           if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['base'][$i])) {
                              $oPurchasesFormPurchaseOrderInvoice->base = $_POST['PurchasesFormsPurchaseOrdersInvoices']['base'][$i]; 
                              $nTotalSumInvoices += $_POST['PurchasesFormsPurchaseOrdersInvoices']['base'][$i];
                           }
                           
                           if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['iva'][$i])) $oPurchasesFormPurchaseOrderInvoice->iva = $_POST['PurchasesFormsPurchaseOrdersInvoices']['iva'][$i]; 
                           
                           if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['paid'][$i])) $oPurchasesFormPurchaseOrderInvoice->paid = $_POST['PurchasesFormsPurchaseOrdersInvoices']['paid'][$i]; 
                           
                           if (isset($_POST['PurchasesFormsPurchaseOrdersInvoices']['price'][$i])) $oPurchasesFormPurchaseOrderInvoice->price = $_POST['PurchasesFormsPurchaseOrdersInvoices']['price'][$i]; 
                        }
                        
                        if (!$oPurchasesFormPurchaseOrderInvoice->save(false)) $bErrorTransaction = true;   
                     }
                     
                     if ($_POST['PurchasesFormsPurchaseOrders']['bFinalized']) {
                        if ((round($oPurchasesFormPurchaseOrder->price - $nTotalSumInvoices, 2)) < 0) {
                           FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_MODIFY_ERROR_TOTAL_PRICE'));  
                           
                           $bNotifySuccess = false;
                        }
                        else $oPurchasesFormPurchaseOrder->status = FModulePurchasesManagement::STATUS_FINALIZED;   
                     }
                  }
                  else {
                     $sErrorTransaction = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_MODIFY_ERROR_NOT_INSERT_INVOICES');
                     $bErrorTransaction = true;
                  }
                  
                  if (!$bErrorTransaction) {
                     if (!$oPurchasesFormPurchaseOrder->save(false)) $bErrorTransaction = true;
                  }
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit(); 
                     
                     if ($bNotifySuccess) FFlash::addSuccess(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMPURCHASEORDERINVOICES_FORM_MODIFY_SUCCESS'));
                  }      
                  else { 
                     $oTransaction->rollBack();
                     
                     FFlash::addError($sErrorTransaction);  
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }
 
            if ($oPurchasesFormPurchaseOrder->status == FModulePurchasesManagement::STATUS_FINALIZED) {
               $oPurchasesFormPurchaseOrder->bFinalized = true;   
            }  
       
            $this->render('updateFormPurchaseOrderInvoices', array('oModelForm'=>$oPurchasesFormPurchaseOrder));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));          
   }
   
   
   public function actionSelectFormRequestOfferLine($nIdForm, $nIdFormParent) {
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdFormParent);
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      $bNotifyPurchaseFormRequestOffer = false;
      $bRedirectMain = false;
      $bRedirectRequestOffers = false;
      $bErrorTransaction = false;
      
      if ((!is_null($oPurchasesFormRequestOffer)) && (!is_null($oPurchasesFormRequestOfferLine)) && (!is_null($oPurchasesModuleParameters))) {
         if (FModulePurchasesManagement::allowSelectFormRequestOfferLine($nIdForm)) {
            if ($oPurchasesFormRequestOfferLine->selected) {
               $oPurchasesFormRequestOfferLine->selected = false;
               $oPurchasesFormRequestOfferLine->save();
            }  
            else {
               try {
                  $oTransaction = Yii::app()->db_rainbow_purchasesmanagement->beginTransaction();
                  
                  $oPurchasesFormsRequestOffersArticles = PurchasesFormsRequestOffersArticles::getPurchasesFormsRequestOffersArticlesByIdFormFK($nIdFormParent);
                  
                  if (count($oPurchasesFormsRequestOffersArticles) > 0) {
                     $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($oPurchasesFormRequestOffer->id_financial_cost_line);
                     if (!is_null($oPurchasesFinancialCostLine)) {
                        if ($oPurchasesFormRequestOfferLine->price < $oPurchasesModuleParameters->range_price_three_offers) {
                           $oPurchasesFormRequestOfferLine->selected = true; 
                           $bRedirectMain = true;
                        }
                        
                        if ($bRedirectMain) {
                           if ($oPurchasesFormRequestOfferLine->save()) {
                              if ($oPurchasesFormRequestOfferLine->selected) {   
                                 $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
                                 foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLineTmp) {
                                    if ($oPurchasesFormRequestOfferLineTmp->id != $oPurchasesFormRequestOfferLine->id) {  
                                       $oPurchasesFormRequestOfferLineTmp->selected = false;
                                       $oPurchasesFormRequestOfferLineTmp->save();   
                                    }
                                 }   
                              }
                           }
                        }  
                     }
                     
                     if (!$bErrorTransaction) {  
                        if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || ((Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && ($oPurchasesFormRequestOfferLine->price < $oPurchasesModuleParameters->range_price_without_authorization))) {      
                           if ($bRedirectMain) {
                              $oEmployeeMainDepartment = null;
                              $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
                              
                              $oPurchasesFormRequestOfferEmployee = Employees::getEmployeeByIdUser($oPurchasesFormRequestOffer->id_user);
                              if (!is_null($oEmployee)) {
                                 $oEmployeeMainDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                              }
                              
                              if (($oPurchasesFormRequestOfferLine->price < $oPurchasesModuleParameters->range_price_without_authorization) || (is_null($oEmployee)) || ((!is_null($oEmployee)) && (FString::isNullOrEmpty($oEmployee->top_department)) && ($oPurchasesFormRequestOffer->id_user == Yii::app()->user->id)) || ((!is_null($oEmployee)) && ($oPurchasesFormRequestOffer->id_user != Yii::app()->user->id) && (!is_null($oPurchasesFormRequestOfferEmployee)) && (!FString::isNullOrEmpty($oPurchasesFormRequestOfferEmployee->top_department)) && (!is_null($oEmployeeMainDepartment)) && ($oPurchasesFormRequestOfferEmployee->top_department == $oEmployeeMainDepartment->department))) {
                                 $oPurchasesFormRequestOffer->accept_date = date('Y-m-d H:i:s');
                                 $oPurchasesFormRequestOffer->discard_reason = null;
                                 
                                 $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                                 if ($sCurrentUser != FString::STRING_EMPTY) $oPurchasesFormRequestOffer->user_accept_discard = $sCurrentUser; 
                                 
                                 $oPurchasesFormRequestOffer->status = FModulePurchasesManagement::STATUS_ACCEPTED;
                                 
                                 if ($oPurchasesFormRequestOffer->save()) {
                                    if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
                                       FModulePurchasesManagement::createFormPurchaseOrderByFormRequestOffer($oPurchasesFormRequestOffer->id);
                                       
                                       $oUser = Users::getUser(Yii::app()->user->id);
                                       if ((!is_null($oUser)) && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) {
                                          $oMail = new FMail($oUser->mail_smtp_host, $oUser->mail_smtp_user, $oUser->mail_smtp_passwd, $oUser->mail_smtp_port, $oUser->mail_smtp_ssl);
                                            
                                          $sSubject = FString::STRING_EMPTY;
                                          if (!FString::isNullOrEmpty(Application::getBusinessName())) {
                                             $sSubject = Application::getBusinessName() . ': ';  
                                          }
                                           
                                          $sSubject .= FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_SELECTFORMREQUESTOFFERLINE_FORM_NOTIFY_MAIL_SUBJECT')); 
                                          $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_SELECTFORMREQUESTOFFERLINE_FORM_NOTIFY_MAIL_BODY', array('{1}'=>$oPurchasesFormRequestOffer->description)); 
                                                  
                                          $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
                                          foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLineTmp) { 
                                             if ($oPurchasesFormRequestOfferLineTmp->id != $oPurchasesFormRequestOfferLine->id) {  
                                                if ((!$oPurchasesFormRequestOfferLineTmp->selected) && (!is_null($oPurchasesFormRequestOfferLineTmp->offer))) {
                                                   // Send Email
                                                   $oProvider = Providers::getProvider($oPurchasesFormRequestOfferLineTmp->id_provider);
                                                   $oUser = Users::getUser(Yii::app()->user->id);
     
                                                   if ((!is_null($oProvider)) && (!FString::isNullOrEmpty($oProvider->mail))) {
                                                      $oMail->send($oUser->mail_smtp_mail, $oProvider->mail, $sSubject, $sBody, true, $oPurchasesFormRequestOfferLine->form_request_offer->owner);   
                                                   }
                                                }         
                                             }
                                          }  
                                       }
             
                                       Yii::app()->user->setFlash('success-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_SELECT_SUCCESS_TYPE_WITHOUT_AUTHORIZATION'));   
                                    }
                                 }
                                 else $bErrorTransaction = true;  
                              }
                              else {
                                 $oPurchasesFormRequestOffer->status = FModulePurchasesManagement::STATUS_PENDING;
                                 $oPurchasesFormRequestOffer->accept_date = null;
                                 $oPurchasesFormRequestOffer->discard_reason = null;
                                 $oPurchasesFormRequestOffer->user_accept_discard = null; 
                                 
                                 if ($oPurchasesFormRequestOffer->save()) {
                                    $bRedirectRequestOffers = true;
                                    $bNotifyPurchaseFormRequestOffer = true;
                                    
                                    Yii::app()->user->setFlash('notice-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_SELECT_NOTICE_ADMINISTRATOR_VALIDATOR'));     
                                 }
                                 else $bErrorTransaction = true; 
                              }
                           }
                        }
                        else {
                           if ($bRedirectMain) {        
                              $oPurchasesFormRequestOffer->status = FModulePurchasesManagement::STATUS_PENDING;
                              $oPurchasesFormRequestOffer->accept_date = null;
                              $oPurchasesFormRequestOffer->discard_reason = null;
                              $oPurchasesFormRequestOffer->user_accept_discard = null; 
                              
                              if ($oPurchasesFormRequestOffer->save()) {
                                 $bRedirectRequestOffers = true;
                                 $bNotifyPurchaseFormRequestOffer = true;
                                                          
                                 Yii::app()->user->setFlash('notice-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_SELECT_NOTICE_ADMINISTRATOR_VALIDATOR'));     
                              }
                              else $bErrorTransaction = true;
                           }
                        }
                     }
                  }
                  else {
                     $bErrorTransaction = true;
                     
                     Yii::app()->user->setFlash('error-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_SELECT_ERROR_NOT_INSERT_ARTICLES'));  
                  }
                  
                  if (!$bErrorTransaction) {
                     $oTransaction->commit();
                     
                     if ($bNotifyPurchaseFormRequestOffer) {
                        $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
          
                        if (!is_null($oPurchasesModuleParameters)) {
                           $sSubject = FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER')) . ': ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_SELECTFORMREQUESTOFFERLINE_FORM_NOTIFY_MAIL_SUBJECT', array('{1}'=>$oPurchasesFormRequestOffer->owner, '{2}'=>FDate::getTimeZoneFormattedDate(date('Y-m-d'))));
                           $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_SELECTFORMREQUESTOFFERLINE_FORM_NOTIFY_MAIL_BODY', array('{1}'=>$oPurchasesFormRequestOffer->owner, '{2}'=>FDate::getTimeZoneFormattedDate(date('Y-m-d')), '{3}'=>$oPurchasesFormRequestOffer->description));
                         
                           $oMail = new FMail($oPurchasesModuleParameters->notify_smtp_host, $oPurchasesModuleParameters->notify_smtp_user, $oPurchasesModuleParameters->notify_smtp_passwd, $oPurchasesModuleParameters->notify_smtp_port, $oPurchasesModuleParameters->notify_smtp_ssl);
                               
                           $oPurchasesFormRequestOfferEmployee = Employees::getEmployeeByIdUser($oPurchasesFormRequestOffer->id_user);
                           if ((!is_null($oPurchasesFormRequestOfferEmployee)) && (!FString::isNullOrEmpty($oPurchasesFormRequestOfferEmployee->top_department))) {
                              $oUsers = Users::getUsers();
                                          
                              foreach($oUsers as $oUser) {
                                 if (((Users::getIsModuleAdmin($oUser->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser($oUser->id, FApplication::MODULE_PURCHASES_MANAGEMENT))) && (!FString::isNullOrEmpty($oUser->mail_smtp_mail))) {
                                    $oEmployee = Employees::getEmployeeByIdUser($oUser->id);
                                    if (!is_null($oEmployee)) {
                                       $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                                       if ((!is_null($oEmployeeDepartment)) && ($oEmployeeDepartment->responsability == FApplication::EMPLOYEE_RESPONSABILITY_BOSS) && ($oEmployeeDepartment->department == $oPurchasesFormRequestOfferEmployee->top_department)) {
                                          $oMail->send($oPurchasesModuleParameters->notify_smtp_mail, $oUser->mail_smtp_mail, $sSubject, $sBody, true, $oPurchasesModuleParameters->notify_smtp_mail);
                                              
                                          Events::addSystemEvent('EVENT_NEW_FORM_REQUEST_OFFER_STATUS_PENDING_TITLE', 'EVENT_NEW_FORM_REQUEST_OFFER_STATUS_PENDING', $sBody, FApplication::MODULE_PURCHASES_MANAGEMENT, FApplication::MODULE_PURCHASES_MANAGEMENT, null, $oUser->id);
                                       } 
                                    }   
                                 } 
                              }
                           }
                        }  
                     } 
                  }      
                  else {
                     $oTransaction->rollBack(); 
                  }
               } catch(Exception $e) {
                  $oTransaction->rollBack(); 
               } 
            }     
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      if (!$bRedirectMain) $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$nIdFormParent)));
      else {
         if ($bRedirectRequestOffers) $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers')); 
         else $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders')); 
      }
   }
   public function actionSelectFormContractingProcedureLine($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdFormParent);
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();

      if ((!is_null($oPurchasesFormContractingProcedure)) && (!is_null($oPurchasesFormContractingProcedureLine)) && (!is_null($oPurchasesModuleParameters))) {
         if (FModulePurchasesManagement::allowSelectFormContractingProcedureLine($nIdForm)) {
            if ($oPurchasesFormContractingProcedureLine->selected) {
               $oPurchasesFormContractingProcedureLine->selected = false;
               $oPurchasesFormContractingProcedureLine->save();
            }  
            else {
               if (($oPurchasesFormContractingProcedureLine->price < $oPurchasesModuleParameters->range_price_three_offers) || ($oPurchasesFormContractingProcedureLine->price >= $oPurchasesModuleParameters->range_price_tendering)) {
                  $oPurchasesFormContractingProcedureLine->selected = true;

                  Yii::app()->user->setFlash('success-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_SELECT_SUCCESS'));  
               }
               else {
                  // Count valid offers
                  $nCurrentValidOffers = 0;
                  $oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormContractingProcedure->id);
                  foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLineTmp) {
                     if (($oPurchasesFormContractingProcedureLineTmp->price >= 0) && (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineTmp->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormContractingProcedureLineTmp->offer))) $nCurrentValidOffers++;
                  }   
                  
                  $oPurchasesFormContractingProcedureLine->selected = true;
                  
                  if ($nCurrentValidOffers >= 3) {
                     Yii::app()->user->setFlash('success-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_SELECT_SUCCESS'));
                  }
                  else {
                     Yii::app()->user->setFlash('notice-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREGENERAL_FORM_SELECT_ALERT_NOT_3_VALID_OFFERS'));        
                  }  
               }
               
               $oPurchasesFormContractingProcedureLine->save();
            } 
            
            FModulePurchasesManagement::updateStatusFormContractingProcedure($nIdFormParent);      
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$nIdFormParent)));
   }                                 
   
   
   public function actionNotifyFormRequestOfferLine($nIdForm, $nIdFormParent) {
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      $bError = false;
      
      if (!is_null($oPurchasesFormRequestOfferLine)) {
         if (FModulePurchasesManagement::allowNotifyFormRequestOfferLine($nIdForm)) {
             // Send Email
             $oProvider = Providers::getProvider($oPurchasesFormRequestOfferLine->id_provider);
             $oUser = Users::getUser(Yii::app()->user->id);
             if ((!is_null($oProvider)) && (!is_null($oUser)) && (!FString::isNullOrEmpty($oProvider->mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) {
                $oMail = new FMail($oUser->mail_smtp_host, $oUser->mail_smtp_user, $oUser->mail_smtp_passwd, $oUser->mail_smtp_port, $oUser->mail_smtp_ssl);
                
                $sSubject = FString::STRING_EMPTY;
                if (!FString::isNullOrEmpty(Application::getBusinessName())) {
                   $sSubject = Application::getBusinessName() . ': ';  
                }
                
                $sSubject .= FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NOTIFY_MAIL_SUBJECT')); 
                $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NOTIFY_MAIL_BODY', array('{1}'=>$oPurchasesFormRequestOfferLine->id, '{2}'=>Providers::getProviderName($oPurchasesFormRequestOfferLine->id_provider), '{3}'=>$oPurchasesFormRequestOfferLine->form_request_offer->owner)); 
                $sBody .= $oPurchasesFormRequestOfferLine->form_request_offer->description;
                
                $oPurchasesFormsRequestOffersArticles = PurchasesFormsRequestOffersArticles::getPurchasesFormsRequestOffersArticlesByIdFormFK($oPurchasesFormRequestOfferLine->form_request_offer->id);
                if (count($oPurchasesFormsRequestOffersArticles) > 0) {
                   $sBody .= '<br/><br/>';
                   $i = 0;
                   foreach($oPurchasesFormsRequestOffersArticles as $oPurchasesFormRequestOfferArticle) {
                      if (($i % 2) == 0) $sRowColor = '#E5F1F4';
                      else $sRowColor = '#F8F8F8'; 
                      
                      $sBody .= '<div style="display:table; width:900px;"><div style="display:table-row; height:25px; background-color:' . $sRowColor . ';">';
                      $sBody .= '<div style="display:table-cell; text-align:center; vertical-align:middle; width:100px;">' . $oPurchasesFormRequestOfferArticle->quantity . '</div>';
                      $sBody .= '<div style="display:table-cell; vertical-align:middle; width:800px;">' . $oPurchasesFormRequestOfferArticle->description . '</div>';
                      $sBody .= '</div></div>';  
                      
                      $i++;        
                   }
                }
                
                if ($oMail->send($oUser->mail_smtp_mail, $oProvider->mail, $sSubject, $sBody, true, $oPurchasesFormRequestOfferLine->form_request_offer->owner)) {
                   $oPurchasesFormRequestOfferLine->notify_date = date('Y-m-d H:i:s');
                   $oPurchasesFormRequestOfferLine->notify = true;
                   
                   $oPurchasesFormRequestOfferLine->save();
                   
                   $oMail->send($oUser->mail_smtp_mail, $oUser->mail_smtp_mail, $sSubject, $sBody, true, $oPurchasesFormRequestOfferLine->form_request_offer->owner);
                }
                else $bError = true;   
                
                if (!$bError) {
                   Yii::app()->user->setFlash('success-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NOTIFY_SUCCESS'));              
                }
                else Yii::app()->user->setFlash('error-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NOTIFY_ERROR_SEND'));   
             } 
             else Yii::app()->user->setFlash('error-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NOTIFY_ERROR_CONFIGURATION'));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionNotifyFormPurchaseOrder($nIdForm) {
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      $bError = false;
      
      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowNotifyFormPurchaseOrder($nIdForm)) {
            // Send Email
            $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
            $oUser = Users::getUser(Yii::app()->user->id);
            if ((!is_null($oProvider)) && (!is_null($oUser)) && (!FString::isNullOrEmpty($oProvider->mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) {
                $oMail = new FMail($oUser->mail_smtp_host, $oUser->mail_smtp_user, $oUser->mail_smtp_passwd, $oUser->mail_smtp_port, $oUser->mail_smtp_ssl);

                $sSubject = FString::STRING_EMPTY;
                if (!FString::isNullOrEmpty(Application::getBusinessName())) {
                   $sSubject = Application::getBusinessName() . ': ';  
                }
                                
                $sSubject .= FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_MAIL_SUBJECT', array('{1}'=>$oPurchasesFormPurchaseOrder->id)));
                $sBody = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_MAIL_BODY', array('{1}'=>$oPurchasesFormPurchaseOrder->id, '{2}'=>Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider), '{3}'=>$oPurchasesFormPurchaseOrder->owner)); 
                $sBody .= $oPurchasesFormPurchaseOrder->description;

                PHPExcel_Settings::setPdfRenderer(PHPExcel_Settings::PDF_RENDERER_MPDF, Yii::getPathOfAlias('application.components.Mpdf'));
     
                $oPHPExcelReader = PHPExcel_IOFactory::createReader('Excel5');
                $oPHPExcel = FModulePurchasesManagement::createFormPurchaseOrderAttachment($oPurchasesFormPurchaseOrder->id, FFile::FILE_PDF_TYPE);
                            
                /* Style new PDF report */
                $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();          
                            
                $oPHPExcelActiveSheet->setShowGridlines(false);
                
                $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(6.0);
                $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(6.0);

                $oPHPExcelActiveSheet->getStyle('F6:N13')->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                $oPHPExcelActiveSheet->getStyle('P6:S8')->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                $oPHPExcelActiveSheet->getStyle('P11:S13')->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                $oPHPExcelActiveSheet->getStyle('B15:S15')->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));

                $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oPurchasesFormPurchaseOrder->id);
                
                $nPurchaseOrdersArticlesRows = max(count($oPurchasesFormsPurchaseOrdersArticles), 18);
                $nRow = 16;
                for($i = 0; $i < $nPurchaseOrdersArticlesRows; $i++) {
                   $oPHPExcelActiveSheet->getStyle('B' . ($nRow + $i) . ':S' . ($nRow + $i))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'F0F0F0')));
                }
                
                $nRow += $nPurchaseOrdersArticlesRows;

                $oPHPExcelActiveSheet->getStyle('P' . $nRow . ':S' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                
                $nRow += 2;
                $oPHPExcelActiveSheet->getStyle('B' . $nRow . ':J' . ($nRow + 2))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                $oPHPExcelActiveSheet->getStyle('L' . $nRow . ':S' . ($nRow + 2))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                 
                $nRow += 4;
                $oPHPExcelActiveSheet->getStyle('B' . $nRow . ':S' . ($nRow + 3))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E0E0E0')));
                
                $oPHPExcelWriter = new PHPExcel_Writer_PDF($oPHPExcel);
                
                $oPHPExcelWriter->writeAllSheets();
                
                $sPurchaseFormPurchaseOrderDocument = FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . FString::getUntilLastStr($oPurchasesFormPurchaseOrder->order, '.') . strtolower('.' . FFile::FILE_PDF_TYPE);
                
                if (file_exists($sPurchaseFormPurchaseOrderDocument)) {
                   unlink($sPurchaseFormPurchaseOrderDocument);
                }
   
                $oPHPExcelWriter->save($sPurchaseFormPurchaseOrderDocument);
                   
                $oMail->addAttachment($sPurchaseFormPurchaseOrderDocument, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_MAIL_ATTACHMENT_NAME', array('{1}'=>$oPurchasesFormPurchaseOrder->id)));
                
                if ($oMail->send($oUser->mail_smtp_mail, $oProvider->mail, $sSubject, $sBody, true, $oPurchasesFormPurchaseOrder->owner)) {
                   $oPurchasesFormPurchaseOrder->notify_date = date('Y-m-d H:i:s');
                   $oPurchasesFormPurchaseOrder->notify = true;

                   $oPurchasesFormPurchaseOrder->save();  
                   
                   $oMail->send($oUser->mail_smtp_mail, $oUser->mail_smtp_mail, $sSubject, $sBody, true, $oPurchasesFormPurchaseOrder->owner);
                }
                else $bError = true;   
                
                if (!$bError) {
                   Yii::app()->user->setFlash('success-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_SUCCESS'));              
                }
                else Yii::app()->user->setFlash('error-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_ERROR_SEND')); 
            }
            else Yii::app()->user->setFlash('error-generic', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFORMSPURCHASEORDERS_FORM_NOTIFY_ERROR_CONFIGURATION'));    
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders'));    
   }
   
   
   public function actionDeleteFormRequestOffer($nIdForm) {
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      if (!is_null($oPurchasesFormRequestOffer)) {
         if (FModulePurchasesManagement::allowDeleteFormRequestOffer($nIdForm)) $oPurchasesFormRequestOffer->delete();
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsRequestOffers'));
   }
   public function actionDeleteFormContractingProcedure($nIdForm) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      
      if ((!is_null($oPurchasesFormContractingProcedure)) && (!is_null($oPurchasesModuleParameters))) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedure($nIdForm)) {
            $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oPurchasesFormContractingProcedure->contracting_procedure_expedient));
            $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;

            $oPurchasesFormsRequestOffersDocuments = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersDocumentsByIdFormFK($nIdForm);
            foreach($oPurchasesFormsRequestOffersDocuments as $oPurchasesFormRequestOfferDocument) {
               if (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder)) {
                  if ($oHandleDirectory = opendir($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder)) {
                     while (false !== ($sFilename = readdir($oHandleDirectory))) {
                        if (($sFilename != ".") && ($sFilename != "..")) {
                           unlink($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder . '/' . $sFilename);
                        }
                     }
                     closedir($oHandleDirectory);
                  }

                  @rmdir($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferDocument->folder);  
               }  
            }
             
            if (file_exists($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure)) {
               if ($oHandleDirectory = opendir($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure)) {
                  while (false !== ($sFilename = readdir($oHandleDirectory))) {
                     if (($sFilename != ".") && ($sFilename != "..")) {
                        unlink($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure . '/' . $sFilename);
                     }
                  }
                  closedir($oHandleDirectory);
               }
               
               @rmdir($sFolderExpedientPath . '/' . $oPurchasesModuleParameters->folder_contracting_procedure);        
            }
            
            @rmdir($sFolderExpedientPath);       
  
            $oPurchasesFormContractingProcedure->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsContractingProcedure'));
   }
   public function actionDeleteFormRequestOfferArticle($nIdForm, $nIdFormParent) {
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
      if (!is_null($oPurchasesFormRequestOfferArticle)) {
         if (FModulePurchasesManagement::allowDeleteFormRequestOfferArticle($nIdForm)) {
            $oPurchasesFormRequestOfferArticle->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormContractingProcedureArticle($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedureArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedureArticle)) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedureArticle($nIdForm)) {
            $oPurchasesFormContractingProcedureArticle->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormRequestOfferLine($nIdForm, $nIdFormParent) {
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      if (!is_null($oPurchasesFormRequestOfferLine)) {
         if (FModulePurchasesManagement::allowDeleteFormRequestOfferLine($nIdForm)) {
            $oPurchasesFormRequestOfferLine->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormContractingProcedureLine($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedureLine)) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedureLine($nIdForm)) {
            $oPurchasesFormContractingProcedureLine->delete();
            
            FModulePurchasesManagement::updateStatusFormContractingProcedure($nIdFormParent);
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormPurchaseOrder($nIdForm) {
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      if (!is_null($oPurchasesFormPurchaseOrder)) {
         if (FModulePurchasesManagement::allowDeleteFormPurchaseOrder($nIdForm)) {
            $nIdPurchasesFormRequestOffer = $oPurchasesFormPurchaseOrder->id_form_request_offer;
            
            if ($oPurchasesFormPurchaseOrder->delete()) {
               $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdPurchasesFormRequestOffer);
               if ((!is_null($oPurchasesFormRequestOffer)) && (!$oPurchasesFormRequestOffer->contracting_procedure)) {
                  $oPurchasesFormRequestOffer->status = FModulePurchasesManagement::STATUS_CREATED;
                  $oPurchasesFormRequestOffer->accept_date = null;
                  $oPurchasesFormRequestOffer->discard_reason = null;
                  $oPurchasesFormRequestOffer->user_accept_discard = null;
                  
                  if ($oPurchasesFormRequestOffer->save()) {
                     $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
                     foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
                        if ($oPurchasesFormRequestOfferLine->selected) {
                           $oPurchasesFormRequestOfferLine->selected = false;
                           $oPurchasesFormRequestOfferLine->save();
                        }
                     }  
                  }
               }
            }       
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/viewFormsPurchaseOrders'));
   }
   public function actionDeleteFormContractingProcedureLineObjective($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedureLineObjective = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormRequestOfferLineObjective($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedureLineObjective)) {
         $oPurchasesFormContractingProcedureLineObjective->delete();
      }             

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureLineObjectives', array('nIdForm'=>$nIdFormParent)));
   }
   public function actionDeleteFormPurchaseOrderArticle($nIdForm, $nIdFormParent) {
      $oPurchasesFormPurchaseOrderArticle = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormPurchaseOrderArticle($nIdForm);
      if (!is_null($oPurchasesFormPurchaseOrderArticle)) {
         if (FModulePurchasesManagement::allowDeleteFormPurchaseOrderArticles($nIdFormParent)) {
            $oPurchasesFormPurchaseOrderArticle->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
   
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrder', array('nIdForm'=>$nIdFormParent)));        
   }
   public function actionDeleteFormPurchaseOrderInvoice($nIdForm, $nIdFormParent) {
      $oPurchasesFormPurchaseOrderInvoice = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormPurchaseOrderInvoice($nIdForm);
      if (!is_null($oPurchasesFormPurchaseOrderInvoice)) {
         $oPurchasesFormPurchaseOrderInvoice->delete();
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormPurchaseOrderInvoices', array('nIdForm'=>$nIdFormParent)));   
   }
   public function actionDeleteFormContractingProcedureRecord($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedureRecord = PurchasesFormsRequestOffersRecords::getPurchasesFormRequestOfferRecord($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedureRecord)) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedureRecord($nIdForm)) {
            $oPurchasesFormContractingProcedureRecord->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$nIdFormParent)));  
   }
   public function actionDeleteFormContractingProcedureNotification($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedureNotification = PurchasesFormsRequestOffersNotifications::getPurchasesFormRequestOfferNotification($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedureNotification)) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedureNotification($nIdForm)) {
            $oPurchasesFormContractingProcedureNotification->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }

      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$nIdFormParent)));  
   }
   public function actionDeleteFormContractingProcedureDocument($nIdForm, $nIdFormParent) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdFormParent);
      $oPurchasesFormContractingProcedureDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormRequestOfferDocument($nIdForm);
      if ((!is_null($oPurchasesFormContractingProcedure)) && (!is_null($oPurchasesFormContractingProcedureDocument))) {
         if (FModulePurchasesManagement::allowDeleteFormContractingProcedureDocument($oPurchasesFormContractingProcedureDocument->id)) {
            $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oPurchasesFormContractingProcedure->contracting_procedure_expedient));
            $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;
            
            if ((!FString::isNullOrEmpty($oPurchasesFormContractingProcedureDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $oPurchasesFormContractingProcedureDocument->document))) {
               unlink($sFolderExpedientPath . '/' . $oPurchasesFormContractingProcedureDocument->folder . '/' . $oPurchasesFormContractingProcedureDocument->document);   
            }
                                    
            $oPurchasesFormContractingProcedureDocument->delete();

            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oPurchasesFormContractingProcedure->id)));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));   
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
}