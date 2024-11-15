<?php 
if ($oModelForm->status == FModuleWarehouseManagement::STATUS_SUCCESS) {              
   $sColorStatus = 'green';
}
else if ($oModelForm->status == FModuleWarehouseManagement::STATUS_ALERT) {      
   $sColorStatus = 'orange';
}
else {
   $sColorStatus = 'red';
}
         
$this->widget('zii.widgets.CDetailView', array(
   'data'=>$oModelForm,
   'attributes'=>array(
      array(
         'name'=>'owner',
      ),
      array(
         'name'=>'date',
         'value'=>FDate::getTimeZoneFormattedDate($oModelForm->date, true),
      ),
      array(
         'name'=>'type',
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_' . $oModelForm->type),
      ),
      array(
         'name'=>'code',
      ),
      array(
         'name'=>'id_provider',
         'value'=>Providers::getProviderName($oModelForm->id_provider),
      ),
      array(
         'name'=>'comments',
      ),
      array(
         'type'=>'raw',
         'name'=>'nTotal',
         'value'=>'<font color="green">' . FFormat::getFormatPrice(WarehouseFormsInputs::getWarehouseFormInputTotalPriceCost($oModelForm->id)) . ' €</font>',
      ),
      array(
         'name'=>'status',
         'type'=>'raw',
         'value'=>'<b><font style="color:' . $sColorStatus . '">' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_' . $oModelForm->status) . '</font></b>',
      )
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div style="padding-top:20px"></div>

<?php 
foreach ($oModelFormArticles as $oModelFormArticle) {
   $oArticle = Articles::getArticle($oModelFormArticle->id_article);
   
   $sArticleIPE = FString::STRING_EMPTY;
   if ($oModelFormArticle->article_ipe) $sArticleIPE = ' - <font color="green"><b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLEIPE') . '</b></font>';

   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oModelFormArticle,
      'attributes'=>array(
         array(
            'type'=>'raw',
            'name'=>'article',                                                                                                                                                                                                                                                                                                                         
            'value'=>$oModelFormArticle->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . FString::STRING_SPACE . $oArticle->getFullName() . FString::STRING_SPACE . '<font color="green">' . FFormat::getFormatPrice($oModelFormArticle->price_cost, false, true) . ' </font>' . ' - [ ' . WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oModelFormArticle->id_location_subcategory) . ' ]' . $sArticleIPE,
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));  
}
?>