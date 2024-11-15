<div class="form">
   <?php $formMethodRisk = $this->beginWidget('CActiveForm', array(
      'id'=>'method-risk-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateMethodRisk', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEMETHODRISK_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formMethodRisk->labelEx($oModelForm, 'id_method', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->dropDownList($oModelForm, 'id_method', CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->error($oModelForm, 'id_method', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formMethodRisk->labelEx($oModelForm, 'id_risk', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->dropDownList($oModelForm, 'id_risk', CHtml::listData(Risks::getRisks(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->error($oModelForm, 'id_risk', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>