<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/visitors.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_VISITORS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITORS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formVisitor = $this->beginWidget('CActiveForm', array(
      'id'=>'visitor-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/viewVisitors'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITORS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITORS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'first_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'middle_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'last_name', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'identification', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'business', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'business', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'business', array('style'=>'width:392px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisitor->labelEx($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->textField($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
               <?php echo $formVisitor->error($oModelForm, 'comments', array('style'=>'width:392px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITORS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('visitors', FApplication::MODULE_VISITORS_MANAGEMENT, 'Visitors', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'full_name',
         'htmlOptions'=>array('width'=>190),
      ),
      array(
         'name'=>'identification',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'business',
         'value'=>'FString::getAbbreviationSentence($data->business, 20)',
         'htmlOptions'=>array('width'=>190),
      ),
      array(
         'name'=>'comments',
         'value'=>'FString::getAbbreviationSentence($data->comments, 20)',
         'htmlOptions'=>array('width'=>200),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateVisitor", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailVisitor", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteVisitor", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>
