<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePlantMonitoringManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '/worker.png'; ?>">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'PAGE_VIEWDETAILFORMTURNROUND_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true), '{2}'=>$oModelForm->user_name, '{3}'=>$oModelForm->name))); ?>   
   </div>
</div>

<div style="padding-top:20px"></div>

<?php 
$sEmployees = FString::STRING_EMPTY;
$oDigitalDiaryFormTurnEventEmployees = DigitalDiaryFormTurnEventEmployees::getDigitalDiaryFormTurnEventEmployeesByIdFormFK($oModelForm->id);
foreach($oDigitalDiaryFormTurnEventEmployees as $oDigitalDiaryFormTurnEventEmployee) {
   if (strlen($sEmployees) > 0) $sEmployees .= ', ' . $oDigitalDiaryFormTurnEventEmployee->name;
   else $sEmployees = $oDigitalDiaryFormTurnEventEmployee->name; 
}                                                                                                                                                                                                  

$nCurrentMonitoringFormTurnRoundGroupForm = 0; 
$oMonitoringFormTurnRoundGroupForms = MonitoringFormsTurnRoundGroupForms::getMonitoringFormsTurnRoundGroupFormsByIdFormFK($oModelForm->id);
foreach($oMonitoringFormTurnRoundGroupForms as $oMonitoringFormTurnRoundGroupForm) { ?>
   <?php
   if ($nCurrentMonitoringFormTurnRoundGroupForm > 0) { ?>
      <div style="padding-top:30px"></div>
   <?php
   }
   ?>

   <div class="row_emphasis" style="background-color:<?php echo '#' . FModulePlantMonitoringManagement::HEADER_GROUP_FORM_COLOR;?>">
      <div class="cell" style="min-width:420px;">
         <?php echo FString::castStrToUpper($oMonitoringFormTurnRoundGroupForm->name) . ' (' . FString::castStrToUpper($oMonitoringFormTurnRoundGroupForm->description) . ')'; ?> 
      </div>
   </div>
   
   <?php 
   if ($nCurrentMonitoringFormTurnRoundGroupForm == 0) {
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oModelForm,
         'attributes'=>array(
            array(
               'name'=>'user_name',
            ),
            array(
               'name'=>'start_date',
               'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date, true),
            ),
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));
      ?>
      <div style="padding-top:10px"></div>
      <?php  
   }
   ?>
   
   <div style="padding-left:40px;">
      <?php      
      $oMonitoringFormTurnRoundForms = MonitoringFormsTurnRoundForms::getMonitoringFormsTurnRoundFormsByIdFormFK($oMonitoringFormTurnRoundGroupForm->id);
      foreach($oMonitoringFormTurnRoundForms as $oMonitoringFormTurnRoundForm) { ?>
         <div style="padding-top:20px"></div>
         
         <div class="row_emphasis" style="background-color:<?php echo '#' . FModulePlantMonitoringManagement::HEADER_FORM_COLOR;?>">
            <div class="first_row">
               <div class="cell" style="min-width:420px;">
                  <?php echo FString::castStrToUpper($oMonitoringFormTurnRoundForm->name) . ' (' . FString::castStrToUpper($oMonitoringFormTurnRoundForm->description) . ')'; ?> 
               </div>
            </div>
            <?php 
            if (!FString::isNullOrEmpty($oMonitoringFormTurnRoundForm->comments)) { ?>
               <div class="row">
                  <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_COMMENTS') . ': ' . $oMonitoringFormTurnRoundForm->comments; ?>    
               </div>
            <?php
            } ?>
         </div>
      <?php
         $oMonitoringFormTurnRoundFormQuestions = new MonitoringFormsTurnRoundFormsQuestions();
         $this->widget('zii.widgets.grid.CGridView', array(
            'template'=>'{items}',    
            'hideHeader'=>true,
            'dataProvider'=>$oMonitoringFormTurnRoundFormQuestions->search($oMonitoringFormTurnRoundForm->id),
            'columns'=>array(
               array(
                  'name'=>'description',
                  'htmlOptions'=>array('width'=>600),
               ),
               array(
                  'name'=>'field_value',
                  'value'=>'($data->field_type != FModulePlantMonitoringManagement::TYPE_QUESTION_FIELD_BIT) ? $data->field_value . FString::STRING_SPACE . $data->field_unit : (($data->field_value == \'1\') ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\'))',
                  'htmlOptions'=>array('width'=>140),
               ),
            ),
            'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
         ));     
      }
      ?>
   </div>
   <?php
   $nCurrentMonitoringFormTurnRoundGroupForm++;
}
?>