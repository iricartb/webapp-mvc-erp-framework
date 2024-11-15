<?php      
class FModulePurchasesManagement {    
   const NOTICE_NUM_DAYS_EXPIRATION_TENDER_OR_CONTRACT = 30;

   const TYPE_FORM_REQUEST_OFFER_WITHOUT_CONTRACTING_PROCEDURE = 'WITHOUT_CONTRACTING_PROCEDURE';
   const TYPE_FORM_REQUEST_OFFER_3_OFFERS = '3_OFFERS';
   const TYPE_FORM_REQUEST_OFFER_TENDERING = 'TENDERING';

   const TYPE_FORM_CONTRACTING_PROCEDURE_SERVICE = 'SERVICE';
   const TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY = 'SUPPLY';
   const TYPE_FORM_CONTRACTING_PROCEDURE_WORK = 'WORK';
   
   const TYPE_FORM_CONTRACTING_PROCEDURE_SERVICE_ABBREVIATION = 'SER';
   const TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY_ABBREVIATION = 'SUB';
   const TYPE_FORM_CONTRACTING_PROCEDURE_WORK_ABBREVIATION = 'OBR';
       
   const TYPE_PAYMENT_METHOD_30_DAYS = '30_DAYS';
   const TYPE_PAYMENT_METHOD_60_DAYS = '60_DAYS';
   const TYPE_PAYMENT_METHOD_90_DAYS = '90_DAYS';
   const TYPE_PAYMENT_METHOD_TRANSFER = 'TRANSFER';
   const TYPE_PAYMENT_METHOD_CASH = 'CASH';
   
   const STATUS_CREATED = 'CREATED';
   const STATUS_PENDING = 'PENDING';
   const STATUS_ALERT_ORANGE = 'ALERT_ORANGE';
   const STATUS_RUNNING = 'RUNNING';
   const STATUS_ACCEPTED = 'ACCEPTED';
   const STATUS_DISCARDED = 'DISCARDED';
   const STATUS_COMPLETED = 'COMPLETED';
   const STATUS_PARTIAL_FINALIZED = 'PARTIAL_FINALIZED';
   const STATUS_FINALIZED = 'FINALIZED';
   const STATUS_ERROR = 'ERROR';
      
   const COLOR_STATUS_CREATED = '#585cfe';
   const COLOR_STATUS_PENDING = '#cfc23a';
   const COLOR_STATUS_ALERT_ORANGE = '#f8b669';
   const COLOR_STATUS_RUNNING = '#5c9b61';
   const COLOR_STATUS_ACCEPTED = '#5c9b61';
   const COLOR_STATUS_DISCARDED = '#a93030';
   const COLOR_STATUS_COMPLETED = '#5c9b61';
   const COLOR_STATUS_PARTIAL_FINALIZED = '#cfb3ff';  
   const COLOR_STATUS_FINALIZED = '#8a8a8a';  
   const COLOR_STATUS_ERROR = '#a93030';
      
   const COLOR_GRID_STATUS_CREATED = '#57aaff';
   const COLOR_GRID_STATUS_PENDING = '#f4e544';
   const COLOR_GRID_STATUS_ALERT_ORANGE = '#f8b669';
   const COLOR_GRID_STATUS_RUNNING = '#88e88f';
   const COLOR_GRID_STATUS_ACCEPTED = '#88e88f';
   const COLOR_GRID_STATUS_DISCARDED = '#ff4848';
   const COLOR_GRID_STATUS_COMPLETED = '#88e88f';
   const COLOR_GRID_STATUS_PARTIAL_FINALIZED = '#cfb3ff';
   const COLOR_GRID_STATUS_FINALIZED = '#cdcdcd';
   const COLOR_GRID_STATUS_ERROR = '#ff4848';
   
   const HEADER_MAIN_COLOR = 'EEEEEE';
   
   const CALENDAR_EVENT_COLOR_0 = '#ff8383';
   const CALENDAR_EVENT_COLOR_1 = '#fffa7e';
   const CALENDAR_EVENT_COLOR_2 = '#e4ff86';  
   const CALENDAR_EVENT_COLOR_3 = '#ffcc83';      
   const CALENDAR_EVENT_COLOR_4 = '#7eff81';
   const CALENDAR_EVENT_COLOR_5 = '#7edfff';
   const CALENDAR_EVENT_COLOR_6 = '#afa9ff';
   const CALENDAR_EVENT_COLOR_7 = '#fca9ff';
   const CALENDAR_EVENT_COLOR_8 = '#bfcfcd';
   const CALENDAR_EVENT_COLOR_9 = '#aeb4a4';
   
   public static function createFormPurchaseOrderAttachment($nIdForm) { 
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      $oApplication = Application::getApplication();
      
      if ((!is_null($oApplication)) && (!is_null($oPurchasesFormPurchaseOrder))) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_NAME', array('{1}'=>$oPurchasesFormPurchaseOrder->id));
         
         $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);

         $nFontSize = 9;
         $sFontName = 'verdana';
         
