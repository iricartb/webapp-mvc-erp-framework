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
            'actions'=>array('viewEvents'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewEvents() {
      $oDigitalDiaryEventsForm = new DigitalDiaryEventsForm();
      $oEmployees = array();
      
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('digitaldiary-events-form', $oDigitalDiaryEventsForm);
       
      if (isset($_POST['DigitalDiaryEventsForm'])) {
         if ($_POST['DigitalDiaryEventsForm']['bAllEmployees'] == false) {
            $oEmployees[0] = $_POST['DigitalDiaryEventsForm']['sEmployee'];  
         }
         else {
            $oDigitalDiaryFormTurnEventsOwner = DigitalDiaryFormsTurnEvents::getDigitalDiaryFormsTurnEventsOwner(); 
            foreach ($oDigitalDiaryFormTurnEventsOwner as $oDigitalDiaryFormTurnEventOwner) {
               $oEmployees[count($oEmployees)] = $oDigitalDiaryFormTurnEventOwner->owner;   
            }
         }
         
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'REPORT_EVENTS_NAME');
         $oPHPExcel = $this->reportExcelEvents($sFilename, $oEmployees, $_POST['DigitalDiaryEventsForm']['sStartDate'], $_POST['DigitalDiaryEventsForm']['sEndDate'], $_POST['DigitalDiaryEventsForm']['sDocFormat']);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['DigitalDiaryEventsForm']['sDocFormat']));            
      }

      $this->render('viewEvents', array('oModelForm'=>$oDigitalDiaryEventsForm));
   }
   
   private function reportExcelEvents($sFilename, $oEmployees, $sStartDate, $sEndDate, $sDocFormat) { 
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
                          
      foreach ($oEmployees as $sEmployee) {
         $this->reportExcelEventsByEmployee($oPHPExcel, $sEmployee, $sStartDate, $sEndDate, $sDocFormat);
      }
      if (count($oEmployees) > 1) $this->reportExcelEventsByEmployee($oPHPExcel, null, $sStartDate, $sEndDate, $sDocFormat);
      else if (count($oEmployees) == 0) FReportExcel::addSheet($oPHPExcel, Yii::t('system', 'SYS_ALL_M')); 
      
      $oPHPExcel->setActiveSheetIndex(0);
      return $oPHPExcel;               
   }
   
   private function reportExcelEventsByEmployee($oPHPExcel, $sEmployee, $sStartDate, $sEndDate, $sDocFormat) {
      if (!is_null($sEmployee)) FReportExcel::addSheet($oPHPExcel, $sEmployee);
      else FReportExcel::addSheet($oPHPExcel, Yii::t('system', 'SYS_ALL_M')); 
      
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 10;
      else $nFontSize = 10;
      $bFirst = true;
      
      $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
      $nRow = 1;
      
      $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

      FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
      $oPHPExcelActiveSheet->getStyle('A:G')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(10);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(10);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(18);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(36);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(18);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(42);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(7);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(7);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(18);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(28);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(14);
         $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(36);
      }
         
      // Header Colors
      FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A');
      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);
      $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleDigitalDiaryManagement::REPORT_EVENTS_COLOR_URGENT)));
      $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT'));
      $nRow+=2;
         
      $sPreviousDate = FString::STRING_EMPTY;
      $oDigitalDiaryFormsTurnEventLines = DigitalDiaryFormTurnEventLines::getDigitalDiaryFormsTurnEventLines($sEmployee, $sStartDate, $sEndDate);   
      foreach ($oDigitalDiaryFormsTurnEventLines as $oDigitalDiaryFormsTurnEventLine) {
         $sDate = ucwords(FDate::getDayName($oDigitalDiaryFormsTurnEventLine->formTurnEvent->date)) . ', ' . FDate::getTimeZoneFormattedDate($oDigitalDiaryFormsTurnEventLine->formTurnEvent->date);
         $sHour = $oDigitalDiaryFormsTurnEventLine->hour;
         $sTurn = Yii::t('system', 'SYS_TURN_' . substr($oDigitalDiaryFormsTurnEventLine->formTurnEvent->turn, 2));
         $sOwner = $oDigitalDiaryFormsTurnEventLine->formTurnEvent->owner;
         
         $sSection = $oDigitalDiaryFormsTurnEventLine->section_name;
         $sZone = $oDigitalDiaryFormsTurnEventLine->zone;  
         $sRegion = $oDigitalDiaryFormsTurnEventLine->region;    
         $sEquipment = $oDigitalDiaryFormsTurnEventLine->equipment;
         
         $sDescription = $oDigitalDiaryFormsTurnEventLine->description;
         
         if ($sPreviousDate != $sDate) {
            $sPreviousDate = $sDate;    
            if (!$bFirst) $nRow += 2;
            
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'C' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sDate, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $nRow++;
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_TURN'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'G', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
            
            $bFirst = false;
         }
         
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sHour, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $sTurn, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $sOwner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, $sSection, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sZone . '/' . $sRegion, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $sEquipment, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         
         $nRowsAdd = floor(strlen(html_entity_decode(strip_tags($sDescription))) / 50);
         
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'G' . ($nRow + $nRowsAdd));
         FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, html_entity_decode(strip_tags($sDescription)), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         
         if ($oDigitalDiaryFormsTurnEventLine->urgent) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':G' . ($nRow + $nRowsAdd))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleDigitalDiaryManagement::REPORT_EVENTS_COLOR_URGENT)));

                      
         $nRow += ($nRowsAdd + 1); 
      }  
   }       
}