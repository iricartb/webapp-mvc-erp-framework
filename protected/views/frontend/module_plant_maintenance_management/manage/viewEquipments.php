<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/equipments.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MAINTENANCE_MANAGEMENT_HEADER_LINE_EQUIPMENTS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formEquipment = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewEquipments'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'name', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'name', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'name', array('style'=>'width:355px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'tag', array('style'=>'width:150px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'manufacturer', array('style'=>'width:355px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
                <?php echo $formEquipment->labelEx($oModelForm, 'installation_date'); ?>
                <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'installation_date', false, FString::STRING_EMPTY, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, true, false, '160px', FString::STRING_EMPTY, FString::STRING_EMPTY)); ?>
                <?php echo $formEquipment->error($oModelForm, 'installation_date'); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'model', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'model', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'model', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'serial_number', array('style'=>'width:160px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_x_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_x', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_x', array('style'=>'width:160px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_y_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_y', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_y', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'dimension_z_m', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->textField($oModelForm, 'dimension_z', array('style'=>'width:160px;')); ?>
               <?php echo $formEquipment->error($oModelForm, 'dimension_z', array('style'=>'width:160px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'image', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->fileField($oModelForm, 'image', array('style'=>'width:355px;')); ?>      
               <?php echo $formEquipment->error($oModelForm, 'image', array('style'=>'width:355px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formEquipment->labelEx($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>
               <?php echo $formEquipment->fileField($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>      
               <?php echo $formEquipment->error($oModelForm, 'attachment', array('style'=>'width:355px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('equipments', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'Equipments', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
   'columns'=>array(
      array(
         'name'=>'name',
         'value'=>'Equipments::getFullEquipment($data->primaryKey)',
         'htmlOptions'=>array('width'=>360),
      ),
      array(
         'name'=>'tag',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'manufacturer',
         'htmlOptions'=>array('width'=>240),
      ),
      FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentEquipment", array("nIdForm"=>$data->primaryKey))', '(!FString::isNullOrEmpty($data->attachment))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateEquipment", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $data->primaryKey, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailEquipment", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteEquipment", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment(null, null, null, null, $data->primaryKey, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>

<div class="form">
   <?php $formEquipmentComponent = $this->beginWidget('CActiveForm', array(
      'id'=>'equipment-component-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewEquipments'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_association_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_association_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_association_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formEquipmentComponent->labelEx($oModelFormAssociation, 'id_equipment', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->dropDownList($oModelFormAssociation, 'id_equipment', CHtml::listData(Equipments::getFullEquipments(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->error($oModelFormAssociation, 'id_equipment', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formEquipmentComponent->labelEx($oModelFormAssociation, 'id_component', array('style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->dropDownList($oModelFormAssociation, 'id_component', CHtml::listData(Components::getFullComponents(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formEquipmentComponent->error($oModelFormAssociation, 'id_component', array('style'=>'width:300px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('equipmentsComponents', FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT, 'EquipmentsComponents', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_2',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAssociationFilters->search(),
   'filter'=>$oModelFormAssociationFilters,
   'columns'=>array(
      array(
         'name'=>'id_equipment',
         'value'=>'Equipments::getFullEquipment($data->id_equipment)',
         'filter'=>CHtml::listData(Equipments::getFullEquipments(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      array(
         'name'=>'id_component',
         'value'=>'Components::getFullComponent($data->id_component)',
         'filter'=>CHtml::listData(Components::getFullComponents(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateEquipmentComponent", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailEquipmentComponent", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteEquipmentComponent", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>