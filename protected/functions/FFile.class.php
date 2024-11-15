<?php      
class FFile {
   const FILE_PDF_TYPE = 'PDF';
   const FILE_TXT_TYPE = 'TXT';
   const FILE_DOC_TYPE = 'DOC';
   const FILE_DOCX_TYPE = 'DOCX';
   const FILE_XLS_TYPE = 'XLS';
   const FILE_XLSX_TYPE = 'XLSX';
   const FILE_CSV_TYPE = 'CSV';
   const FILE_HTML_TYPE = 'HTML';
   const FILE_BMP_TYPE = 'BMP';
   const FILE_JPG_TYPE = 'JPG';
   const FILE_PNG_TYPE = 'PNG';
   const FILE_GIF_TYPE = 'GIF';
   const FILE_ZIP_TYPE = 'ZIP';
   const FILE_RAR_TYPE = 'RAR';
   const FILE_XML_TYPE = 'XML';
   
   public static function resizeImageFile($sOriginalFileUrl, $sWidth, $sHeight, $sOutputFileUrl) {
      $oFileOutput = new imageLib($sOriginalFileUrl);
      $oFileOutput->resizeImage($sWidth, $sHeight);
      $oFileOutput->saveImage($sOutputFileUrl);
   }
   
   public static function saveImageFile($sOriginalFileUrl, $sOutputFileUrl) {
      $oFileOutput = new imageLib($sOriginalFileUrl);
      
      $oFileOutput->saveImage($sOutputFileUrl);  
   }
   
   public static function moveFile($sFilename, $sOriginalFolder, $sDestinyFolder) {
      if (file_exists($sOriginalFolder . $sFilename) && file_exists($sDestinyFolder)) {
         rename($sOriginalFolder . $sFilename, $sDestinyFolder . $sFilename);
      }   
   }
   
   public static function isImageFromMimeType($sMimeType) {
      if ((strtolower($sMimeType) == 'image/bmp') || (strtolower($sMimeType) == 'image/jpeg') || (strtolower($sMimeType) == 'image/png') || (strtolower($sMimeType) == 'image/gif') ||
         (strtolower($sMimeType) == 'image/cgm') || (strtolower($sMimeType) == 'image/cmu-raster') || (strtolower($sMimeType) == 'image/g3fax') || (strtolower($sMimeType) == 'image/ief') ||
         (strtolower($sMimeType) == 'image/naplps') || (strtolower($sMimeType) == 'image/targa') || (strtolower($sMimeType) == 'image/tiff') || (strtolower($sMimeType) == 'image/vnd.dwg') ||
         (strtolower($sMimeType) == 'image/vnd.dxf') || (strtolower($sMimeType) == 'image/vnd.fpx') || (strtolower($sMimeType) == 'image/vnd.net.fpx') || (strtolower($sMimeType) == 'image/vnd.svf') ||
         (strtolower($sMimeType) == 'image/x-xbitmap') || (strtolower($sMimeType) == 'image/x-cmu-raster') || (strtolower($sMimeType) == 'image/x-pict') || (strtolower($sMimeType) == 'image/x-portable-anymap') ||
         (strtolower($sMimeType) == 'image/x-portable-bitmap') || (strtolower($sMimeType) == 'image/x-portable-graymap') || (strtolower($sMimeType) == 'image/x-portable-pixmap') || (strtolower($sMimeType) == 'image/x-rgb') ||
         (strtolower($sMimeType) == 'image/x-tiff') || (strtolower($sMimeType) == 'image/x-win-bmp') || (strtolower($sMimeType) == 'image/x-xbitmap') || (strtolower($sMimeType) == 'image/x-xbm') ||
         (strtolower($sMimeType) == 'image/x-xpixmap') || (strtolower($sMimeType) == 'image/x-windowdump')) {
            return true;
      }
      else return false;
   }                                                              
   
