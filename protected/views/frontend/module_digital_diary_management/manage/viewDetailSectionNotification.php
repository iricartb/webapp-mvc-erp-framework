<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'section.name',
        ),
        array(
            'name'=>'mail',
        ),
        array(
            'name'=>'only_recv_urgent_events', 
            'value'=>($oModelForm->only_recv_urgent_events) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>