<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/forms_turn_events.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->formTurnEvent->date), '{2}'=>$oModelForm->formTurnEvent->owner, '{3}'=>Yii::t('system', 'SYS_TURN_' . substr($oModelForm->formTurnEvent->turn, 2))))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_DESCRIPTION'); ?>
</div>

<?php $sRefreshRegionsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/refreshFormTurnEventLinesRegions');
      $sRefreshEquipmentsUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/refreshFormTurnEventLinesEquipments');
      $sJsRefreshDisappearEquipmentOthers = "jquerySimpleAnimationFadeAppearDisappearTableCell('#id_equipment_others', false, 1.0, 1000)";      

      $bReadOnly = !FModuleDigitalDiaryManagement::allowUpdateFormTurnEvent($oModelForm->formTurnEvent->id);
      
      $sCurrentUser = Users::getUserEmployeeFullName(Yii::app()->user->id);
?>

<div class="form">
   <?php $formFormTurnEventEmployee = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-form-turn-event-employee-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$oModelForm->id_form_turn_event)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>

   <div class="form_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_EMPLOYEE_NEW_DESCRIPTION'); ?>
   </div>
   <div class="form_content">
      <div class="first_row">
         <?php if (!$bReadOnly) { ?>
            <div class="cell">
               <?php echo $formFormTurnEventEmployee->labelEx($oModelFormEmployee, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formFormTurnEventEmployee->dropDownList($oModelFormEmployee, 'name', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), array(array(FApplication::EMPLOYEE_RESPONSABILITY_BOSS, FApplication::EMPLOYEE_DEPARTMENT_OPERATING_TURN), array(null, FApplication::EMPLOYEE_DEPARTMENT_OPERATING, true), array(FApplication::EMPLOYEE_RESPONSABILITY_RESPONSIBLE, FApplication::EMPLOYEE_DEPARTMENT_OPERATING), array(FApplication::EMPLOYEE_RESPONSABILITY_AUXILIAR, FApplication::EMPLOYEE_DEPARTMENT_OPERATING)), null, true), 'full_name', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formFormTurnEventEmployee->error($oModelFormEmployee, 'name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="cell" class="row buttons" style="vertical-align:top">
               <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD_ARROW'), array('class'=>'form_button_submit', 'style'=>'height:60px')); ?>
            </div>
         <?php } ?>
         <div class="last_cell">
            <?php 
            $this->widget('zii.widgets.grid.CGridView', array(
               'id'=>'id_CGridView',
               'template'=>'{items} {pager}',
               'ajaxUpdate'=>false,
               'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
               'pager'=>FGrid::getNavigationButtons(),
               'dataProvider'=>$oModelFormEmployee->search($oModelForm->id_form_turn_event),
               'columns'=> array(
                  array(
                     'name'=>'name',
                     'htmlOptions'=>array('width'=>400),
                  ),
                  FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTurnEventEmployee", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_turn_event))', 'FModuleDigitalDiaryManagement::allowDeleteFormTurnEventEmployee($data->primaryKey)'),
               ),
               'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
            )); ?>
         </div>
      </div> 
   </div>      
   
   <?php $this->endWidget(); ?>
</div>

<div class="form" style="padding-top:20px;">
   <?php $formFormTurnEventComments = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-form-turn-event-comments-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$oModelForm->id_form_turn_event)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>

   <div class="form_header">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_COMMENTS_NEW_DESCRIPTION'); ?>
   </div>
   <div class="form_content">
      <div class="first_row">
         <?php 
         if (!$bReadOnly) { ?>
         <div class="cell">
            <?php echo $formFormTurnEventComments->labelEx($oModelFormTurnEvent, 'comments', array('style'=>'width:300px;')); ?>
            <?php echo $formFormTurnEventComments->textArea($oModelFormTurnEvent, 'comments', array('style'=>'width:300px; height:100px; resize:none;')); ?>
            <?php echo $formFormTurnEventComments->error($oModelFormTurnEvent, 'comments', array('style'=>'width:300px;')); ?>
         </div>
         <div class="cell" class="row buttons" style="vertical-align:top">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD_ARROW'), array('class'=>'form_button_submit', 'style'=>'height:130px')); ?>
         </div>
   <?php } ?>
         <div class="last_cell">
            <?php echo $oModelFormTurnEvent->comments;?>
         </div>
      </div> 
   </div>      

   <?php $this->endWidget(); ?>
