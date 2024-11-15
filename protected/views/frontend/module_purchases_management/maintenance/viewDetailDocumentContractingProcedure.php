<?php
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'type',
      ),
      array(
         'name'=>'description',
      ),
      array(
         'name'=>'folder',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>