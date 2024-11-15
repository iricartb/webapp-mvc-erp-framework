<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'hour',
      ),
      array(
         'name'=>'duration',
      ),
      'description:html',
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>