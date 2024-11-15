<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'code',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>