<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/providers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_PROVIDERS')); ?>
   </div>
</div>

<?php
$sAllowManageProvider = FString::STRING_BOOLEAN_TRUE;

$oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
if (!is_null($oPurchasesModuleParameters)) {
   $bAllowManageProvider = !$oPurchasesModuleParameters->database_providers_synchronization;
   
   if (!$bAllowManageProvider) $sAllowManageProvider = FString::STRING_BOOLEAN_FALSE;
}
?>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWPROVIDERS_DESCRIPTION'); ?>
</div>

<?php
if ($bAllowManageProvider) { ?>
   <div class="form">
      <?php $formProvider = $this->beginWidget('CActiveForm', array(
         'id'=>'provider-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewProviders'),
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
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWPROVIDERS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWPROVIDERS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formProvider->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formProvider->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formProvider->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php
}
?>
 
<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWPROVIDERS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('providers', null, 'Providers', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'htmlOptions'=>array('width'=>270),
      ),
      array(
         'name'=>'nif',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'account',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'phone',
         'htmlOptions'=>array('width'=>90),
      ),
      array(
         'name'=>'mail',
         'htmlOptions'=>array('width'=>150),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateProvider", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteProvider($data->primaryKey, FApplication::MODULE_WAREHOUSE_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailProvider", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteProvider", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteProvider($data->primaryKey, FApplication::MODULE_WAREHOUSE_MANAGEMENT))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>