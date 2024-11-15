<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/plates.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_PLATES')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPLATES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formPlate = $this->beginWidget('CActiveForm', array(
      'id'=>'visitors-plate-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/maintenance/viewPlates'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPLATES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPLATES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formPlate->labelEx($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
               <?php echo $formPlate->textField($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
               <?php echo $formPlate->error($oModelForm, 'plate', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formPlate->labelEx($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
               <?php echo $formPlate->dropDownList($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php // echo FForm::textFieldAutoComplete($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS, FApplication::EMPLOYEE_SUBCONTRACT), null, null, true), 'identification', 'full_name'), array('style'=>'width:300px;')); ?>              
               <?php echo $formPlate->error($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formPlate->labelEx($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
               <?php echo $formPlate->textField($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
               <?php echo $formPlate->error($oModelForm, 'comments', array('style'=>'width:510px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWPLATES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('visitorsPlates', FApplication::MODULE_VISITORS_MANAGEMENT, 'VisitorsPlates', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'plate',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'employee',
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'employee_identification',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'comments',
         'value'=>'FString::getAbbreviationSentence($data->comments, 20)',
         'htmlOptions'=>array('width'=>280),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updatePlate", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailPlate", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deletePlate", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>