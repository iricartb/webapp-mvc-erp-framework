<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'priority',
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'comments',
      ),
      array(
         'name'=>'visible_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->visible_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->visible_date) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'start_date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true),
      ),
      array(
         'name'=>'end_date',
         'value'=>(!is_null($oModelForm->end_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->end_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'status',
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STATUS_VALUE_' . $oModelForm->status),
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>