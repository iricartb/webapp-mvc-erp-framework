<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'name',
        ),
        array(
            'name'=>'description',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>