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
      array(
         'name'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTION') . FString::STRING_SPACE . date('Y'),
         'value'=>FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($oModelForm->id, date('Y'), false)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
      ),
      array(
         'name'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTIONADDCONTRACTINGPROCEDURES') . FString::STRING_SPACE . date('Y'),
         'value'=>FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($oModelForm->id, date('Y'), true)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'),
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>