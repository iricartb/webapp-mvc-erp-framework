<?php      
class FForm {
    
   public static function validateAjaxForm($sFormName, $oForm) {
      if ((isset($_POST['ajax'])) && ($_POST['ajax'] === $sFormName)) {
         echo CActiveForm::validate($oForm);
         Yii::app()->end();
      }
   }
   
   public static function textFieldAutoComplete($oModel, $sAttribute, $oData, $oParameters = array(), $bForceSelection = true, $bNotForceSelectionValueId = false) {     
      $sId = get_class($oModel) . '_' . $sAttribute;
      $sName = get_class($oModel) . '[' . $sAttribute . ']';
      $sAttributeId = eval('return $oModel->' . $sAttribute . ';');
      $sAttributeValue = FString::STRING_EMPTY;

      if (strlen($sAttributeId) > 0) {
         if ($bForceSelection) {
            foreach($oData as $sKey => $sValue) {
               if ($sKey == $sAttributeId) $sAttributeValue = str_replace('"', '\'\'', $sValue);
            }
         }
         else $sAttributeValue = str_replace('"', '\'\'', $sAttributeId);   
      }
      
      $sParameters = FString::STRING_EMPTY;
      foreach($oParameters as $sKey => $sValue) {
         if (strtolower($sKey) == 'onchange') {
            $sJsOnChange = $sValue;  
         }
         else {
            $sParameters .= FString::STRING_SPACE . $sKey . '="' . $sValue . '"';   
         }        
      }  
     
      $sElement = "<input id=\"" . $sId . "\" name=\"" . $sName . "\" type=\"hidden\">
                  
                   <input id=\"idList_" . $sId . "\" list=\"idDataList_" . $sId . "\" onchange=\"jsChangeList_" . $sId . "(this.value);" . $sJsOnChange . "\"" . $sParameters . " type=\"text\" value=\"" . $sAttributeValue . "\">
                   <datalist id=\"idDataList_" . $sId . "\">";
                  
                   foreach($oData as $sKey => $sValue) {
                      $sElement .= "<option id=\"" . str_replace('"', '\'\'', $sKey) . "\" value=\"" . str_replace('"', '\'\'', $sValue) . "\">";   
                   }    
                 
      $sElement .= "</datalist>
                    <script type=\"text/javascript\">
                       function jsChangeList_" . $sId . "(sValue) {";
                       
                       if ($bForceSelection) {  
      $sElement .= "      var sId = $('#idDataList_" . $sId . " option[value=\"' + sValue + '\"]').attr('id');
                        
                          if (sId != null) {
                             $('#" . $sId . "').val(sId);
                          }
                          else {
                             $('#" . $sId . "').val('');
                             $('#idList_" . $sId . "').val('');                      
                          }";
                       }
                       else {
      $sElement .= "      var sId = $('#idDataList_" . $sId . " option[value=\"' + sValue + '\"]').attr('id');
                        
                          if (sId != null) {
                             $('#" . $sId . "').val(sId);";
                             
                             if ($bNotForceSelectionValueId) {
                                $sElement .= "$('#idList_" . $sId . "').val(sId);";
                              }
      $sElement .= "                           
                          }
                          else {
                             $('#" . $sId . "').val(sValue);                  
                          }";   
                       }
                          
      $sElement .= "   }";
                       
                       if (strlen($sAttributeId) > 0) {
                          $sElement .= "$('#" . $sId . "').val('" . $sAttributeId . "');";                      
                       } 
      
      $sElement .= "</script>";
        
      return $sElement;
   }
   
   public static function getCbHours() {
      return array(0=>'00', 1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09', 10=>'10', 11=>'11', 12=>'12', 13=>'13', 14=>'14', 15=>'15', 16=>'16', 17=>'17', 18=>'18', 19=>'19', 20=>'20', 21=>'21', 22=>'22', 23=>'23');
   }
   
   public static function getCbMonths() {
      return array(0=>'00', 1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09', 10=>'10', 11=>'11', 12=>'12');
   }
   
   public static function getTinyMCEAttributes($oModel, $sAttribute, $sWidth = null, $sHeight = null) {
      $oAttributes = array(
                        'model'=>$oModel,
                        'attribute'=>$sAttribute,
                        'useSwitch'=>false,
                        'editorTemplate'=>'full',
                     );
      
      if (!is_null($sWidth)) $oAttributes = array_merge($oAttributes, array('width'=>$sWidth));
      if (!is_null($sHeight)) $oAttributes = array_merge($oAttributes, array('height'=>$sHeight));
      
      return $oAttributes;
   }
   
   public static function getDatePickerAttributes($oModel, $sAttribute, $bShowTime = false, $sMinDate = FString::STRING_EMPTY, $sMaxDate = FString::STRING_EMPTY, $sStepMinute = FString::STRING_EMPTY, $sMinuteMax = FString::STRING_EMPTY, $bReadOnly = false, $bDisabled = false, $sWidth = FString::STRING_EMPTY, $sJsOnChange = FString::STRING_EMPTY, $sValue = FString::STRING_EMPTY, $sInstanceId = FString::STRING_EMPTY, $sInstanceName = FString::STRING_EMPTY) {
      $sLanguage = FString::STRING_EMPTY;
      $sReadOnly = FString::STRING_EMPTY;
      $sDisabled = FString::STRING_EMPTY;
      $sDatePickerMode = FString::STRING_EMPTY;
      
      $oUser = Users::getUser(Yii::app()->user->id); 
      
      if (!is_null($oUser)) $sLanguage = strtolower($oUser->language);                               
      if ($bShowTime) $sDatePickerMode = 'datetime';
      else $sDatePickerMode = 'date';
              
      if ($bReadOnly) $sReadOnly = 'readonly';
      if ($bDisabled) $sDisabled = 'disabled';
           
      $oArray = array(
         'model'=>$oModel,
         'attribute'=>$sAttribute,
         'mode'=>$sDatePickerMode,  
         'language'=>$sLanguage,
         'htmlOptions'=>array('readonly'=>$sReadOnly, 'disabled'=>$sDisabled, 'style'=>'width:' . $sWidth, 'onchange'=>$sJsOnChange),
         'options'=>array(
             'dateFormat'=>FDate::getTimeZoneTypeFormattedDate(),
             'monthNames'=>FDate::getMonthNames(),
             'monthNamesShort'=>FDate::getMonthNames(true),
             'dayNames'=>FDate::getDayNames(),
             'dayNamesShort'=>FDate::getDayNames(true),
             'dayNamesMin'=>FDate::getDayNames(true),
             'currentText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_CURRENT_DATE'),
             'timeText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_TIME'),
             'hourText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_HOUR'),
             'minuteText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_MINUTE'),
             'minDate'=>$sMinDate,
             'maxDate'=>$sMaxDate,
             'autoSize'=>false,
         )
      );
      
