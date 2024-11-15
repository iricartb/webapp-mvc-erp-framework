<?php if ((!FString::isNullOrEmpty($oModelForm->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image))) { ?>
   <div style="display:table">
      <div class="rectangle_content">
         <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_EMPLOYEES . $oModelForm->image; ?>" width="150px" height="150px" />
      </div>
      <div class="last_cell" style="vertical-align:top; padding-left:10px; width:100%;">   
         <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$oModelForm,
                'attributes'=>array(
                    array(
                       'name'=>'full_name',
                    ),
                    array(
                       'name'=>'identification',
                    ),
                    array(
                       'name'=>'num_employee',
                    ),
                    array(
                       'name'=>'id_business',
                       'value'=>Businesses::getBusinessName($oModelForm->id_business),
                    ),
                    array(
                       'name'=>'start_date',
                       'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date),
                    ),
                    array(
                       'name'=>'access_code_FIR',
                       'value'=>chunk_split($oModelForm->access_code_FIR, 20, FString::STRING_SPACE),
                    ),
                    array(
                       'name'=>'access_code_FIR_2',
                       'value'=>chunk_split($oModelForm->access_code_FIR_2, 20, FString::STRING_SPACE),
                    ),
                    array(
                       'name'=>'access_code',
                    ),
                    array(
                       'name'=>'access_information',
                    ),
                    array(
                       'name'=>'access_process_delay',
                       'value'=>($oModelForm->access_process_delay) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
                    ),
                    array(
                       'name'=>'access_tolerance',
                    ),
                    array(
                       'name'=>'show_visual_presence',
                       'value'=>($oModelForm->show_visual_presence) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
                    ),
                    array(
                       'name'=>'id_group_device',
                       'value'=>(!FString::isNullOrEmpty($oModelForm->id_group_device)) ? AccessControlGroupsDevices::getAccessControlGroupDeviceName($oModelForm->id_group_device) : FString::STRING_EMPTY,
                    ),
                    array(
                       'name'=>'id_biostar',
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
            'name'=>'full_name',
         ),
         array(
            'name'=>'identification',
         ),
         array(
            'name'=>'num_employee',
         ),
         array(
            'name'=>'id_business',
            'value'=>Businesses::getBusinessName($oModelForm->id_business),
         ),
         array(
            'name'=>'start_date',
            'value'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date),
         ),
         array(
            'name'=>'access_code_FIR',
            'value'=>chunk_split($oModelForm->access_code_FIR, 20, FString::STRING_SPACE),
         ),
         array(
            'name'=>'access_code_FIR_2',
            'value'=>chunk_split($oModelForm->access_code_FIR_2, 20, FString::STRING_SPACE),
         ),
         array(
            'name'=>'access_code',
         ),
         array(
            'name'=>'access_information',
         ),
         array(
            'name'=>'access_process_delay',
            'value'=>($oModelForm->access_process_delay) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
         ),
         array(
            'name'=>'access_tolerance',
         ),
         array(
            'name'=>'show_visual_presence',
            'value'=>($oModelForm->show_visual_presence) ? Yii::t('system', 'SYS_YES') : Yii::t('system', 'SYS_NO'),
         ),
         array(
            'name'=>'id_group_device',
            'value'=>(!FString::isNullOrEmpty($oModelForm->id_group_device)) ? AccessControlGroupsDevices::getAccessControlGroupDeviceName($oModelForm->id_group_device) : FString::STRING_EMPTY,
         ),
         array(
            'name'=>'id_biostar',
         ),
      ),
      'nullDisplay'=>FString::STRING_EMPTY,
   ));
} ?>