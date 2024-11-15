<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/sections.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_DIGITAL_DIARY_MANAGEMENT_HEADER_LINE_SECTIONS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formSection = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-section-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewSections'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formSection->labelEx($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formSection->textField($oModelForm, 'name', array('style'=>'width:200px;')); ?>
               <?php echo $formSection->error($oModelForm, 'name', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formSection->labelEx($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formSection->textField($oModelForm, 'description', array('style'=>'width:350px;')); ?>
               <?php echo $formSection->error($oModelForm, 'description', array('style'=>'width:350px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('digitalDiarySections', FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT, 'DigitalDiarySections', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
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
         'htmlOptions'=>array('width'=>250),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>460),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateSection", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailSection", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteSection", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?> 

<div class="form">
   <?php $formSectionNotification = $this->beginWidget('CActiveForm', array(
      'id'=>'digitaldiary-section-notification-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/manage/viewSections'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ), 
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_association_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_association_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_association_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formSectionNotification->labelEx($oModelFormAssociation, 'id_section', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->dropDownList($oModelFormAssociation, 'id_section', CHtml::listData(DigitalDiarySections::getDigitalDiarySections(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->error($oModelFormAssociation, 'id_section', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formSectionNotification->labelEx($oModelFormAssociation, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->textField($oModelFormAssociation, 'mail', array('style'=>'width:300px;')); ?>
               <?php echo $formSectionNotification->error($oModelFormAssociation, 'mail', array('style'=>'width:300px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formSectionNotification->labelEx($oModelFormAssociation, 'only_recv_urgent_events', array('style'=>'width:200px;')); ?>
               <?php echo $formSectionNotification->checkBox($oModelFormAssociation, 'only_recv_urgent_events', array('style'=>'width:10px;')); ?>
               <?php echo $formSectionNotification->error($oModelFormAssociation, 'only_recv_urgent_events', array('style'=>'width:200px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('digitalDiarySectionsNotifications', FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT, 'DigitalDiarySectionsNotifications', FString::STRING_EMPTY, 'only_recv_urgent_events', $this, true); ?>
   </div>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_2',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAssociationFilters->search(),
   'filter'=>$oModelFormAssociationFilters,
   'columns'=>array(
      array(
         'name'=>'id_section',
         'value'=>'DigitalDiarySections::getDigitalDiarySectionName($data->id_section)',
         'filter'=>CHtml::listData(DigitalDiarySections::getDigitalDiarySections(), 'id', 'name'),
         'htmlOptions'=>array('width'=>250),
      ),
      array(
         'name'=>'mail',
         'htmlOptions'=>array('width'=>400),
      ),
      array(
         'name'=>'only_recv_urgent_events',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYSECTIONSNOTIFICATIONS_FIELD_ONLYRECVURGENTEVENTS_ABBREVIATION'),
         'value'=>'($data->only_recv_urgent_events) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>60),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateSectionNotification", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailSectionNotification", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteSectionNotification", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>