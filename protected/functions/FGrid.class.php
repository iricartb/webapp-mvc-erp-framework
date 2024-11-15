<?php      
class FGrid {
   public static function getNavigationButtons() {
      return array(
         'header'=>'',
         'firstPageLabel'=>'<<',
         'prevPageLabel'=>'<',
         'nextPageLabel'=>'>',
         'lastPageLabel'=>'>>',
      );
   }
   
   public static function getGenericButton($sUrl, $sVisible = 'true', $bShowPopup = true, $bAjax = false, $sIcon = 'generic_1.png', $sMessage = 'SYS_GRID_BTN_GENERIC', $sRel = 'fancybox_allowNavigation') {
      $oGenericButton = array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', $sMessage) . '}',
         'buttons'=>array(
            Yii::t('system', $sMessage)=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
      
      if ($bShowPopup) {
         $oPopupOptions = array('options'=>array('rel'=>$sRel));
             
         $oGenericButton['buttons'][Yii::t('system', $sMessage)] = array_merge($oGenericButton['buttons'][Yii::t('system', $sMessage)], $oPopupOptions);   
      } 
      else if ($bAjax) {
         $oAjax = array('type'=>'get', 'url'=>'js:$(this).attr("href")');
         $oAjaxOptions = array('options'=>array('ajax'=>$oAjax));
         
         $oGenericButton['buttons'][Yii::t('system', $sMessage)] = array_merge($oGenericButton['buttons'][Yii::t('system', $sMessage)], $oAjaxOptions);  
      } 
      
      return $oGenericButton;
   }
   
