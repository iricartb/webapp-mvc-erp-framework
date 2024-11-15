<div class="form">
   <?php $formEmployee = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-employee-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateEmployee', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>                    
      <div class="form_content">          
         <div class="cell">
   <?php $bImageAttachment = false; 
         if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image))) { 
            $bImageAttachment = true; ?>
            <div class="rectangle_content">
               <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image; ?>" width="100px" height="100px" />
            </div>
    
   <?php } ?>
         </div>
         <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
            <div class="first_row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               </div>
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               </div>
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'num_employee', array('style'=>'width:180px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'start_date', array('style'=>'width:180px;')); ?>
                  <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'start_date', false, null, 'strtotime()', null, null, true, false, '180px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->start_date))); ?>
                  <?php echo $formEmployee->error($oModelForm, 'start_date', array('style'=>'width:180px;')); ?>      
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;', 'onchange'=>'document.getElementById(\'AccessControlEmployees_id_business\').value = this.value;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'sSearchBusiness', array('style'=>'width:100px;')); ?>   
               </div>
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'id_business', array('style'=>'width:480px;')); ?>
                  <?php echo $formEmployee->dropDownList($oModelForm, 'id_business', CHtml::listData(Businesses::getBusinesses(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:480px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'id_business', array('style'=>'width:480px;')); ?>   
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_process_delay', array('style'=>'width:185px;')); ?>
                  <?php echo $formEmployee->checkBox($oModelForm, 'access_process_delay', array('style'=>'width:20px;', 'checked'=>'checked', 'onclick'=>'jquerySimpleAnimationFadeAppearDisappearTableCell(\'#id_access_code_tolerance\', this.checked, 1.0, 1000)')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_process_delay', array('style'=>'width:185px;')); ?>
               </div>
               <div id="id_access_code_tolerance" class="last_cell_content_expand_collapse_show">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_tolerance', array('style'=>'width:180px;')); ?>
               </div>   
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'image', array('style'=>'width:400px;')); ?>
                  <?php echo $formEmployee->fileField($oModelForm, 'image', array('style'=>'width:400px;')); ?>      
                  <?php echo $formEmployee->error($oModelForm, 'image', array('style'=>'width:400px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'show_visual_presence', array('style'=>'width:185px;')); ?>
                  <?php echo $formEmployee->checkBox($oModelForm, 'show_visual_presence', array('style'=>'width:20px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'show_visual_presence', array('style'=>'width:185px;')); ?>
               </div>
            </div>
         </div>
      </div> 
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>