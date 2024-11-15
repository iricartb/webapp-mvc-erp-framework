<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'name',
            'value'=>Equipments::getEquipmentName($oModelForm->id),
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>