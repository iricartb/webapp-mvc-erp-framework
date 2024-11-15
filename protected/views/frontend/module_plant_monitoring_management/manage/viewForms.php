<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/forms.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MONITORING_MANAGEMENT_HEADER_LINE_FORMS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formGroupForm = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-group-form-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewForms'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formGroupForm->labelEx($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formGroupForm->textField($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formGroupForm->error($oModelForm, 'name', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formGroupForm->labelEx($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formGroupForm->textField($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formGroupForm->error($oModelForm, 'description', array('style'=>'width:350px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('monitoringGroupForms', FApplication::MODULE_PLANT_MONITORING_MANAGEMENT, 'MonitoringGroupForms', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'htmlOptions'=>array('width'=>250),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>460),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateGroupForm", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailGroupForm", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteGroupForm", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?> 

<div class="form">
   <?php $formForm = $this->beginWidget('CActiveForm', array(
      'id'=>'monitoring-form-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/manage/viewForms'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formForm->labelEx($oModelFormAssociation, 'id_group_form', array('style'=>'width:300px;')); ?>
               <?php echo $formForm->dropDownList($oModelFormAssociation, 'id_group_form', CHtml::listData(MonitoringGroupForms::getMonitoringGroupForms(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formForm->error($oModelFormAssociation, 'id_group_form', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formForm->labelEx($oModelFormAssociation, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formForm->textField($oModelFormAssociation, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formForm->error($oModelFormAssociation, 'name', array('style'=>'width:200px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formForm->labelEx($oModelFormAssociation, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formForm->textField($oModelFormAssociation, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formForm->error($oModelFormAssociation, 'description', array('style'=>'width:350px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWFORMS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('monitoringForms', FApplication::MODULE_PLANT_MONITORING_MANAGEMENT, 'MonitoringForms', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'id_group_form',
         'value'=>'MonitoringGroupForms::getMonitoringGroupFormName($data->id_group_form)',
         'filter'=>CHtml::listData(MonitoringGroupForms::getMonitoringGroupForms(), 'id', 'name'),
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>310),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateForm", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailForm", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteForm", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>