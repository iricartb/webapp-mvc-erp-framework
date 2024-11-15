<script type="text/javascript">
   function setVisitorIdentificationFocus() {
	  setTimeout(function(){ $("#VisitorsVisits_visitor_identification").focus(); }, 1000);
   }
   
   function setVisitorVehiclePlateFocus() {
	  setTimeout(function(){ $("#VisitorsVisits_visitor_vehicle_plate").focus(); }, 1000);
   }
</script>

<script type="text/javascript">
   function STPadCaptLoad() {
      STPadCapt = document.getElementById('STPadCapt');
      
      nReturn = STPadCapt.DeviceOpen(0);
      if ((nReturn < 0) && (nReturn != -6)) {
         alert("Could not open device because of error " + nReturn);
         return;
      }
      
      if (STPadCapt.DeviceGetCount() > 0) {
         STPadCapt.ControlMirrorDisplay = 2;   // display bitmaps and signature in OCX window
      }
      
      pathname = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . Yii::app()->request->baseUrl . '/' . FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/signature_background.png'; ?>";
      
      // draw bitmap on LCD
      nReturn = STPadCapt.DisplaySetImageFromFile(0, 0, pathname);
      if (nReturn < 0) {  
         alert("Could not load bitmap because of error " + nReturn);
         STPadCapt.DeviceClose(0);
         return;
      }
      
      // set signature window
      nReturn = STPadCapt.SensorSetSignRect(0, 43, 0, 0);
      if (nReturn < 0) {   
         alert("Could not set signature window because of error " + nReturn);
         STPadCapt.DeviceClose();
         return;
      }

      // add hot spots
      nReturn = STPadCapt.SensorAddHotSpot(12, 9, 85, 33);
      if (nReturn < 0) { 
         alert("Could not add 'Cancel' hot spot because of error " + nReturn);
         STPadCapt.DeviceClose(0);
         return;
      }
      nReturn = STPadCapt.SensorAddHotSpot(117, 9, 85, 33);
      if (nReturn < 0) { 
         alert("Could not add 'Retry' hot spot because of error " + nReturn);
         STPadCapt.DeviceClose(0);
         return;
      }
      nReturn = STPadCapt.SensorAddHotSpot(222, 9, 85, 33);
      if (nReturn < 0) {
         alert("Could not add 'Confirm' hot spot because of error " + nReturn);
         STPadCapt.DeviceClose(0);
         return;
      }

      // start capturing
      nReturn = STPadCapt.SignatureStart();
      if (nReturn < 0) { 
         alert("Could not start capture process because of error " + nReturn);
         STPadCapt.DeviceClose();
         return;
      }
   }
</script>

<script type="text/javascript" for="STPadCapt" event="SensorHotSpotPressed(nHotSpotId)">
   STPadCapt_SensorHotSpotPressed(nHotSpotId)
</script>

<script type="text/javascript">
function STPadCapt_SensorHotSpotPressed(nHotSpotId) {
   switch (nHotSpotId) {
      case 0: // "Cancel" button: cancel capturing
         nReturn = STPadCapt.SignatureCancel();
         if (nReturn < 0) alert("Could not cancel capturing because of error " + nReturn);
         else {
            nReturn = STPadCapt.DeviceClose(0);
            if (nReturn < 0) alert("Could not close device because of error " + nReturn);
            document.STPadCaptDemo.StartBtn.disabled = false;   // enable "Start Demo" button
         }
         break;
         
      case 1: // "Retry" button: retry capturing
         nReturn = STPadCapt.SignatureRetry();
         if (nReturn < 0) alert("Could not erase signature because of error " + nReturn);
         break;
         
      case 2: // "OK" button: confirm capturing
         nReturn = STPadCapt.SignatureConfirm();
         if (nReturn < 0) alert("Could not confirm signature because of error " + nReturn);
         else {
            if (nReturn > 0) {
               // show Base64 encoded image
               document.getElementById('VisitorsVisits_visitor_signature').value = STPadCapt.SignatureSaveAsStreamEx(300, 0, 0, 203, 0, 0, 0);
            }
            // clean up
            STPadCapt.SensorClearHotSpots();
            STPadCapt.SensorClearSignRect();
            document.STPadCaptDemo.StartBtn.disabled = false;   // enable "Start Demo" button
         }
         break;
   }
}
</script>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/visits.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_VISITS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_DESCRIPTION'); ?>
</div>

