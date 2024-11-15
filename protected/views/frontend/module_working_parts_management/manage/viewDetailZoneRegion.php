<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'zone.name',
        ),
        array(
            'name'=>'region.name',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>