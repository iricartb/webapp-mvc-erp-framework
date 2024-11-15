<?php      
class FFlash {
   
   public static function addHeaderError($sHeaderError) {
      $sFlashError = Yii::app()->user->getFlash('error');
      
      if (strlen($sFlashError) > 0) {
         Yii::app()->user->setFlash('error', $sFlashError . '<br><br><b><u>' . $sHeaderError . '</u></b>');       
      }                                                               
      else Yii::app()->user->setFlash('error','<b><u>' . $sHeaderError . '</u></b>');   
   }
   
   public static function addError($sErrorInformation) {
      $sFlashError = Yii::app()->user->getFlash('error');
      
      if (strlen($sFlashError) > 0) {
         Yii::app()->user->setFlash('error', $sFlashError . '<br>' . $sErrorInformation);       
      }
      else Yii::app()->user->setFlash('error', $sErrorInformation);                                              
   }
   
   public static function addSuccess($sInformation) {
      $sFlashInformation = Yii::app()->user->getFlash('success');
      
      if (strlen($sFlashInformation) > 0) {
         Yii::app()->user->setFlash('success', $sFlashInformation . '<br>' . $sInformation);       
      }
      else Yii::app()->user->setFlash('success', $sInformation);                                              
   }
}
?>