<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/timetables.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_ACCESS_CONTROL_MANAGEMENT_HEADER_LINE_TIMETABLES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_DESCRIPTION'); ?>
</div>

<?php
$sJsChangeTypeTimetable = 'function onChangeTypeTimetable() {
                              if (document.getElementById("AccessControlTimetables_type_0").checked) {
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].value = "";
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].value = "";
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].disabled = true;
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].disabled = true;   
                              }
                              else {
                                 document.getElementsByName("AccessControlTimetables[hour1_t2]")[0].disabled = false;
                                 document.getElementsByName("AccessControlTimetables[hour2_t2]")[0].disabled = false;
                              }
                           };';
?>

<div class="form">
   <?php $formTimetable = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-timetable-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/viewTimetables'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'name', array('style'=>'width:230px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'name', array('style'=>'width:230px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'name', array('style'=>'width:230px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'abbreviation', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'abbreviation', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'abbreviation', array('style'=>'width:230px;')); ?>
            </div>
         </div>
         <div class="row">
            <?php if (is_null($oModelForm->type)) $oModelForm->type = FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS; ?>
            <?php $sDisableHours = FString::STRING_EMPTY;
                  if ($oModelForm->type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
                     $sDisableHours = 'disabled';
                  } ?>
            <div class="last_cell">
               <?php
               $oTypeTimetableList = array(FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_TYPE_CONTINUOUS'), FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_TYPE_SHIFT'));
               echo $formTimetable->radioButtonList($oModelForm, 'type', $oTypeTimetableList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp', 'onclick'=>$sJsChangeTypeTimetable . 'onChangeTypeTimetable();', 'labelOptions'=>array('class'=>'label_rb')));
               ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour1_t1', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour1_t1', true, false, '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour1_t1', array('style'=>'width:130px;')); ?>       
            </div>
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour2_t1', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour2_t1', true, false, '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour2_t1', array('style'=>'width:130px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour1_t2', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour1_t2', true, ($sDisableHours == 'disabled'), '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour1_t2', array('style'=>'width:130px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'hour2_t2', array('style'=>'width:130px;')); ?>
               <?php $this->widget('CJuiDateTimePicker', FForm::getTimePickerAttributes($oModelForm, 'hour2_t2', true, ($sDisableHours == 'disabled'), '130px', FString::STRING_EMPTY, null)); ?>
               <?php echo $formTimetable->error($oModelForm, 'hour2_t2', array('style'=>'width:130px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formTimetable->labelEx($oModelForm, 'tolerance', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->textField($oModelForm, 'tolerance', array('style'=>'width:130px;')); ?>
               <?php echo $formTimetable->error($oModelForm, 'tolerance', array('style'=>'width:250px;')); ?>
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

<div class="toolbox_table">
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWTIMETABLES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('accessControlTimetables', FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT, 'AccessControlTimetables', FString::STRING_EMPTY, 'tolerance', $this, true); ?>
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
         'name'=>'hour1_t1',
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'hour2_t1',
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'hour1_t2',
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'hour2_t2',
         'htmlOptions'=>array('width'=>110),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateTimetable", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailTimetable", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteTimetable", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>