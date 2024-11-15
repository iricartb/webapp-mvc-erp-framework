<?php      
class FWidget { 
   const TOOLBOX_FOLDER_IMAGES = 'widgets/Toolbox/images/';
   const TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT = 'BIT';
   const TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING = 'STRING';
   const TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE = 'DATE';
   const TOOLBOX_EXPORTER_DATA_MODEL_ACTIVE_RECORD = 'CExportedActiveRecord';
   
   const DROPZONE_FILE_TYPE_IMAGE = 'DROPZONE_FILE_TYPE_IMAGE';
   const DROPZONE_FILE_TYPE_IMAGE_FUNCTION_CALLBACK = 'Image';
   const DROPZONE_TYPE_MULTIPLE_ITEMS = 'DROPZONE_TYPE_MULTIPLE_ITEMS';
   const DROPZONE_TYPE_SINGLE_ITEM = 'DROPZONE_TYPE_SINGLE_ITEM';
   const DROPZONE_FOLDER_IMAGES = 'widgets/Dropzone/images/';
   const DROPZONE_MODEL_ACTIVE_RECORD = 'CDropzoneActiveRecord';
   
   public static function showToolboxExporterData($sId, $sModule, $sModel, $sParameters, $sFieldsToNull, $oController, $bInverse = false) {
      if ($bInverse) $sInverse = FString::STRING_BOOLEAN_TRUE;
      else $sInverse = FString::STRING_BOOLEAN_FALSE;
      
      $sWidget = "<div class=\"toolbox\">
                     <a id=\"toolbox_header_" . $sId . "\" class=\"toolbox_header\" style=\"cursor:pointer\" onclick=\"toolbox_align('toolbox_header_" . $sId . "', 'toolbox_submenu_" . $sId . "', " . $sInverse . "); jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">
                        <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "toolbox_gear.png\" />
                     </a>
                     <div id=\"toolbox_submenu_" . $sId . "\" class=\"toolbox_submenu\">
                        <ul class=\"toolbox_container\">
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_excel.png\" />
                              <a href=\"" . $oController->createUrl('widgets/Toolbox/DataExporter/dataExporter/exportToExcel&sModule=' . $sModule . '&sModel=' . $sModel . '&sParameters=' . $sParameters . '&sFieldsNull=' . $sFieldsToNull . '&sFormat=' . FFile::FILE_XLS_TYPE) . FUrl::getUrlParameters() . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_EXCEL') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_excel.png\" />
                              <a href=\"" . $oController->createUrl('widgets/Toolbox/DataExporter/dataExporter/exportToExcel&sModule=' . $sModule . '&sModel=' . $sModel . '&sParameters=' . $sParameters . '&sFieldsNull=' . $sFieldsToNull . '&sFormat=' . FFile::FILE_XLSX_TYPE) . FUrl::getUrlParameters() . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_EXCEL_2007') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_pdf.png\" />
                              <a href=\"" . $oController->createUrl('widgets/Toolbox/DataExporter/dataExporter/exportToPdf&sModule=' . $sModule . '&sModel=' . $sModel . '&sParameters=' . $sParameters . '&sFieldsNull=' . $sFieldsToNull) . FUrl::getUrlParameters() . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_PDF') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_csv.png\" />
                              <a href=\"" . $oController->createUrl('widgets/Toolbox/DataExporter/dataExporter/exportToCsv&sModule=' . $sModule . '&sModel=' . $sModel . '&sParameters=' . $sParameters . '&sFieldsNull=' . $sFieldsToNull) . FUrl::getUrlParameters() . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_CSV') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item_last\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_html.png\" />
                              <a href=\"" . $oController->createUrl('widgets/Toolbox/DataExporter/dataExporter/exportToHtml&sModule=' . $sModule . '&sModel=' . $sModel . '&sParameters=' . $sParameters . '&sFieldsNull=' . $sFieldsToNull) . FUrl::getUrlParameters() . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_HTML') . "</a>
                           </li>
                        </ul>
                     </div>
                  </div>";

      return $sWidget;
   }
   
