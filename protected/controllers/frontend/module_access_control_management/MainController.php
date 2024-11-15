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
                'actions'=>array('viewCheckinChronograms', 'viewSynchronize'),
                'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewCheckinChronograms() {
       $oAccessControlCheckInChronogramForm = new AccessControlCheckInChronogramForm();
       $oArray['EMPLOYEES_LIST'] = array(); 

       if (isset($_POST['AccessControlCheckInChronogramForm'])) {
          $oAccessControlCheckInChronogramForm->attributes = $_POST['AccessControlCheckInChronogramForm'];
          
          if ($oAccessControlCheckInChronogramForm->validate()) {
             if ($_POST['AccessControlCheckInChronogramForm']['allEmployees'] == false) {
                $oArray['EMPLOYEES_LIST'][count($oArray['EMPLOYEES_LIST'])] = $this->compareCheckinChronogram($_POST['AccessControlCheckInChronogramForm']['employee'], FDate::getEnglishDate($_POST['AccessControlCheckInChronogramForm']['startDate']), FDate::getEnglishDate($_POST['AccessControlCheckInChronogramForm']['endDate']), $_POST['AccessControlCheckInChronogramForm']['sourceData']);
             }
             else {
                $oEmployees = Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT));
                foreach ($oEmployees as $oEmployee) {
                   $oArray['EMPLOYEES_LIST'][count($oArray['EMPLOYEES_LIST'])] = $this->compareCheckinChronogram($oEmployee->identification, FDate::getEnglishDate($_POST['AccessControlCheckInChronogramForm']['startDate']), FDate::getEnglishDate($_POST['AccessControlCheckInChronogramForm']['endDate']), $_POST['AccessControlCheckInChronogramForm']['sourceData']);
                }
             }

             $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_NAME');
             $oPHPExcel = $this->reportExcelCheckinChronogram($sFilename, $oArray, $_POST['AccessControlCheckInChronogramForm']['startDate'], $_POST['AccessControlCheckInChronogramForm']['endDate'], $_POST['AccessControlCheckInChronogramForm']['docDetailInformation'], $_POST['AccessControlCheckInChronogramForm']['docFormat']);
           
             $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['AccessControlCheckInChronogramForm']['docFormat']));            
          }
       }
       
       $this->render('viewCheckinChronograms', array('oModelForm'=>$oAccessControlCheckInChronogramForm));
    }
    public function actionViewSynchronize() {
       $this->updateCheckinDatabase();
       
       $this->renderPartial('viewSynchronize');   
    }

    
    private function reportExcelCheckinChronogram($sFilename, $oArrayReport, $sStartDate, $sEndDate, $sDocDetailInformation, $sDocFormat) { 
       $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
       
       foreach ($oArrayReport['EMPLOYEES_LIST'] as $oArrayEmployee) {
          $this->reportExcelCheckinChronogramByEmployee($oPHPExcel, $oArrayEmployee, $sStartDate, $sEndDate, $sDocDetailInformation, $sDocFormat);
       }
       
       $oPHPExcel->setActiveSheetIndex(0);
       return $oPHPExcel;               
    } 
    private function reportExcelCheckinChronogramByEmployee($oPHPExcel, $oArrayEmployee, $sStartDate, $sEndDate, $sDocDetailInformation, $sDocFormat) {
       FReportExcel::addSheet($oPHPExcel, $oArrayEmployee['EMPLOYEE.NAME']);
       $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
       if ($bDocIsPDF) $nFontSize = 8;
       else $nFontSize = 10;
      
       $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
       $nRow = 1;
       
       $oPHPExcelActiveSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

       FReportExcel::setHorizontalMargin($oPHPExcel, 1, 1);
       $oPHPExcelActiveSheet->getStyle('A:O')->getFont()->setSize($nFontSize);
       $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
       
       // Header colors
       if ($sDocDetailInformation != FApplication::DETAIL_INFORMATION_SUMMARY) {
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B');
          $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'I' . $nRow);
          $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_HOLIDAY_PAUSE)));
          $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE')); 
          $nRow++;
           
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B');
          $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'I' . $nRow);
          $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_ABSENCE)));
          $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION') . '/' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE'));
          $nRow++;
          
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'B');
          $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'I' . $nRow);
          $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_WORKING)));
          $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING'));
       }
       
       // Header employee
       $nRow = 1;
       $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_TOP_HEADER_EMPLOYEE') . ':');
       $oPHPExcelActiveSheet->getStyle('K' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'O' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, FString::STRING_SPACE . $oArrayEmployee['EMPLOYEE.NAME']);
       $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $nRow++;
       
       $oEmployee = Employees::getEmployeeByIdentification($oArrayEmployee['EMPLOYEE.NIF']);
       $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_TOP_HEADER_NUM_EMPLOYEE') . ':');
       $oPHPExcelActiveSheet->getStyle('K' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'O' . $nRow);
       if (!is_null($oEmployee)) {
          $sEmployeeInformation = FString::STRING_EMPTY;
          if (!is_null($oEmployee->num_employee)) { 
             $sEmployeeInformation = $oEmployee->num_employee;
             if (!is_null($oEmployee->access_information)) $sEmployeeInformation .= ' (' . $oEmployee->access_information . ')';
          }
           
          $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, FString::STRING_SPACE . $sEmployeeInformation);
          $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       }
       $nRow++;
       
       /*$oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_TOP_HEADER_DEPARTMENT') . ':');
       $oPHPExcelActiveSheet->getStyle('K' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'O' . $nRow);
       if (!is_null($oEmployee)) {
          $sDepartment = FString::STRING_EMPTY;
          $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
          if (count($oEmployeeDepartments) > 0) {
             if (strlen($oEmployeeDepartments[0]->responsability) > 0) $sDepartment = Yii::t('rainbow', 'MODEL_TYPE_RESPONSABILITY_FIELD_NAME_VALUE_' . $oEmployeeDepartments[0]->responsability) . FString::STRING_SPACE . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartments[0]->department);   
             else $sDepartment = Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartments[0]->department);    
          }
          
          $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, FString::STRING_SPACE . $sDepartment);
          $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
       }
       $nRow++;*/
       
       $oPHPExcelActiveSheet->mergeCells('K' . $nRow . ':' . 'L' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_TOP_HEADER_DATES') . ':');
       $oPHPExcelActiveSheet->getStyle('K' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       $oPHPExcelActiveSheet->mergeCells('M' . $nRow . ':' . 'O' . $nRow);
       
       $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, FString::STRING_SPACE . $sStartDate . ' - ' . $sEndDate);
       $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
       $nRow += 3;
       
       if ($sDocDetailInformation != FApplication::DETAIL_INFORMATION_SUMMARY) {
          // Legend
          $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
          $oPHPExcelActiveSheet->mergeCells('A' . ($nRow + 1) . ':' . 'O' . ($nRow + 1));
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', ($nRow + 1), 'O', true);
          
          $sTI = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HINCIDENCE') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HINCIDENCE_DETAIL');
          $sTD = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HDTOTAL') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HDTOTAL_DETAIL');
          $sTN = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HNTOTAL') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HNTOTAL_DETAIL');
          $sTDF = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHDTOTAL') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHDTOTAL_DETAIL');
          $sTNF = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHNTOTAL') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHNTOTAL_DETAIL');
          $sTT = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HTOTAL') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HTOTAL_DETAIL');
          $sTR = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMLATE') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMLATE_DETAIL');
          $sTH = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAM') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAM_DETAIL');
          $sTE = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMEXTRA') . ' = ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMEXTRA_DETAIL');
          
          $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $sTI . FString::STRING_TAB5 . $sTD . FString::STRING_TAB5 . $sTN . FString::STRING_TAB5 . $sTDF . FString::STRING_TAB5 . $sTNF);
          $nRow++;
          $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $sTT . FString::STRING_TAB5 . $sTR . FString::STRING_TAB5 . $sTH . FString::STRING_TAB5 . $sTE);
          
          $nRow += 2;
          
          // Header day
          $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
          
          $oPHPExcelActiveSheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $oPHPExcelActiveSheet->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          
          $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_DATE'));
          $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_INPUT'));
          $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_OUTPUT'));
          $oPHPExcelActiveSheet->SetCellValue('E' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_INCIDENCE'));
          $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HINCIDENCE'));
          $oPHPExcelActiveSheet->SetCellValue('G' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HDTOTAL'));
          $oPHPExcelActiveSheet->SetCellValue('H' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HNTOTAL'));
          $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHDTOTAL'));
          $oPHPExcelActiveSheet->SetCellValue('J' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHNTOTAL'));
          $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HTOTAL'));
          $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMLATE'));
          $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAM'));
          $oPHPExcelActiveSheet->SetCellValue('N' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HCRONOGRAMEXTRA'));
          $oPHPExcelActiveSheet->SetCellValue('O' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_OBSERVATIONS'));
       }
       
       if ($bDocIsPDF) {
          $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(14.5); 
          $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(12);
          $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9);
          $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(8);
          $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(26);
       }
       else {
          $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(13.5); 
          $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(11);
          $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(9);
          $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('H')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('I')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('J')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('K')->setWidth(7.5);
          $oPHPExcelActiveSheet->getColumnDimension('L')->setWidth(7.5);
          $oPHPExcelActiveSheet->getColumnDimension('M')->setWidth(7.5);
          $oPHPExcelActiveSheet->getColumnDimension('N')->setWidth(6.8);
          $oPHPExcelActiveSheet->getColumnDimension('O')->setWidth(19);   
       } 
       
       $oPHPExcelActiveSheet->getStyle('E')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
       $oPHPExcelActiveSheet->getStyle('F')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
       $oPHPExcelActiveSheet->getStyle('O')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
       
       if ($sDocDetailInformation != FApplication::DETAIL_INFORMATION_SUMMARY) FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'O', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
       
       if ($sDocDetailInformation != FApplication::DETAIL_INFORMATION_SUMMARY) {            
          $nRow += 2;
          foreach($oArrayEmployee['DAYS_LIST'] as $oDay) {
             $nStartRow = $nRow;
             $nEndRow = $nRow; 
             $sRowColor = null;
             
             $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
              
             $sCurrentDate = ucwords(FDate::getDayName($oDay['DATE'], true, true)) . ', ' . FDate::getTimeZoneFormattedDate($oDay['DATE']);
             $bAbsence = $oDay['ABSENCE'];
             $bHolidayPause = (($oDay['HOLIDAY']) || (stristr($oDay['WORKING_PAUSE'], Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE')) !== FALSE)); 
             
             if ($oDay['HOLIDAY']) $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $sCurrentDate . ' (' . Yii::t('system', 'SYS_DAY') . FString::STRING_SPACE . $oDay['HOLIDAY.DESCRIPTION'] . ')');
             else $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $sCurrentDate); 
             $nEndRow = $nRow;
             $nRow++;
             
             if ($sDocDetailInformation == FApplication::DETAIL_INFORMATION_VERY_DETAILED) {
                if ($oDay['ABSENCE']) { 
                   $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
                   $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $oDay['ABSENCE.DESCRIPTION']); 
                   $nEndRow = $nRow; 
                   $nRow++;
                } 
                
                if (strlen($oDay['WORKING_PAUSE']) > 0) { 
                   if (stristr($oDay['WORKING_PAUSE'], Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE')) !== FALSE) {
                      $oExplode = explode(FString::getNewLine(), $oDay['WORKING_PAUSE']);
                      
                      if (count($oExplode) > 1) {
                         $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
                         $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $oExplode[1]);
                         $nRow++;
                         
                         $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_TIMETABLE') . ' (' . $oDay['THEORIC_HOURS'] . '): ');
                         $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, $oExplode[0]);
                         
                         $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);      
                         $nEndRow = $nRow;
                      }
                      else {
                         if (count($oExplode) > 0) {
                            $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
                            $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, $oExplode[0]);

                            $nEndRow = $nRow;
                         }
                      }   
                   }
                   else {
                      $nHoraryCount = substr_count($oDay['WORKING_PAUSE'], FString::getNewLine()) - 1;
                      $oPHPExcelActiveSheet->mergeCells('B' . $nRow . ':' . 'B' . ($nRow + $nHoraryCount));
       
                      $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_TIMETABLE') . ' (' . $oDay['THEORIC_HOURS'] . '): ');
                      $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, $oDay['WORKING_PAUSE']);
                      
                      $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                      $oPHPExcelActiveSheet->getStyle('B' . $nRow)->getAlignment()->setWrapText(true);
                      $nEndRow = ($nRow + $nHoraryCount);   
                   }
                } 
             }
              
             if ($bHolidayPause) $sRowColor = FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_HOLIDAY_PAUSE; 
             else if ($bAbsence) $sRowColor = FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_ABSENCE;
             else $sRowColor = FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_COLOR_WORKING;
             
             if (count($oDay['CHECKIN_LIST']) > 0) $nRow = $nStartRow;
             if ($sDocDetailInformation == FApplication::DETAIL_INFORMATION_VERY_DETAILED) {
                foreach($oDay['CHECKIN_LIST'] as $oCheckin) {
                   if ($oCheckin['I/O'] == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT) {
                      if ($oCheckin['TIME'] != FString::STRING_EMPTY) {
                         if ($oCheckin['SHOW']) $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, $oCheckin['TIME']);
                         else $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_PREVIOUS_DAY);
                      }
                      else $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_NOT_CHECKIN);
                      
                      if ($oCheckin['H.TOTAL.INCIDENCE'] != '0h 0m') {
                         $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, $oCheckin['H.TOTAL.INCIDENCE']);
                         $oPHPExcelActiveSheet->getStyle('C' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                      }  
                   }
                   else {
                      if ($oCheckin['TIME'] != FString::STRING_EMPTY) {
                         if ($oCheckin['SHOW']) $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, $oCheckin['TIME']);
                         else $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_NEXT_DAY);
                      }
                      else $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, FModuleAccessControlManagement::REPORT_CHECKINCHRONOGRAM_NOT_CHECKIN);
                    
                      if ($oCheckin['INCIDENCE']) {
                         $oPHPExcelActiveSheet->getStyle('D' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                         $oPHPExcelActiveSheet->SetCellValue('E' . $nRow, $oCheckin['TYPE.INCIDENCE']); 
                         $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, $oCheckin['H.TOTAL.INCIDENCE']);  
                      }
                      
                      $oPHPExcelActiveSheet->SetCellValue('G' . $nRow, $oCheckin['H.D.TOTAL']);
                      $oPHPExcelActiveSheet->SetCellValue('H' . $nRow, $oCheckin['H.N.TOTAL']);
                      $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, $oCheckin['H.H.D.TOTAL']);
                      $oPHPExcelActiveSheet->SetCellValue('J' . $nRow, $oCheckin['H.H.N.TOTAL']);
                      $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, $oCheckin['H.TOTAL']);
                      $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, $oCheckin['H.CRONOGRAM.LATE']);
                      $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, $oCheckin['H.CRONOGRAM']);
                      $oPHPExcelActiveSheet->SetCellValue('N' . $nRow, $oCheckin['H.CRONOGRAM.EXTRA']);
                      $oPHPExcelActiveSheet->SetCellValue('O' . $nRow, $oCheckin['INFORMATION']);
                      
                      if ($oCheckin['H.CRONOGRAM.LATE'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                      if ($oCheckin['H.CRONOGRAM'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);
                      if ($oCheckin['H.CRONOGRAM.EXTRA'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('N' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKYELLOW);
                      
                      $nRow++;   
                   }
                }
             }
             
             // End Day
             if (count($oDay['CHECKIN_LIST']) > 0) {
                if ($sDocDetailInformation == FApplication::DETAIL_INFORMATION_VERY_DETAILED) FReportExcel::setBorderByRange($oPHPExcel, ($nRow - 1), 'F', ($nRow - 1), 'N', true, FReportExcel::BORDER_STYLE_SOLID_BOTTOM);
                
                $oPHPExcelActiveSheet->SetCellValue('E' . $nRow, Yii::t('system', 'SYS_TOTAL'));
                $oPHPExcelActiveSheet->getStyle('E' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
                
                if ($oDay['H.TOTAL.INCIDENCE'] != '0h 0m') $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, $oDay['H.TOTAL.INCIDENCE']);
                $oPHPExcelActiveSheet->SetCellValue('G' . $nRow, $oDay['H.D.TOTAL']);
                $oPHPExcelActiveSheet->SetCellValue('H' . $nRow, $oDay['H.N.TOTAL']);
                $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, $oDay['H.H.D.TOTAL']);
                $oPHPExcelActiveSheet->SetCellValue('J' . $nRow, $oDay['H.H.N.TOTAL']);
                $oPHPExcelActiveSheet->SetCellValue('K' . $nRow, $oDay['H.TOTAL']);
                $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, $oDay['H.CRONOGRAM.LATE']);
                $oPHPExcelActiveSheet->SetCellValue('M' . $nRow, $oDay['H.CRONOGRAM']);
                $oPHPExcelActiveSheet->SetCellValue('N' . $nRow, $oDay['H.CRONOGRAM.EXTRA']);
                
                if ($oDay['H.CRONOGRAM.LATE'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                if ($oDay['H.CRONOGRAM'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);
                if ($oDay['H.CRONOGRAM.EXTRA'] != '0h 0m') $oPHPExcelActiveSheet->getStyle('N' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKYELLOW);  
                
                $oPHPExcelActiveSheet->getStyle('K' . $nRow)->getFont()->setBold(true);
                $oPHPExcelActiveSheet->getStyle('M' . $nRow)->getFont()->setBold(true);
             }
             else $nRow++;
             
             if (($nRow > $nEndRow) && (count($oDay['CHECKIN_LIST']) > 0)) $nEndRow = $nRow;
             else $nRow = $nEndRow;
              
             if (!is_null($sRowColor)) $oPHPExcelActiveSheet->getStyle('A' . $nStartRow . ':O' . $nEndRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>$sRowColor)));

             $nRow += 2;   
          }
       }
       
       // Footer
       $nRow++;
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'O' . $nRow);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_FOOTER_TITLE'));
       $nRow += 2;
       
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('C' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HDTOTAL_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, $oArrayEmployee['H.D.TOTAL']);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'H' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('I' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HTHEORIC_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, $oArrayEmployee['H.THEORIC']);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
       
       $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'N' . $nRow);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_FOOTER_HCRONOGRAM_DETAIL') . ':');
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getFont()->setSize($nFontSize);
       $oPHPExcelActiveSheet->SetCellValue('O' . $nRow, $oArrayEmployee['H.CRONOGRAM']);
       $nRow++;
                                                                                                                                                   
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('C' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HNTOTAL_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, $oArrayEmployee['H.N.TOTAL']);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'H' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('I' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_FOOTER_HTOTAL_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, $oArrayEmployee['H.TOTAL']);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
       
       $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'N' . $nRow);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_FOOTER_HCRONOGRAMLATE_DETAIL') . ':');
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getFont()->setSize($nFontSize);
       $oPHPExcelActiveSheet->SetCellValue('O' . $nRow, $oArrayEmployee['H.CRONOGRAM.LATE']);
       $nRow++;
       
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('C' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHDTOTAL_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, $oArrayEmployee['H.H.D.TOTAL']);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'H' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('I' . $nRow . ':' . 'J' . $nRow);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('I' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HINCIDENCE_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('I' . $nRow, $oArrayEmployee['H.TOTAL.INCIDENCE']);
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
       
       $oPHPExcelActiveSheet->mergeCells('L' . $nRow . ':' . 'N' . $nRow);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('L' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('L' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_FOOTER_HCRONOGRAMEXTRA_DETAIL') . ':');
       $oPHPExcelActiveSheet->getStyle('O' . $nRow)->getFont()->setSize($nFontSize);
       $oPHPExcelActiveSheet->SetCellValue('O' . $nRow, $oArrayEmployee['H.CRONOGRAM.EXTRA']);
       $nRow++;
       
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'B' . $nRow);
       $oPHPExcelActiveSheet->mergeCells('C' . $nRow . ':' . 'D' . $nRow);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('C' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setBold(true);
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_HEADER_HHNTOTAL_DETAIL') . ':');
       $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, $oArrayEmployee['H.H.N.TOTAL']);
       $nRow++;    
    }
    
    private function compareCheckinChronogram($sEmployee, $nStartDate, $nEndDate, $sSourceData) {
       $oCheckinChronogram['DAYS_LIST'] = array();
       $sCurrentDate = $nStartDate;
       $nDiffDays = FDate::getDiffDays($nStartDate, $nEndDate);
       $bIncidenceNotResolved = false;
       
       $oCheckinChronogram['EMPLOYEE.NIF'] = $sEmployee;
       $oEmployee = Employees::getEmployeeByIdentification($sEmployee);
       
       if (!is_null($oEmployee)) {
          $oCheckinChronogram['EMPLOYEE.NAME'] = Employees::getFullName($oEmployee->id);
       }
       else {
          $oCheckinChronogram['EMPLOYEE.NAME'] = FString::STRING_EMPTY;
       }
          
       for($i = 0; $i <= $nDiffDays; $i++) {
          $oCheckinList = array();
          $oObjectives = array();
          $bInput = true;
          $nInterval = 0;
          
          $sYesterdayDate = date('Y-m-d', strtotime('-1 day', strtotime($sCurrentDate)));
          $sTomorrowDate = date('Y-m-d', strtotime('+1 day', strtotime($sCurrentDate)));
         
          $oYesterdayWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $sEmployee, $sYesterdayDate);
          $oYesterdayAbsenceChronograms = AccessControlChronograms::getAccessControlAbsenceChronogramsByEmployeeDate($sEmployee, $sYesterdayDate);
          $bYesterdayToWorkTurnNight = false; 
          $bYesterdayToWork = (((!is_null($oYesterdayWorkingChronogram)) && (count($oYesterdayAbsenceChronograms) == 0)) || ((!is_null($oYesterdayWorkingChronogram)) && (count($oYesterdayAbsenceChronograms) != 0) && ($this->existsCheckin($sEmployee, $sYesterdayDate, $sSourceData))));
          
          $oTodayWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $sEmployee, $sCurrentDate);
          $oTodayAbsenceChronograms = AccessControlChronograms::getAccessControlAbsenceChronogramsByEmployeeDate($sEmployee, $sCurrentDate);
          $bTodayToWorkTurnNight = false;
          $bTodayToWork = (((!is_null($oTodayWorkingChronogram)) && (count($oTodayAbsenceChronograms) == 0)) || ((!is_null($oTodayWorkingChronogram)) && (count($oTodayAbsenceChronograms) != 0) && ($this->existsCheckin($sEmployee, $sCurrentDate, $sSourceData))));
          
          $bTodayIsHoliday = (!is_null(AccessControlChronograms::getAccessControlHolidayChronogramByDate($sCurrentDate)));
          $bTodayIsPause = (!is_null(AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $sEmployee, $sCurrentDate)));
      
          if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) { 
             // Have to work ? and Night turn yesterday ?
             if ($bYesterdayToWork) {
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oYesterdayWorkingChronogram)) {
                   $bYesterdayToWorkTurnNight = true;
                   $oObjectives[0] = AccessControlChronograms::getAccessControlMinutesOfLastTurn($oYesterdayWorkingChronogram);
                   
                   if ($bTodayToWork) { 
                      $oTurnHour = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram);
                      
                      $oObjectives[1] = ($oTurnHour[0] * 60) + $oTurnHour[1];
                   } 
                } 
             }
             else {
                // Not have a cronogram, but the problem is that employees have night turn 
                if (is_null($oYesterdayWorkingChronogram)) {
                   if ($this->existsCheckin($sEmployee, $sYesterdayDate, $sSourceData, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME)) {
                      $bYesterdayToWorkTurnNight = true;
                               
                      $oObjectives[0] = (((int) FDate::getHour(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME)) * 60) + ((int) FDate::getMinutes(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME));
                      
                      if ($bTodayToWork) { 
                         $oTurnHour = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram);
                         
                         $oObjectives[1] = ($oTurnHour[0] * 60) + $oTurnHour[1];
                      }  
                   }   
                }   
             }
          
             $oCheckin = AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDate($sEmployee, $sCurrentDate);
                               
             if ((count($oCheckin) > 0) && (is_null($oCheckin[0]->type))) { 
                // Check if checkin is Input/Output
                if ($bYesterdayToWorkTurnNight) {   
                   $oFirstCheckin = $oCheckin[0];
                                               
                   $nCheckinMin = ((int) FDate::getHour($oFirstCheckin->date) * 60) + ((int) FDate::getMinutes($oFirstCheckin->date));
                   
                   $bInput = false;
                   $nMinObjective = abs($nCheckinMin - $oObjectives[0]);
                   
                   if (count($oObjectives) > 1) {
                      if (abs($nCheckinMin - $oObjectives[1]) < $nMinObjective) { $nMinObjective = abs($nCheckinMin - $oObjectives[1]); $bInput = true; }
                   }
                   
                   if ($bIncidenceNotResolved) $bInput = true;
                   if ((!is_null($oYesterdayWorkingChronogram)) && (!$bInput)) {
                      $oChronogramLastTurn = AccessControlChronograms::getAccessControlTimeTurn($oYesterdayWorkingChronogram, true, false);
                      if ((count($oChronogramLastTurn) > 0) && (!$this->existsCheckin($sEmployee, $sYesterdayDate, $sSourceData, $oChronogramLastTurn[0] . ':' . $oChronogramLastTurn[1]))) $bInput = true;
                   }
  
                   if (!$bInput) {
                      $oCheckinList[0]['TIME'] = '00:00';
                      $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT;
                      $oCheckinList[0]['SHOW'] = false;
                      $oCheckinList[0]['INCIDENCE'] = false;
                      $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY;   
                   }
                   else {
                      $oCheckinList[0]['TIME'] = '00:00';
                      $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT; 
                      $oCheckinList[0]['SHOW'] = false;
                      $oCheckinList[0]['INCIDENCE'] = false;
                      $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY; 
                      
                      $oCheckinList[1]['TIME'] = FString::STRING_EMPTY;
                      $oCheckinList[1]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[1]['SHOW'] = true;
                      $oCheckinList[1]['INCIDENCE'] = false;
                      $oCheckinList[1]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[1]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[1]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      if (!$bIncidenceNotResolved) $oCheckinList[1]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');       
                      else $oCheckinList[1]['INFORMATION'] = FString::STRING_EMPTY; 
                   }                                                                 
                }
             }
             else {
                if (count($oCheckin) > 0) {
                   $bInput = (($oCheckin[0]->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) || ($oCheckin[0]->type == FModuleAccessControlManagement::TYPE_INPUT));
                   
                   if ($bYesterdayToWorkTurnNight) {
                      if (!$bInput) {
                         $oCheckinList[0]['TIME'] = '00:00';
                         $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT;
                         $oCheckinList[0]['SHOW'] = false;
                         $oCheckinList[0]['INCIDENCE'] = false;
                         $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY;   
                      }
                      else {
                         $oCheckinList[0]['TIME'] = '00:00';
                         $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT; 
                         $oCheckinList[0]['SHOW'] = false;
                         $oCheckinList[0]['INCIDENCE'] = false;
                         $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY; 
                         
                         $oCheckinList[1]['TIME'] = FString::STRING_EMPTY;
                         $oCheckinList[1]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                         $oCheckinList[1]['SHOW'] = true;
                         $oCheckinList[1]['INCIDENCE'] = false;
                         $oCheckinList[1]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[1]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[1]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[1]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[1]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[1]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[1]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[1]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[1]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[1]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         if (!$bIncidenceNotResolved) $oCheckinList[1]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');       
                         else $oCheckinList[1]['INFORMATION'] = FString::STRING_EMPTY; 
                      }
                   }
                }   
             }    
          }
          else {
             if ($bYesterdayToWork) {
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oYesterdayWorkingChronogram)) $bYesterdayToWorkTurnNight = true;
             }
             else {
                // Not have a cronogram, but the problem is that employees have night turn 
                if (is_null($oYesterdayWorkingChronogram)) {
                   if ($this->existsCheckin($sEmployee, $sYesterdayDate, $sSourceData, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME)) $bYesterdayToWorkTurnNight = true;  
                }   
             }
               
             $oCheckin = AccessControlCheckInManual::getAccessControlCheckinByEmployeeDate($sEmployee, $sCurrentDate);
             if (count($oCheckin) > 0) $bInput = (($oCheckin[0]->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) || ($oCheckin[0]->type == FModuleAccessControlManagement::TYPE_INPUT));
              
             if ($bYesterdayToWorkTurnNight) {
                if (count($oCheckin) > 0) {
                   if (!$bInput) {
                      $oCheckinList[0]['TIME'] = '00:00';
                      $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT;
                      $oCheckinList[0]['SHOW'] = false;
                      $oCheckinList[0]['INCIDENCE'] = false;
                      $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY;   
                   }
                   else {
                      $oCheckinList[0]['TIME'] = '00:00';
                      $oCheckinList[0]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT; 
                      $oCheckinList[0]['SHOW'] = false;
                      $oCheckinList[0]['INCIDENCE'] = false;
                      $oCheckinList[0]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[0]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[0]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[0]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[0]['INFORMATION'] = FString::STRING_EMPTY; 
                      
                      $oCheckinList[1]['TIME'] = FString::STRING_EMPTY;
                      $oCheckinList[1]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[1]['SHOW'] = true;
                      $oCheckinList[1]['INCIDENCE'] = false;
                      $oCheckinList[1]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[1]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[1]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[1]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[1]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');       
                   }
                }                                                                  
             }
          }
 
          if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) $oCheckin = AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDate($sEmployee, $sCurrentDate);
          else $oCheckin = AccessControlCheckInManual::getAccessControlCheckinByEmployeeDate($sEmployee, $sCurrentDate);
          
          $oBeforeCheckin = null;
          foreach($oCheckin as $oCurrentCheckin) {
             $bDiscartCheckin = false;
             
             // Discart checkin ?
             if ((!is_null($oBeforeCheckin)) && (!is_null($oBeforeCheckin->id_device)) && (!is_null($oCurrentCheckin->id_device)) && ($oBeforeCheckin->id_device == $oCurrentCheckin->id_device)) {
                if (FDate::getDiffSeconds($oBeforeCheckin->date, $oCurrentCheckin->date) <= FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DISCART_CHECKIN_SECONDS) $bDiscartCheckin = true; 
             }
             
             if (!$bDiscartCheckin) {
                
                if (($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) && (!is_null($oCurrentCheckin->type))) {
                   if (((($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) || ($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_INPUT)) && ((count($oCheckinList) % 2) != 0)) || ((($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_OUTPUT) || ($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_OUTPUT)) && ((count($oCheckinList) % 2) == 0))) {
                      $nCurrentCheckinIndex = count($oCheckinList);
                             
                      if ((($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_MAIN_INPUT) || ($oCurrentCheckin->type == FModuleAccessControlManagement::TYPE_INPUT)) && ((count($oCheckinList) % 2) != 0)) {
                         $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                         $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');   
                      }  
                      else {
                         $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT;
                         $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = FString::STRING_EMPTY;   
                      }                      
                   }     
                }
                
                $nCurrentCheckinIndex = count($oCheckinList);
                $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FFormat::getFormatTimeTwoDigits(FDate::getHour($oCurrentCheckin->date) . ":" . FDate::getMinutes($oCurrentCheckin->date));
                
                // Compute time
                if ((count($oCheckinList) % 2) == 0) {
                   $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;  
                   
                   if ($oCheckinList[count($oCheckinList) - 2]['TIME'] != FString::STRING_EMPTY) $nDateDiffTotal = FDate::getDiffMinutes($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME']);
                   else $nDateDiffTotal = 0;
                   
                   $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                   
                   if (($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) && (!is_null($oCurrentCheckin->incidence_code))) {
                      $oAccessControlIncidence = AccessControlIncidences::getAccessControlIncidenceByCode($oCurrentCheckin->incidence_code);
                      
                      if (!is_null($oAccessControlIncidence)) {
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = true; 
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = $oAccessControlIncidence->description;
                      }
                      else {
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false; 
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;   
                      }
                   } 
                   else {
                      $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                   }
                   $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                   
                   if ($oCheckinList[count($oCheckinList) - 2]['TIME'] != FString::STRING_EMPTY) $nHDTotal = FModuleAccessControlManagement::getDayHours($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME'], FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME);
                   else $nHDTotal = 0; 
                   
                   if (($bTodayIsHoliday) || (count($oTodayAbsenceChronograms) != 0) || ($bTodayIsPause)) {
                      $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m'; 
                      $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                   }
                   else {
                      $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                      $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                   }

                   $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal);
                   
                   if ($oCheckinList[count($oCheckinList) - 2]['TIME'] != FString::STRING_EMPTY) {
                      $nInterval = $this->traceCheckinCronogram($oTodayWorkingChronogram, $oYesterdayWorkingChronogram, $bYesterdayToWork, $oCheckinList, $nCurrentCheckinIndex, $oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME'], $nInterval);
                   }
                   else {
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');     
                   }
                }
                else {
                   $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT;
                   $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                   $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                   $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                   $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';                                                                                                                                
                   $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m'; 
                   $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                   $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = FString::STRING_EMPTY;
                   
                   if ($bIncidenceNotResolved) {
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm(((int) FDate::getHour($oCurrentCheckin->date) * 60) + ((int) FDate::getMinutes($oCurrentCheckin->date)));
                      
                      $bIncidenceNotResolved = false;
                   }
                   
                   $this->computeIncidence($oTodayWorkingChronogram, $oYesterdayWorkingChronogram, $bYesterdayToWorkTurnNight, $oCheckinList, $nCurrentCheckinIndex);  
                }
             }
             
             $oBeforeCheckin = $oCurrentCheckin;   
          }
          
          $nCurrentCheckinIndex = count($oCheckinList);
          if ($nCurrentCheckinIndex > 0) {
             if ($bTodayToWork) {
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayWorkingChronogram)) {
                   $bTodayToWorkTurnNight = true;
                   
                   if (($nCurrentCheckinIndex % 2) != 0) { 
                      $oCheckinList[$nCurrentCheckinIndex]['TIME'] = '24:00';
                      $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = false;
                      
                      $nDateDiffTotal = FDate::getDiffMinutes($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME']);
                      
                      $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      
                      $nHDTotal = FModuleAccessControlManagement::getDayHours($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME'], FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME);
                      
                      if (($bTodayIsHoliday) || (count($oTodayAbsenceChronograms) != 0) || ($bTodayIsPause)) {
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m'; 
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                      }
                      else {
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                      }
                      
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal);
                      
                      $nInterval = $this->traceCheckinCronogram($oTodayWorkingChronogram, $oYesterdayWorkingChronogram, $bYesterdayToWork, $oCheckinList, $nCurrentCheckinIndex, $oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME'], $nInterval);
                   }
                   else {
                      $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT; 
                      $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                      $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = FString::STRING_EMPTY;
                      
                      $this->computeIncidence($oTodayWorkingChronogram, $oYesterdayWorkingChronogram, $bYesterdayToWorkTurnNight, $oCheckinList, $nCurrentCheckinIndex, true, false);  
                      
                      if (($nCurrentCheckinIndex > 0) && ($oCheckinList[$nCurrentCheckinIndex - 1]['INCIDENCE'])) $bIncidenceNotResolved = true;
                         
                      $oCheckinList[$nCurrentCheckinIndex + 1]['TIME'] = '24:00';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[$nCurrentCheckinIndex + 1]['SHOW'] = false;
                      $oCheckinList[$nCurrentCheckinIndex + 1]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex + 1]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      if (!$bIncidenceNotResolved) $oCheckinList[$nCurrentCheckinIndex + 1]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');
                      else $oCheckinList[$nCurrentCheckinIndex + 1]['INFORMATION'] = FString::STRING_EMPTY;  
                   }
                }
                else { 
                   if (($nCurrentCheckinIndex % 2) != 0) {
                      $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                      $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHECKIN');
                   }   
                }
             }      
             else {
                if (is_null($oTodayWorkingChronogram)) {
                   if ($this->existsCheckin($sEmployee, $sCurrentDate, $sSourceData, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME)) {
                      if (($nCurrentCheckinIndex % 2) != 0) { 
                         $oCheckinList[$nCurrentCheckinIndex]['TIME'] = '24:00';
                         $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                         $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = false;
            
                         $nDateDiffTotal = FDate::getDiffMinutes($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME']);
                         
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';

                         $nHDTotal = FModuleAccessControlManagement::getDayHours($oCheckinList[count($oCheckinList) - 2]['TIME'], $oCheckinList[count($oCheckinList) - 1]['TIME'], FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME);
                         
                         if (($bTodayIsHoliday) || (count($oTodayAbsenceChronograms) != 0) || ($bTodayIsPause)) {
                            $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m'; 
                            $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                            $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                            $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                         }
                         else {
                            $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
                            $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal - $nHDTotal);
                            $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                            $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                         }
                         
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = FFormat::getFormatMinutesToHm($nDateDiffTotal);

                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHRONOGRAM');
                      }
                      else {
                         $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_INPUT; 
                         $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = FString::STRING_EMPTY;
                         
                         $this->computeIncidence($oTodayWorkingChronogram, $oYesterdayWorkingChronogram, $bYesterdayToWorkTurnNight, $oCheckinList, $nCurrentCheckinIndex, true, false);  
                         
                         if (($nCurrentCheckinIndex > 0) && ($oCheckinList[$nCurrentCheckinIndex - 1]['INCIDENCE'])) $bIncidenceNotResolved = true;
                            
                         $oCheckinList[$nCurrentCheckinIndex + 1]['TIME'] = '24:00';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                         $oCheckinList[$nCurrentCheckinIndex + 1]['SHOW'] = false;
                         $oCheckinList[$nCurrentCheckinIndex + 1]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex + 1]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex + 1]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHRONOGRAM');  
                      } 
                   }
                   else {
                      if (($nCurrentCheckinIndex % 2) != 0) {
                         $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                         $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                         $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                         $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                         $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_CHRONOGRAM');   
                      }
                   }
                }
                else {
                   if (($nCurrentCheckinIndex % 2) != 0) {
                      $oCheckinList[$nCurrentCheckinIndex]['TIME'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['I/O'] = FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_TYPE_OUTPUT;
                      $oCheckinList[$nCurrentCheckinIndex]['SHOW'] = true;
                      $oCheckinList[$nCurrentCheckinIndex]['INCIDENCE'] = false;
                      $oCheckinList[$nCurrentCheckinIndex]['TYPE.INCIDENCE'] = FString::STRING_EMPTY;
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL.INCIDENCE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.D.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.H.N.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.TOTAL'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
                      $oCheckinList[$nCurrentCheckinIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_FIT_CHRONOGRAM');   
                   }
                }
             }
          }
          
          // Generate day array
          $sHoliday = FString::STRING_EMPTY;
          if ($bTodayIsHoliday) $sHoliday = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY');
                
          $sWorkingPause = FString::STRING_EMPTY;
          $sTheoricHours = FString::STRING_EMPTY;
          $nTheoricHoursMin = 0;
          if (!is_null($oTodayWorkingChronogram)) {
             
             if ($bYesterdayToWorkTurnNight) {
                if (!is_null($oYesterdayWorkingChronogram)) {
                   $oTurnYesterday_h2 = AccessControlChronograms::getAccessControlTimeTurn($oYesterdayWorkingChronogram, false, false);
                    
                   $nTheoricHoursMin = (FDate::getHour($oTurnYesterday_h2[0] * 60)) + FDate::getMinutes($oTurnYesterday_h2[1]);
                   $sWorkingPause = '00:00 - ' . FFormat::getFormatTimeTwoDigits($oTurnYesterday_h2[0] . ':' . $oTurnYesterday_h2[1]) . FString::getNewLine();      
                }   
             }
             
             if ($oTodayWorkingChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, true);
                $sWorkingPause .= FFormat::getFormatTimeTwoDigits($oTurn1_h1[0] . ':' . $oTurn1_h1[1]) . ' - '; 
                
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayWorkingChronogram)) {
                   $nTheoricHoursMin += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], '24:00');
                   $sWorkingPause .= '24:00' . FString::getNewLine(); 
                }
                else {
                   $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, true);
                   
                   $nTheoricHoursMin += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], $oTurn1_h2[0] . ':' . $oTurn1_h2[1]);
                   $sWorkingPause .= FFormat::getFormatTimeTwoDigits($oTurn1_h2[0] . ':' . $oTurn1_h2[1]) . FString::getNewLine();
                }   
             }
             else {
                $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, true);
                $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, true);
                $sWorkingPause .= FFormat::getFormatTimeTwoDigits($oTurn1_h1[0] . ':' . $oTurn1_h1[1]) . ' - ' . FFormat::getFormatTimeTwoDigits($oTurn1_h2[0] . ':' . $oTurn1_h2[1]) . FString::getNewLine();
                $nTheoricHoursMin += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], $oTurn1_h2[0] . ':' . $oTurn1_h2[1]);
                
                $oTurn2_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, false);
                $sWorkingPause .= FFormat::getFormatTimeTwoDigits($oTurn2_h1[0] . ':' . $oTurn2_h1[1]) . ' - ';
                
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayWorkingChronogram)) {
                   $sWorkingPause .= '24:00' . FString::getNewLine();
                   $nTheoricHoursMin += FDate::getDiffMinutes($oTurn2_h1[0] . ':' . $oTurn2_h1[1], '24:00');
                }
                else {
                   $oTurn2_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, false);
                   
                   $nTheoricHoursMin += FDate::getDiffMinutes($oTurn2_h1[0] . ':' . $oTurn2_h1[1], $oTurn2_h2[0] . ':' . $oTurn2_h2[1]);
                   $sWorkingPause .= FFormat::getFormatTimeTwoDigits($oTurn2_h2[0] . ':' . $oTurn2_h2[1]) . FString::getNewLine();   
                }
             }
             
             $sTheoricHours = FFormat::getFormatMinutesToHm($nTheoricHoursMin);
          }   
          else {
             if ($bYesterdayToWorkTurnNight) {
                if (!is_null($oYesterdayWorkingChronogram)) {
                   $oTurnYesterday_h2 = AccessControlChronograms::getAccessControlTimeTurn($oYesterdayWorkingChronogram, false, false);
                    
                   $nTheoricHoursMin = (FDate::getHour($oTurnYesterday_h2[0] * 60)) + FDate::getMinutes($oTurnYesterday_h2[1]);
                   $sWorkingPause = '00:00 - ' . FFormat::getFormatTimeTwoDigits($oTurnYesterday_h2[0] . ':' . $oTurnYesterday_h2[1]) . FString::getNewLine();      
                   
                   $sTheoricHours = FFormat::getFormatMinutesToHm($nTheoricHoursMin);
                }   
             }
                  
             if ($bTodayIsPause) {
                $sWorkingPause .= Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE');   
             }   
          }
          
          $sAbsence = FString::STRING_EMPTY;
          if (count($oTodayAbsenceChronograms) > 0) {
             $sAbsence = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_' . $oTodayAbsenceChronograms[0]->type);         
          }
          
          $oCheckinDay = array('DATE'=>$sCurrentDate, 'HOLIDAY'=>($sHoliday != FString::STRING_EMPTY), 'HOLIDAY.DESCRIPTION'=>$sHoliday, 'WORKING_PAUSE'=>$sWorkingPause, 'ABSENCE'=>($sAbsence != FString::STRING_EMPTY), 'ABSENCE.DESCRIPTION'=>$sAbsence, 'THEORIC_HOURS'=>$sTheoricHours, 'CHECKIN_LIST'=>$oCheckinList);
          $this->computeAllDay($oCheckinDay);
                    
          $oCheckinChronogram['DAYS_LIST'][count($oCheckinChronogram['DAYS_LIST'])] = $oCheckinDay;

          $sCurrentDate = $sTomorrowDate; 
       }
                                                   
       $this->computeAllReport($oCheckinChronogram, $sSourceData);
       
       return $oCheckinChronogram;  
    }
    
    private function computeAllReport(&$oCheckinCronogram, $sSourceData) {
       $nTotalIncidence = 0;
       $nHDTotal = 0;
       $nHNTotal = 0;
       $nHHDTotal = 0;
       $nHHNTotal = 0;
       $nTotal = 0;
       $nCronogramLate = 0;
       $nCronogram = 0;
       $nCronogramExtra = 0;
       $nTheoric = 0;
       
       $oDaysList = $oCheckinCronogram['DAYS_LIST'];
       foreach ($oDaysList as $day) {
          $nTotalIncidence += (((int) FString::getFirstToken($day['H.TOTAL.INCIDENCE'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.TOTAL.INCIDENCE'], FString::STRING_SPACE, 2), 'm'));    
          $nHDTotal += (((int) FString::getFirstToken($day['H.D.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.D.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHNTotal += (((int) FString::getFirstToken($day['H.N.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.N.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHHDTotal += (((int) FString::getFirstToken($day['H.H.D.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.H.D.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHHNTotal += (((int) FString::getFirstToken($day['H.H.N.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.H.N.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nTotal += (((int) FString::getFirstToken($day['H.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nCronogramLate += (((int) FString::getFirstToken($day['H.CRONOGRAM.LATE'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.CRONOGRAM.LATE'], FString::STRING_SPACE, 2), 'm'));
          $nCronogram += (((int) FString::getFirstToken($day['H.CRONOGRAM'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.CRONOGRAM'], FString::STRING_SPACE, 2), 'm'));
          $nCronogramExtra += (((int) FString::getFirstToken($day['H.CRONOGRAM.EXTRA'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($day['H.CRONOGRAM.EXTRA'], FString::STRING_SPACE, 2), 'm'));
          
          $sYesterdayDate = date('Y-m-d', strtotime('-1 day', strtotime($day['DATE'])));
          $oYesterdayWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $oCheckinCronogram['EMPLOYEE.NIF'], $sYesterdayDate);
          $bYesterdayIsPause = (!is_null(AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $oCheckinCronogram['EMPLOYEE.NIF'], $sYesterdayDate)));
          $bYesterdayAbsenceChronograms = (count(AccessControlChronograms::getAccessControlAbsenceChronogramsByEmployeeDate($oCheckinCronogram['EMPLOYEE.NIF'], $sYesterdayDate)) != 0);
           
          $oTodayWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $oCheckinCronogram['EMPLOYEE.NIF'], $day['DATE']);
          
          if ((!$bYesterdayAbsenceChronograms) && (!$bYesterdayIsPause)) {
             if (!is_null($oYesterdayWorkingChronogram)) {
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oYesterdayWorkingChronogram)) {
                   $oArrayTurn = AccessControlChronograms::getAccessControlTimeTurn($oYesterdayWorkingChronogram, false, false);
                   $nTheoric += ($oArrayTurn[0] * 60) + $oArrayTurn[1];
                }   
             }
             else {
                if ($this->existsCheckin($oCheckinCronogram['EMPLOYEE.NIF'], $sYesterdayDate, $sSourceData, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME)) {
                   $nTheoric += 6 * 60;   
                }   
             }
          }
                    
          if ((!$day['ABSENCE']) && (stristr($day['WORKING_PAUSE'], Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE')) === FALSE)) {
             if (!is_null($oTodayWorkingChronogram)) {
                if ($oTodayWorkingChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                   $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, true);
                   
                   if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayWorkingChronogram)) {
                      $nTheoric += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], '24:00');
                   }
                   else {
                      $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, true);
                      
                      $nTheoric += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], $oTurn1_h2[0] . ':' . $oTurn1_h2[1]);
                   }   
                }
                else {
                   $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, true);
                   $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, true);
                   $nTheoric += FDate::getDiffMinutes($oTurn1_h1[0] . ':' . $oTurn1_h1[1], $oTurn1_h2[0] . ':' . $oTurn1_h2[1]);
                   
                   $oTurn2_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, true, false);
                   
                   if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayWorkingChronogram)) {
                      $nTheoric += FDate::getDiffMinutes($oTurn2_h1[0] . ':' . $oTurn2_h1[1], '24:00');
                   }
                   else {
                      $oTurn2_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayWorkingChronogram, false, false);
                      
                      $nTheoric += FDate::getDiffMinutes($oTurn2_h1[0] . ':' . $oTurn2_h1[1], $oTurn2_h2[0] . ':' . $oTurn2_h2[1]);   
                   }
                }
             }
             else { 
                if ($this->existsCheckin($oCheckinCronogram['EMPLOYEE.NIF'], $day['DATE'], $sSourceData, FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_NIGHT_TIME)) {
                   $nTheoric += 2 * 60;   
                }
                else {
                   $nt_hour = (int) FDate::getHour(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME);
                   $nt_min = (int) FDate::getMinutes(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME); 
                   
                   $nt_hour++;
                   if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) {
                      if (count(AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDateHour($oCheckinCronogram['EMPLOYEE.NIF'], $day['DATE'], $nt_hour, $nt_min)) != 0) {
                         $nTheoric += 8 * 60;
                      }
                   }
                   else {
                      if (count(AccessControlCheckInManual::getAccessControlCheckinByEmployeeDateHour($oCheckinCronogram['EMPLOYEE.NIF'], $day['DATE'], $nt_hour, $nt_min)) != 0) {
                         $nTheoric += 8 * 60;
                      }    
                   } 
                }   
             }
          }            
       }

     
       $oCheckinCronogram['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm($nTotalIncidence);
       $oCheckinCronogram['H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
       $oCheckinCronogram['H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nHNTotal);
       $oCheckinCronogram['H.H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHHDTotal);
       $oCheckinCronogram['H.H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nHHNTotal);
       $oCheckinCronogram['H.TOTAL'] = FFormat::getFormatMinutesToHm($nTotal);
       $oCheckinCronogram['H.CRONOGRAM.LATE'] = FFormat::getFormatMinutesToHm($nCronogramLate);
       $oCheckinCronogram['H.CRONOGRAM'] = FFormat::getFormatMinutesToHm($nCronogram);
       $oCheckinCronogram['H.CRONOGRAM.EXTRA'] = FFormat::getFormatMinutesToHm($nCronogramExtra);
       $oCheckinCronogram['H.THEORIC'] = FFormat::getFormatMinutesToHm($nTheoric);   
    }
    
    private function computeAllDay(&$oCheckinDay) {
       $nTotalIncidence = 0;
       $nHDTotal = 0;
       $nHNTotal = 0;
       $nHHDTotal = 0;
       $nHHNTotal = 0;
       $nTotal = 0;
       $nCronogramLate = 0;
       $nCronogram = 0;
       $nCronogramExtra = 0;

       $oCheckinList = $oCheckinDay['CHECKIN_LIST'];
       foreach ($oCheckinList as $checkin) {                   
          $nTotalIncidence += (((int) FString::getFirstToken($checkin['H.TOTAL.INCIDENCE'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.TOTAL.INCIDENCE'], FString::STRING_SPACE, 2), 'm'));    
          $nHDTotal += (((int) FString::getFirstToken($checkin['H.D.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.D.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHNTotal += (((int) FString::getFirstToken($checkin['H.N.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.N.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHHDTotal += (((int) FString::getFirstToken($checkin['H.H.D.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.H.D.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nHHNTotal += (((int) FString::getFirstToken($checkin['H.H.N.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.H.N.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nTotal += (((int) FString::getFirstToken($checkin['H.TOTAL'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.TOTAL'], FString::STRING_SPACE, 2), 'm'));
          $nCronogramLate += (((int) FString::getFirstToken($checkin['H.CRONOGRAM.LATE'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.CRONOGRAM.LATE'], FString::STRING_SPACE, 2), 'm'));
          $nCronogram += (((int) FString::getFirstToken($checkin['H.CRONOGRAM'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.CRONOGRAM'], FString::STRING_SPACE, 2), 'm'));
          $nCronogramExtra += (((int) FString::getFirstToken($checkin['H.CRONOGRAM.EXTRA'], 'h')) * 60) +  ((int) FString::getFirstToken(FString::getToken($checkin['H.CRONOGRAM.EXTRA'], FString::STRING_SPACE, 2), 'm'));
       }

       $oCheckinDay['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm($nTotalIncidence);
       $oCheckinDay['H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHDTotal);
       $oCheckinDay['H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nHNTotal);
       $oCheckinDay['H.H.D.TOTAL'] = FFormat::getFormatMinutesToHm($nHHDTotal);
       $oCheckinDay['H.H.N.TOTAL'] = FFormat::getFormatMinutesToHm($nHHNTotal);
       $oCheckinDay['H.TOTAL'] = FFormat::getFormatMinutesToHm($nTotal);
       $oCheckinDay['H.CRONOGRAM.LATE'] = FFormat::getFormatMinutesToHm($nCronogramLate);
       $oCheckinDay['H.CRONOGRAM'] = FFormat::getFormatMinutesToHm($nCronogram);
       $oCheckinDay['H.CRONOGRAM.EXTRA'] = FFormat::getFormatMinutesToHm($nCronogramExtra);          
    }
    
    private function computeIncidence($oTodayChronogram, $oYesterdayChronogram, $bYesterdayToWorkTurnNight, &$oCheckinList, $nIndex, $bNight = false, $bStart = true) {
       if (($nIndex > 0) && ($oCheckinList[$nIndex - 1]['INCIDENCE'])) {
          if (($bNight) && ($bStart)) {
             $nCheckinIncidenceMin = 0;
          }
          else $nCheckinIncidenceMin = ((int) FDate::getHour($oCheckinList[$nIndex - 1]['TIME']) * 60) + ((int) FDate::getMinutes($oCheckinList[$nIndex - 1]['TIME']));
          
          if (($bNight) && (!$bStart)) {
             $nCheckinAfterIncidenceMin = 24 * 60;      
          }
          else $nCheckinAfterIncidenceMin = ((int) FDate::getHour($oCheckinList[$nIndex]['TIME']) * 60) + ((int) FDate::getMinutes($oCheckinList[$nIndex]['TIME']));    
          
          if (!is_null($oTodayChronogram)) { 
             $oTurnYesterday_h1 = null;
             $oTurnYesterday_h2 = null;
             $oTurn1_h1 = null;
             $oTurn1_h2 = null;
             $oTurn2_h1 = null;
             $oTurn2_h2 = null;
             
             $nYesterdayTurn_h1 = 0;
             $nYesterdayTurn_h2 = 0;
             $nTurn1_h1 = 0;
             $nTurn1_h2 = 0;
             $nTurn2_h1 = 0;
             $nTurn2_h2 = 0;
             
             if ($bYesterdayToWorkTurnNight) {
                if (is_null($oYesterdayChronogram)) {
                   $oTurnYesterday_h1 = array(0, 0);
                   $oTurnYesterday_h2 = array((int) FDate::getHour(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME), (int) FDate::getMinutes(FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_ALGORITHM_DAY_TIME));  
                }
                else {
                   $oTurnYesterday_h1 = array(0, 0);
                   $oTurnYesterday_h2 = AccessControlChronograms::getAccessControlTimeTurn($oYesterdayChronogram, false, false);      
                }   
             }  
              
             if ($oTodayChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, true, true);
                
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayChronogram)) {
                   $oTurn1_h2 = array(24, 0);
                }
                else $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, false, true);   
             }
             else {
                $oTurn1_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, true, true);
                $oTurn1_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, false, true);
                $oTurn2_h1 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, true, false);
                
                if (AccessControlChronograms::isAccessControlChronogamNightTurn($oTodayChronogram)) {
                   $oTurn2_h2 = array(24, 0);
                }
                else $oTurn2_h2 = AccessControlChronograms::getAccessControlTimeTurn($oTodayChronogram, false, false);
             }

             
             if (!is_null($oTurnYesterday_h1)) $nYesterdayTurn_h1 = ($oTurnYesterday_h1[0] * 60) + $oTurnYesterday_h1[1];
             if (!is_null($oTurnYesterday_h2)) $nYesterdayTurn_h2 = ($oTurnYesterday_h2[0] * 60) + $oTurnYesterday_h2[1];
             
             $nTurn1_h1 = ($oTurn1_h1[0] * 60) + $oTurn1_h1[1];
             $nTurn1_h2 = ($oTurn1_h2[0] * 60) + $oTurn1_h2[1];
             if (!is_null($oTurn2_h1)) $nTurn2_h1 = ($oTurn2_h1[0] * 60) + $oTurn2_h1[1];
             if (!is_null($oTurn2_h2)) $nTurn2_h2 = ($oTurn2_h2[0] * 60) + $oTurn2_h2[1];
             
             $candidates = array();
             if (($nYesterdayTurn_h1 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nYesterdayTurn_h1; }
             if (($nYesterdayTurn_h2 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nYesterdayTurn_h2; }
             if (($nTurn1_h1 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nTurn1_h1; } 
             if (($nTurn1_h2 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nTurn1_h2; } 
             if (($nTurn2_h1 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nTurn2_h1; } 
             if (($nTurn2_h2 - $nCheckinIncidenceMin) > 0) { $candidates[count($candidates)] = $nTurn2_h2; } 
             
             if (count($candidates) > 0) {
                $nSelectCandidate = Min($candidates);
                $nSelectCandidate = Min($nSelectCandidate, $nCheckinAfterIncidenceMin);
                 
                $oCheckinList[$nIndex - 1]['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm(abs($nSelectCandidate - $nCheckinIncidenceMin));   
             }  
             else $oCheckinList[$nIndex - 1]['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm(abs($nCheckinAfterIncidenceMin - $nCheckinIncidenceMin)); 
          }                         
          else {
             $oCheckinList[$nIndex - 1]['H.TOTAL.INCIDENCE'] = FFormat::getFormatMinutesToHm(abs($nCheckinAfterIncidenceMin - $nCheckinIncidenceMin));   
          }
       }               
    }
    
    private function traceCheckinCronogram($oChronogram, $oYesterdayChronogram, $bYesterdayToWork, &$oCheckinList, $nIndex, $sCheckinStart, $sCheckinEnd, $nInterval = 0) {
       $oCandidates = array();
       $oCheckinList[$nIndex]['H.CRONOGRAM.LATE'] = '0h 0m';
       $oCheckinList[$nIndex]['H.CRONOGRAM'] = '0h 0m';
       $oCheckinList[$nIndex]['H.CRONOGRAM.EXTRA'] = '0h 0m';
       $oCheckinList[$nIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_NOT_FIT_CHRONOGRAM');
       
       if (($bYesterdayToWork) && (AccessControlChronograms::isAccessControlChronogamNightTurn($oYesterdayChronogram))) {
          $oCandidates[count($oCandidates)] = array(array(0, 0), AccessControlChronograms::getAccessControlTimeTurn($oYesterdayChronogram, false, false));
       }
       
       if ((!is_null($oChronogram))) {
          if ($oChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
             if (AccessControlChronograms::isAccessControlChronogamNightTurn($oChronogram)) {
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, true), array(24, 0));      
             }  
             else {
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, true), AccessControlChronograms::getAccessControlTimeTurn($oChronogram, false, true));   
             }
          }  
          else {
             if (AccessControlChronograms::isAccessControlChronogamNightTurn($oChronogram)) {
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, true), AccessControlChronograms::getAccessControlTimeTurn($oChronogram, false, true));
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, false), array(24, 0));   
             }
             else {
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, true), AccessControlChronograms::getAccessControlTimeTurn($oChronogram, false, true));
                $oCandidates[count($oCandidates)] = array(AccessControlChronograms::getAccessControlTimeTurn($oChronogram, true, false), AccessControlChronograms::getAccessControlTimeTurn($oChronogram, false, false));   
             }      
          } 
       }

       $bComputeLate = true;
       $nCandidate = $nInterval;
       $nCurrentCandidate = 1;
       $nLateMinutes = 0;
       $nComputeMinutes = 0;
       $nExtraMinutes = 0;
       $nValidCandidates = 0;
       $nTotalMin = 0;
       foreach($oCandidates as $oCandidate) {
          $sChronogramStart = $oCandidate[0][0] . ':' . $oCandidate[0][1];
          $sChronogramEnd = $oCandidate[1][0] . ':' . $oCandidate[1][1]; 
                             
          if ((FDate::isDateMinor($sCheckinStart, $sChronogramEnd)) && (FDate::isDateMajor($sCheckinEnd, $sChronogramStart))) {
             // Compute late
             if (($bComputeLate) && ($nCandidate < $nCurrentCandidate)) {
                if (FDate::isDateMajor($sCheckinStart, $sChronogramStart)) {
                   $nLateMinutes = FDate::getDiffMinutes($sCheckinStart, $sChronogramStart); 
                }
                $bComputeLate = false;
             }
             
             // Compute inside chronogram
             $sSelectCheckinStart = null; $sSelectCheckinEnd = null; 
             if (FDate::isDateMajor($sCheckinStart, $sChronogramStart)) $sSelectCheckinStart = $sCheckinStart;
             else $sSelectCheckinStart = $sChronogramStart;
             
             if (FDate::isDateMinor($sCheckinEnd, $sChronogramEnd)) $sSelectCheckinEnd = $sCheckinEnd;
             else $sSelectCheckinEnd = $sChronogramEnd;

             $nComputeMinutes += FDate::getDiffMinutes($sSelectCheckinStart, $sSelectCheckinEnd);
                          
             // Compute extra
             if ($nValidCandidates == 0) {
                if (FDate::isDateMajor($sCheckinEnd, $sChronogramEnd)) {    
                   $nExtraMinutes = FDate::getDiffMinutes($sCheckinEnd, $sChronogramEnd); 
                }
             } 
             else {
                $nExtraMinutes -= FDate::getDiffMinutes($sSelectCheckinStart, $sSelectCheckinEnd);   
             }

             $nTotalMin += FDate::getDiffMinutes($sChronogramStart, $sChronogramEnd);
                       
             $nValidCandidates++;
             $nCandidate++;
          }  
          $nCurrentCandidate++;
       }
       
       $oCheckinList[$nIndex]['H.CRONOGRAM.LATE'] = FFormat::getFormatMinutesToHm($nLateMinutes);
       $oCheckinList[$nIndex]['H.CRONOGRAM'] = FFormat::getFormatMinutesToHm($nComputeMinutes);
       $oCheckinList[$nIndex]['H.CRONOGRAM.EXTRA'] = FFormat::getFormatMinutesToHm($nExtraMinutes);
       
       // Incidence ?
       $nTolerance = 0;
       if ($oChronogram->employee_process_delay) $nTolerance = $oChronogram->employee_tolerance;
       else $nTolerance = $oChronogram->timetable_tolerance;
                                   
       if (($nLateMinutes > 0) && ($nLateMinutes > $nTolerance)) {   
          $oCheckinList[$nIndex]['INFORMATION'] = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHECKINCHRONOGRAM_INCIDENCE_LATENESS', array('{1}'=>FFormat::getFormatMinutesToHm($nLateMinutes)));
       }
       else {
          $nTotalMin = $nTotalMin - $nTolerance;
          if ($nTotalMin <= 0) $nTotalMin = 1;
          
          if ($nComputeMinutes >= $nTotalMin) $oCheckinList[$nIndex]['INFORMATION'] = FString::STRING_EMPTY; 
       }
             
       return $nCandidate;
    }
    
    private function existsCheckin($sEmployee, $sDate, $sSourceData, $sAfterHour = FString::STRING_EMPTY) {
       
       if ($sAfterHour == FString::STRING_EMPTY) {
          $bYesterdayToWorkTurnNight = false;
          $sYesterdayDate = date('Y-m-d', strtotime('-1 day', strtotime($sDate)));
          
          $oYesterdayWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $sEmployee, $sYesterdayDate);
          if (!is_null($oYesterdayWorkingChronogram)) {
             if (AccessControlChronograms::isAccessControlChronogamNightTurn($oYesterdayWorkingChronogram)) {
                $bYesterdayToWorkTurnNight = true;
             }    
          }
          
          if ($bYesterdayToWorkTurnNight) {
             $nt_hour = null;
             $nt_min = null;
             
             if ($oYesterdayWorkingChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                $nt_hour = (int) FDate::getHour($oYesterdayWorkingChronogram->timetable_hour2_t1);
                $nt_min = (int) FDate::getMinutes($oYesterdayWorkingChronogram->timetable_hour2_t1);              
             }
             else {
                $nt_hour = (int) FDate::getHour($oYesterdayWorkingChronogram->timetable_hour2_t2);
                $nt_min = (int) FDate::getMinutes($oYesterdayWorkingChronogram->timetable_hour2_t2);   
             }
             
             $nt_hour++;
             
             if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) return (count(AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDateHour($sEmployee, $sDate, $nt_hour, $nt_min)) != 0);                                                     
             else return (count(AccessControlCheckInManual::getAccessControlCheckinByEmployeeDateHour($sEmployee, $sDate, $nt_hour, $nt_min)) != 0);         
          }
          else {
             if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) return (count(AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDate($sEmployee, $sDate)) != 0);         
             else return (count(AccessControlCheckInManual::getAccessControlCheckinByEmployeeDate($sEmployee, $sDate)) != 0);
          }
       }
       else {
          $nt_hour = (int) FDate::getHour($sAfterHour);
          $nt_min = (int) FDate::getMinutes($sAfterHour);
          
          $nt_hour--;
          
          if ($sSourceData == FModuleAccessControlManagement::CHRONOGRAM_CHECKIN_SOURCE_DATA_VALUE_MACHINE) return (count(AccessControlCheckInMachine::getAccessControlCheckinByEmployeeDateHour($sEmployee, $sDate, $nt_hour, $nt_min)) != 0);  
          else return (count(AccessControlCheckInManual::getAccessControlCheckinByEmployeeDateHour($sEmployee, $sDate, $nt_hour, $nt_min)) != 0);   
       }
    }
    
    private function updateCheckinDatabase() {
       FModuleAccessControlManagement::synchronizeCheckins();
    }
}