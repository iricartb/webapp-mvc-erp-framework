<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EVENTS . '/notifications.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('rainbow', 'MODEL_USERS_FIELD_NOTIFYEVENTS')); ?>
   </div>
</div>
 
<div class="toolbox_table" style="padding-top:20px;">
   <div class="toolbox_table_cell_description"> 
      <div class="item-description-italic">
         <?php echo Yii::t('rainbow', 'PAGE_VIEWEVENTSNOTIFICATIONS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
</div>  
                                                                                                                
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(Yii::app()->user->id),
   'columns'=>array(
      array(
         'name'=>'send_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->send_date)',
         'htmlOptions'=>array('width'=>80, 'style'=>'text-align:center;'),
      ),
      array(
         'name'=>'id_user',
         'value'=>'(!is_null($data->id_user)) ? Users::getUserEmployeeFullName($data->id_user) : FString::STRING_EMPTY',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'module',
         'value'=>'FString::castStrToUpper(Yii::t(\'system\', \'SYS_\' . $data->module . \'_HEADER\'))',
         'htmlOptions'=>array('width'=>140),
      ),
      array(
         'name'=>'title',
         'value'=>'($data->translate) ? Yii::t(\'rainbow\', $data->title) : $data->title',
         'htmlOptions'=>array('width'=>170),
      ),
      array(
         'name'=>'message',
         'value'=>'($data->translate) ? Yii::t(\'rainbow\', $data->message, array(\'{1}\'=>$data->message_parameter)) : $data->message',
         'htmlOptions'=>array('width'=>420),
      ),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>