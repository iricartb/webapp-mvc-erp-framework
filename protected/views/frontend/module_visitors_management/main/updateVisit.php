<script type="text/javascript">
   function setVisitorIdentificationFocus() {
	  setTimeout(function(){ $("#VisitorsVisits_visitor_identification").focus(); }, 1000);
   }
   
   function setVisitorVehiclePlateFocus() {
	  setTimeout(function(){ $("#VisitorsVisits_visitor_vehicle_plate").focus(); }, 1000);
   }
</script>

<div class="form">
   <?php $formVisit = $this->beginWidget('CActiveForm', array(
      'id'=>'visitors-visit-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/updateVisit', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
         'afterValidate'=>'js:onEventAfterValidate',
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_UPDATEVISIT_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_VISIT'); ?>
            </div>
         </div>
         <div class="row">
			<?php
			$oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
			if (!((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management))) { ?>
               <div class="cell">
                  <?php echo $formVisit->labelEx($oModelForm, 'card_id', array('style'=>'width:185px;')); ?>
                  <?php echo $formVisit->dropDownList($oModelForm, 'card_id', CHtml::listData(VisitorsCards::getFreeVisitorsCards($oModelForm->card_id), 'id', 'code'), array('style'=>'width:185px;')); ?>
                  <?php echo $formVisit->error($oModelForm, 'card_id', array('style'=>'width:185px;')); ?>
               </div>
		    <?php 
		    } ?>
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'type', array('style'=>'width:185px;')); ?>
               <?php echo $formVisit->dropDownList($oModelForm, 'type', array(FModuleVisitorsManagement::TYPE_VISIT_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_VISIT), FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT), FModuleVisitorsManagement::TYPE_VISIT_PROVIDER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_PROVIDER), FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL), FModuleVisitorsManagement::TYPE_VISIT_OTHER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_OTHER)), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:185px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'type', array('style'=>'width:185px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_DATA'); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_first_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_first_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_middle_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_middle_name', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_last_name', array('style'=>'width:180px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_last_name', array('style'=>'width:180px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_identification', array('style'=>'width:180px;')); ?>
               <?php
                  $sUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/site/viewVisitorFields'); 
                  $sAfterActionUpdateFirstNameField = "if ($.trim($(data).filter(\'#first_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_first_name\').value = $.trim($(data).filter(\'#first_name\').html());";
                  $sAfterActionUpdateMiddleNameField = "if ($.trim($(data).filter(\'#middle_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_middle_name\').value = $.trim($(data).filter(\'#middle_name\').html());";
                  $sAfterActionUpdateLastNameField = "if ($.trim($(data).filter(\'#last_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_last_name\').value = $.trim($(data).filter(\'#last_name\').html());";
                  $sAfterActionUpdateBusinessField = "if ($.trim($(data).filter(\'#business\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_business\').value = $.trim($(data).filter(\'#business\').html());";
                  $sAfterActionUpdateCommentsField = "if ($.trim($(data).filter(\'#comments\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_comments\').value = $.trim($(data).filter(\'#comments\').html())";
                  
                  $sAfterAction = $sAfterActionUpdateFirstNameField . $sAfterActionUpdateMiddleNameField . $sAfterActionUpdateLastNameField . $sAfterActionUpdateBusinessField . $sAfterActionUpdateCommentsField;  
                  
                  echo $formVisit->textField($oModelForm, 'visitor_identification', array('style'=>'width:180px;', 'onchange'=>'var oData = { identification: this.value }; ajUpdateFields(\'' . $sUrl . '\', oData, "' . $sAfterAction . '")')); 
               ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_identification', array('style'=>'width:180px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_business', array('style'=>'width:394px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_business', array('style'=>'width:394px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_business', array('style'=>'width:394px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_vehicle', array('style'=>'width:185px;')); ?>
               <?php echo $formVisit->checkBox($oModelForm, 'visitor_vehicle', array('style'=>'width:20px;', 'onclick'=>'jquerySimpleAnimationFadeAppearDisappearTableCell(\'#id_visitor_vehicle\', this.checked, 1.0, 1000); setVisitorVehiclePlateFocus()')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_vehicle', array('style'=>'width:185px;')); ?>
            </div>
		    <div id="id_visitor_vehicle" class="last_cell_content_expand_collapse_<?php if ($oModelForm->visitor_vehicle == true) { echo 'show'; } else { echo 'hidden'; } ?>">
			   <div class="cell">
			  	 <?php echo $formVisit->labelEx($oModelForm, 'visitor_vehicle_plate', array('style'=>'width:180px;')); ?>
				 <?php echo $formVisit->textField($oModelForm, 'visitor_vehicle_plate', array('style'=>'width:180px;')); ?>
				 <?php echo $formVisit->error($oModelForm, 'visitor_vehicle_plate', array('style'=>'width:180px;')); ?>
			   </div>
			   <div class="last_cell">
			 	 <?php echo $formVisit->labelEx($oModelForm, 'visitor_destiny_vehicle', array('style'=>'width:185px;')); ?>
				 <?php echo $formVisit->dropDownList($oModelForm, 'visitor_destiny_vehicle', CHtml::listData(VisitorsDestinyVehicle::getVisitorsDestiniesVehicle(), 'cbIndexDescription', 'cbDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:185px;')); ?>
				 <?php echo $formVisit->error($oModelForm, 'visitor_destiny_vehicle', array('style'=>'width:185px;')); ?>
			   </div>
		    </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'reason', array('style'=>'width:400px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'reason', array('style'=>'width:400px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'reason', array('style'=>'width:400px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_comments', array('style'=>'width:400px;')); ?>
               <?php echo $formVisit->textArea($oModelForm, 'visitor_comments', array('style'=>'width:400px; height:60px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_comments', array('style'=>'width:400px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_RESPONSIBLE'); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'employee', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->dropDownList($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), null, null, true), 'identification', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php //echo FForm::textFieldAutoComplete($oModelForm, 'employee_identification', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), null, null, true), 'identification', 'full_name'), array('style'=>'width:400px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'employee_identification', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'employee_comments', array('style'=>'width:400px;')); ?>
               <?php echo $formVisit->textArea($oModelForm, 'employee_comments', array('style'=>'width:400px; height:60px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'employee_comments', array('style'=>'width:400px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>