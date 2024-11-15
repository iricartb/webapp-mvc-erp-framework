<?php if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oModelForm->image))) { ?>
   <div style="display:table">
      <div class="rectangle_content">
         <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oModelForm->image; ?>" width="200px" height="150px" />
      </div>
      <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
         <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$oModelForm,
                'attributes'=>array(
                    array(
                       'name'=>'name',  
                    ),
                    array(
                       'name'=>'area',
                       'value'=>(!is_null($oModelForm->area)) ? $oModelForm->area . FString::STRING_SPACE . Yii::t('system', 'SYS_SQUARE_METER') : FString::STRING_EMPTY,  
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
         ),
         array(
            'name'=>'area',
            'value'=>(!is_null($oModelForm->area)) ? $oModelForm->area . FString::STRING_SPACE . Yii::t('system', 'SYS_SQUARE_METER') : FString::STRING_EMPTY,  
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
} ?>