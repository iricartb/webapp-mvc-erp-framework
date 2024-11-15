<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'name',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>