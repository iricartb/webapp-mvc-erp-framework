<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$oModelForm,
    'attributes'=>array(
        array(
            'name'=>'name',
        ),
        array(
            'name'=>'abbreviation',
        ),
        array(
            'name'=>'hour1_t1',
        ),
        array(
            'name'=>'hour2_t1',
        ),
        array(
            'name'=>'hour1_t2',
        ),
        array(
            'name'=>'hour2_t2',
        ),
        array(
            'name'=>'tolerance',
        ),
    ),
    'nullDisplay'=>FString::STRING_EMPTY,
));
?>