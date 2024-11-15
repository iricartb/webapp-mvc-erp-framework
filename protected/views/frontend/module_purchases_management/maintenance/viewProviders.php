<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/providers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_PROVIDERS')); ?>
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
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWPROVIDERS_DESCRIPTION'); ?>
</div>

<?php
if ($bAllowManageProvider) { ?>
   <div class="form">
      <?php $formProvider = $this->beginWidget('CActiveForm', array(
         'id'=>'provider-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/viewProviders'),
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
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWPROVIDERS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWPROVIDERS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formProvider->labelEx($oModelForm, 'name', array('style'=>'width:395px;')); ?>
                  <?php echo $formProvider->textField($oModelForm, 'name', array('style'=>'width:395px;')); ?>
                  <?php echo $formProvider->error($oModelForm, 'name', array('style'=>'width:395px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formProvider->labelEx($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
                  <?php echo $formProvider->textField($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
                  <?php echo $formProvider->error($oModelForm, 'nif', array('style'=>'width:180px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formProvider->labelEx($oModelForm, 'account', array('style'=>'width:180px;')); ?>
                  <?php echo $formProvider->textField($oModelForm, 'account', array('style'=>'width:180px;')); ?>
                  <?php echo $formProvider->error($oModelForm, 'account', array('style'=>'width:180px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">  
                  <?php echo $formProvider->labelEx($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
                  <?php echo $formProvider->textField($oModelForm, 'mail', array('style'=>'width:265px;')); ?>      
                  <?php echo $formProvider->error($oModelForm, 'mail', array('style'=>'width:265px;')); ?>
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
   <div class="toolbox_table_first_cell_button_left">
      <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('synchronizeProvidersFromExternalDB') . '\''; ?>      
      <?php echo FWidget::showIconImageButton('synchronizeProvidersFromExternalDB', 'refresh_arrow_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWPROVIDERS_REFRESH_BTN_DESCRIPTION'), $sAction); ?>   
   </div>
   <div class="toolbox_table_first_cell_button">      
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
         'htmlOptions'=>array('width'=>80),
      ),
      array(
         'name'=>'mail',
         'htmlOptions'=>array('width'=>150),
      ),
      array(
         'name'=>'nConsumption',
         'header'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTION') . FString::STRING_SPACE . date('Y'),
         'value'=>'FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($data->id, date(\'Y\'), false)) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')',
         'htmlOptions'=>array('width'=>100, 'style'=>'text-align:right'),
      ),
      array(
         'name'=>'nConsumptionAddContractingProcedures',
         'header'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTIONADDCONTRACTINGPROCEDURES') . FString::STRING_SPACE . date('Y'),
         'value'=>'FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($data->id, date(\'Y\'), true)) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')',
         'htmlOptions'=>array('width'=>150, 'style'=>'text-align:right'),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateProvider", array("nIdForm"=>$data->primaryKey))', '(FApplication::canUpdateDeleteProvider($data->primaryKey, FApplication::MODULE_PURCHASES_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailProvider", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteProvider", array("nIdForm"=>$data->primaryKey))', '((FApplication::canUpdateDeleteProvider($data->primaryKey, FApplication::MODULE_PURCHASES_MANAGEMENT)) && (' . $sAllowManageProvider . '))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>