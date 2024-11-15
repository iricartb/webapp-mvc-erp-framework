<?php      
class FFormat {
   const MAX_INTEGER = 2147483647;
   const MAX_PORT_NUMBER = 65535;

   public static function getFormatMinutesToHm($nMinutes) {
      $sHour = floor(abs($nMinutes / 60));
      $sMinutes = floor(abs($nMinutes % 60));
    
      return $sHour . 'h ' .$sMinutes . 'm';
   }

   public static function getFormatPrice($sNumber, $bDeleteZeros = false, $bThreeDecimals = false) {
      if (strlen($sNumber) > 0) {
         if (!$bThreeDecimals) {
            if ($bDeleteZeros) {
               if ((strpos($sNumber, '.') === false) || (substr($sNumber, -3) == '.00') || (substr($sNumber, -2) == '.0'))  {
                  return number_format($sNumber, 0, ',', '.');   
               }   
            }
            return number_format($sNumber, 2, ',', '.');
         }
         else {
            if ($bDeleteZeros) {
               if ((strpos($sNumber, '.') === false) || (substr($sNumber, -4) == '.000') || (substr($sNumber, -3) == '.00') || (substr($sNumber, -2) == '.0'))  {
                  return number_format($sNumber, 0, ',', '.');   
               }   
            }
            return number_format($sNumber, 3, ',', '.');  
         }
      }
      else return $sNumber;
   }
   
   public static function getFormatTimeTwoDigits($sTime) {
      $sHour = FString::getFirstToken($sTime, ':');
      $sHour = str_pad($sHour, 2, '0', STR_PAD_LEFT);
    
      $sMinutes = FString::getToken($sTime, ':', 2);
      $sMinutes = str_pad($sMinutes, 2, '0', STR_PAD_LEFT);
    
      return $sHour . ':' . $sMinutes;   
   }

   public static function getFormatPhone($sPhone) {
      if (strlen($sPhone) == 9) {
         return substr($sPhone, 0, 3) . FString::STRING_SPACE . substr($sPhone, 3, 3) . FString::STRING_SPACE . substr($sPhone, 6, 3);
      }
      else if (strlen($sPhone) == 10) {
         return '+' . substr($sPhone, 0, 1) . FString::STRING_SPACE . substr($sPhone, 1, 3) . FString::STRING_SPACE . substr($sPhone, 4, 3) . FString::STRING_SPACE . substr($sPhone, 7, 3);      
      }
      else if (strlen($sPhone) == 11) {
         return '+' . substr($sPhone, 0, 2) . FString::STRING_SPACE . substr($sPhone, 2, 3) . FString::STRING_SPACE . substr($sPhone, 5, 3) . FString::STRING_SPACE . substr($sPhone, 8, 3);      
      }
      else if (strlen($sPhone) == 12) {
         return '+' . substr($sPhone, 0, 3) . FString::STRING_SPACE . substr($sPhone, 3, 3) . FString::STRING_SPACE . substr($sPhone, 6, 3) . FString::STRING_SPACE . substr($sPhone, 9, 3);      
      } 
      else return $sPhone;
   }          
}                       
?>