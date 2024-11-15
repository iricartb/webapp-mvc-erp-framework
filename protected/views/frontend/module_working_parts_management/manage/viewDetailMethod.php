<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'code',
        ),
        array(
            'name'=>'description',
            'value'=>FString::getAbbreviationSentence($oModelForm->description, 45, 40),
        ),
        array(
            'name'=>'visible_working_part',
            'value'=>($oModelForm->visible_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_maintenance_working_part',
            'value'=>($oModelForm->visible_maintenance_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
        array(
            'name'=>'visible_special_working_part',
            'value'=>($oModelForm->visible_special_working_part) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>