</div>

<?php if (!$bReadOnly) { ?>
   <br/>
   <div class="form">
      <?php $formFormTurnEventLine = $this->beginWidget('CActiveForm', array(
         'id'=>'digitaldiary-form-turn-event-line-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/main/updateFormTurnEvent', array('nIdForm'=>$oModelForm->id_form_turn_event)),
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
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'section_name', array('style'=>'width:300px;')); ?>
                  <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'section_name', CHtml::listData(DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($oModelForm->id_form_turn_event), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'section_name', array('style'=>'width:300px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'urgent', array('style'=>'width:120px;')); ?>
                  <?php echo $formFormTurnEventLine->checkBox($oModelForm, 'urgent', array('style'=>'width:10px;')); ?>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'urgent', array('style'=>'width:120px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>                                                                                                                                                     
                  <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_zone', CHtml::listData(Zones::getZones(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;', 'onchange'=>$sJsRefreshDisappearEquipmentOthers . ';aj(\'' . $sRefreshRegionsUrl . '&nIdZone=\' + this.value, null, \'id_region\');' . ';aj(\'' . $sRefreshEquipmentsUrl . '&nIdRegion=\', null, \'id_equipment\');')); ?>           
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'id_zone', array('style'=>'width:300px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>                                                                                                                                                     
                  <div id="id_region">
                     <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_region', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  </div>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'id_region', array('style'=>'width:300px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
                  <div id="id_equipment">
                     <?php echo $formFormTurnEventLine->dropDownList($oModelForm, 'id_equipment', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  </div>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'id_equipment', array('style'=>'width:300px;')); ?>
               </div>
               <div class="last_cell">
                  <div id="id_equipment_others" class="last_cell_content_expand_collapse_hidden">
                     <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
                     <?php echo $formFormTurnEventLine->textField($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
                     <?php echo $formFormTurnEventLine->error($oModelForm, 'equipment', array('style'=>'width:300px;')); ?>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">  
                  <?php echo $formFormTurnEventLine->labelEx($oModelForm, 'description', array('style'=>'width:705px;')); ?>  
                  <?php echo $formFormTurnEventLine->textArea($oModelForm, 'description', array('class'=>'mceEditor', 'style'=>'width:885px; height:300px')); ?>
                  <?php echo $formFormTurnEventLine->error($oModelForm, 'description', array('style'=>'width:705px;')); ?>
               </div>
            </div>
         </div> 
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit', 'onclick'=>'tinyMCE.triggerSave(true, true);')); ?>
         </div>     
      </div>
        
      <?php $this->endWidget(); ?>
   </div>
<?php } ?>

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

<?php $oDigitalDiaryFormTurnEventSections = DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($oModelForm->id_form_turn_event); ?>

<?php $i = 1; $sPadding = '40px';
foreach($oDigitalDiaryFormTurnEventSections as $oDigitalDiaryFormTurnEventSection) { 
   if ($i == 1) {
   ?><br><?php 
   }?>

   <div class="toolbox_table">
      <div class="toolbox_table_cell_description">      
         <div class="row_emphasis">
            <div class="cell" style="width:420px;">
               <?php echo FString::castStrToUpper($oDigitalDiaryFormTurnEventSection->name); ?>
            </div>
         </div>
      </div>
      <div class="toolbox_table_cell_button">      
         <?php echo FWidget::showToolboxExporterData('digitalDiaryFormTurnEventLines_' . $oDigitalDiaryFormTurnEventSection->id, FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT, 'DigitalDiaryFormTurnEventLines', $oModelForm->id_form_turn_event . ',' . $oDigitalDiaryFormTurnEventSection->name, 'urgent', $this, true); ?>
      </div>
   </div>
   
   <?php
   if ($i == count($oDigitalDiaryFormTurnEventSections)) $sPadding = '0px';
   
   $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'id_CGridView_2',
      'template'=>'{items} {pager}',
      'ajaxUpdate'=>false,
      'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
      'pager'=>FGrid::getNavigationButtons(),
      'dataProvider'=>$oModelForm->search($oModelForm->id_form_turn_event, $oDigitalDiaryFormTurnEventSection->name),
      'rowCssClassExpression'=>'($data->send) ? \'completed\' : \'no_completed\'',
      'columns'=> array(
         array(
            'name'=>'hour',
            'htmlOptions'=>array('width'=>40),
         ),
         array(
            'name'=>'zone',
            'htmlOptions'=>array('width'=>125),
         ),
         array(
            'name'=>'region',
            'htmlOptions'=>array('width'=>125),
         ),
         array(
            'name'=>'equipment',
            'htmlOptions'=>array('width'=>125),
         ),
         array(
            'name'=>'urgent',
            'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT_ABBREVIATION'),
            'value'=>'($data->urgent) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
            'htmlOptions'=>array('width'=>50),
         ),
         array(
            'type'=>'raw',
            'name'=>'description',
            'value'=>'FString::getAbbreviationSentence(strip_tags($data->description), 300)', 
            'htmlOptions'=>array('width'=>250),
         ),
         FGrid::getSendButton('Yii::app()->controller->createUrl("notifyFormTurnEventLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_turn_event))', 'FModuleDigitalDiaryManagement::allowNotifyFormTurnEventLine($data->primaryKey)'),
         FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormTurnEventLine", array("nIdForm"=>$data->primaryKey))', 'FModuleDigitalDiaryManagement::allowUpdateFormTurnEventLine($data->primaryKey)'),
         FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormTurnEventLine", array("nIdForm"=>$data->primaryKey))'),
         FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormTurnEventLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_turn_event))', 'FModuleDigitalDiaryManagement::allowDeleteFormTurnEventLine($data->primaryKey)'),
      ),
      'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
   ));
   
   $sNotifications = FString::STRING_EMPTY;
   $oDigitalDiaryFormTurnEventSectionNotifications = DigitalDiaryFormTurnEventSectionsNotifications::getDigitalDiaryFormTurnEventSectionNotificationsByIdFormFK($oDigitalDiaryFormTurnEventSection->id);
   foreach($oDigitalDiaryFormTurnEventSectionNotifications as $oDigitalDiaryFormTurnEventSectionNotification) {
      if (strlen($sNotifications) > 0) $sNotifications .= ', ' . $oDigitalDiaryFormTurnEventSectionNotification->mail; 
      else $sNotifications = $oDigitalDiaryFormTurnEventSectionNotification->mail; 
      
      if ($oDigitalDiaryFormTurnEventSectionNotification->only_recv_urgent_events) $sNotifications .= ' (' . Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_SECTION_NOTIFICATION_URGENT') . ')';  
   }

   ?>
   <div class="item-description-note">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_SECTION_NOTIFICATIONS', array('{1}'=>$sNotifications)); ?>
   </div>
   
   <div style="padding-top: <?php echo $sPadding;?>"></div> 
   <?php $i++;
}
?>
   
<?php
if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)) { ?>
   <div class="row_emphasis" style="margin-top:40px;">
      <div class="cell" style="width:420px;">
         <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_UPDATEFORMTURNEVENT_HEADER_SECTION_PLANT_MONITORING_FORM_TURN_ROUND')); ?>
      </div>
   </div>

   <?php     
   $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'id_CGridView',
      'template'=>'{items} {pager}',
      'ajaxUpdate'=>false,
      'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
      'pager'=>FGrid::getNavigationButtons(),
      'dataProvider'=>$oModelFormFilters->search($oModelForm->id_form_turn_event),
      'columns'=>array(
         array(
            'name'=>'user_name',
            'htmlOptions'=>array('width'=>235),
         ),
         array(
            'name'=>'name',
            'htmlOptions'=>array('width'=>475),
         ),
         FGrid::getDetailButton('Yii::app()->controller->createUrl("frontend/' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/main/viewDetailFormTurnRound", array("nIdForm"=>$data->primaryKey))'),
      ),
      'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
   ));
}
?>

<div class="form">
   <div class="row buttons">
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsTurnEvents') . '\'')); ?>
   </div>
</div>