<?php   
   PHPExcel_Settings::setPdfRenderer(PHPExcel_Settings::PDF_RENDERER_MPDF, Yii::getPathOfAlias('application.components.Mpdf'));
                          
   if ($sExport == FFile::FILE_PDF_TYPE) $oWriter = new PHPExcel_Writer_PDF($oDocument);
   else {
      if ($sExport == FFile::FILE_XLS_TYPE) $oWriter = PHPExcel_IOFactory::createWriter($oDocument, 'Excel5'); 
      else if ($sExport == FFile::FILE_XLSX_TYPE) $oWriter = PHPExcel_IOFactory::createWriter($oDocument, 'Excel2007');
      else $oWriter = PHPExcel_IOFactory::createWriter($oDocument, $sExport); 
   } 

   for($level=ob_get_level(); $level>0; --$level) {
      @ob_end_clean();
   }

   header("Pragma: public");  
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Content-Transfer-Encoding: binary"); 
   if ($sExport == FFile::FILE_XLS_TYPE) {            
      header("Content-Type: application/vnd.ms-excel");            
      header('Content-Disposition: attachment; filename="' . $sFilename . '_' . date("YmdHis") . '.xls"');   
   }
   else if ($sExport == FFile::FILE_XLSX_TYPE) {
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header('Content-Disposition: attachment; filename="' . $sFilename . '_' . date("YmdHis") . '.xlsx"');   
   }  
   else {
      $oWriter->writeAllSheets();
     
      header("Content-Type: application/pdf");
      header('Content-Disposition: attachment; filename="' . $sFilename . '_' . date("YmdHis") . '.pdf"');    
   }
   header('Cache-Control: max-age=0');         

   $oWriter->save('php://output');     

   exit;
?>