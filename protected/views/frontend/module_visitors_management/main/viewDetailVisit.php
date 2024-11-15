<div class="detail_content">
   <div class="first_row_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_VISIT'); ?>
   </div>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'type',
         'value'=>Yii::t("frontend_" . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), "MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_" . $oModelForm->type),
      ),
      array(
         'name'=>'card_code',
      ),
      array(
         'name'=>'start_date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true),
      ),
      array(
         'name'=>'end_date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->end_date, true),
      ),
   ),           
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div class="detail_content">
   <div class="row_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_DATA'); ?>
   </div>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'visitor_full_name',
         'value'=>FString::castStrToCapitalLetters(FString::castStrSpecialChars($oModelForm->visitor_full_name)),
      ),
      array(
         'name'=>'visitor_identification',
      ),
      array(
         'name'=>'visitor_business',
      ),
      array(
         'name'=>'visitor_vehicle',
         'value'=>($oModelForm->visitor_vehicle) ? Yii::t("system", "SYS_YES") : Yii::t("system", "SYS_NO"),
      ),
      array(
         'name'=>'visitor_vehicle_plate',
         'visible'=>($oModelForm->visitor_vehicle),
      ),
      array(
         'name'=>'visitor_destiny_vehicle',
         'visible'=>($oModelForm->visitor_vehicle),
         'value'=>Yii::t("frontend_" . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), "MODEL_VISITORSDESTINYCAR_FIELD_NAME_VALUE_" . FString::getFirstToken($oModelForm->visitor_destiny_vehicle, '_'), array('{1}'=>FString::getLastToken($oModelForm->visitor_destiny_vehicle, '_'))),
      ),
      array(
         'name'=>'reason',
      ),
      array(
         'name'=>'visitor_comments',
      ),
      array(
         'name'=>'visitor_signature',
         'value'=>FString::getAbbreviationSentence($oModelForm->visitor_signature, 80, null),
      ),
   ),           
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<?php 
$oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management)) { ?>
   <div class="detail_content">
      <div class="row_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_MANUALCARD'); ?>
      </div>
   </div>
   
   <?php $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oModelForm,
      'attributes'=>array(
         array(
            'name'=>'card_information',
         ),
         array(
            'name'=>'id_group_device',
            'value'=>(!FString::isNullOrEmpty($oModelForm->id_group_device)) ? AccessControlGroupsDevices::getAccessControlGroupDeviceName($oModelForm->id_group_device) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'id_biostar',
         ),
      ),           
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
}
?>

<div class="detail_content">
   <div class="row_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_RESPONSIBLE'); ?>
   </div>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'employee',
      ),
      array(
         'name'=>'employee_identification',
      ),
      array(
         'name'=>'employee_comments',
      ),
   ),           
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>