         $sSheetName = Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_SHEET_NAME');
         FReportExcel::addSheet($oPHPExcel, $sSheetName);
         FReportExcel::setVerticalMargin($oPHPExcel, 1, 1);
         FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
         
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
         }
             
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow); 
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize + 5, false, null, true);
         $nRow += 2;
         
         $nRowColumnLeft = $nRow;
         $nRowColumnMiddle = $nRow;
         $nRowColumnRight = $nRow;
         
         if (!FString::isNullOrEmpty($oApplication->business_post_address)) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, $oApplication->business_post_address, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }
         
         if ((!FString::isNullOrEmpty($oApplication->business_post_zipcode)) && (!FString::isNullOrEmpty($oApplication->business_post_province))) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, $oApplication->business_post_zipcode . FString::STRING_SPACE . Yii::t('system', $oApplication->business_post_province), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }
         
         if (!FString::isNullOrEmpty($oApplication->business_phone)) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, Yii::t('system', 'SYS_PHONE_ABBREVIATION') . ':' . FString::STRING_SPACE . FFormat::getFormatPhone($oApplication->business_phone), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }
         
         if (!FString::isNullOrEmpty($oApplication->business_fax)) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, Yii::t('system', 'SYS_FAX') . ':' . FString::STRING_SPACE . FFormat::getFormatPhone($oApplication->business_fax), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }

         if (!FString::isNullOrEmpty($oApplication->business_nif)) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, Yii::t('system', 'SYS_NIF') . ':' . FString::STRING_SPACE . $oApplication->business_nif, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }
         
         if (!FString::isNullOrEmpty($oApplication->business_address_abbreviation)) {  
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . ($nRowColumnLeft + 1)); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, $oApplication->business_address_abbreviation, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_BOTTOM, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft += 2;
         }
         
         if ((!FString::isNullOrEmpty($oApplication->business_zipcode)) && (!FString::isNullOrEmpty($oApplication->business_province))) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRowColumnLeft . ':' . 'D' . $nRowColumnLeft); 
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRowColumnLeft, $oApplication->business_zipcode . FString::STRING_SPACE . Yii::t('system', $oApplication->business_province), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            $nRowColumnLeft++;
         }
         
         // Provider
         $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
         
         if (!is_null($oProvider)) {
            $oPHPExcelActiveSheet->mergeCells('F' . ($nRowColumnMiddle) . ':' . 'N' . ($nRowColumnMiddle)); 
            $oPHPExcelActiveSheet->mergeCells('F' . ($nRowColumnMiddle + 1) . ':' . 'N' . ($nRowColumnMiddle + 4)); 
            $oPHPExcelActiveSheet->mergeCells('F' . ($nRowColumnMiddle + 5) . ':' . 'N' . ($nRowColumnMiddle + 6)); 
            FReportExcel::setBorderByRange($oPHPExcel, $nRowColumnMiddle, 'F', ($nRowColumnMiddle + 7), 'N', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
            FReportExcel::setCellValue($oPHPExcel, 'F' . ($nRowColumnMiddle), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_PROVIDER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'F' . ($nRowColumnMiddle + 1), Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, true, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'F' . ($nRowColumnMiddle + 5), $oProvider->nif, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, true, null, true);
         }
         
         // Date & Number
         $oPHPExcelActiveSheet->mergeCells('P' . $nRowColumnRight . ':' . 'S' . $nRowColumnRight); 
         $oPHPExcelActiveSheet->mergeCells('P' . ($nRowColumnRight + 5) . ':' . 'S' . ($nRowColumnRight + 5)); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRowColumnRight, 'P', ($nRowColumnRight + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, ($nRowColumnRight + 5), 'P', ($nRowColumnRight + 7), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         FReportExcel::setCellValue($oPHPExcel, 'P' . $nRowColumnRight, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_DATE')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'P' . ($nRowColumnRight + 5), FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_NUM_ORDER')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('P' . ($nRowColumnRight + 1) . ':' . 'S' . ($nRowColumnRight + 2));
         $oPHPExcelActiveSheet->mergeCells('P' . ($nRowColumnRight + 6) . ':' . 'S' . ($nRowColumnRight + 7));
         
         FReportExcel::setCellValue($oPHPExcel, 'P' . ($nRowColumnRight + 1), date('d/m/Y'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'P' . ($nRowColumnRight + 6), $oPurchasesFormPurchaseOrder->id, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize + 3), true, '#FF0000', true);
         
         $nRow += 9;
         
         // Quantity & Price
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', $nRow, 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_ARTICLE_QUANTITY')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'O' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'D', $nRow, 'O', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_ARTICLE_DESCRIPTION')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'Q' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'P', $nRow, 'Q', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_ARTICLE_PRICE')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('R' . $nRow . ':' . 'S' . $nRow);       
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'R', $nRow, 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_ARTICLE_TOTAL')), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $nRow++;
         
         $nGridBlankRows = 19;
         
         for($i = 0; $i < $nGridBlankRows; $i++) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $i) . ':' . 'C' . ($nRow + $i));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $i) . ':' . 'O' . ($nRow + $i));       
            $oPHPExcelActiveSheet->mergeCells('P' . ($nRow + $i) . ':' . 'Q' . ($nRow + $i));       
            $oPHPExcelActiveSheet->mergeCells('R' . ($nRow + $i) . ':' . 'S' . ($nRow + $i)); 
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'B', ($nRow + $i), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'D', ($nRow + $i), 'O', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'P', ($nRow + $i), 'Q', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $i), 'R', ($nRow + $i), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);            
         }
         
         $nGridCompletedRows = 0;
         $oPurchasesFormsPurchaseOrdersArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oPurchasesFormPurchaseOrder->id);
         foreach($oPurchasesFormsPurchaseOrdersArticles as $oPurchasesFormPurchaseOrderArticle) {
            $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + $nGridCompletedRows) . ':' . 'C' . ($nRow + $nGridCompletedRows));       
            $oPHPExcelActiveSheet->mergeCells('D' . ($nRow + $nGridCompletedRows) . ':' . 'O' . ($nRow + $nGridCompletedRows));       
            $oPHPExcelActiveSheet->mergeCells('P' . ($nRow + $nGridCompletedRows) . ':' . 'Q' . ($nRow + $nGridCompletedRows));       
            $oPHPExcelActiveSheet->mergeCells('R' . ($nRow + $nGridCompletedRows) . ':' . 'S' . ($nRow + $nGridCompletedRows)); 
            
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'B', ($nRow + $nGridCompletedRows), 'C', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'D', ($nRow + $nGridCompletedRows), 'O', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'P', ($nRow + $nGridCompletedRows), 'Q', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow + $nGridCompletedRows), 'R', ($nRow + $nGridCompletedRows), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);      
            
            if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->quantity)) {
               if ($oPurchasesFormPurchaseOrderArticle->quantity > 0) FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + $nGridCompletedRows), $oPurchasesFormPurchaseOrderArticle->quantity, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
               else FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + $nGridCompletedRows), '-', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->description)) {
               FReportExcel::setCellValue($oPHPExcel, 'D' . ($nRow + $nGridCompletedRows), $oPurchasesFormPurchaseOrderArticle->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->price)) {
               FReportExcel::setCellValue($oPHPExcel, 'P' . ($nRow + $nGridCompletedRows), FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price, false, true), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrderArticle->price)) {
               FReportExcel::setCellValue($oPHPExcel, 'R' . ($nRow + $nGridCompletedRows), FFormat::getFormatPrice($oPurchasesFormPurchaseOrderArticle->price  * $oPurchasesFormPurchaseOrderArticle->quantity), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), false, null, true);
            }
            
            $nGridCompletedRows++;  
         }
         
         $bAddTotalLine = false;
         if ($nGridCompletedRows >= $nGridBlankRows) { 
            $nRow += $nGridCompletedRows;
            $bAddTotalLine = true;
         }
         else $nRow += $nGridBlankRows;
    
         if ($bAddTotalLine) {
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'P', $nRow, 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'S' . $nRow);       
            FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, FFormat::getFormatPrice($oPurchasesFormPurchaseOrder->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), true, null, true);
            
            $nRow++;      
         }
         else {
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'P', ($nRow - 1), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'B', ($nRow - 1), 'C', true, FReportExcel::BORDER_STYLE_NONE);
            FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'D', ($nRow - 1), 'O', true, FReportExcel::BORDER_STYLE_NONE);
            
            $oPHPExcelActiveSheet->unmergeCells('P' . ($nRow - 1) . ':' . 'Q' . ($nRow - 1));
            $oPHPExcelActiveSheet->unmergeCells('R' . ($nRow - 1) . ':' . 'S' . ($nRow - 1));
            $oPHPExcelActiveSheet->mergeCells('P' . ($nRow - 1) . ':' . 'S' . ($nRow - 1));       
            FReportExcel::setCellValue($oPHPExcel, 'P' . ($nRow - 1), FFormat::getFormatPrice($oPurchasesFormPurchaseOrder->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 1), true, null, true);
         }
         
         $nRow++;
         
         // Send Method
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'J' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 2), 'J', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_SEND_METHOD')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'J' . ($nRow + 2));

         if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->send_method)) FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $oPurchasesFormPurchaseOrder->send_method, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         
         // Payment Method
         $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'L', ($nRow + 2), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'L' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_PAYMENT_METHOD')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('L' . ($nRow + 1) . ':' . 'S' . ($nRow + 2));
                                                                                                                                              
         if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->payment_method)) FReportExcel::setCellValue($oPHPExcel, 'L' . ($nRow + 1), Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD_VALUE_' . $oPurchasesFormPurchaseOrder->payment_method), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         
         $nRow += 4;
         
         // Observations
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'S' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 3), 'S', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_OBSERVATIONS')), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'S' . ($nRow + 3));

         if (!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->comments)) FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), $oPurchasesFormPurchaseOrder->comments, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, $nFontSize, false, null, true);
         
         $nRow += 5;
         
         // Signature
         $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'J' . $nRow); 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B', ($nRow + 3), 'J', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         
         $sCurrentUser = Users::getUserEmployeeFullName($oPurchasesFormPurchaseOrder->id_user);
         if ($sCurrentUser != FString::STRING_EMPTY) {
            $oEmployee = Employees::getEmployeeByIdUser($oPurchasesFormPurchaseOrder->id_user);
            if (!is_null($oEmployee)) {
               $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
               if (!is_null($oEmployeeDepartment)) {
                  if (!FString::isNullOrEmpty($oEmployeeDepartment->responsability)) {
                     $sCurrentUser .= ' (' . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . strtoupper($oEmployeeDepartment->responsability) . '_' . $oEmployeeDepartment->department) . ')';    
                  }
                  else $sCurrentUser .= ' (' . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartment->department) . ')';  
               }
            }
         }
         
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'REPORT_PURCHASESFORMSPURCHASEORDERS_REPORT_TITLE_SIGNATURE')) . ':' . FString::STRING_SPACE . $sCurrentUser, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, $sFontName, ($nFontSize - 2), false, null, true);
         
         $oPHPExcelActiveSheet->mergeCells('C' . ($nRow + 1) . ':' . 'J' . ($nRow + 3));
         
         // --> Signature
         if ((!is_null($oEmployee)) && (!FString::isNullOrEmpty($oEmployee->signature)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oEmployee->signature))) {
            $oImageDrawing = new PHPExcel_Worksheet_Drawing();
            $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
            $oImageDrawing->setPath(FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oEmployee->signature);
            $oImageDrawing->setCoordinates('C' . ($nRow + 1));
            
            $oImageDrawing->setResizeProportional(false);
            $oImageDrawing->setHeight(55);
            $oImageDrawing->setWidth(240);
            $oImageDrawing->setOffsetY(3);

            $nRow += 3;    
         }
        
         $oWriter = PHPExcel_IOFactory::createWriter($oPHPExcel, 'Excel5'); 
         $oWriter->save(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $sFilename . '.xls');     
         
         $oPurchasesFormPurchaseOrder->order = $sFilename . '.xls';
         $oPurchasesFormPurchaseOrder->save(false);
         
         return $oPHPExcel;                 
      }
   }
   
   public static function createFormPurchaseOrderByFormRequestOffer($nIdFormRequestOffer) {
      $bNotifyWarehouseSystemEvent = false;
      $bNotifyDepartmentSystemEvent = false;
      $bFindPurchaseFormRequestOfferLine = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdFormRequestOffer);
                           
      if (!is_null($oPurchasesFormRequestOffer)) {
         if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
            $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
            foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
               if (!$bFindPurchaseFormRequestOfferLine) {
                  if ($oPurchasesFormRequestOfferLine->selected) {
                     $oPurchasesFormPurchaseOrder = new PurchasesFormsPurchaseOrders();
                                       
                     $oPurchasesFormPurchaseOrder->owner = $oPurchasesFormRequestOffer->owner;
                     $oPurchasesFormPurchaseOrder->user_accept = $oPurchasesFormRequestOffer->user_accept_discard;
                     $oPurchasesFormPurchaseOrder->description = $oPurchasesFormRequestOffer->description;
                     $oPurchasesFormPurchaseOrder->department = $oPurchasesFormRequestOffer->department;
                     $oPurchasesFormPurchaseOrder->price = $oPurchasesFormRequestOfferLine->price; 
                     $oPurchasesFormPurchaseOrder->offer = $oPurchasesFormRequestOfferLine->offer; 
                     $oPurchasesFormPurchaseOrder->status = FModulePurchasesManagement::STATUS_PENDING; 
                     $oPurchasesFormPurchaseOrder->accept_date = $oPurchasesFormRequestOffer->accept_date;
                     $oPurchasesFormPurchaseOrder->id_provider = $oPurchasesFormRequestOfferLine->id_provider;
                     $oPurchasesFormPurchaseOrder->id_user = $oPurchasesFormRequestOffer->id_user;
                     $oPurchasesFormPurchaseOrder->id_financial_cost_line = $oPurchasesFormRequestOffer->id_financial_cost_line;
                     $oPurchasesFormPurchaseOrder->id_form_request_offer = $oPurchasesFormRequestOffer->id;

                     if ($oPurchasesFormPurchaseOrder->save(false)) {
                        $oPurchasesFormsRequestOffersArticles = PurchasesFormsRequestOffersArticles::getPurchasesFormsRequestOffersArticlesByIdFormFK($oPurchasesFormRequestOffer->id);
                        foreach($oPurchasesFormsRequestOffersArticles as $oPurchasesFormRequestOfferArticle) {
                           $oPurchasesFormPurchaseOrderArticle = new PurchasesFormsPurchaseOrdersArticles();
                           $oPurchasesFormPurchaseOrderArticle->quantity = $oPurchasesFormRequestOfferArticle->quantity;
                           $oPurchasesFormPurchaseOrderArticle->description = $oPurchasesFormRequestOfferArticle->description;
                           $oPurchasesFormPurchaseOrderArticle->requirements_date = $oPurchasesFormRequestOfferArticle->requirements_date;
                           $oPurchasesFormPurchaseOrderArticle->service = $oPurchasesFormRequestOfferArticle->service;
                           $oPurchasesFormPurchaseOrderArticle->id_form_purchase_order = $oPurchasesFormPurchaseOrder->id; 
                           
                           if (!$oPurchasesFormPurchaseOrderArticle->service) $bNotifyWarehouseSystemEvent = true;
                           $bNotifyDepartmentSystemEvent = true;
                           
                           $oPurchasesFormPurchaseOrderArticle->save(false);
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

                     $bFindPurchaseFormRequestOfferLine = true;
                  }
               }
            }  
         }
      }   
   }
   
   
   public static function getTypeFormRequestOffer($nIdForm) {
      $sTypeFormRequestOffer = FString::STRING_EMPTY;
      $bFindPurchaseFormRequestOfferSelected = false;
      
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      if ((!is_null($oPurchasesFormRequestOffer)) && (!is_null($oPurchasesModuleParameters))) {
         $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
         foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
            if (!$bFindPurchaseFormRequestOfferSelected) {
               if ($oPurchasesFormRequestOfferLine->selected) {
                  if ($oPurchasesFormRequestOfferLine->price < $oPurchasesModuleParameters->range_price_three_offers) $sTypeFormRequestOffer = FModulePurchasesManagement::TYPE_FORM_REQUEST_OFFER_WITHOUT_CONTRACTING_PROCEDURE;
                  else if ($oPurchasesFormRequestOfferLine->price >= $oPurchasesModuleParameters->range_price_tendering) $sTypeFormRequestOffer = FModulePurchasesManagement::TYPE_FORM_REQUEST_OFFER_TENDERING;
                  else $sTypeFormRequestOffer = FModulePurchasesManagement::TYPE_FORM_REQUEST_OFFER_3_OFFERS;
                  
                  $bFindPurchaseFormRequestOfferSelected = true;
               }
            }
         }      
      }
      
      return $sTypeFormRequestOffer;    
   }

   
   public static function updateStatusFormContractingProcedure($nIdForm) {
      $bStatusPending = false;
               
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_CREATED) {
            // search all offers
            $oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormContractingProcedure->id);
            foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLine) {
               if ($oPurchasesFormContractingProcedureLine->selected) {
                  $bStatusPending = true;
               }   
            }
            
            if ($bStatusPending) {  
               if ((FModulePurchasesManagement::getTypeFormRequestOffer($nIdForm) == FModulePurchasesManagement::TYPE_FORM_REQUEST_OFFER_TENDERING) || (FModulePurchasesManagement::getTypeFormRequestOffer($nIdForm) == FModulePurchasesManagement::TYPE_FORM_REQUEST_OFFER_3_OFFERS)) {
                  $oPurchasesFormContractingProcedure->status = FModulePurchasesManagement::STATUS_ACCEPTED; 
                  
                  $oPurchasesFormContractingProcedure->accept_date = date('Y-m-d H:i:s');
                  $oPurchasesFormContractingProcedure->discard_reason = null;
                  
                  $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
                  if (!FString::isNullOrEmpty($sCurrentUser)) $oPurchasesFormContractingProcedure->user_accept_discard = $sCurrentUser;
               }
               else {
                  $oPurchasesFormContractingProcedure->status = FModulePurchasesManagement::STATUS_CREATED; 
               }
            }
            else $oPurchasesFormContractingProcedure->status = FModulePurchasesManagement::STATUS_CREATED;
            
            if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_CREATED) {
               // Unselect all offers
               $oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormContractingProcedure->id);
               foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLine) { 
                  if ($oPurchasesFormContractingProcedureLine->selected) {
                     $oPurchasesFormContractingProcedureLine->selected = false;
                     $oPurchasesFormContractingProcedureLine->save();
                  }
               }
            }
            
            $oPurchasesFormContractingProcedure->save();
         }
      }   
   }
      
   
   public static function allowSelectFormRequestOfferLine($nIdForm) {
      $bAllowSelect = false;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOfferLine)) {
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferLine->form_request_offer->id_user)) {
            if ($oPurchasesFormRequestOfferLine->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) {
               if (($oPurchasesFormRequestOfferLine->price >= 0) && (!FString::isNullOrEmpty($oPurchasesFormRequestOfferLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormRequestOfferLine->offer))) {
                  $bAllowSelect = true;   
               }
            }
         }   
      }
      
      return $bAllowSelect; 
   }
   public static function allowSelectFormContractingProcedureLine($nIdForm) {
      $bAllowSelect = false;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureLine)) {                                                                                                                          
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureLine->form_request_offer->id_user)) {
            if (($oPurchasesFormContractingProcedureLine->price >= 0) && (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLine->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $oPurchasesFormContractingProcedureLine->offer))) {
               $bAllowSelect = true;   
            }
         }   
      }
      
      return $bAllowSelect; 
   }
   
   
   public static function allowNotifyFormPurchaseOrder($nIdForm) {
      $bAllowNotify = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);   
      
      if (!is_null($oPurchasesFormPurchaseOrder)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormPurchaseOrder->id_user)) {
            $oProvider = Providers::getProvider($oPurchasesFormPurchaseOrder->id_provider);
            $oUser = Users::getUser(Yii::app()->user->id);
            
            if ((!FString::isNullOrEmpty($oPurchasesFormPurchaseOrder->order)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_ORDERS . $oPurchasesFormPurchaseOrder->order))) {
               if ((!is_null($oProvider)) && (!is_null($oUser))) {
                  if ((!FString::isNullOrEmpty($oProvider->mail)) && ($oProvider->mail != '0') && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) $bAllowNotify = true;    
               }   
            }
         }    
      }
      
      return $bAllowNotify; 
   }
   public static function allowNotifyFormRequestOfferLine($nIdForm) {
      $bAllowNotify = false;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
      
      if (!is_null($oPurchasesFormRequestOfferLine)) {
         $oPurchasesFormRequestOfferArticles = PurchasesFormsRequestOffersArticles::getPurchasesFormsRequestOffersArticlesByIdFormFK($oPurchasesFormRequestOfferLine->form_request_offer->id);
         
         if (count($oPurchasesFormRequestOfferArticles) > 0) {                                                                                                                          
            if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferLine->form_request_offer->id_user)) {
               if ($oPurchasesFormRequestOfferLine->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) {
                  $oProvider = Providers::getProvider($oPurchasesFormRequestOfferLine->id_provider);
                  $oUser = Users::getUser(Yii::app()->user->id);
                         
                  if ((!is_null($oProvider)) && (!is_null($oUser))) {
                     if ((!FString::isNullOrEmpty($oProvider->mail)) && ($oProvider->mail != '0') && (!FString::isNullOrEmpty($oUser->mail_smtp_mail)) && (!FString::isNullOrEmpty($oUser->mail_smtp_host)) && (!FString::isNullOrEmpty($oUser->mail_smtp_port)) && (!FString::isNullOrEmpty($oUser->mail_smtp_user)) && (!FString::isNullOrEmpty($oUser->mail_smtp_passwd))) $bAllowNotify = true;    
                  }   
               }
            }
         }    
      }
           
      return $bAllowNotify; 
   }
   
   
   public static function allowChangeStatusFormRequestOffer($nIdForm) {
      $bAllowChangeStatus = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOffer)) {
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT))) {
            $oEmployeeMainDepartment = null;
            $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
            
            $oPurchasesFormRequestOfferEmployee = Employees::getEmployeeByIdUser($oPurchasesFormRequestOffer->id_user);
            if (!is_null($oEmployee)) {
               $oEmployeeMainDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
            }
            
            if ((is_null($oEmployee)) || ((!is_null($oEmployee)) && (FString::isNullOrEmpty($oEmployee->top_department)) && ($oPurchasesFormRequestOffer->id_user == Yii::app()->user->id)) || ((!is_null($oEmployee)) && ($oPurchasesFormRequestOffer->id_user != Yii::app()->user->id) && (!is_null($oPurchasesFormRequestOfferEmployee)) && (!FString::isNullOrEmpty($oPurchasesFormRequestOfferEmployee->top_department)) && (!is_null($oEmployeeMainDepartment)) && ($oPurchasesFormRequestOfferEmployee->top_department == $oEmployeeMainDepartment->department))) { 
               if (($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_PENDING) || ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_DISCARDED)) $bAllowChangeStatus = true;    
            }
         }    
      }
      
      return $bAllowChangeStatus;        
   }
   public static function allowChangeStatusFormContractingProcedure($nIdForm) {
      $bAllowChangeStatus = false;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT))) {
            if (($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_ACCEPTED) || ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_DISCARDED)) $bAllowChangeStatus = true;    
         }    
      }
      
      return $bAllowChangeStatus;        
   }

 
   public static function allowUpdateFormPurchaseOrder($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
            
      if (!is_null($oPurchasesFormPurchaseOrder)) {                                                                                                                        
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormPurchaseOrder->id_user)) {
            $bAllowUpdate = true;    
         }    
      }
      
      return $bAllowUpdate;  
   }  
   public static function allowUpdateFormPurchaseOrderArticles($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
            
      if (!is_null($oPurchasesFormPurchaseOrder)) {                                                                                                                        
         if (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormPurchaseOrder->id_user)) && ($oPurchasesFormPurchaseOrder->status != FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) && ($oPurchasesFormPurchaseOrder->status != FModulePurchasesManagement::STATUS_FINALIZED)) {
            $bAllowUpdate = true;    
         }    
      }
      
      return $bAllowUpdate;  
   } 
   public static function allowUpdateFormPurchaseOrderInvoices($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
            
      if (!is_null($oPurchasesFormPurchaseOrder)) {    
         $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
         if (!is_null($oEmployee)) $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                                                                                                         
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || ((!is_null($oEmployeeDepartment)) && ($oEmployeeDepartment->department == FApplication::EMPLOYEE_DEPARTMENT_ADMINISTRATION))) {
            $bAllowUpdate = true;                                                                     
         }    
      }
      
      return $bAllowUpdate;   
   }
   public static function allowUpdateFormRequestOffer($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOffer)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOffer->id_user)) {
            if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowUpdate = true;    
         }    
      }
      
      return $bAllowUpdate;        
   }
   public static function allowUpdateFormRequestOfferArticle($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOfferArticle)) {                                                                                                                                                                      
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferArticle->form_request_offer->id_user)) {
            if ($oPurchasesFormRequestOfferArticle->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowUpdate = true;    
         }    
      }
      
      return $bAllowUpdate; 
   }
   public static function allowUpdateFormContractingProcedure($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_CREATED) || ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_ACCEPTED)) $bAllowUpdate = true;    
      }
       
      return $bAllowUpdate;
   }
   public static function allowUpdateFormRequestOfferLine($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOfferLine)) {                                                                                                                        
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferLine->form_request_offer->id_user)) {
            if ($oPurchasesFormRequestOfferLine->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowUpdate = true;    
         }    
      }
      
      return $bAllowUpdate; 
   }
   public static function allowUpdateFormContractingProcedureLine($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureLine)) {
        if (($oPurchasesFormContractingProcedureLine->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) || ($oPurchasesFormContractingProcedureLine->form_request_offer->status == FModulePurchasesManagement::STATUS_ACCEPTED)) $bAllowUpdate = true;    
      }
      
      return $bAllowUpdate; 
   }
   public static function allowUpdateFormContractingProcedureLineObjectives($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureLine)) {
         if (($oPurchasesFormContractingProcedureLine->form_request_offer->status == FModulePurchasesManagement::STATUS_ACCEPTED) && ($oPurchasesFormContractingProcedureLine->selected)) $bAllowUpdate = true;    
      }
      
      return $bAllowUpdate; 
   }
   public static function allowUpdateFinancialCost($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFinancialCost = PurchasesFinancialCosts::getPurchasesFinancialCost($nIdForm);
      
      if (!is_null($oPurchasesFinancialCost)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) $bAllowUpdate = true;
         else { 
            if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && ($oPurchasesFinancialCost->year >= date('Y'))) $bAllowUpdate = true;
         }
      }

      return $bAllowUpdate;     
   }
   public static function allowUpdateFinancialCostLine($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdForm);
      
      if (!is_null($oPurchasesFinancialCostLine)) {
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) $bAllowUpdate = true;
         else { 
            if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && ($oPurchasesFinancialCostLine->financial_cost->year >= date('Y'))) $bAllowUpdate = true;
         }
      }

      return $bAllowUpdate;
   }
   public static function allowUpdateFormContractingProcedureDocument($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormContractingProcedureDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormRequestOfferDocument($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureDocument)) {
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureDocument->id_user)) {
            $bAllowUpdate = true;    
         }  
      }
      
      return $bAllowUpdate;
   } 
   public static function allowUpdateFormManagementContractingProcedure($nIdForm) {
      $bAllowUpdate = false;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_ACCEPTED) $bAllowUpdate = true;    
      }
      
      return $bAllowUpdate; 
   }
   
     
   public static function allowDeleteFormPurchaseOrder($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
            
      if (!is_null($oPurchasesFormPurchaseOrder)) {                                                                                                                        
         if ((Users::getIsMaster(Yii::app()->user->id) || (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormPurchaseOrder->id_user)) && (FDate::getDiffHours($oPurchasesFormPurchaseOrder->accept_date, date('Y-m-d H:i:s')) < FDate::NUM_HOURS_DAY)))) {
            $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete;        
   }
   public static function allowDeleteFormPurchaseOrderArticles($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
            
      if (!is_null($oPurchasesFormPurchaseOrder)) {                                                                                                                        
         if (((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormPurchaseOrder->id_user)) && ($oPurchasesFormPurchaseOrder->status != FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED) && ($oPurchasesFormPurchaseOrder->status != FModulePurchasesManagement::STATUS_FINALIZED)) {
            $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete;        
   } 
   public static function allowDeleteFormRequestOffer($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOffer)) {                                                                                                                          
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOffer->id_user)) {
            if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete;        
   }
   public static function allowDeleteFormContractingProcedure($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedure)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedure->id_user)) {
            if ($oPurchasesFormContractingProcedure->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete;        
   }
   public static function allowDeleteFormRequestOfferArticle($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOfferArticle)) {                                                                                                                                                                      
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferArticle->form_request_offer->id_user)) {
            if ($oPurchasesFormRequestOfferArticle->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFormContractingProcedureArticle($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedureArticle = PurchasesFormsRequestOffersArticles::getPurchasesFormRequestOfferArticle($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureArticle)) {                                                          
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureArticle->form_request_offer->id_user)) {
            if ($oPurchasesFormContractingProcedureArticle->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFormRequestOfferLine($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormRequestOfferLine)) {                                                                                                                         
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormRequestOfferLine->form_request_offer->id_user)) {
            if ($oPurchasesFormRequestOfferLine->form_request_offer->status == FModulePurchasesManagement::STATUS_CREATED) $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFormContractingProcedureLine($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedureLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureLine)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureLine->form_request_offer->id_user)) {
            $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFormContractingProcedureRecord($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedureRecord = PurchasesFormsRequestOffersRecords::getPurchasesFormRequestOfferRecord($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureRecord)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT))) {
            $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFormContractingProcedureNotification($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedureNotification = PurchasesFormsRequestOffersNotifications::getPurchasesFormRequestOfferNotification($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureNotification)) {                                                                                                                       
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureNotification->id_user)) {
            $bAllowDelete = true;    
         }    
      }
      
      return $bAllowDelete; 
   }
   public static function allowDeleteFinancialCostLine($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nIdForm);
      
      if (!is_null($oPurchasesFinancialCostLine)) {
         $oPurchasesFormsRequestOffers = PurchasesFormsRequestOffers::getPurchasesFormsRequestOffers(null, null, null, $oPurchasesFinancialCostLine->id);
         $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, $oPurchasesFinancialCostLine->id);
         $oPurchasesFormsRequestOffersLinesObjectives = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormsRequestOffersLinesObjectivesByIdFinancialCostLine($oPurchasesFinancialCostLine->id);
                                          
         if ((count($oPurchasesFormsRequestOffers) == 0) && (count($oPurchasesFormsPurchaseOrders) == 0) && (count($oPurchasesFormsRequestOffersLinesObjectives) == 0)) {
            if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) $bAllowDelete = true;
            else { 
               if ((!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) && ($oPurchasesFinancialCostLine->financial_cost->year >= date('Y'))) $bAllowDelete = true;
            }
         }
      }

      return $bAllowDelete; 
   }
   public static function allowDeleteContractingProcedure($nIdForm) {
      $bAllowDelete = true;
      $oPurchasesFormsRequestOffers = PurchasesFormsRequestOffers::getPurchasesFormsRequestOffers(true);
      
      foreach($oPurchasesFormsRequestOffers as $oPurchasesFormRequestOffer) {
         if ($oPurchasesFormRequestOffer->id_contracting_procedure == $nIdForm) $bAllowDelete = false;
      }
      
      return $bAllowDelete;
   }
   public static function allowDeleteFormContractingProcedureDocument($nIdForm) {
      $bAllowDelete = false;
      $oPurchasesFormContractingProcedureDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormRequestOfferDocument($nIdForm);
            
      if (!is_null($oPurchasesFormContractingProcedureDocument)) {
         if ((Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Yii::app()->user->id == $oPurchasesFormContractingProcedureDocument->id_user)) {
            if (is_null($oPurchasesFormContractingProcedureDocument->id_form_request_offer_document)) {
               $oPurchasesFormContractingProcedureChildDocuments = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersChildDocumentsByIdFormFK($oPurchasesFormContractingProcedureDocument->id, $oPurchasesFormContractingProcedureDocument->id_form_request_offer);
               if (count($oPurchasesFormContractingProcedureChildDocuments) == 0) { 
                  $bAllowDelete = true;    
               }
            }
            else {
               $oPurchasesFormContractingProcedureLastChildDocument = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersLastChildDocumentByIdFormFK($oPurchasesFormContractingProcedureDocument->id_form_request_offer_document, $oPurchasesFormContractingProcedureDocument->id_form_request_offer);       
               if ((!is_null($oPurchasesFormContractingProcedureLastChildDocument)) && ($oPurchasesFormContractingProcedureLastChildDocument->id == $oPurchasesFormContractingProcedureDocument->id)) {
                  $bAllowDelete = true;       
               }
            }
         }  
      }
      
      return $bAllowDelete;
   } 
   
   
   public static function getStatusFormPurchaseOrderWarehouseReception($nIdForm) {
      $sStatusFormPurchaseOrderWarehouseReception = FModulePurchasesManagement::STATUS_PENDING;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrder($nIdForm);
      
      if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (!is_null($oPurchasesFormPurchaseOrder))) {
         $oWarehouseFormsInputs = WarehouseFormsInputs::getWarehouseFormsInputs(true, null, $nIdForm);

         if (count($oWarehouseFormsInputs) > 0) {
            $oWarehouseFormInput = $oWarehouseFormsInputs[0];
            
            if ($oWarehouseFormInput->status == FModuleWarehouseManagement::STATUS_SUCCESS) {
               $oWarehouseFormsOutputs = array();
               
               if (!FString::isNullOrEmpty($oWarehouseFormInput->code)) {
                  $oWarehouseFormsOutputs = WarehouseFormsOutputs::getWarehouseFormsOutputsByCode($oWarehouseFormInput->code);
               }
               
               if (count($oWarehouseFormsOutputs) == 0) { 
                  $bPurchasesFormPurchaseOrderHaveServices = false;
                  $oPurchasesFormPurchaseOrderArticles = PurchasesFormsPurchaseOrdersArticles::getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($oPurchasesFormPurchaseOrder->id);
                  foreach($oPurchasesFormPurchaseOrderArticles as $oPurchasesFormPurchaseOrderArticle) {
                     if ($oPurchasesFormPurchaseOrderArticle->service) $bPurchasesFormPurchaseOrderHaveServices = true;      
                  }
                  
                  if (!$bPurchasesFormPurchaseOrderHaveServices) $sStatusFormPurchaseOrderWarehouseReception = FModulePurchasesManagement::STATUS_COMPLETED;
                  else $sStatusFormPurchaseOrderWarehouseReception = FModulePurchasesManagement::STATUS_ALERT_ORANGE;
               }
               else $sStatusFormPurchaseOrderWarehouseReception = FModulePurchasesManagement::STATUS_ERROR;
            }
            else if (($oWarehouseFormInput->status == FModuleWarehouseManagement::STATUS_ALERT) || ($oWarehouseFormInput->status == FModuleWarehouseManagement::STATUS_ERROR)) {
               $sStatusFormPurchaseOrderWarehouseReception = FModulePurchasesManagement::STATUS_ERROR;   
            }
         }
      }
      
      return strtolower($sStatusFormPurchaseOrderWarehouseReception);   
   } 
   
   
   public static function getContractingProcedureIdExpedient() {
      $nIdExpedient = 0;
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesLastCompletedFormRequestOfferContractingProcedure();
      
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedure->contracting_procedure_expedient)) {
            $oContractingProcedureExpedient = explode('/', $oPurchasesFormContractingProcedure->contracting_procedure_expedient);
            if (count($oContractingProcedureExpedient) == 3) $nIdExpedient = intval($oContractingProcedureExpedient[2]);  
         }   
      }  
      
      return $nIdExpedient; 
   }
   
   
   public static function getFormContractingProcedureAboutToExpire($nIdForm) {
      $bFormContractingProcedureAboutToExpire = false; 
                                                                
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($nIdForm);
      if (!is_null($oPurchasesFormContractingProcedure)) {
         if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedure->contracting_procedure_end_date)) {
            if (FDate::getDiffDays(date('Y-m-d'), $oPurchasesFormContractingProcedure->contracting_procedure_end_date) <= FModulePurchasesManagement::NOTICE_NUM_DAYS_EXPIRATION_TENDER_OR_CONTRACT) {
               $bFormContractingProcedureAboutToExpire = true;
            }
         }
           
         if (!$bFormContractingProcedureAboutToExpire) {
            $oPurchasesFormsContractingProcedureLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormContractingProcedure->id);
            foreach($oPurchasesFormsContractingProcedureLines as $oPurchasesFormContractingProcedureLine) {
               if (($oPurchasesFormContractingProcedureLine->selected) && (!$bFormContractingProcedureAboutToExpire)) {
                  $oPruchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrdersByIdProviderAndIdFormFK($oPurchasesFormContractingProcedureLine->id_provider, $oPurchasesFormContractingProcedure->id);
                  $nTotalSumOrders = 0;
                  $nTotalSumInvoices = 0;
                  foreach($oPruchasesFormsPurchaseOrders as $oPruchasesFormPurchaseOrder) {
                     $nTotalSumOrders += $oPruchasesFormPurchaseOrder->price;
                     $nTotalSumInvoices += PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($oPruchasesFormPurchaseOrder->id, false);
                  }
                  
                  if (($nTotalSumOrders > $oPurchasesFormContractingProcedureLine->price) || ($nTotalSumInvoices > $oPurchasesFormContractingProcedureLine->price)) $bFormContractingProcedureAboutToExpire = true;
               }
            }   
         }
      }
      
      return $bFormContractingProcedureAboutToExpire;  
   }
   
   public static function synchronizeProvidersFromExternalDB() {
      $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
      if (!is_null($oPurchasesModuleParameters)) { 
         if ($oPurchasesModuleParameters->database_providers_synchronization) {
            $nResourceConnectionId = @odbc_connect($oPurchasesModuleParameters->database_providers_connection_string, $oPurchasesModuleParameters->database_providers_user, $oPurchasesModuleParameters->database_providers_passwd);
      
            if ($nResourceConnectionId) {
               $sSqlQuery = 'SELECT ' . $oPurchasesModuleParameters->database_providers_table . '.*, tblDireccionesEmail.Email AS mail, tblTelefonos.Codigo AS phone FROM ' . $oPurchasesModuleParameters->database_providers_table . ' LEFT OUTER JOIN tblDireccionesEmail ON ' . $oPurchasesModuleParameters->database_providers_table . '.EMail = tblDireccionesEmail.IdNumero AND ' . $oPurchasesModuleParameters->database_providers_table . '.IdEmpresa = tblDireccionesEmail.IdEmpresa LEFT OUTER JOIN tblTelefonos ON ' . $oPurchasesModuleParameters->database_providers_table . '.Telefono = tblTelefonos.IdNumero AND ' . $oPurchasesModuleParameters->database_providers_table . '.IdEmpresa = tblTelefonos.IdEmpresa';

               if (!FString::isNullOrEmpty($oPurchasesModuleParameters->database_provider_where_condition)) $sSqlQuery .= ' WHERE ' . $oPurchasesModuleParameters->database_provider_where_condition;  

               $sSqlQueryResult = @odbc_exec($nResourceConnectionId, $sSqlQuery); 
      
               $oPairMatchTokens = explode(',', $oPurchasesModuleParameters->database_providers_table_columns_match);
                   
               for (;@odbc_fetch_row($sSqlQueryResult);) {
                  $bNewProvider = false;
                  
                  $sNif = @odbc_result($sSqlQueryResult, $oPurchasesModuleParameters->database_providers_table_column_nif);
                  $oProvider = Providers::getProviderByNIF($sNif);
                  
                  if (is_null($oProvider)) {
                     $bNewProvider = true;
                     
                     $oProvider = new Providers(); 
                     $oProvider->nif = $sNif;    
                     $oProvider->module = FApplication::MODULE_PURCHASES_MANAGEMENT;
                  }
                     
                  foreach($oPairMatchTokens as $sPairMatchToken) {
                     $oMatchTokens = explode('=>', $sPairMatchToken);
                                                                                                                                     
                     if (trim($oMatchTokens[0]) == 'Nombre') {     
                        eval('return $oProvider->' . eval('return ' . trim($oMatchTokens[1]) . ';') . ' =  mb_convert_encoding(@odbc_result($sSqlQueryResult, trim($oMatchTokens[0])), \'UTF-8\', \'ISO-8859-1\');');
                     }
                     else if (trim($oMatchTokens[0]) == 'EMail') {  
                        if ($bNewProvider) eval('return $oProvider->' . eval('return ' . trim($oMatchTokens[1]) . ';') . ' = @odbc_result($sSqlQueryResult, trim(\'mail\'));');
                     }
                     else if (trim($oMatchTokens[0]) == 'Telefono') {       
                        eval('return $oProvider->' . eval('return ' . trim($oMatchTokens[1]) . ';') . ' = @odbc_result($sSqlQueryResult, trim(\'phone\'));');
                     }
                     else eval('return $oProvider->' . eval('return ' . trim($oMatchTokens[1]) . ';') . ' = @odbc_result($sSqlQueryResult, trim($oMatchTokens[0]));');  
                  } 

                  if ((!is_null($oProvider)) && (!FString::isNullOrEmpty($oProvider->nif))) {  
                     $oProvider->save();
                  }
               }

               @odbc_close($nResourceConnectionId);  
            }
         }
      }
   }
}
?>