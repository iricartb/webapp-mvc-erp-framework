<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'description',
            'value'=>FString::getAbbreviationSentence($oModelForm->description, 45, 40),
        ),
        array(
            'name'=>'visible_default_working_part',
            'value'=>($oModelForm->visible_default_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_default_maintenance_working_part',
            'value'=>($oModelForm->visible_default_maintenance_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_default_special_working_part',
            'value'=>($oModelForm->visible_default_special_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'alert',
            'value'=>FString::getAbbreviationSentence($oModelForm->alert, 45, 40),
        ),
        array(
            'name'=>'visible_alert_value_yes',
            'value'=>($oModelForm->visible_alert_value_yes) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_alert_value_no',
            'value'=>($oModelForm->visible_alert_value_no) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_alert_value_np',
            'value'=>($oModelForm->visible_alert_value_np) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_alert_value_default',
            'value'=>($oModelForm->visible_alert_value_default) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'required_grade_preventive_action',
            'value'=>($oModelForm->required_grade_preventive_action) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'information',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>