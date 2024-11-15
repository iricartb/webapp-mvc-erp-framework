<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/historical_visits.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_HISTORICAL_VISITS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWHISTORICALVISITS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWHISTORICALVISITS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('visitorsVisits', FApplication::MODULE_VISITORS_MANAGEMENT, 'VisitorsVisits', 'false', FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>
 
<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search('false'),
   'filter'=>$oModelFormFilters,
   'columns'=> array(
      array(
         'name'=>'type',
         'value'=>'Yii::t("frontend_" . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), "MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_" . $data->type)',
         'filter'=>array(FModuleVisitorsManagement::TYPE_VISIT_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_VISIT), FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT), FModuleVisitorsManagement::TYPE_VISIT_PROVIDER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_PROVIDER), FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL), FModuleVisitorsManagement::TYPE_VISIT_OTHER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_OTHER)),
         'htmlOptions'=>array('width'=>164),
      ),
      array(
         'name'=>'visitor_full_name',
         'value'=>'FString::castStrToCapitalLetters(FString::castStrSpecialChars($data->visitor_full_name))',
         'htmlOptions'=>array('width'=>220),
      ),
      array(
         'name'=>'card_code',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_CARDCODE_ABBREVIATION'),
         'value'=>'FString::getAbbreviationSentence($data->card_code, 12)',
         'htmlOptions'=>array('width'=>70),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'start_date', false, null, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>138),
      ),
      array(
         'name'=>'end_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->end_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'end_date', false, null, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>138),
      ),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailVisit", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));    
?>