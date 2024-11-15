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
            'actions'=>array('formWorkingPartExport', 'formMaintenanceWorkingPartExport', 'formSpecialWorkingPartExport'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)',
         ),  
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   
   public function actionFormWorkingPartExport($nIdForm, $sFormat) {
      $oFormWorkingPart = FormsWorkingParts::getFormWorkingPart($nIdForm);

      if (!is_null($oFormWorkingPart)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_NAME');
         $oPHPExcel = $this->reportExcelFormWorkingPart($sFilename, $oFormWorkingPart, false, $sFormat);
      
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionFormMaintenanceWorkingPartExport($nIdForm, $sFormat) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::getFormMaintenanceWorkingPart($nIdForm);

      if (!is_null($oFormMaintenanceWorkingPart)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMMAINTENANCEWORKINGPART_NAME');
         $oPHPExcel = $this->reportExcelFormWorkingPart($sFilename, $oFormMaintenanceWorkingPart, true, $sFormat);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionFormSpecialWorkingPartExport($nIdForm, $sFormat) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::getFormSpecialWorkingPart($nIdForm);

      if (!is_null($oFormSpecialWorkingPart)) {
         $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_NAME');
         $oPHPExcel = $this->reportExcelFormSpecialWorkingPart($sFilename, $oFormSpecialWorkingPart, $sFormat);
       
         $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$sFormat));                  
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   private function reportExcelFormWorkingPart($sFilename, $oFormWorkingPart, $bIsMaintenance, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 9;
      else $nFontSize = 10;
                         
      if ($bIsMaintenance) $sMaintenance = 'MAINTENANCE';
      else $sMaintenance = FString::STRING_EMPTY;
       
      $nSheet = 0;
      for($nSheet = 0; $nSheet < 2; $nSheet++) {
         $bChangeFontEquipmentConditions = false;
         $bChangeFontMeasures = false;
         
         if ($nSheet == 0) $sSheetName = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_SHEET_ORIGINAL_NAME');
         else $sSheetName = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_SHEET_COPY_NAME'); 
         
         FReportExcel::addSheet($oPHPExcel, $sSheetName);
         FReportExcel::setVerticalMargin($oPHPExcel, 0.25, 0.25);
         FReportExcel::setHorizontalMargin($oPHPExcel, 0.25, 0.25);
         
         $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
         $nRow = 1;
         
         $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
         
         if ($bDocIsPDF) {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('U')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('V')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('W')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('X')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Y')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Z')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AA')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AB')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AC')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AD')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AE')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AF')->setWidth(3.05);
            $oPHPExcelActiveSheet->getColumnDimension('AG')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AH')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AI')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AJ')->setWidth(3.90); 
         }
         else {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('U')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('V')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('W')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('X')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Y')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Z')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AA')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AB')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AC')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AD')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AE')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AF')->setWidth(3.05);
            $oPHPExcelActiveSheet->getColumnDimension('AG')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AH')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AI')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AJ')->setWidth(3.90);
         }
         
         // Header
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 2), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         
         // --> Logo business
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . ($nRow + 2));

         $oImageDrawing = new PHPExcel_Worksheet_Drawing();
         $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
         if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
         $oImageDrawing->setCoordinates('A' . $nRow);
         
         $oImageDrawing->setResizeProportional(false);
         $oImageDrawing->setHeight(50);
         $oImageDrawing->setWidth(60);
         $oImageDrawing->setOffsetX(15);
         $oImageDrawing->setOffsetY(7);
         
         // --> Title
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'AD' . ($nRow + 2));
         if ($bIsMaintenance) $sValue =  FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMMAINTENANCEWORKINGPART_TITLE'));
         else $sValue =  FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_TITLE'));
         
         if ($bIsMaintenance) FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $sValue, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 11, null, null, true);
         else FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $sValue, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, null, null, true);
         
         // --> Number
         $oPHPExcelActiveSheet->mergeCells('AE' . $nRow . ':' . 'AJ' . ($nRow + 2));
         FReportExcel::setCellValue($oPHPExcel, 'AE' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_NUMBER') . $oFormWorkingPart->id, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, null, PHPExcel_Style_Color::COLOR_DARKRED);
         $nRow += 3;
         
         // 1st Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_OWNER') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $oFormWorkingPart->owner, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('O' . $nRow . ':' . 'S' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('T' . $nRow . ':' . 'X' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_PRIORITY') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'T' . $nRow, $oFormWorkingPart->priority, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AC' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('system', 'SYS_DATE') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, FDate::getTimeZoneFormattedDate($oFormWorkingPart->start_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // 2nd Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'X' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_EQUIPMENTSTUDIO') . ':', null, null, null, null, true);
         
         $sValue = FString::STRING_EMPTY;
         if ($bIsMaintenance) $sValue = Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_OPERATING'); 
         else {
            if ($oFormWorkingPart->equipment_studio_mechanic) {
               if (strlen($sValue) > 0) $sValue .= ', ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOMECHANIC');  
               else $sValue = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOMECHANIC'); 
            }
            if ($oFormWorkingPart->equipment_studio_electric) {
               if (strlen($sValue) > 0) $sValue .= ', ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOELECTRIC');  
               else $sValue = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOELECTRIC'); 
            }
            if ($oFormWorkingPart->equipment_studio_instrument) {
               if (strlen($sValue) > 0) $sValue .= ', ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOINSTRUMENT');  
               else $sValue = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_EQUIPMENTSTUDIOINSTRUMENT'); 
            }
            if ((!is_null($oFormWorkingPart->equipment_studio_others)) && (strlen($oFormWorkingPart->equipment_studio_others) > 0)) {
               if (strlen($sValue) > 0) $sValue .= ', ' . FString::castStrToCapitalLetters($oFormWorkingPart->equipment_studio_others);  
               else $sValue = FString::castStrToCapitalLetters($oFormWorkingPart->equipment_studio_others);    
            }
         }
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $sValue, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AC' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('system', 'SYS_HOUR') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, FDate::getTime($oFormWorkingPart->start_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // 3rd and 4rt Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_ZONE') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $oFormWorkingPart->zone . '/' . $oFormWorkingPart->region, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

         $oPHPExcelActiveSheet->mergeCells('O' . $nRow . ':' . 'AJ' . ($nRow + 1));
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 1), 'A', ($nRow + 1), 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'O', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         $oValue = new PHPExcel_RichText();
         $oValue->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_EQUIPMENTFAILUREREASON') . ': ')->getFont()->setBold(true);
         if ((!is_null($oFormWorkingPart->equipment_failure_reason)) && (strlen($oFormWorkingPart->equipment_failure_reason) > 0)) $oValue->createText(FString::castStrRemoveNewLines($oFormWorkingPart->equipment_failure_reason));
         FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, $oValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         $nRow++;
         
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_EQUIPMENT') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $oFormWorkingPart->equipment, PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
         $nRow++;
         
         if (!$bIsMaintenance) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'R' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_FIRSTRESPONSIBLE') . ':', null, null, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oFormWorkingPart->first_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   
         
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'Y' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('Z' . $nRow . ':' . 'AJ' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_SECONDRESPONSIBLE') . ':', null, null, null, null, true);
            if ((!is_null($oFormWorkingPart->second_responsible)) && (strlen($oFormWorkingPart->second_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'Z' . $nRow, $oFormWorkingPart->second_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
         
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'R' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_FOURTHRESPONSIBLE') . ':', null, null, null, null, true);
            if ((!is_null($oFormWorkingPart->fourth_responsible)) && (strlen($oFormWorkingPart->fourth_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oFormWorkingPart->fourth_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   
         
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'Y' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('Z' . $nRow . ':' . 'AJ' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_THIRDRESPONSIBLE') . ':', null, null, null, null, true);
            if ((!is_null($oFormWorkingPart->third_responsible)) && (strlen($oFormWorkingPart->third_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'Z' . $nRow, $oFormWorkingPart->third_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;   
         }
         
         if ($bIsMaintenance) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'R' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FIRSTRESPONSIBLE') . ':', null, null, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oFormWorkingPart->first_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   
         
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'Y' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('Z' . $nRow . ':' . 'AJ' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_SECONDRESPONSIBLE') . ':', null, null, null, null, true);
            if ((!is_null($oFormWorkingPart->second_responsible)) && (strlen($oFormWorkingPart->second_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'Z' . $nRow, $oFormWorkingPart->second_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow++;
         
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'R' . ($nRow + 1));
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_THIRDRESPONSIBLE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
            if ((!is_null($oFormWorkingPart->third_responsible)) && (strlen($oFormWorkingPart->third_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oFormWorkingPart->third_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
            
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'Y' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('Z' . $nRow . ':' . 'AJ' . ($nRow + 1));
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_AUXILIARS') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
            if (((!is_null($oFormWorkingPart->fourth_responsible)) && (strlen($oFormWorkingPart->fourth_responsible) > 0)) || ((!is_null($oFormWorkingPart->fifth_responsible)) && (strlen($oFormWorkingPart->fifth_responsible) > 0)) || ((!is_null($oFormWorkingPart->sixth_responsible)) && (strlen($oFormWorkingPart->sixth_responsible) > 0))) { 
               $sAuxiliars = FString::STRING_EMPTY;
               if ((!is_null($oFormWorkingPart->fourth_responsible)) && (strlen($oFormWorkingPart->fourth_responsible) > 0)) $sAuxiliars = $oFormWorkingPart->fourth_responsible;
               if ((!is_null($oFormWorkingPart->fifth_responsible)) && (strlen($oFormWorkingPart->fifth_responsible) > 0)) {
                  if (strlen($sAuxiliars) > 0) $sAuxiliars .= ', ' . $oFormWorkingPart->fifth_responsible;
                  else $sAuxiliars = $oFormWorkingPart->fifth_responsible;
               }
               if ((!is_null($oFormWorkingPart->sixth_responsible)) && (strlen($oFormWorkingPart->sixth_responsible) > 0)) {
                  if (strlen($sAuxiliars) > 0) $sAuxiliars .= ', ' . $oFormWorkingPart->sixth_responsible;
                  else $sAuxiliars = $oFormWorkingPart->sixth_responsible;
               }
                
               FReportExcel::setCellValue($oPHPExcel, 'Z' . $nRow, $sAuxiliars, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);   
            }
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow += 2; 
         }
         else {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 1));
         
            $oValueEmployees = new PHPExcel_RichText();
            $oValueEmployees->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_EMPLOYEES') . ': ')->getFont()->setBold(true);
            $oValueBusinesses = new PHPExcel_RichText();
            $oValueBusinesses->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_BUSINESSES') . ': ')->getFont()->setBold(true);
            $oFormWorkingPartEmployees = FormWorkingPartEmployees::getFormWorkingPartEmployeesByIdFormFK($oFormWorkingPart->id);
            $oBusinesses = array();
            for($j=0; $j < count($oFormWorkingPartEmployees); $j++) {
               $bBusinessOK = true;
               for($k=0; $k < count($oBusinesses); $k++) {
                  if ($oBusinesses[$k] == $oFormWorkingPartEmployees[$j]->business) $bBusinessOK = false;   
               }
               
               if ($j == (count($oFormWorkingPartEmployees) - 1)) {
                  $oValueEmployees->createText($oFormWorkingPartEmployees[$j]->name);
                  if ($bBusinessOK) {
                     $oValueBusinesses->createText($oFormWorkingPartEmployees[$j]->business);
                     $oBusinesses[count($oBusinesses)] = $oFormWorkingPartEmployees[$j]->business;
                  }   
               }  
               else {
                  $oValueEmployees->createText($oFormWorkingPartEmployees[$j]->name . ', ');
                  if ($bBusinessOK) { 
                     $oValueBusinesses->createText($oFormWorkingPartEmployees[$j]->business . ', ');
                     $oBusinesses[count($oBusinesses)] = $oFormWorkingPartEmployees[$j]->business;
                  }  
               } 
            }
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oValueEmployees, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, $oValueBusinesses, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'S', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            $nRow += 2;
         }
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . ($nRow + 1));
         $oValue = new PHPExcel_RichText();
         $oValue->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_METHODDESCRIPTION') . ': ')->getFont()->setBold(true);
         if ((!is_null($oFormWorkingPart->method_description)) && (strlen($oFormWorkingPart->method_description) > 0)) $oValue->createText(FString::castStrRemoveNewLines($oFormWorkingPart->method_code . ' - ' . $oFormWorkingPart->method_description));
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow += 2;
            
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_EQUIPMENTCONDITIONS') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight(24);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'Q' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('R' . $nRow . ':' . 'S' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('T' . $nRow . ':' . 'U' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('V' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_YES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NO'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'T' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NP'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'V' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_ALERTS_EQUIPMENTCONDITIONS') . ':', null, null, null, null, true);
         $nRow++;
         
         // Next Row 
         if ($bIsMaintenance) $oFormEquipmentConditions = FormMaintenanceWorkingPartEquipmentConditions::getFormMaintenanceWorkingPartEquipmentConditionsByIdFormFK($oFormWorkingPart->id);
         else $oFormEquipmentConditions = FormWorkingPartEquipmentConditions::getFormWorkingPartEquipmentConditionsByIdFormFK($oFormWorkingPart->id);   
         
         $l = 0;
         foreach($oFormEquipmentConditions as $oFormEquipmentCondition) {
            if (!$bChangeFontEquipmentConditions) $nStartRowEquipmentConditions = $nRow;
            
            $bChangeFontEquipmentConditions = true;
            
            $sDescription = FString::STRING_EMPTY;
            if ($oFormEquipmentCondition->custom) {
               if (strlen($oFormEquipmentCondition->custom_field) > 0) $sDescription = $oFormEquipmentCondition->custom_field;      
            }  
            else {
               $sDescription = $oFormEquipmentCondition->description;   
            } 
            
            if ($sDescription != FString::STRING_EMPTY) {
               $nRows = floor(strlen($sDescription) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1;
               $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
               
               $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
               $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setWrapText(true);
               
               FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sDescription, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               
               $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'Q' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('R' . $nRow . ':' . 'S' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('T' . $nRow . ':' . 'U' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('V' . $nRow . ':' . 'AJ' . $nRow);
               if (!is_null($oFormEquipmentCondition->value)) {
                  if ($oFormEquipmentCondition->value == 1) FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);      
                  else if ($oFormEquipmentCondition->value == 2) FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
                  else FReportExcel::setCellValue($oPHPExcel, 'T' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
               }
               else {
                  FReportExcel::setCellValue($oPHPExcel, 'T' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);         
               }
               
               $sInformationCapitalLetters = FString::STRING_EMPTY;
               if (strlen($oFormEquipmentCondition->information_field) > 0) {
                  $oInformationCapitalLetters = explode(FString::STRING_SPACE, $oFormEquipmentCondition->information);
                  foreach($oInformationCapitalLetters as $oInformationCapitalLetter) {
                     if (strlen($oInformationCapitalLetter) > 3) $sInformationCapitalLetters .= strtoupper($oInformationCapitalLetter[0]) . '.';   
                  }
               }
                
               if (((is_null($oFormEquipmentCondition->value)) && ($oFormEquipmentCondition->visible_alert_value_default)) || ((!is_null($oFormEquipmentCondition->value)) && ($oFormEquipmentCondition->value == 1) && ($oFormEquipmentCondition->visible_alert_value_yes)) || ((!is_null($oFormEquipmentCondition->value)) && ($oFormEquipmentCondition->value == 2) && ($oFormEquipmentCondition->visible_alert_value_no)) || ((!is_null($oFormEquipmentCondition->value)) && ($oFormEquipmentCondition->value == 3) && ($oFormEquipmentCondition->visible_alert_value_np))) {
                  if (strlen($oFormEquipmentCondition->information_field) > 0) $nRows = floor((strlen($oFormEquipmentCondition->alert) + 1 + strlen($sInformationCapitalLetters) + 2 + strlen($oFormEquipmentCondition->information_field)) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1; 
                  else $nRows = floor(strlen($oFormEquipmentCondition->alert) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1;
                  
                  $nRowHeight = $oPHPExcelActiveSheet->getRowDimension($nRow)->getRowHeight();
                  if ($nRowHeight < $nRows * 16) $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
                  
                  if (strlen($oFormEquipmentCondition->information_field) > 0) FReportExcel::setCellValue($oPHPExcel, 'V' . $nRow, $oFormEquipmentCondition->alert . ',' . $sInformationCapitalLetters . ': ' . $oFormEquipmentCondition->information_field, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_RED);                                   
                  else FReportExcel::setCellValue($oPHPExcel, 'V' . $nRow, $oFormEquipmentCondition->alert, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_RED);                                   
               }
               else if (strlen($oFormEquipmentCondition->information_field) > 0) {
                  FReportExcel::setCellValue($oPHPExcel, 'V' . $nRow, $sInformationCapitalLetters . ': ' . $oFormEquipmentCondition->information_field, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_RED);               
               }
               
               if (($l % 2) == 0) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':AJ' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E7E7E7')));  
               $nRow++; $l++;    
            }   
         }
         FReportExcel::setBorderByRange($oPHPExcel, $nRow - 1, 'A', $nRow - 1, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         
         // Next Row 
         $nEndRowEquipmentConditions = $nRow - 1;
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_MEASURES') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight(24);
         $nRow++;                  
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'Q' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('R' . $nRow . ':' . 'S' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('T' . $nRow . ':' . 'AF' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AG' . $nRow . ':' . 'AH' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AI' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_SUBHEADER_MEASURES') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AG' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORM' . $sMaintenance . 'WORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         $nRow++;
         
         // Next Row 
         if ($bIsMaintenance) $oFormMeasures = FormMaintenanceWorkingPartMeasures::getFormMaintenanceWorkingPartMeasuresByIdFormFK($oFormWorkingPart->id);
         else $oFormMeasures = FormWorkingPartMeasures::getFormWorkingPartMeasuresByIdFormFK($oFormWorkingPart->id);   
         $nStartRow = $nRow;
         
         $l = 0; $i = 0; $bChangeColumns = false;
         foreach($oFormMeasures as $oFormMeasure) {
            $sDescription = FString::STRING_EMPTY;
            if ($oFormMeasure->custom) {
               if (strlen($oFormMeasure->custom_field) > 0) $sDescription = $oFormMeasure->custom_field;      
            }  
            else {
               $sDescription = $oFormMeasure->description;   
            } 
            
            if ($sDescription != FString::STRING_EMPTY) {
               if (((!$bIsMaintenance) && ($i == (FModuleWorkingPartsManagement::MAX_MEASURES_WORKING_PARTS_SIMULTANEOUS / 2))) || (($bIsMaintenance) && ($i == (FModuleWorkingPartsManagement::MAX_MEASURES_MAINTENANCE_WORKING_PARTS_SIMULTANEOUS / 2)))) {
                  $l = 0;
                  $nRow = $nStartRow;
                  $bChangeColumns = true;
               }  
               
               if (!$bChangeFontMeasures) $nStartRowMeasures = $nRow;
               $nEndRowMeasures = $nRow;
               
               $bChangeFontMeasures = true;
                                
               $sFormMeasureMoreInformation = FString::STRING_EMPTY;              
               $sInformationCapitalLetters = FString::STRING_EMPTY;
               if (strlen($oFormMeasure->information_field) > 0) {
                  $oInformationCapitalLetters = explode(FString::STRING_SPACE, $oFormMeasure->information);
                  foreach($oInformationCapitalLetters as $oInformationCapitalLetter) {
                     if (strlen($oInformationCapitalLetter) > 3) $sInformationCapitalLetters .= strtoupper($oInformationCapitalLetter[0]) . '.';   
                  }
               }
                
               if (((is_null($oFormMeasure->value)) && ($oFormMeasure->visible_alert_value_default)) || ((!is_null($oFormMeasure->value)) && ($oFormMeasure->value == 1) && ($oFormMeasure->visible_alert_value_yes)) || ((!is_null($oFormMeasure->value)) && ($oFormMeasure->value == 2) && ($oFormMeasure->visible_alert_value_no)) || ((!is_null($oFormMeasure->value)) && ($oFormMeasure->value == 3) && ($oFormMeasure->visible_alert_value_np))) {
                  if (strlen($oFormMeasure->information_field) > 0) $sFormMeasureMoreInformation = FString::STRING_SPACE . $oFormMeasure->alert . ',' . $sInformationCapitalLetters . ': ' . $oFormMeasure->information_field;
                  else $sFormMeasureMoreInformation = FString::STRING_SPACE . $oFormMeasure->alert;                                   
               }
               else if (strlen($oFormMeasure->information_field) > 0) {
                  $sFormMeasureMoreInformation = FString::STRING_SPACE . $sInformationCapitalLetters . ': ' . $oFormMeasure->information_field;        
               }
               
               if (!$bChangeColumns) {
                  $nRows = floor(strlen($sDescription . $sFormMeasureMoreInformation) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1;
                  $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
                  
                  $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
                  $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setWrapText(true);
                  
                  FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sDescription . $sFormMeasureMoreInformation, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  
                  $oPHPExcelActiveSheet->mergeCells('P' . $nRow . ':' . 'Q' . $nRow);
                  $oPHPExcelActiveSheet->mergeCells('R' . $nRow . ':' . 'S' . $nRow);
                  if (!is_null($oFormMeasure->value)) {
                     if ($oFormMeasure->value == 1) FReportExcel::setCellValue($oPHPExcel, 'P' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);        
                     else FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
                  }
                  else {
                     FReportExcel::setCellValue($oPHPExcel, 'R' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);         
                  }
                  
                  if (($l % 2) == 0) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':AJ' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E7E7E7')));
               }
               else {
                  $nRows = floor(strlen($sDescription . $sFormMeasureMoreInformation) / (FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE - 5)) + 1;
                  $nRowHeight = $oPHPExcelActiveSheet->getRowDimension($nRow)->getRowHeight();
                  if ($nRowHeight < $nRows * 16) $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
                 
                  $oPHPExcelActiveSheet->mergeCells('T' . $nRow . ':' . 'AF' . $nRow);
                  $oPHPExcelActiveSheet->getStyle('T' . $nRow)->getAlignment()->setWrapText(true);
                  
                  FReportExcel::setCellValue($oPHPExcel, 'T' . $nRow, $sDescription . $sFormMeasureMoreInformation, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  
                  $oPHPExcelActiveSheet->mergeCells('AG' . $nRow . ':' . 'AH' . $nRow);
                  $oPHPExcelActiveSheet->mergeCells('AI' . $nRow . ':' . 'AJ' . $nRow);
                  if (!is_null($oFormMeasure->value)) {
                     if ($oFormMeasure->value == 1) FReportExcel::setCellValue($oPHPExcel, 'AG' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);        
                     else FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
                  }
                  else {
                     FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);         
                  }
                  
                  if (($l % 2) == 0) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':AJ' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E7E7E7')));
               }
            
               $nRow++; $l++; $i++;    
            }   
         }
         $nLastRow = $nRow;
         $nRow = $nStartRow; 
         
         if ($nLastRow > $nRow) $nRow = $nLastRow;
         FReportExcel::setBorderByRange($oPHPExcel, $nRow - 1, 'A', $nRow - 1, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_RISKS') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_IPES') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight(20);
         $nRow++;
         
         // Next Row
         $nRowRisksAndIPEs = $nRow;
         if ($bIsMaintenance) $oFormRisks = FormMaintenanceWorkingPartRisks::getFormMaintenanceWorkingPartRisksByIdFormFK($oFormWorkingPart->id);
         else $oFormRisks = FormWorkingPartRisks::getFormWorkingPartRisksByIdFormFK($oFormWorkingPart->id);   

         $sValue = FString::STRING_EMPTY;
         foreach($oFormRisks as $oFormRisk) {
            if (strlen($sValue) > 0) $sValue .= ', ' . $oFormRisk->name;
            else $sValue = $oFormRisk->name;   
         }
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 3));                     
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_RED, true);
         
         if ($bIsMaintenance) $oFormIPEs = FormMaintenanceWorkingPartIPEs::getFormMaintenanceWorkingPartIPEsByIdFormFK($oFormWorkingPart->id);
         else $oFormIPEs = FormWorkingPartIPEs::getFormWorkingPartIPEsByIdFormFK($oFormWorkingPart->id);   

         $sValue = FString::STRING_EMPTY;
         foreach($oFormIPEs as $oFormIPE) {
            if (strlen($sValue) > 0) $sValue .= ', ' . $oFormIPE->name;
            else $sValue = $oFormIPE->name;   
         }
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 3));                     
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, $sValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_DARKGREEN, true);
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'A', ($nRow + 3), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 3), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow += 4;
         
         // Next Row
         if ($bIsMaintenance) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'L' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'X' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AJ' . ($nRow + 1));
                                                                                                                                                                                                  
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_AUTHORIZING_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RECEIPT_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
            FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_AUXILIAR_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                                                                                                                             
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'L', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'M', ($nRow + 1), 'X', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'Y', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);

            $nRow += 2;
		   } else {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'L' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'X' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AJ' . ($nRow + 1));
			
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_AUTHORIZING_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
			   FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RECEIPT_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
			   FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RESPONSIBLE_EXECUTOR_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                                                                                                                             
			   FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'L', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
			   FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'M', ($nRow + 1), 'X', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
			   FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'Y', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);

			   $nRow += 2;
			
			   $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'L' . ($nRow + 1));
			   $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'AC' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
			   $oPHPExcelActiveSheet->mergeCells('AD' . ($nRow + 1) . ':' . 'AJ' . ($nRow + 1));
			         
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_PRL_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);                                                                                                                                                               
            FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RENEW_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
            FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, Yii::t('system', 'SYS_DATE') . ':', null, null, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'AD' . ($nRow + 1), Yii::t('system', 'SYS_HOUR') . ':', null, null, null, null, true);
			
			   FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'L', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
			   FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'M', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
			 
			   $nRow += 2;		
         }
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . ($nRow + 1));
         $oValue = new PHPExcel_RichText();
         $oValue->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMS' . $sMaintenance . 'WORKINGPARTS_FIELD_FAILUREREASON') . ': ')->getFont()->setBold(true);
         if ((!is_null($oFormWorkingPart->failure_reason)) && (strlen($oFormWorkingPart->failure_reason) > 0)) $oValue->createText(FString::castStrRemoveNewLines($oFormWorkingPart->failure_reason));
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow += 2;
         
         if (!$bIsMaintenance) {
            // Next Row
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . ($nRow + 2));
            $oValue = new PHPExcel_RichText();
            $oValue->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_FAILURESOLUTION') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_COMMENTS') . ': ')->getFont()->setBold(true);
            
            $sFailureSolution = FString::STRING_EMPTY;
            $sComments = FString::STRING_EMPTY;
            if ((!is_null($oFormWorkingPart->failure_solution)) && (strlen($oFormWorkingPart->failure_solution) > 0)) $sFailureSolution = $oFormWorkingPart->failure_solution;
            if ((!is_null($oFormWorkingPart->comments)) && (strlen($oFormWorkingPart->comments) > 0)) $sComments = $oFormWorkingPart->comments; 
            
            if ((strlen($sFailureSolution) > 0) && (strlen($sComments) > 0)) $sSeparator = '/';
            else $sSeparator = FString::STRING_EMPTY;
            
            $oValue->createText(FString::castStrRemoveNewLines($sFailureSolution . $sSeparator . $sComments));
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $oValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 2), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
            $nRow += 3;
         }
         
         // Next Row
         if ($bIsMaintenance) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_END_PROCESS'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, null, true);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         } else {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'U' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('V' . $nRow . ':' . 'Y' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('Z' . $nRow . ':' . 'AB' . $nRow);
            $oPHPExcelActiveSheet->mergeCells('AC' . $nRow . ':' . 'AJ' . $nRow);
            
            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_HEADER_END_PROCESS'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('system', 'SYS_DATE') . ':', null, null, null, null, true);
            FReportExcel::setCellValue($oPHPExcel, 'Z' . $nRow, Yii::t('system', 'SYS_HOUR') . ':', null, null, null, null, true);
            
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);  
         }
         $nRow++;
         
         // Next Row
		   if ($bIsMaintenance) {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 1));

            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_AUTHORIZING_CLOSE_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RECEIPT_CLOSE_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                          
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'S', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         }
         else {
            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 1));
            $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 1));

            FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_AUTHORIZING_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
            FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORM' . $sMaintenance . 'WORKINGPART_RESPONSIBLE_EXECUTOR_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                          
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
            FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'S', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         }
	      $nRow += 2;
			 
         // End report
         $oPHPExcelActiveSheet->getStyle('A1:AJ' . ($nRow - 1))->getFont()->setName(FModuleWorkingPartsManagement::REPORT_FONT_NAME);
         $oPHPExcelActiveSheet->getStyle('A4:AJ' . ($nRow - 1))->getFont()->setSize($nFontSize);
         $oPHPExcelActiveSheet->getStyle('A' . $nRowRisksAndIPEs . ':AJ' . ($nRowRisksAndIPEs + 3))->getFont()->setSize($nFontSize - 1);

         if ($bChangeFontEquipmentConditions) $oPHPExcelActiveSheet->getStyle('A' . $nStartRowEquipmentConditions . ':AJ' . $nEndRowEquipmentConditions)->getFont()->setSize($nFontSize - 1);
         if ($bChangeFontMeasures) $oPHPExcelActiveSheet->getStyle('A' . $nStartRowMeasures . ':AJ' . $nEndRowMeasures)->getFont()->setSize($nFontSize - 1);
           
         FReportExcel::setBorderByRange($oPHPExcel, 1, 'A', ($nRow - 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL_MEDIUM);
      }
        
      $oPHPExcel->setActiveSheetIndex(0);    
      return $oPHPExcel;   
   }
   private function reportExcelFormSpecialWorkingPart($sFilename, $oFormSpecialWorkingPart, $sDocFormat) {
      $oApplication = Application::getApplication();
      $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
      $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
      if ($bDocIsPDF) $nFontSize = 9;
      else $nFontSize = 10;

      $nSheet = 0;
      for($nSheet = 0; $nSheet < 2; $nSheet++) {
         $bChangeFontEquipmentConditionsMeasures = false;

         if ($nSheet == 0) $sSheetName = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_SHEET_ORIGINAL_NAME');
         else $sSheetName = Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_SHEET_COPY_NAME'); 
         
         FReportExcel::addSheet($oPHPExcel, $sSheetName);
         FReportExcel::setVerticalMargin($oPHPExcel, 0.25, 0.25);
         FReportExcel::setHorizontalMargin($oPHPExcel, 0.25, 0.25);
                   
         $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
         $nRow = 1;
         
         $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
         
         if ($bDocIsPDF) {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8.90);
            $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('U')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('V')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('W')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('X')->setWidth(8.90);
            $oPHPExcelActiveSheet->getColumnDimension('Y')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Z')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AA')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AB')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AC')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AD')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AE')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AF')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AG')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AH')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AI')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AJ')->setWidth(2.85);
         }
         else {
            $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8.90);
            $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('P')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('Q')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('R')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('S')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('T')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('U')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('V')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('W')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('X')->setWidth(8.90);
            $oPHPExcelActiveSheet->getColumnDimension('Y')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('Z')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AA')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AB')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AC')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AD')->setWidth(2.90);
            $oPHPExcelActiveSheet->getColumnDimension('AE')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AF')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AG')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AH')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AI')->setWidth(1.85);
            $oPHPExcelActiveSheet->getColumnDimension('AJ')->setWidth(2.85);
         }
         
         // Header
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 2), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         
         // --> Logo business
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . ($nRow + 2));

         $oImageDrawing = new PHPExcel_Worksheet_Drawing();
         $oImageDrawing->setWorksheet($oPHPExcelActiveSheet);
         if (!is_null($oApplication->business_logo)) $oImageDrawing->setPath(Application::getBusinessLogoImage());
         $oImageDrawing->setCoordinates('A' . $nRow);

         $oImageDrawing->setResizeProportional(false);
         $oImageDrawing->setHeight(50);
         $oImageDrawing->setWidth(60);
         $oImageDrawing->setOffsetX(15);
         $oImageDrawing->setOffsetY(7);
         
         // --> Title
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'AD' . ($nRow + 2));
         
         $sValue =  FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_TITLE'));
         FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $sValue, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, null, null, true);
         
         // --> Number
         $oPHPExcelActiveSheet->mergeCells('AE' . $nRow . ':' . 'AJ' . ($nRow + 2));
         FReportExcel::setCellValue($oPHPExcel, 'AE' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMWORKINGPART_NUMBER') . $oFormSpecialWorkingPart->id, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, 14, null, PHPExcel_Style_Color::COLOR_DARKRED);
         $nRow += 3;
         
         // 1st Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'X' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_BUSINESS') . ':', null, null, null, null, true);
         
         $oFormSpecialWorkingPartEmployees = FormSpecialWorkingPartEmployees::getFormSpecialWorkingPartEmployeesByIdFormFK($oFormSpecialWorkingPart->id);
         $oBusinesses = array();
         $sBusinesses = FString::STRING_EMPTY;
         for($j=0; $j < count($oFormSpecialWorkingPartEmployees); $j++) {
            $bBusinessOK = true;
            for($k=0; $k < count($oBusinesses); $k++) {
               if ($oBusinesses[$k] == $oFormSpecialWorkingPartEmployees[$j]->business) $bBusinessOK = false;   
            }
            
            if ($bBusinessOK) {
               if (strlen($sBusinesses) > 0) $sBusinesses .= ', ' . $oFormSpecialWorkingPartEmployees[$j]->business;
               else $sBusinesses = $oFormSpecialWorkingPartEmployees[$j]->business; 
               
               $oBusinesses[count($oBusinesses)] = $oFormSpecialWorkingPartEmployees[$j]->business;
            }
         }
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, $sBusinesses, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AC' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('system', 'SYS_DATE') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, FDate::getTimeZoneFormattedDate($oFormSpecialWorkingPart->start_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // 2nd Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'E' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'X' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_INSTALLATION') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'F' . $nRow, FString::castStrRemoveNewLines($oFormSpecialWorkingPart->installation), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('Y' . $nRow . ':' . 'AC' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'Y' . $nRow, Yii::t('system', 'SYS_HOUR') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, FDate::getTime($oFormSpecialWorkingPart->start_date), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // 3rd and 4rt Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_FIRSTRESPONSIBLE') . ':', null, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $oFormSpecialWorkingPart->first_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

         $oPHPExcelActiveSheet->mergeCells('O' . $nRow . ':' . 'AJ' . ($nRow + 1));
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 1), 'A', ($nRow + 1), 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'O', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         $oValue = new PHPExcel_RichText();
         $oValue->createTextRun(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORKDESCRIPTION') . ': ')->getFont()->setBold(true);
         $oValue->createText($oFormSpecialWorkingPart->work_description);
         FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, $oValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         $nRow++;
         
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'F' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('G' . $nRow . ':' . 'N' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK') . ':', null, null, null, null, true);
         if (strtoupper($oFormSpecialWorkingPart->work) == strtoupper(FString::STRING_OTHERS)) FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, $oFormSpecialWorkingPart->work_others, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         else FReportExcel::setCellValue($oPHPExcel, 'G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_' . $oFormSpecialWorkingPart->work), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_THIRDRESPONSIBLE') . ':', null, null, null, null, true);
         if ((!is_null($oFormSpecialWorkingPart->third_responsible)) && (strlen($oFormSpecialWorkingPart->third_responsible) > 0)) FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, $oFormSpecialWorkingPart->third_responsible, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   
      
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
            
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'J' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_METHODDESCRIPTION') . ':', null, null, null, null, true);
         if ((!is_null($oFormSpecialWorkingPart->method_description)) && (strlen($oFormSpecialWorkingPart->method_description) > 0)) FReportExcel::setCellValue($oPHPExcel, 'K' . $nRow, FString::castStrRemoveNewLines($oFormSpecialWorkingPart->method_code . ' - ' . $oFormSpecialWorkingPart->method_description), PHPExcel_Style_Alignment::HORIZONTAL_LEFT, null, null, 7);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_EQUIPMENTCONDITIONS') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_MEASURES') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight(24);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'L' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('O' . $nRow . ':' . 'P' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('Q' . $nRow . ':' . 'R' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AD' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AE' . $nRow . ':' . 'AF' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AG' . $nRow . ':' . 'AH' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AI' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_YES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NO'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'Q' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTEQUIPMENTCONDITIONS_FIELD_VALUE_VALUE_NP'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AE' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_YES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AG' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NO'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSPECIALWORKINGPARTMEASURES_FIELD_VALUE_VALUE_NP'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         $nRow++;
         
         // Next Row
         $oFormEquipmentConditions = FormSpecialWorkingPartEquipmentConditions::getFormSpecialWorkingPartEquipmentConditionsByIdFormFK($oFormSpecialWorkingPart->id);   
         $nStartRow = $nRow;
         
         $l = 0;
         foreach($oFormEquipmentConditions as $oFormEquipmentCondition) {
            $sDescription = FString::STRING_EMPTY;
            if ($oFormEquipmentCondition->custom) {
               if (strlen($oFormEquipmentCondition->custom_field) > 0) $sDescription = $oFormEquipmentCondition->custom_field;      
            }  
            else {
               $sDescription = $oFormEquipmentCondition->description;   
            } 
            
            if ($sDescription != FString::STRING_EMPTY) {
               if (!$bChangeFontEquipmentConditionsMeasures) $nStartRowEquipmentConditionsMeasures = $nRow;
               $nEndRowEquipmentConditionsMeasures = $nRow;
               
               $bChangeFontEquipmentConditionsMeasures = true;
            
               $nRows = floor(strlen($sDescription) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1;
               $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
               
               $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'L' . $nRow);
               $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setWrapText(true);
               
               FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sDescription, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP);
               
               $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'N' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('O' . $nRow . ':' . 'P' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('Q' . $nRow . ':' . 'R' . $nRow);
               if (!is_null($oFormEquipmentCondition->value)) {
                  if ($oFormEquipmentCondition->value == 1) FReportExcel::setCellValue($oPHPExcel, 'M' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);        
                  else if ($oFormEquipmentCondition->value == 2) FReportExcel::setCellValue($oPHPExcel, 'O' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);
                  else FReportExcel::setCellValue($oPHPExcel, 'Q' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
               }
               else {
                  FReportExcel::setCellValue($oPHPExcel, 'Q' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);         
               }
               
               if (($l % 2) == 0) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':AJ' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E7E7E7')));
               $nRow++; $l++;    
            }   
         }
         $nLastRow = $nRow;
         $nRow = $nStartRow;
         
         $oFormMeasures = FormSpecialWorkingPartMeasures::getFormSpecialWorkingPartMeasuresByIdFormFK($oFormSpecialWorkingPart->id);   
         
         $l = 0;
         foreach($oFormMeasures as $oFormMeasure) {
            if (!$bChangeFontEquipmentConditionsMeasures) { $nStartRowEquipmentConditionsMeasures = $nRow; $nEndRowEquipmentConditionsMeasures = $nRow; }
            else if ($nEndRowEquipmentConditionsMeasures < $nRow) $nEndRowEquipmentConditionsMeasures = $nRow;
            
            $bChangeFontEquipmentConditionsMeasures = true;
            
            $sDescription = FString::STRING_EMPTY;
            if ($oFormMeasure->custom) {
               if (strlen($oFormMeasure->custom_field) > 0) $sDescription = $oFormMeasure->custom_field;      
            }  
            else {
               $sDescription = $oFormMeasure->description;   
            } 
            
            $sInformationCapitalLetters = FString::STRING_EMPTY;
            if (strlen($oFormMeasure->information_field) > 0) {
               $oInformationCapitalLetters = explode(FString::STRING_SPACE, $oFormMeasure->information);
               foreach($oInformationCapitalLetters as $oInformationCapitalLetter) {
                  if (strlen($oInformationCapitalLetter) > 3) $sInformationCapitalLetters .= strtoupper($oInformationCapitalLetter[0]) . '.';   
               }
            }
            
            if (strlen($oFormMeasure->information_field) > 0) {
               $sDescription .= FString::STRING_SPACE . $sInformationCapitalLetters . ': ' . $oFormMeasure->information_field; 
            }
 
            if ($sDescription != FString::STRING_EMPTY) {
               $nRows = floor(strlen($sDescription) / FModuleWorkingPartsManagement::REPORT_MAX_CHARS_TO_NEW_LINE) + 1;
               $nRowHeight = $oPHPExcelActiveSheet->getRowDimension($nRow)->getRowHeight();
               if ($nRowHeight < $nRows * 16) $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight($nRows * 16);
               
               $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AD' . $nRow);
               $oPHPExcelActiveSheet->getStyle('S' . $nRow)->getAlignment()->setWrapText(true);
               
               FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, $sDescription, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::VERTICAL_TOP, null);
               
               $oPHPExcelActiveSheet->mergeCells('AE' . $nRow . ':' . 'AF' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('AG' . $nRow . ':' . 'AH' . $nRow);
               $oPHPExcelActiveSheet->mergeCells('AI' . $nRow . ':' . 'AJ' . $nRow);
               if (!is_null($oFormMeasure->value)) {
                  if ($oFormMeasure->value == 1) FReportExcel::setCellValue($oPHPExcel, 'AE' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);        
                  else if ($oFormMeasure->value == 2) FReportExcel::setCellValue($oPHPExcel, 'AG' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);   
                  else FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);    
               }
               else {
                  FReportExcel::setCellValue($oPHPExcel, 'AI' . $nRow, 'X', PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_TOP);         
               }
               
               if (($l % 2) == 0) $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':AJ' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'E7E7E7')));
               $nRow++; $l++;    
            }   
         }
         
         if ($nLastRow > $nRow) $nRow = $nLastRow;
         FReportExcel::setBorderByRange($oPHPExcel, $nStartRow - 2, 'A', $nRow - 1, 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nStartRow - 2, 'S', $nRow - 1, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
      
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . $nRow);  
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_MEANS') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_IPES') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true);
         $oPHPExcelActiveSheet->getRowDimension($nRow)->setRowHeight(20);
         $nRow++;
         
         $nRowMeansAndIPEs = $nRow;
         
         // Next Row
         $oFormPreventionMeans = FormSpecialWorkingPartPreventionMeans::getFormSpecialWorkingPartPreventionMeansByIdFormFK($oFormSpecialWorkingPart->id);   
         $sValue = FString::STRING_EMPTY;
         foreach($oFormPreventionMeans as $oFormPreventionMean) {
            if (strlen($sValue) > 0) $sValue .= ', ' . $oFormPreventionMean->name;
            else $sValue = $oFormPreventionMean->name;   
         }
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 3));                     
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_DARKGREEN, true);
         
         $oFormIPEs = FormSpecialWorkingPartIPEs::getFormSpecialWorkingPartIPEsByIdFormFK($oFormSpecialWorkingPart->id);   
         $sValue = FString::STRING_EMPTY;
         foreach($oFormIPEs as $oFormIPE) {
            if (strlen($sValue) > 0) $sValue .= ', ' . $oFormIPE->name;
            else $sValue = $oFormIPE->name;   
         }
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 3));                     
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, $sValue, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, PHPExcel_Style_Color::COLOR_DARKGREEN, true);
         
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'A', ($nRow + 3), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 3), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow += 4;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_SUPPLEMENTINSTRUCTIONS') . ':', null, null, null, null, true);
         $nRowSupplementInstructions = $nRow;
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow. ':' . 'AJ' . ($nRow + 2));
         if ((!is_null($oFormSpecialWorkingPart->supplement_instructions)) && (strlen($oFormSpecialWorkingPart->supplement_instructions) > 0)) FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, FString::castStrRemoveNewLines($oFormSpecialWorkingPart->supplement_instructions), null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 2), 'A', ($nRow + 2), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow += 3;

         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_SUBHEADER_EMPLOYEES'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, null, null, null, true);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_SUBHEADER_EMPLOYEES_INFORMATION'));
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow. ':' . 'AJ' . ($nRow + 5));
         FReportExcel::setBorderByRange($oPHPExcel, ($nRow + 5), 'A', ($nRow + 5), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         
         $oFormSpecialWorkingPartEmployees = FormSpecialWorkingPartEmployees::getFormSpecialWorkingPartEmployeesByIdFormFK($oFormSpecialWorkingPart->id);
         $sValueEmployees = FString::STRING_EMPTY;
         for($j=0; $j < count($oFormSpecialWorkingPartEmployees); $j++) {
            if (strlen($sValueEmployees) > 0) $sValueEmployees .= ', ' . $oFormSpecialWorkingPartEmployees[$j]->name . ' (' . $oFormSpecialWorkingPartEmployees[$j]->business . ')';
            else $sValueEmployees = $oFormSpecialWorkingPartEmployees[$j]->name . ' (' . $oFormSpecialWorkingPartEmployees[$j]->business . ')'; 
         }
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, $sValueEmployees, null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, null, null, true);
         $nRow += 6;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . ($nRow + 1));
         $oPHPExcelActiveSheet->mergeCells('H' . $nRow . ':' . 'R' . ($nRow + 1));
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'Z' . ($nRow + 1));
         $oPHPExcelActiveSheet->mergeCells('AA' . $nRow . ':' . 'AJ' . ($nRow + 1));
      
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_AUTHORIZING_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
         FReportExcel::setCellValue($oPHPExcel, 'H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_RESPONSIBLE_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_RESPONSIBLE_EXECUTOR_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
         FReportExcel::setCellValue($oPHPExcel, 'AA' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_PRL_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                                                                                                                                                 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'G', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'H', ($nRow + 1), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'S', ($nRow + 1), 'Z', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'AA', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         $nRow += 2;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow. ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_EMERGENCY_PHONE'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, null, true, PHPExcel_Style_Color::COLOR_RED);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_END_PROCESS_BOSS'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, null, true);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;

         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'H' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'R' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_END_DATE') . ':', null, null, null, null, true);
         if ((!is_null($oFormSpecialWorkingPart->end_date)) && (strlen($oFormSpecialWorkingPart->end_date) > 0)) FReportExcel::setCellValue($oPHPExcel, 'I' . $nRow, FDate::getTimeZoneFormattedDate($oFormSpecialWorkingPart->end_date, true), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AC' . $nRow);
         $oPHPExcelActiveSheet->mergeCells('AD' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_PERMISSIONRENOVATION') . ':', null, null, null, null, true);
         if ($oFormSpecialWorkingPart->permission_renovation) FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, Yii::t('system', 'SYS_YES'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         else FReportExcel::setCellValue($oPHPExcel, 'AD' . $nRow, Yii::t('system', 'SYS_NO'), PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
 
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_HEADER_END_PROCESS'), PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, null, null, true);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
         $nRow++;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'R' . ($nRow + 1));
         $oPHPExcelActiveSheet->mergeCells('S' . $nRow . ':' . 'AJ' . ($nRow + 1));
      
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_AUTHORIZING_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
         FReportExcel::setCellValue($oPHPExcel, 'S' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_RESPONSIBLE_EXECUTOR_SIGNATURE') . ':', null, PHPExcel_Style_Alignment::VERTICAL_TOP, null, null, true, PHPExcel_Style_Color::COLOR_DARKRED);
                                                                                                                                                                                 
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'R', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'S', ($nRow + 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL);
         $nRow += 2;
         
         // Next Row
         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'AJ' . $nRow);
         FReportExcel::setCellValue($oPHPExcel, 'A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'REPORT_FORMSPECIALWORKINGPART_FOOTER'));
         $nRow++;

         // End report
         $oPHPExcelActiveSheet->getStyle('A1:AJ' . ($nRow - 1))->getFont()->setName(FModuleWorkingPartsManagement::REPORT_FONT_NAME);
         $oPHPExcelActiveSheet->getStyle('A4:AJ' . ($nRow - 1))->getFont()->setSize($nFontSize);
         if ($bChangeFontEquipmentConditionsMeasures) $oPHPExcelActiveSheet->getStyle('A' . $nStartRowEquipmentConditionsMeasures . ':AJ' . $nEndRowEquipmentConditionsMeasures)->getFont()->setSize($nFontSize - 1);
         $oPHPExcelActiveSheet->getStyle('A' . $nRowSupplementInstructions . ':AJ' . $nRowSupplementInstructions)->getFont()->setSize($nFontSize - 2);
         $oPHPExcelActiveSheet->getStyle('A' . ($nRow - 1) . ':AJ' . ($nRow - 1))->getFont()->setSize($nFontSize - 3);
         
         $oPHPExcelActiveSheet->getStyle('A' . $nRowMeansAndIPEs . ':AJ' . ($nRowMeansAndIPEs + 3))->getFont()->setSize($nFontSize - 1);
         
         $oPHPExcelActiveSheet->getStyle('G9:AJ9')->getFont()->setSize($nFontSize - 3);
         
         FReportExcel::setBorderByRange($oPHPExcel, 1, 'A', ($nRow - 1), 'AJ', true, FReportExcel::BORDER_STYLE_SOLID_ALL_MEDIUM);
      }
  
      $oPHPExcel->setActiveSheetIndex(0);
      return $oPHPExcel;
   }
}