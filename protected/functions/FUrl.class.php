<?php      
class FUrl {
   public static function getUrlParameters($oDiscartParameters = array('r')) {
      $sUrl = FString::getFromFirstStr($_SERVER['REQUEST_URI'], '?');
      $oParameters = explode('&', $sUrl);
      $oValidParameters = array();
      $sValidUrl = FString::STRING_EMPTY;
      
      foreach($oParameters as $oParameter) {
         $sParameterName = null;
         $sParameterValue = null;
         $oParameterSegment = explode('=', $oParameter);
         if (count($oParameterSegment) > 0) {
            $sParameterName = $oParameterSegment[0];
            if (count($oParameterSegment) > 1) $sParameterValue = $oParameterSegment[1];   
         } 

         if (!is_null($sParameterName)) {
            if (substr($sParameterName, 0, 1) == '?') $sParameterName = substr($sParameterName, 1, strlen($sParameterName) - 1);
            
            $oValidParameters[$sParameterName] = array($sParameterName, $sParameterValue);      
         }
      }
      
      foreach($oValidParameters as $oValidParameter) {
         if ((!is_null($oValidParameter[0])) && ((strlen($oValidParameter[0])) > 0)) {
            $bDiscartParameter = false;
            foreach($oDiscartParameters as $oDiscartParameter) {
               if ($oValidParameter[0] == $oDiscartParameter) $bDiscartParameter = true;   
            }
            
            if (!$bDiscartParameter) {
               if (!is_null($oValidParameter[1])) $sValidUrl .= '&' . $oValidParameter[0] . '=' . $oValidParameter[1];
               else $sValidUrl .= '&' . $oValidParameter[0] . '=';
            }
         }   
      }

      return $sValidUrl;   
   }                                 
}
?>