<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/financial_costs.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_FINANCIAL_COSTS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFINANCIALCOSTS_DESCRIPTION'); ?>
</div>

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">                                 
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWFINANCIALCOSTS_FORM_GRID_DESCRIPTION'); ?>
      </div>      
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesFinancialCosts', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesFinancialCosts', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
   'rowCssClassExpression'=>'($data->year > ((int) date(\'Y\'))) ? \'pending\' : (($data->year < ((int) date(\'Y\'))) ? \'finalized\' : \'running\')',
   'columns'=>array(
                 array(
                    'name'=>'year',
                    'htmlOptions'=>array('width'=>720),
                 ),
                 FGrid::getEditButton('Yii::app()->controller->createUrl("updateFinancialCost", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFinancialCost($data->id)', false),
                 FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFinancialCost", array("nIdForm"=>$data->primaryKey))'),
              ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<div class="row">
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTS_FIELD_YEAR_VALUE_PENDING');?>
   </div>
   
   <div class="cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_RUNNING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTS_FIELD_YEAR_VALUE_RUNNING');?>
   </div>

   <div class="last_cell">
      <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_FINALIZED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTS_FIELD_YEAR_VALUE_FINALIZED');?>
   </div>
</div>