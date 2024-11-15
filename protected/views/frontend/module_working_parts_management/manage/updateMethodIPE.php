<div class="form">
   <?php $formMethodIPE = $this->beginWidget('CActiveForm', array(
      'id'=>'method-ipe-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/updateMethodIPE', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_UPDATEMETHODIPE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formMethodIPE->labelEx($oModelForm, 'id_method', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->dropDownList($oModelForm, 'id_method', CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->error($oModelForm, 'id_method', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formMethodIPE->labelEx($oModelForm, 'id_ipe', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->dropDownList($oModelForm, 'id_ipe', CHtml::listData(IPEs::getIPEs(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->error($oModelForm, 'id_ipe', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>