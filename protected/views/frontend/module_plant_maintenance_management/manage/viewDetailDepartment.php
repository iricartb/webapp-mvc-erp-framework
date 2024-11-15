<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'name',
         'value'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->name), 
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>