<?php 
$oLastProvider = Articles::getArticleLastProvider($oModelForm->id); 
$sLastProvider = FString::STRING_EMPTY;
$sLastProviderPhone = FString::STRING_EMPTY;
$sLastProviderMail = FString::STRING_EMPTY;

if (count($oLastProvider) > 0) {
   if (!FString::isNullOrEmpty($oLastProvider[0])) {
      $oProvider = Providers::getProvider($oLastProvider[0]);
      if (!is_null($oProvider)) {
         $sLastProvider = $oProvider->name;   
         $sLastProviderPhone = $oProvider->phone;   
         $sLastProviderMail = $oProvider->mail;   
      }
   }
   else {
      if (!FString::isNullOrEmpty($oLastProvider[1])) $sLastProvider = $oLastProvider[1];   
   }   
}
   
if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES . $oModelForm->image))) { ?>
   <div style="display:table">
      <div class="rectangle_content">
         <img src="<?php echo FApplication::FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES . $oModelForm->image; ?>" width="150px" height="150px" />
      </div>
      <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
         <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$oModelForm,
                'attributes'=>array(
                  array(
                     'name'=>'id',
                     'value'=>Articles::getArticleCodeName($oModelForm->id),
                  ),
                  array(
                     'name'=>'name',
                  ),
                  array(
                     'name'=>'model',
                  ),
                  array(
                     'name'=>'id_subcategory',
                     'value'=>WarehouseArticlesSubcategories::getFullWarehouseArticleSubcategory($oModelForm->id_subcategory),
                  ),
                  array(
                     'name'=>'sLastProvider',
                     'value'=>$sLastProvider,
                  ),
                  array(
                     'name'=>'id_location_subcategory',
                     'value'=>WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oModelForm->id_location_subcategory),
                  ),
                  array(
                     'name'=>'sLastProviderPhone',
                     'value'=>$sLastProviderPhone,
                  ),
                  array(
                     'name'=>'sLastProviderMail',
                     'value'=>$sLastProviderMail,
                  ),
                  array(
                     'name'=>'code_barcode',
                  ),
                  array(
                     'name'=>'code_kks',
                  ),
                  array(
                     'name'=>'ipe',
                     'value'=>($oModelForm->ipe) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
                  ),
                  array(
                     'name'=>'absolete',
                     'value'=>($oModelForm->absolete) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
                  ),
                  array(
                     'name'=>'commonwealth',
                     'value'=>($oModelForm->commonwealth) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
                  ),
                  array(
                     'name'=>'description',
                  ),
                  array(
                     'name'=>'price_medium',
                     'value'=>FFormat::getFormatPrice($oModelForm->price_medium, false, true),
                  ),
                  array(
                     'name'=>'nPriceLast',
                     'value'=>FFormat::getFormatPrice(Articles::getArticleHistoricalPriceLast($oModelForm->id), false, true),
                  ),     
                  array(
                     'name'=>'last_input_date',
                     'value'=>(!FString::isNullOrEmpty(Articles::getArticleLastInputDate($oModelForm->id))) ? FDate::getTimeZoneFormattedDate(Articles::getArticleLastInputDate($oModelForm->id)) : FString::STRING_EMPTY,
                  ), 
                  array(
                     'name'=>'last_output_date',
                     'value'=>(!FString::isNullOrEmpty(Articles::getArticleLastOutputDate($oModelForm->id))) ? FDate::getTimeZoneFormattedDate(Articles::getArticleLastOutputDate($oModelForm->id)) : FString::STRING_EMPTY,
                  ),
                  array(
                     'name'=>'weight',
                     'value'=>FFormat::getFormatPrice($oModelForm->weight) . ' g',
                  ),
                  array(
                     'name'=>'volume',
                     'value'=>FFormat::getFormatPrice($oModelForm->volume) . ' cm³',
                  ),
                  array(
                     'name'=>'quantity_min',
                  ),
                  array(
                     'name'=>'quantity',
                  ),
                  array(
                     'name'=>'id_related_article',
                     'value'=>Articles::getArticleName($oModelForm->id_related_article),
                  ),
                  array(
                     'name'=>'id_equivalent_article',
                     'value'=>Articles::getArticleName($oModelForm->id_equivalent_article),
                  ),
               ),
               'nullDisplay'=>FString::STRING_EMPTY,
          ));
         ?>
      </div>
   </div>
<?php 
} else { 
   $this->widget('zii.widgets.CDetailView', array(
      'data'=>$oModelForm,
      'attributes'=>array(
         array(
            'name'=>'id',
            'value'=>Articles::getArticleCodeName($oModelForm->id),
         ),
         array(
            'name'=>'name',
         ),
         array(
            'name'=>'model',
         ),
         array(
            'name'=>'id_subcategory',
            'value'=>WarehouseArticlesSubcategories::getFullWarehouseArticleSubcategory($oModelForm->id_subcategory),
         ),
         array(
            'name'=>'sLastProvider',
            'value'=>$sLastProvider,
         ),
         array(
            'name'=>'id_location_subcategory',
            'value'=>WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory($oModelForm->id_location_subcategory),
         ),
         array(
            'name'=>'sLastProviderPhone',
            'value'=>$sLastProviderPhone,
         ),
         array(
            'name'=>'sLastProviderMail',
            'value'=>$sLastProviderMail,
         ),
         array(
            'name'=>'code_barcode',
         ),
         array(
            'name'=>'code_kks',
         ),
         array(
            'name'=>'ipe',
            'value'=>($oModelForm->ipe) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
         ),
         array(
            'name'=>'absolete',
            'value'=>($oModelForm->absolete) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
         ),
         array(
            'name'=>'commonwealth',
            'value'=>($oModelForm->commonwealth) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
         ),
         array(
            'name'=>'description',
         ),
         array(
            'name'=>'price_medium',
            'value'=>FFormat::getFormatPrice($oModelForm->price_medium, false, true),
         ),
         array(
            'name'=>'nPriceLast',
            'value'=>FFormat::getFormatPrice(Articles::getArticleHistoricalPriceLast($oModelForm->id), false, true),
         ),
         array(
            'name'=>'last_input_date',
            'value'=>(!FString::isNullOrEmpty(Articles::getArticleLastInputDate($oModelForm->id))) ? FDate::getTimeZoneFormattedDate(Articles::getArticleLastInputDate($oModelForm->id)) : FString::STRING_EMPTY,
         ), 
         array(
            'name'=>'last_output_date',
            'value'=>(!FString::isNullOrEmpty(Articles::getArticleLastOutputDate($oModelForm->id))) ? FDate::getTimeZoneFormattedDate(Articles::getArticleLastOutputDate($oModelForm->id)) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'weight',
            'value'=>FFormat::getFormatPrice($oModelForm->weight) . ' g',
         ),
         array(
            'name'=>'volume',
            'value'=>FFormat::getFormatPrice($oModelForm->volume) . ' cm³',
         ),
         array(
            'name'=>'quantity_min',
         ),
         array(
            'name'=>'quantity',
         ),
         array(
            'name'=>'id_related_article',
            'value'=>Articles::getArticleName($oModelForm->id_related_article),
         ),
         array(
            'name'=>'id_equivalent_article',
            'value'=>Articles::getArticleName($oModelForm->id_equivalent_article),
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
} ?>