   public static function isCommonImageFromMimeType($sMimeType, $bAcceptCompress = false) {
      if ((strtolower($sMimeType) == 'image/bmp') || (strtolower($sMimeType) == 'image/jpeg') || (strtolower($sMimeType) == 'image/png') || (strtolower($sMimeType) == 'image/gif')) return true;
      else {
         if ($bAcceptCompress) {
             if (strtolower($sMimeType) == 'application/octet-stream') return true;   
         }
         else return false;
      }    
   }
   
   public static function isCommonImageFromFileType($sFileType, $bAcceptCompress = false) {
      if ((strtolower($sFileType) == strtolower(FFile::FILE_BMP_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_JPG_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_PNG_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_GIF_TYPE))) return true;
      else {
         if ($bAcceptCompress) {
             if ((strtolower($sFileType) == strtolower(FFile::FILE_ZIP_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_RAR_TYPE))) return true;   
         }
         else return false;
      }    
   }
   
   public static function isCommonRedeableTextFromMimeType($sMimeType, $bAcceptCompress = false) {
      if ((strtolower($sMimeType) == 'text/plain') || (strtolower($sMimeType) == 'application/doc') || (strtolower($sMimeType) == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') || (strtolower($sMimeType) == 'application/ms-excel') || (strtolower($sMimeType) == 'application/pdf')) return true;  
      else {
         if ($bAcceptCompress) {
             if (strtolower($sMimeType) == 'application/octet-stream') return true;   
         }
         else return false;
      } 
   }
   
   public static function isCommonRedeableTextFromFileType($sFileType, $bAcceptCompress = false) {
      if ((strtolower($sFileType) == strtolower(FFile::FILE_TXT_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_DOC_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_DOCX_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_XLS_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_XLSX_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_PDF_TYPE))) return true;
      else {
         if ($bAcceptCompress) {
             if ((strtolower($sFileType) == strtolower(FFile::FILE_ZIP_TYPE)) || (strtolower($sFileType) == strtolower(FFile::FILE_RAR_TYPE))) return true;   
         }
         else return false;
      }   
   }
   
   public static function getExtensionFromFileType($sFileType) { return '.' . strtolower($sFileType); } 
   public static function getMimeFromFileType($sFileType) { 
      $sMimeType = FString::STRING_EMPTY;
      
      $sFileType = strtolower($sFileType);
      switch($sFileType) {
         case strtolower(FFile::FILE_DOC_TYPE):
            $sMimeType = 'application/doc';
            break; 
         case strtolower(FFile::FILE_DOCX_TYPE):
            $sMimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            break; 
         case strtolower(FFile::FILE_PDF_TYPE):
            $sMimeType = 'application/pdf';
            break;
         case strtolower(FFile::FILE_TXT_TYPE):
            $sMimeType = 'text/plain';
            break;
         case strtolower(FFile::FILE_XLS_TYPE):
            $sMimeType = 'application/ms-excel';
            break;
         case strtolower(FFile::FILE_XLSX_TYPE):
            $sMimeType = 'application/ms-excel';
            break; 
         case strtolower(FFile::FILE_CSV_TYPE):
            $sMimeType = 'text/csv';
            break; 
         case strtolower(FFile::FILE_HTML_TYPE):
            $sMimeType = 'text/html';
            break;
         case strtolower(FFile::FILE_BMP_TYPE):
            $sMimeType = 'image/bmp';
            break;
         case strtolower(FFile::FILE_JPG_TYPE):
            $sMimeType = 'image/jpeg';
            break;
         case strtolower(FFile::FILE_PNG_TYPE):
            $sMimeType = 'image/png';
            break;
         case strtolower(FFile::FILE_GIF_TYPE):
            $sMimeType = 'image/gif';
            break;
         case strtolower(FFile::FILE_ZIP_TYPE):
            $sMimeType = 'application/octet-stream';
            break;
         case strtolower(FFile::FILE_RAR_TYPE):
            $sMimeType = 'application/octet-stream';
            break;
         case strtolower(FFile::FILE_XML_TYPE):
            $sMimeType = 'text/xml';
            break; 
      }
      
      return $sMimeType;   
   }
}
?>