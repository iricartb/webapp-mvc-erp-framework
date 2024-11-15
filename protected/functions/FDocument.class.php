<?php 
class FDocument {
   private $sName;
   private $sExtension;
   private $sDataContent;
   private $bDownload = true;
   
   function __construct($sName, $sExtension, $sDataContent = null) {
      $this->sName = $sName;
      $this->sExtension = $sExtension;
      $this->sDataContent = $sDataContent;   
   }
   
   public function setName($sName) { $this->sName = $sName; }
   public function setExtension($sExtension) { $this->sExtension = $sExtension; }
   public function setDataContent($sDataContent) { $this->sDataContent = $sDataContent; }
   public function setDownload($bDownload) { $this->bDownload = $bDownload; }
   
   public function getMimeType() {
      return FFile::getMimeFromFileType(str_replace('.', FString::STRING_EMPTY, $this->sExtension));   
   } 
   
   public function getName() { return $this->sName; } 
   public function getExtension() { return $this->sExtension; }
   public function getDataContent() { return $this->sDataContent; }
   public function getContentDisposition() { 
      if ($this->bDownload) return 'attachment';   
      else return 'inline';   
   }
   
   public function isDirectDownload() { return $this->bDownload; }
}
?>