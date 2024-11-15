<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/businesses.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_BUSINESSES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWBUSINESSES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formBusiness = $this->beginWidget('CActiveForm', array(
      'id'=>'business-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewBusinesses'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWBUSINESSES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWBUSINESSES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'id', array('style'=>'width:115px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'id', array('style'=>'width:115px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'id', array('style'=>'width:115px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'name', array('style'=>'width:250px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'name', array('style'=>'width:250px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'name', array('style'=>'width:250px;')); ?>
            </div>
         </div> 
         <div class="row">
            <div class="cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formBusiness->labelEx($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
               <?php echo $formBusiness->error($oModelForm, 'contact', array('style'=>'width:184px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'address', array('style'=>'width:400px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'address', array('style'=>'width:400px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'address', array('style'=>'width:400px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'phone', array('style'=>'width:100px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'phone', array('style'=>'width:100px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'phone', array('style'=>'width:100px;')); ?>
            </div>
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'fax', array('style'=>'width:100px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'fax', array('style'=>'width:100px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'fax', array('style'=>'width:100px;')); ?>
            </div>
            <div class="cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'mail', array('style'=>'width:265px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
            </div>
            <div class="last_cell">  
               <?php echo $formBusiness->labelEx($oModelForm, 'www', array('style'=>'width:265px;')); ?>
               <?php echo $formBusiness->textField($oModelForm, 'www', array('style'=>'width:265px;')); ?>      
               <?php echo $formBusiness->error($oModelForm, 'www', array('style'=>'width:265px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWBUSINESSES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('businesses', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'Businesses', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'id',
         'htmlOptions'=>array('width'=>60),
      ),
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>340),
      ),
      array(
         'name'=>'nif',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'phone',
         'value'=>'FFormat::getFormatPhone($data->phone)',
         'htmlOptions'=>array('width'=>150),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateBusiness", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailBusiness", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteBusiness", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>