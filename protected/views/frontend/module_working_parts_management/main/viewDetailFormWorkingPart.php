<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'id',
      ),
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'zone',
         'value'=>$oModelForm->zone . '/' . $oModelForm->region,
      ),
      array(
         'name'=>'equipment',
      ),
      array(
         'name'=>'priority',
      ),
      array(
         'name'=>'start_date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true),
      ),
      array(
         'name'=>'equipment_failure_reason',
      ),
      array(
         'name'=>'status',
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKINGPARTS_FIELD_STATUS_VALUE_' . $oModelForm->status),
      ),
      array(
         'name'=>'sNavigation',
         'type' => 'raw',
         'value'=>'<div class="item_link" onclick="parent.window.location = \'' . Yii::app()->controller->createUrl('updateFormWorkingPart&nIdForm=' . $oModelForm->id) . '\'">' . Yii::t('system', 'SYS_NAVIGATION_LINK') . '</div>',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>