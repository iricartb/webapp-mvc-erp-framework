<?php

class VisitorsStatisticVisits extends VisitorsVisits {
   private $xAxis;
   private $yAxis;
   private $colyAxis;
   public $typePeriod;
   public $typeStatistic;
   
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('visitor_full_name', 'length', 'min'=>3, 'max'=>38, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('visitor_business', 'length', 'min'=>3, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('visitor_full_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('visitor_business', 'match', 'pattern'=>FRegEx::getBusinessPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_BUSINESS')),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('visitor_full_name, card_description, type, start_date, end_date, status', 'safe', 'on'=>'search'),
		);
	}
   
   public function setStatisticNumVisitsFromMonthYear($vfield, $gfield, $month, $year, $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $yii_t = FString::STRING_EMPTY) {
      $sFilter = FString::STRING_EMPTY;
      if ($filterTypeVisit != FString::STRING_EMPTY) $sFilter .= ' AND type=\'' . $filterTypeVisit . '\'';
      if ($filterVisitor != FString::STRING_EMPTY) $sFilter .= ' AND visitor_full_name LIKE \'%' . $filterVisitor . '%\'';
      if ($filterVisitorBusiness != FString::STRING_EMPTY) $sFilter .= ' AND visitor_business LIKE \'%' . $filterVisitorBusiness . '%\'';
      
      $oStatisticNumVisits = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ',' . $gfield . ', COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $vfield . ' <> \'\' AND Month(start_date) = ' . $month . ' AND Year(start_date) = ' . $year . $sFilter . ' GROUP BY ' . $gfield . ' ORDER BY yAxis DESC')->queryAll(); 
      $this->xAxis = array();
      $this->colyAxis = array();
      $this->yAxis = array();
      $sCurrentGroup = FString::STRING_EMPTY; 
      
      $nDays = date("d");
      for ($i = 0; $i < $nDays; $i++) {
         $this->xAxis[$i] = ($i + 1);
         $this->yAxis[$i] = 0;      
      }
      
      $i = 0;
      foreach ($oStatisticNumVisits as $oStatisticNumVisit) {
         if ($i < FApplication::STATISTIC_MAX_ITEMS) {
            $oStatisticNumVisitsDetail = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ', Day(start_date) As xAxis, COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $gfield . '=\'' . $oStatisticNumVisit[$gfield] . '\' AND Month(start_date) = ' . $month . ' AND Year(start_date) = ' . $year . $sFilter . ' GROUP BY xAxis ORDER BY ' . $vfield . ' ASC, xAxis ASC')->queryAll();      
            foreach ($oStatisticNumVisitsDetail as $oStatisticNumVisitDetail) {
               if ($sCurrentGroup != $oStatisticNumVisitDetail[$vfield]) {
                  $sCurrentGroup = $oStatisticNumVisitDetail[$vfield];
                  
                  $this->colyAxis[count($this->colyAxis)] = array('name'=>($yii_t == FString::STRING_EMPTY) ? $oStatisticNumVisitDetail[$vfield] : Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), $yii_t . $oStatisticNumVisitDetail[$vfield]), 'data'=>$this->yAxis);
               }
               
               $this->colyAxis[count($this->colyAxis) - 1]['data'][$oStatisticNumVisitDetail['xAxis'] - 1] = (int) $oStatisticNumVisitDetail['yAxis'];   
            }
         }
         else break;
         $i++;
      }
      
      if ($i == 0) $this->colyAxis[0] = array('name'=>Yii::t('system', 'SYS_STATISTIC_EMPTY_RECORDS'));  
   }
   
   public function setStatisticNumVisitsFromYear($vfield, $gfield, $year, $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $yii_t = FString::STRING_EMPTY) {
      $sFilter = FString::STRING_EMPTY;
      if ($filterTypeVisit != FString::STRING_EMPTY) $sFilter .= ' AND type=\'' . $filterTypeVisit . '\'';
      if ($filterVisitor != FString::STRING_EMPTY) $sFilter .= ' AND visitor_full_name LIKE \'%' . $filterVisitor . '%\'';
      if ($filterVisitorBusiness != FString::STRING_EMPTY) $sFilter .= ' AND visitor_business LIKE \'%' . $filterVisitorBusiness . '%\'';
      
      $oStatisticNumVisits = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ',' . $gfield . ', COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $vfield . ' <> \'\' AND Year(start_date) = ' . $year . $sFilter . ' GROUP BY ' . $gfield . ' ORDER BY yAxis DESC')->queryAll(); 
      $this->xAxis = array();
      $this->colyAxis = array();
      $this->yAxis = array();
      $sCurrentGroup = FString::STRING_EMPTY; 
      
      for ($i = 0; $i < 12; $i++) {
         $this->xAxis[$i] = FDate::getMonthName($i + 1, true);
         $this->yAxis[$i] = 0;      
      }
      
      $i = 0;
      foreach ($oStatisticNumVisits as $oStatisticNumVisit) {
         if ($i < FApplication::STATISTIC_MAX_ITEMS) {
            $oStatisticNumVisitsDetail = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ', Month(start_date) As xAxis, COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $gfield . '=\'' . $oStatisticNumVisit[$gfield] . '\' AND Year(start_date) = ' . $year . $sFilter . ' GROUP BY xAxis ORDER BY ' . $vfield . ' ASC, xAxis ASC')->queryAll();      
            foreach ($oStatisticNumVisitsDetail as $oStatisticNumVisitDetail) {
               if ($sCurrentGroup != $oStatisticNumVisitDetail[$vfield]) {
                  $sCurrentGroup = $oStatisticNumVisitDetail[$vfield];
                  
                  $this->colyAxis[count($this->colyAxis)] = array('name'=>($yii_t == FString::STRING_EMPTY) ? $oStatisticNumVisitDetail[$vfield] : Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), $yii_t . $oStatisticNumVisitDetail[$vfield]), 'data'=>$this->yAxis);
               }
               
               $this->colyAxis[count($this->colyAxis) - 1]['data'][$oStatisticNumVisitDetail['xAxis'] - 1] = (int) $oStatisticNumVisitDetail['yAxis'];   
            }
         }
         else break;
         $i++;
      }
      
      if ($i == 0) $this->colyAxis[0] = array('name'=>Yii::t('system', 'SYS_STATISTIC_EMPTY_RECORDS'));
   }
   
   public function setStatisticNumVisits($vfield, $gfield, $minYear, $maxYear, $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $yii_t = FString::STRING_EMPTY) {
      $sFilter = FString::STRING_EMPTY;
      if ($filterTypeVisit != FString::STRING_EMPTY) $sFilter .= ' AND type=\'' . $filterTypeVisit . '\'';
      if ($filterVisitor != FString::STRING_EMPTY) $sFilter .= ' AND visitor_full_name LIKE \'%' . $filterVisitor . '%\'';
      if ($filterVisitorBusiness != FString::STRING_EMPTY) $sFilter .= ' AND visitor_business LIKE \'%' . $filterVisitorBusiness . '%\'';
       
      $oStatisticNumVisits = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ',' . $gfield . ', COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $vfield . ' <> \'\' AND Year(start_date) >= ' . $minYear . ' AND Year(start_date) <= ' . $maxYear . $sFilter . ' GROUP BY ' . $gfield . ' ORDER BY yAxis DESC')->queryAll(); 
      $this->xAxis = array();
      $this->colyAxis = array();
      $this->yAxis = array();
      $sCurrentGroup = FString::STRING_EMPTY; 
      
      for ($i = 0; $i <= ($maxYear - $minYear); $i++) {
         $this->xAxis[$i] = $minYear + $i;
         $this->yAxis[$i] = 0;      
      }
      
      $i = 0;
      foreach ($oStatisticNumVisits as $oStatisticNumVisit) {
         if ($i < FApplication::STATISTIC_MAX_ITEMS) {
            $oStatisticNumVisitsDetail = $this->getDbConnection()->createCommand('SELECT ' . $vfield . ', Year(start_date) As xAxis, COUNT(*) AS yAxis FROM visitors_visits WHERE ' . $gfield . '=\'' . $oStatisticNumVisit[$gfield] . '\' AND Year(start_date) >= ' . $minYear . ' AND Year(start_date) <= ' . $maxYear . $sFilter . ' GROUP BY xAxis ORDER BY ' . $vfield . ' ASC, xAxis ASC')->queryAll();      
            foreach ($oStatisticNumVisitsDetail as $oStatisticNumVisitDetail) {
               if ($sCurrentGroup != $oStatisticNumVisitDetail[$vfield]) {
                  $sCurrentGroup = $oStatisticNumVisitDetail[$vfield];
                  
                  $this->colyAxis[count($this->colyAxis)] = array('name'=>($yii_t == FString::STRING_EMPTY) ? $oStatisticNumVisitDetail[$vfield] : Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), $yii_t . $oStatisticNumVisitDetail[$vfield]), 'data'=>$this->yAxis);
               }
               
               $this->colyAxis[count($this->colyAxis) - 1]['data'][$oStatisticNumVisitDetail['xAxis'] - $minYear] = (int) $oStatisticNumVisitDetail['yAxis'];   
            }
         }
         else break;
         $i++;
      }
      
      if ($i == 0) $this->colyAxis[0] = array('name'=>Yii::t('system', 'SYS_STATISTIC_EMPTY_RECORDS'));
   }
   
   public function getXAxis() { return $this->xAxis; }
   public function getYAxis() { return $this->yAxis; }
   public function getColYAxis() { return $this->colyAxis; }
}