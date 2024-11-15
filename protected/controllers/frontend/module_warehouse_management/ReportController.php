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
            'actions'=>array('formArticleExport', 'formOutputMaterialReleaseAuthorizationExport', 'formOutputMaterialReleaseRepairBenefitExport', 'viewInputsOutputs', 'viewStock', 'viewInventory'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)',
         ),  
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewInputsOutputs() {
      $oWarehouseInputsOutputsForm = new WarehouseInputsOutputsForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('warehouse-inputs-outputs-form', $oWarehouseInputsOutputsForm);
       
      if (isset($_POST['WarehouseInputsOutputsForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_NAME');

         $oPHPExcel = $this->reportExcelInputsOutputs($sFilename, $_POST['WarehouseInputsOutputsForm']['sType'], $_POST['WarehouseInputsOutputsForm']['sSubtype'], $_POST['WarehouseInputsOutputsForm']['nIdArticle'], $_POST['WarehouseInputsOutputsForm']['bOnlyIPE'], null, $_POST['WarehouseInputsOutputsForm']['sProvider'], $_POST['WarehouseInputsOutputsForm']['sEmployee'], $_POST['WarehouseInputsOutputsForm']['nIdSubcategory'], $_POST['WarehouseInputsOutputsForm']['nIdLocation'], FDate::getEnglishDate($_POST['WarehouseInputsOutputsForm']['sStartDate']), FDate::getEnglishDate($_POST['WarehouseInputsOutputsForm']['sEndDate']), $_POST['WarehouseInputsOutputsForm']['sOrder'], $_POST['WarehouseInputsOutputsForm']['sDocFormat']);
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['WarehouseInputsOutputsForm']['sDocFormat']));            
      }
      else {
         $oWarehouseInputsOutputsForm->sStartDate = date('Ym01');
         $oWarehouseInputsOutputsForm->sEndDate = date('Ymd');
         
         if (isset($_GET['WarehouseInputsOutputsForm']['sType'])) {
            if (($_GET['WarehouseInputsOutputsForm']['sType'] == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) || ($_GET['WarehouseInputsOutputsForm']['sType'] == FModuleWarehouseManagement::REPORT_TYPE_OUTPUTS)) {
               $oWarehouseInputsOutputsForm->sType = $_GET['WarehouseInputsOutputsForm']['sType']; 
            }  
         }       
      }
      
      $this->render('viewInputsOutputs', array('oModelForm'=>$oWarehouseInputsOutputsForm));
   }
   public function actionViewStock() {
      $oWarehouseStockForm = new WarehouseStockForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('warehouse-stock-form', $oWarehouseStockForm);
       
      if (isset($_POST['WarehouseStockForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_NAME');

         $oPHPExcel = $this->reportExcelStock($sFilename, $_POST['WarehouseStockForm']['nIdArticle'], null, $_POST['WarehouseStockForm']['sProvider'], $_POST['WarehouseStockForm']['nIdSubcategory'], $_POST['WarehouseStockForm']['nIdLocation'], $_POST['WarehouseStockForm']['bOnlyStock'], $_POST['WarehouseStockForm']['bOnlyAbsolete'], $_POST['WarehouseStockForm']['bOnlyCommonwealth'], $_POST['WarehouseStockForm']['sOrder'], $_POST['WarehouseStockForm']['sDocFormat']);
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['WarehouseStockForm']['sDocFormat']));            
      }
      
      $this->render('viewStock', array('oModelForm'=>$oWarehouseStockForm));
   }
   public function actionViewInventory() {
      $oWarehouseInventoryForm = new WarehouseInventoryForm();
   
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('warehouse-inventory-form', $oWarehouseInventoryForm);
       
      if (isset($_POST['WarehouseInventoryForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_NAME');
                             
         $oPHPExcel = $this->reportExcelInventory($sFilename, $_POST['WarehouseInventoryForm']['nIdArticle'], null, $_POST['WarehouseInventoryForm']['sProvider'], $_POST['WarehouseInventoryForm']['nIdSubcategory'], $_POST['WarehouseInventoryForm']['nIdLocation'], $_POST['WarehouseInventoryForm']['bOnlyAbsolete'], $_POST['WarehouseInventoryForm']['bOnlyCommonwealth'], FDate::getEnglishDate($_POST['WarehouseInventoryForm']['sDate']), $_POST['WarehouseInventoryForm']['sOrder'], $_POST['WarehouseInventoryForm']['sDocFormat']);
                        
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['WarehouseInventoryForm']['sDocFormat']));            
      }
      
      $this->render('viewInventory', array('oModelForm'=>$oWarehouseInventoryForm));
   }
   public function actionFormArticleExport($nIdForm, $sFormat) {
      $oArticle = Articles::getArticle($nIdForm);

      if (!is_null($oArticle)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEARTICLE_NAME');
         $oPHPExcel = $this->reportExcelArticle($sFilename, $oArticle, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionFormOutputMaterialReleaseAuthorizationExport($nIdForm, $sFormat) {
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);

      if (!is_null($oWarehouseFormOutput)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_NAME');
         $oPHPExcel = $this->reportExcelOutputMaterialReleaseAuthorization($sFilename, $oWarehouseFormOutput, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   public function actionFormOutputMaterialReleaseRepairBenefitExport($nIdForm, $sFormat) {
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nIdForm);

      if (!is_null($oWarehouseFormOutput)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_NAME');
         $oPHPExcel = $this->reportExcelOutputMaterialReleaseRepairBenefit($sFilename, $oWarehouseFormOutput, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));    
   }
   
   
   private function reportExcelInputsOutputs($sFilename, $sType, $sSubtype, $nIdArticle, $bOnlyIPE, $nIdProvider, $sProvider, $sEmployee, $nIdSubcategory, $nIdLocation, $sStartDate, $sEndDate, $sOrder, $sDocFormat) {    
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:N')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
       
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(12); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(13);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(9);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(12); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(13.64);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(8.57);  
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
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'N' . ($nRow + 2));
      if (FString::isNullOrEmpty($sStartDate)) FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_REPORT_HEADER', array('{1}'=>'*', '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      else FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_REPORT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($sStartDate), '{2}'=>FDate::getTimeZoneFormattedDate($sEndDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);
      
      $nRow += 3;
      
      // Header colors
      if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) {
         if ($sOrder == FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_ORDER_DATE) $oWarehouseFormsInputsOutputs = WarehouseFormsInputs::getWarehouseFormsInputs(true, null, null, $sSubtype, $nIdArticle, $bOnlyIPE, $nIdProvider, $sProvider, $nIdSubcategory, $nIdLocation, $sStartDate . ' 00:00:00', $sEndDate . ' 23:59:59', true);
         else $oWarehouseFormsInputsOutputs = WarehouseFormsInputs::getWarehouseFormsInputs(true, null, null, $sSubtype, $nIdArticle, $bOnlyIPE, $nIdProvider, $sProvider, $nIdSubcategory, $nIdLocation, $sStartDate . ' 00:00:00', $sEndDate . ' 23:59:59', false, true);
         
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B');
         $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'I' . $nRow);
         $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_COLOR_INPUTS)));
         $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_INPUTS_HEADER')); 
         $nRow++;
      }
      else if ($sType == FModuleWarehouseManagement::REPORT_TYPE_OUTPUTS) {
         if ($sOrder == FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_ORDER_DATE) $oWarehouseFormsInputsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputs(true, null, $sSubtype, $nIdArticle, $bOnlyIPE, $nIdProvider, $sProvider, $sEmployee, $nIdSubcategory, $nIdLocation, $sStartDate . ' 00:00:00', $sEndDate . ' 23:59:59', true);
         else $oWarehouseFormsInputsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputs(true, null, $sSubtype, $nIdArticle, $bOnlyIPE, $nIdProvider, $sProvider, $sEmployee, $nIdSubcategory, $nIdLocation, $sStartDate . ' 00:00:00', $sEndDate . ' 23:59:59', false, true);
         
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B');
         $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'I' . $nRow);
         $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_COLOR_OUTPUTS)));
         $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_OUTPUTS_HEADER')); 
         $nRow++;
      }
      
      $nRow += 2;

      // Header Report
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
      if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) {
         $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'N' . $nRow);
      }
      else {
         $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'K' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'N' . $nRow);
      }
      
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_DATE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_OWNER'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_TYPE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_CODE'), null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_PROVIDER'), null, null, null, null, true);
      
      if ($sType == FModuleWarehouseManagement::REPORT_TYPE_OUTPUTS) {
         FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_EMPLOYEE'), null, null, null, null, true);
      }
       
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalSum = 0;
      foreach($oWarehouseFormsInputsOutputs as $oWarehouseFormInputOutput) {
         $nStartRow = $nRow;
         
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FDate::getTimeZoneFormattedDate($oWarehouseFormInputOutput->date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow);
         $sWarehouseInputOutputOwner = Users::getUserEmployeeFullName($oWarehouseFormInputOutput->id_user);
         if ($sWarehouseInputOutputOwner != FString::STRING_EMPTY) FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $sWarehouseInputOutputOwner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
         if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_' . $oWarehouseFormInputOutput->type), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         else FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_' . $oWarehouseFormInputOutput->type), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
         if (!FString::isNullOrEmpty($oWarehouseFormInputOutput->code)) FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $oWarehouseFormInputOutput->code, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) {
            $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'N' . $nRow);
         }
         else {
            $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'K' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'N' . $nRow);
         }

         if (!FString::isNullOrEmpty($oWarehouseFormInputOutput->id_provider)) FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Providers::getProviderName($oWarehouseFormInputOutput->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         else if (!FString::isNullOrEmpty($oWarehouseFormInputOutput->provider)) FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, $oWarehouseFormInputOutput->provider, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         if ($sType == FModuleWarehouseManagement::REPORT_TYPE_OUTPUTS) {
            if (!FString::isNullOrEmpty($oWarehouseFormInputOutput->employee)) FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, $oWarehouseFormInputOutput->employee, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         }
         
         if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) $oWarehouseFormInputOutputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInputOutput->id);
         else $oWarehouseFormInputOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormInputOutput->id);
         
         if (count($oWarehouseFormInputOutputArticles) > 0) {
            $nRow += 2;
            
            // Header Articles
            $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'F' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
            
            $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_IDARTICLE'));
            $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_NAME'));
            FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_LOCATION'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_QUANTITY'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_PRICE'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_HEADER_ARTICLE_TOTAL'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
            
            $nTotalSumFormInputOutput = 0;
            foreach($oWarehouseFormInputOutputArticles as $oWarehouseFormInputOutputArticle) {
               
               if (((FString::isNullOrEmpty($nIdArticle)) || ((!FString::isNullOrEmpty($nIdArticle)) && ($nIdArticle == $oWarehouseFormInputOutputArticle->id_article))) &&
                   ((!$bOnlyIPE) || (($bOnlyIPE) && ($oWarehouseFormInputOutputArticle->article_ipe))) && 
                   ((FString::isNullOrEmpty($nIdSubcategory)) || ((!FString::isNullOrEmpty($nIdSubcategory)) && (!FString::isNullOrEmpty($oWarehouseFormInputOutputArticle->id_subcategory)) && ($nIdSubcategory == $oWarehouseFormInputOutputArticle->id_subcategory))) && 
                   ((FString::isNullOrEmpty($nIdLocation)) || ((!FString::isNullOrEmpty($nIdLocation)) && (!FString::isNullOrEmpty($oWarehouseFormInputOutputArticle->id_location_subcategory)) && ($nIdLocation == $oWarehouseFormInputOutputArticle->id_location_subcategory)))) {
                      
                  FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Articles::getArticleCodeName($oWarehouseFormInputOutputArticle->id_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               
                  $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'F' . $nRow);
                  FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Articles::getArticleName($oWarehouseFormInputOutputArticle->id_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               
                  $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
                  if (!FString::isNullOrEmpty($oWarehouseFormInputOutputArticle->id_location_subcategory)) FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oWarehouseFormInputOutputArticle->id_location_subcategory), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
                  $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
                  FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, $oWarehouseFormInputOutputArticle->quantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
                  $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
                  FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FFormat::getFormatPrice($oWarehouseFormInputOutputArticle->price_cost, false, true), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
                  $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
                  FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($oWarehouseFormInputOutputArticle->quantity * $oWarehouseFormInputOutputArticle->price_cost) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
                  $nTotalSumFormInputOutput += $oWarehouseFormInputOutputArticle->quantity * $oWarehouseFormInputOutputArticle->price_cost;
                  
                  $nRow++;
               }
            }       
            
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nTotalSumFormInputOutput) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');
            
            $nTotalSum += $nTotalSumFormInputOutput;  
         }
         
         if ($sType == FModuleWarehouseManagement::REPORT_TYPE_INPUTS) $oPHPExcelActiveSheet->getStyle('A' . $nStartRow . ':N' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_COLOR_INPUTS)));
         else $oPHPExcelActiveSheet->getStyle('A' . $nStartRow . ':N' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleWarehouseManagement::REPORT_INPUTSOUTPUTS_COLOR_OUTPUTS))); 
         
         $nRow += 2;      
      }  
      
      if ($nTotalSum > 0) {
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'N', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_TOP);
         
         $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nTotalSum) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');
      }
      
      return $oPHPExcel;  
   }
   private function reportExcelStock($sFilename, $nIdArticle, $nIdProvider, $sProvider, $nIdSubcategory, $nIdLocation, $bOnlyStock, $bOnlyAbsolete, $bOnlyCommonwealth, $sOrder, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:N')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
       
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(13); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(12);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(9);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(14); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(11.64);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(8.57);  
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
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'N' . ($nRow + 2));
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_REPORT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate(date('Ymd')))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);

      $nRow += 5;
      
      if ($sOrder == FModuleWarehouseManagement::REPORT_STOCK_ORDER_CODE) {
         $oArticles = Articles::getArticles($nIdArticle, $nIdSubcategory, $nIdLocation, $bOnlyStock, $bOnlyAbsolete, $bOnlyCommonwealth, false);
      }
      else {
         $oArticles = Articles::getArticles($nIdArticle, $nIdSubcategory, $nIdLocation, $bOnlyStock, $bOnlyAbsolete, $bOnlyCommonwealth, true);
      }
      
      // Header Articles                              
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'G' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'J' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
      
      $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_IDARTICLE'));
      $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_NAME'));
      $oPHPExcelActiveSheet->SetCellValue('E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_PROVIDER'));
      $oPHPExcelActiveSheet->SetCellValue('H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_LOCATION'));
      FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_PRICE_MEDIUM'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_QUANTITY'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSESTOCK_HEADER_ARTICLE_TOTAL'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
                
      $nTotalSum = 0;
      foreach($oArticles as $oArticle) {         
         $sArticleProvider = Articles::getArticleLastProviderName($oArticle->id);
         
         if ((strlen($sProvider) == 0) || ((strlen($sProvider) > 0) && (strpos($sArticleProvider, $sProvider) !== FALSE))) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Articles::getArticleCodeNameByArticle($oArticle), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Articles::getArticleNameByArticle($oArticle), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'G' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sArticleProvider, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'J' . $nRow);
            if (!FString::isNullOrEmpty($oArticle->id_location_subcategory)) FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $nArticlePriceMedium = $oArticle->price_medium;
            FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FFormat::getFormatPrice($nArticlePriceMedium, false, true), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $nCurrentQuantity = $oArticle->quantity;
            FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, $nCurrentQuantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   
            
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
            $nCurrentSum = $oArticle->quantity * $nArticlePriceMedium;
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nCurrentSum) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
            $nTotalQuantity += $nCurrentQuantity;
            $nTotalSum += $nCurrentSum;
            
            $nRow++;            
         }
      }
      
      $nRow++;
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'L', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_TOP);
      
      FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, $nTotalQuantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');

      $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nTotalSum) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');

      return $oPHPExcel;     
   }
   private function reportExcelInventory($sFilename, $nIdArticle, $nIdProvider, $sProvider, $nIdSubcategory, $nIdLocation, $bOnlyAbsolete, $bOnlyCommonwealth, $sDate, $sOrder, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 8;
      else $nFontSize = 10;
      
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINPUTSOUTPUTS_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;                 

      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:N')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF); 
       
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(13); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(12);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(9);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(9);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(14); 
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(11.64);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(8.57);
         $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(8.57);  
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
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'N' . ($nRow + 2));
      FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_REPORT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($sDate))), null, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, true);

      $nRow += 5;
      
      if ($sOrder == FModuleWarehouseManagement::REPORT_INVENTORY_ORDER_CODE) {
         $oArticles = Articles::getArticles($nIdArticle, $nIdSubcategory, $nIdLocation, null, $bOnlyAbsolete, $bOnlyCommonwealth, false);
      }
      else {
         $oArticles = Articles::getArticles($nIdArticle, $nIdSubcategory, $nIdLocation, null, $bOnlyAbsolete, $bOnlyCommonwealth, true);
      }  
                                      
      // Header Articles                              
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
      
      $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_IDARTICLE'));
      $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_NAME'));
      FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_PRICE_MEDIUM'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_PRICE_LAST'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_QUANTITY'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEINVENTORY_HEADER_ARTICLE_TOTAL'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      $nTotalSum = 0;
      foreach($oArticles as $oArticle) {   
         $sArticleProvider = Articles::getArticleLastProviderName($oArticle->id);
         
         if ((strlen($sProvider) == 0) || ((strlen($sProvider) > 0) && (strpos($sArticleProvider, $sProvider) !== FALSE))) {   
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Articles::getArticleCodeName($oArticle->id), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'F' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Articles::getArticleName($oArticle->id), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'H' . $nRow);
            $nArticlePriceMedium = $oArticle->price_medium;
            FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, FFormat::getFormatPrice($nArticlePriceMedium, false, true), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, FFormat::getFormatPrice(Articles::getArticleHistoricalPriceLast($oArticle->id, $sDate), false, true), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
            if ($sDate == date('Y-m-d')) {
               $nCurrentQuantity = $oArticle->quantity;
               FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, $nCurrentQuantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   
            }
            else {
               $nCurrentQuantity = Articles::getArticleHistoricalStock($oArticle->id, $sDate); 
               FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, $nCurrentQuantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
            $nCurrentSum = $nCurrentQuantity * $nArticlePriceMedium;
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nCurrentSum) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $nTotalQuantity += $nCurrentQuantity;
            $nTotalSum += $nCurrentSum;
            
            $nRow++;  
         } 
      }
      
      $nRow++;
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'L', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_TOP);
      
      $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, $nTotalQuantity, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');

      $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, FFormat::getFormatPrice($nTotalSum) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, null, null, null, true, '#00BB00');

      return $oPHPExcel;   
   }
   private function reportExcelArticle($sFilename, $oArticle, $sDocFormat) {   
      $oApplication = Application::getApplication();
      $oLastProvider = Articles::getArticleLastProvider($oArticle->id); 
      $sLastProvider = FString::STRING_EMPTY;
      $sLastProviderPhone = FString::STRING_EMPTY;
      $sLastProviderMail = FString::STRING_EMPTY;

      if (count($oLastProvider) > 0) {
         if (!FString::isNullOrEmpty($oLastProvider[0])) {
            $oProvider = Providers::getProvider($oLastProvider[0]);
            if (!is_null($oProvider)) {
               $sLastProvider = $oProvider->name;   
               $sLastProviderPhone = $oProvider->phone;   
               $sLastProviderMail = $oProvider->mail;   
            }
         }   
         else {
            if (!FString::isNullOrEmpty($oLastProvider[1])) $sLastProvider = $oLastProvider[1];   
         }  
      }
      
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
                   
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 11;
      else $nFontSize = 11;

      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEARTICLE_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getStyle('A:F')->getFont()->setSize($nFontSize);
      
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
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(16.71);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16.71);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(12);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(12);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(20);
      }
      
      // --> Title
      $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Articles::getArticleCodeName($oArticle->id), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'F', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
      $nRow += 2;
      
      // --> Name
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_NAME')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Model
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_MODEL')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->model, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Category
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDSUBCATEGORY')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->id_subcategory)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, WarehouseArticlesSubcategories::getFullWarehouseArticleSubcategory($oArticle->id_subcategory), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Location
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDLOCATIONSUBCATEGORY')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->id_location_subcategory)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oArticle->id_location_subcategory), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Provider
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDER')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($sLastProvider)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sLastProvider, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Phone
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDERPHONE')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($sLastProviderPhone)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sLastProviderPhone, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Mail
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDERMAIL')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($sLastProviderMail)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sLastProviderMail, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Code Barcode
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_CODEBARCODE')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->code_barcode)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->code_barcode, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Code KKS
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_CODEKKS')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->code_kks)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->code_kks, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Description
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . ($nRow + 1));
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_DESCRIPTION')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->description)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
      $nRow += 2;
      
      // --> Price Medium
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_PRICEMEDIUM')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FFormat::getFormatPrice($oArticle->price_medium, false, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Price Last
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_PRICELAST')) . ':', null, null, null, null, true);
      FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FFormat::getFormatPrice(Articles::getArticleHistoricalPriceLast($oArticle->id), false, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Weight
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_WEIGHT')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->weight)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FFormat::getFormatPrice($oArticle->weight) . ' g', PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Volume
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_VOLUME')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->volume)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, FFormat::getFormatPrice($oArticle->volume) . ' cm³', PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Quantity Min
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_QUANTITYMIN')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->quantity_min)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->quantity_min, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Quantity
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_QUANTITY')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->quantity)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $oArticle->quantity, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Related Article
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDRELATEDARTICLE')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->id_related_article)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Articles::getArticleName($oArticle->id_related_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $nRow++;
      
      // --> Equivalent Article
      $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
      $oPHPExcelActiveSheet->mergeCells('E' . $nRow . ':' . 'F' . $nRow);
      FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FString::castStrToUpper(Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDEQUIVALENTARTICLE')) . ':', null, null, null, null, true);
      if (!FString::isNullOrEmpty($oArticle->id_equivalent_article)) FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Articles::getArticleName($oArticle->id_equivalent_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

      // --> Image
      $oPHPExcelActiveSheet->mergeCells('A3:' . 'B' . $nRow);

      if (!is_null($oArticle->image)) {
         $oImageDrawing = new PHPExcel_Worksheet_Drawing();
         $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
      
         $oImageDrawing->setPath(FApplication::FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES . $oArticle->image);
         $oImageDrawing->setCoordinates('A3');
      
         $oImageDrawing->setResizeProportional(true);
         $oImageDrawing->setWidth(220);
      }
      
      return $oPHPExcel;   
   } 
   private function reportExcelOutputMaterialReleaseAuthorization($sFilename, $oWarehouseFormOutput, $sDocFormat) {  
      $oApplication = Application::getApplication();
      
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
             
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 9;
      else $nFontSize = 9;
      
      $sFontName = 'verdana';
       
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(4.875);
      
      if ((!is_null($oApplication)) && (!is_null($oWarehouseFormOutput))) {
         // --> Title Invoice & Logo
         if ((!FString::isNullOrEmpty($oApplication->business_logo)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_logo))) {
            $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . ($nRow + 3));
             
            $oImageDrawing = new PHPExcel_Worksheet_Drawing();
            $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
            $oImageDrawing->setPath(FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_logo);
            $oImageDrawing->setCoordinates('B' . $nRow);
            
            $oImageDrawing->setResizeProportional(true);
            $oImageDrawing->setWidth(67);
            
            $nRow += 3;
            
            $oPHPExcelActiveSheet->mergeCells('F' . ($nRow - 1) . ':' . 'N' . ($nRow - 1)); 
            FReportExcel::setCellValue($oPHPExcel, 'F' . ($nRow - 1), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize + 5, false, null, true);
         }
         else {
            $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow); 
            FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize + 5, false, null, true);
         }
         
         $nRow += 2;
         
         // Number
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'E' . ($nRow + 2));
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 2), 'E', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_NUM_FORM_OUTPUT')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $oWarehouseFormOutput->id, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize + 3), true, '#FF0000', true);
         
         // Employee & Department
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'L' . $nRow); 
         $oPHPExcelActiveSheet->mergeCells('G' . ($nRow + 1) . ':' . 'L' . ($nRow + 2)); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'G', ($nRow + 2), 'L', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'N', ($nRow + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_EMPLOYEE')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'G' . ($nRow + 1), $oWarehouseFormOutput->employee, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, true, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('N' . $nRow . ':' . 'S' . $nRow); 
         $oPHPExcelActiveSheet->mergeCells('N' . ($nRow + 1) . ':' . 'S' . ($nRow + 2));
         
         FReportExcel::setCellValue($oPHPExcel, 'N' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_EMPLOYEE_DEPARTMENT')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         if (!FString::isNullOrEmpty($oWarehouseFormOutput->employee_department)) FReportExcel::setCellValue($oPHPExcel, 'N' . ($nRow + 1), Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oWarehouseFormOutput->employee_department), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, true, null, true);
         
         // Date
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 4) . ':' . 'E' . ($nRow + 4));
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 5) . ':' . 'E' . ($nRow + 6));
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 4), 'B', ($nRow + 6), 'E', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 4), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_DATE')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 5), FDate::getTimeZoneFormattedDate($oWarehouseFormOutput->date), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);

         // Working Part
         $oPHPExcelActiveSheet->mergeCells('G' . ($nRow + 4) . ':' . 'L' . ($nRow + 4)); 
         $oPHPExcelActiveSheet->mergeCells('G' . ($nRow + 5) . ':' . 'L' . ($nRow + 6)); 
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 4), 'G', ($nRow + 6), 'L', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'G' . ($nRow + 4), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_WORKING_PART')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         if (!FString::isNullOrEmpty($oWarehouseFormOutput->id_form_working_part)) {
            $sIdFormWorkingPart = $oWarehouseFormOutput->id_form_working_part;
            $oFormWorkingPart = explode('-', $sIdFormWorkingPart);
            
            if (count($oFormWorkingPart) == 2) {
               $sIdFormWorkingPart = FString::STRING_EMPTY;
               
               if ($oFormWorkingPart[0] == FModuleWorkingPartsManagement::WORKING_PART_FULL_ABBREVIATION) $sIdFormWorkingPart = Yii::t('rainbow', 'WORKING_PART_FULL_ABBREVIATION') . '-' . $oFormWorkingPart[1]; 
               else if ($oFormWorkingPart[0] == FModuleWorkingPartsManagement::WORKING_PART_MAINTENANCE_FULL_ABBREVIATION) $sIdFormWorkingPart = Yii::t('rainbow', 'WORKING_PART_MAINTENANCE_FULL_ABBREVIATION') . '-' . $oFormWorkingPart[1]; 
               else $sIdFormWorkingPart = Yii::t('rainbow', 'WORKING_PART_SPECIAL_FULL_ABBREVIATION') . '-' . $oFormWorkingPart[1]; 
               
               FReportExcel::setCellValue($oPHPExcel, 'G' . ($nRow + 5), $sIdFormWorkingPart, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);  
            }
         }
         
         $nRow += 8;
         
         // Articles
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_ARTICLE_QUANTITY')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'S' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'D', $nRow, 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_ARTICLE_DESCRIPTION')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $nRow++;
         
         $nGridBlankRows = 15;
         for($i = 0; $i < $nGridBlankRows; $i++) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $i) . ':' . 'C' . ($nRow + $i));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $i) . ':' . 'S' . ($nRow + $i));       
            
            $oPHPExcelActiveSheet->getRowDimension($nRow + $i)->setRowHeight(25);
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'B', ($nRow + $i), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'D', ($nRow + $i), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);            
         }
         
         $nGridCompletedRows = 0;
         $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
         foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $nGridCompletedRows) . ':' . 'C' . ($nRow + $nGridCompletedRows));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $nGridCompletedRows) . ':' . 'S' . ($nRow + $nGridCompletedRows));
            
            $oPHPExcelActiveSheet->getRowDimension($nRow + $nGridCompletedRows)->setRowHeight(25);
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'B', ($nRow + $nGridCompletedRows), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'D', ($nRow + $nGridCompletedRows), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            
            if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->quantity)) {
               FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + $nGridCompletedRows), $oWarehouseFormOutputArticle->quantity, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->id_article)) {
               FReportExcel::setCellValue($oPHPExcel, 'D' . ($nRow + $nGridCompletedRows), Articles::getArticleName($oWarehouseFormOutputArticle->id_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }  
            
            $nGridCompletedRows++;  
         }
         
         if ($nGridCompletedRows >= $nGridBlankRows) { 
            $nRow += $nGridCompletedRows;
         }
         else $nRow += $nGridBlankRows;
         
         $nRow++; 
         
         // Observations
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 3), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_OBSERVATIONS')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'S' . ($nRow + 3));

         if (!FString::isNullOrEmpty($oWarehouseFormOutput->comments)) FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $oWarehouseFormOutput->comments, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         
         $nRow += 5;
         
         // Signature Transmitter
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'J' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 2), 'J', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_SIGNATURE_TRANSMITTER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'J' . ($nRow + 2));
        
         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) {
            FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $sCurrentUser, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         }
         
         // Signature Employee
         $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'K', ($nRow + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEAUTHORIZATION_REPORT_TITLE_SIGNATURE_EMPLOYEE')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('K' . ($nRow + 1) . ':' . 'S' . ($nRow + 2));
      }
      
      return $oPHPExcel; 
   }      
   
   
   private function reportExcelOutputMaterialReleaseRepairBenefit($sFilename, $oWarehouseFormOutput, $sDocFormat) {  
      $oApplication = Application::getApplication();
      
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
             
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 9;
      else $nFontSize = 9;
      
      $sFontName = 'verdana';
       
      FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_SHEET_NAME'));
      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(4.875);
      $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(4.875);
      
      if ((!is_null($oApplication)) && (!is_null($oWarehouseFormOutput))) {
         if ($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR) {
            $sWarehouseFormOutputType = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REPAIR_ABBR');
         }
         else if ($oWarehouseFormOutput->type == FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT) $sWarehouseFormOutputType = Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_BENEFIT_ABBR');

         // --> Title Invoice & Logo
         if ((!FString::isNullOrEmpty($oApplication->business_logo)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_logo))) {
            $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . ($nRow + 3));
             
            $oImageDrawing = new PHPExcel_Worksheet_Drawing();
            $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
            $oImageDrawing->setPath(FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_logo);
            $oImageDrawing->setCoordinates('B' . $nRow);
            
            $oImageDrawing->setResizeProportional(true);
            $oImageDrawing->setWidth(67);
            
            $nRow += 3;
            
            $oPHPExcelActiveSheet->mergeCells('F' . ($nRow - 1) . ':' . 'N' . ($nRow - 1)); 
            FReportExcel::setCellValue($oPHPExcel, 'F' . ($nRow - 1), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE', array('{1}'=>$sWarehouseFormOutputType))), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize + 5, false, null, true);
         }
         else {
            $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow); 
            FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE', array('{1}'=>$sWarehouseFormOutputType))), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize + 5, false, null, true);
         }
         
         $nRow += 2;
         
         // Date
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'E' . ($nRow + 2));
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 2), 'E', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_DATE')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), FDate::getTimeZoneFormattedDate($oWarehouseFormOutput->date), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);

         // Provider
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'S' . $nRow); 
         $oPHPExcelActiveSheet->mergeCells('G' . ($nRow + 1) . ':' . 'S' . ($nRow + 2));
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'G', ($nRow + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_PROVIDER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         if (!FString::isNullOrEmpty($oWarehouseFormOutput->id_provider)) FReportExcel::setCellValue($oPHPExcel, 'G' . ($nRow + 1), Providers::getProviderName($oWarehouseFormOutput->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, true, null, true);
         
         $nRow += 4;
         
         // Articles
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_ARTICLE_QUANTITY')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'S' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'D', $nRow, 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_ARTICLE_DESCRIPTION')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $nRow++;
         
         $nGridBlankRows = 15;
         for($i = 0; $i < $nGridBlankRows; $i++) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $i) . ':' . 'C' . ($nRow + $i));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $i) . ':' . 'S' . ($nRow + $i));       
            
            $oPHPExcelActiveSheet->getRowDimension($nRow + $i)->setRowHeight(25);
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'B', ($nRow + $i), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'D', ($nRow + $i), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);            
         }
         
         $nGridCompletedRows = 0;
         $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
         foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $nGridCompletedRows) . ':' . 'C' . ($nRow + $nGridCompletedRows));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $nGridCompletedRows) . ':' . 'S' . ($nRow + $nGridCompletedRows));
            
            $oPHPExcelActiveSheet->getRowDimension($nRow + $nGridCompletedRows)->setRowHeight(25);
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'B', ($nRow + $nGridCompletedRows), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'D', ($nRow + $nGridCompletedRows), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            
            if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->quantity)) {
               FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + $nGridCompletedRows), $oWarehouseFormOutputArticle->quantity, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            if (!FString::isNullOrEmpty($oWarehouseFormOutputArticle->id_article)) {
               FReportExcel::setCellValue($oPHPExcel, 'D' . ($nRow + $nGridCompletedRows), Articles::getArticleName($oWarehouseFormOutputArticle->id_article), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }  
            
            $nGridCompletedRows++;  
         }
         
         if ($nGridCompletedRows >= $nGridBlankRows) { 
            $nRow += $nGridCompletedRows;
         }
         else $nRow += $nGridBlankRows;
         
         $nRow++; 
         
         // Observations
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 3), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_OBSERVATIONS')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'S' . ($nRow + 3));

         if (!FString::isNullOrEmpty($oWarehouseFormOutput->comments)) FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $oWarehouseFormOutput->comments, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         
         $nRow += 5;
         
         // Signature Transmitter
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'J' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 2), 'J', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_SIGNATURE_TRANSMITTER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'J' . ($nRow + 2));
        
         $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
         if ($sCurrentUser != FString::STRING_EMPTY) {
            FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $sCurrentUser, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         }
         
         // Signature Employee
         $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'K', ($nRow + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'REPORT_WAREHOUSEOUTPUTMATERIALRELEASEREPAIRBENEFIT_REPORT_TITLE_SIGNATURE_PROVIDER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('K' . ($nRow + 1) . ':' . 'S' . ($nRow + 2));
      }
      
      return $oPHPExcel; 
   }      
}