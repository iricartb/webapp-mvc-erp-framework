<div class="form">
   <?php $formFormWorkRequest = $this->beginWidget('CActiveForm', array(
      'id'=>'form-work-request-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/updateFormWorkRequest', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEFORMWORKREQUEST_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formFormWorkRequest->labelEx($oModelForm, 'priority', array('style'=>'width:300px;')); ?>
               <?php echo $formFormWorkRequest->dropDownList($oModelForm, 'priority', CHtml::listData(Priorities::getPriorities(), 'description', 'description'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formFormWorkRequest->error($oModelForm, 'priority', array('style'=>'width:300px;')); ?>    
            </div>
            <div class="last_cell">
               <?php echo $formFormWorkRequest->labelEx($oModelForm, 'visible_date', array('style'=>'width:300px;')); ?>
               <?php 
               if (!FString::isNullOrEmpty($oModelForm->visible_date)) {
                  $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'visible_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '140px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->visible_date))); 
               }
               else {
                  $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'visible_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '140px'));
               }
               ?>
               <?php echo $formFormWorkRequest->error($oModelForm, 'visible_date', array('style'=>'width:300px;')); ?>    
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
                <?php echo $formFormWorkRequest->labelEx($oModelForm, 'description', array('style'=>'width:630px;')); ?>
                <?php echo $formFormWorkRequest->textArea($oModelForm, 'description', array('style'=>'width:630px; height:60px; overflow:auto; resize:none')); ?>
                <?php echo $formFormWorkRequest->error($oModelForm, 'description', array('style'=>'width:630px;')); ?>     
            </div>
         </div>
         <?php
         if (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) { ?>
            <div class="row">
               <div class="last_cell">
                   <?php echo $formFormWorkRequest->labelEx($oModelForm, 'comments', array('style'=>'width:630px;')); ?>
                   <?php echo $formFormWorkRequest->textArea($oModelForm, 'comments', array('style'=>'width:630px; height:60px; overflow:auto; resize:none')); ?>
                   <?php echo $formFormWorkRequest->error($oModelForm, 'comments', array('style'=>'width:630px;')); ?>     
               </div>
            </div>
            <div class="row">
               <div class="last_cell">
                   <?php echo $formFormWorkRequest->labelEx($oModelForm, 'bFinalized', array('style'=>'width:200px;')); ?>
                   <?php echo $formFormWorkRequest->checkBox($oModelForm, 'bFinalized', array('style'=>'width:20px;')); ?>
                   <?php echo $formFormWorkRequest->error($oModelForm, 'bFinalized', array('style'=>'width:200px;')); ?>     
               </div>
            </div>
         <?php
         }
         ?>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>