   public static function showToolboxExporterCustomData($sId, $sModule, $sAction, $sParameter, $oController, $bFrontend = true, $bInverse = false) {
      if ($bInverse) $sInverse = FString::STRING_BOOLEAN_TRUE;
      else $sInverse = FString::STRING_BOOLEAN_FALSE;
      
      if ($bFrontend) $sFrontendBackend = 'frontend';
      else $sFrontendBackend = 'backend'; 
      
      $sWidget = "<div class=\"toolbox\">
                     <a id=\"toolbox_header_" . $sId . "\"  class=\"toolbox_header\" style=\"cursor:pointer\" onclick=\"toolbox_align('toolbox_header_" . $sId . "', 'toolbox_submenu_" . $sId . "', " . $sInverse . "); jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">
                        <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "toolbox_gear.png\" />
                     </a>
                     <div id=\"toolbox_submenu_" . $sId . "\" class=\"toolbox_submenu\">
                        <ul class=\"toolbox_container\">
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_excel.png\" />
                              <a href=\"" . $oController->createUrl($sFrontendBackend . '/' . strtolower($sModule) . '/report/' . $sAction . 'Export&nIdForm=' . $sParameter . '&sFormat=' . FFile::FILE_XLS_TYPE) . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_EXCEL') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_excel.png\" />
                              <a href=\"" . $oController->createUrl($sFrontendBackend . '/' . strtolower($sModule) . '/report/' . $sAction . 'Export&nIdForm=' . $sParameter . '&sFormat=' . FFile::FILE_XLSX_TYPE) . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_EXCEL_2007') . "</a>
                           </li>
                           <li class=\"toolbox_item_separator\" />
                           <li class=\"toolbox_item\">
                              <img src=\"" . FWidget::TOOLBOX_FOLDER_IMAGES . "document_pdf.png\" />
                              <a href=\"" . $oController->createUrl($sFrontendBackend . '/' . strtolower($sModule) . '/report/' . $sAction . 'Export&nIdForm=' . $sParameter . '&sFormat=' . FFile::FILE_PDF_TYPE) . "\" onclick=\"jquerySimpleAnimationExpandCollapse('#toolbox_submenu_" . $sId . "', 'fast');\">" . Yii::t('widgets', 'WIDGET_TOOLBOX_EXPORTER_DATA_PDF') . "</a>
                           </li>
                        </ul>
                     </div>
                  </div>";

     return $sWidget;
   }
   
   public static function showIconImageButton($sId, $sImage, $sText, $sAction = FString::STRING_EMPTY, $bShowPopup = false, $sFontSize = '11px', $sPaddingTopText = '0px', $sIconSize = '16x16', $bSelected = false, $sRelFancyBox = FString::STRING_EMPTY) {
      $sShowPopup = FString::STRING_EMPTY;
      
      if ($bSelected) $sToolboxCss = 'toolbox_header_selected';
      else $sToolboxCss = 'toolbox_header';
      
      if ($bShowPopup) {
         if (FString::isNullOrEmpty($sRelFancyBox)) {
            $sButton = "<div class=\"toolbox\">
                           <a id=\"image_button_header_" . $sId . "\" class=\"" . $sToolboxCss . "\" style=\"cursor:pointer;\" href=\"" . $sAction . "\" rel=\"fancybox_refreshGridOnClose\">";
         }
         else {
            $sButton = "<div class=\"toolbox\">
                           <a id=\"image_button_header_" . $sId . "\" class=\"" . $sToolboxCss . "\" style=\"cursor:pointer;\" href=\"" . $sAction . "\" rel=\"" . $sRelFancyBox . "\">";  
         }   
      }
      else {
         $sButton = "<div class=\"toolbox\">
                        <a id=\"image_button_header_" . $sId . "\" class=\"" . $sToolboxCss . "\" style=\"cursor:pointer;\" onclick=\"" . $sAction . "\">";  
      }
      
      $sButton .= "<div style=\"display:inline-block\">
                     <img style=\"float:left;\" src=\"images/generic/" . $sIconSize . "/" . $sImage . "\"/>
                     <div style=\"font-size:" . $sFontSize . "; float:left; padding-left:10px; padding-top:" . $sPaddingTopText . "\">" . $sText . "</div> 
                  </div>
               </a>
           </div>";
  
      return $sButton;
   }    
   
   public static function showButton($sId, $sText, $sAction = FString::STRING_EMPTY, $bSelected = false) {
      if ($bSelected) $sToolboxCss = 'toolbox_header_selected';
      else $sToolboxCss = 'toolbox_header';
      
      $sButton = "<div class=\"toolbox\">
                     <a id=\"button_header_" . $sId . "\" class=\"" . $sToolboxCss . "\" style=\"cursor:pointer\" onclick=\"" . $sAction . "\">
                        <div>" . $sText . "</div>
                     </a>
                 </div>";
                 
      return $sButton;
   }
   
