<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'name',
      ),
      array(
         'name'=>'ipv4',
      ),
      array(
         'name'=>'type',
         'value'=>(!is_null($oModelForm->type)) ? FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . $oModelForm->type)) : FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT . '_ABBREVIATION')),
      ),
      array(
         'name'=>'status',
         'value'=>FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_STATUS_VALUE_' . FString::getLastToken($oModelForm->status, '_'))),
      )
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>