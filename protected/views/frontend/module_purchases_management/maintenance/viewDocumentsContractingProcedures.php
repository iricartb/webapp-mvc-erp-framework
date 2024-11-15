<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/documents_contracting_procedures.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_DOCUMENTS_CONTRACTING_PROCEDURES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDOCUMENTSCONTRACTINGPROCEDURES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formPurchasesDocumentContractingProcedure = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-document-contracting-procedure-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewDocumentsContractingProcedures'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDOCUMENTSCONTRACTINGPROCEDURES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDOCUMENTSCONTRACTINGPROCEDURES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'type', array('style'=>'width:120px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'type', array('style'=>'width:120px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'type', array('style'=>'width:120px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'description', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'description', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'description', array('style'=>'width:250px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formPurchasesDocumentContractingProcedure->labelEx($oModelForm, 'folder', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->textField($oModelForm, 'folder', array('style'=>'width:250px;')); ?>
               <?php echo $formPurchasesDocumentContractingProcedure->error($oModelForm, 'folder', array('style'=>'width:250px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWDOCUMENTSCONTRACTINGPROCEDURES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesDocumentsContractingProcedures', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesDocumentsContractingProcedures', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'name'=>'type',
         'htmlOptions'=>array('width'=>190),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>260),
      ),
      array(
         'name'=>'folder',
         'htmlOptions'=>array('width'=>260),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateDocumentContractingProcedure", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailDocumentContractingProcedure", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteDocumentContractingProcedure", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>