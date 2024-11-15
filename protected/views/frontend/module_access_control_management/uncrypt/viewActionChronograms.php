<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/action_chronograms.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_ACTION_CHRONOGRAMS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWACTIONCHRONOGRAMS_DESCRIPTION'); ?>
</div>

<?php
$oCalendar = $oModelCalendar->getObject();
$sJsParameters = 'function createUrlParameters(employee) {
                    var sEmployee = "&employee=";
                    if (employee == undefined) sEmployee += document.getElementById("AccessControlChronogramActionForm_employee").value;
                    else sEmployee += employee;
                    
                    var sDate = "&date=' . $oCalendar->year . '-' . $oCalendar->month . '";
                    
                    return sEmployee + sDate;
                 };';
?>

<?php
   $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id);
   
   if ((!is_null($oEmployee)) && (!Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT))) {
      if (is_null($oModelForm->employee)) { ?>
         <script type="text/javascript">
            <?php echo $sJsParameters; ?>
            
            <?php echo 'window.location.href = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/uncrypt/viewActionChronograms') . '\' + createUrlParameters(\'' . $oEmployee->identification . '\');'; ?> 
         </script>
      <?php }
   }
?>

<div class="form">
   <?php $formActionChronogram = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-actionchronogram-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/uncrypt/viewActionChronograms'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_element"> 
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formActionChronogram->labelEx($oModelForm, 'employee', array('style'=>'width:300px;')); ?>

               <?php if ((!is_null($oEmployee)) && (!Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT))) {
                        echo $formActionChronogram->dropDownList($oModelForm, 'employee', CHtml::listData(array($oEmployee), 'identification', 'full_name'), array('style'=>'width:300px;'));   
                     }
                     else {
                        echo $formActionChronogram->dropDownList($oModelForm, 'employee', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT)), 'identification', 'full_name'), array('id'=>'AccessControlChronogramActionForm_employee', 'empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/uncrypt/viewActionChronograms') . '\' + createUrlParameters()'));
                     } ?>
                     
               <?php echo $formActionChronogram->error($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>     
   </div>
   
   <div class="form_element">
      <?php echo $oModelCalendar->show(); ?>
   </div>
   
   <?php echo $formActionChronogram->hiddenField($oModelForm, 'action', array('style'=>'width:180px;')); ?>
   
   <?php if (strlen($oModelForm->employee) > 0) { ?>
      <?php $nCurrentYear = ((int) date('Y')) - ((FApplication::FORM_COMBOBOX_MAX_YEARS - 1)/2);
            $oPrintDates = array();
            for ($i = 0; $i < FApplication::FORM_COMBOBOX_MAX_YEARS; $i++) {
               $oPrintDates[$nCurrentYear + $i] = $nCurrentYear + $i;    
            } 
            ?>
            
      <div class="form_expand_collapse" >
         <div id="id_form_print_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_print_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_print_content_expand_collapse');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWACTIONCHRONOGRAMS_FORM_PRINT_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
      
      <div id="id_form_print_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWACTIONCHRONOGRAMS_FORM_PRINT_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formActionChronogram->labelEx($oModelForm, 'datePrint', array('style'=>'width:133px;')); ?>
                  <?php echo $formActionChronogram->dropDownList($oModelForm, 'datePrint', $oPrintDates, array('options'=>array(date('Y')=>array('selected'=>'selected')), 'style'=>'width:133px;')); ?>
                  <?php echo $formActionChronogram->error($oModelForm, 'datePrint', array('style'=>'width:133px;')); ?>       
               </div>
               <div class="last_cell">
                  <?php echo $formActionChronogram->labelEx($oModelForm, 'docFormat', array('style'=>'width:300px;')); ?>
                  <?php echo $formActionChronogram->dropDownList($oModelForm, 'docFormat', array(FFile::FILE_XLS_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL'), FFile::FILE_XLSX_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_EXCEL_2007'), FFile::FILE_PDF_TYPE=>Yii::t('system', 'SYS_DOCUMENT_FORMAT_PDF')), array('style'=>'width:300px;')); ?>
                  <?php echo $formActionChronogram->error($oModelForm, 'docFormat', array('style'=>'width:300px;')); ?>       
               </div>
            </div>                           
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_PRINT'), array('class'=>'form_button_submit', 'onclick'=>'document.getElementById(\'AccessControlChronogramActionForm_action\').value = \'' . FApplication::FORM_ACTION_PRINT . '\';')); ?>
         </div>     
      </div>
   <?php } ?>
   
   <?php $this->endWidget(); ?>
</div>