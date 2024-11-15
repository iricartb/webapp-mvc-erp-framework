<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'name',
         'value'=>$oModelForm->name . ' (' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK_VALUE_' . $oModelForm->type_task) . ')',
      ),
      array(
         'name'=>'task',
      ),
      array(
         'name'=>'priority',
      ),
      array(
         'type'=>'raw',
         'name'=>'working_part',
         'value'=>($oModelForm->working_part != FModulePlantMaintenanceManagement::TYPE_WORKING_PART_VALUE_NONE) ? '<b><font color="red">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_' . $oModelForm->working_part) . ': ' . $oModelForm->working_part_number . ' - ' . $oModelForm->working_part_owner . '</font></b>'  : Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_' . $oModelForm->working_part),
         'visible'=>(Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)),
      ),
      array(
         'name'=>'sEmployees',
         'value'=>MaintenanceFormsTasks::getEmployeesDescription($oModelForm->id),
      ),
      array(
         'name'=>'start_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->start_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->start_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'execution_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->execution_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->execution_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'end_date',
         'value'=>(!FString::isNullOrEmpty($oModelForm->end_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->end_date, true) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'sDepartments',
         'value'=>MaintenanceFormsTasks::getDepartmentsDescription($oModelForm->id),
      ),
      array(
         'name'=>'id_zone',
         'value'=>Zones::getZoneName($oModelForm->id_zone) . '/' . Regions::getRegionName($oModelForm->id_region),
      ),
      array(
         'name'=>'id_equipment',
         'value'=>Equipments::getEquipmentName($oModelForm->id_equipment),
      ),
      array(
         'name'=>'sComponents',
         'value'=>MaintenanceFormsTasks::getComponentsDescription($oModelForm->id),
      ),
      array(
         'name'=>'sSupplies',
         'value'=>MaintenanceFormsTasks::getSuppliesDescription($oModelForm->id),
         'visible'=>(Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)),
      ),
      array(
         'name'=>'failure_reason',
      ),
      array(
         'name'=>'failure_solution',
      ),
      array(
         'name'=>'comments',
      ),  
      array(
         'name'=>'status',
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_' . $oModelForm->status),
      )
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>