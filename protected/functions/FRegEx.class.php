<?php      
class FRegEx {
   
   public static function getAlphaPattern() {
      return '/^[ÑA-Za-z\s]+$/';
   }
   
   public static function getAlphaNumericPattern() {
      return '/^[ÑA-Za-z0-9\s]+$/';
   }
   
   public static function getAlphaNumericNoSpacePattern() {
      return '/^[ÑA-Za-z0-9]+$/';
   }
   
   public static function getNamePattern() {
      return '/^[àáèéìíòóùúñÀÁÈÉÌÍÒÓÙÚÑA-Za-z\s]+$/';
   }
    
   public static function getBusinessPattern() {
      return '/^[0-9àáèéìíòóùúñÀÁÈÉÌÍÒÓÙÚÑA-Za-z.\s&-]+$/';
   }
   
   public static function getPlatePattern() {
      return '/(^[A-Za-z]{1,2}-[0-9]{4}-[A-Za-z]{2,3}$)|(^[0-9]{4}-[A-Za-z]{3}$)|(^[A-Za-z]{1,2}[0-9]{4}[A-Za-z]{2,3}$)|(^[0-9]{4}[A-Za-z]{3}$)/';
   }
   
   public static function getIdentificationPattern() {
      return '/^[A-Za-z0-9]+$/';
   }
   
   public static function getSpecialIdentificationPattern() {
      return '/^[A-Za-z0-9$@_.-]+$/';
   }
   
   public static function getPasswdPattern() {
      return '/^[a-zA-Z0-9_]+$/';      
   } 
         
   public static function getNumericPattern() {
      return '/^([+]|[-])*[0-9]+$/';   
   }
   
   public static function getDecimalPattern() {
      return '/^([+]|[-]){0,1}[0-9]+[.]{0,1}[0-9]*$/';   
   }
   
   public static function getMailPattern() {
      return '/^[0-9A-Za-z._%+-]+@[0-9A-Za-z.-]+\.[A-Za-z]{2,4}/';   
   }

   public static function getCsvFieldPattern() {
      return '/^[^,]+$/';   
   }
   
   public static function getIPv4Pattern() {
      return '/(^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$)/';
   }
   
   public static function getMacPattern() {
      return '/^([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})$/';
   }
   
   public static function getAlphaNumericWithSlashNoSpacePattern() {
      return '/^[ÑA-Za-z0-9\\/]+$/';
   }
   
   public static function getFolderPattern() {
      return '/^[A-Za-z0-9,_\s-]+$/';
   }
   
   public static function getDocumentPattern() {
      return '/^[àáèéìíòóùúñÀÁÈÉÌÍÒÓÙÚÑA-Za-z0-9,_().\s]+$/';
   }
}
?>