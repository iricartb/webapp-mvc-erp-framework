<div class="form">
   <?php $formFormContractingProcedureLineObjectives = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-line-objectives-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureLineObjectives', array('nIdForm'=>$oModelForm->id)),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
         
   <div class="form_content_popup_modify">
      <?php $sAction = 'window.location = \'' . Yii::app()->controller->createUrl('createFormContractingProcedureLineObjective', array('nIdForm'=>$oModelForm->id)) . '\''; ?>      
      <?php echo FWidget::showIconImageButton('purchasesFormContractingProcedureLineObjectives', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINEOBJECTIVES_NEW_BTN_DESCRIPTION'), $sAction); ?>  
      <br/>
      
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINEOBJECTIVES_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <?php 
         $oPurchasesFormContractingProcedureLineObjectives = PurchasesFormsRequestOffersLinesObjectives::getPurchasesFormsRequestOffersLinesObjectivesByIdFormFK($oModelForm->id);
         if (count($oPurchasesFormContractingProcedureLineObjectives) > 0) {
            $nCurrentObjective = 1;
            foreach($oPurchasesFormContractingProcedureLineObjectives as $oPurchasesFormContractingProcedureLineObjective) {
               ?>
               <input type="hidden" name="PurchasesFormsRequestOffersLinesObjectives[ID][<?php echo $nCurrentObjective; ?>]" value="<?php echo $oPurchasesFormContractingProcedureLineObjective->id;?>">
               
               <div class="row">
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'bSelected', array('style'=>'width:64px; color:blue;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->checkBox($oPurchasesFormContractingProcedureLineObjective, 'bSelected', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[bSelected][' . $nCurrentObjective . ']', 'style'=>'width:10px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'bSelected', array('style'=>'width:64px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'quantity', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->textField($oPurchasesFormContractingProcedureLineObjective, 'quantity', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[quantity][' . $nCurrentObjective . ']', 'style'=>'width:60px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'quantity', array('style'=>'width:60px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'description', array('style'=>'width:366px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->textField($oPurchasesFormContractingProcedureLineObjective, 'description', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[description][' . $nCurrentObjective . ']', 'style'=>'width:366px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'description', array('style'=>'width:366px;')); ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'type', array('style'=>'width:125px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->dropDownList($oPurchasesFormContractingProcedureLineObjective, 'type', array(FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SERVICE=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURETYPE_VALUE_SERVICE'), FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_SUPPLY=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURETYPE_VALUE_SUPPLY'), FModulePurchasesManagement::TYPE_FORM_CONTRACTING_PROCEDURE_WORK=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURETYPE_VALUE_WORK')), array('name'=>'PurchasesFormsRequestOffersLinesObjectives[type][' . $nCurrentObjective . ']', 'style'=>'width:125px;')); ?>           
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'type', array('style'=>'width:125px;')); ?>
                  </div>
               </div>

               <div class="row">
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'id_financial_cost_line', array('style'=>'width:410px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->dropDownList($oPurchasesFormContractingProcedureLineObjective, 'id_financial_cost_line', CHtml::listData(PurchasesFinancialCostsLines::getPurchasesFinancialCostLines(), 'id', 'fullDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'name'=>'PurchasesFormsRequestOffersLinesObjectives[id_financial_cost_line][' . $nCurrentObjective . ']', 'style'=>'width:410px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'id_financial_cost_line', array('style'=>'width:410px;')); ?>
                  </div>

                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'estimated_date', array('style'=>'width:115px;')); ?>
                     <?php 
                     if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineObjective->estimated_date)) {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormContractingProcedureLineObjective, 'estimated_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '115px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedureLineObjective->estimated_date), $nCurrentObjective, 'PurchasesFormsRequestOffersLinesObjectives[estimated_date][' . $nCurrentObjective . ']'));
                     }
                     else {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormContractingProcedureLineObjective, 'estimated_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '115px', FString::STRING_EMPTY, FString::STRING_EMPTY, $nCurrentObjective, 'PurchasesFormsRequestOffersLinesObjectives[estimated_date][' . $nCurrentObjective . ']'));
                     } ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'estimated_date', array('style'=>'width:115px;')); ?>
                  </div> 
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'estimated_price', array('style'=>'width:125px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->textField($oPurchasesFormContractingProcedureLineObjective, 'estimated_price', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[estimated_price][' . $nCurrentObjective . ']', 'style'=>'width:125px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'estimated_price', array('style'=>'width:125px;')); ?>
                  </div>
                  <div class="last_cell" style="vertical-align:middle">
                     <a href="<?php echo Yii::app()->controller->createUrl("deleteFormContractingProcedureLineObjective", array("nIdForm"=>$oPurchasesFormContractingProcedureLineObjective->id, "nIdFormParent"=>$oPurchasesFormContractingProcedureLineObjective->id_form_request_offer_line))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                        <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" />
                     </a>
                  </div>
               </div>
               <div class="row">
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'accomplished', array('style'=>'width:64px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->checkBox($oPurchasesFormContractingProcedureLineObjective, 'accomplished', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[accomplished][' . $nCurrentObjective . ']', 'style'=>'width:10px;', 'disabled'=>'disabled')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'accomplished', array('style'=>'width:64px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'id_user', array('style'=>'width:312px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->textField($oPurchasesFormContractingProcedureLineObjective, 'id_user', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[id_user][' . $nCurrentObjective . ']', 'style'=>'width:312px;', 'disabled'=>'disabled', 'value'=>Users::getUserEmployeeFullName($oPurchasesFormContractingProcedureLineObjective->id_user))); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'id_user', array('style'=>'width:312px;')); ?>
                  </div>
                  <div class="cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'accomplished_date', array('style'=>'width:115px;')); ?>
                     <?php 
                     if (!FString::isNullOrEmpty($oPurchasesFormContractingProcedureLineObjective->accomplished_date)) {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormContractingProcedureLineObjective, 'accomplished_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '115px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oPurchasesFormContractingProcedureLineObjective->accomplished_date), $nCurrentObjective, 'PurchasesFormsRequestOffersLinesObjectives[accomplished_date][' . $nCurrentObjective . ']'));
                     }
                     else {
                        $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oPurchasesFormContractingProcedureLineObjective, 'accomplished_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '115px', FString::STRING_EMPTY, FString::STRING_EMPTY, $nCurrentObjective, 'PurchasesFormsRequestOffersLinesObjectives[accomplished_date][' . $nCurrentObjective . ']'));
                     } ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'accomplished_date', array('style'=>'width:115px;')); ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormContractingProcedureLineObjectives->labelEx($oPurchasesFormContractingProcedureLineObjective, 'accomplished_price', array('style'=>'width:125px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->textField($oPurchasesFormContractingProcedureLineObjective, 'accomplished_price', array('name'=>'PurchasesFormsRequestOffersLinesObjectives[accomplished_price][' . $nCurrentObjective . ']', 'style'=>'width:125px;')); ?>
                     <?php echo $formFormContractingProcedureLineObjectives->error($oPurchasesFormContractingProcedureLineObjective, 'accomplished_price', array('style'=>'width:125px;')); ?>
                  </div>
               </div>
               <?php
               if ($nCurrentObjective < count($oPurchasesFormContractingProcedureLineObjectives)) { ?>
                  <br/><hr>
               <?php } 
               $nCurrentObjective++; 
            }
         }
         ?> 
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURELINEOBJECTIVES_ACTION_MODIFY_CREATE_FORMPURCHASEORDER'), array('class'=>'form_button_submit')); ?>
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
}
?>