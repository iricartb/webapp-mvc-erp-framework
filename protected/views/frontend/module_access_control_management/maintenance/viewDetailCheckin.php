<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'employee_identification',
            'value'=>(!is_null(Employees::getEmployeeByIdentification($oModelForm->employee_identification))) ? Employees::getEmployeeByIdentification($oModelForm->employee_identification)->full_name : FString::STRING_EMPTY,
        ),
        array(
            'name'=>'date',
            'value'=>FDate::getTimeZoneFormattedDate($oModelForm->date, true),
        ),
        array(
           'name'=>'type',
           'value'=>(!is_null($oModelForm->type)) ? FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . $oModelForm->type)) : FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT . '_ABBREVIATION')),
        ),
        array(
            'name'=>'incidence_code',
            'value'=>(!is_null($oModelForm->incidence_code)) ? (!is_null(AccessControlIncidences::getAccessControlIncidenceByCode($oModelForm->incidence_code))) ? AccessControlIncidences::getAccessControlIncidenceByCode($oModelForm->incidence_code)->description : FString::STRING_EMPTY : FString::STRING_EMPTY,
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>