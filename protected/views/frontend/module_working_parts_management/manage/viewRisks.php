<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/risks.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WORKING_PARTS_MANAGEMENT_HEADER_LINE_RISKS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formRisk = $this->beginWidget('CActiveForm', array(
      'id'=>'risk-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRisks'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formRisk->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRisk->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRisk->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('risks', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'Risks', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateRisk", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailRisk", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteRisk", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>   

<div class="form">
   <?php $formRiskIPE = $this->beginWidget('CActiveForm', array(
      'id'=>'risk-ipe-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewRisks'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formRiskIPE->labelEx($oModelFormAssociation, 'id_risk', array('style'=>'width:300px;')); ?>
               <?php echo $formRiskIPE->dropDownList($oModelFormAssociation, 'id_risk', CHtml::listData(Risks::getRisks(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formRiskIPE->error($oModelFormAssociation, 'id_risk', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formRiskIPE->labelEx($oModelFormAssociation, 'id_ipe', array('style'=>'width:300px;')); ?>
               <?php echo $formRiskIPE->dropDownList($oModelFormAssociation, 'id_ipe', CHtml::listData(IPEs::getIPEs(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formRiskIPE->error($oModelFormAssociation, 'id_ipe', array('style'=>'width:300px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWRISKS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('risksIpes', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'RisksIPEs', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'id_risk',
         'value'=>'Risks::getRiskName($data->id_risk)',
         'filter'=>CHtml::listData(Risks::getRisks(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      array(
         'name'=>'id_ipe',
         'value'=>'IPEs::getIPEName($data->id_ipe)',
         'filter'=>CHtml::listData(IPEs::getIPEs(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateRiskIPE", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailRiskIPE", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteRiskIPE", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>