<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_contracting_procedure.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner, '{3}'=>$oModelForm->contracting_procedure_expedient))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_DESCRIPTION'); ?>
</div>

<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_GENERAL'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureMoreInformation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_MORE_INFORMATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_DOCUMENTATION'); ?>
</div>
<div class="tab_button tab_active">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_RECORDS'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_NOTIFICATIONS'); ?>
</div>
<div class="form">
   <?php $formFormContractingProcedureRecord = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-record-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content container_tab">
      <div class="first_row">
         <div class="cell">
            <?php echo $formFormContractingProcedureRecord->labelEx($oModelFormContractingProcedureRecord, 'date', array('style'=>'width:120px;')); ?>
            <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormContractingProcedureRecord, 'date', true, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px')); ?>
            <?php echo $formFormContractingProcedureRecord->error($oModelFormContractingProcedureRecord, 'date', array('style'=>'width:120px;')); ?> 
         </div>
         <div class="last_cell">
            <?php echo $formFormContractingProcedureRecord->labelEx($oModelFormContractingProcedureRecord, 'provider', array('style'=>'width:480px;')); ?>
            <?php echo $formFormContractingProcedureRecord->textField($oModelFormContractingProcedureRecord, 'provider', array('style'=>'width:480px;')); ?>
            <?php echo $formFormContractingProcedureRecord->error($oModelFormContractingProcedureRecord, 'provider', array('style'=>'width:480px;')); ?>
         </div>
      </div>
      
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
      </div>
      
      <?php $this->endWidget(); ?>

      <br/><br/>
                                         
      <?php                               
      $this->widget('zii.widgets.grid.CGridView', array(
         'id'=>'id_CGridView',
         'template'=>'{items} {pager}',
         'ajaxUpdate'=>false,
         'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
         'pager'=>FGrid::getNavigationButtons(),
         'dataProvider'=>$oModelFormContractingProcedureRecordFilters->search($oModelForm->id),
         'columns'=>array(
            array(
               'name'=>'date',
               'value'=>'FDate::getTimeZoneFormattedDate($data->date, true)',                                                                                                                                                                                                          
               'htmlOptions'=>array('width'=>120),
            ),
            array(
               'name'=>'provider',
               'htmlOptions'=>array('width'=>590),
            ),                                                                                             
            FGrid::getPrintButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . "/report/formContractingProcedureRecordExport", array("nIdForm"=>$data->primaryKey, "sFormat"=>FFile::FILE_XLS_TYPE))'),
            FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormContractingProcedureRecord", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowDeleteFormContractingProcedureRecord($data->primaryKey)'),
         ),
         'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
      ));
      ?>  
   </div>
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
}
?>