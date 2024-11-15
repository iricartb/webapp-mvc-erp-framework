<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'quantity',
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'requirements_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->requirements_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->requirements_date) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'service',
         'value'=>($oModelForm->service) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>