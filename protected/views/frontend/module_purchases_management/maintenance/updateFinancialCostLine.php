<div class="form">
   <?php $formFinancialCostLine = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-financial-cost-line-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateFinancialCostLine', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
               
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFINANCIALCOSTLINE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formFinancialCostLine->labelEx($oModelForm, 'group', array('style'=>'width:350px;')); ?>
               <?php echo $formFinancialCostLine->textField($oModelForm, 'group', array('style'=>'width:350px;')); ?>
               <?php echo $formFinancialCostLine->error($oModelForm, 'group', array('style'=>'width:350px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFinancialCostLine->labelEx($oModelForm, 'concept', array('style'=>'width:350px;')); ?>
               <?php echo $formFinancialCostLine->textField($oModelForm, 'concept', array('style'=>'width:350px;')); ?>
               <?php echo $formFinancialCostLine->error($oModelForm, 'concept', array('style'=>'width:350px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFinancialCostLine->labelEx($oModelForm, 'department', array('style'=>'width:200px;')); ?>
               <?php echo $formFinancialCostLine->dropDownList($oModelForm, 'department', array(FApplication::EMPLOYEE_DEPARTMENT_ADMINISTRATION=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_ADMINISTRATION'), FApplication::EMPLOYEE_DEPARTMENT_PREVENTION_SECURITY=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_PREVENTION_SECURITY'), FApplication::EMPLOYEE_DEPARTMENT_OPERATING=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_OPERATING'), FApplication::EMPLOYEE_DEPARTMENT_MANAGEMENT=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MANAGEMENT'), FApplication::EMPLOYEE_DEPARTMENT_LOGISTIC=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_LOGISTIC'), FApplication::EMPLOYEE_DEPARTMENT_MAINTENANCE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_MAINTENANCE'), FApplication::EMPLOYEE_DEPARTMENT_TECHNICAL_OFFICE=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_TECHNICAL_OFFICE')), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:200px;')); ?>
               <?php echo $formFinancialCostLine->error($oModelForm, 'department', array('style'=>'width:200px;')); ?>
            </div>  
            <div class="last_cell">  
               <?php echo $formFinancialCostLine->labelEx($oModelForm, 'max_price', array('style'=>'width:120px;')); ?>  
               <?php echo $formFinancialCostLine->textField($oModelForm, 'max_price', array('style'=>'width:120px;')) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR'); ?>  
               <?php echo $formFinancialCostLine->error($oModelForm, 'max_price', array('style'=>'width:120px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
   
   <?php $this->endWidget(); ?>
</div>

<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>

<div class="form" style="margin-top:40px;">
   <?php $formFinancialCostAccountingAccount = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-financial-cost-accounting-account-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/maintenance/updateFinancialCostLine', array('nIdForm'=>$oModelForm->id)),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFINANCIALCOSTLINE_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>                                                                                            
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFINANCIALCOSTLINE_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">  
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formFinancialCostAccountingAccount->labelEx($oModelFormAccountingAccount, 'account', array('style'=>'width:200px;')); ?>
               <?php echo $formFinancialCostAccountingAccount->textField($oModelFormAccountingAccount, 'account', array('style'=>'width:200px;')); ?>
               <?php echo $formFinancialCostAccountingAccount->error($oModelFormAccountingAccount, 'account', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFinancialCostAccountingAccount->labelEx($oModelFormAccountingAccount, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formFinancialCostAccountingAccount->textField($oModelFormAccountingAccount, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formFinancialCostAccountingAccount->error($oModelFormAccountingAccount, 'description', array('style'=>'width:300px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFINANCIALCOSTLINE_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('purchasesFinancialCostsAccountingAccounts', FApplication::MODULE_PURCHASES_MANAGEMENT, 'PurchasesFinancialCostsAccountingAccounts', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAccountingAccount->search($oModelForm->id),
   'columns'=>array(
      array(
         'name'=>'account',
         'htmlOptions'=>array('width'=>200),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>505),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFinancialCostAccountingAccount", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_financial_cost_line))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>