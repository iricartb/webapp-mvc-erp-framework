<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'mail',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>