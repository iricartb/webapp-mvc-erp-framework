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
            'actions'=>array('viewRounds'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)',
         ),                                                                                                                                                                                                                                 
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionViewRounds() {
      $oMonitoringRoundsForm = new MonitoringRoundsForm();

      // Ajax validation request=>Unique validator
      FForm::validateAjaxForm('monitoring-rounds-form', $oMonitoringRoundsForm);
       
      if (isset($_POST['MonitoringRoundsForm'])) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'REPORT_ROUNDS_NAME');
         $oPHPExcel = $this->reportExcelRounds($sFilename, $_POST['MonitoringRoundsForm']['sEmployee'], $_POST['MonitoringRoundsForm']['sStartDate'], $_POST['MonitoringRoundsForm']['sEndDate'], $_POST['MonitoringRoundsForm']['sDocFormat']);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['MonitoringRoundsForm']['sDocFormat']));            
      }

      $this->render('viewRounds', array('oModelForm'=>$oMonitoringRoundsForm));
   }
   
   private function reportExcelRounds($sFilename, $sUser, $sStartDate, $sEndDate, $sDocFormat) { 
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
                          
      $nDiffDays = FDate::getDiffDays(FDate::getEnglishDate($sStartDate), FDate::getEnglishDate($sEndDate));
      $sDate = FDate::getEnglishDate($sStartDate);
                 
      for($i = 0; $i <= $nDiffDays; $i++) {
         $this->reportExcelRoundsByDate($oPHPExcel, $sUser, $sDate, $sDocFormat);
         
         $sDate = date('Y-m-d', strtotime($sDate . ' +1 Day'));
      }
       
      if ($oPHPExcel->getSheetCount() > 0) $oPHPExcel->setActiveSheetIndex(0);
      else FReportExcel::addSheet($oPHPExcel, FReportExcel::BLANK_SHEET_NAME);
      
      return $oPHPExcel;               
   }
   
   private function reportExcelRoundsByDate($oPHPExcel, $sUser, $sDate, $sDocFormat) {    
      $oMonitoringFormsTurnRounds = MonitoringFormsTurnRounds::getMonitoringFormsTurnRoundsByUserDate($sUser, $sDate);
               
      if (count($oMonitoringFormsTurnRounds) > 0) {     
         FReportExcel::addSheet($oPHPExcel, $sDate);

         $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
         if ($bDocIsPDF) $nFontSize = 10;
         else $nFontSize = 10;
         $bFirst = true;
         
         $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
         $nRow = 1;
         

         FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
         $oPHPExcelActiveSheet->getStyle('A:E')->getFont()->setSize($nFontSize);
         $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
         
         if ($bDocIsPDF) {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(27.8);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(27.8);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(27.8);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(27.8);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(13.9);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(13.9);
         }
         else {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(19.5);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(19.5);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(19.5);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(19.5);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9.75);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(9.75);
         }
         
         foreach($oMonitoringFormsTurnRounds as $oMonitoringFormTurnRound) {
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_USERNAME'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oMonitoringFormTurnRound->user_name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            $nRow++;
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_NAME'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oMonitoringFormTurnRound->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            $nRow++;
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_STARTDATE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRound->start_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            $nRow++;
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_ENDDATE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRound->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            $nRow++;
            
            $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_SDIFFDATE'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, FDate::getDiffDatesDescription($oMonitoringFormTurnRound->start_date, $oMonitoringFormTurnRound->end_date, false, false, false), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            $nRow += 2;
            
            $nCurrentFormTurnRoundGroupForm = 0;
            $oMonitoringFormsTurnRoundGroupForms = MonitoringFormsTurnRoundGroupForms::getMonitoringFormsTurnRoundGroupFormsByIdFormFK($oMonitoringFormTurnRound->id, true);
            foreach($oMonitoringFormsTurnRoundGroupForms as $oMonitoringFormTurnRoundGroupForm) {
               $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':' . 'F' . ($nRow + 1))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModulePlantMonitoringManagement::HEADER_GROUP_FORM_COLOR)));
               
               $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow); 
               FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oMonitoringFormTurnRoundGroupForm->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
  
               $sCurrentFormTurnRoundGroupFormStartDate = FString::STRING_EMPTY;
               if ($nCurrentFormTurnRoundGroupForm == 0) $sCurrentFormTurnRoundGroupFormStartDate = $oMonitoringFormTurnRoundGroupForm->start_date;
               else $sCurrentFormTurnRoundGroupFormStartDate = $oMonitoringFormsTurnRoundGroupForms[($nCurrentFormTurnRoundGroupForm - 1)]->end_date;
               
               if (FDate::isDateMinorEqual($sCurrentFormTurnRoundGroupFormStartDate, $oMonitoringFormTurnRoundGroupForm->end_date)) {
                  FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FDate::getTimeZoneFormattedDate($sCurrentFormTurnRoundGroupFormStartDate, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundGroupForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               }
               else {
                  FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundGroupForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundGroupForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               }
               $nRow++;
               
               $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'C' . $nRow); 
               FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oMonitoringFormTurnRoundGroupForm->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               
               if (FDate::isDateMinorEqual($sCurrentFormTurnRoundGroupFormStartDate, $oMonitoringFormTurnRoundGroupForm->end_date)) FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getDiffDatesDescription($sCurrentFormTurnRoundGroupFormStartDate, $oMonitoringFormTurnRoundGroupForm->end_date, false, false, false), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               else FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getDiffDatesDescription($oMonitoringFormTurnRoundGroupForm->end_date, $oMonitoringFormTurnRoundGroupForm->end_date, false, false, false), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               $nRow += 2;
               
               $nCurrentFormTurnRoundForm = 0;
               $oMonitoringFormsTurnRoundForms = MonitoringFormsTurnRoundForms::getMonitoringFormsTurnRoundFormsByIdFormFK($oMonitoringFormTurnRoundGroupForm->id, true);
               foreach($oMonitoringFormsTurnRoundForms as $oMonitoringFormTurnRoundForm) {
                  if (!Fstring::isNullOrEmpty($oMonitoringFormTurnRoundForm->comments)) {
                     $oPHPExcelActiveSheet->getStyle('B' . $nRow . ':' . 'F' . ($nRow + 4))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModulePlantMonitoringManagement::HEADER_FORM_COLOR)));
                  }
                  else $oPHPExcelActiveSheet->getStyle('B' . $nRow . ':' . 'F' . ($nRow + 1))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModulePlantMonitoringManagement::HEADER_FORM_COLOR)));
                   
                  FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oMonitoringFormTurnRoundForm->name, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, FString::STRING_EMPTY, null, true);
                  
                  $sCurrentFormTurnRoundFormStartDate = FString::STRING_EMPTY;
                  if ($nCurrentFormTurnRoundForm == 0) $sCurrentFormTurnRoundFormStartDate = $sCurrentFormTurnRoundGroupFormStartDate;
                  else $sCurrentFormTurnRoundFormStartDate = $oMonitoringFormsTurnRoundForms[($nCurrentFormTurnRoundForm - 1)]->end_date;
   
                  if (FDate::isDateMinorEqual($sCurrentFormTurnRoundFormStartDate, $oMonitoringFormTurnRoundForm->end_date)) {
                     FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FDate::getTimeZoneFormattedDate($sCurrentFormTurnRoundFormStartDate, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                     FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  }
                  else {
                     FReportExcel::setCellValue($oPHPExcel, 'C' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                     FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getTimeZoneFormattedDate($oMonitoringFormTurnRoundForm->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);   
                  }
                  $nRow++;
                  
                  $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'C' . $nRow); 
                  FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oMonitoringFormTurnRoundForm->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);

                  if (FDate::isDateMinorEqual($sCurrentFormTurnRoundFormStartDate, $oMonitoringFormTurnRoundForm->end_date)) FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getDiffDatesDescription($sCurrentFormTurnRoundFormStartDate, $oMonitoringFormTurnRoundForm->end_date, false, false, false), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  else FReportExcel::setCellValue($oPHPExcel, 'D' . $nRow, FDate::getDiffDatesDescription($oMonitoringFormTurnRoundForm->end_date, $oMonitoringFormTurnRoundForm->end_date, false, false, false), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP); 
                  $nRow++;
                  
                  if (!Fstring::isNullOrEmpty($oMonitoringFormTurnRoundForm->comments)) {
                     $oPHPExcelActiveSheet->mergeCells('B' . ($nRow + 1) . ':' . 'F' . ($nRow + 2)); 
                     FReportExcel::setCellValue($oPHPExcel, 'B' . ($nRow + 1), Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_COMMENTS') . ': ' . $oMonitoringFormTurnRoundForm->comments, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
                     $nRow += 3;
                  }
                  
                  $nCurrentFormTurnRoundFormQuestion = 1;
                  $oMonitoringFormsTurnRoundFormsQuestions = MonitoringFormsTurnRoundFormsQuestions::getMonitoringFormsTurnRoundFormsQuestionsByIdFormFK($oMonitoringFormTurnRoundForm->id);
                  foreach($oMonitoringFormsTurnRoundFormsQuestions as $oMonitoringFormTurnRoundFormQuestion) {
                     $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'D' . $nRow); 
                     FReportExcel::setCellValue($oPHPExcel, 'B' . $nRow, $oMonitoringFormTurnRoundFormQuestion->description, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);      
                  
                     $sFieldValue = FString::STRING_EMPTY;
                     if ($oMonitoringFormTurnRoundFormQuestion->field_type == FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT) {
                        if ($oMonitoringFormTurnRoundFormQuestion->field_value) $sFieldValue = Yii::t('system', 'SYS_YES');
                        else $sFieldValue = Yii::t('system', 'SYS_NO');
                     }
                     else $sFieldValue = $oMonitoringFormTurnRoundFormQuestion->field_value;
                     
                     FReportExcel::setCellValue($oPHPExcel, 'E' . $nRow, $sFieldValue, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);      
                     
                     FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $oMonitoringFormTurnRoundFormQuestion->field_unit, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP); 
                     
                     if (count($oMonitoringFormsTurnRoundFormsQuestions) == $nCurrentFormTurnRoundFormQuestion) $nRow += 2;
                     else $nRow++;
                     
                     $nCurrentFormTurnRoundFormQuestion++;
                  }
                  
                  if ($nCurrentFormTurnRoundFormQuestion == 1) $nRow++;
                  
                  $nCurrentFormTurnRoundForm++;
               } 
               
               $nCurrentFormTurnRoundGroupForm++; 
            }
            
            $nRow += 4;   
         }
      } 
   }       
}