   public static function getEditButton($sUrl, $sVisible = 'true', $bShowPopup = true, $bAjax = false, $sIcon = 'edit_pencil_1.png') {
      $oEditButton = array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_EDIT') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_EDIT')=>array(    
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
      
      if ($bShowPopup) {
         $oPopupOptions = array('options'=>array('rel'=>'fancybox_refreshGridOnClose'));
             
         $oEditButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_EDIT')] = array_merge($oEditButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_EDIT')], $oPopupOptions);   
      } 
      else if ($bAjax) {
         $oAjax = array('type'=>'get', 'url'=>'js:$(this).attr("href")');
         $oAjaxOptions = array('options'=>array('ajax'=>$oAjax));
         
         $oEditButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_EDIT')] = array_merge($oEditButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_EDIT')], $oAjaxOptions);  
      }
      
      return $oEditButton;
   }
   
   public static function getDetailButton($sUrl, $sVisible = 'true', $bShowPopup = true, $bAjax = false, $sIcon = 'search_magnifying_glass_1.png', $sRel = 'fancybox_allowNavigation') {
      $oDetailButton = array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_DETAIL') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_DETAIL')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
      
      if ($bShowPopup) {
         $oPopupOptions = array('options'=>array('rel'=>$sRel));
             
         $oDetailButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DETAIL')] = array_merge($oDetailButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DETAIL')], $oPopupOptions);   
      } 
      else if ($bAjax) {
         $oAjax = array('type'=>'get', 'url'=>'js:$(this).attr("href")');
         $oAjaxOptions = array('options'=>array('ajax'=>$oAjax));
         
         $oDetailButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DETAIL')] = array_merge($oDetailButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DETAIL')], $oAjaxOptions);  
      } 
      
      return $oDetailButton;
   }
   
   public static function getDeleteButton($sUrl, $sVisible = 'true', $bAjax = false, $bConfirmation = true, $sIcon = 'sign_no_ok_1.png') {
      $oDeleteButton = array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_DELETE') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_DELETE')=>array( 
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl, 
               'visible'=>$sVisible,
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
    
      if ((!$bAjax) && ($bConfirmation)) {
         $oConfirmation = array('click'=>'function(){return confirm("' . Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION') . '");}');
         
         $oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')] = array_merge($oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')], $oConfirmation); 
      } 
      else if (($bAjax) && ($bConfirmation)) {
         $oConfirmation = array('click'=>'function(){
                                             if (confirm("' . Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION') . '")) {
                                                aj($(this).attr("href"), null);
                                                refreshAllCGridViews();
                                             }
                                             return false;
                                          }');
         
         $oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')] = array_merge($oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')], $oConfirmation);   
      }
      else if (($bAjax) && (!$bConfirmation)) {
         $oConfirmation = array('click'=>'function(){
                                             aj($(this).attr("href"), null);
                                             refreshAllCGridViews();

                                             return false;
                                          }');
         
         $oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')] = array_merge($oDeleteButton['buttons'][Yii::t('system', 'SYS_GRID_BTN_DELETE')], $oConfirmation);   
      }
      
      return $oDeleteButton;
   }
   
   public static function getExitButton($sUrl, $sVisible = 'true', $sIcon = 'exit_door_1.png') {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_EXIT') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_EXIT')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
               'click'=>'function(){return confirm("' . Yii::t('system', 'SYS_EXIT_RECORD_CONFIRMATION') . '");}',
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
   
   public static function getPrintButton($sUrl, $sVisible = 'true', $sIcon = 'print_printer_1.png') {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_PRINT') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_PRINT')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
               'click'=>'function(){return confirm("' . Yii::t('system', 'SYS_PRINT_RECORD_CONFIRMATION') . '");}',
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
   
   public static function getSendButton($sUrl, $sVisible = 'true', $sIcon = 'send_mail_1.png') {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_SEND') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_SEND')=>array( 
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
               'click'=>'function(){return confirm("' . Yii::t('system', 'SYS_SEND_RECORD_CONFIRMATION') . '");}',
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
   
   public static function getAttachmentButton($sUrl, $sVisible = 'true', $sIcon = 'document_download_1.png') {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_ATTACHMENT') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_ATTACHMENT')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl, 
               'visible'=>$sVisible,
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
   
   public static function getChangeStatusButton($sUrl, $sVisible = 'true', $sIcon = 'refresh_arrow_1.png') {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_CHANGE_STATUS') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_CHANGE_STATUS')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
               'click'=>'function(){return confirm("' . Yii::t('system', 'SYS_CHANGE_STATUS_RECORD_CONFIRMATION') . '");}',
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
   
   public static function getSelectorButton($sUrl, $sVisible = 'true', $sJsOnClick = FString::STRING_EMPTY, $bConfirmation = true, $sIcon = 'selector_hand_1.png', $nWidth = 10) {
      $sJsOnClickSentence = FString::STRING_EMPTY;
      
      if ($bConfirmation) {
         if (FString::isNullOrEmpty($sJsOnClick)) {
            $sJsOnClickSentence = 'return confirm("' . Yii::t('system', 'SYS_SELECTOR_RECORD_CONFIRMATION') . '");';  
         }
         else {
            $sJsOnClickSentence = 'if (confirm("' . Yii::t('system', 'SYS_SELECTOR_RECORD_CONFIRMATION') . '")) {' 
                                      . $sJsOnClick . 
                                  '} 
                                   return false;';   
         }
      }
      else {
         if (FString::isNullOrEmpty($sJsOnClick)) $sJsOnClickSentence = 'return true;';  
         else {
            $sJsOnClickSentence = $sJsOnClick . ' return false;';   
         }   
      }
      
      if (FString::isNullOrEmpty($sJsOnClick)) $sJsOnClickBoolean = FString::STRING_BOOLEAN_TRUE;
      else $sJsOnClickBoolean = FString::STRING_BOOLEAN_FALSE;
      
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_SELECTOR') . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_SELECTOR')=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'url'=>$sUrl,
               'visible'=>$sVisible,
               'click'=>'function() {
                  ' . $sJsOnClickSentence . '
               }',
            ),
         ),
         'htmlOptions'=>array('width'=>$nWidth, 'style'=>'text-align: center'),
      );
   }
   
   public static function getInformationButton($sMessage, $sVisible = 'true', $sIcon = 'caution_alert_1.png', $sClass = FString::STRING_EMPTY) {
      return array(
         'class'=>'CButtonColumn',
         'template'=>'{' . Yii::t('system', 'SYS_GRID_BTN_INFORMATION_' . $sMessage) . '}',
         'buttons'=>array(
            Yii::t('system', 'SYS_GRID_BTN_INFORMATION_' . $sMessage)=>array(
               'imageUrl'=>FApplication::FOLDER_IMAGES_GENERIC_16x16 . $sIcon,
               'visible'=>$sVisible,
               'options'=>array('class'=>'cbuttoncolumn_green'),
            ),
         ),
         'htmlOptions'=>array('width'=>10, 'style'=>'text-align: center'),
      );
   }
}
?>