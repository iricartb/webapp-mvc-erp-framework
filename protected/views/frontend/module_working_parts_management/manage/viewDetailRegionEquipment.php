<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'region.name',
        ),
        array(
            'name'=>'equipment.name',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>