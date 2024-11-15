<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'hour',
      ),
      array(
         'name'=>'section_name',
      ),
      array(
         'name'=>'zone',
      ),
      array(
         'name'=>'region',
      ),
      array(
         'name'=>'equipment',
      ),
      array(
         'name'=>'urgent', 
         'value'=>($oModelForm->urgent) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
      ),
      'description:html',
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>