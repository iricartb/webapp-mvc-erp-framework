<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsSpecialWorkingParts::getFormSpecialWorkingPart($oModelFormPreventionMean->id_form_special_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_meansipes.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTMEANSIPES_HEADER', array('{1}'=>$oModelFormPreventionMean->id_form_special_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php } ?>

<div class="form_header">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTMEANSIPES_FORM_NEW_DESCRIPTION'); ?>
</div>

<div class="cell">
   <div class="form">
      <?php $formSpecialWorkingPartPreventionMean = $this->beginWidget('CActiveForm', array(
         'id'=>'form-special-working-part-prevention-mean-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$oModelFormPreventionMean->id_form_special_working_part)),
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
                  <?php echo $formSpecialWorkingPartPreventionMean->labelEx($oModelFormPreventionMean, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formSpecialWorkingPartPreventionMean->dropDownList($oModelFormPreventionMean, 'name', CHtml::listData(PreventionMeans::getPreventionMeans(), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formSpecialWorkingPartPreventionMean->error($oModelFormPreventionMean, 'name', array('style'=>'width:300px;')); ?>
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
      <?php $formSpecialWorkingPartIPE = $this->beginWidget('CActiveForm', array(
         'id'=>'form-special-working-part-ipe-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$oModelFormIPE->id_form_special_working_part)),
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
                  <?php echo $formSpecialWorkingPartIPE->labelEx($oModelFormIPE, 'name', array('style'=>'width:300px;')); ?>
                  <?php echo $formSpecialWorkingPartIPE->dropDownList($oModelFormIPE, 'name', CHtml::listData(IPEs::getIPEs(), 'name', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
                  <?php echo $formSpecialWorkingPartIPE->error($oModelFormIPE, 'name', array('style'=>'width:300px;')); ?>
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
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMSPECIALWORKINGPARTMEANSIPES_FORM_GRID_DESCRIPTION'); ?>
</div>

<div class="cell" style="width:350px">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormPreventionMean->search($oModelFormPreventionMean->id_form_special_working_part),
   'columns'=> array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>340),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormSpecialWorkingPartPreventionMean", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_special_working_part))'),
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
   'dataProvider'=>$oModelFormIPE->search($oModelFormIPE->id_form_special_working_part),
   'columns'=> array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>340),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormSpecialWorkingPartIPE", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_special_working_part))'),
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
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormSpecialWorkingPartEmployees', array('nIdForm'=>$oModelFormPreventionMean->id_form_special_working_part)) . '\'')); 
      ?>
      <?php 
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_LAST_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('updateFormSpecialWorkingPartMeansIPEs', array('nIdForm'=>$oModelFormPreventionMean->id_form_special_working_part)) . '\'')); 
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