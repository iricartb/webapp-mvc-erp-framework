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
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>