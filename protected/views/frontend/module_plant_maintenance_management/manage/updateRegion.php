<div class="form">
   <?php $formRegion = $this->beginWidget('CActiveForm', array(
      'id'=>'region-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/updateRegion', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_UPDATEREGION_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formRegion->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRegion->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formRegion->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formRegion->labelEx($oModelForm, 'area_m2', array('style'=>'width:200px;')); ?>
               <?php echo $formRegion->textField($oModelForm, 'area', array('style'=>'width:150px;')); ?>
               <?php echo $formRegion->error($oModelForm, 'area', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <?php echo $formRegion->labelEx($oModelForm, 'image', array('style'=>'width:392px;')); ?>
            
            <?php if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oModelForm->image))) { ?>
               <div class="rectangle_content" style="width:200px; height:150px;">
                  <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oModelForm->image; ?>" width="200px" height="150px" />
               </div>
               <br>
            <?php } ?>
                      
            <?php echo $formRegion->fileField($oModelForm, 'image', array('style'=>'width:300px;')); ?>      
            <?php echo $formRegion->error($oModelForm, 'image', array('style'=>'width:300px;')); ?>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>