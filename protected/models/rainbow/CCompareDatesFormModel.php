<?php

class CCompareDatesFormModel extends CFormModel {
   
   public function compareDates($sAttribute, $oParams) {
      $sAttributeDate = $sAttribute;
      $sParamDate = $oParams['compareAttribute'];
       
      $sAttributeDateValue = strtotime(FDate::getEnglishDate(eval('return $this->' . $sAttributeDate . ';')));
      $sParamDateValue = strtotime(FDate::getEnglishDate(eval('return $this->' . $sParamDate . ';')));
      
      switch($oParams['operator']) {
         case '<=':
            if ($sAttributeDateValue > $sParamDateValue) {
               $this->addError($sAttribute, $oParams['message']);
            }
            break;
         case '>=':
            if ($sAttributeDateValue < $sParamDateValue) {
               $this->addError($sAttribute, $oParams['message']);
            }
            break;
      }  
   }
}