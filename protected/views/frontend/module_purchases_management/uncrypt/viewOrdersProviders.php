<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/orders_providers.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_HEADER_LINE_ORDERS_PROVIDERS')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php
   $formFilterPurchasesStatisticOrdersProviders = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-statistic-orders-providers-filter-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/uncrypt/viewOrdersProviders'),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="last_form_graph_option_content"> 
      <div class="first_row">
         <div class="cell">
            <?php echo $formFilterPurchasesStatisticOrdersProviders->labelEx($oModelFormFilters, 'sTypeHighchart'); ?>
            <?php echo $formFilterPurchasesStatisticOrdersProviders->dropDownList($oModelFormFilters, 'sTypeHighchart', array(FApplication::TYPE_HIGHCHART_GRAPHIC_BARS=>Yii::t('system', 'SYS_HIGHCHART_GRAPHIC_BARS'), FApplication::TYPE_HIGHCHART_GRAPHIC_COLUMNS=>Yii::t('system', 'SYS_HIGHCHART_GRAPHIC_COLUMNS'), FApplication::TYPE_HIGHCHART_GRAPHIC_CAKE=>Yii::t('system', 'SYS_HIGHCHART_GRAPHIC_CAKE'), FApplication::TYPE_HIGHCHART_GRAPHIC_SEMICIRCLE=>Yii::t('system', 'SYS_HIGHCHART_GRAPHIC_SEMICIRCLE')), array('style'=>'width:200px;', 'onchange'=>'document.getElementById(\'purchases-statistic-orders-providers-filter-form\').submit();')); ?>                                                    
         </div>
         <div class="last_cell">
            <?php echo $formFilterPurchasesStatisticOrdersProviders->labelEx($oModelFormFilters, 'nYear'); ?>
            <?php echo $formFilterPurchasesStatisticOrdersProviders->dropDownList($oModelFormFilters, 'nYear', FForm::getLastFiveYears(), array('style'=>'width:200px;', 'onchange'=>'document.getElementById(\'purchases-statistic-orders-providers-filter-form\').submit();')); ?>                                                 
         </div>
      </div>
   </div>                                                                                                                                                                        
                                                                                                             
   <?php $this->endWidget(); ?>
   
   <div class="item-description-italic">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_FORM_GRAPH_DESCRIPTION'); ?>
   </div>

   <?php     
   if (count($oModelForm) > 0) {
      $oHighchartData = array();     
      foreach($oModelForm as $oPurchasesFormPurchaseOrder) {
         $nProviderConsumption = Providers::getProviderConsumptionByYear($oPurchasesFormPurchaseOrder->id_provider, $oModelFormFilters->nYear, true);
         if ($nProviderConsumption != 0) {
            array_push($oHighchartData,
               array(
                  'name'=>FString::castStrToUpper(Providers::getProviderName($oPurchasesFormPurchaseOrder->id_provider)),
                  'y'=>floatval($nProviderConsumption),
               )
            ); 
         }
      }
      
      if (count($oHighchartData) > 0) {   
         ?>
         <div class="form_content" style="padding-bottom:20px; color:#9d5901;">
         <?php  
         if ($oModelFormFilters->sTypeHighchart == FApplication::TYPE_HIGHCHART_GRAPHIC_CAKE) {
            $this->Widget('HighchartsWidget', array(
               'options'=>array(
                  'chart'=>array(
                     'plotBackgroundColor'=>null,
                     'plotBorderWidth'=>null,
                     'plotShadow'=>false,
                     'type'=>'pie',
                     'marginTop'=>75,
                     'height'=>600, 
                   ),
                   
                  'title'=>array('style'=>array('fontFamily'=>'verdana', 'fontSize'=>'12px'), 'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_TITLE', array('{1}'=>$oModelFormFilters->nYear))),

                  'tooltip'=>array('pointFormat'=>'{series.name}: {point.y:.2f}€ ({point.percentage:.1f}%)'),
                  
                  'plotOptions'=>array(
                     'pie'=>array(
                        'allowPointSelect'=>true,
                        'cursor'=>'pointer', 
                        'dataLabels'=>array('enabled'=>false),
                        'showInLegend'=>true,
                     ),
                  ),
                  
                  'legend'=>array(
                      'layout'=>'vertical',  
                      'align'=>'left',
                      'height'=>550,
                      'maxHeight'=>550,
                      'itemStyle'=>array(
                         'fontSize'=>'11px',
                         'fontWeight'=>'none',
                      )
                  ),
                  
                  'series'=>array(
                     array(       
                        'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_SERIE_NAME'),
                        'colorByPoint'=>true, 
                        'data'=>$oHighchartData,
                        'dataLabels'=>array(
                           'enabled'=>true,
                           'color'=>'black',
                           'align'=>'right',
                           'format'=>'{point.y:.2f}€',
                           'y'=>10,
                        ),
                     ),  
                  ),
                  
                  'credits'=>array(
                     'enabled'=>false,
                  )  
               )
            ));
         }
         else if ($oModelFormFilters->sTypeHighchart == FApplication::TYPE_HIGHCHART_GRAPHIC_SEMICIRCLE) {
            $this->Widget('HighchartsWidget', array(
               'options'=>array(
                  'chart'=>array(
                     'plotBackgroundColor'=>null,
                     'plotBorderWidth'=>null,
                     'plotShadow'=>false,
                     'type'=>'pie',
                     'marginTop'=>75,
                     'height'=>600,  
                   ),
                   
                  'title'=>array('style'=>array('fontFamily'=>'verdana', 'fontSize'=>'12px'), 'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_TITLE', array('{1}'=>$oModelFormFilters->nYear))),

                  'tooltip'=>array('pointFormat'=>'{series.name}: {point.y:.2f}€ ({point.percentage:.1f}%)'),
                  
                  'plotOptions'=>array(
                     'pie'=>array(
                        'allowPointSelect'=>true,
                        'cursor'=>'pointer',
                        'dataLabels'=>array('enabled'=>false),
                        'showInLegend'=>true,
                        'startAngle'=>-90,
                        'endAngle'=>90,
                        'center'=>array('50%', '60%'),
                     ),
                  ),
                  
                  'legend'=>array(
                      'layout'=>'vertical',  
                      'align'=>'left',
                      'height'=>550,
                      'maxHeight'=>550,
                      'itemStyle'=>array(
                         'fontSize'=>'11px',
                         'fontWeight'=>'none',
                      )
                  ),
                  
                  'series'=>array(
                     array(     
                        'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_SERIE_NAME'),
                        'colorByPoint'=>true, 
                        'innerSize'=>'50%',
                        'data'=>$oHighchartData,
                        'dataLabels'=>array(
                           'enabled'=>true,
                           'color'=>'black',
                           'align'=>'right',
                           'format'=>'{point.y:.2f}€',
                           'y'=>10,
                        ),
                     ),
                  ),
                  
                  'credits'=>array(
                     'enabled'=>false,
                  )  
               )
            ));
         }
         else if ($oModelFormFilters->sTypeHighchart == FApplication::TYPE_HIGHCHART_GRAPHIC_COLUMNS) {
            $this->Widget('HighchartsWidget', array(
               'options'=>array(
                  'chart'=>array(
                     'plotBackgroundColor'=>null,
                     'plotBorderWidth'=>null,
                     'plotShadow'=>false,
                     'type'=>'column',
                     'marginTop'=>75,
                     'height'=>600, 
                   ),
                   
                  'title'=>array('style'=>array('fontFamily'=>'verdana', 'fontSize'=>'12px'), 'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_TITLE', array('{1}'=>$oModelFormFilters->nYear))),

                  'tooltip'=>array('pointFormat'=>'{series.name}: {point.y:.2f}€'),

                  'xAxis'=>array(
                     'type'=>'category',
                     'labels'=>array(
                        'rotation'=>-90,
                     ),
                  ),
                  
                  'yAxis'=>array(
                     'min'=>0,
                     'title'=>array(
                        'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_AXIS_NAME'),
                     ),
                  ),

                  'legend'=>array(
                     'enabled'=>false,  
                  ),
                  
                  'series'=>array(
                     array(     
                        'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_SERIE_NAME'),
                        'colorByPoint'=>true, 
                        'data'=>$oHighchartData,
                        'dataLabels'=>array(
                           'enabled'=>true,
                           'rotation'=>-90,
                           'color'=>'black',
                           'align'=>'right',
                           'format'=>'{point.y:.2f}€',
                           'y'=>10,
                        ),
                     ),
                  ),
                 
                  'credits'=>array(
                     'enabled'=>false,
                  )  
               )
            ));
         }
         else if ($oModelFormFilters->sTypeHighchart == FApplication::TYPE_HIGHCHART_GRAPHIC_BARS) {
            $this->Widget('HighchartsWidget', array(
               'options'=>array(
                  'chart'=>array(
                     'plotBackgroundColor'=>null,
                     'plotBorderWidth'=>null,
                     'plotShadow'=>false,
                     'type'=>'bar',
                     'marginTop'=>75,
                     'height'=>2000,
                   ),
                   
                  'title'=>array('style'=>array('fontFamily'=>'verdana', 'fontSize'=>'12px'), 'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_TITLE', array('{1}'=>$oModelFormFilters->nYear))),

                  'tooltip'=>array('pointFormat'=>'{series.name}: {point.y:.2f}€'),

                  'xAxis'=>array(
                     'type'=>'category',
                     'labels'=>array(
                        'rotation'=>0,
                     ),
                  ),
                  
                  'yAxis'=>array(
                     'min'=>0,
                     'title'=>array(
                        'text'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_AXIS_NAME'),
                     ),
                  ),
  
                  'legend'=>array(
                     'enabled'=>false,  
                  ),
                  
                  'series'=>array(
                     array(     
                        'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_VIEWORDERSPROVIDERS_HIGHCHART_SERIE_NAME'),
                        'colorByPoint'=>true, 
                        'data'=>$oHighchartData,
                        'dataLabels'=>array(
                           'enabled'=>true,
                           'rotation'=>0,
                           'color'=>'black',
                           'align'=>'right',
                           'format'=>'{point.y:.2f}€',
                           'y'=>10,
                        ),
                     ),
                  ),
                  
                  'credits'=>array(
                     'enabled'=>false,
                  )  
               )
            ));
         }
         ?>
         </div>
         <?php
      }
   }
   ?>
</div>