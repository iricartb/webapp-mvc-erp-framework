<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/zones.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER_LINE_ZONES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formZone = $this->beginWidget('CActiveForm', array(
      'id'=>'zone-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewZones'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formZone->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formZone->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formZone->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('zones', null, 'Zones', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'htmlOptions'=>array('width'=>710),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateZone", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment($data->primaryKey, null, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailZone", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteZone", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment($data->primaryKey, null, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>   

<div class="form">
   <?php $formZoneRegion = $this->beginWidget('CActiveForm', array(
      'id'=>'zone-region-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewZones'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formZoneRegion->labelEx($oModelFormAssociation, 'id_zone', array('style'=>'width:300px;')); ?>
               <?php echo $formZoneRegion->dropDownList($oModelFormAssociation, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formZoneRegion->error($oModelFormAssociation, 'id_zone', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formZoneRegion->labelEx($oModelFormAssociation, 'id_region', array('style'=>'width:300px;')); ?>
               <?php echo $formZoneRegion->dropDownList($oModelFormAssociation, 'id_region', CHtml::listData(Regions::getFullRegions(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formZoneRegion->error($oModelFormAssociation, 'id_region', array('style'=>'width:300px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWZONES_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('zonesRegions', null, 'ZonesRegions', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'id_zone',
         'value'=>'Zones::getZoneName($data->id_zone)',
         'filter'=>CHtml::listData(Zones::getZones(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      array(
         'name'=>'id_region',
         'value'=>'Regions::getFullRegion($data->id_region)',
         'filter'=>CHtml::listData(Regions::getFullRegions(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateZoneRegion", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment(null, $data->primaryKey, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailZoneRegion", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteZoneRegion", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteZoneRegionEquipment(null, $data->primaryKey, null, null, null, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>