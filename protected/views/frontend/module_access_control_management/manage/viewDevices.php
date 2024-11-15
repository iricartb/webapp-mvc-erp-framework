<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/devices.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_DEVICES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWDEVICES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formDevice = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-device-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewDevices'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWDEVICES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWDEVICES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formDevice->labelEx($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->textField($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formDevice->labelEx($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->textField($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formDevice->labelEx($oModelForm, 'type', array('style'=>'width:400px;')); ?>
               <?php echo $formDevice->dropDownList($oModelForm, 'type', array(FModuleAccessControlManagement::TYPE_MAIN_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_INPUT), FModuleAccessControlManagement::TYPE_MAIN_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_MAIN_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT), FModuleAccessControlManagement::TYPE_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_OUTPUT), FModuleAccessControlManagement::TYPE_INPUT_OUTPUT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT)), array('style'=>'width:400px;')); ?>
               <?php echo $formDevice->error($oModelForm, 'type', array('style'=>'width:400px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>
  
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWDEVICES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('accessControlDevices', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'AccessControlDevices', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
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
   'rowCssClassExpression'=>'strtolower(FString::getLastToken($data->status, \'_\'))',  
   'columns'=>array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>250),
      ),
      array(
         'name'=>'ipv4',
         'htmlOptions'=>array('width'=>155),
      ),
      array(
         'name'=>'type',
         'value'=>'(!is_null($data->type)) ? FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_\' . $data->type)) : FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE_VALUE_\' . FModuleAccessControlManagement::TYPE_INPUT_OUTPUT . \'_ABBREVIATION\'))',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'status',
         'value'=>'FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_STATUS_VALUE_\' . FString::getLastToken($data->status, \'_\')))',
         'htmlOptions'=>array('width'=>155),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateDevice", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailDevice", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteDevice", array("nIdForm"=>$data->primaryKey))', '!(AccessControlDevices::isAccessControlDeviceLocked($data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div style="color:darkred; margin-top:20px;">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWDEVICES_INFORMATION_LOCKED');?>
</div>