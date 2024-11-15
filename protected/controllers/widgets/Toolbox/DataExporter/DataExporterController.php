<?php

class DataExporterController extends FrontendController {
    
    public function actionExportToExcel($sModule, $sModel, $sParameters = FString::STRING_EMPTY, $sFieldsNull = FString::STRING_EMPTY, $sFormat = FFile::FILE_XLS_TYPE) {
       $this->actionExport($sModule, $sModel, $sParameters, $sFieldsNull, $sFormat);   
    }
    
    public function actionExportToPdf($sModule, $sModel, $sParameters = FString::STRING_EMPTY, $sFieldsNull = FString::STRING_EMPTY) {
       PHPExcel_Settings::setPdfRenderer(PHPExcel_Settings::PDF_RENDERER_MPDF, Yii::getPathOfAlias('application.components.Mpdf'));
       
       $this->actionExport($sModule, $sModel, $sParameters, $sFieldsNull, FFile::FILE_PDF_TYPE);
    }
    
    public function actionExportToCsv($sModule, $sModel, $sParameters = FString::STRING_EMPTY, $sFieldsNull = FString::STRING_EMPTY) {
       $this->actionExport($sModule, $sModel, $sParameters, $sFieldsNull, FFile::FILE_CSV_TYPE);   
    }
    
    public function actionExportToHtml($sModule, $sModel, $sParameters = FString::STRING_EMPTY, $sFieldsNull = FString::STRING_EMPTY) {
       $this->actionExport($sModule, $sModel, $sParameters, $sFieldsNull, FFile::FILE_HTML_TYPE);   
    }
    
    private function actionExport($sModule, $sModel, $sParameters = FString::STRING_EMPTY, $sFieldsNull = FString::STRING_EMPTY, $sFormat) {
       if ((FString::isNullOrEmpty($sModule)) || ($sModule == strtolower(Yii::app()->name)) || ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, $sModule)) && ((file_exists(Yii::app()->getBasePath() . '/models/' . strtolower($sModule) . '/' . $sModel . '.php')) || (file_exists(Yii::app()->getBasePath() . '/models/' . strtolower(Yii::app()->name) . '/' . $sModel . '.php'))))) {
          $oDynamicModel = new $sModel;
          
          if (is_subclass_of($oDynamicModel, FWidget::TOOLBOX_EXPORTER_DATA_MODEL_ACTIVE_RECORD)) {
             if ((!is_null($sFieldsNull)) && (strlen($sFieldsNull) > 0)) {
                $oFieldsNull = explode(",", $sFieldsNull);
                foreach($oFieldsNull as $sFieldNull) {
                   eval('return $oDynamicModel->' . trim($sFieldNull) . '= null;');   
                }
             }
             
             if (isset($_GET[$sModel])) $oDynamicModel->attributes = $_GET[$sModel];
             
             if ($sParameters != FString::STRING_EMPTY) $oDynamicDataProvider = call_user_func_array(array($oDynamicModel, "search"), explode(",", $sParameters));
             else $oDynamicDataProvider = $oDynamicModel->search();
             
             $oDynamicDataProvider->setPagination(false);
             
             $oArrayData = $oDynamicDataProvider->data;
             $oArrayExportSpecifications = $oDynamicModel->getExportSpecifications()['data'];
             
             for($i = 0; $i < count($oArrayData); $i++) {
                foreach ($oArrayExportSpecifications as $specification) { 
                   $oValue = $oArrayData[$i][$specification[0]];
                   $bBeforeActionOK = true;
                   
                   switch ($specification[1]) {
                      case FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT:
                         if (count($specification) == 6) $bBeforeActionOK = eval('return ' . str_replace('?', $oValue, $specification[5]) . ';');
                         
                         if ($bBeforeActionOK) {
                            if ((!is_null($oValue)) && ($oValue != 0)) $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[2]) . ';');
                            else if (!is_null($oValue)) $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[3]) . ';');
                            else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[4]) . ';');
                         }
                         else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[4]) . ';');   
                         break;
                      
                      case FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE:
                         if (count($specification) == 5) $bBeforeActionOK = eval('return ' . str_replace('?', $oValue, $specification[4]) . ';');
                         
                         if ($bBeforeActionOK) {
                            if ((!is_null($oValue)) && (strlen($oValue) > 0)) $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[2]) . ';');
                            else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[3]) . ';');
                         }
                         else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[3]) . ';'); 
                         break;
                         
                      case FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING:
                         if (count($specification) == 5) $bBeforeActionOK = eval('return ' . str_replace('?', $oValue, $specification[4]) . ';');
                         
                         if ($bBeforeActionOK) {
                            if ((!is_null($oValue)) && (strlen($oValue) > 0)) $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[2]) . ';');
                            else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[3]) . ';');
                         }
                         else $oArrayData[$i][$specification[0]] = eval('return ' . str_replace('?', $oValue, $specification[3]) . ';');
                         break;
                   }
                } 
                $oDynamicDataProvider->setData($oArrayData); 
             }
             
             $this->render('export', array('oModelForm'=>$oDynamicModel, 'oModelDataProvider'=>$oDynamicDataProvider, 'sFormat'=>$sFormat));
          }
       }
       
       $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
    }
}