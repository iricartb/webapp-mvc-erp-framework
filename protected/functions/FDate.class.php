<?php      
class FDate {
   const TIMEZONE_EUROPE_MADRID = 'Europe/Madrid';
   const START_HOUR_OF_DAY = '00:00:00';
   const END_HOUR_OF_DAY = '23:59:59';
   const NUM_HOURS_DAY = 24;
   
   public static function getTimeZoneFormattedDate($sDatetime, $bShowTime = false) {
      if (Yii::app()->params['timeZone'] == FDate::TIMEZONE_EUROPE_MADRID) {
         if ($bShowTime) return Yii::app()->dateFormatter->format("dd/MM/yyyy HH:mm:ss", strtotime($sDatetime));
         else return Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($sDatetime)); 
      }
      else {
         if ($bShowTime) return Yii::app()->dateFormatter->format("yyyy-MM-dd HH:mm:ss", strtotime($sDatetime));
         else return Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($sDatetime));
      }   
   }
   
   public static function getTimeZoneTypeFormattedDate() {
      if (Yii::app()->params['timeZone'] == FDate::TIMEZONE_EUROPE_MADRID) return "dd/mm/yy";
      else return "yy-mm-dd";  
   }

   public static function getDiffDays($sDate1, $sDate2, $bAbsolute = true) {
      $sTsDate1 = strtotime($sDate1);
      $sTsDate2 = strtotime($sDate2);
      $sDiff = $sTsDate2 - $sTsDate1;
      
      if ($bAbsolute) return floor(abs($sDiff / 86400));
      else return floor($sDiff / 86400);  
   }
   
   public static function getDiffHours($sDate1, $sDate2, $bAbsolute = true) {
      $sTsDate1 = strtotime($sDate1);
      $sTsDate2 = strtotime($sDate2);
      $sDiff = $sTsDate2 - $sTsDate1;
      
      if ($bAbsolute) return floor(abs($sDiff / 3600)); 
      else return floor($sDiff / 3600);
   }
   
   public static function getDiffMinutes($sDate1, $sDate2, $bAbsolute = true) {
      $sTsDate1 = strtotime($sDate1);
      $sTsDate2 = strtotime($sDate2);
      $sDiff = $sTsDate2 - $sTsDate1;
      
      if ($bAbsolute) return floor(abs($sDiff / 60)); 
      else return floor($sDiff / 60); 
   }
   
   public static function getDiffSeconds($sDate1, $sDate2, $bAbsolute = true) {
      $sTsDate1 = strtotime($sDate1);
      $sTsDate2 = strtotime($sDate2);
      $sDiff = $sTsDate2 - $sTsDate1;
      
      if ($bAbsolute) return abs($sDiff); 
      else return $sDiff;
   }
   
   public static function getDiffDatesDescription($sDate1, $sDate2, $bShowYears = true, $bShowMonths = true, $bShowDays = true, $bShowHours = true, $bShowMinutes = true, $bShowSeconds = true) {
      $oDateDiff = date_diff(date_create($sDate1), date_create($sDate2));
      $sDateDiffDescription = FString::STRING_EMPTY;
      
      $nDateDiffYears = $oDateDiff->format('%y');
      $nDateDiffMonths = $oDateDiff->format('%m');
      $nDateDiffDays = $oDateDiff->format('%d');
      $nDateDiffHours = $oDateDiff->format('%h');
      $nDateDiffMinutes = $oDateDiff->format('%i');
      $nDateDiffSeconds = $oDateDiff->format('%s');
      
      if ($bShowYears) {
         if ($nDateDiffYears == '1') $sDateDiffDescription .= $nDateDiffYears . FString::STRING_SPACE . Yii::t('system', 'SYS_YEAR') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffYears . FString::STRING_SPACE . Yii::t('system', 'SYS_YEARS') . FString::STRING_SPACE;   
      }
      
      if ($bShowMonths) {
         if ($nDateDiffMonths == '1') $sDateDiffDescription .= $nDateDiffMonths . FString::STRING_SPACE . Yii::t('system', 'SYS_MONTH') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffMonths . FString::STRING_SPACE . Yii::t('system', 'SYS_MONTHS') . FString::STRING_SPACE;   
      }
      
      if ($bShowDays) {
         if ($nDateDiffDays == '1') $sDateDiffDescription .= $nDateDiffDays . FString::STRING_SPACE . Yii::t('system', 'SYS_DAY') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffDays . FString::STRING_SPACE . Yii::t('system', 'SYS_DAYS') . FString::STRING_SPACE;   
      }
      
      if ($bShowHours) {
         if ($nDateDiffHours == '1') $sDateDiffDescription .= $nDateDiffHours . FString::STRING_SPACE . Yii::t('system', 'SYS_HOUR') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffHours . FString::STRING_SPACE . Yii::t('system', 'SYS_HOURS') . FString::STRING_SPACE;   
      }
      
      if ($bShowMinutes) {
         if ($nDateDiffMinutes == '1') $sDateDiffDescription .= $nDateDiffMinutes . FString::STRING_SPACE . Yii::t('system', 'SYS_MINUTE') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffMinutes . FString::STRING_SPACE . Yii::t('system', 'SYS_MINUTES') . FString::STRING_SPACE;   
      }
      
      if ($bShowSeconds) {
         if ($nDateDiffSeconds == '1') $sDateDiffDescription .= $nDateDiffSeconds . FString::STRING_SPACE . Yii::t('system', 'SYS_SECOND') . FString::STRING_SPACE;   
         else $sDateDiffDescription .= $nDateDiffSeconds . FString::STRING_SPACE . Yii::t('system', 'SYS_SECONDS') . FString::STRING_SPACE;   
      }
      
      return $sDateDiffDescription;    
   }
   
   public static function getTime($sDate) {
      return FString::getLastToken($sDate, FString::STRING_SPACE);   
   } 
   
   public static function getHour($sDate) {
      $sTime = FDate::getTime($sDate);
      
      return FString::getFirstToken($sTime, ':');   
   }

   public static function getMinutes($sDate) {
      $sTime = FDate::getTime($sDate);
      
      return FString::getToken($sTime, ':', 2);   
   }
   
   public static function getSeconds($sDate) {
      $sTime = FDate::getTime($sDate);
      
      return FString::getToken($sTime, ':', 3);   
   }
   
   
   public static function getNumDays($nYear, $nMonth) {
      return cal_days_in_month(CAL_GREGORIAN, $nMonth, $nYear);   
   }
   
   
   // Only use this function in the model search method to transform date in db correct format 
   public static function getEnglishDate($sDate) {
      if (!is_null($sDate)) {
         if (Yii::app()->params['timeZone'] == FDate::TIMEZONE_EUROPE_MADRID) {
            $sDay = substr($sDate, 0, 2);
            $sMonth = substr($sDate, 3, 2);
            $sYear = substr($sDate, 6, 4);   
            $sTime = substr($sDate, 11, 8);
           
            if ((is_numeric($sDay)) && (is_numeric($sMonth)) && (is_numeric($sYear))) {
               if (strlen($sTime) > 0) return $sYear . '-' . $sMonth . '-' . $sDay . FString::STRING_SPACE . $sTime;
               else return $sYear . '-' . $sMonth . '-' . $sDay; 
            }  
         }
      }
      return $sDate; 
   }
   
   public static function getDayName($sDate, $bAbbreviation = false, $bAbbreviation3Letters = false) {
      $sPrefix = FString::STRING_EMPTY;
      if ($bAbbreviation3Letters) $sPrefix = 'ABBREVIATION_3_LETTERS_';
      else if ($bAbbreviation) $sPrefix = 'ABBREVIATION_';
      
      switch (date('w', strtotime($sDate))) {
         case 0: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'SUNDAY');
         case 1: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'MONDAY');
         case 2: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'TUESDAY');
         case 3: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'WEDNESDAY');
         case 4: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'THURSDAY');
         case 5: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'FRIDAY');
         case 6: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'SATURDAY');
      }
   }
   
   public static function getDayNameByDay($nDay, $bAbbreviation = false, $bAbbreviation3Letters = false) {
      $sPrefix = FString::STRING_EMPTY;
      if ($bAbbreviation3Letters) $sPrefix = 'ABBREVIATION_3_LETTERS_';
      else if ($bAbbreviation) $sPrefix = 'ABBREVIATION_';
      
      switch ($nDay) {
         case 0: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'SUNDAY');
         case 1: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'MONDAY');
         case 2: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'TUESDAY');
         case 3: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'WEDNESDAY');
         case 4: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'THURSDAY');
         case 5: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'FRIDAY');
         case 6: return Yii::t('system', 'SYS_DAY_' . $sPrefix . 'SATURDAY');
      }
   }
   
   public static function getMonthName($nMonth, $bAbbreviation = false) {
      $sPrefix = FString::STRING_EMPTY;
      if ($bAbbreviation) $sPrefix = 'ABBREVIATION_';
      
      switch ($nMonth) {
         case 1: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'JANUARY');
         case 2: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'FEBRUARY');
         case 3: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'MARCH');
         case 4: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'APRIL');
         case 5: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'MAY');
         case 6: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'JUNE');
         case 7: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'JULY');
         case 8: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'AUGUST');
         case 9: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'SEPTEMBER');
         case 10: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'OCTOBER');
         case 11: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'NOVEMBER');
         case 12: return Yii::t('system', 'SYS_MONTH_' . $sPrefix . 'DECEMBER');
      }
   }
   
   public static function getMonthNames($bAbbreviation = false) {
      return array(ucwords(FDate::getMonthName(1, $bAbbreviation)), ucwords(FDate::getMonthName(2, $bAbbreviation)), ucwords(FDate::getMonthName(3, $bAbbreviation)), ucwords(FDate::getMonthName(4, $bAbbreviation)), ucwords(FDate::getMonthName(5, $bAbbreviation)), ucwords(FDate::getMonthName(6, $bAbbreviation)), ucwords(FDate::getMonthName(7, $bAbbreviation)), ucwords(FDate::getMonthName(8, $bAbbreviation)), ucwords(FDate::getMonthName(9, $bAbbreviation)), ucwords(FDate::getMonthName(10, $bAbbreviation)), ucwords(FDate::getMonthName(11, $bAbbreviation)), ucwords(FDate::getMonthName(12, $bAbbreviation)));
   }
   
   public static function getDayNames($bAbbreviation = false) {
      return array(ucwords(FDate::getDayNameByDay(0, $bAbbreviation)), ucwords(FDate::getDayNameByDay(1, $bAbbreviation)), ucwords(FDate::getDayNameByDay(2, $bAbbreviation)), ucwords(FDate::getDayNameByDay(3, $bAbbreviation)), ucwords(FDate::getDayNameByDay(4, $bAbbreviation)), ucwords(FDate::getDayNameByDay(5, $bAbbreviation)),ucwords(FDate::getDayNameByDay(6, $bAbbreviation)));
   }
   
   public static function isDateMajorEqual($sDate1, $sDate2) {
      $oDateTime1 = new DateTime($sDate1);
      $oDateTime2 = new DateTime($sDate2);
      
      return ($oDateTime1 >= $oDateTime2);   
   }
   
   public static function isDateMajor($sDate1, $sDate2) {
      $oDateTime1 = new DateTime($sDate1);
      $oDateTime2 = new DateTime($sDate2);
      
      return ($oDateTime1 > $oDateTime2);   
   }
   
   public static function isDateMinorEqual($sDate1, $sDate2) {
      $oDateTime1 = new DateTime($sDate1);
      $oDateTime2 = new DateTime($sDate2);
      
      return ($oDateTime1 <= $oDateTime2);   
   }
   
   public static function isDateMinor($sDate1, $sDate2) {
      $oDateTime1 = new DateTime($sDate1);
      $oDateTime2 = new DateTime($sDate2);
      
      return ($oDateTime1 < $oDateTime2);   
   }
   
   public static function isDateTime($sDate, $sFormat = 'Y-m-d H:i:s') {
      $d = DateTime::createFromFormat($sFormat, $sDate);
      return (($d) && ($d->format($sFormat) == $sDate));
   }
}
?>