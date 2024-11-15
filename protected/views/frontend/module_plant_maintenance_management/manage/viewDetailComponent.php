<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'name',
            'value'=>Components::getComponentName($oModelForm->id),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>