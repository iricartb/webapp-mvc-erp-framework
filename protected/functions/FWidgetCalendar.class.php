<?php      
class FWidgetCalendar {
   const CALENDAR_TYPE_FULL = 'full';
   const CALENDAR_TYPE_MINI = 'mini';
   const CALENDAR_TYPE_LIST = 'list';
   const CALENDAR_TYPE_MINILIST = 'mini-list';

   private $oCalendar;
   
   public function __construct($sCalendarType, $sUrl = FString::STRING_EMPTY, $sDate = FString::STRING_EMPTY, $sColor = FString::STRING_EMPTY) {
      if ($sDate != FString::STRING_EMPTY) $this->oCalendar = new CALENDAR($sCalendarType, $sDate);
      else $this->oCalendar = new CALENDAR($sCalendarType, FString::STRING_EMPTY, true);
      
      $this->oCalendar->minilinkbase = $sUrl;      
      if ($sColor != FString::STRING_EMPTY) $this->oCalendar->basecolor = $sColor;
      
      $this->oCalendar->fulllinkbase = $sUrl;
      
      $this->oCalendar->weekdays = array(ucwords(Yii::t('system', 'SYS_DAY_SUNDAY')), ucwords(Yii::t('system', 'SYS_DAY_MONDAY')), ucwords(Yii::t('system', 'SYS_DAY_TUESDAY')), ucwords(Yii::t('system', 'SYS_DAY_WEDNESDAY')), ucwords(Yii::t('system', 'SYS_DAY_THURSDAY')), ucwords(Yii::t('system', 'SYS_DAY_FRIDAY')), ucwords(Yii::t('system', 'SYS_DAY_SATURDAY'))); 
      $this->oCalendar->abbrevweekdays = array(ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_SUNDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_MONDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_TUESDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_WEDNESDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_THURSDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_FRIDAY')), ucwords(Yii::t('system', 'SYS_DAY_ABBREVIATION_SATURDAY')));
      $this->oCalendar->weekdayschar = array(ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_SUNDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_MONDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_TUESDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_WEDNESDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_THURSDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_FRIDAY')), ucwords(Yii::t('system', 'SYS_DAY_FULL_ABBREVIATION_SATURDAY')));
      
      $this->oCalendar->months = array(ucwords(Yii::t('system', 'SYS_MONTH_JANUARY')), ucwords(Yii::t('system', 'SYS_MONTH_FEBRUARY')), ucwords(Yii::t('system', 'SYS_MONTH_MARCH')), ucwords(Yii::t('system', 'SYS_MONTH_APRIL')), ucwords(Yii::t('system', 'SYS_MONTH_MAY')), ucwords(Yii::t('system', 'SYS_MONTH_JUNE')), ucwords(Yii::t('system', 'SYS_MONTH_JULY')), ucwords(Yii::t('system', 'SYS_MONTH_AUGUST')), ucwords(Yii::t('system', 'SYS_MONTH_SEPTEMBER')), ucwords(Yii::t('system', 'SYS_MONTH_OCTOBER')), ucwords(Yii::t('system', 'SYS_MONTH_NOVEMBER')), ucwords(Yii::t('system', 'SYS_MONTH_DECEMBER')));
      $this->oCalendar->setMonthName();
      
      $this->oCalendar->infodetails = Yii::t('system', 'SYS_DETAIL');
      $this->oCalendar->jqueryinclude = false;
          
      if ($sCalendarType == FWidgetCalendar::CALENDAR_TYPE_FULL) $this->oCalendar->weeknames = 1;
   }
   
   public function addEvent($sTitle, $sFrom, $sTo, $sColor, $sDetail = FString::STRING_EMPTY, $sStartTime = FString::STRING_EMPTY, $sEndTime = FString::STRING_EMPTY, $sLocation = FString::STRING_EMPTY, $sLink = FString::STRING_EMPTY) {
      $oEvent = array(
         'title'=>$sTitle,
         'from'=>$sFrom,
         'to'=>$sTo,
         'color'=>$sColor,   
      );
     
      if ($sDetail != FString::STRING_EMPTY) $oEvent['details'] = $sDetail;
      if ($sStartTime != FString::STRING_EMPTY) $oEvent['starttime'] = $sStartTime; 
      if ($sEndTime != FString::STRING_EMPTY) $oEvent['endtime'] = $sEndTime; 
      if ($sLocation != FString::STRING_EMPTY) $oEvent['location'] = $sLocation; 
      if ($sLink != FString::STRING_EMPTY) $oEvent['link'] = $sLink; 
      
      $this->oCalendar->addEvent($oEvent);  
   }
   
   public function show() {
      return $this->oCalendar->showcal();   
   }
   
   public function getObject() { return $this->oCalendar; }                          
}
?>