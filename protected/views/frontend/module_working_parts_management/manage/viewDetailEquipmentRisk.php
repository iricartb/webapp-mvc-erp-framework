<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'equipment.name',
            'value'=>Equipments::getEquipmentName($oModelForm->id_equipment),
        ),
        array(
            'name'=>'risk.name',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>