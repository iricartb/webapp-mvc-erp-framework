<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'id_form',
         'value'=>MonitoringForms::getFullMonitoringForm($oModelForm->form),
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'field_type',
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE_VALUE_' . $oModelForm->field_type),
      ),
      array(
         'name'=>'field_unit',
      ),
      array(
         'name'=>'field_required',
         'value'=>($oModelForm->field_required) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
      ),
      array(
         'name'=>'field_value_default',
      ),
      array(
         'name'=>'field_value_options',
      ),
      array(
         'name'=>'repeat',
         'value'=>MonitoringFormsQuestions::getFullMonitoringFormQuestionRepeat($oModelForm),
      ),
      array(
         'name'=>'start_hour',
      ),
      array(
         'name'=>'end_hour',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>