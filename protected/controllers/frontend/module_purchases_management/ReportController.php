<?php

class ReportController extends FrontendController {
    
   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewOrders', 'viewInvoices', 'viewTotalInvoices', 'viewTotalConsumption', 'formContractingProcedureRecordExport', 'formContractingProcedureExport'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)',
         ),  
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionFormContractingProcedureExport($nIdForm, $sFormat) {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedure)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_NAME');
         $oPHPExcel = $this->reportExcelFormContractingProcedure($sFilename, $oPurchasesFormContractingProcedure, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionFormContractingProcedureRecordExport($nIdForm, $sFormat) {
      $oPurchasesFormContractingProcedureRecord = PurchasesFormsRequestOffersRecords::getPurchasesFormRequestOfferRecord($nIdForm);

      if (!is_null($oPurchasesFormContractingProcedureRecord)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_NAME');
         $oPHPExcel = $this->reportExcelFormContractingProcedureRecord($sFilename, $oPurchasesFormContractingProcedureRecord, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));  
   }
   public function actionViewOrders() {
      $oPurchasesOrdersForm = new PurchasesOrdersForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('purchases-orders-form', $oPurchasesOrdersForm);
       
      if (isset($_POST['PurchasesOrdersForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_NAME');

         $oPHPExcel = $this->reportExcelOrders($sFilename, $_POST['PurchasesOrdersForm']['nIdProvider'], $_POST['PurchasesOrdersForm']['sOwner'], $_POST['PurchasesOrdersForm']['sDepartment'], FDate::getEnglishDate($_POST['PurchasesOrdersForm']['sStartDate']), FDate::getEnglishDate($_POST['PurchasesOrdersForm']['sEndDate']), $_POST['PurchasesOrdersForm']['bOnlyNotInvoices'], $_POST['PurchasesOrdersForm']['sDocFormat']);
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['PurchasesOrdersForm']['sDocFormat']));            
      }
      else {
         $oPurchasesOrdersForm->sStartDate = date('Y0101');
         $oPurchasesOrdersForm->sEndDate = date('Ymd');       
      }
      
      $this->render('viewOrders', array('oModelForm'=>$oPurchasesOrdersForm));
   }
   public function actionViewInvoices() {
      $oPurchasesInvoicesForm = new PurchasesInvoicesForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('purchases-invoices-form', $oPurchasesInvoicesForm);
       
      if (isset($_POST['PurchasesInvoicesForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_NAME');

         $oPHPExcel = $this->reportExcelInvoices($sFilename, $_POST['PurchasesInvoicesForm']['nIdProvider'], $_POST['PurchasesInvoicesForm']['sDocFormat']);
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['PurchasesInvoicesForm']['sDocFormat']));            
      }
      
      $this->render('viewInvoices', array('oModelForm'=>$oPurchasesInvoicesForm));
   }
   public function actionViewTotalInvoices() {
      $oPurchasesTotalInvoicesForm = new PurchasesTotalInvoicesForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('purchases-total-invoices-form', $oPurchasesTotalInvoicesForm);
       
      if (isset($_POST['PurchasesTotalInvoicesForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_NAME');

         $oPHPExcel = $this->reportExcelTotalInvoices($sFilename, $_POST['PurchasesTotalInvoicesForm']['nIdProvider'], $_POST['PurchasesTotalInvoicesForm']['sStartDate'], FDate::getEnglishDate($_POST['PurchasesTotalInvoicesForm']['sEndDate']), FDate::getEnglishDate($_POST['PurchasesTotalInvoicesForm']['sDocFormat']));
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['PurchasesTotalInvoicesForm']['sDocFormat']));            
      }
      else {
         $oPurchasesTotalInvoicesForm->sStartDate = date('Y0101');
         $oPurchasesTotalInvoicesForm->sEndDate = date('Ymd');       
      }
      
      $this->render('viewTotalInvoices', array('oModelForm'=>$oPurchasesTotalInvoicesForm));
   }
   public function actionViewTotalConsumption() {
      $oPurchasesTotalConsumptionForm = new PurchasesTotalConsumptionForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('purchases-total-consumption-form', $oPurchasesTotalConsumptionForm);
       
      if (isset($_POST['PurchasesTotalConsumptionForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALCONSUMPTION_NAME');

         $oPHPExcel = $this->reportExcelTotalConsumption($sFilename, $_POST['PurchasesTotalConsumptionForm']['nIdProvider'], $_POST['PurchasesTotalConsumptionForm']['nYear'], FDate::getEnglishDate($_POST['PurchasesTotalConsumptionForm']['sDocFormat']));
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['PurchasesTotalConsumptionForm']['sDocFormat']));            
      }
      else {
         $oPurchasesTotalConsumptionForm->nYear = date('Y');  
      }
      
      $this->render('viewTotalConsumption', array('oModelForm'=>$oPurchasesTotalConsumptionForm));
   }
   
   
   private function reportExcelFormContractingProcedure($sFilename, $oPurchasesFormContractingProcedure, $sDocFormat) {   
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
                   
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 12;
      else $nFontSize = 12;

      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getStyle('A:G')->getFont()->setSize($nFontSize);
      
      for ($i = 11; $i < 35; $i++) {
         $oPHPExcelActiveSheet->getRowDimension($i)->setRowHeight(25);  
      }
      
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(20);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(18.13);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(16);
      }
      
      // --> Logo business
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . ($nRow + 7));

      $oImageDrawing = new PHPExcel_Worksheet_Drawing();
      $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
      $oImageDrawing->setCoordinates('C' . $nRow);
      
      $oImageDrawing->setResizeProportional(true);
      $oImageDrawing->setHeight(140);
      $oImageDrawing->setOffsetX(50);
      
      $nRow += 10;
           
      // --> Service
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURESERVICE')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesFormContractingProcedure->contracting_procedure_service, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      $nRow++;
      
      // --> Expedient
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREEXPEDIENT')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesFormContractingProcedure->contracting_procedure_expedient, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FString::castStrToUpper(Yii::t('system', 'SYS_YEAR')) . ':', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, date('Y', strtotime($oPurchasesFormContractingProcedure->contracting_procedure_start_date)), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'D', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'F', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      $nRow++;     
      
      // --> Procedure
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_IDCONTRACTINGPROCEDURE')) . ':', null, null, null, null, true);
      
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::getPurchasesContractingProcedure($oPurchasesFormContractingProcedure->id_contracting_procedure);
      if (!is_null($oPurchasesContractingProcedure)) {
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesContractingProcedure->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      }
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      $nRow++;
      
      // --> Description
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_DESCRIPTION')) . ':', null, null, null, null, true);
   
      $oContractingProcedureDescriptions = explode('<br />', nl2br($oPurchasesFormContractingProcedure->description));
      $i = 0;
      foreach($oContractingProcedureDescriptions as $sContractingProcedureDescription) {
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $sContractingProcedureDescription, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);                                                                                                                                                   
         
         $nRow++;
         $i++;    
      }
      
      if (count($oContractingProcedureDescriptions) < 2) {
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
         $nRow++;
      }
      
      // --> Start date / End date
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURESTARTDATE')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedure->contracting_procedure_start_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREENDDATE')) . ':', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedure->contracting_procedure_end_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'C', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'E', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
      $nRow += 2;
                     
      // --> Comments
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURECOMMENTS')) . ':', null, null, null, null, true);    
      $nRow++;
      
      $oContractingProcedureComments = explode('<br />', nl2br($oPurchasesFormContractingProcedure->contracting_procedure_comments));
      foreach($oContractingProcedureComments as $sContractingProcedureComment) {
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sContractingProcedureComment, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);                                                                                                                                                   
         $nRow++;    
      }
      
      if (count($oContractingProcedureComments) < 10) {
         $nNewBlankLines = 10 - count($oContractingProcedureComments);
         for($i = 0; $i < $nNewBlankLines; $i++) {
            // --> Blank line
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'F', true, FReportExcel::BORDER_STYLE_DOTTED_BOTTOM);
            $nRow++;
         }
      }

      // Line 31-34
      $nRow = 31;
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 3), 'F', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_ARCHIVE')) . ':', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      $nRow++;
      
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_NUM_REG')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_SIGNATURE')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURE_SIGNATURE_2')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      
      return $oPHPExcel;   
   }    
   private function reportExcelFormContractingProcedureRecord($sFilename, $oPurchasesFormContractingProcedureRecord, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
                   
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 12;
      else $nFontSize = 12;

      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 2, 2);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getStyle('A:F')->getFont()->setSize($nFontSize);
      
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(28);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(28);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(21);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(21);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(21);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(22);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(20);
      }
      
      // --> Logo business
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'C' . ($nRow + 3));

      $oImageDrawing = new PHPExcel_Worksheet_Drawing();
      $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
      $oImageDrawing->setCoordinates('A' . $nRow);
      
      $oImageDrawing->setResizeProportional(true);
      $oImageDrawing->setHeight(70);
       
      // --> Identify
      $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + 2) . ':' . 'E' . ($nRow + 3));
      $oPHPExcelActiveSheet->getStyle('D' . ($nRow + 2) . ':' . 'E' . ($nRow + 3))->applyFromArray(
         array(
            'fill'=>array(
               'type'=>PHPExcel_Style_Fill::FILL_SOLID,
               'color'=>array('rgb'=>'F2F2F2')
            )
         )
      );

      FReportExcel::setCellValue($oPHPExcel, 'D' . ($nRow + 2), $oPurchasesFormContractingProcedureRecord->id, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, $nFontSize, null, PHPExcel_Style_Color::COLOR_DARKRED);

      $nRow += 10;
      
      // Data Report
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_HEADER'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize);
      $nRow++;
      
      if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureRecord->form_request_offer->description)) {
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oPurchasesFormContractingProcedureRecord->form_request_offer->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize, true);

         $nRow += 3;   
      }
      else $nRow += 2;   
      
      // Data Report - Expedient
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_TITLE_EXPEDIENT') . ':', PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize);
      if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureRecord->form_request_offer->contracting_procedure_expedient_external)) {
         $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'E' . $nRow);  
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, '="' . $oPurchasesFormContractingProcedureRecord->form_request_offer->contracting_procedure_expedient_external . '"', PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize, true); 
      }
      $nRow += 2;
      
      // Data Report - Provider
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_TITLE_PROVIDER') . ':', PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize);
      if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureRecord->provider)) {
         $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'E' . $nRow);  
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $oPurchasesFormContractingProcedureRecord->provider, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize, true); 
      }
      $nRow += 2;
      
      // Data Report - Date
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_TITLE_DATE') . ':', PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize);
      if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureRecord->date)) {
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'E' . $nRow);  
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedureRecord->date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize, true); 
      }
      $nRow += 2;
      
      // Data Report - Time
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_TITLE_TIME') . ':', PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize);
      if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureRecord->date)) {
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'E' . $nRow);  
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::getLastToken($oPurchasesFormContractingProcedureRecord->date, FString::STRING_SPACE), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, $nFontSize, true); 
      }
      $nRow += 8;
      
      // Data Report - End
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . ($nRow + 12));
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMCONTRACRINGPROCEDURERECORD_FOOTER'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, 10, false, null, true); 
      $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setItalic(true);
      
      return $oPHPExcel;   
   }
   private function reportExcelOrders($sFilename, $nIdProvider, $sOwner, $sDepartment, $sStartDate, $sEndDate, $bOnlyNotInvoices, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:L')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(12); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(22);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(50);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(32);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(25);
         $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(55);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(15); 
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(19);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(40);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(28); 
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(11);  
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(13); 
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(25); 
         $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(45); 
      }
      
      // --> Logo business
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'A' . ($nRow + 3));

      $oImageDrawing = new PHPExcel_Worksheet_Drawing();
      $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
      $oImageDrawing->setCoordinates('A' . $nRow);
      
      $oImageDrawing->setResizeProportional(true);
      $oImageDrawing->setHeight(70);
       
      // Title
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'M' . ($nRow + 2));
      if (FString::isNullOrEmpty($sStartDate)) FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_REPORT_HEADER', array('{1}'=>'*', '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      else FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_REPORT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($sStartDate), '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      
      $nRow += 5;
      
      // Header Report
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_ID'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_EMPLOYEE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_DEPARTMENT'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_FINANCIAL_COST'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_SERVICE'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_DATE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PROVIDER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PROVIDER_NIF'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_COMMERCIAL_OFFER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'J' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_DATE_OFFER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PRICE'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PRICE_TOTAL_INVOICES'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PRICE_TOTAL_PAID_INVOICES'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'N' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_PRICE_TOTAL'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESORDERS_HEADER_DESCRIPTION'), null, null, null, null, true);
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'O', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalPrice = 0;
      $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, null, $nIdProvider, $sOwner, $sDepartment, $sStartDate, $sEndDate, $bOnlyNotInvoices);
      foreach($oPurchasesFormsPurchaseOrders as $oPurchasesFormPurchaseOrder) {
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oPurchasesFormPurchaseOrder->id, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesFormPurchaseOrder->owner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('rainbow' , 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oPurchasesFormPurchaseOrder->department), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, PurchasesFinancialCostsLines::getPurchasesFinancialCostLineFullDescription($oPurchasesFormPurchaseOrder->id_financial_cost_line, false), $oPurchasesFormPurchaseOrder->owner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $sServiceMaterial = FString::STRING_EMPTY;
         $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oPurchasesFormPurchaseOrder->id);
         foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
            if (($oPurchasesFormPurchaseOrderArticle->service) && (strpos($sServiceMaterial, 'S') === false)) {
               if (strlen($sServiceMaterial) > 0) $sServiceMaterial = 'S/' . $sServiceMaterial;
               else $sServiceMaterial = 'S';   
            }
            else if ((!$oPurchasesFormPurchaseOrderArticle->service) && (strpos($sServiceMaterial, 'M') === false)) {
               if (strlen($sServiceMaterial) > 0) $sServiceMaterial = $sServiceMaterial . '/M';
               else $sServiceMaterial = 'M';
            }
         }
         
         FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sServiceMaterial, PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrder->accept_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
         if (!is_null($oProvider)) {
            FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oProvider->nif, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         }
         
         $sRequestOfferDate = FString::STRING_EMPTY;
         $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormPurchaseOrder->id_form_request_offer);
         foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
            if ($oPurchasesFormRequestOfferLine->selected) $sRequestOfferDate = $oPurchasesFormRequestOfferLine->start_date;   
         }
         
         if (strlen($sRequestOfferDate) > 0) FReportExcel::setCellValue($oPHPExcel, 'J' . $nRow, FDate::getTimeZoneFormattedDate($sRequestOfferDate), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($oPurchasesFormPurchaseOrder->id_financial_cost_line);
         
         FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FFormat::getFormatPrice(PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderConsumption($oPurchasesFormPurchaseOrder->id)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
         FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, FFormat::getFormatPrice(PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPurchasesFormPurchaseOrder->id, false)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
         FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice(PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPurchasesFormPurchaseOrder->id, true)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
         if (!is_null($oPurchasesFinancialCostLine)) FReportExcel::setCellValue($oPHPExcel, 'N' . $nRow, FFormat::getFormatPrice($oPurchasesFinancialCostLine->max_price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
         FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, $oPurchasesFormPurchaseOrder->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, null, false, null, true);
         
         $nTotalPrice += PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderConsumption($oPurchasesFormPurchaseOrder->id);
         
         $nRow++;   
      }
      
      if (count($oPurchasesFormsPurchaseOrders) > 0) {
         $nRow++;
         
         FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FFormat::getFormatPrice($nTotalPrice) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      }
      
      return $oPHPExcel;
   }  
   private function reportExcelInvoices($sFilename, $nIdProvider, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:K')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(12); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(22);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(32);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(60);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(15); 
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(19);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(28); 
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11);  
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(50); 
      }
      
      // --> Logo business
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'A' . ($nRow + 3));

      $oImageDrawing = new PHPExcel_Worksheet_Drawing();
      $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
      $oImageDrawing->setCoordinates('A' . $nRow);
      
      $oImageDrawing->setResizeProportional(true);
      $oImageDrawing->setHeight(70);
       
      // Title
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'I' . ($nRow + 2));
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_REPORT_HEADER'), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      
      $nRow += 5; 
      
      // Header Report
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_ID'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_EMPLOYEE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_DEPARTMENT'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_INVOICE_NUMBER'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_INVOICE_DATE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_PROVIDER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_PROVIDER_NIF'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_INVOICE_PRICE'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESINVOICES_HEADER_DESCRIPTION'), null, null, null, null, true);
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'I', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalPrice = 0;
      $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesPendingPayment($nIdProvider);
      foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
         $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($oPurchasesFormPurchaseOrderInvoice->id_form_purchase_order);
         
         if (!is_null($oPurchasesFormPurchaseOrder)) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oPurchasesFormPurchaseOrder->id, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesFormPurchaseOrder->owner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('rainbow' , 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oPurchasesFormPurchaseOrder->department), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, $oPurchasesFormPurchaseOrderInvoice->number, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrderInvoice->date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
            if (!is_null($oProvider)) {
               FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $oProvider->nif, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            }
            
            FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, FFormat::getFormatPrice($oPurchasesFormPurchaseOrderInvoice->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, $oPurchasesFormPurchaseOrder->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $nTotalPrice += $oPurchasesFormPurchaseOrderInvoice->price;
            
            $nRow++;
         }   
      }
      
      if (count($oPurchasesFormsPurchaseOrdersInvoices) > 0) {
         $nRow++;
         
         FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, FFormat::getFormatPrice($nTotalPrice) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      }
      
      return $oPHPExcel;
   } 
   private function reportExcelTotalInvoices($sFilename, $nIdProvider, $sStartDate, $sEndDate, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:K')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(12); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(22);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(32);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(60);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(15); 
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(19);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(11);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(28); 
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(11); 
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(11);  
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(50); 
      }
      
      // --> Logo business
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'A' . ($nRow + 3));

      $oImageDrawing = new PHPExcel_Worksheet_Drawing();
      $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
      $oImageDrawing->setCoordinates('A' . $nRow);
      
      $oImageDrawing->setResizeProportional(true);
      $oImageDrawing->setHeight(70);
       
      // Title
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'I' . ($nRow + 2));
      if (FString::isNullOrEmpty($sStartDate)) FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_REPORT_HEADER', array('{1}'=>'*', '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      else FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_REPORT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($sStartDate), '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      
      $nRow += 5; 
      
      // Header Report
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_ID'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_EMPLOYEE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_DEPARTMENT'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_INVOICE_NUMBER'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_INVOICE_DATE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_PROVIDER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_PROVIDER_NIF'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_INVOICE_PRICE'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALINVOICES_HEADER_DESCRIPTION'), null, null, null, null, true);
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'I', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalPrice = 0;
      $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalInvoices($nIdProvider, $sStartDate, $sEndDate);
      foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
         $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($oPurchasesFormPurchaseOrderInvoice->id_form_purchase_order);
         
         if (!is_null($oPurchasesFormPurchaseOrder)) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oPurchasesFormPurchaseOrder->id, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oPurchasesFormPurchaseOrder->owner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('rainbow' , 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oPurchasesFormPurchaseOrder->department), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, $oPurchasesFormPurchaseOrderInvoice->number, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderInvoice->date)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FDate::getTimeZoneFormattedDate($oPurchasesFormPurchaseOrderInvoice->date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
            if (!is_null($oProvider)) {
               FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $oProvider->nif, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            }
            
            FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, FFormat::getFormatPrice($oPurchasesFormPurchaseOrderInvoice->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, $oPurchasesFormPurchaseOrder->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $nTotalPrice += $oPurchasesFormPurchaseOrderInvoice->price;
            
            $nRow++;
         }   
      }
      
      if (count($oPurchasesFormsPurchaseOrdersInvoices) > 0) {
         $nRow++;
         
         FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, FFormat::getFormatPrice($nTotalPrice) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
      }
      
      return $oPHPExcel;
   } 
   private function reportExcelTotalConsumption($sFilename, $nIdProvider, $nYear, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALCONSUMPTION_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:B')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(80); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(40);  
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(80); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(40);  
      }

      // Title
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'A' . ($nRow + 2));
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALCONSUMPTION_REPORT_HEADER', array('{1}'=>$nYear)), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);

      $nRow += 5; 
      
      // Header Report
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALCONSUMPTION_HEADER_PROVIDER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESTOTALCONSUMPTION_HEADER_CONSUMPTION'), null, null, null, null, true);

      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'I', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalPrice = 0;
      if (!FString::isNullOrEmpty($nIdProvider)) {
         $oProvider = Providers::getProvider($nIdProvider);
         if (!is_null($oProvider)) {
            $nProviderConsumption = Providers::getProviderConsumptionByYear($oProvider->id, $nYear, true); 
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper($oProvider->name), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FFormat::getFormatPrice($nProviderConsumption) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
         
            $nTotalPrice += $nProviderConsumption;
            
            $nRow++;
         } 
      }
      else {
         $oProviders = Providers::getProviders();
         foreach($oProviders as $oProvider) {
            $nProviderConsumption = Providers::getProviderConsumptionByYear($oProvider->id, $nYear, true);   
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrToUpper($oProvider->name), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FFormat::getFormatPrice($nProviderConsumption) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);
         
            $nTotalPrice += $nProviderConsumption;
            
            $nRow++;
         }       
      }

      $nRow++;
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FFormat::getFormatPrice($nTotalPrice) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true);

      return $oPHPExcel;
   } 
}