<?php 
   $oVisitorsModuleParameters = VisitorsModuleParameters::getVisitorsModuleParameters();
   if (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) { ?>
   <div class="form">
      <?php $formVisit = $this->beginWidget('CActiveForm', array(
         'id'=>'visitors-visit-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewVisits'),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:onEventAfterValidate',
         ),
      )); ?>
           
      <div class="form_expand_collapse" >
         <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse'); setVisitorIdentificationFocus();" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_NEW_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_NEW_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="cell_header">
                  <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_VISIT'); ?>
               </div>
            </div>
			<div class="row">
			   <?php
			   if (!((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management))) { ?>
				   <div class="cell">
					  <?php echo $formVisit->labelEx($oModelForm, 'card_id', array('style'=>'width:185px;')); ?>
					  <?php echo $formVisit->dropDownList($oModelForm, 'card_id', CHtml::listData(VisitorsCards::getFreeVisitorsCards(), 'id', 'code'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT_ABBREVIATION'), 'style'=>'width:185px;')); ?>
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
                     $sAfterActionUpdateFirstNameField = "if ($.trim($(sAjData).filter(\'#first_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_first_name\').value = $.trim($(sAjData).filter(\'#first_name\').html());";
                     $sAfterActionUpdateMiddleNameField = "if ($.trim($(sAjData).filter(\'#middle_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_middle_name\').value = $.trim($(sAjData).filter(\'#middle_name\').html());";
                     $sAfterActionUpdateLastNameField = "if ($.trim($(sAjData).filter(\'#last_name\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_last_name\').value = $.trim($(sAjData).filter(\'#last_name\').html());";
                     $sAfterActionUpdateBusinessField = "if ($.trim($(sAjData).filter(\'#business\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_business\').value = $.trim($(sAjData).filter(\'#business\').html());";
                     $sAfterActionUpdateCommentsField = "if ($.trim($(sAjData).filter(\'#comments\').html()).length > 0) document.getElementById(\'VisitorsVisits_visitor_comments\').value = $.trim($(sAjData).filter(\'#comments\').html())";
                     
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
            
            <?php 
            if ((Modules::getIsAvaliableModuleByName(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (!is_null($oVisitorsModuleParameters)) && ($oVisitorsModuleParameters->biostar_card_management)) { ?>
               <div class="row">
                  <div class="cell_header">
                     <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_MANUALCARD'); ?>
                  </div>
               </div>
               <div class="row">
                  <div class="cell">
                     <?php echo $formVisit->labelEx($oModelForm, 'card_code', array('style'=>'width:190px;')); ?>
                     <?php echo $formVisit->textField($oModelForm, 'card_code', array('style'=>'width:190px;')); ?>
                     <?php echo $formVisit->error($oModelForm, 'card_code', array('style'=>'width:190px;')); ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formVisit->labelEx($oModelForm, 'card_information', array('style'=>'width:175px;')); ?>
                     <?php echo $formVisit->textField($oModelForm, 'card_information', array('style'=>'width:175px;')); ?>
                     <?php echo $formVisit->error($oModelForm, 'card_information', array('style'=>'width:175px;')); ?>
                  </div>
               </div>
               <div class="row">
                  <div class="last_cell">
                     <?php echo $formVisit->labelEx($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>
                     <?php echo $formVisit->dropDownList($oModelForm, 'id_group_device', CHtml::listData(AccessControlGroupsDevices::getAccessControlGroupsDevices(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
                     <?php echo $formVisit->error($oModelForm, 'id_group_device', array('style'=>'width:400px;')); ?>   
                  </div>
               </div>
            <?php
            }
            ?>
            
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
            
            <div class="row">
               <div class="cell_header">
                  <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_SIGNATURE'); ?>
               </div>     
            </div>
            <div class="row">
               <div class="last_cell">
                  <input type="button" value="<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_BUTTON_SIGNATURE_NAME');?>" onclick="STPadCaptLoad()">
               </div>
            </div>
            <div class="row">
               <div class="last_cell">   
                  <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/signature.png'; ?>" height="200px" width="300px">
                  <object id="STPadCapt" name="STPadCapt" height="100px" width="200px" style="position:relative; top:-65px; left:-253px" classid="clsid:3946312B-1829-4D4F-A2DF-CD35C8908BA1" viewastext>
                     <param name="_Version" value="131095">
                     <param name="_ExtentX" value="4842">
                     <param name="_ExtentY" value="1323">
                     <param name="_StockProps" value="0">
                  </object>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">
                  <?php echo $formVisit->hiddenField($oModelForm, 'visitor_signature', array('style'=>'width:400px; height:60px;')); ?>
                  <?php echo $formVisit->error($oModelForm, 'visitor_signature', array('style'=>'width:400px;')); ?>
               </div>
            </div>
         </div>
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
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
      
<div class="item-description-italic">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_GRID_DESCRIPTION'); ?>
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
   'columns'=> array(
      array(
         'name'=>'type',
         'value'=>'Yii::t("frontend_" . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), "MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_" . $data->type)',
         'filter'=>array(FModuleVisitorsManagement::TYPE_VISIT_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_VISIT), FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT), FModuleVisitorsManagement::TYPE_VISIT_PROVIDER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_PROVIDER), FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL), FModuleVisitorsManagement::TYPE_VISIT_OTHER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_OTHER)),
         'htmlOptions'=>array('width'=>145),
      ),
      array(
         'name'=>'visitor_full_name',
         'value'=>'FString::castStrToCapitalLetters(FString::castStrSpecialChars($data->visitor_full_name))',
         'htmlOptions'=>array('width'=>180),
      ),
      array(
         'name'=>'visitor_business',
         'htmlOptions'=>array('width'=>180),
      ),
      array(        
         'name'=>'employee',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISITS_FORM_HEADER_RESPONSIBLE'),
         'htmlOptions'=>array('width'=>180),
      ),
      array(
         'name'=>'card_code',
         'header'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_CARDCODE_ABBREVIATION'),
         'value'=>'FString::getAbbreviationSentence($data->card_code, 12)',
         'htmlOptions'=>array('width'=>60),
      ),
      array(
         'name'=>'start_date',
         'value'=>'FDate::getTimeZoneFormattedDate($data->start_date, true)',
         'filter'=>$this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormFilters, 'start_date', false, null, 'strtotime()'), true), 
         'htmlOptions'=>array('width'=>145),
      ),
      FGrid::getExitButton('Yii::app()->controller->createUrl("updateVisitStatus", array("nIdForm"=>$data->primaryKey))', '(!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateVisit", array("nIdForm"=>$data->primaryKey))', '(!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailVisit", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteVisit", array("nIdForm"=>$data->primaryKey))', '(Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>