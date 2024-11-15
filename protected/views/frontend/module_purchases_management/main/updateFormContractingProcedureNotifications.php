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
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_RECORDS'); ?>
</div> 
<div class="tab_button tab_active">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_NOTIFICATIONS'); ?>
</div>
<div class="form">
   <?php $formFormContractingProcedureNotification = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-notification-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content container_tab">
      <div class="first_row">
         <div class="cell">
            <?php echo $formFormContractingProcedureNotification->labelEx($oModelFormContractingProcedureNotification, 'start_date', array('style'=>'width:120px;')); ?>
            <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormContractingProcedureNotification, 'start_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px')); ?>
            <?php echo $formFormContractingProcedureNotification->error($oModelFormContractingProcedureNotification, 'start_date', array('style'=>'width:120px;')); ?> 
         </div>
         <div class="cell">
            <?php echo $formFormContractingProcedureNotification->labelEx($oModelFormContractingProcedureNotification, 'end_date', array('style'=>'width:120px;')); ?>
            <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormContractingProcedureNotification, 'end_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '120px')); ?>
            <?php echo $formFormContractingProcedureNotification->error($oModelFormContractingProcedureNotification, 'end_date', array('style'=>'width:120px;')); ?> 
         </div>
         <div class="last_cell">
            <?php echo $formFormContractingProcedureNotification->labelEx($oModelFormContractingProcedureNotification, 'public', array('style'=>'width:60px;')); ?>
            <?php echo $formFormContractingProcedureNotification->checkBox($oModelFormContractingProcedureNotification, 'public', array('style'=>'width:10px;')); ?>
            <?php echo $formFormContractingProcedureNotification->error($oModelFormContractingProcedureNotification, 'public', array('style'=>'width:60px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormContractingProcedureNotification->labelEx($oModelFormContractingProcedureNotification, 'message', array('style'=>'width:625px;')); ?>
            <?php echo $formFormContractingProcedureNotification->textField($oModelFormContractingProcedureNotification, 'message', array('style'=>'width:625px;')); ?>
            <?php echo $formFormContractingProcedureNotification->error($oModelFormContractingProcedureNotification, 'message', array('style'=>'width:625px;')); ?>
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
         'dataProvider'=>$oModelFormContractingProcedureNotificationFilters->search($oModelForm->id),
         'columns'=>array(
            array(
               'name'=>'start_date',
               'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, false)',                                                                                                                                                                                                          
               'htmlOptions'=>array('width'=>70),
            ),
            array(
               'name'=>'end_date',
               'value'=>'FDate::getTimeZoneFormattedDate($data->end_date, false)',
               'htmlOptions'=>array('width'=>70),
            ),
            array(
               'name'=>'message',
               'htmlOptions'=>array('width'=>350),
            ),
            array(
               'name'=>'id_user',
               'value'=>'(!FString::isNullOrEmpty($data->id_user)) ? Users::getUserEmployeeFullName($data->id_user) : FString::STRING_EMPTY',
               'htmlOptions'=>array('width'=>140),
            ),
            array(
               'name'=>'public',
               'value'=>'($data->public) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
               'htmlOptions'=>array('width'=>80, 'style'=>'text-align:center'),
            ), 
            FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormContractingProcedureNotification", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowDeleteFormContractingProcedureNotification($data->primaryKey)'),
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