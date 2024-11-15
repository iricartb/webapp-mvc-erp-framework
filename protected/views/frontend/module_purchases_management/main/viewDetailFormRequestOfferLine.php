<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'id',
      ),
      array(
         'name'=>'id_provider',
         'value'=>Providers::getProviderName($oModelForm->id_provider),
      ),
      array(
         'name'=>'price',
         'value'=>($oModelForm->price >= 0) ? FFormat::getFormatPrice($oModelForm->price) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'notify_date',
         'value'=>(!is_null($oModelForm->notify_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->notify_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'start_date',
         'value'=>(!is_null($oModelForm->start_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->start_date, true) : FString::STRING_EMPTY,
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>