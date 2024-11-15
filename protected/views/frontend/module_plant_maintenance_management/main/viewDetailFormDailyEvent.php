<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->date)) ? FDate::getTimeZoneFormattedDate($oModelForm->date) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'owner',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>