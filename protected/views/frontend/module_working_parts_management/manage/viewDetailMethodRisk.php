<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'id_method',
            'value'=>Methods::getMethodName($oModelForm->id_method),
        ),
        array(
            'name'=>'id_risk',
            'value'=>Risks::getRiskName($oModelForm->id_risk),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>