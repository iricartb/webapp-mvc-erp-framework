<?php      
class FString {
   const STRING_SPACE = " ";
   const STRING_EMPTY = "";
   const STRING_TAB5 = "     ";
   const STRING_BOOLEAN_TRUE = 'true';
   const STRING_BOOLEAN_FALSE = 'false';
   const STRING_OTHERS = 'others';
   const STRING_HTML_TAG_BR = '<br>';
   const STRING_NULL = 'null';
                        
   public static function castStrRemoveNewLines($sSentence, $bReplaceBySpace = true) {
      if ($bReplaceBySpace) return str_replace("\n", FString::STRING_SPACE, str_replace("\r", FString::STRING_EMPTY, $sSentence));   
      else return str_replace("\n", FString::STRING_EMPTY, str_replace("\r", FString::STRING_EMPTY, $sSentence));   
   }
   
   public static function castStrToUpper($sSentence) {
      return strtr(strtoupper($sSentence), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");         
   }

   public static function castStrToCapitalLetters($sSentence) {
      return ucwords(strtr(strtolower($sSentence), "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ", "àèìòùáéíóúçñäëïöü"));         
   }
   
   public static function castStrSpecialChars($sSentence) {
      $oArraySpecialChars = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                  'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                  'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                  'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                  'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
                                      
      return strtr($sSentence, $oArraySpecialChars);         
   }
   
   public static function isNullOrEmpty($sSentence) {
      return ((is_null($sSentence)) || ((!is_null($sSentence)) && (strlen($sSentence) == 0)));
   }
   
   public static function getNewLine() {
      if (Yii::app()->params['applicationSystem'] == FApplication::SYSTEM_UNIX) return "\n";
      else if (Yii::app()->params['applicationSystem'] == FApplication::SYSTEM_APPLE) return "\r";
      else return "\r\n";   
   }
   
   public static function getAbbreviationSentence($sSentence, $nMaxlength, $nMaxLettersWords = 30, $sSentenceAbbreviation = '...') {
      $bAbbreviation = false;
      $nAbbreviationMaxlength = 0;
      
      if ($nMaxLettersWords != 0) {
          $oWords = explode(FString::STRING_SPACE, $sSentence);
          foreach ($oWords as $oWord) {
             if ($nAbbreviationMaxlength != 0) $nAbbreviationMaxlength++; 
              
             if (strlen($oWord) > $nMaxLettersWords) { $bAbbreviation = true; $nAbbreviationMaxlength += $nMaxLettersWords; }
             else $nAbbreviationMaxlength += strlen($oWord);
          }
      }
      
      if ((strlen($sSentence) > $nMaxlength) || ($bAbbreviation)) {
         for (;((!preg_match('/^[A-Za-z0-9\s]+$/', substr($sSentence, ($nMaxlength - 1), 1))) && ($nMaxlength > 0));) $nMaxlength--;                           
                          
         if (($bAbbreviation) && ($nAbbreviationMaxlength < $nMaxlength)) return substr($sSentence, 0, $nAbbreviationMaxlength) . $sSentenceAbbreviation;
         else return substr($sSentence, 0, $nMaxlength) . $sSentenceAbbreviation;
      }
      return $sSentence;
   }
   
   public static function getToken($sSentence, $sSeparator, $nToken) {
      $oArray = explode($sSeparator, $sSentence);
      
      if (count($oArray) > 0) {
         $nToken--;
         if ($nToken < 0) $nToken = 0;
         else if ($nToken > (count($oArray) - 1)) $nToken = count($oArray) - 1; 
         
         return $oArray[$nToken];
      }
      else return FString::STRING_EMPTY; 
   }
   
   public static function getFirstToken($sSentence, $sSeparator) {
      $oArray = explode($sSeparator, $sSentence);
      
      if (count($oArray) > 0) return $oArray[0];
      else return FString::STRING_EMPTY;
   }
   
   public static function getNumTokens($sSentence, $sSeparator) {
      $oArray = explode($sSeparator, $sSentence);
      
      return count($oArray); 
   }
   
   public static function getLastToken($sSentence, $sSeparator) {
      $oArray = explode($sSeparator, $sSentence);
      
      if (count($oArray) > 0) return $oArray[count($oArray) - 1];
      else return FString::STRING_EMPTY;
   }
   
   public static function getFromFirstStr($sSentence, $sStr) {
      $nPos = strpos($sSentence, $sStr);
      
      if ($nPos === false) return FString::STRING_EMPTY;
      else return substr($sSentence, $nPos); 
   }
   
   public static function getUntilLastStr($sSentence, $sStr) {
      $nPos = strrpos($sSentence, $sStr);
      
      if ($nPos === false) return $sSentence;
      else return substr($sSentence, 0, $nPos);   
   }                              
}
?>