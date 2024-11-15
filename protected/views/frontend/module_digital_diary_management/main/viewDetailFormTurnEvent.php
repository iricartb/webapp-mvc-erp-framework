<div class="row_emphasis" style="background-color:<?php echo '#' . FModulePlantMonitoringManagement::HEADER_MAIN_COLOR;?>">
   <div style="display:table-cell">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT) . '/boss.png'; ?>">
   </div>
   <div style="display:table-cell; padding-left:5px; vertical-align:middle;">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'PAGE_VIEWDETAILFORMTURNEVENT_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->date), '{2}'=>$oModelForm->owner, '{3}'=>Yii::t('system', 'SYS_TURN_' . substr($oModelForm->turn, 2))))); ?>   
   </div>
</div>

<div style="padding-top:10px"></div>

<?php 
   $sEmployees = FString::STRING_EMPTY;
   $oDigitalDiaryFormTurnEventEmployees = DigitalDiaryFormTurnEventEmployees::getDigitalDiaryFormTurnEventEmployeesByIdFormFK($oModelForm->id);
   foreach($oDigitalDiaryFormTurnEventEmployees as $oDigitalDiaryFormTurnEventEmployee) {
      if (strlen($sEmployees) > 0) $sEmployees .= ', ' . $oDigitalDiaryFormTurnEventEmployee->name;
      else $sEmployees = $oDigitalDiaryFormTurnEventEmployee->name; 
   }
?>

<?php 
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->date, false),
      ),
      array(
         'name'=>'turn',
         'value'=>Yii::t('system', 'SYS_TURN_' . substr($oModelForm->turn, 2)),
      ),
      array(
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMTURNEVENTEMPLOYEES_FIELD_EMPLOYEES'),
         'value'=>$sEmployees,
      ),
      array(
         'name'=>'comments',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div style="padding-top:10px"></div>

<?php $oDigitalDiaryFormTurnEventSections = DigitalDiaryFormTurnEventSections::getDigitalDiaryFormTurnEventSectionsByIdFormFK($oModelForm->id);
foreach($oDigitalDiaryFormTurnEventSections as $oDigitalDiaryFormTurnEventSection) { ?> 
   <div style="padding-top:30px"></div>
   
   <div class="row_emphasis">
      <div class="cell" style="width:420px;">
         <?php echo FString::castStrToUpper($oDigitalDiaryFormTurnEventSection->name); ?>
      </div>
   </div>
         
   <?php
   $oDigitalDiaryFormTurnEventLine = new DigitalDiaryFormTurnEventLines();
   $oDigitalDiaryFormTurnEventLines = $oDigitalDiaryFormTurnEventLine->getDigitalDiaryFormTurnEventLinesBySectionNameAndIdFormFK($oDigitalDiaryFormTurnEventSection->name, $oModelForm->id);
   
   foreach ($oDigitalDiaryFormTurnEventLines as $oDigitalDiaryFormTurnEventLine) {
      $this->widget('zii.widgets.CDetailView', array(
         'data'=>$oDigitalDiaryFormTurnEventLine,
         'attributes'=>array(
            array(
               'name'=>'hour',
            ),
            array(
               'name'=>'region',
            ),
            array(
               'name'=>'equipment',
            ),
            array(
               'name'=>'urgent', 
               'value'=>($oDigitalDiaryFormTurnEventLine->urgent) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
            ),
            'description:html',
         ),
         'nullDisplay'=>FString::STRING_EMPTY,
      ));  
      ?><div style="padding-top:10px"></div><?php
   }
}
?>