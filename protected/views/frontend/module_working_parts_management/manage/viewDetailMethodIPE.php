<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'id_method',
            'value'=>Methods::getMethodName($oModelForm->id_method),
        ),
        array(
            'name'=>'id_ipe',
            'value'=>IPEs::getIPEName($oModelForm->id_ipe),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>