<?php 
class FZipDocument extends FDocument {
   private $oZipDocument;
   
   function __construct($sName) {
      $this->setName($sName);
       
      $this->oZipDocument = new zipfile();
      $this->setExtension(FFile::getExtensionFromFileType(FFile::FILE_ZIP_TYPE));
   }
   
   public function addDocument($oDocument) {
      $this->oZipDocument->add_file($oDocument->getDataContent(), $oDocument->getName() . $oDocument->getExtension());     
   }  
    
   public function getDataContent() { return $this->oZipDocument->file(); }
   public function getZipDocumentObject() { return $this->oZipDocument; }
}
?>