   public static function showDropzone($oController, $sId, $sModel, $sDropzoneType = FWidget::DROPZONE_TYPE_MULTIPLE_ITEMS, $sDropzoneFileType = FWidget::DROPZONE_FILE_TYPE_IMAGE, $sParametersGetElements, $sParametersUploadElements, $sJsUploadElements = FString::STRING_EMPTY, $sJsDeleteElements = FString::STRING_EMPTY, $sDropzoneStyle = FString::STRING_EMPTY, $sDropzoneElementStyle = FString::STRING_EMPTY) {
      $oDynamicModel = new $sModel;
      $sFunctionCallback = FString::STRING_EMPTY;
      
      $sJsDeleteElements = str_replace('"', '%ascii_34', $sJsDeleteElements);
      $sJsDeleteElements = str_replace('\'', '%ascii_34', $sJsDeleteElements);
      
      if ($sDropzoneFileType == FWidget::DROPZONE_FILE_TYPE_IMAGE) $sFunctionCallback = FWidget::DROPZONE_FILE_TYPE_IMAGE_FUNCTION_CALLBACK;
      
      if ((is_subclass_of($oDynamicModel, FWidget::DROPZONE_MODEL_ACTIVE_RECORD)) && ($sDropzoneFileType == FWidget::DROPZONE_FILE_TYPE_IMAGE)) {
         if ($sDropzoneType == FWidget::DROPZONE_TYPE_MULTIPLE_ITEMS) $sDropzoneBackgroundUrl = FWidget::DROPZONE_FOLDER_IMAGES . 'multiple_bg_photos.png';
         else $sDropzoneBackgroundUrl = FWidget::DROPZONE_FOLDER_IMAGES . 'single_bg_photos.png'; 
      }
      else $sDropzoneBackgroundUrl = FString::STRING_EMPTY;
            
      $sWidget = "<div id=\"dropzone_" . $sId . "\" class=\"dropzone\" style=\"background-image: url(" . $sDropzoneBackgroundUrl . "); " . $sDropzoneStyle . "\">
                     <div id=\"dropzone_elements_" . $sId . "\" class=\"dropzone_elements\">";
      
      if (is_subclass_of($oDynamicModel, FWidget::DROPZONE_MODEL_ACTIVE_RECORD)) {                  
         if ($sParametersGetElements != FString::STRING_EMPTY) $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneSpecifications"), explode(",", $sParametersGetElements));
         else $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneSpecifications"), array());
         
         if (count($oElements['elements'] ) > 0) { ?>
            <script type="text/javascript">
               $(document).ready(function($) {  
                  aj('<?php echo $oController->createUrl('widgets/Dropzone/dropzone/getDropzoneElements&sId=') . $sId . "&sModel=" . $sModel . "&sDropzoneFileType=" . $sDropzoneFileType . "&sFunctionCallback=" . $sFunctionCallback . "&sDropzoneType=" . $sDropzoneType . "&sParameters=" . $sParametersGetElements . '&sJsDeleteElements=' . $sJsDeleteElements . "&sStyle=" . $sDropzoneElementStyle; ?>', null, '<?php echo 'dropzone_elements_' . $sId; ?>', null, null, null, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE;?>', 0, false, false);
               });
            </script>
         <?php
         }
      }
      
      $sWidget .= "</div>  
                </div>";
      
      if (is_subclass_of($oDynamicModel, FWidget::DROPZONE_MODEL_ACTIVE_RECORD)) {
         $sWidget .= "<script type=\"text/javascript\">
                         function sendFileToServer" . $sId . "(formData) {
                            $.ajax({
                               url: '" . $oController->createUrl('widgets/Dropzone/dropzone/uploadDropzoneElement&sModel=') . $sModel . "&sDropzoneFileType=" . $sDropzoneFileType . "&sFunctionCallback=" . $sFunctionCallback . "&sPath=" . $oElements['path_documents'] . "&sParametersGetElements=" . $sParametersGetElements . "&sParameters=" . $sParametersUploadElements . "',
                               type: 'POST',
                               contentType: false,
                               processData: false,
                               cache: false,
                               data: formData,
                               success: function(data) {
                                  aj('" . $oController->createUrl('widgets/Dropzone/dropzone/getDropzoneElements&sId=') . $sId . "&sModel=" . $sModel . "&sDropzoneFileType=" . $sDropzoneFileType . "&sFunctionCallback=" . $sFunctionCallback . "&sDropzoneType=" . $sDropzoneType . "&sParameters=" . $sParametersGetElements . '&sJsDeleteElements=' . $sJsDeleteElements . "&sStyle=" . $sDropzoneElementStyle . "', null, 'dropzone_elements_" . $sId . "', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE . "', 0, false, true);   
                               ";
                                if ($sJsUploadElements != FString::STRING_EMPTY) {
                                   $sWidget .= $sJsUploadElements;      
                                }
                  $sWidget .= "}
                            });
                         }
                         
                         $(document).ready(function() {
                            var obj = $(\"#dropzone_" . $sId . "\");
                               
                            obj.on('dragover', function (e) {
                               e.stopPropagation();
                               e.preventDefault();
                            });
                            
                            obj.on('drop', function (e) { 
                               e.preventDefault();
                                   
                               var oFiles = e.originalEvent.dataTransfer.files; 
                          
                               for (var i = 0; i < oFiles.length; i++) {  
                                  var oFormData = new FormData();
                                  oFormData.append('file', oFiles[i]);

                                  sendFileToServer" . $sId . "(oFormData);
                               }
                            });
                         });   
                            
                         $(document).on('dragover', function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                         });
                        
                         $(document).on('drop', function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                         });
                      </script>";
      }
                       
      return $sWidget;   
   }                 
}
?>