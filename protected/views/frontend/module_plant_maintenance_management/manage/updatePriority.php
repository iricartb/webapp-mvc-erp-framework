<div class="form">
   <?php $formPriority = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-priority-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updatePriority', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEPRIORITY_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formPriority->labelEx($oModelForm, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formPriority->textField($oModelForm, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formPriority->error($oModelForm, 'description', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formPriority->labelEx($oModelForm, 'priority', array('style'=>'width:120px;')); ?>
               <?php echo $formPriority->dropDownList($oModelForm, 'priority', array(1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5', 6=>'6', 7=>'7', 8=>'8', 9=>'9', 10=>'10'), array('style'=>'width:100px;')); ?>
               <?php echo $formPriority->error($oModelForm, 'priority', array('style'=>'width:120px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>