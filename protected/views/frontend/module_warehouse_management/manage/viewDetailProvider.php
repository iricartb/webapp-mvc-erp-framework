<?php
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'name',
      ),
      array(
         'name'=>'nif',
      ),
      array(
         'name'=>'account',
      ),
      array(
         'name'=>'phone',
      ),
      array(
         'name'=>'mail',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>