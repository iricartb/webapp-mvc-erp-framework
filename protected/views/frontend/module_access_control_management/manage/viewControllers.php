<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/controllers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_CONTROLLERS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCONTROLLERS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formController = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-controller-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewControllers'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCONTROLLERS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCONTROLLERS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formController->labelEx($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'name', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formController->labelEx($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'ipv4', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formController->labelEx($oModelForm, 'mac', array('style'=>'width:180px;')); ?>
               <?php echo $formController->textField($oModelForm, 'mac', array('style'=>'width:180px;')); ?>
               <?php echo $formController->error($oModelForm, 'mac', array('style'=>'width:180px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWCONTROLLERS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('accessControlControllers', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'AccessControlControllers', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'htmlOptions'=>array('width'=>230),
      ),
      array(
         'name'=>'ipv4',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'mac',
         'htmlOptions'=>array('width'=>180),
      ),
      array(
         'name'=>'status',
         'value'=>'FString::castStrToUpper(Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), \'MODEL_ACCESSCONTROLDEVICES_FIELD_STATUS_VALUE_\' . FString::getLastToken($data->status, \'_\')))',
         'htmlOptions'=>array('width'=>150),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateController", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailController", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteController", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>