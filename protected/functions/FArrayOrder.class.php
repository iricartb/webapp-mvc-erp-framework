<?php      
class FArrayOrder {
   
   public static function setOrderByTranslateName($sModelName, $oElements) {
      $oElementsResult = array();
      $oElementsTmpResult = array();

      foreach($oElements as $oElement) {
         $sTranslateName = eval('return $sModelName::getTranslateName($oElement->id);');
         
         $bEndPosition = true; $i = 0;
         for($i = 0; $i < count($oElementsTmpResult); $i++) {
            if ($bEndPosition) {
               if ($oElementsTmpResult[$i]['key'] > $sTranslateName) {
                  for($j = count($oElementsTmpResult); $j >= ($i + 1); $j--) {
                     $oElementsTmpResult[$j]['key'] = $oElementsTmpResult[($j - 1)]['key'];
                     $oElementsTmpResult[$j]['value'] = $oElementsTmpResult[($j - 1)]['value'];          
                  }
               
                  $oElementsTmpResult[$i] = array('key'=>$sTranslateName, 'value'=>$oElement);
                  $bEndPosition = false;             
               }
            }
         }
         
         if ($bEndPosition) $oElementsTmpResult[count($oElementsTmpResult)] = array('key'=>$sTranslateName, 'value'=>$oElement);              
      }
      
      $i = 0;
      foreach($oElementsTmpResult as $oElementTmpResult) {
         $oElementsResult[$i] = $oElementTmpResult['value'];
         
         $i++;  
      }
      
      return $oElementsResult;            
   }
}
?>