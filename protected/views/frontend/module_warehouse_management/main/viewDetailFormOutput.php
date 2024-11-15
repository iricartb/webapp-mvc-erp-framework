<?php 
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
         'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_' . $oModelForm->type),
      ),
      array(
         'name'=>'code',
      ),
      array(
         'name'=>'id_provider',
         'value'=>Providers::getProviderName($oModelForm->id_provider),
      ),
      array(
         'name'=>'employee',
      ),
      array(
         'name'=>'employee_department',
         'value'=>(!FString::isNullOrEmpty($oModelForm->employee_department)) ? Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->employee_department) : FString::STRING_EMPTY,
      ),
      array(
         'name'=>'id_form_working_part',
      ),
      array(
         'name'=>'comments',
      ),
   ),
   'nullDisplay'=>FString::STRING_EMPTY,
));
?>

<div style="padding-top:20px"></div>

<?php 
foreach ($oModelFormArticles as $oModelFormArticle) {
   $oArticle = Articles::getArticle($oModelFormArticle->id_article);
   
   $sArticleIPE = FString::STRING_EMPTY;
   if ($oModelFormArticle->article_ipe) $sArticleIPE = ' - <font color="green"><b>' . Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMOUTPUTARTICLES_FIELD_ARTICLEIPE') . '</b></font>';

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