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
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );                                                                          
   }
   
   
   public function actionViewEvents() {
      $oMaintenanceEventsForm = new MaintenanceEventsForm();
      $oEmployees = array();
      
      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('maintenance-events-form', $oMaintenanceEventsForm);
       
      if (isset($_POST['MaintenanceEventsForm'])) {
         if ($_POST['MaintenanceEventsForm']['bAllEmployees'] == false) {
            $oEmployees[0] = $_POST['MaintenanceEventsForm']['sEmployee'];  
         }
         else {
            $oMaintenanceFormsDailyEventsOwner = MaintenanceFormsDailyEvents::getMaintenanceFormsDailyEventsOwner(); 
            foreach ($oMaintenanceFormsDailyEventsOwner as $oMaintenanceFormDailyEventOwner) {
               $oEmployees[count($oEmployees)] = $oMaintenanceFormDailyEventOwner->owner;   
            }
         }
         
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'REPORT_EVENTS_NAME');
         $oPHPExcel = $this->reportExcelEvents($sFilename, $oEmployees, $_POST['MaintenanceEventsForm']['sStartDate'], $_POST['MaintenanceEventsForm']['sEndDate'], $_POST['MaintenanceEventsForm']['sDocFormat']);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['MaintenanceEventsForm']['sDocFormat']));            
      }

      $this->render('viewEvents', array('oModelForm'=>$oMaintenanceEventsForm));
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
      $oPHPExcelActiveSheet->getStyle('A:C')->getFont()->setSize($nFontSize);
      $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
      
      if ($bDocIsPDF) {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(20);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(84);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(16);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(78);
      }
         
      $sPreviousDate = FString::STRING_EMPTY;
      $oMaintenanceFormsDailyEventLines = MaintenanceFormDailyEventLines::getMaintenanceFormsDailyEventLines($sEmployee, $sStartDate, $sEndDate);
      foreach ($oMaintenanceFormsDailyEventLines as $oMaintenanceFormDailyEventLine) {
         $sDate = ucwords(FDate::getDayName($oMaintenanceFormDailyEventLine->formDailyEvent->date)) . ', ' . FDate::getTimeZoneFormattedDate($oMaintenanceFormDailyEventLine->formDailyEvent->date);
         $sHour = $oMaintenanceFormDailyEventLine->hour;
         $sDuration = $oMaintenanceFormDailyEventLine->duration;
         $sOwner = $oMaintenanceFormDailyEventLine->formDailyEvent->owner;
         
         $sDescription = $oMaintenanceFormDailyEventLine->description;
         
         if ($sPreviousDate != $sDate) {
            $sPreviousDate = $sDate;    
            if (!$bFirst) $nRow += 2;
            
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sDate, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $nRow++;
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_HOUR'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DURATION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSDAILYEVENTS_FIELD_OWNER'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DESCRIPTION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'D', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
            
            $bFirst = false;
         }
         
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sHour, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $sDuration, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $sOwner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         
         $nRowsAdd = floor(strlen(html_entity_decode(strip_tags($sDescription))) / 50);
         
         $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'D' . ($nRow + $nRowsAdd));
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, html_entity_decode(strip_tags($sDescription)), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         
         $nRow += ($nRowsAdd + 1); 
      }  
   }       
}