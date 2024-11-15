<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'risk.name',
        ),
        array(
            'name'=>'ipe.name',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>