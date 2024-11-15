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
            'actions'=>array('viewPeople'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewPeople() {
      $oVisitorsPeopleForm = new VisitorsPeopleForm();

      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('visitors-people-form', $oVisitorsPeopleForm);
       
      if (isset($_POST['VisitorsPeopleForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'REPORT_PEOPLE_NAME');
         $oPHPExcel = $this->reportExcelPeople($sFilename, $_POST['VisitorsPeopleForm']['sType'], $_POST['VisitorsPeopleForm']['sDocFormat']);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['VisitorsPeopleForm']['sDocFormat']));            
      }

      $this->render('viewPeople', array('oModelForm'=>$oVisitorsPeopleForm));
   }
   
   private function reportExcelPeople($sFilename, $sType, $sDocFormat) { 
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      
      if (($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT) || ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE)) {               
         FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_VISIT));

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
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(52);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(46);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(56);
         }
         else {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(43);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(37);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(46);
         }
      }
      
      if (($sType == FModuleVisitorsManagement::TYPE_PEOPLE_EMPLOYEE) || ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE)) {
         FReportExcel::addSheet($oPHPExcel, Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPEOPLEFORM_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_PEOPLE_EMPLOYEE));

         $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
         if ($bDocIsPDF) $nFontSize = 10;
         else $nFontSize = 10;
         $bFirst = true;
         
         if ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE) $oPHPExcel->setActiveSheetIndex(1);
         $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
         $nRow = 1;
         
         $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

         FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
         $oPHPExcelActiveSheet->getStyle('A:D')->getFont()->setSize($nFontSize);
         $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
         
         if ($bDocIsPDF) {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(52);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(46);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(20);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(36);
         }
         else {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(43);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(37);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(18);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(28);
         }
      }
      
      $oPHPExcel->setActiveSheetIndex(0);
      
      if (($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT) || ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE)) {
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_FULLNAME'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_IDENTIFICATION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_BUSINESS'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         $nRow++;
         
         $oVisitorsVisits = VisitorsVisits::getActiveVisitorsVisits();
         foreach($oVisitorsVisits as $oVisit) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oVisit->visitor_full_name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);     
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oVisit->visitor_identification, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);      
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $oVisit->visitor_business, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);       
            
            $nRow++;
         }
      }
      
      $nRow = 1;
      if ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE) $oPHPExcel->setActiveSheetIndex(1);
      
      if (($sType == FModuleVisitorsManagement::TYPE_PEOPLE_EMPLOYEE) || ($sType == FModuleVisitorsManagement::TYPE_PEOPLE_VISIT_EMPLOYEE)) {
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_FULLNAME'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDENTIFICATION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_NUMEMPLOYEE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDBUSINESS'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
         $nRow++;
         
         $oEmployees = Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, FApplication::EMPLOYEE_ACCESS_CODE_NOT_NULL, true, true);
         
         foreach($oEmployees as $oEmployee) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oEmployee->full_name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);     
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oEmployee->identification, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);      
            FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $oEmployee->num_employee, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);       
            
            if (!is_null($oEmployee->id_business)) {
               $oBusiness = Businesses::getBusiness($oEmployee->id_business);
               if (!is_null($oBusiness)) {
                  FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, $oBusiness->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               }
            }
            
            $nRow++;
         }
      }
      
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
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(36);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(36);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(42);
      }
      else {
         $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(7);
         $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(7);
         $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(18);
         $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(28);
         $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(30);
         $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(36);
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
         
         $sZone = $oDigitalDiaryFormsTurnEventLine->zone;  
         $sRegion = $oDigitalDiaryFormsTurnEventLine->region;
         
         $sEquipment = FString::STRING_EMPTY;
         if (!FString::isNullOrEmpty($oDigitalDiaryFormsTurnEventLine->equipment)) $sEquipment = $oDigitalDiaryFormsTurnEventLine->equipment;     

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
            FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'F', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
            
            $bFirst = false;
         }
         
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sHour, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $sTurn, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, $sOwner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         
         FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, $sZone . '/' . $sRegion, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sEquipment, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
         
         $nRowsAdd = floor(strlen(html_entity_decode(strip_tags($sDescription))) / 50);
         
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'F' . ($nRow + $nRowsAdd));
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, html_entity_decode(strip_tags($sDescription)), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         
         if ($oDigitalDiaryFormsTurnEventLine->urgent) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':F' . ($nRow + $nRowsAdd))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleDigitalDiaryManagement::REPORT_EVENTS_COLOR_URGENT)));

                      
         $nRow += ($nRowsAdd + 1); 
      }  
   }       
}