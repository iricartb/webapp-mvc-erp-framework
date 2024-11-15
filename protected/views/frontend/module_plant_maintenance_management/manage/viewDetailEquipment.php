<?php if ((!is_null($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oModelForm->image))) { ?>
   <div style="display:table">
      <div class="rectangle_content">
         <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oModelForm->image; ?>" width="200px" height="150px" />
      </div>
      <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
         <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$oModelForm,
                'attributes'=>array(
                    array(
                       'name'=>'name',  
                       'value'=>Equipments::getEquipmentName($oModelForm->id),
                    ),
                    array(
                       'name'=>'tag',
                    ),
                    array(
                       'name'=>'manufacturer',
                    ),
                    array(
                       'name'=>'installation_date',
                       'value'=>(!FString::isNullOrEmpty($oModelForm->installation_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->installation_date, false) : FString::STRING_EMPTY,
                    ),
                    array(
                       'name'=>'model',
                    ),
                    array(
                       'name'=>'serial_number',
                    ),
                    array(
                       'name'=>'dimension_x',
                       'value'=>(!is_null($oModelForm->dimension_x)) ? $oModelForm->dimension_x . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
                    ),
                    array(
                       'name'=>'dimension_y',
                       'value'=>(!is_null($oModelForm->dimension_y)) ? $oModelForm->dimension_y . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
                    ),
                    array(
                       'name'=>'dimension_z',
                       'value'=>(!is_null($oModelForm->dimension_z)) ? $oModelForm->dimension_z . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
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
            'name'=>'name',
            'value'=>Equipments::getEquipmentName($oModelForm->id),
         ),
         array(
            'name'=>'tag',
         ),
         array(
            'name'=>'manufacturer',
         ),
         array(
            'name'=>'installation_date',      
            'value'=>(!FString::isNullOrEmpty($oModelForm->installation_date)) ? FDate::getTimeZoneFormattedDate($oModelForm->installation_date, false) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'model',
         ),
         array(
            'name'=>'serial_number',
         ),
         array(
            'name'=>'dimension_x',
            'value'=>(!is_null($oModelForm->dimension_x)) ? $oModelForm->dimension_x . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
         ),
         array(
            'name'=>'dimension_y',
            'value'=>(!is_null($oModelForm->dimension_y)) ? $oModelForm->dimension_y . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
         ),
         array(
            'name'=>'dimension_z',
            'value'=>(!is_null($oModelForm->dimension_z)) ? $oModelForm->dimension_z . FString::STRING_SPACE . Yii::t('system', 'SYS_METER') : FString::STRING_EMPTY,  
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
} ?>