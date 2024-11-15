<?php

class UncryptController extends FrontendController {
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('viewActionChronograms'),
                'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)',
            ),
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('viewChronograms'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewActionChronograms($employee = FString::STRING_EMPTY, $date = FString::STRING_EMPTY) {
       $oAccessControlChronogramActionForm = new AccessControlChronogramActionForm();
       $sCalendarMonth = null;
       $sCalendarYear = null;
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-actionchronogram-form', $oAccessControlChronogramActionForm);
        
       if ($date == FString::STRING_EMPTY) {
          $sCalendarYear = date("Y");
          $sCalendarMonth = date("m");
       }
       else {
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
       
       if ((!is_null($sCalendarYear)) && (!is_null($sCalendarMonth))) {
          if ((isset($_POST['AccessControlChronogramActionForm'])) && (strlen($_POST['AccessControlChronogramActionForm']['employee']) > 0)) {
             $employee = $_POST['AccessControlChronogramActionForm']['employee'];  
          }
          
          $oCalendar = new FWidgetCalendar(FWidgetCalendar::CALENDAR_TYPE_FULL, FString::getFirstToken(Yii::app()->request->getUrl(), '&') . '&employee=' . $employee);
          
          if (isset($_POST['AccessControlChronogramActionForm'])) {
             if ($_POST['AccessControlChronogramActionForm']['action'] == FApplication::FORM_ACTION_PRINT) {
                $sFilename = Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHRONOGRAM_NAME');
                $oPHPExcel = $this->reportExcelChronogram($sFilename, $_POST['AccessControlChronogramActionForm']['employee'], (int) $_POST['AccessControlChronogramActionForm']['datePrint'], $_POST['AccessControlChronogramActionForm']['docFormat']);
              
                $this->render('/generic/report', array('oDocument'=>$oPHPExcel, 'sFilename'=>$sFilename, 'sExport'=>$_POST['AccessControlChronogramActionForm']['docFormat']));   
             }
          }
          
          if ($employee != FString::STRING_EMPTY) {
             $oAccessControlChronogramActionForm->employee = $employee;
             
             // Show working, vacations and absence days
             $oAbsencePersonalChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERSONAL, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsencePersonalChronograms as $absencePersonal) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL'), $absencePersonal->date, $absencePersonal->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERSONAL);    
             }
             
             $oAbsenceTemporaryDisabilityChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsenceTemporaryDisabilityChronograms as $absenceTemporaryDisability) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY_ABBREVIATION'), $absenceTemporaryDisability->date, $absenceTemporaryDisability->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_TEMPORARY_DISABILITY);    
             }
             
             $oAbsencePermissionChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERMISSION, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsencePermissionChronograms as $absencePermission) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION'), $absencePermission->date, $absencePermission->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERMISSION);    
             }
             
             $oAbsenceLeaveChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_LEAVE, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsenceLeaveChronograms as $absenceLeave) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE'), $absenceLeave->date, $absenceLeave->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_LEAVE);    
             }
             
             $oVacationChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_VACATION, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oVacationChronograms as $vacation) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION'), $vacation->date, $vacation->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_VACATION);    
             }
             
             $oWorkingChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oWorkingChronograms as $working) {
                $sDetail = FString::castStrToCapitalLetters($working->timetable_name) . '<br/>' . $working->timetable_hour1_t1 . '-' . $working->timetable_hour2_t1;
                if ($working->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT) $sDetail .= '<br/>' . $working->timetable_hour1_t2 . '-' . $working->timetable_hour2_t2;
                
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING') . ' (' . $working->timetable_abbreviation . ')', $working->date, $working->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_WORKING, $sDetail);    
             }
             
             $oPauseChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oPauseChronograms as $pause) {
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE'), $pause->date, $pause->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_PAUSE);    
             }
          }
          
          $oHolidayChronograms = AccessControlChronograms::getAccessControlHolidayChronogramsByYearMonth($sCalendarYear, $sCalendarMonth);
          foreach ($oHolidayChronograms as $holiday) {
             $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY'), $holiday->date, $holiday->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_HOLIDAY);    
          }
          
          $this->render('viewActionChronograms', array('oModelForm'=>$oAccessControlChronogramActionForm, 'oModelCalendar'=>$oCalendar));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionViewChronograms($employee = FString::STRING_EMPTY, $date = FString::STRING_EMPTY) {
       $oAccessControlChronogramForm = new AccessControlChronogramForm();
       $oEmployee = null;
       $sCalendarMonth = null;
       $sCalendarYear = null;
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-chronogram-form', $oAccessControlChronogramForm);
        
       if ($employee != FString::STRING_EMPTY) $oEmployee = Employees::getEmployeeWithAccessCodeByIdentification($employee);
       
       if ($date == FString::STRING_EMPTY) {
          $sCalendarYear = date("Y");
          $sCalendarMonth = date("m");
       }
       else {
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
       
       if ((($employee == FString::STRING_EMPTY) || ($employee != FString::STRING_EMPTY) && (!is_null($oEmployee))) && ((!is_null($sCalendarYear)) && (!is_null($sCalendarMonth)))) {
          if ((isset($_POST['AccessControlChronogramForm'])) && (strlen($_POST['AccessControlChronogramForm']['employee']) > 0)) {
             $employee = $_POST['AccessControlChronogramForm']['employee'];  
          }
          
          $oCalendar = new FWidgetCalendar(FWidgetCalendar::CALENDAR_TYPE_FULL, FString::getFirstToken(Yii::app()->request->getUrl(), '&') . '&employee=' . $employee);
          
          // Insert or Delete values to database 
          if (isset($_POST['AccessControlChronogramForm'])) {      
             if ($_POST['AccessControlChronogramForm']['action'] == FApplication::FORM_ACTION_SAVE) {
               if (strlen($_POST['AccessControlChronogramForm']['endDateAdd']) > 0) $nDateDiffDays = FDate::getDiffDays(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateAdd']), FDate::getEnglishDate($_POST['AccessControlChronogramForm']['endDateAdd']));
               else $nDateDiffDays = 0;
             
                if ($_POST['AccessControlChronogramForm']['typeAdd'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY) {
                   for ($i = 0; $i <= $nDateDiffDays; $i++) {
                      $sDate = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateAdd']) . '+' . $i . ' days'));
                      if (is_null(AccessControlChronograms::getAccessControlHolidayChronogramByDate($sDate))) { 
                         $oAccessControlChronogram = new AccessControlChronograms();
                       
                         $oAccessControlChronogram->date = $sDate;
                         $oAccessControlChronogram->type = FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY;
                         
                         $oAccessControlChronogram->save();
                      }   
                   } 
                }
                else {
                   $oEmployee = Employees::getEmployeeByIdentification($_POST['AccessControlChronogramForm']['employee']);
                   
                   for ($i = 0; $i <= $nDateDiffDays; $i++) {
                      $sDate = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateAdd']) . '+' . $i . ' days'));
                      if (is_null(AccessControlChronograms::getAccessControlChronogramByEmployeeDate($_POST['AccessControlChronogramForm']['typeAdd'], $_POST['AccessControlChronogramForm']['employee'], $sDate))) { 
                         if (($_POST['AccessControlChronogramForm']['typeAdd'] != FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) && ($_POST['AccessControlChronogramForm']['typeAdd'] != FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE)) {
                            // Search types to delete
                            $oCronograms = AccessControlChronograms::getAccessControlAbsenceChronogramsByEmployeeDate($_POST['AccessControlChronogramForm']['employee'], $sDate);   
                            
                            foreach ($oCronograms as $absenceChronogram) $absenceChronogram->delete(); 
                         }
                         else if ($_POST['AccessControlChronogramForm']['typeAdd'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
                           // Search and delete pause type
                           $oPauseChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $_POST['AccessControlChronogramForm']['employee'], $sDate);   
                           if (!is_null($oPauseChronogram)) $oPauseChronogram->delete();
                         }
                         else if ($_POST['AccessControlChronogramForm']['typeAdd'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE) {
                           // Search and delete working type
                           $oWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $_POST['AccessControlChronogramForm']['employee'], $sDate);   
                           if (!is_null($oWorkingChronogram)) $oWorkingChronogram->delete();
                         }
                         
                         $oAccessControlChronogram = new AccessControlChronograms();
                         $oAccessControlChronogram->date = $sDate;
                         $oAccessControlChronogram->employee_identification = $_POST['AccessControlChronogramForm']['employee'];
                         $oAccessControlChronogram->type = $_POST['AccessControlChronogramForm']['typeAdd'];
                         if (!is_null($oEmployee)) { 
                            $oAccessControlChronogram->employee_tolerance = $oEmployee->access_tolerance;
                            $oAccessControlChronogram->employee_process_delay = $oEmployee->access_process_delay;
                         }
                         
                         if ($_POST['AccessControlChronogramForm']['typeAdd'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
                            $oAccessControlTimetable = AccessControlTimetables::getAccessControlTimetable($_POST['AccessControlChronogramForm']['timetableAdd']);
                            
                            if (!is_null($oAccessControlTimetable)) {
                               $oAccessControlChronogram->timetable_name = $oAccessControlTimetable->name;
                               $oAccessControlChronogram->timetable_abbreviation = $oAccessControlTimetable->abbreviation;
                               $oAccessControlChronogram->timetable_type = $oAccessControlTimetable->type;
                               $oAccessControlChronogram->timetable_hour1_t1 = $oAccessControlTimetable->hour1_t1;
                               $oAccessControlChronogram->timetable_hour2_t1 = $oAccessControlTimetable->hour2_t1;
                               $oAccessControlChronogram->timetable_hour1_t2 = $oAccessControlTimetable->hour1_t2;
                               $oAccessControlChronogram->timetable_hour2_t2 = $oAccessControlTimetable->hour2_t2;
                               $oAccessControlChronogram->timetable_tolerance = $oAccessControlTimetable->tolerance;        
                            }        
                         } 
                         
                         $oAccessControlChronogram->save();
                      }
                      else if ($_POST['AccessControlChronogramForm']['typeAdd'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
                         $oAccessControlChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate($_POST['AccessControlChronogramForm']['typeAdd'], $_POST['AccessControlChronogramForm']['employee'], $sDate);
                         
                         if (!is_null($oEmployee)) {
                            $oAccessControlChronogram->employee_tolerance = $oEmployee->access_tolerance;
                            $oAccessControlChronogram->employee_process_delay = $oEmployee->access_process_delay;
                         }
                         
                         $oAccessControlTimetable = AccessControlTimetables::getAccessControlTimetable($_POST['AccessControlChronogramForm']['timetableAdd']);
                         
                         if (!is_null($oAccessControlTimetable)) {
                            $oAccessControlChronogram->timetable_name = $oAccessControlTimetable->name;
                            $oAccessControlChronogram->timetable_abbreviation = $oAccessControlTimetable->abbreviation;
                            $oAccessControlChronogram->timetable_type = $oAccessControlTimetable->type;
                            $oAccessControlChronogram->timetable_hour1_t1 = $oAccessControlTimetable->hour1_t1;
                            $oAccessControlChronogram->timetable_hour2_t1 = $oAccessControlTimetable->hour2_t1;
                            $oAccessControlChronogram->timetable_hour1_t2 = $oAccessControlTimetable->hour1_t2;
                            $oAccessControlChronogram->timetable_hour2_t2 = $oAccessControlTimetable->hour2_t2;
                            $oAccessControlChronogram->timetable_tolerance = $oAccessControlTimetable->tolerance;        
                         }
                            
                         $oAccessControlChronogram->save();  
                      }   
                   }    
                } 
             }
             else if ($_POST['AccessControlChronogramForm']['action'] == FApplication::FORM_ACTION_DELETE) {
                if (strlen($_POST['AccessControlChronogramForm']['endDateDel']) > 0) $nDateDiffDays = FDate::getDiffDays(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateDel']), FDate::getEnglishDate($_POST['AccessControlChronogramForm']['endDateDel']));
                else $nDateDiffDays = 0;
               
                if ($_POST['AccessControlChronogramForm']['typeDel'] == FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY) {
                   for ($i = 0; $i <= $nDateDiffDays; $i++) {
                      $sDate = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateDel']) . '+' . $i . ' days'));
                      $oAccessControlChronogram = AccessControlChronograms::getAccessControlHolidayChronogramByDate($sDate);
                      
                      if (!is_null($oAccessControlChronogram)) $oAccessControlChronogram->delete();   
                   } 
                }
                else {
                   for ($i = 0; $i <= $nDateDiffDays; $i++) {
                      $sDate = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateDel']) . '+' . $i . ' days'));
                      $oAccessControlChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate($_POST['AccessControlChronogramForm']['typeDel'], $_POST['AccessControlChronogramForm']['employee'], $sDate);
                      
                      if (!is_null($oAccessControlChronogram)) $oAccessControlChronogram->delete();   
                   }  
                }
             }
             else if ($_POST['AccessControlChronogramForm']['action'] == FApplication::FORM_ACTION_COPY_PASTE) {
                if (strlen($_POST['AccessControlChronogramForm']['endDateCopy']) > 0) $nDateDiffDays = FDate::getDiffDays(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateCopy']), FDate::getEnglishDate($_POST['AccessControlChronogramForm']['endDateCopy']));
                else $nDateDiffDays = 0;
                
                if (strlen($_POST['AccessControlChronogramForm']['endDatePaste']) > 0) $nDateDiffDaysPaste = FDate::getDiffDays(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDatePaste']), FDate::getEnglishDate($_POST['AccessControlChronogramForm']['endDatePaste']));
                else $nDateDiffDaysPaste = 0;
                
                for ($i = 0; $i <= $nDateDiffDaysPaste; $i++) {
                   $bCopyWorking = true;
                   $bPasteWorking = true;
                   $sDateCopy = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateCopy']) . '+' . ($i % ($nDateDiffDays + 1)) . ' days'));
                   $sDatePaste = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDatePaste']) . '+' . $i . ' days'));
                   
                   $oAccessControlChronogramCopy = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $_POST['AccessControlChronogramForm']['employee'], $sDateCopy);
                   if (is_null($oAccessControlChronogramCopy)) {
                      $oAccessControlChronogramCopy = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $_POST['AccessControlChronogramForm']['employee'], $sDateCopy);
                      $bCopyWorking = false;      
                   }
                    
                   $oAccessControlChronogramPaste = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $_POST['AccessControlChronogramForm']['employee'], $sDatePaste);
                   if (is_null($oAccessControlChronogramPaste)) {
                      $oAccessControlChronogramPaste = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $_POST['AccessControlChronogramForm']['employee'], $sDatePaste);
                      $bPasteWorking = false;
                   }
                      
                   if ((!is_null($oAccessControlChronogramPaste)) && (!is_null($oAccessControlChronogramCopy))) {
                      if ($bCopyWorking) {
                         if (!$bPasteWorking) {
                            $oAccessControlChronogramPaste->delete();
                            $oAccessControlChronogramPaste = new AccessControlChronograms();      
                         }
                      
                         $oAccessControlChronogramPaste->date = $sDatePaste;
                         $oAccessControlChronogramPaste->employee_identification = $oAccessControlChronogramCopy->employee_identification;
                         $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                         $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                         $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                            
                         $oAccessControlChronogramPaste->timetable_name = $oAccessControlChronogramCopy->timetable_name;
                         $oAccessControlChronogramPaste->timetable_abbreviation = $oAccessControlChronogramCopy->timetable_abbreviation;
                         $oAccessControlChronogramPaste->timetable_type = $oAccessControlChronogramCopy->timetable_type;
                         $oAccessControlChronogramPaste->timetable_hour1_t1 = $oAccessControlChronogramCopy->timetable_hour1_t1;
                         $oAccessControlChronogramPaste->timetable_hour2_t1 = $oAccessControlChronogramCopy->timetable_hour2_t1;
                         $oAccessControlChronogramPaste->timetable_hour1_t2 = $oAccessControlChronogramCopy->timetable_hour1_t2;
                         $oAccessControlChronogramPaste->timetable_hour2_t2 = $oAccessControlChronogramCopy->timetable_hour2_t2;
                         $oAccessControlChronogramPaste->timetable_tolerance = $oAccessControlChronogramCopy->timetable_tolerance;                
                      }
                      else {
                         if ($bPasteWorking) {
                            $oAccessControlChronogramPaste->delete();
                            $oAccessControlChronogramPaste = new AccessControlChronograms();   
                         }
                         
                         $oAccessControlChronogramPaste->date = $sDatePaste;
                         $oAccessControlChronogramPaste->employee_identification = $oAccessControlChronogramCopy->employee_identification;
                         $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                         $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                         $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                      }   
                      $oAccessControlChronogramPaste->save();   
                   }
                   else if ((!is_null($oAccessControlChronogramPaste)) && (is_null($oAccessControlChronogramCopy))) {
                      $oAccessControlChronogramPaste->delete();   
                   } 
                   else if ((is_null($oAccessControlChronogramPaste)) && (!is_null($oAccessControlChronogramCopy))) {
                      $oAccessControlChronogramPaste = new AccessControlChronograms();
                       
                      $oAccessControlChronogramPaste->date = $sDatePaste;
                      $oAccessControlChronogramPaste->employee_identification = $oAccessControlChronogramCopy->employee_identification;
                      $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                      $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                      $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                      
                      if ($bCopyWorking) {   
                         $oAccessControlChronogramPaste->timetable_name = $oAccessControlChronogramCopy->timetable_name;
                         $oAccessControlChronogramPaste->timetable_abbreviation = $oAccessControlChronogramCopy->timetable_abbreviation;
                         $oAccessControlChronogramPaste->timetable_type = $oAccessControlChronogramCopy->timetable_type;
                         $oAccessControlChronogramPaste->timetable_hour1_t1 = $oAccessControlChronogramCopy->timetable_hour1_t1;
                         $oAccessControlChronogramPaste->timetable_hour2_t1 = $oAccessControlChronogramCopy->timetable_hour2_t1;
                         $oAccessControlChronogramPaste->timetable_hour1_t2 = $oAccessControlChronogramCopy->timetable_hour1_t2;
                         $oAccessControlChronogramPaste->timetable_hour2_t2 = $oAccessControlChronogramCopy->timetable_hour2_t2;
                         $oAccessControlChronogramPaste->timetable_tolerance = $oAccessControlChronogramCopy->timetable_tolerance;                
                      }
                         
                      $oAccessControlChronogramPaste->save(); 
                   }
                }   
             }
             else if ($_POST['AccessControlChronogramForm']['action'] == FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM) {
                if (strlen($_POST['AccessControlChronogramForm']['endDateCopyChronogram']) > 0) $nDateDiffDays = FDate::getDiffDays(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateCopyChronogram']), FDate::getEnglishDate($_POST['AccessControlChronogramForm']['endDateCopyChronogram']));
                else $nDateDiffDays = 0;

                for ($i = 0; $i <= $nDateDiffDays; $i++) {
                   $bCopyWorking = true;
                   $bPasteWorking = true;
                   $sDate = date('Y-m-d', strtotime(FDate::getEnglishDate($_POST['AccessControlChronogramForm']['startDateCopyChronogram']) . '+' . $i . ' days'));
                   
                   $oAccessControlChronogramCopy = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $_POST['AccessControlChronogramForm']['employeeCopyChronogram'], $sDate);
                   if (is_null($oAccessControlChronogramCopy)) {
                      $oAccessControlChronogramCopy = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $_POST['AccessControlChronogramForm']['employeeCopyChronogram'], $sDate);
                      $bCopyWorking = false;      
                   }
                    
                   $oAccessControlChronogramPaste = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $_POST['AccessControlChronogramForm']['employee'], $sDate);
                   if (is_null($oAccessControlChronogramPaste)) {
                      $oAccessControlChronogramPaste = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $_POST['AccessControlChronogramForm']['employee'], $sDate);
                      $bPasteWorking = false;
                   }
                   
                   if ((!is_null($oAccessControlChronogramPaste)) && (!is_null($oAccessControlChronogramCopy))) {
                      if ($bCopyWorking) {
                         if (!$bPasteWorking) {
                            $oAccessControlChronogramPaste->delete();
                            $oAccessControlChronogramPaste = new AccessControlChronograms();      
                         }
                      
                         $oAccessControlChronogramPaste->date = $sDate;
                         $oAccessControlChronogramPaste->employee_identification = $_POST['AccessControlChronogramForm']['employee'];
                         $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                         $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                         $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                            
                         $oAccessControlChronogramPaste->timetable_name = $oAccessControlChronogramCopy->timetable_name;
                         $oAccessControlChronogramPaste->timetable_abbreviation = $oAccessControlChronogramCopy->timetable_abbreviation;
                         $oAccessControlChronogramPaste->timetable_type = $oAccessControlChronogramCopy->timetable_type;
                         $oAccessControlChronogramPaste->timetable_hour1_t1 = $oAccessControlChronogramCopy->timetable_hour1_t1;
                         $oAccessControlChronogramPaste->timetable_hour2_t1 = $oAccessControlChronogramCopy->timetable_hour2_t1;
                         $oAccessControlChronogramPaste->timetable_hour1_t2 = $oAccessControlChronogramCopy->timetable_hour1_t2;
                         $oAccessControlChronogramPaste->timetable_hour2_t2 = $oAccessControlChronogramCopy->timetable_hour2_t2;
                         $oAccessControlChronogramPaste->timetable_tolerance = $oAccessControlChronogramCopy->timetable_tolerance;                
                      }
                      else {
                         if ($bPasteWorking) {
                            $oAccessControlChronogramPaste->delete();
                            $oAccessControlChronogramPaste = new AccessControlChronograms();   
                         }
                         
                         $oAccessControlChronogramPaste->date = $sDate;
                         $oAccessControlChronogramPaste->employee_identification = $_POST['AccessControlChronogramForm']['employee'];
                         $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                         $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                         $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                      }   
                      $oAccessControlChronogramPaste->save();   
                   }
                   else if ((!is_null($oAccessControlChronogramPaste)) && (is_null($oAccessControlChronogramCopy))) {
                      $oAccessControlChronogramPaste->delete();   
                   } 
                   else if ((is_null($oAccessControlChronogramPaste)) && (!is_null($oAccessControlChronogramCopy))) {
                      $oAccessControlChronogramPaste = new AccessControlChronograms();
                       
                      $oAccessControlChronogramPaste->date = $sDate;
                      $oAccessControlChronogramPaste->employee_identification = $_POST['AccessControlChronogramForm']['employee'];
                      $oAccessControlChronogramPaste->type = $oAccessControlChronogramCopy->type;
                      $oAccessControlChronogramPaste->employee_tolerance = $oAccessControlChronogramCopy->employee_tolerance;
                      $oAccessControlChronogramPaste->employee_process_delay = $oAccessControlChronogramCopy->employee_process_delay;
                                                              
                      if ($bCopyWorking) {   
                         $oAccessControlChronogramPaste->timetable_name = $oAccessControlChronogramCopy->timetable_name;
                         $oAccessControlChronogramPaste->timetable_abbreviation = $oAccessControlChronogramCopy->timetable_abbreviation;
                         $oAccessControlChronogramPaste->timetable_type = $oAccessControlChronogramCopy->timetable_type;
                         $oAccessControlChronogramPaste->timetable_hour1_t1 = $oAccessControlChronogramCopy->timetable_hour1_t1;
                         $oAccessControlChronogramPaste->timetable_hour2_t1 = $oAccessControlChronogramCopy->timetable_hour2_t1;
                         $oAccessControlChronogramPaste->timetable_hour1_t2 = $oAccessControlChronogramCopy->timetable_hour1_t2;
                         $oAccessControlChronogramPaste->timetable_hour2_t2 = $oAccessControlChronogramCopy->timetable_hour2_t2;
                         $oAccessControlChronogramPaste->timetable_tolerance = $oAccessControlChronogramCopy->timetable_tolerance;                
                      }
                         
                      $oAccessControlChronogramPaste->save(); 
                   }
                } 
             } 
          }
  
          if ($employee != FString::STRING_EMPTY) {
             $oAccessControlChronogramForm->employee = $employee;
             
             // Show working, vacations and absence days
             $oAbsencePersonalChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERSONAL, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsencePersonalChronograms as $absencePersonal) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL'), $absencePersonal->date, $absencePersonal->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERSONAL);    
             }
             
             $oAbsenceTemporaryDisabilityChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsenceTemporaryDisabilityChronograms as $absenceTemporaryDisability) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY_ABBREVIATION'), $absenceTemporaryDisability->date, $absenceTemporaryDisability->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_TEMPORARY_DISABILITY);    
             }
             
             $oAbsencePermissionChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERMISSION, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsencePermissionChronograms as $absencePermission) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION'), $absencePermission->date, $absencePermission->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERMISSION);    
             }
             
             $oAbsenceLeaveChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_LEAVE, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oAbsenceLeaveChronograms as $absenceLeave) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE'), $absenceLeave->date, $absenceLeave->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_LEAVE);    
             }
             
             $oVacationChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_VACATION, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oVacationChronograms as $vacation) {                                          
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION'), $vacation->date, $vacation->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_VACATION);    
             }
             
             $oWorkingChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oWorkingChronograms as $working) {
                $sDetail = FString::castStrToCapitalLetters($working->timetable_name) . '<br/>' . $working->timetable_hour1_t1 . '-' . $working->timetable_hour2_t1;
                if ($working->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT) $sDetail .= '<br/>' . $working->timetable_hour1_t2 . '-' . $working->timetable_hour2_t2;
                
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING') . ' (' . $working->timetable_abbreviation . ')', $working->date, $working->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_WORKING, $sDetail);    
             }
             
             $oPauseChronograms = AccessControlChronograms::getAccessControlChronogramsByEmployeeYearMonth(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $employee, $sCalendarYear, $sCalendarMonth);
             foreach ($oPauseChronograms as $pause) {
                $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE'), $pause->date, $pause->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_PAUSE);    
             }
          }
          
          $oHolidayChronograms = AccessControlChronograms::getAccessControlHolidayChronogramsByYearMonth($sCalendarYear, $sCalendarMonth);
          foreach ($oHolidayChronograms as $holiday) {
             $oCalendar->addEvent(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY'), $holiday->date, $holiday->date, FModuleAccessControlManagement::CHRONOGRAM_COLOR_HOLIDAY);    
          }
          
          $this->render('viewChronograms', array('oModelForm'=>$oAccessControlChronogramForm, 'oModelCalendar'=>$oCalendar));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));        
    }
    
    
    private function reportExcelChronogram($sFilename, $sEmployee, $nYear, $sDocFormat) {
       $oPHPExcel = FReportExcel::getInstance($sFilename, Yii::app()->user->name);
       
       for ($nMonth = 1; $nMonth <= 12; $nMonth++) {
          $this->reportExcelChronogramByEmployeeDate($oPHPExcel, $sEmployee, $nYear, $nMonth, $sDocFormat);
       }
       
       $oPHPExcel->setActiveSheetIndex(0);
       return $oPHPExcel;   
    }
    private function reportExcelChronogramByEmployeeDate($oPHPExcel, $sEmployee, $nYear, $nMonth, $sDocFormat) {
       FReportExcel::addSheet($oPHPExcel, FDate::getMonthName($nMonth));
       $bDocIsPDF = ($sDocFormat == FFile::FILE_PDF_TYPE);
       if ($bDocIsPDF) $nFontSize = 8;
       else $nFontSize = 10;
       
       $nTotalDays = FDate::getNumDays($nYear, $nMonth);
       $nStartIndex = date('w', strtotime($nYear . '-' . $nMonth . '-01'));
       if ($nStartIndex == 0) $nStartIndex = 7;
       $nStartIndex--;
       
       $oPHPExcelActiveSheet = $oPHPExcel->getActiveSheet();
       FReportExcel::setHorizontalMargin($oPHPExcel, 1.5, 1.5);
       $oPHPExcelActiveSheet->getStyle('A:G')->getFont()->setSize($nFontSize);
       $oPHPExcelActiveSheet->setShowGridlines(!$bDocIsPDF);
       
       // Header employee
       $nRow = 1;

       $oEmployee = Employees::getEmployeeByIdentification($sEmployee);
       $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'E' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHRONOGRAM_TOP_HEADER_EMPLOYEE') . ':');
       $oPHPExcelActiveSheet->getStyle('D' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'G' . $nRow);
       if (!is_null($oEmployee)) {
          $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, FString::STRING_SPACE . $oEmployee->full_name);
          $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);     
       }
       $nRow++;
       
       $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'E' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHRONOGRAM_TOP_HEADER_DEPARTMENT') . ':');
       $oPHPExcelActiveSheet->getStyle('D' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'G' . $nRow);
       if (!is_null($oEmployee)) {
          $sDepartment = FString::STRING_EMPTY;
          $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
          if (count($oEmployeeDepartments) > 0) {
             if (strlen($oEmployeeDepartments[0]->responsability) > 0) $sDepartment = Yii::t('rainbow', 'MODEL_TYPE_RESPONSABILITY_FIELD_NAME_VALUE_' . $oEmployeeDepartments[0]->responsability) . FString::STRING_SPACE . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartments[0]->department);   
             else $sDepartment = Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oEmployeeDepartments[0]->department);    
          }
          
          $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, FString::STRING_SPACE . $sDepartment);
          $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
       }
       $nRow++;
       
       $oPHPExcelActiveSheet->mergeCells('D' . $nRow . ':' . 'E' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHRONOGRAM_TOP_HEADER_DATE') . ':');
       $oPHPExcelActiveSheet->getStyle('D' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       
       $oPHPExcelActiveSheet->mergeCells('F' . $nRow . ':' . 'G' . $nRow);
       $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, FString::STRING_SPACE . ucwords(FDate::getMonthName($nMonth) . FString::STRING_SPACE . $nYear));
       $oPHPExcelActiveSheet->getStyle('F' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
       $nRow += 3; 

       // Header title
       $oPHPExcelActiveSheet->mergeCells('A' . $nRow . ':' . 'G' . ($nRow + 1));
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, strtoupper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'REPORT_CHRONOGRAM_NAME') . FString::STRING_SPACE . FDate::getMonthName($nMonth) . FString::STRING_SPACE . $nYear));
       $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
       if ($bDocIsPDF) $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setSize(12);
       else $oPHPExcelActiveSheet->getStyle('A' . $nRow)->getFont()->setSize(16);
       $nRow += 3;
       
       if ($bDocIsPDF) {
          $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(16);
          $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(16);
       }
       else {
          $oPHPExcelActiveSheet->getColumnDimension('A')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('B')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('C')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('D')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('E')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('F')->setWidth(13.3);
          $oPHPExcelActiveSheet->getColumnDimension('G')->setWidth(13.3);
       }
       
       if (($nStartIndex == 0) && (($nTotalDays % 7) == 0)) $nLimitRow = $nRow + 25;
       else if (($nStartIndex + $nTotalDays) > 35) $nLimitRow = $nRow + 37;
       else $nLimitRow = $nRow + 31;
       
       for($i = ($nRow + 1); $i < $nLimitRow; $i++) $oPHPExcelActiveSheet->getRowDimension($i)->setRowHeight(15);
    
       $oPHPExcelActiveSheet->SetCellValue('A' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_MONDAY')));
       $oPHPExcelActiveSheet->SetCellValue('B' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_TUESDAY')));
       $oPHPExcelActiveSheet->SetCellValue('C' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_WEDNESDAY')));
       $oPHPExcelActiveSheet->SetCellValue('D' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_THURSDAY')));
       $oPHPExcelActiveSheet->SetCellValue('E' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_FRIDAY')));
       $oPHPExcelActiveSheet->SetCellValue('F' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_SATURDAY')));
       $oPHPExcelActiveSheet->SetCellValue('G' . $nRow, ucwords(Yii::t('system', 'SYS_DAY_SUNDAY')));
       $oPHPExcelActiveSheet->getStyle('A' . $nRow . ':G' . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'G', FReportExcel::BORDER_STYLE_SOLID_ALL);
       
       FReportExcel::setBorderByRange($oPHPExcel, $nRow, 'A', $nRow, 'G'); 
       $nRow++;
       
       for($i = 0; ($i < $nStartIndex); $i++) {
          $nColumn = (ord('A') + ($i % 7));
          $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nRow . ':' . chr($nColumn) . ($nRow + 5))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'EEEEEE'))); 
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, chr($nColumn), ($nRow+5), chr($nColumn), true);
       }
       
       for($i = $nStartIndex; ($i < ($nTotalDays + $nStartIndex)); $i++) {
          $nColumn = (ord('A') + ($i % 7));
          $sCurrentDate = $nYear . '-' . $nMonth . '-' . (($i - $nStartIndex) + 1);
          if ((($i % 7) == 0) && ($i != $nStartIndex)) $nRow+=6;
          $nTmpRow = $nRow + 1;

          $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nRow, ($i - $nStartIndex) + 1);
          $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
          $oHolidayChronogram = AccessControlChronograms::getAccessControlHolidayChronogramByDate($sCurrentDate);
          if (!is_null($oHolidayChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_HOLIDAY')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_HOLIDAY, '#')))); 
             $nTmpRow++;
          }
          
          $oWorkingChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING, $sEmployee, $sCurrentDate);
          if (!is_null($oWorkingChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_WORKING') . ' (' . $oWorkingChronogram->timetable_abbreviation . ')'); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_WORKING, '#')))); 
             $nTmpRow++;
             
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, $oWorkingChronogram->timetable_hour1_t1 . '-' . $oWorkingChronogram->timetable_hour2_t1); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_WORKING, '#')))); 
             $nTmpRow++;
             
             if ($oWorkingChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT) {
                $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, $oWorkingChronogram->timetable_hour1_t2 . '-' . $oWorkingChronogram->timetable_hour2_t2); 
                $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_WORKING, '#')))); 
                $nTmpRow++;   
             }
          }
          
          $oPauseChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE, $sEmployee, $sCurrentDate);
          if (!is_null($oPauseChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_PAUSE')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_PAUSE, '#')))); 
             $nTmpRow++;  
          }   
          
          $oVacationChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_VACATION, $sEmployee, $sCurrentDate);
          if (!is_null($oVacationChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_VACATION')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_VACATION, '#')))); 
             $nTmpRow++; 
          }                                          
          
          $oAbsencePersonalChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERSONAL, $sEmployee, $sCurrentDate);
          if (!is_null($oAbsencePersonalChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERSONAL')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERSONAL, '#')))); 
             $nTmpRow++; 
          }
          
          $oAbsenceTemporaryDisabilityChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_TEMPORARY_DISABILITY, $sEmployee, $sCurrentDate);
          if (!is_null($oAbsenceTemporaryDisabilityChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_TEMPORARY_DISABILITY_ABBREVIATION')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_TEMPORARY_DISABILITY, '#')))); 
             $nTmpRow++; 
          }
          
          $oAbsencePermissionChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_PERMISSION, $sEmployee, $sCurrentDate);
          if (!is_null($oAbsencePermissionChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_PERMISSION')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_PERMISSION, '#')))); 
             $nTmpRow++; 
          }   
           
          $oAbsenceLeaveChronogram = AccessControlChronograms::getAccessControlChronogramByEmployeeDate(FModuleAccessControlManagement::TYPE_CHRONOGRAM_ABSENCE_LEAVE, $sEmployee, $sCurrentDate);
          if (!is_null($oAbsenceLeaveChronogram)) {
             $oPHPExcelActiveSheet->SetCellValue(chr($nColumn) . $nTmpRow, Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMS_FIELD_TYPE_VALUE_ABSENCE_LEAVE')); 
             $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nTmpRow)->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>FString::getLastToken(FModuleAccessControlManagement::CHRONOGRAM_COLOR_ABSENCE_LEAVE, '#')))); 
             $nTmpRow++; 
          }
          
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, chr($nColumn), ($nRow+5), chr($nColumn), true);         
       }
       
       for($i = $i; ($i % 7 != 0); $i++) {
          $nColumn = (ord('A') + ($i % 7));
          $oPHPExcelActiveSheet->getStyle(chr($nColumn) . $nRow . ':' . chr($nColumn) . ($nRow + 5))->getFill()->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'EEEEEE'))); 
          FReportExcel::setBorderByRange($oPHPExcel, $nRow, chr($nColumn), ($nRow+5), chr($nColumn), true);
       }
    }
}