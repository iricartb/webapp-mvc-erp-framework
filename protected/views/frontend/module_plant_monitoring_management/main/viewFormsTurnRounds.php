<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/forms_turn_rounds.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MONITORING_MANAGEMENT_HEADER_LINE_FORMS_TURN_ROUNDS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMSTURNROUNDS_DESCRIPTION'); ?>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'columns'=>array(
      array(
         'name'=>'user_name',
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'start_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'end_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->end_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'end_date', false, FString::STRING_EMPTY, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'sDiffDate',
         'value'=>'FDate::getDiffDatesDescription($data->start_date, $data->end_date, false, false, false)',
         'htmlOptions'=>array('width'=>150),
      ),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormTurnRound", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?> 