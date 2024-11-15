<div class="form">
   <?php $formDepartment = $this->beginWidget('CActiveForm', array(
      'id'=>'maintenance-department-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateDepartment', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEDEPARTMENT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formDepartment->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
			   <?php echo $formDepartment->dropDownList($oModelForm, 'name', array('BOSS_TECHNICAL_DIRECTOR'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_BOSS_TECHNICAL_DIRECTOR'), 'BOSS_MAINTENANCE'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_BOSS_MAINTENANCE'), 'BOSS_OPERATING'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_BOSS_OPERATING'), 'BOSS_PREVENTION_SECURITY'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_BOSS_PREVENTION_SECURITY'), 'PREVENTION_SECURITY'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_PREVENTION_SECURITY'), 'ELECTRIC'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_ELECTRIC'), 'MECHANICAL'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MECHANICAL'), 'LOGISTIC'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_LOGISTIC'), 'WAREHOUSE'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_WAREHOUSE')), array('style'=>'width:300px;')); ?>
               <?php echo $formDepartment->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>