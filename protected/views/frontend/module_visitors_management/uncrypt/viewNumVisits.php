<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/num_visits.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_NUM_VISITS')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_DESCRIPTION'); ?>
</div>

<?php
$sJsParameters = 'function createUrlParameters() {
                     var sFilterTypeVisit = "&filterTypeVisit=";
                     sFilterTypeVisit += document.getElementById("VisitorsStatisticVisits_type").value;
                     
                     var sFilterVisitor = "&filterVisitor=";
                     sFilterVisitor += document.getElementById("VisitorsStatisticVisits_visitor_full_name").value;
                     
                     var sFilterVisitorBusiness = "&filterVisitorBusiness=";
                     sFilterVisitorBusiness += document.getElementById("VisitorsStatisticVisits_visitor_business").value;
                       
                     var sTypeStatistic = "&typeStatistic=";
                     if (document.getElementById("VisitorsStatisticVisits_typeStatistic_0").checked) sTypeStatistic += document.getElementById("VisitorsStatisticVisits_typeStatistic_0").value;    
                     else if (document.getElementById("VisitorsStatisticVisits_typeStatistic_1").checked) sTypeStatistic += document.getElementById("VisitorsStatisticVisits_typeStatistic_1").value;
                     else sTypeStatistic += document.getElementById("VisitorsStatisticVisits_typeStatistic_2").value;
                     
                     var sTypePeriod = "&typePeriod=";
                     if (document.getElementById("VisitorsStatisticVisits_typePeriod_0").checked) sTypePeriod += document.getElementById("VisitorsStatisticVisits_typePeriod_0").value;    
                     else if (document.getElementById("VisitorsStatisticVisits_typePeriod_1").checked) sTypePeriod += document.getElementById("VisitorsStatisticVisits_typePeriod_1").value;
                     else sTypePeriod += document.getElementById("VisitorsStatisticVisits_typePeriod_2").value;
                     
                     return sFilterTypeVisit + sFilterVisitor + sFilterVisitorBusiness + sTypeStatistic + sTypePeriod; 
                  };';
?>

<div class="form">
   <?php $formVisit = $this->beginWidget('CActiveForm', array(
      'id'=>'visit-form',
      'method'=>'get',
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_FILTER_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_FILTER_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'type', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->dropDownList($oModelForm, 'type', array(FModuleVisitorsManagement::TYPE_VISIT_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_VISIT), FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_SUBCONTRACT), FModuleVisitorsManagement::TYPE_VISIT_PROVIDER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_PROVIDER), FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_COMMERCIAL), FModuleVisitorsManagement::TYPE_VISIT_OTHER=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_' . FModuleVisitorsManagement::TYPE_VISIT_OTHER)), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'type', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_full_name', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_full_name', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_full_name', array('style'=>'width:300px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formVisit->labelEx($oModelForm, 'visitor_business', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->textField($oModelForm, 'visitor_business', array('style'=>'width:300px;')); ?>
               <?php echo $formVisit->error($oModelForm, 'visitor_business', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_FILTER'), array('class'=>'form_button_submit', 'onclick'=>$sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/uncrypt/viewNumVisits') . '\' + createUrlParameters()')); ?>
      </div>     
   </div>
                                                                                                       
   <?php $this->endWidget(); ?>
</div>

<div class="form_graph_option_content">
   <?php
   $oTypeStatisticList = array(FModuleVisitorsManagement::STATISTIC_TYPE_BUSINESS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_STATISTIC_TYPE_BUSINESS'), FModuleVisitorsManagement::STATISTIC_TYPE_VISITOR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_STATISTIC_TYPE_VISITOR'), FModuleVisitorsManagement::STATISTIC_TYPE_VISIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_STATISTIC_TYPE_VISIT'));
   echo $formVisit->radioButtonList($oModelForm, 'typeStatistic', $oTypeStatisticList, array('separator'=>FString::STRING_SPACE, 'onclick'=>$sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/uncrypt/viewNumVisits') . '\' + createUrlParameters()'));
   ?>
</div>

<div class="last_form_graph_option_content">
   <?php
   $oTypePeriodsList = array(FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_DAY=>Yii::t('system', 'SYS_DAY'), FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_MONTH=>Yii::t('system', 'SYS_MONTH'), FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_YEAR=>Yii::t('system', 'SYS_YEAR'));
   echo $formVisit->radioButtonList($oModelForm, 'typePeriod', $oTypePeriodsList, array('separator'=>FString::STRING_SPACE, 'onclick'=>$sJsParameters . 'window.location.href=\'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/uncrypt/viewNumVisits') . '\' + createUrlParameters()')); 
   ?>
</div>

<?php
$sChartTitle = FString::STRING_EMPTY;
if ($oModelForm->typePeriod == FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_DAY) $sChartTitle .= FString::STRING_SPACE . ucwords(FDate::getMonthName(date('n'))) . FString::STRING_SPACE . date('Y');
else if ($oModelForm->typePeriod == FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_MONTH) $sChartTitle .= FString::STRING_SPACE . date('Y');
?>

<div class="item-description-italic">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_FORM_GRAPH_DESCRIPTION'); ?>
</div>

<?php 
$this->Widget('HighchartsWidget', array(
   'scripts' => array(
      'highcharts-more',
      'modules/exporting',
      'themes/grid'     
   ),           
   'options'=>array(
      'chart'=>array('type' =>'column'),
      
      'title'=>array('text' => Yii::t('system', 'SYS_TOP') . FString::STRING_SPACE . FApplication::STATISTIC_MAX_ITEMS . FString::STRING_SPACE . Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_GRAPH_STATISTIC_TITLE') . $sChartTitle),
      'xAxis'=>array(
         'categories' => $oModelForm->getXAxis()
      ),
      'yAxis'=>array(
         'title'=>array('text' => Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWNUMVISITS_GRAPH_STATISTIC_AXIS_Y_TITLE')),
         'min'=>0,
         'allowDecimals'=>false,      
      ),
      'tooltip'=>array(
         'headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>',
         'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
         'footerFormat'=>'</table>',
         'shared'=>true,
         'useHTML'=>true
      ),
      'series'=>$oModelForm->getColYAxis(),
      'credits'=>array('enabled' => false),
   )
));
?>