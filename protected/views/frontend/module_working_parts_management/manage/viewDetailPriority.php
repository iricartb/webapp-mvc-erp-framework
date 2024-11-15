<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'description',
        ),
        array(
            'name'=>'priority',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>