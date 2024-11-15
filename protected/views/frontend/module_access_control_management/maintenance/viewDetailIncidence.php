<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'code',
        ),
        array(
            'name'=>'description',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>