<?php 
   $dataCompleted = true;
   $oModelFormParent = FormsWorkingParts::getFormWorkingPart($oModelForm->id_form_working_part);
   if ((!is_null($oModelFormParent)) && ($oModelFormParent->data_completed == false)) $dataCompleted = false; 
   
   if (!$dataCompleted) { ?>
      <div class="item-header">
         <div class="item-header-image">
            <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/item_employees.png' ?>" />
         </div>
         <div class="item-header-text">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTEMPLOYEES_HEADER', array('{1}'=>$oModelForm->id_form_working_part))); ?>
         </div>
      </div>
      <div class="separator_30"></div>
<?php } ?>

<div class="form">
   <?php $formWorkingPartEmployee = $this->beginWidget('CActiveForm', array(
      'id'=>'form-working-part-employee-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormWorkingPartEmployees', array('nIdForm'=>$oModelForm->id_form_working_part)),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_add">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTEMPLOYEES_FORM_NEW_DESCRIPTION'); ?>
      </div>

      <?php
      try {
         ?>
         <div style="display:table-cell;">
            <?php
            if (!is_null($oModelFormEmployees)) {
               $this->widget('zii.widgets.grid.CGridView', array(
                  'id'=>'id_CGridView_2',
                  'template'=>'{items} {pager}',
                  'ajaxUpdate'=>false,
                  'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
                  'dataProvider'=>$oModelFormEmployees,
                  'columns'=>array(
                     array(
                        'name'=>'full_name',
                        'value'=>'FString::castStrToCapitalLetters(FString::castStrSpecialChars($data->full_name))',
                        'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEMPLOYEES_FIELD_NAME'),
                        'htmlOptions'=>array('width'=>250),
                     ),
                     array(
                        'name'=>'id_business',
                        'value'=>'$data->business->name',
                        'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEMPLOYEES_FIELD_BUSINESS'),
                        'htmlOptions'=>array('width'=>250),
                     ),
                     FGrid::getSelectorButton(FString::STRING_BOOLEAN_FALSE, FString::STRING_BOOLEAN_TRUE, '
                     document.getElementById(\'FormWorkingPartEmployees_name\').value = $(this).parent().parent().children(\':nth-child(1)\').text();
                     document.getElementById(\'FormWorkingPartEmployees_business\').value = $(this).parent().parent().children(\':nth-child(2)\').text();
                     document.getElementById(\'form-working-part-employee-form\').submit();
                     ', false),
                  ),
                  'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
               ));
            }
         ?>
         </div>
         <div style="display:table-cell; width:50%">
         <?php
            if (!is_null($oModelFormVisitors)) {
               $this->widget('zii.widgets.grid.CGridView', array(
                  'id'=>'id_CGridView_3',
                  'template'=>'{items} {pager}',
                  'ajaxUpdate'=>false,
                  'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
                  'dataProvider'=>$oModelFormVisitors,
                  'columns'=>array(
                     array(
                        'name'=>'visitor_full_name',
                        'value'=>'FString::castStrToCapitalLetters(FString::castStrSpecialChars($data->visitor_full_name))',
                        'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEMPLOYEES_FIELD_NAME'),
                        'htmlOptions'=>array('width'=>250),
                     ),
                     array(
                        'name'=>'visitor_business',
                        'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTEMPLOYEES_FIELD_BUSINESS'),
                        'htmlOptions'=>array('width'=>250),
                     ),
                     FGrid::getSelectorButton(FString::STRING_BOOLEAN_FALSE, FString::STRING_BOOLEAN_TRUE, '
                     document.getElementById(\'FormWorkingPartEmployees_name\').value = $(this).parent().parent().children(\':nth-child(1)\').text();
                     document.getElementById(\'FormWorkingPartEmployees_business\').value = $(this).parent().parent().children(\':nth-child(2)\').text();
                     document.getElementById(\'form-working-part-employee-form\').submit();
                     ', false),
                  ),
                  'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 10px;'),
               ));
            } 
         ?>
         </div>
         <?php
      } catch(Exception $oException) { }    
      ?>

      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formWorkingPartEmployee->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formWorkingPartEmployee->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formWorkingPartEmployee->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formWorkingPartEmployee->labelEx($oModelForm, 'business', array('style'=>'width:300px;')); ?>
               <?php echo $formWorkingPartEmployee->textField($oModelForm, 'business', array('style'=>'width:300px;')); ?>
               <?php echo $formWorkingPartEmployee->error($oModelForm, 'business', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<div class="item-description-italic">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'PAGE_VIEWFORMWORKINGPARTEMPLOYEES_FORM_GRID_DESCRIPTION'); ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search($oModelForm->id_form_working_part),
   'columns'=> array(
      array(
         'name'=>'name',
         'value'=>'FString::getAbbreviationSentence($data->name, 25)',
         'htmlOptions'=>array('width'=>300),
      ),
      array(
         'name'=>'business',
         'value'=>'FString::getAbbreviationSentence($data->business, 25)',
         'htmlOptions'=>array('width'=>430),
      ),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormWorkingPartEmployee", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_working_part))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<?php 
if (!$dataCompleted) { ?>
   <div class="separator_30"></div>
   <div class="form">
      <?php 
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('updateFormWorkingPart', array('nIdForm'=>$oModelForm->id_form_working_part)) . '\'')); 
      ?>
      <?php 
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_NEXT_STEP'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('updateFormWorkingPartEmployees', array('nIdForm'=>$oModelForm->id_form_working_part)) . '\'')); 
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
