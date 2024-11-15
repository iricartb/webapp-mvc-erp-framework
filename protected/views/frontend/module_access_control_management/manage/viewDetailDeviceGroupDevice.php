<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'id_device',
         'value'=>AccessControlDevices::getAccessControlDeviceName($oModelForm->id_device),
      ),
      array(
         'name'=>'id_group_device',
         'value'=>AccessControlGroupsDevices::getAccessControlGroupDeviceName($oModelForm->id_group_device),
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>