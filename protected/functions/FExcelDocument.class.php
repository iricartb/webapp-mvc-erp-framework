<?php 
class FExcelDocument extends FDocument {
   private $oExcelDocument;
   private $sFileType;
   
   function __construct($sName, $oPHPExcel, $sFileType = FFile::FILE_XLS_TYPE) {
      PHPExcel_Settings::setPdfRenderer(PHPExcel_Settings::PDF_RENDERER_MPDF, Yii::getPathOfAlias('application.components.Mpdf'));
      
      $this->setName($sName);
      
      $this->oExcelDocument = $oPHPExcel;
      $this->sFileType = $sFileType;
                                                                         
      if ($this->sFileType == FFile::FILE_XLSX_TYPE) $this->setExtension(FFile::getExtensionFromFileType(FFile::FILE_XLSX_TYPE));
      else $this->setExtension(FFile::getExtensionFromFileType(FFile::FILE_XLS_TYPE));
   }
   
   public function getDataContent() {
      if ($this->sFileType == FFile::FILE_PDF_TYPE) {
         $oWriter = new PHPExcel_Writer_PDF($this->oExcelDocument); 
         $oWriter->writeAllSheets();  
      } 
      else $oWriter = PHPExcel_IOFactory::createWriter($this->oExcelDocument, $this->sFileType);
        
      for($level=ob_get_level(); $level>0; --$level) {
         @ob_end_clean();
      }

      ob_start();
      $oWriter->save('php://output');
      $sDataContent = ob_get_clean();

      return $sDataContent; 
   }
   
   public function transformToPdf($bShowGridLines = false) {
      $this->sFileType = FFile::FILE_PDF_TYPE;
      $this->setExtension(FFile::getExtensionFromFileType(FFile::FILE_PDF_TYPE));
      
      $this->oExcelDocument->getActiveSheet()->setShowGridlines($bShowGridLines);
   }

   public function getExcelDocumentObject() { return $this->oExcelDocument; }
}
?>