      if ($sInstanceId != FString::STRING_EMPTY) $oArray = array_merge($oArray, array('id'=>'widgetDateTimePicker_' . $sAttribute . '_' . $sInstanceId)); 
      if ($sInstanceName != FString::STRING_EMPTY) $oArray = array_merge($oArray, array('name'=>$sInstanceName)); 
      if ($sStepMinute != FString::STRING_EMPTY) $oArray['options'] = array_merge($oArray['options'], array('stepMinute'=>$sStepMinute)); 
      if ($sMinuteMax != FString::STRING_EMPTY) $oArray['options'] = array_merge($oArray['options'], array('minuteMax'=>$sMinuteMax));
      if ($sValue != FString::STRING_EMPTY) $oArray['htmlOptions'] = array_merge($oArray['htmlOptions'], array('value'=>$sValue));
      return $oArray; 
   }
   
   public static function getTimePickerAttributes($oModel, $sAttribute, $bReadOnly = false, $bDisabled = false, $sWidth = FString::STRING_EMPTY, $sJsOnChange = FString::STRING_EMPTY, $sValue = FString::STRING_EMPTY, $sInstanceId = FString::STRING_EMPTY, $sInstanceName = FString::STRING_EMPTY) {
      $sLanguage = FString::STRING_EMPTY;
      $sReadOnly = FString::STRING_EMPTY;
      $sDisabled = FString::STRING_EMPTY;
      $oUser = Users::getUser(Yii::app()->user->id);

      if (!is_null($oUser)) $sLanguage = strtolower($oUser->language);                               
      if ($bReadOnly) $sReadOnly = 'readonly';
      if ($bDisabled) $sDisabled = 'disabled';
      
      $oArray = array(
         'model'=>$oModel,
         'attribute'=>$sAttribute,
         'mode'=>'time',  
         'language'=>$sLanguage,
         'htmlOptions'=>array('readonly'=>$sReadOnly, 'disabled'=>$sDisabled, 'style'=>'width:' . $sWidth, 'onchange'=>$sJsOnChange),
         'options'=>array(
             'currentText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_CURRENT_TIME'),
             'timeOnlyTitle'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_TIME'),
             'timeText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_TIME'),
             'hourText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_HOUR'),
             'minuteText'=>Yii::t('system', 'SYS_COMPONENT_CJUIDATETIMEPICKER_MINUTE'),
             'autoSize'=>false,
         )
      );
                                  
      if ($sInstanceId != FString::STRING_EMPTY) $oArray = array_merge($oArray, array('id'=>'widgetTimePicker_' . $sAttribute . $sInstanceId));
      if ($sInstanceName != FString::STRING_EMPTY) $oArray = array_merge($oArray, array('name'=>$sInstanceName));
      if ($sValue != FString::STRING_EMPTY) $oArray['htmlOptions'] = array_merge($oArray['htmlOptions'], array('value'=>$sValue));
      return $oArray;  
   }
   
   public static function getLastFiveYears() {
      return array(date('Y')=>date('Y'), (date('Y') - 1)=>date('Y') - 1, (date('Y') - 2)=>date('Y') - 2, (date('Y') - 3)=>date('Y') - 3, (date('Y') - 4)=>date('Y') - 4);
   }
   
   public static function getLastTenYears() {
      return array(date('Y')=>date('Y'), (date('Y') - 1)=>date('Y') - 1, (date('Y') - 2)=>date('Y') - 2, (date('Y') - 3)=>date('Y') - 3, (date('Y') - 4)=>date('Y') - 4, (date('Y') - 5)=>date('Y') - 5, (date('Y') - 6)=>date('Y') - 6, (date('Y') - 7)=>date('Y') - 7, (date('Y') - 8)=>date('Y') - 8, (date('Y') - 9)=>date('Y') - 9);
   }
   
   public static function getLastTwentyYears() {
      return array(date('Y')=>date('Y'), (date('Y') - 1)=>date('Y') - 1, (date('Y') - 2)=>date('Y') - 2, (date('Y') - 3)=>date('Y') - 3, (date('Y') - 4)=>date('Y') - 4, (date('Y') - 5)=>date('Y') - 5, (date('Y') - 6)=>date('Y') - 6, (date('Y') - 7)=>date('Y') - 7, (date('Y') - 8)=>date('Y') - 8, (date('Y') - 9)=>date('Y') - 9, (date('Y') - 10)=>date('Y') - 10, (date('Y') - 11)=>date('Y') - 11, (date('Y') - 12)=>date('Y') - 12, (date('Y') - 13)=>date('Y') - 13, (date('Y') - 14)=>date('Y') - 14, (date('Y') - 15)=>date('Y') - 15, (date('Y') - 16)=>date('Y') - 16, (date('Y') - 17)=>date('Y') - 17, (date('Y') - 18)=>date('Y') - 18, (date('Y') - 19)=>date('Y') - 19); 
   }
}
?>