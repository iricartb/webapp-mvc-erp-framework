<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/methods.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WORKING_PARTS_MANAGEMENT_HEADER_LINE_METHODS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formMethod = $this->beginWidget('CActiveForm', array(
      'id'=>'method-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->textField($oModelForm, 'code', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'code', array('style'=>'width:360px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'description', array('style'=>'width:180px;')); ?>
               <?php echo $formMethod->textArea($oModelForm, 'description', array('style'=>'width:630px; height:40px; overflow:auto; resize:none')); ?>
               <?php echo $formMethod->error($oModelForm, 'description', array('style'=>'width:360px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_working_part', array('style'=>'width:140px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:160px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_maintenance_working_part', array('style'=>'width:160px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formMethod->labelEx($oModelForm, 'visible_special_working_part', array('style'=>'width:140px;')); ?>
               <?php echo $formMethod->checkBox($oModelForm, 'visible_special_working_part', array('style'=>'width:10px;')); ?>
               <?php echo $formMethod->error($oModelForm, 'visible_special_working_part', array('style'=>'width:140px;')); ?>
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('methods', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'Methods', FString::STRING_EMPTY, 'visible_working_part,visible_maintenance_working_part,visible_special_working_part', $this, true); ?>
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
         'name'=>'code',
         'htmlOptions'=>array('width'=>100),
      ),
      array(
         'name'=>'description',
         'value'=>'FString::getAbbreviationSentence($data->description, 35)',
         'htmlOptions'=>array('width'=>280),
      ),
      array(
         'name'=>'visible_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLEWORKINGPART'),
         'value'=>'($data->visible_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'visible_maintenance_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLEMAINTENANCEWORKINGPART'),
         'value'=>'($data->visible_maintenance_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>110),
      ),
      array(
         'name'=>'visible_special_working_part',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLESPECIALWORKINGPART'),
         'value'=>'($data->visible_special_working_part) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
         'filter'=>array(1=>Yii::t('system', 'SYS_YES'), 0=>Yii::t('system', 'SYS_NO')),
         'htmlOptions'=>array('width'=>110),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateMethod", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailMethod", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteMethod", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>

<div class="form">
   <?php $formMethodRisk = $this->beginWidget('CActiveForm', array(
      'id'=>'method-risk-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'),
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_RISK_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_RISK_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formMethodRisk->labelEx($oModelFormAssociationRisk, 'id_method', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->dropDownList($oModelFormAssociationRisk, 'id_method', CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->error($oModelFormAssociationRisk, 'id_method', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formMethodRisk->labelEx($oModelFormAssociationRisk, 'id_risk', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->dropDownList($oModelFormAssociationRisk, 'id_risk', CHtml::listData(Risks::getRisks(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodRisk->error($oModelFormAssociationRisk, 'id_risk', array('style'=>'width:300px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('methodsRisks', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'MethodsRisks', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_2',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAssociationRiskFilters->search(),
   'filter'=>$oModelFormAssociationRiskFilters,
   'columns'=>array(    
      array(
         'name'=>'id_method',                      
         'value'=>'FString::getAbbreviationSentence(Methods::getMethodName($data->id_method), 45)',
         'filter'=>CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'),
         'htmlOptions'=>array('width'=>355),
      ),
      array(
         'name'=>'id_risk',
         'value'=>'Risks::getRiskName($data->id_risk)',
         'filter'=>CHtml::listData(Risks::getRisks(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateMethodRisk", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailMethodRisk", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteMethodRisk", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>

<div class="form">
   <?php $formMethodIPE = $this->beginWidget('CActiveForm', array(
      'id'=>'method-ipe-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/manage/viewMethods'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ), 
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_association_ipe_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_association_ipe_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_association_ipe_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_IPE_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_ipe_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_IPE_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formMethodIPE->labelEx($oModelFormAssociationIPE, 'id_method', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->dropDownList($oModelFormAssociationIPE, 'id_method', CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->error($oModelFormAssociationIPE, 'id_method', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formMethodIPE->labelEx($oModelFormAssociationIPE, 'id_ipe', array('style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->dropDownList($oModelFormAssociationIPE, 'id_ipe', CHtml::listData(IPEs::getIPEs(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formMethodIPE->error($oModelFormAssociationIPE, 'id_ipe', array('style'=>'width:300px;')); ?>   
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
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWMETHODS_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('methodsIPEs', FApplication::MODULE_WORKING_PARTS_MANAGEMENT, 'MethodsIPEs', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_3',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAssociationIPEFilters->search(),
   'filter'=>$oModelFormAssociationIPEFilters,
   'columns'=>array(    
      array(
         'name'=>'id_method',                      
         'value'=>'FString::getAbbreviationSentence(Methods::getMethodName($data->id_method), 45)',
         'filter'=>CHtml::listData(Methods::getMethods(), 'id', 'cbDescription'),
         'htmlOptions'=>array('width'=>355),
      ),
      array(
         'name'=>'id_ipe',
         'value'=>'IPEs::getIPEName($data->id_ipe)',
         'filter'=>CHtml::listData(IPEs::getIPEs(), 'id', 'name'),
         'htmlOptions'=>array('width'=>355),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateMethodIPE", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailMethodIPE", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteMethodIPE", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>