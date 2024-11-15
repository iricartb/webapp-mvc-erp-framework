<?php
class DropzoneController extends Controller {
   
   public function actionChangeDropzoneElements($sModel, $sDropzoneFileType, $sFunctionCallback, $sParameter1, $sParameter2) {
      $oDynamicModel = new $sModel;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) call_user_func_array(array($oDynamicModel, "changeDropzone" . $sFunctionCallback . "Elements"), array($sParameter1, $sParameter2));   
   }
    
   public function actionDeleteDropzoneElement($sModel, $sDropzoneFileType, $sFunctionCallback, $sParameter) {
      $oDynamicModel = new $sModel;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) {
         call_user_func_array(array($oDynamicModel, "deleteDropzone" . $sFunctionCallback . "Element"), array($sParameter));
      }   
   }
   
   public function actionUploadDropzoneElement($sModel, $sDropzoneFileType, $sFunctionCallback, $sPath, $sParametersGetElements, $sParameters) {
      $oDynamicModel = new $sModel;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) {
         $oFile = CUploadedFile::getInstanceByName('file');
         if ($oFile) { 
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = '.' . strtolower($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
            
            $sOriginalFileUrl = $sPath . $sOriginalFile;
            
            /* Put hear new types of files */
            if (($sDropzoneFileType == FWidget::DROPZONE_FILE_TYPE_IMAGE) && (FFile::isCommonImageFromMimeType($oFile->type)) && ($oFile->saveAs($sOriginalFileUrl))) {
               $oDropzoneOutputFormat = $oDynamicModel->getDropzoneImageOutputFormat();

               $sOutputFileExtension = $oDropzoneOutputFormat['file_image_output_extension'];
               $sOutputFile = $sOriginalFilename . $sOutputFileExtension;
   
               $oDropzoneOutputSize = $oDropzoneOutputFormat['file_image_resize'];
                 
               if (count($oDropzoneOutputSize) == 2) {
                  FFile::resizeImageFile($sOriginalFileUrl, $oDropzoneOutputSize[0], $oDropzoneOutputSize[1], $sPath . $sOutputFile);
               }
               else {
                  if ($sOriginalFileExtension != $sOutputFileExtension) FFile::saveImageFile($sOriginalFileUrl, $sPath . $sOutputFile);    
                  else copy($sOriginalFileUrl, $sPath . $sOutputFile);
               }

               if ($sOriginalFileExtension != $sOutputFileExtension) unlink($sOriginalFileUrl);
                                
               if (strlen($sParameters) > 0) $sParameters = $sOutputFile . ',' . $sParameters;
               else $sParameters = $sOutputFile;      
            }
            
            call_user_func_array(array($oDynamicModel, "uploadDropzone" . $sFunctionCallback . "Element"), explode(",", $sParameters));
         }
      }
   }
   
   public function actionGetDropzoneElements($sId, $sModel, $sDropzoneFileType, $sFunctionCallback, $sDropzoneType, $sParameters, $sJsDeleteElements, $sStyle) {
      $this->layout = null;
      $sElements = FString::STRING_EMPTY;
      
      $oDynamicModel = new $sModel; 
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) {
         if (strlen($sParameters > 0)) $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneSpecifications"), explode(",", $sParameters));
         else $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneSpecifications"), array());
         
         foreach ($oElements['elements'] as $oElement) { 
            if (strlen(eval('return $oElement->' . $oElements['field_document'] . ';')) > 0) {                                                                                                                                                                                                       
               $sElements .= "<div id=\"dropzone_element_" . $sId . "\" class=\"dropzone_element_" . $sId . " column_draggable_" . $sId ."\" onmouseover=\"jqueryEventAnimationFadeOnMouseOverOut('.dropzone_element_" . $sId . "', '" . FAjax::TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS . "', 0.4, 1000, 1.0, 1000, true, true, true, 1.0, 1000);\" style=\"float:left; cursor:pointer;\">
                            <div id=\"dropzone_element_" . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element\">";
               
               $sJsAfterActionDeleteElement = "aj(%ascii_39" . $this->createUrl('widgets/Dropzone/dropzone/getDropzoneElements&sId=') . $sId . '&sModel=' . $sModel . '&sDropzoneFileType=' . $sDropzoneFileType . '&sFunctionCallback=' . $sFunctionCallback . '&sDropzoneType=' . $sDropzoneType . '&sParameters=' . $sParameters . '&sJsDeleteElements=' . $sJsDeleteElements . '&sStyle=' . $sStyle . "%ascii_39, null, %ascii_39dropzone_elements_" . $sId . "%ascii_39, null, null, %ascii_39" . $sJsDeleteElements . "%ascii_39, null, %ascii_39" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "%ascii_39, %ascii_39" . FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE . "%ascii_39, 0, false, true);";        
               $sJsOnClickDelete = "dropzone_remove_element(\'#dropzone_element_" . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\', \'" . $sJsAfterActionDeleteElement . "\');";
               $sJsSentence = "aj('" . $this->createUrl('widgets/Dropzone/dropzone/deleteDropzoneElement&sModel=') . $sModel . '&sDropzoneFileType=' . $sDropzoneFileType . '&sFunctionCallback=' . $sFunctionCallback . '&sParameter=' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "', null, null, null, '" . Yii::t('widgets', 'WIDGET_DROPZONE_' . strtoupper($sFunctionCallback) . '_CONFIRMATION') . "', '" . $sJsOnClickDelete . "', null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE . "', 0, false, false);";
                 
               $sElements .= "<img src=\"" . FWidget::DROPZONE_FOLDER_IMAGES . "delete.png\" class=\"remove\" onclick=\"" . $sJsSentence . "\">";
               
               /* Put hear new types of files */
               if ($sDropzoneFileType == FWidget::DROPZONE_FILE_TYPE_IMAGE) $sElements .= "<img src=\"" . $oElements['path_documents'] . eval('return $oElement->' . $oElements['field_document'] . ';') . "\" style=\"" . $sStyle . "\">";
               
               $sElements .= "</div>
                             </div>";                                   
            }
         }
         
         if ($sDropzoneType == FWidget::DROPZONE_TYPE_MULTIPLE_ITEMS) {
            $sElements .= "<script type=\"text/javascript\">
                             $(document).ready(function() {
                                var columns = $(\".column_draggable_" . $sId . "\");

                                [].forEach.call(columns, function(column) {
                                   column.addEventListener('dragstart', handleDragStart_" . $sId . ", false);
                                   column.addEventListener('drop', handleDrop_" . $sId . ", false);
                                });
                             });
                             
                             var widgetDragStart = null;
                             
                             function handleDragStart_" . $sId . "(e) {
                                widgetDragStart = '" . $sId . "'; 
                                
                                e.dataTransfer.effectAllowed = 'move';
                                e.dataTransfer.setData('text/html', this.innerHTML);
                             }

                             function handleDrop_" . $sId . "(e) {
                                if (widgetDragStart == '" . $sId . "') { 
                                   var nSubstringDestinyStart = this.innerHTML.indexOf('dropzone_element_') + 17;
                                   var nSubstringDestinyEnd = this.innerHTML.substring(nSubstringDestinyStart).indexOf('\"');
                                   
                                   var sInnerHtmlSource = e.dataTransfer.getData('text/html');
                                   var nSubstringSourceStart = sInnerHtmlSource.indexOf('dropzone_element_') + 17;
                                   var nSubstringSourceEnd = sInnerHtmlSource.substring(nSubstringSourceStart).indexOf('\"'); 
                
                                   var nSource = sInnerHtmlSource.substring(nSubstringSourceStart, nSubstringSourceStart + nSubstringSourceEnd);
                                   var nDestiny = this.innerHTML.substring(nSubstringDestinyStart, nSubstringDestinyStart + nSubstringDestinyEnd);
                                   
                                   if (nSource != nDestiny) {    
                                      aj('" . $this->createUrl('widgets/Dropzone/dropzone/changeDropzoneElements&sModel=') . $sModel . '&sDropzoneFileType=' . $sDropzoneFileType . '&sFunctionCallback=' . $sFunctionCallback . '&sParameter1=\'' . " + nSource + '&sParameter2=' + nDestiny, null, null, null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE . "', 0, false, false);
                                      aj('" . $this->createUrl('widgets/Dropzone/dropzone/getDropzoneElements&sId=') . $sId . '&sModel=' . $sModel . '&sDropzoneFileType=' . $sDropzoneFileType . '&sFunctionCallback=' . $sFunctionCallback . '&sDropzoneType=' . $sDropzoneType . '&sParameters=' . $sParameters . '&sJsDeleteElements=' . $sJsDeleteElements . '&sStyle=' . $sStyle . "', null, 'dropzone_elements_" . $sId . "', null, null, null, null, '" . FAjax::TYPE_METHOD_CONTENT_REPLACE . "', '" . FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE . "', 0, false, true);
                                   }
                                } 
                                
                                widgetDragStart = null;   
                             }
                         </script>";
         }
            
         $this->renderText($sElements); 
      }      
   }
}