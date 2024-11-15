<script type="text/javascript">
   function getFingerprintIdentificationRecord() {
      var sFingerprintIdentificationRecord = '';
       
      try {
          var oTCIBioStarMini = new ActiveXObject("TCI.BioStarMini");
          sFingerprintIdentificationRecord = oTCIBioStarMini.getFingerprintTemplates();
      } catch(oException) { alert(oException); }
      
      return sFingerprintIdentificationRecord;
   }
</script>

<div class="form">
   <?php $formEmployee = $this->beginWidget('CActiveForm', array(
      'id'=>'access-control-employee-biometric-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/maintenance/updateEmployeeBiometric', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_UPDATEEMPLOYEEBIOMETRIC_FORM_UPDATE_DESCRIPTION'); ?>
      </div>                    
      <div class="form_content">          
         <div class="cell">
   <?php $bImageAttachment = false; 
         if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image))) { 
            $bImageAttachment = true; ?>
            <div class="rectangle_content">
               <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image; ?>" width="100px" height="100px" />
            </div>
    
   <?php } ?>
         </div>
         <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
            <div class="first_row">
               <div class="cell">
                  <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint.png'; ?>" style="margin-top:15px; cursor:pointer;" onclick="document.getElementById('idAccessCodeFIR').value = getFingerprintIdentificationRecord(); if (document.getElementById('idAccessCodeFIR').value.length > 0) document.getElementById('idImageAccessCodeFIR2').src = '<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint.png'; ?>'" />
               </div>
               <div class="cell" style="vertical-align:top">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_code_FIR', array('style'=>'width:195px;')); ?>
                  <?php echo $formEmployee->textArea($oModelForm, 'access_code_FIR', array('id'=>'idAccessCodeFIR', 'style'=>'width:195px; height:140px; background-color:lightgray; resize:none;', 'readonly'=>'readonly')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_code_FIR', array('style'=>'width:195px;')); ?>
                  
                  <div style="position:relative; float:right; right:8px; top:-4px; background-color:white; cursor:pointer; border:1px solid gray;" onclick="document.getElementById('idAccessCodeFIR').value = ''; document.getElementById('idAccessCodeFIR2').value = ''; document.getElementById('idImageAccessCodeFIR2').src = '<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint_disabled.png'; ?>'">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16; ?>/sign_no_ok_1.png"/>
                  </div>
               </div>
               
               <div class="cell">
                  <img id="idImageAccessCodeFIR2" src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint_disabled.png'; ?>" style="margin-top:15px; cursor:pointer;" onclick="if (document.getElementById('idAccessCodeFIR').value.length > 0) document.getElementById('idAccessCodeFIR2').value = getFingerprintIdentificationRecord()" />
               </div>
               <div class="last_cell" style="vertical-align:top">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_code_FIR_2', array('style'=>'width:195px;')); ?>
                  <?php echo $formEmployee->textArea($oModelForm, 'access_code_FIR_2', array('id'=>'idAccessCodeFIR2', 'style'=>'width:195px; height:140px; background-color:lightgray; resize:none;', 'readonly'=>'readonly')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_code_FIR_2', array('style'=>'width:195px;')); ?>
               
                  <div style="position:relative; float:right; right:8px; top:-4px; background-color:white; cursor:pointer; border:1px solid gray;" onclick="document.getElementById('idAccessCodeFIR2').value = '';">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16; ?>/sign_no_ok_1.png"/>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_code', array('style'=>'width:180px;')); ?>
               </div>
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->textField($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'access_information', array('style'=>'width:180px;')); ?>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">
                  <?php echo $formEmployee->labelEx($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>
                  <?php echo $formEmployee->dropDownList($oModelForm, 'id_group_device', CHtml::listData(AccessControlGroupsDevices::getAccessControlGroupsDevices(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
                  <?php echo $formEmployee->error($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>   
               </div>
            </div>
         </div>
      </div> 
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
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

<script>
   if (document.getElementById('idAccessCodeFIR').value.length > 0) {
      document.getElementById('idImageAccessCodeFIR2').src = '<?php echo FApplication::FOLDER_IMAGES_GENERIC_48x48 . 'fingerprint.png'; ?>';   
   }
</script>