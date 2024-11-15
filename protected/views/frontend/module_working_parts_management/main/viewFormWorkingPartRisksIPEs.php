<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsWorkingParts::getFormWorkingPart($oModelFormRisk->id_form_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_risksipes.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTRISKSIPES_HEADER', array('{1}'=>$oModelFormRisk->id_form_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php } ?>

<div class="form_header">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTRISKSIPES_FORM_NEW_DESCRIPTION'); ?>
</div>

<div class="cell">
   <div class="form">
      <?php $formWorkingPartRisk = $this->beginWidget('CActiveForm', array(
         'id'=>'form-working-part-risk-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs', array('nIdForm'=>$oModelFormRisk->id_form_working_part)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
      
      <div class="form_content_popup_add">
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formWorkingPartRisk->labelEx($oModelFormRisk, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formWorkingPartRisk->dropDownList($oModelFormRisk, 'name', CHtml::listData(Risks::getRisks(), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formWorkingPartRisk->error($oModelFormRisk, 'name', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
         </div>
      </div>
          
      <?php $this->endWidget(); ?>
   </div>
</div>
<div class="last_cell">
   <div class="form">
      <?php $formWorkingPartIPE = $this->beginWidget('CActiveForm', array(
         'id'=>'form-working-part-ipe-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartRisksIPEs', array('nIdForm'=>$oModelFormIPE->id_form_working_part)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
      
      <div class="form_content_popup_add">
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formWorkingPartIPE->labelEx($oModelFormIPE, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formWorkingPartIPE->dropDownList($oModelFormIPE, 'name', CHtml::listData(IPEs::getIPEs(), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formWorkingPartIPE->error($oModelFormIPE, 'name', array('style'=>'width:300px;')); ?>
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
         </div>
      </div>
          
      <?php $this->endWidget(); ?>
   </div>
</div>
      
<div class="item-description-italic">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTRISKSIPES_FORM_GRID_DESCRIPTION'); ?>
</div>

<div class="cell" style="width:350px">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormRisk->search($oModelFormRisk->id_form_working_part),
   'columns'=> array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>340),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormWorkingPartRisk", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_working_part))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>
</div>
<div class="last_cell" style="width:350px">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_2',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormIPE->search($oModelFormIPE->id_form_working_part),
   'columns'=> array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>340),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormWorkingPartIPE", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_working_part))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>
</div>

<?php 
if (!$dataCompleted) { ?>
   <div class="separator_30"></div>
   <div class="form">
      <?php 
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormWorkingPartEmployees', array('nIdForm'=>$oModelFormRisk->id_form_working_part)) . '\'')); 
      ?>
      <?php 
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_LAST_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('updateFormWorkingPartRisksIPEs', array('nIdForm'=>$oModelFormRisk->id_form_working_part)) . '\'')); 
      ?>
   </div>
<?php 
}  
?>
<div class="separator_10"></div>
<?php 
if (Yii::app()->user->hasFlash('error')) { ?>
   <div class="flash-error">
      <?php echo Yii::app()->user->getFlash('error'); ?>
   </div> <?php 
} ?>